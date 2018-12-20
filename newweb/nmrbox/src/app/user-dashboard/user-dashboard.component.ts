import {Component, OnInit} from '@angular/core';
import {NgForm} from '@angular/forms';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';

/* Import service files */
import {AuthenticationService} from '../authentication/authentication.service';
import {UserDashboardService} from './user-dashboard.service';
import {PersonModel} from './person.model';

@Component({
  selector: 'app-user-dashboard',
  templateUrl: './user-dashboard.component.html',
  styleUrls: ['./user-dashboard.component.scss']
})
export class UserDashboardComponent implements OnInit {
  person: PersonModel;
  isAdmin: string;
  showHide: boolean;
  public notifications: any = {message: '', type: ''};


  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private authService: AuthenticationService,
    private userDashboardService: UserDashboardService,
  ) {
    this.showHide = false;
  }

  log(it) {console.log(it);}


  ngOnInit() {
    const person_id = this.authService.getToken('person_id');
    if (!person_id) {
      this.router.navigateByUrl('signin');
    }

    /* user profile*/
    this.getPersonDetails(person_id);

    /* is admin checking */
    this.isAdmin = this.authService.getToken('user_is_admin');
  }

  getPersonDetails(id: string): void {
    this.userDashboardService.getPersonDetails(id).then(person => this.person = person);
  }

  isUserAdmin(id: string) {
    return this.authService.getToken('is_user_admin');
  }

  onPasswordResetSubmit(form: NgForm): void {
    this.userDashboardService.SubmitResetPassword(
      this.authService.getToken('person_id'),
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
      this.authService.getToken('person_id'),
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
