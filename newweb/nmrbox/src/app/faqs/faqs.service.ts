import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';


/* import model */
import {FaqsModel} from './faqs.model';

@Injectable()
export class FaqsService {
  private handleError: any;
  public faqsUrl = 'faq';

  constructor(private http: HttpClient) {
  }

  getAllFaqs(): Promise<FaqsModel> {
    const url = environment.appUrl + `/` + this.faqsUrl;
    return this.http
      .get(url)
      .toPromise()
      .then(response => response['data'] as FaqsModel)
      .catch(this.handleError);
  }

  searchFAQs(search_term: string): Promise<FaqsModel> {
    const url = environment.appUrl + `/` + this.faqsUrl + `/` + search_term;
    return this.http
      .get(url)
      .toPromise()
      .then(response => response['data'] as FaqsModel)
      .catch(this.handleError);
  }
}
