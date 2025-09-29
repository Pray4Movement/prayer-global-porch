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

  getImageUrl() {
      if (this.badge.has_earned_badge) {
          return this.badge.image;
      }
      return this.badge.bw_image;
  }

  render() {
    return html`
        <pg-header
            backUrl="/dashboard/badges"
            title=${this.badge.title}
        ></pg-header>

      <div class="brand-bg white page px-3 text-center">
        <div class="pg-container stack-sm badge-item" data-grid data-small>
            ${
                this.badge.timestamp ? html`
                    <div class="badge-item__timestamp">Earned ${new Intl.DateTimeFormat().format(this.badge.timestamp * 1000)}</div>
                ` : ''
            }
            <div class="center">
              <div class="badge-image-wrapper two-rem">
                <img src="${this.getImageUrl()}" alt="${this.badge.title}" />
                ${this.badge.type === 'multiple' && this.badge.no_times_earned ? html`
                    <div class="badge-times-earned">x${this.badge.no_times_earned}</div>
                ` : ''}
              </div>
            </div>
            <div class="badge-item__title">${this.badge.title}</div>
            ${this.badge.has_earned_badge ? html`
                <div class="badge-item__description">${this.badge.description_earned}</div>
            ` : html`
                <div class="badge-item__description">${this.badge.description_unearned}</div>
            `}
            ${
                this.badge.type === 'progression' && this.badge.progression_value ? html`
                    <div>
                      <div class="d-flex align-items-center gap-2 justify-content-center brand-highlight">
                        <div class="progress-bar" data-small>
                            <div class="progress-bar__slider blue-highlight-bg" style="width: ${this.badge.progression_value / this.badge.value * 100}%"></div>
                        </div>
                        <span class="progress-bar__text">${this.badge.progression_value}/${this.badge.value}</span>
                      </div>
                    </div>
                ` : ''
            }
        </div>
      </div>
    `;
  }
}
