import { LitElement } from "lit";

export class OpenElement extends LitElement {
  constructor() {
    super();
  }
  createRenderRoot() {
    return this;
  }
}
