import { html } from "lit";
import { customElement } from "lit/decorators.js";
import { PageBase } from "./page-base";
import { Router } from "@lit-labs/router";

@customElement("pg-router")
export class PgRouter extends PageBase {
  private router = new Router(this, [
    {
      name: "dashboard",
      path: "/user_app/profile",
      render: () => html`<pg-dashboard></pg-dashboard>`,
    },
    {
      name: "prayer-relays",
      path: "/user_app/profile/prayer-relays",
      render: () => html`<pg-relays></pg-relays>`,
    },
    {
      name: "prayer-activity",
      path: "/user_app/profile/prayer-activity",
      render: () => html`<pg-activity></pg-activity>`,
    },
    {
      name: "profile-settings",
      path: "/user_app/profile/profile-settings",
      render: () => html`<pg-settings></pg-settings>`,
    },
  ]);

  render() {
    return html`
      <section
        class="page-section flow"
        data-section="login"
        id="section-login"
      >
        ${this.router.outlet()}
      </section>
    `;
  }
}

declare global {
  interface HTMLElementTagNameMap {
    "pg-router": PgRouter;
  }
}
