import {Injectable} from '@angular/core';
import {HttpHeaders, HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import 'rxjs/add/operator/toPromise';

/* import model */
import {PersonModel} from './person.model';

@Injectable()
export class UserDashboardService {
  handleError: any;

  private passResetUrl = 'password-reset';  // URL to password reset
  private DownloadableVMUrl = 'downloadable-vm';  // URL to downloadable vm
  private personUrl = 'person';  // URL to web api
  private headers = new HttpHeaders({'Content-Type': 'application/json'});

  constructor(private http: HttpClient) {
  }

  getPersonDetails(id: string): Promise<PersonModel> {
    const url = environment.appUrl + `/` + this.personUrl + `/` + id;

    return this.http
      .get(url)
      .toPromise()
      .then(response => response['data'] as PersonModel)
      .catch(this.handleError);
  }

  SubmitResetPassword(
    person_id: string,
    current_pass: string,
    new_pass: string,
    confirm_new_pass: string
  ) {
    return this.http.post(environment.appUrl + '/' + this.passResetUrl, JSON.stringify(
      {
        person_id: person_id,
        current_pass: current_pass,
        new_pass: new_pass,
        confirm_new_pass: confirm_new_pass
      }), {headers: this.headers});
  }

  SubmitDownloadVM(
    person_id: string,
    vm_id: string,
    vm_username: string,
    vm_password: string
  ) {
    return this.http.post(environment.appUrl + '/' + this.DownloadableVMUrl, JSON.stringify(
      {
        person_id: person_id,
        vm_id: vm_id,
        vm_username: vm_username,
        vm_password: vm_password
      }), {headers: this.headers});
  }
}
