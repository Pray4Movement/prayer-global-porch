import { html } from "lit";
import { customElement, state } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { User, Relay } from "../interfaces";

@customElement("pg-dashboard")
export class PgDashboard extends OpenElement {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  @state() relays: Relay[] = [];
  @state() loading: boolean = true;

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
        this.relays = relays.filter(
          (relay: Relay) => !hidden_relays.includes(relay.post_id)
        );
      })
      .finally(() => {
        this.loading = false;
      });
  }

  render() {
    return html`
      <div class="pg-container page">
          <div class="stack" id="pg_content">
            <div class="stack-md">
              <section class="user__summary stack-sm">
                <div class="user__avatar">
                  <pg-avatar text=${this.user.display_name}></pg-avatar>
                </div>

                <div class="user__info text-center">
                  <h2 class="user__full-name font-title uppercase">
                    ${this.user.display_name}
                  </h2>
                  <div class="user__location">
                    <div class="user__location-label">
                    ${
                      (this.user.location && this.user.location.label) ||
                      html`<span class="loading-spinner active"></span>`
                    }
                    </div>
                    ${
                      this.user.location && this.user.location.source === "ip"
                        ? html`
                            <span
                              class="iplocation-message small d-block text-secondary"
                            >
                              ${this.translations.estimated_location}
                            </span>
                          `
                        : ""
                    }
                  </div>
                </div>
              </section>
              <hr>
              <section class="profile-menu">
                <div class="w-fit mx-auto stack-md align-items-start">
                  <nav-link href="/dashboard/relays">
                    <div class="profile-link">
                      <svg class="icon-md">
                        <use href="${
                          window.jsObject.spritesheet_url
                        }#pg-relay"></use>
                      </svg>
                      <span class="one-rem">
                        ${this.translations.challenges}
                      </span>
                    </div>
                  </nav-link>
                  <nav-link href="/dashboard/activity">
                    <div class="profile-link">
                      <svg class="icon-md">
                        <use href="${
                          window.jsObject.spritesheet_url
                        }#pg-prayer"></use>
                      </svg>
                      <span class="one-rem">${this.translations.prayers}</span>
                    </div>
                  </nav-link>
                  <nav-link href="/dashboard/settings">
                    <div class="profile-link">
                      <svg class="icon-md">
                        <use href="${
                          window.jsObject.spritesheet_url
                        }#pg-settings"></use>
                      </svg>
                      <span class="one-rem">${this.translations.profile}</span>
                    </div>
                  </nav-link>
                </div>
              </section>

              <hr>

              <div class="flow-small">
                ${
                  this.loading
                    ? html`<span class="loading-spinner active"></span>`
                    : this.relays.map(
                        (relay) => html`
                          <div
                            class="repel relay-item"
                            data-type=${relay.relay_type}
                            data-visibility=${relay.visibility}
                          >
                            ${relay.post_title}

                            <a
                              href=${`/prayer_app/${relay.relay_type}/${relay.lap_key}`}
                              class="btn btn-cta"
                            >
                              ${this.translations.pray}
                            </a>
                          </div>
                        `
                      )
                }
              </div>

              <hr>

              <section class="text-center">
                <p>${this.translations.are_you_enjoying_the_app}</p>
                <p>${this.translations.would_you_like_to_partner}</p>
                <div class="d-flex flex-column m-auto w-fit">
                  <a
                    class="btn btn-small btn-primary-light uppercase"
                    data-reverse-color
                    href="/give"
                  >
                    ${this.translations.give}
                  </a>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    `;
  }
}
