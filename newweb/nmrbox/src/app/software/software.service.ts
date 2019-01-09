import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';


import {SoftwareModel} from './software.model';
import {SoftwareMetadataModel} from './software-metadata.model';

@Injectable()
export class SoftwareService {

  constructor(private http: HttpClient) {
  }

  getSoftwareList(): Promise<SoftwareModel[]> {
    return this.http
      .get(environment.appUrl + `/` + environment.softwareRegistryUrl)
      .toPromise()
      .then(response => response['data'] as SoftwareModel[])
      .catch(this.handleError);
  }

  getSoftware(slug: string): Promise<SoftwareModel> {

    const url = environment.appUrl + `/` + environment.softwareRegistryUrl + `/` + slug;
    return this.http
      .get(url)
      .toPromise()
      .then(response => response['data'] as SoftwareModel)
      .catch(this.handleError);
  }

  getSoftwareMetaData(slug: string): Promise<SoftwareMetadataModel> {

    const url = environment.appUrl + `/` + environment.softwareRegistryMetaUrl + `/` + slug;
    return this.http
      .get(url)
      .toPromise()
      .then(response => response['data'] as SoftwareMetadataModel)
      .catch(this.handleError);
  }

  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message || error);
  }
}
