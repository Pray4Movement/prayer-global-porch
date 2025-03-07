export interface User {
  display_name: string;
  location: Location;
  user_email: string;
  send_general_emails: boolean;
}

export interface Location {
  source: string;
  label: string;
  lat: number;
  lng: number;
  level: string;
  grid_id: number;
}

export interface Language {
  parent_code: string;
  po_code: string;
  datatabes_url: string;
  firebase_code: string;
  native_name: string;
  language: string;
  english_name: string;
  iso: Array<string>;
  flag: string;
}
