import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import {FormGroup, FormControl, FormBuilder, Validators, NgForm} from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute, Params } from '@angular/router';
import { Observable} from 'rxjs/Observable';

/* Import services */
import {AuthenticationService} from '../authentication/authentication.service';
import { UserDashboardService } from './user-dashboard.service';

/* Import model */
import {PersonModel} from './person.model';

@Component({
  selector: 'profile-update',
  templateUrl: './profile-update.component.html',
  styleUrls: ['./profile-update.component.css']
})
export class ProfileUpdateComponent implements OnInit {
    person: PersonModel;
    public notifications: any = {message: '', type: ''};

    constructor(
        private router: Router,
        private route: ActivatedRoute,
        private authService: AuthenticationService,
        private userService: UserDashboardService,
    ) { }

    ngOnInit() {
        const person_id = this.authService.getToken('person_id');
        if (person_id === '' && person_id.length === 0) {
            this.router.navigateByUrl('signin');
        }

        this.getPersonDetails(person_id);

    }

    getPersonDetails(id: string): void {
        this.userService.getPersonDetails(id).then(person => {
          this.person = person;
          console.log(this.person);
        });
    }

    onProfileUpdate(form: NgForm) {
        this.authService.updateProfile(
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
                response => this.notifications = response
            );
    }

}
