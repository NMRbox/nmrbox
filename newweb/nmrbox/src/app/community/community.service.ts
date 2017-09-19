import { Injectable }    from '@angular/core';
import { Headers, Http, Response, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/toPromise';

import { CommunityModel } from './community.model';

@Injectable()
export class CommunityService {

  // test url
  private appUrl = 'https://webdev.nmrbox.org:8001';  // URL to web api
  //private appUrl = 'http://nmrbox.dev';  // URL to web api
  private baseUrl = 'api/communityList';  // URL to web api
  private supportUrl = 'api/comSupportList';  // URL to web api
  private blogUrl = 'api/comBlogList';  // URL to web api
  private eventsUrl = 'workshops';  // URL to web api
  //private eventsUrl = 'api/comEventsList';  // URL to web api

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

  getCommunityList(): Promise<CommunityModel[]> {
    return this.http
      .get(this.blogUrl)
      .toPromise()
      .then(response => response.json().data as CommunityModel[])
      .catch(this.handleError);
  }

  getSupportList(): Promise<CommunityModel[]> {
    return this.http
      .get(this.supportUrl)
      .toPromise()
      .then(response => response.json().data as CommunityModel[])
      .catch(this.handleError);
  }
  getSupportSubList(): Promise<CommunityModel[]> {
    return this.http
      .get(this.supportUrl)
      .toPromise()
      .then(response => response.json().data as CommunityModel[])
      .catch(this.handleError);
  }

  getBlogList(): Promise<CommunityModel[]> {
    return this.http
      .get(this.blogUrl)
      .toPromise()
      .then(response => response.json().data as CommunityModel[])
      .catch(this.handleError);
  }

  getEventsList(): Promise<CommunityModel[]> {
    return this.http
      .get(this.appUrl + `/` + this.eventsUrl)
      .toPromise()
      .then(response => response.json().data as CommunityModel[])
      .catch(this.handleError);
  }

    /* test (redirecting from router for page details */
    getPageContent(pageUrl: string): Promise<CommunityModel> {
        let url = this.appUrl + '/' + pageUrl;
        console.log("URL: ", url);
        return this.http
          .get(url)
          .toPromise()
          .then(response => response.json().data as CommunityModel)
          .catch(this.handleError);
    }


  //getSoftware(type: string, id: number): Promise<CommunityModel> {
  getCommunityDetail(id: number, type: string): Promise<CommunityModel> {

    let baseUrl = `${this.blogUrl}`;

    console.log("ID: ", id);
    console.log("TYPE: ", type);

    if(type == "support"){
      baseUrl = `${this.supportUrl}`;
    } else if(type == "blog") {
      baseUrl = `${this.blogUrl}`;
    } else {
      baseUrl = `${this.eventsUrl}`;
    }

    //let url = baseUrl + `/${id}`;
    let url = 'https://webdev.nmrbox.org:8001/documentation';

    console.log("getSoftware URL: ", url);

    return this.http
      .get(url)
      .toPromise()
      .then(response => response.json().data as CommunityModel)
      .catch(this.handleError);

  }

  /* test function */
    filterSupportType(supportType: string): Promise<CommunityModel[]> {
        let url = this.appUrl;
        if(supportType == "workflow"){
            let url = this.appUrl; // should be like http://nmrbox.dev/overview
        } else if(supportType == "tutorial") {
            let url = this.appUrl;
        } else if(supportType == "swdoc"){
            let url = this.appUrl;
        } else {
            let url = this.appUrl;
        }

        return this.http
            //.get(`${this.supportUrl}/?supportType=${supportType}`)
            .get(url)
            .toPromise()
            .then((r: Response) => r.json().data as CommunityModel[]);
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

  delete(id: number): Promise<void> {
    const url = `${this.baseUrl}/${id}`;
    return this.http.delete(url, {headers: this.headers})
      .toPromise()
      .then(() => null)
      .catch(this.handleError);
  }

  searchSoftware(term: string): Promise<CommunityModel[]> {

    //let url = this.blogUrl + '?name=' + name;

    return this.http
        .get(`${this.supportUrl}/?name=${term}`)
        .toPromise()
        .then((r: Response) => r.json().data as CommunityModel[]);
  }

  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message || error);
  }
}