import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { OpenElement } from "../profile-pages/open-element";
import { navigator } from "lit-element-router";

@customElement("pg-header")
export class PgHeader extends navigator(OpenElement) {
  @property({ type: String })
  title: string = "";

  @property({ type: String })
  backUrl: string = "";

  render() {
    return html`
      <div class="offcanvas__header lh-sm">
        <div class="container d-flex align-items-center">
          <button
            type="button"
            class="me-auto"
            @click=${() => this.navigate(this.backUrl)}
          >
            <svg class="icon-md">
              <use
                href="${window.jsObject.spritesheet_url}#pg-chevron-left"
              ></use>
            </svg>
          </button>
          <h3 class="mb-0 me-auto">${this.title}</h3>
        </div>
      </div>
    `;
  }
}

declare global {
  interface HTMLElementTagNameMap {
    "pg-header": PgHeader;
  }
}
