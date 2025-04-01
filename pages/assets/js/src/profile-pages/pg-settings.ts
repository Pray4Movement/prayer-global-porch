import { html, PropertyValues } from "lit";
import { customElement, state } from "lit/decorators.js";
import { OpenElement } from "./open-element";
import { Language, Location, MedianPermissions, User } from "../interfaces";

@customElement("pg-settings")
export class PgSettings extends OpenElement {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  currentLanguage: string = window.jsObject.current_language;
  language: Language | null = null;
  permissionsManager: MedianPermissions;

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

  @state()
  hasNotificationsPermission: boolean = false;

  constructor() {
    super();

    const languageCode = window.jsObject.current_language;
    if (Object.keys(window.jsObject.languages).includes(languageCode)) {
      this.language = window.jsObject.languages[languageCode] as Language;
    }

    this.permissionsManager = window.medianPermissions;
  }

  async connectedCallback() {
    super.connectedCallback();
    await this.getNotificationsPermission();
  }

  async update(changedProperties: PropertyValues) {
    await this.getNotificationsPermission();
    super.update(changedProperties);
  }

  back() {
    history.back();
  }

  async getNotificationsPermission() {
    this.hasNotificationsPermission =
      await this.permissionsManager.getNotificationsPermission();
  }

  private subsribeToNews() {
    this.subscribing = true;
    window
      .api_fetch(
        `${window.pg_global.root}pg-api/v1/dashboard/subscribe_to_news`,
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
      location: this.user.location,
      language: this.language?.po_code,
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
      .api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/save_details`, {
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
      .api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/delete_user`, {
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
    console.log(this.language);
  }

  handleChangeLocation(event: Event) {
    const selectedLocation = (event.target as HTMLInputElement).value;
    if (selectedLocation[0]) {
      this.user.location = selectedLocation[0] as unknown as Location;
    }
  }

  requestNotificationsPermission() {
    if (this.permissionsManager.medianLibraryReady) {
      this.permissionsManager.requestNotificationsPermission();
    }
  }

  handleNotificationsToggle() {
    this.permissionsManager.openAppSettings();
  }

  render() {
    return html`
      <pg-header
        backUrl="/dashboard"
        title=${this.translations.profile}
      ></pg-header>

      <div class="pg-container stack-md page">
        <section class="stack-sm">
          <div class="user__avatar">
            <pg-avatar text=${this.user.display_name}></pg-avatar>
          </div>
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

        <section class="stack-sm text-center">
          <svg class="brand-light icon-xxlg">
            <use href="${window.jsObject.spritesheet_url}#pg-bell"></use>
          </svg>
          <div class="cluster s-sm align-items-center">
            <label class="h5 form-group" for="notifications-toggle">
              ${this.translations.notifications_toggle}
              <input
                type="checkbox"
                role="switch"
                ?disabled=${window.isLegacyAppUser || !window.isMobileAppUser()}
                ?checked=${this.hasNotificationsPermission}
                id="notifications-toggle"
                @change=${this.handleNotificationsToggle}
              />
            </label>
          </div>
          <p>${this.translations.notifications_text}</p>
          ${window.isLegacyAppUser || !window.isMobileAppUser()
            ? html`
                <p class="small brand-lighter">
                  <i>${this.translations.notifications_text_mobile}</i>
                </p>
                <a
                  href="/qr/app"
                  target="_blank"
                  class="btn btn-small btn-outline-primary"
                >
                  ${this.translations.go_to_app_store}
                </a>
              `
            : ""}
        </section>

        <hr />

        <section class="stack-sm text-center">
          <svg class="brand-light icon-xxlg">
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

            <label for="location">
              ${this.translations.location_text}
              <dt-location-map
                name="location"
                .value="${[this.user.location]}"
                mapbox-token=${window.pg_global.map_key}
                mapboxToken=${window.pg_global.map_key}
                limit="1"
                @change=${this.handleChangeLocation}
                onchange=${this.handleChangeLocation}
              ></dt-location-map>
            </label>

            <label for="language">
              ${this.translations.language}
              <select
                class="form-select"
                id="language"
                @change=${this.handleChangeLanguage}
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
