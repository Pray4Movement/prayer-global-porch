import { LitElement } from "lit";

export class PageBase extends LitElement {
  constructor() {
    super();
  }
  createRenderRoot() {
    return this;
  }
}
