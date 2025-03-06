/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const z=globalThis,F=z.ShadowRoot&&(z.ShadyCSS===void 0||z.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,K=Symbol(),G=new WeakMap;let ut=class{constructor(t,e,s){if(this._$cssResult$=!0,s!==K)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e}get styleSheet(){let t=this.o;const e=this.t;if(F&&t===void 0){const s=e!==void 0&&e.length===1;s&&(t=G.get(e)),t===void 0&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),s&&G.set(e,t))}return t}toString(){return this.cssText}};const vt=n=>new ut(typeof n=="string"?n:n+"",void 0,K),yt=(n,...t)=>{const e=n.length===1?n[0]:t.reduce((s,i,o)=>s+(a=>{if(a._$cssResult$===!0)return a.cssText;if(typeof a=="number")return a;throw Error("Value passed to 'css' function must be a 'css' function result: "+a+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(i)+n[o+1],n[0]);return new ut(e,n,K)},wt=(n,t)=>{if(F)n.adoptedStyleSheets=t.map(e=>e instanceof CSSStyleSheet?e:e.styleSheet);else for(const e of t){const s=document.createElement("style"),i=z.litNonce;i!==void 0&&s.setAttribute("nonce",i),s.textContent=e.cssText,n.appendChild(s)}},X=F?n=>n:n=>n instanceof CSSStyleSheet?(t=>{let e="";for(const s of t.cssRules)e+=s.cssText;return vt(e)})(n):n;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:At,defineProperty:Et,getOwnPropertyDescriptor:xt,getOwnPropertyNames:St,getOwnPropertySymbols:Pt,getPrototypeOf:Ot}=Object,_=globalThis,Y=_.trustedTypes,Ct=Y?Y.emptyScript:"",V=_.reactiveElementPolyfillSupport,U=(n,t)=>n,M={toAttribute(n,t){switch(t){case Boolean:n=n?Ct:null;break;case Object:case Array:n=n==null?n:JSON.stringify(n)}return n},fromAttribute(n,t){let e=n;switch(t){case Boolean:e=n!==null;break;case Number:e=n===null?null:Number(n);break;case Object:case Array:try{e=JSON.parse(n)}catch{e=null}}return e}},Z=(n,t)=>!At(n,t),tt={attribute:!0,type:String,converter:M,reflect:!1,hasChanged:Z};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),_.litPropertyMetadata??(_.litPropertyMetadata=new WeakMap);class E extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??(this.l=[])).push(t)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,e=tt){if(e.state&&(e.attribute=!1),this._$Ei(),this.elementProperties.set(t,e),!e.noAccessor){const s=Symbol(),i=this.getPropertyDescriptor(t,s,e);i!==void 0&&Et(this.prototype,t,i)}}static getPropertyDescriptor(t,e,s){const{get:i,set:o}=xt(this.prototype,t)??{get(){return this[e]},set(a){this[e]=a}};return{get(){return i==null?void 0:i.call(this)},set(a){const l=i==null?void 0:i.call(this);o.call(this,a),this.requestUpdate(t,l,s)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??tt}static _$Ei(){if(this.hasOwnProperty(U("elementProperties")))return;const t=Ot(this);t.finalize(),t.l!==void 0&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties)}static finalize(){if(this.hasOwnProperty(U("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(U("properties"))){const e=this.properties,s=[...St(e),...Pt(e)];for(const i of s)this.createProperty(i,e[i])}const t=this[Symbol.metadata];if(t!==null){const e=litPropertyMetadata.get(t);if(e!==void 0)for(const[s,i]of e)this.elementProperties.set(s,i)}this._$Eh=new Map;for(const[e,s]of this.elementProperties){const i=this._$Eu(e,s);i!==void 0&&this._$Eh.set(i,e)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(t){const e=[];if(Array.isArray(t)){const s=new Set(t.flat(1/0).reverse());for(const i of s)e.unshift(X(i))}else t!==void 0&&e.push(X(t));return e}static _$Eu(t,e){const s=e.attribute;return s===!1?void 0:typeof s=="string"?s:typeof t=="string"?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var t;this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),(t=this.constructor.l)==null||t.forEach(e=>e(this))}addController(t){var e;(this._$EO??(this._$EO=new Set)).add(t),this.renderRoot!==void 0&&this.isConnected&&((e=t.hostConnected)==null||e.call(t))}removeController(t){var e;(e=this._$EO)==null||e.delete(t)}_$E_(){const t=new Map,e=this.constructor.elementProperties;for(const s of e.keys())this.hasOwnProperty(s)&&(t.set(s,this[s]),delete this[s]);t.size>0&&(this._$Ep=t)}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return wt(t,this.constructor.elementStyles),t}connectedCallback(){var t;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(t=this._$EO)==null||t.forEach(e=>{var s;return(s=e.hostConnected)==null?void 0:s.call(e)})}enableUpdating(t){}disconnectedCallback(){var t;(t=this._$EO)==null||t.forEach(e=>{var s;return(s=e.hostDisconnected)==null?void 0:s.call(e)})}attributeChangedCallback(t,e,s){this._$AK(t,s)}_$EC(t,e){var o;const s=this.constructor.elementProperties.get(t),i=this.constructor._$Eu(t,s);if(i!==void 0&&s.reflect===!0){const a=(((o=s.converter)==null?void 0:o.toAttribute)!==void 0?s.converter:M).toAttribute(e,s.type);this._$Em=t,a==null?this.removeAttribute(i):this.setAttribute(i,a),this._$Em=null}}_$AK(t,e){var o;const s=this.constructor,i=s._$Eh.get(t);if(i!==void 0&&this._$Em!==i){const a=s.getPropertyOptions(i),l=typeof a.converter=="function"?{fromAttribute:a.converter}:((o=a.converter)==null?void 0:o.fromAttribute)!==void 0?a.converter:M;this._$Em=i,this[i]=l.fromAttribute(e,a.type),this._$Em=null}}requestUpdate(t,e,s){if(t!==void 0){if(s??(s=this.constructor.getPropertyOptions(t)),!(s.hasChanged??Z)(this[t],e))return;this.P(t,e,s)}this.isUpdatePending===!1&&(this._$ES=this._$ET())}P(t,e,s){this._$AL.has(t)||this._$AL.set(t,e),s.reflect===!0&&this._$Em!==t&&(this._$Ej??(this._$Ej=new Set)).add(t)}async _$ET(){this.isUpdatePending=!0;try{await this._$ES}catch(e){Promise.reject(e)}const t=this.scheduleUpdate();return t!=null&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var s;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[o,a]of this._$Ep)this[o]=a;this._$Ep=void 0}const i=this.constructor.elementProperties;if(i.size>0)for(const[o,a]of i)a.wrapped!==!0||this._$AL.has(o)||this[o]===void 0||this.P(o,this[o],a)}let t=!1;const e=this._$AL;try{t=this.shouldUpdate(e),t?(this.willUpdate(e),(s=this._$EO)==null||s.forEach(i=>{var o;return(o=i.hostUpdate)==null?void 0:o.call(i)}),this.update(e)):this._$EU()}catch(i){throw t=!1,this._$EU(),i}t&&this._$AE(e)}willUpdate(t){}_$AE(t){var e;(e=this._$EO)==null||e.forEach(s=>{var i;return(i=s.hostUpdated)==null?void 0:i.call(s)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(t){return!0}update(t){this._$Ej&&(this._$Ej=this._$Ej.forEach(e=>this._$EC(e,this[e]))),this._$EU()}updated(t){}firstUpdated(t){}}E.elementStyles=[],E.shadowRootOptions={mode:"open"},E[U("elementProperties")]=new Map,E[U("finalized")]=new Map,V==null||V({ReactiveElement:E}),(_.reactiveElementVersions??(_.reactiveElementVersions=[])).push("2.0.4");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const j=globalThis,I=j.trustedTypes,et=I?I.createPolicy("lit-html",{createHTML:n=>n}):void 0,pt="$lit$",$=`lit$${Math.random().toFixed(9).slice(2)}$`,gt="?"+$,Ut=`<${gt}>`,w=document,T=()=>w.createComment(""),k=n=>n===null||typeof n!="object"&&typeof n!="function",Q=Array.isArray,jt=n=>Q(n)||typeof(n==null?void 0:n[Symbol.iterator])=="function",q=`[ 	
\f\r]`,C=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,st=/-->/g,it=/>/g,v=RegExp(`>|${q}(?:([^\\s"'>=/]+)(${q}*=${q}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),nt=/'/g,at=/"/g,mt=/^(?:script|style|textarea|title)$/i,Tt=n=>(t,...e)=>({_$litType$:n,strings:t,values:e}),p=Tt(1),S=Symbol.for("lit-noChange"),d=Symbol.for("lit-nothing"),ot=new WeakMap,y=w.createTreeWalker(w,129);function ft(n,t){if(!Q(n)||!n.hasOwnProperty("raw"))throw Error("invalid template strings array");return et!==void 0?et.createHTML(t):t}const kt=(n,t)=>{const e=n.length-1,s=[];let i,o=t===2?"<svg>":t===3?"<math>":"",a=C;for(let l=0;l<e;l++){const r=n[l];let h,u,c=-1,g=0;for(;g<r.length&&(a.lastIndex=g,u=a.exec(r),u!==null);)g=a.lastIndex,a===C?u[1]==="!--"?a=st:u[1]!==void 0?a=it:u[2]!==void 0?(mt.test(u[2])&&(i=RegExp("</"+u[2],"g")),a=v):u[3]!==void 0&&(a=v):a===v?u[0]===">"?(a=i??C,c=-1):u[1]===void 0?c=-2:(c=a.lastIndex-u[2].length,h=u[1],a=u[3]===void 0?v:u[3]==='"'?at:nt):a===at||a===nt?a=v:a===st||a===it?a=C:(a=v,i=void 0);const f=a===v&&n[l+1].startsWith("/>")?" ":"";o+=a===C?r+Ut:c>=0?(s.push(h),r.slice(0,c)+pt+r.slice(c)+$+f):r+$+(c===-2?l:f)}return[ft(n,o+(n[e]||"<?>")+(t===2?"</svg>":t===3?"</math>":"")),s]};class R{constructor({strings:t,_$litType$:e},s){let i;this.parts=[];let o=0,a=0;const l=t.length-1,r=this.parts,[h,u]=kt(t,e);if(this.el=R.createElement(h,s),y.currentNode=this.el.content,e===2||e===3){const c=this.el.content.firstChild;c.replaceWith(...c.childNodes)}for(;(i=y.nextNode())!==null&&r.length<l;){if(i.nodeType===1){if(i.hasAttributes())for(const c of i.getAttributeNames())if(c.endsWith(pt)){const g=u[a++],f=i.getAttribute(c).split($),N=/([.?@])?(.*)/.exec(g);r.push({type:1,index:o,name:N[2],strings:f,ctor:N[1]==="."?Dt:N[1]==="?"?Ht:N[1]==="@"?Nt:B}),i.removeAttribute(c)}else c.startsWith($)&&(r.push({type:6,index:o}),i.removeAttribute(c));if(mt.test(i.tagName)){const c=i.textContent.split($),g=c.length-1;if(g>0){i.textContent=I?I.emptyScript:"";for(let f=0;f<g;f++)i.append(c[f],T()),y.nextNode(),r.push({type:2,index:++o});i.append(c[g],T())}}}else if(i.nodeType===8)if(i.data===gt)r.push({type:2,index:o});else{let c=-1;for(;(c=i.data.indexOf($,c+1))!==-1;)r.push({type:7,index:o}),c+=$.length-1}o++}}static createElement(t,e){const s=w.createElement("template");return s.innerHTML=t,s}}function P(n,t,e=n,s){var a,l;if(t===S)return t;let i=s!==void 0?(a=e._$Co)==null?void 0:a[s]:e._$Cl;const o=k(t)?void 0:t._$litDirective$;return(i==null?void 0:i.constructor)!==o&&((l=i==null?void 0:i._$AO)==null||l.call(i,!1),o===void 0?i=void 0:(i=new o(n),i._$AT(n,e,s)),s!==void 0?(e._$Co??(e._$Co=[]))[s]=i:e._$Cl=i),i!==void 0&&(t=P(n,i._$AS(n,t.values),i,s)),t}class Rt{constructor(t,e){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=e}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:e},parts:s}=this._$AD,i=((t==null?void 0:t.creationScope)??w).importNode(e,!0);y.currentNode=i;let o=y.nextNode(),a=0,l=0,r=s[0];for(;r!==void 0;){if(a===r.index){let h;r.type===2?h=new D(o,o.nextSibling,this,t):r.type===1?h=new r.ctor(o,r.name,r.strings,this,t):r.type===6&&(h=new zt(o,this,t)),this._$AV.push(h),r=s[++l]}a!==(r==null?void 0:r.index)&&(o=y.nextNode(),a++)}return y.currentNode=w,i}p(t){let e=0;for(const s of this._$AV)s!==void 0&&(s.strings!==void 0?(s._$AI(t,s,e),e+=s.strings.length-2):s._$AI(t[e])),e++}}class D{get _$AU(){var t;return((t=this._$AM)==null?void 0:t._$AU)??this._$Cv}constructor(t,e,s,i){this.type=2,this._$AH=d,this._$AN=void 0,this._$AA=t,this._$AB=e,this._$AM=s,this.options=i,this._$Cv=(i==null?void 0:i.isConnected)??!0}get parentNode(){let t=this._$AA.parentNode;const e=this._$AM;return e!==void 0&&(t==null?void 0:t.nodeType)===11&&(t=e.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,e=this){t=P(this,t,e),k(t)?t===d||t==null||t===""?(this._$AH!==d&&this._$AR(),this._$AH=d):t!==this._$AH&&t!==S&&this._(t):t._$litType$!==void 0?this.$(t):t.nodeType!==void 0?this.T(t):jt(t)?this.k(t):this._(t)}O(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}T(t){this._$AH!==t&&(this._$AR(),this._$AH=this.O(t))}_(t){this._$AH!==d&&k(this._$AH)?this._$AA.nextSibling.data=t:this.T(w.createTextNode(t)),this._$AH=t}$(t){var o;const{values:e,_$litType$:s}=t,i=typeof s=="number"?this._$AC(t):(s.el===void 0&&(s.el=R.createElement(ft(s.h,s.h[0]),this.options)),s);if(((o=this._$AH)==null?void 0:o._$AD)===i)this._$AH.p(e);else{const a=new Rt(i,this),l=a.u(this.options);a.p(e),this.T(l),this._$AH=a}}_$AC(t){let e=ot.get(t.strings);return e===void 0&&ot.set(t.strings,e=new R(t)),e}k(t){Q(this._$AH)||(this._$AH=[],this._$AR());const e=this._$AH;let s,i=0;for(const o of t)i===e.length?e.push(s=new D(this.O(T()),this.O(T()),this,this.options)):s=e[i],s._$AI(o),i++;i<e.length&&(this._$AR(s&&s._$AB.nextSibling,i),e.length=i)}_$AR(t=this._$AA.nextSibling,e){var s;for((s=this._$AP)==null?void 0:s.call(this,!1,!0,e);t&&t!==this._$AB;){const i=t.nextSibling;t.remove(),t=i}}setConnected(t){var e;this._$AM===void 0&&(this._$Cv=t,(e=this._$AP)==null||e.call(this,t))}}class B{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,e,s,i,o){this.type=1,this._$AH=d,this._$AN=void 0,this.element=t,this.name=e,this._$AM=i,this.options=o,s.length>2||s[0]!==""||s[1]!==""?(this._$AH=Array(s.length-1).fill(new String),this.strings=s):this._$AH=d}_$AI(t,e=this,s,i){const o=this.strings;let a=!1;if(o===void 0)t=P(this,t,e,0),a=!k(t)||t!==this._$AH&&t!==S,a&&(this._$AH=t);else{const l=t;let r,h;for(t=o[0],r=0;r<o.length-1;r++)h=P(this,l[s+r],e,r),h===S&&(h=this._$AH[r]),a||(a=!k(h)||h!==this._$AH[r]),h===d?t=d:t!==d&&(t+=(h??"")+o[r+1]),this._$AH[r]=h}a&&!i&&this.j(t)}j(t){t===d?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"")}}class Dt extends B{constructor(){super(...arguments),this.type=3}j(t){this.element[this.name]=t===d?void 0:t}}class Ht extends B{constructor(){super(...arguments),this.type=4}j(t){this.element.toggleAttribute(this.name,!!t&&t!==d)}}class Nt extends B{constructor(t,e,s,i,o){super(t,e,s,i,o),this.type=5}_$AI(t,e=this){if((t=P(this,t,e,0)??d)===S)return;const s=this._$AH,i=t===d&&s!==d||t.capture!==s.capture||t.once!==s.once||t.passive!==s.passive,o=t!==d&&(s===d||i);i&&this.element.removeEventListener(this.name,this,s),o&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var e;typeof this._$AH=="function"?this._$AH.call(((e=this.options)==null?void 0:e.host)??this.element,t):this._$AH.handleEvent(t)}}class zt{constructor(t,e,s){this.element=t,this.type=6,this._$AN=void 0,this._$AM=e,this.options=s}get _$AU(){return this._$AM._$AU}_$AI(t){P(this,t)}}const W=j.litHtmlPolyfillSupport;W==null||W(R,D),(j.litHtmlVersions??(j.litHtmlVersions=[])).push("3.2.1");const Mt=(n,t,e)=>{const s=(e==null?void 0:e.renderBefore)??t;let i=s._$litPart$;if(i===void 0){const o=(e==null?void 0:e.renderBefore)??null;s._$litPart$=i=new D(t.insertBefore(T(),o),o,void 0,e??{})}return i._$AI(n),i};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */let x=class extends E{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var e;const t=super.createRenderRoot();return(e=this.renderOptions).renderBefore??(e.renderBefore=t.firstChild),t}update(t){const e=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=Mt(e,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),(t=this._$Do)==null||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),(t=this._$Do)==null||t.setConnected(!1)}render(){return S}};var dt;x._$litElement$=!0,x.finalized=!0,(dt=globalThis.litElementHydrateSupport)==null||dt.call(globalThis,{LitElement:x});const J=globalThis.litElementPolyfillSupport;J==null||J({LitElement:x});(globalThis.litElementVersions??(globalThis.litElementVersions=[])).push("4.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const O=n=>(t,e)=>{e!==void 0?e.addInitializer(()=>{customElements.define(n,t)}):customElements.define(n,t)};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const It={attribute:!0,type:String,converter:M,reflect:!1,hasChanged:Z},Lt=(n=It,t,e)=>{const{kind:s,metadata:i}=e;let o=globalThis.litPropertyMetadata.get(i);if(o===void 0&&globalThis.litPropertyMetadata.set(i,o=new Map),o.set(e.name,n),s==="accessor"){const{name:a}=e;return{set(l){const r=t.get.call(this);t.set.call(this,l),this.requestUpdate(a,r,n)},init(l){return l!==void 0&&this.P(a,void 0,n),l}}}if(s==="setter"){const{name:a}=e;return function(l){const r=this[a];t.call(this,l),this.requestUpdate(a,r,n)}}throw Error("Unsupported decorator location: "+s)};function $t(n){return(t,e)=>typeof e=="object"?Lt(n,t,e):((s,i,o)=>{const a=i.hasOwnProperty(o);return i.constructor.createProperty(o,a?{...s,wrapped:!0}:s),a?Object.getOwnPropertyDescriptor(i,o):void 0})(n,t,e)}/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */function A(n){return $t({...n,state:!0,attribute:!1})}class H extends x{constructor(){super()}createRenderRoot(){return this}}var Bt=Object.getOwnPropertyDescriptor,Vt=(n,t,e,s)=>{for(var i=s>1?void 0:s?Bt(t,e):t,o=n.length-1,a;o>=0;o--)(a=n[o])&&(i=a(i)||i);return i};let rt=class extends H{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return p` <h2>Prayer Activity</h2> `}};rt=Vt([O("pg-activity")],rt);function qt(n){return n?JSON.parse('{"'+n.substring(1).replace(/&/g,'","').replace(/=/g,'":"')+'"}'):{}}function Wt(n,t){let e={};const s=n.split("/").filter(o=>o!=""),i=t.split("/").filter(o=>o!="");return s.map((o,a)=>{/^:/.test(o)&&(e[o.substring(1)]=i[a])}),e}function Jt(n){return n?new RegExp("^(|/)"+n.replace(/:[^\s/]+/g,"([\\wÀ-ÖØ-öø-ÿ-]+)")+"(|/)$"):new RegExp("(^$|^/$)")}function Ft(n,t){if(Jt(t).test(n))return!0}function Kt(n){return class extends n{static get properties(){return{route:{type:String,reflect:!0,attribute:"route"},canceled:{type:Boolean}}}constructor(...t){super(...t),this.route="",this.canceled=!1}connectedCallback(...t){super.connectedCallback(...t),this.routing(this.constructor.routes,(...e)=>this.router(...e)),window.addEventListener("route",()=>{this.routing(this.constructor.routes,(...e)=>this.router(...e))}),window.onpopstate=()=>{window.dispatchEvent(new CustomEvent("route"))}}routed(t,e,s,i,o,a){a&&a(t,e,s,i),o(t,e,s,i)}routing(t,e){this.canceled=!0;const s=decodeURI(window.location.pathname),i=decodeURI(window.location.search);let o=t.filter(r=>r.pattern==="*")[0],a=t.filter(r=>r.pattern!=="*"&&Ft(s,r.pattern))[0],l=qt(i);a?(a.params=Wt(a.pattern,s),a.data=a.data||{},a.authentication&&a.authentication.authenticate&&typeof a.authentication.authenticate=="function"?(this.canceled=!1,Promise.resolve(a.authentication.authenticate.bind(this).call()).then(r=>{this.canceled||(r?a.authorization&&a.authorization.authorize&&typeof a.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(a.authorization.authorize.bind(this).call()).then(h=>{this.canceled||(h?this.routed(a.name,a.params,l,a.data,e,a.callback):this.routed(a.authorization.unauthorized.name,a.params,l,a.data,e,a.callback))})):this.routed(a.name,a.params,l,a.data,e,a.callback):this.routed(a.authentication.unauthenticated.name,a.params,l,a.data,e,a.callback))})):a.authorization&&a.authorization.authorize&&typeof a.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(a.authorization.authorize.bind(this).call()).then(r=>{this.canceled||(r?this.routed(a.name,a.params,l,a.data,e,a.callback):this.routed(a.authorization.unauthorized.name,a.params,l,a.data,e,a.callback))})):this.routed(a.name,a.params,l,a.data,e,a.callback)):o&&(o.data=o.data||{},this.routed(o.name,{},l,o.data,e,o.callback))}}}function _t(n){return class extends n{navigate(t){window.history.pushState({},null,t),window.dispatchEvent(new CustomEvent("route"))}}}var Zt=Object.getOwnPropertyDescriptor,Qt=(n,t,e,s)=>{for(var i=s>1?void 0:s?Zt(t,e):t,o=n.length-1,a;o>=0;o--)(a=n[o])&&(i=a(i)||i);return i};let lt=class extends _t(H){constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}navigateToHref(n){n.preventDefault();const{href:t}=n.currentTarget;this.navigate(t)}render(){return p`
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
                    @click=${n=>this.navigateToHref(n)}
                  >
                    <i class="icon pg-relay two-rem"></i>
                    <span class="one-rem">
                      ${this.translations.challenges}
                    </span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/prayer-activity"
                    @click=${n=>this.navigateToHref(n)}
                  >
                    <i class="icon pg-prayer two-rem"></i>
                    <span class="one-rem">${this.translations.prayers}</span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/profile-settings"
                    @click=${n=>this.navigateToHref(n)}
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
                  >
                    ${this.translations.give}
                  </a>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    `}};lt=Qt([O("pg-dashboard")],lt);var Gt=Object.defineProperty,Xt=Object.getOwnPropertyDescriptor,bt=(n,t,e,s)=>{for(var i=s>1?void 0:s?Xt(t,e):t,o=n.length-1,a;o>=0;o--)(a=n[o])&&(i=(s?a(t,e,i):a(i))||i);return s&&i&&Gt(t,e,i),i};let L=class extends x{constructor(){super(...arguments),this.open=!1,this.modalId=this.generateId()}generateId(){return Array(6).fill("").map(()=>String.fromCharCode(97+Math.floor(Math.random()*26))).join("")}render(){return p`
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
    `}close(){this.dispatchEvent(new CustomEvent("close"))}};L.styles=[yt`
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
    `];bt([$t({type:Boolean})],L.prototype,"open",2);L=bt([O("pg-modal")],L);var Yt=Object.getOwnPropertyDescriptor,te=(n,t,e,s)=>{for(var i=s>1?void 0:s?Yt(t,e):t,o=n.length-1,a;o>=0;o--)(a=n[o])&&(i=a(i)||i);return i};let ct=class extends H{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return p` <h2>My Prayer Relays</h2> `}};ct=te([O("pg-relays")],ct);var ee=Object.getOwnPropertyDescriptor,se=(n,t,e,s)=>{for(var i=s>1?void 0:s?ee(t,e):t,o=n.length-1,a;o>=0;o--)(a=n[o])&&(i=a(i)||i);return i};let ht=class extends _t(Kt(H)){constructor(){super(...arguments),this.route="",this.params={},this.query={},this.data={}}static get properties(){return{route:{type:String},params:{type:Object},query:{type:Object},data:{type:Object}}}static get routes(){return[{name:"dashboard",pattern:"/profile",data:{render:()=>p`<pg-dashboard></pg-dashboard>`}},{name:"prayer-relays",pattern:"/profile/prayer-relays",data:{render:()=>p`<pg-relays></pg-relays>`}},{name:"prayer-activity",pattern:"/profile/prayer-activity",data:{render:()=>p`<pg-activity></pg-activity>`}},{name:"profile-settings",pattern:"/profile/profile-settings",data:{render:()=>p`<pg-settings></pg-settings>`}}]}router(n,t,e,s){this.route=n,this.params=t,this.query=e,this.data=s}render(){var n;return p` ${((n=this.data)==null?void 0:n.render)&&this.data.render()} `}};ht=se([O("pg-router")],ht);var ie=Object.defineProperty,ne=Object.getOwnPropertyDescriptor,b=(n,t,e,s)=>{for(var i=s>1?void 0:s?ne(t,e):t,o=n.length-1,a;o>=0;o--)(a=n[o])&&(i=(s?a(t,e,i):a(i))||i);return s&&i&&ie(t,e,i),i};let m=class extends H{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.currentLanguage=window.jsObject.current_language,this.language=null,this.showEditAccount=!1,this.saving=!1,this.name=this.user.display_name,this.showDeleteAccount=!1,this.deleteInputValue="",this.subscribing=!1,this.subscribed=!1;const n=window.jsObject.current_language;Object.keys(window.jsObject.languages).includes(n)&&(this.language=window.jsObject.languages[n])}back(){history.back()}subsribeToNews(){this.subscribing=!0,window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/subscribe_to_news`,{method:"POST"}).then(n=>{n===!0&&(this.subscribed=!0)}).finally(()=>{this.subscribing=!1})}openEditAccount(){this.showEditAccount=!0}closeEditAccount(){this.showEditAccount=!1}editAccount(){this.user.display_name=this.name,this.saving=!0;const n={display_name:this.name};window.location_data&&window.location_data.location_grid_meta&&window.location_data.location_grid_meta.values&&Array.isArray(window.location_data.location_grid_meta.values)&&window.location_data.location_grid_meta.values.length>0&&(n.location=window.location_data.location_grid_meta.values[0],this.user={...this.user,location:n.location}),window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/save_details`,{method:"POST",body:JSON.stringify(n)}).finally(()=>{if(this.language&&this.language.po_code!==this.currentLanguage){const t=new URLSearchParams(window.location.search);t.set("lang",this.language.po_code),window.location.search=t.toString()}this.closeEditAccount(),this.saving=!1})}openDeleteAccount(){this.showDeleteAccount=!0}closeDeleteAccount(){this.showDeleteAccount=!1}deleteAccount(){window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/delete_user`,{method:"POST"}).then(n=>{n===!0&&(window.location.href="/")})}handleChangeName(n){this.name=n}handleChangeLanguage(n){const t=n.target.value;this.language=window.jsObject.languages[t]??null}render(){var n;return p`
      <div class="offcanvas__header align-items-center lh-sm">
        <button type="button" class="me-auto" @click=${this.back}>
          <i class="icon pg-chevron-left two-em"></i>
        </button>
        <h3 class="mb-0 me-auto">${this.translations.profile}</h3>
      </div>
      <div class="container-md stack-md pb-10">
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
                <td>${(n=this.language)==null?void 0:n.native_name}</td>
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
        <i slot="close-icon" class="icon pg-close brand-light two-em"></i>
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
        <i slot="close-icon" class="icon pg-close brand-light two-em"></i>
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
                      <i class="icon pg-close one-rem lh-small"></i>
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
    `}};b([A()],m.prototype,"showEditAccount",2);b([A()],m.prototype,"saving",2);b([A()],m.prototype,"name",2);b([A()],m.prototype,"showDeleteAccount",2);b([A()],m.prototype,"deleteInputValue",2);b([A()],m.prototype,"subscribing",2);b([A()],m.prototype,"subscribed",2);m=b([O("pg-settings")],m);
//# sourceMappingURL=components-bundle.js.map
