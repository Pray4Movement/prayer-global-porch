import { html } from "lit";
import { customElement, state } from "lit/decorators.js";
import { OpenElement } from "./open-element";

@customElement("pg-new-relay")
export class PgNewRelay extends OpenElement {
  translations: any = window.jsObject.translations;

  @state()
  saving: boolean = false;

  constructor() {
    super();
  }

  render() {
    return html`
      <pg-header title=${this.translations.new_relay}></pg-header>
      <div class="pg-container stack-md page">
        <h2>New Relay</h2>
        <!-- Stub for future implementation -->
      </div>
    `;
  }
}
