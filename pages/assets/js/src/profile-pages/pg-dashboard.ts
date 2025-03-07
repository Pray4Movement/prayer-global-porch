import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { PageBase } from "./page-base";
import { navigator } from "lit-element-router";
import { User } from "../interfaces";

@customElement("pg-dashboard")
export class PgDashboard extends navigator(PageBase) {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;

  navigateToHref(event: Event) {
    event.preventDefault();
    const { href } = event.currentTarget as HTMLAnchorElement;
    this.navigate(href);
  }

  render() {
    return html`
      <div class="container-md page">
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
                  <a
                    class="profile-link"
                    href="/profile/prayer-relays"
                    @click=${(e: Event) => this.navigateToHref(e)}
                  >
                    <svg class="icon-md">
                      <use href="${
                        window.jsObject.spritesheet_url
                      }#pg-relay"></use>
                    </svg>
                    <span class="one-rem">
                      ${this.translations.challenges}
                    </span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/prayer-activity"
                    @click=${(e: Event) => this.navigateToHref(e)}
                  >
                    <svg class="icon-md">
                      <use href="${
                        window.jsObject.spritesheet_url
                      }#pg-prayer"></use>
                    </svg>
                    <span class="one-rem">${this.translations.prayers}</span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/profile-settings"
                    @click=${(e: Event) => this.navigateToHref(e)}
                  >
                    <svg class="icon-md">
                      <use href="${
                        window.jsObject.spritesheet_url
                      }#pg-settings"></use>
                    </svg>
                    <span class="one-rem">${this.translations.profile}</span>
                  </a>
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
