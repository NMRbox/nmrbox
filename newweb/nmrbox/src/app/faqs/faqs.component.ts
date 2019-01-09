import {AfterViewChecked, Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
/* import service files */
import {FaqsService} from './faqs.service';


@Component({
  selector: 'app-faqs',
  templateUrl: './faqs.component.html',
  styleUrls: ['./faqs.component.css']
})
export class FaqsComponent implements OnInit, AfterViewChecked {
  public notifications: any = {message: '', type: ''};
  slug: string;
  term: string;

  constructor(
    private route: ActivatedRoute,
    public faqService: FaqsService,
    private router: Router
  ) {
  }

  // Scrolls to the active FAQ
  ngAfterViewChecked() {
    const el = document.getElementById('active');
    if (el) {
      document.getElementById('active').scrollIntoView();
      window.scrollBy(0, -20);
    }
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
    } else {
      this.slug = slug;
      this.router.navigate(['faqs', slug]);
    }
  }

  searchFAQs(term: string): void {
    this.faqService.searchFAQs(term);
  }
}
