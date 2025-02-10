import{r as n,C as P,c as m,g as me,m as pe,a as ue,u as o,a5 as w,a3 as I,Y as ye,a6 as $e,a7 as he,H as fe}from"./index-C9q2FBSY.js";var Se=function(e,t){var i={};for(var a in e)Object.prototype.hasOwnProperty.call(e,a)&&t.indexOf(a)<0&&(i[a]=e[a]);if(e!=null&&typeof Object.getOwnPropertySymbols=="function")for(var r=0,a=Object.getOwnPropertySymbols(e);r<a.length;r++)t.indexOf(a[r])<0&&Object.prototype.propertyIsEnumerable.call(e,a[r])&&(i[a[r]]=e[a[r]]);return i};const W=e=>{var{prefixCls:t,className:i,hoverable:a=!0}=e,r=Se(e,["prefixCls","className","hoverable"]);const{getPrefixCls:d}=n.useContext(P),g=d("card",t),p=m(`${g}-grid`,i,{[`${g}-grid-hoverable`]:a});return n.createElement("div",Object.assign({},r,{className:p}))},ve=e=>{const{antCls:t,componentCls:i,headerHeight:a,cardPaddingBase:r,tabsMarginBottom:d}=e;return Object.assign(Object.assign({display:"flex",justifyContent:"center",flexDirection:"column",minHeight:a,marginBottom:-1,padding:`0 ${o(r)}`,color:e.colorTextHeading,fontWeight:e.fontWeightStrong,fontSize:e.headerFontSize,background:e.headerBg,borderBottom:`${o(e.lineWidth)} ${e.lineType} ${e.colorBorderSecondary}`,borderRadius:`${o(e.borderRadiusLG)} ${o(e.borderRadiusLG)} 0 0`},w()),{"&-wrapper":{width:"100%",display:"flex",alignItems:"center"},"&-title":Object.assign(Object.assign({display:"inline-block",flex:1},I),{[`
          > ${i}-typography,
          > ${i}-typography-edit-content
        `]:{insetInlineStart:0,marginTop:0,marginBottom:0}}),[`${t}-tabs-top`]:{clear:"both",marginBottom:d,color:e.colorText,fontWeight:"normal",fontSize:e.fontSize,"&-bar":{borderBottom:`${o(e.lineWidth)} ${e.lineType} ${e.colorBorderSecondary}`}}})},xe=e=>{const{cardPaddingBase:t,colorBorderSecondary:i,cardShadow:a,lineWidth:r}=e;return{width:"33.33%",padding:t,border:0,borderRadius:0,boxShadow:`
      ${o(r)} 0 0 0 ${i},
      0 ${o(r)} 0 0 ${i},
      ${o(r)} ${o(r)} 0 0 ${i},
      ${o(r)} 0 0 0 ${i} inset,
      0 ${o(r)} 0 0 ${i} inset;
    `,transition:`all ${e.motionDurationMid}`,"&-hoverable:hover":{position:"relative",zIndex:1,boxShadow:a}}},Ce=e=>{const{componentCls:t,iconCls:i,actionsLiMargin:a,cardActionsIconSize:r,colorBorderSecondary:d,actionsBg:g}=e;return Object.assign(Object.assign({margin:0,padding:0,listStyle:"none",background:g,borderTop:`${o(e.lineWidth)} ${e.lineType} ${d}`,display:"flex",borderRadius:`0 0 ${o(e.borderRadiusLG)} ${o(e.borderRadiusLG)}`},w()),{"& > li":{margin:a,color:e.colorTextDescription,textAlign:"center","> span":{position:"relative",display:"block",minWidth:e.calc(e.cardActionsIconSize).mul(2).equal(),fontSize:e.fontSize,lineHeight:e.lineHeight,cursor:"pointer","&:hover":{color:e.colorPrimary,transition:`color ${e.motionDurationMid}`},[`a:not(${t}-btn), > ${i}`]:{display:"inline-block",width:"100%",color:e.colorTextDescription,lineHeight:o(e.fontHeight),transition:`color ${e.motionDurationMid}`,"&:hover":{color:e.colorPrimary}},[`> ${i}`]:{fontSize:r,lineHeight:o(e.calc(r).mul(e.lineHeight).equal())}},"&:not(:last-child)":{borderInlineEnd:`${o(e.lineWidth)} ${e.lineType} ${d}`}}})},Oe=e=>Object.assign(Object.assign({margin:`${o(e.calc(e.marginXXS).mul(-1).equal())} 0`,display:"flex"},w()),{"&-avatar":{paddingInlineEnd:e.padding},"&-detail":{overflow:"hidden",flex:1,"> div:not(:last-child)":{marginBottom:e.marginXS}},"&-title":Object.assign({color:e.colorTextHeading,fontWeight:e.fontWeightStrong,fontSize:e.fontSizeLG},I),"&-description":{color:e.colorTextDescription}}),je=e=>{const{componentCls:t,cardPaddingBase:i,colorFillAlter:a}=e;return{[`${t}-head`]:{padding:`0 ${o(i)}`,background:a,"&-title":{fontSize:e.fontSize}},[`${t}-body`]:{padding:`${o(e.padding)} ${o(i)}`}}},ze=e=>{const{componentCls:t}=e;return{overflow:"hidden",[`${t}-body`]:{userSelect:"none"}}},we=e=>{const{componentCls:t,cardShadow:i,cardHeadPadding:a,colorBorderSecondary:r,boxShadowTertiary:d,cardPaddingBase:g,extraColor:p}=e;return{[t]:Object.assign(Object.assign({},ue(e)),{position:"relative",background:e.colorBgContainer,borderRadius:e.borderRadiusLG,[`&:not(${t}-bordered)`]:{boxShadow:d},[`${t}-head`]:ve(e),[`${t}-extra`]:{marginInlineStart:"auto",color:p,fontWeight:"normal",fontSize:e.fontSize},[`${t}-body`]:Object.assign({padding:g,borderRadius:`0 0 ${o(e.borderRadiusLG)} ${o(e.borderRadiusLG)}`},w()),[`${t}-grid`]:xe(e),[`${t}-cover`]:{"> *":{display:"block",width:"100%",borderRadius:`${o(e.borderRadiusLG)} ${o(e.borderRadiusLG)} 0 0`}},[`${t}-actions`]:Ce(e),[`${t}-meta`]:Oe(e)}),[`${t}-bordered`]:{border:`${o(e.lineWidth)} ${e.lineType} ${r}`,[`${t}-cover`]:{marginTop:-1,marginInlineStart:-1,marginInlineEnd:-1}},[`${t}-hoverable`]:{cursor:"pointer",transition:`box-shadow ${e.motionDurationMid}, border-color ${e.motionDurationMid}`,"&:hover":{borderColor:"transparent",boxShadow:i}},[`${t}-contain-grid`]:{borderRadius:`${o(e.borderRadiusLG)} ${o(e.borderRadiusLG)} 0 0 `,[`${t}-body`]:{display:"flex",flexWrap:"wrap"},[`&:not(${t}-loading) ${t}-body`]:{marginBlockStart:e.calc(e.lineWidth).mul(-1).equal(),marginInlineStart:e.calc(e.lineWidth).mul(-1).equal(),padding:0}},[`${t}-contain-tabs`]:{[`> div${t}-head`]:{minHeight:0,[`${t}-head-title, ${t}-extra`]:{paddingTop:a}}},[`${t}-type-inner`]:je(e),[`${t}-loading`]:ze(e),[`${t}-rtl`]:{direction:"rtl"}}},Ee=e=>{const{componentCls:t,cardPaddingSM:i,headerHeightSM:a,headerFontSizeSM:r}=e;return{[`${t}-small`]:{[`> ${t}-head`]:{minHeight:a,padding:`0 ${o(i)}`,fontSize:r,[`> ${t}-head-wrapper`]:{[`> ${t}-extra`]:{fontSize:e.fontSize}}},[`> ${t}-body`]:{padding:i}},[`${t}-small${t}-contain-tabs`]:{[`> ${t}-head`]:{[`${t}-head-title, ${t}-extra`]:{paddingTop:0,display:"flex",alignItems:"center"}}}}},Te=e=>({headerBg:"transparent",headerFontSize:e.fontSizeLG,headerFontSizeSM:e.fontSize,headerHeight:e.fontSizeLG*e.lineHeightLG+e.padding*2,headerHeightSM:e.fontSize*e.lineHeight+e.paddingXS*2,actionsBg:e.colorBgContainer,actionsLiMargin:`${e.paddingSM}px 0`,tabsMarginBottom:-e.padding-e.lineWidth,extraColor:e.colorText}),Be=me("Card",e=>{const t=pe(e,{cardShadow:e.boxShadowCard,cardHeadPadding:e.padding,cardPaddingBase:e.paddingLG,cardActionsIconSize:e.fontSize,cardPaddingSM:12});return[we(t),Ee(t)]},Te);var R=function(e,t){var i={};for(var a in e)Object.prototype.hasOwnProperty.call(e,a)&&t.indexOf(a)<0&&(i[a]=e[a]);if(e!=null&&typeof Object.getOwnPropertySymbols=="function")for(var r=0,a=Object.getOwnPropertySymbols(e);r<a.length;r++)t.indexOf(a[r])<0&&Object.prototype.propertyIsEnumerable.call(e,a[r])&&(i[a[r]]=e[a[r]]);return i};const Pe=e=>{const{actionClasses:t,actions:i=[],actionStyle:a}=e;return n.createElement("ul",{className:t,style:a},i.map((r,d)=>{const g=`action-${d}`;return n.createElement("li",{style:{width:`${100/i.length}%`},key:g},n.createElement("span",null,r))}))},Ne=n.forwardRef((e,t)=>{const{prefixCls:i,className:a,rootClassName:r,style:d,extra:g,headStyle:p={},bodyStyle:u={},title:h,loading:v,bordered:x=!0,size:C,type:O,cover:N,actions:j,tabList:f,children:z,activeTabKey:H,defaultActiveTabKey:A,tabBarExtraContent:_,hoverable:K,tabProps:F={},classNames:E,styles:T}=e,q=R(e,["prefixCls","className","rootClassName","style","extra","headStyle","bodyStyle","title","loading","bordered","size","type","cover","actions","tabList","children","activeTabKey","defaultActiveTabKey","tabBarExtraContent","hoverable","tabProps","classNames","styles"]),{getPrefixCls:X,direction:V,card:b}=n.useContext(P),Y=c=>{var s;(s=e.onTabChange)===null||s===void 0||s.call(e,c)},y=c=>{var s;return m((s=b==null?void 0:b.classNames)===null||s===void 0?void 0:s[c],E==null?void 0:E[c])},$=c=>{var s;return Object.assign(Object.assign({},(s=b==null?void 0:b.styles)===null||s===void 0?void 0:s[c]),T==null?void 0:T[c])},J=n.useMemo(()=>{let c=!1;return n.Children.forEach(z,s=>{(s==null?void 0:s.type)===W&&(c=!0)}),c},[z]),l=X("card",i),[Q,U,Z]=Be(l),k=n.createElement(fe,{loading:!0,active:!0,paragraph:{rows:4},title:!1},z),G=H!==void 0,ee=Object.assign(Object.assign({},F),{[G?"activeKey":"defaultActiveKey"]:G?H:A,tabBarExtraContent:_});let L;const S=ye(C),te=!S||S==="default"?"large":S,M=f?n.createElement($e,Object.assign({size:te},ee,{className:`${l}-head-tabs`,onChange:Y,items:f.map(c=>{var{tab:s}=c,B=R(c,["tab"]);return Object.assign({label:s},B)})})):null;if(h||g||M){const c=m(`${l}-head`,y("header")),s=m(`${l}-head-title`,y("title")),B=m(`${l}-extra`,y("extra")),be=Object.assign(Object.assign({},p),$("header"));L=n.createElement("div",{className:c,style:be},n.createElement("div",{className:`${l}-head-wrapper`},h&&n.createElement("div",{className:s,style:$("title")},h),g&&n.createElement("div",{className:B,style:$("extra")},g)),M)}const ae=m(`${l}-cover`,y("cover")),re=N?n.createElement("div",{className:ae,style:$("cover")},N):null,ie=m(`${l}-body`,y("body")),oe=Object.assign(Object.assign({},u),$("body")),ne=n.createElement("div",{className:ie,style:oe},v?k:z),se=m(`${l}-actions`,y("actions")),le=j!=null&&j.length?n.createElement(Pe,{actionClasses:se,actionStyle:$("actions"),actions:j}):null,de=he(q,["onTabChange"]),ce=m(l,b==null?void 0:b.className,{[`${l}-loading`]:v,[`${l}-bordered`]:x,[`${l}-hoverable`]:K,[`${l}-contain-grid`]:J,[`${l}-contain-tabs`]:f==null?void 0:f.length,[`${l}-${S}`]:S,[`${l}-type-${O}`]:!!O,[`${l}-rtl`]:V==="rtl"},a,r,U,Z),ge=Object.assign(Object.assign({},b==null?void 0:b.style),d);return Q(n.createElement("div",Object.assign({ref:t},de,{className:ce,style:ge}),L,re,ne,le))});var He=function(e,t){var i={};for(var a in e)Object.prototype.hasOwnProperty.call(e,a)&&t.indexOf(a)<0&&(i[a]=e[a]);if(e!=null&&typeof Object.getOwnPropertySymbols=="function")for(var r=0,a=Object.getOwnPropertySymbols(e);r<a.length;r++)t.indexOf(a[r])<0&&Object.prototype.propertyIsEnumerable.call(e,a[r])&&(i[a[r]]=e[a[r]]);return i};const Ge=e=>{const{prefixCls:t,className:i,avatar:a,title:r,description:d}=e,g=He(e,["prefixCls","className","avatar","title","description"]),{getPrefixCls:p}=n.useContext(P),u=p("card",t),h=m(`${u}-meta`,i),v=a?n.createElement("div",{className:`${u}-meta-avatar`},a):null,x=r?n.createElement("div",{className:`${u}-meta-title`},r):null,C=d?n.createElement("div",{className:`${u}-meta-description`},d):null,O=x||C?n.createElement("div",{className:`${u}-meta-detail`},x,C):null;return n.createElement("div",Object.assign({},g,{className:h}),v,O)},D=Ne;D.Grid=W;D.Meta=Ge;export{D as C};
