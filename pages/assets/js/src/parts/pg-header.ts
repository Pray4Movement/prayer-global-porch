import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { OpenElement } from "../profile-pages/open-element";

@customElement("pg-header")
export class PgHeader extends OpenElement {
  @property({ type: String })
  title: string = "";

  render() {
    return html`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${() => history.back()}>
          <svg class="icon-md">
            <use
              href="${window.jsObject.spritesheet_url}#pg-chevron-left"
            ></use>
          </svg>
        </button>
        <h3 class="mb-0 me-auto">${this.title}</h3>
      </div>
    `;
  }
}

declare global {
  interface HTMLElementTagNameMap {
    "pg-header": PgHeader;
  }
}
