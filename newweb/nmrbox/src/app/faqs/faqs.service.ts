import { Injectable } from '@angular/core';
import { Headers, Http, Response, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/toPromise';
import 'rxjs/add/operator/map';

/* import model */
import { FaqsModel } from './faqs.model';

@Injectable()
export class FaqsService {
    private handleError: any;

    /* Web api urls*/
    public appUrl = 'https://apidev.nmrbox.org';  // URL to web api
    // public appUrl = 'http://nmrbox.test';  // URL to web api
    public faqsUrl = 'faq';


  constructor(
      private http: Http
  ) { }

    getAllFaqs(): Promise<FaqsModel> {
        const url = this.appUrl + `/` + this.faqsUrl;
        return this.http
            .get(url)
            .toPromise()
            .then(response => response.json().data as FaqsModel)
            .catch(this.handleError);
    }

    searchFAQs($search_term: string ): Promise<FaqsModel> {
        const url = this.appUrl + `/` + this.faqsUrl + `/` + $search_term;

        return this.http
            .get(url)
            .toPromise()
            .then(response => response.json().data as FaqsModel)
            .catch(this.handleError);
    }

}
