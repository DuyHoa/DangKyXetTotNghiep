DocsSite.loadBundle("m3zdr5uv",["exports","./chunk-7a8ffcac.js"],function(t,a){var i=window.DocsSite.h,e=function(){function t(){this.unsubscribe=function(){},this.activeClass="link-active",this.exact=!1,this.strict=!0,this.custom="a",this.match=null}return t.prototype.componentWillLoad=function(){this.computeMatch()},t.prototype.computeMatch=function(){this.location&&(this.match=a.matchPath(this.location.pathname,{path:this.urlMatch||this.url,exact:this.exact,strict:this.strict}))},t.prototype.handleClick=function(t){var i,e;if(!a.isModifiedEvent(t)&&this.history&&this.url&&this.root)return t.preventDefault(),this.history.push((e=this.root,"/"==(i=this.url).charAt(0)&&"/"==e.charAt(e.length-1)?e.slice(0,e.length-1)+i:e+i))},t.prototype.render=function(){var t,a={class:(t={},t[this.activeClass]=null!==this.match,t),onClick:this.handleClick.bind(this)};return this.anchorClass&&(a.class[this.anchorClass]=!0),"a"===this.custom&&(a=Object.assign({},a,{href:this.url,title:this.anchorTitle,role:this.anchorRole,tabindex:this.anchorTabIndex,"aria-haspopup":this.ariaHaspopup,id:this.anchorId,"aria-posinset":this.ariaPosinset,"aria-setsize":this.ariaSetsize,"aria-label":this.ariaLabel})),i(this.custom,Object.assign({},a),i("slot",null))},Object.defineProperty(t,"is",{get:function(){return"stencil-route-link"},enumerable:!0,configurable:!0}),Object.defineProperty(t,"properties",{get:function(){return{activeClass:{type:String,attr:"active-class"},anchorClass:{type:String,attr:"anchor-class"},anchorId:{type:String,attr:"anchor-id"},anchorRole:{type:String,attr:"anchor-role"},anchorTabIndex:{type:String,attr:"anchor-tab-index"},anchorTitle:{type:String,attr:"anchor-title"},ariaHaspopup:{type:String,attr:"aria-haspopup"},ariaLabel:{type:String,attr:"aria-label"},ariaPosinset:{type:String,attr:"aria-posinset"},ariaSetsize:{type:Number,attr:"aria-setsize"},custom:{type:String,attr:"custom"},el:{elementRef:!0},exact:{type:Boolean,attr:"exact"},history:{type:"Any",attr:"history"},location:{type:"Any",attr:"location",watchCallbacks:["computeMatch"]},match:{state:!0},root:{type:String,attr:"root"},strict:{type:Boolean,attr:"strict"},url:{type:String,attr:"url"},urlMatch:{type:String,attr:"url-match"}}},enumerable:!0,configurable:!0}),t}();a.ActiveRouter.injectProps(e,["history","location","root"]),t.StencilRouteLink=e,Object.defineProperty(t,"__esModule",{value:!0})});