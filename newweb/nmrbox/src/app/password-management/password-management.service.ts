import { Injectable } from '@angular/core';
import { Headers, Http, Response, RequestOptions } from '@angular/http';
import { Router } from '@angular/router';
import 'rxjs/Rx';
import 'rxjs/add/operator/toPromise';
import 'rxjs/add/operator/map';

import {PersonModel} from '../user-dashboard/person.model';
import {promise} from "selenium-webdriver";


@Injectable()
export class PasswordManagementService {
    private appUrl = 'https://apidev.nmrbox.org';  // URL to web api
    //private appUrl = 'http://nmrbox.dev';  // URL to web api
    private forgotPassUrl = 'password-forgot';  // URL to signin
    private forgotPassConfirmUrl = 'password-forgot-confirm';  // URL to signin
    private headers = new Headers({'Content-Type': 'application/json'});
    options: RequestOptions;

    constructor(private http: Http, private router: Router) { }

    forgetPassword(email: string) {
        return this.http
            .post(this.appUrl + '/' + this.forgotPassUrl, JSON.stringify({
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
            .post(this.appUrl + '/' + this.forgotPassConfirmUrl, JSON.stringify({
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
