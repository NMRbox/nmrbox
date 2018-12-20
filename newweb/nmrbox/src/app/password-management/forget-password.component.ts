import {Component, OnInit} from '@angular/core';
import {NgForm} from '@angular/forms';
import {ActivatedRoute, Router} from '@angular/router';

/* Import the service */
import {PasswordManagementService} from './password-management.service';

@Component({
  selector: 'app-forget-password',
  templateUrl: './forget-password.component.html',
  styleUrls: ['./forget-password.component.scss']
})
export class ForgetPasswordComponent implements OnInit {
  public notifications: any = {message: '', type: ''};

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private passService: PasswordManagementService
  ) {
  }

  ngOnInit() {
  }

  onPasswordSubmit(form: NgForm): void {
    this.passService.forgetPassword(
      form.value.email,
    )
      .subscribe(
        response => this.notifications = response,
      );
  }


}
