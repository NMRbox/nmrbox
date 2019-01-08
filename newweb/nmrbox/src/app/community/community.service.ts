import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {EventModel} from './event.model';

@Injectable()
export class CommunityService {

  private eventsUrl = 'events';  // URL to events page
  private eventRegisterUrl = 'events_register';  // URL to events page

  private headers = new HttpHeaders({'Content-Type': 'application/json'});

  constructor(private http: HttpClient) {
  }

  getAllEvents(): Promise<{}> {
    return this.http
      .get(environment.appUrl + `/` + this.eventsUrl)
      .toPromise()
      .then(response => {
        const response_json = response;
        return [response_json['data'] as EventModel[],
          response_json['data']['upcoming'] as EventModel[],
          response_json['data']['completed'] as EventModel[]];
      })
      .catch(CommunityService.handleError);
  }

  /* Workshop registration */
  workshopRegister(userid: string, workshopid: string) {
    return this.http.post(environment.appUrl + '/' + this.eventRegisterUrl, JSON.stringify(
      {
        userid: userid,
        workshopid: workshopid,
      }), {headers: this.headers});
  }

  private static handleError(error: any): Promise<never> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message);
  }
}
