import { property, customElement } from 'lit/decorators.js';
import { Badge } from '../interfaces';
import { html } from 'lit';
import { navigator } from 'lit-element-router';
import { OpenElement } from '../profile-pages/open-element';

@customElement('pg-badge')
export class PgBadge extends navigator(OpenElement) {
    @property({ type: Object }) badge: Badge = {} as Badge;

    getImageUrl() {
        if (this.badge.has_badge) {
            return this.badge.image;
        }
        return this.badge.bw_image;
    }

    render() {
        return html`
            <div
                class="prayer-milestone text-center"
                @click=${() => this.navigate(`/dashboard/badge/${this.badge.id}`)}
            >
                <img src="${this.badge.image}" alt="${this.badge.title}" />
                <span>${this.badge.title}</span>
            </div>
        `;
    }
}
