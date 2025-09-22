import { html } from "lit";
import { customElement } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { User, Badge } from "../interfaces";
import { navigator } from "lit-element-router";

@customElement("pg-activity")
export class PgActivity extends navigator(OpenElement) {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;

  navigateToBadges(e: Event) {
    e.preventDefault();
    this.navigate("/dashboard/badges");
  }

  render() {
    return html`
      <pg-header
        backUrl="/dashboard"
        title=${this.translations.prayer_activity}
      ></pg-header>

      <div class="brand-bg white page px-3">
        <div class="pg-container stack-md" data-grid data-small>
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
                <span class="f-lg font-weight-bold"
                  >${window.jsObject.stats.current_streak_in_days}</span
                >
              </div>
              <div class="cluster | s-sm">
                <svg class="brand-highlight icon-md">
                  <use
                    href="${window.jsObject.spritesheet_url}#pg-streak"
                  ></use>
                </svg>
                <span class="fs-3 brand-highlight"
                  >${window.jsObject.stats.best_streak_in_days}
                  ${this.translations.best}</span
                >
              </div>
            </section>
            <section class="stack-sm activity-card lh-xsm">
              <h3 class="activity-card__title">
                ${this.translations.weeks_in_a_row}
              </h3>
              <span class="f-lg font-weight-bold"
                >${window.jsObject.stats.current_streak_in_weeks}</span
              >
              <h3 class="activity-card__title">
                ${this.translations.days_this_year}
              </h3>
              <span class="f-lg font-weight-bold"
                >${window.jsObject.stats.days_this_year}</span
              >
            </section>
          </div>

          <section class="prayer-milestones">
            <div>
              <h3 class="prayer-milestones__title">
                ${this.translations.prayer_milestones}
              </h3>
              <a href="dashboard/badges" @click=${this.navigateToBadges}>
                ${this.translations.see_all}
              </a>
            </div>
            <div class="prayer-milestones__list">
              ${window.jsObject.available_badges.map((badge: Badge) => {
                return html`
                  <div class="prayer-milestone">
                    <img src="${badge.image}" alt="${badge.title}" />
                    ${badge.title}
                  </div>
                `;
              })}
            </div>
          </section>

          <section class="activity-card">
            <table class="activity-table mx-auto">
              <tr>
                <td>${window.jsObject.stats.total_minutes_prayed}</td>
                <td>${this.translations.minutes_prayed}</td>
              </tr>
              <tr>
                <td>${window.jsObject.stats.total_places_prayed}</td>
                <td>${this.translations.places_prayed_for}</td>
              </tr>
              <tr>
                <td>${window.jsObject.stats.total_relays_part_of}</td>
                <td>${this.translations.active_laps}</td>
              </tr>
              <tr>
                <td>${window.jsObject.stats.total_finished_relays_part_of}</td>
                <td>${this.translations.finished_laps}</td>
              </tr>
            </table>
          </section>
          <a class="btn btn-cta btn-lg w-fit mx-auto" href="/newest/lap">
            ${this.translations.start_praying}
          </a>
        </div>
      </div>
    `;
  }
}
