import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';

/* import service files */
import {FaqsService} from './faqs.service';
import {Router} from '@angular/router';

@Component({
  selector: 'app-faqs',
  templateUrl: './faqs.component.html',
  styleUrls: ['./faqs.component.css']
})
export class FaqsComponent implements OnInit {
  public notifications: any = {message: '', type: ''};
  slug: string;
  term: string;

  constructor(
    private route: ActivatedRoute,
    private faqService: FaqsService,
    private router: Router
  ) {
  }

  ngOnInit(): void {

    /* Determine if they are viewing a specific FAQ */
    const parent = this;
    this.route.params.subscribe(function (params) {
      parent.slug = params['slug'];
    });

    if (this.term) {
      this.searchFAQs(this.term);
    }
  }

  toggleSlug(slug) {
    if (this.slug === slug) {
      this.slug = undefined;
      this.router.navigate(['faqs']);
    } else {
      this.slug = slug;
      this.router.navigate(['faqs', slug]);
    }
  }

  searchFAQs(term: string): void {
    this.faqService.searchFAQs(term);
  }
}
