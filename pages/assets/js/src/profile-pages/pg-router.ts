import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { router, navigator } from "lit-element-router";

@customElement("pg-router")
export class PgRouter extends navigator(router(OpenElement)) {
  static get properties() {
    return {
      route: { type: String },
      params: { type: Object },
      query: { type: Object },
      data: { type: Object },
    };
  }
  static get routes() {
    return [
      {
        name: "dashboard",
        pattern: "/dashboard",
        data: {
          render: () => html`<pg-dashboard></pg-dashboard>`,
        },
      },
      {
        name: "prayer-relays",
        pattern: "/dashboard/relays",
        data: {
          render: () => html`<pg-relays></pg-relays>`,
        },
      },
      {
        name: "prayer-activity",
        pattern: "/dashboard/activity",
        data: {
          render: () => html`<pg-activity></pg-activity>`,
        },
      },
      {
        name: "profile-settings",
        pattern: "/dashboard/settings",
        data: {
          render: () => html`<pg-settings></pg-settings>`,
        },
      },
      {
        name: "new-relay",
        pattern: "/dashboard/new-relay",
        data: { render: () => html`<pg-new-relay></pg-new-relay>` },
      },
      {
        name: "badges",
        pattern: "/dashboard/badges",
        data: { render: () => html`<pg-badges></pg-badges>` },
      },
      {
        name: "badge-item",
        pattern: "/dashboard/badge/:badgeId",
        data: { render: (params: any) => html`<pg-badge-item badgeId=${params.badgeId}></pg-badge-item>` },
      },
    ];
  }

  route: string = "";
  params: any = {};
  query: any = {};
  data: any = {};

  router(route: string, params: any, query: any, data: any) {
    this.route = route;
    this.params = params;
    this.query = query;
    this.data = data;
  }

  render() {
    return html` ${this.data?.render && this.data.render(this.params)} `;
  }
}

declare global {
  interface HTMLElementTagNameMap {
    "pg-router": PgRouter;
  }
}
