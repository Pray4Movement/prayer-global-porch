/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const J=globalThis,ot=J.ShadowRoot&&(J.ShadyCSS===void 0||J.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,lt=Symbol(),ut=new WeakMap;let St=class{constructor(t,e,a){if(this._$cssResult$=!0,a!==lt)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e}get styleSheet(){let t=this.o;const e=this.t;if(ot&&t===void 0){const a=e!==void 0&&e.length===1;a&&(t=ut.get(e)),t===void 0&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),a&&ut.set(e,t))}return t}toString(){return this.cssText}};const It=i=>new St(typeof i=="string"?i:i+"",void 0,lt),ct=(i,...t)=>{const e=i.length===1?i[0]:t.reduce((a,s,r)=>a+(n=>{if(n._$cssResult$===!0)return n.cssText;if(typeof n=="number")return n;throw Error("Value passed to 'css' function must be a 'css' function result: "+n+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(s)+i[r+1],i[0]);return new St(e,i,lt)},Lt=(i,t)=>{if(ot)i.adoptedStyleSheets=t.map(e=>e instanceof CSSStyleSheet?e:e.styleSheet);else for(const e of t){const a=document.createElement("style"),s=J.litNonce;s!==void 0&&a.setAttribute("nonce",s),a.textContent=e.cssText,i.appendChild(a)}},gt=ot?i=>i:i=>i instanceof CSSStyleSheet?(t=>{let e="";for(const a of t.cssRules)e+=a.cssText;return It(e)})(i):i;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:Bt,defineProperty:Vt,getOwnPropertyDescriptor:Wt,getOwnPropertyNames:qt,getOwnPropertySymbols:Jt,getPrototypeOf:Xt}=Object,O=globalThis,_t=O.trustedTypes,Zt=_t?_t.emptyScript:"",tt=O.reactiveElementPolyfillSupport,I=(i,t)=>i,X={toAttribute(i,t){switch(t){case Boolean:i=i?Zt:null;break;case Object:case Array:i=i==null?i:JSON.stringify(i)}return i},fromAttribute(i,t){let e=i;switch(t){case Boolean:e=i!==null;break;case Number:e=i===null?null:Number(i);break;case Object:case Array:try{e=JSON.parse(i)}catch{e=null}}return e}},dt=(i,t)=>!Bt(i,t),$t={attribute:!0,type:String,converter:X,reflect:!1,hasChanged:dt};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),O.litPropertyMetadata??(O.litPropertyMetadata=new WeakMap);class T extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??(this.l=[])).push(t)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,e=$t){if(e.state&&(e.attribute=!1),this._$Ei(),this.elementProperties.set(t,e),!e.noAccessor){const a=Symbol(),s=this.getPropertyDescriptor(t,a,e);s!==void 0&&Vt(this.prototype,t,s)}}static getPropertyDescriptor(t,e,a){const{get:s,set:r}=Wt(this.prototype,t)??{get(){return this[e]},set(n){this[e]=n}};return{get(){return s==null?void 0:s.call(this)},set(n){const l=s==null?void 0:s.call(this);r.call(this,n),this.requestUpdate(t,l,a)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??$t}static _$Ei(){if(this.hasOwnProperty(I("elementProperties")))return;const t=Xt(this);t.finalize(),t.l!==void 0&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties)}static finalize(){if(this.hasOwnProperty(I("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(I("properties"))){const e=this.properties,a=[...qt(e),...Jt(e)];for(const s of a)this.createProperty(s,e[s])}const t=this[Symbol.metadata];if(t!==null){const e=litPropertyMetadata.get(t);if(e!==void 0)for(const[a,s]of e)this.elementProperties.set(a,s)}this._$Eh=new Map;for(const[e,a]of this.elementProperties){const s=this._$Eu(e,a);s!==void 0&&this._$Eh.set(s,e)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(t){const e=[];if(Array.isArray(t)){const a=new Set(t.flat(1/0).reverse());for(const s of a)e.unshift(gt(s))}else t!==void 0&&e.push(gt(t));return e}static _$Eu(t,e){const a=e.attribute;return a===!1?void 0:typeof a=="string"?a:typeof t=="string"?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var t;this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),(t=this.constructor.l)==null||t.forEach(e=>e(this))}addController(t){var e;(this._$EO??(this._$EO=new Set)).add(t),this.renderRoot!==void 0&&this.isConnected&&((e=t.hostConnected)==null||e.call(t))}removeController(t){var e;(e=this._$EO)==null||e.delete(t)}_$E_(){const t=new Map,e=this.constructor.elementProperties;for(const a of e.keys())this.hasOwnProperty(a)&&(t.set(a,this[a]),delete this[a]);t.size>0&&(this._$Ep=t)}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return Lt(t,this.constructor.elementStyles),t}connectedCallback(){var t;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(t=this._$EO)==null||t.forEach(e=>{var a;return(a=e.hostConnected)==null?void 0:a.call(e)})}enableUpdating(t){}disconnectedCallback(){var t;(t=this._$EO)==null||t.forEach(e=>{var a;return(a=e.hostDisconnected)==null?void 0:a.call(e)})}attributeChangedCallback(t,e,a){this._$AK(t,a)}_$EC(t,e){var r;const a=this.constructor.elementProperties.get(t),s=this.constructor._$Eu(t,a);if(s!==void 0&&a.reflect===!0){const n=(((r=a.converter)==null?void 0:r.toAttribute)!==void 0?a.converter:X).toAttribute(e,a.type);this._$Em=t,n==null?this.removeAttribute(s):this.setAttribute(s,n),this._$Em=null}}_$AK(t,e){var r;const a=this.constructor,s=a._$Eh.get(t);if(s!==void 0&&this._$Em!==s){const n=a.getPropertyOptions(s),l=typeof n.converter=="function"?{fromAttribute:n.converter}:((r=n.converter)==null?void 0:r.fromAttribute)!==void 0?n.converter:X;this._$Em=s,this[s]=l.fromAttribute(e,n.type),this._$Em=null}}requestUpdate(t,e,a){if(t!==void 0){if(a??(a=this.constructor.getPropertyOptions(t)),!(a.hasChanged??dt)(this[t],e))return;this.P(t,e,a)}this.isUpdatePending===!1&&(this._$ES=this._$ET())}P(t,e,a){this._$AL.has(t)||this._$AL.set(t,e),a.reflect===!0&&this._$Em!==t&&(this._$Ej??(this._$Ej=new Set)).add(t)}async _$ET(){this.isUpdatePending=!0;try{await this._$ES}catch(e){Promise.reject(e)}const t=this.scheduleUpdate();return t!=null&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var a;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[r,n]of this._$Ep)this[r]=n;this._$Ep=void 0}const s=this.constructor.elementProperties;if(s.size>0)for(const[r,n]of s)n.wrapped!==!0||this._$AL.has(r)||this[r]===void 0||this.P(r,this[r],n)}let t=!1;const e=this._$AL;try{t=this.shouldUpdate(e),t?(this.willUpdate(e),(a=this._$EO)==null||a.forEach(s=>{var r;return(r=s.hostUpdate)==null?void 0:r.call(s)}),this.update(e)):this._$EU()}catch(s){throw t=!1,this._$EU(),s}t&&this._$AE(e)}willUpdate(t){}_$AE(t){var e;(e=this._$EO)==null||e.forEach(a=>{var s;return(s=a.hostUpdated)==null?void 0:s.call(a)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(t){return!0}update(t){this._$Ej&&(this._$Ej=this._$Ej.forEach(e=>this._$EC(e,this[e]))),this._$EU()}updated(t){}firstUpdated(t){}}T.elementStyles=[],T.shadowRootOptions={mode:"open"},T[I("elementProperties")]=new Map,T[I("finalized")]=new Map,tt==null||tt({ReactiveElement:T}),(O.reactiveElementVersions??(O.reactiveElementVersions=[])).push("2.0.4");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const L=globalThis,Z=L.trustedTypes,mt=Z?Z.createPolicy("lit-html",{createHTML:i=>i}):void 0,Ct="$lit$",x=`lit$${Math.random().toFixed(9).slice(2)}$`,Rt="?"+x,Ft=`<${Rt}>`,k=document,B=()=>k.createComment(""),V=i=>i===null||typeof i!="object"&&typeof i!="function",ht=Array.isArray,Kt=i=>ht(i)||typeof(i==null?void 0:i[Symbol.iterator])=="function",et=`[ 	
\f\r]`,M=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,ft=/-->/g,vt=/>/g,S=RegExp(`>|${et}(?:([^\\s"'>=/]+)(${et}*=${et}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),yt=/'/g,bt=/"/g,kt=/^(?:script|style|textarea|title)$/i,Qt=i=>(t,...e)=>({_$litType$:i,strings:t,values:e}),h=Qt(1),U=Symbol.for("lit-noChange"),$=Symbol.for("lit-nothing"),wt=new WeakMap,R=k.createTreeWalker(k,129);function Ut(i,t){if(!ht(i)||!i.hasOwnProperty("raw"))throw Error("invalid template strings array");return mt!==void 0?mt.createHTML(t):t}const Gt=(i,t)=>{const e=i.length-1,a=[];let s,r=t===2?"<svg>":t===3?"<math>":"",n=M;for(let l=0;l<e;l++){const o=i[l];let d,g,c=-1,u=0;for(;u<o.length&&(n.lastIndex=u,g=n.exec(o),g!==null);)u=n.lastIndex,n===M?g[1]==="!--"?n=ft:g[1]!==void 0?n=vt:g[2]!==void 0?(kt.test(g[2])&&(s=RegExp("</"+g[2],"g")),n=S):g[3]!==void 0&&(n=S):n===S?g[0]===">"?(n=s??M,c=-1):g[1]===void 0?c=-2:(c=n.lastIndex-g[2].length,d=g[1],n=g[3]===void 0?S:g[3]==='"'?bt:yt):n===bt||n===yt?n=S:n===ft||n===vt?n=M:(n=S,s=void 0);const p=n===S&&i[l+1].startsWith("/>")?" ":"";r+=n===M?o+Ft:c>=0?(a.push(d),o.slice(0,c)+Ct+o.slice(c)+x+p):o+x+(c===-2?l:p)}return[Ut(i,r+(i[e]||"<?>")+(t===2?"</svg>":t===3?"</math>":"")),a]};class W{constructor({strings:t,_$litType$:e},a){let s;this.parts=[];let r=0,n=0;const l=t.length-1,o=this.parts,[d,g]=Gt(t,e);if(this.el=W.createElement(d,a),R.currentNode=this.el.content,e===2||e===3){const c=this.el.content.firstChild;c.replaceWith(...c.childNodes)}for(;(s=R.nextNode())!==null&&o.length<l;){if(s.nodeType===1){if(s.hasAttributes())for(const c of s.getAttributeNames())if(c.endsWith(Ct)){const u=g[n++],p=s.getAttribute(c).split(x),_=/([.?@])?(.*)/.exec(u);o.push({type:1,index:r,name:_[2],strings:p,ctor:_[1]==="."?te:_[1]==="?"?ee:_[1]==="@"?se:G}),s.removeAttribute(c)}else c.startsWith(x)&&(o.push({type:6,index:r}),s.removeAttribute(c));if(kt.test(s.tagName)){const c=s.textContent.split(x),u=c.length-1;if(u>0){s.textContent=Z?Z.emptyScript:"";for(let p=0;p<u;p++)s.append(c[p],B()),R.nextNode(),o.push({type:2,index:++r});s.append(c[u],B())}}}else if(s.nodeType===8)if(s.data===Rt)o.push({type:2,index:r});else{let c=-1;for(;(c=s.data.indexOf(x,c+1))!==-1;)o.push({type:7,index:r}),c+=x.length-1}r++}}static createElement(t,e){const a=k.createElement("template");return a.innerHTML=t,a}}function D(i,t,e=i,a){var n,l;if(t===U)return t;let s=a!==void 0?(n=e._$Co)==null?void 0:n[a]:e._$Cl;const r=V(t)?void 0:t._$litDirective$;return(s==null?void 0:s.constructor)!==r&&((l=s==null?void 0:s._$AO)==null||l.call(s,!1),r===void 0?s=void 0:(s=new r(i),s._$AT(i,e,a)),a!==void 0?(e._$Co??(e._$Co=[]))[a]=s:e._$Cl=s),s!==void 0&&(t=D(i,s._$AS(i,t.values),s,a)),t}let Yt=class{constructor(t,e){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=e}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:e},parts:a}=this._$AD,s=((t==null?void 0:t.creationScope)??k).importNode(e,!0);R.currentNode=s;let r=R.nextNode(),n=0,l=0,o=a[0];for(;o!==void 0;){if(n===o.index){let d;o.type===2?d=new H(r,r.nextSibling,this,t):o.type===1?d=new o.ctor(r,o.name,o.strings,this,t):o.type===6&&(d=new ie(r,this,t)),this._$AV.push(d),o=a[++l]}n!==(o==null?void 0:o.index)&&(r=R.nextNode(),n++)}return R.currentNode=k,s}p(t){let e=0;for(const a of this._$AV)a!==void 0&&(a.strings!==void 0?(a._$AI(t,a,e),e+=a.strings.length-2):a._$AI(t[e])),e++}};class H{get _$AU(){var t;return((t=this._$AM)==null?void 0:t._$AU)??this._$Cv}constructor(t,e,a,s){this.type=2,this._$AH=$,this._$AN=void 0,this._$AA=t,this._$AB=e,this._$AM=a,this.options=s,this._$Cv=(s==null?void 0:s.isConnected)??!0}get parentNode(){let t=this._$AA.parentNode;const e=this._$AM;return e!==void 0&&(t==null?void 0:t.nodeType)===11&&(t=e.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,e=this){t=D(this,t,e),V(t)?t===$||t==null||t===""?(this._$AH!==$&&this._$AR(),this._$AH=$):t!==this._$AH&&t!==U&&this._(t):t._$litType$!==void 0?this.$(t):t.nodeType!==void 0?this.T(t):Kt(t)?this.k(t):this._(t)}O(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}T(t){this._$AH!==t&&(this._$AR(),this._$AH=this.O(t))}_(t){this._$AH!==$&&V(this._$AH)?this._$AA.nextSibling.data=t:this.T(k.createTextNode(t)),this._$AH=t}$(t){var r;const{values:e,_$litType$:a}=t,s=typeof a=="number"?this._$AC(t):(a.el===void 0&&(a.el=W.createElement(Ut(a.h,a.h[0]),this.options)),a);if(((r=this._$AH)==null?void 0:r._$AD)===s)this._$AH.p(e);else{const n=new Yt(s,this),l=n.u(this.options);n.p(e),this.T(l),this._$AH=n}}_$AC(t){let e=wt.get(t.strings);return e===void 0&&wt.set(t.strings,e=new W(t)),e}k(t){ht(this._$AH)||(this._$AH=[],this._$AR());const e=this._$AH;let a,s=0;for(const r of t)s===e.length?e.push(a=new H(this.O(B()),this.O(B()),this,this.options)):a=e[s],a._$AI(r),s++;s<e.length&&(this._$AR(a&&a._$AB.nextSibling,s),e.length=s)}_$AR(t=this._$AA.nextSibling,e){var a;for((a=this._$AP)==null?void 0:a.call(this,!1,!0,e);t&&t!==this._$AB;){const s=t.nextSibling;t.remove(),t=s}}setConnected(t){var e;this._$AM===void 0&&(this._$Cv=t,(e=this._$AP)==null||e.call(this,t))}}class G{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,e,a,s,r){this.type=1,this._$AH=$,this._$AN=void 0,this.element=t,this.name=e,this._$AM=s,this.options=r,a.length>2||a[0]!==""||a[1]!==""?(this._$AH=Array(a.length-1).fill(new String),this.strings=a):this._$AH=$}_$AI(t,e=this,a,s){const r=this.strings;let n=!1;if(r===void 0)t=D(this,t,e,0),n=!V(t)||t!==this._$AH&&t!==U,n&&(this._$AH=t);else{const l=t;let o,d;for(t=r[0],o=0;o<r.length-1;o++)d=D(this,l[a+o],e,o),d===U&&(d=this._$AH[o]),n||(n=!V(d)||d!==this._$AH[o]),d===$?t=$:t!==$&&(t+=(d??"")+r[o+1]),this._$AH[o]=d}n&&!s&&this.j(t)}j(t){t===$?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"")}}class te extends G{constructor(){super(...arguments),this.type=3}j(t){this.element[this.name]=t===$?void 0:t}}class ee extends G{constructor(){super(...arguments),this.type=4}j(t){this.element.toggleAttribute(this.name,!!t&&t!==$)}}class se extends G{constructor(t,e,a,s,r){super(t,e,a,s,r),this.type=5}_$AI(t,e=this){if((t=D(this,t,e,0)??$)===U)return;const a=this._$AH,s=t===$&&a!==$||t.capture!==a.capture||t.once!==a.once||t.passive!==a.passive,r=t!==$&&(a===$||s);s&&this.element.removeEventListener(this.name,this,a),r&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var e;typeof this._$AH=="function"?this._$AH.call(((e=this.options)==null?void 0:e.host)??this.element,t):this._$AH.handleEvent(t)}}class ie{constructor(t,e,a){this.element=t,this.type=6,this._$AN=void 0,this._$AM=e,this.options=a}get _$AU(){return this._$AM._$AU}_$AI(t){D(this,t)}}const ae={I:H},st=L.litHtmlPolyfillSupport;st==null||st(W,H),(L.litHtmlVersions??(L.litHtmlVersions=[])).push("3.2.1");const ne=(i,t,e)=>{const a=(e==null?void 0:e.renderBefore)??t;let s=a._$litPart$;if(s===void 0){const r=(e==null?void 0:e.renderBefore)??null;a._$litPart$=s=new H(t.insertBefore(B(),r),r,void 0,e??{})}return s._$AI(i),s};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */let P=class extends T{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var e;const t=super.createRenderRoot();return(e=this.renderOptions).renderBefore??(e.renderBefore=t.firstChild),t}update(t){const e=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=ne(e,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),(t=this._$Do)==null||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),(t=this._$Do)==null||t.setConnected(!1)}render(){return U}};var Et;P._$litElement$=!0,P.finalized=!0,(Et=globalThis.litElementHydrateSupport)==null||Et.call(globalThis,{LitElement:P});const it=globalThis.litElementPolyfillSupport;it==null||it({LitElement:P});(globalThis.litElementVersions??(globalThis.litElementVersions=[])).push("4.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const y=i=>(t,e)=>{e!==void 0?e.addInitializer(()=>{customElements.define(i,t)}):customElements.define(i,t)};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const re={attribute:!0,type:String,converter:X,reflect:!1,hasChanged:dt},oe=(i=re,t,e)=>{const{kind:a,metadata:s}=e;let r=globalThis.litPropertyMetadata.get(s);if(r===void 0&&globalThis.litPropertyMetadata.set(s,r=new Map),r.set(e.name,i),a==="accessor"){const{name:n}=e;return{set(l){const o=t.get.call(this);t.set.call(this,l),this.requestUpdate(n,o,i)},init(l){return l!==void 0&&this.P(n,void 0,i),l}}}if(a==="setter"){const{name:n}=e;return function(l){const o=this[n];t.call(this,l),this.requestUpdate(n,o,i)}}throw Error("Unsupported decorator location: "+a)};function m(i){return(t,e)=>typeof e=="object"?oe(i,t,e):((a,s,r)=>{const n=s.hasOwnProperty(r);return s.constructor.createProperty(r,n?{...a,wrapped:!0}:a),n?Object.getOwnPropertyDescriptor(s,r):void 0})(i,t,e)}/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */function f(i){return m({...i,state:!0,attribute:!1})}var le=Object.defineProperty,ce=Object.getOwnPropertyDescriptor,Tt=(i,t,e,a)=>{for(var s=a>1?void 0:a?ce(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=(a?n(t,e,s):n(s))||s);return a&&s&&le(t,e,s),s};let F=class extends P{constructor(){super(...arguments),this.text=""}updated(i){i.has("text")&&document.querySelectorAll("pg-avatar").forEach(e=>{e.text!==this.text&&(e.text=this.text)})}getInitials(i){const t=i.split(" ").map(e=>e[0]).join("").toUpperCase().slice(0,2);return t.length===0?"?":t}render(){return h`
      <div class="circle">
        <div>${this.getInitials(this.text)}</div>
      </div>
    `}};F.styles=[ct`
      :host {
        display: block;
      }
      .circle {
        position: relative;
        border-radius: 1000px;
        aspect-ratio: 1;
        padding: 0.3em;
        background-color: var(--pg-avatar-bg-color, #ccc);
        color: inherit;
        text-align: center;
        font-family: var(--pg-font-family-title);
        font-size: inherit;

        display: flex;
        justify-content: center;
        align-items: center;
        line-height: 1;
      }
      .circle > * {
        min-width: 1em;
      }
    `];Tt([m({type:String})],F.prototype,"text",2);F=Tt([y("pg-avatar")],F);class j extends P{constructor(){super()}createRenderRoot(){return this}}var de=Object.defineProperty,he=Object.getOwnPropertyDescriptor,Dt=(i,t,e,a)=>{for(var s=a>1?void 0:a?he(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=(a?n(t,e,s):n(s))||s);return a&&s&&de(t,e,s),s};let nt=class extends j{constructor(){super(...arguments),this.title=""}render(){return h`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${()=>history.back()}>
          <svg class="icon-md">
            <use
              href="${window.jsObject.spritesheet_url}#pg-chevron-left"
            ></use>
          </svg>
        </button>
        <h3 class="mb-0 me-auto">${this.title}</h3>
      </div>
    `}};Dt([m({type:String})],nt.prototype,"title",2);nt=Dt([y("pg-header")],nt);var pe=Object.defineProperty,ue=Object.getOwnPropertyDescriptor,Nt=(i,t,e,a)=>{for(var s=a>1?void 0:a?ue(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=(a?n(t,e,s):n(s))||s);return a&&s&&pe(t,e,s),s};let K=class extends P{constructor(){super(...arguments),this.open=!1,this.modalId=this.generateId()}generateId(){return Array(6).fill("").map(()=>String.fromCharCode(97+Math.floor(Math.random()*26))).join("")}render(){return h`
      <div
        class="modal fade ${this.open?"show":""}"
        id=${this.modalId+"_modal"}
        tabindex="-1"
        aria-labelledby=${this.modalId+"_label"}
        aria-hidden=${this.open?"false":"true"}
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <div class="modal-title" id=${this.modalId+"_label"}>
                <slot name="title"></slot>
              </div>
              <button
                type="button"
                class="btn-close"
                aria-label="Close"
                @click=${()=>this.close()}
              >
                <slot name="close-icon"></slot>
              </button>
            </div>
            <div class="modal-body">
              <slot name="body"></slot>
            </div>
            <div class="modal-footer">
              <slot name="footer"></slot>
            </div>
          </div>
        </div>
      </div>
    `}close(){this.dispatchEvent(new CustomEvent("close"))}};K.styles=[ct`
      :root {
        font-size: 18px;
      }
      .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #00000055;
        z-index: 1000;

        opacity: 0;
        display: none;
      }
      .modal.show {
        display: block;
        opacity: 1;
      }
      .modal-dialog {
        max-width: 500px;
        margin: 1rem auto;
        width: auto;
        pointer-events: none;
      }
      .modal-content {
        pointer-events: auto;
        background-color: white;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        width: 100%;
      }
      .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid var(--pg-grey);
      }
      .modal-title {
        line-height: 1;
        margin: 0;
      }
      .modal-body {
        padding: 1rem;
      }
      .modal-footer {
        padding: 1rem;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
      }
      .btn-close {
        display: flex;
        cursor: pointer;
        font-size: inherit;
        background: none;
        border: none;
      }
    `];Nt([m({type:Boolean})],K.prototype,"open",2);K=Nt([y("pg-modal")],K);function ge(i){return i?JSON.parse('{"'+i.substring(1).replace(/&/g,'","').replace(/=/g,'":"')+'"}'):{}}function _e(i,t){let e={};const a=i.split("/").filter(r=>r!=""),s=t.split("/").filter(r=>r!="");return a.map((r,n)=>{/^:/.test(r)&&(e[r.substring(1)]=s[n])}),e}function $e(i){return i?new RegExp("^(|/)"+i.replace(/:[^\s/]+/g,"([\\wÀ-ÖØ-öø-ÿ-]+)")+"(|/)$"):new RegExp("(^$|^/$)")}function me(i,t){if($e(t).test(i))return!0}function fe(i){return class extends i{static get properties(){return{route:{type:String,reflect:!0,attribute:"route"},canceled:{type:Boolean}}}constructor(...t){super(...t),this.route="",this.canceled=!1}connectedCallback(...t){super.connectedCallback(...t),this.routing(this.constructor.routes,(...e)=>this.router(...e)),window.addEventListener("route",()=>{this.routing(this.constructor.routes,(...e)=>this.router(...e))}),window.onpopstate=()=>{window.dispatchEvent(new CustomEvent("route"))}}routed(t,e,a,s,r,n){n&&n(t,e,a,s),r(t,e,a,s)}routing(t,e){this.canceled=!0;const a=decodeURI(window.location.pathname),s=decodeURI(window.location.search);let r=t.filter(o=>o.pattern==="*")[0],n=t.filter(o=>o.pattern!=="*"&&me(a,o.pattern))[0],l=ge(s);n?(n.params=_e(n.pattern,a),n.data=n.data||{},n.authentication&&n.authentication.authenticate&&typeof n.authentication.authenticate=="function"?(this.canceled=!1,Promise.resolve(n.authentication.authenticate.bind(this).call()).then(o=>{this.canceled||(o?n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(d=>{this.canceled||(d?this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,l,n.data,e,n.callback))})):this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authentication.unauthenticated.name,n.params,l,n.data,e,n.callback))})):n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(o=>{this.canceled||(o?this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,l,n.data,e,n.callback))})):this.routed(n.name,n.params,l,n.data,e,n.callback)):r&&(r.data=r.data||{},this.routed(r.name,{},l,r.data,e,r.callback))}}}function Ht(i){return class extends i{navigate(t){window.history.pushState({},null,t),window.dispatchEvent(new CustomEvent("route"))}}}var ve=Object.defineProperty,ye=Object.getOwnPropertyDescriptor,Mt=(i,t,e,a)=>{for(var s=a>1?void 0:a?ye(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=(a?n(t,e,s):n(s))||s);return a&&s&&ve(t,e,s),s};let Q=class extends Ht(P){constructor(){super(...arguments),this.href=""}handleClick(i){i.preventDefault();const{href:t}=i.currentTarget;this.navigate(t)}render(){return h`
      <a href="${this.href}" @click=${this.handleClick}>
        <slot></slot>
      </a>
    `}};Q.styles=ct`
    a {
      color: inherit;
      text-decoration: inherit;
    }
    a:hover {
      text-decoration: underline;
    }
  `;Mt([m({type:String})],Q.prototype,"href",2);Q=Mt([y("nav-link")],Q);var be=Object.defineProperty,we=Object.getOwnPropertyDescriptor,b=(i,t,e,a)=>{for(var s=a>1?void 0:a?we(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=(a?n(t,e,s):n(s))||s);return a&&s&&be(t,e,s),s};let v=class extends j{constructor(){super(...arguments),this.name="",this.lapNumber=0,this.progress=0,this.translations={},this.spritesheetUrl="",this.relayType="global",this.visibility="public",this.urlRoot="",this.hiddenRelay=!1,this.token=""}connectedCallback(){super.connectedCallback(),this.token=this.name.replace(/\s+/g,"-")}renderIcon(){const t={global:"pg-logo-prayer",custom:this.visibility==="private"?"pg-private":"pg-world-light"}[this.relayType]||"pg-logo-prayer";return h`
      <svg>
        <use href="${this.spritesheetUrl}#${t}"></use>
      </svg>
    `}render(){const i=this.relayType==="custom"?this.visibility:this.relayType;return h`
      <div
        role="listitem"
        class="relay-item"
        data-type=${i}
        ?data-hidden=${this.hiddenRelay}
      >
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
            data-size=${this.relayType==="global"?"large":"medium"}
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
              <li>
                <a class="dropdown-item" href="${this.urlRoot}/map">
                  ${this.translations.map}
                </a>
              </li>
              ${this.relayType==="custom"?h`
                    <li>
                      <a class="dropdown-item" href="${this.urlRoot}/tools">
                        ${this.translations.share}
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="${this.urlRoot}/display">
                        ${this.translations.display}
                      </a>
                    </li>
                    <li class="dropdown-item">${this.translations.edit}</li>
                  `:""}
              ${this.hiddenRelay?h`
                    <li
                      class="dropdown-item"
                      @click=${()=>this.dispatchEvent(new CustomEvent("unhide"))}
                    >
                      ${this.translations.unhide}
                    </li>
                  `:h`
                    <li
                      class="dropdown-item"
                      @click=${()=>this.dispatchEvent(new CustomEvent("hide"))}
                    >
                      ${this.translations.hide}
                    </li>
                  `}
            </ul>
            <a href=${this.urlRoot} class="btn btn-cta"
              >${this.translations.pray}</a
            >
          </div>
        </div>
      </div>
    `}};b([m({type:String})],v.prototype,"name",2);b([m({type:Number})],v.prototype,"lapNumber",2);b([m({type:Number})],v.prototype,"progress",2);b([m({type:Object})],v.prototype,"translations",2);b([m({type:String})],v.prototype,"spritesheetUrl",2);b([m({type:String})],v.prototype,"relayType",2);b([m({type:String})],v.prototype,"visibility",2);b([m({type:String})],v.prototype,"urlRoot",2);b([m({type:Boolean})],v.prototype,"hiddenRelay",2);v=b([y("pg-relay-item")],v);var Ae=Object.getOwnPropertyDescriptor,xe=(i,t,e,a)=>{for(var s=a>1?void 0:a?Ae(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=n(s)||s);return s};let At=class extends j{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return h`
      <pg-header title=${this.translations.prayer_activity}></pg-header>

      <div class="brand-bg white page px-3">
        <div class="pg-container stack-md" data-grid data-small>
          <h2 class="text-center fs-3 font-base">
            ${this.translations.strengthen_text}
          </h2>

          <div class="switcher">
            <section class="stack-sm | activity-card lh-xsm">
              <h3 class="activity-card__title">
                ${this.translations.daily_streak}
              </h3>
              <div class="cluster">
                <div
                  class="orange-gradient icon-xlg"
                  style="mask:url('${window.jsObject.icons_url}/pg-streak.svg') no-repeat 0 0/100% 100%;"
                ></div>
                <span class="f-lg font-weight-bold"
                  >${window.jsObject.stats.current_streak_in_days}</span
                >
              </div>
              <div class="cluster | s-sm">
                <svg class="brand-highlight icon-md">
                  <use
                    href="${window.jsObject.spritesheet_url}#pg-streak"
                  ></use>
                </svg>
                <span class="fs-3 brand-highlight"
                  >${window.jsObject.stats.best_streak_in_days}
                  ${this.translations.best}</span
                >
              </div>
            </section>
            <section class="stack-sm activity-card lh-xsm">
              <h3 class="activity-card__title">
                ${this.translations.weeks_in_a_row}
              </h3>
              <span class="f-lg font-weight-bold"
                >${window.jsObject.stats.current_streak_in_weeks}</span
              >
              <h3 class="activity-card__title">
                ${this.translations.days_this_year}
              </h3>
              <span class="f-lg font-weight-bold"
                >${window.jsObject.stats.days_this_year}</span
              >
            </section>
          </div>

          <section class="activity-card">
            <table class="activity-table mx-auto">
              <tr>
                <td>${window.jsObject.stats.total_minutes_prayed}</td>
                <td>${this.translations.minutes_prayed}</td>
              </tr>
              <tr>
                <td>${window.jsObject.stats.total_places_prayed}</td>
                <td>${this.translations.places_prayed_for}</td>
              </tr>
              <tr>
                <td>${window.jsObject.stats.total_relays_part_of}</td>
                <td>${this.translations.active_laps}</td>
              </tr>
              <tr>
                <td>${window.jsObject.stats.total_finished_relays_part_of}</td>
                <td>${this.translations.finished_laps}</td>
              </tr>
            </table>
          </section>
          <a class="btn btn-cta btn-lg w-fit mx-auto" href="/newest/lap">
            ${this.translations.start_praying}
          </a>
        </div>
      </div>
    `}};At=xe([y("pg-activity")],At);var Oe=Object.getOwnPropertyDescriptor,Pe=(i,t,e,a)=>{for(var s=a>1?void 0:a?Oe(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=n(s)||s);return s};let xt=class extends j{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return h`
      <div class="pg-container page">
          <div class="stack" id="pg_content">
            <div class="stack-md">
              <section class="user__summary stack-sm">
                <div class="user__avatar">
                  <pg-avatar text=${this.user.display_name}></pg-avatar>
                </div>

                <div class="user__info text-center">
                  <h2 class="user__full-name font-title uppercase">
                    ${this.user.display_name}
                  </h2>
                  <div class="user__location">
                    <div class="user__location-label">
                    ${this.user.location&&this.user.location.label||h`<span class="loading-spinner active"></span>`}
                    </div>
                    ${this.user.location&&this.user.location.source==="ip"?h`
                            <span
                              class="iplocation-message small d-block text-secondary"
                            >
                              ${this.translations.estimated_location}
                            </span>
                          `:""}
                  </div>
                </div>
              </section>
              <hr>
              <section class="profile-menu">
                <div class="w-fit mx-auto stack-md align-items-start">
                  <nav-link href="/dashboard/relays">
                    <div class="profile-link">
                      <svg class="icon-md">
                        <use href="${window.jsObject.spritesheet_url}#pg-relay"></use>
                      </svg>
                      <span class="one-rem">
                        ${this.translations.challenges}
                      </span>
                    </div>
                  </nav-link>
                  <nav-link href="/dashboard/activity">
                    <div class="profile-link">
                      <svg class="icon-md">
                        <use href="${window.jsObject.spritesheet_url}#pg-prayer"></use>
                      </svg>
                      <span class="one-rem">${this.translations.prayers}</span>
                    </div>
                  </nav-link>
                  <nav-link href="/dashboard/settings">
                    <div class="profile-link">
                      <svg class="icon-md">
                        <use href="${window.jsObject.spritesheet_url}#pg-settings"></use>
                      </svg>
                      <span class="one-rem">${this.translations.profile}</span>
                    </div>
                  </nav-link>
                </div>
              </section>
              <hr>
              <a class="btn btn-cta mx-2 two-rem" href="/newest/lap/">
                ${this.translations.start_praying}
              </a>
              <section class="text-center">
                <p>${this.translations.are_you_enjoying_the_app}</p>
                <p>${this.translations.would_you_like_to_partner}</p>
                <div class="d-flex flex-column m-auto w-fit">
                  <a
                    class="btn btn-small btn-primary-light uppercase"
                    data-reverse-color
                    href="/give"
                  >
                    ${this.translations.give}
                  </a>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    `}};xt=Pe([y("pg-dashboard")],xt);var je=Object.defineProperty,Ee=Object.getOwnPropertyDescriptor,zt=(i,t,e,a)=>{for(var s=a>1?void 0:a?Ee(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=(a?n(t,e,s):n(s))||s);return a&&s&&je(t,e,s),s};let rt=class extends j{constructor(){super(),this.translations=window.jsObject.translations,this.saving=!1}render(){return h`
      <pg-header title=${this.translations.new_relay}></pg-header>
      <div class="pg-container stack-md page">
        <h2>New Relay</h2>
        <!-- Stub for future implementation -->
      </div>
    `}};zt([f()],rt.prototype,"saving",2);rt=zt([y("pg-new-relay")],rt);/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Se={CHILD:2},Ce=i=>(...t)=>({_$litDirective$:i,values:t});class Re{constructor(t){}get _$AU(){return this._$AM._$AU}_$AT(t,e,a){this._$Ct=t,this._$AM=e,this._$Ci=a}_$AS(t,e){return this.update(t,e)}update(t,e){return this.render(...e)}}/**
 * @license
 * Copyright 2020 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{I:ke}=ae,Ot=()=>document.createComment(""),z=(i,t,e)=>{var r;const a=i._$AA.parentNode,s=t===void 0?i._$AB:t._$AA;if(e===void 0){const n=a.insertBefore(Ot(),s),l=a.insertBefore(Ot(),s);e=new ke(n,l,i,i.options)}else{const n=e._$AB.nextSibling,l=e._$AM,o=l!==i;if(o){let d;(r=e._$AQ)==null||r.call(e,i),e._$AM=i,e._$AP!==void 0&&(d=i._$AU)!==l._$AU&&e._$AP(d)}if(n!==s||o){let d=e._$AA;for(;d!==n;){const g=d.nextSibling;a.insertBefore(d,s),d=g}}}return e},C=(i,t,e=i)=>(i._$AI(t,e),i),Ue={},Te=(i,t=Ue)=>i._$AH=t,De=i=>i._$AH,at=i=>{var a;(a=i._$AP)==null||a.call(i,!1,!0);let t=i._$AA;const e=i._$AB.nextSibling;for(;t!==e;){const s=t.nextSibling;t.remove(),t=s}};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Pt=(i,t,e)=>{const a=new Map;for(let s=t;s<=e;s++)a.set(i[s],s);return a},Ne=Ce(class extends Re{constructor(i){if(super(i),i.type!==Se.CHILD)throw Error("repeat() can only be used in text expressions")}dt(i,t,e){let a;e===void 0?e=t:t!==void 0&&(a=t);const s=[],r=[];let n=0;for(const l of i)s[n]=a?a(l,n):n,r[n]=e(l,n),n++;return{values:r,keys:s}}render(i,t,e){return this.dt(i,t,e).values}update(i,[t,e,a]){const s=De(i),{values:r,keys:n}=this.dt(t,e,a);if(!Array.isArray(s))return this.ut=n,r;const l=this.ut??(this.ut=[]),o=[];let d,g,c=0,u=s.length-1,p=0,_=r.length-1;for(;c<=u&&p<=_;)if(s[c]===null)c++;else if(s[u]===null)u--;else if(l[c]===n[p])o[p]=C(s[c],r[p]),c++,p++;else if(l[u]===n[_])o[_]=C(s[u],r[_]),u--,_--;else if(l[c]===n[_])o[_]=C(s[c],r[_]),z(i,o[_+1],s[c]),c++,_--;else if(l[u]===n[p])o[p]=C(s[u],r[p]),z(i,s[c],s[u]),u--,p++;else if(d===void 0&&(d=Pt(n,p,_),g=Pt(l,c,u)),d.has(l[c]))if(d.has(l[u])){const w=g.get(n[p]),Y=w!==void 0?s[w]:null;if(Y===null){const pt=z(i,s[c]);C(pt,r[p]),o[p]=pt}else o[p]=C(Y,r[p]),z(i,s[c],Y),s[w]=null;p++}else at(s[u]),u--;else at(s[c]),c++;for(;p<=_;){const w=z(i,o[_+1]);C(w,r[p]),o[p++]=w}for(;c<=u;){const w=s[c++];w!==null&&at(w)}return this.ut=n,Te(i,o),U}});var He=Object.defineProperty,Me=Object.getOwnPropertyDescriptor,q=(i,t,e,a)=>{for(var s=a>1?void 0:a?Me(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=(a?n(t,e,s):n(s))||s);return a&&s&&He(t,e,s),s};let N=class extends j{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.relays=[],this.hiddenRelays=[],this.showHiddenRelays=!1,this.loading=!0,fetch(window.pg_global.root+"pg-api/v1/dashboard/relays",{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":window.pg_global.nonce},body:JSON.stringify({data:{user_id:this.user.id}})}).then(i=>i.json()).then(i=>{const{relays:t,hidden_relays:e}=i;this.relays=t,this.hiddenRelays=e}).finally(()=>{this.loading=!1})}async handleHide(i){(await fetch(`${window.pg_global.root}pg-api/v1/dashboard/relays/hide?relay_id=${i.post_id}`,{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":window.pg_global.nonce}})).ok&&(this.hiddenRelays=[...this.hiddenRelays,i.post_id])}async handleUnhide(i){(await fetch(`${window.pg_global.root}pg-api/v1/dashboard/relays/unhide?relay_id=${i.post_id}`,{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":window.pg_global.nonce}})).ok&&(this.hiddenRelays=this.hiddenRelays.filter(e=>e!==i.post_id))}toggleHiddenRelays(){this.showHiddenRelays=!this.showHiddenRelays}render(){return h`
      <pg-header title=${this.translations.prayer_relays}></pg-header>

      <div class="white-bg page px-3">
        <div class="pg-container stack-md" data-small data-stretch>
          ${this.loading?h`<div class="center">
                <span class="loading-spinner active"></span>
              </div>`:h`
                <div role="list" class="stack-md relay-list" data-stretch>
                  ${Ne(this.relays,i=>i.post_id,i=>!this.showHiddenRelays&&this.hiddenRelays.includes(i.post_id)?"":h`
                        <pg-relay-item
                          key="${i.post_id}"
                          name="${i.post_title}"
                          lapNumber="${i.stats.lap_number}"
                          progress="${i.stats.completed_percent}"
                          relayType="${i.relay_type}"
                          visibility="${i.visibility}"
                          ?hiddenRelay=${this.hiddenRelays.includes(i.post_id)}
                          .translations="${{lap:this.translations.lap,pray:this.translations.pray,map:this.translations.map,share:this.translations.share,display:this.translations.display,edit:this.translations.edit,hide:this.translations.hide,unhide:this.translations.unhide}}"
                          spritesheetUrl="${window.jsObject.spritesheet_url}"
                          urlRoot="/prayer_app/${i.relay_type}/${i.lap_key}"
                          @hide=${()=>this.handleHide(i)}
                          @unhide=${()=>this.handleUnhide(i)}
                        ></pg-relay-item>
                      `)}
                  ${this.relays.some(i=>i.relay_type==="custom")?"":h`
                        <div
                          class="stack-sm center | text-center | border-dashed lh-xsm"
                        >
                          <p class="font-weight-bold">
                            ${this.translations.no_custom_relays}
                          </p>
                          <svg class="icon-md">
                            <use
                              href="${window.jsObject.spritesheet_url}#pg-relay"
                            ></use>
                          </svg>
                        </div>
                      `}
                  <nav-link href="/dashboard/new-relay">
                    <div class="stack-sm center text-center brand">
                      <svg center text-center brandsvg class="icon-lg">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-plus"
                        ></use>
                      </svg>
                      <span class="uppercase"
                        >${this.translations.new_relay}</span
                      >
                    </div>
                  </nav-link>
                </div>
              `}
          ${this.hiddenRelays.length>0?h`
                <div class="cluster ms-auto">
                  <button @click=${()=>this.toggleHiddenRelays()}>
                    ${this.showHiddenRelays?this.translations.hide_hidden_relays:this.translations.show_hidden_relays}
                  </button>
                </div>
              `:""}
        </div>
      </div>
    `}};q([f()],N.prototype,"relays",2);q([f()],N.prototype,"hiddenRelays",2);q([f()],N.prototype,"showHiddenRelays",2);q([f()],N.prototype,"loading",2);N=q([y("pg-relays")],N);var ze=Object.getOwnPropertyDescriptor,Ie=(i,t,e,a)=>{for(var s=a>1?void 0:a?ze(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=n(s)||s);return s};let jt=class extends Ht(fe(j)){constructor(){super(...arguments),this.route="",this.params={},this.query={},this.data={}}static get properties(){return{route:{type:String},params:{type:Object},query:{type:Object},data:{type:Object}}}static get routes(){return[{name:"dashboard",pattern:"/dashboard",data:{render:()=>h`<pg-dashboard></pg-dashboard>`}},{name:"prayer-relays",pattern:"/dashboard/relays",data:{render:()=>h`<pg-relays></pg-relays>`}},{name:"prayer-activity",pattern:"/dashboard/activity",data:{render:()=>h`<pg-activity></pg-activity>`}},{name:"profile-settings",pattern:"/dashboard/settings",data:{render:()=>h`<pg-settings></pg-settings>`}},{name:"new-relay",pattern:"/dashboard/new-relay",data:{render:()=>h`<pg-new-relay></pg-new-relay>`}}]}router(i,t,e,a){this.route=i,this.params=t,this.query=e,this.data=a}render(){var i;return h` ${((i=this.data)==null?void 0:i.render)&&this.data.render()} `}};jt=Ie([y("pg-router")],jt);var Le=Object.defineProperty,Be=Object.getOwnPropertyDescriptor,E=(i,t,e,a)=>{for(var s=a>1?void 0:a?Be(t,e):t,r=i.length-1,n;r>=0;r--)(n=i[r])&&(s=(a?n(t,e,s):n(s))||s);return a&&s&&Le(t,e,s),s};let A=class extends j{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.currentLanguage=window.jsObject.current_language,this.language=null,this.showEditAccount=!1,this.saving=!1,this.name=this.user.display_name,this.showDeleteAccount=!1,this.deleteInputValue="",this.subscribing=!1,this.subscribed=!1;const i=window.jsObject.current_language;Object.keys(window.jsObject.languages).includes(i)&&(this.language=window.jsObject.languages[i])}back(){history.back()}subsribeToNews(){this.subscribing=!0,window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/subscribe_to_news`,{method:"POST"}).then(i=>{i===!0&&(this.subscribed=!0)}).finally(()=>{this.subscribing=!1})}openEditAccount(){this.showEditAccount=!0}closeEditAccount(){this.showEditAccount=!1}editAccount(){this.user.display_name=this.name,this.saving=!0;const i={display_name:this.name};window.location_data&&window.location_data.location_grid_meta&&window.location_data.location_grid_meta.values&&Array.isArray(window.location_data.location_grid_meta.values)&&window.location_data.location_grid_meta.values.length>0&&(i.location=window.location_data.location_grid_meta.values[0],this.user={...this.user,location:i.location}),window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/save_details`,{method:"POST",body:JSON.stringify(i)}).finally(()=>{if(this.language&&this.language.po_code!==this.currentLanguage){const t=new URLSearchParams(window.location.search);t.set("lang",this.language.po_code),window.location.search=t.toString()}this.closeEditAccount(),this.saving=!1})}openDeleteAccount(){this.showDeleteAccount=!0}closeDeleteAccount(){this.showDeleteAccount=!1}deleteAccount(){window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/delete_user`,{method:"POST"}).then(i=>{i===!0&&(window.location.href="/")})}handleChangeName(i){this.name=i}handleChangeLanguage(i){const t=i.target.value;this.language=window.jsObject.languages[t]??null}render(){var i;return h`
      <pg-header title=${this.translations.profile}></pg-header>

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
                    >${this.user.location&&this.user.location.label||this.translations.select_a_location}</span
                  >
                  <span class="iplocation-message small d-block text-secondary">
                    ${this.user.location&&this.user.location.source==="ip"?this.translations.estimated_location:""}
                  </span>
                </td>
              </tr>
              <tr>
                <td><strong>${this.translations.language}:</strong></td>
                <td>${(i=this.language)==null?void 0:i.native_name}</td>
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
          <svg class="brand-light icon-xxlg">
            <use href="${window.jsObject.spritesheet_url}#pg-go-logo"></use>
          </svg>
          <h2 class="h5">${this.translations.communication_preferences}</h2>
          <p>${this.translations.send_general_emails_text}</p>
          <button
            class="btn btn-primary btn-small cluster s-sm"
            @click=${this.subsribeToNews}
            ?disabled=${this.subscribed||this.subscribing}
          >
            ${this.subscribed?this.translations.subscribed:this.translations.subscribe}
            ${this.subscribing?h` <span class="loading-spinner active"></span> `:""}
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
            @click=${()=>this.openDeleteAccount()}
          >
            ${this.translations.delete_account}
          </button>
        </div>
      </div>

      <pg-modal
        ?open=${this.showDeleteAccount}
        @close=${()=>this.closeDeleteAccount()}
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
              @input=${t=>this.deleteInputValue=t.target.value}
            />
          </div>
        </div>
        <div slot="footer">
          <button
            type="button"
            class="btn btn-outline-primary btn-small"
            @click=${()=>this.closeDeleteAccount()}
          >
            ${this.translations.cancel}
          </button>
          <button
            type="button"
            class="btn btn-primary btn-small"
            id="delete-account-button"
            ?disabled=${this.deleteInputValue!=="delete"}
            @click=${()=>this.deleteAccount()}
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
                @change=${t=>this.handleChangeName(t.target.value)}
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
                ${Object.entries(window.jsObject.languages).map(([t,e])=>h`
                    <option
                      value=${t}
                      ?selected=${this.currentLanguage===t}
                    >
                      ${e.flag} ${e.native_name}
                    </option>
                  `)}
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
    `}};E([f()],A.prototype,"showEditAccount",2);E([f()],A.prototype,"saving",2);E([f()],A.prototype,"name",2);E([f()],A.prototype,"showDeleteAccount",2);E([f()],A.prototype,"deleteInputValue",2);E([f()],A.prototype,"subscribing",2);E([f()],A.prototype,"subscribed",2);A=E([y("pg-settings")],A);
//# sourceMappingURL=components-bundle.js.map
