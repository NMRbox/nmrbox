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


    this.showPageContent('people-leadership');

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
    this.router.navigate(['/team', index]);
    console.log("selectedIndexChange to: ", this.selectedIndex);
  }

  gotoDetail(): void {
    this.router.navigate(['/t/detail']);
  }

  /* test for page content */
    showPageContent(pageName: string): void {
        this.teamService.getPageContent(pageName).then(pageContent => this.pageContent = pageContent);

    }
}