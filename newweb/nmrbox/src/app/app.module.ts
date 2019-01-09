import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {HttpClientModule} from '@angular/common/http';

// Animations & UI
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {
  MatButtonModule, MatCheckboxModule, MatInputModule,
  MatRadioModule, MatSelectModule, MatMenuModule, MatSidenavModule,
  MatToolbarModule, MatListModule, MatGridListModule, MatCardModule,
  MatTabsModule, MatChipsModule
} from '@angular/material';

// 3rd Party Modules
import {SwiperModule} from 'angular2-useful-swiper';

// Application components
import {AppComponent} from './app.component';
import {SoftwareDetailComponent} from './software/software-detail.component';
import {SoftwareListComponent} from './software/software-list.component';
import {StaticPageComponent} from './static/static-page.component';
import {CommunityListComponent} from './community/community-list.component';
import {TeamListComponent} from './team/team-list.component';
import {HomeComponent} from './home/home.component';
import {SignupComponent} from './authentication/signup.component';
import {SigninComponent} from './authentication/signin.component';
import {UserDashboardComponent} from './user-dashboard/user-dashboard.component';
import {ProfileUpdateComponent} from './user-dashboard/profile-update.component';
import {FaqsComponent} from './faqs/faqs.component';
import {PasswordResetComponent} from './authentication/password-reset.component';
import {ForgetPasswordComponent} from './password-management/forget-password.component';
import {ForgetPasswordConfirmComponent} from './password-management/forget-password-confirm.component';

// Application services
import {SoftwareService} from './software/software.service';
import {CommunityService} from './community/community.service';
import {AuthenticationService} from './authentication/authentication.service';
import {UserDashboardService} from './authentication/user-dashboard.service';
import {PasswordManagementService} from './password-management/password-management.service';
import {FaqsService} from './faqs/faqs.service';

// Router
import {AppRoutingModule} from './app-routing.module';

// CommonModule
import {CommonModule} from '@angular/common';

// Container
import {SupportComponent} from './support/support.component';
import {StaticPageService} from './static/static-page.service';
import {EmbeddedStaticComponent} from './static/embedded-static.component';
import {SafeHtmlPipe} from './pipes/safe-html.pipe';

@NgModule({
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    BrowserAnimationsModule,
    MatButtonModule, MatCheckboxModule,
    MatInputModule, MatRadioModule, MatSelectModule,
    MatMenuModule, MatSidenavModule, MatToolbarModule,
    MatListModule, MatGridListModule, MatTabsModule, MatCardModule,
    MatChipsModule,
    SwiperModule,
    AppRoutingModule,
    CommonModule,
  ],
  declarations: [
    AppComponent,
    SoftwareDetailComponent,
    SoftwareListComponent,
    StaticPageComponent,
    CommunityListComponent,
    TeamListComponent,
    HomeComponent,
    SignupComponent,
    SigninComponent,
    UserDashboardComponent,
    ProfileUpdateComponent,
    FaqsComponent,
    PasswordResetComponent,
    ForgetPasswordComponent,
    ForgetPasswordConfirmComponent,
    FaqsComponent,
    SupportComponent,
    EmbeddedStaticComponent,
    SafeHtmlPipe
  ],
  providers: [
    SoftwareService,
    CommunityService,
    AuthenticationService,
    UserDashboardService,
    PasswordManagementService,
    FaqsService,
    StaticPageService
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
}
