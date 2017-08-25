import 'rxjs/add/operator/switchMap';
import { Component, OnInit }      from '@angular/core';
import { ActivatedRoute, Params } from '@angular/router';
import { Location }               from '@angular/common';

import { SoftwareModel }         from './software.model';
import { SoftwareService }  from './software.service';
@Component({
  selector: 'software-detail',
  templateUrl: './software-detail.component.html',
  styleUrls: [ './software-detail.component.scss' ]
})
export class SoftwareDetailComponent implements OnInit {
  software: SoftwareModel;

  constructor(
    private softwareService: SoftwareService,
    private route: ActivatedRoute,
    private location: Location
  ) {}

  ngOnInit(): void {
    this.route.params
      //.switchMap((params: Params) => this.softwareService.getSoftware(+params['id']))
      .switchMap((params: Params) => this.softwareService.getSoftware(params['slug']))
      .subscribe(software => this.software = software);
  }

  save(): void {
  this.softwareService.update(this.software)
    .then(() => this.goBack());
  }

  goBack(): void {
    this.location.back();
  }
}