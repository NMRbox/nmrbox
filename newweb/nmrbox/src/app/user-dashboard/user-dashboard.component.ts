import { Component, OnInit } from '@angular/core';
import {FormGroup, FormControl, FormBuilder, Validators, NgForm} from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute, Params } from '@angular/router';
import { Observable} from 'rxjs/Observable';

/* Import the service */
import { AuthenticationService } from '../authentication/authentication.service';
import { UserDashboardService} from './user-dashboard.service';
import {PersonModel} from "./person.model";

@Component({
  selector: 'user-dashboard',
  templateUrl: './user-dashboard.component.html',
  styleUrls: ['./user-dashboard.component.css']
})
export class UserDashboardComponent implements OnInit {
    person: PersonModel;

  constructor(
      private router: Router,
      private route: ActivatedRoute,
      private authService: AuthenticationService,
      private userDashboardService: UserDashboardService
  ) { }

  ngOnInit() {
      const person_id = this.authService.getCookie('person_id');
      if (person_id === '' && person_id.length === 0) {
          this.router.navigateByUrl('signin');
      }

      this.getPersonDetails(person_id);
  }
  getPersonDetails(id: string): void {
        this.userDashboardService.getPersonDetails(id).then(person => this.person = person);
  }

}
