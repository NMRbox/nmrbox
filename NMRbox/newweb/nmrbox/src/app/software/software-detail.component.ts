
import {switchMap} from 'rxjs/operators';

import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Params} from '@angular/router';
import {Location} from '@angular/common';

import {SoftwareModel} from './software.model';
import {SoftwareService} from './software.service';
import {SoftwareMetadataModel} from './software-metadata.model';

@Component({
  selector: 'app-software-detail',
  templateUrl: './software-detail.component.html',
  styleUrls: ['./software-detail.component.scss']
})
export class SoftwareDetailComponent implements OnInit {
  software: SoftwareModel;
  softwareMetaData: SoftwareMetadataModel;

  constructor(
    private softwareService: SoftwareService,
    private route: ActivatedRoute,
    private location: Location
  ) {
  }

  ngOnInit(): void {
    this.route.params.pipe(
      switchMap((params: Params) => this.softwareService.getSoftware(params['slug'])))
      .subscribe(software => this.software = software);

    this.route.params.pipe(
      switchMap((params: Params) => this.softwareService.getSoftwareMetaData(params['slug'])))
      .subscribe(softwareMetaData => this.softwareMetaData = softwareMetaData);
  }

  goBack(): void {
    this.location.back();
  }
}
