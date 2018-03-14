import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';

// Animations & UI
import { BrowserAnimationsModule} from '@angular/platform-browser/animations';
import { MdButtonModule, MdCheckboxModule, MdInputModule,
    MdRadioModule, MdSelectModule, MdMenuModule, MdSidenavModule,
    MdToolbarModule, MdListModule, MdGridListModule, MdCardModule,
    MdTabsModule, MdChipsModule
} from '@angular/material';

// Imports for loading & configuring the in-memory web api
import { InMemoryWebApiModule } from 'angular-in-memory-web-api';
import { SoftwareDataService } from './software/software-data.service';

// 3rd Party Modules
import { SwiperModule } from '../../node_modules/angular2-useful-swiper';

// Application components
import { AppComponent } from './app.component';
import { SoftwareDetailComponent } from './software/software-detail.component';
import { SoftwareListComponent } from './software/software-list.component';
import { CommunityDetailComponent } from './community/community-detail.component';
import { CommunityListComponent } from './community/community-list.component';
import { TeamDetailComponent } from './team/team-detail.component';
import { TeamListComponent } from './team/team-list.component';
import { HomeComponent } from './home/home.component';
import { SignupComponent } from './authentication/signup.component';
import { SigninComponent } from './authentication/signin.component';
import { UserDashboardComponent } from './user-dashboard/user-dashboard.component';
import { ProfileUpdateComponent } from './user-dashboard/profile-update.component';
import { FaqsComponent } from './faqs/faqs.component';
import { PasswordResetComponent } from './authentication/password-reset.component';
import { ForgetPasswordComponent } from './password-management/forget-password.component';
import { ForgetPasswordConfirmComponent } from './password-management/forget-password-confirm.component';

// Application animation components
import { FaderComponent } from './fader.component';

// Application services
import { SoftwareService } from './software/software.service';
import { CommunityService } from './community/community.service';
import { TeamService } from './team/team.service';
import { AuthenticationService } from './authentication/authentication.service';
import { UserDashboardService } from './user-dashboard/user-dashboard.service';
import { PasswordManagementService } from './password-management/password-management.service';
import { FaqsService } from './faqs/faqs.service';

// Router
import { AppRoutingModule } from './app-routing.module';

// CommonModule
import { CommonModule } from '@angular/common';

// Container
import { ShowHideContainer } from './authentication/show-hide-container';

@NgModule({
    imports: [
        BrowserModule,
        FormsModule,
        HttpModule,
        BrowserAnimationsModule,
        MdButtonModule, MdCheckboxModule,
        MdInputModule, MdRadioModule, MdSelectModule,
        MdMenuModule, MdSidenavModule, MdToolbarModule,
        MdListModule, MdGridListModule, MdTabsModule, MdCardModule,
        MdChipsModule,
        SwiperModule,
        AppRoutingModule,
        CommonModule,
    ],
    declarations: [
        AppComponent,
        SoftwareDetailComponent,
        SoftwareListComponent,
        CommunityDetailComponent,
        CommunityListComponent,
        TeamDetailComponent,
        TeamListComponent,
        HomeComponent,
        FaderComponent,
        SignupComponent,
        SigninComponent,
        UserDashboardComponent,
        ProfileUpdateComponent,
        FaqsComponent,
        PasswordResetComponent,
        ForgetPasswordComponent,
        ForgetPasswordConfirmComponent,
        FaqsComponent,
        ShowHideContainer
    ],
    providers: [
        SoftwareService,
        CommunityService,
        TeamService,
        AuthenticationService,
        UserDashboardService,
        PasswordManagementService,
        FaqsService
    ],
    bootstrap: [AppComponent]
})
export class AppModule { }
