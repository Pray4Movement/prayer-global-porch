import { html } from "lit";
import { customElement, state } from "lit/decorators.js";
import { OpenElement } from "../profile-pages/open-element";

@customElement("pg-relay-form")
export class PgRelayForm extends OpenElement {
  translations: any = window.jsObject.translations;

  @state()
  type: string = "";
  @state()
  title: string = "";
  @state()
  showAdvancedOptions: boolean = false;
  @state()
  startDate: string = "";
  @state()
  startTime: string = "";
  @state()
  endDate: string = "";
  @state()
  endTime: string = "";
  @state()
  isSingle: boolean = false;

  constructor() {
    super();
  }

  handleChangeTitle(value: string) {
    this.title = value;
  }

  handleDateTimeChange(
    event: Event,
    field: "startDate" | "startTime" | "endDate" | "endTime"
  ) {
    const value = (event.target as HTMLInputElement).value;
    this[field] = value;
  }

  onSubmit(event: Event) {
    event.preventDefault();
    const body: any = {
      title: this.title,
      visibility: this.type,
    };

    if (this.startDate) {
      const startTime = this.startTime ? this.startTime : "00:00";
      body.start_date =
        new Date(`${this.startDate} ${startTime}`).getTime() / 1000;
    }

    if (this.endDate) {
      const endTime = this.endTime ? this.endTime : "23:59";
      body.end_date = new Date(`${this.endDate} ${endTime}`).getTime() / 1000;
    }

    if (this.isSingle) {
      body.single_lap = true;
    }

    window
      .api_fetch(window.pg_global.root + "pg-api/v1/dashboard/create_relay", {
        method: "POST",
        body: JSON.stringify(body),
      })
      .then((data: any) => {
        window.location.href = "/dashboard/relays";
      });
  }

  openAdvancedOptions() {
    this.showAdvancedOptions = true;
  }

  setTimestampToNow() {
    this.startDate = window.toDateInputFormat(Date.now() / 1000);
    this.startTime = window.toTimeInputFormat(Date.now() / 1000);
  }

  render() {
    return html`
      <form class="stack-sm align-items-start w-100" @submit=${this.onSubmit}>
        <label for="title" class="w-100">
          ${this.translations.title} *
          <input
            required
            type="text"
            name="title"
            id="title"
            class="form-control"
            placeholder=${this.translations.title}
            @input=${(event: Event) =>
              this.handleChangeTitle((event.target as HTMLInputElement).value)}
          />
        </label>
        ${!this.showAdvancedOptions
          ? html`
              <button
                class="btn btn-outline-primary btn-small me-auto"
                @click=${this.openAdvancedOptions}
              >
                ${this.translations.advanced}
              </button>
            `
          : html`
              <label for="start-date" class="stack-xsm align-items-start">
                <div class="cluster">
                  ${this.translations.start_date}
                  <button
                    type="button"
                    class="btn btn-outline-primary btn-xsmall"
                    @click=${this.setTimestampToNow}
                  >
                    ${this.translations.now}
                  </button>
                </div>
                <div class="cluster">
                  <input
                    type="date"
                    name="start-date"
                    id="start-date"
                    value=${this.startDate}
                    @input=${(e: Event) =>
                      this.handleDateTimeChange(e, "startDate")}
                  />
                  <input
                    type="time"
                    name="start-time"
                    id="start-time"
                    value=${this.startTime}
                    @input=${(e: Event) =>
                      this.handleDateTimeChange(e, "startTime")}
                  />
                </div>
              </label>
              <label for="end-date" class="stack-xsm align-items-start">
                ${this.translations.end_date}
                <div class="cluster">
                  <input
                    type="date"
                    name="end-date"
                    id="end-date"
                    value=${this.endDate}
                    @input=${(e: Event) =>
                      this.handleDateTimeChange(e, "endDate")}
                  />
                  <input
                    type="time"
                    name="end-time"
                    id="end-time"
                    value=${this.endTime}
                    @input=${(e: Event) =>
                      this.handleDateTimeChange(e, "endTime")}
                  />
                </div>
              </label>
              <label class="form-group">
                <input
                  type="checkbox"
                  ?checked=${this.isSingle}
                  @change=${(e: Event) =>
                    (this.isSingle = (e.target as HTMLInputElement).checked)}
                />
                ${this.translations.single_lap_relay}
              </label>
            `}
        <div class="cluster ms-auto">
          <button
            class="btn btn-outline-primary btn-small"
            @click=${() => this.dispatchEvent(new CustomEvent("cancel"))}
          >
            ${this.translations.cancel}
          </button>
          <button class="btn btn-primary btn-small">
            ${this.translations.create}
          </button>
        </div>
      </form>
    `;
  }
}
