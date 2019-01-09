import {Injectable} from '@angular/core';
import {HttpHeaders, HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';

@Injectable()
export class PasswordManagementService {


  private headers = new HttpHeaders({'Content-Type': 'application/json'});

  constructor(private http: HttpClient) {
  }

  forgetPassword(email: string) {
    return this.http
      .post(environment.appUrl + '/' + environment.forgotPassUrl, JSON.stringify({
        email: email
      }), {headers: this.headers});
  }

  forgetPasswordConfirm(
    person_id: string,
    nmrbox_acct: string,
    password: string,
    password_confirm: string,
    pass_reset_confirm: string
  ) {
    return this.http
      .post(environment.appUrl + '/' + environment.forgotPassConfirmUrl, JSON.stringify({
        person_id: person_id,
        nmrbox_acct: nmrbox_acct,
        password: password,
        password_confirm: password_confirm,
        pass_reset_code: pass_reset_confirm
      }), {headers: this.headers});
  }

}
