import { Injectable } from '@angular/core';
import { Headers, Http, Response, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/toPromise';

/* import model */
import { PersonModel} from './person.model';

@Injectable()
export class UserDashboardService {
    handleError: any;
    private appUrl = 'https://webdev.nmrbox.org:8001';  // URL to web api
    //private appUrl = 'http://nmrbox.dev';  // URL to web api
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
}
