export class CommunityModel {
  id: number;
  contentType: string;
  name: string;
  synopsis: string;
  description: string;
  imgUrl: string;
  url: string;
  dateEvent: string;
  datePublished: string;
  dateCurrent: boolean;
  dateCurrentStr: string;
  author: string;
  authorTitle: string;
  authorPhotoUrl: string;
  software_types: Array<string>;
  nmrbox_version: number;
  software_version: number;
}