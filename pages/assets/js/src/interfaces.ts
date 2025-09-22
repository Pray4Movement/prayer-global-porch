export interface User {
  id: number;
  display_name: string;
  location: Location;
  location_hash: string;
  user_email: string;
  send_general_emails: boolean;
}

export interface Location {
  source: string;
  label: string;
  country: string;
  lat: number;
  lng: number;
  level?: string;
  grid_id?: number;
  date_set?: number;
  timezone?: string;
  hash?: string;
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

export interface Badge {
  id: string;
  title: string;
  description: string;
  value: number;
  image: string;
  type: string;
  category: string;
  hidden: boolean;
  has_badge: boolean;
  timestamp: number | null;
  next_badge: Badge | null;
}

export type RelayVisibility = "private" | "public";
export type RelayType = "global" | "custom";

export interface RelayStats {
  lap_number: number;
  completed_percent: number;
}

export interface BaseRelay {
  post_id: number;
  post_title: string;
  stats: RelayStats;
  lap_key: string;
  start_time: number;
  end_time: number;
  single_lap: boolean;
  is_owner: string;
}

export type GlobalRelay = BaseRelay & {
  relay_type: "global";
  visibility: "public";
};

export type CustomRelay = BaseRelay & {
  relay_type: "custom";
  visibility: RelayVisibility;
};

export type Relay = GlobalRelay | CustomRelay;

export interface MedianPermissions {
  medianLibraryReady: boolean;
  getNotificationsPermission(): Promise<boolean>;
  requestNotificationsPermission(): void;
  openAppSettings(): Promise<void>;
}
