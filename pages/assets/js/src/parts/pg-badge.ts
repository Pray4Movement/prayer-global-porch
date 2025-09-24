import { LitElement } from 'lit';
import { property, customElement } from 'lit/decorators.js';
import { Badge } from '../interfaces';
import { html } from 'lit';

@customElement('pg-badge')
export class PgBadge extends LitElement {
    @property({ type: Object }) badge: Badge = {} as Badge;

    render() {
        return html`
            <img src="${this.badge.image}" alt="${this.badge.title}" />
        `;
    }
}
