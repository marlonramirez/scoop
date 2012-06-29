(function(a,f,h,b){var d=true,g=false,e=null,c={$:function(l,n,u){var k=l.substr(1),r=l.charAt(0);if(r=="#"){return h.getElementById(k)}n||(n=h);if(r=="@"){return n.getElementsByName(k)}if(r=="."){if(n.getElementsByClassName){return n.getElementsByClassName(k)}u||(u="*");var t=[],p=c.$(u),s=new RegExp("(^|\\s)"+k+"(\\s|$)");for(var q=0,m,o=0;m=p[q];q++){if(s.test(m.className)){t[o]=m;o++}}return t}return n.getElementsByTagName(l)},ready:(function(){var k=[];function j(m){var n=g;function l(){if(!n){n=d;m()}}if(h.addEventListener){h.addEventListener("DOMContentLoaded",l,g)}else{if(h.attachEvent){if(h.documentElement.doScroll&&f==f.top){function o(){if(!n||h.body){try{h.documentElement.doScroll("left");l()}catch(p){setTimeout(o,0)}}}o()}h.attachEvent("onreadystatechange",function(){if(h.readyState==="complete"){l()}})}}c.evt.add(f,"load",l)}return function(l){if(!k.length){j(function(){for(var m=0;m<k.length;m++){k[m]()}})}k.push(l)}})(),extend:function(j,k){for(var l in k){j[l]=k[l]}return j},evt:(function(){var k={add:function(n,m,o,l){if(j(n,m,o,l)){if(n.attachEvent){var p=function(){o.call(n,event)};n.attachEvent("on"+m,p);n[o.toString()+m]=p}else{if(n.addEventListener){n.addEventListener(m,o,l)}else{n["on"+m]=o}}}},remove:function(n,m,o,l){if(j(n,m,o,l)){if(n.detachEvent){n.detachEvent("on"+m,n[o.toString()+m]);n[o.toString()+m]=e}else{if(n.removeEventListener){n.removeEventListener(m,o,l)}else{n["on"+m]=function(){}}}}},on:function(o,s,n,q,l){if(j(o,n,q,l,s)){var r=s.charAt(0),p=(r=="#")?"id":(r==".")?"className":(r=="@")?"name":"nodeName",m=(p=="nodeName")?s.toUpperCase():s.substr(1);k.add(o,n,function(){var v=k.get().target;if(s=="*"){q.apply(v,arguments)}else{while(v&&v!==o){var w=v[p].split(" ");for(var t=0,u;u=w[t];t++){if(u==m){q.apply(v,arguments)}}v=v.parentNode}}},l)}},get:function(){var l=f.event;if(l){if(navigator.appName=="Opera"){return l}l.charCode=(l.type=="keypress")?l.keyCode:0;l.eventPhase=2;l.isChar=(l.charCode>0);l.pageX=l.clientX+h.body.scrollLeft;l.pageY=l.clientY+h.body.scrollTop;l.preventDefault=function(){this.returnValue=g};if(l.type=="mouseout"){l.relatedTarget=l.toElement}else{if(l.type=="mouseover"){l.relatedTarget=l.fromElement}}l.stopPropagation=function(){this.cancelBubble=d};l.target=l.srcElement;l.time=(new Date).getTime();return l}else{return k.get.caller.arguments[0]}}};function j(q,o,r,m,s){var n=j.caller;if(q.length){for(var p=0;el=q[p];p++){n(el,o,r,m)}return g}if(o instanceof Object){for(var l in o){if(s){n(q,s,l,o[l],r)}else{n(q,l,o[l],r)}}return g}return d}return k})(),css:(function(m){var l=h.createElement("b").style;function k(r,t){for(var q=0,s;s=h.styleSheets[q];q++){var o=s.cssRules||s.rules;for(var n=0,p;p=o[n];n++){if(p.selectorText==r){if(t){if(s.cssRules){s.deleteRule(n)}else{s.removeRule(n)}return d}else{return p}}}}return g}function j(n){if(n[0]=="opacity"&&l[n[0]]==b){n[0]="filter";n[1]="alpha(opacity='"+n[1]*100+"')"}}return function(n,p){var o;if(typeof n=="string"){if(p){k(n,p)}else{if(!k(n)){if(h.styleSheets[0].addRule){h.styleSheets[0].addRule(n,e,0)}else{h.styleSheets[0].insertRule(n+" { }",0)}}o=k(n)}}else{o=n}return{get:function(r){j(arguments);var q=(o!=n)?o.style[r]:(o.currentStyle||h.defaultView.getComputedStyle(o,""))[r];if(q.indexOf("#")==0){temp=i(q);q="rgb("+temp[0]+", "+temp[1]+", "+temp[2]+")"}if(r=="filter"){q=(q=="")?"1":(m(q.replace(/[^\d]/g,""))/100)+""}return q},set:function(s,r){if(s instanceof Object){for(var q in s){this.set(q,s[q])}}else{j(arguments);o.style[s]=r}}}}})(parseInt),ajax:{xhr:function(){try{return new XMLHttpRequest()}catch(l){try{return new ActiveXObject("Microsoft.XMLHTTP")}catch(k){try{return new ActiveXObject("Msxml2.XMLHTTP")}catch(j){return e}}}},request:function(k,r,m){m||(m={});var q=c.ajax.xhr(),o=(m.response||"Text").toUpperCase(),l=m.feedback,p=m.data,j=(m.method||"POST").toUpperCase(),n=!m.sync;q.onreadystatechange=function(){if(q.readyState==4){if(q.status==200){var s=(o=="XML")?q.responseXML:q.responseText;r(s)}else{if(l){l(q.status)}}}else{if(l){l(q.readyState)}}};p=c.ajax.url(p);if(j=="GET"){if(p){k=k+"?"+p;p=e}q.open(j,k,n)}else{q.open("POST",k,n);q.setRequestHeader("Content-Type","application/x-www-form-urlencoded")}q.setRequestHeader("X-Requested-With","XMLHttpRequest");q.send(p)},url:function(m){if(!(m instanceof Object)){return m}var k="",l=encodeURIComponent;for(var j in m){if(typeof m[j]=="string"||typeof m[j]=="number"){k+=l(j)+"="+l(m[j])+"&"}}return k.substr(0,k.length-1)},form:function(l){var m={};for(var j=0,k;k=l[j];j++){if(k.name!=b&&k.name!=""){if(k.type=="radio"||k.type=="checkbox"){if(k.checked){m[k.name]=k.value}}else{m[k.name]=k.value}}}return m}},sfx:{dyd:function(r,u,k){var q=r.clientX+h.documentElement.scrollLeft+h.body.scrollLeft,o=r.clientY+h.documentElement.scrollTop+h.body.scrollTop,m=c.css(u),n=parseInt(m.get("marginLeft"))||0,j=parseInt(m.get("marginTop"))||0,t=u.offsetLeft-n,s=u.offsetTop-j;function p(){var B=c.evt.get(),z=B.clientX+h.documentElement.scrollLeft+h.body.scrollLeft,w=B.clientY+h.documentElement.scrollTop+h.body.scrollTop,v=k.offsetLeft,A=k.offsetTop,E=k.offsetHeight,C=k.offsetWidth,F=t+z-q,D=s+w-o;if(F<=(n*-1)+v){F=(n*-1)+v}else{if(F>=(C+n+v-(u.offsetWidth+n*2))){F=C+n+v-(u.offsetWidth+n*2)}}if(D<=(j*-1)+A){D=(j*-1)+A}else{if(D>=(E+j+A-(u.offsetHeight+j*2))){D=E+j+A-(u.offsetHeight+j*2)}}if(m.get("position")=="relative"){F=F-v;D=D-A}m.set({left:F+"px",top:D+"px"});B.preventDefault()}function l(){c.evt.remove(h,{mousemove:p,mouseup:l},d)}c.evt.add(h,{mousemove:p,mouseup:l},d);r.preventDefault()},anim:function(t,u,m){m||(m={});var k=c.css(t),q=parseInt(m.duration)||1000,n=parseInt(m.fps)||100,o=m.onComplete,p,l,x=[],w=[],y=[];for(var j in u){var s=k.get(j);if(s.indexOf("rgb")==0){y[j]=[];var v=u[j];if(v.indexOf("#")==0){w[j]=i(v)}else{w[j]=v.substring(4,v.length-1).split(",")}x[j]=s.substring(4,s.length-1).split(",");for(var r=0;r<3;r++){x[j][r]=parseInt(x[j][r]);y[j][r]=(x[j][r]-w[j][r])/((q/1000)*n)}}else{x[j]=parseInt(s);w[j]=parseInt(u[j]);y[j]=isNaN(u[j])?u[j].replace(/(\+|-)?\d+/g,""):""}}p=+new Date;l=setInterval(function(){var A=+new Date;if(A<p+q){for(var B in u){if(k.get(B).indexOf("rgb")==0){for(var z=0;z<3;z++){x[B][z]=Math.round(x[B][z]-y[B][z])}k.set(B,"rgb("+x[B].toString()+")")}else{k.set(B,(x[B]+(w[B]-x[B])*((A-p)/q))+y[B])}}}else{l=clearInterval(l);for(var B in u){k.set(B,u[B])}if(o){o()}}},Math.round(1000/n))},fade:function(l,j){j||(j={});var m=c.css(l),k=j.onComplete;if(m.get("display")=="none"){m.set({display:"block",opacity:0});c.sfx.anim(l,{opacity:1},j)}else{c.sfx.anim(l,{opacity:0},c.extend(j,{onComplete:function(){m.set("display","none");k&&k()}}))}}},modal:(function(){var k=f.sessionStorage||{},o,l,m,j={show:function(){c.evt.get().preventDefault();var y=this.getAttribute("title")||"",p=this.getAttribute("href"),F=h.location,E=this.rel.split("-")[1]=="cache",t;if(p.indexOf(F+"#")==0){p=p.replace(F,"")}if(!l){l=h.createElement("div");o=l.cloneNode(g);var x=l.cloneNode(g),u=l.cloneNode(g),B=h.createElement("h2");l.id="overlay";o.id="modal";x.className="head";c.evt.add(x,"mousedown",function(){c.sfx.dyd(c.evt.get(),o,l)});c.evt.add([u,l],"click",j.hide);h.body.appendChild(l);x.appendChild(u);x.appendChild(B);o.appendChild(j.round(c.css(".head").get("backgroundColor"),"top"));o.appendChild(x);h.body.appendChild(o)}if(o.childNodes[2]){var D=this,w=arguments;c.sfx.fade(o,{onComplete:function(){n();j.show.apply(D,w)},duration:500});return}if(p.indexOf("#")==0){m=c.$(p);var z=m.parentNode;t=m.cloneNode(d);z.removeChild(m)}else{var r=h.createElement("div");if(!E||!(r.innerHTML=k[p])){c.ajax.request(p,function(G){if(E){k[p]=G}r.innerHTML=G},{sync:d})}t=r.firstChild}o.appendChild(t);o.appendChild(j.round(c.css(t).get("backgroundColor"),"bottom"));t.style.display="block";o.childNodes[1].childNodes[1].innerHTML=y;c.css(l).set("display","block");c.sfx.fade(o);var C=o.childNodes,A=0,q=t.offsetWidth;for(var s=0,v;v=C[s];s++){A+=v.offsetHeight}c.css(o).set({width:q+"px",height:A+"px",marginLeft:-(q/2)+"px",marginTop:-(A/2)+"px"});c.modal.reset()},hide:function(){c.sfx.fade(o,{onComplete:function(){c.css(l).set("display","none");n()},duration:500})},reset:function(){o&&c.css(o).set({top:"50%",left:"50%"})},round:function(q,p){p=p.toLowerCase();var s=h.createElement("b"),u=[],t=0;while(t<4){u[t]=s.cloneNode(g);u[t].style.backgroundColor=q;u[t].className="r"+(t+1);t++}s.className="round";if(p=="top"){t=0;while(t<4){s.appendChild(u[t]);t++}}else{if(p=="bottom"){t=3;while(t>=0){s.appendChild(u[t]);t--}}else{return}}return s}};function n(){if(m){h.body.appendChild(m)}o.removeChild(o.childNodes[2]);o.removeChild(o.childNodes[2])}return j})()};function i(k){k=k.substr(1);if(k.length==3){var j=k.split("");k="";for(var l=0;l<3;l++){k+=j[l]+j[l]}}k=parseInt(k,16);return[k>>16,k>>8&255,k&255]}c.ready(function(){c.evt.add(f,"resize",c.modal.reset);c.evt.on(h,"a","click",function(){var j=this.rel;if(j.indexOf("modal")==0){c.modal.show.apply(this,arguments)}else{if(j=="external"&&this.target!="_blank"){this.target="_blank"}}})});c.extend(String.prototype,{trim:function(){return this.replace(/^[\s\t\r\n]+|[\s\t\r\n]+$/g,"")}});c.extend(a,c);if(typeof f.JSON=="undefined"){f.JSON={stringify:function(m){if(!(m instanceof Object)){return}var j=(m instanceof Array),k=j?"[":"{";for(var l in m){if(m[l] instanceof Object){if(!j){k+='"'+l+'" : '}k+=JSON.stringify(m[l])+", "}else{if(typeof m[l]!="function"){if(!j){k+='"'+l+'" : '}k+='"'+m[l]+'", '}}}return k.substr(0,k.length-2)+(j?" ]":" }")},parse:function(j){if(typeof j!="string"){return}if(/^[\],:{}\s]*$/.test(j.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,""))){return f["eval"]("("+j+")")}else{return}}}}})(std={},window,document);