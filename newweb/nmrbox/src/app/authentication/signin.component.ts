import {Component, OnInit} from '@angular/core';
import {NgForm} from '@angular/forms';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';

/* Import the service */
import {AuthenticationService} from './authentication.service';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {
  public notifications: any = {message: '', type: ''};

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private authService: AuthenticationService
  ) {
  }

  ngOnInit() {
    if (this.authService.userID) {
      this.router.navigateByUrl('user-dashboard');
    }

  }

  onSignin(form: NgForm) {
    this.authService.signIn(form.value.username, form.value.password)
      .subscribe(
        response => this.notifications = response,
        () => this.notifications = {'message': 'Server error.', 'type': 'error'}
      );
  }

}
