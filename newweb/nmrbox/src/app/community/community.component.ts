import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';

import {EventModel} from './event.model';
import {CommunityService} from './community.service';
import {AuthenticationService} from '../authentication/authentication.service';

@Component({
  selector: 'app-community',
  templateUrl: './community.component.html',
  styleUrls: ['./community.component.scss']
})
export class CommunityComponent implements OnInit {

  upcoming: EventModel[];
  completed: EventModel[];
  selectedIndex = 0;

  public notifications: any = {message: '', type: ''};

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private communityService: CommunityService,
    public authService: AuthenticationService
  ) {
  }

  ngOnInit(): void {

    // Keep the events lists up to date locally
    this.communityService.upcomingEvents.subscribe(upcomingEvents => {
      this.upcoming = upcomingEvents;
    });

    this.communityService.pastEvents.subscribe(pastEvents => {
      this.completed = pastEvents;
    });

    // Tabs: go to specific subsection
    this.route.params.subscribe(params => {
        this.selectedIndex = params['index'];
        if (this.selectedIndex > 0) {
          this.selectedIndexChange(this.selectedIndex);
        }
      }
    );
  }

  // Tabs
  selectedIndexChange(index: number): void {
    if (!index) {
      index = 0;
    }
    this.selectedIndex = index;
    this.router.navigate(['/community', index]);
  }

  onWorkshopRegister(workshopName) {
    this.authService.workshopRegister(workshopName)
      .subscribe(
        response => this.notifications = response,
        error => this.notifications = error,
        () => this.communityService.updateEvents()
      );
  }
}
