import { NgModule }             from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

// App components
import { SoftwareListComponent }      from './software/software-list.component';
import { SoftwareDetailComponent }  from './software/software-detail.component';
import { CommunityDetailComponent }  from './community/community-detail.component';
import { CommunityListComponent }  from './community/community-list.component';
import { TeamDetailComponent }  from './team/team-detail.component';
import { TeamListComponent }  from './team/team-list.component';
import { HomeComponent }  from './home/home.component';

const routes: Routes = [
  { path: 'app',     component: HomeComponent },
  { path: '', redirectTo: 'app', pathMatch: 'full' },
  { path: 'software', component: SoftwareListComponent },
  { path: 'detail/:id', component: SoftwareDetailComponent },
  { path: 'software/:filterName', component: SoftwareListComponent },
  { path: 'com/:type/:id', component: CommunityDetailComponent },
  { path: 'community', component: CommunityListComponent },
  { path: 'community/:index', component: CommunityListComponent },
  { path: 'team', component: TeamListComponent },
  { path: 'team/:index', component: TeamListComponent },
  { path: 't/detail', component: TeamDetailComponent },
  { path: '**', redirectTo: '/app', pathMatch: 'full' }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}