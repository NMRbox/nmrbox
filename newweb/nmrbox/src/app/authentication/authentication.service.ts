import { Injectable } from '@angular/core';
import { Headers, Http, Response, RequestOptions } from '@angular/http';
import { Router } from '@angular/router';
import 'rxjs/Rx';
import {Observable} from "rxjs/Observable";

@Injectable()
export class AuthenticationService {
    //private appUrl = 'http://nmrbox.dev';  // URL to web api
    private appUrl = 'https://webdev.nmrbox.org:8001';  // URL to web api
    private signinUrl = 'signin';  // URL to signin
    private signupUrl = 'signup';  // URL to signup
    private profileUpdateUrl = 'updateProfile';  // URL to profileUpdate
    private authUrl = 'auth.php';  // URL to Laravel CURL page
    private headers = new Headers({'Content-Type': 'application/json'});

    constructor(private http: Http, private router: Router) {

    }

    private _serverError(err: any) {
        console.log('sever error:', err);  // debug
        if(err instanceof Response) {
            return Observable.throw((response: Response) => response.json() || 'backend server error');
            // if you're using lite-server, use the following line
            // instead of the line above:
            //return Observable.throw(err.text() || 'backend server error');
        }
        return Observable.throw(err || 'backend server error');
    }

    signup(
        first_name: string,
        last_name: string,
        email: string,
        email_institution: string,
        pi: string,
        institution: string,
        institution_type: number,
        department: string,
        job_title: string,
        address1: string,
        address2: string,
        address3: string,
        city: string,
        state_province: string,
        zip_code: number,
        country: string,
        time_zone_id: number,
        ) {
        return this.http
            .post(this.appUrl + '/' + this.signupUrl, JSON.stringify(
                {
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    email_institution: email_institution,
                    pi: pi,
                    institution: institution, // set to unassigned, but update immediately after saving the model
                    institution_type: institution_type, // set to unassigned, but update immediately after saving the model
                    department: department,
                    job_title: job_title,
                    address1: address1,
                    address2: address2,
                    address3: address3,
                    city: city,
                    state_province: state_province,
                    zip_code: zip_code,
                    country: country,
                    time_zone_id: time_zone_id,
                    request_type: 'signup'
                }), {headers: this.headers})
            .map(
                (response: Response) => {
                    const message = response.json().message;
                    if (message === 'success') {
                        this.router.navigateByUrl('signin');
                    } else {
                        console.log('couldnt save data');
                    }
                }
            )
        ;
    }

    signin(username: string, password: string) {
        return this.http
            .post(this.appUrl + '/' + this.signinUrl, JSON.stringify({
                    username: username,
                    password: password,
                    request_type: 'signin'
                }), {headers: this.headers})
            .map(
                (response: Response) => {
                    console.log(response);
                    if(response.json().person_id != null){
                        const person_id = response.json().person_id;
                        const user_is_admin = response.json().user_is_admin;
                        const token = response.json().token;
                        const base64Url = token.split('.')[1];
                        const base64 = base64Url.replace('-', '+').replace('_', '/');
                        return {person_id: person_id, user_is_admin: user_is_admin, token: token, decoded: JSON.parse(window.atob(base64))};
                    }
                }
            )
            .do(
                tokenData => {
                    localStorage.setItem('person_id', tokenData.person_id);
                    localStorage.setItem('user_is_admin', tokenData.user_is_admin);
                    localStorage.setItem('token', tokenData.token);
                    this.router.navigateByUrl('user-dashboard');
                }
            )
            .catch(this._serverError);
        ;
    }

    public getToken(name: string) {
        return localStorage.getItem( name );
    }

    public deleteToken(name: string) {
        return localStorage.removeItem( name );
    }


    public getCookie(name: string) {
        let ca: Array<string> = document.cookie.split(';');
        let caLen: number = ca.length;
        let cookieName = `${name}=`;
        let c: string;

        for (let i: number = 0; i < caLen; i += 1) {
            c = ca[i].replace(/^\s+/g, '');
            if (c.indexOf(cookieName) === 0) {
                return c.substring(cookieName.length, c.length);
            }
        }
        return '';
    }

    public deleteCookie(name) {
        document.cookie = name + '=' + ';' + '-1;';
    }

    public setCookie(name: string, value: string) {
        document.cookie = name + '=' + value + ';';
    }

    updateProfile(
        first_name: string,
        last_name: string,
        email: string,
        email_institution: string,
        pi: string,
        institution: string,
        institution_type: number,
        department: string,
        job_title: string,
        address1: string,
        address2: string,
        address3: string,
        city: string,
        state_province: string,
        zip_code: number,
        country: string,
        time_zone_id: number,
    ) {
        const person_id = this.getToken('person_id');
        return this.http
            .post(this.appUrl + '/' + this.profileUpdateUrl + '/' + person_id, JSON.stringify(
                {
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    email_institution: email_institution,
                    pi: pi,
                    institution: institution,
                    institution_type: institution_type,
                    department: department,
                    job_title: job_title,
                    address1: address1,
                    address2: address2,
                    address3: address3,
                    city: city,
                    state_province: state_province,
                    zip_code: zip_code,
                    country: country,
                    time_zone_id: time_zone_id,
                }), {headers: this.headers})
            .map(
                (response: Response) => {
                    const message = response.json().message;
                    if (message === 'success') {
                        this.router.navigateByUrl('my-account');
                    } else {
                        console.log('couldnt save data');
                    }
                }
            )
            ;
    }

}
