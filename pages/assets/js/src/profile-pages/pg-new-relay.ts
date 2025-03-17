import { html } from "lit";
import { customElement, state } from "lit/decorators.js";
import { OpenElement } from "./open-element";

@customElement("pg-new-relay")
export class PgNewRelay extends OpenElement {
  translations: any = window.jsObject.translations;

  @state()
  saving: boolean = false;
  @state()
  step: string = "choose-option";
  @state()
  type: string = "";
  @state()
  title: string = "";

  constructor() {
    super();
  }

  createRelay(type: string) {
    this.step = "new-relay";
    this.type = type;
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

  handleChangeTitle(value: string) {
    this.title = value;
  }

  onSubmit(event: Event) {
    event.preventDefault();
    window
      .api_fetch(window.pg_global.root + "pg-api/v1/dashboard/create_relay", {
        method: "POST",
        body: JSON.stringify({ title: this.title, visibility: this.type }),
      })
      .then((data: any) => {
        window.location.href = "/dashboard/relays";
      });
  }

  onCancel() {
    this.step = "choose-option";
  }

  render() {
    return html`
      <pg-header title=${this.translations.new_relay}></pg-header>
      <div class="pg-container stack-md page">
        ${this.step === "choose-option"
          ? html`
              <div class="stack-md mx-auto w-fit align-items-start">
                <button
                  class="profile-link"
                  @click=${() => (location.href = "/dashboard/join-relay")}
                >
                  <svg class="icon-md">
                    <use
                      href="${window.jsObject.spritesheet_url}#pg-relay"
                    ></use>
                  </svg>
                  ${this.translations.join_a_relay}
                </button>
                <button
                  class="profile-link"
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
                  class="profile-link"
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
              <div class="stack-md mx-auto w-fit align-items-start">
                <h5 class="cluster">
                  <svg class="icon-lg">
                    <use href=${this.getIcon()}></use>
                  </svg>
                  ${this.getTitle()}
                </h5>
                <form class="stack-sm w-100">
                  <label for="title" class="w-100">
                    ${this.translations.title}
                    <input
                      type="text"
                      name="title"
                      id="title"
                      class="form-control"
                      placeholder=${this.translations.title}
                      @input=${(event: Event) =>
                        this.handleChangeTitle(
                          (event.target as HTMLInputElement).value
                        )}
                    />
                  </label>
                  <div class="cluster ms-auto">
                    <button
                      class="btn btn-outline-primayr btn-small"
                      @click=${this.onCancel}
                    >
                      ${this.translations.cancel}
                    </button>
                    <button
                      class="btn btn-primary btn-small"
                      @click=${this.onSubmit}
                    >
                      ${this.translations.create}
                    </button>
                  </div>
                </form>
              </div>
            `
          : ""}
      </div>
    `;
  }
}
