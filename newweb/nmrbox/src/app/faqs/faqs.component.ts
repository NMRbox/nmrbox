import { Component, OnInit } from '@angular/core';
import {PRIMARY_OUTLET, Router, UrlSegment, UrlSegmentGroup, UrlTree} from '@angular/router';
import { ActivatedRoute } from '@angular/router';

/* import model files */
import { FaqsModel} from './faqs.model';

/* import service files */
import { FaqsService } from './faqs.service';

@Component({
  selector: 'app-faqs',
  templateUrl: './faqs.component.html',
  styleUrls: ['./faqs.component.css']
})
export class FaqsComponent implements OnInit {
    faqs: FaqsModel;
    allFaqs: FaqsModel[];

    showHide = false;
    panelOpenState = false;
    public notifications: any = {message: '', type: ''};
    step = 0;
    slug: string;
    term: string;

    constructor(
      private faqService: FaqsService,
      private router: Router,
      private route: ActivatedRoute,
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
        this.searchFAQs(this.term);
    }

    getAllFaqs(): void {
        this.faqService.getAllFaqs().then(allFaqs => this.faqs = allFaqs);
    }

    searchFAQs(term: string): void {
        this.faqService.searchFAQs(term).then(allFaqs => this.faqs = allFaqs);
    }

}
