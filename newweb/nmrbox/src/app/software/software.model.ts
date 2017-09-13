export class SoftwareModel {
  id: number;
  name: string;
  short_title: string;
  synopsis: string;
  description: string;
  url: string;
  slug: string;
  software_types: Array<string>;
  nmrbox_version: Array<string>;
  software_version: Array<string>;
  /*nmrbox_version: number;
  software_version: number;*/
}