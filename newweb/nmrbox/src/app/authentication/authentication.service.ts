
import {map} from 'rxjs/operators';
import {Injectable} from '@angular/core';
import {HttpHeaders, HttpClient} from '@angular/common/http';
import {Router} from '@angular/router';
import {environment} from '../../environments/environment';
import {UserAuthModel} from './user-auth.model';


@Injectable()
export class AuthenticationService {

  private signinUrl = 'signin';  // URL to signin
  private signupUrl = 'signup';  // URL to signup
  private profileUpdateUrl = 'updateProfile';  // URL to profileUpdate
  private headers = new HttpHeaders({'Content-Type': 'application/json'});

  private userData: UserAuthModel;
  public userID: string;
  public isAdmin: boolean;

  constructor(private http: HttpClient, private router: Router) {
    this.assignFromJSON(JSON.parse(localStorage.getItem('userAuthData')));
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
            this.assignFromJSON(response);
            // noinspection JSIgnoredPromiseFromCall
            this.router.navigateByUrl('user-dashboard');
          } else {
            return response;
          }
        }
      ));
  }

  signOut() {
    localStorage.removeItem('userAuthData');
    this.userData = null;
    this.userID = null;
    this.isAdmin = false;

    // noinspection JSIgnoredPromiseFromCall
    this.router.navigateByUrl('');
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
    return this.http
      .post(environment.appUrl + '/' + this.profileUpdateUrl + '/' + this.userID, JSON.stringify(
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

  private assignFromJSON(response: {}) {
    if (response) {
      localStorage.setItem('userAuthData', JSON.stringify(response));
      this.userID = response['person_id'];
      this.isAdmin = response['user_is_admin'];
      this.userData = response as UserAuthModel;
    } else {
      this.userData = null;
      this.isAdmin = false;
      this.userID = null;
    }
  }

}
