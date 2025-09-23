import { html, PropertyValues, render } from "lit";
import { customElement, state } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { User, Badge } from "../interfaces";
import { navigator } from "lit-element-router";

@customElement("pg-badges")
export class PgBadges extends navigator(OpenElement) {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  badges: Badge[] = window.jsObject.available_badges;

  render() {
    return html`
        <pg-header
            backUrl="/dashboard/activity"
            title=${this.translations.prayer_milestones}
        ></pg-header>

      <div class="brand-bg white page px-3">
        <div class="pg-container stack-md" data-grid data-small>
            ${this.badges.map((badge) => {
              return html`
                <div @click=${() => this.navigate(`/dashboard/badge/${badge.id}`)}>${badge.title}</div>
              `;
            })}
        </div>
      </div>
    `;
  }
}