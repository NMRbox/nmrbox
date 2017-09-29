import { Component, OnInit } from '@angular/core';
import {FormGroup, FormControl, FormBuilder, Validators, NgForm} from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute, Params } from '@angular/router';
import { Observable} from 'rxjs/Observable';

/* Import the service */
import { AuthenticationService } from '../authentication/authentication.service';

@Component({
  selector: 'user-dashboard',
  templateUrl: './user-dashboard.component.html',
  styleUrls: ['./user-dashboard.component.css']
})
export class UserDashboardComponent implements OnInit {

  constructor(
      private router: Router,
      private route: ActivatedRoute,
      private authService: AuthenticationService
  ) { }

  ngOnInit() {
      const person_id = this.authService.getCookie('person_id');
      if (person_id === '' && person_id.length === 0) {
          this.router.navigateByUrl('signin');
      }
  }

}
