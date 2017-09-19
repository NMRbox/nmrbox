export class CommunityModel {
  id: number;
  contentType: string;
  title: string;
  name: string;
  synopsis: string;
  description: string;
  content: string;
  url: string;
  software_types: Array<string>;
  nmrbox_version: number;
  software_version: number;
  descriptionHtml: string;
  imgUrl: string;
  /*dateEvent: string;
  datePublished: string;
  dateCurrent: boolean;
  dateCurrentStr: string;*/
  start_date: string;
  end_date: string;
  location: string;
  attendance_max: number;
  author: string;
  authorTitle: string;
  authorPhotoUrl: string;
}