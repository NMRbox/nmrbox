import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {EventModel} from './event.model';
import {BehaviorSubject} from 'rxjs/Rx';

@Injectable()
export class CommunityService {

  public upcomingEvents: BehaviorSubject<EventModel[]>;
  public pastEvents: BehaviorSubject<EventModel[]>;

  constructor(private http: HttpClient) {
    this.upcomingEvents = new BehaviorSubject([]);
    this.pastEvents = new BehaviorSubject([]);

    this.updateEvents();
  }

  updateEvents() {
    this.http
      .get(environment.appUrl + `/` + environment.eventsUrl)
      .subscribe(response => {
        this.upcomingEvents.next(response['data']['upcoming'] as EventModel[]);
        this.pastEvents.next(response['data']['completed'] as EventModel[]);
      });
  }
}
