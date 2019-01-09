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
      .then(response => {
          if (response && response['data']) {
            return response['data'] as SoftwareModel[];
          } else {
            return [{}] as SoftwareModel[];
          }
        },
        () => []);
  }

  getSoftware(slug: string): Promise<SoftwareModel> {

    const url = environment.appUrl + `/` + environment.softwareRegistryUrl + `/` + slug;
    return this.http
      .get(url)
      .toPromise()
      .then(response => {
          if (response && response['data']) {
            return response['data'] as SoftwareModel;
          } else {
            return {} as SoftwareModel;
          }
        },
        () => new SoftwareModel(slug));
  }

  getSoftwareMetaData(slug: string): Promise<SoftwareMetadataModel> {

    const url = environment.appUrl + `/` + environment.softwareRegistryMetaUrl + `/` + slug;
    return this.http
      .get(url)
      .toPromise()
      .then(response => {
          if (response && response['data']) {
            return response['data'] as SoftwareMetadataModel;
          } else {
            return {} as SoftwareMetadataModel;
          }
        },
        () => new SoftwareMetadataModel());
  }
}
