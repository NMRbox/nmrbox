import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {Location} from '@angular/common';
import {StaticPageService} from './static-page.service';
import {StaticPageModel} from './static-page.model';

@Component({
  selector: 'app-static-page',
  templateUrl: './static-page.component.html',
  styleUrls: ['./static-page.component.scss']
})
export class StaticPageComponent implements OnInit {
  staticPage: StaticPageModel;
  pageURL: string;

  constructor(
    private staticPageService: StaticPageService,
    private route: ActivatedRoute,
    private location: Location
  ) {
  }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      if (params['pageUrl'] !== undefined) {
        this.staticPageService.getPageContent(params['pageUrl']).then(response => this.staticPage = response);
        this.pageURL = params['pageUrl'];
      }
    });
  }

  goBack(): void {
    this.location.back();
  }
}
