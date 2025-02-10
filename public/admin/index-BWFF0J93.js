import{W as h,r,C as F,c as M,X as he,U as Se,g as ye,m as ve,u as l,a as xe,Y as Ce,Z,$ as Q,T as be,a0 as Ee}from"./index-C9q2FBSY.js";import{e as ze,P as Pe}from"./Table-Aik4FbcR.js";import{D as Oe}from"./index-BfF7_6j9.js";import{u as Ne}from"./SearchForm--fHSw7Ey.js";const J=h.createContext({});J.Consumer;var k=function(t,e){var i={};for(var n in t)Object.prototype.hasOwnProperty.call(t,n)&&e.indexOf(n)<0&&(i[n]=t[n]);if(t!=null&&typeof Object.getOwnPropertySymbols=="function")for(var a=0,n=Object.getOwnPropertySymbols(t);a<n.length;a++)e.indexOf(n[a])<0&&Object.prototype.propertyIsEnumerable.call(t,n[a])&&(i[n[a]]=t[n[a]]);return i};const Be=t=>{var{prefixCls:e,className:i,avatar:n,title:a,description:s}=t,$=k(t,["prefixCls","className","avatar","title","description"]);const{getPrefixCls:y}=r.useContext(F),m=y("list",e),z=M(`${m}-item-meta`,i),C=h.createElement("div",{className:`${m}-item-meta-content`},a&&h.createElement("h4",{className:`${m}-item-meta-title`},a),s&&h.createElement("div",{className:`${m}-item-meta-description`},s));return h.createElement("div",Object.assign({},$,{className:z}),n&&h.createElement("div",{className:`${m}-item-meta-avatar`},n),(a||s)&&C)},Ie=h.forwardRef((t,e)=>{const{prefixCls:i,children:n,actions:a,extra:s,styles:$,className:y,classNames:m,colStyle:z}=t,C=k(t,["prefixCls","children","actions","extra","styles","className","classNames","colStyle"]),{grid:P,itemLayout:c}=r.useContext(J),{getPrefixCls:O,list:f}=r.useContext(F),b=u=>{var d,E;return M((E=(d=f==null?void 0:f.item)===null||d===void 0?void 0:d.classNames)===null||E===void 0?void 0:E[u],m==null?void 0:m[u])},N=u=>{var d,E;return Object.assign(Object.assign({},(E=(d=f==null?void 0:f.item)===null||d===void 0?void 0:d.styles)===null||E===void 0?void 0:E[u]),$==null?void 0:$[u])},H=()=>{let u=!1;return r.Children.forEach(n,d=>{typeof d=="string"&&(u=!0)}),u&&r.Children.count(n)>1},B=()=>c==="vertical"?!!s:!H(),S=O("list",i),I=a&&a.length>0&&h.createElement("ul",{className:M(`${S}-item-action`,b("actions")),key:"actions",style:N("actions")},a.map((u,d)=>h.createElement("li",{key:`${S}-item-action-${d}`},u,d!==a.length-1&&h.createElement("em",{className:`${S}-item-action-split`})))),T=P?"div":"li",L=h.createElement(T,Object.assign({},C,P?{}:{ref:e},{className:M(`${S}-item`,{[`${S}-item-no-flex`]:!B()},y)}),c==="vertical"&&s?[h.createElement("div",{className:`${S}-item-main`,key:"content"},n,I),h.createElement("div",{className:M(`${S}-item-extra`,b("extra")),key:"extra",style:N("extra")},s)]:[n,I,he(s,{key:"extra"})]);return P?h.createElement(Se,{ref:e,flex:1,style:z},L):L}),ee=Ie;ee.Meta=Be;const Le=t=>{const{listBorderedCls:e,componentCls:i,paddingLG:n,margin:a,itemPaddingSM:s,itemPaddingLG:$,marginLG:y,borderRadiusLG:m}=t;return{[e]:{border:`${l(t.lineWidth)} ${t.lineType} ${t.colorBorder}`,borderRadius:m,[`${i}-header,${i}-footer,${i}-item`]:{paddingInline:n},[`${i}-pagination`]:{margin:`${l(a)} ${l(y)}`}},[`${e}${i}-sm`]:{[`${i}-item,${i}-header,${i}-footer`]:{padding:s}},[`${e}${i}-lg`]:{[`${i}-item,${i}-header,${i}-footer`]:{padding:$}}}},we=t=>{const{componentCls:e,screenSM:i,screenMD:n,marginLG:a,marginSM:s,margin:$}=t;return{[`@media screen and (max-width:${n}px)`]:{[e]:{[`${e}-item`]:{[`${e}-item-action`]:{marginInlineStart:a}}},[`${e}-vertical`]:{[`${e}-item`]:{[`${e}-item-extra`]:{marginInlineStart:a}}}},[`@media screen and (max-width: ${i}px)`]:{[e]:{[`${e}-item`]:{flexWrap:"wrap",[`${e}-action`]:{marginInlineStart:s}}},[`${e}-vertical`]:{[`${e}-item`]:{flexWrap:"wrap-reverse",[`${e}-item-main`]:{minWidth:t.contentWidth},[`${e}-item-extra`]:{margin:`auto auto ${l($)}`}}}}}},Me=t=>{const{componentCls:e,antCls:i,controlHeight:n,minHeight:a,paddingSM:s,marginLG:$,padding:y,itemPadding:m,colorPrimary:z,itemPaddingSM:C,itemPaddingLG:P,paddingXS:c,margin:O,colorText:f,colorTextDescription:b,motionDurationSlow:N,lineWidth:H,headerBg:B,footerBg:S,emptyTextPadding:I,metaMarginBottom:T,avatarMarginRight:L,titleMarginBottom:u,descriptionFontSize:d}=t;return{[e]:Object.assign(Object.assign({},xe(t)),{position:"relative","*":{outline:"none"},[`${e}-header`]:{background:B},[`${e}-footer`]:{background:S},[`${e}-header, ${e}-footer`]:{paddingBlock:s},[`${e}-pagination`]:{marginBlockStart:$,[`${i}-pagination-options`]:{textAlign:"start"}},[`${e}-spin`]:{minHeight:a,textAlign:"center"},[`${e}-items`]:{margin:0,padding:0,listStyle:"none"},[`${e}-item`]:{display:"flex",alignItems:"center",justifyContent:"space-between",padding:m,color:f,[`${e}-item-meta`]:{display:"flex",flex:1,alignItems:"flex-start",maxWidth:"100%",[`${e}-item-meta-avatar`]:{marginInlineEnd:L},[`${e}-item-meta-content`]:{flex:"1 0",width:0,color:f},[`${e}-item-meta-title`]:{margin:`0 0 ${l(t.marginXXS)} 0`,color:f,fontSize:t.fontSize,lineHeight:t.lineHeight,"> a":{color:f,transition:`all ${N}`,"&:hover":{color:z}}},[`${e}-item-meta-description`]:{color:b,fontSize:d,lineHeight:t.lineHeight}},[`${e}-item-action`]:{flex:"0 0 auto",marginInlineStart:t.marginXXL,padding:0,fontSize:0,listStyle:"none","& > li":{position:"relative",display:"inline-block",padding:`0 ${l(c)}`,color:b,fontSize:t.fontSize,lineHeight:t.lineHeight,textAlign:"center","&:first-child":{paddingInlineStart:0}},[`${e}-item-action-split`]:{position:"absolute",insetBlockStart:"50%",insetInlineEnd:0,width:H,height:t.calc(t.fontHeight).sub(t.calc(t.marginXXS).mul(2)).equal(),transform:"translateY(-50%)",backgroundColor:t.colorSplit}}},[`${e}-empty`]:{padding:`${l(y)} 0`,color:b,fontSize:t.fontSizeSM,textAlign:"center"},[`${e}-empty-text`]:{padding:I,color:t.colorTextDisabled,fontSize:t.fontSize,textAlign:"center"},[`${e}-item-no-flex`]:{display:"block"}}),[`${e}-grid ${i}-col > ${e}-item`]:{display:"block",maxWidth:"100%",marginBlockEnd:O,paddingBlock:0,borderBlockEnd:"none"},[`${e}-vertical ${e}-item`]:{alignItems:"initial",[`${e}-item-main`]:{display:"block",flex:1},[`${e}-item-extra`]:{marginInlineStart:$},[`${e}-item-meta`]:{marginBlockEnd:T,[`${e}-item-meta-title`]:{marginBlockStart:0,marginBlockEnd:u,color:f,fontSize:t.fontSizeLG,lineHeight:t.lineHeightLG}},[`${e}-item-action`]:{marginBlockStart:y,marginInlineStart:"auto","> li":{padding:`0 ${l(y)}`,"&:first-child":{paddingInlineStart:0}}}},[`${e}-split ${e}-item`]:{borderBlockEnd:`${l(t.lineWidth)} ${t.lineType} ${t.colorSplit}`,"&:last-child":{borderBlockEnd:"none"}},[`${e}-split ${e}-header`]:{borderBlockEnd:`${l(t.lineWidth)} ${t.lineType} ${t.colorSplit}`},[`${e}-split${e}-empty ${e}-footer`]:{borderTop:`${l(t.lineWidth)} ${t.lineType} ${t.colorSplit}`},[`${e}-loading ${e}-spin-nested-loading`]:{minHeight:n},[`${e}-split${e}-something-after-last-item ${i}-spin-container > ${e}-items > ${e}-item:last-child`]:{borderBlockEnd:`${l(t.lineWidth)} ${t.lineType} ${t.colorSplit}`},[`${e}-lg ${e}-item`]:{padding:P},[`${e}-sm ${e}-item`]:{padding:C},[`${e}:not(${e}-vertical)`]:{[`${e}-item-no-flex`]:{[`${e}-item-action`]:{float:"right"}}}}},je=t=>({contentWidth:220,itemPadding:`${l(t.paddingContentVertical)} 0`,itemPaddingSM:`${l(t.paddingContentVerticalSM)} ${l(t.paddingContentHorizontal)}`,itemPaddingLG:`${l(t.paddingContentVerticalLG)} ${l(t.paddingContentHorizontalLG)}`,headerBg:"transparent",footerBg:"transparent",emptyTextPadding:t.padding,metaMarginBottom:t.padding,avatarMarginRight:t.padding,titleMarginBottom:t.paddingSM,descriptionFontSize:t.fontSize}),He=ye("List",t=>{const e=ve(t,{listBorderedCls:`${t.componentCls}-bordered`,minHeight:t.controlHeightLG});return[Me(e),Le(e),we(e)]},je);var Te=function(t,e){var i={};for(var n in t)Object.prototype.hasOwnProperty.call(t,n)&&e.indexOf(n)<0&&(i[n]=t[n]);if(t!=null&&typeof Object.getOwnPropertySymbols=="function")for(var a=0,n=Object.getOwnPropertySymbols(t);a<n.length;a++)e.indexOf(n[a])<0&&Object.prototype.propertyIsEnumerable.call(t,n[a])&&(i[n[a]]=t[n[a]]);return i};function We(t,e){var{pagination:i=!1,prefixCls:n,bordered:a=!1,split:s=!0,className:$,rootClassName:y,style:m,children:z,itemLayout:C,loadMore:P,grid:c,dataSource:O=[],size:f,header:b,footer:N,loading:H=!1,rowKey:B,renderItem:S,locale:I}=t,T=Te(t,["pagination","prefixCls","bordered","split","className","rootClassName","style","children","itemLayout","loadMore","grid","dataSource","size","header","footer","loading","rowKey","renderItem","locale"]);const L=i&&typeof i=="object"?i:{},[u,d]=r.useState(L.defaultCurrent||1),[E,te]=r.useState(L.defaultPageSize||10),{getPrefixCls:ie,renderEmpty:_,direction:ne,list:j}=r.useContext(F),ae={current:1,total:0},K=o=>(p,x)=>{var V;d(p),te(x),i&&((V=i==null?void 0:i[o])===null||V===void 0||V.call(i,p,x))},re=K("onChange"),oe=K("onShowSizeChange"),le=(o,p)=>{if(!S)return null;let x;return typeof B=="function"?x=B(o):B?x=o[B]:x=o.key,x||(x=`list-item-${p}`),r.createElement(r.Fragment,{key:x},S(o,p))},se=()=>!!(P||i||N),g=ie("list",n),[ce,de,me]=He(g);let w=H;typeof w=="boolean"&&(w={spinning:w});const A=!!(w!=null&&w.spinning),ge=Ce(f);let W="";switch(ge){case"large":W="lg";break;case"small":W="sm";break}const pe=M(g,{[`${g}-vertical`]:C==="vertical",[`${g}-${W}`]:W,[`${g}-split`]:s,[`${g}-bordered`]:a,[`${g}-loading`]:A,[`${g}-grid`]:!!c,[`${g}-something-after-last-item`]:se(),[`${g}-rtl`]:ne==="rtl"},j==null?void 0:j.className,$,y,de,me),v=ze(ae,{total:O.length,current:u,pageSize:E},i||{}),Y=Math.ceil(v.total/v.pageSize);v.current>Y&&(v.current=Y);const q=i&&r.createElement("div",{className:M(`${g}-pagination`)},r.createElement(Pe,Object.assign({align:"end"},v,{onChange:re,onShowSizeChange:oe})));let X=Z(O);i&&O.length>(v.current-1)*v.pageSize&&(X=Z(O).splice((v.current-1)*v.pageSize,v.pageSize));const $e=Object.keys(c||{}).some(o=>["xs","sm","md","lg","xl","xxl"].includes(o)),U=Ne($e),G=r.useMemo(()=>{for(let o=0;o<Q.length;o+=1){const p=Q[o];if(U[p])return p}},[U]),fe=r.useMemo(()=>{if(!c)return;const o=G&&c[G]?c[G]:c.column;if(o)return{width:`${100/o}%`,maxWidth:`${100/o}%`}},[JSON.stringify(c),G]);let D=A&&r.createElement("div",{style:{minHeight:53}});if(X.length>0){const o=X.map((p,x)=>le(p,x));D=c?r.createElement(be,{gutter:c.gutter},r.Children.map(o,p=>r.createElement("div",{key:p==null?void 0:p.key,style:fe},p))):r.createElement("ul",{className:`${g}-items`},o)}else!z&&!A&&(D=r.createElement("div",{className:`${g}-empty-text`},(I==null?void 0:I.emptyText)||(_==null?void 0:_("List"))||r.createElement(Oe,{componentName:"List"})));const R=v.position||"bottom",ue=r.useMemo(()=>({grid:c,itemLayout:C}),[JSON.stringify(c),C]);return ce(r.createElement(J.Provider,{value:ue},r.createElement("div",Object.assign({ref:e,style:Object.assign(Object.assign({},j==null?void 0:j.style),m),className:pe},T),(R==="top"||R==="both")&&q,b&&r.createElement("div",{className:`${g}-header`},b),r.createElement(Ee,Object.assign({},w),D,z),N&&r.createElement("div",{className:`${g}-footer`},N),P||(R==="bottom"||R==="both")&&q)))}const Ge=r.forwardRef(We),Re=Ge;Re.Item=ee;export{Re as L};
