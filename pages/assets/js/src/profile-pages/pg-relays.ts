import { html } from "lit";
import { customElement } from "lit/decorators.js";
import { PageBase } from "./page-base";
import { User } from "../interfaces";

@customElement("pg-relays")
export class PgRelays extends PageBase {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;

  constructor() {
    super();

    fetch(window.pg_global.root + "pg-api/v1/profile/relays", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-WP-Nonce": window.pg_global.nonce,
      },
      body: JSON.stringify({
        data: {
          user_id: this.user.id,
        },
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
      });
  }

  render() {
    return html` <h2>My Prayer Relays</h2> `;
  }
}
