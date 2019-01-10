import {map} from 'rxjs/operators';
import {Injectable} from '@angular/core';
import {HttpHeaders, HttpClient} from '@angular/common/http';
import {Router} from '@angular/router';
import {environment} from '../../environments/environment';
import {UserAuthModel} from './user-auth.model';
import {PersonModel} from './person.model';


@Injectable()
export class AuthenticationService {

  private headers = new HttpHeaders({'Content-Type': 'application/json'});

  personData: PersonModel;
  private authData: UserAuthModel;
  public userID: string;
  public isAdmin: boolean;

  constructor(private http: HttpClient, private router: Router) {
    this.loadUserCredentials();
  }

  forgetPassword(email: string) {
    return this.http
      .post(environment.appUrl + '/' + environment.forgotPassUrl, JSON.stringify({
        email: email
      }), {headers: this.headers});
  }

  signUp(
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
      .post(environment.appUrl + '/' + environment.signupUrl, JSON.stringify(
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
            if (response['type'] === 'success') {
              this.router.navigateByUrl('signin');
            }
            return response;
          }
        ))
      ;
  }

  signIn(username: string, password: string) {

    const authURL = environment.appUrl + '/' + environment.signinUrl;

    return this.http
      .post(authURL, JSON.stringify({
        username: username,
        password: password,
        request_type: 'signin'
      }), {headers: this.headers}).pipe(
        map(
          authResponse => {

            // Now we're getting the person data
            if (authResponse['type'] !== 'error') {
              const personURL = environment.appUrl + `/` + environment.personUrl + `/` + authResponse['person_id'];
              this.http.get(personURL).subscribe(personResponse => {
                this.assignFromJSON(authResponse, personResponse['data']);
                // noinspection JSIgnoredPromiseFromCall
                this.router.navigateByUrl('user-dashboard');
              },
                () => { this.personData = null; });
            } else {
              return authResponse;
            }
          }
        ));
  }

  signOut() {
    localStorage.removeItem('userAuthData');
    localStorage.removeItem('personData');
    this.authData = null;
    this.personData = null;
    this.userID = null;
    this.isAdmin = false;

    // noinspection JSIgnoredPromiseFromCall
    this.router.navigateByUrl('');
  }

  submitDownloadVM(vm_id: string, vm_username: string, vm_password: string) {
    if (!this.userID) {
      this.router.navigateByUrl('signin');
    }
    return this.http.post(environment.appUrl + '/' + environment.downloadableVMUrl, JSON.stringify(
      {
        person_id: this.userID,
        vm_id: vm_id,
        vm_username: vm_username,
        vm_password: vm_password
      }), {headers: this.headers});
  }

  submitResetPassword(current_pass: string, new_pass: string, confirm_new_pass: string) {
    if (!this.userID) {
      this.router.navigateByUrl('signin');
    }
    return this.http.post(environment.appUrl + '/' + environment.passResetUrl, JSON.stringify(
      {
        person_id: this.userID,
        current_pass: current_pass,
        new_pass: new_pass,
        confirm_new_pass: confirm_new_pass
      }), {headers: this.headers});
  }

  hasClassification(searchClassification: string) {
    if (!this.personData) {
      return false;
    }
    for (const classification of this.personData.classifications) {
      if (searchClassification === classification['name']) {
        return true;
      }
    }
    return false;
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
    if (!this.userID) {
      this.router.navigateByUrl('signin');
    }
    return this.http
      .post(environment.appUrl + '/' + environment.profileUpdateUrl + '/' + this.userID, JSON.stringify(
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
        }), {headers: this.headers}).pipe(map(
          response => {
            this.fetchPersonInfo();
            return response;
          }
      ));
  }

  fetchPersonInfo() {
    if (!this.authData) {
      return;
    }

    console.log('Updating person information.');
    this.http.get(environment.appUrl + `/` + environment.personUrl + `/` + this.userID).subscribe(
      personResponse => this.assignFromJSON(this.authData, personResponse['data']),
      () => this.signOut());
  }

  workshopRegister(workshopid: string) {
    if (!this.userID) {
      this.router.navigateByUrl('signin');
    }

    const subscribeData = {userid: this.authData.user, workshopid: workshopid};
    return this.http.post(environment.appUrl + '/' + environment.eventRegisterUrl, JSON.stringify(subscribeData), {headers: this.headers})
      .pipe(map(
      response => {
        this.fetchPersonInfo();
        return response;
      }));
  }

  private assignFromJSON(authResponse: {}, personResponse: {}) {

    // Write to local storage if we're called from the sign-in method
    localStorage.setItem('userAuthData', JSON.stringify(authResponse));
    localStorage.setItem('personData', JSON.stringify(personResponse));

    this.userID = authResponse['person_id'];
    this.isAdmin = authResponse['user_is_admin'];
    this.authData = authResponse as UserAuthModel;
    this.personData = personResponse as PersonModel;
  }

  private loadUserCredentials() {
    this.authData = JSON.parse(localStorage.getItem('userAuthData')) as UserAuthModel;

    if (this.authData) {
      this.userID = this.authData['person_id'];
      this.isAdmin = this.authData['user_is_admin'];
      this.fetchPersonInfo();
    } else {
      this.userID = null;
      this.isAdmin = false;
    }
  }

}
