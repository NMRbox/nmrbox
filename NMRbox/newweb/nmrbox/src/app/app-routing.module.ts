import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';

// App components
import {HomeComponent} from './home/home.component';
import {SoftwareListComponent} from './software/software-list.component';
import {SoftwareDetailComponent} from './software/software-detail.component';
import {StaticPageComponent} from './static/static-page.component';
import {CommunityComponent} from './community/community.component';
import {SupportComponent} from './support/support.component';
import {TeamListComponent} from './team/team-list.component';
import {SignupComponent} from './authentication/signup.component';
import {SigninComponent} from './authentication/signin.component';
import {UserDashboardComponent} from './user-dashboard/user-dashboard.component';
import {ProfileUpdateComponent} from './user-dashboard/profile-update.component';
import {ForgetPasswordComponent} from './password-management/forget-password.component';
import {FilesComponent} from './files/files.component';

const routes: Routes = [
  {path: '', component: HomeComponent},
  {path: 'software', component: SoftwareListComponent},
  {path: 'registry', component: SoftwareListComponent},
  {path: 's/:slug', component: SoftwareDetailComponent},
  {path: 'software/:filterType/:filter', component: SoftwareListComponent},
  {path: 'pages/:pageUrl', component: StaticPageComponent},
  {path: 'community', component: CommunityComponent},
  {path: 'community/:index', component: CommunityComponent},
  {path: 'events', component: CommunityComponent},
  {path: 'support', component: SupportComponent},
  {path: 'support/:index', component: SupportComponent},
  {path: 'support/:index/:slug', component: SupportComponent},
  {path: 'team-tab', component: TeamListComponent},
  {path: 'team-tab/:index', component: TeamListComponent},
  {path: 'signup', component: SignupComponent},
  {path: 'login', component: SigninComponent},
  {path: 'signin', component: SigninComponent},
  {path: 'signout', component: SigninComponent},
  {path: 'forgot-password', component: ForgetPasswordComponent},
  {path: 'user-dashboard', component: UserDashboardComponent},
  {path: 'profile-update', component: ProfileUpdateComponent},
  {path: 'files/:filename', component: FilesComponent},
  {path: '**', redirectTo: '/', pathMatch: 'full'}
];

@NgModule({
  // using hash location strategy for more consistent deep linking
  imports: [RouterModule.forRoot(routes, {scrollPositionRestoration: 'enabled'})],
  exports: [RouterModule]
})
export class AppRoutingModule {
}
