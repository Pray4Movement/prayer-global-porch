import "./parts/pg-avatar";
import "./parts/pg-header";
import "./parts/pg-modal";
import "./parts/nav-link";
import "./parts/pg-relay-item";
import "./parts/pg-relay-form";
import "./profile-pages/open-element";
import "./profile-pages/pg-activity";
import "./profile-pages/pg-dashboard";
import "./profile-pages/pg-new-relay";
import "./profile-pages/pg-relays";
import "./profile-pages/pg-router";
import "./profile-pages/pg-settings";
import { MedianPermissions } from "./interfaces";

declare global {
  interface Window {
    pg_global: any;
    jsObject: any;
    api_fetch: Function;
    location_data: any;
    toDateInputFormat: (timestamp: number) => string;
    toTimeInputFormat: (timestamp: number) => string;
    isMobile: () => boolean;
    isMobileAppUser: () => boolean;
    isLegacyAppUser: boolean;
    medianPermissions: MedianPermissions;
    bootstrap: any;
    requestNotificationsPermission: (
      callback: (notificationsPermission: boolean) => void
    ) => void;
    pg_set_up_share_buttons: (wait?: boolean) => void;
    has_used_app: boolean;
  }
}
