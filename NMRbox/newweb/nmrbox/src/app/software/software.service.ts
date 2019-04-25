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

  public slugMapper = {
    'metabolomics': '21', 'protein-dynamics': '22', 'protein-structure': '23',
    'intrinsically': '24', 'binding': '25',
    'spectral-analysis': '1', 'predictor': '2', 'molecular-modeling': '3', 'structure-visualization': '4',
    'rdc': '5', 'relaxation': '6', 'data-translator': '7', 'validation': '8', 'time-domain': '9',
    'tools': '10', 'saxs-cryoem': '11'
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
        if (softwareType['id'] in packageFrequency) {
          packageFrequency[softwareType['id']] += 1;
        } else {
          packageFrequency[softwareType['id']] = 1;
          packageList.push(softwareType['id']);
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
            const SoftwareMetadata = response['data'] as SoftwareMetadataModel;
            const SoftwareVersions = [];
            for (const index in SoftwareMetadata.nmrbox_version) {
              if (SoftwareMetadata.nmrbox_version.hasOwnProperty(index)) {
                SoftwareVersions.push([SoftwareMetadata.nmrbox_version[index], SoftwareMetadata.software_version[index][0]]);
              }
            }
            SoftwareVersions.sort((a, b) => a[0].localeCompare(b[0]));
            SoftwareMetadata.software_versions = SoftwareVersions;
            return SoftwareMetadata;
          } else {
            return {} as SoftwareMetadataModel;
          }
        },
        () => new SoftwareMetadataModel());
  }
}
