import { LitElement } from "lit";

export class PageBase extends LitElement {
  createRenderRoot() {
    return this;
  }
}
