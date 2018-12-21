import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {Location} from '@angular/common';
import {CommunityService} from './community.service';


@Component({
  selector: 'app-community-detail',
  templateUrl: './community-detail.component.html',
  styleUrls: ['./community-detail.component.scss']
})
export class CommunityDetailComponent implements OnInit {
  community: string;

  constructor(
    private communityService: CommunityService,
    private route: ActivatedRoute,
    private location: Location
  ) {
  }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.community = this.communityService.getPageContent(params['pageUrl']);
    });
  }

  goBack(): void {
    this.location.back();
  }
}
