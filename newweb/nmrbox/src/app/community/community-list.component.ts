import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';

import {EventModel} from './event.model';
import {CommunityService} from './community.service';
import {AuthenticationService} from '../authentication/authentication.service';

@Component({
  selector: 'app-community-list',
  templateUrl: './community-list.component.html',
  styleUrls: ['./community-list.component.scss']
})
export class CommunityListComponent implements OnInit {

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
    /* Workshops */
    this.getEventsList();

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

  getEventsList(): void {
    this.communityService.getAllEvents().then(events => {
      this.upcoming = events[0] as EventModel[];
      this.completed = events[1] as EventModel[];
    });
  }

  onWorkshopRegister(workshopName) {
    this.authService.workshopRegister(workshopName)
      .subscribe(
        response => this.notifications = response,
        error => this.notifications = error,
        () => this.getEventsList()
      );
  }
}
