import { html } from "lit";
import { customElement } from "lit/decorators.js";
import { PageBase } from "./page-base";

interface User {
  display_name: string;
  location: Location;
}

interface Location {
  source: string;
  label: string;
}

@customElement("pg-settings")
export class PgSettings extends PageBase {
  constructor() {
    super();

    if (!window.pg_global.is_logged_in) {
      window.loginRedirect();
    }
  }

  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;

  render() {
    return html` <h2>Profile Settings</h2> `;
  }
}
