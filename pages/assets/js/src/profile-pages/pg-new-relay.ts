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
  @state()
  openInfo: string = "";

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

  private async handleOpenInfo(event: Event, type: string) {
    event.stopImmediatePropagation();
    if (this.openInfo !== type) {
      this.openInfo = type;
    } else {
      this.openInfo = "";
    }
  }

  private handleNavigate() {
    location.href = "/relays";
  }

  render() {
    return html`
      <pg-header
        backUrl="/dashboard/relays"
        title=${this.translations.new_relay}
      ></pg-header>
      <div class="pg-container page" data-small>
        ${this.step === "choose-option"
          ? html`
              <div class="seperated-list mx-auto align-items-start">
                <div
                  class="stack-sm align-items-stretch text-center px-2 py-4 w-100"
                >
                  <div
                    class="profile-link"
                    role="button"
                    @click=${this.handleNavigate}
                  >
                    <svg class="icon-md">
                      <use
                        href="${window.jsObject.spritesheet_url}#pg-relay"
                      ></use>
                    </svg>
                    <span>${this.translations.join_a_relay}</span>
                    <button
                      class="ms-auto d-inline-block p-2"
                      @click=${(event: Event) =>
                        this.handleOpenInfo(event, "join")}
                    >
                      <svg class="icon-sm">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-info"
                        ></use>
                      </svg>
                    </button>
                  </div>
                  ${this.openInfo === "join"
                    ? html`
                        <p class="info-text">
                          ${this.translations.join_a_relay_info}
                        </p>
                      `
                    : ""}
                </div>
                <div
                  class="stack-sm align-items-stretch text-center px-2 py-4 w-100"
                >
                  <div
                    class="profile-link"
                    role="button"
                    @click=${() => this.createRelay("public")}
                  >
                    <svg class="icon-md">
                      <use
                        href="${window.jsObject.spritesheet_url}#pg-world-light"
                      ></use>
                    </svg>
                    <span>${this.translations.new_public_relay}</span>
                    <button
                      class="ms-auto d-inline-block p-2"
                      @click=${(event: Event) =>
                        this.handleOpenInfo(event, "create-public")}
                    >
                      <svg class="icon-sm">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-info"
                        ></use>
                      </svg>
                    </button>
                  </div>
                  ${this.openInfo === "create-public"
                    ? html`
                        <p class="info-text">
                          ${this.translations.create_public_relay_info}
                        </p>
                      `
                    : ""}
                </div>
                <div
                  class="stack-sm align-items-stretch text-center px-2 py-4 w-100"
                >
                  <div
                    class="profile-link"
                    role="button"
                    @click=${() => this.createRelay("private")}
                  >
                    <svg class="icon-md">
                      <use
                        href="${window.jsObject.spritesheet_url}#pg-private"
                      ></use>
                    </svg>
                    <span>${this.translations.new_private_relay}</span>
                    <button
                      class="ms-auto d-inline-block p-2"
                      @click=${(event: Event) =>
                        this.handleOpenInfo(event, "create-private")}
                    >
                      <svg class="icon-sm">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-info"
                        ></use>
                      </svg>
                    </button>
                  </div>
                  ${this.openInfo === "create-private"
                    ? html`
                        <p class="info-text">
                          ${this.translations.create_private_relay_info}
                        </p>
                      `
                    : ""}
                </div>
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
