import { Injectable }    from '@angular/core';
import { Headers, Http, Response, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/toPromise';

import { TeamModel } from './team.model';

@Injectable()
export class TeamService {

  private baseUrl = 'https://webdev.nmrbox.org:8001/';  // URL to web api
  private supportUrl = 'api/comSupportList';  // URL to web api
  private blogUrl = 'api/comBlogList';  // URL to web api
  private eventsUrl = 'api/comEventsList';  // URL to web api

  private headers = new Headers({'Content-Type': 'application/json'});

  constructor(private http: Http) { }

  create(name: string): Promise<TeamModel> {
    return this.http
      .post(this.baseUrl, JSON.stringify({name: name}), {headers: this.headers})
      .toPromise()
      .then(res => res.json().data as TeamModel)
      .catch(this.handleError);
  }

  getPageContent(type: string): Promise<TeamModel> {

//      let url = 'http://nmrbox.dev/documentation';

      let url = this.baseUrl + `/${type}`;

      console.log("getSoftware URL: ", url);

      return this.http
          .get(url)
          .toPromise()
          .then(response => response.json().data as TeamModel)
          .catch(this.handleError);

  }

  /*getCommunityList(): Promise<TeamModel[]> {
    return this.http
      .get(this.blogUrl)
      .toPromise()
      .then(response => response.json().data as TeamModel[])
      .catch(this.handleError);
  }

  getSupportList(): Promise<TeamModel[]> {
    return this.http
      .get(this.supportUrl)
      .toPromise()
      .then(response => response.json().data as TeamModel[])
      .catch(this.handleError);
  }
  getSupportSubList(): Promise<TeamModel[]> {
    return this.http
      .get(this.supportUrl)
      .toPromise()
      .then(response => response.json().data as TeamModel[])
      .catch(this.handleError);
  }

  getBlogList(): Promise<TeamModel[]> {
    return this.http
      .get(this.blogUrl)
      .toPromise()
      .then(response => response.json().data as TeamModel[])
      .catch(this.handleError);
  }

  getEventsList(): Promise<TeamModel[]> {
    return this.http
      .get(this.eventsUrl)
      .toPromise()
      .then(response => response.json().data as TeamModel[])
      .catch(this.handleError);
  }*/

  getDetail(id: number, type: string): Promise<TeamModel> {
    
    let baseUrl = `${this.blogUrl}`;

    console.log("getSoftware TYPE: ", type); 
    
    if(type == "support"){
      baseUrl = `${this.supportUrl}`;
    } else if(type == "blog") {
      baseUrl = `${this.blogUrl}`;
    } else {
      baseUrl = `${this.eventsUrl}`;
    }

    let url = baseUrl + `/${id}`;

    console.log("getSoftware URL: ", url);
    
    return this.http
      .get(url)
      .toPromise()
      .then(response => response.json().data as TeamModel)
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

  delete(id: number): Promise<void> {
    const url = `${this.baseUrl}/${id}`;
    return this.http.delete(url, {headers: this.headers})
      .toPromise()
      .then(() => null)
      .catch(this.handleError);
  }

  /*searchSoftware(term: string): Promise<TeamModel[]> {

    //let url = this.blogUrl + '?name=' + name;

    return this.http
        .get(`${this.supportUrl}/?name=${term}`)
        .toPromise()
        .then((r: Response) => r.json().data as TeamModel[]);
  }

  filterSoftwareType(softwareType: string): Promise<TeamModel[]> {

    return this.http
        .get(`${this.supportUrl}/?software_types=${softwareType}`)
        .toPromise()
        .then((r: Response) => r.json().data as TeamModel[]);
  }

  filterSupportType(supportType: string): Promise<TeamModel[]> {

    return this.http
        .get(`${this.supportUrl}/?supportType=${supportType}`)
        .toPromise()
        .then((r: Response) => r.json().data as TeamModel[]);
  }
  filterMostRecent(dateCurrent: boolean): Promise<TeamModel[]> {

    return this.http
        .get(`${this.blogUrl}/?dateCurrent=${dateCurrent}`)
        .toPromise()
        .then((r: Response) => r.json().data as TeamModel[]);
  }
  filterCurrentEvents(dateCurrent: boolean): Promise<TeamModel[]> {

    return this.http
        .get(`${this.eventsUrl}/?dateCurrent=${dateCurrent}`)
        .toPromise()
        .then((r: Response) => r.json().data as TeamModel[]);
  }*/

  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message || error);
  }
}