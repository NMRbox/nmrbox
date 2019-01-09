import {Injectable} from '@angular/core';
import {StaticPageModel} from './static-page.model';
import {environment} from '../../environments/environment';
import {HttpClient} from '@angular/common/http';
import {AuthenticationService} from '../authentication/authentication.service';

@Injectable()
export class StaticPageService {

  constructor(private http: HttpClient,
              private authService: AuthenticationService) {
  }

  getPageContent(pageUrl: string): Promise<StaticPageModel> {

    const url = environment.appUrl + '/pages/' + pageUrl;
    return this.http
      .get(url)
      .toPromise()
      .then(response => {
          if (response && response['data']) {
            return response['data'] as StaticPageModel;
          } else {
            return new StaticPageModel('No such page exists: ' + pageUrl);
          }
        },
        error => new StaticPageModel(error));
  };

  getAdmin() {
    return this.authService.isAdmin();
  }
}
