import {Component, OnInit, Input} from '@angular/core';
import {StaticPageService} from './static-page.service';
import {EventModel} from './static-page.model';

@Component({
  selector: 'app-embedded-static-detail',
  templateUrl: './embedded-static.component.html',
  styleUrls: ['./embedded-static.component.scss']
})
export class EmbeddedStaticComponent implements OnInit {
  @Input() pageURL: string;
  staticPage: EventModel;

  constructor(
    private staticPageService: StaticPageService
  ) {
  }

  ngOnInit(): void {
    this.staticPageService.getPageContent(this.pageURL).then(response => this.staticPage = response);
  }
}
