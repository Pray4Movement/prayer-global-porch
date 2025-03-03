import { html } from "lit";
import { customElement } from "lit/decorators.js";
import { PageBase } from "./page-base";
import { User } from "../interfaces";

@customElement("pg-settings")
export class PgSettings extends PageBase {
  user: User = window.pg_global.user;
  translations: any = window.jsObject.translations;
  language: string = "";

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

  onSendGeneralEmailsChange(event: Event) {
    console.log("Method not implemented.");
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
            @click=${(event: Event) => this.deleteAccount(event)}
          >
            ${this.translations.delete_account}
          </button>
        </div>
      </div>
    `;
  }
  deleteAccount(event: Event) {
    throw new Error("Method not implemented.");
  }
}
