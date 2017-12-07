import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import {FormGroup, FormControl, FormBuilder, Validators, NgForm} from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute, Params } from '@angular/router';
import { Observable} from 'rxjs/Observable';

/* Import the service */
import { AuthenticationService } from './authentication.service';

@Component({
  selector: 'signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {
    public notifications: any = {message: '', type: ''};

  constructor(
      private router: Router,
      private route: ActivatedRoute,
      private authService: AuthenticationService
  ) { }

  ngOnInit() {
    //const person_id = this.authService.getCookie('person_id');
    const person_id = this.authService.getToken('person_id');
    if (person_id != null && person_id.length > 0 ) {
      this.router.navigateByUrl('user-dashboard');
    }

  }

  onSignin(form: NgForm) {
      this.authService.signin(form.value.username, form.value.password)
          .subscribe(
              //this.router.navigateByUrl('user-dashboard');
              response => this.router.navigateByUrl('user-dashboard'),
              response => this.notifications = response
              /*tokenData => [
                  token => console.log(tokenData),
                  person_id => console.log(person_id)
              ],
              error => console.log(error)*/
          )
  }

}
