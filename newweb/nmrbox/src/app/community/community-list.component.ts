import {Component, OnInit, Input, Output, EventEmitter} from '@angular/core';
import {NgForm} from '@angular/forms';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';

import {EventModel} from '../static/static-page.model';
import {CommunityService} from './community.service';
import {AuthenticationService} from '../authentication/authentication.service';

@Component({
  selector: 'app-community-list',
  templateUrl: './community-list.component.html',
  styleUrls: ['./community-list.component.scss']
})
export class CommunityListComponent implements OnInit {

  @Input() communityList: EventModel[];

  @Input() supportList: EventModel[];
  @Input() supportNmrboxList: EventModel[];
  @Input() supportTutorialList: EventModel[];
  @Input() supportSwdocList: EventModel[];
  @Input() supportWorkflowList: EventModel[];

  @Input() eventsList: EventModel[];
  @Input() upcoming: EventModel[];
  @Input() completed: EventModel[];

  @Input() eventsCurrentList: EventModel[];
  @Input() eventsPastList: EventModel[];

  @Output() listChange: EventEmitter<EventModel[]> = new EventEmitter<EventModel[]>();

  // Tabs
  @Input() selectedIndex = 0;
  @Input() routeIndex: number;

  /*notification variable*/
  public notifications: any = {message: '', type: ''};

  config: Object = {
    slidesPerView: 'auto',
    centeredSlides: false,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    spaceBetween: 0,
    speed: 500,
    loop: false
  };

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private communityService: CommunityService,
    private authService: AuthenticationService
  ) {
  }

  ngOnInit(): void {
    /* Workshops */
    this.getEventsList();

    // Tabs: go to specific subsection
    this.route.params.subscribe(params => {
        this.routeIndex = params['index'];
        this.selectedIndex = this.routeIndex;
      }
    );

    if (this.routeIndex > -1) {
      this.selectedIndexChange(this.routeIndex);
    }
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
      this.eventsList = events[0];
      this.upcoming = events[1];
      this.completed = events[2];
    });
  }

  /* workshops registration */
  onWorkshopRegister(form: NgForm) {
    const person_id = this.authService.getToken('person_id');
    const workshop_id = form.value.name;
    console.log(person_id);
    console.log(workshop_id);

    this.communityService.workshopRegister(
      person_id,
      workshop_id
    )
      .subscribe(
        response => this.notifications = response
      );
  }

  isLoggedIn() {
    return this.authService.getToken('person_id');
  }

}
