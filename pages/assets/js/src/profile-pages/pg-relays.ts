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
  @state() loading: boolean = true;
  @state() editRelayModalOpen: boolean = false;
  @state() editRelay: Relay | null = null;
  constructor() {
    super();

    fetch(window.pg_global.root + "pg-api/v1/dashboard/relays", {
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
      })
      .finally(() => {
        this.loading = false;
      });
  }

  private async handleHide(relay: Relay) {
    const response = await fetch(
      `${window.pg_global.root}pg-api/v1/dashboard/relays/hide?relay_id=${relay.post_id}`,
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
    const response = await window.api_fetch(
      `${window.pg_global.root}pg-api/v1/dashboard/relays/unhide?relay_id=${relay.post_id}`,
      {
        method: "POST",
      }
    );
    if (response.ok) {
      this.hiddenRelays = this.hiddenRelays.filter((r) => r !== relay.post_id);
    }
  }

  private openEditRelayModal(relayId: number) {
    this.editRelayModalOpen = true;
    this.editRelay = this.relays.find((r) => r.post_id === relayId) || null;
  }

  private toggleHiddenRelays() {
    this.showHiddenRelays = !this.showHiddenRelays;
  }

  private closeModal(modalId: string) {
    this.editRelayModalOpen = false;
  }

  render() {
    return html`
      <pg-header title=${this.translations.prayer_relays}></pg-header>

      <div class="white-bg page px-3">
        <div class="pg-container stack-md" data-small data-stretch>
          ${this.loading
            ? html`<div class="center">
                <span class="loading-spinner active"></span>
              </div>`
            : html`
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
                          ?hiddenRelay=${this.hiddenRelays.includes(
                            relay.post_id
                          )}
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
                          @edit=${() => this.openEditRelayModal(relay.post_id)}
                        ></pg-relay-item>
                      `;
                    }
                  )}
                  ${!this.relays.some(
                    (relay: Relay) => relay.relay_type === "custom"
                  )
                    ? html`
                        <div
                          class="stack-sm center | text-center | border-dashed lh-xsm"
                        >
                          <p class="font-weight-bold">
                            ${this.translations.no_custom_relays}
                          </p>
                          <svg class="icon-md">
                            <use
                              href="${window.jsObject.spritesheet_url}#pg-relay"
                            ></use>
                          </svg>
                        </div>
                      `
                    : ""}
                  <nav-link href="/dashboard/new-relay">
                    <div class="stack-sm center text-center brand">
                      <svg center text-center brandsvg class="icon-lg">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-plus"
                        ></use>
                      </svg>
                      <span class="uppercase"
                        >${this.translations.new_relay}</span
                      >
                    </div>
                  </nav-link>
                </div>
              `}
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
          <pg-modal
            id="edit-relay-modal"
            ?open=${this.editRelayModalOpen}
            @close=${() => this.closeModal("edit-relay-modal")}
          >
            <h2 slot="title" class="h5 cluster">
              <svg class="icon-md">
                <use
                  href="${window.jsObject.spritesheet_url}#${this.editRelay
                    ?.visibility === "private"
                    ? "pg-private"
                    : "pg-world-light"}"
                ></use>
              </svg>
              ${this.translations.edit_relay}
            </h2>
            <pg-relay-form
              slot="body"
              edit
              .relay=${this.editRelay}
              @cancel=${() => this.closeModal("edit-relay-modal")}
            ></pg-relay-form>
          </pg-modal>
        </div>
      </div>
    `;
  }
}
