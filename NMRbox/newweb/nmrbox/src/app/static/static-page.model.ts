export class StaticPageModel {
  'subheader': string;
  'user_id': string;
  'title': string;
  'created_at': string;
  'updated_at': string;
  'id': number;
  'content': string;
  'deleted_at': string;
  'slug': string;

  constructor(title) {
    this.title = title;
  }
}
