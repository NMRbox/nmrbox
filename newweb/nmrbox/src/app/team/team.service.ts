import {Injectable} from '@angular/core';
import {HttpHeaders, HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';


import {TeamModel} from './team.model';

@Injectable()
export class TeamService {

  private baseUrl = 'api/teamSupportList/';  // URL to web api
  private supportUrl = 'api/comSupportList';  // URL to web api
  private blogUrl = 'api/comBlogList';  // URL to web api
  private eventsUrl = 'api/comEventsList';  // URL to web api

  private headers = new HttpHeaders({'Content-Type': 'application/json'});

  constructor(private http: HttpClient) {
  }

  create(name: string): Promise<TeamModel> {
    return this.http
      .post(environment.appUrl + '/' + this.baseUrl, JSON.stringify({name: name}), {headers: this.headers})
      .toPromise()
      .then(res => res['data'] as TeamModel)
      .catch(this.handleError);
  }

  /* test (redirecting from router for page details */
  getPageContent(pageUrl: string): Promise<any> {

    return new Promise((resolve, reject) => {
      resolve('<h1>Currently invalid "' + pageUrl + '": waiting for new static page access method. </h1>');
    });
/*
    const url = environment.appUrl + '/' + pageUrl;
    console.log('URL: ', url);
    return this.http
      .get(url, {responseType: 'text'})
      .toPromise()
      .then(response => response)
      .catch(this.handleError);*/
  }

  /* test */

  getDetail(id: number, type: string): Promise<TeamModel> {

    let baseUrl = `${environment.appUrl}/${this.blogUrl}`;

    if (type === 'support') {
      baseUrl = `${this.supportUrl}`;
    } else if (type === 'blog') {
      baseUrl = `${this.blogUrl}`;
    } else {
      baseUrl = `${this.eventsUrl}`;
    }

    const url = baseUrl + `/${id}`;

    return this.http
      .get(url)
      .toPromise()
      .then(response => response['data'] as TeamModel)
      .catch(this.handleError);
  }

  update(software: TeamModel): Promise<TeamModel> {
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
