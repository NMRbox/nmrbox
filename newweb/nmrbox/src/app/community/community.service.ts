import { Injectable } from '@angular/core';
import { Headers, Http, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';

import { CommunityModel } from './community.model';

@Injectable()
export class CommunityService {

  private appUrl = 'https://apidev.nmrbox.org';  // URL to web api
  private baseUrl = 'api/communityList';  // URL to web api
  private supportUrl = 'api/comSupportList';  // URL to web api
  private blogUrl = 'api/comBlogList';  // URL to web api
  private eventsUrl = 'events';  // URL to events page
  private eventRegisterUrl = 'events_register';  // URL to events page
  private documentationUrl = 'events';  // URL to documentation page


  private headers = new Headers({'Content-Type': 'application/json'});

  constructor(private http: Http) { }

  create(name: string): Promise<CommunityModel> {
    return this.http
      .post(this.baseUrl, JSON.stringify({name: name}), {headers: this.headers})
      .toPromise()
      .then(res => res.json().data as CommunityModel)
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
      .get(this.appUrl + `/` + this.eventsUrl)
      .toPromise()
      .then(response => {
        const response_json = response.json();
        return [response_json.data as CommunityModel[],
                response_json.data.upcoming as CommunityModel[],
                response_json.data.completed as CommunityModel[]];
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
      .get(this.appUrl + `/` + this.supportUrl)
      .toPromise()
      .then(response => response.json().data as CommunityModel[])
      .catch(this.handleError);
    }
    getSupportSubList(): Promise<CommunityModel[]> {
    return this.http
      .get(this.appUrl + `/` + this.supportUrl)
      .toPromise()
      .then(response => response.json().data as CommunityModel[])
      .catch(this.handleError);
    }

    /* test (redirecting from router for page details */
    getPageContent(pageUrl: string): Promise<CommunityModel> {
        const url = this.appUrl + '/' + pageUrl;
        return this.http
          .get(url)
          .toPromise()
          .then(response => response.json().data as CommunityModel)
          .catch(this.handleError);
    }


  getCommunityDetail(id: number, type: string): Promise<CommunityModel> {

    let baseUrl = `${this.blogUrl}`;

    console.log('ID: ', id);
    console.log('TYPE: ', type);

    if (type === 'support') {
      baseUrl = `${this.supportUrl}`;
    } else if (type === 'blog') {
      baseUrl = `${this.blogUrl}`;
    } else {
      baseUrl = `${this.eventsUrl}`;
    }

    // let url = baseUrl + `/${id}`;
    // let url = 'https://apidev.nmrbox.org/documentation';
    const url = this.appUrl + '/' + this.documentationUrl;

    console.log('getSoftware URL: ', url);

    return this.http
      .get(url)
      .toPromise()
      .then(response => response.json().data as CommunityModel)
      .catch(this.handleError);

  }

  /* test function */
    filterSupportType(supportType: string): Promise<CommunityModel[]> {


      return new Promise<CommunityModel[]>(null); /*

        let url = this.appUrl;
        if (supportType === 'workflow') {
            url = this.appUrl; // should be like http://nmrbox.dev/overview
        } else if (supportType === 'tutorial') {
            url = this.appUrl;
        } else if (supportType === 'swdoc') {
            url = this.appUrl;
        } else {
            url = this.appUrl;
        }

        return this.http
            //.get(`${this.supportUrl}/?supportType=${supportType}`)
            .get(url)
            .toPromise()
            .then((r: Response) => r.json().data as CommunityModel[]);*/
    }

    /*filterSupportType(supportType: string): Promise<CommunityModel[]> {

        return this.http
            .get(`${this.supportUrl}/?supportType=${supportType}`)
            .toPromise()
            .then((r: Response) => r.json().data as CommunityModel[]);
    }*/

    filterSoftwareType(softwareType: string): Promise<CommunityModel[]> {

        return this.http
            .get(`${this.supportUrl}/?software_types=${softwareType}`)
            .toPromise()
            .then((r: Response) => r.json().data as CommunityModel[]);
    }

    filterMostRecent(dateCurrent: boolean): Promise<CommunityModel[]> {

        return this.http
            .get(`${this.blogUrl}/?dateCurrent=${dateCurrent}`)
            .toPromise()
            .then((r: Response) => r.json().data as CommunityModel[]);
    }
    filterCurrentEvents(): Promise<CommunityModel[]> {

        return this.http
            .get(this.appUrl + `/` + this.eventsUrl)
            .toPromise()
            .then((r: Response) => r.json().data as CommunityModel[]);
    }
    /*
    filterCurrentEvents(dateCurrent: boolean): Promise<CommunityModel[]> {

        return this.http
            .get(`${this.eventsUrl}/?dateCurrent=${dateCurrent}`)
            .toPromise()
            .then((r: Response) => r.json().data as CommunityModel[]);
    }*/

  update(software: CommunityModel): Promise<CommunityModel> {
    const url = `${this.baseUrl}/${software.id}`;
    return this.http
      .put(url, JSON.stringify(software), {headers: this.headers})
      .toPromise()
      .then(() => software)
      .catch(this.handleError);
  }


  searchSoftware(term: string): Promise<CommunityModel[]> {

    return new Promise<CommunityModel[]>(null);
    /*
    return this.http
        .get(`${this.appUrl}/${this.supportUrl}/?name=${term}`)
        .toPromise()
        .then((r: Response) => r.json().data as CommunityModel[]);*/
  }

  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message || error);
  }

  /* Workshop registration */
    workshopRegister(userid: string, workshopid: string) {
        return this.http.post(this.appUrl + '/' + this.eventRegisterUrl, JSON.stringify(
            {
                userid: userid,
                workshopid: workshopid,
            }), {headers: this.headers})
            .map(
                (response: Response) => response.json()
            );
    }
}
