import {Component, OnInit} from '@angular/core';
import {PRIMARY_OUTLET, Router, UrlSegment, UrlSegmentGroup, UrlTree} from '@angular/router';

/* import model files */
import {FaqsModel} from './faqs.model';

/* import service files */
import {FaqsService} from './faqs.service';

@Component({
  selector: 'app-faqs',
  templateUrl: './faqs.component.html',
  styleUrls: ['./faqs.component.css']
})
export class FaqsComponent implements OnInit {
  faqs: FaqsModel;

  showHide = false;
  public notifications: any = {message: '', type: ''};
  slug: string;
  term: string;

  constructor(
    private faqService: FaqsService,
    private router: Router
  ) {
    this.showHide = true;
  }

  ngOnInit(): void {
    const tree: UrlTree = this.router.parseUrl(this.router.url);
    const g: UrlSegmentGroup = tree.root.children[PRIMARY_OUTLET];
    const s: UrlSegment[] = g.segments;

    this.slug = (s.length > 1 ? s[1].path : '');


    /* get all FAQs*/
    this.getAllFaqs();
    if (this.term) {
      this.searchFAQs(this.term);
    }
  }

  getAllFaqs(): void {
    this.faqService.getAllFaqs().then(allFaqs => this.faqs = allFaqs);
  }

  searchFAQs(term: string): void {
    this.faqService.searchFAQs(term).then(allFaqs => this.faqs = allFaqs);
  }

}
