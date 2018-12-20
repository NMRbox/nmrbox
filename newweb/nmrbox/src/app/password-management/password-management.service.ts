import {Injectable} from '@angular/core';
import {Headers, Http, Response} from '@angular/http';
import {environment} from '../../environments/environment';

@Injectable()
export class PasswordManagementService {

  private forgotPassUrl = 'password-forgot';  // URL to signin
  private forgotPassConfirmUrl = 'password-forgot-confirm';  // URL to signin
  private headers = new Headers({'Content-Type': 'application/json'});

  constructor(private http: Http) {
  }

  forgetPassword(email: string) {
    return this.http
      .post(environment.appUrl + '/' + this.forgotPassUrl, JSON.stringify({
        email: email
      }), {headers: this.headers})
      .map(
        (response: Response) => response.json()
        /*(response: Response) => {
            //console.log(response);
            const message = response.json().message;
            const type = response.json().type;
            return {message: message, type: type};
        }*/
      )
      /*
      .do(
          response => {
              localStorage.setItem('person_id', tokenData.person_id);
              localStorage.setItem('token', tokenData.token);
              this.router.navigateByUrl('user-dashboard');
          }
      )*/;
  }

  forgetPasswordConfirm(
    person_id: string,
    nmrbox_acct: string,
    password: string,
    password_confirm: string,
    pass_reset_confirm: string
  ) {
    return this.http
      .post(environment.appUrl + '/' + this.forgotPassConfirmUrl, JSON.stringify({
        person_id: person_id,
        nmrbox_acct: nmrbox_acct,
        password: password,
        password_confirm: password_confirm,
        pass_reset_code: pass_reset_confirm
      }), {headers: this.headers})
      .map(
        (response: Response) => response.json()
        /*(response: Response) => {
            //console.log(response);
            const message = response.json().message;
            const type = response.json().type;
            return {message: message, type: type};
        }*/
      )
      /*
      .do(
          response => {
              localStorage.setItem('person_id', tokenData.person_id);
              localStorage.setItem('token', tokenData.token);
              this.router.navigateByUrl('user-dashboard');
          }
      )*/;
  }

}
