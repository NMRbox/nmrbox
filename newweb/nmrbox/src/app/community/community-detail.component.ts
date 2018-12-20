
import {switchMap} from 'rxjs/operators';

import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Params} from '@angular/router';
import {Location} from '@angular/common';

import {CommunityModel} from './community.model';
import {CommunityService} from './community.service';

@Component({
  selector: 'app-community-detail',
  templateUrl: './community-detail.component.html',
  styleUrls: ['./community-detail.component.scss']
})
export class CommunityDetailComponent implements OnInit {
  community: CommunityModel;

  constructor(
    private communityService: CommunityService,
    private route: ActivatedRoute,
    private location: Location
  ) {
  }

  ngOnInit(): void {
    /*this.route.params
      .switchMap((params: Params) => this.communityService.getCommunityDetail(+params['id'], params['type']))
      .subscribe(community => this.community = community);*/
    /* test (new community details page) */
    this.route.params.pipe(
      switchMap((params: Params) => this.communityService.getPageContent(params['pageUrl'])))
      .subscribe(community => this.community = community);
  }

  goBack(): void {
    this.location.back();
  }
}

/*
import { CommunityModel }         from './community.model';
import { CommunityService }  from './community.service';
@Component({
  selector: 'community-detail',
  templateUrl: './community-detail.component.html',
  styleUrls: [ './community-detail.component.scss' ]
})
export class CommunityDetailComponent implements OnInit {
  software: CommunityModel;

  constructor(
    private communityService: CommunityService,
    private route: ActivatedRoute,
    private location: Location
  ) {}

  ngOnInit(): void {
    this.route.params
      .switchMap((params: Params) => this.communityService.getSoftware(+params['id']))
      .subscribe(software => this.software = software);
  }

  save(): void {
  this.communityService.update(this.software)
    .then(() => this.goBack());
  }

  goBack(): void {
    this.location.back();
  }
}
*/
