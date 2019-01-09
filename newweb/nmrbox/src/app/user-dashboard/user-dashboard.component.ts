import {Component, OnInit} from '@angular/core';
import {NgForm} from '@angular/forms';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';

/* Import service files */
import {AuthenticationService} from '../authentication/authentication.service';
import {UserDashboardService} from './user-dashboard.service';
import {PersonModel} from './person.model';
import {environment} from '../../environments/environment';

@Component({
  selector: 'app-user-dashboard',
  templateUrl: './user-dashboard.component.html',
  styleUrls: ['./user-dashboard.component.scss']
})
export class UserDashboardComponent implements OnInit {
  person: PersonModel;
  showHide: boolean;
  apiURL = environment.appUrl;

  public notifications: any = {message: '', type: ''};


  constructor(
    private router: Router,
    private route: ActivatedRoute,
    public authService: AuthenticationService,
    private userDashboardService: UserDashboardService,
  ) {
    this.showHide = false;
  }

  ngOnInit() {
    if (!this.authService.userID) {
      this.router.navigateByUrl('signin');
    }

    /* user profile*/
    this.getPersonDetails(this.authService.userID);
  }

  getPersonDetails(id: string): void {
    this.userDashboardService.getPersonDetails(id).then(person => this.person = person);
  }

  onPasswordResetSubmit(form: NgForm): void {
    this.userDashboardService.SubmitResetPassword(
      this.authService.userID,
      form.value.old_password,
      form.value.new_password,
      form.value.conf_password,
    )
      .subscribe(
        response => this.notifications = response,
      );
  }

  onDownloadVMSubmit(form: NgForm): void {

    this.userDashboardService.SubmitDownloadVM(
      this.authService.userID,
      form.value.vm_id,
      form.value.vm_username,
      form.value.vm_password,
    )
      .subscribe(
        response => this.notifications = response,
      );
  }

  changeShowStatus() {
    this.showHide = !this.showHide;
  }

}
