import { html } from "lit";
import { customElement, state } from "lit/decorators.js";
import { OpenElement } from "./open-element";

@customElement("pg-new-relay")
export class PgNewRelay extends OpenElement {
  translations: any = window.jsObject.translations;

  @state()
  step: string = "choose-option";
  @state()
  type: string = "";

  constructor() {
    super();
  }

  createRelay(type: string) {
    this.step = "new-relay";
    this.type = type;
  }

  onCancel() {
    this.step = "choose-option";
  }

  getIcon() {
    return `${window.jsObject.spritesheet_url}#${
      this.type === "public" ? "pg-world-light" : "pg-private"
    }`;
  }

  getTitle() {
    return this.type === "public"
      ? this.translations.create_public_relay
      : this.translations.create_private_relay;
  }

  render() {
    return html`
      <pg-header title=${this.translations.new_relay}></pg-header>
      <div class="pg-container page" data-small>
        ${this.step === "choose-option"
          ? html`
              <div class="seperated-list mx-auto w-fit align-items-start">
                <button
                  class="profile-link p-4"
                  @click=${() => (location.href = "/relays")}
                >
                  <svg class="icon-md">
                    <use
                      href="${window.jsObject.spritesheet_url}#pg-relay"
                    ></use>
                  </svg>
                  ${this.translations.join_a_relay}
                </button>
                <button
                  class="profile-link p-4"
                  @click=${() => this.createRelay("public")}
                >
                  <svg class="icon-md">
                    <use
                      href="${window.jsObject.spritesheet_url}#pg-world-light"
                    ></use>
                  </svg>
                  ${this.translations.new_public_relay}
                </button>
                <button
                  class="profile-link p-4"
                  @click=${() => this.createRelay("private")}
                >
                  <svg class="icon-md">
                    <use
                      href="${window.jsObject.spritesheet_url}#pg-private"
                    ></use>
                  </svg>
                  ${this.translations.new_private_relay}
                </button>
              </div>
            `
          : ""}
        ${this.step === "new-relay"
          ? html`
              <div class="stack-md align-items-start">
                <h5 class="cluster">
                  <svg class="icon-lg">
                    <use href=${this.getIcon()}></use>
                  </svg>
                  ${this.getTitle()}
                </h5>
                <pg-relay-form
                  class="w-100"
                  .type=${this.type}
                  @cancel=${this.onCancel}
                ></pg-relay-form>
              </div>
            `
          : ""}
      </div>
    `;
  }
}
