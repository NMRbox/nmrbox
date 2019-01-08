import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {Location} from '@angular/common';
import {StaticPageService} from './static-page.service';
import {EventModel} from './static-page.model';

@Component({
  selector: 'app-community-detail',
  templateUrl: './static-page.component.html',
  styleUrls: ['./static-page.component.scss']
})
export class StaticPageComponent implements OnInit {
  staticPage: EventModel;

  constructor(
    private staticPageService: StaticPageService,
    private route: ActivatedRoute,
    private location: Location
  ) {
  }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.staticPageService.getPageContent(params['pageUrl']).then(response => this.staticPage = response);
    });
  }

  goBack(): void {
    this.location.back();
  }
}
