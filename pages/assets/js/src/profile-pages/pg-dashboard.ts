import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { User } from "../interfaces";

@customElement("pg-dashboard")
export class PgDashboard extends OpenElement {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;

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
                  <nav-link href="/dashboard/relays" class="profile-link">
                    <svg class="icon-md">
                      <use href="${
                        window.jsObject.spritesheet_url
                      }#pg-relay"></use>
                    </svg>
                    <span class="one-rem">
                      ${this.translations.challenges}
                    </span>
                  </nav-link>
                  <nav-link href="/dashboard/activity" class="profile-link">
                    <svg class="icon-md">
                      <use href="${
                        window.jsObject.spritesheet_url
                      }#pg-prayer"></use>
                    </svg>
                    <span class="one-rem">${this.translations.prayers}</span>
                  </nav-link>
                  <nav-link href="/dashboard/settings" class="profile-link">
                    <svg class="icon-md">
                      <use href="${
                        window.jsObject.spritesheet_url
                      }#pg-settings"></use>
                    </svg>
                    <span class="one-rem">${this.translations.profile}</span>
                  </nav-link>
                </div>
              </section>
              <hr>
              <a class="btn btn-cta mx-2 two-rem" href="/newest/lap/">
                ${this.translations.start_praying}
              </a>
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
