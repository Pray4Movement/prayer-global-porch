import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { PageBase } from "./page-base";

interface User {
  display_name: string;
  location: Location;
}

interface Location {
  source: string;
  label: string;
}

@customElement("pg-activity")
export class PgActivity extends PageBase {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;

  render() {
    return html` <h2>Prayer Activity</h2> `;
  }
}
