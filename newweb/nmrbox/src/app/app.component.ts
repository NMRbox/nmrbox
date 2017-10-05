import { Component } from '@angular/core';

/* Import the service */
import { AuthenticationService } from './authentication/authentication.service';
import {Router} from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'NMRbox';
  version = '1.0';

    constructor(
        private router: Router,
        private authService: AuthenticationService
    ) { }

    isLoggedIn() {
        return this.authService.getCookie('person_id');
    }

    signOut() {
        this.authService.deleteCookie('person_id');
        this.authService.deleteCookie('logged_in');
        this.router.navigateByUrl('app');
    }
}
