!function(e){function t(n){if(r[n])return r[n].exports;var a=r[n]={i:n,l:!1,exports:{}};return e[n].call(a.exports,a,a.exports,t),a.l=!0,a.exports}var r={};t.m=e,t.c=r,t.d=function(e,r,n){t.o(e,r)||Object.defineProperty(e,r,{configurable:!1,enumerable:!0,get:n})},t.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(r,"a",r),r},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=0)}([function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});r(1)},function(e,t,r){"use strict";function n(e){if(Array.isArray(e)){for(var t=0,r=Array(e.length);t<e.length;t++)r[t]=e[t];return r}return Array.from(e)}var a=r(2),l=(r.n(a),r(3)),i=(r.n(l),wp.i18n.__),o=wp.blocks.registerBlockType,s=wp.editor.MediaUpload,c=wp.components.Button;o("deo/block-gallery-slider",{title:i("Deo Gallery Slider"),description:i("Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items."),icon:"format-gallery",category:"common",keywords:[i("slider"),i("photos"),i("images")],attributes:{images:{type:"array"}},edit:function(e){var t=e.attributes,r=(e.className,e.setAttributes),a=t.images,l=void 0===a?[]:a,i=function(e){var t=l.filter(function(t){if(t.id!=e.id)return t});r({images:t})};return wp.element.createElement("div",null,wp.element.createElement("div",{className:"deo-gallery-grid"},function(e){return e.map(function(t){return wp.element.createElement("div",{className:"deo-gallery-grid__item-container"},wp.element.createElement("img",{className:"deo-gallery-grid__item",src:t.url,key:e.id}),wp.element.createElement("div",{className:"remove-item",onClick:function(){return i(t)}},wp.element.createElement("span",{class:"dashicons dashicons-trash"})))})}(l)),wp.element.createElement("div",{className:"components-placeholder editor-media-placeholder"},wp.element.createElement("div",{className:"components-placeholder__instructions"},"Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items."),wp.element.createElement(s,{onSelect:function(e){r({images:[].concat(n(l),n(e))})},type:"image",multiple:!0,value:l,render:function(e){var t=e.open;return wp.element.createElement(c,{className:"select-images-button is-button is-default is-large",onClick:t},"Add images")}})))},save:function(e){var t=e.attributes,r=t.images,n=void 0===r?[]:r;return wp.element.createElement("div",{className:"entry__img-holder"},wp.element.createElement("div",{className:"deo-gallery-slider flickity-single-carousel arrows-white dots-inside","data-total-slides":n.length},function(e){return e.map(function(t,r){return wp.element.createElement("img",{className:"deo-gallery-slider__item",key:e.id,src:t.url,"data-slide-no":r,"data-caption":t.caption,alt:t.alt})})}(n)))}})},function(e,t){},function(e,t){}]);