/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const N=globalThis,K=N.ShadowRoot&&(N.ShadyCSS===void 0||N.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,Z=Symbol(),Y=new WeakMap;let gt=class{constructor(t,e,i){if(this._$cssResult$=!0,i!==Z)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e}get styleSheet(){let t=this.o;const e=this.t;if(K&&t===void 0){const i=e!==void 0&&e.length===1;i&&(t=Y.get(e)),t===void 0&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),i&&Y.set(e,t))}return t}toString(){return this.cssText}};const At=a=>new gt(typeof a=="string"?a:a+"",void 0,Z),ft=(a,...t)=>{const e=a.length===1?a[0]:t.reduce((i,s,r)=>i+(n=>{if(n._$cssResult$===!0)return n.cssText;if(typeof n=="number")return n;throw Error("Value passed to 'css' function must be a 'css' function result: "+n+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(s)+a[r+1],a[0]);return new gt(e,a,Z)},xt=(a,t)=>{if(K)a.adoptedStyleSheets=t.map(e=>e instanceof CSSStyleSheet?e:e.styleSheet);else for(const e of t){const i=document.createElement("style"),s=N.litNonce;s!==void 0&&i.setAttribute("nonce",s),i.textContent=e.cssText,a.appendChild(i)}},tt=K?a=>a:a=>a instanceof CSSStyleSheet?(t=>{let e="";for(const i of t.cssRules)e+=i.cssText;return At(e)})(a):a;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:Et,defineProperty:Ot,getOwnPropertyDescriptor:Pt,getOwnPropertyNames:St,getOwnPropertySymbols:jt,getPrototypeOf:Ct}=Object,$=globalThis,et=$.trustedTypes,kt=et?et.emptyScript:"",q=$.reactiveElementPolyfillSupport,C=(a,t)=>a,M={toAttribute(a,t){switch(t){case Boolean:a=a?kt:null;break;case Object:case Array:a=a==null?a:JSON.stringify(a)}return a},fromAttribute(a,t){let e=a;switch(t){case Boolean:e=a!==null;break;case Number:e=a===null?null:Number(a);break;case Object:case Array:try{e=JSON.parse(a)}catch{e=null}}return e}},Q=(a,t)=>!Et(a,t),st={attribute:!0,type:String,converter:M,reflect:!1,hasChanged:Q};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),$.litPropertyMetadata??($.litPropertyMetadata=new WeakMap);class O extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??(this.l=[])).push(t)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,e=st){if(e.state&&(e.attribute=!1),this._$Ei(),this.elementProperties.set(t,e),!e.noAccessor){const i=Symbol(),s=this.getPropertyDescriptor(t,i,e);s!==void 0&&Ot(this.prototype,t,s)}}static getPropertyDescriptor(t,e,i){const{get:s,set:r}=Pt(this.prototype,t)??{get(){return this[e]},set(n){this[e]=n}};return{get(){return s==null?void 0:s.call(this)},set(n){const l=s==null?void 0:s.call(this);r.call(this,n),this.requestUpdate(t,l,i)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??st}static _$Ei(){if(this.hasOwnProperty(C("elementProperties")))return;const t=Ct(this);t.finalize(),t.l!==void 0&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties)}static finalize(){if(this.hasOwnProperty(C("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(C("properties"))){const e=this.properties,i=[...St(e),...jt(e)];for(const s of i)this.createProperty(s,e[s])}const t=this[Symbol.metadata];if(t!==null){const e=litPropertyMetadata.get(t);if(e!==void 0)for(const[i,s]of e)this.elementProperties.set(i,s)}this._$Eh=new Map;for(const[e,i]of this.elementProperties){const s=this._$Eu(e,i);s!==void 0&&this._$Eh.set(s,e)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(t){const e=[];if(Array.isArray(t)){const i=new Set(t.flat(1/0).reverse());for(const s of i)e.unshift(tt(s))}else t!==void 0&&e.push(tt(t));return e}static _$Eu(t,e){const i=e.attribute;return i===!1?void 0:typeof i=="string"?i:typeof t=="string"?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var t;this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),(t=this.constructor.l)==null||t.forEach(e=>e(this))}addController(t){var e;(this._$EO??(this._$EO=new Set)).add(t),this.renderRoot!==void 0&&this.isConnected&&((e=t.hostConnected)==null||e.call(t))}removeController(t){var e;(e=this._$EO)==null||e.delete(t)}_$E_(){const t=new Map,e=this.constructor.elementProperties;for(const i of e.keys())this.hasOwnProperty(i)&&(t.set(i,this[i]),delete this[i]);t.size>0&&(this._$Ep=t)}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return xt(t,this.constructor.elementStyles),t}connectedCallback(){var t;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(t=this._$EO)==null||t.forEach(e=>{var i;return(i=e.hostConnected)==null?void 0:i.call(e)})}enableUpdating(t){}disconnectedCallback(){var t;(t=this._$EO)==null||t.forEach(e=>{var i;return(i=e.hostDisconnected)==null?void 0:i.call(e)})}attributeChangedCallback(t,e,i){this._$AK(t,i)}_$EC(t,e){var r;const i=this.constructor.elementProperties.get(t),s=this.constructor._$Eu(t,i);if(s!==void 0&&i.reflect===!0){const n=(((r=i.converter)==null?void 0:r.toAttribute)!==void 0?i.converter:M).toAttribute(e,i.type);this._$Em=t,n==null?this.removeAttribute(s):this.setAttribute(s,n),this._$Em=null}}_$AK(t,e){var r;const i=this.constructor,s=i._$Eh.get(t);if(s!==void 0&&this._$Em!==s){const n=i.getPropertyOptions(s),l=typeof n.converter=="function"?{fromAttribute:n.converter}:((r=n.converter)==null?void 0:r.fromAttribute)!==void 0?n.converter:M;this._$Em=s,this[s]=l.fromAttribute(e,n.type),this._$Em=null}}requestUpdate(t,e,i){if(t!==void 0){if(i??(i=this.constructor.getPropertyOptions(t)),!(i.hasChanged??Q)(this[t],e))return;this.P(t,e,i)}this.isUpdatePending===!1&&(this._$ES=this._$ET())}P(t,e,i){this._$AL.has(t)||this._$AL.set(t,e),i.reflect===!0&&this._$Em!==t&&(this._$Ej??(this._$Ej=new Set)).add(t)}async _$ET(){this.isUpdatePending=!0;try{await this._$ES}catch(e){Promise.reject(e)}const t=this.scheduleUpdate();return t!=null&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var i;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[r,n]of this._$Ep)this[r]=n;this._$Ep=void 0}const s=this.constructor.elementProperties;if(s.size>0)for(const[r,n]of s)n.wrapped!==!0||this._$AL.has(r)||this[r]===void 0||this.P(r,this[r],n)}let t=!1;const e=this._$AL;try{t=this.shouldUpdate(e),t?(this.willUpdate(e),(i=this._$EO)==null||i.forEach(s=>{var r;return(r=s.hostUpdate)==null?void 0:r.call(s)}),this.update(e)):this._$EU()}catch(s){throw t=!1,this._$EU(),s}t&&this._$AE(e)}willUpdate(t){}_$AE(t){var e;(e=this._$EO)==null||e.forEach(i=>{var s;return(s=i.hostUpdated)==null?void 0:s.call(i)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(t){return!0}update(t){this._$Ej&&(this._$Ej=this._$Ej.forEach(e=>this._$EC(e,this[e]))),this._$EU()}updated(t){}firstUpdated(t){}}O.elementStyles=[],O.shadowRootOptions={mode:"open"},O[C("elementProperties")]=new Map,O[C("finalized")]=new Map,q==null||q({ReactiveElement:O}),($.reactiveElementVersions??($.reactiveElementVersions=[])).push("2.0.4");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const k=globalThis,I=k.trustedTypes,it=I?I.createPolicy("lit-html",{createHTML:a=>a}):void 0,mt="$lit$",_=`lit$${Math.random().toFixed(9).slice(2)}$`,_t="?"+_,Ut=`<${_t}>`,A=document,U=()=>A.createComment(""),T=a=>a===null||typeof a!="object"&&typeof a!="function",G=Array.isArray,Tt=a=>G(a)||typeof(a==null?void 0:a[Symbol.iterator])=="function",W=`[ 	
\f\r]`,j=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,at=/-->/g,nt=/>/g,b=RegExp(`>|${W}(?:([^\\s"'>=/]+)(${W}*=${W}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),rt=/'/g,ot=/"/g,$t=/^(?:script|style|textarea|title)$/i,Rt=a=>(t,...e)=>({_$litType$:a,strings:t,values:e}),p=Rt(1),P=Symbol.for("lit-noChange"),d=Symbol.for("lit-nothing"),lt=new WeakMap,y=A.createTreeWalker(A,129);function vt(a,t){if(!G(a)||!a.hasOwnProperty("raw"))throw Error("invalid template strings array");return it!==void 0?it.createHTML(t):t}const Dt=(a,t)=>{const e=a.length-1,i=[];let s,r=t===2?"<svg>":t===3?"<math>":"",n=j;for(let l=0;l<e;l++){const o=a[l];let h,u,c=-1,g=0;for(;g<o.length&&(n.lastIndex=g,u=n.exec(o),u!==null);)g=n.lastIndex,n===j?u[1]==="!--"?n=at:u[1]!==void 0?n=nt:u[2]!==void 0?($t.test(u[2])&&(s=RegExp("</"+u[2],"g")),n=b):u[3]!==void 0&&(n=b):n===b?u[0]===">"?(n=s??j,c=-1):u[1]===void 0?c=-2:(c=n.lastIndex-u[2].length,h=u[1],n=u[3]===void 0?b:u[3]==='"'?ot:rt):n===ot||n===rt?n=b:n===at||n===nt?n=j:(n=b,s=void 0);const m=n===b&&a[l+1].startsWith("/>")?" ":"";r+=n===j?o+Ut:c>=0?(i.push(h),o.slice(0,c)+mt+o.slice(c)+_+m):o+_+(c===-2?l:m)}return[vt(a,r+(a[e]||"<?>")+(t===2?"</svg>":t===3?"</math>":"")),i]};class R{constructor({strings:t,_$litType$:e},i){let s;this.parts=[];let r=0,n=0;const l=t.length-1,o=this.parts,[h,u]=Dt(t,e);if(this.el=R.createElement(h,i),y.currentNode=this.el.content,e===2||e===3){const c=this.el.content.firstChild;c.replaceWith(...c.childNodes)}for(;(s=y.nextNode())!==null&&o.length<l;){if(s.nodeType===1){if(s.hasAttributes())for(const c of s.getAttributeNames())if(c.endsWith(mt)){const g=u[n++],m=s.getAttribute(c).split(_),z=/([.?@])?(.*)/.exec(g);o.push({type:1,index:r,name:z[2],strings:m,ctor:z[1]==="."?zt:z[1]==="?"?Nt:z[1]==="@"?Mt:V}),s.removeAttribute(c)}else c.startsWith(_)&&(o.push({type:6,index:r}),s.removeAttribute(c));if($t.test(s.tagName)){const c=s.textContent.split(_),g=c.length-1;if(g>0){s.textContent=I?I.emptyScript:"";for(let m=0;m<g;m++)s.append(c[m],U()),y.nextNode(),o.push({type:2,index:++r});s.append(c[g],U())}}}else if(s.nodeType===8)if(s.data===_t)o.push({type:2,index:r});else{let c=-1;for(;(c=s.data.indexOf(_,c+1))!==-1;)o.push({type:7,index:r}),c+=_.length-1}r++}}static createElement(t,e){const i=A.createElement("template");return i.innerHTML=t,i}}function S(a,t,e=a,i){var n,l;if(t===P)return t;let s=i!==void 0?(n=e._$Co)==null?void 0:n[i]:e._$Cl;const r=T(t)?void 0:t._$litDirective$;return(s==null?void 0:s.constructor)!==r&&((l=s==null?void 0:s._$AO)==null||l.call(s,!1),r===void 0?s=void 0:(s=new r(a),s._$AT(a,e,i)),i!==void 0?(e._$Co??(e._$Co=[]))[i]=s:e._$Cl=s),s!==void 0&&(t=S(a,s._$AS(a,t.values),s,i)),t}class Ht{constructor(t,e){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=e}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:e},parts:i}=this._$AD,s=((t==null?void 0:t.creationScope)??A).importNode(e,!0);y.currentNode=s;let r=y.nextNode(),n=0,l=0,o=i[0];for(;o!==void 0;){if(n===o.index){let h;o.type===2?h=new D(r,r.nextSibling,this,t):o.type===1?h=new o.ctor(r,o.name,o.strings,this,t):o.type===6&&(h=new It(r,this,t)),this._$AV.push(h),o=i[++l]}n!==(o==null?void 0:o.index)&&(r=y.nextNode(),n++)}return y.currentNode=A,s}p(t){let e=0;for(const i of this._$AV)i!==void 0&&(i.strings!==void 0?(i._$AI(t,i,e),e+=i.strings.length-2):i._$AI(t[e])),e++}}class D{get _$AU(){var t;return((t=this._$AM)==null?void 0:t._$AU)??this._$Cv}constructor(t,e,i,s){this.type=2,this._$AH=d,this._$AN=void 0,this._$AA=t,this._$AB=e,this._$AM=i,this.options=s,this._$Cv=(s==null?void 0:s.isConnected)??!0}get parentNode(){let t=this._$AA.parentNode;const e=this._$AM;return e!==void 0&&(t==null?void 0:t.nodeType)===11&&(t=e.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,e=this){t=S(this,t,e),T(t)?t===d||t==null||t===""?(this._$AH!==d&&this._$AR(),this._$AH=d):t!==this._$AH&&t!==P&&this._(t):t._$litType$!==void 0?this.$(t):t.nodeType!==void 0?this.T(t):Tt(t)?this.k(t):this._(t)}O(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}T(t){this._$AH!==t&&(this._$AR(),this._$AH=this.O(t))}_(t){this._$AH!==d&&T(this._$AH)?this._$AA.nextSibling.data=t:this.T(A.createTextNode(t)),this._$AH=t}$(t){var r;const{values:e,_$litType$:i}=t,s=typeof i=="number"?this._$AC(t):(i.el===void 0&&(i.el=R.createElement(vt(i.h,i.h[0]),this.options)),i);if(((r=this._$AH)==null?void 0:r._$AD)===s)this._$AH.p(e);else{const n=new Ht(s,this),l=n.u(this.options);n.p(e),this.T(l),this._$AH=n}}_$AC(t){let e=lt.get(t.strings);return e===void 0&&lt.set(t.strings,e=new R(t)),e}k(t){G(this._$AH)||(this._$AH=[],this._$AR());const e=this._$AH;let i,s=0;for(const r of t)s===e.length?e.push(i=new D(this.O(U()),this.O(U()),this,this.options)):i=e[s],i._$AI(r),s++;s<e.length&&(this._$AR(i&&i._$AB.nextSibling,s),e.length=s)}_$AR(t=this._$AA.nextSibling,e){var i;for((i=this._$AP)==null?void 0:i.call(this,!1,!0,e);t&&t!==this._$AB;){const s=t.nextSibling;t.remove(),t=s}}setConnected(t){var e;this._$AM===void 0&&(this._$Cv=t,(e=this._$AP)==null||e.call(this,t))}}class V{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,e,i,s,r){this.type=1,this._$AH=d,this._$AN=void 0,this.element=t,this.name=e,this._$AM=s,this.options=r,i.length>2||i[0]!==""||i[1]!==""?(this._$AH=Array(i.length-1).fill(new String),this.strings=i):this._$AH=d}_$AI(t,e=this,i,s){const r=this.strings;let n=!1;if(r===void 0)t=S(this,t,e,0),n=!T(t)||t!==this._$AH&&t!==P,n&&(this._$AH=t);else{const l=t;let o,h;for(t=r[0],o=0;o<r.length-1;o++)h=S(this,l[i+o],e,o),h===P&&(h=this._$AH[o]),n||(n=!T(h)||h!==this._$AH[o]),h===d?t=d:t!==d&&(t+=(h??"")+r[o+1]),this._$AH[o]=h}n&&!s&&this.j(t)}j(t){t===d?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"")}}class zt extends V{constructor(){super(...arguments),this.type=3}j(t){this.element[this.name]=t===d?void 0:t}}class Nt extends V{constructor(){super(...arguments),this.type=4}j(t){this.element.toggleAttribute(this.name,!!t&&t!==d)}}class Mt extends V{constructor(t,e,i,s,r){super(t,e,i,s,r),this.type=5}_$AI(t,e=this){if((t=S(this,t,e,0)??d)===P)return;const i=this._$AH,s=t===d&&i!==d||t.capture!==i.capture||t.once!==i.once||t.passive!==i.passive,r=t!==d&&(i===d||s);s&&this.element.removeEventListener(this.name,this,i),r&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var e;typeof this._$AH=="function"?this._$AH.call(((e=this.options)==null?void 0:e.host)??this.element,t):this._$AH.handleEvent(t)}}class It{constructor(t,e,i){this.element=t,this.type=6,this._$AN=void 0,this._$AM=e,this.options=i}get _$AU(){return this._$AM._$AU}_$AI(t){S(this,t)}}const J=k.litHtmlPolyfillSupport;J==null||J(R,D),(k.litHtmlVersions??(k.litHtmlVersions=[])).push("3.2.1");const Lt=(a,t,e)=>{const i=(e==null?void 0:e.renderBefore)??t;let s=i._$litPart$;if(s===void 0){const r=(e==null?void 0:e.renderBefore)??null;i._$litPart$=s=new D(t.insertBefore(U(),r),r,void 0,e??{})}return s._$AI(a),s};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */let w=class extends O{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var e;const t=super.createRenderRoot();return(e=this.renderOptions).renderBefore??(e.renderBefore=t.firstChild),t}update(t){const e=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=Lt(e,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),(t=this._$Do)==null||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),(t=this._$Do)==null||t.setConnected(!1)}render(){return P}};var pt;w._$litElement$=!0,w.finalized=!0,(pt=globalThis.litElementHydrateSupport)==null||pt.call(globalThis,{LitElement:w});const F=globalThis.litElementPolyfillSupport;F==null||F({LitElement:w});(globalThis.litElementVersions??(globalThis.litElementVersions=[])).push("4.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const x=a=>(t,e)=>{e!==void 0?e.addInitializer(()=>{customElements.define(a,t)}):customElements.define(a,t)};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Bt={attribute:!0,type:String,converter:M,reflect:!1,hasChanged:Q},Vt=(a=Bt,t,e)=>{const{kind:i,metadata:s}=e;let r=globalThis.litPropertyMetadata.get(s);if(r===void 0&&globalThis.litPropertyMetadata.set(s,r=new Map),r.set(e.name,a),i==="accessor"){const{name:n}=e;return{set(l){const o=t.get.call(this);t.set.call(this,l),this.requestUpdate(n,o,a)},init(l){return l!==void 0&&this.P(n,void 0,a),l}}}if(i==="setter"){const{name:n}=e;return function(l){const o=this[n];t.call(this,l),this.requestUpdate(n,o,a)}}throw Error("Unsupported decorator location: "+i)};function X(a){return(t,e)=>typeof e=="object"?Vt(a,t,e):((i,s,r)=>{const n=s.hasOwnProperty(r);return s.constructor.createProperty(r,n?{...i,wrapped:!0}:i),n?Object.getOwnPropertyDescriptor(s,r):void 0})(a,t,e)}/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */function E(a){return X({...a,state:!0,attribute:!1})}var qt=Object.defineProperty,Wt=Object.getOwnPropertyDescriptor,bt=(a,t,e,i)=>{for(var s=i>1?void 0:i?Wt(t,e):t,r=a.length-1,n;r>=0;r--)(n=a[r])&&(s=(i?n(t,e,s):n(s))||s);return i&&s&&qt(t,e,s),s};let L=class extends w{constructor(){super(...arguments),this.text=""}updated(a){a.has("text")&&document.querySelectorAll("pg-avatar").forEach(e=>{e.text!==this.text&&(e.text=this.text)})}getInitials(a){const t=a.split(" ").map(e=>e[0]).join("").toUpperCase().slice(0,2);return t.length===0?"?":t}render(){return p`
      <div class="circle">
        <div>${this.getInitials(this.text)}</div>
      </div>
    `}};L.styles=[ft`
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
    `];bt([X({type:String})],L.prototype,"text",2);L=bt([x("pg-avatar")],L);var Jt=Object.defineProperty,Ft=Object.getOwnPropertyDescriptor,yt=(a,t,e,i)=>{for(var s=i>1?void 0:i?Ft(t,e):t,r=a.length-1,n;r>=0;r--)(n=a[r])&&(s=(i?n(t,e,s):n(s))||s);return i&&s&&Jt(t,e,s),s};let B=class extends w{constructor(){super(...arguments),this.open=!1,this.modalId=this.generateId()}generateId(){return Array(6).fill("").map(()=>String.fromCharCode(97+Math.floor(Math.random()*26))).join("")}render(){return p`
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
    `}close(){this.dispatchEvent(new CustomEvent("close"))}};B.styles=[ft`
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
    `];yt([X({type:Boolean})],B.prototype,"open",2);B=yt([x("pg-modal")],B);class H extends w{constructor(){super()}createRenderRoot(){return this}}var Kt=Object.getOwnPropertyDescriptor,Zt=(a,t,e,i)=>{for(var s=i>1?void 0:i?Kt(t,e):t,r=a.length-1,n;r>=0;r--)(n=a[r])&&(s=n(s)||s);return s};let ct=class extends H{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return p`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${()=>history.back()}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.prayer_activity}</h3>
      </div>

      <div class="brand-bg white">
        <div class="container-md stack-md page px-3">
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
                  >${window.jsObject.stats.best_streak_in_days} Best</span
                >
              </div>
            </section>
            <section class="stack-sm activity-card lh-xsm">
              <h3 class="activity-card__title">Weeks in a row</h3>
              <span class="f-lg font-weight-bold"
                >${window.jsObject.stats.current_streak_in_weeks}</span
              >
              <h3 class="activity-card__title">Days this year</h3>
              <span class="f-lg font-weight-bold"
                >${window.jsObject.stats.days_this_year}</span
              >
            </section>
          </div>

          <section class="activity-table activity-card">
            <span>${window.jsObject.stats.total_minutes_prayed}</span>
            <span>Minutes prayed</span>
            <span>${window.jsObject.stats.total_places_prayed}</span>
            <span>Places prayed for</span>
            <span>${window.jsObject.stats.total_relays_part_of}</span>
            <span>Active laps</span>
            <span>${window.jsObject.stats.total_finished_relays_part_of}</span>
            <span>Laps finished</span>
          </section>
          <a class="btn btn-cta btn-lg" href="/newest/lap">
            ${this.translations.start_praying}
          </a>
        </div>
      </div>
    `}};ct=Zt([x("pg-activity")],ct);function Qt(a){return a?JSON.parse('{"'+a.substring(1).replace(/&/g,'","').replace(/=/g,'":"')+'"}'):{}}function Gt(a,t){let e={};const i=a.split("/").filter(r=>r!=""),s=t.split("/").filter(r=>r!="");return i.map((r,n)=>{/^:/.test(r)&&(e[r.substring(1)]=s[n])}),e}function Xt(a){return a?new RegExp("^(|/)"+a.replace(/:[^\s/]+/g,"([\\wÀ-ÖØ-öø-ÿ-]+)")+"(|/)$"):new RegExp("(^$|^/$)")}function Yt(a,t){if(Xt(t).test(a))return!0}function te(a){return class extends a{static get properties(){return{route:{type:String,reflect:!0,attribute:"route"},canceled:{type:Boolean}}}constructor(...t){super(...t),this.route="",this.canceled=!1}connectedCallback(...t){super.connectedCallback(...t),this.routing(this.constructor.routes,(...e)=>this.router(...e)),window.addEventListener("route",()=>{this.routing(this.constructor.routes,(...e)=>this.router(...e))}),window.onpopstate=()=>{window.dispatchEvent(new CustomEvent("route"))}}routed(t,e,i,s,r,n){n&&n(t,e,i,s),r(t,e,i,s)}routing(t,e){this.canceled=!0;const i=decodeURI(window.location.pathname),s=decodeURI(window.location.search);let r=t.filter(o=>o.pattern==="*")[0],n=t.filter(o=>o.pattern!=="*"&&Yt(i,o.pattern))[0],l=Qt(s);n?(n.params=Gt(n.pattern,i),n.data=n.data||{},n.authentication&&n.authentication.authenticate&&typeof n.authentication.authenticate=="function"?(this.canceled=!1,Promise.resolve(n.authentication.authenticate.bind(this).call()).then(o=>{this.canceled||(o?n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(h=>{this.canceled||(h?this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,l,n.data,e,n.callback))})):this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authentication.unauthenticated.name,n.params,l,n.data,e,n.callback))})):n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(o=>{this.canceled||(o?this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,l,n.data,e,n.callback))})):this.routed(n.name,n.params,l,n.data,e,n.callback)):r&&(r.data=r.data||{},this.routed(r.name,{},l,r.data,e,r.callback))}}}function wt(a){return class extends a{navigate(t){window.history.pushState({},null,t),window.dispatchEvent(new CustomEvent("route"))}}}var ee=Object.getOwnPropertyDescriptor,se=(a,t,e,i)=>{for(var s=i>1?void 0:i?ee(t,e):t,r=a.length-1,n;r>=0;r--)(n=a[r])&&(s=n(s)||s);return s};let ht=class extends wt(H){constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}navigateToHref(a){a.preventDefault();const{href:t}=a.currentTarget;this.navigate(t)}render(){return p`
      <div class="container-md page">
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
                    ${this.user.location&&this.user.location.label||p`<span class="loading-spinner active"></span>`}
                    </div>
                    ${this.user.location&&this.user.location.source==="ip"?p`
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
                    @click=${a=>this.navigateToHref(a)}
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
                    @click=${a=>this.navigateToHref(a)}
                  >
                    <svg class="icon-md">
                      <use href="${window.jsObject.spritesheet_url}#pg-prayer"></use>
                    </svg>
                    <span class="one-rem">${this.translations.prayers}</span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/profile-settings"
                    @click=${a=>this.navigateToHref(a)}
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
    `}};ht=se([x("pg-dashboard")],ht);var ie=Object.getOwnPropertyDescriptor,ae=(a,t,e,i)=>{for(var s=i>1?void 0:i?ie(t,e):t,r=a.length-1,n;r>=0;r--)(n=a[r])&&(s=n(s)||s);return s};let dt=class extends H{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return p` <h2>My Prayer Relays</h2> `}};dt=ae([x("pg-relays")],dt);var ne=Object.getOwnPropertyDescriptor,re=(a,t,e,i)=>{for(var s=i>1?void 0:i?ne(t,e):t,r=a.length-1,n;r>=0;r--)(n=a[r])&&(s=n(s)||s);return s};let ut=class extends wt(te(H)){constructor(){super(...arguments),this.route="",this.params={},this.query={},this.data={}}static get properties(){return{route:{type:String},params:{type:Object},query:{type:Object},data:{type:Object}}}static get routes(){return[{name:"dashboard",pattern:"/profile",data:{render:()=>p`<pg-dashboard></pg-dashboard>`}},{name:"prayer-relays",pattern:"/profile/prayer-relays",data:{render:()=>p`<pg-relays></pg-relays>`}},{name:"prayer-activity",pattern:"/profile/prayer-activity",data:{render:()=>p`<pg-activity></pg-activity>`}},{name:"profile-settings",pattern:"/profile/profile-settings",data:{render:()=>p`<pg-settings></pg-settings>`}}]}router(a,t,e,i){this.route=a,this.params=t,this.query=e,this.data=i}render(){var a;return p` ${((a=this.data)==null?void 0:a.render)&&this.data.render()} `}};ut=re([x("pg-router")],ut);var oe=Object.defineProperty,le=Object.getOwnPropertyDescriptor,v=(a,t,e,i)=>{for(var s=i>1?void 0:i?le(t,e):t,r=a.length-1,n;r>=0;r--)(n=a[r])&&(s=(i?n(t,e,s):n(s))||s);return i&&s&&oe(t,e,s),s};let f=class extends H{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.currentLanguage=window.jsObject.current_language,this.language=null,this.showEditAccount=!1,this.saving=!1,this.name=this.user.display_name,this.showDeleteAccount=!1,this.deleteInputValue="",this.subscribing=!1,this.subscribed=!1;const a=window.jsObject.current_language;Object.keys(window.jsObject.languages).includes(a)&&(this.language=window.jsObject.languages[a])}back(){history.back()}subsribeToNews(){this.subscribing=!0,window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/subscribe_to_news`,{method:"POST"}).then(a=>{a===!0&&(this.subscribed=!0)}).finally(()=>{this.subscribing=!1})}openEditAccount(){this.showEditAccount=!0}closeEditAccount(){this.showEditAccount=!1}editAccount(){this.user.display_name=this.name,this.saving=!0;const a={display_name:this.name};window.location_data&&window.location_data.location_grid_meta&&window.location_data.location_grid_meta.values&&Array.isArray(window.location_data.location_grid_meta.values)&&window.location_data.location_grid_meta.values.length>0&&(a.location=window.location_data.location_grid_meta.values[0],this.user={...this.user,location:a.location}),window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/save_details`,{method:"POST",body:JSON.stringify(a)}).finally(()=>{if(this.language&&this.language.po_code!==this.currentLanguage){const t=new URLSearchParams(window.location.search);t.set("lang",this.language.po_code),window.location.search=t.toString()}this.closeEditAccount(),this.saving=!1})}openDeleteAccount(){this.showDeleteAccount=!0}closeDeleteAccount(){this.showDeleteAccount=!1}deleteAccount(){window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/delete_user`,{method:"POST"}).then(a=>{a===!0&&(window.location.href="/")})}handleChangeName(a){this.name=a}handleChangeLanguage(a){const t=a.target.value;this.language=window.jsObject.languages[t]??null}render(){var a;return p`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${this.back}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.profile}</h3>
      </div>

      <div class="container-md stack-md page">
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
                <td>${(a=this.language)==null?void 0:a.native_name}</td>
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
            ${this.subscribing?p` <span class="loading-spinner active"></span> `:""}
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
                ${Object.entries(window.jsObject.languages).map(([t,e])=>p`
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
    `}};v([E()],f.prototype,"showEditAccount",2);v([E()],f.prototype,"saving",2);v([E()],f.prototype,"name",2);v([E()],f.prototype,"showDeleteAccount",2);v([E()],f.prototype,"deleteInputValue",2);v([E()],f.prototype,"subscribing",2);v([E()],f.prototype,"subscribed",2);f=v([x("pg-settings")],f);
//# sourceMappingURL=components-bundle.js.map
