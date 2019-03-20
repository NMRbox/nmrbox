import {Component} from '@angular/core';

/* Import the service */
import {AuthenticationService} from './authentication/authentication.service';
import {ResponsiveService} from './responsive.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

  // The "unused" responsiveService is here to ensure the small screen pop-up always occurs
  constructor(
    public authService: AuthenticationService,
    public responsiveService: ResponsiveService
  ) {
  }

  signOut() {
    this.authService.signOut();
  }

}
