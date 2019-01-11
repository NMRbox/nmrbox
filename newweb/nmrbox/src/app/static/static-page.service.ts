import {Injectable} from '@angular/core';
import {StaticPageModel} from './static-page.model';
import {environment} from '../../environments/environment';
import {HttpClient} from '@angular/common/http';

@Injectable()
export class StaticPageService {

  constructor(private http: HttpClient) {
  }

  getPageContent(pageUrl: string): Promise<StaticPageModel> {

    const url = environment.appUrl + '/pages/' + pageUrl;
    return this.http
      .get(url)
      .toPromise()
      .then(response => {
          if (response && response['data']) {
            response['data']['content'] = response['data']['content'].replace(/((https*:\/\/)*nmrbox.org)*\/files\/(.+?)"/g,
              environment.appUrl + '/files/$3"');
            // The 'not a period' at the beginning is to prevent overwriting file URLs created above
            response['data']['content'] = response['data']['content'].replace(/https*:\/\/nmrbox.org\/([a-zA-Z0-9-]+)/g,
              '/#/pages/$1');

            return response['data'] as StaticPageModel;
          } else {
            return new StaticPageModel('No such page exists: ' + pageUrl);
          }
        },
        error => new StaticPageModel(error));
  };

}
