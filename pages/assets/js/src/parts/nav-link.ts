import { html, LitElement, css } from "lit";
import { customElement, property } from "lit/decorators.js";
import { navigator } from "lit-element-router";

@customElement("nav-link")
export class NavLink extends navigator(LitElement) {
  static styles = css`
    a {
      color: inherit;
      text-decoration: inherit;
    }
    a:hover {
      text-decoration: underline;
    }
  `;

  @property({ type: String }) href = "";

  private handleClick(event: Event) {
    event.preventDefault();
    const { href } = event.currentTarget as HTMLAnchorElement;
    this.navigate(href);
  }

  render() {
    return html`
      <a href="${this.href}" @click=${this.handleClick}>
        <slot></slot>
      </a>
    `;
  }
}
