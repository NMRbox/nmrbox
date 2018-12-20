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

  softwareTypes: {};
  researchProblems: {};
  activeSoftwareType;
  activeResearchProblem;
  activeNameSearch;
  filteredList: SoftwareModel[];
  softwareList: SoftwareModel[];

  config: Object = {
    slidesPerView: 'auto',
    centeredSlides: false,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    spaceBetween: 0,
    speed: 500,
    loop: false
  };

  /* Routing filters */
  private researchSlugs;
  private softwareSlugs;

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private softwareService: SoftwareService
  ) {
    this.filteredList = [];
    this.softwareTypes = {
      '1': 'Spectrum Analysis', '2': 'Chemical Shift',
      '3': 'Molecular Modeling', '4': 'Structure Visualization',
      '5': 'Residual Dipolar Coupling', '6': 'Assignment',
      '7': 'Relaxation', null: 'Show all'
    };
    this.softwareSlugs = {
      '1': 'spectral', '2': 'chemical', '3': 'molecular', '4': 'structure',
      '5': 'rdc', '6': 'assignment', '7': 'relaxation'
    };
    this.researchProblems = {
      '1': 'Metabolomics', '2': 'Protein Dynamics',
      '3': 'Protein Structure', '4': 'Intrinsically Disordered Proteins',
      null: 'Show all'
    };
    this.researchSlugs = {
      '1': 'metabolomics', '2': 'protein-dynamics', '3': 'protein-structure',
      '4': 'intrinsically',
    };
    this.activeResearchProblem = null;
    this.activeSoftwareType = null;
    this.activeNameSearch = null;
  }

  ngOnInit(): void {
    this.getSoftwareList();

    const slugMapper = {
      'metabolomics': '1', 'protein-dynamics': '2', 'protein-structure': '3',
      'intrinsically': '4',
      'spectral': '1', 'chemical-shift': '2', 'molecular-modeling': '3', 'structure': '4',
      'rdc': '5', 'assignment': '6', 'relaxation': '7'
    };


    const parent = this;
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


  hasResearchProblemByID(software: SoftwareModel, id: string): boolean {
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

  hasSoftwareTypeByID(software: SoftwareModel, id: string): boolean {
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

  matchesNameSearch(software: SoftwareModel, name: string) {
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

  resetSelections(): void {
    this.activeNameSearch = null;
    this.activeSoftwareType = null;
    this.activeResearchProblem = null;
  }

  gotoDetail(software: SoftwareModel): void {
    this.router.navigate(['/s', software.slug]);
  }
}
