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
    public appUrl = 'https://webdev.nmrbox.org:8001';  // URL to web api
    //public appUrl = 'http://nmrbox.dev';  // URL to web api
    private faqsUrl = 'faq';


  constructor(
      private http: Http
  ) { }

    getAllFaqs(): Promise<FaqsModel> {
        const url = this.appUrl + `/` + this.faqsUrl;
        console.log(url);
        return this.http
            .get(url)
            .toPromise()
            .then(response => response.json().data as FaqsModel)
            .catch(this.handleError);
    }

}
