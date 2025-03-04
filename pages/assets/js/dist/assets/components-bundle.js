/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const D=globalThis,W=D.ShadowRoot&&(D.ShadyCSS===void 0||D.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,J=Symbol(),Z=new WeakMap;let dt=class{constructor(t,e,s){if(this._$cssResult$=!0,s!==J)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=e}get styleSheet(){let t=this.o;const e=this.t;if(W&&t===void 0){const s=e!==void 0&&e.length===1;s&&(t=Z.get(e)),t===void 0&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),s&&Z.set(e,t))}return t}toString(){return this.cssText}};const yt=r=>new dt(typeof r=="string"?r:r+"",void 0,J),bt=(r,...t)=>{const e=r.length===1?r[0]:t.reduce((s,i,o)=>s+(n=>{if(n._$cssResult$===!0)return n.cssText;if(typeof n=="number")return n;throw Error("Value passed to 'css' function must be a 'css' function result: "+n+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(i)+r[o+1],r[0]);return new dt(e,r,J)},At=(r,t)=>{if(W)r.adoptedStyleSheets=t.map(e=>e instanceof CSSStyleSheet?e:e.styleSheet);else for(const e of t){const s=document.createElement("style"),i=D.litNonce;i!==void 0&&s.setAttribute("nonce",i),s.textContent=e.cssText,r.appendChild(s)}},Q=W?r=>r:r=>r instanceof CSSStyleSheet?(t=>{let e="";for(const s of t.cssRules)e+=s.cssText;return yt(e)})(r):r;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:wt,defineProperty:Et,getOwnPropertyDescriptor:St,getOwnPropertyNames:Pt,getOwnPropertySymbols:xt,getPrototypeOf:Ot}=Object,m=globalThis,X=m.trustedTypes,Ct=X?X.emptyScript:"",L=m.reactiveElementPolyfillSupport,x=(r,t)=>r,H={toAttribute(r,t){switch(t){case Boolean:r=r?Ct:null;break;case Object:case Array:r=r==null?r:JSON.stringify(r)}return r},fromAttribute(r,t){let e=r;switch(t){case Boolean:e=r!==null;break;case Number:e=r===null?null:Number(r);break;case Object:case Array:try{e=JSON.parse(r)}catch{e=null}}return e}},F=(r,t)=>!wt(r,t),Y={attribute:!0,type:String,converter:H,reflect:!1,hasChanged:F};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),m.litPropertyMetadata??(m.litPropertyMetadata=new WeakMap);class b extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??(this.l=[])).push(t)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,e=Y){if(e.state&&(e.attribute=!1),this._$Ei(),this.elementProperties.set(t,e),!e.noAccessor){const s=Symbol(),i=this.getPropertyDescriptor(t,s,e);i!==void 0&&Et(this.prototype,t,i)}}static getPropertyDescriptor(t,e,s){const{get:i,set:o}=St(this.prototype,t)??{get(){return this[e]},set(n){this[e]=n}};return{get(){return i==null?void 0:i.call(this)},set(n){const l=i==null?void 0:i.call(this);o.call(this,n),this.requestUpdate(t,l,s)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??Y}static _$Ei(){if(this.hasOwnProperty(x("elementProperties")))return;const t=Ot(this);t.finalize(),t.l!==void 0&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties)}static finalize(){if(this.hasOwnProperty(x("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(x("properties"))){const e=this.properties,s=[...Pt(e),...xt(e)];for(const i of s)this.createProperty(i,e[i])}const t=this[Symbol.metadata];if(t!==null){const e=litPropertyMetadata.get(t);if(e!==void 0)for(const[s,i]of e)this.elementProperties.set(s,i)}this._$Eh=new Map;for(const[e,s]of this.elementProperties){const i=this._$Eu(e,s);i!==void 0&&this._$Eh.set(i,e)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(t){const e=[];if(Array.isArray(t)){const s=new Set(t.flat(1/0).reverse());for(const i of s)e.unshift(Q(i))}else t!==void 0&&e.push(Q(t));return e}static _$Eu(t,e){const s=e.attribute;return s===!1?void 0:typeof s=="string"?s:typeof t=="string"?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var t;this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),(t=this.constructor.l)==null||t.forEach(e=>e(this))}addController(t){var e;(this._$EO??(this._$EO=new Set)).add(t),this.renderRoot!==void 0&&this.isConnected&&((e=t.hostConnected)==null||e.call(t))}removeController(t){var e;(e=this._$EO)==null||e.delete(t)}_$E_(){const t=new Map,e=this.constructor.elementProperties;for(const s of e.keys())this.hasOwnProperty(s)&&(t.set(s,this[s]),delete this[s]);t.size>0&&(this._$Ep=t)}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return At(t,this.constructor.elementStyles),t}connectedCallback(){var t;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(t=this._$EO)==null||t.forEach(e=>{var s;return(s=e.hostConnected)==null?void 0:s.call(e)})}enableUpdating(t){}disconnectedCallback(){var t;(t=this._$EO)==null||t.forEach(e=>{var s;return(s=e.hostDisconnected)==null?void 0:s.call(e)})}attributeChangedCallback(t,e,s){this._$AK(t,s)}_$EC(t,e){var o;const s=this.constructor.elementProperties.get(t),i=this.constructor._$Eu(t,s);if(i!==void 0&&s.reflect===!0){const n=(((o=s.converter)==null?void 0:o.toAttribute)!==void 0?s.converter:H).toAttribute(e,s.type);this._$Em=t,n==null?this.removeAttribute(i):this.setAttribute(i,n),this._$Em=null}}_$AK(t,e){var o;const s=this.constructor,i=s._$Eh.get(t);if(i!==void 0&&this._$Em!==i){const n=s.getPropertyOptions(i),l=typeof n.converter=="function"?{fromAttribute:n.converter}:((o=n.converter)==null?void 0:o.fromAttribute)!==void 0?n.converter:H;this._$Em=i,this[i]=l.fromAttribute(e,n.type),this._$Em=null}}requestUpdate(t,e,s){if(t!==void 0){if(s??(s=this.constructor.getPropertyOptions(t)),!(s.hasChanged??F)(this[t],e))return;this.P(t,e,s)}this.isUpdatePending===!1&&(this._$ES=this._$ET())}P(t,e,s){this._$AL.has(t)||this._$AL.set(t,e),s.reflect===!0&&this._$Em!==t&&(this._$Ej??(this._$Ej=new Set)).add(t)}async _$ET(){this.isUpdatePending=!0;try{await this._$ES}catch(e){Promise.reject(e)}const t=this.scheduleUpdate();return t!=null&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var s;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[o,n]of this._$Ep)this[o]=n;this._$Ep=void 0}const i=this.constructor.elementProperties;if(i.size>0)for(const[o,n]of i)n.wrapped!==!0||this._$AL.has(o)||this[o]===void 0||this.P(o,this[o],n)}let t=!1;const e=this._$AL;try{t=this.shouldUpdate(e),t?(this.willUpdate(e),(s=this._$EO)==null||s.forEach(i=>{var o;return(o=i.hostUpdate)==null?void 0:o.call(i)}),this.update(e)):this._$EU()}catch(i){throw t=!1,this._$EU(),i}t&&this._$AE(e)}willUpdate(t){}_$AE(t){var e;(e=this._$EO)==null||e.forEach(s=>{var i;return(i=s.hostUpdated)==null?void 0:i.call(s)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(t){return!0}update(t){this._$Ej&&(this._$Ej=this._$Ej.forEach(e=>this._$EC(e,this[e]))),this._$EU()}updated(t){}firstUpdated(t){}}b.elementStyles=[],b.shadowRootOptions={mode:"open"},b[x("elementProperties")]=new Map,b[x("finalized")]=new Map,L==null||L({ReactiveElement:b}),(m.reactiveElementVersions??(m.reactiveElementVersions=[])).push("2.0.4");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const O=globalThis,z=O.trustedTypes,tt=z?z.createPolicy("lit-html",{createHTML:r=>r}):void 0,ut="$lit$",$=`lit$${Math.random().toFixed(9).slice(2)}$`,pt="?"+$,Ut=`<${pt}>`,y=document,C=()=>y.createComment(""),U=r=>r===null||typeof r!="object"&&typeof r!="function",G=Array.isArray,jt=r=>G(r)||typeof(r==null?void 0:r[Symbol.iterator])=="function",B=`[ 	
\f\r]`,P=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,et=/-->/g,st=/>/g,_=RegExp(`>|${B}(?:([^\\s"'>=/]+)(${B}*=${B}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),it=/'/g,rt=/"/g,ft=/^(?:script|style|textarea|title)$/i,Tt=r=>(t,...e)=>({_$litType$:r,strings:t,values:e}),p=Tt(1),w=Symbol.for("lit-noChange"),d=Symbol.for("lit-nothing"),nt=new WeakMap,v=y.createTreeWalker(y,129);function gt(r,t){if(!G(r)||!r.hasOwnProperty("raw"))throw Error("invalid template strings array");return tt!==void 0?tt.createHTML(t):t}const Rt=(r,t)=>{const e=r.length-1,s=[];let i,o=t===2?"<svg>":t===3?"<math>":"",n=P;for(let l=0;l<e;l++){const a=r[l];let h,u,c=-1,f=0;for(;f<a.length&&(n.lastIndex=f,u=n.exec(a),u!==null);)f=n.lastIndex,n===P?u[1]==="!--"?n=et:u[1]!==void 0?n=st:u[2]!==void 0?(ft.test(u[2])&&(i=RegExp("</"+u[2],"g")),n=_):u[3]!==void 0&&(n=_):n===_?u[0]===">"?(n=i??P,c=-1):u[1]===void 0?c=-2:(c=n.lastIndex-u[2].length,h=u[1],n=u[3]===void 0?_:u[3]==='"'?rt:it):n===rt||n===it?n=_:n===et||n===st?n=P:(n=_,i=void 0);const g=n===_&&r[l+1].startsWith("/>")?" ":"";o+=n===P?a+Ut:c>=0?(s.push(h),a.slice(0,c)+ut+a.slice(c)+$+g):a+$+(c===-2?l:g)}return[gt(r,o+(r[e]||"<?>")+(t===2?"</svg>":t===3?"</math>":"")),s]};class j{constructor({strings:t,_$litType$:e},s){let i;this.parts=[];let o=0,n=0;const l=t.length-1,a=this.parts,[h,u]=Rt(t,e);if(this.el=j.createElement(h,s),v.currentNode=this.el.content,e===2||e===3){const c=this.el.content.firstChild;c.replaceWith(...c.childNodes)}for(;(i=v.nextNode())!==null&&a.length<l;){if(i.nodeType===1){if(i.hasAttributes())for(const c of i.getAttributeNames())if(c.endsWith(ut)){const f=u[n++],g=i.getAttribute(c).split($),k=/([.?@])?(.*)/.exec(f);a.push({type:1,index:o,name:k[2],strings:g,ctor:k[1]==="."?Dt:k[1]==="?"?Ht:k[1]==="@"?zt:I}),i.removeAttribute(c)}else c.startsWith($)&&(a.push({type:6,index:o}),i.removeAttribute(c));if(ft.test(i.tagName)){const c=i.textContent.split($),f=c.length-1;if(f>0){i.textContent=z?z.emptyScript:"";for(let g=0;g<f;g++)i.append(c[g],C()),v.nextNode(),a.push({type:2,index:++o});i.append(c[f],C())}}}else if(i.nodeType===8)if(i.data===pt)a.push({type:2,index:o});else{let c=-1;for(;(c=i.data.indexOf($,c+1))!==-1;)a.push({type:7,index:o}),c+=$.length-1}o++}}static createElement(t,e){const s=y.createElement("template");return s.innerHTML=t,s}}function E(r,t,e=r,s){var n,l;if(t===w)return t;let i=s!==void 0?(n=e._$Co)==null?void 0:n[s]:e._$Cl;const o=U(t)?void 0:t._$litDirective$;return(i==null?void 0:i.constructor)!==o&&((l=i==null?void 0:i._$AO)==null||l.call(i,!1),o===void 0?i=void 0:(i=new o(r),i._$AT(r,e,s)),s!==void 0?(e._$Co??(e._$Co=[]))[s]=i:e._$Cl=i),i!==void 0&&(t=E(r,i._$AS(r,t.values),i,s)),t}class kt{constructor(t,e){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=e}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:e},parts:s}=this._$AD,i=((t==null?void 0:t.creationScope)??y).importNode(e,!0);v.currentNode=i;let o=v.nextNode(),n=0,l=0,a=s[0];for(;a!==void 0;){if(n===a.index){let h;a.type===2?h=new T(o,o.nextSibling,this,t):a.type===1?h=new a.ctor(o,a.name,a.strings,this,t):a.type===6&&(h=new Mt(o,this,t)),this._$AV.push(h),a=s[++l]}n!==(a==null?void 0:a.index)&&(o=v.nextNode(),n++)}return v.currentNode=y,i}p(t){let e=0;for(const s of this._$AV)s!==void 0&&(s.strings!==void 0?(s._$AI(t,s,e),e+=s.strings.length-2):s._$AI(t[e])),e++}}class T{get _$AU(){var t;return((t=this._$AM)==null?void 0:t._$AU)??this._$Cv}constructor(t,e,s,i){this.type=2,this._$AH=d,this._$AN=void 0,this._$AA=t,this._$AB=e,this._$AM=s,this.options=i,this._$Cv=(i==null?void 0:i.isConnected)??!0}get parentNode(){let t=this._$AA.parentNode;const e=this._$AM;return e!==void 0&&(t==null?void 0:t.nodeType)===11&&(t=e.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,e=this){t=E(this,t,e),U(t)?t===d||t==null||t===""?(this._$AH!==d&&this._$AR(),this._$AH=d):t!==this._$AH&&t!==w&&this._(t):t._$litType$!==void 0?this.$(t):t.nodeType!==void 0?this.T(t):jt(t)?this.k(t):this._(t)}O(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}T(t){this._$AH!==t&&(this._$AR(),this._$AH=this.O(t))}_(t){this._$AH!==d&&U(this._$AH)?this._$AA.nextSibling.data=t:this.T(y.createTextNode(t)),this._$AH=t}$(t){var o;const{values:e,_$litType$:s}=t,i=typeof s=="number"?this._$AC(t):(s.el===void 0&&(s.el=j.createElement(gt(s.h,s.h[0]),this.options)),s);if(((o=this._$AH)==null?void 0:o._$AD)===i)this._$AH.p(e);else{const n=new kt(i,this),l=n.u(this.options);n.p(e),this.T(l),this._$AH=n}}_$AC(t){let e=nt.get(t.strings);return e===void 0&&nt.set(t.strings,e=new j(t)),e}k(t){G(this._$AH)||(this._$AH=[],this._$AR());const e=this._$AH;let s,i=0;for(const o of t)i===e.length?e.push(s=new T(this.O(C()),this.O(C()),this,this.options)):s=e[i],s._$AI(o),i++;i<e.length&&(this._$AR(s&&s._$AB.nextSibling,i),e.length=i)}_$AR(t=this._$AA.nextSibling,e){var s;for((s=this._$AP)==null?void 0:s.call(this,!1,!0,e);t&&t!==this._$AB;){const i=t.nextSibling;t.remove(),t=i}}setConnected(t){var e;this._$AM===void 0&&(this._$Cv=t,(e=this._$AP)==null||e.call(this,t))}}class I{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,e,s,i,o){this.type=1,this._$AH=d,this._$AN=void 0,this.element=t,this.name=e,this._$AM=i,this.options=o,s.length>2||s[0]!==""||s[1]!==""?(this._$AH=Array(s.length-1).fill(new String),this.strings=s):this._$AH=d}_$AI(t,e=this,s,i){const o=this.strings;let n=!1;if(o===void 0)t=E(this,t,e,0),n=!U(t)||t!==this._$AH&&t!==w,n&&(this._$AH=t);else{const l=t;let a,h;for(t=o[0],a=0;a<o.length-1;a++)h=E(this,l[s+a],e,a),h===w&&(h=this._$AH[a]),n||(n=!U(h)||h!==this._$AH[a]),h===d?t=d:t!==d&&(t+=(h??"")+o[a+1]),this._$AH[a]=h}n&&!i&&this.j(t)}j(t){t===d?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"")}}class Dt extends I{constructor(){super(...arguments),this.type=3}j(t){this.element[this.name]=t===d?void 0:t}}class Ht extends I{constructor(){super(...arguments),this.type=4}j(t){this.element.toggleAttribute(this.name,!!t&&t!==d)}}class zt extends I{constructor(t,e,s,i,o){super(t,e,s,i,o),this.type=5}_$AI(t,e=this){if((t=E(this,t,e,0)??d)===w)return;const s=this._$AH,i=t===d&&s!==d||t.capture!==s.capture||t.once!==s.once||t.passive!==s.passive,o=t!==d&&(s===d||i);i&&this.element.removeEventListener(this.name,this,s),o&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var e;typeof this._$AH=="function"?this._$AH.call(((e=this.options)==null?void 0:e.host)??this.element,t):this._$AH.handleEvent(t)}}class Mt{constructor(t,e,s){this.element=t,this.type=6,this._$AN=void 0,this._$AM=e,this.options=s}get _$AU(){return this._$AM._$AU}_$AI(t){E(this,t)}}const V=O.litHtmlPolyfillSupport;V==null||V(j,T),(O.litHtmlVersions??(O.litHtmlVersions=[])).push("3.2.1");const Nt=(r,t,e)=>{const s=(e==null?void 0:e.renderBefore)??t;let i=s._$litPart$;if(i===void 0){const o=(e==null?void 0:e.renderBefore)??null;s._$litPart$=i=new T(t.insertBefore(C(),o),o,void 0,e??{})}return i._$AI(r),i};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */let A=class extends b{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var e;const t=super.createRenderRoot();return(e=this.renderOptions).renderBefore??(e.renderBefore=t.firstChild),t}update(t){const e=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=Nt(e,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),(t=this._$Do)==null||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),(t=this._$Do)==null||t.setConnected(!1)}render(){return w}};var ht;A._$litElement$=!0,A.finalized=!0,(ht=globalThis.litElementHydrateSupport)==null||ht.call(globalThis,{LitElement:A});const q=globalThis.litElementPolyfillSupport;q==null||q({LitElement:A});(globalThis.litElementVersions??(globalThis.litElementVersions=[])).push("4.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const S=r=>(t,e)=>{e!==void 0?e.addInitializer(()=>{customElements.define(r,t)}):customElements.define(r,t)};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const It={attribute:!0,type:String,converter:H,reflect:!1,hasChanged:F},Lt=(r=It,t,e)=>{const{kind:s,metadata:i}=e;let o=globalThis.litPropertyMetadata.get(i);if(o===void 0&&globalThis.litPropertyMetadata.set(i,o=new Map),o.set(e.name,r),s==="accessor"){const{name:n}=e;return{set(l){const a=t.get.call(this);t.set.call(this,l),this.requestUpdate(n,a,r)},init(l){return l!==void 0&&this.P(n,void 0,r),l}}}if(s==="setter"){const{name:n}=e;return function(l){const a=this[n];t.call(this,l),this.requestUpdate(n,a,r)}}throw Error("Unsupported decorator location: "+s)};function $t(r){return(t,e)=>typeof e=="object"?Lt(r,t,e):((s,i,o)=>{const n=i.hasOwnProperty(o);return i.constructor.createProperty(o,n?{...s,wrapped:!0}:s),n?Object.getOwnPropertyDescriptor(i,o):void 0})(r,t,e)}/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */function mt(r){return $t({...r,state:!0,attribute:!1})}class R extends A{constructor(){super()}createRenderRoot(){return this}}var Bt=Object.getOwnPropertyDescriptor,Vt=(r,t,e,s)=>{for(var i=s>1?void 0:s?Bt(t,e):t,o=r.length-1,n;o>=0;o--)(n=r[o])&&(i=n(i)||i);return i};let ot=class extends R{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return p` <h2>Prayer Activity</h2> `}};ot=Vt([S("pg-activity")],ot);function qt(r){return r?JSON.parse('{"'+r.substring(1).replace(/&/g,'","').replace(/=/g,'":"')+'"}'):{}}function Wt(r,t){let e={};const s=r.split("/").filter(o=>o!=""),i=t.split("/").filter(o=>o!="");return s.map((o,n)=>{/^:/.test(o)&&(e[o.substring(1)]=i[n])}),e}function Jt(r){return r?new RegExp("^(|/)"+r.replace(/:[^\s/]+/g,"([\\wÀ-ÖØ-öø-ÿ-]+)")+"(|/)$"):new RegExp("(^$|^/$)")}function Ft(r,t){if(Jt(t).test(r))return!0}function Gt(r){return class extends r{static get properties(){return{route:{type:String,reflect:!0,attribute:"route"},canceled:{type:Boolean}}}constructor(...t){super(...t),this.route="",this.canceled=!1}connectedCallback(...t){super.connectedCallback(...t),this.routing(this.constructor.routes,(...e)=>this.router(...e)),window.addEventListener("route",()=>{this.routing(this.constructor.routes,(...e)=>this.router(...e))}),window.onpopstate=()=>{window.dispatchEvent(new CustomEvent("route"))}}routed(t,e,s,i,o,n){n&&n(t,e,s,i),o(t,e,s,i)}routing(t,e){this.canceled=!0;const s=decodeURI(window.location.pathname),i=decodeURI(window.location.search);let o=t.filter(a=>a.pattern==="*")[0],n=t.filter(a=>a.pattern!=="*"&&Ft(s,a.pattern))[0],l=qt(i);n?(n.params=Wt(n.pattern,s),n.data=n.data||{},n.authentication&&n.authentication.authenticate&&typeof n.authentication.authenticate=="function"?(this.canceled=!1,Promise.resolve(n.authentication.authenticate.bind(this).call()).then(a=>{this.canceled||(a?n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(h=>{this.canceled||(h?this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,l,n.data,e,n.callback))})):this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authentication.unauthenticated.name,n.params,l,n.data,e,n.callback))})):n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(a=>{this.canceled||(a?this.routed(n.name,n.params,l,n.data,e,n.callback):this.routed(n.authorization.unauthorized.name,n.params,l,n.data,e,n.callback))})):this.routed(n.name,n.params,l,n.data,e,n.callback)):o&&(o.data=o.data||{},this.routed(o.name,{},l,o.data,e,o.callback))}}}function _t(r){return class extends r{navigate(t){window.history.pushState({},null,t),window.dispatchEvent(new CustomEvent("route"))}}}var Kt=Object.getOwnPropertyDescriptor,Zt=(r,t,e,s)=>{for(var i=s>1?void 0:s?Kt(t,e):t,o=r.length-1,n;o>=0;o--)(n=r[o])&&(i=n(i)||i);return i};let at=class extends _t(R){constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}navigateToHref(r){r.preventDefault();const{href:t}=r.currentTarget;this.navigate(t)}render(){return p`
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
                    @click=${r=>this.navigateToHref(r)}
                  >
                    <i class="icon pg-relay two-rem"></i>
                    <span class="one-rem">
                      ${this.translations.challenges}
                    </span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/prayer-activity"
                    @click=${r=>this.navigateToHref(r)}
                  >
                    <i class="icon pg-prayer two-rem"></i>
                    <span class="one-rem">${this.translations.prayers}</span>
                  </a>
                  <a
                    class="profile-link"
                    href="/profile/profile-settings"
                    @click=${r=>this.navigateToHref(r)}
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
    `}};at=Zt([S("pg-dashboard")],at);var Qt=Object.defineProperty,Xt=Object.getOwnPropertyDescriptor,vt=(r,t,e,s)=>{for(var i=s>1?void 0:s?Xt(t,e):t,o=r.length-1,n;o>=0;o--)(n=r[o])&&(i=(s?n(t,e,i):n(i))||i);return s&&i&&Qt(t,e,i),i};let M=class extends A{constructor(){super(...arguments),this.open=!1,this.modalId=this.generateId()}generateId(){return Array(6).fill("").map(()=>String.fromCharCode(97+Math.floor(Math.random()*26))).join("")}render(){return p`
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
    `}close(){this.dispatchEvent(new CustomEvent("close"))}};M.styles=[bt`
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
        font-size: inherit;
        background: none;
        border: none;
      }
    `];vt([$t({type:Boolean})],M.prototype,"open",2);M=vt([S("pg-modal")],M);var Yt=Object.getOwnPropertyDescriptor,te=(r,t,e,s)=>{for(var i=s>1?void 0:s?Yt(t,e):t,o=r.length-1,n;o>=0;o--)(n=r[o])&&(i=n(i)||i);return i};let lt=class extends R{constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}render(){return p` <h2>My Prayer Relays</h2> `}};lt=te([S("pg-relays")],lt);var ee=Object.getOwnPropertyDescriptor,se=(r,t,e,s)=>{for(var i=s>1?void 0:s?ee(t,e):t,o=r.length-1,n;o>=0;o--)(n=r[o])&&(i=n(i)||i);return i};let ct=class extends _t(Gt(R)){constructor(){super(...arguments),this.route="",this.params={},this.query={},this.data={}}static get properties(){return{route:{type:String},params:{type:Object},query:{type:Object},data:{type:Object}}}static get routes(){return[{name:"dashboard",pattern:"/profile",data:{render:()=>p`<pg-dashboard></pg-dashboard>`}},{name:"prayer-relays",pattern:"/profile/prayer-relays",data:{render:()=>p`<pg-relays></pg-relays>`}},{name:"prayer-activity",pattern:"/profile/prayer-activity",data:{render:()=>p`<pg-activity></pg-activity>`}},{name:"profile-settings",pattern:"/profile/profile-settings",data:{render:()=>p`<pg-settings></pg-settings>`}}]}router(r,t,e,s){this.route=r,this.params=t,this.query=e,this.data=s}render(){var r;return p` ${((r=this.data)==null?void 0:r.render)&&this.data.render()} `}};ct=se([S("pg-router")],ct);var ie=Object.defineProperty,re=Object.getOwnPropertyDescriptor,K=(r,t,e,s)=>{for(var i=s>1?void 0:s?re(t,e):t,o=r.length-1,n;o>=0;o--)(n=r[o])&&(i=(s?n(t,e,i):n(i))||i);return s&&i&&ie(t,e,i),i};let N=class extends R{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.language="",this.showDeleteAccount=!1,this.deleteInputValue="";const r=window.jsObject.current_language;Object.keys(window.jsObject.languages).includes(r)&&(this.language=window.jsObject.languages[r].native_name)}back(){history.back()}onSendGeneralEmailsChange(r){console.log("Method not implemented.")}openDeleteAccount(){this.showDeleteAccount=!0}closeDeleteAccount(){this.showDeleteAccount=!1}deleteAccount(){window.api_fetch(`${window.pg_global.root}pg-api/v1/profile`,{method:"POST",body:JSON.stringify({action:"delete_user",parts:window.jsObject.parts})}).then(r=>{console.log(r,"not confirmed")})}render(){return p`
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
              @change=${r=>this.onSendGeneralEmailsChange(r)}
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
              @input=${r=>this.deleteInputValue=r.target.value}
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
    `}};K([mt()],N.prototype,"showDeleteAccount",2);K([mt()],N.prototype,"deleteInputValue",2);N=K([S("pg-settings")],N);
//# sourceMappingURL=components-bundle.js.map
