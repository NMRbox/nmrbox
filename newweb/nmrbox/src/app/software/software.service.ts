import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {SoftwareModel} from './software.model';
import {SoftwareMetadataModel} from './software-metadata.model';
import {BehaviorSubject} from 'rxjs/Rx';

@Injectable()
export class SoftwareService {

  public softwareTypeFrequency: BehaviorSubject<Array<Array<string>>>;
  public software: BehaviorSubject<SoftwareModel[]>;

  public softwareTypes = {
    '1': 'Spectrum Analysis', '2': 'Predictor',
    '3': 'Molecular Modeling', '4': 'Structure Visualization',
    '5': 'Residual Dipolar Coupling', '6': 'Relaxation',
    '7': 'Data Translator', '8': 'Validation', '9': 'Time-domain data processing',
    '10': 'Tools / Utilities', '11': 'SAXS / CryoEM',
    null: 'Show all'
  };
  public softwareSlugs = {
    '1': 'spectral-analysis', '2': 'predictor', '3': 'molecular-modeling', '4': 'structure-visualization',
    '5': 'rdc', '6': 'relaxation', '7': 'data-translator', '8': 'validation',
    '9': 'time-domain', '10': 'tools', '11': 'saxs-cryoem'
  };
  public researchProblems = {
    '21': 'Metabolomics', '22': 'Protein Dynamics',
    '23': 'Protein Structure', '24': 'Intrinsically Disordered Proteins',
    '25': 'Binding', null: 'Show all'
  };
  public researchSlugs = {
    '21': 'metabolomics', '22': 'protein-dynamics', '23': 'protein-structure',
    '24': 'intrinsically', '25': 'binding'
  };

  constructor(private http: HttpClient) {
    this.softwareTypeFrequency = new BehaviorSubject([]);
    this.software = new BehaviorSubject([]);

    const parent: SoftwareService = this;

    this.http
      .get(environment.appUrl + `/` + environment.softwareRegistryUrl)
      .subscribe(response => {
        if (response && response['data']) {
          const model = response['data'] as SoftwareModel[];
          parent.software.next(model);
          parent.storeCommonPackages(model);
        } else {
          console.error('Could not fetch software packages.');
        }});
  }

  storeCommonPackages(software: SoftwareModel[]): void {

    const packageList = [];
    const packageFrequency = {};

    for (const oneSoftware of software){
      for (const softwareType of oneSoftware.software_type){
        if (softwareType['label'] in packageFrequency) {
          packageFrequency[softwareType['label']] += 1;
        } else {
          packageFrequency[softwareType['label']] = 1;
          packageList.push(softwareType['label']);
        }
      }
    }
    const softwareTypeFrequency = [];
    for (const onePackage of packageList){
      softwareTypeFrequency.push([onePackage, packageFrequency[onePackage]]);
    }
    softwareTypeFrequency.sort(function(a, b){
      if (a[1] > b[1]) { return -1; }
      if (a[1] < b[1]) { return 1; }
      return 0;
    });
    this.softwareTypeFrequency.next(softwareTypeFrequency);
  }

  getSoftware(slug: string): Promise<SoftwareModel> {

    const url = environment.appUrl + `/` + environment.softwareRegistryUrl + `/` + slug;
    return this.http
      .get(url)
      .toPromise()
      .then(response => {
          if (response && response['data']) {
            return response['data'] as SoftwareModel;
          } else {
            return {} as SoftwareModel;
          }
        },
        () => new SoftwareModel(slug));
  }

  getSoftwareMetaData(slug: string): Promise<SoftwareMetadataModel> {

    const url = environment.appUrl + `/` + environment.softwareRegistryMetaUrl + `/` + slug;
    return this.http
      .get(url)
      .toPromise()
      .then(response => {
          if (response && response['data']) {
            return response['data'] as SoftwareMetadataModel;
          } else {
            return {} as SoftwareMetadataModel;
          }
        },
        () => new SoftwareMetadataModel());
  }
}
