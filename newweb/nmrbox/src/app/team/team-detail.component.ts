import 'rxjs/add/operator/switchMap';
import { Component, OnInit }      from '@angular/core';
import { ActivatedRoute, Params } from '@angular/router';
import { Location }               from '@angular/common';

import { TeamModel }         from './team.model';
import { TeamService }  from './team.service';

@Component({
  selector: 'team-detail',
  templateUrl: './team-detail.component.html',
  styleUrls: [ './team-detail.component.scss' ]
})
export class TeamDetailComponent implements OnInit {
  teamModel: TeamModel;

  constructor(
    private teamService: TeamService,
    private route: ActivatedRoute,
    private location: Location
  ) {}

  ngOnInit(): void {
    this.route.params
      .switchMap((params: Params) => this.teamService.getDetail(+params['id'], params['type']))
      .subscribe(teamModel => this.teamModel = teamModel);
  }

  goBack(): void {
    this.location.back();
  }
}