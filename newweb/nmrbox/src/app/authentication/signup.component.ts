import {Component, AfterViewInit} from '@angular/core';
import {NgForm} from '@angular/forms';

import {AuthenticationService} from './authentication.service';

/* Import country updater code */
import * as crs from '../../javascript/crs.min';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements AfterViewInit {
  public notifications: any = {message: '', type: ''};

  constructor(
    private authService: AuthenticationService
  ) {
  }

  ngAfterViewInit() {
    crs.init();
  }

  onSignup(form: NgForm) {
    this.authService.signUp(
      form.value.first_name,
      form.value.last_name,
      form.value.email,
      form.value.email_institution,
      form.value.pi,
      form.value.institution,
      form.value.institution_type,
      form.value.department,
      form.value.job_title,
      form.value.address1,
      form.value.address2,
      form.value.address3,
      form.value.city,
      form.value.state_province,
      form.value.zip_code,
      form.value.country,
      form.value.time_zone_id,
    )
      .subscribe(
        response => this.notifications = response,
        error => {
          if (error.error && error.error.message) {
            this.notifications = error.error;
          } else {
            this.notifications = {'message': 'Server error.', 'type': 'error'};
          }
        }
      );
  }

}
