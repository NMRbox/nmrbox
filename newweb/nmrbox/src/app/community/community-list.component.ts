import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute, Params } from '@angular/router';

import { Observable }        from 'rxjs/Observable';

import { CommunityModel }         from './community.model';
import { CommunityService }  from './community.service';
import { AuthenticationService } from '../authentication/authentication.service';

@Component({
  selector: 'community-list',
  templateUrl: './community-list.component.html',
  styleUrls: [ './community-list.component.scss' ]
})
export class CommunityListComponent implements OnInit {
  //communityList: SoftwareModel[];
  @Input() communityList: CommunityModel[];

  @Input() supportList: CommunityModel[];
  @Input() supportNmrboxList: CommunityModel[];
  @Input() supportTutorialList: CommunityModel[];
  @Input() supportSwdocList: CommunityModel[];
  @Input() supportWorkflowList: CommunityModel[];

  /*@Input() blogList: CommunityModel[];
  @Input() blogMostRecentList: CommunityModel[];
  @Input() blogNextList: CommunityModel[];*/

  @Input() eventsList: CommunityModel[];
  @Input() upcoming: CommunityModel[];
  @Input() completed: CommunityModel[];

  @Input() eventsCurrentList: CommunityModel[];
  @Input() eventsPastList: CommunityModel[];
  
  @Output() listChange: EventEmitter<CommunityModel[]> = new EventEmitter<CommunityModel[]>();
  selectedCommunity: CommunityModel;

  // Tabs
  @Input() selectedIndex: number=0;
  @Input() routeIndex: number;

  /*notification variable*/
    public notifications: any = {message: '', type: ''};


  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private communityService: CommunityService,
    private authService: AuthenticationService
  ) { }

  config: Object = {
            slidesPerView: 'auto',
            centeredSlides: false,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 0,
            speed: 500,
            loop: false
        };

  ngOnInit(): void {
    this.getCommunityList();
    //this.getSupportList();
    this.filterSupportType('nmrbox');
    this.filterSupportType('tutorial');
    this.filterSupportType('swdoc');
    this.filterSupportType('workflow');

    /* Workshops */
    this.getEventsList();


    // Tabs: go to specific subsection
    this.route.params.subscribe( params =>
        this.routeIndex = params['index']
    );

    if(this.routeIndex > -1){
      this.selectedIndexChange(this.routeIndex);
    }
  }

  // Tabs
  selectedIndexChange(index: number): void {
    if(!index) index = 0;
    this.selectedIndex = index;
    this.router.navigate(['/community', index]);
  }

  // Data & Filters
  getCommunityList(): void {
    this.communityService.getCommunityList().then(communityList => this.communityList = communityList);
  }

  getSupportList(): void {
    this.communityService.getSupportList().then(supportList => this.supportList = supportList);
  }
  /*getBlogList(): void {
    this.communityService.getBlogList().then(blogList => this.blogList = blogList);
  }*/
  getEventsList(): void {
    this.communityService.getEventsList().then(eventsList => this.eventsList = eventsList);
    this.communityService.getUpcomingEventsList().then(upcoming => this.upcoming = upcoming);
    this.communityService.getCompletedEventsList().then(completed => this.completed = completed);
  }

  searchSoftware(term: string): void {
    this.communityService.searchSoftware(term).then(communityList => this.communityList = communityList);
  }

  filterSoftwareType(softwareType: string): void {
    
    this.communityService.filterSoftwareType(softwareType).then(communityList => this.communityList = communityList);
  }

  filterSupportType(supportType: string): void {

    if(supportType == "nmrbox"){
      this.communityService.filterSupportType(supportType).then(supportNmrboxList => this.supportNmrboxList = supportNmrboxList);
    } else if (supportType == "tutorial"){
      this.communityService.filterSupportType(supportType).then(supportTutorialList => this.supportTutorialList = supportTutorialList);
    } else if (supportType == "swdoc"){
      this.communityService.filterSupportType(supportType).then(supportSwdocList => this.supportSwdocList = supportSwdocList);
    } else if (supportType == "workflow"){
      this.communityService.filterSupportType(supportType).then(supportWorkflowList => this.supportWorkflowList = supportWorkflowList);
    }
  }

  //gotoDetail(community: CommunityModel): void {
  gotoDetail(pageUrl: string): void {
      console.log('component url : ', pageUrl);
      if (pageUrl === 'faqs') {
          this.router.navigate(['faqs']);
      } else {
          this.router.navigate(['/c', pageUrl]);
      }
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
            )
    }

    isLoggedIn() {
        return this.authService.getToken('person_id');
    }

}