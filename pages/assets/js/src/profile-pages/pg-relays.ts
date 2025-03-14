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
  @state() hiddenRelays: number[] = [];
  @state() showHiddenRelays: boolean = false;
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
        this.hiddenRelays = hidden_relays;
      });
  }

  private async handleHide(relay: Relay) {
    const response = await fetch(
      `${window.pg_global.root}pg-api/v1/profile/relays/hide?relay_id=${relay.post_id}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": window.pg_global.nonce,
        },
      }
    );
    if (response.ok) {
      this.hiddenRelays = [...this.hiddenRelays, relay.post_id];
    }
  }

  private async handleUnhide(relay: Relay) {
    const response = await fetch(
      `${window.pg_global.root}pg-api/v1/profile/relays/unhide?relay_id=${relay.post_id}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": window.pg_global.nonce,
        },
      }
    );
    if (response.ok) {
      this.hiddenRelays = this.hiddenRelays.filter((r) => r !== relay.post_id);
    }
  }

  private toggleHiddenRelays() {
    this.showHiddenRelays = !this.showHiddenRelays;
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
          ${this.hiddenRelays.length > 0
            ? html`
                <div class="cluster ms-auto">
                  <button @click=${() => this.toggleHiddenRelays()}>
                    ${this.showHiddenRelays
                      ? this.translations.hide_hidden_relays
                      : this.translations.show_hidden_relays}
                  </button>
                </div>
              `
            : ""}
          <div role="list" class="stack-md relay-list" data-stretch>
            ${repeat(
              this.relays,
              (relay) => relay.post_id,
              (relay) => {
                if (
                  !this.showHiddenRelays &&
                  this.hiddenRelays.includes(relay.post_id)
                ) {
                  return "";
                }
                return html`
                  <pg-relay-item
                    key="${relay.post_id}"
                    name="${relay.post_title}"
                    lapNumber="${relay.stats.lap_number}"
                    progress="${relay.stats.completed_percent}"
                    relayType="${relay.relay_type}"
                    visibility="${relay.visibility}"
                    ?hiddenRelay=${this.hiddenRelays.includes(relay.post_id)}
                    .translations="${{
                      lap: this.translations.lap,
                      pray: this.translations.pray,
                      map: this.translations.map,
                      share: this.translations.share,
                      display: this.translations.display,
                      edit: this.translations.edit,
                      hide: this.translations.hide,
                      unhide: this.translations.unhide,
                    }}"
                    spritesheetUrl="${window.jsObject.spritesheet_url}"
                    urlRoot="/prayer_app/${relay.relay_type}/${relay.lap_key}"
                    @hide=${() => this.handleHide(relay)}
                    @unhide=${() => this.handleUnhide(relay)}
                  ></pg-relay-item>
                `;
              }
            )}
          </div>
        </div>
      </div>
    `;
  }
}
