import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {EventModel} from './event.model';

@Injectable()
export class CommunityService {

  constructor(private http: HttpClient) {
  }

  getAllEvents(): Promise<{}> {
    return this.http
      .get(environment.appUrl + `/` + environment.eventsUrl)
      .toPromise()
      .then(response => {
          const response_json = response;
          return [response_json['data']['upcoming'] as EventModel[],
                  response_json['data']['completed'] as EventModel[]];
        },
        () => [[], []]);
  }

}
