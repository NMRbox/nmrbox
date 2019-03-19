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
  MatTabsModule, MatChipsModule, MatSnackBarModule
} from '@angular/material';

// 3rd Party Modules
import {SwiperModule} from 'angular2-useful-swiper';

// Application components
import {AppComponent} from './app.component';
import {SoftwareDetailComponent} from './software/software-detail.component';
import {SoftwareListComponent} from './software/software-list.component';
import {StaticPageComponent} from './static/static-page.component';
import {CommunityComponent} from './community/community.component';
import {TeamListComponent} from './team/team-list.component';
import {HomeComponent} from './home/home.component';
import {SignupComponent} from './authentication/signup.component';
import {SigninComponent} from './authentication/signin.component';
import {UserDashboardComponent} from './user-dashboard/user-dashboard.component';
import {ProfileUpdateComponent} from './user-dashboard/profile-update.component';
import {FaqsComponent} from './faqs/faqs.component';
import {ForgetPasswordComponent} from './password-management/forget-password.component';

// Application services
import {SoftwareService} from './software/software.service';
import {CommunityService} from './community/community.service';
import {AuthenticationService} from './authentication/authentication.service';
import {FaqsService} from './faqs/faqs.service';
import {ResponsiveService} from './responsive.service';

// Router
import {AppRoutingModule} from './app-routing.module';

// CommonModule
import {CommonModule} from '@angular/common';

// Container
import {SupportComponent} from './support/support.component';
import {StaticPageService} from './static/static-page.service';
import {EmbeddedStaticComponent} from './static/embedded-static.component';
import {SafeHtmlPipe} from './pipes/safe-html.pipe';
import { FilesComponent } from './files/files.component';

@NgModule({
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    BrowserAnimationsModule,
    MatButtonModule, MatCheckboxModule, MatInputModule, MatRadioModule, MatSelectModule, MatMenuModule, MatSidenavModule, MatToolbarModule,
    MatListModule, MatGridListModule, MatTabsModule, MatCardModule, MatSnackBarModule, MatChipsModule,
    SwiperModule,
    AppRoutingModule,
    CommonModule,
  ],
  declarations: [
    AppComponent,
    SoftwareDetailComponent,
    SoftwareListComponent,
    StaticPageComponent,
    CommunityComponent,
    TeamListComponent,
    HomeComponent,
    SignupComponent,
    SigninComponent,
    UserDashboardComponent,
    ProfileUpdateComponent,
    FaqsComponent,
    ForgetPasswordComponent,
    FaqsComponent,
    SupportComponent,
    EmbeddedStaticComponent,
    SafeHtmlPipe,
    FilesComponent
  ],
  providers: [
    SoftwareService,
    CommunityService,
    AuthenticationService,
    FaqsService,
    StaticPageService,
    ResponsiveService
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
}
