import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormControl, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute, Params } from '@angular/router';

import { Observable }        from 'rxjs/Observable';

import { SoftwareModel } from './software.model';
import { SoftwareService } from './software.service';

import { FilterModel } from './../filter.model';

@Component({
  selector: 'my-software-list',
  templateUrl: './software-list.component.html',
  styleUrls: [ './software-list.component.scss' ]
})
export class SoftwareListComponent implements OnInit {
  //softwareList: SoftwareModel[];
  @Input() softwareList: SoftwareModel[];
  @Output() listChange: EventEmitter<SoftwareModel[]> = new EventEmitter<SoftwareModel[]>();
  selectedSoftware: SoftwareModel;

  // Filters
  @Input() swtList: FilterModel[];
  @Input() isVisible: boolean = true;
  @Input() swFiltersOpen: boolean = true;
  @Input() selectedFilter: FilterModel;

  // Filters - routing
  @Input() filterType: string;  // values: 'swt' or 'rp' (i.e. - software type or research problem)
  @Input() filterName: string;

  // TESTING
  spectralSelected: true;
  isSelected: true; // testing

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private softwareService: SoftwareService
  ) { }

  config: Object = {
            slidesPerView: 'auto',
            centeredSlides: false,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 0,
            speed: 500,
            loop: false
        };

  ngOnInit(): void {
    this.getSoftwareList();
    this.getSwtList();

    // ToDo: get router params (filterType, filterName)
    this.route.params.subscribe( params =>
        this.filterName = params['filterName']
    );
    //console.log("filterName: ", this.filterName);
    /*
    this.route.params.subscribe( params =>
        this.filterType = params['filterType']
    );
    console.log("filterType: ", this.filterType);
    */
    
    // check for filter
    if(!this.filterName){ 
      this.clearFilters();

    }else {

      // Set selectedFilter (FilterModel)
      this.softwareService.getFilter(this.filterName).then(selectedFilter => this.selectedFilter = selectedFilter);

      // Filter results, based on route
      this.filterSoftwareType(this.filterName,'swt');

    } // ENDIF

  }

  // Calling the 'SoftwareService' mock API (software.service.ts) to pull a list of all 'software' records from the mock database (software-data.service.ts)
  // It also runs a 'getSwtList' function to pull a list of all 'software type' records from the same mock database.
  getSoftwareList(): void {
    this.softwareService.getSoftwareList().then(softwareList => this.softwareList = softwareList);
    this.clearFilters();
  }

  getSwtList(): void {
    this.softwareService.getSwtList().then(swtList => this.swtList = swtList);
  }

  searchSoftware(term: string): void {
    this.softwareService.searchSoftware(term).then(softwareList => this.softwareList = softwareList);
  }
  clearFilters(): void {
    this.displayActiveFilter(null);
    this.displayActiveRoute(null);
    this.selectedFilter = null;
  }

  // ToDo: adapt to handle 'research problem' as well
  filterSoftwareType(softwareType: string, filterType: string): void {
    
    // get list of software packages
    this.softwareService.filterSoftwareType(softwareType, filterType).then(softwareList => this.softwareList = softwareList);

    // update UI & URL to reflect active filter
    this.displayActiveFilter(softwareType);
    this.displayActiveRoute(softwareType);
  }

  displayActiveFilter(softwareType: string): void {
    this.filterName = softwareType;
  }

  displayActiveRoute(softwareType: string): void {
    if(!softwareType){
      this.router.navigate(['/software']);
    } else {
      this.router.navigate(['/software', softwareType]);
    }
  }

  onSelect(filter: FilterModel): void {
    this.selectedFilter = filter;
  }

  gotoDetail(software: SoftwareModel): void {
    this.router.navigate(['/s', software.slug]);
    //this.router.navigate(['/s', software.id]);
  }
}