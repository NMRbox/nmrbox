export class SoftwareModel {
  id: number;
  name: string;
  short_title: string;
  long_title: string;
  synopsis: string;
  description: string;
  url: string;
  slug: string;
  nmrbox_version: Array<string>;
  software_version: Array<string>;
  citation: string;
  title: string;
  first_name: string;
  last_name: string;
  journal: any;
  year: any;
  volume: any;
  issue: any;
  authors: string;
  research_problems: Array<Array<string>>;
  software_type: Array<Array<string>>; // change to 'types' once mosrur is on board
}
