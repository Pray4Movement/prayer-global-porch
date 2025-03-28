/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const X=globalThis,dt=X.ShadowRoot&&(X.ShadyCSS===void 0||X.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,pt=Symbol(),vt=new WeakMap;let Ut=class{constructor(t,e,a){if(this._$cssResult$=!0,a!==pt)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e}get styleSheet(){let t=this.o;const e=this.t;if(dt&&t===void 0){const a=e!==void 0&&e.length===1;a&&(t=vt.get(e)),t===void 0&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),a&&vt.set(e,t))}return t}toString(){return this.cssText}};const qt=s=>new Ut(typeof s=="string"?s:s+"",void 0,pt),ut=(s,...t)=>{const e=s.length===1?s[0]:t.reduce((a,i,r)=>a+(n=>{if(n._$cssResult$===!0)return n.cssText;if(typeof n=="number")return n;throw Error("Value passed to 'css' function must be a 'css' function result: "+n+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(i)+s[r+1],s[0]);return new Ut(e,s,pt)},Vt=(s,t)=>{if(dt)s.adoptedStyleSheets=t.map(e=>e instanceof CSSStyleSheet?e:e.styleSheet);else for(const e of t){const a=document.createElement("style"),i=X.litNonce;i!==void 0&&a.setAttribute("nonce",i),a.textContent=e.cssText,s.appendChild(a)}},bt=dt?s=>s:s=>s instanceof CSSStyleSheet?(t=>{let e="";for(const a of t.cssRules)e+=a.cssText;return qt(e)})(s):s;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:Ft,defineProperty:Jt,getOwnPropertyDescriptor:Wt,getOwnPropertyNames:Kt,getOwnPropertySymbols:Xt,getPrototypeOf:Zt}=Object,S=globalThis,wt=S.trustedTypes,Qt=wt?wt.emptyScript:"",rt=S.reactiveElementPolyfillSupport,q=(s,t)=>s,Z={toAttribute(s,t){switch(t){case Boolean:s=s?Qt:null;break;case Object:case Array:s=s==null?s:JSON.stringify(s)}return s},fromAttribute(s,t){let e=s;switch(t){case Boolean:e=s!==null;break;case Number:e=s===null?null:Number(s);break;case Object:case Array:try{e=JSON.parse(s)}catch{e=null}}return e}},gt=(s,t)=>!Ft(s,t),At={attribute:!0,type:String,converter:Z,reflect:!1,hasChanged:gt};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),S.litPropertyMetadata??(S.litPropertyMetadata=new WeakMap);class M extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??(this.l=[])).push(t)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,e=At){if(e.state&&(e.attribute=!1),this._$Ei(),this.elementProperties.set(t,e),!e.noAccessor){const a=Symbol(),i=this.getPropertyDescriptor(t,a,e);i!==void 0&&Jt(this.prototype,t,i)}}static getPropertyDescriptor(t,e,a){const{get:i,set:r}=Wt(this.prototype,t)??{get(){return this[e]},set(n){this[e]=n}};return{get(){return i==null?void 0:i.call(this)},set(n){const l=i==null?void 0:i.call(this);r.call(this,n),this.requestUpdate(t,l,a)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??At}static _$Ei(){if(this.hasOwnProperty(q("elementProperties")))return;const t=Zt(this);t.finalize(),t.l!==void 0&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties)}static finalize(){if(this.hasOwnProperty(q("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(q("properties"))){const e=this.properties,a=[...Kt(e),...Xt(e)];for(const i of a)this.createProperty(i,e[i])}const t=this[Symbol.metadata];if(t!==null){const e=litPropertyMetadata.get(t);if(e!==void 0)for(const[a,i]of e)this.elementProperties.set(a,i)}this._$Eh=new Map;for(const[e,a]of this.elementProperties){const i=this._$Eu(e,a);i!==void 0&&this._$Eh.set(i,e)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(t){const e=[];if(Array.isArray(t)){const a=new Set(t.flat(1/0).reverse());for(const i of a)e.unshift(bt(i))}else t!==void 0&&e.push(bt(t));return e}static _$Eu(t,e){const a=e.attribute;return a===!1?void 0:typeof a=="string"?a:typeof t=="string"?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var t;this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),(t=this.constructor.l)==null||t.forEach(e=>e(this))}addController(t){var e;(this._$EO??(this._$EO=new Set)).add(t),this.renderRoot!==void 0&&this.isConnected&&((e=t.hostConnected)==null||e.call(t))}removeController(t){var e;(e=this._$EO)==null||e.delete(t)}_$E_(){const t=new Map,e=this.constructor.elementProperties;for(const a of e.keys())this.hasOwnProperty(a)&&(t.set(a,this[a]),delete this[a]);t.size>0&&(this._$Ep=t)}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return Vt(t,this.constructor.elementStyles),t}connectedCallback(){var t;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(t=this._$EO)==null||t.forEach(e=>{var a;return(a=e.hostConnected)==null?void 0:a.call(e)})}enableUpdating(t){}disconnectedCallback(){var t;(t=this._$EO)==null||t.forEach(e=>{var a;return(a=e.hostDisconnected)==null?void 0:a.call(e)})}attributeChangedCallback(t,e,a){this._$AK(t,a)}_$EC(t,e){var r;const a=this.constructor.elementProperties.get(t),i=this.constructor._$Eu(t,a);if(i!==void 0&&a.reflect===!0){const n=(((r=a.converter)==null?void 0:r.toAttribute)!==void 0?a.converter:Z).toAttribute(e,a.type);this._$Em=t,n==null?this.removeAttribute(i):this.setAttribute(i,n),this._$Em=null}}_$AK(t,e){var r;const a=this.constructor,i=a._$Eh.get(t);if(i!==void 0&&this._$Em!==i){const n=a.getPropertyOptions(i),l=typeof n.converter=="function"?{fromAttribute:n.converter}:((r=n.converter)==null?void 0:r.fromAttribute)!==void 0?n.converter:Z;this._$Em=i,this[i]=l.fromAttribute(e,n.type),this._$Em=null}}requestUpdate(t,e,a){if(t!==void 0){if(a??(a=this.constructor.getPropertyOptions(t)),!(a.hasChanged??gt)(this[t],e))return;this.P(t,e,a)}this.isUpdatePending===!1&&(this._$ES=this._$ET())}P(t,e,a){this._$AL.has(t)||this._$AL.set(t,e),a.reflect===!0&&this._$Em!==t&&(this._$Ej??(this._$Ej=new Set)).add(t)}async _$ET(){this.isUpdatePending=!0;try{await this._$ES}catch(e){Promise.reject(e)}const t=this.scheduleUpdate();return t!=null&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var a;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[r,n]of this._$Ep)this[r]=n;this._$Ep=void 0}const i=this.constructor.elementProperties;if(i.size>0)for(const[r,n]of i)n.wrapped!==!0||this._$AL.has(r)||this[r]===void 0||this.P(r,this[r],n)}let t=!1;const e=this._$AL;try{t=this.shouldUpdate(e),t?(this.willUpdate(e),(a=this._$EO)==null||a.forEach(i=>{var r;return(r=i.hostUpdate)==null?void 0:r.call(i)}),this.update(e)):this._$EU()}catch(i){throw t=!1,this._$EU(),i}t&&this._$AE(e)}willUpdate(t){}_$AE(t){var e;(e=this._$EO)==null||e.forEach(a=>{var i;return(i=a.hostUpdated)==null?void 0:i.call(a)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(t){return!0}update(t){this._$Ej&&(this._$Ej=this._$Ej.forEach(e=>this._$EC(e,this[e]))),this._$EU()}updated(t){}firstUpdated(t){}}M.elementStyles=[],M.shadowRootOptions={mode:"open"},M[q("elementProperties")]=new Map,M[q("finalized")]=new Map,rt==null||rt({ReactiveElement:M}),(S.reactiveElementVersions??(S.reactiveElementVersions=[])).push("2.0.4");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const V=globalThis,Q=V.trustedTypes,Ot=Q?Q.createPolicy("lit-html",{createHTML:s=>s}):void 0,It="$lit$",P=`lit$${Math.random().toFixed(9).slice(2)}$`,Nt="?"+P,Gt=`<${Nt}>`,U=document,F=()=>U.createComment(""),J=s=>s===null||typeof s!="object"&&typeof s!="function",_t=Array.isArray,Yt=s=>_t(s)||typeof(s==null?void 0:s[Symbol.iterator])=="function",ot=`[ 	
\f\r]`,L=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,xt=/-->/g,jt=/>/g,T=RegExp(`>|${ot}(?:([^\\s"'>=/]+)(${ot}*=${ot}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),Pt=/'/g,St=/"/g,Mt=/^(?:script|style|textarea|title)$/i,te=s=>(t,...e)=>({_$litType$:s,strings:t,values:e}),h=te(1),I=Symbol.for("lit-noChange"),m=Symbol.for("lit-nothing"),Et=new WeakMap,D=U.createTreeWalker(U,129);function Ht(s,t){if(!_t(s)||!s.hasOwnProperty("raw"))throw Error("invalid template strings array");return Ot!==void 0?Ot.createHTML(t):t}const ee=(s,t)=>{const e=s.length-1,a=[];let i,r=t===2?"<svg>":t===3?"<math>":"",n=L;for(let l=0;l<e;l++){const o=s[l];let d,p,c=-1,_=0;for(;_<o.length&&(n.lastIndex=_,p=n.exec(o),p!==null);)_=n.lastIndex,n===L?p[1]==="!--"?n=xt:p[1]!==void 0?n=jt:p[2]!==void 0?(Mt.test(p[2])&&(i=RegExp("</"+p[2],"g")),n=T):p[3]!==void 0&&(n=T):n===T?p[0]===">"?(n=i??L,c=-1):p[1]===void 0?c=-2:(c=n.lastIndex-p[2].length,d=p[1],n=p[3]===void 0?T:p[3]==='"'?St:Pt):n===St||n===Pt?n=T:n===xt||n===jt?n=L:(n=T,i=void 0);const u=n===T&&s[l+1].startsWith("/>")?" ":"";r+=n===L?o+Gt:c>=0?(a.push(d),o.slice(0,c)+It+o.slice(c)+P+u):o+P+(c===-2?l:u)}return[Ht(s,r+(s[e]||"<?>")+(t===2?"</svg>":t===3?"</math>":"")),a]};class W{constructor({strings:t,_$litType$:e},a){let i;this.parts=[];let r=0,n=0;const l=t.length-1,o=this.parts,[d,p]=ee(t,e);if(this.el=W.createElement(d,a),D.currentNode=this.el.content,e===2||e===3){const c=this.el.content.firstChild;c.replaceWith(...c.childNodes)}for(;(i=D.nextNode())!==null&&o.length<l;){if(i.nodeType===1){if(i.hasAttributes())for(const c of i.getAttributeNames())if(c.endsWith(It)){const _=p[n++],u=i.getAttribute(c).split(P),y=/([.?@])?(.*)/.exec(_);o.push({type:1,index:r,name:y[2],strings:u,ctor:y[1]==="."?ie:y[1]==="?"?ae:y[1]==="@"?ne:it}),i.removeAttribute(c)}else c.startsWith(P)&&(o.push({type:6,index:r}),i.removeAttribute(c));if(Mt.test(i.tagName)){const c=i.textContent.split(P),_=c.length-1;if(_>0){i.textContent=Q?Q.emptyScript:"";for(let u=0;u<_;u++)i.append(c[u],F()),D.nextNode(),o.push({type:2,index:++r});i.append(c[_],F())}}}else if(i.nodeType===8)if(i.data===Nt)o.push({type:2,index:r});else{let c=-1;for(;(c=i.data.indexOf(P,c+1))!==-1;)o.push({type:7,index:r}),c+=P.length-1}r++}}static createElement(t,e){const a=U.createElement("template");return a.innerHTML=t,a}}function H(s,t,e=s,a){var n,l;if(t===I)return t;let i=a!==void 0?(n=e._$Co)==null?void 0:n[a]:e._$Cl;const r=J(t)?void 0:t._$litDirective$;return(i==null?void 0:i.constructor)!==r&&((l=i==null?void 0:i._$AO)==null||l.call(i,!1),r===void 0?i=void 0:(i=new r(s),i._$AT(s,e,a)),a!==void 0?(e._$Co??(e._$Co=[]))[a]=i:e._$Cl=i),i!==void 0&&(t=H(s,i._$AS(s,t.values),i,a)),t}let se=class{constructor(t,e){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=e}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:e},parts:a}=this._$AD,i=((t==null?void 0:t.creationScope)??U).importNode(e,!0);D.currentNode=i;let r=D.nextNode(),n=0,l=0,o=a[0];for(;o!==void 0;){if(n===o.index){let d;o.type===2?d=new z(r,r.nextSibling,this,t):o.type===1?d=new o.ctor(r,o.name,o.strings,this,t):o.type===6&&(d=new re(r,this,t)),this._$AV.push(d),o=a[++l]}n!==(o==null?void 0:o.index)&&(r=D.nextNode(),n++)}return D.currentNode=U,i}p(t){let e=0;for(const a of this._$AV)a!==void 0&&(a.strings!==void 0?(a._$AI(t,a,e),e+=a.strings.length-2):a._$AI(t[e])),e++}};class z{get _$AU(){var t;return((t=this._$AM)==null?void 0:t._$AU)??this._$Cv}constructor(t,e,a,i){this.type=2,this._$AH=m,this._$AN=void 0,this._$AA=t,this._$AB=e,this._$AM=a,this.options=i,this._$Cv=(i==null?void 0:i.isConnected)??!0}get parentNode(){let t=this._$AA.parentNode;const e=this._$AM;return e!==void 0&&(t==null?void 0:t.nodeType)===11&&(t=e.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,e=this){t=H(this,t,e),J(t)?t===m||t==null||t===""?(this._$AH!==m&&this._$AR(),this._$AH=m):t!==this._$AH&&t!==I&&this._(t):t._$litType$!==void 0?this.$(t):t.nodeType!==void 0?this.T(t):Yt(t)?this.k(t):this._(t)}O(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}T(t){this._$AH!==t&&(this._$AR(),this._$AH=this.O(t))}_(t){this._$AH!==m&&J(this._$AH)?this._$AA.nextSibling.data=t:this.T(U.createTextNode(t)),this._$AH=t}$(t){var r;const{values:e,_$litType$:a}=t,i=typeof a=="number"?this._$AC(t):(a.el===void 0&&(a.el=W.createElement(Ht(a.h,a.h[0]),this.options)),a);if(((r=this._$AH)==null?void 0:r._$AD)===i)this._$AH.p(e);else{const n=new se(i,this),l=n.u(this.options);n.p(e),this.T(l),this._$AH=n}}_$AC(t){let e=Et.get(t.strings);return e===void 0&&Et.set(t.strings,e=new W(t)),e}k(t){_t(this._$AH)||(this._$AH=[],this._$AR());const e=this._$AH;let a,i=0;for(const r of t)i===e.length?e.push(a=new z(this.O(F()),this.O(F()),this,this.options)):a=e[i],a._$AI(r),i++;i<e.length&&(this._$AR(a&&a._$AB.nextSibling,i),e.length=i)}_$AR(t=this._$AA.nextSibling,e){var a;for((a=this._$AP)==null?void 0:a.call(this,!1,!0,e);t&&t!==this._$AB;){const i=t.nextSibling;t.remove(),t=i}}setConnected(t){var e;this._$AM===void 0&&(this._$Cv=t,(e=this._$AP)==null||e.call(this,t))}}class it{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,e,a,i,r){this.type=1,this._$AH=m,this._$AN=void 0,this.element=t,this.name=e,this._$AM=i,this.options=r,a.length>2||a[0]!==""||a[1]!==""?(this._$AH=Array(a.length-1).fill(new String),this.strings=a):this._$AH=m}_$AI(t,e=this,a,i){const r=this.strings;let n=!1;if(r===void 0)t=H(this,t,e,0),n=!J(t)||t!==this._$AH&&t!==I,n&&(this._$AH=t);else{const l=t;let o,d;for(t=r[0],o=0;o<r.length-1;o++)d=H(this,l[a+o],e,o),d===I&&(d=this._$AH[o]),n||(n=!J(d)||d!==this._$AH[o]),d===m?t=m:t!==m&&(t+=(d??"")+r[o+1]),this._$AH[o]=d}n&&!i&&this.j(t)}j(t){t===m?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"")}}class ie extends it{constructor(){super(...arguments),this.type=3}j(t){this.element[this.name]=t===m?void 0:t}}class ae extends it{constructor(){super(...arguments),this.type=4}j(t){this.element.toggleAttribute(this.name,!!t&&t!==m)}}class ne extends it{constructor(t,e,a,i,r){super(t,e,a,i,r),this.type=5}_$AI(t,e=this){if((t=H(this,t,e,0)??m)===I)return;const a=this._$AH,i=t===m&&a!==m||t.capture!==a.capture||t.once!==a.once||t.passive!==a.passive,r=t!==m&&(a===m||i);i&&this.element.removeEventListener(this.name,this,a),r&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var e;typeof this._$AH=="function"?this._$AH.call(((e=this.options)==null?void 0:e.host)??this.element,t):this._$AH.handleEvent(t)}}class re{constructor(t,e,a){this.element=t,this.type=6,this._$AN=void 0,this._$AM=e,this.options=a}get _$AU(){return this._$AM._$AU}_$AI(t){H(this,t)}}const oe={I:z},lt=V.litHtmlPolyfillSupport;lt==null||lt(W,z),(V.litHtmlVersions??(V.litHtmlVersions=[])).push("3.2.1");const le=(s,t,e)=>{const a=(e==null?void 0:e.renderBefore)??t;let i=a._$litPart$;if(i===void 0){const r=(e==null?void 0:e.renderBefore)??null;a._$litPart$=i=new z(t.insertBefore(F(),r),r,void 0,e??{})}return i._$AI(s),i};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */let E=class extends M{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var e;const t=super.createRenderRoot();return(e=this.renderOptions).renderBefore??(e.renderBefore=t.firstChild),t}update(t){const e=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=le(e,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),(t=this._$Do)==null||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),(t=this._$Do)==null||t.setConnected(!1)}render(){return I}};var Dt;E._$litElement$=!0,E.finalized=!0,(Dt=globalThis.litElementHydrateSupport)==null||Dt.call(globalThis,{LitElement:E});const ct=globalThis.litElementPolyfillSupport;ct==null||ct({LitElement:E});(globalThis.litElementVersions??(globalThis.litElementVersions=[])).push("4.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const b=s=>(t,e)=>{e!==void 0?e.addInitializer(()=>{customElements.define(s,t)}):customElements.define(s,t)};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const ce={attribute:!0,type:String,converter:Z,reflect:!1,hasChanged:gt},he=(s=ce,t,e)=>{const{kind:a,metadata:i}=e;let r=globalThis.litPropertyMetadata.get(i);if(r===void 0&&globalThis.litPropertyMetadata.set(i,r=new Map),r.set(e.name,s),a==="accessor"){const{name:n}=e;return{set(l){const o=t.get.call(this);t.set.call(this,l),this.requestUpdate(n,o,s)},init(l){return l!==void 0&&this.P(n,void 0,s),l}}}if(a==="setter"){const{name:n}=e;return function(l){const o=this[n];t.call(this,l),this.requestUpdate(n,o,s)}}throw Error("Unsupported decorator location: "+a)};function $(s){return(t,e)=>typeof e=="object"?he(s,t,e):((a,i,r)=>{const n=i.hasOwnProperty(r);return i.constructor.createProperty(r,n?{...a,wrapped:!0}:a),n?Object.getOwnPropertyDescriptor(i,r):void 0})(s,t,e)}/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */function g(s){return $({...s,state:!0,attribute:!1})}var de=Object.defineProperty,pe=Object.getOwnPropertyDescriptor,zt=(s,t,e,a)=>{for(var i=a>1?void 0:a?pe(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&de(t,e,i),i};let G=class extends E{constructor(){super(...arguments),this.text=""}updated(s){s.has("text")&&document.querySelectorAll("pg-avatar").forEach(e=>{e.text!==this.text&&(e.text=this.text)})}getInitials(s){const t=s.split(" ").map(e=>e[0]).join("").toUpperCase().slice(0,2);return t.length===0?"?":t}render(){return h`
      <div class="circle">
        <div>${this.getInitials(this.text)}</div>
      </div>
    `}};G.styles=[ut`
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
    `];zt([$({type:String})],G.prototype,"text",2);G=zt([b("pg-avatar")],G);class j extends E{constructor(){super()}createRenderRoot(){return this}}function ue(s){return s?JSON.parse('{"'+s.substring(1).replace(/&/g,'","').replace(/=/g,'":"')+'"}'):{}}function ge(s,t){let e={};const a=s.split("/").filter(r=>r!=""),i=t.split("/").filter(r=>r!="");return a.map((r,n)=>{/^:/.test(r)&&(e[r.substring(1)]=i[n])}),e}function _e(s){return s?new RegExp("^(|/)"+s.replace(/:[^\s/]+/g,"([\\wÀ-ÖØ-öø-ÿ-]+)")+"(|/)$"):new RegExp("(^$|^/$)")}function ye(s,t){if(_e(t).test(s))return!0}function me(s){return class extends s{static get properties(){return{route:{type:String,reflect:!0,attribute:"route"},canceled:{type:Boolean}}}constructor(...t){super(...t),this.route="",this.canceled=!1}connectedCallback(...t){super.connectedCallback(...t),this.routing(this.constructor.routes,(...e)=>this.router(...e)),window.addEventListener("route",()=>{this.routing(this.constructor.routes,(...e)=>this.router(...e))}),window.onpopstate=()=>{window.dispatchEvent(new CustomEvent("route"))}}routed(t,e,a,i,r,n){n&&n(t,e,a,i),r(t,e,a,i)}routing(t,e){this.canceled=!0;const a=decodeURI(window.location.pathname),i=decodeURI(window.location.search);let r=t.filter(o=>o.pattern==="*")[0],n=t.filter(o=>o.pattern!=="*"&&ye(a,o.pattern))[0],l=ue(i);n?(n.params=ge(n.pattern,a),n.data=n.data||{},n.authentication&&n.authentication.authenticate&&typeof n.authentication.authenticate=="function"?(this.canceled=!1,Promise.resolve(n.authentication.authenticate.bind(this).call()).then(o=>{this.canceled||(o?n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(d=>{this.canceled||(d?this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,l,n.data,e,n.callback))})):this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authentication.unauthenticated.name,n.params,l,n.data,e,n.callback))})):n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(o=>{this.canceled||(o?this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,l,n.data,e,n.callback))})):this.routed(n.name,n.params,l,n.data,e,n.callback)):r&&(r.data=r.data||{},this.routed(r.name,{},l,r.data,e,r.callback))}}}function yt(s){return class extends s{navigate(t){window.history.pushState({},null,t),window.dispatchEvent(new CustomEvent("route"))}}}var $e=Object.defineProperty,fe=Object.getOwnPropertyDescriptor,mt=(s,t,e,a)=>{for(var i=a>1?void 0:a?fe(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&$e(t,e,i),i};let Y=class extends yt(j){constructor(){super(...arguments),this.title="",this.backUrl=""}render(){return h`
      <div class="page-header">
        <div class="container d-flex align-items-center">
          <button
            type="button"
            class="me-auto"
            @click=${()=>this.navigate(this.backUrl)}
          >
            <svg class="icon-md">
              <use
                href="${window.jsObject.spritesheet_url}#pg-chevron-left"
              ></use>
            </svg>
          </button>
          <h3 class="mb-0 me-auto">${this.title}</h3>
        </div>
      </div>
    `}};mt([$({type:String})],Y.prototype,"title",2);mt([$({type:String})],Y.prototype,"backUrl",2);Y=mt([b("pg-header")],Y);var ve=Object.defineProperty,be=Object.getOwnPropertyDescriptor,Lt=(s,t,e,a)=>{for(var i=a>1?void 0:a?be(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&ve(t,e,i),i};let tt=class extends E{constructor(){super(...arguments),this.open=!1,this.modalId=this.generateId()}generateId(){return Array(6).fill("").map(()=>String.fromCharCode(97+Math.floor(Math.random()*26))).join("")}render(){return h`
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
    `}close(){this.dispatchEvent(new CustomEvent("close"))}};tt.styles=[ut`
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
    `];Lt([$({type:Boolean})],tt.prototype,"open",2);tt=Lt([b("pg-modal")],tt);var we=Object.defineProperty,Ae=Object.getOwnPropertyDescriptor,Bt=(s,t,e,a)=>{for(var i=a>1?void 0:a?Ae(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&we(t,e,i),i};let et=class extends yt(E){constructor(){super(),this.href="",this.setAttribute("tabindex","0"),this.setAttribute("role","link"),this.addEventListener("click",this.handleClick),this.addEventListener("keydown",this.handleKeydown)}handleClick(s){s.preventDefault();const{href:t}=s.currentTarget;this.navigate(t)}handleKeydown(s){(s.key==="Enter"||s.key===" ")&&(s.preventDefault(),this.navigate(this.href))}render(){return h` <slot></slot> `}};et.styles=ut`
    :host {
      cursor: pointer;
    }
    a {
      color: inherit;
      text-decoration: inherit;
    }
    a:hover {
      text-decoration: underline;
    }
  `;Bt([$({type:String})],et.prototype,"href",2);et=Bt([b("nav-link")],et);var Oe=Object.defineProperty,xe=Object.getOwnPropertyDescriptor,w=(s,t,e,a)=>{for(var i=a>1?void 0:a?xe(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&Oe(t,e,i),i};let f=class extends j{constructor(){super(...arguments),this.name="",this.lapNumber=0,this.progress=0,this.translations={},this.spritesheetUrl="",this.relayType="global",this.visibility="public",this.urlRoot="",this.hiddenRelay=!1,this.isOwner=!1,this.token=""}connectedCallback(){super.connectedCallback(),this.token=this.name.replace(/\s+/g,"-")}renderIcon(){const t={global:"pg-logo-prayer",custom:this.visibility==="private"?"pg-private":"pg-world-light"}[this.relayType]||"pg-logo-prayer";return h`
      <svg>
        <use href="${this.spritesheetUrl}#${t}"></use>
      </svg>
    `}render(){return h`
      <div
        role="listitem"
        class="relay-item"
        data-type=${this.relayType}
        data-visibility=${this.visibility}
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
                    ${window.isMobile()?"":h`
                          <li>
                            <a
                              class="dropdown-item"
                              href="${this.urlRoot}/display"
                            >
                              ${this.translations.display}
                            </a>
                          </li>
                        `}
                    ${this.isOwner?h` <li
                          class="dropdown-item"
                          role="button"
                          @click=${()=>this.dispatchEvent(new CustomEvent("edit"))}
                        >
                          ${this.translations.edit}
                        </li>`:""}
                  `:""}
              ${this.hiddenRelay?h`
                    <li
                      class="dropdown-item"
                      role="button"
                      @click=${()=>this.dispatchEvent(new CustomEvent("unhide"))}
                    >
                      ${this.translations.unhide}
                    </li>
                  `:h`
                    <li
                      class="dropdown-item"
                      role="button"
                      @click=${()=>this.dispatchEvent(new CustomEvent("hide"))}
                    >
                      ${this.translations.hide}
                    </li>
                  `}
            </ul>
            <a href=${this.urlRoot} class="btn btn-cta">
              ${this.translations.pray}
            </a>
          </div>
        </div>
      </div>
    `}};w([$({type:String})],f.prototype,"name",2);w([$({type:Number})],f.prototype,"lapNumber",2);w([$({type:Number})],f.prototype,"progress",2);w([$({type:Object})],f.prototype,"translations",2);w([$({type:String})],f.prototype,"spritesheetUrl",2);w([$({type:String})],f.prototype,"relayType",2);w([$({type:String})],f.prototype,"visibility",2);w([$({type:String})],f.prototype,"urlRoot",2);w([$({type:Boolean})],f.prototype,"hiddenRelay",2);w([$({type:Boolean})],f.prototype,"isOwner",2);f=w([b("pg-relay-item")],f);var je=Object.defineProperty,Pe=Object.getOwnPropertyDescriptor,A=(s,t,e,a)=>{for(var i=a>1?void 0:a?Pe(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&je(t,e,i),i};let v=class extends j{constructor(){super(...arguments),this.translations=window.jsObject.translations,this.edit=!1,this.relay=null,this.type="",this.title="",this.showAdvancedOptions=!1,this.startDate="",this.startTime="",this.endDate="",this.endTime="",this.isSingle=!1}shouldUpdate(s){return s.has("relay")&&this.relay!==null&&(this.title=this.relay.post_title,this.type=this.relay.visibility,this.relay.start_time&&(this.startDate=window.toDateInputFormat(this.relay.start_time),this.startTime=window.toTimeInputFormat(this.relay.start_time)),this.relay.end_time&&(this.endDate=window.toDateInputFormat(this.relay.end_time),this.endTime=window.toTimeInputFormat(this.relay.end_time)),this.isSingle=this.relay.single_lap),super.shouldUpdate(s)}connectedCallback(){super.connectedCallback(),this.edit&&(this.showAdvancedOptions=!0)}handleChangeTitle(s){this.title=s}handleDateTimeChange(s,t){const e=s.target.value;this[t]=e}onSubmit(s){s.preventDefault();const t={title:this.title,visibility:this.type};if(this.startDate){const a=this.startTime?this.startTime:"00:00";t.start_date=new Date(`${this.startDate} ${a}`).getTime()/1e3}if(this.endDate){const a=this.endTime?this.endTime:"23:59";t.end_date=new Date(`${this.endDate} ${a}`).getTime()/1e3}this.isSingle&&(t.single_lap=!0),this.edit&&this.relay!==null&&(t.relay_id=this.relay.post_id);const e=this.edit?window.pg_global.root+"pg-api/v1/dashboard/edit_relay":window.pg_global.root+"pg-api/v1/dashboard/create_relay";window.api_fetch(e,{method:"POST",body:JSON.stringify(t)}).then(a=>{window.location.href="/dashboard/relays"})}openAdvancedOptions(){this.showAdvancedOptions=!0}setTimestampToNow(){this.startDate=window.toDateInputFormat(Date.now()/1e3),this.startTime=window.toTimeInputFormat(Date.now()/1e3)}render(){return h`
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
            value=${this.title}
            @input=${s=>this.handleChangeTitle(s.target.value)}
          />
        </label>
        ${this.showAdvancedOptions?h`
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
                    @input=${s=>this.handleDateTimeChange(s,"startDate")}
                  />
                  <input
                    type="time"
                    name="start-time"
                    id="start-time"
                    value=${this.startTime}
                    @input=${s=>this.handleDateTimeChange(s,"startTime")}
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
                    @input=${s=>this.handleDateTimeChange(s,"endDate")}
                  />
                  <input
                    type="time"
                    name="end-time"
                    id="end-time"
                    value=${this.endTime}
                    @input=${s=>this.handleDateTimeChange(s,"endTime")}
                  />
                </div>
              </label>
              <label class="form-group">
                <input
                  type="checkbox"
                  ?checked=${this.isSingle}
                  @change=${s=>this.isSingle=s.target.checked}
                />
                ${this.translations.single_lap_relay}
              </label>
            `:h`
              <button
                class="btn btn-outline-primary btn-small me-auto"
                @click=${this.openAdvancedOptions}
              >
                ${this.translations.advanced}
              </button>
            `}
        <div class="cluster ms-auto">
          <button
            class="btn btn-outline-primary btn-small"
            type="button"
            @click=${()=>this.dispatchEvent(new CustomEvent("cancel"))}
          >
            ${this.translations.cancel}
          </button>
          <button class="btn btn-primary btn-small">
            ${this.edit?this.translations.update:this.translations.create}
          </button>
        </div>
      </form>
    `}};A([$({type:Boolean})],v.prototype,"edit",2);A([$({type:Object})],v.prototype,"relay",2);A([g()],v.prototype,"type",2);A([g()],v.prototype,"title",2);A([g()],v.prototype,"showAdvancedOptions",2);A([g()],v.prototype,"startDate",2);A([g()],v.prototype,"startTime",2);A([g()],v.prototype,"endDate",2);A([g()],v.prototype,"endTime",2);A([g()],v.prototype,"isSingle",2);v=A([b("pg-relay-form")],v);var Se=Object.getOwnPropertyDescriptor,Ee=(s,t,e,a)=>{for(var i=a>1?void 0:a?Se(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=n(i)||i);return i};let Ct=class extends j{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return h`
      <pg-header
        backUrl="/dashboard"
        title=${this.translations.prayer_activity}
      ></pg-header>

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
    `}};Ct=Ee([b("pg-activity")],Ct);var Ce=Object.defineProperty,ke=Object.getOwnPropertyDescriptor,$t=(s,t,e,a)=>{for(var i=a>1?void 0:a?ke(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&Ce(t,e,i),i};let st=class extends j{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.relays=[],this.loading=!0,fetch(window.pg_global.root+"pg-api/v1/dashboard/relays",{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":window.pg_global.nonce},body:JSON.stringify({data:{user_id:this.user.id}})}).then(s=>s.json()).then(s=>{const{relays:t,hidden_relays:e}=s;this.relays=t.filter(a=>!e.includes(a.post_id))}).finally(()=>{this.loading=!1})}async connectedCallback(){super.connectedCallback(),this.user.location_hash.length||await this.getLocationFromIP(),await this.link_anonymous_prayers()}render(){return h`
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

              <div class="pg-container flow-small">
                <h3 class="text-center">${this.translations.prayer_relays}</h3>
                ${this.loading?h`<span class="loading-spinner active"></span>`:this.relays.map(s=>h`
                          <div
                            class="repel relay-item align-items-center"
                            data-type=${s.relay_type}
                            data-visibility=${s.visibility}
                          >
                            ${s.post_title}

                            <a
                              href=${`/prayer_app/${s.relay_type}/${s.lap_key}`}
                              class="btn btn-cta"
                            >
                              ${this.translations.pray}
                            </a>
                          </div>
                        `)}
              </div>

              <hr>

              <section class="text-center">
                <p>${this.translations.are_you_enjoying_the_app}</p>
                <p>${this.translations.would_you_like_to_partner}</p>
                <div class="d-flex flex-column m-auto w-fit">
                  <a
                    class="btn btn-small btn-primary-light uppercase"
                    data-reverse-color
                    href="/give"
                  >
                    ${this.translations.donate}
                  </a>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    `}async getLocationFromIP(){var t;const s=localStorage.getItem("user_location");this.user.location=s?JSON.parse(s):null,(t=this.user.location)!=null&&t.hash&&(this.user.location_hash=this.user.location.hash),(!this.user.location||this.user.location.date_set&&this.user.location.date_set<Date.now()-6048e5)&&await window.api_fetch("https://geo.prayer.global/json",{method:"GET"}).then(e=>{var a,i,r,n,l,o;if(e){const d={lat:e.location.latitude,lng:e.location.longitude,label:`${(i=(a=e.city)==null?void 0:a.names)==null?void 0:i.en}, ${(n=(r=e.country)==null?void 0:r.names)==null?void 0:n.en}`,country:(o=(l=e.country)==null?void 0:l.names)==null?void 0:o.en,date_set:Date.now(),source:"ip"};this.user.location=d;let p=localStorage.getItem("pg_user_hash");(!p||p==="undefined")&&(p=window.crypto.randomUUID(),localStorage.setItem("pg_user_hash",p),this.user.location_hash=p),this.user.location.hash=p,localStorage.setItem("user_location",JSON.stringify(this.user.location))}}),await window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/save_location`,{method:"POST",body:JSON.stringify({location_hash:this.user.location_hash,location:this.user.location})}),this.requestUpdate()}async link_anonymous_prayers(){const s=`${window.pg_global.root}pg-api/v1/dashboard/link_anonymous_prayers`;window.api_fetch(s,{method:"POST",body:JSON.stringify({location_hash:this.user.location_hash})})}};$t([g()],st.prototype,"relays",2);$t([g()],st.prototype,"loading",2);st=$t([b("pg-dashboard")],st);var Te=Object.defineProperty,Re=Object.getOwnPropertyDescriptor,at=(s,t,e,a)=>{for(var i=a>1?void 0:a?Re(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&Te(t,e,i),i};let K=class extends j{constructor(){super(),this.translations=window.jsObject.translations,this.step="choose-option",this.type="",this.openInfo=""}createRelay(s){this.step="new-relay",this.type=s}onCancel(){this.step="choose-option"}getIcon(){return`${window.jsObject.spritesheet_url}#${this.type==="public"?"pg-world-light":"pg-private"}`}getTitle(){return this.type==="public"?this.translations.create_public_relay:this.translations.create_private_relay}async handleOpenInfo(s,t){s.stopImmediatePropagation(),this.openInfo!==t?this.openInfo=t:this.openInfo=""}handleNavigate(){location.href="/relays"}render(){return h`
      <pg-header
        backUrl="/dashboard/relays"
        title=${this.translations.new_relay}
      ></pg-header>
      <div class="pg-container page" data-small>
        ${this.step==="choose-option"?h`
              <div class="seperated-list mx-auto align-items-start">
                <div
                  class="stack-sm align-items-stretch text-center px-2 py-4 w-100"
                >
                  <div
                    class="profile-link"
                    role="button"
                    @click=${this.handleNavigate}
                  >
                    <svg class="icon-md">
                      <use
                        href="${window.jsObject.spritesheet_url}#pg-relay"
                      ></use>
                    </svg>
                    <span>${this.translations.join_a_relay}</span>
                    <button
                      class="ms-auto d-inline-block p-2"
                      @click=${s=>this.handleOpenInfo(s,"join")}
                    >
                      <svg class="icon-sm">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-info"
                        ></use>
                      </svg>
                    </button>
                  </div>
                  ${this.openInfo==="join"?h`
                        <p class="info-text">
                          ${this.translations.join_a_relay_info}
                        </p>
                      `:""}
                </div>
                <div
                  class="stack-sm align-items-stretch text-center px-2 py-4 w-100"
                >
                  <div
                    class="profile-link"
                    role="button"
                    @click=${()=>this.createRelay("public")}
                  >
                    <svg class="icon-md">
                      <use
                        href="${window.jsObject.spritesheet_url}#pg-world-light"
                      ></use>
                    </svg>
                    <span>${this.translations.new_public_relay}</span>
                    <button
                      class="ms-auto d-inline-block p-2"
                      @click=${s=>this.handleOpenInfo(s,"create-public")}
                    >
                      <svg class="icon-sm">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-info"
                        ></use>
                      </svg>
                    </button>
                  </div>
                  ${this.openInfo==="create-public"?h`
                        <p class="info-text">
                          ${this.translations.create_public_relay_info}
                        </p>
                      `:""}
                </div>
                <div
                  class="stack-sm align-items-stretch text-center px-2 py-4 w-100"
                >
                  <div
                    class="profile-link"
                    role="button"
                    @click=${()=>this.createRelay("private")}
                  >
                    <svg class="icon-md">
                      <use
                        href="${window.jsObject.spritesheet_url}#pg-private"
                      ></use>
                    </svg>
                    <span>${this.translations.new_private_relay}</span>
                    <button
                      class="ms-auto d-inline-block p-2"
                      @click=${s=>this.handleOpenInfo(s,"create-private")}
                    >
                      <svg class="icon-sm">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-info"
                        ></use>
                      </svg>
                    </button>
                  </div>
                  ${this.openInfo==="create-private"?h`
                        <p class="info-text">
                          ${this.translations.create_private_relay_info}
                        </p>
                      `:""}
                </div>
              </div>
            `:""}
        ${this.step==="new-relay"?h`
              <div class="stack-md align-items-start">
                <h5 class="cluster">
                  <svg class="icon-lg">
                    <use href=${this.getIcon()}></use>
                  </svg>
                  ${this.getTitle()}
                </h5>
                <pg-relay-form
                  class="w-100"
                  .type=${this.type}
                  @cancel=${this.onCancel}
                ></pg-relay-form>
              </div>
            `:""}
      </div>
    `}};at([g()],K.prototype,"step",2);at([g()],K.prototype,"type",2);at([g()],K.prototype,"openInfo",2);K=at([b("pg-new-relay")],K);/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const De={CHILD:2},Ue=s=>(...t)=>({_$litDirective$:s,values:t});class Ie{constructor(t){}get _$AU(){return this._$AM._$AU}_$AT(t,e,a){this._$Ct=t,this._$AM=e,this._$Ci=a}_$AS(t,e){return this.update(t,e)}update(t,e){return this.render(...e)}}/**
 * @license
 * Copyright 2020 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{I:Ne}=oe,kt=()=>document.createComment(""),B=(s,t,e)=>{var r;const a=s._$AA.parentNode,i=t===void 0?s._$AB:t._$AA;if(e===void 0){const n=a.insertBefore(kt(),i),l=a.insertBefore(kt(),i);e=new Ne(n,l,s,s.options)}else{const n=e._$AB.nextSibling,l=e._$AM,o=l!==s;if(o){let d;(r=e._$AQ)==null||r.call(e,s),e._$AM=s,e._$AP!==void 0&&(d=s._$AU)!==l._$AU&&e._$AP(d)}if(n!==i||o){let d=e._$AA;for(;d!==n;){const p=d.nextSibling;a.insertBefore(d,i),d=p}}}return e},R=(s,t,e=s)=>(s._$AI(t,e),s),Me={},He=(s,t=Me)=>s._$AH=t,ze=s=>s._$AH,ht=s=>{var a;(a=s._$AP)==null||a.call(s,!1,!0);let t=s._$AA;const e=s._$AB.nextSibling;for(;t!==e;){const i=t.nextSibling;t.remove(),t=i}};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Tt=(s,t,e)=>{const a=new Map;for(let i=t;i<=e;i++)a.set(s[i],i);return a},Le=Ue(class extends Ie{constructor(s){if(super(s),s.type!==De.CHILD)throw Error("repeat() can only be used in text expressions")}dt(s,t,e){let a;e===void 0?e=t:t!==void 0&&(a=t);const i=[],r=[];let n=0;for(const l of s)i[n]=a?a(l,n):n,r[n]=e(l,n),n++;return{values:r,keys:i}}render(s,t,e){return this.dt(s,t,e).values}update(s,[t,e,a]){const i=ze(s),{values:r,keys:n}=this.dt(t,e,a);if(!Array.isArray(i))return this.ut=n,r;const l=this.ut??(this.ut=[]),o=[];let d,p,c=0,_=i.length-1,u=0,y=r.length-1;for(;c<=_&&u<=y;)if(i[c]===null)c++;else if(i[_]===null)_--;else if(l[c]===n[u])o[u]=R(i[c],r[u]),c++,u++;else if(l[_]===n[y])o[y]=R(i[_],r[y]),_--,y--;else if(l[c]===n[y])o[y]=R(i[c],r[y]),B(s,o[y+1],i[c]),c++,y--;else if(l[_]===n[u])o[u]=R(i[_],r[u]),B(s,i[c],i[_]),_--,u++;else if(d===void 0&&(d=Tt(n,u,y),p=Tt(l,c,_)),d.has(l[c]))if(d.has(l[_])){const O=p.get(n[u]),nt=O!==void 0?i[O]:null;if(nt===null){const ft=B(s,i[c]);R(ft,r[u]),o[u]=ft}else o[u]=R(nt,r[u]),B(s,i[c],nt),i[O]=null;u++}else ht(i[_]),_--;else ht(i[c]),c++;for(;u<=y;){const O=B(s,o[y+1]);R(O,r[u]),o[u++]=O}for(;c<=_;){const O=i[c++];O!==null&&ht(O)}return this.ut=n,He(s,o),I}});var Be=Object.defineProperty,qe=Object.getOwnPropertyDescriptor,N=(s,t,e,a)=>{for(var i=a>1?void 0:a?qe(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&Be(t,e,i),i};let C=class extends j{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.relays=[],this.hiddenRelays=[],this.showHiddenRelays=!1,this.loading=!0,this.editRelayModalOpen=!1,this.editRelay=null,fetch(window.pg_global.root+"pg-api/v1/dashboard/relays",{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":window.pg_global.nonce},body:JSON.stringify({data:{user_id:this.user.id}})}).then(s=>s.json()).then(s=>{const{relays:t,hidden_relays:e}=s;this.relays=t,this.hiddenRelays=e}).finally(()=>{this.loading=!1})}async handleHide(s){(await fetch(`${window.pg_global.root}pg-api/v1/dashboard/relays/hide?relay_id=${s.post_id}`,{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":window.pg_global.nonce}})).ok&&(this.hiddenRelays=[...this.hiddenRelays,s.post_id])}async handleUnhide(s){await window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/relays/unhide?relay_id=${s.post_id}`,{method:"POST"}),this.hiddenRelays=this.hiddenRelays.filter(t=>t!==s.post_id)}openEditRelayModal(s){this.editRelayModalOpen=!0,this.editRelay=this.relays.find(t=>t.post_id===s)||null}toggleHiddenRelays(){this.showHiddenRelays=!this.showHiddenRelays}closeModal(s){this.editRelayModalOpen=!1}render(){var s;return h`
      <pg-header
        backUrl="/dashboard"
        title=${this.translations.prayer_relays}
      ></pg-header>

      <div class="white-bg page px-3">
        <div class="pg-container stack-md" data-small data-stretch>
          ${this.loading?h`<div class="text-center">
                <span class="loading-spinner active"></span>
              </div>`:h`
                <div role="list" class="stack-md relay-list" data-stretch>
                  ${Le(this.relays,t=>t.post_id,t=>!this.showHiddenRelays&&this.hiddenRelays.includes(t.post_id)?"":h`
                        <pg-relay-item
                          key="${t.post_id}"
                          name="${t.post_title}"
                          lapNumber="${t.stats.lap_number}"
                          progress="${t.stats.completed_percent}"
                          relayType="${t.relay_type}"
                          visibility="${t.visibility}"
                          ?hiddenRelay=${this.hiddenRelays.includes(t.post_id)}
                          ?isOwner=${t.is_owner==="1"}
                          .translations="${{lap:this.translations.lap,pray:this.translations.pray,map:this.translations.map,share:this.translations.share,display:this.translations.display,edit:this.translations.edit,hide:this.translations.hide,unhide:this.translations.unhide}}"
                          spritesheetUrl="${window.jsObject.spritesheet_url}"
                          urlRoot="/prayer_app/${t.relay_type}/${t.lap_key}"
                          @hide=${()=>this.handleHide(t)}
                          @unhide=${()=>this.handleUnhide(t)}
                          @edit=${()=>this.openEditRelayModal(t.post_id)}
                        ></pg-relay-item>
                      `)}
                  ${this.relays.some(t=>t.relay_type==="custom")?"":h`
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
                    <div class="stack-sm brand">
                      <svg class="icon-lg">
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
          <pg-modal
            id="edit-relay-modal"
            ?open=${this.editRelayModalOpen}
            @close=${()=>this.closeModal("edit-relay-modal")}
          >
            <h2 slot="title" class="h5 cluster">
              <svg class="icon-md">
                <use
                  href="${window.jsObject.spritesheet_url}#${((s=this.editRelay)==null?void 0:s.visibility)==="private"?"pg-private":"pg-world-light"}"
                ></use>
              </svg>
              ${this.translations.edit_relay}
            </h2>
            <pg-relay-form
              slot="body"
              edit
              .relay=${this.editRelay}
              @cancel=${()=>this.closeModal("edit-relay-modal")}
            ></pg-relay-form>
          </pg-modal>
        </div>
      </div>
    `}};N([g()],C.prototype,"relays",2);N([g()],C.prototype,"hiddenRelays",2);N([g()],C.prototype,"showHiddenRelays",2);N([g()],C.prototype,"loading",2);N([g()],C.prototype,"editRelayModalOpen",2);N([g()],C.prototype,"editRelay",2);C=N([b("pg-relays")],C);var Ve=Object.getOwnPropertyDescriptor,Fe=(s,t,e,a)=>{for(var i=a>1?void 0:a?Ve(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=n(i)||i);return i};let Rt=class extends yt(me(j)){constructor(){super(...arguments),this.route="",this.params={},this.query={},this.data={}}static get properties(){return{route:{type:String},params:{type:Object},query:{type:Object},data:{type:Object}}}static get routes(){return[{name:"dashboard",pattern:"/dashboard",data:{render:()=>h`<pg-dashboard></pg-dashboard>`}},{name:"prayer-relays",pattern:"/dashboard/relays",data:{render:()=>h`<pg-relays></pg-relays>`}},{name:"prayer-activity",pattern:"/dashboard/activity",data:{render:()=>h`<pg-activity></pg-activity>`}},{name:"profile-settings",pattern:"/dashboard/settings",data:{render:()=>h`<pg-settings></pg-settings>`}},{name:"new-relay",pattern:"/dashboard/new-relay",data:{render:()=>h`<pg-new-relay></pg-new-relay>`}}]}router(s,t,e,a){this.route=s,this.params=t,this.query=e,this.data=a}render(){var s;return h` ${((s=this.data)==null?void 0:s.render)&&this.data.render()} `}};Rt=Fe([b("pg-router")],Rt);var Je=Object.defineProperty,We=Object.getOwnPropertyDescriptor,k=(s,t,e,a)=>{for(var i=a>1?void 0:a?We(t,e):t,r=s.length-1,n;r>=0;r--)(n=s[r])&&(i=(a?n(t,e,i):n(i))||i);return a&&i&&Je(t,e,i),i};let x=class extends j{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.currentLanguage=window.jsObject.current_language,this.language=null,this.showEditAccount=!1,this.saving=!1,this.name=this.user.display_name,this.showDeleteAccount=!1,this.deleteInputValue="",this.subscribing=!1,this.subscribed=!1;const s=window.jsObject.current_language;Object.keys(window.jsObject.languages).includes(s)&&(this.language=window.jsObject.languages[s])}back(){history.back()}subsribeToNews(){this.subscribing=!0,window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/subscribe_to_news`,{method:"POST"}).then(s=>{s===!0&&(this.subscribed=!0)}).finally(()=>{this.subscribing=!1})}openEditAccount(){this.showEditAccount=!0}closeEditAccount(){this.showEditAccount=!1}editAccount(){var t;this.user.display_name=this.name,this.saving=!0;const s={display_name:this.name,location:this.user.location,language:(t=this.language)==null?void 0:t.po_code};window.location_data&&window.location_data.location_grid_meta&&window.location_data.location_grid_meta.values&&Array.isArray(window.location_data.location_grid_meta.values)&&window.location_data.location_grid_meta.values.length>0&&(s.location=window.location_data.location_grid_meta.values[0],this.user={...this.user,location:s.location}),window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/save_details`,{method:"POST",body:JSON.stringify(s)}).finally(()=>{if(this.language&&this.language.po_code!==this.currentLanguage){const e=new URLSearchParams(window.location.search);e.set("lang",this.language.po_code),window.location.search=e.toString()}this.closeEditAccount(),this.saving=!1})}openDeleteAccount(){this.showDeleteAccount=!0}closeDeleteAccount(){this.showDeleteAccount=!1}deleteAccount(){window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/delete_user`,{method:"POST"}).then(s=>{s===!0&&(window.location.href="/")})}handleChangeName(s){this.name=s}handleChangeLanguage(s){const t=s.target.value;this.language=window.jsObject.languages[t]??null,console.log(this.language)}handleChangeLocation(s){const t=s.target.value;t[0]&&(this.user.location=t[0])}render(){var s;return h`
      <pg-header
        backUrl="/dashboard"
        title=${this.translations.profile}
      ></pg-header>

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

            <label for="location">
              ${this.translations.location_text}
              <dt-location-map
                name="location"
                .value="${[this.user.location]}"
                mapbox-token=${window.pg_global.map_key}
                mapboxToken=${window.pg_global.map_key}
                limit="1"
                @change=${this.handleChangeLocation}
                onchange=${this.handleChangeLocation}
              ></dt-location-map>
            </label>

            <label for="language">
              ${this.translations.language}
              <select
                class="form-select"
                id="language"
                @change=${this.handleChangeLanguage}
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
    `}};k([g()],x.prototype,"showEditAccount",2);k([g()],x.prototype,"saving",2);k([g()],x.prototype,"name",2);k([g()],x.prototype,"showDeleteAccount",2);k([g()],x.prototype,"deleteInputValue",2);k([g()],x.prototype,"subscribing",2);k([g()],x.prototype,"subscribed",2);x=k([b("pg-settings")],x);
//# sourceMappingURL=components-bundle.js.map
