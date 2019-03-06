import {AfterViewChecked, Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
/* import service files */
import {FaqsService} from './faqs.service';
import {FaqsModel} from './faqs.model';


@Component({
  selector: 'app-faqs',
  templateUrl: './faqs.component.html',
  styleUrls: ['./faqs.component.css']
})
export class FaqsComponent implements OnInit, AfterViewChecked {
  public notifications: any = {message: '', type: ''};
  slug: string;
  term: string;
  scrolled: boolean;
  faqs: Array<FaqsModel>;

  constructor(
    private route: ActivatedRoute,
    public faqService: FaqsService,
    private router: Router
  ) {
    this.scrolled = false;
  }

  // Scrolls to the active FAQ
  ngAfterViewChecked() {

    const el = document.getElementById('active');
    if (el) {
      if (!this.scrolled) {
        document.getElementById('active').scrollIntoView();
        window.scrollBy(0, -20);
        this.scrolled = true;
      }
    }
  }

  ngOnInit(): void {

    this.faqService.allFAQs.subscribe(faqs => {
      this.faqs = faqs;
    });

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
      this.router.navigate(['support', '0', slug]);
      this.scrolled = false;
    }
  }

  searchFAQs(term: string): void {
    this.faqs = this.faqService.searchFAQs(term);
  }
}
