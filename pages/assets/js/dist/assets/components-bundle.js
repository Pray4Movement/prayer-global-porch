/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const q=globalThis,it=q.ShadowRoot&&(q.ShadyCSS===void 0||q.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,at=Symbol(),lt=new WeakMap;let xt=class{constructor(t,e,a){if(this._$cssResult$=!0,a!==at)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e}get styleSheet(){let t=this.o;const e=this.t;if(it&&t===void 0){const a=e!==void 0&&e.length===1;a&&(t=lt.get(e)),t===void 0&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),a&&lt.set(e,t))}return t}toString(){return this.cssText}};const Nt=s=>new xt(typeof s=="string"?s:s+"",void 0,at),Et=(s,...t)=>{const e=s.length===1?s[0]:t.reduce((a,i,r)=>a+(n=>{if(n._$cssResult$===!0)return n.cssText;if(typeof n=="number")return n;throw Error("Value passed to 'css' function must be a 'css' function result: "+n+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(i)+s[r+1],s[0]);return new xt(e,s,at)},Dt=(s,t)=>{if(it)s.adoptedStyleSheets=t.map(e=>e instanceof CSSStyleSheet?e:e.styleSheet);else for(const e of t){const a=document.createElement("style"),i=q.litNonce;i!==void 0&&a.setAttribute("nonce",i),a.textContent=e.cssText,s.appendChild(a)}},ct=it?s=>s:s=>s instanceof CSSStyleSheet?(t=>{let e="";for(const a of t.cssRules)e+=a.cssText;return Nt(e)})(s):s;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:Ht,defineProperty:Mt,getOwnPropertyDescriptor:Rt,getOwnPropertyNames:zt,getOwnPropertySymbols:It,getPrototypeOf:Lt}=Object,w=globalThis,ht=w.trustedTypes,Bt=ht?ht.emptyScript:"",X=w.reactiveElementPolyfillSupport,z=(s,t)=>s,W={toAttribute(s,t){switch(t){case Boolean:s=s?Bt:null;break;case Object:case Array:s=s==null?s:JSON.stringify(s)}return s},fromAttribute(s,t){let e=s;switch(t){case Boolean:e=s!==null;break;case Number:e=s===null?null:Number(s);break;case Object:case Array:try{e=JSON.parse(s)}catch{e=null}}return e}},nt=(s,t)=>!Ht(s,t),dt={attribute:!0,type:String,converter:W,reflect:!1,hasChanged:nt};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),w.litPropertyMetadata??(w.litPropertyMetadata=new WeakMap);class T extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??(this.l=[])).push(t)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,e=dt){if(e.state&&(e.attribute=!1),this._$Ei(),this.elementProperties.set(t,e),!e.noAccessor){const a=Symbol(),i=this.getPropertyDescriptor(t,a,e);i!==void 0&&Mt(this.prototype,t,i)}}static getPropertyDescriptor(t,e,a){const{get:i,set:r}=Rt(this.prototype,t)??{get(){return this[e]},set(n){this[e]=n}};return{get(){return i==null?void 0:i.call(this)},set(n){const l=i==null?void 0:i.call(this);r.call(this,n),this.requestUpdate(t,l,a)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??dt}static _$Ei(){if(this.hasOwnProperty(z("elementProperties")))return;const t=Lt(this);t.finalize(),t.l!==void 0&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties)}static finalize(){if(this.hasOwnProperty(z("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(z("properties"))){const e=this.properties,a=[...zt(e),...It(e)];for(const i of a)this.createProperty(i,e[i])}const t=this[Symbol.metadata];if(t!==null){const e=litPropertyMetadata.get(t);if(e!==void 0)for(const[a,i]of e)this.elementProperties.set(a,i)}this._$Eh=new Map;for(const[e,a]of this.elementProperties){const i=this._$Eu(e,a);i!==void 0&&this._$Eh.set(i,e)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(t){const e=[];if(Array.isArray(t)){const a=new Set(t.flat(1/0).reverse());for(const i of a)e.unshift(ct(i))}else t!==void 0&&e.push(ct(t));return e}static _$Eu(t,e){const a=e.attribute;return a===!1?void 0:typeof a=="string"?a:typeof t=="string"?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var t;this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),(t=this.constructor.l)==null||t.forEach(e=>e(this))}addController(t){var e;(this._$EO??(this._$EO=new Set)).add(t),this.renderRoot!==void 0&&this.isConnected&&((e=t.hostConnected)==null||e.call(t))}removeController(t){var e;(e=this._$EO)==null||e.delete(t)}_$E_(){const t=new Map,e=this.constructor.elementProperties;for(const a of e.keys())this.hasOwnProperty(a)&&(t.set(a,this[a]),delete this[a]);t.size>0&&(this._$Ep=t)}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return Dt(t,this.constructor.elementStyles),t}connectedCallback(){var t;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(t=this._$EO)==null||t.forEach(e=>{var a;return(a=e.hostConnected)==null?void 0:a.call(e)})}enableUpdating(t){}disconnectedCallback(){var t;(t=this._$EO)==null||t.forEach(e=>{var a;return(a=e.hostDisconnected)==null?void 0:a.call(e)})}attributeChangedCallback(t,e,a){this._$AK(t,a)}_$EC(t,e){var r;const a=this.constructor.elementProperties.get(t),i=this.constructor._$Eu(t,a);if(i!==void 0&&a.reflect===!0){const n=(((r=a.converter)==null?void 0:r.toAttribute)!==void 0?a.converter:W).toAttribute(e,a.type);this._$Em=t,n==null?this.removeAttribute(i):this.setAttribute(i,n),this._$Em=null}}_$AK(t,e){var r;const a=this.constructor,i=a._$Eh.get(t);if(i!==void 0&&this._$Em!==i){const n=a.getPropertyOptions(i),l=typeof n.converter=="function"?{fromAttribute:n.converter}:((r=n.converter)==null?void 0:r.fromAttribute)!==void 0?n.converter:W;this._$Em=i,this[i]=l.fromAttribute(e,n.type),this._$Em=null}}requestUpdate(t,e,a){if(t!==void 0){if(a??(a=this.constructor.getPropertyOptions(t)),!(a.hasChanged??nt)(this[t],e))return;this.P(t,e,a)}this.isUpdatePending===!1&&(this._$ES=this._$ET())}P(t,e,a){this._$AL.has(t)||this._$AL.set(t,e),a.reflect===!0&&this._$Em!==t&&(this._$Ej??(this._$Ej=new Set)).add(t)}async _$ET(){this.isUpdatePending=!0;try{await this._$ES}catch(e){Promise.reject(e)}const t=this.scheduleUpdate();return t!=null&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var a;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[r,n]of this._$Ep)this[r]=n;this._$Ep=void 0}const i=this.constructor.elementProperties;if(i.size>0)for(const[r,n]of i)n.wrapped!==!0||this._$AL.has(r)||this[r]===void 0||this.P(r,this[r],n)}let t=!1;const e=this._$AL;try{t=this.shouldUpdate(e),t?(this.willUpdate(e),(a=this._$EO)==null||a.forEach(i=>{var r;return(r=i.hostUpdate)==null?void 0:r.call(i)}),this.update(e)):this._$EU()}catch(i){throw t=!1,this._$EU(),i}t&&this._$AE(e)}willUpdate(t){}_$AE(t){var e;(e=this._$EO)==null||e.forEach(a=>{var i;return(i=a.hostUpdated)==null?void 0:i.call(a)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(t){return!0}update(t){this._$Ej&&(this._$Ej=this._$Ej.forEach(e=>this._$EC(e,this[e]))),this._$EU()}updated(t){}firstUpdated(t){}}T.elementStyles=[],T.shadowRootOptions={mode:"open"},T[z("elementProperties")]=new Map,T[z("finalized")]=new Map,X==null||X({ReactiveElement:T}),(w.reactiveElementVersions??(w.reactiveElementVersions=[])).push("2.0.4");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const I=globalThis,J=I.trustedTypes,pt=J?J.createPolicy("lit-html",{createHTML:s=>s}):void 0,Ot="$lit$",y=`lit$${Math.random().toFixed(9).slice(2)}$`,St="?"+y,Vt=`<${St}>`,k=document,L=()=>k.createComment(""),B=s=>s===null||typeof s!="object"&&typeof s!="function",rt=Array.isArray,qt=s=>rt(s)||typeof(s==null?void 0:s[Symbol.iterator])=="function",G=`[ 	
\f\r]`,M=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,ut=/-->/g,gt=/>/g,S=RegExp(`>|${G}(?:([^\\s"'>=/]+)(${G}*=${G}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),mt=/'/g,_t=/"/g,Pt=/^(?:script|style|textarea|title)$/i,Wt=s=>(t,...e)=>({_$litType$:s,strings:t,values:e}),_=Wt(1),U=Symbol.for("lit-noChange"),m=Symbol.for("lit-nothing"),$t=new WeakMap,j=k.createTreeWalker(k,129);function jt(s,t){if(!rt(s)||!s.hasOwnProperty("raw"))throw Error("invalid template strings array");return pt!==void 0?pt.createHTML(t):t}const Jt=(s,t)=>{const e=s.length-1,a=[];let i,r=t===2?"<svg>":t===3?"<math>":"",n=M;for(let l=0;l<e;l++){const o=s[l];let h,u,c=-1,p=0;for(;p<o.length&&(n.lastIndex=p,u=n.exec(o),u!==null);)p=n.lastIndex,n===M?u[1]==="!--"?n=ut:u[1]!==void 0?n=gt:u[2]!==void 0?(Pt.test(u[2])&&(i=RegExp("</"+u[2],"g")),n=S):u[3]!==void 0&&(n=S):n===S?u[0]===">"?(n=i??M,c=-1):u[1]===void 0?c=-2:(c=n.lastIndex-u[2].length,h=u[1],n=u[3]===void 0?S:u[3]==='"'?_t:mt):n===_t||n===mt?n=S:n===ut||n===gt?n=M:(n=S,i=void 0);const d=n===S&&s[l+1].startsWith("/>")?" ":"";r+=n===M?o+Vt:c>=0?(a.push(h),o.slice(0,c)+Ot+o.slice(c)+y+d):o+y+(c===-2?l:d)}return[jt(s,r+(s[e]||"<?>")+(t===2?"</svg>":t===3?"</math>":"")),a]};class V{constructor({strings:t,_$litType$:e},a){let i;this.parts=[];let r=0,n=0;const l=t.length-1,o=this.parts,[h,u]=Jt(t,e);if(this.el=V.createElement(h,a),j.currentNode=this.el.content,e===2||e===3){const c=this.el.content.firstChild;c.replaceWith(...c.childNodes)}for(;(i=j.nextNode())!==null&&o.length<l;){if(i.nodeType===1){if(i.hasAttributes())for(const c of i.getAttributeNames())if(c.endsWith(Ot)){const p=u[n++],d=i.getAttribute(c).split(y),g=/([.?@])?(.*)/.exec(p);o.push({type:1,index:r,name:g[2],strings:d,ctor:g[1]==="."?Ft:g[1]==="?"?Kt:g[1]==="@"?Qt:K}),i.removeAttribute(c)}else c.startsWith(y)&&(o.push({type:6,index:r}),i.removeAttribute(c));if(Pt.test(i.tagName)){const c=i.textContent.split(y),p=c.length-1;if(p>0){i.textContent=J?J.emptyScript:"";for(let d=0;d<p;d++)i.append(c[d],L()),j.nextNode(),o.push({type:2,index:++r});i.append(c[p],L())}}}else if(i.nodeType===8)if(i.data===St)o.push({type:2,index:r});else{let c=-1;for(;(c=i.data.indexOf(y,c+1))!==-1;)o.push({type:7,index:r}),c+=y.length-1}r++}}static createElement(t,e){const a=k.createElement("template");return a.innerHTML=t,a}}function N(s,t,e=s,a){var n,l;if(t===U)return t;let i=a!==void 0?(n=e._$Co)==null?void 0:n[a]:e._$Cl;const r=B(t)?void 0:t._$litDirective$;return(i==null?void 0:i.constructor)!==r&&((l=i==null?void 0:i._$AO)==null||l.call(i,!1),r===void 0?i=void 0:(i=new r(s),i._$AT(s,e,a)),a!==void 0?(e._$Co??(e._$Co=[]))[a]=i:e._$Cl=i),i!==void 0&&(t=N(s,i._$AS(s,t.values),i,a)),t}let Zt=class{constructor(t,e){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=e}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:e},parts:a}=this._$AD,i=((t==null?void 0:t.creationScope)??k).importNode(e,!0);j.currentNode=i;let r=j.nextNode(),n=0,l=0,o=a[0];for(;o!==void 0;){if(n===o.index){let h;o.type===2?h=new D(r,r.nextSibling,this,t):o.type===1?h=new o.ctor(r,o.name,o.strings,this,t):o.type===6&&(h=new Xt(r,this,t)),this._$AV.push(h),o=a[++l]}n!==(o==null?void 0:o.index)&&(r=j.nextNode(),n++)}return j.currentNode=k,i}p(t){let e=0;for(const a of this._$AV)a!==void 0&&(a.strings!==void 0?(a._$AI(t,a,e),e+=a.strings.length-2):a._$AI(t[e])),e++}};class D{get _$AU(){var t;return((t=this._$AM)==null?void 0:t._$AU)??this._$Cv}constructor(t,e,a,i){this.type=2,this._$AH=m,this._$AN=void 0,this._$AA=t,this._$AB=e,this._$AM=a,this.options=i,this._$Cv=(i==null?void 0:i.isConnected)??!0}get parentNode(){let t=this._$AA.parentNode;const e=this._$AM;return e!==void 0&&(t==null?void 0:t.nodeType)===11&&(t=e.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,e=this){t=N(this,t,e),B(t)?t===m||t==null||t===""?(this._$AH!==m&&this._$AR(),this._$AH=m):t!==this._$AH&&t!==U&&this._(t):t._$litType$!==void 0?this.$(t):t.nodeType!==void 0?this.T(t):qt(t)?this.k(t):this._(t)}O(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}T(t){this._$AH!==t&&(this._$AR(),this._$AH=this.O(t))}_(t){this._$AH!==m&&B(this._$AH)?this._$AA.nextSibling.data=t:this.T(k.createTextNode(t)),this._$AH=t}$(t){var r;const{values:e,_$litType$:a}=t,i=typeof a=="number"?this._$AC(t):(a.el===void 0&&(a.el=V.createElement(jt(a.h,a.h[0]),this.options)),a);if(((r=this._$AH)==null?void 0:r._$AD)===i)this._$AH.p(e);else{const n=new Zt(i,this),l=n.u(this.options);n.p(e),this.T(l),this._$AH=n}}_$AC(t){let e=$t.get(t.strings);return e===void 0&&$t.set(t.strings,e=new V(t)),e}k(t){rt(this._$AH)||(this._$AH=[],this._$AR());const e=this._$AH;let a,i=0;for(const r of t)i===e.length?e.push(a=new D(this.O(L()),this.O(L()),this,this.options)):a=e[i],a._$AI(r),i++;i<e.length&&(this._$AR(a&&a._$AB.nextSibling,i),e.length=i)}_$AR(t=this._$AA.nextSibling,e){var a;for((a=this._$AP)==null?void 0:a.call(this,!1,!0,e);t&&t!==this._$AB;){const i=t.nextSibling;t.remove(),t=i}}setConnected(t){var e;this._$AM===void 0&&(this._$Cv=t,(e=this._$AP)==null||e.call(this,t))}}class K{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,e,a,i,r){this.type=1,this._$AH=m,this._$AN=void 0,this.element=t,this.name=e,this._$AM=i,this.options=r,a.length>2||a[0]!==""||a[1]!==""?(this._$AH=Array(a.length-1).fill(new String),this.strings=a):this._$AH=m}_$AI(t,e=this,a,i){const r=this.strings;let n=!1;if(r===void 0)t=N(this,t,e,0),n=!B(t)||t!==this._$AH&&t!==U,n&&(this._$AH=t);else{const l=t;let o,h;for(t=r[0],o=0;o<r.length-1;o++)h=N(this,l[a+o],e,o),h===U&&(h=this._$AH[o]),n||(n=!B(h)||h!==this._$AH[o]),h===m?t=m:t!==m&&(t+=(h??"")+r[o+1]),this._$AH[o]=h}n&&!i&&this.j(t)}j(t){t===m?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"")}}class Ft extends K{constructor(){super(...arguments),this.type=3}j(t){this.element[this.name]=t===m?void 0:t}}class Kt extends K{constructor(){super(...arguments),this.type=4}j(t){this.element.toggleAttribute(this.name,!!t&&t!==m)}}class Qt extends K{constructor(t,e,a,i,r){super(t,e,a,i,r),this.type=5}_$AI(t,e=this){if((t=N(this,t,e,0)??m)===U)return;const a=this._$AH,i=t===m&&a!==m||t.capture!==a.capture||t.once!==a.once||t.passive!==a.passive,r=t!==m&&(a===m||i);i&&this.element.removeEventListener(this.name,this,a),r&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var e;typeof this._$AH=="function"?this._$AH.call(((e=this.options)==null?void 0:e.host)??this.element,t):this._$AH.handleEvent(t)}}class Xt{constructor(t,e,a){this.element=t,this.type=6,this._$AN=void 0,this._$AM=e,this.options=a}get _$AU(){return this._$AM._$AU}_$AI(t){N(this,t)}}const Gt={I:D},Y=I.litHtmlPolyfillSupport;Y==null||Y(V,D),(I.litHtmlVersions??(I.litHtmlVersions=[])).push("3.2.1");const Yt=(s,t,e)=>{const a=(e==null?void 0:e.renderBefore)??t;let i=a._$litPart$;if(i===void 0){const r=(e==null?void 0:e.renderBefore)??null;a._$litPart$=i=new D(t.insertBefore(L(),r),r,void 0,e??{})}return i._$AI(s),i};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */let C=class extends T{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var e;const t=super.createRenderRoot();return(e=this.renderOptions).renderBefore??(e.renderBefore=t.firstChild),t}update(t){const e=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=Yt(e,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),(t=this._$Do)==null||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),(t=this._$Do)==null||t.setConnected(!1)}render(){return U}};var At;C._$litElement$=!0,C.finalized=!0,(At=globalThis.litElementHydrateSupport)==null||At.call(globalThis,{LitElement:C});const tt=globalThis.litElementPolyfillSupport;tt==null||tt({LitElement:C});(globalThis.litElementVersions??(globalThis.litElementVersions=[])).push("4.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const A=s=>(t,e)=>{e!==void 0?e.addInitializer(()=>{customElements.define(s,t)}):customElements.define(s,t)};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const te={attribute:!0,type:String,converter:W,reflect:!1,hasChanged:nt},ee=(s=te,t,e)=>{const{kind:a,metadata:i}=e;let r=globalThis.litPropertyMetadata.get(i);if(r===void 0&&globalThis.litPropertyMetadata.set(i,r=new Map),r.set(e.name,s),a==="accessor"){const{name:n}=e;return{set(l){const o=t.get.call(this);t.set.call(this,l),this.requestUpdate(n,o,s)},init(l){return l!==void 0&&this.P(n,void 0,s),l}}}if(a==="setter"){const{name:n}=e;return function(l){const o=this[n];t.call(this,l),this.requestUpdate(n,o,s)}}throw Error("Unsupported decorator location: "+a)};function $(s){return(t,e)=>typeof e=="object"?ee(s,t,e):((a,i,r)=>{const n=i.hasOwnProperty(r);return i.constructor.createProperty(r,n?{...a,wrapped:!0}:a),n?Object.getOwnPropertyDescriptor(i,r):void 0})(s,t,e)}/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */function x(s){return $({...s,state:!0,attribute:!1})}var se=Object.defineProperty,ie=Object.getOwnPropertyDescriptor,Ct=(s,t,e,a)=>{for(var i=a>1?void 0:a?ie(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&se(t,e,i),i};let Z=class extends C{constructor(){super(...arguments),this.text=""}updated(s){s.has("text")&&document.querySelectorAll("pg-avatar").forEach(e=>{e.text!==this.text&&(e.text=this.text)})}getInitials(s){const t=s.split(" ").map(e=>e[0]).join("").toUpperCase().slice(0,2);return t.length===0?"?":t}render(){return _`
      <div class="circle">
        <div>${this.getInitials(this.text)}</div>
      </div>
    `}};Z.styles=[Et`
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
    `];Ct([$({type:String})],Z.prototype,"text",2);Z=Ct([A("pg-avatar")],Z);var ae=Object.defineProperty,ne=Object.getOwnPropertyDescriptor,kt=(s,t,e,a)=>{for(var i=a>1?void 0:a?ne(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&ae(t,e,i),i};let F=class extends C{constructor(){super(...arguments),this.open=!1,this.modalId=this.generateId()}generateId(){return Array(6).fill("").map(()=>String.fromCharCode(97+Math.floor(Math.random()*26))).join("")}render(){return _`
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
    `}close(){this.dispatchEvent(new CustomEvent("close"))}};F.styles=[Et`
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
    `];kt([$({type:Boolean})],F.prototype,"open",2);F=kt([A("pg-modal")],F);class H extends C{constructor(){super()}createRenderRoot(){return this}}var re=Object.defineProperty,oe=Object.getOwnPropertyDescriptor,E=(s,t,e,a)=>{for(var i=a>1?void 0:a?oe(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&re(t,e,i),i};let v=class extends H{constructor(){super(...arguments),this.name="",this.lapNumber=0,this.progress=0,this.translations={},this.spritesheetUrl="",this.relayType="global",this.visibility="public",this.token=""}connectedCallback(){super.connectedCallback(),this.token=this.name.replace(/\s+/g,"-")}renderIcon(){const t={global:"pg-logo-prayer",custom:this.visibility==="private"?"pg-private":"pg-world-light"}[this.relayType]||"pg-logo-prayer";return _`
      <svg>
        <use href="${this.spritesheetUrl}#${t}"></use>
      </svg>
    `}render(){const s=this.relayType==="custom"?this.visibility:this.relayType;return _`
      <div role="listitem" class="relay-item" data-type=${s}>
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
              <li class="dropdown-item">${this.translations.map}</li>
              <li class="dropdown-item">${this.translations.share}</li>
              <li class="dropdown-item">${this.translations.display}</li>
              <li class="dropdown-item">${this.translations.edit}</li>
              <li class="dropdown-item">${this.translations.delete}</li>
            </ul>
            <button class="btn btn-cta">${this.translations.pray}</button>
          </div>
        </div>
      </div>
    `}};E([$({type:String})],v.prototype,"name",2);E([$({type:Number})],v.prototype,"lapNumber",2);E([$({type:Number})],v.prototype,"progress",2);E([$({type:Object})],v.prototype,"translations",2);E([$({type:String})],v.prototype,"spritesheetUrl",2);E([$({type:String})],v.prototype,"relayType",2);E([$({type:String})],v.prototype,"visibility",2);v=E([A("pg-relay-item")],v);var le=Object.getOwnPropertyDescriptor,ce=(s,t,e,a)=>{for(var i=a>1?void 0:a?le(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=n(i)||i);return i};let ft=class extends H{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return _`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${()=>history.back()}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.prayer_activity}</h3>
      </div>

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
    `}};ft=ce([A("pg-activity")],ft);function he(s){return s?JSON.parse('{"'+s.substring(1).replace(/&/g,'","').replace(/=/g,'":"')+'"}'):{}}function de(s,t){let e={};const a=s.split("/").filter(r=>r!=""),i=t.split("/").filter(r=>r!="");return a.map((r,n)=>{/^:/.test(r)&&(e[r.substring(1)]=i[n])}),e}function pe(s){return s?new RegExp("^(|/)"+s.replace(/:[^\s/]+/g,"([\\wÀ-ÖØ-öø-ÿ-]+)")+"(|/)$"):new RegExp("(^$|^/$)")}function ue(s,t){if(pe(t).test(s))return!0}function ge(s){return class extends s{static get properties(){return{route:{type:String,reflect:!0,attribute:"route"},canceled:{type:Boolean}}}constructor(...t){super(...t),this.route="",this.canceled=!1}connectedCallback(...t){super.connectedCallback(...t),this.routing(this.constructor.routes,(...e)=>this.router(...e)),window.addEventListener("route",()=>{this.routing(this.constructor.routes,(...e)=>this.router(...e))}),window.onpopstate=()=>{window.dispatchEvent(new CustomEvent("route"))}}routed(t,e,a,i,r,n){n&&n(t,e,a,i),r(t,e,a,i)}routing(t,e){this.canceled=!0;const a=decodeURI(window.location.pathname),i=decodeURI(window.location.search);let r=t.filter(o=>o.pattern==="*")[0],n=t.filter(o=>o.pattern!=="*"&&ue(a,o.pattern))[0],l=he(i);n?(n.params=de(n.pattern,a),n.data=n.data||{},n.authentication&&n.authentication.authenticate&&typeof n.authentication.authenticate=="function"?(this.canceled=!1,Promise.resolve(n.authentication.authenticate.bind(this).call()).then(o=>{this.canceled||(o?n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(h=>{this.canceled||(h?this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,l,n.data,e,n.callback))})):this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authentication.unauthenticated.name,n.params,l,n.data,e,n.callback))})):n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(o=>{this.canceled||(o?this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,l,n.data,e,n.callback))})):this.routed(n.name,n.params,l,n.data,e,n.callback)):r&&(r.data=r.data||{},this.routed(r.name,{},l,r.data,e,r.callback))}}}function Ut(s){return class extends s{navigate(t){window.history.pushState({},null,t),window.dispatchEvent(new CustomEvent("route"))}}}var me=Object.getOwnPropertyDescriptor,_e=(s,t,e,a)=>{for(var i=a>1?void 0:a?me(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=n(i)||i);return i};let vt=class extends Ut(H){constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}navigateToHref(s){s.preventDefault();const{href:t}=s.currentTarget;this.navigate(t)}render(){return _`
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
                    ${this.user.location&&this.user.location.label||_`<span class="loading-spinner active"></span>`}
                    </div>
                    ${this.user.location&&this.user.location.source==="ip"?_`
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
                  <a
                    class="profile-link"
                    href="/profile/prayer-relays"
                    @click=${s=>this.navigateToHref(s)}
                  >
                    <svg class="icon-md">
                      <use href="${window.jsObject.spritesheet_url}#pg-relay"></use>
                    </svg>
                    <span class="one-rem">
                      ${this.translations.challenges}
                    </span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/prayer-activity"
                    @click=${s=>this.navigateToHref(s)}
                  >
                    <svg class="icon-md">
                      <use href="${window.jsObject.spritesheet_url}#pg-prayer"></use>
                    </svg>
                    <span class="one-rem">${this.translations.prayers}</span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/profile-settings"
                    @click=${s=>this.navigateToHref(s)}
                  >
                    <svg class="icon-md">
                      <use href="${window.jsObject.spritesheet_url}#pg-settings"></use>
                    </svg>
                    <span class="one-rem">${this.translations.profile}</span>
                  </a>
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
    `}};vt=_e([A("pg-dashboard")],vt);/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const $e={CHILD:2},fe=s=>(...t)=>({_$litDirective$:s,values:t});class ve{constructor(t){}get _$AU(){return this._$AM._$AU}_$AT(t,e,a){this._$Ct=t,this._$AM=e,this._$Ci=a}_$AS(t,e){return this.update(t,e)}update(t,e){return this.render(...e)}}/**
 * @license
 * Copyright 2020 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{I:be}=Gt,bt=()=>document.createComment(""),R=(s,t,e)=>{var r;const a=s._$AA.parentNode,i=t===void 0?s._$AB:t._$AA;if(e===void 0){const n=a.insertBefore(bt(),i),l=a.insertBefore(bt(),i);e=new be(n,l,s,s.options)}else{const n=e._$AB.nextSibling,l=e._$AM,o=l!==s;if(o){let h;(r=e._$AQ)==null||r.call(e,s),e._$AM=s,e._$AP!==void 0&&(h=s._$AU)!==l._$AU&&e._$AP(h)}if(n!==i||o){let h=e._$AA;for(;h!==n;){const u=h.nextSibling;a.insertBefore(h,i),h=u}}}return e},P=(s,t,e=s)=>(s._$AI(t,e),s),ye={},we=(s,t=ye)=>s._$AH=t,Ae=s=>s._$AH,et=s=>{var a;(a=s._$AP)==null||a.call(s,!1,!0);let t=s._$AA;const e=s._$AB.nextSibling;for(;t!==e;){const i=t.nextSibling;t.remove(),t=i}};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const yt=(s,t,e)=>{const a=new Map;for(let i=t;i<=e;i++)a.set(s[i],i);return a},xe=fe(class extends ve{constructor(s){if(super(s),s.type!==$e.CHILD)throw Error("repeat() can only be used in text expressions")}dt(s,t,e){let a;e===void 0?e=t:t!==void 0&&(a=t);const i=[],r=[];let n=0;for(const l of s)i[n]=a?a(l,n):n,r[n]=e(l,n),n++;return{values:r,keys:i}}render(s,t,e){return this.dt(s,t,e).values}update(s,[t,e,a]){const i=Ae(s),{values:r,keys:n}=this.dt(t,e,a);if(!Array.isArray(i))return this.ut=n,r;const l=this.ut??(this.ut=[]),o=[];let h,u,c=0,p=i.length-1,d=0,g=r.length-1;for(;c<=p&&d<=g;)if(i[c]===null)c++;else if(i[p]===null)p--;else if(l[c]===n[d])o[d]=P(i[c],r[d]),c++,d++;else if(l[p]===n[g])o[g]=P(i[p],r[g]),p--,g--;else if(l[c]===n[g])o[g]=P(i[c],r[g]),R(s,o[g+1],i[c]),c++,g--;else if(l[p]===n[d])o[d]=P(i[p],r[d]),R(s,i[c],i[p]),p--,d++;else if(h===void 0&&(h=yt(n,d,g),u=yt(l,c,p)),h.has(l[c]))if(h.has(l[p])){const f=u.get(n[d]),Q=f!==void 0?i[f]:null;if(Q===null){const ot=R(s,i[c]);P(ot,r[d]),o[d]=ot}else o[d]=P(Q,r[d]),R(s,i[c],Q),i[f]=null;d++}else et(i[p]),p--;else et(i[c]),c++;for(;d<=g;){const f=R(s,o[g+1]);P(f,r[d]),o[d++]=f}for(;c<=p;){const f=i[c++];f!==null&&et(f)}return this.ut=n,we(s,o),U}});var Ee=Object.defineProperty,Oe=Object.getOwnPropertyDescriptor,Tt=(s,t,e,a)=>{for(var i=a>1?void 0:a?Oe(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&Ee(t,e,i),i};let st=class extends H{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.relays=[],fetch(window.pg_global.root+"pg-api/v1/profile/relays",{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":window.pg_global.nonce},body:JSON.stringify({data:{user_id:this.user.id}})}).then(s=>s.json()).then(s=>{const{relays:t,hidden_relays:e}=s;this.relays=t})}render(){return _`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${()=>history.back()}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.prayer_relays}</h3>
      </div>

      <div class="white-bg page px-3">
        <div class="pg-container stack-md" data-small data-stretch>
          <div role="list" class="stack-md relay-list" data-stretch>
            ${xe(this.relays,s=>s.post_title,s=>_`
                <pg-relay-item
                  name="${s.post_title}"
                  lapNumber="${s.stats.lap_number}"
                  progress="${s.stats.completed_percent}"
                  relayType="${s.relay_type}"
                  visibility="${s.visibility}"
                  .translations="${{lap:this.translations.lap,pray:this.translations.pray,map:this.translations.map,share:this.translations.share,display:this.translations.display,edit:this.translations.edit,delete:this.translations.delete}}"
                  spritesheetUrl="${window.jsObject.spritesheet_url}"
                ></pg-relay-item>
              `)}
          </div>
        </div>
      </div>
    `}};Tt([x()],st.prototype,"relays",2);st=Tt([A("pg-relays")],st);var Se=Object.getOwnPropertyDescriptor,Pe=(s,t,e,a)=>{for(var i=a>1?void 0:a?Se(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=n(i)||i);return i};let wt=class extends Ut(ge(H)){constructor(){super(...arguments),this.route="",this.params={},this.query={},this.data={}}static get properties(){return{route:{type:String},params:{type:Object},query:{type:Object},data:{type:Object}}}static get routes(){return[{name:"dashboard",pattern:"/profile",data:{render:()=>_`<pg-dashboard></pg-dashboard>`}},{name:"prayer-relays",pattern:"/profile/prayer-relays",data:{render:()=>_`<pg-relays></pg-relays>`}},{name:"prayer-activity",pattern:"/profile/prayer-activity",data:{render:()=>_`<pg-activity></pg-activity>`}},{name:"profile-settings",pattern:"/profile/profile-settings",data:{render:()=>_`<pg-settings></pg-settings>`}}]}router(s,t,e,a){this.route=s,this.params=t,this.query=e,this.data=a}render(){var s;return _` ${((s=this.data)==null?void 0:s.render)&&this.data.render()} `}};wt=Pe([A("pg-router")],wt);var je=Object.defineProperty,Ce=Object.getOwnPropertyDescriptor,O=(s,t,e,a)=>{for(var i=a>1?void 0:a?Ce(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&je(t,e,i),i};let b=class extends H{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.currentLanguage=window.jsObject.current_language,this.language=null,this.showEditAccount=!1,this.saving=!1,this.name=this.user.display_name,this.showDeleteAccount=!1,this.deleteInputValue="",this.subscribing=!1,this.subscribed=!1;const s=window.jsObject.current_language;Object.keys(window.jsObject.languages).includes(s)&&(this.language=window.jsObject.languages[s])}back(){history.back()}subsribeToNews(){this.subscribing=!0,window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/subscribe_to_news`,{method:"POST"}).then(s=>{s===!0&&(this.subscribed=!0)}).finally(()=>{this.subscribing=!1})}openEditAccount(){this.showEditAccount=!0}closeEditAccount(){this.showEditAccount=!1}editAccount(){this.user.display_name=this.name,this.saving=!0;const s={display_name:this.name};window.location_data&&window.location_data.location_grid_meta&&window.location_data.location_grid_meta.values&&Array.isArray(window.location_data.location_grid_meta.values)&&window.location_data.location_grid_meta.values.length>0&&(s.location=window.location_data.location_grid_meta.values[0],this.user={...this.user,location:s.location}),window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/save_details`,{method:"POST",body:JSON.stringify(s)}).finally(()=>{if(this.language&&this.language.po_code!==this.currentLanguage){const t=new URLSearchParams(window.location.search);t.set("lang",this.language.po_code),window.location.search=t.toString()}this.closeEditAccount(),this.saving=!1})}openDeleteAccount(){this.showDeleteAccount=!0}closeDeleteAccount(){this.showDeleteAccount=!1}deleteAccount(){window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/delete_user`,{method:"POST"}).then(s=>{s===!0&&(window.location.href="/")})}handleChangeName(s){this.name=s}handleChangeLanguage(s){const t=s.target.value;this.language=window.jsObject.languages[t]??null}render(){var s;return _`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${this.back}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.profile}</h3>
      </div>

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
                <td>${(s=this.language)==null?void 0:s.native_name}</td>
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
            ?disabled=${this.subscribed||this.subscribing}
          >
            ${this.subscribed?this.translations.subscribed:this.translations.subscribe}
            ${this.subscribing?_` <span class="loading-spinner active"></span> `:""}
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
                ${Object.entries(window.jsObject.languages).map(([t,e])=>_`
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
    `}};O([x()],b.prototype,"showEditAccount",2);O([x()],b.prototype,"saving",2);O([x()],b.prototype,"name",2);O([x()],b.prototype,"showDeleteAccount",2);O([x()],b.prototype,"deleteInputValue",2);O([x()],b.prototype,"subscribing",2);O([x()],b.prototype,"subscribed",2);b=O([A("pg-settings")],b);
//# sourceMappingURL=components-bundle.js.map
