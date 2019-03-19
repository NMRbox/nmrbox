import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';
import {SoftwareModel} from './software.model';
import {SoftwareService} from './software.service';
import {ResponsiveService} from '../responsive.service';

@Component({
  selector: 'app-my-software-list',
  templateUrl: './software-list.component.html',
  styleUrls: ['./software-list.component.scss']
})
export class SoftwareListComponent implements OnInit {

  activeSoftwareType;
  activeResearchProblem;
  activeNameSearch;
  filteredList: SoftwareModel[];
  softwareList: SoftwareModel[];

  /* Routing filters */
  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private softwareService: SoftwareService,
    public responsiveService: ResponsiveService
  ) {
    this.filteredList = [];
    this.activeResearchProblem = null;
    this.activeSoftwareType = null;
    this.activeNameSearch = null;
  }

  ngOnInit(): void {


    const parent = this;
    this.softwareService.software.subscribe(softwareList => {
        parent.softwareList = softwareList;
        parent.filterSelections();
      }
    );
    this.route.params.subscribe(function (params) {
      if (params['filterType'] === 'software') {
        parent.activeSoftwareType = parent.softwareService.slugMapper[params['filter']];
      } else if (params['filterType'] === 'research') {
        parent.activeResearchProblem = parent.softwareService.slugMapper[params['filter']];
      } else if (params['filterType'] === 'name') {
        parent.activeNameSearch = params['filter'];
      }
      parent.filterSelections();
    });
  };


  static hasResearchProblemByID(software: SoftwareModel, id: string): boolean {
    if (id === null) {
      return true;
    }
    for (const researchProblem of software.research_problems) {
      if (String(researchProblem['id']) === id) {
        return true;
      }
    }
    return false;
  }

  static hasSoftwareTypeByID(software: SoftwareModel, id: string): boolean {
    if (id === null) {
      return true;
    }

    for (const softwareType of software.software_type) {
      if (String(softwareType['id']) === id) {
        return true;
      }
    }
    return false;
  }

  static matchesNameSearch(software: SoftwareModel, name: string) {
    if (name === null) {
      return true;
    }
    const lowerName = name.toLowerCase();
    return software.short_title.toLowerCase().includes(lowerName) || software.long_title.toLowerCase().includes(lowerName) ||
      software.synopsis.toLowerCase().includes(lowerName);
  }

  // Filter the software based on the menu
  filterSelections() {

    if (!this.softwareList) {
      return;
    }

    this.filteredList = [];

    for (const software of this.softwareList) {
      if (SoftwareListComponent.hasResearchProblemByID(software, this.activeResearchProblem) &&
        SoftwareListComponent.hasSoftwareTypeByID(software, this.activeSoftwareType) &&
        SoftwareListComponent.matchesNameSearch(software, this.activeNameSearch)) {
        this.filteredList.push(software);
      }
    }
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
