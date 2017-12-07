import { Component, OnInit, AfterViewInit } from '@angular/core';
import {FormGroup, FormControl, FormBuilder, Validators, NgForm} from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute, Params } from '@angular/router';
import { Observable} from 'rxjs/Observable';
declare const $: any;
declare const jQuery: any;

/* Import the service */
import { AuthenticationService } from '../authentication/authentication.service';
import { UserDashboardService} from './user-dashboard.service';
import {PersonModel} from "./person.model";

@Component({
  selector: 'user-dashboard',
  templateUrl: './user-dashboard.component.html',
  styleUrls: ['./user-dashboard.component.css']
})
export class UserDashboardComponent implements OnInit, AfterViewInit {
    person: PersonModel;
    isAdmin: string;
    showHide: boolean;
    appUrl: string;
    public notifications: any = {message: '', type: ''};


    constructor(
      private router: Router,
      private route: ActivatedRoute,
      private authService: AuthenticationService,
      private userDashboardService: UserDashboardService,

  ) {
        this.showHide = false;
    }

    ngOnInit() {
        // App url
        this.appUrl = this.userDashboardService.appUrl;

        const person_id = this.authService.getToken('person_id');
        if (person_id === '' && person_id.length === 0) {
          this.router.navigateByUrl('signin');
        }

        /* user profile*/
        this.getPersonDetails(person_id);

        /* is admin checking */
        this.isAdmin = this.authService.getToken('user_is_admin');
        console.log(this.isAdmin);

        /* Script */
      $(document).ready(function () {

      });
    }

    getPersonDetails(id: string): void {
        this.userDashboardService.getPersonDetails(id).then(person => this.person = person);
    }

    isUserAdmin(id: string) {
        return this.authService.getToken('is_user_admin');
    }

    ngAfterViewInit() {
      jQuery('#test').on('click', function (e) {
          e.preventDefault();
          console.log('hello');
          alert('hello');
      });
    }

    onPasswordResetSubmit(form: NgForm): void{
        this.userDashboardService.SubmitResetPassword(
            this.authService.getToken('person_id'),
            form.value.old_password,
            form.value.new_password,
            form.value.conf_password,
        )
            .subscribe(
                response => this.notifications = response,
            )
    }

    onDownloadVMSubmit(form: NgForm): void{
        this.userDashboardService.SubmitDownloadVM(
            this.authService.getToken('person_id'),
            form.value.vm,
            form.value.vm_username,
            form.value.vm_password,
        )
            .subscribe(
                response => this.notifications = response,
            )
    }

    changeShowStatus(){
        this.showHide = !this.showHide;
    }

}
