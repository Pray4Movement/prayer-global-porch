import { html, LitElement, css } from "lit";
import { customElement, property } from "lit/decorators.js";
import { navigator } from "lit-element-router";

@customElement("nav-link")
export class NavLink extends navigator(LitElement) {
  static styles = css`
    :host {
      cursor: pointer;
    }
    a {
      color: inherit;
      text-decoration: inherit;
    }
    a:hover {
      text-decoration: underline;
    }
  `;

  @property({ type: String }) href = "";

  constructor() {
    super();
    this.setAttribute("tabindex", "0");
    this.setAttribute("role", "link");

    this.addEventListener("click", this.handleClick);
    this.addEventListener("keydown", this.handleKeydown);
  }
  private handleClick(event: Event) {
    event.preventDefault();
    const { href } = event.currentTarget as HTMLAnchorElement;
    this.navigate(href);
  }

  private handleKeydown(event: KeyboardEvent) {
    if (event.key === "Enter" || event.key === " ") {
      event.preventDefault();
      this.navigate(this.href);
    }
  }

  render() {
    return html` <slot></slot> `;
  }
}
