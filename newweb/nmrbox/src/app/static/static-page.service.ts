import {Injectable} from '@angular/core';
import {EventModel} from './static-page.model';
import {environment} from '../../environments/environment';
import {HttpClient} from '@angular/common/http';

@Injectable()
export class StaticPageService {

  constructor(private http: HttpClient) {
  }

  getPageContent(pageUrl: string): Promise<EventModel> {

    const url = environment.appUrl + '/pages/' + pageUrl;

    return this.http
      .get(url)
      .toPromise()
      .then(response => {
          if (response && response['data']) {
            return response['data'] as EventModel;
          } else {
            return new EventModel('No such page exists: ' + pageUrl);
          }
        },
        error => new EventModel(error));
  };
}
