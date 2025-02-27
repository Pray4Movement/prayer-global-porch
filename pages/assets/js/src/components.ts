import "./profile-pages/pg-activity";
import "./profile-pages/page-base";
import "./profile-pages/pg-dashboard";
import "./profile-pages/pg-relays";
import "./profile-pages/pg-router";
import "./profile-pages/pg-settings";

declare global {
  interface Window {
    pg_global: any;
    jsObject: any;
  }
}
