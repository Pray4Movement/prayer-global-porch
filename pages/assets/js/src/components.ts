import "./parts/pg-avatar";
import "./parts/pg-header";
import "./parts/pg-modal";
import "./parts/nav-link";
import "./parts/pg-relay-item";
import "./profile-pages/open-element";
import "./profile-pages/pg-activity";
import "./profile-pages/pg-dashboard";
import "./profile-pages/pg-new-relay";
import "./profile-pages/pg-relays";
import "./profile-pages/pg-router";
import "./profile-pages/pg-settings";

declare global {
  interface Window {
    pg_global: any;
    jsObject: any;
    api_fetch: Function;
    location_data: any;
    toDateInputFormat: (timestamp: number) => string;
    toTimeInputFormat: (timestamp: number) => string;
  }
}
