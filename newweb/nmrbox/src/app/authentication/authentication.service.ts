import { Injectable } from '@angular/core';
import { Headers, Http, Response, RequestOptions } from '@angular/http';
import { Router } from '@angular/router';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class AuthenticationService {
    private appUrl = 'http://nmrbox.dev';  // URL to web api
    //private appUrl = 'https://webdev.nmrbox.org:8001';  // URL to web api
    private signinUrl = 'signin';  // URL to signin
    private signupUrl = 'signup';  // URL to signup
    private authUrl = 'auth.php';  // URL to signup
    private headers = new Headers({'Content-Type': 'application/json'});

    constructor(private http: Http, private router: Router) {

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
            .post(this.appUrl + '/' + this.authUrl, JSON.stringify(
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
            .post(this.appUrl + '/' + this.authUrl, JSON.stringify({
                    username: username,
                    password: password,
                    request_type: 'signin'
                }), {headers: this.headers})
            .map(
                (response: Response) => {
                    const message = response.json().message;
                    const person_id = response.json().person_id;
                    if (message === 'success') {
                        console.log(person_id);
                        this.setCookie('logged_in', '1');
                        this.setCookie('person_id', person_id);
                        this.router.navigateByUrl('user-dashboard');
                    } else {
                     console.log('couldnt logged in');
                    }
                }
            )
        ;
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

}
