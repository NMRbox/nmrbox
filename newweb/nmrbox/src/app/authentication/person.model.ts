export class ClassificationModel {
  name: string;
  web_role: boolean;
  pivot: {};
  definition: string;
}

export class PersonModel {
    id: number;
    first_name: string;
    last_name: string;
    nmrbox_acct: string;
    description: string;
    email: string;
    email_institution: string;
    institution: string;
    institution_type: number;
    pi: string;
    department: string;
    position: string;
    downloadableVm: Array<Array<string>>;
    job_title: string;
    address1: string;
    address2: string;
    address3: string;
    city: string;
    state_province: string;
    zip_code: number;
    country: string;
    time_zone_id: number;
    classifications: Array<ClassificationModel>;
    name: string;
    notification: Array<string>;
}
