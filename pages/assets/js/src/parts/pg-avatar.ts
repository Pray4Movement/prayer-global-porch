import { LitElement, html, css } from "lit";
import { customElement, property } from "lit/decorators.js";

@customElement("pg-avatar")
export class PgAvatar extends LitElement {
  static styles = [
    css`
      :host {
        display: block;
      }
      .circle {
        position: relative;
        border-radius: 1000px;
        aspect-ratio: 1;
        padding: 0.3em;
        background-color: var(--pg-avatar-bg-color, #ccc);
        color: inherit;
        text-align: center;
        font-family: var(--pg-font-family-title);
        font-size: inherit;

        display: flex;
        justify-content: center;
        align-items: center;
        line-height: 1;
      }
    `,
  ];

  @property({ type: String })
  text: string = "";

  getInitials(text: string) {
    return text
      .split(" ")
      .map((name: string) => name[0])
      .join("")
      .toUpperCase()
      .slice(0, 2);
  }
  render() {
    return html`
      <div class="circle">
        <div>${this.getInitials(this.text)}</div>
      </div>
    `;
  }
}

declare global {
  interface HTMLElementTagNameMap {
    "pg-avatar": PgAvatar;
  }
}
