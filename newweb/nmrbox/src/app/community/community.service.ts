import {Injectable} from '@angular/core';
import {HttpHeaders, HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';

import 'rxjs/add/operator/toPromise';

import {CommunityModel} from './community.model';

@Injectable()
export class CommunityService {

  private baseUrl = 'api/communityList';  // URL to web api
  private supportUrl = 'api/comSupportList';  // URL to web api
  private blogUrl = 'api/comBlogList';  // URL to web api
  private eventsUrl = 'events';  // URL to events page
  private eventRegisterUrl = 'events_register';  // URL to events page
  private documentationUrl = 'events';  // URL to documentation page


  private headers = new HttpHeaders({'Content-Type': 'application/json'});

  constructor(private http: HttpClient) {
  }

  create(name: string): Promise<CommunityModel> {
    return this.http
      .post(this.baseUrl, JSON.stringify({name: name}), {headers: this.headers})
      .toPromise()
      .then(res => res as CommunityModel)
      .catch(this.handleError);
  }

  /*
  getCommunitySection(contentType: string): Promise<CommunityModel[]> {

    console.log("getCommunitySection contentType: ", contentType);

    // ToDo: switch 'url' based on contentType

    return this.http
      .get(this.blogUrl)
      .toPromise()
      .then(response => response.json().data as CommunityModel[])
      .catch(this.handleError);
  }

  getCommunityIndex(index: number) {
      console.log("getCommunityIndex index: ", index);
  }
  */

  getAllEvents(): Promise<{}> {
    return this.http
      .get(environment.appUrl + `/` + this.eventsUrl)
      .toPromise()
      .then(response => {
        const response_json = response;
        return [response_json['data'] as CommunityModel[],
          response_json['data']['upcoming'] as CommunityModel[],
          response_json['data']['completed'] as CommunityModel[]];
      })
      .catch(this.handleError);
  }

  getCommunityList(): Promise<CommunityModel[]> {
    return new Promise<CommunityModel[]>(null);
    /*return this.http
      .get(this.appUrl + `/` + this.blogUrl)
      .toPromise()
      .then(response => response.json().data as CommunityModel[])
      .catch(this.handleError);*/
  }

  getSupportList(): Promise<CommunityModel[]> {
    return this.http
      .get(environment.appUrl + `/` + this.supportUrl)
      .toPromise()
      .then(response => response['data'] as CommunityModel[])
      .catch(this.handleError);
  }

  getSupportSubList(): Promise<CommunityModel[]> {
    return this.http
      .get(environment.appUrl + `/` + this.supportUrl)
      .toPromise()
      .then(response => response['data'] as CommunityModel[])
      .catch(this.handleError);
  }

  /* test (redirecting from router for page details */
  getPageContent(pageUrl: string): Promise<CommunityModel> {
    const url = environment.appUrl + '/' + pageUrl;
    return this.http
      .get(url)
      .toPromise()
      .then(response => response['data'] as CommunityModel)
      .catch(this.handleError);
  }

  /* test function */
  filterSupportType(supportType: string): Promise<CommunityModel[]> {


    return new Promise<CommunityModel[]>(null);
  }

  /* Workshop registration */
  workshopRegister(userid: string, workshopid: string) {
    return this.http.post(environment.appUrl + '/' + this.eventRegisterUrl, JSON.stringify(
      {
        userid: userid,
        workshopid: workshopid,
      }), {headers: this.headers});
  }

  update(software: CommunityModel): Promise<CommunityModel> {
    const url = `${this.baseUrl}/${software.id}`;
    return this.http
      .put(url, JSON.stringify(software), {headers: this.headers})
      .toPromise()
      .then(() => software)
      .catch(this.handleError);
  }

  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message || error);
  }
}
