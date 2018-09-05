import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormControl, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { SoftwareModel } from './software.model';
import { SoftwareService } from './software.service';
import { FilterModel } from '../filter.model';

import {MdFormFieldModule, MdInputModule} from '@angular/material';

@Component({
  selector: 'app-my-software-list',
  templateUrl: './software-list.component.html',
  styleUrls: [ './software-list.component.scss' ]
})
export class SoftwareListComponent implements OnInit {

  private readonly softwareTypes: {};
  private readonly researchProblems: {};
  activeSoftwareType = null;
  activeResearchProblem = null;
  filteredList: SoftwareModel[];

  config: Object = {
    slidesPerView: 'auto',
    centeredSlides: false,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    spaceBetween: 0,
    speed: 500,
    loop: false
  };

  @Input() softwareList: SoftwareModel[];
  @Output() listChange: EventEmitter<SoftwareModel[]> = new EventEmitter<SoftwareModel[]>();

  // Filters
  @Input() swtList: FilterModel[];
  @Input() isVisible: boolean;
  @Input() swFiltersOpen: boolean;
  @Input() selectedFilter: FilterModel;

  // Filters - routing
  @Input() filterType: string;  // values: 'swt' or 'rp' (i.e. - software type or research problem)
  @Input() filterName: string;


  objectKeys = Object.keys;

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private softwareService: SoftwareService
  ) {
    this.softwareTypes = {};
    this.researchProblems = {};
    this.filteredList = [];
  }


  log(ob) {
    console.log(ob);
  }

  ngOnInit(): void {
    this.getSoftwareList();

    // ToDo: get router params (filterType, filterName)
    this.route.params.subscribe( params =>
        this.filterName = params['filterName']
    );

  }


  hasResearchProblemByID(software: SoftwareModel, id: string) {
    if (id === null) {
      return true;
    }
    for (const researchProblem of software.research_problems){
      if (researchProblem['id'] === parseInt(id, 10)) {
        return true;
      }
    }
    return false;
  }

  hasSoftwareTypeByID(software: SoftwareModel, id: string) {
    if (id === null) {
      return true;
    }

    for (const softwareType of software.software_type){
      if (softwareType['id'] === parseInt(id, 10)) {
        return true;
      }
    }
    return false;
  }

  //
  filterSelections() {
    this.filteredList = [];

    for (const software of this.softwareList){
      if (this.hasResearchProblemByID(software, this.activeResearchProblem) && this.hasSoftwareTypeByID(software, this.activeSoftwareType)) {
        this.filteredList.push(software);
      }
    }
  }

  // Get the full software list
  getSoftwareList(): void {
    this.softwareService.getSoftwareList().then(softwareList => {
      for (const s of softwareList){
        for (const type of s.software_type) {
          this.softwareTypes[parseInt(type['id'], 10)] = type['label'];
        }
        for (const type of s.research_problems) {
          this.researchProblems[parseInt(type['id'], 10)] = type['label'];
        }
      }
      this.softwareList = softwareList;
      this.filterSelections();
    }
    );
  }


  searchSoftware(term: string): void {
    this.softwareService.searchSoftware(term).then(softwareList => this.softwareList = softwareList);
    this.filterSelections();
  }

  onSelect(filter: FilterModel): void {
    this.selectedFilter = filter;
  }

  gotoDetail(software: SoftwareModel): void {
    this.router.navigate(['/s', software.slug]);
  }
}
