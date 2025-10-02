import { html } from "lit";
import { customElement, state } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { User, Badge } from "../interfaces";
import { navigator } from "lit-element-router";

@customElement("pg-badges")
export class PgBadges extends navigator(OpenElement) {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  badges: Badge[] = window.jsObject.available_badges;

  constructor() {
    super();
    window.scrollTo(0, 0);
  }

  connectedCallback() {
    super.connectedCallback();
    this.badges.sort((a, b) => a.priority - b.priority);
    this.badges.sort((a, b) => {
      if (a.has_earned_badge && !b.has_earned_badge) {
        return -1;
      }
      if (!a.has_earned_badge && b.has_earned_badge) {
        return 1;
      }
      return 0;
    });
    this.badges = this.badges.filter((badge) => {
      if (badge.hidden && !badge.has_earned_badge) {
        return false;
      }
      return true;
    });
    console.log(this.badges);
  }

  render() {
    return html`
        <pg-header
            backUrl="/dashboard/activity"
            title=${this.translations.prayer_milestones}
        ></pg-header>

      <div class="brand-bg white page px-3">
        <div class="pg-container grid" data-grid data-small>
            ${this.badges.map((badge) => {
              return html`
                <pg-badge .badge=${badge}></pg-badge>
              `;
            })}
        </div>
      </div>
    `;
  }
}
