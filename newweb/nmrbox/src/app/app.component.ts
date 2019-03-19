import {Component} from '@angular/core';

/* Import the service */
import {AuthenticationService} from './authentication/authentication.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  constructor(
    public authService: AuthenticationService
  ) {
  }

  signOut() {
    this.authService.signOut();
  }

}
