import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormControl, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute, Params } from '@angular/router';

import { Observable } from 'rxjs/Observable';

import { TeamModel } from './team.model';
import { TeamService }  from './team.service';

@Component({
  selector: 'team-list',
  templateUrl: './team-list.component.html',
  styleUrls: [ './team-list.component.scss' ]
})
export class TeamListComponent implements OnInit {

  @Input() pageContent: TeamModel;
  @Input() leadershipContent: TeamModel;
  @Input() researchContent: TeamModel;
  @Input() staffContent: TeamModel;
  @Input() advisoryContent: TeamModel;

  // Tabs
  @Input() selectedIndex: number=0;
  @Input() routeIndex: number;

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private teamService: TeamService
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


    this.showPageContent(0);
    this.showPageContent(1);
    this.showPageContent(2);
    this.showPageContent(3);

    // ROUTES
    // Tabs: go to specific subsection
    this.route.params.subscribe( params =>
        this.routeIndex = params['index']
    );

    console.log("routeIndex: ", this.routeIndex);

    if(this.routeIndex > -1){
      this.selectedIndexChange(this.routeIndex);
    }

  }

   // Tabs
  selectedIndexChange(index: number): void {

    if(!index) index = 0;
    this.selectedIndex = index;

    if (index === 0){
        this.showPageContent(0);
    /*} else if (index === 1) {
        this.showPageContent(1);*/
    } else if (index === 1) {
        this.showPageContent(1);
    } else if (index === 2) {
        this.showPageContent(2);
    }
    //this.router.navigate(['/team', index]);
    console.log('selectedIndexChange to: ', index);
  }

  gotoDetail(): void {
    this.router.navigate(['/t/detail']);
  }

  /* test for page content */
    showPageContent(index: number): void {
        if (index === 0){
            this.teamService.getPageContent('people-leadership').then(advisoryContent => this.leadershipContent = advisoryContent);
        /*} else if (index === 1) {
            this.teamService.getPageContent('overview').then(researchContent => this.researchContent = researchContent);*/
        } else if (index === 1) {
            this.teamService.getPageContent('people-technical-staff').then(staffContent => this.staffContent = staffContent);
        } else if (index === 2) {
            this.teamService.getPageContent('people-eab').then(advisoryContent => this.advisoryContent = advisoryContent);
        }
    }
}