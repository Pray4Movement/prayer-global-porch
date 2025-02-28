import { html } from "lit";
import { customElement } from "lit/decorators.js";
import { PageBase } from "./page-base";
import { User } from "../interfaces";

@customElement("pg-relays")
export class PgRelays extends PageBase {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;

  render() {
    return html` <h2>My Prayer Relays</h2> `;
  }
}
