import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormControl, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';

import { Observable } from 'rxjs/Observable';

import { TeamModel } from './team.model';
import { TeamService }  from './team.service';

@Component({
  selector: 'team-list',
  templateUrl: './team-list.component.html',
  styleUrls: [ './team-list.component.scss' ]
})
export class TeamListComponent implements OnInit {

  constructor(
    private router: Router,
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

  }

  gotoDetail(teamModel: TeamModel): void {
    //this.router.navigate(['/t/detail', teamModel.contentType, teamModel.id]);
  }
}