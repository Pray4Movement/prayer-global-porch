import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { User, Badge } from "../interfaces";

@customElement("pg-badge-item")
export class PgBadgeItem extends OpenElement {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  @property({ type: String }) badgeId: string = "";
  @property({ type: Object, attribute: false }) badge: Badge = {} as Badge;

  connectedCallback() {
    super.connectedCallback();

    const badges = window.jsObject.available_badges;
    this.badge = badges.find((badge: Badge) => badge.id === this.badgeId);
  }


  render() {
    return html`
        <pg-header
            backUrl="/dashboard/activity"
            title=${this.badge.title}
        ></pg-header>

      <div class="brand-bg white page px-3">
        <div class="pg-container stack-md" data-grid data-small>
            <img src="${this.badge.image}" alt="${this.badge.title}" />
            <div>${this.badge.title}</div>
            <div>${this.badge.description}</div>
        </div>
      </div>
    `;
  }
}
