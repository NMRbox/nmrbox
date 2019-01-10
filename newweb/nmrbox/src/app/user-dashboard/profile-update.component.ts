import {Component, OnInit} from '@angular/core';
import {NgForm} from '@angular/forms';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';

/* Import services */
import {AuthenticationService} from '../authentication/authentication.service';

/* Import model */
import {PersonModel} from '../authentication/person.model';

@Component({
  selector: 'app-profile-update',
  templateUrl: './profile-update.component.html',
  styleUrls: ['./profile-update.component.css']
})
export class ProfileUpdateComponent implements OnInit {
  person: PersonModel;
  public notifications: any = {message: '', type: ''};

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private authService: AuthenticationService
  ) {
  }

  ngOnInit() {
    if (!this.authService.personData) {
      this.router.navigateByUrl('signin');
    }

    this.person = this.authService.personData;
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
        response => this.notifications = response,
        () => this.notifications = {'message': 'An unhandled server error happened.', 'type': 'error'}
      );
  }

}
