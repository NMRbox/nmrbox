import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {ActivatedRoute} from '@angular/router';
import {SoftwareModel} from './software.model';
import {SoftwareService} from './software.service';

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
    private softwareService: SoftwareService
  ) {
    this.filteredList = [];
    this.activeResearchProblem = null;
    this.activeSoftwareType = null;
    this.activeNameSearch = null;
  }

  ngOnInit(): void {
    const slugMapper = {
      'metabolomics': '21', 'protein-dynamics': '22', 'protein-structure': '23',
      'intrinsically': '24', 'binding': '25',
      'spectral': '1', 'chemical-shift': '2', 'molecular-modeling': '3', 'structure': '4',
      'rdc': '5', 'assignment': '6', 'relaxation': '7', 'validation': '8', 'time-domain': '9',
      'tools': '10', 'saxs-cryoem': '11'
    };

    const parent = this;
    this.softwareService.software.subscribe(softwareList => {
        parent.softwareList = softwareList;
        parent.filterSelections();
      }
    );
    this.route.params.subscribe(function (params) {
      if (params['filterType'] === 'software') {
        parent.activeSoftwareType = slugMapper[params['filter']];
      } else if (params['filterType'] === 'research') {
        parent.activeResearchProblem = slugMapper[params['filter']];
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
    return software.short_title.toLowerCase().includes(name.toLowerCase());
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
