export class Author {
  id: number;
  first_name: string;
  last_name: string;
}

export class Citation {
  id: number;
  citation_type_id: number;
  title: string;
  year: number;
  journal: string;
  volume: string;
  issue: string;
  publisher: string;
  note: string;
  pages: string;
  source_key: string;
  authors: Author[];
}

export class SoftwareModel {
  id: number;
  name: string;
  short_title: string;
  long_title: string;
  synopsis: string;
  description: string;
  slug: string;
  url: string;
  citations: Citation[];
  research_problems: Array<Array<string>>;
  software_type: Array<Array<string>>;

  constructor(slug: string) {
    this.name = slug;
    this.long_title = 'An error occurred, no software package was found with the given name.';
  }
}
