import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { PageBase } from "./page-base";
import { Router } from "@lit-labs/router";

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
  constructor() {
    super();

    if (!window.pg_global.is_logged_in) {
      window.loginRedirect();
    }
  }

  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;

  render() {
    return html`
      <section
        class="page-section flow"
        data-section="login"
        id="section-login"
      >
        <div class="container">
          <h2>Prayer Activity</h2>
        </div>
      </section>
    `;
  }
}
