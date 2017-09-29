import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import {FormGroup, FormControl, FormBuilder, Validators, NgForm} from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute, Params } from '@angular/router';
import { Observable} from 'rxjs/Observable';

/* Import the service */
import { AuthenticationService } from './authentication.service';


@Component({
  selector: 'signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {

  constructor(
      private router: Router,
      private route: ActivatedRoute,
      private authService: AuthenticationService
  ) { }

  ngOnInit() {
  }

  onSignup(form: NgForm) {
      this.authService.signup(
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
              //response => console.log(response),
              //error => console.log(error)
          );
  }

}
