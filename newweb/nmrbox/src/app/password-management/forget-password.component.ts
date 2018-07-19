import { Component, OnInit } from '@angular/core';
import {NgForm} from '@angular/forms';
import {ActivatedRoute, Router} from '@angular/router';

/* Import the service */
import { PasswordManagementService } from './password-management.service';
import { AuthenticationService } from '../authentication/authentication.service';
import {PersonModel} from '../user-dashboard/person.model';

@Component({
  selector: 'app-forget-password',
  templateUrl: './forget-password.component.html',
  styleUrls: ['./forget-password.component.scss']
})
export class ForgetPasswordComponent implements OnInit {
    // notification: PersonModel[];
    public notifications: any = {message: '', type: ''};
    notification_message: Object = {};
    errors: Object = {};
    isSubmitting = false;


  constructor(
      private router: Router,
      private route: ActivatedRoute,
      private passService: PasswordManagementService,
      private authService: AuthenticationService
  ) { }

  ngOnInit() {
  }

  onPasswordSubmit(form: NgForm): void {
      this.passService.forgetPassword(
            form.value.email,
      )
          .subscribe(
              response => this.notifications = response,

           /*   error => console.log(error),
              () => console.log(this.notifications)*/
              /*message => {
                    console.log(message);
                    this.alert = message;
                },
                  err => {
                      this.errors = err.type;
                      this.isSubmitting = false;
                  }*/
                /*message => console.log(response),
                err => {
                    this.errors = err;
                    this.isSubmitting = false;
                }*/

        );
  }


}
