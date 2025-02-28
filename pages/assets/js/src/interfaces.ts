export interface User {
  display_name: string;
  location: Location;
  user_email: string;
}

export interface Location {
  source: string;
  label: string;
}
