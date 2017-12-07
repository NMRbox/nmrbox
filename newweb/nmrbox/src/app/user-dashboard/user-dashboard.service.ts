import { Injectable } from '@angular/core';
import { Headers, Http, Response, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/toPromise';
import 'rxjs/add/operator/map';

/* import model */
import { PersonModel} from './person.model';

@Injectable()
export class UserDashboardService {
    handleError: any;
    public appUrl = 'https://webdev.nmrbox.org:8001';  // URL to web api
    //public appUrl = 'http://nmrbox.dev';  // URL to web api
    private passResetUrl = 'password-reset';  // URL to password reset
    private DownloadableVMUrl = 'downloadable-vm';  // URL to downloadable vm
    private personUrl = 'person';  // URL to web api
    private headers = new Headers({'Content-Type': 'application/json'});

    constructor(private http: Http) { }

    getPersonDetails(id: string): Promise<PersonModel> {
        const url = this.appUrl + `/` + this.personUrl + `/` + id;
        console.log(url);
        return this.http
            .get(url)
            .toPromise()
            .then(response => response.json().data as PersonModel)
            .catch(this.handleError);
    }

    SubmitResetPassword(
        person_id: string,
        current_pass: string,
        new_pass: string,
        confirm_new_pass: string
    ) {
        return this.http.post(this.appUrl + '/' + this.passResetUrl, JSON.stringify(
            {
                person_id: person_id,
                current_pass: current_pass,
                new_pass: new_pass,
                confirm_new_pass: confirm_new_pass
            }), {headers: this.headers})
    .map(
        (response: Response) => response.json()
    )
    }

    SubmitDownloadVM(
        person_id: string,
        vm_id: string,
        vm_username: string,
        vm_password: string
    ) {
        return this.http.post(this.appUrl + '/' + this.DownloadableVMUrl, JSON.stringify(
            {
                person_id: person_id,
                vm_id: vm_id,
                vm_username: vm_username,
                vm_password: vm_password
            }), {headers: this.headers})
    .map(
        (response: Response) => response.json()
    )
    }
}
