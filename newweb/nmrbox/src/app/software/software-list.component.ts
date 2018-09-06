import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormControl, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { SoftwareModel } from './software.model';
import { SoftwareService } from './software.service';
import { FilterModel } from '../filter.model';

import {MatFormFieldModule, MatInputModule} from '@angular/material';

@Component({
  selector: 'app-my-software-list',
  templateUrl: './software-list.component.html',
  styleUrls: [ './software-list.component.scss' ]
})
export class SoftwareListComponent implements OnInit {

  softwareTypes: {};
  researchProblems: {};
  activeSoftwareType;
  activeResearchProblem;
  activeNameSearch = null;
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
    this.filteredList = [];
    this.softwareTypes = {'1': 'Spectrum Analysis', '2': 'Chemical Shift',
      '3': 'Molecular Modeling', '4': 'Structure Visualization',
      '5': 'Residual Dipolar Coupling', '6': 'Assignment',
      '7': 'Relaxation', null: 'Show all'};
    this.researchProblems = {'1': 'Metabolomics', '2': 'Protein Dynamics',
      '3': 'Protein Structure', '4': 'Intrinsically Disordered Proteins',
      null: 'Show all'};
    this.activeResearchProblem = null;
    this.activeSoftwareType = null;
  }

  ngOnInit(): void {
    this.getSoftwareList();

    // ToDo: get router params (filterType, filterName)
    this.route.params.subscribe( params =>
        this.filterName = params['filterName']
    );

  }


  hasResearchProblemByID(software: SoftwareModel, id: string): boolean {
    if (id === null) {
      return true;
    }
    for (const researchProblem of software.research_problems){
      if (String(researchProblem['id']) === id) {
        return true;
      }
    }
    return false;
  }

  hasSoftwareTypeByID(software: SoftwareModel, id: string): boolean {
    if (id === null) {
      return true;
    }

    for (const softwareType of software.software_type){
      if (String(softwareType['id']) === id) {
        return true;
      }
    }
    return false;
  }

  matchesNameSearch(software: SoftwareModel, name: string) {
    if (name === null) {
      return true;
    }
    return software.short_title.toLowerCase().includes(name.toLowerCase());
  }

  // Filter the software based on the menu
  filterSelections() {

    this.filteredList = [];

    for (const software of this.softwareList){
      if (this.hasResearchProblemByID(software, this.activeResearchProblem) &&
          this.hasSoftwareTypeByID(software, this.activeSoftwareType) &&
          this.matchesNameSearch(software, this.activeNameSearch)) {
        this.filteredList.push(software);
      }
    }
  }

  // Get the full software list
  getSoftwareList(): void {
    this.softwareService.getSoftwareList().then(softwareList => {
      /* We have this hardcoded now
      for (const s of softwareList){
        for (const type of s.software_type) {
          this.softwareTypes[parseInt(type['id'], 10)] = type['label'];
        }
        for (const type of s.research_problems) {
          this.researchProblems[parseInt(type['id'], 10)] = type['label'];
        }
      } */
      this.softwareList = softwareList;
      this.filterSelections();
    }
    );
  }


  searchSoftware(term: string): void {
    this.softwareService.searchSoftware(term).then(softwareList => this.softwareList = softwareList);
    this.filterSelections();
  }

  resetSelections(): void {
    this.activeNameSearch = null;
    this.activeSoftwareType = null;
    this.activeResearchProblem = null;
  }

  gotoDetail(software: SoftwareModel): void {
    this.router.navigate(['/s', software.slug]);
  }
}
