import { html } from "lit";
import { customElement, state } from "lit/decorators.js";
import { repeat } from "lit/directives/repeat.js";
import { OpenElement } from "./open-element";
import { User, Relay } from "../interfaces";

@customElement("pg-relays")
export class PgRelays extends OpenElement {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  @state() relays: Relay[] = [];

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
        const { relays, hidden_relays } = data;
        this.relays = relays;
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
            ${repeat(
              this.relays,
              (relay) => relay.post_title,
              (relay) => html`
                <pg-relay-item
                  name="${relay.post_title}"
                  lapNumber="${relay.stats.lap_number}"
                  progress="${relay.stats.completed_percent}"
                  relayType="${relay.relay_type}"
                  visibility="${relay.visibility}"
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
              `
            )}
          </div>
        </div>
      </div>
    `;
  }
}
