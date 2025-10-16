import { html } from "lit";
import { customElement, property, state } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { User, Badge } from "../interfaces";
import { navigator } from "lit-element-router";

@customElement("pg-badges")
export class PgBadges extends navigator(OpenElement) {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  badges: Badge[] = window.jsObject.available_badges;
  @property({ type: Array, attribute: false }) earnedBadges: Badge[] = [];
  @property({ type: Array, attribute: false }) unearnedBadges: Badge[] = [];

  constructor() {
    super();
    window.scrollTo(0, 0);
  }

  connectedCallback() {
    super.connectedCallback();
    this.sortBadges();
    this.splitBadges();
  }

  sortBadges() {
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
  }

  splitBadges() {
    this.earnedBadges = this.badges.filter((badge) => badge.has_earned_badge);
    this.unearnedBadges = this.badges.filter((badge) => !badge.has_earned_badge);
    this.earnedBadges.sort((a, b) => a.priority - b.priority);
    this.unearnedBadges.sort((a, b) => a.priority - b.priority);
  }

  render() {
    return html`
        <pg-header
            backUrl="/dashboard/activity"
            title=${this.translations.prayer_milestones}
        ></pg-header>

      <div class="brand-bg white page px-3">
        <div class="pg-container flow-medium">
          <div class="grid" data-grid data-small>
              ${this.earnedBadges.map((badge) => {
                return html`
                  <pg-badge .badge=${badge}></pg-badge>
                `;
              })}
              ${this.unearnedBadges.map((badge) => {
                return html`
                  <pg-badge .badge=${badge}></pg-badge>
                `;
              })}
          </div>
        </div>
      </div>
    `;
  }
}
