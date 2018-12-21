import {Component, ElementRef, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
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
  @ViewChild('someVar') insertElement: ElementRef;

  constructor(
    private communityService: CommunityService,
    private route: ActivatedRoute,
    private location: Location
  ) {
  }

  ngOnInit(): void {
    const parent = this;
    this.route.params.subscribe(params => {
      this.communityService.getPageContent(params['pageUrl']).then(response => {
        //const el = document.createElement('html');
        //el.innerHTML = response;
        //parent.insertElement['nativeElement'].appendChild(el.getElementsByClassName('container-fluid')[0]);
        parent.community = response;
      });
    });
  }

  goBack(): void {
    this.location.back();
  }
}
