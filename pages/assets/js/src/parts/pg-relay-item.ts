import { html } from "lit";
import { customElement, property } from "lit/decorators.js";
import { OpenElement } from "../profile-pages/open-element";

type RelayType = "private" | "public" | "global";

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

  token = "";

  override connectedCallback() {
    super.connectedCallback();
    this.token = this.name.replace(/\s+/g, "-");
  }

  private renderIcon() {
    const iconMap = {
      private: "pg-private",
      public: "pg-world-light",
      global: "pg-logo-prayer",
    };
    const iconName = iconMap[this.relayType] || "pg-logo-prayer";

    return html`
      <svg>
        <use href="${this.spritesheetUrl}#${iconName}"></use>
      </svg>
    `;
  }

  render() {
    return html`
      <div role="listitem" class="relay-item" data-type="${this.relayType}">
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
              <li class="dropdown-item">${this.translations.map}</li>
              <li class="dropdown-item">${this.translations.share}</li>
              <li class="dropdown-item">${this.translations.display}</li>
              <li class="dropdown-item">${this.translations.edit}</li>
              <li class="dropdown-item">${this.translations.delete}</li>
            </ul>
            <button class="btn btn-cta">${this.translations.pray}</button>
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
