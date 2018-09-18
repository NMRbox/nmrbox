import {Injectable} from '@angular/core';
import {Http} from '@angular/http';
import {environment} from '../../environments/environment';
import 'rxjs/add/operator/toPromise';
import 'rxjs/add/operator/map';

/* import model */
import {FaqsModel} from './faqs.model';

@Injectable()
export class FaqsService {
  private handleError: any;
  public faqsUrl = 'faq';

  constructor(private http: Http) {
  }

  getAllFaqs(): Promise<FaqsModel> {
    const url = environment.appUrl + `/` + this.faqsUrl;
    return this.http
      .get(url)
      .toPromise()
      .then(response => response.json().data as FaqsModel)
      .catch(this.handleError);
  }

  searchFAQs(search_term: string): Promise<FaqsModel> {
    const url = environment.appUrl + `/` + this.faqsUrl + `/` + search_term;
    return this.http
      .get(url)
      .toPromise()
      .then(response => response.json().data as FaqsModel)
      .catch(this.handleError);
  }
}
