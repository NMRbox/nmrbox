import {Component, OnInit} from '@angular/core';
import {NgForm} from '@angular/forms';
import {Router} from '@angular/router';

/* Import service files */
import {AuthenticationService} from '../authentication/authentication.service';
import {PersonModel} from '../authentication/person.model';
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
    public authService: AuthenticationService,
  ) {
    this.showHide = false;
  }

  ngOnInit() {
    if (!this.authService.userID) {
      this.router.navigateByUrl('signin');
    }

    this.person = this.authService.personData;
  }

  onPasswordResetSubmit(form: NgForm): void {
    this.authService.submitResetPassword(form.value.old_password, form.value.new_password, form.value.conf_password)
      .subscribe(
        response => this.notifications = response,
        error => this.notifications = error.error
      );
  }

  onDownloadVMSubmit(form: NgForm): void {

    this.authService.submitDownloadVM(form.value.vm_id, form.value.vm_username, 'CHANGEME')
      .subscribe(
        response => this.notifications = response,
        error => this.notifications = error.error
      );
  }

  changeShowStatus() {
    this.showHide = !this.showHide;
  }

}
