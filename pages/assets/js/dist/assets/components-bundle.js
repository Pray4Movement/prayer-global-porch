/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const tt=globalThis,mt=tt.ShadowRoot&&(tt.ShadyCSS===void 0||tt.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,_t=Symbol(),Ot=new WeakMap;let Ht=class{constructor(t,s,a){if(this._$cssResult$=!0,a!==_t)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=t,this.t=s}get styleSheet(){let t=this.o;const s=this.t;if(mt&&t===void 0){const a=s!==void 0&&s.length===1;a&&(t=Ot.get(s)),t===void 0&&((this.o=t=new CSSStyleSheet).replaceSync(this.cssText),a&&Ot.set(s,t))}return t}toString(){return this.cssText}};const Kt=e=>new Ht(typeof e=="string"?e:e+"",void 0,_t),vt=(e,...t)=>{const s=e.length===1?e[0]:t.reduce((a,i,r)=>a+(n=>{if(n._$cssResult$===!0)return n.cssText;if(typeof n=="number")return n;throw Error("Value passed to 'css' function must be a 'css' function result: "+n+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(i)+e[r+1],e[0]);return new Ht(s,e,_t)},Xt=(e,t)=>{if(mt)e.adoptedStyleSheets=t.map(s=>s instanceof CSSStyleSheet?s:s.styleSheet);else for(const s of t){const a=document.createElement("style"),i=tt.litNonce;i!==void 0&&a.setAttribute("nonce",i),a.textContent=s.cssText,e.appendChild(a)}},xt=mt?e=>e:e=>e instanceof CSSStyleSheet?(t=>{let s="";for(const a of t.cssRules)s+=a.cssText;return Kt(s)})(e):e;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:Zt,defineProperty:Qt,getOwnPropertyDescriptor:Gt,getOwnPropertyNames:Yt,getOwnPropertySymbols:te,getPrototypeOf:ee}=Object,E=globalThis,jt=E.trustedTypes,se=jt?jt.emptyScript:"",ht=E.reactiveElementPolyfillSupport,V=(e,t)=>e,et={toAttribute(e,t){switch(t){case Boolean:e=e?se:null;break;case Object:case Array:e=e==null?e:JSON.stringify(e)}return e},fromAttribute(e,t){let s=e;switch(t){case Boolean:s=e!==null;break;case Number:s=e===null?null:Number(e);break;case Object:case Array:try{s=JSON.parse(e)}catch{s=null}}return s}},ft=(e,t)=>!Zt(e,t),Pt={attribute:!0,type:String,converter:et,reflect:!1,hasChanged:ft};Symbol.metadata??(Symbol.metadata=Symbol("metadata")),E.litPropertyMetadata??(E.litPropertyMetadata=new WeakMap);class M extends HTMLElement{static addInitializer(t){this._$Ei(),(this.l??(this.l=[])).push(t)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(t,s=Pt){if(s.state&&(s.attribute=!1),this._$Ei(),this.elementProperties.set(t,s),!s.noAccessor){const a=Symbol(),i=this.getPropertyDescriptor(t,a,s);i!==void 0&&Qt(this.prototype,t,i)}}static getPropertyDescriptor(t,s,a){const{get:i,set:r}=Gt(this.prototype,t)??{get(){return this[s]},set(n){this[s]=n}};return{get(){return i==null?void 0:i.call(this)},set(n){const d=i==null?void 0:i.call(this);r.call(this,n),this.requestUpdate(t,d,a)},configurable:!0,enumerable:!0}}static getPropertyOptions(t){return this.elementProperties.get(t)??Pt}static _$Ei(){if(this.hasOwnProperty(V("elementProperties")))return;const t=ee(this);t.finalize(),t.l!==void 0&&(this.l=[...t.l]),this.elementProperties=new Map(t.elementProperties)}static finalize(){if(this.hasOwnProperty(V("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(V("properties"))){const s=this.properties,a=[...Yt(s),...te(s)];for(const i of a)this.createProperty(i,s[i])}const t=this[Symbol.metadata];if(t!==null){const s=litPropertyMetadata.get(t);if(s!==void 0)for(const[a,i]of s)this.elementProperties.set(a,i)}this._$Eh=new Map;for(const[s,a]of this.elementProperties){const i=this._$Eu(s,a);i!==void 0&&this._$Eh.set(i,s)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(t){const s=[];if(Array.isArray(t)){const a=new Set(t.flat(1/0).reverse());for(const i of a)s.unshift(xt(i))}else t!==void 0&&s.push(xt(t));return s}static _$Eu(t,s){const a=s.attribute;return a===!1?void 0:typeof a=="string"?a:typeof t=="string"?t.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){var t;this._$ES=new Promise(s=>this.enableUpdating=s),this._$AL=new Map,this._$E_(),this.requestUpdate(),(t=this.constructor.l)==null||t.forEach(s=>s(this))}addController(t){var s;(this._$EO??(this._$EO=new Set)).add(t),this.renderRoot!==void 0&&this.isConnected&&((s=t.hostConnected)==null||s.call(t))}removeController(t){var s;(s=this._$EO)==null||s.delete(t)}_$E_(){const t=new Map,s=this.constructor.elementProperties;for(const a of s.keys())this.hasOwnProperty(a)&&(t.set(a,this[a]),delete this[a]);t.size>0&&(this._$Ep=t)}createRenderRoot(){const t=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return Xt(t,this.constructor.elementStyles),t}connectedCallback(){var t;this.renderRoot??(this.renderRoot=this.createRenderRoot()),this.enableUpdating(!0),(t=this._$EO)==null||t.forEach(s=>{var a;return(a=s.hostConnected)==null?void 0:a.call(s)})}enableUpdating(t){}disconnectedCallback(){var t;(t=this._$EO)==null||t.forEach(s=>{var a;return(a=s.hostDisconnected)==null?void 0:a.call(s)})}attributeChangedCallback(t,s,a){this._$AK(t,a)}_$EC(t,s){var r;const a=this.constructor.elementProperties.get(t),i=this.constructor._$Eu(t,a);if(i!==void 0&&a.reflect===!0){const n=(((r=a.converter)==null?void 0:r.toAttribute)!==void 0?a.converter:et).toAttribute(s,a.type);this._$Em=t,n==null?this.removeAttribute(i):this.setAttribute(i,n),this._$Em=null}}_$AK(t,s){var r;const a=this.constructor,i=a._$Eh.get(t);if(i!==void 0&&this._$Em!==i){const n=a.getPropertyOptions(i),d=typeof n.converter=="function"?{fromAttribute:n.converter}:((r=n.converter)==null?void 0:r.fromAttribute)!==void 0?n.converter:et;this._$Em=i,this[i]=d.fromAttribute(s,n.type),this._$Em=null}}requestUpdate(t,s,a){if(t!==void 0){if(a??(a=this.constructor.getPropertyOptions(t)),!(a.hasChanged??ft)(this[t],s))return;this.P(t,s,a)}this.isUpdatePending===!1&&(this._$ES=this._$ET())}P(t,s,a){this._$AL.has(t)||this._$AL.set(t,s),a.reflect===!0&&this._$Em!==t&&(this._$Ej??(this._$Ej=new Set)).add(t)}async _$ET(){this.isUpdatePending=!0;try{await this._$ES}catch(s){Promise.reject(s)}const t=this.scheduleUpdate();return t!=null&&await t,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){var a;if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??(this.renderRoot=this.createRenderRoot()),this._$Ep){for(const[r,n]of this._$Ep)this[r]=n;this._$Ep=void 0}const i=this.constructor.elementProperties;if(i.size>0)for(const[r,n]of i)n.wrapped!==!0||this._$AL.has(r)||this[r]===void 0||this.P(r,this[r],n)}let t=!1;const s=this._$AL;try{t=this.shouldUpdate(s),t?(this.willUpdate(s),(a=this._$EO)==null||a.forEach(i=>{var r;return(r=i.hostUpdate)==null?void 0:r.call(i)}),this.update(s)):this._$EU()}catch(i){throw t=!1,this._$EU(),i}t&&this._$AE(s)}willUpdate(t){}_$AE(t){var s;(s=this._$EO)==null||s.forEach(a=>{var i;return(i=a.hostUpdated)==null?void 0:i.call(a)}),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(t)),this.updated(t)}_$EU(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(t){return!0}update(t){this._$Ej&&(this._$Ej=this._$Ej.forEach(s=>this._$EC(s,this[s]))),this._$EU()}updated(t){}firstUpdated(t){}}M.elementStyles=[],M.shadowRootOptions={mode:"open"},M[V("elementProperties")]=new Map,M[V("finalized")]=new Map,ht==null||ht({ReactiveElement:M}),(E.reactiveElementVersions??(E.reactiveElementVersions=[])).push("2.0.4");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const K=globalThis,st=K.trustedTypes,St=st?st.createPolicy("lit-html",{createHTML:e=>e}):void 0,Lt="$lit$",S=`lit$${Math.random().toFixed(9).slice(2)}$`,zt="?"+S,ie=`<${zt}>`,U=document,X=()=>U.createComment(""),Z=e=>e===null||typeof e!="object"&&typeof e!="function",yt=Array.isArray,ae=e=>yt(e)||typeof(e==null?void 0:e[Symbol.iterator])=="function",pt=`[ 	
\f\r]`,F=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,Et=/-->/g,Ct=/>/g,T=RegExp(`>|${pt}(?:([^\\s"'>=/]+)(${pt}*=${pt}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),kt=/'/g,Tt=/"/g,qt=/^(?:script|style|textarea|title)$/i,ne=e=>(t,...s)=>({_$litType$:e,strings:t,values:s}),l=ne(1),R=Symbol.for("lit-noChange"),v=Symbol.for("lit-nothing"),It=new WeakMap,D=U.createTreeWalker(U,129);function Wt(e,t){if(!yt(e)||!e.hasOwnProperty("raw"))throw Error("invalid template strings array");return St!==void 0?St.createHTML(t):t}const re=(e,t)=>{const s=e.length-1,a=[];let i,r=t===2?"<svg>":t===3?"<math>":"",n=F;for(let d=0;d<s;d++){const o=e[d];let h,p,c=-1,m=0;for(;m<o.length&&(n.lastIndex=m,p=n.exec(o),p!==null);)m=n.lastIndex,n===F?p[1]==="!--"?n=Et:p[1]!==void 0?n=Ct:p[2]!==void 0?(qt.test(p[2])&&(i=RegExp("</"+p[2],"g")),n=T):p[3]!==void 0&&(n=T):n===T?p[0]===">"?(n=i??F,c=-1):p[1]===void 0?c=-2:(c=n.lastIndex-p[2].length,h=p[1],n=p[3]===void 0?T:p[3]==='"'?Tt:kt):n===Tt||n===kt?n=T:n===Et||n===Ct?n=F:(n=T,i=void 0);const u=n===T&&e[d+1].startsWith("/>")?" ":"";r+=n===F?o+ie:c>=0?(a.push(h),o.slice(0,c)+Lt+o.slice(c)+S+u):o+S+(c===-2?d:u)}return[Wt(e,r+(e[s]||"<?>")+(t===2?"</svg>":t===3?"</math>":"")),a]};class Q{constructor({strings:t,_$litType$:s},a){let i;this.parts=[];let r=0,n=0;const d=t.length-1,o=this.parts,[h,p]=re(t,s);if(this.el=Q.createElement(h,a),D.currentNode=this.el.content,s===2||s===3){const c=this.el.content.firstChild;c.replaceWith(...c.childNodes)}for(;(i=D.nextNode())!==null&&o.length<d;){if(i.nodeType===1){if(i.hasAttributes())for(const c of i.getAttributeNames())if(c.endsWith(Lt)){const m=p[n++],u=i.getAttribute(c).split(S),_=/([.?@])?(.*)/.exec(m);o.push({type:1,index:r,name:_[2],strings:u,ctor:_[1]==="."?le:_[1]==="?"?de:_[1]==="@"?ce:lt}),i.removeAttribute(c)}else c.startsWith(S)&&(o.push({type:6,index:r}),i.removeAttribute(c));if(qt.test(i.tagName)){const c=i.textContent.split(S),m=c.length-1;if(m>0){i.textContent=st?st.emptyScript:"";for(let u=0;u<m;u++)i.append(c[u],X()),D.nextNode(),o.push({type:2,index:++r});i.append(c[m],X())}}}else if(i.nodeType===8)if(i.data===zt)o.push({type:2,index:r});else{let c=-1;for(;(c=i.data.indexOf(S,c+1))!==-1;)o.push({type:7,index:r}),c+=S.length-1}r++}}static createElement(t,s){const a=U.createElement("template");return a.innerHTML=t,a}}function H(e,t,s=e,a){var n,d;if(t===R)return t;let i=a!==void 0?(n=s._$Co)==null?void 0:n[a]:s._$Cl;const r=Z(t)?void 0:t._$litDirective$;return(i==null?void 0:i.constructor)!==r&&((d=i==null?void 0:i._$AO)==null||d.call(i,!1),r===void 0?i=void 0:(i=new r(e),i._$AT(e,s,a)),a!==void 0?(s._$Co??(s._$Co=[]))[a]=i:s._$Cl=i),i!==void 0&&(t=H(e,i._$AS(e,t.values),i,a)),t}let oe=class{constructor(t,s){this._$AV=[],this._$AN=void 0,this._$AD=t,this._$AM=s}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(t){const{el:{content:s},parts:a}=this._$AD,i=((t==null?void 0:t.creationScope)??U).importNode(s,!0);D.currentNode=i;let r=D.nextNode(),n=0,d=0,o=a[0];for(;o!==void 0;){if(n===o.index){let h;o.type===2?h=new z(r,r.nextSibling,this,t):o.type===1?h=new o.ctor(r,o.name,o.strings,this,t):o.type===6&&(h=new he(r,this,t)),this._$AV.push(h),o=a[++d]}n!==(o==null?void 0:o.index)&&(r=D.nextNode(),n++)}return D.currentNode=U,i}p(t){let s=0;for(const a of this._$AV)a!==void 0&&(a.strings!==void 0?(a._$AI(t,a,s),s+=a.strings.length-2):a._$AI(t[s])),s++}};class z{get _$AU(){var t;return((t=this._$AM)==null?void 0:t._$AU)??this._$Cv}constructor(t,s,a,i){this.type=2,this._$AH=v,this._$AN=void 0,this._$AA=t,this._$AB=s,this._$AM=a,this.options=i,this._$Cv=(i==null?void 0:i.isConnected)??!0}get parentNode(){let t=this._$AA.parentNode;const s=this._$AM;return s!==void 0&&(t==null?void 0:t.nodeType)===11&&(t=s.parentNode),t}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(t,s=this){t=H(this,t,s),Z(t)?t===v||t==null||t===""?(this._$AH!==v&&this._$AR(),this._$AH=v):t!==this._$AH&&t!==R&&this._(t):t._$litType$!==void 0?this.$(t):t.nodeType!==void 0?this.T(t):ae(t)?this.k(t):this._(t)}O(t){return this._$AA.parentNode.insertBefore(t,this._$AB)}T(t){this._$AH!==t&&(this._$AR(),this._$AH=this.O(t))}_(t){this._$AH!==v&&Z(this._$AH)?this._$AA.nextSibling.data=t:this.T(U.createTextNode(t)),this._$AH=t}$(t){var r;const{values:s,_$litType$:a}=t,i=typeof a=="number"?this._$AC(t):(a.el===void 0&&(a.el=Q.createElement(Wt(a.h,a.h[0]),this.options)),a);if(((r=this._$AH)==null?void 0:r._$AD)===i)this._$AH.p(s);else{const n=new oe(i,this),d=n.u(this.options);n.p(s),this.T(d),this._$AH=n}}_$AC(t){let s=It.get(t.strings);return s===void 0&&It.set(t.strings,s=new Q(t)),s}k(t){yt(this._$AH)||(this._$AH=[],this._$AR());const s=this._$AH;let a,i=0;for(const r of t)i===s.length?s.push(a=new z(this.O(X()),this.O(X()),this,this.options)):a=s[i],a._$AI(r),i++;i<s.length&&(this._$AR(a&&a._$AB.nextSibling,i),s.length=i)}_$AR(t=this._$AA.nextSibling,s){var a;for((a=this._$AP)==null?void 0:a.call(this,!1,!0,s);t&&t!==this._$AB;){const i=t.nextSibling;t.remove(),t=i}}setConnected(t){var s;this._$AM===void 0&&(this._$Cv=t,(s=this._$AP)==null||s.call(this,t))}}class lt{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(t,s,a,i,r){this.type=1,this._$AH=v,this._$AN=void 0,this.element=t,this.name=s,this._$AM=i,this.options=r,a.length>2||a[0]!==""||a[1]!==""?(this._$AH=Array(a.length-1).fill(new String),this.strings=a):this._$AH=v}_$AI(t,s=this,a,i){const r=this.strings;let n=!1;if(r===void 0)t=H(this,t,s,0),n=!Z(t)||t!==this._$AH&&t!==R,n&&(this._$AH=t);else{const d=t;let o,h;for(t=r[0],o=0;o<r.length-1;o++)h=H(this,d[a+o],s,o),h===R&&(h=this._$AH[o]),n||(n=!Z(h)||h!==this._$AH[o]),h===v?t=v:t!==v&&(t+=(h??"")+r[o+1]),this._$AH[o]=h}n&&!i&&this.j(t)}j(t){t===v?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,t??"")}}class le extends lt{constructor(){super(...arguments),this.type=3}j(t){this.element[this.name]=t===v?void 0:t}}class de extends lt{constructor(){super(...arguments),this.type=4}j(t){this.element.toggleAttribute(this.name,!!t&&t!==v)}}class ce extends lt{constructor(t,s,a,i,r){super(t,s,a,i,r),this.type=5}_$AI(t,s=this){if((t=H(this,t,s,0)??v)===R)return;const a=this._$AH,i=t===v&&a!==v||t.capture!==a.capture||t.once!==a.once||t.passive!==a.passive,r=t!==v&&(a===v||i);i&&this.element.removeEventListener(this.name,this,a),r&&this.element.addEventListener(this.name,this,t),this._$AH=t}handleEvent(t){var s;typeof this._$AH=="function"?this._$AH.call(((s=this.options)==null?void 0:s.host)??this.element,t):this._$AH.handleEvent(t)}}class he{constructor(t,s,a){this.element=t,this.type=6,this._$AN=void 0,this._$AM=s,this.options=a}get _$AU(){return this._$AM._$AU}_$AI(t){H(this,t)}}const pe={I:z},ut=K.litHtmlPolyfillSupport;ut==null||ut(Q,z),(K.litHtmlVersions??(K.litHtmlVersions=[])).push("3.2.1");const ue=(e,t,s)=>{const a=(s==null?void 0:s.renderBefore)??t;let i=a._$litPart$;if(i===void 0){const r=(s==null?void 0:s.renderBefore)??null;a._$litPart$=i=new z(t.insertBefore(X(),r),r,void 0,s??{})}return i._$AI(e),i};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */let C=class extends M{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){var s;const t=super.createRenderRoot();return(s=this.renderOptions).renderBefore??(s.renderBefore=t.firstChild),t}update(t){const s=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(t),this._$Do=ue(s,this.renderRoot,this.renderOptions)}connectedCallback(){var t;super.connectedCallback(),(t=this._$Do)==null||t.setConnected(!0)}disconnectedCallback(){var t;super.disconnectedCallback(),(t=this._$Do)==null||t.setConnected(!1)}render(){return R}};var Mt;C._$litElement$=!0,C.finalized=!0,(Mt=globalThis.litElementHydrateSupport)==null||Mt.call(globalThis,{LitElement:C});const gt=globalThis.litElementPolyfillSupport;gt==null||gt({LitElement:C});(globalThis.litElementVersions??(globalThis.litElementVersions=[])).push("4.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const f=e=>(t,s)=>{s!==void 0?s.addInitializer(()=>{customElements.define(e,t)}):customElements.define(e,t)};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const ge={attribute:!0,type:String,converter:et,reflect:!1,hasChanged:ft},be=(e=ge,t,s)=>{const{kind:a,metadata:i}=s;let r=globalThis.litPropertyMetadata.get(i);if(r===void 0&&globalThis.litPropertyMetadata.set(i,r=new Map),r.set(s.name,e),a==="accessor"){const{name:n}=s;return{set(d){const o=t.get.call(this);t.set.call(this,d),this.requestUpdate(n,o,e)},init(d){return d!==void 0&&this.P(n,void 0,e),d}}}if(a==="setter"){const{name:n}=s;return function(d){const o=this[n];t.call(this,d),this.requestUpdate(n,o,e)}}throw Error("Unsupported decorator location: "+a)};function b(e){return(t,s)=>typeof s=="object"?be(e,t,s):((a,i,r)=>{const n=i.hasOwnProperty(r);return i.constructor.createProperty(r,n?{...a,wrapped:!0}:a),n?Object.getOwnPropertyDescriptor(i,r):void 0})(e,t,s)}/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */function g(e){return b({...e,state:!0,attribute:!1})}var me=Object.defineProperty,_e=Object.getOwnPropertyDescriptor,Ft=(e,t,s,a)=>{for(var i=a>1?void 0:a?_e(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&me(t,s,i),i};let it=class extends C{constructor(){super(...arguments),this.text=""}updated(e){e.has("text")&&document.querySelectorAll("pg-avatar").forEach(s=>{s.text!==this.text&&(s.text=this.text)})}getInitials(e){const t=e.split(" ").map(s=>s[0]).join("").toUpperCase().slice(0,2);return t.length===0?"?":t}render(){return l`
      <div class="circle">
        <div>${this.getInitials(this.text)}</div>
      </div>
    `}};it.styles=[vt`
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
    `];Ft([b({type:String})],it.prototype,"text",2);it=Ft([f("pg-avatar")],it);function ve(e){return e?JSON.parse('{"'+e.substring(1).replace(/&/g,'","').replace(/=/g,'":"')+'"}'):{}}function fe(e,t){let s={};const a=e.split("/").filter(r=>r!=""),i=t.split("/").filter(r=>r!="");return a.map((r,n)=>{/^:/.test(r)&&(s[r.substring(1)]=i[n])}),s}function ye(e){return e?new RegExp("^(|/)"+e.replace(/:[^\s/]+/g,"([\\wÀ-ÖØ-öø-ÿ-]+)")+"(|/)$"):new RegExp("(^$|^/$)")}function $e(e,t){if(ye(t).test(e))return!0}function we(e){return class extends e{static get properties(){return{route:{type:String,reflect:!0,attribute:"route"},canceled:{type:Boolean}}}constructor(...t){super(...t),this.route="",this.canceled=!1}connectedCallback(...t){super.connectedCallback(...t),this.routing(this.constructor.routes,(...s)=>this.router(...s)),window.addEventListener("route",()=>{this.routing(this.constructor.routes,(...s)=>this.router(...s))}),window.onpopstate=()=>{window.dispatchEvent(new CustomEvent("route"))}}routed(t,s,a,i,r,n){n&&n(t,s,a,i),r(t,s,a,i)}routing(t,s){this.canceled=!0;const a=decodeURI(window.location.pathname),i=decodeURI(window.location.search);let r=t.filter(o=>o.pattern==="*")[0],n=t.filter(o=>o.pattern!=="*"&&$e(a,o.pattern))[0],d=ve(i);n?(n.params=fe(n.pattern,a),n.data=n.data||{},n.authentication&&n.authentication.authenticate&&typeof n.authentication.authenticate=="function"?(this.canceled=!1,Promise.resolve(n.authentication.authenticate.bind(this).call()).then(o=>{this.canceled||(o?n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(h=>{this.canceled||(h?this.routed(n.name,n.params,d,n.data,s,n.callback):this.routed(n.authorization.unauthorized.name,n.params,d,n.data,s,n.callback))})):this.routed(n.name,n.params,d,n.data,s,n.callback):this.routed(n.authentication.unauthenticated.name,n.params,d,n.data,s,n.callback))})):n.authorization&&n.authorization.authorize&&typeof n.authorization.authorize=="function"?(this.canceled=!1,Promise.resolve(n.authorization.authorize.bind(this).call()).then(o=>{this.canceled||(o?this.routed(n.name,n.params,d,n.data,s,n.callback):this.routed(n.authorization.unauthorized.name,n.params,d,n.data,s,n.callback))})):this.routed(n.name,n.params,d,n.data,s,n.callback)):r&&(r.data=r.data||{},this.routed(r.name,{},d,r.data,s,r.callback))}}}function q(e){return class extends e{navigate(t){window.history.pushState({},null,t),window.dispatchEvent(new CustomEvent("route"))}}}class w extends C{constructor(){super()}createRenderRoot(){return this}}var Ae=Object.defineProperty,Oe=Object.getOwnPropertyDescriptor,Y=(e,t,s,a)=>{for(var i=a>1?void 0:a?Oe(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&Ae(t,s,i),i};let L=class extends q(w){constructor(){super(...arguments),this.lastEarnedBadgeIndex=0,this.badge={},this.currentBadgeIndex=0,this.currentBadge={},this.progressionBadges=[]}connectedCallback(){super.connectedCallback(),this.currentBadge=this.badge,this.badge.type==="progression"&&(this.progressionBadges=Object.values(this.badge.progression_badges))}firstUpdated(){if(this.badge.type==="progression"){this.lastEarnedBadgeIndex=0;for(const e of this.progressionBadges)if(e.has_earned_badge)this.lastEarnedBadgeIndex=this.lastEarnedBadgeIndex+1;else{this.currentBadge=e;break}}}getImageUrl(){const e=this.badge.has_earned_badge?this.badge.image:this.badge.bw_image;return`${window.jsObject.badges_url}/${e}`}render(){return l`
            <div
                class="prayer-badge text-center"
                @click=${()=>this.navigate(`/dashboard/badge/${this.badge.id}`)}
            >
                <div class="badge-image-wrapper">
                    <img src="${this.getImageUrl()}" alt="${this.badge.title}" />
                    ${this.badge.type==="multiple"&&this.badge.num_times_earned>1?l`
                        <div class="badge-times-earned">x${this.badge.num_times_earned}</div>
                    `:""}
                </div>
                <span>${this.badge.title}</span>
                ${this.badge.type==="progression"&&!this.currentBadge.has_earned_badge||this.badge.type==="challenge"&&!this.badge.has_earned_badge?l`
                        <div class="brand-highlight w-100">
                            <div class="progress-bar" data-small>
                                <div class="progress-bar__slider blue-highlight-bg" style="width: ${this.badge.progression_value/this.currentBadge.value*100}%"></div>
                            </div>
                        </div>
                    `:""}

            </div>
        `}};Y([b({type:Object})],L.prototype,"badge",2);Y([b({type:Number,attribute:!1})],L.prototype,"currentBadgeIndex",2);Y([b({type:Object,attribute:!1})],L.prototype,"currentBadge",2);Y([b({type:Array,attribute:!1})],L.prototype,"progressionBadges",2);L=Y([f("pg-badge")],L);var xe=Object.defineProperty,je=Object.getOwnPropertyDescriptor,$t=(e,t,s,a)=>{for(var i=a>1?void 0:a?je(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&xe(t,s,i),i};let at=class extends q(w){constructor(){super(...arguments),this.title="",this.backUrl=""}render(){return l`
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
    `}};$t([b({type:String})],at.prototype,"title",2);$t([b({type:String})],at.prototype,"backUrl",2);at=$t([f("pg-header")],at);var Pe=Object.defineProperty,Se=Object.getOwnPropertyDescriptor,Jt=(e,t,s,a)=>{for(var i=a>1?void 0:a?Se(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&Pe(t,s,i),i};let nt=class extends C{constructor(){super(...arguments),this.open=!1,this.modalId=this.generateId()}generateId(){return Array(6).fill("").map(()=>String.fromCharCode(97+Math.floor(Math.random()*26))).join("")}render(){return l`
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
    `}close(){this.dispatchEvent(new CustomEvent("close"))}};nt.styles=[vt`
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
    `];Jt([b({type:Boolean})],nt.prototype,"open",2);nt=Jt([f("pg-modal")],nt);var Ee=Object.defineProperty,Ce=Object.getOwnPropertyDescriptor,Vt=(e,t,s,a)=>{for(var i=a>1?void 0:a?Ce(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&Ee(t,s,i),i};let rt=class extends q(C){constructor(){super(),this.href="",this.setAttribute("tabindex","0"),this.setAttribute("role","link"),this.addEventListener("click",this.handleClick),this.addEventListener("keydown",this.handleKeydown)}handleClick(e){e.preventDefault();const{href:t}=e.currentTarget;this.navigate(t)}handleKeydown(e){(e.key==="Enter"||e.key===" ")&&(e.preventDefault(),this.navigate(this.href))}render(){return l` <slot></slot> `}};rt.styles=vt`
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
  `;Vt([b({type:String})],rt.prototype,"href",2);rt=Vt([f("nav-link")],rt);var ke=Object.defineProperty,Te=Object.getOwnPropertyDescriptor,O=(e,t,s,a)=>{for(var i=a>1?void 0:a?Te(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&ke(t,s,i),i};let y=class extends w{constructor(){super(...arguments),this.name="",this.lapNumber=0,this.progress=0,this.translations={},this.spritesheetUrl="",this.relayType="global",this.visibility="public",this.urlRoot="",this.hiddenRelay=!1,this.isOwner=!1,this.token=""}connectedCallback(){super.connectedCallback(),this.token=this.name.replace(/\s+/g,"-")}renderIcon(){const t={global:"pg-logo-prayer",custom:this.visibility==="private"?"pg-private":"pg-world-light"}[this.relayType]||"pg-logo-prayer";return l`
      <svg>
        <use href="${this.spritesheetUrl}#${t}"></use>
      </svg>
    `}render(){return l`
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
              ${this.relayType==="custom"?l`
                    <li>
                      <a class="dropdown-item" href="${this.urlRoot}/tools">
                        ${this.translations.share}
                      </a>
                    </li>
                    ${window.isMobile()?"":l`
                          <li>
                            <a
                              class="dropdown-item"
                              href="${this.urlRoot}/display"
                            >
                              ${this.translations.display}
                            </a>
                          </li>
                        `}
                    ${this.isOwner?l` <li
                          class="dropdown-item"
                          role="button"
                          tabindex="0"
                          @click=${()=>this.dispatchEvent(new CustomEvent("edit"))}
                        >
                          ${this.translations.edit}
                        </li>`:""}
                  `:""}
              ${this.hiddenRelay?l`
                    <li
                      class="dropdown-item"
                      role="button"
                      tabindex="0"
                      @click=${()=>this.dispatchEvent(new CustomEvent("unhide"))}
                    >
                      ${this.translations.unhide}
                    </li>
                  `:l`
                    <li
                      class="dropdown-item"
                      role="button"
                      tabindex="0"
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
    `}};O([b({type:String})],y.prototype,"name",2);O([b({type:Number})],y.prototype,"lapNumber",2);O([b({type:Number})],y.prototype,"progress",2);O([b({type:Object})],y.prototype,"translations",2);O([b({type:String})],y.prototype,"spritesheetUrl",2);O([b({type:String})],y.prototype,"relayType",2);O([b({type:String})],y.prototype,"visibility",2);O([b({type:String})],y.prototype,"urlRoot",2);O([b({type:Boolean})],y.prototype,"hiddenRelay",2);O([b({type:Boolean})],y.prototype,"isOwner",2);y=O([f("pg-relay-item")],y);var Ie=Object.defineProperty,De=Object.getOwnPropertyDescriptor,x=(e,t,s,a)=>{for(var i=a>1?void 0:a?De(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&Ie(t,s,i),i};let $=class extends w{constructor(){super(...arguments),this.translations=window.jsObject.translations,this.edit=!1,this.relay=null,this.type="",this.title="",this.showAdvancedOptions=!1,this.startDate="",this.startTime="",this.endDate="",this.endTime="",this.isSingle=!1}shouldUpdate(e){return e.has("relay")&&this.relay!==null&&(this.title=this.relay.post_title,this.type=this.relay.visibility,this.relay.start_time&&(this.startDate=window.toDateInputFormat(this.relay.start_time),this.startTime=window.toTimeInputFormat(this.relay.start_time)),this.relay.end_time&&(this.endDate=window.toDateInputFormat(this.relay.end_time),this.endTime=window.toTimeInputFormat(this.relay.end_time)),this.isSingle=this.relay.single_lap),super.shouldUpdate(e)}connectedCallback(){super.connectedCallback(),this.edit&&(this.showAdvancedOptions=!0)}handleChangeTitle(e){this.title=e}handleDateTimeChange(e,t){const s=e.target.value;this[t]=s}onSubmit(e){e.preventDefault();const t={title:this.title,visibility:this.type};if(this.startDate){const a=this.startTime?this.startTime:"00:00";t.start_date=new Date(`${this.startDate} ${a}`).getTime()/1e3}if(this.endDate){const a=this.endTime?this.endTime:"23:59";t.end_date=new Date(`${this.endDate} ${a}`).getTime()/1e3}this.isSingle&&(t.single_lap=!0),this.edit&&this.relay!==null&&(t.relay_id=this.relay.post_id);const s=this.edit?window.pg_global.root+"pg-api/v1/dashboard/edit_relay":window.pg_global.root+"pg-api/v1/dashboard/create_relay";window.api_fetch(s,{method:"POST",body:JSON.stringify(t)}).then(a=>{window.location.href="/dashboard/relays"})}openAdvancedOptions(){this.showAdvancedOptions=!0}setTimestampToNow(){this.startDate=window.toDateInputFormat(Date.now()/1e3),this.startTime=window.toTimeInputFormat(Date.now()/1e3)}render(){return l`
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
            @input=${e=>this.handleChangeTitle(e.target.value)}
          />
        </label>
        ${this.showAdvancedOptions?l`
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
                    @input=${e=>this.handleDateTimeChange(e,"startDate")}
                  />
                  <input
                    type="time"
                    name="start-time"
                    id="start-time"
                    value=${this.startTime}
                    @input=${e=>this.handleDateTimeChange(e,"startTime")}
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
                    @input=${e=>this.handleDateTimeChange(e,"endDate")}
                  />
                  <input
                    type="time"
                    name="end-time"
                    id="end-time"
                    value=${this.endTime}
                    @input=${e=>this.handleDateTimeChange(e,"endTime")}
                  />
                </div>
              </label>
              <label class="form-group">
                <input
                  type="checkbox"
                  ?checked=${this.isSingle}
                  @change=${e=>this.isSingle=e.target.checked}
                />
                ${this.translations.single_lap_relay}
              </label>
              <div class="space-out">
                <button
                  class="form-group btn btn-small ${this.type==="public"?"btn-primary":"btn-outline-primary"}"
                  @click=${()=>this.type="public"}
                  type="button"
                >
                  <svg class="icon-sm">
                    <use
                      href="${window.jsObject.spritesheet_url}#pg-world-light"
                    ></use>
                  </svg>
                  ${this.translations.public}
                </button>
                <button
                  class="form-group btn btn-small ${this.type==="private"?"btn-primary":"btn-outline-primary"}"
                  @click=${()=>this.type="private"}
                  type="button"
                >
                  <svg class="icon-sm">
                    <use
                      href="${window.jsObject.spritesheet_url}#pg-private"
                    ></use>
                  </svg>
                  ${this.translations.private}
                </button>
              </div>
            `:l`
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
    `}};x([b({type:Boolean})],$.prototype,"edit",2);x([b({type:Object})],$.prototype,"relay",2);x([g()],$.prototype,"type",2);x([g()],$.prototype,"title",2);x([g()],$.prototype,"showAdvancedOptions",2);x([g()],$.prototype,"startDate",2);x([g()],$.prototype,"startTime",2);x([g()],$.prototype,"endDate",2);x([g()],$.prototype,"endTime",2);x([g()],$.prototype,"isSingle",2);$=x([f("pg-relay-form")],$);var Ue=Object.getOwnPropertyDescriptor,Re=(e,t,s,a)=>{for(var i=a>1?void 0:a?Ue(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=n(i)||i);return i};let Dt=class extends q(w){constructor(){super(...arguments),this.user=window.pg_global.user,this.translations=window.jsObject.translations}navigateToBadges(e){e.preventDefault(),this.navigate("/dashboard/badges")}render(){return l`
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

          <section class="prayer-badges">
            <div class="d-flex justify-content-between align-items-center">
              <h3 class="prayer-badges__title">
                ${this.translations.prayer_milestones}
              </h3>
              <a href="dashboard/badges" @click=${this.navigateToBadges} class="link-light">
                ${this.translations.see_all}
              </a>
            </div>
            <div class="prayer-badges__list">
              ${window.jsObject.available_badges.map(e=>l`
                  <pg-badge .badge=${e}></pg-badge>
                `)}
            </div>
          </section>

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
    `}};Dt=Re([f("pg-activity")],Dt);var Be=Object.defineProperty,Ne=Object.getOwnPropertyDescriptor,wt=(e,t,s,a)=>{for(var i=a>1?void 0:a?Ne(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&Be(t,s,i),i};let ot=class extends w{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.relays=[],this.loading=!0,fetch(window.pg_global.root+"pg-api/v1/dashboard/relays",{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":window.pg_global.nonce},body:JSON.stringify({data:{user_id:this.user.id}})}).then(e=>e.json()).then(e=>{const{relays:t,hidden_relays:s}=e;this.relays=t.filter(a=>!s.includes(a.post_id))}).finally(()=>{this.loading=!1})}async connectedCallback(){super.connectedCallback(),(!this.user.location_hash.length||!this.user.location.timezone)&&await this.getLocationFromIP(),await this.link_anonymous_prayers()}updated(e){super.updated(e),e.has("relays")&&window.pg_set_up_share_buttons&&window.pg_set_up_share_buttons(!0)}render(){return l`
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
                    ${this.user.location&&this.user.location.label||l`<span class="loading-spinner active"></span>`}
                    </div>
                    ${this.user.location&&this.user.location.source==="ip"?l`
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

              <!-- If the user has installed the app, don't show the download app section -->
              ${!window.pg_global.has_used_app&&(!window.isMobileAppUser()||window.isLegacyAppUser)?l`
                      <div
                        class="stack-sm brand-lightest-bg p-4 rounded-3 white"
                      >
                        <h5 class="text-center font-weight-bold">
                          ${window.isLegacyAppUser?this.translations.update_the_app:this.translations.download_the_app}
                        </h5>
                        <a
                          href="/qr/app"
                          target="_blank"
                          class="btn btn-cta d-block center-block"
                          data-umami-event="Dashboard - Download app"
                        >
                          ${this.translations.go_to_app_store}
                        </a>
                      </div>
                    `:""}

              <div class="flow-small w-100">
                <h3 class="text-center">${this.translations.prayer_relays}</h3>
                ${this.loading?l`<span class="loading-spinner active"></span>`:this.relays.map(e=>l`
                          <div
                            class="repel relay-item align-items-center"
                            data-type=${e.relay_type}
                            data-visibility=${e.visibility}
                          >
                            ${e.post_title}

                            <div class="space-out">
                              <button
                                class="p-0 icon-button share-button two-rem d-flex"
                                data-toggle="modal"
                                data-target="#exampleModal"
                                data-url=${`${window.location.origin}/prayer_app/${e.relay_type}/${e.lap_key}`}
                              >
                                <svg class="icon-sm white">
                                  <use
                                    href="${window.jsObject.spritesheet_url}#pg-share"
                                  ></use>
                                </svg>
                              </button>
                              <a
                                href=${`/prayer_app/${e.relay_type}/${e.lap_key}`}
                                class="btn btn-cta"
                              >
                                ${this.translations.pray}
                              </a>
                            </div>
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
                    data-umami-event="Dashboard - Donate"
                  >
                    ${this.translations.donate}
                  </a>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    `}async getLocationFromIP(){var t;const e=localStorage.getItem("user_location");this.user.location=e?JSON.parse(e):null,(t=this.user.location)!=null&&t.hash&&(this.user.location_hash=this.user.location.hash),(!this.user.location||this.user.location.date_set&&this.user.location.date_set<Date.now()-6048e5||!this.user.location.timezone)&&await window.api_fetch("https://geo.prayer.global/json",{method:"GET"}).then(s=>{var a,i,r,n,d,o;if(s){const h={lat:s.location.latitude,lng:s.location.longitude,label:`${(i=(a=s.city)==null?void 0:a.names)==null?void 0:i.en}, ${(n=(r=s.country)==null?void 0:r.names)==null?void 0:n.en}`,country:(o=(d=s.country)==null?void 0:d.names)==null?void 0:o.en,date_set:Date.now(),timezone:s.location.time_zone,source:"ip"};this.user.location=h;let p=localStorage.getItem("pg_user_hash");(!p||p==="undefined")&&(p=window.crypto.randomUUID(),localStorage.setItem("pg_user_hash",p),this.user.location_hash=p),this.user.location.hash=p,localStorage.setItem("user_location",JSON.stringify(this.user.location))}}),await window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/save_location`,{method:"POST",body:JSON.stringify({location_hash:this.user.location_hash,location:this.user.location})}),this.requestUpdate()}async link_anonymous_prayers(){const e=`${window.pg_global.root}pg-api/v1/dashboard/link_anonymous_prayers`;window.api_fetch(e,{method:"POST",body:JSON.stringify({location_hash:this.user.location_hash})})}};wt([g()],ot.prototype,"relays",2);wt([g()],ot.prototype,"loading",2);ot=wt([f("pg-dashboard")],ot);var Me=Object.getOwnPropertyDescriptor,He=(e,t,s,a)=>{for(var i=a>1?void 0:a?Me(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=n(i)||i);return i};let Ut=class extends q(w){constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.badges=window.jsObject.available_badges,window.scrollTo(0,0)}connectedCallback(){super.connectedCallback(),this.badges.sort((e,t)=>e.priority-t.priority),this.badges.sort((e,t)=>e.has_earned_badge&&!t.has_earned_badge?-1:!e.has_earned_badge&&t.has_earned_badge?1:0),this.badges=this.badges.filter(e=>!(e.hidden&&!e.has_earned_badge)),console.log(this.badges)}render(){return l`
        <pg-header
            backUrl="/dashboard/activity"
            title=${this.translations.prayer_milestones}
        ></pg-header>

      <div class="brand-bg white page px-3">
        <div class="pg-container grid" data-grid data-small>
            ${this.badges.map(e=>l`
                <pg-badge .badge=${e}></pg-badge>
              `)}
        </div>
      </div>
    `}};Ut=He([f("pg-badges")],Ut);var Le=Object.defineProperty,ze=Object.getOwnPropertyDescriptor,W=(e,t,s,a)=>{for(var i=a>1?void 0:a?ze(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&Le(t,s,i),i};let B=class extends w{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.spritesheetUrl=window.jsObject.spritesheet_url,this.sliderElement=null,this.lastScrollLeft=0,this.scrollTimeout=null,this.lastEarnedBadgeIndex=0,this.badgeId="",this.badge={},this.progressionBadges=[],this.currentBadgeIndex=0,this.currentBadge={},window.scrollTo(0,0)}connectedCallback(){super.connectedCallback();const e=window.jsObject.available_badges;this.badge=e.find(t=>t.id===this.badgeId),this.currentBadge=this.badge,this.badge.type==="progression"&&(this.progressionBadges=Object.values(this.badge.progression_badges))}firstUpdated(){if(this.badge.type!=="progression")return;const e=this.renderRoot.querySelector(".badge-slides");if(e){this.sliderElement=e;let t=null;this.lastEarnedBadgeIndex=0;for(const s of this.progressionBadges)if(s.has_earned_badge)this.lastEarnedBadgeIndex=this.lastEarnedBadgeIndex+1;else{t=s;break}console.log(this.lastEarnedBadgeIndex),this.slideToBadge(t)}}getImageUrl(e){const t=e.has_earned_badge?e.image:e.bw_image;return`${window.jsObject.badges_url}/${t}`}onSliderScroll(e){if(this.badge.type!=="progression"||!this.sliderElement)return;const t=5,s=.01;this.scrollTimeout=setTimeout(()=>{if(!this.sliderElement)return;const a=Math.abs((this.sliderElement.scrollLeft-this.lastScrollLeft)*(t/1e3));this.lastScrollLeft=this.sliderElement.scrollLeft,a<s&&this.setCurrentBadge()},t)}onSliderScrollEnd(e){this.scrollTimeout&&clearTimeout(this.scrollTimeout),this.setCurrentBadge()}slideToBadge(e){this.badge.type==="progression"&&this.sliderElement&&e&&this.sliderElement.scrollTo({left:this.sliderElement.scrollWidth*(this.progressionBadges.indexOf(e)/(this.progressionBadges.length+1))})}slideToIndex(e){this.badge.type==="progression"&&this.slideToBadge(this.progressionBadges[e])}setCurrentBadge(){this.badge.type==="progression"&&this.sliderElement&&(this.currentBadgeIndex=Math.round(this.sliderElement.scrollLeft/this.sliderElement.scrollWidth*(this.progressionBadges.length+1)),this.currentBadge=this.progressionBadges[this.currentBadgeIndex])}render(){return l`
        <pg-header
            backUrl="/dashboard/badges"
            title=${this.badge.title}
        ></pg-header>

      <div class="brand-bg white page px-3 text-center">
        <div class="pg-container stack-sm badge-item" data-grid data-small>

          <div class="badge-item__timestamp" ?data-empty=${!this.currentBadge.timestamp}>
            Earned ${this.currentBadge.timestamp?`${new Intl.DateTimeFormat().format(this.currentBadge.timestamp*1e3)}`:""}
          </div>

            ${this.badge.type!=="progression"?l`
              <div class="center">
                <div class="badge-image-wrapper two-rem">
                  <img src="${this.getImageUrl(this.badge)}" alt="${this.badge.title}" />
                  ${this.badge.type==="multiple"&&this.badge.num_times_earned>1?l`
                      <div class="badge-times-earned">x${this.badge.num_times_earned}</div>
                  `:""}
                </div>
              </div>
            `:""}
        </div>

        ${this.badge.type==="progression"?l`
          <div class="badge-slider">
              <div class="badge-slides" @scrollend=${this.onSliderScrollEnd} @scroll=${this.onSliderScroll}>
                <div class="badge-buffer"></div>
                ${this.progressionBadges.map((e,t)=>l`
                  <div class="badge-slide ${t===this.currentBadgeIndex?"active":""}">
                    <img src="${this.getImageUrl(e)}" alt="${this.badge.title}" />
                  </div>
                `)}
                <div class="badge-buffer"></div>
              </div>
          </div>
          <div class="repel">
            <button
              class="badge-item__progression-button"
              @click=${()=>this.slideToIndex(this.currentBadgeIndex-1)}
            >
              <svg class="white icon-sm">
                <use href="${this.spritesheetUrl}#pg-chevron-left"></use>
              </svg>
            </button>
            <button
              class="badge-item__progression-button"
              @click=${()=>this.slideToIndex(this.currentBadgeIndex+1)}
            >
              <svg class="white icon-sm">
                <use href="${this.spritesheetUrl}#pg-chevron-right"></use>
              </svg>
            </button>
          </div>
        `:""}

        <div class="pg-container stack-sm badge-item" data-grid data-small>
            <div class="badge-item__title">${this.currentBadge.title}</div>
            ${this.currentBadge.has_earned_badge?l`
                <div class="badge-item__description">${this.currentBadge.description_earned}</div>
            `:l`
                <div class="badge-item__description">${this.currentBadge.description_unearned}</div>
            `}
            ${this.badge.type==="progression"&&this.currentBadgeIndex<this.lastEarnedBadgeIndex+2&&!this.currentBadge.has_earned_badge||this.badge.type==="challenge"&&!this.badge.has_earned_badge?l`
                    <div>
                      <div class="d-flex align-items-center gap-2 justify-content-center brand-highlight">
                        <div class="progress-bar" data-small>
                            <div class="progress-bar__slider blue-highlight-bg" style="width: ${this.badge.progression_value/this.currentBadge.value*100}%"></div>
                        </div>
                        <span class="progress-bar__text">${this.badge.progression_value}/${this.currentBadge.value}</span>
                      </div>
                    </div>
                `:""}
        </div>
      </div>
    `}};W([b({type:String})],B.prototype,"badgeId",2);W([b({type:Object,attribute:!1})],B.prototype,"badge",2);W([b({type:Array,attribute:!1})],B.prototype,"progressionBadges",2);W([b({type:Number,attribute:!1})],B.prototype,"currentBadgeIndex",2);W([b({type:Object,attribute:!1})],B.prototype,"currentBadge",2);B=W([f("pg-badge-item")],B);var qe=Object.defineProperty,We=Object.getOwnPropertyDescriptor,dt=(e,t,s,a)=>{for(var i=a>1?void 0:a?We(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&qe(t,s,i),i};let G=class extends w{constructor(){super(),this.translations=window.jsObject.translations,this.step="choose-option",this.type="",this.openInfo=""}createRelay(e){this.step="new-relay",this.type=e}onCancel(){this.step="choose-option"}getIcon(){return`${window.jsObject.spritesheet_url}#${this.type==="public"?"pg-world-light":"pg-private"}`}getTitle(){return this.type==="public"?this.translations.create_public_relay:this.translations.create_private_relay}async handleOpenInfo(e,t){e.stopImmediatePropagation(),this.openInfo!==t?this.openInfo=t:this.openInfo=""}handleNavigate(){location.href="/relays"}render(){return l`
      <pg-header
        backUrl="/dashboard/relays"
        title=${this.translations.new_relay}
      ></pg-header>
      <div class="pg-container page" data-small>
        ${this.step==="choose-option"?l`
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
                      @click=${e=>this.handleOpenInfo(e,"join")}
                    >
                      <svg class="icon-sm">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-info"
                        ></use>
                      </svg>
                    </button>
                  </div>
                  ${this.openInfo==="join"?l`
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
                      @click=${e=>this.handleOpenInfo(e,"create-public")}
                    >
                      <svg class="icon-sm">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-info"
                        ></use>
                      </svg>
                    </button>
                  </div>
                  ${this.openInfo==="create-public"?l`
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
                      @click=${e=>this.handleOpenInfo(e,"create-private")}
                    >
                      <svg class="icon-sm">
                        <use
                          href="${window.jsObject.spritesheet_url}#pg-info"
                        ></use>
                      </svg>
                    </button>
                  </div>
                  ${this.openInfo==="create-private"?l`
                        <p class="info-text">
                          ${this.translations.create_private_relay_info}
                        </p>
                      `:""}
                </div>
              </div>
            `:""}
        ${this.step==="new-relay"?l`
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
    `}};dt([g()],G.prototype,"step",2);dt([g()],G.prototype,"type",2);dt([g()],G.prototype,"openInfo",2);G=dt([f("pg-new-relay")],G);/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Fe={CHILD:2},Je=e=>(...t)=>({_$litDirective$:e,values:t});class Ve{constructor(t){}get _$AU(){return this._$AM._$AU}_$AT(t,s,a){this._$Ct=t,this._$AM=s,this._$Ci=a}_$AS(t,s){return this.update(t,s)}update(t,s){return this.render(...s)}}/**
 * @license
 * Copyright 2020 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{I:Ke}=pe,Rt=()=>document.createComment(""),J=(e,t,s)=>{var r;const a=e._$AA.parentNode,i=t===void 0?e._$AB:t._$AA;if(s===void 0){const n=a.insertBefore(Rt(),i),d=a.insertBefore(Rt(),i);s=new Ke(n,d,e,e.options)}else{const n=s._$AB.nextSibling,d=s._$AM,o=d!==e;if(o){let h;(r=s._$AQ)==null||r.call(s,e),s._$AM=e,s._$AP!==void 0&&(h=e._$AU)!==d._$AU&&s._$AP(h)}if(n!==i||o){let h=s._$AA;for(;h!==n;){const p=h.nextSibling;a.insertBefore(h,i),h=p}}}return s},I=(e,t,s=e)=>(e._$AI(t,s),e),Xe={},Ze=(e,t=Xe)=>e._$AH=t,Qe=e=>e._$AH,bt=e=>{var a;(a=e._$AP)==null||a.call(e,!1,!0);let t=e._$AA;const s=e._$AB.nextSibling;for(;t!==s;){const i=t.nextSibling;t.remove(),t=i}};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const Bt=(e,t,s)=>{const a=new Map;for(let i=t;i<=s;i++)a.set(e[i],i);return a},Ge=Je(class extends Ve{constructor(e){if(super(e),e.type!==Fe.CHILD)throw Error("repeat() can only be used in text expressions")}dt(e,t,s){let a;s===void 0?s=t:t!==void 0&&(a=t);const i=[],r=[];let n=0;for(const d of e)i[n]=a?a(d,n):n,r[n]=s(d,n),n++;return{values:r,keys:i}}render(e,t,s){return this.dt(e,t,s).values}update(e,[t,s,a]){const i=Qe(e),{values:r,keys:n}=this.dt(t,s,a);if(!Array.isArray(i))return this.ut=n,r;const d=this.ut??(this.ut=[]),o=[];let h,p,c=0,m=i.length-1,u=0,_=r.length-1;for(;c<=m&&u<=_;)if(i[c]===null)c++;else if(i[m]===null)m--;else if(d[c]===n[u])o[u]=I(i[c],r[u]),c++,u++;else if(d[m]===n[_])o[_]=I(i[m],r[_]),m--,_--;else if(d[c]===n[_])o[_]=I(i[c],r[_]),J(e,o[_+1],i[c]),c++,_--;else if(d[m]===n[u])o[u]=I(i[m],r[u]),J(e,i[c],i[m]),m--,u++;else if(h===void 0&&(h=Bt(n,u,_),p=Bt(d,c,m)),h.has(d[c]))if(h.has(d[m])){const P=p.get(n[u]),ct=P!==void 0?i[P]:null;if(ct===null){const At=J(e,i[c]);I(At,r[u]),o[u]=At}else o[u]=I(ct,r[u]),J(e,i[c],ct),i[P]=null;u++}else bt(i[m]),m--;else bt(i[c]),c++;for(;u<=_;){const P=J(e,o[_+1]);I(P,r[u]),o[u++]=P}for(;c<=m;){const P=i[c++];P!==null&&bt(P)}return this.ut=n,Ze(e,o),R}});var Ye=Object.defineProperty,ts=Object.getOwnPropertyDescriptor,N=(e,t,s,a)=>{for(var i=a>1?void 0:a?ts(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&Ye(t,s,i),i};let k=class extends w{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.relays=[],this.hiddenRelays=[],this.showHiddenRelays=!1,this.loading=!0,this.editRelayModalOpen=!1,this.editRelay=null,fetch(window.pg_global.root+"pg-api/v1/dashboard/relays",{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":window.pg_global.nonce},body:JSON.stringify({data:{user_id:this.user.id}})}).then(e=>e.json()).then(e=>{const{relays:t,hidden_relays:s}=e;this.relays=t,this.hiddenRelays=s}).finally(()=>{this.loading=!1})}async handleHide(e){(await fetch(`${window.pg_global.root}pg-api/v1/dashboard/relays/hide?relay_id=${e.post_id}`,{method:"POST",headers:{"Content-Type":"application/json","X-WP-Nonce":window.pg_global.nonce}})).ok&&(this.hiddenRelays=[...this.hiddenRelays,e.post_id])}async handleUnhide(e){await window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/relays/unhide?relay_id=${e.post_id}`,{method:"POST"}),this.hiddenRelays=this.hiddenRelays.filter(t=>t!==e.post_id)}openEditRelayModal(e){this.editRelayModalOpen=!0,this.editRelay=this.relays.find(t=>t.post_id===e)||null}toggleHiddenRelays(){this.showHiddenRelays=!this.showHiddenRelays}closeModal(e){this.editRelayModalOpen=!1}render(){var e;return l`
      <pg-header
        backUrl="/dashboard"
        title=${this.translations.prayer_relays}
      ></pg-header>

      <div class="white-bg page px-3">
        <div class="pg-container stack-md" data-small data-stretch>
          ${this.loading?l`<div class="text-center">
                <span class="loading-spinner active"></span>
              </div>`:l`
                <div role="list" class="stack-md relay-list" data-stretch>
                  ${Ge(this.relays,t=>t.post_id,t=>!this.showHiddenRelays&&this.hiddenRelays.includes(t.post_id)?"":l`
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
                  ${this.relays.some(t=>t.relay_type==="custom")?"":l`
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
          ${this.hiddenRelays.length>0?l`
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
                  href="${window.jsObject.spritesheet_url}#${((e=this.editRelay)==null?void 0:e.visibility)==="private"?"pg-private":"pg-world-light"}"
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
    `}};N([g()],k.prototype,"relays",2);N([g()],k.prototype,"hiddenRelays",2);N([g()],k.prototype,"showHiddenRelays",2);N([g()],k.prototype,"loading",2);N([g()],k.prototype,"editRelayModalOpen",2);N([g()],k.prototype,"editRelay",2);k=N([f("pg-relays")],k);var es=Object.getOwnPropertyDescriptor,ss=(e,t,s,a)=>{for(var i=a>1?void 0:a?es(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=n(i)||i);return i};let Nt=class extends q(we(w)){constructor(){super(...arguments),this.route="",this.params={},this.query={},this.data={}}static get properties(){return{route:{type:String},params:{type:Object},query:{type:Object},data:{type:Object}}}static get routes(){return[{name:"dashboard",pattern:"/dashboard",data:{render:()=>l`<pg-dashboard></pg-dashboard>`}},{name:"prayer-relays",pattern:"/dashboard/relays",data:{render:()=>l`<pg-relays></pg-relays>`}},{name:"prayer-activity",pattern:"/dashboard/activity",data:{render:()=>l`<pg-activity></pg-activity>`}},{name:"profile-settings",pattern:"/dashboard/settings",data:{render:()=>l`<pg-settings></pg-settings>`}},{name:"new-relay",pattern:"/dashboard/new-relay",data:{render:()=>l`<pg-new-relay></pg-new-relay>`}},{name:"badges",pattern:"/dashboard/badges",data:{render:()=>l`<pg-badges></pg-badges>`}},{name:"badge-item",pattern:"/dashboard/badge/:badgeId",data:{render:e=>l`<pg-badge-item badgeId=${e.badgeId}></pg-badge-item>`}}]}router(e,t,s,a){this.route=e,this.params=t,this.query=s,this.data=a}render(){var e;return l` ${((e=this.data)==null?void 0:e.render)&&this.data.render(this.params)} `}};Nt=ss([f("pg-router")],Nt);var is=Object.defineProperty,as=Object.getOwnPropertyDescriptor,j=(e,t,s,a)=>{for(var i=a>1?void 0:a?as(t,s):t,r=e.length-1,n;r>=0;r--)(n=e[r])&&(i=(a?n(t,s,i):n(i))||i);return a&&i&&is(t,s,i),i};let A=class extends w{constructor(){super(),this.user=window.pg_global.user,this.translations=window.jsObject.translations,this.currentLanguage=window.jsObject.current_language,this.language=null,this.showEditAccount=!1,this.saving=!1,this.name=this.user.display_name,this.showDeleteAccount=!1,this.deleteInputValue="",this.subscribing=!1,this.subscribed=!1,this.hasDeviceNotificationsPermission=!1,this.hasUserNotificationsPermission=window.pg_global.has_notifications_permission,this.notificationInterval=null;const e=window.jsObject.current_language;Object.keys(window.jsObject.languages).includes(e)&&(this.language=window.jsObject.languages[e]),this.permissionsManager=window.medianPermissions}connectedCallback(){super.connectedCallback(),this.getNotificationsPermission(),this.notificationInterval=setInterval(()=>{this.getNotificationsPermission()},1e3)}disconnectedCallback(){super.disconnectedCallback(),this.notificationInterval&&clearInterval(this.notificationInterval)}update(e){this.getNotificationsPermission(),super.update(e)}back(){history.back()}getNotificationsPermission(){window.isMobileAppUser()&&this.permissionsManager.getNotificationsPermission().then(e=>{this.hasDeviceNotificationsPermission=e})}subsribeToNews(){this.subscribing=!0,window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/subscribe_to_news`,{method:"POST"}).then(e=>{e===!0&&(this.subscribed=!0)}).finally(()=>{this.subscribing=!1})}openEditAccount(){this.showEditAccount=!0}closeEditAccount(){this.showEditAccount=!1}editAccount(){var t;this.user.display_name=this.name,this.saving=!0;const e={display_name:this.name,location:this.user.location,language:(t=this.language)==null?void 0:t.po_code};window.location_data&&window.location_data.location_grid_meta&&window.location_data.location_grid_meta.values&&Array.isArray(window.location_data.location_grid_meta.values)&&window.location_data.location_grid_meta.values.length>0&&(e.location=window.location_data.location_grid_meta.values[0],this.user={...this.user,location:e.location}),window.api_fetch(`${window.pg_global.root}pg-api/v1/user/save_details`,{method:"POST",body:JSON.stringify(e)}).finally(()=>{if(this.language&&this.language.po_code!==this.currentLanguage){const s=new URLSearchParams(window.location.search);s.set("lang",this.language.po_code),window.location.search=s.toString()}this.closeEditAccount(),this.saving=!1})}openDeleteAccount(){this.showDeleteAccount=!0}closeDeleteAccount(){this.showDeleteAccount=!1}deleteAccount(){window.api_fetch(`${window.pg_global.root}pg-api/v1/dashboard/delete_user`,{method:"POST"}).then(e=>{e===!0&&(window.location.href="/")})}handleChangeName(e){this.name=e}handleChangeLanguage(e){const t=e.target.value;this.language=window.jsObject.languages[t]??null}handleChangeLocation(e){const t=e.target.value;t[0]&&(this.user.location=t[0])}requestNotificationsPermission(){this.permissionsManager.medianLibraryReady&&this.permissionsManager.requestNotificationsPermission()}handleNotificationsToggle(e){const t=e.target.checked;return window.api_fetch(`${window.pg_global.root}pg-api/v1/user/notifications-permission`,{method:"POST",body:JSON.stringify({notifications_permission:!!t})}).then(()=>{this.hasUserNotificationsPermission=t,this.isUserAndDevicePermissionMismatched()&&window.requestNotificationsPermission(()=>{this.getNotificationsPermission()})})}isUserAndDevicePermissionMismatched(){return!!this.hasUserNotificationsPermission&&!!this.hasUserNotificationsPermission!==this.hasDeviceNotificationsPermission}async wait(e){return new Promise(t=>setTimeout(t,e))}render(){var e;return l`
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
                <td>${(e=this.language)==null?void 0:e.native_name}</td>
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

        <section class="stack-sm text-center">
          <svg class="brand-light icon-xxlg">
            <use href="${window.jsObject.spritesheet_url}#pg-bell"></use>
          </svg>
          <div class="cluster s-sm align-items-center">
            <label class="h5 form-group" for="notifications-toggle">
              ${this.translations.notifications_toggle}
              <input
                type="checkbox"
                role="switch"
                ?disabled=${window.isLegacyAppUser||!window.isMobileAppUser()}
                ?checked=${this.hasUserNotificationsPermission}
                id="notifications-toggle"
                @change=${this.handleNotificationsToggle}
              />
            </label>
          </div>
          <p>${this.translations.notifications_text}</p>
          ${!window.isLegacyAppUser&&window.isMobileAppUser()&&this.isUserAndDevicePermissionMismatched()?l`
                <p class="small brand-lighter">
                  <i>${this.translations.notifications_text_mismatch}</i>
                </p>
                <button
                  class="btn btn-small btn-outline-primary"
                  @click=${this.requestNotificationsPermission}
                >
                  ${this.translations.request_notifications}
                </button>
              `:""}
          ${window.isLegacyAppUser||!window.isMobileAppUser()&&window.isMobile()?l`
                <p class="small brand-lighter">
                  <i>${this.translations.notifications_text_mobile}</i>
                </p>
                <a
                  href="/qr/app"
                  target="_blank"
                  class="btn btn-small btn-outline-primary"
                >
                  ${this.translations.go_to_app_store}
                </a>
              `:""}
        </section>

        <hr />

        <section class="stack-sm text-center">
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
            ${this.subscribing?l` <span class="loading-spinner active"></span> `:""}
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
                ${Object.entries(window.jsObject.languages).map(([t,s])=>l`
                    <option
                      value=${t}
                      ?selected=${this.currentLanguage===t}
                    >
                      ${s.flag} ${s.native_name}
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
    `}};j([g()],A.prototype,"showEditAccount",2);j([g()],A.prototype,"saving",2);j([g()],A.prototype,"name",2);j([g()],A.prototype,"showDeleteAccount",2);j([g()],A.prototype,"deleteInputValue",2);j([g()],A.prototype,"subscribing",2);j([g()],A.prototype,"subscribed",2);j([g()],A.prototype,"hasDeviceNotificationsPermission",2);j([g()],A.prototype,"hasUserNotificationsPermission",2);A=j([f("pg-settings")],A);
//# sourceMappingURL=components-bundle.js.map
