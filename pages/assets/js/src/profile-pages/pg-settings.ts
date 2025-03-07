import { html } from "lit";
import { customElement, state } from "lit/decorators.js";
import { PageBase } from "./page-base";
import { Language, Location, User } from "../interfaces";

@customElement("pg-settings")
export class PgSettings extends PageBase {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  currentLanguage: string = window.jsObject.current_language;
  language: Language | null = null;

  @state()
  showEditAccount: boolean = false;
  @state()
  saving: boolean = false;
  @state()
  name: string = this.user.display_name;

  @state()
  showDeleteAccount: boolean = false;
  @state()
  deleteInputValue: string = "";

  @state()
  subscribing: boolean = false;
  @state()
  subscribed: boolean = false;

  constructor() {
    super();

    const languageCode = window.jsObject.current_language;
    if (Object.keys(window.jsObject.languages).includes(languageCode)) {
      this.language = window.jsObject.languages[languageCode] as Language;
    }
  }

  back() {
    history.back();
  }

  private subsribeToNews() {
    this.subscribing = true;
    window
      .api_fetch(
        `${window.pg_global.root}pg-api/v1/profile/subscribe_to_news`,
        {
          method: "POST",
        }
      )
      .then((response: boolean) => {
        if (response === true) {
          this.subscribed = true;
        }
      })
      .finally(() => {
        this.subscribing = false;
      });
  }

  private openEditAccount() {
    this.showEditAccount = true;
  }
  private closeEditAccount() {
    this.showEditAccount = false;
  }
  private editAccount() {
    // TO DO: implement account saving logic here
    this.user.display_name = this.name;
    this.saving = true;

    const data: Record<string, any> = {
      display_name: this.name,
    };

    if (
      window.location_data &&
      window.location_data.location_grid_meta &&
      window.location_data.location_grid_meta.values &&
      Array.isArray(window.location_data.location_grid_meta.values) &&
      window.location_data.location_grid_meta.values.length > 0
    ) {
      data["location"] = window.location_data.location_grid_meta.values[0];
      this.user = { ...this.user, location: data["location"] };
    }

    // For example, you could make an API call to save the account data
    window
      .api_fetch(`${window.pg_global.root}pg-api/v1/profile/save_details`, {
        method: "POST",
        body: JSON.stringify(data),
      })
      .finally(() => {
        if (this.language && this.language.po_code !== this.currentLanguage) {
          const urlParams = new URLSearchParams(window.location.search);
          urlParams.set("lang", this.language.po_code);
          window.location.search = urlParams.toString();
        }
        this.closeEditAccount();
        this.saving = false;
      });
  }
  private openDeleteAccount() {
    this.showDeleteAccount = true;
  }
  private closeDeleteAccount() {
    this.showDeleteAccount = false;
  }
  private deleteAccount() {
    window
      .api_fetch(`${window.pg_global.root}pg-api/v1/profile/delete_user`, {
        method: "POST",
      })
      .then((confirmed: boolean) => {
        if (confirmed === true) {
          window.location.href = "/";
        }
      });
  }
  handleChangeName(value: string) {
    this.name = value;
  }
  handleChangeLanguage(event: Event) {
    const selectedLanguage = (event.target as HTMLSelectElement).value;
    this.language = window.jsObject.languages[selectedLanguage] ?? null;
  }

  render() {
    return html`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${this.back}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.profile}</h3>
      </div>

      <div class="container-md stack-md pb-10">
        <section>
          <table class="table">
            <tbody>
              <tr>
                <td><strong>${this.translations.name_text}:</strong></td>
                <td class="user__full-name">${this.user.display_name}</td>
              </tr>
              <tr>
                <td><strong>${this.translations.email_text}:</strong></td>
                <td>${this.user.user_email}</td>
              </tr>
              <tr>
                <td><strong>${this.translations.location_text}:</strong></td>
                <td>
                  <span class="user__location-label"
                    >${(this.user.location && this.user.location.label) ||
                    this.translations.select_a_location}</span
                  >
                  <span class="iplocation-message small d-block text-secondary">
                    ${this.user.location && this.user.location.source === "ip"
                      ? this.translations.estimated_location
                      : ""}
                  </span>
                </td>
              </tr>
              <tr>
                <td><strong>${this.translations.language}:</strong></td>
                <td>${this.language?.native_name}</td>
              </tr>
            </tbody>
          </table>
          <button
            class="mx-auto d-block brand-lightest"
            @click=${this.openEditAccount}
          >
            ${this.translations.edit}
          </button>
        </section>

        <hr />

        <section class="stack-sm">
          <svg class="brand-light icon-lg">
            <use href="${window.jsObject.spritesheet_url}#pg-go-logo"></use>
          </svg>
          <h2 class="h5">${this.translations.communication_preferences}</h2>
          <p>${this.translations.send_general_emails_text}</p>
          <button
            class="btn btn-primary btn-small cluster s-sm"
            @click=${this.subsribeToNews}
            ?disabled=${this.subscribed || this.subscribing}
          >
            ${this.subscribed
              ? this.translations.subscribed
              : this.translations.subscribe}
            ${this.subscribing
              ? html` <span class="loading-spinner active"></span> `
              : ""}
          </button>
        </section>

        <hr />

        <div class="stack-md align-items-stretch">
          <a
            class="btn btn-small btn-primary-light uppercase"
            href="/user_app/logout"
          >
            ${this.translations.logout}
          </a>
          <button
            class="btn btn-small btn-outline-primary uppercase"
            href="/user_app/logout"
            @click=${() => this.openDeleteAccount()}
          >
            ${this.translations.delete_account}
          </button>
        </div>
      </div>

      <pg-modal
        ?open=${this.showDeleteAccount}
        @close=${() => this.closeDeleteAccount()}
      >
        <h2 slot="title" class="h5">${this.translations.delete_account}</h2>
        <svg slot="close-icon" class="icon-md brand-light">
          <use href="${window.jsObject.spritesheet_url}#pg-close"></use>
        </svg>
        <div slot="body">
          <p>${this.translations.delete_account_confirmation}</p>
          <p>${this.translations.delete_account_warning}</p>
          <p>${this.translations.delete_account_confirm_proceed}</p>
          <div class="mb-3">
            <label for="delete-confirmation" class="form-label">
              ${this.translations.confirm_delete}
            </label>
            <input
              type="text"
              class="form-control text-danger"
              id="delete-confirmation"
              placeholder="delete"
              @input=${(event: InputEvent) =>
                (this.deleteInputValue = (
                  event.target as HTMLInputElement
                ).value)}
            />
          </div>
        </div>
        <div slot="footer">
          <button
            type="button"
            class="btn btn-outline-primary btn-small"
            @click=${() => this.closeDeleteAccount()}
          >
            ${this.translations.cancel}
          </button>
          <button
            type="button"
            class="btn btn-primary btn-small"
            id="delete-account-button"
            ?disabled=${this.deleteInputValue !== "delete"}
            @click=${() => this.deleteAccount()}
          >
            ${this.translations.delete_account}
          </button>
        </div>
      </pg-modal>

      <pg-modal ?open=${this.showEditAccount} @close=${this.closeEditAccount}>
        <h2 slot="title" class="h5">${this.translations.edit_account}</h2>
        <svg slot="close-icon" class="icon-md brand-light">
          <use href="${window.jsObject.spritesheet_url}#pg-close"></use>
        </svg>
        <div slot="body">
          <div class="stack-sm align-items-stretch">
            <label for="name">
              ${this.translations.name_text}
              <input
                required
                type="text"
                name="name"
                id="name"
                class="form-control"
                placeholder=${this.translations.name}
                value=${this.user.display_name}
                @change=${(event: Event) =>
                  this.handleChangeName(
                    (event.target as HTMLInputElement).value
                  )}
              />
            </label>
            <label for="mapbox-search">
              ${this.translations.location_text}
              <div id="mapbox-wrapper">
                <div
                  id="mapbox-autocomplete"
                  class="mapbox-autocomplete"
                  data-autosubmit="false"
                  data-add-address="true"
                >
                  <div class="input-group mb-2">
                    <input
                      id="mapbox-search"
                      type="text"
                      name="mapbox_search"
                      class="form-control"
                      autocomplete="off"
                      placeholder=${this.translations.select_location}
                    />
                    <button
                      id="mapbox-clear-autocomplete"
                      class="btn btn-small btn-secondary d-flex align-items-center"
                      type="button"
                      title=${this.translations.delete_location}
                      style=""
                    >
                      <svg slot="close-icon" class="icon-sm white">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-close"
                        ></use>
                      </svg>
                    </button>
                  </div>
                  <div class="mapbox-error-message text-danger small"></div>
                  <div id="mapbox-spinner-button" style="display: none;">
                    <span class="loading-spinner active"></span>
                  </div>
                  <div
                    id="mapbox-autocomplete-list"
                    class="mapbox-autocomplete-items"
                  ></div>
                </div>
              </div>
            </label>
            <label for="language">
              ${this.translations.language}
              <select
                class="form-select"
                id="language"
                @click=${this.handleChangeLanguage}
              >
                ${Object.entries(
                  window.jsObject.languages as Record<string, Language>
                ).map(([code, language]) => {
                  return html`
                    <option
                      value=${code}
                      ?selected=${this.currentLanguage === code}
                    >
                      ${language.flag} ${language.native_name}
                    </option>
                  `;
                })}
              </select>
            </label>
          </div>
        </div>
        <div slot="footer">
          <button
            type="button"
            class="btn btn-outline-primary btn-small"
            @click=${this.closeEditAccount}
          >
            ${this.translations.cancel}
          </button>
          <button
            class="btn btn-primary btn-small"
            ?disabled=${this.saving}
            @click=${this.editAccount}
          >
            ${this.translations.save}
          </button>
        </div>
      </pg-modal>
    `;
  }
}
