import { NgModule }             from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

// App components
import { HomeComponent } from './home/home.component';
import { SoftwareListComponent } from './software/software-list.component';
import { SoftwareDetailComponent } from './software/software-detail.component';
import { CommunityDetailComponent } from './community/community-detail.component';
import { CommunityListComponent } from './community/community-list.component';
import { TeamDetailComponent } from './team/team-detail.component';
import { TeamListComponent } from './team/team-list.component';
import { SignupComponent } from './authentication/signup.component';
import { SigninComponent } from './authentication/signin.component';
import { PasswordResetComponent } from './authentication/password-reset.component';
import { UserDashboardComponent } from './user-dashboard/user-dashboard.component';
import { ProfileUpdateComponent } from './user-dashboard/profile-update.component';
import { FaqsComponent } from './faqs/faqs.component';
import { ForgetPasswordComponent} from './password-management/forget-password.component';
import { ForgetPasswordConfirmComponent} from './password-management/forget-password-confirm.component';


const routes: Routes = [
    { path: 'app',     component: HomeComponent },
    { path: '', redirectTo: 'app', pathMatch: 'full' },
    { path: 'software', component: SoftwareListComponent },
    { path: 's/:slug', component: SoftwareDetailComponent },
    { path: 'software/:filterName', component: SoftwareListComponent },
    { path: 'c/:pageUrl', component: CommunityDetailComponent },
    { path: 'community', component: CommunityListComponent },
    { path: 'community/:index', component: CommunityListComponent },
    { path: 'team', component: TeamListComponent },
    { path: 'team/:index', component: TeamListComponent },
    { path: 't/detail', component: TeamDetailComponent },
    { path: 'signup', component: SignupComponent },
    { path: 'signin', component: SigninComponent },
    { path: 'signout', component: SigninComponent },
    { path: 'password-reset', component: PasswordResetComponent },
    { path: 'user-dashboard', component: UserDashboardComponent },
    { path: 'profile-update', component: ProfileUpdateComponent },
    { path: 'faqs', component: FaqsComponent },
    { path: '**', redirectTo: '/app', pathMatch: 'full' }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes, {useHash: true}) ], // using hash location strategy for more consistent deep linking
  exports: [ RouterModule ]
})
export class AppRoutingModule {}