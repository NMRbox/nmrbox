import {Component, OnInit, Input} from '@angular/core';
import {StaticPageService} from './static-page.service';
import {StaticPageModel} from './static-page.model';
import {environment} from '../../environments/environment';

@Component({
  selector: 'app-embedded-static-detail',
  templateUrl: './embedded-static.component.html',
  styleUrls: ['./embedded-static.component.scss']
})
export class EmbeddedStaticComponent implements OnInit {
  @Input() pageURL: string;
  @Input() staticPage: StaticPageModel;
  adminUser: boolean;
  appUrl: string;

  constructor(
    private staticPageService: StaticPageService
  ) {
  }

  ngOnInit(): void {
    // Get the page if we only have the URL
    if (!this.staticPage) {
      console.log('getting in inside', this.pageURL);
      this.staticPageService.getPageContent(this.pageURL).then(response => this.staticPage = response);
    }

    this.adminUser = this.staticPageService.getAdmin();
    this.appUrl = environment.appUrl;
  }
}
