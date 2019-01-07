import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {Location} from '@angular/common';
import {CommunityService} from './community.service';
import {CommunityModel} from './community.model';


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
    this.route.params.subscribe(params => {
      this.communityService.getPageContent(params['pageUrl']).then(response => this.community = response);
    });
  }

  goBack(): void {
    this.location.back();
  }
}
