/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const T=globalThis,J=T.ShadowRoot&&(T.ShadyCSS===void 0||T.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,ut=Symbol(),it=new WeakMap;let Dt=class{constructor(t,e,r){if(this._$cssResult$=!0,r!==ut)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e}get styleSheet(){let t=this.o;const e=this.t;if(J&&t===void 0){const r=e!==void 0&&e.length===1;r&&(t=it.get(e)),t===void 0&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),r&&it.set(e,t))}return t}toString(){return this.cssText}};const Lt=s=>new Dt(typeof s=="string"?s:s+"",void 0,ut),Bt=(s,t)=>{if(J)s.adoptedStyleSheets=t.map(e=>e instanceof CSSStyleSheet?e:e.styleSheet);else for(const e of t){const r=document.createElement("style"),i=T.litNonce;i!==void 0&&r.setAttribute("nonce",i),r.textContent=e.cssText,s.appendChild(r)}},rt=J?s=>s:s=>s instanceof CSSStyleSheet?(t=>{let e="";for(const r of t.cssRules)e+=r.cssText;return Lt(e)})(s):s;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:Ft,defineProperty:Wt,getOwnPropertyDescriptor:Vt,getOwnPropertyNames:qt,getOwnPropertySymbols:Jt,getPrototypeOf:Kt}=Object,f=globalThis,ot=f.trustedTypes,Zt=ot?ot.emptyScript:"",z=f.reactiveElementPolyfillSupport,E=(s,t)=>s,B={toAttribute(s,t){switch(t){case Boolean:s=s?Zt:null;break;case Object:case Array:s=s==null?s:JSON.stringify(s)}return s},fromAttribute(s,t){let e=s;switch(t){case Boolean:e=s!==null;break;case Number:e=s===null?null:Number(s);break;case Object:case Array:try{e=JSON.parse(s)}catch{e=null}}return e}},$t=(s,t)=>!Ft(s,t),nt={attribute:!0,type:String,converter:B,reflect:!1,hasChanged:$t};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),f.litPropertyMetadata??(f.litPropertyMetadata=new WeakMap);class A extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??(this.l=[])).push(t)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,e=nt){if(e.state&&(e.attribute=!1),this._$Ei(),this.elementProperties.set(t,e),!e.noAccessor){const r=Symbol(),i=this.getPropertyDescriptor(t,r,e);i!==void 0&&Wt(this.prototype,t,i)}}static getPropertyDescriptor(t,e,r){const{get:i,set:o}=Vt(this.prototype,t)??{get(){return this[e]},set(n){this[e]=n}};return{get(){return i==null?void 0:i.call(this)},set(n){const h=i==null?void 0:i.call(this);o.call(this,n),this.requestUpdate(t,h,r)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??nt}static _$Ei(){if(this.hasOwnProperty(E("elementProperties")))return;const t=Kt(this);t.finalize(),t.l!==void 0&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties)}static finalize(){if(this.hasOwnProperty(E("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(E("properties"))){const e=this.properties,r=[...qt(e),...Jt(e)];for(const i of r)this.createProperty(i,e[i])}const t=this[Symbol.metadata];if(t!==null){const e=litPropertyMetadata.get(t);if(e!==void 0)for(const[r,i]of e)this.elementProperties.set(r,i)}this._$Eh=new Map;for(const[e,r]of this.elementProperties){const i=this._$Eu(e,r);i!==void 0&&this._$Eh.set(i,e)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(t){const e=[];if(Array.isArray(t)){const r=new Set(t.flat(1/0).reverse());for(const i of r)e.unshift(rt(i))}else t!==void 0&&e.push(rt(t));return e}static _$Eu(t,e){const r=e.attribute;return r===!1?void 0:typeof r=="string"?r:typeof t=="string"?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var t;this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),(t=this.constructor.l)==null||t.forEach(e=>e(this))}addController(t){var e;(this._$EO??(this._$EO=new Set)).add(t),this.renderRoot!==void 0&&this.isConnected&&((e=t.hostConnected)==null||e.call(t))}removeController(t){var e;(e=this._$EO)==null||e.delete(t)}_$E_(){const t=new Map,e=this.constructor.elementProperties;for(const r of e.keys())this.hasOwnProperty(r)&&(t.set(r,this[r]),delete this[r]);t.size>0&&(this._$Ep=t)}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return Bt(t,this.constructor.elementStyles),t}connectedCallback(){var t;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(t=this._$EO)==null||t.forEach(e=>{var r;return(r=e.hostConnected)==null?void 0:r.call(e)})}enableUpdating(t){}disconnectedCallback(){var t;(t=this._$EO)==null||t.forEach(e=>{var r;return(r=e.hostDisconnected)==null?void 0:r.call(e)})}attributeChangedCallback(t,e,r){this._$AK(t,r)}_$EC(t,e){var o;const r=this.constructor.elementProperties.get(t),i=this.constructor._$Eu(t,r);if(i!==void 0&&r.reflect===!0){const n=(((o=r.converter)==null?void 0:o.toAttribute)!==void 0?r.converter:B).toAttribute(e,r.type);this._$Em=t,n==null?this.removeAttribute(i):this.setAttribute(i,n),this._$Em=null}}_$AK(t,e){var o;const r=this.constructor,i=r._$Eh.get(t);if(i!==void 0&&this._$Em!==i){const n=r.getPropertyOptions(i),h=typeof n.converter=="function"?{fromAttribute:n.converter}:((o=n.converter)==null?void 0:o.fromAttribute)!==void 0?n.converter:B;this._$Em=i,this[i]=h.fromAttribute(e,n.type),this._$Em=null}}requestUpdate(t,e,r){if(t!==void 0){if(r??(r=this.constructor.getPropertyOptions(t)),!(r.hasChanged??$t)(this[t],e))return;this.P(t,e,r)}this.isUpdatePending===!1&&(this._$ES=this._$ET())}P(t,e,r){this._$AL.has(t)||this._$AL.set(t,e),r.reflect===!0&&this._$Em!==t&&(this._$Ej??(this._$Ej=new Set)).add(t)}async _$ET(){this.isUpdatePending=!0;try{await this._$ES}catch(e){Promise.reject(e)}const t=this.scheduleUpdate();return t!=null&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var r;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[o,n]of this._$Ep)this[o]=n;this._$Ep=void 0}const i=this.constructor.elementProperties;if(i.size>0)for(const[o,n]of i)n.wrapped!==!0||this._$AL.has(o)||this[o]===void 0||this.P(o,this[o],n)}let t=!1;const e=this._$AL;try{t=this.shouldUpdate(e),t?(this.willUpdate(e),(r=this._$EO)==null||r.forEach(i=>{var o;return(o=i.hostUpdate)==null?void 0:o.call(i)}),this.update(e)):this._$EU()}catch(i){throw t=!1,this._$EU(),i}t&&this._$AE(e)}willUpdate(t){}_$AE(t){var e;(e=this._$EO)==null||e.forEach(r=>{var i;return(i=r.hostUpdated)==null?void 0:i.call(r)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(t){return!0}update(t){this._$Ej&&(this._$Ej=this._$Ej.forEach(e=>this._$EC(e,this[e]))),this._$EU()}updated(t){}firstUpdated(t){}}A.elementStyles=[],A.shadowRootOptions={mode:"open"},A[E("elementProperties")]=new Map,A[E("finalized")]=new Map,z==null||z({ReactiveElement:A}),(f.reactiveElementVersions??(f.reactiveElementVersions=[])).push("2.0.4");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const P=globalThis,H=P.trustedTypes,at=H?H.createPolicy("lit-html",{createHTML:s=>s}):void 0,vt="$lit$",v=`lit$${Math.random().toFixed(9).slice(2)}$`,ft="?"+v,Gt=`<${ft}>`,y=document,O=()=>y.createComment(""),C=s=>s===null||typeof s!="object"&&typeof s!="function",K=Array.isArray,Qt=s=>K(s)||typeof(s==null?void 0:s[Symbol.iterator])=="function",I=`[ 	
\f\r]`,S=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,lt=/-->/g,ct=/>/g,g=RegExp(`>|${I}(?:([^\\s"'>=/]+)(${I}*=${I}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),ht=/'/g,dt=/"/g,gt=/^(?:script|style|textarea|title)$/i,Xt=s=>(t,...e)=>({_$litType$:s,strings:t,values:e}),N=Xt(1),b=Symbol.for("lit-noChange"),u=Symbol.for("lit-nothing"),pt=new WeakMap,m=y.createTreeWalker(y,129);function mt(s,t){if(!K(s)||!s.hasOwnProperty("raw"))throw Error("invalid template strings array");return at!==void 0?at.createHTML(t):t}const Yt=(s,t)=>{const e=s.length-1,r=[];let i,o=t===2?"<svg>":t===3?"<math>":"",n=S;for(let h=0;h<e;h++){const a=s[h];let l,d,c=-1,$=0;for(;$<a.length&&(n.lastIndex=$,d=n.exec(a),d!==null);)$=n.lastIndex,n===S?d[1]==="!--"?n=lt:d[1]!==void 0?n=ct:d[2]!==void 0?(gt.test(d[2])&&(i=RegExp("</"+d[2],"g")),n=g):d[3]!==void 0&&(n=g):n===g?d[0]===">"?(n=i??S,c=-1):d[1]===void 0?c=-2:(c=n.lastIndex-d[2].length,l=d[1],n=d[3]===void 0?g:d[3]==='"'?dt:ht):n===dt||n===ht?n=g:n===lt||n===ct?n=S:(n=g,i=void 0);const p=n===g&&s[h+1].startsWith("/>")?" ":"";o+=n===S?a+Gt:c>=0?(r.push(l),a.slice(0,c)+vt+a.slice(c)+v+p):a+v+(c===-2?h:p)}return[mt(s,o+(s[e]||"<?>")+(t===2?"</svg>":t===3?"</math>":"")),r]};class U{constructor({strings:t,_$litType$:e},r){let i;this.parts=[];let o=0,n=0;const h=t.length-1,a=this.parts,[l,d]=Yt(t,e);if(this.el=U.createElement(l,r),m.currentNode=this.el.content,e===2||e===3){const c=this.el.content.firstChild;c.replaceWith(...c.childNodes)}for(;(i=m.nextNode())!==null&&a.length<h;){if(i.nodeType===1){if(i.hasAttributes())for(const c of i.getAttributeNames())if(c.endsWith(vt)){const $=d[n++],p=i.getAttribute(c).split(v),_=/([.?@])?(.*)/.exec($);a.push({type:1,index:o,name:_[2],strings:p,ctor:_[1]==="."?ee:_[1]==="?"?se:_[1]==="@"?ie:k}),i.removeAttribute(c)}else c.startsWith(v)&&(a.push({type:6,index:o}),i.removeAttribute(c));if(gt.test(i.tagName)){const c=i.textContent.split(v),$=c.length-1;if($>0){i.textContent=H?H.emptyScript:"";for(let p=0;p<$;p++)i.append(c[p],O()),m.nextNode(),a.push({type:2,index:++o});i.append(c[$],O())}}}else if(i.nodeType===8)if(i.data===ft)a.push({type:2,index:o});else{let c=-1;for(;(c=i.data.indexOf(v,c+1))!==-1;)a.push({type:7,index:o}),c+=v.length-1}o++}}static createElement(t,e){const r=y.createElement("template");return r.innerHTML=t,r}}function w(s,t,e=s,r){var n,h;if(t===b)return t;let i=r!==void 0?(n=e._$Co)==null?void 0:n[r]:e._$Cl;const o=C(t)?void 0:t._$litDirective$;return(i==null?void 0:i.constructor)!==o&&((h=i==null?void 0:i._$AO)==null||h.call(i,!1),o===void 0?i=void 0:(i=new o(s),i._$AT(s,e,r)),r!==void 0?(e._$Co??(e._$Co=[]))[r]=i:e._$Cl=i),i!==void 0&&(t=w(s,i._$AS(s,t.values),i,r)),t}class te{constructor(t,e){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=e}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:e},parts:r}=this._$AD,i=((t==null?void 0:t.creationScope)??y).importNode(e,!0);m.currentNode=i;let o=m.nextNode(),n=0,h=0,a=r[0];for(;a!==void 0;){if(n===a.index){let l;a.type===2?l=new R(o,o.nextSibling,this,t):a.type===1?l=new a.ctor(o,a.name,a.strings,this,t):a.type===6&&(l=new re(o,this,t)),this._$AV.push(l),a=r[++h]}n!==(a==null?void 0:a.index)&&(o=m.nextNode(),n++)}return m.currentNode=y,i}p(t){let e=0;for(const r of this._$AV)r!==void 0&&(r.strings!==void 0?(r._$AI(t,r,e),e+=r.strings.length-2):r._$AI(t[e])),e++}}class R{get _$AU(){var t;return((t=this._$AM)==null?void 0:t._$AU)??this._$Cv}constructor(t,e,r,i){this.type=2,this._$AH=u,this._$AN=void 0,this._$AA=t,this._$AB=e,this._$AM=r,this.options=i,this._$Cv=(i==null?void 0:i.isConnected)??!0}get parentNode(){let t=this._$AA.parentNode;const e=this._$AM;return e!==void 0&&(t==null?void 0:t.nodeType)===11&&(t=e.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,e=this){t=w(this,t,e),C(t)?t===u||t==null||t===""?(this._$AH!==u&&this._$AR(),this._$AH=u):t!==this._$AH&&t!==b&&this._(t):t._$litType$!==void 0?this.$(t):t.nodeType!==void 0?this.T(t):Qt(t)?this.k(t):this._(t)}O(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}T(t){this._$AH!==t&&(this._$AR(),this._$AH=this.O(t))}_(t){this._$AH!==u&&C(this._$AH)?this._$AA.nextSibling.data=t:this.T(y.createTextNode(t)),this._$AH=t}$(t){var o;const{values:e,_$litType$:r}=t,i=typeof r=="number"?this._$AC(t):(r.el===void 0&&(r.el=U.createElement(mt(r.h,r.h[0]),this.options)),r);if(((o=this._$AH)==null?void 0:o._$AD)===i)this._$AH.p(e);else{const n=new te(i,this),h=n.u(this.options);n.p(e),this.T(h),this._$AH=n}}_$AC(t){let e=pt.get(t.strings);return e===void 0&&pt.set(t.strings,e=new U(t)),e}k(t){K(this._$AH)||(this._$AH=[],this._$AR());const e=this._$AH;let r,i=0;for(const o of t)i===e.length?e.push(r=new R(this.O(O()),this.O(O()),this,this.options)):r=e[i],r._$AI(o),i++;i<e.length&&(this._$AR(r&&r._$AB.nextSibling,i),e.length=i)}_$AR(t=this._$AA.nextSibling,e){var r;for((r=this._$AP)==null?void 0:r.call(this,!1,!0,e);t&&t!==this._$AB;){const i=t.nextSibling;t.remove(),t=i}}setConnected(t){var e;this._$AM===void 0&&(this._$Cv=t,(e=this._$AP)==null||e.call(this,t))}}class k{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,e,r,i,o){this.type=1,this._$AH=u,this._$AN=void 0,this.element=t,this.name=e,this._$AM=i,this.options=o,r.length>2||r[0]!==""||r[1]!==""?(this._$AH=Array(r.length-1).fill(new String),this.strings=r):this._$AH=u}_$AI(t,e=this,r,i){const o=this.strings;let n=!1;if(o===void 0)t=w(this,t,e,0),n=!C(t)||t!==this._$AH&&t!==b,n&&(this._$AH=t);else{const h=t;let a,l;for(t=o[0],a=0;a<o.length-1;a++)l=w(this,h[r+a],e,a),l===b&&(l=this._$AH[a]),n||(n=!C(l)||l!==this._$AH[a]),l===u?t=u:t!==u&&(t+=(l??"")+o[a+1]),this._$AH[a]=l}n&&!i&&this.j(t)}j(t){t===u?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"")}}class ee extends k{constructor(){super(...arguments),this.type=3}j(t){this.element[this.name]=t===u?void 0:t}}class se extends k{constructor(){super(...arguments),this.type=4}j(t){this.element.toggleAttribute(this.name,!!t&&t!==u)}}class ie extends k{constructor(t,e,r,i,o){super(t,e,r,i,o),this.type=5}_$AI(t,e=this){if((t=w(this,t,e,0)??u)===b)return;const r=this._$AH,i=t===u&&r!==u||t.capture!==r.capture||t.once!==r.once||t.passive!==r.passive,o=t!==u&&(r===u||i);i&&this.element.removeEventListener(this.name,this,r),o&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var e;typeof this._$AH=="function"?this._$AH.call(((e=this.options)==null?void 0:e.host)??this.element,t):this._$AH.handleEvent(t)}}class re{constructor(t,e,r){this.element=t,this.type=6,this._$AN=void 0,this._$AM=e,this.options=r}get _$AU(){return this._$AM._$AU}_$AI(t){w(this,t)}}const D=P.litHtmlPolyfillSupport;D==null||D(U,R),(P.litHtmlVersions??(P.litHtmlVersions=[])).push("3.2.1");const oe=(s,t,e)=>{const r=(e==null?void 0:e.renderBefore)??t;let i=r._$litPart$;if(i===void 0){const o=(e==null?void 0:e.renderBefore)??null;r._$litPart$=i=new R(t.insertBefore(O(),o),o,void 0,e??{})}return i._$AI(s),i};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */class x extends A{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var e;const t=super.createRenderRoot();return(e=this.renderOptions).renderBefore??(e.renderBefore=t.firstChild),t}update(t){const e=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=oe(e,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),(t=this._$Do)==null||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),(t=this._$Do)==null||t.setConnected(!1)}render(){return b}}var _t;x._$litElement$=!0,x.finalized=!0,(_t=globalThis.litElementHydrateSupport)==null||_t.call(globalThis,{LitElement:x});const L=globalThis.litElementPolyfillSupport;L==null||L({LitElement:x});(globalThis.litElementVersions??(globalThis.litElementVersions=[])).push("4.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const M=s=>(t,e)=>{e!==void 0?e.addInitializer(()=>{customElements.define(s,t)}):customElements.define(s,t)};class j extends x{constructor(){super()}createRenderRoot(){return this}}var ne=Object.create,Z=Object.defineProperty,ae=Object.getOwnPropertyDescriptor,yt=(s,t)=>(t=Symbol[s])?t:Symbol.for("Symbol."+s),At=s=>{throw TypeError(s)},le=(s,t,e)=>t in s?Z(s,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):s[t]=e,ce=(s,t)=>Z(s,"name",{value:t,configurable:!0}),he=s=>[,,,ne((s==null?void 0:s[yt("metadata")])??null)],de=["class","method","getter","setter","accessor","field","value","get","set"],bt=s=>s!==void 0&&typeof s!="function"?At("Function expected"):s,pe=(s,t,e,r,i)=>({kind:de[s],name:t,metadata:r,addInitializer:o=>e._?At("Already initialized"):i.push(bt(o||null))}),_e=(s,t)=>le(t,yt("metadata"),s[3]),ue=(s,t,e,r)=>{for(var i=0,o=s[t>>1],n=o&&o.length;i<n;i++)o[i].call(e);return r},$e=(s,t,e,r,i,o)=>{var n,h,a,l=t&7,d=!1,c=0,$=s[c]||(s[c]=[]),p=l&&(i=i.prototype,l<5&&(l>3||!d)&&ae(i,e));ce(i,e);for(var _=r.length-1;_>=0;_--)a=pe(l,e,h={},s[3],$),n=(0,r[_])(i,a),h._=1,bt(n)&&(i=n);return _e(s,i),p&&Z(i,e,p),d?l^4?o:p:i},wt,G,St;wt=[M("pg-activity")];class F extends(St=j){constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,window.pg_global.is_logged_in||window.loginRedirect()}render(){return N`
      <section
        class="page-section flow"
        data-section="login"
        id="section-login"
      >
        <div class="container">
          <h2>Prayer Activity</h2>
        </div>
      </section>
    `}}G=he(St);F=$e(G,0,"PgActivity",wt,F);ue(G,1,F);var ve=Object.create,Q=Object.defineProperty,fe=Object.getOwnPropertyDescriptor,Et=(s,t)=>(t=Symbol[s])?t:Symbol.for("Symbol."+s),Pt=s=>{throw TypeError(s)},ge=(s,t,e)=>t in s?Q(s,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):s[t]=e,me=(s,t)=>Q(s,"name",{value:t,configurable:!0}),ye=s=>[,,,ve((s==null?void 0:s[Et("metadata")])??null)],Ae=["class","method","getter","setter","accessor","field","value","get","set"],xt=s=>s!==void 0&&typeof s!="function"?Pt("Function expected"):s,be=(s,t,e,r,i)=>({kind:Ae[s],name:t,metadata:r,addInitializer:o=>e._?Pt("Already initialized"):i.push(xt(o||null))}),we=(s,t)=>ge(t,Et("metadata"),s[3]),Se=(s,t,e,r)=>{for(var i=0,o=s[t>>1],n=o&&o.length;i<n;i++)o[i].call(e);return r},Ee=(s,t,e,r,i,o)=>{var n,h,a,l=t&7,d=!1,c=0,$=s[c]||(s[c]=[]),p=l&&(i=i.prototype,l<5&&(l>3||!d)&&fe(i,e));me(i,e);for(var _=r.length-1;_>=0;_--)a=be(l,e,h={},s[3],$),n=(0,r[_])(i,a),h._=1,xt(n)&&(i=n);return we(s,i),p&&Q(i,e,p),d?l^4?o:p:i},Ot,X,Ct;Ot=[M("pg-profile")];class W extends(Ct=j){constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,window.pg_global.is_logged_in||window.loginRedirect()}render(){return N`
      <section
        class="page-section flow"
        data-section="login"
        id="section-login"
      >
        <div class="container">
          <div class="row justify-content-md-center text-center">
            <div class="flow" id="pg_content">
              <div class="flow-medium">
                <section class="user__summary flow-small">
                  <div class="user__avatar">
                    <span class="user__badge loading">
                      <span class="loading-spinner active"></span>
                    </span>
                  </div>

                  <div class="user__info">
                    <h2 class="user__full-name font-base uppercase">
                      ${this.user.display_name}
                    </h2>
                    <p class="user__location">
                      <span class="user__location-label"
                        >${this.user.location&&this.user.location.label||'<span class="loading-spinner active"></span>'}</span
                      >
                      <button>Edit</button>
                      <span
                        class="iplocation-message small d-block text-secondary"
                      >
                        ${this.user.location&&this.user.location.source==="ip"?this.translations.estimated_location:""}
                      </span>
                    </p>
                  </div>
                </section>
                <section class="profile-menu px-2 mt-5">
                  <div class="navbar-nav w-fit mx-auto">
                    <button
                      class="user-profile-link nav-link uppercase px-1 py-4 d-flex justify-content-between align-items-center border-bottom border-top border-1 border-dark"
                    >
                      <i class="icon pg-profile three-em"></i>
                      <span class="two-em">${this.translations.profile}</span>
                      <i class="icon pg-chevron-right three-em"></i>
                    </button>
                    <button
                      class="user-prayers-link nav-link uppercase px-1 py-4 d-flex justify-content-between align-items-center border-bottom border-1 border-dark"
                    >
                      <i class="icon pg-prayer three-em"></i>
                      <span class="two-em">${this.translations.prayers}</span>
                      <i class="icon pg-chevron-right three-em"></i>
                    </button>
                    <button
                      class="user-challenges-link nav-link uppercase px-1 py-4 d-flex justify-content-between align-items-center border-bottom border-1 border-dark"
                    >
                      <i class="icon pg-relay three-em"></i>
                      <span class="two-em px-3"
                        >${this.translations.challenges}</span
                      >
                      <i class="icon pg-chevron-right three-em"></i>
                    </button>
                  </div>
                </section>
                <section>
                  <p>${this.translations.are_you_enjoying_the_app}</p>
                  <p>${this.translations.would_you_like_to_partner}</p>
                  <div class="d-flex flex-column m-auto w-fit">
                    <a
                      class="btn btn-small btn-primary-light uppercase"
                      data-reverse-color
                      href="/give"
                      target="_blank"
                      >${this.translations.give} <i class="ion-android-open"></i
                    ></a>
                    <a
                      class="btn btn-small btn-outline-primary mt-3 uppercase"
                      href="/user_app/logout"
                      >${this.translations.logout}</a
                    ><br />
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </section>
    `}}X=ye(Ct);W=Ee(X,0,"PgProfile",Ot,W);Se(X,1,W);var Pe=Object.create,Y=Object.defineProperty,xe=Object.getOwnPropertyDescriptor,Ut=(s,t)=>(t=Symbol[s])?t:Symbol.for("Symbol."+s),Rt=s=>{throw TypeError(s)},Oe=(s,t,e)=>t in s?Y(s,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):s[t]=e,Ce=(s,t)=>Y(s,"name",{value:t,configurable:!0}),Ue=s=>[,,,Pe((s==null?void 0:s[Ut("metadata")])??null)],Re=["class","method","getter","setter","accessor","field","value","get","set"],Tt=s=>s!==void 0&&typeof s!="function"?Rt("Function expected"):s,Te=(s,t,e,r,i)=>({kind:Re[s],name:t,metadata:r,addInitializer:o=>e._?Rt("Already initialized"):i.push(Tt(o||null))}),He=(s,t)=>Oe(t,Ut("metadata"),s[3]),Ne=(s,t,e,r)=>{for(var i=0,o=s[t>>1],n=o&&o.length;i<n;i++)o[i].call(e);return r},ke=(s,t,e,r,i,o)=>{var n,h,a,l=t&7,d=!1,c=0,$=s[c]||(s[c]=[]),p=l&&(i=i.prototype,l<5&&(l>3||!d)&&xe(i,e));Ce(i,e);for(var _=r.length-1;_>=0;_--)a=Te(l,e,h={},s[3],$),n=(0,r[_])(i,a),h._=1,Tt(n)&&(i=n);return He(s,i),p&&Y(i,e,p),d?l^4?o:p:i},Ht,tt,Nt;Ht=[M("pg-relays")];class V extends(Nt=j){constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,window.pg_global.is_logged_in||window.loginRedirect()}render(){return N`
      <section
        class="page-section flow"
        data-section="login"
        id="section-login"
      >
        <h2>My Prayer Relays</h2>
      </section>
    `}}tt=Ue(Nt);V=ke(tt,0,"PgRelays",Ht,V);Ne(tt,1,V);var Me=Object.create,et=Object.defineProperty,je=Object.getOwnPropertyDescriptor,kt=(s,t)=>(t=Symbol[s])?t:Symbol.for("Symbol."+s),Mt=s=>{throw TypeError(s)},ze=(s,t,e)=>t in s?et(s,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):s[t]=e,Ie=(s,t)=>et(s,"name",{value:t,configurable:!0}),De=s=>[,,,Me((s==null?void 0:s[kt("metadata")])??null)],Le=["class","method","getter","setter","accessor","field","value","get","set"],jt=s=>s!==void 0&&typeof s!="function"?Mt("Function expected"):s,Be=(s,t,e,r,i)=>({kind:Le[s],name:t,metadata:r,addInitializer:o=>e._?Mt("Already initialized"):i.push(jt(o||null))}),Fe=(s,t)=>ze(t,kt("metadata"),s[3]),We=(s,t,e,r)=>{for(var i=0,o=s[t>>1],n=o&&o.length;i<n;i++)o[i].call(e);return r},Ve=(s,t,e,r,i,o)=>{var n,h,a,l=t&7,d=!1,c=0,$=s[c]||(s[c]=[]),p=l&&(i=i.prototype,l<5&&(l>3||!d)&&je(i,e));Ie(i,e);for(var _=r.length-1;_>=0;_--)a=Be(l,e,h={},s[3],$),n=(0,r[_])(i,a),h._=1,jt(n)&&(i=n);return Fe(s,i),p&&et(i,e,p),d?l^4?o:p:i},zt,st,It;zt=[M("pg-settings")];class q extends(It=j){constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,window.pg_global.is_logged_in||window.loginRedirect()}render(){return N`
      <section
        class="page-section flow"
        data-section="login"
        id="section-login"
      >
        <h2>Profile Settings</h2>
      </section>
    `}}st=De(It);q=Ve(st,0,"PgSettings",zt,q);We(st,1,q);
//# sourceMappingURL=components-bundle.js.map
