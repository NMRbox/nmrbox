import {Component, OnInit, Input} from '@angular/core';
import {StaticPageService} from './static-page.service';
import {StaticPageModel} from './static-page.model';
import {environment} from '../../environments/environment';
import {AuthenticationService} from '../authentication/authentication.service';

@Component({
  selector: 'app-embedded-static-detail',
  templateUrl: './embedded-static.component.html',
  styleUrls: ['./embedded-static.component.scss']
})
export class EmbeddedStaticComponent implements OnInit {
  @Input() pageURL: string;
  @Input() staticPage: StaticPageModel;
  appUrl: string;

  constructor(
    private staticPageService: StaticPageService,
    private authService: AuthenticationService
  ) {
  }

  ngOnInit(): void {
    // Get the page if we only have the URL
    if (!this.staticPage) {
      this.staticPageService.getPageContent(this.pageURL).then(response => this.staticPage = response);
    }

    this.appUrl = environment.appUrl;
  }
}
