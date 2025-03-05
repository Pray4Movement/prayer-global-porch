/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const M=globalThis,G=M.ShadowRoot&&(M.ShadyCSS===void 0||M.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,K=Symbol(),X=new WeakMap;let pt=class{constructor(t,e,i){if(this._$cssResult$=!0,i!==K)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e}get styleSheet(){let t=this.o;const e=this.t;if(G&&t===void 0){const i=e!==void 0&&e.length===1;i&&(t=X.get(e)),t===void 0&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),i&&X.set(e,t))}return t}toString(){return this.cssText}};const yt=n=>new pt(typeof n=="string"?n:n+"",void 0,K),At=(n,...t)=>{const e=n.length===1?n[0]:t.reduce((i,r,a)=>i+(o=>{if(o._$cssResult$===!0)return o.cssText;if(typeof o=="number")return o;throw Error("Value passed to 'css' function must be a 'css' function result: "+o+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(r)+n[a+1],n[0]);return new pt(e,n,K)},wt=(n,t)=>{if(G)n.adoptedStyleSheets=t.map(e=>e instanceof CSSStyleSheet?e:e.styleSheet);else for(const e of t){const i=document.createElement("style"),r=M.litNonce;r!==void 0&&i.setAttribute("nonce",r),i.textContent=e.cssText,n.appendChild(i)}},Y=G?n=>n:n=>n instanceof CSSStyleSheet?(t=>{let e="";for(const i of t.cssRules)e+=i.cssText;return yt(e)})(n):n;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:Et,defineProperty:St,getOwnPropertyDescriptor:Pt,getOwnPropertyNames:xt,getOwnPropertySymbols:Ct,getPrototypeOf:Ot}=Object,_=globalThis,tt=_.trustedTypes,Ut=tt?tt.emptyScript:"",q=_.reactiveElementPolyfillSupport,O=(n,t)=>n,N={toAttribute(n,t){switch(t){case Boolean:n=n?Ut:null;break;case Object:case Array:n=n==null?n:JSON.stringify(n)}return n},fromAttribute(n,t){let e=n;switch(t){case Boolean:e=n!==null;break;case Number:e=n===null?null:Number(n);break;case Object:case Array:try{e=JSON.parse(n)}catch{e=null}}return e}},Z=(n,t)=>!Et(n,t),et={attribute:!0,type:String,converter:N,reflect:!1,hasChanged:Z};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),_.litPropertyMetadata??(_.litPropertyMetadata=new WeakMap);class A extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??(this.l=[])).push(t)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,e=et){if(e.state&&(e.attribute=!1),this._$Ei(),this.elementProperties.set(t,e),!e.noAccessor){const i=Symbol(),r=this.getPropertyDescriptor(t,i,e);r!==void 0&&St(this.prototype,t,r)}}static getPropertyDescriptor(t,e,i){const{get:r,set:a}=Pt(this.prototype,t)??{get(){return this[e]},set(o){this[e]=o}};return{get(){return r==null?void 0:r.call(this)},set(o){const c=r==null?void 0:r.call(this);a.call(this,o),this.requestUpdate(t,c,i)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??et}static _$Ei(){if(this.hasOwnProperty(O("elementProperties")))return;const t=Ot(this);t.finalize(),t.l!==void 0&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties)}static finalize(){if(this.hasOwnProperty(O("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(O("properties"))){const e=this.properties,i=[...xt(e),...Ct(e)];for(const r of i)this.createProperty(r,e[r])}const t=this[Symbol.metadata];if(t!==null){const e=litPropertyMetadata.get(t);if(e!==void 0)for(const[i,r]of e)this.elementProperties.set(i,r)}this._$Eh=new Map;for(const[e,i]of this.elementProperties){const r=this._$Eu(e,i);r!==void 0&&this._$Eh.set(r,e)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(t){const e=[];if(Array.isArray(t)){const i=new Set(t.flat(1/0).reverse());for(const r of i)e.unshift(Y(r))}else t!==void 0&&e.push(Y(t));return e}static _$Eu(t,e){const i=e.attribute;return i===!1?void 0:typeof i=="string"?i:typeof t=="string"?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var t;this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),(t=this.constructor.l)==null||t.forEach(e=>e(this))}addController(t){var e;(this._$EO??(this._$EO=new Set)).add(t),this.renderRoot!==void 0&&this.isConnected&&((e=t.hostConnected)==null||e.call(t))}removeController(t){var e;(e=this._$EO)==null||e.delete(t)}_$E_(){const t=new Map,e=this.constructor.elementProperties;for(const i of e.keys())this.hasOwnProperty(i)&&(t.set(i,this[i]),delete this[i]);t.size>0&&(this._$Ep=t)}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return wt(t,this.constructor.elementStyles),t}connectedCallback(){var t;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(t=this._$EO)==null||t.forEach(e=>{var i;return(i=e.hostConnected)==null?void 0:i.call(e)})}enableUpdating(t){}disconnectedCallback(){var t;(t=this._$EO)==null||t.forEach(e=>{var i;return(i=e.hostDisconnected)==null?void 0:i.call(e)})}attributeChangedCallback(t,e,i){this._$AK(t,i)}_$EC(t,e){var a;const i=this.constructor.elementProperties.get(t),r=this.constructor._$Eu(t,i);if(r!==void 0&&i.reflect===!0){const o=(((a=i.converter)==null?void 0:a.toAttribute)!==void 0?i.converter:N).toAttribute(e,i.type);this._$Em=t,o==null?this.removeAttribute(r):this.setAttribute(r,o),this._$Em=null}}_$AK(t,e){var a;const i=this.constructor,r=i._$Eh.get(t);if(r!==void 0&&this._$Em!==r){const o=i.getPropertyOptions(r),c=typeof o.converter=="function"?{fromAttribute:o.converter}:((a=o.converter)==null?void 0:a.fromAttribute)!==void 0?o.converter:N;this._$Em=r,this[r]=c.fromAttribute(e,o.type),this._$Em=null}}requestUpdate(t,e,i){if(t!==void 0){if(i??(i=this.constructor.getPropertyOptions(t)),!(i.hasChanged??Z)(this[t],e))return;this.P(t,e,i)}this.isUpdatePending===!1&&(this._$ES=this._$ET())}P(t,e,i){this._$AL.has(t)||this._$AL.set(t,e),i.reflect===!0&&this._$Em!==t&&(this._$Ej??(this._$Ej=new Set)).add(t)}async _$ET(){this.isUpdatePending=!0;try{await this._$ES}catch(e){Promise.reject(e)}const t=this.scheduleUpdate();return t!=null&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var i;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[a,o]of this._$Ep)this[a]=o;this._$Ep=void 0}const r=this.constructor.elementProperties;if(r.size>0)for(const[a,o]of r)o.wrapped!==!0||this._$AL.has(a)||this[a]===void 0||this.P(a,this[a],o)}let t=!1;const e=this._$AL;try{t=this.shouldUpdate(e),t?(this.willUpdate(e),(i=this._$EO)==null||i.forEach(r=>{var a;return(a=r.hostUpdate)==null?void 0:a.call(r)}),this.update(e)):this._$EU()}catch(r){throw t=!1,this._$EU(),r}t&&this._$AE(e)}willUpdate(t){}_$AE(t){var e;(e=this._$EO)==null||e.forEach(i=>{var r;return(r=i.hostUpdated)==null?void 0:r.call(i)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(t){return!0}update(t){this._$Ej&&(this._$Ej=this._$Ej.forEach(e=>this._$EC(e,this[e]))),this._$EU()}updated(t){}firstUpdated(t){}}A.elementStyles=[],A.shadowRootOptions={mode:"open"},A[O("elementProperties")]=new Map,A[O("finalized")]=new Map,q==null||q({ReactiveElement:A}),(_.reactiveElementVersions??(_.reactiveElementVersions=[])).push("2.0.4");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const U=globalThis,I=U.trustedTypes,st=I?I.createPolicy("lit-html",{createHTML:n=>n}):void 0,ft="$lit$",m=`lit$${Math.random().toFixed(9).slice(2)}$`,$t="?"+m,Tt=`<${$t}>`,y=document,T=()=>y.createComment(""),j=n=>n===null||typeof n!="object"&&typeof n!="function",Q=Array.isArray,jt=n=>Q(n)||typeof(n==null?void 0:n[Symbol.iterator])=="function",W=`[ 	
\f\r]`,C=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,it=/-->/g,rt=/>/g,b=RegExp(`>|${W}(?:([^\\s"'>=/]+)(${W}*=${W}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),nt=/'/g,ot=/"/g,gt=/^(?:script|style|textarea|title)$/i,Rt=n=>(t,...e)=>({_$litType$:n,strings:t,values:e}),f=Rt(1),E=Symbol.for("lit-noChange"),u=Symbol.for("lit-nothing"),at=new WeakMap,v=y.createTreeWalker(y,129);function mt(n,t){if(!Q(n)||!n.hasOwnProperty("raw"))throw Error("invalid template strings array");return st!==void 0?st.createHTML(t):t}const kt=(n,t)=>{const e=n.length-1,i=[];let r,a=t===2?"<svg>":t===3?"<math>":"",o=C;for(let c=0;c<e;c++){const l=n[c];let d,p,h=-1,$=0;for(;$<l.length&&(o.lastIndex=$,p=o.exec(l),p!==null);)$=o.lastIndex,o===C?p[1]==="!--"?o=it:p[1]!==void 0?o=rt:p[2]!==void 0?(gt.test(p[2])&&(r=RegExp("</"+p[2],"g")),o=b):p[3]!==void 0&&(o=b):o===b?p[0]===">"?(o=r??C,h=-1):p[1]===void 0?h=-2:(h=o.lastIndex-p[2].length,d=p[1],o=p[3]===void 0?b:p[3]==='"'?ot:nt):o===ot||o===nt?o=b:o===it||o===rt?o=C:(o=b,r=void 0);const g=o===b&&n[c+1].startsWith("/>")?" ":"";a+=o===C?l+Tt:h>=0?(i.push(d),l.slice(0,h)+ft+l.slice(h)+m+g):l+m+(h===-2?c:g)}return[mt(n,a+(n[e]||"<?>")+(t===2?"</svg>":t===3?"</math>":"")),i]};class R{constructor({strings:t,_$litType$:e},i){let r;this.parts=[];let a=0,o=0;const c=t.length-1,l=this.parts,[d,p]=kt(t,e);if(this.el=R.createElement(d,i),v.currentNode=this.el.content,e===2||e===3){const h=this.el.content.firstChild;h.replaceWith(...h.childNodes)}for(;(r=v.nextNode())!==null&&l.length<c;){if(r.nodeType===1){if(r.hasAttributes())for(const h of r.getAttributeNames())if(h.endsWith(ft)){const $=p[o++],g=r.getAttribute(h).split(m),z=/([.?@])?(.*)/.exec($);l.push({type:1,index:a,name:z[2],strings:g,ctor:z[1]==="."?Ht:z[1]==="?"?zt:z[1]==="@"?Mt:B}),r.removeAttribute(h)}else h.startsWith(m)&&(l.push({type:6,index:a}),r.removeAttribute(h));if(gt.test(r.tagName)){const h=r.textContent.split(m),$=h.length-1;if($>0){r.textContent=I?I.emptyScript:"";for(let g=0;g<$;g++)r.append(h[g],T()),v.nextNode(),l.push({type:2,index:++a});r.append(h[$],T())}}}else if(r.nodeType===8)if(r.data===$t)l.push({type:2,index:a});else{let h=-1;for(;(h=r.data.indexOf(m,h+1))!==-1;)l.push({type:7,index:a}),h+=m.length-1}a++}}static createElement(t,e){const i=y.createElement("template");return i.innerHTML=t,i}}function S(n,t,e=n,i){var o,c;if(t===E)return t;let r=i!==void 0?(o=e._$Co)==null?void 0:o[i]:e._$Cl;const a=j(t)?void 0:t._$litDirective$;return(r==null?void 0:r.constructor)!==a&&((c=r==null?void 0:r._$AO)==null||c.call(r,!1),a===void 0?r=void 0:(r=new a(n),r._$AT(n,e,i)),i!==void 0?(e._$Co??(e._$Co=[]))[i]=r:e._$Cl=r),r!==void 0&&(t=S(n,r._$AS(n,t.values),r,i)),t}class Dt{constructor(t,e){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=e}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:e},parts:i}=this._$AD,r=((t==null?void 0:t.creationScope)??y).importNode(e,!0);v.currentNode=r;let a=v.nextNode(),o=0,c=0,l=i[0];for(;l!==void 0;){if(o===l.index){let d;l.type===2?d=new k(a,a.nextSibling,this,t):l.type===1?d=new l.ctor(a,l.name,l.strings,this,t):l.type===6&&(d=new Nt(a,this,t)),this._$AV.push(d),l=i[++c]}o!==(l==null?void 0:l.index)&&(a=v.nextNode(),o++)}return v.currentNode=y,r}p(t){let e=0;for(const i of this._$AV)i!==void 0&&(i.strings!==void 0?(i._$AI(t,i,e),e+=i.strings.length-2):i._$AI(t[e])),e++}}class k{get _$AU(){var t;return((t=this._$AM)==null?void 0:t._$AU)??this._$Cv}constructor(t,e,i,r){this.type=2,this._$AH=u,this._$AN=void 0,this._$AA=t,this._$AB=e,this._$AM=i,this.options=r,this._$Cv=(r==null?void 0:r.isConnected)??!0}get parentNode(){let t=this._$AA.parentNode;const e=this._$AM;return e!==void 0&&(t==null?void 0:t.nodeType)===11&&(t=e.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,e=this){t=S(this,t,e),j(t)?t===u||t==null||t===""?(this._$AH!==u&&this._$AR(),this._$AH=u):t!==this._$AH&&t!==E&&this._(t):t._$litType$!==void 0?this.$(t):t.nodeType!==void 0?this.T(t):jt(t)?this.k(t):this._(t)}O(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}T(t){this._$AH!==t&&(this._$AR(),this._$AH=this.O(t))}_(t){this._$AH!==u&&j(this._$AH)?this._$AA.nextSibling.data=t:this.T(y.createTextNode(t)),this._$AH=t}$(t){var a;const{values:e,_$litType$:i}=t,r=typeof i=="number"?this._$AC(t):(i.el===void 0&&(i.el=R.createElement(mt(i.h,i.h[0]),this.options)),i);if(((a=this._$AH)==null?void 0:a._$AD)===r)this._$AH.p(e);else{const o=new Dt(r,this),c=o.u(this.options);o.p(e),this.T(c),this._$AH=o}}_$AC(t){let e=at.get(t.strings);return e===void 0&&at.set(t.strings,e=new R(t)),e}k(t){Q(this._$AH)||(this._$AH=[],this._$AR());const e=this._$AH;let i,r=0;for(const a of t)r===e.length?e.push(i=new k(this.O(T()),this.O(T()),this,this.options)):i=e[r],i._$AI(a),r++;r<e.length&&(this._$AR(i&&i._$AB.nextSibling,r),e.length=r)}_$AR(t=this._$AA.nextSibling,e){var i;for((i=this._$AP)==null?void 0:i.call(this,!1,!0,e);t&&t!==this._$AB;){const r=t.nextSibling;t.remove(),t=r}}setConnected(t){var e;this._$AM===void 0&&(this._$Cv=t,(e=this._$AP)==null||e.call(this,t))}}class B{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,e,i,r,a){this.type=1,this._$AH=u,this._$AN=void 0,this.element=t,this.name=e,this._$AM=r,this.options=a,i.length>2||i[0]!==""||i[1]!==""?(this._$AH=Array(i.length-1).fill(new String),this.strings=i):this._$AH=u}_$AI(t,e=this,i,r){const a=this.strings;let o=!1;if(a===void 0)t=S(this,t,e,0),o=!j(t)||t!==this._$AH&&t!==E,o&&(this._$AH=t);else{const c=t;let l,d;for(t=a[0],l=0;l<a.length-1;l++)d=S(this,c[i+l],e,l),d===E&&(d=this._$AH[l]),o||(o=!j(d)||d!==this._$AH[l]),d===u?t=u:t!==u&&(t+=(d??"")+a[l+1]),this._$AH[l]=d}o&&!r&&this.j(t)}j(t){t===u?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"")}}class Ht extends B{constructor(){super(...arguments),this.type=3}j(t){this.element[this.name]=t===u?void 0:t}}class zt extends B{constructor(){super(...arguments),this.type=4}j(t){this.element.toggleAttribute(this.name,!!t&&t!==u)}}class Mt extends B{constructor(t,e,i,r,a){super(t,e,i,r,a),this.type=5}_$AI(t,e=this){if((t=S(this,t,e,0)??u)===E)return;const i=this._$AH,r=t===u&&i!==u||t.capture!==i.capture||t.once!==i.once||t.passive!==i.passive,a=t!==u&&(i===u||r);r&&this.element.removeEventListener(this.name,this,i),a&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var e;typeof this._$AH=="function"?this._$AH.call(((e=this.options)==null?void 0:e.host)??this.element,t):this._$AH.handleEvent(t)}}class Nt{constructor(t,e,i){this.element=t,this.type=6,this._$AN=void 0,this._$AM=e,this.options=i}get _$AU(){return this._$AM._$AU}_$AI(t){S(this,t)}}const J=U.litHtmlPolyfillSupport;J==null||J(R,k),(U.litHtmlVersions??(U.litHtmlVersions=[])).push("3.2.1");const It=(n,t,e)=>{const i=(e==null?void 0:e.renderBefore)??t;let r=i._$litPart$;if(r===void 0){const a=(e==null?void 0:e.renderBefore)??null;i._$litPart$=r=new k(t.insertBefore(T(),a),a,void 0,e??{})}return r._$AI(n),r};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */let w=class extends A{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var e;const t=super.createRenderRoot();return(e=this.renderOptions).renderBefore??(e.renderBefore=t.firstChild),t}update(t){const e=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=It(e,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),(t=this._$Do)==null||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),(t=this._$Do)==null||t.setConnected(!1)}render(){return E}};var ut;w._$litElement$=!0,w.finalized=!0,(ut=globalThis.litElementHydrateSupport)==null||ut.call(globalThis,{LitElement:w});const F=globalThis.litElementPolyfillSupport;F==null||F({LitElement:w});(globalThis.litElementVersions??(globalThis.litElementVersions=[])).push("4.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const x=n=>(t,e)=>{e!==void 0?e.addInitializer(()=>{customElements.define(n,t)}):customElements.define(n,t)};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Lt={attribute:!0,type:String,converter:N,reflect:!1,hasChanged:Z},Bt=(n=Lt,t,e)=>{const{kind:i,metadata:r}=e;let a=globalThis.litPropertyMetadata.get(r);if(a===void 0&&globalThis.litPropertyMetadata.set(r,a=new Map),a.set(e.name,n),i==="accessor"){const{name:o}=e;return{set(c){const l=t.get.call(this);t.set.call(this,c),this.requestUpdate(o,l,n)},init(c){return c!==void 0&&this.P(o,void 0,n),c}}}if(i==="setter"){const{name:o}=e;return function(c){const l=this[o];t.call(this,c),this.requestUpdate(o,l,n)}}throw Error("Unsupported decorator location: "+i)};function _t(n){return(t,e)=>typeof e=="object"?Bt(n,t,e):((i,r,a)=>{const o=r.hasOwnProperty(a);return r.constructor.createProperty(a,o?{...i,wrapped:!0}:i),o?Object.getOwnPropertyDescriptor(r,a):void 0})(n,t,e)}/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */function V(n){return _t({...n,state:!0,attribute:!1})}class D extends w{constructor(){super()}createRenderRoot(){return this}}var Vt=Object.getOwnPropertyDescriptor,qt=(n,t,e,i)=>{for(var r=i>1?void 0:i?Vt(t,e):t,a=n.length-1,o;a>=0;a--)(o=n[a])&&(r=o(r)||r);return r};let lt=class extends D{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return f` <h2>Prayer Activity</h2> `}};lt=qt([x("pg-activity")],lt);function Wt(n){return n?JSON.parse('{"'+n.substring(1).replace(/&/g,'","').replace(/=/g,'":"')+'"}'):{}}function Jt(n,t){let e={};const i=n.split("/").filter(a=>a!=""),r=t.split("/").filter(a=>a!="");return i.map((a,o)=>{/^:/.test(a)&&(e[a.substring(1)]=r[o])}),e}function Ft(n){return n?new RegExp("^(|/)"+n.replace(/:[^\s/]+/g,"([\\wÀ-ÖØ-öø-ÿ-]+)")+"(|/)$"):new RegExp("(^$|^/$)")}function Gt(n,t){if(Ft(t).test(n))return!0}function Kt(n){return class extends n{static get properties(){return{route:{type:String,reflect:!0,attribute:"route"},canceled:{type:Boolean}}}constructor(...t){super(...t),this.route="",this.canceled=!1}connectedCallback(...t){super.connectedCallback(...t),this.routing(this.constructor.routes,(...e)=>this.router(...e)),window.addEventListener("route",()=>{this.routing(this.constructor.routes,(...e)=>this.router(...e))}),window.onpopstate=()=>{window.dispatchEvent(new CustomEvent("route"))}}routed(t,e,i,r,a,o){o&&o(t,e,i,r),a(t,e,i,r)}routing(t,e){this.canceled=!0;const i=decodeURI(window.location.pathname),r=decodeURI(window.location.search);let a=t.filter(l=>l.pattern==="*")[0],o=t.filter(l=>l.pattern!=="*"&&Gt(i,l.pattern))[0],c=Wt(r);o?(o.params=Jt(o.pattern,i),o.data=o.data||{},o.authentication&&o.authentication.authenticate&&typeof o.authentication.authenticate=="function"?(this.canceled=!1,Promise.resolve(o.authentication.authenticate.bind(this).call()).then(l=>{this.canceled||(l?o.authorization&&o.authorization.authorize&&typeof o.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(o.authorization.authorize.bind(this).call()).then(d=>{this.canceled||(d?this.routed(o.name,o.params,c,o.data,e,o.callback):this.routed(o.authorization.unauthorized.name,o.params,c,o.data,e,o.callback))})):this.routed(o.name,o.params,c,o.data,e,o.callback):this.routed(o.authentication.unauthenticated.name,o.params,c,o.data,e,o.callback))})):o.authorization&&o.authorization.authorize&&typeof o.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(o.authorization.authorize.bind(this).call()).then(l=>{this.canceled||(l?this.routed(o.name,o.params,c,o.data,e,o.callback):this.routed(o.authorization.unauthorized.name,o.params,c,o.data,e,o.callback))})):this.routed(o.name,o.params,c,o.data,e,o.callback)):a&&(a.data=a.data||{},this.routed(a.name,{},c,a.data,e,a.callback))}}}function bt(n){return class extends n{navigate(t){window.history.pushState({},null,t),window.dispatchEvent(new CustomEvent("route"))}}}var Zt=Object.getOwnPropertyDescriptor,Qt=(n,t,e,i)=>{for(var r=i>1?void 0:i?Zt(t,e):t,a=n.length-1,o;a>=0;a--)(o=n[a])&&(r=o(r)||r);return r};let ct=class extends bt(D){constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}navigateToHref(n){n.preventDefault();const{href:t}=n.currentTarget;this.navigate(t)}render(){return f`
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
    `}};ct=Qt([x("pg-dashboard")],ct);var Xt=Object.defineProperty,Yt=Object.getOwnPropertyDescriptor,vt=(n,t,e,i)=>{for(var r=i>1?void 0:i?Yt(t,e):t,a=n.length-1,o;a>=0;a--)(o=n[a])&&(r=(i?o(t,e,r):o(r))||r);return i&&r&&Xt(t,e,r),r};let L=class extends w{constructor(){super(...arguments),this.open=!1,this.modalId=this.generateId()}generateId(){return Array(6).fill("").map(()=>String.fromCharCode(97+Math.floor(Math.random()*26))).join("")}render(){return f`
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
              <h5 class="modal-title" id=${this.modalId+"_label"}>
                <slot name="title"></slot>
              </h5>
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
    `}close(){this.dispatchEvent(new CustomEvent("close"))}};L.styles=[At`
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
    `];vt([_t({type:Boolean})],L.prototype,"open",2);L=vt([x("pg-modal")],L);var te=Object.getOwnPropertyDescriptor,ee=(n,t,e,i)=>{for(var r=i>1?void 0:i?te(t,e):t,a=n.length-1,o;a>=0;a--)(o=n[a])&&(r=o(r)||r);return r};let ht=class extends D{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return f` <h2>My Prayer Relays</h2> `}};ht=ee([x("pg-relays")],ht);var se=Object.getOwnPropertyDescriptor,ie=(n,t,e,i)=>{for(var r=i>1?void 0:i?se(t,e):t,a=n.length-1,o;a>=0;a--)(o=n[a])&&(r=o(r)||r);return r};let dt=class extends bt(Kt(D)){constructor(){super(...arguments),this.route="",this.params={},this.query={},this.data={}}static get properties(){return{route:{type:String},params:{type:Object},query:{type:Object},data:{type:Object}}}static get routes(){return[{name:"dashboard",pattern:"/profile",data:{render:()=>f`<pg-dashboard></pg-dashboard>`}},{name:"prayer-relays",pattern:"/profile/prayer-relays",data:{render:()=>f`<pg-relays></pg-relays>`}},{name:"prayer-activity",pattern:"/profile/prayer-activity",data:{render:()=>f`<pg-activity></pg-activity>`}},{name:"profile-settings",pattern:"/profile/profile-settings",data:{render:()=>f`<pg-settings></pg-settings>`}}]}router(n,t,e,i){this.route=n,this.params=t,this.query=e,this.data=i}render(){var n;return f` ${((n=this.data)==null?void 0:n.render)&&this.data.render()} `}};dt=ie([x("pg-router")],dt);var re=Object.defineProperty,ne=Object.getOwnPropertyDescriptor,H=(n,t,e,i)=>{for(var r=i>1?void 0:i?ne(t,e):t,a=n.length-1,o;a>=0;a--)(o=n[a])&&(r=(i?o(t,e,r):o(r))||r);return i&&r&&re(t,e,r),r};let P=class extends D{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.language="",this.showDeleteAccount=!1,this.deleteInputValue="",this.subscribing=!1,this.subscribed=!1;const n=window.jsObject.current_language;Object.keys(window.jsObject.languages).includes(n)&&(this.language=window.jsObject.languages[n].native_name)}back(){history.back()}onSendGeneralEmailsChange(){this.subscribing=!0,window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/subscribe_to_news`,{method:"POST"}).then(n=>{n===!0&&(this.subscribed=!0),s}).finally(()=>{this.subscribing=!1})}openDeleteAccount(){this.showDeleteAccount=!0}closeDeleteAccount(){this.showDeleteAccount=!1}deleteAccount(){window.api_fetch(`${window.pg_global.root}pg-api/v1/profile/delete_user`,{method:"POST"}).then(n=>{n===!0&&(window.location.href="/")})}render(){return f`
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
          <p>${this.translations.send_general_emails_text}</p>
          <button
            class="btn btn-primary btn-small cluster s-sm"
            @click=${this.onSendGeneralEmailsChange}
            ?disabled=${this.subscribed||this.subscribing}
          >
            ${this.subscribed?this.translations.subscribed:this.translations.subscribe}
            ${this.subscribing?f` <span class="loading-spinner active"></span> `:""}
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
        <div slot="title">
          <h2 class="h5">${this.translations.delete_account}</h2>
        </div>
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
              @input=${n=>this.deleteInputValue=n.target.value}
            />
          </div>
        </div>
        <div slot="footer">
          <button
            type="button"
            class="btn btn-outline-primary"
            @click=${()=>this.closeDeleteAccount()}
          >
            ${this.translations.cancel}
          </button>
          <button
            type="button"
            class="btn btn-primary"
            id="delete-account-button"
            ?disabled=${this.deleteInputValue!=="delete"}
            @click=${()=>this.deleteAccount()}
          >
            ${this.translations.delete_account}
          </button>
        </div>
      </pg-modal>
    `}};H([V()],P.prototype,"showDeleteAccount",2);H([V()],P.prototype,"deleteInputValue",2);H([V()],P.prototype,"subscribing",2);H([V()],P.prototype,"subscribed",2);P=H([x("pg-settings")],P);
//# sourceMappingURL=components-bundle.js.map
