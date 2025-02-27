import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { PageBase } from "./page-base";
import { navigator } from "lit-element-router";

interface User {
  display_name: string;
  location: Location;
}

interface Location {
  source: string;
  label: string;
}

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
      <div class="container">
        <div class="row justify-content-md-center text-center">
          <div class="flow" id="pg_content">
            <div class="flow-medium">
              <section class="user__summary flow-small">
                <div class="user__avatar">
                  <span class="user__badge"></span>
                </div>

                <div class="user__info">
                  <h2 class="user__full-name font-base uppercase">
                    ${this.user.display_name}
                  </h2>
                  <div class="user__location flow-small">
                    <span class="user__location-label"
                      >${(this.user.location && this.user.location.label) ||
                      `<span class="loading-spinner active"></span>`}</span
                    >
                    <button>Edit</button>
                    <span
                      class="iplocation-message small d-block text-secondary"
                    >
                      ${this.user.location && this.user.location.source === "ip"
                        ? this.translations.estimated_location
                        : ""}
                    </span>
                  </div>
                </div>
              </section>
              <section class="profile-menu px-2 mt-5">
                <div class="navbar-nav w-fit mx-auto">
                  <a
                    class="user-challenges-link nav-link uppercase px-1 py-4 d-flex justify-content-between align-items-center border-bottom border-1 border-dark"
                    href="/profile/prayer-relays"
                    @click=${(e: Event) => this.navigateToHref(e)}
                  >
                    <i class="icon pg-relay three-em"></i>
                    <span class="two-em px-3"
                      >${this.translations.challenges}</span
                    >
                    <i class="icon pg-chevron-right three-em"></i>
                  </a>
                  <a
                    class="user-prayers-link nav-link uppercase px-1 py-4 d-flex justify-content-between align-items-center border-bottom border-1 border-dark"
                    href="/profile/prayer-activity"
                    @click=${(e: Event) => this.navigateToHref(e)}
                  >
                    <i class="icon pg-prayer three-em"></i>
                    <span class="two-em">${this.translations.prayers}</span>
                    <i class="icon pg-chevron-right three-em"></i>
                  </a>
                  <a
                    class="user-profile-link nav-link uppercase px-1 py-4 d-flex justify-content-between align-items-center border-bottom border-top border-1 border-dark"
                    href="/profile/profile-settings"
                    @click=${(e: Event) => this.navigateToHref(e)}
                  >
                    <i class="icon pg-profile three-em"></i>
                    <span class="two-em">${this.translations.profile}</span>
                    <i class="icon pg-chevron-right three-em"></i>
                  </a>
                </div>
              </section>
              <section>
                <p>${this.translations.are_you_enjoying_the_app}</p>
                <p>${this.translations.would_you_like_to_partner}</p>
                <div class="d-flex flex-column m-auto w-fit">
                  <a
                    class="btn btn-small btn-primary-light uppercase"
                    data-reverse-color
                    href="/give"
                    target="_blank"
                    >${this.translations.give} <i class="ion-android-open"></i
                  ></a>
                  <a
                    class="btn btn-small btn-outline-primary mt-3 uppercase"
                    href="/user_app/logout"
                    >${this.translations.logout}</a
                  ><br />
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    `;
  }
}
