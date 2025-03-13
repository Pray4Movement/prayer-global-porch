import { html } from "lit";
import { customElement } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { User } from "../interfaces";

@customElement("pg-relays")
export class PgRelays extends OpenElement {
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
    return html`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${() => history.back()}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.prayer_relays}</h3>
      </div>

      <div class="white-bg page px-3">
        <div class="pg-container stack-md" data-small data-stretch>
          <div role="list" class="stack-md relay-list" data-stretch>
            <pg-relay-item
              name="The Global lap"
              lapNumber="33"
              progress="30"
              relayType="global"
              .translations="${{
                lap: this.translations.lap,
                pray: this.translations.pray,
                map: this.translations.map,
                share: this.translations.share,
                display: this.translations.display,
                edit: this.translations.edit,
                delete: this.translations.delete,
              }}"
              spritesheetUrl="${window.jsObject.spritesheet_url}"
            ></pg-relay-item>
            <pg-relay-item
              name="Northside Christian Church"
              lapNumber="2"
              progress="60"
              relayType="public"
              .translations="${{
                lap: this.translations.lap,
                pray: this.translations.pray,
                map: this.translations.map,
                share: this.translations.share,
                display: this.translations.display,
                edit: this.translations.edit,
                delete: this.translations.delete,
              }}"
              spritesheetUrl="${window.jsObject.spritesheet_url}"
            ></pg-relay-item>
            <pg-relay-item
              name="My Private lap"
              lapNumber="1"
              progress="30"
              relayType="private"
              .translations="${{
                lap: this.translations.lap,
                pray: this.translations.pray,
                map: this.translations.map,
                share: this.translations.share,
                display: this.translations.display,
                edit: this.translations.edit,
                delete: this.translations.delete,
              }}"
              spritesheetUrl="${window.jsObject.spritesheet_url}"
            ></pg-relay-item>
          </div>
        </div>
      </div>
    `;
  }
}
