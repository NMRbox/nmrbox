export class CommunityModel {
  id: number;
  contentType: string;
  title: string;
  name: string;
  synopsis: string;
  description: string;
  content: string;
  descriptionHtml: string;
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