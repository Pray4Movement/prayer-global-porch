import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { User, Badge, ProgressionBadge } from "../interfaces";

@customElement("pg-badge-item")
export class PgBadgeItem extends OpenElement {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  spritesheetUrl: string = window.jsObject.spritesheet_url;
  sliderElement: HTMLElement | null = null;
  lastScrollLeft: number = 0;
  scrollTimeout: NodeJS.Timeout | null = null;
  lastEarnedBadgeIndex: number = 0;

  @property({ type: String }) badgeId: string = "";
  @property({ type: Object, attribute: false }) badge: Badge = {} as Badge;
  @property({ type: Number, attribute: false }) currentBadgeIndex: number = 0;
  @property({ type: Object, attribute: false }) currentBadge: Badge = {} as Badge;

  constructor() {
    super();
    window.scrollTo(0, 0);
  }

  connectedCallback() {
    super.connectedCallback();

    const badges = window.jsObject.available_badges;
    this.badge = badges.find((badge: Badge) => badge.id === this.badgeId);
    this.currentBadge = this.badge;

  }

  firstUpdated() {
    if (this.badge.type !== 'progression') {
      return;
    }
    const slides = this.renderRoot.querySelector('.badge-slides') as HTMLElement;
    if (slides) {
      this.sliderElement = slides;
      let firstUnearnedBadge : Badge | null = null;
      this.lastEarnedBadgeIndex = 0;
      for (const badge of this.badge.progression_badges) {
        if (badge.has_earned_badge) {
          this.lastEarnedBadgeIndex = this.lastEarnedBadgeIndex + 1;
        } else {
          firstUnearnedBadge = badge;
          break;
        }
      }
      console.log(this.lastEarnedBadgeIndex);
      this.slideToBadge(firstUnearnedBadge);
    }
  }

  getImageUrl(badge: Badge) {
      if (badge.has_earned_badge) {
          return badge.image;
      }
      return badge.bw_image;
  }

  onSliderScroll(event: Event) {
    if (this.badge.type !== 'progression') {
      return;
    }
    if (!this.sliderElement) {
      return;
    }

    // we want to calculate the speed that the slider is scrolling at.
    const timeSpan = 5;
    const threshold = 0.01;
    this.scrollTimeout = setTimeout(() => {
      if (!this.sliderElement) {
        return;
      }
      const speed = Math.abs((this.sliderElement.scrollLeft - this.lastScrollLeft) * ( timeSpan / 1000 ));
      this.lastScrollLeft = this.sliderElement.scrollLeft;

      if (speed < threshold) {
        this.setCurrentBadge();
      }
    }, timeSpan);
  }

  onSliderScrollEnd(event: Event) {
    if (this.scrollTimeout) {
      clearTimeout(this.scrollTimeout);
    }
    this.setCurrentBadge();
  }

  slideToBadge(badge: Badge | null) {
    if (this.badge.type !== 'progression') {
      return;
    }
    if (!this.sliderElement) {
      return;
    }
    if (!badge) {
      return;
    }
    this.sliderElement.scrollTo({
      left: this.sliderElement.scrollWidth * (this.badge.progression_badges.indexOf(badge) / (this.badge.progression_badges.length + 1)),
    });
  }

  slideToIndex(index: number) {
    if (this.badge.type !== 'progression') {
      return;
    }
    this.slideToBadge(this.badge.progression_badges[index]);
  }

  setCurrentBadge() {
    if (this.badge.type !== 'progression') {
      return;
    }
    if (!this.sliderElement) {
      return;
    }

    this.currentBadgeIndex = Math.round(this.sliderElement.scrollLeft / this.sliderElement.scrollWidth * (this.badge.progression_badges.length + 1))
    this.currentBadge = this.badge.progression_badges[this.currentBadgeIndex];
  }

  render() {
    return html`
        <pg-header
            backUrl="/dashboard/badges"
            title=${this.badge.title}
        ></pg-header>

      <div class="brand-bg white page px-3 text-center">
        <div class="pg-container stack-sm badge-item" data-grid data-small>

          <div class="badge-item__timestamp" ?data-empty=${!this.currentBadge.timestamp}>
            Earned ${this.currentBadge.timestamp ? `${new Intl.DateTimeFormat().format(this.currentBadge.timestamp * 1000)}` : ''}
          </div>

            ${this.badge.type !== 'progression' ? html`
              <div class="center">
                <div class="badge-image-wrapper two-rem">
                  <img src="${this.getImageUrl(this.badge)}" alt="${this.badge.title}" />
                  ${this.badge.type === 'multiple' && this.badge.no_times_earned > 1 ? html`
                      <div class="badge-times-earned">x${this.badge.no_times_earned}</div>
                  ` : ''}
                </div>
              </div>
            ` : ''}
        </div>

        ${this.badge.type === 'progression' ? html`
          <div class="badge-slider">
              <div class="badge-slides" @scrollend=${this.onSliderScrollEnd} @scroll=${this.onSliderScroll}>
                <div class="badge-buffer"></div>
                ${this.badge.progression_badges.map((badge, index) => html`
                  <div class="badge-slide ${index === this.currentBadgeIndex ? 'active' : ''}">
                    <img src="${this.getImageUrl(badge)}" alt="${this.badge.title}" />
                  </div>
                `)}
                <div class="badge-buffer"></div>
              </div>
          </div>
          <div class="repel">
            <button
              class="badge-item__progression-button"
              @click=${() => this.slideToIndex(this.currentBadgeIndex - 1)}
            >
              <svg class="white icon-sm">
                <use href="${this.spritesheetUrl}#pg-chevron-left"></use>
              </svg>
            </button>
            <button
              class="badge-item__progression-button"
              @click=${() => this.slideToIndex(this.currentBadgeIndex + 1)}
            >
              <svg class="white icon-sm">
                <use href="${this.spritesheetUrl}#pg-chevron-right"></use>
              </svg>
            </button>
          </div>
        ` : ''}

        <div class="pg-container stack-sm badge-item" data-grid data-small>
            <div class="badge-item__title">${this.currentBadge.title}</div>
            ${this.currentBadge.has_earned_badge ? html`
                <div class="badge-item__description">${this.currentBadge.description_earned}</div>
            ` : html`
                <div class="badge-item__description">${this.currentBadge.description_unearned}</div>
            `}
            ${
                this.badge.type === 'progression' &&
                this.badge.progression_value &&
                !this.currentBadge.has_earned_badge &&
                this.currentBadgeIndex < this.lastEarnedBadgeIndex + 2
                  ? html`
                    <div>
                      <div class="d-flex align-items-center gap-2 justify-content-center brand-highlight">
                        <div class="progress-bar" data-small>
                            <div class="progress-bar__slider blue-highlight-bg" style="width: ${this.badge.progression_value / this.currentBadge.value * 100}%"></div>
                        </div>
                        <span class="progress-bar__text">${this.badge.progression_value}/${this.currentBadge.value}</span>
                      </div>
                    </div>
                ` : ''
            }
        </div>
      </div>
    `;
  }
}
