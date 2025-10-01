import { property, customElement } from 'lit/decorators.js';
import { Badge, MultipleBadge, ProgressionBadge } from '../interfaces';
import { html } from 'lit';
import { navigator } from 'lit-element-router';
import { OpenElement } from '../profile-pages/open-element';

@customElement('pg-badge')
export class PgBadge extends navigator(OpenElement) {
    @property({ type: Object }) badge: Badge = {} as Badge;

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
            </div>
        `;
    }
}
