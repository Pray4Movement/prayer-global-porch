import { property, customElement } from 'lit/decorators.js';
import { Badge, MultipleBadge, ProgressionBadge } from '../interfaces';
import { html } from 'lit';
import { navigator } from 'lit-element-router';
import { OpenElement } from '../profile-pages/open-element';

@customElement('pg-badge')
export class PgBadge extends navigator(OpenElement) {
    lastEarnedBadgeIndex: number = 0;

    @property({ type: Object }) badge: Badge = {} as Badge;
    @property({ type: Number, attribute: false }) currentBadgeIndex: number = 0;
    @property({ type: Object, attribute: false }) currentBadge: Badge = {} as Badge;
    @property({ type: Array, attribute: false }) progressionBadges: Badge[] = [];

    connectedCallback() {
        super.connectedCallback();

        this.currentBadge = this.badge;
        if (this.badge.type === 'progression') {
            this.progressionBadges = Object.values(this.badge.progression_badges);
        }
    }

    firstUpdated() {
        if (this.badge.type === 'progression') {
            this.lastEarnedBadgeIndex = 0;
            for (const badge of this.progressionBadges) {
              if (badge.has_earned_badge) {
                this.lastEarnedBadgeIndex = this.lastEarnedBadgeIndex + 1;
              } else {
                this.currentBadge = badge;
                break;
              }
            }
        }
    }

    getImageUrl() {
        const badgeImage = this.badge.has_earned_badge ? this.badge.image : this.badge.bw_image;
        return `${window.jsObject.badges_url}/${badgeImage}`;
    }

    render() {
        return html`
            <div
                class="prayer-badge text-center"
                @click=${() => this.navigate(`/dashboard/badge/${this.badge.id}`)}
            >
                <div class="badge-image-wrapper">
                    <img src="${this.getImageUrl()}" alt="${this.badge.title}" />
                    ${this.badge.type === 'multiple' && this.badge.num_times_earned > 1 ? html`
                        <div class="badge-times-earned">x${this.badge.num_times_earned}</div>
                    ` : ''}
                </div>
                <span>${this.badge.title}</span>
                ${
                    (
                      (
                        this.badge.type === 'progression' &&
                        !this.currentBadge.has_earned_badge
                      ) || (
                        this.badge.type === 'challenge' &&
                        !this.badge.has_earned_badge
                      )
                    ) ? html`
                        <div class="brand-highlight w-100">
                            <div class="progress-bar" data-small>
                                <div class="progress-bar__slider blue-highlight-bg" style="width: ${this.badge.progression_value / this.currentBadge.value * 100}%"></div>
                            </div>
                        </div>
                    ` : ''
                }

            </div>
        `;
    }
}
