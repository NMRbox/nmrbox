
import {map} from 'rxjs/operators';
import {Injectable} from '@angular/core';
import {HttpHeaders, HttpClient} from '@angular/common/http';
import {Router} from '@angular/router';
import {environment} from '../../environments/environment';


@Injectable()
export class AuthenticationService {

  private signinUrl = 'signin';  // URL to signin
  private signupUrl = 'signup';  // URL to signup
  private profileUpdateUrl = 'updateProfile';  // URL to profileUpdate
  private headers = new HttpHeaders({'Content-Type': 'application/json'});

  constructor(private http: HttpClient, private router: Router) {

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
      .post(environment.appUrl + '/' + this.signupUrl, JSON.stringify(
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
        }), {headers: this.headers}).pipe(
      map(
        response => {
          const message = response['message'];
          if (message === 'success') {
            this.router.navigateByUrl('signin');
          } else {
            console.log('Couldn\'t save data');
          }
        }
      ))
      ;
  }

  signin(username: string, password: string) {
    return this.http
      .post(environment.appUrl + '/' + this.signinUrl, JSON.stringify({
        username: username,
        password: password,
        request_type: 'signin'
      }), {headers: this.headers}).pipe(
      map(
        response => {

          if (response['type'] !== 'error') {
            const person_id = response['person_id'];
            const user_is_admin = response['user_is_admin'];
            const token = response['token'];

            localStorage.setItem('person_id', person_id);
            localStorage.setItem('user_is_admin', user_is_admin);
            localStorage.setItem('token', token);

            this.router.navigateByUrl('user-dashboard');
          } else {
            return response;
          }
        }
      ));
  }

  public getToken(name: string) {
    return localStorage.getItem(name);
  }

  public isAdmin() {
    return JSON.parse(this.getToken('user_is_admin'));
  }

  public deleteToken(name: string) {
    return localStorage.removeItem(name);
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
      .post(environment.appUrl + '/' + this.profileUpdateUrl + '/' + person_id, JSON.stringify(
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
        }), {headers: this.headers});
  }

}
