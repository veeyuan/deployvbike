if (self.CavalryLogger) { CavalryLogger.start_js(["EAoOu"]); }

__d("BanzaiUtils",["BanzaiConsts","CurrentUser","FBLogger","WebSession","performanceAbsoluteNow"],(function(a,b,c,d,e,f){"use strict";var g,h,i={canSend:function(a){return a[2]>=(g||(g=b("performanceAbsoluteNow")))()-(h||(h=b("BanzaiConsts"))).EXPIRY},filterPost:function(a,c,d,e){if(e.overlimit)return!0;if(!e.sendMinimumOnePost&&a[4]+e.currentSize>(h||(h=b("BanzaiConsts"))).BATCH_SIZE_LIMIT)return!0;var f=a.__meta;if(f.status!=null&&f.status>=(h||(h=b("BanzaiConsts"))).POST_SENT||!i.canSend(a))return!1;if(f.status!=null&&f.status>=(h||(h=b("BanzaiConsts"))).POST_INFLIGHT)return!0;var g=f.compress!=null?f.compress:!0,j=(f.webSessionId!=null?f.webSessionId:"null")+(f.userID!=null?f.userID:"null")+(f.appID!=null?f.appID:"null")+(g?"compress":""),k=e.wadMap.get(j);k||(k={app_id:f.appID,needs_compression:g,posts:[],user:f.userID,webSessionId:f.webSessionId},e.wadMap.set(j,k),c.push(k));f.status=(h||(h=b("BanzaiConsts"))).POST_INFLIGHT;Array.isArray(k.posts)?k.posts.push(a):b("FBLogger")("banzai").mustfix("Posts were a string instead of array");d.push(a);e.currentSize+=a[4];e.currentSize>=(h||(h=b("BanzaiConsts"))).BATCH_SIZE_LIMIT&&(e.overlimit=!0);return e.keepRetryable&&Boolean(f.retry)},resetPostStatus:function(a){a.__meta.status=(h||(h=b("BanzaiConsts"))).POST_READY},retryPost:function(a,c,d){var e=a;e.__meta.status=(h||(h=b("BanzaiConsts"))).POST_READY;e[3]=(e[3]||0)+1;e.__meta.retry!==!0&&c>=400&&c<600&&d.push(a)},wrapData:function(a,c,d,e,f){d=[a,c,d,0,(a=f)!=null?a:c?JSON.stringify(c).length:0];d.__meta={appID:b("CurrentUser").getAppID(),retry:e===!0,status:(h||(h=b("BanzaiConsts"))).POST_READY,userID:b("CurrentUser").getID(),webSessionId:b("WebSession").getId()};return d}};e.exports=i}),null);
__d("SetIdleTimeoutAcrossTransitions",["NavigationMetrics","cancelIdleCallback","clearTimeout","nullthrows","requestIdleCallbackAcrossTransitions","setTimeoutAcrossTransitions"],(function(a,b,c,d,e,f){"use strict";f.start=c;f.clear=d;var g=!1,h=new Map();function c(a,c){if(g){var d=b("setTimeoutAcrossTransitions")(function(){var c=b("requestIdleCallbackAcrossTransitions")(function(){a(),h["delete"](c)});h.set(d,c)},c);return d}else return b("setTimeoutAcrossTransitions")(a,c)}function d(a){b("clearTimeout")(a),h.has(a)&&(b("cancelIdleCallback")(b("nullthrows")(h.get(a))),h["delete"](a))}b("NavigationMetrics").addRetroactiveListener(b("NavigationMetrics").Events.EVENT_OCCURRED,function(b,c){c.event==="all_pagelets_loaded"&&(g=!!a.requestIdleCallback)})}),null);
__d("BanzaiStorage",["BanzaiConsts","BanzaiUtils","CurrentUser","FBJSON","SetIdleTimeoutAcrossTransitions","WebSession","WebStorage","WebStorageMutex","isInIframe","performanceAbsoluteNow"],(function(a,b,c,d,e,f){"use strict";var g,h,i,j="bz:",k=b("isInIframe")(),l,m=!1,n=null;function o(){var a="check_quota";try{var b=p();if(!b)return!1;b.setItem(a,a);b.removeItem(a);return!0}catch(a){return!1}}function p(){m||(m=!0,l=(g||(g=b("WebStorage"))).getLocalStorage());return l}a={flush:function(a){if(k)return;var c=p();if(c){n==null&&(n=parseInt(c.getItem((h||(h=b("BanzaiConsts"))).LAST_STORAGE_FLUSH),10));var d=n&&(i||(i=b("performanceAbsoluteNow")))()-n>=(h||(h=b("BanzaiConsts"))).STORAGE_FLUSH_INTERVAL;d&&a();(d||!n)&&(n=(i||(i=b("performanceAbsoluteNow")))(),(g||(g=b("WebStorage"))).setItemGuarded(c,(h||(h=b("BanzaiConsts"))).LAST_STORAGE_FLUSH,n.toString()))}},restore:function(a){if(k)return;var c=p();if(!c)return;var d=function(d){var e=[];for(var f=0;f<c.length;f++){var g=c.key(f);typeof g==="string"&&g.indexOf(j)===0&&g.indexOf("bz:__")!==0&&e.push(g)}e.forEach(function(d){var e=c.getItem(d);c.removeItem(d);if(e==null||e==="")return;d=b("FBJSON").parse(e);d.forEach(function(c){if(!c)return;var d=c.__meta=c.pop(),e=b("BanzaiUtils").canSend(c);if(!e)return;e=b("CurrentUser").getID();(d.userID===e||e==="0")&&(b("BanzaiUtils").resetPostStatus(c),a(c))})});d&&d.unlock()};o()?new(b("WebStorageMutex"))("banzai").lock(d):b("SetIdleTimeoutAcrossTransitions").start(d,0)},store:function(a){if(k)return;var c=p(),d=a.filter(function(a){return a.__meta.status!==(h||(h=b("BanzaiConsts"))).POST_SENT});if(!c||d.length<=0)return;d=d.map(function(a){return[a[0],a[1],a[2],a[3]||0,a[4],a.__meta]});a.splice(0,a.length);(g||(g=b("WebStorage"))).setItemGuarded(c,j+b("WebSession").getId()+"."+(i||(i=b("performanceAbsoluteNow")))(),b("FBJSON").stringify(d))}};e.exports=a}),null);
__d("BanzaiAdapter",["invariant","Arbiter","BanzaiConsts","BanzaiStorage","CurrentUser","ErrorGuard","QueryString","Run","TimeSlice","URI","UserAgent","ZeroRewrites","getAsyncParams","gkx","isInIframe","lowerFacebookDomain","once","BanzaiConfig"],(function(a,b,c,d,e,f,g){var h,i,j=[],k=new(b("Arbiter"))(),l=b("isInIframe")();a=b("BanzaiConfig");var m="/ajax/bz",n="POST",o={config:a,useBeacon:!0,getEndPointUrl:function(a){a=b("getAsyncParams")(n);a=b("QueryString").appendToUrl(m,a);a.length<=2e3||g(0,21850,a);return a},getStorage:function(){return b("BanzaiStorage")},getTopLevel:function(){return l&&b("lowerFacebookDomain").isValidDocumentDomain()?window.top:null},getUserID:function(){return b("CurrentUser").getID()},inform:function(a){k.inform(a)},subscribe:function(a,b){return k.subscribe(a,b)},wrapInTimeSlice:function(a,c){return b("TimeSlice").guard(function(){a()},c,{propagationType:b("TimeSlice").PropagationType.ORPHAN})},cleanup:function(){var a=j;j=[];a.forEach(function(a){a.readyState<4&&a.abort()})},preferredCompressionMethod:b("once")(function(){return"snappy_base64"}),readyToSend:function(){return b("UserAgent").isBrowser("IE <= 8")||navigator.onLine},send:function(a,c,d,e){var f=o.getEndPointUrl(!1);f=b("ZeroRewrites").rewriteURI(new(h||(h=b("URI")))(f));var g=b("ZeroRewrites").getTransportBuilderForURI(f)();g.open(n,f.toString(),!0);g.onreadystatechange=function(){if(g.readyState>=4){var a=j.indexOf(g);a>=0&&j.splice(a,1);try{a=g.status}catch(b){a=0}a==200?(c&&c(),e||o.inform((i||(i=b("BanzaiConsts"))).OK)):(d&&d(a),e||o.inform((i||(i=b("BanzaiConsts"))).ERROR))}};j.push(g);g.send(a,!1)},setHooks:function(a){},setUnloadHook:function(a){b("Run").onAfterUnload(a._unload)},onUnload:function(a){b("Run").onAfterUnload(a)},isOkToSendViaBeacon:function(){return!0}};c=o;e.exports=c}),null);
__d("InlineFbtResultImpl",["cx","FbtHooks","FbtReactUtil","FbtResultBase"],(function(a,b,c,d,e,f,g){var h;function i(a,c,d,e){var f="_4qba";e!=null&&e!=""&&(c==="TRANSLATION"?f="_4qbb":c==="APPROVE"?f="_4qbc":c==="REPORT"&&(f="_4qbd"));return{$$typeof:b("FbtReactUtil").REACT_ELEMENT_TYPE,type:"em",key:null,ref:null,props:{className:f,"data-intl-hash":e,"data-intl-translation":d,"data-intl-trid":"",children:a,suppressHydrationWarning:!0},_owner:null}}var j=function(a){return i(a.content,a.inlineMode,a.translation,a.hash)};a=function(a){babelHelpers.inheritsLoose(c,a);function c(c,d,e,f){var g;g=a.call(this,c,(h||(h=b("FbtHooks"))).getErrorListener({translation:e,hash:f}))||this;g.$$typeof=b("FbtReactUtil").REACT_ELEMENT_TYPE;g.key=null;g.ref=null;g.type=j;g.props={content:c,inlineMode:d,translation:e,hash:f};return g}return c}(b("FbtResultBase"));e.exports=a}),null);
__d("cancelIdleCallbackBlue",["IdleCallbackImplementation"],(function(a,b,c,d,e,f){e.exports=c;var g=(d=a.cancelIdleCallback)!=null?d:b("IdleCallbackImplementation").cancelIdleCallback;function c(a){g(a)}}),null);
__d("BanzaiCompressionUtils",["Promise","FBLogger","SnappyCompressUtil","once","performanceNow"],(function(a,b,c,d,e,f){"use strict";var g,h=b("once")(function(){if(a.CompressionStream==null)return!1;if(a.Response==null)return!1;try{new a.CompressionStream("deflate")}catch(a){return!1}return!0}),i={compressWad:function(a,c){if(a.needs_compression!==!0){delete a.needs_compression;return}if(c==="deflate"){i.compressWad(a,"snappy");return}var d=(g||(g=b("performanceNow")))(),e=JSON.stringify(a.posts),f;switch(c){case"snappy":f=b("SnappyCompressUtil").compressStringToSnappyBinary(e);break;case"snappy_base64":f=b("SnappyCompressUtil").compressStringToSnappy(e);break;default:break}f!=null&&f.length<e.length?(a.posts=f,a.compression=c,a.snappy_ms=Math.ceil((g||(g=b("performanceNow")))()-d),a.snappy_ms<0&&b("FBLogger")("BanzaiCompressionUtils").warn("Expected positive snappy_ms but got %s",a.snappy_ms)):a.compression="";delete a.needs_compression},compressWadAsync:function(c,d){if(d!=="deflate"){i.compressWad(c,"snappy");return b("Promise").resolve()}if(!h())return i.compressWadAsync(c,"snappy");var e=(g||(g=b("performanceNow")))(),f=JSON.stringify(c.posts),j=new Response(f).body;if(!j){c.compression="";delete c.needs_compression;return b("Promise").resolve()}j=j.pipeThrough(new a.CompressionStream("deflate"));return new Response(j).arrayBuffer().then(function(a){a.byteLength<f.length?(c.posts=new Uint8Array(a),c.compression=d,c.snappy_ms=Math.ceil((g||(g=b("performanceNow")))()-e),c.snappy_ms<0&&b("FBLogger")("BanzaiCompressionUtils").warn("Expected positive snappy_ms but got %s",c.snappy_ms)):c.compression="",delete c.needs_compression})["catch"](function(){c.compression="",delete c.needs_compression})},outOfBandsPosts:function(a){var b=0,c={};for(var d=0;d<a.length;d++){var e=a[d],f=e.compression==="snappy"||e.compression==="deflate";if(f){f=new Blob([e.posts],{type:"application/octet-stream"});e.posts=String(b);c["post_"+String(b)]=f;b++}}return c}};e.exports=i}),null);
__d("BanzaiBase",["BanzaiAdapter","BanzaiCompressionUtils","BanzaiConsts","BanzaiLazyQueue","BanzaiUtils","CurrentUser","ErrorGuard","ExecutionEnvironment","FBLogger","NavigationMetrics","SetIdleTimeoutAcrossTransitions","Visibility","WebSession","performanceAbsoluteNow"],(function(a,b,c,d,e,f){var g,h,i,j,k,l=[],m=null,n={_clearPostBuffer:function(){l=[]},_gatherWadsAndPostsFromBuffer:function(a,c,d,e,f){var g={currentSize:0,keepRetryable:d,overlimit:!1,sendMinimumOnePost:f,wadMap:new Map()};d=e.filter(function(d,e){return b("BanzaiUtils").filterPost(d,a,c,g)});g.overlimit&&d.length&&n._schedule(0);return d},_getEventTime:function(){return(g||(g=b("performanceAbsoluteNow")))()},_getWebSessionId:function(){return b("WebSession").getId()},_getPostBuffer:function(){return l},_getUserId:function(){return b("CurrentUser").getID()},_getAppId:function(){return b("CurrentUser").getAppID()},_initialize:function(){b("ExecutionEnvironment").canUseDOM&&(n.adapter.useBeacon&&b("Visibility").isSupported()?(b("Visibility").addListener(b("Visibility").HIDDEN,function(){n._getPostBuffer().length>0&&(n._tryToSendViaBeacon()||n._store(!1))}),n.isEnabled("enable_client_logging_clear_on_visible")&&b("Visibility").addListener(b("Visibility").VISIBLE,function(){n._tryToSendViaBeacon()||n._restore(!1)})):n.adapter.setHooks(n),n.adapter.setUnloadHook(n),b("NavigationMetrics").addListener(b("NavigationMetrics").Events.NAVIGATION_DONE,function(a,c){if(c.pageType!=="normal")return;n._restore(!1);b("NavigationMetrics").removeCurrentListener()}))},_sendBeacon:function(b,c){return a.navigator.sendBeacon(b,c)},_prepForTransit:function(a){var c=new FormData();c.append("ts",String(Date.now()));var d={};Object.keys(d).sort().forEach(function(a){var b=d[a];if(b===void 0)return;if(b===null){c.append(a,"");return}c.append(a,String(b))});var e=b("BanzaiCompressionUtils").outOfBandsPosts(a);Object.keys(e).forEach(function(a){c.append(a,e[a])});c.append("q",JSON.stringify(a));return c},_prepWadForTransit:function(a){b("BanzaiCompressionUtils").compressWad(a,b("BanzaiAdapter").preferredCompressionMethod())},_processCallbacksAndSendViaBeacon:function(){var a=[],c=[],d=[];n._gatherWadsAndPostsFromBuffer(c,d,!0,a,!1);if(c.length>0){c[0].send_method="beacon";c.map(n._prepWadForTransit);d=n._prepForTransit(c);a=b("BanzaiAdapter").getEndPointUrl(!0);c=n._sendBeacon(a,d);c||b("FBLogger")("banzai").warn("Error sending beacon")}},_restore:function(a){a=b("BanzaiAdapter").getStorage();var c=function(a){l.push(a)};(h||(h=b("ErrorGuard"))).applyWithGuard(a.restore,a,[c]);n._schedule(b("BanzaiAdapter").config.RESTORE_WAIT||(i||(i=b("BanzaiConsts"))).VITAL_WAIT)},_schedule:function(a){var c=n._getEventTime()+a;if(!k||c<k){k=c;b("SetIdleTimeoutAcrossTransitions").clear(j);j=b("SetIdleTimeoutAcrossTransitions").start(b("BanzaiAdapter").wrapInTimeSlice(n._sendWithCallbacks,"Banzai.send"),a);return!0}return!1},_sendWithCallbacks:function(a,c){k=null;n._schedule(n.BASIC.delay);if(!b("BanzaiAdapter").readyToSend()){c&&c();return}if(n.isEnabled("flush_storage_periodically")){var d=b("BanzaiAdapter").getStorage(),e=function(){n._restore(!1)};(h||(h=b("ErrorGuard"))).applyWithGuard(d.flush,d,[e])}b("BanzaiAdapter").inform((i||(i=b("BanzaiConsts"))).SEND);d=[];var f=[];l=n._gatherWadsAndPostsFromBuffer(d,f,!0,l,!0);if(d.length<=0){b("BanzaiAdapter").inform((i||(i=b("BanzaiConsts"))).OK);a&&a();return}d[0].trigger=m;m=null;d[0].send_method="ajax";d.map(n._prepWadForTransit);b("BanzaiAdapter").send(n._prepForTransit(d),function(){f.forEach(function(a){a=a;a.__meta.status=(i||(i=b("BanzaiConsts"))).POST_SENT;a.__meta.callback&&a.__meta.callback()}),a&&a()},function(a){f.forEach(function(c){b("BanzaiUtils").retryPost(c,a,l)}),c&&c()})},_store:function(a){a=b("BanzaiAdapter").getStorage();(h||(h=b("ErrorGuard"))).applyWithGuard(a.store,a,[l])},_testState:function(){return{postBuffer:l,triggerRoute:m}},_tryToSendViaBeacon:function(){if(!(navigator&&navigator.sendBeacon&&b("BanzaiAdapter").isOkToSendViaBeacon()))return!1;var a=[],c=[];l=n._gatherWadsAndPostsFromBuffer(a,c,!1,l,!1);if(a.length<=0)return!1;a[0].send_method="beacon";a.map(n._prepWadForTransit);a=n._prepForTransit(a);var d=b("BanzaiAdapter").getEndPointUrl(!0);d=n._sendBeacon(d,a);if(!d){c.forEach(function(a){l.push(a)});return!1}return!0},_unload:function(){if(b("BanzaiAdapter").config.disabled)return;navigator&&navigator.sendBeacon&&b("BanzaiAdapter").isOkToSendViaBeacon()&&n._processCallbacksAndSendViaBeacon();b("BanzaiAdapter").cleanup();b("BanzaiAdapter").inform((i||(i=b("BanzaiConsts"))).SHUTDOWN);l.length>0&&((!n.adapter.useBeacon||!n._tryToSendViaBeacon())&&n._store(!1))},BASIC:{delay:b("BanzaiAdapter").config.MAX_WAIT||(i||(i=b("BanzaiConsts"))).BASIC_WAIT},BASIC_WAIT:(i||(i=b("BanzaiConsts"))).BASIC_WAIT,ERROR:i.ERROR,OK:i.OK,SEND:i.SEND,SHUTDOWN:i.SHUTDOWN,VITAL:{delay:b("BanzaiAdapter").config.MIN_WAIT||(i||(i=b("BanzaiConsts"))).VITAL_WAIT},VITAL_WAIT:i.VITAL_WAIT,adapter:b("BanzaiAdapter"),canUseNavigatorBeacon:function(){return Boolean(navigator&&navigator.sendBeacon&&b("BanzaiAdapter").isOkToSendViaBeacon())},flush:function(a,c){b("SetIdleTimeoutAcrossTransitions").clear(j),n._sendWithCallbacks(a,c)},isEnabled:function(a){return Boolean(b("BanzaiAdapter").config.gks&&b("BanzaiAdapter").config.gks[a]&&!b("BanzaiAdapter").config.disabled)},post:function(a,c,d){a||b("FBLogger")("banzai").mustfix("Banzai.post called without specifying a route");var e="";try{var f;e=(f=JSON.stringify(c))!=null?f:""}catch(c){b("FBLogger")("banzai").catching(c).addToCategoryKey(a).mustfix("Could not JSON.stringify banzai data for route %s",a);return}var g=d==null?void 0:d.retry;if(b("BanzaiAdapter").config.disabled)return;if(!b("ExecutionEnvironment").canUseDOM&&!b("ExecutionEnvironment").isInWorker)return;var h=n.adapter.getTopLevel();if(h){var j;try{j=h.require("Banzai")}catch(a){j=null}if(j){j.post.apply(j,arguments);return}}var k=b("BanzaiAdapter").config.blacklist;if(k&&(k.indexOf&&(typeof k.indexOf=="function"&&k.indexOf(a)!=-1)))return;var o=e.length,p=b("BanzaiUtils").wrapData(a,c,n._getEventTime(),g,o),q=p;(d==null?void 0:d.callback)&&(q.__meta.callback=d==null?void 0:d.callback);(d==null?void 0:d.compress)!=null&&(q.__meta.compress=d==null?void 0:d.compress);var r=d==null?void 0:d.delay;r==null&&(r=(i||(i=b("BanzaiConsts"))).BASIC_WAIT);if(d==null?void 0:d.signal){q.__meta.status=(i||(i=b("BanzaiConsts"))).POST_INFLIGHT;var s=[{user:n._getUserId(),webSessionId:n._getWebSessionId(),app_id:n._getAppId(),posts:[p],trigger:a}];b("BanzaiAdapter").send(n._prepForTransit(s),function(){q.__meta.status=(i||(i=b("BanzaiConsts"))).POST_SENT,q.__meta.callback&&q.__meta.callback()},function(a){b("BanzaiUtils").retryPost(p,a,l)},!0);if(!g)return}l.push(p);(n._schedule(r)||!m)&&(m=a);var t=b("BanzaiLazyQueue").flushQueue();t.forEach(function(a){return n.post.apply(n,a)})},subscribe:b("BanzaiAdapter").subscribe};n._initialize();e.exports=n}),null);