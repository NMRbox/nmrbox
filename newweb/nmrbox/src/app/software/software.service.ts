import { Injectable }    from '@angular/core';
import { Headers, Http, Response, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/toPromise';

import { SoftwareModel } from './software.model';
import { FilterModel } from './../filter.model';

@Injectable()
export class SoftwareService {

  private appUrl = 'https://webdev.nmrbox.org:8001/registry';  // URL to web api
  private baseUrl = 'api/softwareList';  // URL to web api
  private swtUrl = 'api/swtList';  // URL to web api
  private testUrl = 'api/spectralSoftware';
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
      .get(this.appUrl)
      .toPromise()
      .then(response => response.json().data as SoftwareModel[])
      .catch(this.handleError);
  }

  getSwtList(): Promise<FilterModel[]> {
    console.log("getSwtList");
    return this.http
      .get(this.swtUrl)
      .toPromise()
      .then(response => response.json().data as FilterModel[])
      .catch(this.handleError);
  }

  getFilter(name: string): Promise<FilterModel> {
    console.log("getSwt, name: ", name);
    return this.http
      .get(`api/swtList/?name=${name}`)
      .toPromise()
      .then(response => response.json().data as FilterModel)
      .catch(this.handleError);
  }

  getSoftware(slug: string): Promise<SoftwareModel> {

    const url = `${this.appUrl}/${slug}`;
    return this.http
      .get(url)
      .toPromise()
      .then(response => response.json().data as SoftwareModel)
      .catch(this.handleError);
  }

  /*getSoftware(id: number): Promise<SoftwareModel> {
    const url = `${this.baseUrl}/${id}`;
    return this.http
      .get(url)
      .toPromise()
      .then(response => response.json().data as SoftwareModel)
      .catch(this.handleError);
  }*/

  update(software: SoftwareModel): Promise<SoftwareModel> {
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

  searchSoftware(term: string): Promise<SoftwareModel[]> {

    let url = this.baseUrl + '?name=' + name;

    return this.http
        .get(`api/softwareList/?name=${term}`)
        .toPromise()
        .then((r: Response) => r.json().data as SoftwareModel[]);
  }

  filterSoftwareType(softwareType: string, filterType: string): Promise<SoftwareModel[]> {
    //let filterType = "swt";
    let url = `api/softwareList/?software_types=${softwareType}`;
    //let url = `api/softwareList/?research_problems=${softwareType}`;

    
    if(filterType == "swt"){
      url = `api/softwareList/?software_types=${softwareType}`;
    } else if (filterType == "rp") {
      url = `api/softwareList/?research_problems=${softwareType}`;
    } else {
      url = `api/softwareList/?research_problems=${softwareType}&software_types=${softwareType}`;
    }
    

    return this.http
        //.get(`api/softwareList/?software_types=${softwareType}`)
        .get(url)
        .toPromise()
        .then((r: Response) => r.json().data as SoftwareModel[]);
  }

  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message || error);
  }
}