import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { OpenElement } from "../profile-pages/open-element";
import { RelayVisibility, RelayType } from "../interfaces";

@customElement("pg-relay-item")
export class PgRelayItem extends OpenElement {
  @property({ type: String })
  name: string = "";

  @property({ type: Number })
  lapNumber: number = 0;

  @property({ type: Number })
  progress: number = 0;

  @property({ type: Object })
  translations: any = {};

  @property({ type: String })
  spritesheetUrl: string = "";

  @property({ type: String })
  relayType: RelayType = "global";

  @property({ type: String })
  visibility: RelayVisibility = "public";

  @property({ type: String })
  urlRoot: string = "";

  @property({ type: Boolean })
  hiddenRelay: boolean = false;

  token = "";

  override connectedCallback() {
    super.connectedCallback();
    this.token = this.name.replace(/\s+/g, "-");
  }

  private renderIcon() {
    const iconMap = {
      global: "pg-logo-prayer",
      custom: this.visibility === "private" ? "pg-private" : "pg-world-light",
    };
    const iconName = iconMap[this.relayType] || "pg-logo-prayer";

    return html`
      <svg>
        <use href="${this.spritesheetUrl}#${iconName}"></use>
      </svg>
    `;
  }

  render() {
    const displayType =
      this.relayType === "custom" ? this.visibility : this.relayType;
    return html`
      <div
        role="listitem"
        class="relay-item"
        data-type=${displayType}
        ?data-hidden=${this.hiddenRelay}
      >
        <div class="relay-item__container">
          <div class="stack-sm relay-item__info">
            <span class="relay-item__name">${this.name}</span>
            <span class="relay-item__lap"
              >${this.translations.lap} ${this.lapNumber}</span
            >
            <div class="progress-bar" data-small>
              <div
                class="progress-bar__slider orange-bg"
                style="width: ${this.progress}%"
              ></div>
            </div>
          </div>
          <div
            class="relay-item__center-icon"
            data-size=${this.relayType === "global" ? "large" : "medium"}
          >
            ${this.renderIcon()}
          </div>
          <div class="stack-sm relay-item__actions">
            <button
              class="dropdown-toggle"
              data-bs-toggle="dropdown"
              data-bs-auto-close="true"
              aria-expanded="false"
              id="relay-item-actions-${this.token}"
            >
              <svg class="white icon-sm">
                <use
                  href="${this.spritesheetUrl}#ion-ellipsis-horizontal"
                ></use>
              </svg>
            </button>
            <ul
              class="dropdown-menu"
              aria-labelledby="relay-item-actions-${this.token}"
            >
              <li>
                <a class="dropdown-item" href="${this.urlRoot}/map">
                  ${this.translations.map}
                </a>
              </li>
              ${this.relayType === "custom"
                ? html`
                    <li>
                      <a class="dropdown-item" href="${this.urlRoot}/tools">
                        ${this.translations.share}
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="${this.urlRoot}/display">
                        ${this.translations.display}
                      </a>
                    </li>
                    <li class="dropdown-item">${this.translations.edit}</li>
                  `
                : ""}
              ${this.hiddenRelay
                ? html`
                    <li
                      class="dropdown-item"
                      @click=${() =>
                        this.dispatchEvent(new CustomEvent("unhide"))}
                    >
                      ${this.translations.unhide}
                    </li>
                  `
                : html`
                    <li
                      class="dropdown-item"
                      @click=${() =>
                        this.dispatchEvent(new CustomEvent("hide"))}
                    >
                      ${this.translations.hide}
                    </li>
                  `}
            </ul>
            <a href=${this.urlRoot} class="btn btn-cta"
              >${this.translations.pray}</a
            >
          </div>
        </div>
      </div>
    `;
  }
}

declare global {
  interface HTMLElementTagNameMap {
    "pg-relay-item": PgRelayItem;
  }
}
