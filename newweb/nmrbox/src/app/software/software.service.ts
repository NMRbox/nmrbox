import { Injectable } from '@angular/core';
import { Headers, Http, Response } from '@angular/http';
import { environment } from '../../environments/environment';
import 'rxjs/add/operator/toPromise';

import { SoftwareModel } from './software.model';
import { FilterModel } from '../filter.model';
import {SoftwareMetadataModel} from './software-metadata.model';

@Injectable()
export class SoftwareService {

  private baseUrl = 'api/softwareList';  // URL to web api
  private swtUrl = 'registry';  // URL to web api
  private swtFltrUrl = 'registry/filter-software-search';  // URL to web api
  private swtMtDtUrl = 'registry/software-metadata';  // URL to web api
  private headers = new Headers({'Content-Type': 'application/json'});

  constructor(private http: Http) { }

  create(name: string): Promise<SoftwareModel> {
    return this.http
      .post(this.baseUrl, JSON.stringify({name: name}), {headers: this.headers})
      .toPromise()
      .then(res => res.json().data as SoftwareModel)
      .catch(this.handleError);

  }

  getSoftwareList(): Promise<SoftwareModel[]> {
    return this.http
      .get(environment.appUrl + `/` + this.swtUrl)
      .toPromise()
      .then(response => response.json().data as SoftwareModel[])
      .catch(this.handleError);
  }

  getFilter(name: string): Promise<FilterModel> {
    console.log('getSwt, name: ', name);
    console.log('URL: ', environment.appUrl + `/?name=${name}`);
    return this.http
        .get(environment.appUrl + `/?name=${name}`)
      .toPromise()
      .then(response => response.json().data as FilterModel)
      .catch(this.handleError);
  }

  getSoftware(slug: string): Promise<SoftwareModel> {

    const url = environment.appUrl + `/` + this.swtUrl + `/` + slug;
    console.log(url);
    return this.http
      .get(url)
      .toPromise()
      .then(response => response.json().data as SoftwareModel)
      .catch(this.handleError);
  }

  getSoftwareMetaData(slug: string): Promise<SoftwareMetadataModel> {

      const url = environment.appUrl + `/` + this.swtMtDtUrl + `/` + slug ;
      console.log(url);

      return this.http
              .get(url)
              .toPromise()
              .then(response => response.json().data as SoftwareMetadataModel)
              .catch(this.handleError);
  }

  update(software: SoftwareModel): Promise<SoftwareModel> {
    const url = `${this.baseUrl}/${software.id}`;
    return this.http
      .put(url, JSON.stringify(software), {headers: this.headers})
      .toPromise()
      .then(() => software)
      .catch(this.handleError);
  }

  delete(id: number): Promise<Response | never> {
    const url = `${this.baseUrl}/${id}`;
    return this.http.delete(url, {headers: this.headers})
      .toPromise()
      .then(() => null)
      .catch(this.handleError);
  }

  searchSoftware(term: string): Promise<SoftwareModel[]> {

    let url;

    if ( term ) {
        url = environment.appUrl + `/` + this.swtFltrUrl + `/${term}`;
    } else {
        url = environment.appUrl + `/` + this.swtUrl ;
    }

    return this.http
        .get(url)
        .toPromise()
        .then((r: Response) => r.json().data as SoftwareModel[]);
  }

  filterSoftwareType(softwareType: string, filterType: string): Promise<SoftwareModel[]> {
    let url = `api/softwareList/?software_types=${softwareType}`;
    // let url = `api/softwareList/?research_problems=${softwareType}`;


    if (filterType === 'swt') {
      url = `${environment.appUrl}/api/softwareList/?software_types=${softwareType}`;
    } else if (filterType === 'rp') {
      url = `${environment.appUrl}/api/softwareList/?research_problems=${softwareType}`;
    } else {
      url = `${environment.appUrl}/api/softwareList/?research_problems=${softwareType}&software_types=${softwareType}`;
    }

    return this.http
        // .get(`api/softwareList/?software_types=${softwareType}`)
        .get(url, {headers: this.headers})
        .toPromise()
        .then((r: Response) => r.json().data as SoftwareModel[]);
  }

  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message || error);
  }
}
