import { fdatasync } from "fs";
import { css, html, LitElement } from "lit";
import { customElement, property } from "lit/decorators.js";

@customElement("pg-modal")
class PgModal extends LitElement {
  @property({ type: Boolean })
  open: boolean = false;

  private modalId: string = this.generateId();

  static styles = [
    css`
      :root {
        font-size: 18px;
      }
      .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #00000055;
        z-index: 1000;

        opacity: 0;
        display: none;
      }
      .modal.show {
        display: block;
        opacity: 1;
      }
      .modal-dialog {
        max-width: 500px;
        margin: 1rem auto;
        width: auto;
        pointer-events: none;
      }
      .modal-content {
        pointer-events: auto;
        background-color: white;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        width: 100%;
      }
      .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid var(--pg-grey);
      }
      .modal-title {
        line-height: 1;
        margin: 0;
      }
      .modal-body {
        padding: 1rem;
      }
      .modal-footer {
        padding: 1rem;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
      }
      .btn-close {
        display: flex;
        font-size: inherit;
        background: none;
        border: none;
      }
    `,
  ];

  private generateId(): string {
    return Array(6)
      .fill("")
      .map(() => String.fromCharCode(97 + Math.floor(Math.random() * 26)))
      .join("");
  }

  render() {
    return html`
      <div
        class="modal fade ${this.open ? "show" : ""}"
        id=${this.modalId + "_modal"}
        tabindex="-1"
        aria-labelledby=${this.modalId + "_label"}
        aria-hidden=${this.open ? "false" : "true"}
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id=${this.modalId + "_label"}>
                <slot name="title"></slot>
              </h5>
              <button
                type="button"
                class="btn-close"
                aria-label="Close"
                @click=${() => this.close()}
              >
                <slot name="close-icon"></slot>
              </button>
            </div>
            <div class="modal-body">
              <slot name="body"></slot>
            </div>
            <div class="modal-footer">
              <slot name="footer"></slot>
            </div>
          </div>
        </div>
      </div>
    `;
  }
  close() {
    this.dispatchEvent(new CustomEvent("close"));
  }
}

declare global {
  interface HTMLElementTagNameMap {
    "pg-modal": PgModal;
  }
}
