import {Component} from '@angular/core';

/* Import the service */
import {AuthenticationService} from './authentication/authentication.service';
import {Router} from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  constructor(
    private router: Router,
    public authService: AuthenticationService
  ) {
  }

  signOut() {
    this.authService.signOut();
    this.router.navigateByUrl('');
  }


}
