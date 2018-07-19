import {Component, ContentChild, OnInit} from '@angular/core';
import {NgForm} from '@angular/forms';
import {ActivatedRoute, PRIMARY_OUTLET, Router, UrlSegment, UrlSegmentGroup, UrlTree} from '@angular/router';

/* Import the service */
import { PasswordManagementService } from './password-management.service';
import { AuthenticationService } from '../authentication/authentication.service';
import {PersonModel} from '../user-dashboard/person.model';

/* Import container */
// import { ShowHideContainer} from '../../../../show-hide-container';
// import { ShowHideContainer } from './show-hide-container';
import { ShowHideContainer } from '../authentication/show-hide-container';


@Component({
  selector: 'app-forget-password-confirm',
  templateUrl: './forget-password-confirm.component.html',
  styleUrls: ['./forget-password.component.scss']
})
export class ForgetPasswordConfirmComponent implements OnInit {
    public notifications: any = {message: '', type: ''};
    public personId: any;
    public reset_code: any;
    public show = false;

    @ContentChild('showhideinput') input;

  constructor(
      private router: Router,
      private route: ActivatedRoute,
      private passService: PasswordManagementService,
      private authService: AuthenticationService
  ) { }

  ngOnInit() {
      // console.log(this.router.parseUrl(this.router.url));
      const tree: UrlTree = this.router.parseUrl(this.router.url);
      const g: UrlSegmentGroup = tree.root.children[PRIMARY_OUTLET];
      const s: UrlSegment[] = g.segments;

      this.personId = s[1].path;
      this.reset_code = s[2].path;
  }

    public onPasswordConfirmSubmit(form: NgForm): void {
      this.passService.forgetPasswordConfirm(
          // this.authService.getToken('person_id'),
          this.personId,
          form.value.nmrbox_acct,
          form.value.password,
          form.value.password_confirm,
          this.reset_code
      )
          .subscribe(
              response => this.notifications = response

              /*   error => console.log(error),
                 () => console.log(this.notifications)*/
              /*message => {
                    console.log(message);
                    this.alert = message;
                },
                  err => {
                      this.errors = err.type;
                      this.isSubmitting = false;
                  }*/
              /*message => console.log(response),
              err => {
                  this.errors = err;
                  this.isSubmitting = false;
              }*/

          );
    }

    toggleShow() {
        this.show = !this.show;
        console.log(this.input);
        if (this.show) {
            this.input.nativeElement.type = 'text';
        } else {
            this.input.nativeElement.type = 'password';
        }
    }



}
