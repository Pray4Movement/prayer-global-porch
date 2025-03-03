/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const j=globalThis,G=j.ShadowRoot&&(j.ShadyCSS===void 0||j.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,vt=Symbol(),ot=new WeakMap;let Kt=class{constructor(t,e,i){if(this._$cssResult$=!0,i!==vt)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e}get styleSheet(){let t=this.o;const e=this.t;if(G&&t===void 0){const i=e!==void 0&&e.length===1;i&&(t=ot.get(e)),t===void 0&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),i&&ot.set(e,t))}return t}toString(){return this.cssText}};const Zt=r=>new Kt(typeof r=="string"?r:r+"",void 0,vt),Qt=(r,t)=>{if(G)r.adoptedStyleSheets=t.map(e=>e instanceof CSSStyleSheet?e:e.styleSheet);else for(const e of t){const i=document.createElement("style"),s=j.litNonce;s!==void 0&&i.setAttribute("nonce",s),i.textContent=e.cssText,r.appendChild(i)}},at=G?r=>r:r=>r instanceof CSSStyleSheet?(t=>{let e="";for(const i of t.cssRules)e+=i.cssText;return Zt(e)})(r):r;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:Xt,defineProperty:Yt,getOwnPropertyDescriptor:te,getOwnPropertyNames:ee,getOwnPropertySymbols:re,getPrototypeOf:se}=Object,m=globalThis,lt=m.trustedTypes,ie=lt?lt.emptyScript:"",M=m.reactiveElementPolyfillSupport,P=(r,t)=>r,B={toAttribute(r,t){switch(t){case Boolean:r=r?ie:null;break;case Object:case Array:r=r==null?r:JSON.stringify(r)}return r},fromAttribute(r,t){let e=r;switch(t){case Boolean:e=r!==null;break;case Number:e=r===null?null:Number(r);break;case Object:case Array:try{e=JSON.parse(r)}catch{e=null}}return e}},mt=(r,t)=>!Xt(r,t),ct={attribute:!0,type:String,converter:B,reflect:!1,hasChanged:mt};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),m.litPropertyMetadata??(m.litPropertyMetadata=new WeakMap);class A extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??(this.l=[])).push(t)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,e=ct){if(e.state&&(e.attribute=!1),this._$Ei(),this.elementProperties.set(t,e),!e.noAccessor){const i=Symbol(),s=this.getPropertyDescriptor(t,i,e);s!==void 0&&Yt(this.prototype,t,s)}}static getPropertyDescriptor(t,e,i){const{get:s,set:o}=te(this.prototype,t)??{get(){return this[e]},set(n){this[e]=n}};return{get(){return s==null?void 0:s.call(this)},set(n){const c=s==null?void 0:s.call(this);o.call(this,n),this.requestUpdate(t,c,i)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??ct}static _$Ei(){if(this.hasOwnProperty(P("elementProperties")))return;const t=se(this);t.finalize(),t.l!==void 0&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties)}static finalize(){if(this.hasOwnProperty(P("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(P("properties"))){const e=this.properties,i=[...ee(e),...re(e)];for(const s of i)this.createProperty(s,e[s])}const t=this[Symbol.metadata];if(t!==null){const e=litPropertyMetadata.get(t);if(e!==void 0)for(const[i,s]of e)this.elementProperties.set(i,s)}this._$Eh=new Map;for(const[e,i]of this.elementProperties){const s=this._$Eu(e,i);s!==void 0&&this._$Eh.set(s,e)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(t){const e=[];if(Array.isArray(t)){const i=new Set(t.flat(1/0).reverse());for(const s of i)e.unshift(at(s))}else t!==void 0&&e.push(at(t));return e}static _$Eu(t,e){const i=e.attribute;return i===!1?void 0:typeof i=="string"?i:typeof t=="string"?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var t;this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),(t=this.constructor.l)==null||t.forEach(e=>e(this))}addController(t){var e;(this._$EO??(this._$EO=new Set)).add(t),this.renderRoot!==void 0&&this.isConnected&&((e=t.hostConnected)==null||e.call(t))}removeController(t){var e;(e=this._$EO)==null||e.delete(t)}_$E_(){const t=new Map,e=this.constructor.elementProperties;for(const i of e.keys())this.hasOwnProperty(i)&&(t.set(i,this[i]),delete this[i]);t.size>0&&(this._$Ep=t)}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return Qt(t,this.constructor.elementStyles),t}connectedCallback(){var t;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(t=this._$EO)==null||t.forEach(e=>{var i;return(i=e.hostConnected)==null?void 0:i.call(e)})}enableUpdating(t){}disconnectedCallback(){var t;(t=this._$EO)==null||t.forEach(e=>{var i;return(i=e.hostDisconnected)==null?void 0:i.call(e)})}attributeChangedCallback(t,e,i){this._$AK(t,i)}_$EC(t,e){var o;const i=this.constructor.elementProperties.get(t),s=this.constructor._$Eu(t,i);if(s!==void 0&&i.reflect===!0){const n=(((o=i.converter)==null?void 0:o.toAttribute)!==void 0?i.converter:B).toAttribute(e,i.type);this._$Em=t,n==null?this.removeAttribute(s):this.setAttribute(s,n),this._$Em=null}}_$AK(t,e){var o;const i=this.constructor,s=i._$Eh.get(t);if(s!==void 0&&this._$Em!==s){const n=i.getPropertyOptions(s),c=typeof n.converter=="function"?{fromAttribute:n.converter}:((o=n.converter)==null?void 0:o.fromAttribute)!==void 0?n.converter:B;this._$Em=s,this[s]=c.fromAttribute(e,n.type),this._$Em=null}}requestUpdate(t,e,i){if(t!==void 0){if(i??(i=this.constructor.getPropertyOptions(t)),!(i.hasChanged??mt)(this[t],e))return;this.P(t,e,i)}this.isUpdatePending===!1&&(this._$ES=this._$ET())}P(t,e,i){this._$AL.has(t)||this._$AL.set(t,e),i.reflect===!0&&this._$Em!==t&&(this._$Ej??(this._$Ej=new Set)).add(t)}async _$ET(){this.isUpdatePending=!0;try{await this._$ES}catch(e){Promise.reject(e)}const t=this.scheduleUpdate();return t!=null&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var i;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[o,n]of this._$Ep)this[o]=n;this._$Ep=void 0}const s=this.constructor.elementProperties;if(s.size>0)for(const[o,n]of s)n.wrapped!==!0||this._$AL.has(o)||this[o]===void 0||this.P(o,this[o],n)}let t=!1;const e=this._$AL;try{t=this.shouldUpdate(e),t?(this.willUpdate(e),(i=this._$EO)==null||i.forEach(s=>{var o;return(o=s.hostUpdate)==null?void 0:o.call(s)}),this.update(e)):this._$EU()}catch(s){throw t=!1,this._$EU(),s}t&&this._$AE(e)}willUpdate(t){}_$AE(t){var e;(e=this._$EO)==null||e.forEach(i=>{var s;return(s=i.hostUpdated)==null?void 0:s.call(i)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(t){return!0}update(t){this._$Ej&&(this._$Ej=this._$Ej.forEach(e=>this._$EC(e,this[e]))),this._$EU()}updated(t){}firstUpdated(t){}}A.elementStyles=[],A.shadowRootOptions={mode:"open"},A[P("elementProperties")]=new Map,A[P("finalized")]=new Map,M==null||M({ReactiveElement:A}),(m.reactiveElementVersions??(m.reactiveElementVersions=[])).push("2.0.4");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const x=globalThis,H=x.trustedTypes,ht=H?H.createPolicy("lit-html",{createHTML:r=>r}):void 0,gt="$lit$",v=`lit$${Math.random().toFixed(9).slice(2)}$`,yt="?"+v,ne=`<${yt}>`,b=document,C=()=>b.createComment(""),z=r=>r===null||typeof r!="object"&&typeof r!="function",K=Array.isArray,oe=r=>K(r)||typeof(r==null?void 0:r[Symbol.iterator])=="function",I=`[ 	
\f\r]`,E=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,dt=/-->/g,ut=/>/g,g=RegExp(`>|${I}(?:([^\\s"'>=/]+)(${I}*=${I}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),pt=/'/g,_t=/"/g,bt=/^(?:script|style|textarea|title)$/i,ae=r=>(t,...e)=>({_$litType$:r,strings:t,values:e}),f=ae(1),w=Symbol.for("lit-noChange"),$=Symbol.for("lit-nothing"),$t=new WeakMap,y=b.createTreeWalker(b,129);function At(r,t){if(!K(r)||!r.hasOwnProperty("raw"))throw Error("invalid template strings array");return ht!==void 0?ht.createHTML(t):t}const le=(r,t)=>{const e=r.length-1,i=[];let s,o=t===2?"<svg>":t===3?"<math>":"",n=E;for(let c=0;c<e;c++){const a=r[c];let l,d,h=-1,_=0;for(;_<a.length&&(n.lastIndex=_,d=n.exec(a),d!==null);)_=n.lastIndex,n===E?d[1]==="!--"?n=dt:d[1]!==void 0?n=ut:d[2]!==void 0?(bt.test(d[2])&&(s=RegExp("</"+d[2],"g")),n=g):d[3]!==void 0&&(n=g):n===g?d[0]===">"?(n=s??E,h=-1):d[1]===void 0?h=-2:(h=n.lastIndex-d[2].length,l=d[1],n=d[3]===void 0?g:d[3]==='"'?_t:pt):n===_t||n===pt?n=g:n===dt||n===ut?n=E:(n=g,s=void 0);const u=n===g&&r[c+1].startsWith("/>")?" ":"";o+=n===E?a+ne:h>=0?(i.push(l),a.slice(0,h)+gt+a.slice(h)+v+u):a+v+(h===-2?c:u)}return[At(r,o+(r[e]||"<?>")+(t===2?"</svg>":t===3?"</math>":"")),i]};class k{constructor({strings:t,_$litType$:e},i){let s;this.parts=[];let o=0,n=0;const c=t.length-1,a=this.parts,[l,d]=le(t,e);if(this.el=k.createElement(l,i),y.currentNode=this.el.content,e===2||e===3){const h=this.el.content.firstChild;h.replaceWith(...h.childNodes)}for(;(s=y.nextNode())!==null&&a.length<c;){if(s.nodeType===1){if(s.hasAttributes())for(const h of s.getAttributeNames())if(h.endsWith(gt)){const _=d[n++],u=s.getAttribute(h).split(v),p=/([.?@])?(.*)/.exec(_);a.push({type:1,index:o,name:p[2],strings:u,ctor:p[1]==="."?he:p[1]==="?"?de:p[1]==="@"?ue:N}),s.removeAttribute(h)}else h.startsWith(v)&&(a.push({type:6,index:o}),s.removeAttribute(h));if(bt.test(s.tagName)){const h=s.textContent.split(v),_=h.length-1;if(_>0){s.textContent=H?H.emptyScript:"";for(let u=0;u<_;u++)s.append(h[u],C()),y.nextNode(),a.push({type:2,index:++o});s.append(h[_],C())}}}else if(s.nodeType===8)if(s.data===yt)a.push({type:2,index:o});else{let h=-1;for(;(h=s.data.indexOf(v,h+1))!==-1;)a.push({type:7,index:o}),h+=v.length-1}o++}}static createElement(t,e){const i=b.createElement("template");return i.innerHTML=t,i}}function S(r,t,e=r,i){var n,c;if(t===w)return t;let s=i!==void 0?(n=e._$Co)==null?void 0:n[i]:e._$Cl;const o=z(t)?void 0:t._$litDirective$;return(s==null?void 0:s.constructor)!==o&&((c=s==null?void 0:s._$AO)==null||c.call(s,!1),o===void 0?s=void 0:(s=new o(r),s._$AT(r,e,i)),i!==void 0?(e._$Co??(e._$Co=[]))[i]=s:e._$Cl=s),s!==void 0&&(t=S(r,s._$AS(r,t.values),s,i)),t}class ce{constructor(t,e){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=e}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:e},parts:i}=this._$AD,s=((t==null?void 0:t.creationScope)??b).importNode(e,!0);y.currentNode=s;let o=y.nextNode(),n=0,c=0,a=i[0];for(;a!==void 0;){if(n===a.index){let l;a.type===2?l=new R(o,o.nextSibling,this,t):a.type===1?l=new a.ctor(o,a.name,a.strings,this,t):a.type===6&&(l=new pe(o,this,t)),this._$AV.push(l),a=i[++c]}n!==(a==null?void 0:a.index)&&(o=y.nextNode(),n++)}return y.currentNode=b,s}p(t){let e=0;for(const i of this._$AV)i!==void 0&&(i.strings!==void 0?(i._$AI(t,i,e),e+=i.strings.length-2):i._$AI(t[e])),e++}}class R{get _$AU(){var t;return((t=this._$AM)==null?void 0:t._$AU)??this._$Cv}constructor(t,e,i,s){this.type=2,this._$AH=$,this._$AN=void 0,this._$AA=t,this._$AB=e,this._$AM=i,this.options=s,this._$Cv=(s==null?void 0:s.isConnected)??!0}get parentNode(){let t=this._$AA.parentNode;const e=this._$AM;return e!==void 0&&(t==null?void 0:t.nodeType)===11&&(t=e.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,e=this){t=S(this,t,e),z(t)?t===$||t==null||t===""?(this._$AH!==$&&this._$AR(),this._$AH=$):t!==this._$AH&&t!==w&&this._(t):t._$litType$!==void 0?this.$(t):t.nodeType!==void 0?this.T(t):oe(t)?this.k(t):this._(t)}O(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}T(t){this._$AH!==t&&(this._$AR(),this._$AH=this.O(t))}_(t){this._$AH!==$&&z(this._$AH)?this._$AA.nextSibling.data=t:this.T(b.createTextNode(t)),this._$AH=t}$(t){var o;const{values:e,_$litType$:i}=t,s=typeof i=="number"?this._$AC(t):(i.el===void 0&&(i.el=k.createElement(At(i.h,i.h[0]),this.options)),i);if(((o=this._$AH)==null?void 0:o._$AD)===s)this._$AH.p(e);else{const n=new ce(s,this),c=n.u(this.options);n.p(e),this.T(c),this._$AH=n}}_$AC(t){let e=$t.get(t.strings);return e===void 0&&$t.set(t.strings,e=new k(t)),e}k(t){K(this._$AH)||(this._$AH=[],this._$AR());const e=this._$AH;let i,s=0;for(const o of t)s===e.length?e.push(i=new R(this.O(C()),this.O(C()),this,this.options)):i=e[s],i._$AI(o),s++;s<e.length&&(this._$AR(i&&i._$AB.nextSibling,s),e.length=s)}_$AR(t=this._$AA.nextSibling,e){var i;for((i=this._$AP)==null?void 0:i.call(this,!1,!0,e);t&&t!==this._$AB;){const s=t.nextSibling;t.remove(),t=s}}setConnected(t){var e;this._$AM===void 0&&(this._$Cv=t,(e=this._$AP)==null||e.call(this,t))}}class N{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,e,i,s,o){this.type=1,this._$AH=$,this._$AN=void 0,this.element=t,this.name=e,this._$AM=s,this.options=o,i.length>2||i[0]!==""||i[1]!==""?(this._$AH=Array(i.length-1).fill(new String),this.strings=i):this._$AH=$}_$AI(t,e=this,i,s){const o=this.strings;let n=!1;if(o===void 0)t=S(this,t,e,0),n=!z(t)||t!==this._$AH&&t!==w,n&&(this._$AH=t);else{const c=t;let a,l;for(t=o[0],a=0;a<o.length-1;a++)l=S(this,c[i+a],e,a),l===w&&(l=this._$AH[a]),n||(n=!z(l)||l!==this._$AH[a]),l===$?t=$:t!==$&&(t+=(l??"")+o[a+1]),this._$AH[a]=l}n&&!s&&this.j(t)}j(t){t===$?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"")}}class he extends N{constructor(){super(...arguments),this.type=3}j(t){this.element[this.name]=t===$?void 0:t}}class de extends N{constructor(){super(...arguments),this.type=4}j(t){this.element.toggleAttribute(this.name,!!t&&t!==$)}}class ue extends N{constructor(t,e,i,s,o){super(t,e,i,s,o),this.type=5}_$AI(t,e=this){if((t=S(this,t,e,0)??$)===w)return;const i=this._$AH,s=t===$&&i!==$||t.capture!==i.capture||t.once!==i.once||t.passive!==i.passive,o=t!==$&&(i===$||s);s&&this.element.removeEventListener(this.name,this,i),o&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var e;typeof this._$AH=="function"?this._$AH.call(((e=this.options)==null?void 0:e.host)??this.element,t):this._$AH.handleEvent(t)}}class pe{constructor(t,e,i){this.element=t,this.type=6,this._$AN=void 0,this._$AM=e,this.options=i}get _$AU(){return this._$AM._$AU}_$AI(t){S(this,t)}}const D=x.litHtmlPolyfillSupport;D==null||D(k,R),(x.litHtmlVersions??(x.litHtmlVersions=[])).push("3.2.1");const _e=(r,t,e)=>{const i=(e==null?void 0:e.renderBefore)??t;let s=i._$litPart$;if(s===void 0){const o=(e==null?void 0:e.renderBefore)??null;i._$litPart$=s=new R(t.insertBefore(C(),o),o,void 0,e??{})}return s._$AI(r),s};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */class O extends A{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var e;const t=super.createRenderRoot();return(e=this.renderOptions).renderBefore??(e.renderBefore=t.firstChild),t}update(t){const e=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=_e(e,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),(t=this._$Do)==null||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),(t=this._$Do)==null||t.setConnected(!1)}render(){return w}}var ft;O._$litElement$=!0,O.finalized=!0,(ft=globalThis.litElementHydrateSupport)==null||ft.call(globalThis,{LitElement:O});const L=globalThis.litElementPolyfillSupport;L==null||L({LitElement:O});(globalThis.litElementVersions??(globalThis.litElementVersions=[])).push("4.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const T=r=>(t,e)=>{e!==void 0?e.addInitializer(()=>{customElements.define(r,t)}):customElements.define(r,t)};class U extends O{constructor(){super()}createRenderRoot(){return this}}var $e=Object.create,Z=Object.defineProperty,fe=Object.getOwnPropertyDescriptor,wt=(r,t)=>(t=Symbol[r])?t:Symbol.for("Symbol."+r),St=r=>{throw TypeError(r)},ve=(r,t,e)=>t in r?Z(r,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):r[t]=e,me=(r,t)=>Z(r,"name",{value:t,configurable:!0}),ge=r=>[,,,$e((r==null?void 0:r[wt("metadata")])??null)],ye=["class","method","getter","setter","accessor","field","value","get","set"],Et=r=>r!==void 0&&typeof r!="function"?St("Function expected"):r,be=(r,t,e,i,s)=>({kind:ye[r],name:t,metadata:i,addInitializer:o=>e._?St("Already initialized"):s.push(Et(o||null))}),Ae=(r,t)=>ve(t,wt("metadata"),r[3]),we=(r,t,e,i)=>{for(var s=0,o=r[t>>1],n=o&&o.length;s<n;s++)o[s].call(e);return i},Se=(r,t,e,i,s,o)=>{var n,c,a,l=t&7,d=!1,h=0,_=r[h]||(r[h]=[]),u=l&&(s=s.prototype,l<5&&(l>3||!d)&&fe(s,e));me(s,e);for(var p=i.length-1;p>=0;p--)a=be(l,e,c={},r[3],_),n=(0,i[p])(s,a),c._=1,Et(n)&&(s=n);return Ae(r,s),u&&Z(s,e,u),d?l^4?o:u:s},Pt,Q,xt;Pt=[T("pg-activity")];class F extends(xt=U){constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return f` <h2>Prayer Activity</h2> `}}Q=ge(xt);F=Se(Q,0,"PgActivity",Pt,F);we(Q,1,F);function Ee(r){return r?JSON.parse('{"'+r.substring(1).replace(/&/g,'","').replace(/=/g,'":"')+'"}'):{}}function Pe(r,t){let e={};const i=r.split("/").filter(o=>o!=""),s=t.split("/").filter(o=>o!="");return i.map((o,n)=>{/^:/.test(o)&&(e[o.substring(1)]=s[n])}),e}function xe(r){return r?new RegExp("^(|/)"+r.replace(/:[^\s/]+/g,"([\\wÀ-ÖØ-öø-ÿ-]+)")+"(|/)$"):new RegExp("(^$|^/$)")}function Oe(r,t){if(xe(t).test(r))return!0}function Ce(r){return class extends r{static get properties(){return{route:{type:String,reflect:!0,attribute:"route"},canceled:{type:Boolean}}}constructor(...t){super(...t),this.route="",this.canceled=!1}connectedCallback(...t){super.connectedCallback(...t),this.routing(this.constructor.routes,(...e)=>this.router(...e)),window.addEventListener("route",()=>{this.routing(this.constructor.routes,(...e)=>this.router(...e))}),window.onpopstate=()=>{window.dispatchEvent(new CustomEvent("route"))}}routed(t,e,i,s,o,n){n&&n(t,e,i,s),o(t,e,i,s)}routing(t,e){this.canceled=!0;const i=decodeURI(window.location.pathname),s=decodeURI(window.location.search);let o=t.filter(a=>a.pattern==="*")[0],n=t.filter(a=>a.pattern!=="*"&&Oe(i,a.pattern))[0],c=Ee(s);n?(n.params=Pe(n.pattern,i),n.data=n.data||{},n.authentication&&n.authentication.authenticate&&typeof n.authentication.authenticate=="function"?(this.canceled=!1,Promise.resolve(n.authentication.authenticate.bind(this).call()).then(a=>{this.canceled||(a?n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(l=>{this.canceled||(l?this.routed(n.name,n.params,c,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,c,n.data,e,n.callback))})):this.routed(n.name,n.params,c,n.data,e,n.callback):this.routed(n.authentication.unauthenticated.name,n.params,c,n.data,e,n.callback))})):n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(a=>{this.canceled||(a?this.routed(n.name,n.params,c,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,c,n.data,e,n.callback))})):this.routed(n.name,n.params,c,n.data,e,n.callback)):o&&(o.data=o.data||{},this.routed(o.name,{},c,o.data,e,o.callback))}}}function Ot(r){return class extends r{navigate(t){window.history.pushState({},null,t),window.dispatchEvent(new CustomEvent("route"))}}}var ze=Object.create,X=Object.defineProperty,ke=Object.getOwnPropertyDescriptor,Ct=(r,t)=>(t=Symbol[r])?t:Symbol.for("Symbol."+r),zt=r=>{throw TypeError(r)},Re=(r,t,e)=>t in r?X(r,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):r[t]=e,Te=(r,t)=>X(r,"name",{value:t,configurable:!0}),Ue=r=>[,,,ze((r==null?void 0:r[Ct("metadata")])??null)],je=["class","method","getter","setter","accessor","field","value","get","set"],kt=r=>r!==void 0&&typeof r!="function"?zt("Function expected"):r,He=(r,t,e,i,s)=>({kind:je[r],name:t,metadata:i,addInitializer:o=>e._?zt("Already initialized"):s.push(kt(o||null))}),Ne=(r,t)=>Re(t,Ct("metadata"),r[3]),Me=(r,t,e,i)=>{for(var s=0,o=r[t>>1],n=o&&o.length;s<n;s++)o[s].call(e);return i},Ie=(r,t,e,i,s,o)=>{var n,c,a,l=t&7,d=!1,h=0,_=r[h]||(r[h]=[]),u=l&&(s=s.prototype,l<5&&(l>3||!d)&&ke(s,e));Te(s,e);for(var p=i.length-1;p>=0;p--)a=He(l,e,c={},r[3],_),n=(0,i[p])(s,a),c._=1,kt(n)&&(s=n);return Ne(r,s),u&&X(s,e,u),d?l^4?o:u:s},Rt,Y,Tt;Rt=[T("pg-dashboard")];class W extends(Tt=Ot(U)){constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}navigateToHref(t){t.preventDefault();const{href:e}=t.currentTarget;this.navigate(e)}render(){return f`
      <div class="container-md pb-10">
          <div class="stack" id="pg_content">
            <div class="stack-md">
              <section class="user__summary stack-sm">
                <div class="user__avatar">
                  <span class="user__badge"></span>
                </div>

                <div class="user__info text-center">
                  <h2 class="user__full-name font-title uppercase">
                    ${this.user.display_name}
                  </h2>
                  <div class="user__location">
                    <div class="user__location-label">
                    ${this.user.location&&this.user.location.label||f`<span class="loading-spinner active"></span>`}
                    </div>
                    ${this.user.location&&this.user.location.source==="ip"?f`
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
                    @click=${t=>this.navigateToHref(t)}
                  >
                    <i class="icon pg-relay two-rem"></i>
                    <span class="one-rem">
                      ${this.translations.challenges}
                    </span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/prayer-activity"
                    @click=${t=>this.navigateToHref(t)}
                  >
                    <i class="icon pg-prayer two-rem"></i>
                    <span class="one-rem">${this.translations.prayers}</span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/profile-settings"
                    @click=${t=>this.navigateToHref(t)}
                  >
                    <i class="icon pg-settings two-rem"></i>
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
                    target="_blank"
                  >
                    ${this.translations.give}
                  </a>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    `}}Y=Ue(Tt);W=Ie(Y,0,"PgDashboard",Rt,W);Me(Y,1,W);var De=Object.create,tt=Object.defineProperty,Le=Object.getOwnPropertyDescriptor,Ut=(r,t)=>(t=Symbol[r])?t:Symbol.for("Symbol."+r),jt=r=>{throw TypeError(r)},Be=(r,t,e)=>t in r?tt(r,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):r[t]=e,Fe=(r,t)=>tt(r,"name",{value:t,configurable:!0}),We=r=>[,,,De((r==null?void 0:r[Ut("metadata")])??null)],Ve=["class","method","getter","setter","accessor","field","value","get","set"],Ht=r=>r!==void 0&&typeof r!="function"?jt("Function expected"):r,qe=(r,t,e,i,s)=>({kind:Ve[r],name:t,metadata:i,addInitializer:o=>e._?jt("Already initialized"):s.push(Ht(o||null))}),Je=(r,t)=>Be(t,Ut("metadata"),r[3]),Ge=(r,t,e,i)=>{for(var s=0,o=r[t>>1],n=o&&o.length;s<n;s++)o[s].call(e);return i},Ke=(r,t,e,i,s,o)=>{var n,c,a,l=t&7,d=!1,h=0,_=r[h]||(r[h]=[]),u=l&&(s=s.prototype,l<5&&(l>3||!d)&&Le(s,e));Fe(s,e);for(var p=i.length-1;p>=0;p--)a=qe(l,e,c={},r[3],_),n=(0,i[p])(s,a),c._=1,Ht(n)&&(s=n);return Je(r,s),u&&tt(s,e,u),d?l^4?o:u:s},Nt,et,Mt;Nt=[T("pg-relays")];class V extends(Mt=U){constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return f` <h2>My Prayer Relays</h2> `}}et=We(Mt);V=Ke(et,0,"PgRelays",Nt,V);Ge(et,1,V);var Ze=Object.create,rt=Object.defineProperty,Qe=Object.getOwnPropertyDescriptor,It=(r,t)=>(t=Symbol[r])?t:Symbol.for("Symbol."+r),Dt=r=>{throw TypeError(r)},Xe=(r,t,e)=>t in r?rt(r,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):r[t]=e,Ye=(r,t)=>rt(r,"name",{value:t,configurable:!0}),tr=r=>[,,,Ze((r==null?void 0:r[It("metadata")])??null)],er=["class","method","getter","setter","accessor","field","value","get","set"],Lt=r=>r!==void 0&&typeof r!="function"?Dt("Function expected"):r,rr=(r,t,e,i,s)=>({kind:er[r],name:t,metadata:i,addInitializer:o=>e._?Dt("Already initialized"):s.push(Lt(o||null))}),sr=(r,t)=>Xe(t,It("metadata"),r[3]),ir=(r,t,e,i)=>{for(var s=0,o=r[t>>1],n=o&&o.length;s<n;s++)o[s].call(e);return i},nr=(r,t,e,i,s,o)=>{var n,c,a,l=t&7,d=!1,h=0,_=r[h]||(r[h]=[]),u=l&&(s=s.prototype,l<5&&(l>3||!d)&&Qe(s,e));Ye(s,e);for(var p=i.length-1;p>=0;p--)a=rr(l,e,c={},r[3],_),n=(0,i[p])(s,a),c._=1,Lt(n)&&(s=n);return sr(r,s),u&&rt(s,e,u),d?l^4?o:u:s},Bt,st,Ft;Bt=[T("pg-router")];class q extends(Ft=Ot(Ce(U))){constructor(){super(...arguments),this.route="",this.params={},this.query={},this.data={}}static get properties(){return{route:{type:String},params:{type:Object},query:{type:Object},data:{type:Object}}}static get routes(){return[{name:"dashboard",pattern:"/profile",data:{render:()=>f`<pg-dashboard></pg-dashboard>`}},{name:"prayer-relays",pattern:"/profile/prayer-relays",data:{render:()=>f`<pg-relays></pg-relays>`}},{name:"prayer-activity",pattern:"/profile/prayer-activity",data:{render:()=>f`<pg-activity></pg-activity>`}},{name:"profile-settings",pattern:"/profile/profile-settings",data:{render:()=>f`<pg-settings></pg-settings>`}}]}router(t,e,i,s){this.route=t,this.params=e,this.query=i,this.data=s}render(){var t;return f` ${((t=this.data)==null?void 0:t.render)&&this.data.render()} `}}st=tr(Ft);q=nr(st,0,"PgRouter",Bt,q);ir(st,1,q);var or=Object.create,it=Object.defineProperty,ar=Object.getOwnPropertyDescriptor,Wt=(r,t)=>(t=Symbol[r])?t:Symbol.for("Symbol."+r),Vt=r=>{throw TypeError(r)},lr=(r,t,e)=>t in r?it(r,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):r[t]=e,cr=(r,t)=>it(r,"name",{value:t,configurable:!0}),hr=r=>[,,,or((r==null?void 0:r[Wt("metadata")])??null)],dr=["class","method","getter","setter","accessor","field","value","get","set"],qt=r=>r!==void 0&&typeof r!="function"?Vt("Function expected"):r,ur=(r,t,e,i,s)=>({kind:dr[r],name:t,metadata:i,addInitializer:o=>e._?Vt("Already initialized"):s.push(qt(o||null))}),pr=(r,t)=>lr(t,Wt("metadata"),r[3]),_r=(r,t,e,i)=>{for(var s=0,o=r[t>>1],n=o&&o.length;s<n;s++)o[s].call(e);return i},$r=(r,t,e,i,s,o)=>{var n,c,a,l=t&7,d=!1,h=0,_=r[h]||(r[h]=[]),u=l&&(s=s.prototype,l<5&&(l>3||!d)&&ar(s,e));cr(s,e);for(var p=i.length-1;p>=0;p--)a=ur(l,e,c={},r[3],_),n=(0,i[p])(s,a),c._=1,qt(n)&&(s=n);return pr(r,s),u&&it(s,e,u),d?l^4?o:u:s},Jt,nt,Gt;Jt=[T("pg-settings")];class J extends(Gt=U){constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.language="";const t=window.jsObject.current_language;Object.keys(window.jsObject.languages).includes(t)&&(this.language=window.jsObject.languages[t].native_name)}back(){history.back()}onSendGeneralEmailsChange(t){console.log("Method not implemented.")}render(){return f`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${this.back}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.profile}</h3>
      </div>
      <div class="container-md stack-md">
        <section>
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
                <td>${this.language}</td>
              </tr>
            </tbody>
          </table>
          <button class="mx-auto d-block brand-lightest">
            ${this.translations.edit}
          </button>
        </section>
        <hr />
        <section class="stack-sm">
          <h2 class="h5">${this.translations.communication_preferences}</h2>
          <label class="form-group" for="send_general_emails">
            <input
              type="checkbox"
              id="send_general_emails"
              ?checked="${this.user.send_general_emails}"
              @change=${t=>this.onSendGeneralEmailsChange(t)}
            />
            ${this.translations.send_general_emails_text}
          </label>
        </section>
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
            @click=${t=>this.deleteAccount(t)}
          >
            ${this.translations.delete_account}
          </button>
        </div>
      </div>
    `}deleteAccount(t){throw new Error("Method not implemented.")}}nt=hr(Gt);J=$r(nt,0,"PgSettings",Jt,J);_r(nt,1,J);
//# sourceMappingURL=components-bundle.js.map
