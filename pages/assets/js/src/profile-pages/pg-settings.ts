import { html } from "lit";
import { customElement, state } from "lit/decorators.js";
import { PageBase } from "./page-base";
import { User } from "../interfaces";

@customElement("pg-settings")
export class PgSettings extends PageBase {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  language: string = "";

  @state()
  showDeleteAccount: boolean = false;

  @state()
  deleteInputValue: string = "";

  constructor() {
    super();

    const languageCode = window.jsObject.current_language;
    if (Object.keys(window.jsObject.languages).includes(languageCode)) {
      this.language = window.jsObject.languages[languageCode].native_name;
    }
  }

  back() {
    history.back();
  }

  private onSendGeneralEmailsChange(event: Event) {
    const id = (event.target as HTMLInputElement).id;
    const checked = (event.target as HTMLInputElement).checked;
    window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/update_user`, {
      method: "POST",
      body: JSON.stringify({
        data: {
          [id]: checked,
        },
      }),
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

  render() {
    return html`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${this.back}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.profile}</h3>
      </div>
      <div class="container-md stack-md">
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
                <td>${this.language}</td>
              </tr>
            </tbody>
          </table>
          <button class="mx-auto d-block brand-lightest">
            ${this.translations.edit}
          </button>
        </section>
        <hr />
        <section class="stack-sm">
          <h2 class="h5">${this.translations.communication_preferences}</h2>
          <label class="form-group" for="send_general_emails">
            <input
              type="checkbox"
              id="send_general_emails"
              ?checked="${this.user.send_general_emails}"
              @change=${(event: Event) => this.onSendGeneralEmailsChange(event)}
            />
            ${this.translations.send_general_emails_text}
          </label>
        </section>
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
        <div slot="title">
          <h2 class="h5">${this.translations.delete_account}</h2>
        </div>
        <i slot="close-icon" class="icon pg-close brand-light two-em"></i>
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
            class="btn btn-outline-primary"
            @click=${() => this.closeDeleteAccount()}
          >
            ${this.translations.cancel}
          </button>
          <button
            type="button"
            class="btn btn-primary"
            id="delete-account-button"
            ?disabled=${this.deleteInputValue !== "delete"}
            @click=${() => this.deleteAccount()}
          >
            ${this.translations.delete_account}
          </button>
        </div>
      </pg-modal>
    `;
  }
}
