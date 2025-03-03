export interface User {
  display_name: string;
  location: Location;
  user_email: string;
  send_general_emails: boolean;
}

export interface Location {
  source: string;
  label: string;
}
