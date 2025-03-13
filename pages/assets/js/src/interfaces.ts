export interface User {
  id: number;
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

export type RelayVisibility = "private" | "public";
export type RelayType = "global" | "custom";

export interface RelayStats {
  lap_number: number;
  completed_percent: number;
}

export type GlobalRelay = {
  post_title: string;
  relay_type: "global";
  visibility: "public";
  stats: RelayStats;
};

export type CustomRelay = {
  post_title: string;
  relay_type: "custom";
  visibility: RelayVisibility;
  stats: RelayStats;
};

export type Relay = GlobalRelay | CustomRelay;
