import { html, PropertyValues, render } from "lit";
import { customElement, state } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { User, Relay, Location } from "../interfaces";

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

  async connectedCallback() {
    super.connectedCallback();

    //if no location is saved on the user, get it from the IP and save it to the user
    if (!this.user.location_hash.length || !this.user.location.timezone) {
      await this.getLocationFromIP();
    }
    //link anonymous prayers to the user
    //@todo save the user id locacally so this happens automatically
    await this.link_anonymous_prayers();
  }

  updated(changedProperties: PropertyValues) {
    super.updated(changedProperties);
    if (changedProperties.has("relays") && window.pg_set_up_share_buttons) {
      window.pg_set_up_share_buttons(true);
    }
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

              <!-- If the user has installed the app, don't show the download app section -->
              ${
                !window.pg_global.has_used_app &&
                (!window.isMobileAppUser() || window.isLegacyAppUser)
                  ? html`
                      <div
                        class="stack-sm brand-lightest-bg p-4 rounded-3 white"
                      >
                        <h5 class="text-center font-weight-bold">
                          ${window.isLegacyAppUser
                            ? this.translations.update_the_app
                            : this.translations.download_the_app}
                        </h5>
                        <a
                          href="/qr/app"
                          target="_blank"
                          class="btn btn-cta d-block center-block"
                          data-umami-event="Dashboard - Download app"
                        >
                          ${this.translations.go_to_app_store}
                        </a>
                      </div>
                    `
                  : ""
              }

              <div class="flow-small w-100">
                <h3 class="text-center">${this.translations.prayer_relays}</h3>
                ${
                  this.loading
                    ? html`<span class="loading-spinner active"></span>`
                    : this.relays.map(
                        (relay) => html`
                          <div
                            class="repel relay-item align-items-center"
                            data-type=${relay.relay_type}
                            data-visibility=${relay.visibility}
                          >
                            ${relay.post_title}

                            <div class="space-out">
                              <button
                                class="p-0 icon-button share-button two-rem d-flex"
                                data-toggle="modal"
                                data-target="#exampleModal"
                                data-url=${`${window.location.origin}/prayer_app/${relay.relay_type}/${relay.lap_key}`}
                              >
                                <svg class="icon-sm white">
                                  <use
                                    href="${window.jsObject
                                      .spritesheet_url}#pg-share"
                                  ></use>
                                </svg>
                              </button>
                              <a
                                href=${`/prayer_app/${relay.relay_type}/${relay.lap_key}`}
                                class="btn btn-cta"
                              >
                                ${this.translations.pray}
                              </a>
                            </div>
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
                    data-umami-event="Dashboard - Donate"
                  >
                    ${this.translations.donate}
                  </a>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    `;
  }

  private saveLocationToLocalStorage(location: Location) {
    localStorage.setItem(
      "user_location",
      JSON.stringify(location)
    );
  }

  private async getLocationFromIP() {

    if (!this.user || !this.user.location) {
      const saved_location = localStorage.getItem("user_location");
      this.user.location = saved_location ? JSON.parse(saved_location) : null;
      if (this.user.location?.hash) {
        this.user.location_hash = this.user.location.hash;
      }
    } else {
      this.saveLocationToLocalStorage(this.user.location);
    }

    if (
      !this.user.location ||
      (this.user.location.date_set &&
        this.user.location.date_set <
          Date.now() - 7 * 24 * 60 * 60 * 1000) ||
      !this.user.location.timezone
    ) {
      await window
        .api_fetch(`https://geo.prayer.global/json`, {
          method: "GET",
        })
        .then((response: any) => {
          if (response) {
            const locationData = {
              lat: response.location.latitude,
              lng: response.location.longitude,
              label: `${response.city?.names?.en}, ${response.country?.names?.en}`,
              country: response.country?.names?.en,
              date_set: Date.now(),
              timezone: response.location.time_zone,
              source: "ip",
            };
            // Update the user's location
            this.user.location = locationData;

            let pg_user_hash = localStorage.getItem("pg_user_hash");
            if (!pg_user_hash || pg_user_hash === "undefined") {
              pg_user_hash = window.crypto.randomUUID();
              localStorage.setItem("pg_user_hash", pg_user_hash);
              this.user.location_hash = pg_user_hash;
            }
            this.user.location.hash = pg_user_hash;

            this.saveLocationToLocalStorage(this.user.location);
          }
        });

        await window.api_fetch(
          `${window.pg_global.root}pg-api/v1/dashboard/save_location`,
          {
            method: "POST",
            body: JSON.stringify({
              location_hash: this.user.location_hash,
              location: this.user.location,
            }),
          }
        );
    }

    this.requestUpdate();
  }

  private async link_anonymous_prayers() {
    const url = `${window.pg_global.root}pg-api/v1/dashboard/link_anonymous_prayers`;
    window.api_fetch(url, {
      method: "POST",
      body: JSON.stringify({
        location_hash: this.user.location_hash,
      }),
    });
  }
}
