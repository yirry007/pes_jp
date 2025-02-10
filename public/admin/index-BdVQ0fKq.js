import{g as L,m as T,a as W,u as d,r as l,C as H,c as j,W as V,a1 as _,a2 as F,a3 as U,Y}from"./index-C9q2FBSY.js";import{u as q}from"./SearchForm--fHSw7Ey.js";const J=e=>{const{componentCls:t,sizePaddingEdgeHorizontal:o,colorSplit:n,lineWidth:r,textPaddingInline:a,orientationMargin:i,verticalMarginInline:s}=e;return{[t]:Object.assign(Object.assign({},W(e)),{borderBlockStart:`${d(r)} solid ${n}`,"&-vertical":{position:"relative",top:"-0.06em",display:"inline-block",height:"0.9em",marginInline:s,marginBlock:0,verticalAlign:"middle",borderTop:0,borderInlineStart:`${d(r)} solid ${n}`},"&-horizontal":{display:"flex",clear:"both",width:"100%",minWidth:"100%",margin:`${d(e.dividerHorizontalGutterMargin)} 0`},[`&-horizontal${t}-with-text`]:{display:"flex",alignItems:"center",margin:`${d(e.dividerHorizontalWithTextGutterMargin)} 0`,color:e.colorTextHeading,fontWeight:500,fontSize:e.fontSizeLG,whiteSpace:"nowrap",textAlign:"center",borderBlockStart:`0 ${n}`,"&::before, &::after":{position:"relative",width:"50%",borderBlockStart:`${d(r)} solid transparent`,borderBlockStartColor:"inherit",borderBlockEnd:0,transform:"translateY(50%)",content:"''"}},[`&-horizontal${t}-with-text-left`]:{"&::before":{width:`calc(${i} * 100%)`},"&::after":{width:`calc(100% - ${i} * 100%)`}},[`&-horizontal${t}-with-text-right`]:{"&::before":{width:`calc(100% - ${i} * 100%)`},"&::after":{width:`calc(${i} * 100%)`}},[`${t}-inner-text`]:{display:"inline-block",paddingBlock:0,paddingInline:a},"&-dashed":{background:"none",borderColor:n,borderStyle:"dashed",borderWidth:`${d(r)} 0 0`},[`&-horizontal${t}-with-text${t}-dashed`]:{"&::before, &::after":{borderStyle:"dashed none none"}},[`&-vertical${t}-dashed`]:{borderInlineStartWidth:r,borderInlineEnd:0,borderBlockStart:0,borderBlockEnd:0},"&-dotted":{background:"none",borderColor:n,borderStyle:"dotted",borderWidth:`${d(r)} 0 0`},[`&-horizontal${t}-with-text${t}-dotted`]:{"&::before, &::after":{borderStyle:"dotted none none"}},[`&-vertical${t}-dotted`]:{borderInlineStartWidth:r,borderInlineEnd:0,borderBlockStart:0,borderBlockEnd:0},[`&-plain${t}-with-text`]:{color:e.colorText,fontWeight:"normal",fontSize:e.fontSize},[`&-horizontal${t}-with-text-left${t}-no-default-orientation-margin-left`]:{"&::before":{width:0},"&::after":{width:"100%"},[`${t}-inner-text`]:{paddingInlineStart:o}},[`&-horizontal${t}-with-text-right${t}-no-default-orientation-margin-right`]:{"&::before":{width:"100%"},"&::after":{width:0},[`${t}-inner-text`]:{paddingInlineEnd:o}}})}},K=e=>({textPaddingInline:"1em",orientationMargin:.05,verticalMarginInline:e.marginXS}),Q=L("Divider",e=>{const t=T(e,{dividerHorizontalWithTextGutterMargin:e.margin,dividerHorizontalGutterMargin:e.marginLG,sizePaddingEdgeHorizontal:0});return[J(t)]},K,{unitless:{orientationMargin:!0}});var Z=function(e,t){var o={};for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&t.indexOf(n)<0&&(o[n]=e[n]);if(e!=null&&typeof Object.getOwnPropertySymbols=="function")for(var r=0,n=Object.getOwnPropertySymbols(e);r<n.length;r++)t.indexOf(n[r])<0&&Object.prototype.propertyIsEnumerable.call(e,n[r])&&(o[n[r]]=e[n[r]]);return o};const ue=e=>{const{getPrefixCls:t,direction:o,divider:n}=l.useContext(H),{prefixCls:r,type:a="horizontal",orientation:i="center",orientationMargin:s,className:m,rootClassName:g,children:b,dashed:$,variant:h="solid",plain:f,style:x}=e,w=Z(e,["prefixCls","type","orientation","orientationMargin","className","rootClassName","children","dashed","variant","plain","style"]),c=t("divider",r),[O,v,u]=Q(c),p=!!b,y=i==="left"&&s!=null,S=i==="right"&&s!=null,z=j(c,n==null?void 0:n.className,v,u,`${c}-${a}`,{[`${c}-with-text`]:p,[`${c}-with-text-${i}`]:p,[`${c}-dashed`]:!!$,[`${c}-${h}`]:h!=="solid",[`${c}-plain`]:!!f,[`${c}-rtl`]:o==="rtl",[`${c}-no-default-orientation-margin-left`]:y,[`${c}-no-default-orientation-margin-right`]:S},m,g),C=l.useMemo(()=>typeof s=="number"?s:/^\d+$/.test(s)?Number(s):s,[s]),I=Object.assign(Object.assign({},y&&{marginLeft:C}),S&&{marginRight:C});return O(l.createElement("div",Object.assign({className:z,style:Object.assign(Object.assign({},n==null?void 0:n.style),x)},w,{role:"separator"}),b&&a!=="vertical"&&l.createElement("span",{className:`${c}-inner-text`,style:I},b)))},k={xxl:3,xl:3,lg:3,md:3,sm:2,xs:1},G=V.createContext({});var ee=function(e,t){var o={};for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&t.indexOf(n)<0&&(o[n]=e[n]);if(e!=null&&typeof Object.getOwnPropertySymbols=="function")for(var r=0,n=Object.getOwnPropertySymbols(e);r<n.length;r++)t.indexOf(n[r])<0&&Object.prototype.propertyIsEnumerable.call(e,n[r])&&(o[n[r]]=e[n[r]]);return o};const te=e=>F(e).map(t=>Object.assign(Object.assign({},t==null?void 0:t.props),{key:t.key}));function ne(e,t,o){const n=l.useMemo(()=>t||te(o),[t,o]);return l.useMemo(()=>n.map(a=>{var{span:i}=a,s=ee(a,["span"]);return i==="filled"?Object.assign(Object.assign({},s),{filled:!0}):Object.assign(Object.assign({},s),{span:typeof i=="number"?i:_(e,i)})}),[n,e])}var re=function(e,t){var o={};for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&t.indexOf(n)<0&&(o[n]=e[n]);if(e!=null&&typeof Object.getOwnPropertySymbols=="function")for(var r=0,n=Object.getOwnPropertySymbols(e);r<n.length;r++)t.indexOf(n[r])<0&&Object.prototype.propertyIsEnumerable.call(e,n[r])&&(o[n[r]]=e[n[r]]);return o};function oe(e,t){let o=[],n=[],r=!1,a=0;return e.filter(i=>i).forEach(i=>{const{filled:s}=i,m=re(i,["filled"]);if(s){n.push(m),o.push(n),n=[],a=0;return}const g=t-a;a+=i.span||1,a>=t?(a>t?(r=!0,n.push(Object.assign(Object.assign({},m),{span:g}))):n.push(m),o.push(n),n=[],a=0):n.push(m)}),n.length>0&&o.push(n),o=o.map(i=>{const s=i.reduce((m,g)=>m+(g.span||1),0);if(s<t){const m=i[i.length-1];return m.span=t-s+1,i}return i}),[o,r]}const ie=(e,t)=>{const[o,n]=l.useMemo(()=>oe(t,e),[t,e]);return o},le=e=>{let{children:t}=e;return t};function B(e){return e!=null}const N=e=>{const{itemPrefixCls:t,component:o,span:n,className:r,style:a,labelStyle:i,contentStyle:s,bordered:m,label:g,content:b,colon:$,type:h}=e,f=o;return m?l.createElement(f,{className:j({[`${t}-item-label`]:h==="label",[`${t}-item-content`]:h==="content"},r),style:a,colSpan:n},B(g)&&l.createElement("span",{style:i},g),B(b)&&l.createElement("span",{style:s},b)):l.createElement(f,{className:j(`${t}-item`,r),style:a,colSpan:n},l.createElement("div",{className:`${t}-item-container`},(g||g===0)&&l.createElement("span",{className:j(`${t}-item-label`,{[`${t}-item-no-colon`]:!$}),style:i},g),(b||b===0)&&l.createElement("span",{className:j(`${t}-item-content`),style:s},b)))};function P(e,t,o){let{colon:n,prefixCls:r,bordered:a}=t,{component:i,type:s,showLabel:m,showContent:g,labelStyle:b,contentStyle:$}=o;return e.map((h,f)=>{let{label:x,children:w,prefixCls:c=r,className:O,style:v,labelStyle:u,contentStyle:p,span:y=1,key:S}=h;return typeof i=="string"?l.createElement(N,{key:`${s}-${S||f}`,className:O,style:v,labelStyle:Object.assign(Object.assign({},b),u),contentStyle:Object.assign(Object.assign({},$),p),span:y,colon:n,component:i,itemPrefixCls:c,bordered:a,label:m?x:null,content:g?w:null,type:s}):[l.createElement(N,{key:`label-${S||f}`,className:O,style:Object.assign(Object.assign(Object.assign({},b),v),u),span:1,colon:n,component:i[0],itemPrefixCls:c,bordered:a,label:x,type:"label"}),l.createElement(N,{key:`content-${S||f}`,className:O,style:Object.assign(Object.assign(Object.assign({},$),v),p),span:y*2-1,component:i[1],itemPrefixCls:c,bordered:a,content:w,type:"content"})]})}const ae=e=>{const t=l.useContext(G),{prefixCls:o,vertical:n,row:r,index:a,bordered:i}=e;return n?l.createElement(l.Fragment,null,l.createElement("tr",{key:`label-${a}`,className:`${o}-row`},P(r,e,Object.assign({component:"th",type:"label",showLabel:!0},t))),l.createElement("tr",{key:`content-${a}`,className:`${o}-row`},P(r,e,Object.assign({component:"td",type:"content",showContent:!0},t)))):l.createElement("tr",{key:a,className:`${o}-row`},P(r,e,Object.assign({component:i?["th","td"]:"td",type:"item",showLabel:!0,showContent:!0},t)))},se=e=>{const{componentCls:t,labelBg:o}=e;return{[`&${t}-bordered`]:{[`> ${t}-view`]:{border:`${d(e.lineWidth)} ${e.lineType} ${e.colorSplit}`,"> table":{tableLayout:"auto"},[`${t}-row`]:{borderBottom:`${d(e.lineWidth)} ${e.lineType} ${e.colorSplit}`,"&:last-child":{borderBottom:"none"},[`> ${t}-item-label, > ${t}-item-content`]:{padding:`${d(e.padding)} ${d(e.paddingLG)}`,borderInlineEnd:`${d(e.lineWidth)} ${e.lineType} ${e.colorSplit}`,"&:last-child":{borderInlineEnd:"none"}},[`> ${t}-item-label`]:{color:e.colorTextSecondary,backgroundColor:o,"&::after":{display:"none"}}}},[`&${t}-middle`]:{[`${t}-row`]:{[`> ${t}-item-label, > ${t}-item-content`]:{padding:`${d(e.paddingSM)} ${d(e.paddingLG)}`}}},[`&${t}-small`]:{[`${t}-row`]:{[`> ${t}-item-label, > ${t}-item-content`]:{padding:`${d(e.paddingXS)} ${d(e.padding)}`}}}}}},ce=e=>{const{componentCls:t,extraColor:o,itemPaddingBottom:n,itemPaddingEnd:r,colonMarginRight:a,colonMarginLeft:i,titleMarginBottom:s}=e;return{[t]:Object.assign(Object.assign(Object.assign({},W(e)),se(e)),{"&-rtl":{direction:"rtl"},[`${t}-header`]:{display:"flex",alignItems:"center",marginBottom:s},[`${t}-title`]:Object.assign(Object.assign({},U),{flex:"auto",color:e.titleColor,fontWeight:e.fontWeightStrong,fontSize:e.fontSizeLG,lineHeight:e.lineHeightLG}),[`${t}-extra`]:{marginInlineStart:"auto",color:o,fontSize:e.fontSize},[`${t}-view`]:{width:"100%",borderRadius:e.borderRadiusLG,table:{width:"100%",tableLayout:"fixed",borderCollapse:"collapse"}},[`${t}-row`]:{"> th, > td":{paddingBottom:n,paddingInlineEnd:r},"> th:last-child, > td:last-child":{paddingInlineEnd:0},"&:last-child":{borderBottom:"none","> th, > td":{paddingBottom:0}}},[`${t}-item-label`]:{color:e.colorTextTertiary,fontWeight:"normal",fontSize:e.fontSize,lineHeight:e.lineHeight,textAlign:"start","&::after":{content:'":"',position:"relative",top:-.5,marginInline:`${d(i)} ${d(a)}`},[`&${t}-item-no-colon::after`]:{content:'""'}},[`${t}-item-no-label`]:{"&::after":{margin:0,content:'""'}},[`${t}-item-content`]:{display:"table-cell",flex:1,color:e.contentColor,fontSize:e.fontSize,lineHeight:e.lineHeight,wordBreak:"break-word",overflowWrap:"break-word"},[`${t}-item`]:{paddingBottom:0,verticalAlign:"top","&-container":{display:"flex",[`${t}-item-label`]:{display:"inline-flex",alignItems:"baseline"},[`${t}-item-content`]:{display:"inline-flex",alignItems:"baseline",minWidth:"1em"}}},"&-middle":{[`${t}-row`]:{"> th, > td":{paddingBottom:e.paddingSM}}},"&-small":{[`${t}-row`]:{"> th, > td":{paddingBottom:e.paddingXS}}}})}},de=e=>({labelBg:e.colorFillAlter,titleColor:e.colorText,titleMarginBottom:e.fontSizeSM*e.lineHeightSM,itemPaddingBottom:e.padding,itemPaddingEnd:e.padding,colonMarginRight:e.marginXS,colonMarginLeft:e.marginXXS/2,contentColor:e.colorText,extraColor:e.colorText}),me=L("Descriptions",e=>{const t=T(e,{});return ce(t)},de);var pe=function(e,t){var o={};for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&t.indexOf(n)<0&&(o[n]=e[n]);if(e!=null&&typeof Object.getOwnPropertySymbols=="function")for(var r=0,n=Object.getOwnPropertySymbols(e);r<n.length;r++)t.indexOf(n[r])<0&&Object.prototype.propertyIsEnumerable.call(e,n[r])&&(o[n[r]]=e[n[r]]);return o};const ge=e=>{const{prefixCls:t,title:o,extra:n,column:r,colon:a=!0,bordered:i,layout:s,children:m,className:g,rootClassName:b,style:$,size:h,labelStyle:f,contentStyle:x,items:w}=e,c=pe(e,["prefixCls","title","extra","column","colon","bordered","layout","children","className","rootClassName","style","size","labelStyle","contentStyle","items"]),{getPrefixCls:O,direction:v,descriptions:u}=l.useContext(H),p=O("descriptions",t),y=q(),S=l.useMemo(()=>{var E;return typeof r=="number"?r:(E=_(y,Object.assign(Object.assign({},k),r)))!==null&&E!==void 0?E:3},[y,r]),z=ne(y,w,m),C=Y(h),I=ie(S,z),[R,D,A]=me(p),X=l.useMemo(()=>({labelStyle:f,contentStyle:x}),[f,x]);return R(l.createElement(G.Provider,{value:X},l.createElement("div",Object.assign({className:j(p,u==null?void 0:u.className,{[`${p}-${C}`]:C&&C!=="default",[`${p}-bordered`]:!!i,[`${p}-rtl`]:v==="rtl"},g,b,D,A),style:Object.assign(Object.assign({},u==null?void 0:u.style),$)},c),(o||n)&&l.createElement("div",{className:`${p}-header`},o&&l.createElement("div",{className:`${p}-title`},o),n&&l.createElement("div",{className:`${p}-extra`},n)),l.createElement("div",{className:`${p}-view`},l.createElement("table",null,l.createElement("tbody",null,I.map((E,M)=>l.createElement(ae,{key:M,index:M,colon:a,prefixCls:p,vertical:s==="vertical",bordered:i,row:E}))))))))};ge.Item=le;export{ue as D,ge as a};
