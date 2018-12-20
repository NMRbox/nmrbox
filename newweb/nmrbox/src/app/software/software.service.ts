import {Injectable} from '@angular/core';
import {HttpHeaders, HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import 'rxjs/add/operator/toPromise';

import {SoftwareModel} from './software.model';
import {FilterModel} from '../filter.model';
import {SoftwareMetadataModel} from './software-metadata.model';

@Injectable()
export class SoftwareService {

  private baseUrl = 'api/softwareList';  // URL to web api
  private swtUrl = 'registry';  // URL to web api
  private swtMtDtUrl = 'registry/software-metadata';  // URL to web api
  private headers = new HttpHeaders({'Content-Type': 'application/json'});

  constructor(private http: HttpClient) {
  }

  create(name: string): Promise<SoftwareModel> {
    return this.http
      .post(this.baseUrl, JSON.stringify({name: name}), {headers: this.headers})
      .toPromise()
      .then(res => res['data'] as SoftwareModel)
      .catch(this.handleError);

  }

  getSoftwareList(): Promise<SoftwareModel[]> {
    return this.http
      .get(environment.appUrl + `/` + this.swtUrl)
      .toPromise()
      .then(response => response['data'] as SoftwareModel[])
      .catch(this.handleError);
  }

  getFilter(name: string): Promise<FilterModel> {
    console.log('getSwt, name: ', name);
    console.log('URL: ', environment.appUrl + `/?name=${name}`);
    return this.http
      .get(environment.appUrl + `/?name=${name}`)
      .toPromise()
      .then(response => response['data'] as FilterModel)
      .catch(this.handleError);
  }

  getSoftware(slug: string): Promise<SoftwareModel> {

    const url = environment.appUrl + `/` + this.swtUrl + `/` + slug;
    console.log(url);
    return this.http
      .get(url)
      .toPromise()
      .then(response => response['data'] as SoftwareModel)
      .catch(this.handleError);
  }

  getSoftwareMetaData(slug: string): Promise<SoftwareMetadataModel> {

    const url = environment.appUrl + `/` + this.swtMtDtUrl + `/` + slug;
    console.log(url);

    return this.http
      .get(url)
      .toPromise()
      .then(response => response['data'] as SoftwareMetadataModel)
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

  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message || error);
  }
}
