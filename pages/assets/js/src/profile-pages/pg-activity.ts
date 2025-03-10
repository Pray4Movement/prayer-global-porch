import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { PageBase } from "./page-base";
import { User } from "../interfaces";

@customElement("pg-activity")
export class PgActivity extends PageBase {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;

  render() {
    return html`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${() => history.back()}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.prayer_activity}</h3>
      </div>

      <div class="brand-bg white">
        <div class="container-md stack-md page px-3">
          <h2 class="text-center fs-3 font-base">
            ${this.translations.strengthen_text}
          </h2>

          <div class="switcher">
            <section class="stack-sm | activity-card lh-xsm">
              <h3 class="activity-card__title">
                ${this.translations.daily_streak}
              </h3>
              <div class="cluster">
                <div
                  class="orange-gradient icon-xlg"
                  style="mask:url('${window.jsObject
                    .icons_url}/pg-streak.svg') no-repeat 0 0/100% 100%;"
                ></div>
                <span class="f-lg font-weight-bold">30</span>
              </div>
              <div class="cluster | s-sm">
                <svg class="brand-highlight icon-md">
                  <use
                    href="${window.jsObject.spritesheet_url}#pg-streak"
                  ></use>
                </svg>
                <span class="fs-3 brand-highlight">47 Best</span>
              </div>
            </section>
            <section class="stack-sm activity-card lh-xsm">
              <h3 class="activity-card__title">Weeks in a row</h3>
              <span class="f-lg font-weight-bold">4</span>
              <h3 class="activity-card__title">Days this year</h3>
              <span class="f-lg font-weight-bold">56</span>
            </section>
          </div>

          <section class="activity-table activity-card">
            <span>250</span>
            <span>Minutes prayed</span>
            <span>127</span>
            <span>Places prayed for</span>
            <span>3</span>
            <span>Active laps</span>
            <span>7</span>
            <span>Laps finished</span>
          </section>
          <a class="btn btn-cta btn-lg" href="/newest/lap">
            ${this.translations.start_praying}
          </a>
        </div>
      </div>
    `;
  }
}
