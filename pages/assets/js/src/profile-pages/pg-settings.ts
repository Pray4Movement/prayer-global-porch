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
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;

  back() {
    history.back();
  }

  render() {
    return html`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${this.back}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">Profile Settings</h3>
      </div>
      <div class="container-md stack">
        <a
          class="btn btn-small btn-outline-primary mt-3 uppercase"
          href="/user_app/logout"
        >
          ${this.translations.logout}
        </a>
      </div>
    `;
  }
}
