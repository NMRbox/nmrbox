import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';

/* import model */
import {FaqsModel} from './faqs.model';
import {BehaviorSubject} from 'rxjs/Rx';

@Injectable()
export class FaqsService {

  public allFAQs: BehaviorSubject<Array<FaqsModel>>;
  private allFAQsDirectly: Array<FaqsModel>;

  constructor(private http: HttpClient) {
    this.allFAQs = new BehaviorSubject([]);

    this.allFAQs.subscribe(faqs => {
      this.allFAQsDirectly = faqs;
    });

    const url = environment.appUrl + '/' + environment.faqsUrl;
    const parent = this;
    this.http.get(url).subscribe(response => {
      const faqsList: Array<FaqsModel> = [];
      for (const faq of response['data']) {
        faqsList.push(faq as FaqsModel);
      }
      parent.allFAQs.next(faqsList);
    });
  }

  searchFAQs(term: string): Array<FaqsModel> {
    const faqs = [];
    term = term.toLowerCase();
    for (const faq of this.allFAQsDirectly) {
      if (faq.question.toLowerCase().indexOf(term) > -1) {
        faqs.push(faq);
      } else if (faq.answer.toLowerCase().indexOf(term) > -1) {
        faqs.push(faq);
      }
    }
    return faqs;
  }
}
