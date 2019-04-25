import {Component, OnInit} from '@angular/core';
import {NgForm} from '@angular/forms';

/* Import the service */
import {AuthenticationService} from '../authentication/authentication.service';

@Component({
  selector: 'app-forget-password',
  templateUrl: './forget-password.component.html',
  styleUrls: ['./forget-password.component.scss']
})
export class ForgetPasswordComponent implements OnInit {
  public notifications: any = {message: '', type: ''};

  constructor(
    private authService: AuthenticationService
  ) {
  }

  ngOnInit() {
  }

  onPasswordSubmit(form: NgForm): void {
    this.authService.forgetPassword(form.value.email)
      .subscribe(
        response => this.notifications = response,
      );
  }

}
