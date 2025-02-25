import { html } from "lit";
import { customElement } from "lit/decorators.js";
import { PageBase } from "./page-base";

@customElement("pg-profile")
export class PgProfile extends PageBase {
  render() {
    return html`
      <section
        class="page-section flow"
        data-section="login"
        id="section-login"
      >
        <div class="container">
          <div class="row justify-content-md-center text-center">
            <div class="flow" id="pg_content">
              Profile page
              <span class="loading-spinner active"></span>
            </div>
          </div>
        </div>
      </section>
    `;
  }
}
