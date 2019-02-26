import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {map} from 'rxjs/operators';

/* import model */
import {FaqsModel} from './faqs.model';

@Injectable()
export class FaqsService {

  public allFAQs: Array<FaqsModel>;
  public faqs: Array<FaqsModel>;

  constructor(private http: HttpClient) {
    this.allFAQs = [];
    this.faqs = [];

    const url = environment.appUrl + '/' + environment.faqsUrl;
    const parent = this;
    this.http.get(url).pipe(
      map(response => {
        for (const faq of response['data']) {
          parent.allFAQs.push(faq as FaqsModel);
        }
        parent.faqs = parent.allFAQs;
      })).subscribe();
  }

  searchFAQs(term: string): void {
    this.faqs = [];
    term = term.toLowerCase();
    for (const faq of this.allFAQs) {
      if (faq.question.toLowerCase().indexOf(term) > -1) {
        this.faqs.push(faq);
      }
      if (faq.answer.toLowerCase().indexOf(term) > -1) {
        this.faqs.push(faq);
      }
    }
  }
}
