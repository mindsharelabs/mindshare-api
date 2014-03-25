/*this file is deprecated and being pahsed out */

/*ssb min */
(function (A, w) {
	function ma() {
		if (!c.isReady) {
			try {
				s.documentElement.doScroll("left")
			} catch (a) {
				setTimeout(ma, 1);
				return
			}
			c.ready()
		}
	}

	function Qa(a, b) {
		b.src ? c.ajax({url:b.src, async:false, dataType:"script"}) : c.globalEval(b.text || b.textContent || b.innerHTML || "");
		b.parentNode && b.parentNode.removeChild(b)
	}

	function X(a, b, d, f, e, j) {
		var i = a.length;
		if (typeof b === "object") {
			for (var o in b)X(a, o, b[o], f, e, d);
			return a
		}
		if (d !== w) {
			f = !j && f && c.isFunction(d);
			for (o = 0; o < i; o++)e(a[o], b, f ? d.call(a[o], o, e(a[o], b)) : d, j);
			return a
		}
		return i ? e(a[0], b) : w
	}

	function J() {
		return(new Date).getTime()
	}

	function Y() {
		return false
	}

	function Z() {
		return true
	}

	function na(a, b, d) {
		d[0].type = a;
		return c.event.handle.apply(b, d)
	}

	function oa(a) {
		var b, d = [], f = [], e = arguments, j, i, o, k, n, r;
		i = c.data(this, "events");
		if (!(a.liveFired === this || !i || !i.live || a.button && a.type === "click")) {
			a.liveFired = this;
			var u = i.live.slice(0);
			for (k = 0; k < u.length; k++) {
				i = u[k];
				i.origType.replace(O, "") === a.type ? f.push(i.selector) : u.splice(k--, 1)
			}
			j = c(a.target).closest(f, a.currentTarget);
			n = 0;
			for (r = j.length; n < r; n++)for (k = 0; k < u.length; k++) {
				i = u[k];
				if (j[n].selector === i.selector) {
					o = j[n].elem;
					f = null;
					if (i.preType === "mouseenter" || i.preType === "mouseleave")f = c(a.relatedTarget).closest(i.selector)[0];
					if (!f || f !== o)d.push({elem:o, handleObj:i})
				}
			}
			n = 0;
			for (r = d.length; n < r; n++) {
				j = d[n];
				a.currentTarget = j.elem;
				a.data = j.handleObj.data;
				a.handleObj = j.handleObj;
				if (j.handleObj.origHandler.apply(j.elem, e) === false) {
					b = false;
					break
				}
			}
			return b
		}
	}

	function pa(a, b) {
		return"live." + (a && a !== "*" ? a + "." : "") + b.replace(/\./g, "`").replace(/ /g, "&")
	}

	function qa(a) {
		return!a || !a.parentNode || a.parentNode.nodeType === 11
	}

	function ra(a, b) {
		var d = 0;
		b.each(function () {
			if (this.nodeName === (a[d] && a[d].nodeName)) {
				var f = c.data(a[d++]), e = c.data(this, f);
				if (f = f && f.events) {
					delete e.handle;
					e.events = {};
					for (var j in f)for (var i in f[j])c.event.add(this, j, f[j][i], f[j][i].data)
				}
			}
		})
	}

	function sa(a, b, d) {
		var f, e, j;
		b = b && b[0] ? b[0].ownerDocument || b[0] : s;
		if (a.length === 1 && typeof a[0] === "string" && a[0].length < 512 && b === s && !ta.test(a[0]) && (c.support.checkClone || !ua.test(a[0]))) {
			e = true;
			if (j = c.fragments[a[0]])if (j !== 1)f = j
		}
		if (!f) {
			f = b.createDocumentFragment();
			c.clean(a, b, f, d)
		}
		if (e)c.fragments[a[0]] = j ? f : 1;
		return{fragment:f, cacheable:e}
	}

	function K(a, b) {
		var d = {};
		c.each(va.concat.apply([], va.slice(0, b)), function () {
			d[this] = a
		});
		return d
	}

	function wa(a) {
		return"scrollTo"in a && a.document ? a : a.nodeType === 9 ? a.defaultView || a.parentWindow : false
	}

	var c = function (a, b) {
		return new c.fn.init(a, b)
	}, Ra = A.SsbBase, Sa = A.$, s = A.document, T, Ta = /^[^<]*(<[\w\W]+>)[^>]*$|^#([\w-]+)$/, Ua = /^.[^:#\[\.,]*$/, Va = /\S/, Wa = /^(\s|\u00A0)+|(\s|\u00A0)+$/g, Xa = /^<(\w+)\s*\/?>(?:<\/\1>)?$/, P = navigator.userAgent, xa = false, Q = [], L, $ = Object.prototype.toString, aa = Object.prototype.hasOwnProperty, ba = Array.prototype.push, R = Array.prototype.slice, ya = Array.prototype.indexOf;
	c.fn = c.prototype = {init:function (a, b) {
		var d, f;
		if (!a)return this;
		if (a.nodeType) {
			this.context = this[0] = a;
			this.length = 1;
			return this
		}
		if (a === "body" && !b) {
			this.context = s;
			this[0] = s.body;
			this.selector = "body";
			this.length = 1;
			return this
		}
		if (typeof a === "string")if ((d = Ta.exec(a)) && (d[1] || !b))if (d[1]) {
			f = b ? b.ownerDocument || b : s;
			if (a = Xa.exec(a))if (c.isPlainObject(b)) {
				a = [s.createElement(a[1])];
				c.fn.attr.call(a, b, true)
			} else a = [f.createElement(a[1])]; else {
				a = sa([d[1]], [f]);
				a = (a.cacheable ? a.fragment.cloneNode(true) : a.fragment).childNodes
			}
			return c.merge(this, a)
		} else {
			if (b = s.getElementById(d[2])) {
				if (b.id !== d[2])return T.find(a);
				this.length = 1;
				this[0] = b
			}
			this.context = s;
			this.selector = a;
			return this
		} else if (!b && /^\w+$/.test(a)) {
			this.selector = a;
			this.context = s;
			a = s.getElementsByTagName(a);
			return c.merge(this, a)
		} else return!b || b.SsbBase ? (b || T).find(a) : c(b).find(a); else if (c.isFunction(a))return T.ready(a);
		if (a.selector !== w) {
			this.selector = a.selector;
			this.context = a.context
		}
		return c.makeArray(a, this)
	}, selector:"", SsbBase:"1.4.2", length:0, size:function () {
		return this.length
	}, toArray:function () {
		return R.call(this, 0)
	}, get:function (a) {
		return a == null ? this.toArray() : a < 0 ? this.slice(a)[0] : this[a]
	}, pushStack:function (a, b, d) {
		var f = c();
		c.isArray(a) ? ba.apply(f, a) : c.merge(f, a);
		f.prevObject = this;
		f.context = this.context;
		if (b === "find")f.selector = this.selector + (this.selector ? " " : "") + d; else if (b)f.selector = this.selector + "." + b + "(" + d + ")";
		return f
	}, each:function (a, b) {
		return c.each(this, a, b)
	}, ready:function (a) {
		c.bindReady();
		if (c.isReady)a.call(s, c); else Q && Q.push(a);
		return this
	}, eq:function (a) {
		return a === -1 ? this.slice(a) : this.slice(a, +a + 1)
	}, first:function () {
		return this.eq(0)
	}, last:function () {
		return this.eq(-1)
	}, slice:function () {
		return this.pushStack(R.apply(this, arguments), "slice", R.call(arguments).join(","))
	}, map:function (a) {
		return this.pushStack(c.map(this, function (b, d) {
			return a.call(b, d, b)
		}))
	}, end:function () {
		return this.prevObject || c(null)
	}, push:ba, sort:[].sort, splice:[].splice};
	c.fn.init.prototype = c.fn;
	c.extend = c.fn.extend = function () {
		var a = arguments[0] || {}, b = 1, d = arguments.length, f = false, e, j, i, o;
		if (typeof a === "boolean") {
			f = a;
			a = arguments[1] || {};
			b = 2
		}
		if (typeof a !== "object" && !c.isFunction(a))a = {};
		if (d === b) {
			a = this;
			--b
		}
		for (; b < d; b++)if ((e = arguments[b]) != null)for (j in e) {
			i = a[j];
			o = e[j];
			if (a !== o)if (f && o && (c.isPlainObject(o) || c.isArray(o))) {
				i = i && (c.isPlainObject(i) || c.isArray(i)) ? i : c.isArray(o) ? [] : {};
				a[j] = c.extend(f, i, o)
			} else if (o !== w)a[j] = o
		}
		return a
	};
	c.extend({noConflict:function (a) {
		A.$ = Sa;
		if (a)A.SsbBase = Ra;
		return c
	}, isReady:false, ready:function () {
		if (!c.isReady) {
			if (!s.body)return setTimeout(c.ready, 13);
			c.isReady = true;
			if (Q) {
				for (var a, b = 0; a = Q[b++];)a.call(s, c);
				Q = null
			}
			c.fn.triggerHandler && c(s).triggerHandler("ready")
		}
	}, bindReady:function () {
		if (!xa) {
			xa = true;
			if (s.readyState === "complete")return c.ready();
			if (s.addEventListener) {
				s.addEventListener("DOMContentLoaded", L, false);
				A.addEventListener("load", c.ready, false)
			} else if (s.attachEvent) {
				s.attachEvent("onreadystatechange", L);
				A.attachEvent("onload", c.ready);
				var a = false;
				try {
					a = A.frameElement == null
				} catch (b) {
				}
				s.documentElement.doScroll && a && ma()
			}
		}
	}, isFunction:function (a) {
		return $.call(a) === "[object Function]"
	}, isArray:function (a) {
		return $.call(a) === "[object Array]"
	}, isPlainObject:function (a) {
		if (!a || $.call(a) !== "[object Object]" || a.nodeType || a.setInterval)return false;
		if (a.constructor && !aa.call(a, "constructor") && !aa.call(a.constructor.prototype, "isPrototypeOf"))return false;
		var b;
		for (b in a);
		return b === w || aa.call(a, b)
	}, isEmptyObject:function (a) {
		for (var b in a)return false;
		return true
	}, error:function (a) {
		throw a;
	}, parseJSON:function (a) {
		if (typeof a !== "string" || !a)return null;
		a = c.trim(a);
		if (/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, "")))return A.JSON && A.JSON.parse ? A.JSON.parse(a) : (new Function("return " + a))(); else c.error("Invalid JSON: " + a)
	}, noop:function () {
	}, globalEval:function (a) {
		if (a && Va.test(a)) {
			var b = s.getElementsByTagName("head")[0] || s.documentElement, d = s.createElement("script");
			d.type = "text/javascript";
			if (c.support.scriptEval)d.appendChild(s.createTextNode(a)); else d.text = a;
			b.insertBefore(d, b.firstChild);
			b.removeChild(d)
		}
	}, nodeName:function (a, b) {
		return a.nodeName && a.nodeName.toUpperCase() === b.toUpperCase()
	}, each:function (a, b, d) {
		var f, e = 0, j = a.length, i = j === w || c.isFunction(a);
		if (d)if (i)for (f in a) {
			if (b.apply(a[f], d) === false)break
		} else for (; e < j;) {
			if (b.apply(a[e++], d) === false)break
		} else if (i)for (f in a) {
			if (b.call(a[f], f, a[f]) === false)break
		} else for (d = a[0]; e < j && b.call(d, e, d) !== false; d = a[++e]);
		return a
	}, trim:function (a) {
		return(a || "").replace(Wa, "")
	}, makeArray:function (a, b) {
		b = b || [];
		if (a != null)a.length == null || typeof a === "string" || c.isFunction(a) || typeof a !== "function" && a.setInterval ? ba.call(b, a) : c.merge(b, a);
		return b
	}, inArray:function (a, b) {
		if (b.indexOf)return b.indexOf(a);
		for (var d = 0, f = b.length; d < f; d++)if (b[d] === a)return d;
		return-1
	}, merge:function (a, b) {
		var d = a.length, f = 0;
		if (typeof b.length === "number")for (var e = b.length; f < e; f++)a[d++] = b[f]; else for (; b[f] !== w;)a[d++] = b[f++];
		a.length = d;
		return a
	}, grep:function (a, b, d) {
		for (var f = [], e = 0, j = a.length; e < j; e++)!d !== !b(a[e], e) && f.push(a[e]);
		return f
	}, map:function (a, b, d) {
		for (var f = [], e, j = 0, i = a.length; j < i; j++) {
			e = b(a[j], j, d);
			if (e != null)f[f.length] = e
		}
		return f.concat.apply([], f)
	}, guid:1, proxy:function (a, b, d) {
		if (arguments.length === 2)if (typeof b === "string") {
			d = a;
			a = d[b];
			b = w
		} else if (b && !c.isFunction(b)) {
			d = b;
			b = w
		}
		if (!b && a)b = function () {
			return a.apply(d || this, arguments)
		};
		if (a)b.guid = a.guid = a.guid || b.guid || c.guid++;
		return b
	}, uaMatch:function (a) {
		a = a.toLowerCase();
		a = /(webkit)[ \/]([\w.]+)/.exec(a) || /(opera)(?:.*version)?[ \/]([\w.]+)/.exec(a) || /(msie) ([\w.]+)/.exec(a) || !/compatible/.test(a) && /(mozilla)(?:.*? rv:([\w.]+))?/.exec(a) || [];
		return{browser:a[1] || "", version:a[2] || "0"}
	}, browser:{}});
	P = c.uaMatch(P);
	if (P.browser) {
		c.browser[P.browser] = true;
		c.browser.version = P.version
	}
	if (c.browser.webkit)c.browser.safari = true;
	if (ya)c.inArray = function (a, b) {
		return ya.call(b, a)
	};
	T = c(s);
	if (s.addEventListener)L = function () {
		s.removeEventListener("DOMContentLoaded", L, false);
		c.ready()
	}; else if (s.attachEvent)L = function () {
		if (s.readyState === "complete") {
			s.detachEvent("onreadystatechange", L);
			c.ready()
		}
	};
	(function () {
		c.support = {};
		var a = s.documentElement, b = s.createElement("script"), d = s.createElement("div"), f = "script" + J();
		d.style.display = "none";
		d.innerHTML = "   <link/><table></table><a href='/a' style='color:red;float:left;opacity:.55;'>a</a><input type='checkbox'/>";
		var e = d.getElementsByTagName("*"), j = d.getElementsByTagName("a")[0];
		if (!(!e || !e.length || !j)) {
			c.support = {leadingWhitespace:d.firstChild.nodeType === 3, tbody:!d.getElementsByTagName("tbody").length, htmlSerialize:!!d.getElementsByTagName("link").length, style:/red/.test(j.getAttribute("style")), hrefNormalized:j.getAttribute("href") === "/a", opacity:/^0.55$/.test(j.style.opacity), cssFloat:!!j.style.cssFloat, checkOn:d.getElementsByTagName("input")[0].value === "on", optSelected:s.createElement("select").appendChild(s.createElement("option")).selected, parentNode:d.removeChild(d.appendChild(s.createElement("div"))).parentNode === null, deleteExpando:true, checkClone:false, scriptEval:false, noCloneEvent:true, boxModel:null};
			b.type = "text/javascript";
			try {
				b.appendChild(s.createTextNode("window." + f + "=1;"))
			} catch (i) {
			}
			a.insertBefore(b, a.firstChild);
			if (A[f]) {
				c.support.scriptEval = true;
				delete A[f]
			}
			try {
				delete b.test
			} catch (o) {
				c.support.deleteExpando = false
			}
			a.removeChild(b);
			if (d.attachEvent && d.fireEvent) {
				d.attachEvent("onclick", function k() {
					c.support.noCloneEvent = false;
					d.detachEvent("onclick", k)
				});
				d.cloneNode(true).fireEvent("onclick")
			}
			d = s.createElement("div");
			d.innerHTML = "<input type='radio' name='radiotest' checked='checked'/>";
			a = s.createDocumentFragment();
			a.appendChild(d.firstChild);
			c.support.checkClone = a.cloneNode(true).cloneNode(true).lastChild.checked;
			c(function () {
				var k = s.createElement("div");
				k.style.width = k.style.paddingLeft = "1px";
				s.body.appendChild(k);
				c.boxModel = c.support.boxModel = k.offsetWidth === 2;
				s.body.removeChild(k).style.display = "none"
			});
			a = function (k) {
				var n = s.createElement("div");
				k = "on" + k;
				var r = k in n;
				if (!r) {
					n.setAttribute(k, "return;");
					r = typeof n[k] === "function"
				}
				return r
			};
			c.support.submitBubbles = a("submit");
			c.support.changeBubbles = a("change");
			a = b = d = e = j = null
		}
	})();
	c.props = {"for":"htmlFor", "class":"className", readonly:"readOnly", maxlength:"maxLength", cellspacing:"cellSpacing", rowspan:"rowSpan", colspan:"colSpan", tabindex:"tabIndex", usemap:"useMap", frameborder:"frameBorder"};
	var G = "SsbBase" + J(), Ya = 0, za = {};
	c.extend({cache:{}, expando:G, noData:{embed:true, object:true, applet:true}, data:function (a, b, d) {
		if (!(a.nodeName && c.noData[a.nodeName.toLowerCase()])) {
			a = a == A ? za : a;
			var f = a[G], e = c.cache;
			if (!f && typeof b === "string" && d === w)return null;
			f || (f = ++Ya);
			if (typeof b === "object") {
				a[G] = f;
				e[f] = c.extend(true, {}, b)
			} else if (!e[f]) {
				a[G] = f;
				e[f] = {}
			}
			a = e[f];
			if (d !== w)a[b] = d;
			return typeof b === "string" ? a[b] : a
		}
	}, removeData:function (a, b) {
		if (!(a.nodeName && c.noData[a.nodeName.toLowerCase()])) {
			a = a == A ? za : a;
			var d = a[G], f = c.cache, e = f[d];
			if (b) {
				if (e) {
					delete e[b];
					c.isEmptyObject(e) && c.removeData(a)
				}
			} else {
				if (c.support.deleteExpando)delete a[c.expando]; else a.removeAttribute && a.removeAttribute(c.expando);
				delete f[d]
			}
		}
	}});
	c.fn.extend({data:function (a, b) {
		if (typeof a === "undefined" && this.length)return c.data(this[0]); else if (typeof a === "object")return this.each(function () {
			c.data(this, a)
		});
		var d = a.split(".");
		d[1] = d[1] ? "." + d[1] : "";
		if (b === w) {
			var f = this.triggerHandler("getData" + d[1] + "!", [d[0]]);
			if (f === w && this.length)f = c.data(this[0], a);
			return f === w && d[1] ? this.data(d[0]) : f
		} else return this.trigger("setData" + d[1] + "!", [d[0], b]).each(function () {
			c.data(this, a, b)
		})
	}, removeData:function (a) {
		return this.each(function () {
			c.removeData(this, a)
		})
	}});
	c.extend({queue:function (a, b, d) {
		if (a) {
			b = (b || "fx") + "queue";
			var f = c.data(a, b);
			if (!d)return f || [];
			if (!f || c.isArray(d))f = c.data(a, b, c.makeArray(d)); else f.push(d);
			return f
		}
	}, dequeue:function (a, b) {
		b = b || "fx";
		var d = c.queue(a, b), f = d.shift();
		if (f === "inprogress")f = d.shift();
		if (f) {
			b === "fx" && d.unshift("inprogress");
			f.call(a, function () {
				c.dequeue(a, b)
			})
		}
	}});
	c.fn.extend({queue:function (a, b) {
		if (typeof a !== "string") {
			b = a;
			a = "fx"
		}
		if (b === w)return c.queue(this[0], a);
		return this.each(function () {
			var d = c.queue(this, a, b);
			a === "fx" && d[0] !== "inprogress" && c.dequeue(this, a)
		})
	}, dequeue:function (a) {
		return this.each(function () {
			c.dequeue(this, a)
		})
	}, delay:function (a, b) {
		a = c.fx ? c.fx.speeds[a] || a : a;
		b = b || "fx";
		return this.queue(b, function () {
			var d = this;
			setTimeout(function () {
				c.dequeue(d, b)
			}, a)
		})
	}, clearQueue:function (a) {
		return this.queue(a || "fx", [])
	}});
	var Aa = /[\n\t]/g, ca = /\s+/, Za = /\r/g, $a = /href|src|style/, ab = /(button|input)/i, bb = /(button|input|object|select|textarea)/i, cb = /^(a|area)$/i, Ba = /radio|checkbox/;
	c.fn.extend({attr:function (a, b) {
		return X(this, a, b, true, c.attr)
	}, removeAttr:function (a) {
		return this.each(function () {
			c.attr(this, a, "");
			this.nodeType === 1 && this.removeAttribute(a)
		})
	}, addClass:function (a) {
		if (c.isFunction(a))return this.each(function (n) {
			var r = c(this);
			r.addClass(a.call(this, n, r.attr("class")))
		});
		if (a && typeof a === "string")for (var b = (a || "").split(ca), d = 0, f = this.length; d < f; d++) {
			var e = this[d];
			if (e.nodeType === 1)if (e.className) {
				for (var j = " " + e.className + " ", i = e.className, o = 0, k = b.length; o < k; o++)if (j.indexOf(" " + b[o] + " ") < 0)i += " " + b[o];
				e.className = c.trim(i)
			} else e.className = a
		}
		return this
	}, removeClass:function (a) {
		if (c.isFunction(a))return this.each(function (k) {
			var n = c(this);
			n.removeClass(a.call(this, k, n.attr("class")))
		});
		if (a && typeof a === "string" || a === w)for (var b = (a || "").split(ca), d = 0, f = this.length; d < f; d++) {
			var e = this[d];
			if (e.nodeType === 1 && e.className)if (a) {
				for (var j = (" " + e.className + " ").replace(Aa, " "), i = 0, o = b.length; i < o; i++)j = j.replace(" " + b[i] + " ", " ");
				e.className = c.trim(j)
			} else e.className = ""
		}
		return this
	}, toggleClass:function (a, b) {
		var d = typeof a, f = typeof b === "boolean";
		if (c.isFunction(a))return this.each(function (e) {
			var j = c(this);
			j.toggleClass(a.call(this, e, j.attr("class"), b), b)
		});
		return this.each(function () {
			if (d === "string")for (var e, j = 0, i = c(this), o = b, k = a.split(ca); e = k[j++];) {
				o = f ? o : !i.hasClass(e);
				i[o ? "addClass" : "removeClass"](e)
			} else if (d === "undefined" || d === "boolean") {
				this.className && c.data(this, "__className__", this.className);
				this.className = this.className || a === false ? "" : c.data(this, "__className__") || ""
			}
		})
	}, hasClass:function (a) {
		a = " " + a + " ";
		for (var b = 0, d = this.length; b < d; b++)if ((" " + this[b].className + " ").replace(Aa, " ").indexOf(a) > -1)return true;
		return false
	}, val:function (a) {
		if (a === w) {
			var b = this[0];
			if (b) {
				if (c.nodeName(b, "option"))return(b.attributes.value || {}).specified ? b.value : b.text;
				if (c.nodeName(b, "select")) {
					var d = b.selectedIndex, f = [], e = b.options;
					b = b.type === "select-one";
					if (d < 0)return null;
					var j = b ? d : 0;
					for (d = b ? d + 1 : e.length; j < d; j++) {
						var i = e[j];
						if (i.selected) {
							a = c(i).val();
							if (b)return a;
							f.push(a)
						}
					}
					return f
				}
				if (Ba.test(b.type) && !c.support.checkOn)return b.getAttribute("value") === null ? "on" : b.value;
				return(b.value || "").replace(Za, "")
			}
			return w
		}
		var o = c.isFunction(a);
		return this.each(function (k) {
			var n = c(this), r = a;
			if (this.nodeType === 1) {
				if (o)r = a.call(this, k, n.val());
				if (typeof r === "number")r += "";
				if (c.isArray(r) && Ba.test(this.type))this.checked = c.inArray(n.val(), r) >= 0; else if (c.nodeName(this, "select")) {
					var u = c.makeArray(r);
					c("option", this).each(function () {
						this.selected = c.inArray(c(this).val(), u) >= 0
					});
					if (!u.length)this.selectedIndex = -1
				} else this.value = r
			}
		})
	}});
	c.extend({attrFn:{val:true, css:true, html:true, text:true, data:true, width:true, height:true, offset:true}, attr:function (a, b, d, f) {
		if (!a || a.nodeType === 3 || a.nodeType === 8)return w;
		if (f && b in c.attrFn)return c(a)[b](d);
		f = a.nodeType !== 1 || !c.isXMLDoc(a);
		var e = d !== w;
		b = f && c.props[b] || b;
		if (a.nodeType === 1) {
			var j = $a.test(b);
			if (b in a && f && !j) {
				if (e) {
					b === "type" && ab.test(a.nodeName) && a.parentNode && c.error("type property can't be changed");
					a[b] = d
				}
				if (c.nodeName(a, "form") && a.getAttributeNode(b))return a.getAttributeNode(b).nodeValue;
				if (b === "tabIndex")return(b = a.getAttributeNode("tabIndex")) && b.specified ? b.value : bb.test(a.nodeName) || cb.test(a.nodeName) && a.href ? 0 : w;
				return a[b]
			}
			if (!c.support.style && f && b === "style") {
				if (e)a.style.cssText = "" + d;
				return a.style.cssText
			}
			e && a.setAttribute(b, "" + d);
			a = !c.support.hrefNormalized && f && j ? a.getAttribute(b, 2) : a.getAttribute(b);
			return a === null ? w : a
		}
		return c.style(a, b, d)
	}});
	var O = /\.(.*)$/, db = function (a) {
		return a.replace(/[^\w\s\.\|`]/g, function (b) {
			return"\\" + b
		})
	};
	c.event = {add:function (a, b, d, f) {
		if (!(a.nodeType === 3 || a.nodeType === 8)) {
			if (a.setInterval && a !== A && !a.frameElement)a = A;
			var e, j;
			if (d.handler) {
				e = d;
				d = e.handler
			}
			if (!d.guid)d.guid = c.guid++;
			if (j = c.data(a)) {
				var i = j.events = j.events || {}, o = j.handle;
				if (!o)j.handle = o = function () {
					return typeof c !== "undefined" && !c.event.triggered ? c.event.handle.apply(o.elem, arguments) : w
				};
				o.elem = a;
				b = b.split(" ");
				for (var k, n = 0, r; k = b[n++];) {
					j = e ? c.extend({}, e) : {handler:d, data:f};
					if (k.indexOf(".") > -1) {
						r = k.split(".");
						k = r.shift();
						j.namespace = r.slice(0).sort().join(".")
					} else {
						r = [];
						j.namespace = ""
					}
					j.type = k;
					j.guid = d.guid;
					var u = i[k], z = c.event.special[k] || {};
					if (!u) {
						u = i[k] = [];
						if (!z.setup || z.setup.call(a, f, r, o) === false)if (a.addEventListener)a.addEventListener(k, o, false); else a.attachEvent && a.attachEvent("on" + k, o)
					}
					if (z.add) {
						z.add.call(a, j);
						if (!j.handler.guid)j.handler.guid = d.guid
					}
					u.push(j);
					c.event.global[k] = true
				}
				a = null
			}
		}
	}, global:{}, remove:function (a, b, d, f) {
		if (!(a.nodeType === 3 || a.nodeType === 8)) {
			var e, j = 0, i, o, k, n, r, u, z = c.data(a), C = z && z.events;
			if (z && C) {
				if (b && b.type) {
					d = b.handler;
					b = b.type
				}
				if (!b || typeof b === "string" && b.charAt(0) === ".") {
					b = b || "";
					for (e in C)c.event.remove(a, e + b)
				} else {
					for (b = b.split(" "); e = b[j++];) {
						n = e;
						i = e.indexOf(".") < 0;
						o = [];
						if (!i) {
							o = e.split(".");
							e = o.shift();
							k = new RegExp("(^|\\.)" + c.map(o.slice(0).sort(), db).join("\\.(?:.*\\.)?") + "(\\.|$)")
						}
						if (r = C[e])if (d) {
							n = c.event.special[e] || {};
							for (B = f || 0; B < r.length; B++) {
								u = r[B];
								if (d.guid === u.guid) {
									if (i || k.test(u.namespace)) {
										f == null && r.splice(B--, 1);
										n.remove && n.remove.call(a, u)
									}
									if (f != null)break
								}
							}
							if (r.length === 0 || f != null && r.length === 1) {
								if (!n.teardown || n.teardown.call(a, o) === false)Ca(a, e, z.handle);
								delete C[e]
							}
						} else for (var B = 0; B < r.length; B++) {
							u = r[B];
							if (i || k.test(u.namespace)) {
								c.event.remove(a, n, u.handler, B);
								r.splice(B--, 1)
							}
						}
					}
					if (c.isEmptyObject(C)) {
						if (b = z.handle)b.elem = null;
						delete z.events;
						delete z.handle;
						c.isEmptyObject(z) && c.removeData(a)
					}
				}
			}
		}
	}, trigger:function (a, b, d, f) {
		var e = a.type || a;
		if (!f) {
			a = typeof a === "object" ? a[G] ? a : c.extend(c.Event(e), a) : c.Event(e);
			if (e.indexOf("!") >= 0) {
				a.type = e = e.slice(0, -1);
				a.exclusive = true
			}
			if (!d) {
				a.stopPropagation();
				c.event.global[e] && c.each(c.cache, function () {
					this.events && this.events[e] && c.event.trigger(a, b, this.handle.elem)
				})
			}
			if (!d || d.nodeType === 3 || d.nodeType === 8)return w;
			a.result = w;
			a.target = d;
			b = c.makeArray(b);
			b.unshift(a)
		}
		a.currentTarget = d;
		(f = c.data(d, "handle")) && f.apply(d, b);
		f = d.parentNode || d.ownerDocument;
		try {
			if (!(d && d.nodeName && c.noData[d.nodeName.toLowerCase()]))if (d["on" + e] && d["on" + e].apply(d, b) === false)a.result = false
		} catch (j) {
		}
		if (!a.isPropagationStopped() && f)c.event.trigger(a, b, f, true); else if (!a.isDefaultPrevented()) {
			f = a.target;
			var i, o = c.nodeName(f, "a") && e === "click", k = c.event.special[e] || {};
			if ((!k._default || k._default.call(d, a) === false) && !o && !(f && f.nodeName && c.noData[f.nodeName.toLowerCase()])) {
				try {
					if (f[e]) {
						if (i = f["on" + e])f["on" + e] = null;
						c.event.triggered = true;
						f[e]()
					}
				} catch (n) {
				}
				if (i)f["on" + e] = i;
				c.event.triggered = false
			}
		}
	}, handle:function (a) {
		var b, d, f, e;
		a = arguments[0] = c.event.fix(a || A.event);
		a.currentTarget = this;
		b = a.type.indexOf(".") < 0 && !a.exclusive;
		if (!b) {
			d = a.type.split(".");
			a.type = d.shift();
			f = new RegExp("(^|\\.)" + d.slice(0).sort().join("\\.(?:.*\\.)?") + "(\\.|$)")
		}
		e = c.data(this, "events");
		d = e[a.type];
		if (e && d) {
			d = d.slice(0);
			e = 0;
			for (var j = d.length; e < j; e++) {
				var i = d[e];
				if (b || f.test(i.namespace)) {
					a.handler = i.handler;
					a.data = i.data;
					a.handleObj = i;
					i = i.handler.apply(this, arguments);
					if (i !== w) {
						a.result = i;
						if (i === false) {
							a.preventDefault();
							a.stopPropagation()
						}
					}
					if (a.isImmediatePropagationStopped())break
				}
			}
		}
		return a.result
	}, props:"altKey attrChange attrName bubbles button cancelable charCode clientX clientY ctrlKey currentTarget data detail eventPhase fromElement handler keyCode layerX layerY metaKey newValue offsetX offsetY originalTarget pageX pageY prevValue relatedNode relatedTarget screenX screenY shiftKey srcElement target toElement view wheelDelta which".split(" "), fix:function (a) {
		if (a[G])return a;
		var b = a;
		a = c.Event(b);
		for (var d = this.props.length, f; d;) {
			f = this.props[--d];
			a[f] = b[f]
		}
		if (!a.target)a.target = a.srcElement || s;
		if (a.target.nodeType === 3)a.target = a.target.parentNode;
		if (!a.relatedTarget && a.fromElement)a.relatedTarget = a.fromElement === a.target ? a.toElement : a.fromElement;
		if (a.pageX == null && a.clientX != null) {
			b = s.documentElement;
			d = s.body;
			a.pageX = a.clientX + (b && b.scrollLeft || d && d.scrollLeft || 0) - (b && b.clientLeft || d && d.clientLeft || 0);
			a.pageY = a.clientY + (b && b.scrollTop || d && d.scrollTop || 0) - (b && b.clientTop || d && d.clientTop || 0)
		}
		if (!a.which && (a.charCode || a.charCode === 0 ? a.charCode : a.keyCode))a.which = a.charCode || a.keyCode;
		if (!a.metaKey && a.ctrlKey)a.metaKey = a.ctrlKey;
		if (!a.which && a.button !== w)a.which = a.button & 1 ? 1 : a.button & 2 ? 3 : a.button & 4 ? 2 : 0;
		return a
	}, guid:1E8, proxy:c.proxy, special:{ready:{setup:c.bindReady, teardown:c.noop}, live:{add:function (a) {
		c.event.add(this, a.origType, c.extend({}, a, {handler:oa}))
	}, remove:function (a) {
		var b = true, d = a.origType.replace(O, "");
		c.each(c.data(this, "events").live || [], function () {
			if (d === this.origType.replace(O, ""))return b = false
		});
		b && c.event.remove(this, a.origType, oa)
	}}, beforeunload:{setup:function (a, b, d) {
		if (this.setInterval)this.onbeforeunload = d;
		return false
	}, teardown:function (a, b) {
		if (this.onbeforeunload === b)this.onbeforeunload = null
	}}}};
	var Ca = s.removeEventListener ? function (a, b, d) {
		a.removeEventListener(b, d, false)
	} : function (a, b, d) {
		a.detachEvent("on" + b, d)
	};
	c.Event = function (a) {
		if (!this.preventDefault)return new c.Event(a);
		if (a && a.type) {
			this.originalEvent = a;
			this.type = a.type
		} else this.type = a;
		this.timeStamp = J();
		this[G] = true
	};
	c.Event.prototype = {preventDefault:function () {
		this.isDefaultPrevented = Z;
		var a = this.originalEvent;
		if (a) {
			a.preventDefault && a.preventDefault();
			a.returnValue = false
		}
	}, stopPropagation:function () {
		this.isPropagationStopped = Z;
		var a = this.originalEvent;
		if (a) {
			a.stopPropagation && a.stopPropagation();
			a.cancelBubble = true
		}
	}, stopImmediatePropagation:function () {
		this.isImmediatePropagationStopped = Z;
		this.stopPropagation()
	}, isDefaultPrevented:Y, isPropagationStopped:Y, isImmediatePropagationStopped:Y};
	var Da = function (a) {
		var b = a.relatedTarget;
		try {
			for (; b && b !== this;)b = b.parentNode;
			if (b !== this) {
				a.type = a.data;
				c.event.handle.apply(this, arguments)
			}
		} catch (d) {
		}
	}, Ea = function (a) {
		a.type = a.data;
		c.event.handle.apply(this, arguments)
	};
	c.each({mouseenter:"mouseover", mouseleave:"mouseout"}, function (a, b) {
		c.event.special[a] = {setup:function (d) {
			c.event.add(this, b, d && d.selector ? Ea : Da, a)
		}, teardown:function (d) {
			c.event.remove(this, b, d && d.selector ? Ea : Da)
		}}
	});
	if (!c.support.submitBubbles)c.event.special.submit = {setup:function () {
		if (this.nodeName.toLowerCase() !== "form") {
			c.event.add(this, "click.specialSubmit", function (a) {
				var b = a.target, d = b.type;
				if ((d === "submit" || d === "image") && c(b).closest("form").length)return na("submit", this, arguments)
			});
			c.event.add(this, "keypress.specialSubmit", function (a) {
				var b = a.target, d = b.type;
				if ((d === "text" || d === "password") && c(b).closest("form").length && a.keyCode === 13)return na("submit", this, arguments)
			})
		} else return false
	}, teardown:function () {
		c.event.remove(this, ".specialSubmit")
	}};
	if (!c.support.changeBubbles) {
		var da = /textarea|input|select/i, ea, Fa = function (a) {
			var b = a.type, d = a.value;
			if (b === "radio" || b === "checkbox")d = a.checked; else if (b === "select-multiple")d = a.selectedIndex > -1 ? c.map(a.options,function (f) {
				return f.selected
			}).join("-") : ""; else if (a.nodeName.toLowerCase() === "select")d = a.selectedIndex;
			return d
		}, fa = function (a, b) {
			var d = a.target, f, e;
			if (!(!da.test(d.nodeName) || d.readOnly)) {
				f = c.data(d, "_change_data");
				e = Fa(d);
				if (a.type !== "focusout" || d.type !== "radio")c.data(d, "_change_data", e);
				if (!(f === w || e === f))if (f != null || e) {
					a.type = "change";
					return c.event.trigger(a, b, d)
				}
			}
		};
		c.event.special.change = {filters:{focusout:fa, click:function (a) {
			var b = a.target, d = b.type;
			if (d === "radio" || d === "checkbox" || b.nodeName.toLowerCase() === "select")return fa.call(this, a)
		}, keydown:function (a) {
			var b = a.target, d = b.type;
			if (a.keyCode === 13 && b.nodeName.toLowerCase() !== "textarea" || a.keyCode === 32 && (d === "checkbox" || d === "radio") || d === "select-multiple")return fa.call(this, a)
		}, beforeactivate:function (a) {
			a = a.target;
			c.data(a, "_change_data", Fa(a))
		}}, setup:function () {
			if (this.type === "file")return false;
			for (var a in ea)c.event.add(this, a + ".specialChange", ea[a]);
			return da.test(this.nodeName)
		}, teardown:function () {
			c.event.remove(this, ".specialChange");
			return da.test(this.nodeName)
		}};
		ea = c.event.special.change.filters
	}
	s.addEventListener && c.each({focus:"focusin", blur:"focusout"}, function (a, b) {
		function d(f) {
			f = c.event.fix(f);
			f.type = b;
			return c.event.handle.call(this, f)
		}

		c.event.special[b] = {setup:function () {
			this.addEventListener(a, d, true)
		}, teardown:function () {
			this.removeEventListener(a, d, true)
		}}
	});
	c.each(["bind", "one"], function (a, b) {
		c.fn[b] = function (d, f, e) {
			if (typeof d === "object") {
				for (var j in d)this[b](j, f, d[j], e);
				return this
			}
			if (c.isFunction(f)) {
				e = f;
				f = w
			}
			var i = b === "one" ? c.proxy(e, function (k) {
				c(this).unbind(k, i);
				return e.apply(this, arguments)
			}) : e;
			if (d === "unload" && b !== "one")this.one(d, f, e); else {
				j = 0;
				for (var o = this.length; j < o; j++)c.event.add(this[j], d, i, f)
			}
			return this
		}
	});
	c.fn.extend({unbind:function (a, b) {
		if (typeof a === "object" && !a.preventDefault)for (var d in a)this.unbind(d, a[d]); else {
			d = 0;
			for (var f = this.length; d < f; d++)c.event.remove(this[d], a, b)
		}
		return this
	}, delegate:function (a, b, d, f) {
		return this.live(b, d, f, a)
	}, undelegate:function (a, b, d) {
		return arguments.length === 0 ? this.unbind("live") : this.die(b, null, d, a)
	}, trigger:function (a, b) {
		return this.each(function () {
			c.event.trigger(a, b, this)
		})
	}, triggerHandler:function (a, b) {
		if (this[0]) {
			a = c.Event(a);
			a.preventDefault();
			a.stopPropagation();
			c.event.trigger(a, b, this[0]);
			return a.result
		}
	}, toggle:function (a) {
		for (var b = arguments, d = 1; d < b.length;)c.proxy(a, b[d++]);
		return this.click(c.proxy(a, function (f) {
			var e = (c.data(this, "lastToggle" + a.guid) || 0) % d;
			c.data(this, "lastToggle" + a.guid, e + 1);
			f.preventDefault();
			return b[e].apply(this, arguments) || false
		}))
	}, hover:function (a, b) {
		return this.mouseenter(a).mouseleave(b || a)
	}});
	var Ga = {focus:"focusin", blur:"focusout", mouseenter:"mouseover", mouseleave:"mouseout"};
	c.each(["live", "die"], function (a, b) {
		c.fn[b] = function (d, f, e, j) {
			var i, o = 0, k, n, r = j || this.selector, u = j ? this : c(this.context);
			if (c.isFunction(f)) {
				e = f;
				f = w
			}
			for (d = (d || "").split(" "); (i = d[o++]) != null;) {
				j = O.exec(i);
				k = "";
				if (j) {
					k = j[0];
					i = i.replace(O, "")
				}
				if (i === "hover")d.push("mouseenter" + k, "mouseleave" + k); else {
					n = i;
					if (i === "focus" || i === "blur") {
						d.push(Ga[i] + k);
						i += k
					} else i = (Ga[i] || i) + k;
					b === "live" ? u.each(function () {
						c.event.add(this, pa(i, r), {data:f, selector:r, handler:e, origType:i, origHandler:e, preType:n})
					}) : u.unbind(pa(i, r), e)
				}
			}
			return this
		}
	});
	c.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error".split(" "), function (a, b) {
		c.fn[b] = function (d) {
			return d ? this.bind(b, d) : this.trigger(b)
		};
		if (c.attrFn)c.attrFn[b] = true
	});
	A.attachEvent && !A.addEventListener && A.attachEvent("onunload", function () {
		for (var a in c.cache)if (c.cache[a].handle)try {
			c.event.remove(c.cache[a].handle.elem)
		} catch (b) {
		}
	});
	(function () {
		function a(g) {
			for (var h = "", l, m = 0; g[m]; m++) {
				l = g[m];
				if (l.nodeType === 3 || l.nodeType === 4)h += l.nodeValue; else if (l.nodeType !== 8)h += a(l.childNodes)
			}
			return h
		}

		function b(g, h, l, m, q, p) {
			q = 0;
			for (var v = m.length; q < v; q++) {
				var t = m[q];
				if (t) {
					t = t[g];
					for (var y = false; t;) {
						if (t.sizcache === l) {
							y = m[t.sizset];
							break
						}
						if (t.nodeType === 1 && !p) {
							t.sizcache = l;
							t.sizset = q
						}
						if (t.nodeName.toLowerCase() === h) {
							y = t;
							break
						}
						t = t[g]
					}
					m[q] = y
				}
			}
		}

		function d(g, h, l, m, q, p) {
			q = 0;
			for (var v = m.length; q < v; q++) {
				var t = m[q];
				if (t) {
					t = t[g];
					for (var y = false; t;) {
						if (t.sizcache === l) {
							y = m[t.sizset];
							break
						}
						if (t.nodeType === 1) {
							if (!p) {
								t.sizcache = l;
								t.sizset = q
							}
							if (typeof h !== "string") {
								if (t === h) {
									y = true;
									break
								}
							} else if (k.filter(h, [t]).length > 0) {
								y = t;
								break
							}
						}
						t = t[g]
					}
					m[q] = y
				}
			}
		}

		var f = /((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^[\]]*\]|['"][^'"]*['"]|[^[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g, e = 0, j = Object.prototype.toString, i = false, o = true;
		[0, 0].sort(function () {
			o = false;
			return 0
		});
		var k = function (g, h, l, m) {
			l = l || [];
			var q = h = h || s;
			if (h.nodeType !== 1 && h.nodeType !== 9)return[];
			if (!g || typeof g !== "string")return l;
			for (var p = [], v, t, y, S, H = true, M = x(h), I = g; (f.exec(""), v = f.exec(I)) !== null;) {
				I = v[3];
				p.push(v[1]);
				if (v[2]) {
					S = v[3];
					break
				}
			}
			if (p.length > 1 && r.exec(g))if (p.length === 2 && n.relative[p[0]])t = ga(p[0] + p[1], h); else for (t = n.relative[p[0]] ? [h] : k(p.shift(), h); p.length;) {
				g = p.shift();
				if (n.relative[g])g += p.shift();
				t = ga(g, t)
			} else {
				if (!m && p.length > 1 && h.nodeType === 9 && !M && n.match.ID.test(p[0]) && !n.match.ID.test(p[p.length - 1])) {
					v = k.find(p.shift(), h, M);
					h = v.expr ? k.filter(v.expr, v.set)[0] : v.set[0]
				}
				if (h) {
					v = m ? {expr:p.pop(), set:z(m)} : k.find(p.pop(), p.length === 1 && (p[0] === "~" || p[0] === "+") && h.parentNode ? h.parentNode : h, M);
					t = v.expr ? k.filter(v.expr, v.set) : v.set;
					if (p.length > 0)y = z(t); else H = false;
					for (; p.length;) {
						var D = p.pop();
						v = D;
						if (n.relative[D])v = p.pop(); else D = "";
						if (v == null)v = h;
						n.relative[D](y, v, M)
					}
				} else y = []
			}
			y || (y = t);
			y || k.error(D || g);
			if (j.call(y) === "[object Array]")if (H)if (h && h.nodeType === 1)for (g = 0; y[g] != null; g++) {
				if (y[g] && (y[g] === true || y[g].nodeType === 1 && E(h, y[g])))l.push(t[g])
			} else for (g = 0; y[g] != null; g++)y[g] && y[g].nodeType === 1 && l.push(t[g]); else l.push.apply(l, y); else z(y, l);
			if (S) {
				k(S, q, l, m);
				k.uniqueSort(l)
			}
			return l
		};
		k.uniqueSort = function (g) {
			if (B) {
				i = o;
				g.sort(B);
				if (i)for (var h = 1; h < g.length; h++)g[h] === g[h - 1] && g.splice(h--, 1)
			}
			return g
		};
		k.matches = function (g, h) {
			return k(g, null, null, h)
		};
		k.find = function (g, h, l) {
			var m, q;
			if (!g)return[];
			for (var p = 0, v = n.order.length; p < v; p++) {
				var t = n.order[p];
				if (q = n.leftMatch[t].exec(g)) {
					var y = q[1];
					q.splice(1, 1);
					if (y.substr(y.length - 1) !== "\\") {
						q[1] = (q[1] || "").replace(/\\/g, "");
						m = n.find[t](q, h, l);
						if (m != null) {
							g = g.replace(n.match[t], "");
							break
						}
					}
				}
			}
			m || (m = h.getElementsByTagName("*"));
			return{set:m, expr:g}
		};
		k.filter = function (g, h, l, m) {
			for (var q = g, p = [], v = h, t, y, S = h && h[0] && x(h[0]); g && h.length;) {
				for (var H in n.filter)if ((t = n.leftMatch[H].exec(g)) != null && t[2]) {
					var M = n.filter[H], I, D;
					D = t[1];
					y = false;
					t.splice(1, 1);
					if (D.substr(D.length - 1) !== "\\") {
						if (v === p)p = [];
						if (n.preFilter[H])if (t = n.preFilter[H](t, v, l, p, m, S)) {
							if (t === true)continue
						} else y = I = true;
						if (t)for (var U = 0; (D = v[U]) != null; U++)if (D) {
							I = M(D, t, U, v);
							var Ha = m ^ !!I;
							if (l && I != null)if (Ha)y = true; else v[U] = false; else if (Ha) {
								p.push(D);
								y = true
							}
						}
						if (I !== w) {
							l || (v = p);
							g = g.replace(n.match[H], "");
							if (!y)return[];
							break
						}
					}
				}
				if (g === q)if (y == null)k.error(g); else break;
				q = g
			}
			return v
		};
		k.error = function (g) {
			throw"Syntax error, unrecognized expression: " + g;
		};
		var n = k.selectors = {order:["ID", "NAME", "TAG"], match:{ID:/#((?:[\w\u00c0-\uFFFF-]|\\.)+)/, CLASS:/\.((?:[\w\u00c0-\uFFFF-]|\\.)+)/, NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF-]|\\.)+)['"]*\]/, ATTR:/\[\s*((?:[\w\u00c0-\uFFFF-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/, TAG:/^((?:[\w\u00c0-\uFFFF\*-]|\\.)+)/, CHILD:/:(only|nth|last|first)-child(?:\((even|odd|[\dn+-]*)\))?/, POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^-]|$)/, PSEUDO:/:((?:[\w\u00c0-\uFFFF-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/}, leftMatch:{}, attrMap:{"class":"className", "for":"htmlFor"}, attrHandle:{href:function (g) {
			return g.getAttribute("href")
		}}, relative:{"+":function (g, h) {
			var l = typeof h === "string", m = l && !/\W/.test(h);
			l = l && !m;
			if (m)h = h.toLowerCase();
			m = 0;
			for (var q = g.length, p; m < q; m++)if (p = g[m]) {
				for (; (p = p.previousSibling) && p.nodeType !== 1;);
				g[m] = l || p && p.nodeName.toLowerCase() === h ? p || false : p === h
			}
			l && k.filter(h, g, true)
		}, ">":function (g, h) {
			var l = typeof h === "string";
			if (l && !/\W/.test(h)) {
				h = h.toLowerCase();
				for (var m = 0, q = g.length; m < q; m++) {
					var p = g[m];
					if (p) {
						l = p.parentNode;
						g[m] = l.nodeName.toLowerCase() === h ? l : false
					}
				}
			} else {
				m = 0;
				for (q = g.length; m < q; m++)if (p = g[m])g[m] = l ? p.parentNode : p.parentNode === h;
				l && k.filter(h, g, true)
			}
		}, "":function (g, h, l) {
			var m = e++, q = d;
			if (typeof h === "string" && !/\W/.test(h)) {
				var p = h = h.toLowerCase();
				q = b
			}
			q("parentNode", h, m, g, p, l)
		}, "~":function (g, h, l) {
			var m = e++, q = d;
			if (typeof h === "string" && !/\W/.test(h)) {
				var p = h = h.toLowerCase();
				q = b
			}
			q("previousSibling", h, m, g, p, l)
		}}, find:{ID:function (g, h, l) {
			if (typeof h.getElementById !== "undefined" && !l)return(g = h.getElementById(g[1])) ? [g] : []
		}, NAME:function (g, h) {
			if (typeof h.getElementsByName !== "undefined") {
				var l = [];
				h = h.getElementsByName(g[1]);
				for (var m = 0, q = h.length; m < q; m++)h[m].getAttribute("name") === g[1] && l.push(h[m]);
				return l.length === 0 ? null : l
			}
		}, TAG:function (g, h) {
			return h.getElementsByTagName(g[1])
		}}, preFilter:{CLASS:function (g, h, l, m, q, p) {
			g = " " + g[1].replace(/\\/g, "") + " ";
			if (p)return g;
			p = 0;
			for (var v; (v = h[p]) != null; p++)if (v)if (q ^ (v.className && (" " + v.className + " ").replace(/[\t\n]/g, " ").indexOf(g) >= 0))l || m.push(v); else if (l)h[p] = false;
			return false
		}, ID:function (g) {
			return g[1].replace(/\\/g, "")
		}, TAG:function (g) {
			return g[1].toLowerCase()
		}, CHILD:function (g) {
			if (g[1] === "nth") {
				var h = /(-?)(\d*)n((?:\+|-)?\d*)/.exec(g[2] === "even" && "2n" || g[2] === "odd" && "2n+1" || !/\D/.test(g[2]) && "0n+" + g[2] || g[2]);
				g[2] = h[1] + (h[2] || 1) - 0;
				g[3] = h[3] - 0
			}
			g[0] = e++;
			return g
		}, ATTR:function (g, h, l, m, q, p) {
			h = g[1].replace(/\\/g, "");
			if (!p && n.attrMap[h])g[1] = n.attrMap[h];
			if (g[2] === "~=")g[4] = " " + g[4] + " ";
			return g
		}, PSEUDO:function (g, h, l, m, q) {
			if (g[1] === "not")if ((f.exec(g[3]) || "").length > 1 || /^\w/.test(g[3]))g[3] = k(g[3], null, null, h); else {
				g = k.filter(g[3], h, l, true ^ q);
				l || m.push.apply(m, g);
				return false
			} else if (n.match.POS.test(g[0]) || n.match.CHILD.test(g[0]))return true;
			return g
		}, POS:function (g) {
			g.unshift(true);
			return g
		}}, filters:{enabled:function (g) {
			return g.disabled === false && g.type !== "hidden"
		}, disabled:function (g) {
			return g.disabled === true
		}, checked:function (g) {
			return g.checked === true
		}, selected:function (g) {
			return g.selected === true
		}, parent:function (g) {
			return!!g.firstChild
		}, empty:function (g) {
			return!g.firstChild
		}, has:function (g, h, l) {
			return!!k(l[3], g).length
		}, header:function (g) {
			return/h\d/i.test(g.nodeName)
		}, text:function (g) {
			return"text" === g.type
		}, radio:function (g) {
			return"radio" === g.type
		}, checkbox:function (g) {
			return"checkbox" === g.type
		}, file:function (g) {
			return"file" === g.type
		}, password:function (g) {
			return"password" === g.type
		}, submit:function (g) {
			return"submit" === g.type
		}, image:function (g) {
			return"image" === g.type
		}, reset:function (g) {
			return"reset" === g.type
		}, button:function (g) {
			return"button" === g.type || g.nodeName.toLowerCase() === "button"
		}, input:function (g) {
			return/input|select|textarea|button/i.test(g.nodeName)
		}}, setFilters:{first:function (g, h) {
			return h === 0
		}, last:function (g, h, l, m) {
			return h === m.length - 1
		}, even:function (g, h) {
			return h % 2 === 0
		}, odd:function (g, h) {
			return h % 2 === 1
		}, lt:function (g, h, l) {
			return h < l[3] - 0
		}, gt:function (g, h, l) {
			return h > l[3] - 0
		}, nth:function (g, h, l) {
			return l[3] - 0 === h
		}, eq:function (g, h, l) {
			return l[3] - 0 === h
		}}, filter:{PSEUDO:function (g, h, l, m) {
			var q = h[1], p = n.filters[q];
			if (p)return p(g, l, h, m); else if (q === "contains")return(g.textContent || g.innerText || a([g]) || "").indexOf(h[3]) >= 0; else if (q === "not") {
				h = h[3];
				l = 0;
				for (m = h.length; l < m; l++)if (h[l] === g)return false;
				return true
			} else k.error("Syntax error, unrecognized expression: " + q)
		}, CHILD:function (g, h) {
			var l = h[1], m = g;
			switch (l) {
				case"only":
				case"first":
					for (; m = m.previousSibling;)if (m.nodeType === 1)return false;
					if (l === "first")return true;
					m = g;
				case"last":
					for (; m = m.nextSibling;)if (m.nodeType === 1)return false;
					return true;
				case"nth":
					l = h[2];
					var q = h[3];
					if (l === 1 && q === 0)return true;
					h = h[0];
					var p = g.parentNode;
					if (p && (p.sizcache !== h || !g.nodeIndex)) {
						var v = 0;
						for (m = p.firstChild; m; m = m.nextSibling)if (m.nodeType === 1)m.nodeIndex = ++v;
						p.sizcache = h
					}
					g = g.nodeIndex - q;
					return l === 0 ? g === 0 : g % l === 0 && g / l >= 0
			}
		}, ID:function (g, h) {
			return g.nodeType === 1 && g.getAttribute("id") === h
		}, TAG:function (g, h) {
			return h === "*" && g.nodeType === 1 || g.nodeName.toLowerCase() === h
		}, CLASS:function (g, h) {
			return(" " + (g.className || g.getAttribute("class")) + " ").indexOf(h) > -1
		}, ATTR:function (g, h) {
			var l = h[1];
			g = n.attrHandle[l] ? n.attrHandle[l](g) : g[l] != null ? g[l] : g.getAttribute(l);
			l = g + "";
			var m = h[2];
			h = h[4];
			return g == null ? m === "!=" : m === "=" ? l === h : m === "*=" ? l.indexOf(h) >= 0 : m === "~=" ? (" " + l + " ").indexOf(h) >= 0 : !h ? l && g !== false : m === "!=" ? l !== h : m === "^=" ? l.indexOf(h) === 0 : m === "$=" ? l.substr(l.length - h.length) === h : m === "|=" ? l === h || l.substr(0, h.length + 1) === h + "-" : false
		}, POS:function (g, h, l, m) {
			var q = n.setFilters[h[2]];
			if (q)return q(g, l, h, m)
		}}}, r = n.match.POS;
		for (var u in n.match) {
			n.match[u] = new RegExp(n.match[u].source + /(?![^\[]*\])(?![^\(]*\))/.source);
			n.leftMatch[u] = new RegExp(/(^(?:.|\r|\n)*?)/.source + n.match[u].source.replace(/\\(\d+)/g, function (g, h) {
				return"\\" + (h - 0 + 1)
			}))
		}
		var z = function (g, h) {
			g = Array.prototype.slice.call(g, 0);
			if (h) {
				h.push.apply(h, g);
				return h
			}
			return g
		};
		try {
			Array.prototype.slice.call(s.documentElement.childNodes, 0)
		} catch (C) {
			z = function (g, h) {
				h = h || [];
				if (j.call(g) === "[object Array]")Array.prototype.push.apply(h, g); else if (typeof g.length === "number")for (var l = 0, m = g.length; l < m; l++)h.push(g[l]); else for (l = 0; g[l]; l++)h.push(g[l]);
				return h
			}
		}
		var B;
		if (s.documentElement.compareDocumentPosition)B = function (g, h) {
			if (!g.compareDocumentPosition || !h.compareDocumentPosition) {
				if (g == h)i = true;
				return g.compareDocumentPosition ? -1 : 1
			}
			g = g.compareDocumentPosition(h) & 4 ? -1 : g === h ? 0 : 1;
			if (g === 0)i = true;
			return g
		}; else if ("sourceIndex"in s.documentElement)B = function (g, h) {
			if (!g.sourceIndex || !h.sourceIndex) {
				if (g == h)i = true;
				return g.sourceIndex ? -1 : 1
			}
			g = g.sourceIndex - h.sourceIndex;
			if (g === 0)i = true;
			return g
		}; else if (s.createRange)B = function (g, h) {
			if (!g.ownerDocument || !h.ownerDocument) {
				if (g == h)i = true;
				return g.ownerDocument ? -1 : 1
			}
			var l = g.ownerDocument.createRange(), m = h.ownerDocument.createRange();
			l.setStart(g, 0);
			l.setEnd(g, 0);
			m.setStart(h, 0);
			m.setEnd(h, 0);
			g = l.compareBoundaryPoints(Range.START_TO_END, m);
			if (g === 0)i = true;
			return g
		};
		(function () {
			var g = s.createElement("div"), h = "script" + (new Date).getTime();
			g.innerHTML = "<a name='" + h + "'/>";
			var l = s.documentElement;
			l.insertBefore(g, l.firstChild);
			if (s.getElementById(h)) {
				n.find.ID = function (m, q, p) {
					if (typeof q.getElementById !== "undefined" && !p)return(q = q.getElementById(m[1])) ? q.id === m[1] || typeof q.getAttributeNode !== "undefined" && q.getAttributeNode("id").nodeValue === m[1] ? [q] : w : []
				};
				n.filter.ID = function (m, q) {
					var p = typeof m.getAttributeNode !== "undefined" && m.getAttributeNode("id");
					return m.nodeType === 1 && p && p.nodeValue === q
				}
			}
			l.removeChild(g);
			l = g = null
		})();
		(function () {
			var g = s.createElement("div");
			g.appendChild(s.createComment(""));
			if (g.getElementsByTagName("*").length > 0)n.find.TAG = function (h, l) {
				l = l.getElementsByTagName(h[1]);
				if (h[1] === "*") {
					h = [];
					for (var m = 0; l[m]; m++)l[m].nodeType === 1 && h.push(l[m]);
					l = h
				}
				return l
			};
			g.innerHTML = "<a href='#'></a>";
			if (g.firstChild && typeof g.firstChild.getAttribute !== "undefined" && g.firstChild.getAttribute("href") !== "#")n.attrHandle.href = function (h) {
				return h.getAttribute("href", 2)
			};
			g = null
		})();
		s.querySelectorAll && function () {
			var g = k, h = s.createElement("div");
			h.innerHTML = "<p class='TEST'></p>";
			if (!(h.querySelectorAll && h.querySelectorAll(".TEST").length === 0)) {
				k = function (m, q, p, v) {
					q = q || s;
					if (!v && q.nodeType === 9 && !x(q))try {
						return z(q.querySelectorAll(m), p)
					} catch (t) {
					}
					return g(m, q, p, v)
				};
				for (var l in g)k[l] = g[l];
				h = null
			}
		}();
		(function () {
			var g = s.createElement("div");
			g.innerHTML = "<div class='test e'></div><div class='test'></div>";
			if (!(!g.getElementsByClassName || g.getElementsByClassName("e").length === 0)) {
				g.lastChild.className = "e";
				if (g.getElementsByClassName("e").length !== 1) {
					n.order.splice(1, 0, "CLASS");
					n.find.CLASS = function (h, l, m) {
						if (typeof l.getElementsByClassName !== "undefined" && !m)return l.getElementsByClassName(h[1])
					};
					g = null
				}
			}
		})();
		var E = s.compareDocumentPosition ? function (g, h) {
			return!!(g.compareDocumentPosition(h) & 16)
		} : function (g, h) {
			return g !== h && (g.contains ? g.contains(h) : true)
		}, x = function (g) {
			return(g = (g ? g.ownerDocument || g : 0).documentElement) ? g.nodeName !== "HTML" : false
		}, ga = function (g, h) {
			var l = [], m = "", q;
			for (h = h.nodeType ? [h] : h; q = n.match.PSEUDO.exec(g);) {
				m += q[0];
				g = g.replace(n.match.PSEUDO, "")
			}
			g = n.relative[g] ? g + "*" : g;
			q = 0;
			for (var p = h.length; q < p; q++)k(g, h[q], l);
			return k.filter(m, l)
		};
		c.find = k;
		c.expr = k.selectors;
		c.expr[":"] = c.expr.filters;
		c.unique = k.uniqueSort;
		c.text = a;
		c.isXMLDoc = x;
		c.contains = E
	})();
	var eb = /Until$/, fb = /^(?:parents|prevUntil|prevAll)/, gb = /,/;
	R = Array.prototype.slice;
	var Ia = function (a, b, d) {
		if (c.isFunction(b))return c.grep(a, function (e, j) {
			return!!b.call(e, j, e) === d
		}); else if (b.nodeType)return c.grep(a, function (e) {
			return e === b === d
		}); else if (typeof b === "string") {
			var f = c.grep(a, function (e) {
				return e.nodeType === 1
			});
			if (Ua.test(b))return c.filter(b, f, !d); else b = c.filter(b, f)
		}
		return c.grep(a, function (e) {
			return c.inArray(e, b) >= 0 === d
		})
	};
	c.fn.extend({find:function (a) {
		for (var b = this.pushStack("", "find", a), d = 0, f = 0, e = this.length; f < e; f++) {
			d = b.length;
			c.find(a, this[f], b);
			if (f > 0)for (var j = d; j < b.length; j++)for (var i = 0; i < d; i++)if (b[i] === b[j]) {
				b.splice(j--, 1);
				break
			}
		}
		return b
	}, has:function (a) {
		var b = c(a);
		return this.filter(function () {
			for (var d = 0, f = b.length; d < f; d++)if (c.contains(this, b[d]))return true
		})
	}, not:function (a) {
		return this.pushStack(Ia(this, a, false), "not", a)
	}, filter:function (a) {
		return this.pushStack(Ia(this, a, true), "filter", a)
	}, is:function (a) {
		return!!a && c.filter(a, this).length > 0
	}, closest:function (a, b) {
		if (c.isArray(a)) {
			var d = [], f = this[0], e, j = {}, i;
			if (f && a.length) {
				e = 0;
				for (var o = a.length; e < o; e++) {
					i = a[e];
					j[i] || (j[i] = c.expr.match.POS.test(i) ? c(i, b || this.context) : i)
				}
				for (; f && f.ownerDocument && f !== b;) {
					for (i in j) {
						e = j[i];
						if (e.SsbBase ? e.index(f) > -1 : c(f).is(e)) {
							d.push({selector:i, elem:f});
							delete j[i]
						}
					}
					f = f.parentNode
				}
			}
			return d
		}
		var k = c.expr.match.POS.test(a) ? c(a, b || this.context) : null;
		return this.map(function (n, r) {
			for (; r && r.ownerDocument && r !== b;) {
				if (k ? k.index(r) > -1 : c(r).is(a))return r;
				r = r.parentNode
			}
			return null
		})
	}, index:function (a) {
		if (!a || typeof a === "string")return c.inArray(this[0], a ? c(a) : this.parent().children());
		return c.inArray(a.SsbBase ? a[0] : a, this)
	}, add:function (a, b) {
		a = typeof a === "string" ? c(a, b || this.context) : c.makeArray(a);
		b = c.merge(this.get(), a);
		return this.pushStack(qa(a[0]) || qa(b[0]) ? b : c.unique(b))
	}, andSelf:function () {
		return this.add(this.prevObject)
	}});
	c.each({parent:function (a) {
		return(a = a.parentNode) && a.nodeType !== 11 ? a : null
	}, parents:function (a) {
		return c.dir(a, "parentNode")
	}, parentsUntil:function (a, b, d) {
		return c.dir(a, "parentNode", d)
	}, next:function (a) {
		return c.nth(a, 2, "nextSibling")
	}, prev:function (a) {
		return c.nth(a, 2, "previousSibling")
	}, nextAll:function (a) {
		return c.dir(a, "nextSibling")
	}, prevAll:function (a) {
		return c.dir(a, "previousSibling")
	}, nextUntil:function (a, b, d) {
		return c.dir(a, "nextSibling", d)
	}, prevUntil:function (a, b, d) {
		return c.dir(a, "previousSibling", d)
	}, siblings:function (a) {
		return c.sibling(a.parentNode.firstChild, a)
	}, children:function (a) {
		return c.sibling(a.firstChild)
	}, contents:function (a) {
		return c.nodeName(a, "iframe") ? a.contentDocument || a.contentWindow.document : c.makeArray(a.childNodes)
	}}, function (a, b) {
		c.fn[a] = function (d, f) {
			var e = c.map(this, b, d);
			eb.test(a) || (f = d);
			if (f && typeof f === "string")e = c.filter(f, e);
			e = this.length > 1 ? c.unique(e) : e;
			if ((this.length > 1 || gb.test(f)) && fb.test(a))e = e.reverse();
			return this.pushStack(e, a, R.call(arguments).join(","))
		}
	});
	c.extend({filter:function (a, b, d) {
		if (d)a = ":not(" + a + ")";
		return c.find.matches(a, b)
	}, dir:function (a, b, d) {
		var f = [];
		for (a = a[b]; a && a.nodeType !== 9 && (d === w || a.nodeType !== 1 || !c(a).is(d));) {
			a.nodeType === 1 && f.push(a);
			a = a[b]
		}
		return f
	}, nth:function (a, b, d) {
		b = b || 1;
		for (var f = 0; a; a = a[d])if (a.nodeType === 1 && ++f === b)break;
		return a
	}, sibling:function (a, b) {
		for (var d = []; a; a = a.nextSibling)a.nodeType === 1 && a !== b && d.push(a);
		return d
	}});
	var Ja = / SsbBase\d+="(?:\d+|null)"/g, V = /^\s+/, Ka = /(<([\w:]+)[^>]*?)\/>/g, hb = /^(?:area|br|col|embed|hr|img|input|link|meta|param)$/i, La = /<([\w:]+)/, ib = /<tbody/i, jb = /<|&#?\w+;/, ta = /<script|<object|<embed|<option|<style/i, ua = /checked\s*(?:[^=]|=\s*.checked.)/i, Ma = function (a, b, d) {
		return hb.test(d) ? a : b + "></" + d + ">"
	}, F = {option:[1, "<select multiple='multiple'>", "</select>"], legend:[1, "<fieldset>", "</fieldset>"], thead:[1, "<table>", "</table>"], tr:[2, "<table><tbody>", "</tbody></table>"], td:[3, "<table><tbody><tr>", "</tr></tbody></table>"], col:[2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"], area:[1, "<map>", "</map>"], _default:[0, "", ""]};
	F.optgroup = F.option;
	F.tbody = F.tfoot = F.colgroup = F.caption = F.thead;
	F.th = F.td;
	if (!c.support.htmlSerialize)F._default = [1, "div<div>", "</div>"];
	c.fn.extend({text:function (a) {
		if (c.isFunction(a))return this.each(function (b) {
			var d = c(this);
			d.text(a.call(this, b, d.text()))
		});
		if (typeof a !== "object" && a !== w)return this.empty().append((this[0] && this[0].ownerDocument || s).createTextNode(a));
		return c.text(this)
	}, wrapAll:function (a) {
		if (c.isFunction(a))return this.each(function (d) {
			c(this).wrapAll(a.call(this, d))
		});
		if (this[0]) {
			var b = c(a, this[0].ownerDocument).eq(0).clone(true);
			this[0].parentNode && b.insertBefore(this[0]);
			b.map(function () {
				for (var d = this; d.firstChild && d.firstChild.nodeType === 1;)d = d.firstChild;
				return d
			}).append(this)
		}
		return this
	}, wrapInner:function (a) {
		if (c.isFunction(a))return this.each(function (b) {
			c(this).wrapInner(a.call(this, b))
		});
		return this.each(function () {
			var b = c(this), d = b.contents();
			d.length ? d.wrapAll(a) : b.append(a)
		})
	}, wrap:function (a) {
		return this.each(function () {
			c(this).wrapAll(a)
		})
	}, unwrap:function () {
		return this.parent().each(function () {
			c.nodeName(this, "body") || c(this).replaceWith(this.childNodes)
		}).end()
	}, append:function () {
		return this.domManip(arguments, true, function (a) {
			this.nodeType === 1 && this.appendChild(a)
		})
	}, prepend:function () {
		return this.domManip(arguments, true, function (a) {
			this.nodeType === 1 && this.insertBefore(a, this.firstChild)
		})
	}, before:function () {
		if (this[0] && this[0].parentNode)return this.domManip(arguments, false, function (b) {
			this.parentNode.insertBefore(b, this)
		}); else if (arguments.length) {
			var a = c(arguments[0]);
			a.push.apply(a, this.toArray());
			return this.pushStack(a, "before", arguments)
		}
	}, after:function () {
		if (this[0] && this[0].parentNode)return this.domManip(arguments, false, function (b) {
			this.parentNode.insertBefore(b, this.nextSibling)
		}); else if (arguments.length) {
			var a = this.pushStack(this, "after", arguments);
			a.push.apply(a, c(arguments[0]).toArray());
			return a
		}
	}, remove:function (a, b) {
		for (var d = 0, f; (f = this[d]) != null; d++)if (!a || c.filter(a, [f]).length) {
			if (!b && f.nodeType === 1) {
				c.cleanData(f.getElementsByTagName("*"));
				c.cleanData([f])
			}
			f.parentNode && f.parentNode.removeChild(f)
		}
		return this
	}, empty:function () {
		for (var a = 0, b; (b = this[a]) != null; a++)for (b.nodeType === 1 && c.cleanData(b.getElementsByTagName("*")); b.firstChild;)b.removeChild(b.firstChild);
		return this
	}, clone:function (a) {
		var b = this.map(function () {
			if (!c.support.noCloneEvent && !c.isXMLDoc(this)) {
				var d = this.outerHTML, f = this.ownerDocument;
				if (!d) {
					d = f.createElement("div");
					d.appendChild(this.cloneNode(true));
					d = d.innerHTML
				}
				return c.clean([d.replace(Ja, "").replace(/=([^="'>\s]+\/)>/g, '="$1">').replace(V, "")], f)[0]
			} else return this.cloneNode(true)
		});
		if (a === true) {
			ra(this, b);
			ra(this.find("*"), b.find("*"))
		}
		return b
	}, html:function (a) {
		if (a === w)return this[0] && this[0].nodeType === 1 ? this[0].innerHTML.replace(Ja, "") : null; else if (typeof a === "string" && !ta.test(a) && (c.support.leadingWhitespace || !V.test(a)) && !F[(La.exec(a) || ["", ""])[1].toLowerCase()]) {
			a = a.replace(Ka, Ma);
			try {
				for (var b = 0, d = this.length; b < d; b++)if (this[b].nodeType === 1) {
					c.cleanData(this[b].getElementsByTagName("*"));
					this[b].innerHTML = a
				}
			} catch (f) {
				this.empty().append(a)
			}
		} else c.isFunction(a) ? this.each(function (e) {
			var j = c(this), i = j.html();
			j.empty().append(function () {
				return a.call(this, e, i)
			})
		}) : this.empty().append(a);
		return this
	}, replaceWith:function (a) {
		if (this[0] && this[0].parentNode) {
			if (c.isFunction(a))return this.each(function (b) {
				var d = c(this), f = d.html();
				d.replaceWith(a.call(this, b, f))
			});
			if (typeof a !== "string")a = c(a).detach();
			return this.each(function () {
				var b = this.nextSibling, d = this.parentNode;
				c(this).remove();
				b ? c(b).before(a) : c(d).append(a)
			})
		} else return this.pushStack(c(c.isFunction(a) ? a() : a), "replaceWith", a)
	}, detach:function (a) {
		return this.remove(a, true)
	}, domManip:function (a, b, d) {
		function f(u) {
			return c.nodeName(u, "table") ? u.getElementsByTagName("tbody")[0] || u.appendChild(u.ownerDocument.createElement("tbody")) : u
		}

		var e, j, i = a[0], o = [], k;
		if (!c.support.checkClone && arguments.length === 3 && typeof i === "string" && ua.test(i))return this.each(function () {
			c(this).domManip(a, b, d, true)
		});
		if (c.isFunction(i))return this.each(function (u) {
			var z = c(this);
			a[0] = i.call(this, u, b ? z.html() : w);
			z.domManip(a, b, d)
		});
		if (this[0]) {
			e = i && i.parentNode;
			e = c.support.parentNode && e && e.nodeType === 11 && e.childNodes.length === this.length ? {fragment:e} : sa(a, this, o);
			k = e.fragment;
			if (j = k.childNodes.length === 1 ? (k = k.firstChild) : k.firstChild) {
				b = b && c.nodeName(j, "tr");
				for (var n = 0, r = this.length; n < r; n++)d.call(b ? f(this[n], j) : this[n], n > 0 || e.cacheable || this.length > 1 ? k.cloneNode(true) : k)
			}
			o.length && c.each(o, Qa)
		}
		return this
	}});
	c.fragments = {};
	c.each({appendTo:"append", prependTo:"prepend", insertBefore:"before", insertAfter:"after", replaceAll:"replaceWith"}, function (a, b) {
		c.fn[a] = function (d) {
			var f = [];
			d = c(d);
			var e = this.length === 1 && this[0].parentNode;
			if (e && e.nodeType === 11 && e.childNodes.length === 1 && d.length === 1) {
				d[b](this[0]);
				return this
			} else {
				e = 0;
				for (var j = d.length; e < j; e++) {
					var i = (e > 0 ? this.clone(true) : this).get();
					c.fn[b].apply(c(d[e]), i);
					f = f.concat(i)
				}
				return this.pushStack(f, a, d.selector)
			}
		}
	});
	c.extend({clean:function (a, b, d, f) {
		b = b || s;
		if (typeof b.createElement === "undefined")b = b.ownerDocument || b[0] && b[0].ownerDocument || s;
		for (var e = [], j = 0, i; (i = a[j]) != null; j++) {
			if (typeof i === "number")i += "";
			if (i) {
				if (typeof i === "string" && !jb.test(i))i = b.createTextNode(i); else if (typeof i === "string") {
					i = i.replace(Ka, Ma);
					var o = (La.exec(i) || ["", ""])[1].toLowerCase(), k = F[o] || F._default, n = k[0], r = b.createElement("div");
					for (r.innerHTML = k[1] + i + k[2]; n--;)r = r.lastChild;
					if (!c.support.tbody) {
						n = ib.test(i);
						o = o === "table" && !n ? r.firstChild && r.firstChild.childNodes : k[1] === "<table>" && !n ? r.childNodes : [];
						for (k = o.length - 1; k >= 0; --k)c.nodeName(o[k], "tbody") && !o[k].childNodes.length && o[k].parentNode.removeChild(o[k])
					}
					!c.support.leadingWhitespace && V.test(i) && r.insertBefore(b.createTextNode(V.exec(i)[0]), r.firstChild);
					i = r.childNodes
				}
				if (i.nodeType)e.push(i); else e = c.merge(e, i)
			}
		}
		if (d)for (j = 0; e[j]; j++)if (f && c.nodeName(e[j], "script") && (!e[j].type || e[j].type.toLowerCase() === "text/javascript"))f.push(e[j].parentNode ? e[j].parentNode.removeChild(e[j]) : e[j]); else {
			e[j].nodeType === 1 && e.splice.apply(e, [j + 1, 0].concat(c.makeArray(e[j].getElementsByTagName("script"))));
			d.appendChild(e[j])
		}
		return e
	}, cleanData:function (a) {
		for (var b, d, f = c.cache, e = c.event.special, j = c.support.deleteExpando, i = 0, o; (o = a[i]) != null; i++)if (d = o[c.expando]) {
			b = f[d];
			if (b.events)for (var k in b.events)e[k] ? c.event.remove(o, k) : Ca(o, k, b.handle);
			if (j)delete o[c.expando]; else o.removeAttribute && o.removeAttribute(c.expando);
			delete f[d]
		}
	}});
	var kb = /z-?index|font-?weight|opacity|zoom|line-?height/i, Na = /alpha\([^)]*\)/, Oa = /opacity=([^)]*)/, ha = /float/i, ia = /-([a-z])/ig, lb = /([A-Z])/g, mb = /^-?\d+(?:px)?$/i, nb = /^-?\d/, ob = {position:"absolute", visibility:"hidden", display:"block"}, pb = ["Left", "Right"], qb = ["Top", "Bottom"], rb = s.defaultView && s.defaultView.getComputedStyle, Pa = c.support.cssFloat ? "cssFloat" : "styleFloat", ja = function (a, b) {
		return b.toUpperCase()
	};
	c.fn.css = function (a, b) {
		return X(this, a, b, true, function (d, f, e) {
			if (e === w)return c.curCSS(d, f);
			if (typeof e === "number" && !kb.test(f))e += "px";
			c.style(d, f, e)
		})
	};
	c.extend({style:function (a, b, d) {
		if (!a || a.nodeType === 3 || a.nodeType === 8)return w;
		if ((b === "width" || b === "height") && parseFloat(d) < 0)d = w;
		var f = a.style || a, e = d !== w;
		if (!c.support.opacity && b === "opacity") {
			if (e) {
				f.zoom = 1;
				b = parseInt(d, 10) + "" === "NaN" ? "" : "alpha(opacity=" + d * 100 + ")";
				a = f.filter || c.curCSS(a, "filter") || "";
				f.filter = Na.test(a) ? a.replace(Na, b) : b
			}
			return f.filter && f.filter.indexOf("opacity=") >= 0 ? parseFloat(Oa.exec(f.filter)[1]) / 100 + "" : ""
		}
		if (ha.test(b))b = Pa;
		b = b.replace(ia, ja);
		if (e)f[b] = d;
		return f[b]
	}, css:function (a, b, d, f) {
		if (b === "width" || b === "height") {
			var e, j = b === "width" ? pb : qb;

			function i() {
				e = b === "width" ? a.offsetWidth : a.offsetHeight;
				f !== "border" && c.each(j, function () {
					f || (e -= parseFloat(c.curCSS(a, "padding" + this, true)) || 0);
					if (f === "margin")e += parseFloat(c.curCSS(a, "margin" + this, true)) || 0; else e -= parseFloat(c.curCSS(a, "border" + this + "Width", true)) || 0
				})
			}

			a.offsetWidth !== 0 ? i() : c.swap(a, ob, i);
			return Math.max(0, Math.round(e))
		}
		return c.curCSS(a, b, d)
	}, curCSS:function (a, b, d) {
		var f, e = a.style;
		if (!c.support.opacity && b === "opacity" && a.currentStyle) {
			f = Oa.test(a.currentStyle.filter || "") ? parseFloat(RegExp.$1) / 100 + "" : "";
			return f === "" ? "1" : f
		}
		if (ha.test(b))b = Pa;
		if (!d && e && e[b])f = e[b]; else if (rb) {
			if (ha.test(b))b = "float";
			b = b.replace(lb, "-$1").toLowerCase();
			e = a.ownerDocument.defaultView;
			if (!e)return null;
			if (a = e.getComputedStyle(a, null))f = a.getPropertyValue(b);
			if (b === "opacity" && f === "")f = "1"
		} else if (a.currentStyle) {
			d = b.replace(ia, ja);
			f = a.currentStyle[b] || a.currentStyle[d];
			if (!mb.test(f) && nb.test(f)) {
				b = e.left;
				var j = a.runtimeStyle.left;
				a.runtimeStyle.left = a.currentStyle.left;
				e.left = d === "fontSize" ? "1em" : f || 0;
				f = e.pixelLeft + "px";
				e.left = b;
				a.runtimeStyle.left = j
			}
		}
		return f
	}, swap:function (a, b, d) {
		var f = {};
		for (var e in b) {
			f[e] = a.style[e];
			a.style[e] = b[e]
		}
		d.call(a);
		for (e in b)a.style[e] = f[e]
	}});
	if (c.expr && c.expr.filters) {
		c.expr.filters.hidden = function (a) {
			var b = a.offsetWidth, d = a.offsetHeight, f = a.nodeName.toLowerCase() === "tr";
			return b === 0 && d === 0 && !f ? true : b > 0 && d > 0 && !f ? false : c.curCSS(a, "display") === "none"
		};
		c.expr.filters.visible = function (a) {
			return!c.expr.filters.hidden(a)
		}
	}
	var sb = J(), tb = /<script(.|\s)*?\/script>/gi, ub = /select|textarea/i, vb = /color|date|datetime|email|hidden|month|number|password|range|search|tel|text|time|url|week/i, N = /=\?(&|$)/, ka = /\?/, wb = /(\?|&)_=.*?(&|$)/, xb = /^(\w+:)?\/\/([^\/?#]+)/, yb = /%20/g, zb = c.fn.load;
	c.fn.extend({load:function (a, b, d) {
		if (typeof a !== "string")return zb.call(this, a); else if (!this.length)return this;
		var f = a.indexOf(" ");
		if (f >= 0) {
			var e = a.slice(f, a.length);
			a = a.slice(0, f)
		}
		f = "GET";
		if (b)if (c.isFunction(b)) {
			d = b;
			b = null
		} else if (typeof b === "object") {
			b = c.param(b, c.ajaxSettings.traditional);
			f = "POST"
		}
		var j = this;
		c.ajax({url:a, type:f, dataType:"html", data:b, complete:function (i, o) {
			if (o === "success" || o === "notmodified")j.html(e ? c("<div />").append(i.responseText.replace(tb, "")).find(e) : i.responseText);
			d && j.each(d, [i.responseText, o, i])
		}});
		return this
	}, serialize:function () {
		return c.param(this.serializeArray())
	}, serializeArray:function () {
		return this.map(function () {
			return this.elements ? c.makeArray(this.elements) : this
		}).filter(function () {
			return this.name && !this.disabled && (this.checked || ub.test(this.nodeName) || vb.test(this.type))
		}).map(function (a, b) {
			a = c(this).val();
			return a == null ? null : c.isArray(a) ? c.map(a, function (d) {
				return{name:b.name, value:d}
			}) : {name:b.name, value:a}
		}).get()
	}});
	c.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "), function (a, b) {
		c.fn[b] = function (d) {
			return this.bind(b, d)
		}
	});
	c.extend({get:function (a, b, d, f) {
		if (c.isFunction(b)) {
			f = f || d;
			d = b;
			b = null
		}
		return c.ajax({type:"GET", url:a, data:b, success:d, dataType:f})
	}, getScript:function (a, b) {
		return c.get(a, null, b, "script")
	}, getJSON:function (a, b, d) {
		return c.get(a, b, d, "json")
	}, post:function (a, b, d, f) {
		if (c.isFunction(b)) {
			f = f || d;
			d = b;
			b = {}
		}
		return c.ajax({type:"POST", url:a, data:b, success:d, dataType:f})
	}, ajaxSetup:function (a) {
		c.extend(c.ajaxSettings, a)
	}, ajaxSettings:{url:location.href, global:true, type:"GET", contentType:"application/x-www-form-urlencoded", processData:true, async:true, xhr:A.XMLHttpRequest && (A.location.protocol !== "file:" || !A.ActiveXObject) ? function () {
		return new A.XMLHttpRequest
	} : function () {
		try {
			return new A.ActiveXObject("Microsoft.XMLHTTP")
		} catch (a) {
		}
	}, accepts:{xml:"application/xml, text/xml", html:"text/html", script:"text/javascript, application/javascript", json:"application/json, text/javascript", text:"text/plain", _default:"*/*"}}, lastModified:{}, etag:{}, ajax:function (a) {
		function b() {
			e.success && e.success.call(k, o, i, x);
			e.global && f("ajaxSuccess", [x, e])
		}

		function d() {
			e.complete && e.complete.call(k, x, i);
			e.global && f("ajaxComplete", [x, e]);
			e.global && !--c.active && c.event.trigger("ajaxStop")
		}

		function f(q, p) {
			(e.context ? c(e.context) : c.event).trigger(q, p)
		}

		var e = c.extend(true, {}, c.ajaxSettings, a), j, i, o, k = a && a.context || e, n = e.type.toUpperCase();
		if (e.data && e.processData && typeof e.data !== "string")e.data = c.param(e.data, e.traditional);
		if (e.dataType === "jsonp") {
			if (n === "GET")N.test(e.url) || (e.url += (ka.test(e.url) ? "&" : "?") + (e.jsonp || "callback") + "=?"); else if (!e.data || !N.test(e.data))e.data = (e.data ? e.data + "&" : "") + (e.jsonp || "callback") + "=?";
			e.dataType = "json"
		}
		if (e.dataType === "json" && (e.data && N.test(e.data) || N.test(e.url))) {
			j = e.jsonpCallback || "jsonp" + sb++;
			if (e.data)e.data = (e.data + "").replace(N, "=" + j + "$1");
			e.url = e.url.replace(N, "=" + j + "$1");
			e.dataType = "script";
			A[j] = A[j] || function (q) {
				o = q;
				b();
				d();
				A[j] = w;
				try {
					delete A[j]
				} catch (p) {
				}
				z && z.removeChild(C)
			}
		}
		if (e.dataType === "script" && e.cache === null)e.cache = false;
		if (e.cache === false && n === "GET") {
			var r = J(), u = e.url.replace(wb, "$1_=" + r + "$2");
			e.url = u + (u === e.url ? (ka.test(e.url) ? "&" : "?") + "_=" + r : "")
		}
		if (e.data && n === "GET")e.url += (ka.test(e.url) ? "&" : "?") + e.data;
		e.global && !c.active++ && c.event.trigger("ajaxStart");
		r = (r = xb.exec(e.url)) && (r[1] && r[1] !== location.protocol || r[2] !== location.host);
		if (e.dataType === "script" && n === "GET" && r) {
			var z = s.getElementsByTagName("head")[0] || s.documentElement, C = s.createElement("script");
			C.src = e.url;
			if (e.scriptCharset)C.charset = e.scriptCharset;
			if (!j) {
				var B = false;
				C.onload = C.onreadystatechange = function () {
					if (!B && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
						B = true;
						b();
						d();
						C.onload = C.onreadystatechange = null;
						z && C.parentNode && z.removeChild(C)
					}
				}
			}
			z.insertBefore(C, z.firstChild);
			return w
		}
		var E = false, x = e.xhr();
		if (x) {
			e.username ? x.open(n, e.url, e.async, e.username, e.password) : x.open(n, e.url, e.async);
			try {
				if (e.data || a && a.contentType)x.setRequestHeader("Content-Type", e.contentType);
				if (e.ifModified) {
					c.lastModified[e.url] && x.setRequestHeader("If-Modified-Since", c.lastModified[e.url]);
					c.etag[e.url] && x.setRequestHeader("If-None-Match", c.etag[e.url])
				}
				r || x.setRequestHeader("X-Requested-With", "XMLHttpRequest");
				x.setRequestHeader("Accept", e.dataType && e.accepts[e.dataType] ? e.accepts[e.dataType] + ", */*" : e.accepts._default)
			} catch (ga) {
			}
			if (e.beforeSend && e.beforeSend.call(k, x, e) === false) {
				e.global && !--c.active && c.event.trigger("ajaxStop");
				x.abort();
				return false
			}
			e.global && f("ajaxSend", [x, e]);
			var g = x.onreadystatechange = function (q) {
				if (!x || x.readyState === 0 || q === "abort") {
					E || d();
					E = true;
					if (x)x.onreadystatechange = c.noop
				} else if (!E && x && (x.readyState === 4 || q === "timeout")) {
					E = true;
					x.onreadystatechange = c.noop;
					i = q === "timeout" ? "timeout" : !c.httpSuccess(x) ? "error" : e.ifModified && c.httpNotModified(x, e.url) ? "notmodified" : "success";
					var p;
					if (i === "success")try {
						o = c.httpData(x, e.dataType, e)
					} catch (v) {
						i = "parsererror";
						p = v
					}
					if (i === "success" || i === "notmodified")j || b(); else c.handleError(e, x, i, p);
					d();
					q === "timeout" && x.abort();
					if (e.async)x = null
				}
			};
			try {
				var h = x.abort;
				x.abort = function () {
					x && h.call(x);
					g("abort")
				}
			} catch (l) {
			}
			e.async && e.timeout > 0 && setTimeout(function () {
				x && !E && g("timeout")
			}, e.timeout);
			try {
				x.send(n === "POST" || n === "PUT" || n === "DELETE" ? e.data : null)
			} catch (m) {
				c.handleError(e, x, null, m);
				d()
			}
			e.async || g();
			return x
		}
	}, handleError:function (a, b, d, f) {
		if (a.error)a.error.call(a.context || a, b, d, f);
		if (a.global)(a.context ? c(a.context) : c.event).trigger("ajaxError", [b, a, f])
	}, active:0, httpSuccess:function (a) {
		try {
			return!a.status && location.protocol === "file:" || a.status >= 200 && a.status < 300 || a.status === 304 || a.status === 1223 || a.status === 0
		} catch (b) {
		}
		return false
	}, httpNotModified:function (a, b) {
		var d = a.getResponseHeader("Last-Modified"), f = a.getResponseHeader("Etag");
		if (d)c.lastModified[b] = d;
		if (f)c.etag[b] = f;
		return a.status === 304 || a.status === 0
	}, httpData:function (a, b, d) {
		var f = a.getResponseHeader("content-type") || "", e = b === "xml" || !b && f.indexOf("xml") >= 0;
		a = e ? a.responseXML : a.responseText;
		e && a.documentElement.nodeName === "parsererror" && c.error("parsererror");
		if (d && d.dataFilter)a = d.dataFilter(a, b);
		if (typeof a === "string")if (b === "json" || !b && f.indexOf("json") >= 0)a = c.parseJSON(a); else if (b === "script" || !b && f.indexOf("javascript") >= 0)c.globalEval(a);
		return a
	}, param:function (a, b) {
		function d(i, o) {
			if (c.isArray(o))c.each(o, function (k, n) {
				b || /\[\]$/.test(i) ? f(i, n) : d(i + "[" + (typeof n === "object" || c.isArray(n) ? k : "") + "]", n)
			}); else!b && o != null && typeof o === "object" ? c.each(o, function (k, n) {
				d(i + "[" + k + "]", n)
			}) : f(i, o)
		}

		function f(i, o) {
			o = c.isFunction(o) ? o() : o;
			e[e.length] = encodeURIComponent(i) + "=" + encodeURIComponent(o)
		}

		var e = [];
		if (b === w)b = c.ajaxSettings.traditional;
		if (c.isArray(a) || a.SsbBase)c.each(a, function () {
			f(this.name, this.value)
		}); else for (var j in a)d(j, a[j]);
		return e.join("&").replace(yb, "+")
	}});
	var la = {}, Ab = /toggle|show|hide/, Bb = /^([+-]=)?([\d+-.]+)(.*)$/, W, va = [
		["height", "marginTop", "marginBottom", "paddingTop", "paddingBottom"],
		["width", "marginLeft", "marginRight", "paddingLeft", "paddingRight"],
		["opacity"]
	];
	c.fn.extend({show:function (a, b) {
		if (a || a === 0)return this.animate(K("show", 3), a, b); else {
			a = 0;
			for (b = this.length; a < b; a++) {
				var d = c.data(this[a], "olddisplay");
				this[a].style.display = d || "";
				if (c.css(this[a], "display") === "none") {
					d = this[a].nodeName;
					var f;
					if (la[d])f = la[d]; else {
						var e = c("<" + d + " />").appendTo("body");
						f = e.css("display");
						if (f === "none")f = "block";
						e.remove();
						la[d] = f
					}
					c.data(this[a], "olddisplay", f)
				}
			}
			a = 0;
			for (b = this.length; a < b; a++)this[a].style.display = c.data(this[a], "olddisplay") || "";
			return this
		}
	}, hide:function (a, b) {
		if (a || a === 0)return this.animate(K("hide", 3), a, b); else {
			a = 0;
			for (b = this.length; a < b; a++) {
				var d = c.data(this[a], "olddisplay");
				!d && d !== "none" && c.data(this[a], "olddisplay", c.css(this[a], "display"))
			}
			a = 0;
			for (b = this.length; a < b; a++)this[a].style.display = "none";
			return this
		}
	}, _toggle:c.fn.toggle, toggle:function (a, b) {
		var d = typeof a === "boolean";
		if (c.isFunction(a) && c.isFunction(b))this._toggle.apply(this, arguments); else a == null || d ? this.each(function () {
			var f = d ? a : c(this).is(":hidden");
			c(this)[f ? "show" : "hide"]()
		}) : this.animate(K("toggle", 3), a, b);
		return this
	}, fadeTo:function (a, b, d) {
		return this.filter(":hidden").css("opacity", 0).show().end().animate({opacity:b}, a, d)
	}, animate:function (a, b, d, f) {
		var e = c.speed(b, d, f);
		if (c.isEmptyObject(a))return this.each(e.complete);
		return this[e.queue === false ? "each" : "queue"](function () {
			var j = c.extend({}, e), i, o = this.nodeType === 1 && c(this).is(":hidden"), k = this;
			for (i in a) {
				var n = i.replace(ia, ja);
				if (i !== n) {
					a[n] = a[i];
					delete a[i];
					i = n
				}
				if (a[i] === "hide" && o || a[i] === "show" && !o)return j.complete.call(this);
				if ((i === "height" || i === "width") && this.style) {
					j.display = c.css(this, "display");
					j.overflow = this.style.overflow
				}
				if (c.isArray(a[i])) {
					(j.specialEasing = j.specialEasing || {})[i] = a[i][1];
					a[i] = a[i][0]
				}
			}
			if (j.overflow != null)this.style.overflow = "hidden";
			j.curAnim = c.extend({}, a);
			c.each(a, function (r, u) {
				var z = new c.fx(k, j, r);
				if (Ab.test(u))z[u === "toggle" ? o ? "show" : "hide" : u](a); else {
					var C = Bb.exec(u), B = z.cur(true) || 0;
					if (C) {
						u = parseFloat(C[2]);
						var E = C[3] || "px";
						if (E !== "px") {
							k.style[r] = (u || 1) + E;
							B = (u || 1) / z.cur(true) * B;
							k.style[r] = B + E
						}
						if (C[1])u = (C[1] === "-=" ? -1 : 1) * u + B;
						z.custom(B, u, E)
					} else z.custom(B, u, "")
				}
			});
			return true
		})
	}, stop:function (a, b) {
		var d = c.timers;
		a && this.queue([]);
		this.each(function () {
			for (var f = d.length - 1; f >= 0; f--)if (d[f].elem === this) {
				b && d[f](true);
				d.splice(f, 1)
			}
		});
		b || this.dequeue();
		return this
	}});
	c.each({slideDown:K("show", 1), slideUp:K("hide", 1), slideToggle:K("toggle", 1), fadeIn:{opacity:"show"}, fadeOut:{opacity:"hide"}}, function (a, b) {
		c.fn[a] = function (d, f) {
			return this.animate(b, d, f)
		}
	});
	c.extend({speed:function (a, b, d) {
		var f = a && typeof a === "object" ? a : {complete:d || !d && b || c.isFunction(a) && a, duration:a, easing:d && b || b && !c.isFunction(b) && b};
		f.duration = c.fx.off ? 0 : typeof f.duration === "number" ? f.duration : c.fx.speeds[f.duration] || c.fx.speeds._default;
		f.old = f.complete;
		f.complete = function () {
			f.queue !== false && c(this).dequeue();
			c.isFunction(f.old) && f.old.call(this)
		};
		return f
	}, easing:{linear:function (a, b, d, f) {
		return d + f * a
	}, swing:function (a, b, d, f) {
		return(-Math.cos(a * Math.PI) / 2 + 0.5) * f + d
	}}, timers:[], fx:function (a, b, d) {
		this.options = b;
		this.elem = a;
		this.prop = d;
		if (!b.orig)b.orig = {}
	}});
	c.fx.prototype = {update:function () {
		this.options.step && this.options.step.call(this.elem, this.now, this);
		(c.fx.step[this.prop] || c.fx.step._default)(this);
		if ((this.prop === "height" || this.prop === "width") && this.elem.style)this.elem.style.display = "block"
	}, cur:function (a) {
		if (this.elem[this.prop] != null && (!this.elem.style || this.elem.style[this.prop] == null))return this.elem[this.prop];
		return(a = parseFloat(c.css(this.elem, this.prop, a))) && a > -10000 ? a : parseFloat(c.curCSS(this.elem, this.prop)) || 0
	}, custom:function (a, b, d) {
		function f(j) {
			return e.step(j)
		}

		this.startTime = J();
		this.start = a;
		this.end = b;
		this.unit = d || this.unit || "px";
		this.now = this.start;
		this.pos = this.state = 0;
		var e = this;
		f.elem = this.elem;
		if (f() && c.timers.push(f) && !W)W = setInterval(c.fx.tick, 13)
	}, show:function () {
		this.options.orig[this.prop] = c.style(this.elem, this.prop);
		this.options.show = true;
		this.custom(this.prop === "width" || this.prop === "height" ? 1 : 0, this.cur());
		c(this.elem).show()
	}, hide:function () {
		this.options.orig[this.prop] = c.style(this.elem, this.prop);
		this.options.hide = true;
		this.custom(this.cur(), 0)
	}, step:function (a) {
		var b = J(), d = true;
		if (a || b >= this.options.duration + this.startTime) {
			this.now = this.end;
			this.pos = this.state = 1;
			this.update();
			this.options.curAnim[this.prop] = true;
			for (var f in this.options.curAnim)if (this.options.curAnim[f] !== true)d = false;
			if (d) {
				if (this.options.display != null) {
					this.elem.style.overflow = this.options.overflow;
					a = c.data(this.elem, "olddisplay");
					this.elem.style.display = a ? a : this.options.display;
					if (c.css(this.elem, "display") === "none")this.elem.style.display = "block"
				}
				this.options.hide && c(this.elem).hide();
				if (this.options.hide || this.options.show)for (var e in this.options.curAnim)c.style(this.elem, e, this.options.orig[e]);
				this.options.complete.call(this.elem)
			}
			return false
		} else {
			e = b - this.startTime;
			this.state = e / this.options.duration;
			a = this.options.easing || (c.easing.swing ? "swing" : "linear");
			this.pos = c.easing[this.options.specialEasing && this.options.specialEasing[this.prop] || a](this.state, e, 0, 1, this.options.duration);
			this.now = this.start + (this.end - this.start) * this.pos;
			this.update()
		}
		return true
	}};
	c.extend(c.fx, {tick:function () {
		for (var a = c.timers, b = 0; b < a.length; b++)a[b]() || a.splice(b--, 1);
		a.length || c.fx.stop()
	}, stop:function () {
		clearInterval(W);
		W = null
	}, speeds:{slow:600, fast:200, _default:1400}, step:{opacity:function (a) {
		c.style(a.elem, "opacity", a.now)
	}, _default:function (a) {
		if (a.elem.style && a.elem.style[a.prop] != null)a.elem.style[a.prop] = (a.prop === "width" || a.prop === "height" ? Math.max(0, a.now) : a.now) + a.unit; else a.elem[a.prop] = a.now
	}}});
	if (c.expr && c.expr.filters)c.expr.filters.animated = function (a) {
		return c.grep(c.timers,function (b) {
			return a === b.elem
		}).length
	};
	c.fn.offset = "getBoundingClientRect"in s.documentElement ? function (a) {
		var b = this[0];
		if (a)return this.each(function (e) {
			c.offset.setOffset(this, a, e)
		});
		if (!b || !b.ownerDocument)return null;
		if (b === b.ownerDocument.body)return c.offset.bodyOffset(b);
		var d = b.getBoundingClientRect(), f = b.ownerDocument;
		b = f.body;
		f = f.documentElement;
		return{top:d.top + (self.pageYOffset || c.support.boxModel && f.scrollTop || b.scrollTop) - (f.clientTop || b.clientTop || 0), left:d.left + (self.pageXOffset || c.support.boxModel && f.scrollLeft || b.scrollLeft) - (f.clientLeft || b.clientLeft || 0)}
	} : function (a) {
		var b = this[0];
		if (a)return this.each(function (r) {
			c.offset.setOffset(this, a, r)
		});
		if (!b || !b.ownerDocument)return null;
		if (b === b.ownerDocument.body)return c.offset.bodyOffset(b);
		c.offset.initialize();
		var d = b.offsetParent, f = b, e = b.ownerDocument, j, i = e.documentElement, o = e.body;
		f = (e = e.defaultView) ? e.getComputedStyle(b, null) : b.currentStyle;
		for (var k = b.offsetTop, n = b.offsetLeft; (b = b.parentNode) && b !== o && b !== i;) {
			if (c.offset.supportsFixedPosition && f.position === "fixed")break;
			j = e ? e.getComputedStyle(b, null) : b.currentStyle;
			k -= b.scrollTop;
			n -= b.scrollLeft;
			if (b === d) {
				k += b.offsetTop;
				n += b.offsetLeft;
				if (c.offset.doesNotAddBorder && !(c.offset.doesAddBorderForTableAndCells && /^t(able|d|h)$/i.test(b.nodeName))) {
					k += parseFloat(j.borderTopWidth) || 0;
					n += parseFloat(j.borderLeftWidth) || 0
				}
				f = d;
				d = b.offsetParent
			}
			if (c.offset.subtractsBorderForOverflowNotVisible && j.overflow !== "visible") {
				k += parseFloat(j.borderTopWidth) || 0;
				n += parseFloat(j.borderLeftWidth) || 0
			}
			f = j
		}
		if (f.position === "relative" || f.position === "static") {
			k += o.offsetTop;
			n += o.offsetLeft
		}
		if (c.offset.supportsFixedPosition && f.position === "fixed") {
			k += Math.max(i.scrollTop, o.scrollTop);
			n += Math.max(i.scrollLeft, o.scrollLeft)
		}
		return{top:k, left:n}
	};
	c.offset = {initialize:function () {
		var a = s.body, b = s.createElement("div"), d, f, e, j = parseFloat(c.curCSS(a, "marginTop", true)) || 0;
		c.extend(b.style, {position:"absolute", top:0, left:0, margin:0, border:0, width:"1px", height:"1px", visibility:"hidden"});
		b.innerHTML = "<div style='position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;'><div></div></div><table style='position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;' cellpadding='0' cellspacing='0'><tr><td></td></tr></table>";
		a.insertBefore(b, a.firstChild);
		d = b.firstChild;
		f = d.firstChild;
		e = d.nextSibling.firstChild.firstChild;
		this.doesNotAddBorder = f.offsetTop !== 5;
		this.doesAddBorderForTableAndCells = e.offsetTop === 5;
		f.style.position = "fixed";
		f.style.top = "20px";
		this.supportsFixedPosition = f.offsetTop === 20 || f.offsetTop === 15;
		f.style.position = f.style.top = "";
		d.style.overflow = "hidden";
		d.style.position = "relative";
		this.subtractsBorderForOverflowNotVisible = f.offsetTop === -5;
		this.doesNotIncludeMarginInBodyOffset = a.offsetTop !== j;
		a.removeChild(b);
		c.offset.initialize = c.noop
	}, bodyOffset:function (a) {
		var b = a.offsetTop, d = a.offsetLeft;
		c.offset.initialize();
		if (c.offset.doesNotIncludeMarginInBodyOffset) {
			b += parseFloat(c.curCSS(a, "marginTop", true)) || 0;
			d += parseFloat(c.curCSS(a, "marginLeft", true)) || 0
		}
		return{top:b, left:d}
	}, setOffset:function (a, b, d) {
		if (/static/.test(c.curCSS(a, "position")))a.style.position = "relative";
		var f = c(a), e = f.offset(), j = parseInt(c.curCSS(a, "top", true), 10) || 0, i = parseInt(c.curCSS(a, "left", true), 10) || 0;
		if (c.isFunction(b))b = b.call(a, d, e);
		d = {top:b.top - e.top + j, left:b.left - e.left + i};
		"using"in b ? b.using.call(a, d) : f.css(d)
	}};
	c.fn.extend({position:function () {
		if (!this[0])return null;
		var a = this[0], b = this.offsetParent(), d = this.offset(), f = /^body|html$/i.test(b[0].nodeName) ? {top:0, left:0} : b.offset();
		d.top -= parseFloat(c.curCSS(a, "marginTop", true)) || 0;
		d.left -= parseFloat(c.curCSS(a, "marginLeft", true)) || 0;
		f.top += parseFloat(c.curCSS(b[0], "borderTopWidth", true)) || 0;
		f.left += parseFloat(c.curCSS(b[0], "borderLeftWidth", true)) || 0;
		return{top:d.top - f.top, left:d.left - f.left}
	}, offsetParent:function () {
		return this.map(function () {
			for (var a = this.offsetParent || s.body; a && !/^body|html$/i.test(a.nodeName) && c.css(a, "position") === "static";)a = a.offsetParent;
			return a
		})
	}});
	c.each(["Left", "Top"], function (a, b) {
		var d = "scroll" + b;
		c.fn[d] = function (f) {
			var e = this[0], j;
			if (!e)return null;
			if (f !== w)return this.each(function () {
				if (j = wa(this))j.scrollTo(!a ? f : c(j).scrollLeft(), a ? f : c(j).scrollTop()); else this[d] = f
			}); else return(j = wa(e)) ? "pageXOffset"in j ? j[a ? "pageYOffset" : "pageXOffset"] : c.support.boxModel && j.document.documentElement[d] || j.document.body[d] : e[d]
		}
	});
	c.each(["Height", "Width"], function (a, b) {
		var d = b.toLowerCase();
		c.fn["inner" + b] = function () {
			return this[0] ? c.css(this[0], d, false, "padding") : null
		};
		c.fn["outer" + b] = function (f) {
			return this[0] ? c.css(this[0], d, false, f ? "margin" : "border") : null
		};
		c.fn[d] = function (f) {
			var e = this[0];
			if (!e)return f == null ? null : this;
			if (c.isFunction(f))return this.each(function (j) {
				var i = c(this);
				i[d](f.call(this, j, i[d]()))
			});
			return"scrollTo"in e && e.document ? e.document.compatMode === "CSS1Compat" && e.document.documentElement["client" + b] || e.document.body["client" + b] : e.nodeType === 9 ? Math.max(e.documentElement["client" + b], e.body["scroll" + b], e.documentElement["scroll" + b], e.body["offset" + b], e.documentElement["offset" + b]) : f === w ? c.css(e, d) : this.css(d, typeof f === "string" ? f : f + "px")
		}
	});
	A.SsbBase = A.$ = c
})(window);
(function ($) {
	$.extend({xml2json:function (xml, extended) {
		if (!xml)return{};
		function parseXML(node, simple) {
			if (!node)return null;
			var txt = '', obj = null, att = null;
			var nt = node.nodeType, nn = jsVar(node.localName || node.nodeName);
			var nv = node.text || node.nodeValue || '';
			if (node.childNodes) {
				if (node.childNodes.length > 0) {
					$.each(node.childNodes, function (n, cn) {
						var cnt = cn.nodeType, cnn = jsVar(cn.localName || cn.nodeName);
						var cnv = cn.text || cn.nodeValue || '';
						if (cnt == 8) {
							return
						} else if (cnt == 3 || cnt == 4 || !cnn) {
							if (cnv.match(/^\s+$/)) {
								return
							}
							;
							txt += cnv.replace(/^\s+/, '').replace(/\s+$/, '')
						} else {
							obj = obj || {};
							if (obj[cnn]) {
								if (!obj[cnn].length)obj[cnn] = myArr(obj[cnn]);
								obj[cnn][obj[cnn].length] = parseXML(cn, true);
								obj[cnn].length = obj[cnn].length
							} else {
								obj[cnn] = parseXML(cn)
							}
						}
					})
				}
			}
			;
			if (node.attributes) {
				if (node.attributes.length > 0) {
					att = {};
					obj = obj || {};
					$.each(node.attributes, function (a, at) {
						var atn = jsVar(at.name), atv = at.value;
						att[atn] = atv;
						if (obj[atn]) {
							if (!obj[atn].length)obj[atn] = myArr(obj[atn]);
							obj[atn][obj[atn].length] = atv;
							obj[atn].length = obj[atn].length
						} else {
							obj[atn] = atv
						}
					})
				}
			}
			;
			if (obj) {
				obj = $.extend((txt != '' ? new String(txt) : {}), obj || {});
				txt = (obj.text) ? (typeof(obj.text) == 'object' ? obj.text : [obj.text || '']).concat([txt]) : txt;
				if (txt)obj.text = txt;
				txt = ''
			}
			;
			var out = obj || txt;
			if (extended) {
				if (txt)out = {};
				txt = out.text || txt || '';
				if (txt)out.text = txt;
				if (!simple)out = myArr(out)
			}
			;
			return out
		}

		;
		var jsVar = function (s) {
			return String(s || '').replace(/-/g, "_")
		};
		var isNum = function (s) {
			return(typeof s == "number") || String((s && typeof s == "string") ? s : '').test(/^((-)?([0-9]*)((\.{0,1})([0-9]+))?$)/)
		};
		var myArr = function (o) {
			if (!o.length)o = [o];
			o.length = o.length;
			return o
		};
		if (typeof xml == 'string')xml = $.text2xml(xml);
		if (!xml.nodeType)return;
		if (xml.nodeType == 3 || xml.nodeType == 4)return xml.nodeValue;
		var root = (xml.nodeType == 9) ? xml.documentElement : xml;
		var out = parseXML(root, true);
		xml = null;
		root = null;
		return out
	}, text2xml:function (str) {
		var out;
		try {
			var xml = ($.browser.msie) ? new ActiveXObject("Microsoft.XMLDOM") : new DOMParser();
			xml.async = false
		} catch (e) {
			throw new Error("XML Parser could not be instantiated")
		}
		;
		try {
			if ($.browser.msie)out = (xml.loadXML(str)) ? xml : false; else out = xml.parseFromString(str, "text/xml")
		} catch (e) {
			throw new Error("Error parsing XML string")
		}
		;
		return out
	}})
})(SsbBase);
(function ($) {
	$.fn.touchwipe = function (settings) {
		if ($.browser.msie == true)return;
		var config = {min_move_x:20, wipeLeft:function () {
		}, wipeRight:function () {
		}, preventDefaultEvents:false};
		if (settings)$.extend(config, settings);
		this.each(function () {
			var startX;
			var isMoving = false;

			function cancelTouch() {
				this.removeEventListener('touchmove', onTouchMove);
				startX = null;
				isMoving = false
			}

			function onTouchMove(e) {
				if (config.preventDefaultEvents) {
					e.preventDefault()
				}
				if (isMoving) {
					var x = e.touches[0].pageX;
					var dx = startX - x;
					if (Math.abs(dx) >= config.min_move_x) {
						cancelTouch();
						if (dx > 0) {
							config.wipeLeft()
						} else {
							config.wipeRight()
						}
					}
				}
			}

			function onTouchStart(e) {
				if (e.touches.length == 1) {
					startX = e.touches[0].pageX;
					isMoving = true;
					this.addEventListener('touchmove', onTouchMove, false)
				}
			}

			this.addEventListener('touchstart', onTouchStart, false)
		});
		return this
	}
})(SsbBase);
(function ($) {
	$.cssRule = function (Selector, Property, Value) {
		if (typeof Selector == "object") {
			$.each(Selector, function (NewSelector, NewProperty) {
				$.cssRule(NewSelector, NewProperty)
			});
			return
		}
		if ((typeof Selector == "string") && (Selector.indexOf(":") > -1) && (Property == undefined) && (Value == undefined)) {
			Data = Selector.split("{");
			Data[1] = Data[1].replace(/\}/, "");
			$.cssRule($.trim(Data[0]), $.trim(Data[1]));
			return
		}
		if ((typeof Selector == "string") && (Selector.indexOf(",") > -1)) {
			Multi = Selector.split(",");
			for (x = 0; x < Multi.length; x++) {
				Multi[x] = $.trim(Multi[x]);
				if (Multi[x] != "")$.cssRule(Multi[x], Property, Value)
			}
			return
		}
		if (typeof Property == "object") {
			if (Property.length == undefined) {
				$.each(Property, function (NewProperty, NewValue) {
					$.cssRule(Selector + " " + NewProperty, NewValue)
				})
			} else if ((Property.length == 2) && (typeof Property[0] == "string") && (typeof Property[1] == "string")) {
				$.cssRule(Selector, Property[0], Property[1])
			} else {
				for (x1 = 0; x1 < Property.length; x1++) {
					$.cssRule(Selector, Property[x1], Value)
				}
			}
			return
		}
		if ((typeof Property == "string") && (Property.indexOf("{") > -1) && (Property.indexOf("}") > -1)) {
			Property = Property.replace(/\{/, "").replace(/\}/, "")
		}
		if ((typeof Property == "string") && (Property.indexOf(";") > -1)) {
			Multi1 = Property.split(";");
			for (x2 = 0; x2 < Multi1.length; x2++) {
				$.cssRule(Selector, Multi1[x2], undefined)
			}
			return
		}
		if ((typeof Property == "string") && (Property.indexOf(":") > -1)) {
			Multi3 = Property.split(":");
			$.cssRule(Selector, Multi3[0], Multi3[1]);
			return
		}
		if ((typeof Property == "string") && (Property.indexOf(",") > -1)) {
			Multi2 = Property.split(",");
			for (x3 = 0; x3 < Multi2.length; x3++) {
				$.cssRule(Selector, Multi2[x3], Value)
			}
			return
		}
		var ssbStyle = undefined;
		for (var i = 0; i < document.styleSheets.length; i++) {
			if (document.styleSheets[i].title == 'slideshowBoxStyleSheet') {
				ssbStyle = document.styleSheets[i]
			}
		}
		if (typeof ssbStyle != 'object') {
			if (typeof document.createElementNS != 'undefined') {
				var ssbStyle = document.createElementNS("http://www.w3.org/1999/xhtml", "style")
			} else {
				var ssbStyle = document.createElement("style")
			}
			ssbStyle.setAttribute("type", "text/css");
			ssbStyle.setAttribute("media", "screen");
			ssbStyle.setAttribute("title", "slideshowBoxStyleSheet");
			$($("head")[0]).append(ssbStyle);
			for (var i = 0; i < document.styleSheets.length; i++) {
				if (document.styleSheets[i].title == 'slideshowBoxStyleSheet') {
					ssbStyle = document.styleSheets[i]
				}
			}
		}
		if ((Property == undefined) || (Value == undefined))return;
		Selector = $.trim(Selector);
		Property = $.trim(Property);
		Value = $.trim(Value);
		if ((Property == "") || (Value == ""))return;
		if ($.browser.msie) {
			switch (Property) {
				case"float":
					Property = "style-float";
					break
			}
		} else {
			switch (Property) {
				case"float":
					Property = "css-float";
					break
			}
		}
		CssProperty = (Property || "").replace(/\-(\w)/g, function (m, c) {
			return(c.toUpperCase())
		});
		var Rules = (ssbStyle.cssRules || ssbStyle.rules);
		LowerSelector = Selector.toLowerCase();
		for (var i2 = 0, len = Rules.length - 1; i2 < len; i2++) {
			if (Rules[i2].selectorText && (Rules[i2].selectorText.toLowerCase() == LowerSelector)) {
				if (Value != null) {
					Rules[i2].style[CssProperty] = Value;
					return
				} else {
					if (ssbStyle.deleteRule) {
						ssbStyle.deleteRule(i2)
					} else if (ssbStyle.removeRule) {
						ssbStyle.removeRule(i2)
					} else {
						Rules[i2].style.cssText = ""
					}
				}
			}
		}
		if (Property && Value) {
			if (ssbStyle.insertRule) {
				Rules = (ssbStyle.cssRules || ssbStyle.rules);
				ssbStyle.insertRule(Selector + "{ " + Property + ":" + Value + "; }", Rules.length)
			} else if (ssbStyle.addRule) {
				ssbStyle.addRule(Selector, Property + ":" + Value + ";", 0)
			} else {
				throw new Error("Add/insert not enabled.");
			}
		}
	};
	$.tocssRule = function (cssText) {
		matchRes = cssText.match(/(.*?)\{(.*?)\}/);
		while (matchRes) {
			cssText = cssText.replace(/(.*?)\{(.*?)\}/, "");
			$.cssRule(matchRes[1], matchRes[2]);
			matchRes = cssText.match(/(.*?)\{(.*?)\}/)
		}
	}
})(SsbBase);
(function ($) {
	$.fn.canvas = function (where) {
		$(this).each(function () {
			var $this = $(this);
			var w = $this.width();
			var h = $this.height();
			if (w === 0 && $this.css('width') !== '0px') {
				w = parseInt($this.css('width'))
			}
			if (h === 0 && $this.css('height') !== '0px') {
				h = parseInt($this.css('height'))
			}
			if (!where)where = 'under';
			$this.find('.cnvsWrapper').remove();
			$this.find('.cnvsCanvas').remove();
			var $canvas = document.createElement('CANVAS');
			$canvas.className = 'cnvsCanvas';
			$canvas.style.position = 'absolute';
			$canvas.style.top = '0px';
			$canvas.style.left = '0px';
			$canvas.setAttribute('width', w);
			$canvas.setAttribute('height', h);
			$canvas.useExcanvas = false;
			if ((where == 'under' || where == 'over') && $this.html() !== '') {
				$this.wrapInner('<div class="cnvsWrapper" style="position:absolute;top:0px;left:0px;width:100%;height:100%;border:0px;padding:0px;margin:0px;"></div>')
			}
			if (where == 'under' || where == 'unshift') {
				$this.prepend($canvas)
			}
			if (where == 'over' || where == 'push') {
				$this.append($canvas)
			}
			if ($.browser.msie && !$canvas.getContext) {
				var canvas = G_vmlCanvasManager.initElement($($canvas).get(0));
				$canvas = $(canvas);
				$canvas.useExcanvas = true
			}
			this.cnvs = canvasObject($($canvas), w, h);
			if ($.browser.msie) {
				if ($canvas.useExcanvas) {
					var parent = this.cnvs.getTag().parent();
					var child = this.cnvs.getTag()[0].firstChild;
					$(child).width($(parent).css('width'));
					$(child).height($(parent).css('height'))
				} else {
					$canvas.style.width = w + 'px';
					$canvas.style.height = h + 'px'
				}
			}
			return this
		});
		return this
	};
	$.fn.fixIE = function () {
		return;
		$(this).each(function () {
			var parent = this.cnvs.getTag().parent();
			var child = this.cnvs.getTag()[0].firstChild;
			$(child).width($(parent).css('width'));
			$(child).height($(parent).css('height'))
		});
		return this
	};
	$.fn.uncanvas = function () {
		$(this).each(function () {
			this.cnvs.getTag().remove();
			this.cnvs = null
		});
		return this
	};
	$.fn.hidecanvas = function () {
		$(this).each(function () {
			this.cnvs.getTag().hide()
		});
		return this
	};
	$.fn.showcanvas = function () {
		$(this).each(function () {
			this.cnvs.getTag().show()
		});
		return this
	};
	$.fn.canvasraw = function (callback) {
		$(this).each(function () {
			if (callback)eval(callback)(this.cnvs)
		})
	};
	$.fn.canvasinfo = function (info) {
		$(this).each(function () {
			info[info.length] = {};
			info[info.length - 1].width = this.cnvs.w;
			info[info.length - 1].height = this.cnvs.h;
			info[info.length - 1].tag = this.cnvs.$tag;
			info[info.length - 1].context = this.cnvs.c
		})
	};
	$.fn.style = function (style) {
		$(this).each(function () {
			this.cnvs.style(style);
			return this
		});
		return this
	};
	$.fn.beginPath = function () {
		$(this).each(function () {
			this.cnvs.beginPath();
			return this
		});
		return this
	};
	$.fn.closePath = function () {
		$(this).each(function () {
			this.cnvs.closePath();
			return this
		});
		return this
	};
	$.fn.stroke = function () {
		$(this).each(function () {
			this.cnvs.stroke();
			return this
		});
		return this
	};
	$.fn.fill = function () {
		$(this).each(function () {
			this.cnvs.fill();
			return this
		});
		return this
	};
	$.fn.moveTo = function (coord) {
		$(this).each(function () {
			this.cnvs.moveTo(coord);
			return this
		});
		return this
	};
	$.fn.arc = function (coord, settings, style) {
		$(this).each(function () {
			this.cnvs.arc(coord, settings, style);
			return this
		});
		return this
	};
	$.fn.arcTo = function (coord1, coord2, settings, style) {
		$(this).each(function () {
			this.cnvs.arcTo(coord1, coord2, settings, style);
			return this
		});
		return this
	};
	$.fn.bezierCurveTo = function (ref1, ref2, end, style) {
		$(this).each(function () {
			this.cnvs.bezierCurveTo(ref1, ref2, end, style);
			return this
		});
		return this
	};
	$.fn.quadraticCurveTo = function (ref1, end, style) {
		$(this).each(function () {
			this.cnvs.quadraticCurveTo(ref1, end, style);
			return this
		});
		return this
	};
	$.fn.clearRect = function (coord, settings) {
		$(this).each(function () {
			this.cnvs.clearRect(coord, settings);
			return this
		});
		return this
	};
	$.fn.strokeRect = function (coord, settings, style) {
		$(this).each(function () {
			this.cnvs.strokeRect(coord, settings, style);
			return this
		});
		return this
	};
	$.fn.fillRect = function (coord, settings, style) {
		$(this).each(function () {
			this.cnvs.fillRect(coord, settings, style);
			return this
		});
		return this
	};
	$.fn.rect = function (coord, settings, style) {
		$(this).each(function () {
			this.cnvs.rect(coord, settings, style);
			return this
		});
		return this
	};
	$.fn.lineTo = function (end, style) {
		$(this).each(function () {
			this.cnvs.lineTo(end, style);
			return this
		});
		return this
	};
	$.fn.fillText = function (txt, x, y) {
		$(this).each(function () {
			this.cnvs.fillText(txt, x, y);
			return this
		});
		return this
	};
	$.fn.translate = function (x, y) {
		$(this).each(function () {
			this.cnvs.translate(x, y);
			return this
		});
		return this
	};
	$.fn.transform = function (m11, m12, m21, m22, dx, dy) {
		$(this).each(function () {
			this.cnvs.transform(m11, m12, m21, m22, dx, dy);
			return this
		});
		return this
	};
	$.fn.rotate = function (r) {
		$(this).each(function () {
			this.cnvs.rotate(r);
			return this
		});
		return this
	};
	$.fn.save = function () {
		$(this).each(function () {
			this.cnvs.save();
			return this
		});
		return this
	};
	$.fn.restore = function () {
		$(this).each(function () {
			this.cnvs.restore();
			return this
		});
		return this
	};
	$.fn.roundRect = function (coord, settings, radius, style) {
		$(this).each(function () {
			this.cnvs.roundRect(coord, settings, radius, style);
			return this
		});
		return this
	};
	$.fn.polygon = function (start, blocks, settings, style) {
		$(this).each(function () {
			this.cnvs.atomPolygon(start, blocks, settings, style)
		})
	};
	function canvasObject($canvas, width, height) {
		var cnvs = {};
		cnvs.w = width;
		cnvs.h = height;
		cnvs.$tag = $canvas;
		cnvs.c = $canvas.get(0).getContext('2d');
		cnvs.laststyle = {'fillStyle':'rgba( 0, 0, 0, 0.2)', 'strokeStyle':'rgba( 0, 0, 0, 0.5)', 'lineWidth':5};
		cnvs.getContext = function () {
			return this.c
		};
		cnvs.getTag = function () {
			return this.$tag
		};
		cnvs.deg2rad = function (deg) {
			return 2 * 3.14159265 * (deg / 360)
		};
		cnvs.style = function (style) {
			if (style)this.laststyle = style;
			for (var name in this.laststyle)this.c[name] = this.laststyle[name]
		};
		cnvs.fillText = function (txt, x, y) {
			this.c.fillText(txt, x, y)
		};
		cnvs.translate = function (x, y) {
			this.c.translate(x, y)
		};
		cnvs.transform = function (m11, m12, m21, m22, dx, dy) {
			this.c.transform(m11, m12, m21, m22, dx, dy)
		};
		cnvs.roundRect = function (coord, settings, radius, style) {
			settings = $.extend({'width':100, 'height':50}, settings);
			if (style)this.style(style);
			var x = coord[0];
			var y = coord[1];
			var width = settings.width;
			var height = settings.height;
			this.beginPath();
			this.moveTo([x, y + radius]);
			this.lineTo([x, y + height - radius]);
			this.quadraticCurveTo([x, y + height], [x + radius, y + height]);
			this.lineTo([x + width - radius, y + height]);
			this.quadraticCurveTo([x + width, y + height], [x + width, y + height - radius]);
			this.lineTo([x + width, y + radius]);
			this.quadraticCurveTo([x + width, y], [x + width - radius, y]);
			this.lineTo([x + radius, y]);
			this.quadraticCurveTo([x, y], [x, y + radius]);
			this.fill();
			if (typeof this.laststyle.lineWidth !== 'undefined' && this.laststyle.lineWidth > 0) {
				this.stroke()
			}
		};
		cnvs.rotate = function (r) {
			this.c.rotate(r)
		};
		cnvs.save = function () {
			this.c.save()
		};
		cnvs.restore = function () {
			this.c.restore()
		};
		cnvs.beginPath = function () {
			this.c.beginPath()
		};
		cnvs.closePath = function () {
			this.c.closePath()
		};
		cnvs.stroke = function () {
			this.c.stroke()
		};
		cnvs.fill = function () {
			this.c.fill()
		};
		cnvs.moveTo = function (coord) {
			this.c.moveTo(coord[0], coord[1])
		};
		cnvs.arc = function (coord, settings, style) {
			settings = $.extend({'radius':50, 'startAngle':0, 'endAngle':360, 'clockwise':true}, settings);
			if (style)this.style(style);
			this.c.arc(coord[0], coord[1], settings.radius, this.deg2rad(settings.startAngle), this.deg2rad(settings.endAngle), settings.clockwise ? 1 : 0)
		};
		cnvs.arcTo = function (coord1, coord2, settings, style) {
			settings = $.extend({'radius':50}, settings);
			if (style)this.style(style);
			this.c.arcTo(coord1[0], coord1[1], coord2[0], coord2[1], settings.radius)
		};
		cnvs.bezierCurveTo = function (ref1, ref2, end, style) {
			if (style)this.style(style);
			this.c.bezierCurveTo(ref1[0], ref1[1], ref2[0], ref2[1], end[0], end[1])
		};
		cnvs.quadraticCurveTo = function (ref1, end, style) {
			if (style)this.style(style);
			this.c.quadraticCurveTo(ref1[0], ref1[1], end[0], end[1])
		};
		cnvs.clearRect = function (coord, settings, style) {
			if (!coord)coord = [0, 0];
			settings = $.extend({'width':this.w, 'height':this.h}, settings);
			this.c.clearRect(coord[0], coord[1], settings.width, settings.height)
		};
		cnvs.fillRect = function (coord, settings, style) {
			settings = $.extend({'width':100, 'height':50}, settings);
			if (style)this.style(style);
			this.c.fillRect(coord[0], coord[1], settings.width, settings.height)
		};
		cnvs.strokeRect = function (coord, settings, style) {
			settings = $.extend({'width':100, 'height':50}, settings);
			if (style)this.style(style);
			this.c.strokeRect(coord[0], coord[1], settings.width, settings.height)
		};
		cnvs.rect = function (coord, settings, style) {
			settings = $.extend({'width':100, 'height':50}, settings);
			if (style)this.style(style);
			this.c.rect(coord[0], coord[1], settings.width, settings.height)
		};
		cnvs.lineTo = function (end, style) {
			if (style)this.style(style);
			this.c.lineTo(end[0], end[1])
		};
		cnvs.path = function (blocks) {
			for (var i = 0; i < blocks.length; i++) {
				var arg1 = null;
				var arg2 = null;
				var arg3 = null;
				var arg4 = null;
				if (blocks[i].length >= 2)arg1 = blocks[i][1];
				if (blocks[i].length >= 3)arg2 = blocks[i][2];
				if (blocks[i].length >= 4)arg3 = blocks[i][3];
				if (blocks[i].length >= 5)arg4 = blocks[i][4];
				if (blocks[i][0] == 'moveTo')this.moveTo(arg1);
				if (blocks[i][0] == 'arc')this.arc(arg1, arg2, arg3);
				if (blocks[i][0] == 'arcTo')this.arcTo(arg1, arg2, arg3, arg4);
				if (blocks[i][0] == 'bezierCurveTo')this.bezierCurveTo(arg1, arg2, arg3, arg4);
				if (blocks[i][0] == 'quadraticCurveTo')this.quadraticCurveTo(arg1, arg2, arg3);
				if (blocks[i][0] == 'lineTo')this.lineTo(arg1, arg2)
			}
		};
		cnvs.atomPolygon = function (start, blocks, settings, style) {
			settings = $.extend({'fill':false, 'stroke':true, 'close':false}, settings);
			this.style(style);
			if (settings.stroke) {
				this.beginPath();
				this.moveTo(start);
				this.path(blocks);
				if (settings.close) {
					this.moveTo(start);
					this.closePath()
				}
				this.c.fillStyle = 'rgba( 0, 0, 0, 0)';
				this.stroke()
			}
			this.style(style);
			if (settings.fill) {
				this.beginPath();
				this.moveTo(start);
				this.path(blocks);
				if (settings.close) {
					this.moveTo(start);
					this.closePath()
				}
				this.c.strokeStyle = 'rgba( 0, 0, 0, 0)';
				this.fill()
			}
			this.style(style)
		};
		return cnvs
	}
})(SsbBase);
if (!document.createElement('canvas').getContext) {
	(function () {
		var m = Math;
		var mr = m.round;
		var ms = m.sin;
		var mc = m.cos;
		var abs = m.abs;
		var sqrt = m.sqrt;
		var Z = 10;
		var Z2 = Z / 2;
		var IE_VERSION = +navigator.userAgent.match(/MSIE ([\d.]+)?/)[1];

		function getContext() {
			return this.context_ || (this.context_ = new CanvasRenderingContext2D_(this))
		}

		var slice = Array.prototype.slice;

		function bind(f, obj, var_args) {
			var a = slice.call(arguments, 2);
			return function () {
				return f.apply(obj, a.concat(slice.call(arguments)))
			}
		}

		function encodeHtmlAttribute(s) {
			return String(s).replace(/&/g, '&amp;').replace(/"/g, '&quot;')
		}

		function addNamespace(doc, prefix, urn) {
			if (!doc.namespaces[prefix]) {
				doc.namespaces.add(prefix, urn, '#default#VML')
			}
		}

		function addNamespacesAndStylesheet(doc) {
			addNamespace(doc, 'g_vml_', 'urn:schemas-microsoft-com:vml');
			addNamespace(doc, 'g_o_', 'urn:schemas-microsoft-com:office:office');
			if (!doc.styleSheets['ex_canvas_']) {
				var ss = doc.createStyleSheet();
				ss.owningElement.id = 'ex_canvas_';
				ss.cssText = 'canvas{display:inline-block;overflow:hidden;' + 'text-align:left;width:300px;height:150px}'
			}
		}

		addNamespacesAndStylesheet(document);
		var G_vmlCanvasManager_ = {init:function (opt_doc) {
			var doc = opt_doc || document;
			doc.createElement('canvas');
			doc.attachEvent('onreadystatechange', bind(this.init_, this, doc))
		}, init_:function (doc) {
			var els = doc.getElementsByTagName('canvas');
			for (var i = 0; i < els.length; i++) {
				this.initElement(els[i])
			}
		}, initElement:function (el) {
			if (!el.getContext) {
				el.getContext = getContext;
				addNamespacesAndStylesheet(el.ownerDocument);
				el.innerHTML = '';
				el.attachEvent('onpropertychange', onPropertyChange);
				el.attachEvent('onresize', onResize);
				var attrs = el.attributes;
				if (attrs.width && attrs.width.specified) {
					el.style.width = attrs.width.nodeValue + 'px'
				} else {
					el.width = el.clientWidth
				}
				if (attrs.height && attrs.height.specified) {
					el.style.height = attrs.height.nodeValue + 'px'
				} else {
					el.height = el.clientHeight
				}
			}
			return el
		}};

		function onPropertyChange(e) {
			var el = e.srcElement;
			switch (e.propertyName) {
				case'width':
					el.getContext().clearRect();
					el.style.width = el.attributes.width.nodeValue + 'px';
					el.firstChild.style.width = el.clientWidth + 'px';
					break;
				case'height':
					el.getContext().clearRect();
					el.style.height = el.attributes.height.nodeValue + 'px';
					el.firstChild.style.height = el.clientHeight + 'px';
					break
			}
		}

		function onResize(e) {
			var el = e.srcElement;
			if (el.firstChild) {
				el.firstChild.style.width = el.clientWidth + 'px';
				el.firstChild.style.height = el.clientHeight + 'px'
			}
		}

		G_vmlCanvasManager_.init();
		var decToHex = [];
		for (var i = 0; i < 16; i++) {
			for (var j = 0; j < 16; j++) {
				decToHex[i * 16 + j] = i.toString(16) + j.toString(16)
			}
		}
		function createMatrixIdentity() {
			return[
				[1, 0, 0],
				[0, 1, 0],
				[0, 0, 1]
			]
		}

		function matrixMultiply(m1, m2) {
			var result = createMatrixIdentity();
			for (var x = 0; x < 3; x++) {
				for (var y = 0; y < 3; y++) {
					var sum = 0;
					for (var z = 0; z < 3; z++) {
						sum += m1[x][z] * m2[z][y]
					}
					result[x][y] = sum
				}
			}
			return result
		}

		function copyState(o1, o2) {
			o2.fillStyle = o1.fillStyle;
			o2.lineCap = o1.lineCap;
			o2.lineJoin = o1.lineJoin;
			o2.lineWidth = o1.lineWidth;
			o2.miterLimit = o1.miterLimit;
			o2.shadowBlur = o1.shadowBlur;
			o2.shadowColor = o1.shadowColor;
			o2.shadowOffsetX = o1.shadowOffsetX;
			o2.shadowOffsetY = o1.shadowOffsetY;
			o2.strokeStyle = o1.strokeStyle;
			o2.globalAlpha = o1.globalAlpha;
			o2.font = o1.font;
			o2.textAlign = o1.textAlign;
			o2.textBaseline = o1.textBaseline;
			o2.arcScaleX_ = o1.arcScaleX_;
			o2.arcScaleY_ = o1.arcScaleY_;
			o2.lineScale_ = o1.lineScale_
		}

		var colorData = {aliceblue:'#F0F8FF', antiquewhite:'#FAEBD7', aquamarine:'#7FFFD4', azure:'#F0FFFF', beige:'#F5F5DC', bisque:'#FFE4C4', black:'#000000', blanchedalmond:'#FFEBCD', blueviolet:'#8A2BE2', brown:'#A52A2A', burlywood:'#DEB887', cadetblue:'#5F9EA0', chartreuse:'#7FFF00', chocolate:'#D2691E', coral:'#FF7F50', cornflowerblue:'#6495ED', cornsilk:'#FFF8DC', crimson:'#DC143C', cyan:'#00FFFF', darkblue:'#00008B', darkcyan:'#008B8B', darkgoldenrod:'#B8860B', darkgray:'#A9A9A9', darkgreen:'#006400', darkgrey:'#A9A9A9', darkkhaki:'#BDB76B', darkmagenta:'#8B008B', darkolivegreen:'#556B2F', darkorange:'#FF8C00', darkorchid:'#9932CC', darkred:'#8B0000', darksalmon:'#E9967A', darkseagreen:'#8FBC8F', darkslateblue:'#483D8B', darkslategray:'#2F4F4F', darkslategrey:'#2F4F4F', darkturquoise:'#00CED1', darkviolet:'#9400D3', deeppink:'#FF1493', deepskyblue:'#00BFFF', dimgray:'#696969', dimgrey:'#696969', dodgerblue:'#1E90FF', firebrick:'#B22222', floralwhite:'#FFFAF0', forestgreen:'#228B22', gainsboro:'#DCDCDC', ghostwhite:'#F8F8FF', gold:'#FFD700', goldenrod:'#DAA520', grey:'#808080', greenyellow:'#ADFF2F', honeydew:'#F0FFF0', hotpink:'#FF69B4', indianred:'#CD5C5C', indigo:'#4B0082', ivory:'#FFFFF0', khaki:'#F0E68C', lavender:'#E6E6FA', lavenderblush:'#FFF0F5', lawngreen:'#7CFC00', lemonchiffon:'#FFFACD', lightblue:'#ADD8E6', lightcoral:'#F08080', lightcyan:'#E0FFFF', lightgoldenrodyellow:'#FAFAD2', lightgreen:'#90EE90', lightgrey:'#D3D3D3', lightpink:'#FFB6C1', lightsalmon:'#FFA07A', lightseagreen:'#20B2AA', lightskyblue:'#87CEFA', lightslategray:'#778899', lightslategrey:'#778899', lightsteelblue:'#B0C4DE', lightyellow:'#FFFFE0', limegreen:'#32CD32', linen:'#FAF0E6', magenta:'#FF00FF', mediumaquamarine:'#66CDAA', mediumblue:'#0000CD', mediumorchid:'#BA55D3', mediumpurple:'#9370DB', mediumseagreen:'#3CB371', mediumslateblue:'#7B68EE', mediumspringgreen:'#00FA9A', mediumturquoise:'#48D1CC', mediumvioletred:'#C71585', midnightblue:'#191970', mintcream:'#F5FFFA', mistyrose:'#FFE4E1', moccasin:'#FFE4B5', navajowhite:'#FFDEAD', oldlace:'#FDF5E6', olivedrab:'#6B8E23', orange:'#FFA500', orangered:'#FF4500', orchid:'#DA70D6', palegoldenrod:'#EEE8AA', palegreen:'#98FB98', paleturquoise:'#AFEEEE', palevioletred:'#DB7093', papayawhip:'#FFEFD5', peachpuff:'#FFDAB9', peru:'#CD853F', pink:'#FFC0CB', plum:'#DDA0DD', powderblue:'#B0E0E6', rosybrown:'#BC8F8F', royalblue:'#4169E1', saddlebrown:'#8B4513', salmon:'#FA8072', sandybrown:'#F4A460', seagreen:'#2E8B57', seashell:'#FFF5EE', sienna:'#A0522D', skyblue:'#87CEEB', slateblue:'#6A5ACD', slategray:'#708090', slategrey:'#708090', snow:'#FFFAFA', springgreen:'#00FF7F', steelblue:'#4682B4', tan:'#D2B48C', thistle:'#D8BFD8', tomato:'#FF6347', turquoise:'#40E0D0', violet:'#EE82EE', wheat:'#F5DEB3', whitesmoke:'#F5F5F5', yellowgreen:'#9ACD32'};

		function getRgbHslContent(styleString) {
			var start = styleString.indexOf('(', 3);
			var end = styleString.indexOf(')', start + 1);
			var parts = styleString.substring(start + 1, end).split(',');
			if (parts.length != 4 || styleString.charAt(3) != 'a') {
				parts[3] = 1
			}
			return parts
		}

		function aP(s) {
			return parseFloat(s) / 100
		}

		function clamp(v, min, max) {
			return Math.min(max, Math.max(min, v))
		}

		function hslToRgb(parts) {
			var r, g, b, h, s, l;
			h = parseFloat(parts[0]) / 360 % 360;
			if (h < 0)h++;
			s = clamp(aP(parts[1]), 0, 1);
			l = clamp(aP(parts[2]), 0, 1);
			if (s == 0) {
				r = g = b = l
			} else {
				var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
				var p = 2 * l - q;
				r = hueToRgb(p, q, h + 1 / 3);
				g = hueToRgb(p, q, h);
				b = hueToRgb(p, q, h - 1 / 3)
			}
			return'#' + decToHex[Math.floor(r * 255)] + decToHex[Math.floor(g * 255)] + decToHex[Math.floor(b * 255)]
		}

		function hueToRgb(m1, m2, h) {
			if (h < 0)h++;
			if (h > 1)h--;
			if (6 * h < 1)return m1 + (m2 - m1) * 6 * h; else if (2 * h < 1)return m2; else if (3 * h < 2)return m1 + (m2 - m1) * (2 / 3 - h) * 6; else return m1
		}

		var processStyleCache = {};

		function processStyle(styleString) {
			if (styleString in processStyleCache) {
				return processStyleCache[styleString]
			}
			var str, alpha = 1;
			styleString = String(styleString);
			if (styleString.charAt(0) == '#') {
				str = styleString
			} else if (/^rgb/.test(styleString)) {
				var parts = getRgbHslContent(styleString);
				var str = '#', n;
				for (var i = 0; i < 3; i++) {
					if (parts[i].indexOf('%') != -1) {
						n = Math.floor(aP(parts[i]) * 255)
					} else {
						n = +parts[i]
					}
					str += decToHex[clamp(n, 0, 255)]
				}
				alpha = +parts[3]
			} else if (/^hsl/.test(styleString)) {
				var parts = getRgbHslContent(styleString);
				str = hslToRgb(parts);
				alpha = parts[3]
			} else {
				str = colorData[styleString] || styleString
			}
			return processStyleCache[styleString] = {color:str, alpha:alpha}
		}

		var DEFAULT_STYLE = {style:'normal', variant:'normal', weight:'normal', size:10, family:'sans-serif'};
		var fontStyleCache = {};

		function processFontStyle(styleString) {
			if (fontStyleCache[styleString]) {
				return fontStyleCache[styleString]
			}
			var el = document.createElement('div');
			var style = el.style;
			try {
				style.font = styleString
			} catch (ex) {
			}
			return fontStyleCache[styleString] = {style:style.fontStyle || DEFAULT_STYLE.style, variant:style.fontVariant || DEFAULT_STYLE.variant, weight:style.fontWeight || DEFAULT_STYLE.weight, size:style.fontSize || DEFAULT_STYLE.size, family:style.fontFamily || DEFAULT_STYLE.family}
		}

		function getComputedStyle(style, element) {
			var computedStyle = {};
			for (var p in style) {
				computedStyle[p] = style[p]
			}
			var canvasFontSize = parseFloat(element.currentStyle.fontSize), fontSize = parseFloat(style.size);
			if (typeof style.size == 'number') {
				computedStyle.size = style.size
			} else if (style.size.indexOf('px') != -1) {
				computedStyle.size = fontSize
			} else if (style.size.indexOf('em') != -1) {
				computedStyle.size = canvasFontSize * fontSize
			} else if (style.size.indexOf('%') != -1) {
				computedStyle.size = (canvasFontSize / 100) * fontSize
			} else if (style.size.indexOf('pt') != -1) {
				computedStyle.size = fontSize / .75
			} else {
				computedStyle.size = canvasFontSize
			}
			computedStyle.size *= 0.981;
			return computedStyle
		}

		function buildStyle(style) {
			return style.style + ' ' + style.variant + ' ' + style.weight + ' ' + style.size + 'px ' + style.family
		}

		var lineCapMap = {'butt':'flat', 'round':'round'};

		function processLineCap(lineCap) {
			return lineCapMap[lineCap] || 'square'
		}

		function CanvasRenderingContext2D_(canvasElement) {
			this.m_ = createMatrixIdentity();
			this.mStack_ = [];
			this.aStack_ = [];
			this.currentPath_ = [];
			this.strokeStyle = '#000';
			this.fillStyle = '#000';
			this.lineWidth = 1;
			this.lineJoin = 'miter';
			this.lineCap = 'butt';
			this.miterLimit = Z * 1;
			this.globalAlpha = 1;
			this.font = '10px sans-serif';
			this.textAlign = 'left';
			this.textBaseline = 'alphabetic';
			this.canvas = canvasElement;
			var cssText = 'width:' + canvasElement.clientWidth + 'px;height:' + canvasElement.clientHeight + 'px;overflow:hidden;position:absolute';
			var el = canvasElement.ownerDocument.createElement('div');
			el.style.cssText = cssText;
			canvasElement.appendChild(el);
			var overlayEl = el.cloneNode(false);
			overlayEl.style.backgroundColor = 'red';
			overlayEl.style.filter = 'alpha(opacity=0)';
			canvasElement.appendChild(overlayEl);
			this.element_ = el;
			this.arcScaleX_ = 1;
			this.arcScaleY_ = 1;
			this.lineScale_ = 1
		}

		var contextPrototype = CanvasRenderingContext2D_.prototype;
		contextPrototype.clearRect = function () {
			if (this.textMeasureEl_) {
				this.textMeasureEl_.removeNode(true);
				this.textMeasureEl_ = null
			}
			this.element_.innerHTML = ''
		};
		contextPrototype.beginPath = function () {
			this.currentPath_ = []
		};
		contextPrototype.moveTo = function (aX, aY) {
			var p = getCoords(this, aX, aY);
			this.currentPath_.push({type:'moveTo', x:p.x, y:p.y});
			this.currentX_ = p.x;
			this.currentY_ = p.y
		};
		contextPrototype.lineTo = function (aX, aY) {
			var p = getCoords(this, aX, aY);
			this.currentPath_.push({type:'lineTo', x:p.x, y:p.y});
			this.currentX_ = p.x;
			this.currentY_ = p.y
		};
		contextPrototype.bezierCurveTo = function (aCP1x, aCP1y, aCP2x, aCP2y, aX, aY) {
			var p = getCoords(this, aX, aY);
			var cp1 = getCoords(this, aCP1x, aCP1y);
			var cp2 = getCoords(this, aCP2x, aCP2y);
			bezierCurveTo(this, cp1, cp2, p)
		};
		function bezierCurveTo(self, cp1, cp2, p) {
			self.currentPath_.push({type:'bezierCurveTo', cp1x:cp1.x, cp1y:cp1.y, cp2x:cp2.x, cp2y:cp2.y, x:p.x, y:p.y});
			self.currentX_ = p.x;
			self.currentY_ = p.y
		}

		contextPrototype.quadraticCurveTo = function (aCPx, aCPy, aX, aY) {
			var cp = getCoords(this, aCPx, aCPy);
			var p = getCoords(this, aX, aY);
			var cp1 = {x:this.currentX_ + 2.0 / 3.0 * (cp.x - this.currentX_), y:this.currentY_ + 2.0 / 3.0 * (cp.y - this.currentY_)};
			var cp2 = {x:cp1.x + (p.x - this.currentX_) / 3.0, y:cp1.y + (p.y - this.currentY_) / 3.0};
			bezierCurveTo(this, cp1, cp2, p)
		};
		contextPrototype.arc = function (aX, aY, aRadius, aStartAngle, aEndAngle, aClockwise) {
			aRadius *= Z;
			var arcType = aClockwise ? 'at' : 'wa';
			var xStart = aX + mc(aStartAngle) * aRadius - Z2;
			var yStart = aY + ms(aStartAngle) * aRadius - Z2;
			var xEnd = aX + mc(aEndAngle) * aRadius - Z2;
			var yEnd = aY + ms(aEndAngle) * aRadius - Z2;
			if (xStart == xEnd && !aClockwise) {
				xStart += 0.125
			}
			var p = getCoords(this, aX, aY);
			var pStart = getCoords(this, xStart, yStart);
			var pEnd = getCoords(this, xEnd, yEnd);
			this.currentPath_.push({type:arcType, x:p.x, y:p.y, radius:aRadius, xStart:pStart.x, yStart:pStart.y, xEnd:pEnd.x, yEnd:pEnd.y})
		};
		contextPrototype.rect = function (aX, aY, aWidth, aHeight) {
			this.moveTo(aX, aY);
			this.lineTo(aX + aWidth, aY);
			this.lineTo(aX + aWidth, aY + aHeight);
			this.lineTo(aX, aY + aHeight);
			this.closePath()
		};
		contextPrototype.strokeRect = function (aX, aY, aWidth, aHeight) {
			var oldPath = this.currentPath_;
			this.beginPath();
			this.moveTo(aX, aY);
			this.lineTo(aX + aWidth, aY);
			this.lineTo(aX + aWidth, aY + aHeight);
			this.lineTo(aX, aY + aHeight);
			this.closePath();
			this.stroke();
			this.currentPath_ = oldPath
		};
		contextPrototype.fillRect = function (aX, aY, aWidth, aHeight) {
			var oldPath = this.currentPath_;
			this.beginPath();
			this.moveTo(aX, aY);
			this.lineTo(aX + aWidth, aY);
			this.lineTo(aX + aWidth, aY + aHeight);
			this.lineTo(aX, aY + aHeight);
			this.closePath();
			this.fill();
			this.currentPath_ = oldPath
		};
		contextPrototype.createLinearGradient = function (aX0, aY0, aX1, aY1) {
			var gradient = new CanvasGradient_('gradient');
			gradient.x0_ = aX0;
			gradient.y0_ = aY0;
			gradient.x1_ = aX1;
			gradient.y1_ = aY1;
			return gradient
		};
		contextPrototype.createRadialGradient = function (aX0, aY0, aR0, aX1, aY1, aR1) {
			var gradient = new CanvasGradient_('gradientradial');
			gradient.x0_ = aX0;
			gradient.y0_ = aY0;
			gradient.r0_ = aR0;
			gradient.x1_ = aX1;
			gradient.y1_ = aY1;
			gradient.r1_ = aR1;
			return gradient
		};
		contextPrototype.drawImage = function (image, var_args) {
			var dx, dy, dw, dh, sx, sy, sw, sh;
			var oldRuntimeWidth = image.runtimeStyle.width;
			var oldRuntimeHeight = image.runtimeStyle.height;
			image.runtimeStyle.width = 'auto';
			image.runtimeStyle.height = 'auto';
			var w = image.width;
			var h = image.height;
			image.runtimeStyle.width = oldRuntimeWidth;
			image.runtimeStyle.height = oldRuntimeHeight;
			if (arguments.length == 3) {
				dx = arguments[1];
				dy = arguments[2];
				sx = sy = 0;
				sw = dw = w;
				sh = dh = h
			} else if (arguments.length == 5) {
				dx = arguments[1];
				dy = arguments[2];
				dw = arguments[3];
				dh = arguments[4];
				sx = sy = 0;
				sw = w;
				sh = h
			} else if (arguments.length == 9) {
				sx = arguments[1];
				sy = arguments[2];
				sw = arguments[3];
				sh = arguments[4];
				dx = arguments[5];
				dy = arguments[6];
				dw = arguments[7];
				dh = arguments[8]
			} else {
				throw Error('Invalid number of arguments');
			}
			var d = getCoords(this, dx, dy);
			var w2 = sw / 2;
			var h2 = sh / 2;
			var vmlStr = [];
			var W = 10;
			var H = 10;
			vmlStr.push(' <g_vml_:group', ' coordsize="', Z * W, ',', Z * H, '"', ' coordorigin="0,0"', ' style="width:', W, 'px;height:', H, 'px;position:absolute;');
			if (this.m_[0][0] != 1 || this.m_[0][1] || this.m_[1][1] != 1 || this.m_[1][0]) {
				var filter = [];
				filter.push('M11=', this.m_[0][0], ',', 'M12=', this.m_[1][0], ',', 'M21=', this.m_[0][1], ',', 'M22=', this.m_[1][1], ',', 'Dx=', mr(d.x / Z), ',', 'Dy=', mr(d.y / Z), '');
				var max = d;
				var c2 = getCoords(this, dx + dw, dy);
				var c3 = getCoords(this, dx, dy + dh);
				var c4 = getCoords(this, dx + dw, dy + dh);
				max.x = m.max(max.x, c2.x, c3.x, c4.x);
				max.y = m.max(max.y, c2.y, c3.y, c4.y);
				vmlStr.push('padding:0 ', mr(max.x / Z), 'px ', mr(max.y / Z), 'px 0;filter:progid:DXImageTransform.Microsoft.Matrix(', filter.join(''), ", sizingmethod='clip');")
			} else {
				vmlStr.push('top:', mr(d.y / Z), 'px;left:', mr(d.x / Z), 'px;')
			}
			vmlStr.push(' ">', '<g_vml_:image src="', image.src, '"', ' style="width:', Z * dw, 'px;', ' height:', Z * dh, 'px"', ' cropleft="', sx / w, '"', ' croptop="', sy / h, '"', ' cropright="', (w - sx - sw) / w, '"', ' cropbottom="', (h - sy - sh) / h, '"', ' />', '</g_vml_:group>');
			this.element_.insertAdjacentHTML('BeforeEnd', vmlStr.join(''))
		};
		contextPrototype.stroke = function (aFill) {
			var lineStr = [];
			var lineOpen = false;
			var W = 10;
			var H = 10;
			lineStr.push('<g_vml_:shape', ' filled="', !!aFill, '"', ' style="position:absolute;width:', W, 'px;height:', H, 'px;"', ' coordorigin="0,0"', ' coordsize="', Z * W, ',', Z * H, '"', ' stroked="', !aFill, '"', ' path="');
			var newSeq = false;
			var min = {x:null, y:null};
			var max = {x:null, y:null};
			for (var i = 0; i < this.currentPath_.length; i++) {
				var p = this.currentPath_[i];
				var c;
				switch (p.type) {
					case'moveTo':
						c = p;
						lineStr.push(' m ', mr(p.x), ',', mr(p.y));
						break;
					case'lineTo':
						lineStr.push(' l ', mr(p.x), ',', mr(p.y));
						break;
					case'close':
						lineStr.push(' x ');
						p = null;
						break;
					case'bezierCurveTo':
						lineStr.push(' c ', mr(p.cp1x), ',', mr(p.cp1y), ',', mr(p.cp2x), ',', mr(p.cp2y), ',', mr(p.x), ',', mr(p.y));
						break;
					case'at':
					case'wa':
						lineStr.push(' ', p.type, ' ', mr(p.x - this.arcScaleX_ * p.radius), ',', mr(p.y - this.arcScaleY_ * p.radius), ' ', mr(p.x + this.arcScaleX_ * p.radius), ',', mr(p.y + this.arcScaleY_ * p.radius), ' ', mr(p.xStart), ',', mr(p.yStart), ' ', mr(p.xEnd), ',', mr(p.yEnd));
						break
				}
				if (p) {
					if (min.x == null || p.x < min.x) {
						min.x = p.x
					}
					if (max.x == null || p.x > max.x) {
						max.x = p.x
					}
					if (min.y == null || p.y < min.y) {
						min.y = p.y
					}
					if (max.y == null || p.y > max.y) {
						max.y = p.y
					}
				}
			}
			lineStr.push(' ">');
			if (!aFill) {
				appendStroke(this, lineStr)
			} else {
				appendFill(this, lineStr, min, max)
			}
			lineStr.push('</g_vml_:shape>');
			this.element_.insertAdjacentHTML('beforeEnd', lineStr.join(''))
		};
		function appendStroke(ctx, lineStr) {
			var a = processStyle(ctx.strokeStyle);
			var color = a.color;
			var opacity = a.alpha * ctx.globalAlpha;
			var lineWidth = ctx.lineScale_ * ctx.lineWidth;
			if (lineWidth < 1) {
				opacity *= lineWidth
			}
			lineStr.push('<g_vml_:stroke', ' opacity="', opacity, '"', ' joinstyle="', ctx.lineJoin, '"', ' miterlimit="', ctx.miterLimit, '"', ' endcap="', processLineCap(ctx.lineCap), '"', ' weight="', lineWidth, 'px"', ' color="', color, '" />')
		}

		function appendFill(ctx, lineStr, min, max) {
			var fillStyle = ctx.fillStyle;
			var arcScaleX = ctx.arcScaleX_;
			var arcScaleY = ctx.arcScaleY_;
			var width = max.x - min.x;
			var height = max.y - min.y;
			if (fillStyle instanceof CanvasGradient_) {
				var angle = 0;
				var focus = {x:0, y:0};
				var shift = 0;
				var expansion = 1;
				if (fillStyle.type_ == 'gradient') {
					var x0 = fillStyle.x0_ / arcScaleX;
					var y0 = fillStyle.y0_ / arcScaleY;
					var x1 = fillStyle.x1_ / arcScaleX;
					var y1 = fillStyle.y1_ / arcScaleY;
					var p0 = getCoords(ctx, x0, y0);
					var p1 = getCoords(ctx, x1, y1);
					var dx = p1.x - p0.x;
					var dy = p1.y - p0.y;
					angle = Math.atan2(dx, dy) * 180 / Math.PI;
					if (angle < 0) {
						angle += 360
					}
					if (angle < 1e-6) {
						angle = 0
					}
				} else {
					var p0 = getCoords(ctx, fillStyle.x0_, fillStyle.y0_);
					focus = {x:(p0.x - min.x) / width, y:(p0.y - min.y) / height};
					width /= arcScaleX * Z;
					height /= arcScaleY * Z;
					var dimension = m.max(width, height);
					shift = 2 * fillStyle.r0_ / dimension;
					expansion = 2 * fillStyle.r1_ / dimension - shift
				}
				var stops = fillStyle.colors_;
				stops.sort(function (cs1, cs2) {
					return cs1.offset - cs2.offset
				});
				var length = stops.length;
				var color1 = stops[0].color;
				var color2 = stops[length - 1].color;
				var opacity1 = stops[0].alpha * ctx.globalAlpha;
				var opacity2 = stops[length - 1].alpha * ctx.globalAlpha;
				var colors = [];
				for (var i = 0; i < length; i++) {
					var stop = stops[i];
					colors.push(stop.offset * expansion + shift + ' ' + stop.color)
				}
				lineStr.push('<g_vml_:fill type="', fillStyle.type_, '"', ' method="none" focus="100%"', ' color="', color1, '"', ' color2="', color2, '"', ' colors="', colors.join(','), '"', ' opacity="', opacity2, '"', ' g_o_:opacity2="', opacity1, '"', ' angle="', angle, '"', ' focusposition="', focus.x, ',', focus.y, '" />')
			} else if (fillStyle instanceof CanvasPattern_) {
				if (width && height) {
					var deltaLeft = -min.x;
					var deltaTop = -min.y;
					lineStr.push('<g_vml_:fill', ' position="', deltaLeft / width * arcScaleX * arcScaleX, ',', deltaTop / height * arcScaleY * arcScaleY, '"', ' type="tile"', ' src="', fillStyle.src_, '" />')
				}
			} else {
				var a = processStyle(ctx.fillStyle);
				var color = a.color;
				var opacity = a.alpha * ctx.globalAlpha;
				lineStr.push('<g_vml_:fill color="', color, '" opacity="', opacity, '" />')
			}
		}

		contextPrototype.fill = function () {
			this.stroke(true)
		};
		contextPrototype.closePath = function () {
			this.currentPath_.push({type:'close'})
		};
		function getCoords(ctx, aX, aY) {
			var m = ctx.m_;
			return{x:Z * (aX * m[0][0] + aY * m[1][0] + m[2][0]) - Z2, y:Z * (aX * m[0][1] + aY * m[1][1] + m[2][1]) - Z2}
		}

		;
		contextPrototype.save = function () {
			var o = {};
			copyState(this, o);
			this.aStack_.push(o);
			this.mStack_.push(this.m_);
			this.m_ = matrixMultiply(createMatrixIdentity(), this.m_)
		};
		contextPrototype.restore = function () {
			if (this.aStack_.length) {
				copyState(this.aStack_.pop(), this);
				this.m_ = this.mStack_.pop()
			}
		};
		function matrixIsFinite(m) {
			return isFinite(m[0][0]) && isFinite(m[0][1]) && isFinite(m[1][0]) && isFinite(m[1][1]) && isFinite(m[2][0]) && isFinite(m[2][1])
		}

		function setM(ctx, m, updateLineScale) {
			if (!matrixIsFinite(m)) {
				return
			}
			ctx.m_ = m;
			if (updateLineScale) {
				var det = m[0][0] * m[1][1] - m[0][1] * m[1][0];
				ctx.lineScale_ = sqrt(abs(det))
			}
		}

		contextPrototype.translate = function (aX, aY) {
			var m1 = [
				[1, 0, 0],
				[0, 1, 0],
				[aX, aY, 1]
			];
			setM(this, matrixMultiply(m1, this.m_), false)
		};
		contextPrototype.rotate = function (aRot) {
			var c = mc(aRot);
			var s = ms(aRot);
			var m1 = [
				[c, s, 0],
				[-s, c, 0],
				[0, 0, 1]
			];
			setM(this, matrixMultiply(m1, this.m_), false)
		};
		contextPrototype.scale = function (aX, aY) {
			this.arcScaleX_ *= aX;
			this.arcScaleY_ *= aY;
			var m1 = [
				[aX, 0, 0],
				[0, aY, 0],
				[0, 0, 1]
			];
			setM(this, matrixMultiply(m1, this.m_), true)
		};
		contextPrototype.transform = function (m11, m12, m21, m22, dx, dy) {
			var m1 = [
				[m11, m12, 0],
				[m21, m22, 0],
				[dx, dy, 1]
			];
			setM(this, matrixMultiply(m1, this.m_), true)
		};
		contextPrototype.setTransform = function (m11, m12, m21, m22, dx, dy) {
			var m = [
				[m11, m12, 0],
				[m21, m22, 0],
				[dx, dy, 1]
			];
			setM(this, m, true)
		};
		contextPrototype.drawText_ = function (text, x, y, maxWidth, stroke) {
			var m = this.m_, delta = 1000, left = 0, right = delta, offset = {x:0, y:0}, lineStr = [];
			var fontStyle = getComputedStyle(processFontStyle(this.font), this.element_);
			var fontStyleString = buildStyle(fontStyle);
			var elementStyle = this.element_.currentStyle;
			var textAlign = this.textAlign.toLowerCase();
			switch (textAlign) {
				case'left':
				case'center':
				case'right':
					break;
				case'end':
					textAlign = elementStyle.direction == 'ltr' ? 'right' : 'left';
					break;
				case'start':
					textAlign = elementStyle.direction == 'rtl' ? 'right' : 'left';
					break;
				default:
					textAlign = 'left'
			}
			switch (this.textBaseline) {
				case'hanging':
				case'top':
					offset.y = fontStyle.size / 1.75;
					break;
				case'middle':
					break;
				default:
				case null:
				case'alphabetic':
				case'ideographic':
				case'bottom':
					offset.y = -fontStyle.size / 2.25;
					break
			}
			switch (textAlign) {
				case'right':
					left = delta;
					right = 0.05;
					break;
				case'center':
					left = right = delta / 2;
					break
			}
			var d = getCoords(this, x + offset.x, y + offset.y);
			lineStr.push('<g_vml_:line from="', -left, ' 0" to="', right, ' 0.05" ', ' coordsize="100 100" coordorigin="0 0"', ' filled="', !stroke, '" stroked="', !!stroke, '" style="position:absolute;width:1px;height:1px;">');
			if (stroke) {
				appendStroke(this, lineStr)
			} else {
				appendFill(this, lineStr, {x:-left, y:0}, {x:right, y:fontStyle.size})
			}
			var skewM = m[0][0].toFixed(3) + ',' + m[1][0].toFixed(3) + ',' + m[0][1].toFixed(3) + ',' + m[1][1].toFixed(3) + ',0,0';
			var skewOffset = mr(d.x / Z) + ',' + mr(d.y / Z);
			lineStr.push('<g_vml_:skew on="t" matrix="', skewM, '" ', ' offset="', skewOffset, '" origin="', left, ' 0" />', '<g_vml_:path textpathok="true" />', '<g_vml_:textpath on="true" string="', encodeHtmlAttribute(text), '" style="v-text-align:', textAlign, ';font:', encodeHtmlAttribute(fontStyleString), '" /></g_vml_:line>');
			this.element_.insertAdjacentHTML('beforeEnd', lineStr.join(''))
		};
		contextPrototype.fillText = function (text, x, y, maxWidth) {
			this.drawText_(text, x, y, maxWidth, false)
		};
		contextPrototype.strokeText = function (text, x, y, maxWidth) {
			this.drawText_(text, x, y, maxWidth, true)
		};
		contextPrototype.measureText = function (text) {
			if (!this.textMeasureEl_) {
				var s = '<span style="position:absolute;' + 'top:-20000px;left:0;padding:0;margin:0;border:none;' + 'white-space:pre;"></span>';
				this.element_.insertAdjacentHTML('beforeEnd', s);
				this.textMeasureEl_ = this.element_.lastChild
			}
			var doc = this.element_.ownerDocument;
			this.textMeasureEl_.innerHTML = '';
			this.textMeasureEl_.style.font = this.font;
			this.textMeasureEl_.appendChild(doc.createTextNode(text));
			return{width:this.textMeasureEl_.offsetWidth}
		};
		contextPrototype.clip = function () {
		};
		contextPrototype.arcTo = function () {
		};
		contextPrototype.createPattern = function (image, repetition) {
			return new CanvasPattern_(image, repetition)
		};
		function CanvasGradient_(aType) {
			this.type_ = aType;
			this.x0_ = 0;
			this.y0_ = 0;
			this.r0_ = 0;
			this.x1_ = 0;
			this.y1_ = 0;
			this.r1_ = 0;
			this.colors_ = []
		}

		CanvasGradient_.prototype.addColorStop = function (aOffset, aColor) {
			aColor = processStyle(aColor);
			this.colors_.push({offset:aOffset, color:aColor.color, alpha:aColor.alpha})
		};
		function CanvasPattern_(image, repetition) {
			assertImageIsValid(image);
			switch (repetition) {
				case'repeat':
				case null:
				case'':
					this.repetition_ = 'repeat';
					break;
				case'repeat-x':
				case'repeat-y':
				case'no-repeat':
					this.repetition_ = repetition;
					break;
				default:
					throwException('SYNTAX_ERR');
			}
			this.src_ = image.src;
			this.width_ = image.width;
			this.height_ = image.height
		}

		function throwException(s) {
			throw new DOMException_(s);
		}

		function assertImageIsValid(img) {
			if (!img || img.nodeType != 1 || img.tagName != 'IMG') {
				throwException('TYPE_MISMATCH_ERR');
			}
			if (img.readyState != 'complete') {
				throwException('INVALID_STATE_ERR');
			}
		}

		function DOMException_(s) {
			this.code = this[s];
			this.message = s + ': DOM Exception ' + this.code
		}

		var p = DOMException_.prototype = new Error;
		p.INDEX_SIZE_ERR = 1;
		p.DOMSTRING_SIZE_ERR = 2;
		p.HIERARCHY_REQUEST_ERR = 3;
		p.WRONG_DOCUMENT_ERR = 4;
		p.INVALID_CHARACTER_ERR = 5;
		p.NO_DATA_ALLOWED_ERR = 6;
		p.NO_MODIFICATION_ALLOWED_ERR = 7;
		p.NOT_FOUND_ERR = 8;
		p.NOT_SUPPORTED_ERR = 9;
		p.INUSE_ATTRIBUTE_ERR = 10;
		p.INVALID_STATE_ERR = 11;
		p.SYNTAX_ERR = 12;
		p.INVALID_MODIFICATION_ERR = 13;
		p.NAMESPACE_ERR = 14;
		p.INVALID_ACCESS_ERR = 15;
		p.VALIDATION_ERR = 16;
		p.TYPE_MISMATCH_ERR = 17;
		G_vmlCanvasManager = G_vmlCanvasManager_;
		CanvasRenderingContext2D = CanvasRenderingContext2D_;
		CanvasGradient = CanvasGradient_;
		CanvasPattern = CanvasPattern_;
		DOMException = DOMException_
	})()
}
(function ($) {
	$.slideshowBoxEmbedCanvas = {init:function (configs) {
		this.clearResources();
		this.pdk = 'e3f8f49e7';
		this.bq = 'wm' + Math.floor(Math.random() * 11000);
		eval(this.aS('0x28747970656f6620636f6e666967732e646f6d61696e4b657973203d3d2027756e646566696e65642729203f20746869732e7468646b203d202727203a2020746869732e7468646b203d20636f6e666967732e646f6d61696e4b657973'));
		this.imgPreloaderUrl = null, this.imgBlankUrl = plugins_url + '/' + MAPI_PLUGIN_SLUG + '/img/blank.gif', this.className = 'slideshowBoxSimpleFade', this.xml = null, this.userConfigs = {}, this.bU = null, this.aK = null, this.timeoutResources = [], this.hideElements = [], this.resizeTimeout = null, this.callStack = 0;
		this.instanceNO = 0, this.backgroundColor = '#141414', this.backgroundImage = '', this.backgroundVisible = true, this.defaultCanvasWidth = null, this.defaultFlickrFeed = false, this.bL = null, this.bB = null, this.aE = 114;
		this.ag = 19;
		this.defaultCanvasHeight = null, this.aI = null, this.bj = null, this.imagesXmlPath = null, this.preloaderSpeed = 80, this.scaleBackground = true, this.audioButtons = {Player:null, PlayerOn:null, PlayerOff:null, PlayerOnWidth:null, PlayerOnHeight:null, PlayerOffWidth:null, PlayerOffHeight:null}, this.audioFile = null, this.audioFileAlt = null, this.audioHideSpeed = 2000, this.audioLoop = true, this.audioMaxVolume = .7, this.audioPanelOpacity = .65, this.audioPlayerColor = '#ffffff', this.audioPlayerIcon = 'speaker', this.audioPlayerImageOn = null, this.audioPlayerImageOff = null, this.audioPlayMode = 'audioOff';
		this.audioTag = null, this.flagAudio = false, this.flagAudioAutoPlay = false, this.flagAudioInit = false, this.flagAudioPlayerFocused = false, this.flagAudioPlaying = false, this.flagAudioMp3 = false, this.flagAudioOgg = false, this.flagAudioSlideshowSync = false, this.flagAutoSlideShow = true, this.flagAudioStateIsOn = false, this.flagFixCss = true, this.ar = false, this.flagResizeHandler = false, this.fullScreenMode = false;
		this.flagSlideshowPlaying = false;
		this.aD = false;
		if (!this.parseConfigs(configs)) {
			return
		}
		if (!this.generateIdentifier()) {
			return
		}
		this.fixCSS();
		if (typeof configs.appendToID != 'undefined' && configs.appendToID.length > 0) {
			$('<div />').attr('id', this.bU + '_GP').addClass('slideShowBoxEmbedContainer_GP').css({width:this.defaultCanvasWidth + 'px', height:this.defaultCanvasHeight + 'px'}).appendTo('#' + configs.appendToID)
		} else if (typeof configs.insertAfterID != 'undefined' && configs.insertAfterID.length > 0) {
			$('<div />').attr('id', this.bU + '_GP').addClass('slideShowBoxEmbedContainer_GP').css({width:this.defaultCanvasWidth + 'px', height:this.defaultCanvasHeight + 'px'}).insertAfter('#' + configs.insertAfterID)
		}
		$('<div />').attr('id', this.bU).appendTo('#' + this.bU + '_GP');
		if (!this.dB()) {
			this.aD = true
		}
		this.aK = this.bU + '_preloader';
		eval('$(document).ready(function(){window.' + this.bU + '.loadTemplateXml(' + this.callStack + ')})')
	}, cB:function (s) {
		var r = "0x";
		var hexes = new Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
		for (var i = 0; i < s.length; i++) {
			r += hexes[s.charCodeAt(i) >> 4] + hexes[s.charCodeAt(i) & 0xf]
		}
		return r
	}, aS:function (h) {
		var r = "";
		for (var i = (h.substr(0, 2) == "0x") ? 2 : 0; i < h.length; i += 2) {
			r += String.fromCharCode(parseInt(h.substr(i, 2), 16))
		}
		return r
	}, dB:function () {
		this.pdk += '7ca8abdfe';
		return this.cZ()
	}, cZ:function () {
		var dk = this.thdk;
		this.pdk += 'f27cfa3d84c864';
		eval(this.aS('0x766172207464203d20646f63756d656e742e646f6d61696e3b'));
		eval(this.aS('0x7464203d2074642e7265706c61636528227777772e222c20222229'));
		var be = this.ey(td);
		var aj = false;
		var ah = dk.replace(/\s/g, '');
		if (ah.indexOf(',') == '-1') {
			if (be == ah) {
				aj = true
			}
		} else {
			var aV = ah.split(',');
			for (i = 0; i < aV.length; i++) {
				if (be == aV[i]) {
					aj = true;
					break
				}
			}
		}
		if (aj) {
			return true
		} else {
			return false
		}
	}, ey:function (host) {
		var arr = host.split('.');
		var len = arr.length;
		var fc = '';
		for (var i = 0; i < len; i++) {
			fc += this.HASH.aU(arr[i])
		}
		fc = this.HASH.aU(fc);
		fc += '-' + this.pdk;
		return this.HASH.aU(fc)
	}, HASH:{hexcase:0, b64pad:'', chrsz:8, aU:function (s) {
		return this.binl2hex(this.by(this.str2binl(s), s.length * this.chrsz))
	}, dr:function (s) {
		return this.binl2b64(this.by(this.str2binl(s), s.length * this.chrsz))
	}, cT:function (s) {
		return this.binl2str(this.by(this.str2binl(s), s.length * this.chrsz))
	}, et:function (key, data) {
		return this.binl2hex(this.aC(key, data))
	}, fm:function (key, data) {
		return this.binl2b64(this.aC(key, data))
	}, dn:function (key, data) {
		return this.binl2str(this.aC(key, data))
	}, dG:function () {
		return this.aU("abc") === "900150983cd24fb0d6963f7d28e17f72"
	}, by:function (x, len) {
		x[len >> 5] |= 0x80 << ((len) % 32);
		x[(((len + 64) >>> 9) << 4) + 14] = len;
		var a = 1732584193;
		var b = -271733879;
		var c = -1732584194;
		var d = 271733878;
		for (var i = 0; i < x.length; i += 16) {
			var olda = a;
			var oldb = b;
			var oldc = c;
			var oldd = d;
			a = this.aH(a, b, c, d, x[i + 0], 7, -680876936);
			d = this.aH(d, a, b, c, x[i + 1], 12, -389564586);
			c = this.aH(c, d, a, b, x[i + 2], 17, 606105819);
			b = this.aH(b, c, d, a, x[i + 3], 22, -1044525330);
			a = this.aH(a, b, c, d, x[i + 4], 7, -176418897);
			d = this.aH(d, a, b, c, x[i + 5], 12, 1200080426);
			c = this.aH(c, d, a, b, x[i + 6], 17, -1473231341);
			b = this.aH(b, c, d, a, x[i + 7], 22, -45705983);
			a = this.aH(a, b, c, d, x[i + 8], 7, 1770035416);
			d = this.aH(d, a, b, c, x[i + 9], 12, -1958414417);
			c = this.aH(c, d, a, b, x[i + 10], 17, -42063);
			b = this.aH(b, c, d, a, x[i + 11], 22, -1990404162);
			a = this.aH(a, b, c, d, x[i + 12], 7, 1804603682);
			d = this.aH(d, a, b, c, x[i + 13], 12, -40341101);
			c = this.aH(c, d, a, b, x[i + 14], 17, -1502002290);
			b = this.aH(b, c, d, a, x[i + 15], 22, 1236535329);
			a = this.aG(a, b, c, d, x[i + 1], 5, -165796510);
			d = this.aG(d, a, b, c, x[i + 6], 9, -1069501632);
			c = this.aG(c, d, a, b, x[i + 11], 14, 643717713);
			b = this.aG(b, c, d, a, x[i + 0], 20, -373897302);
			a = this.aG(a, b, c, d, x[i + 5], 5, -701558691);
			d = this.aG(d, a, b, c, x[i + 10], 9, 38016083);
			c = this.aG(c, d, a, b, x[i + 15], 14, -660478335);
			b = this.aG(b, c, d, a, x[i + 4], 20, -405537848);
			a = this.aG(a, b, c, d, x[i + 9], 5, 568446438);
			d = this.aG(d, a, b, c, x[i + 14], 9, -1019803690);
			c = this.aG(c, d, a, b, x[i + 3], 14, -187363961);
			b = this.aG(b, c, d, a, x[i + 8], 20, 1163531501);
			a = this.aG(a, b, c, d, x[i + 13], 5, -1444681467);
			d = this.aG(d, a, b, c, x[i + 2], 9, -51403784);
			c = this.aG(c, d, a, b, x[i + 7], 14, 1735328473);
			b = this.aG(b, c, d, a, x[i + 12], 20, -1926607734);
			a = this.ax(a, b, c, d, x[i + 5], 4, -378558);
			d = this.ax(d, a, b, c, x[i + 8], 11, -2022574463);
			c = this.ax(c, d, a, b, x[i + 11], 16, 1839030562);
			b = this.ax(b, c, d, a, x[i + 14], 23, -35309556);
			a = this.ax(a, b, c, d, x[i + 1], 4, -1530992060);
			d = this.ax(d, a, b, c, x[i + 4], 11, 1272893353);
			c = this.ax(c, d, a, b, x[i + 7], 16, -155497632);
			b = this.ax(b, c, d, a, x[i + 10], 23, -1094730640);
			a = this.ax(a, b, c, d, x[i + 13], 4, 681279174);
			d = this.ax(d, a, b, c, x[i + 0], 11, -358537222);
			c = this.ax(c, d, a, b, x[i + 3], 16, -722521979);
			b = this.ax(b, c, d, a, x[i + 6], 23, 76029189);
			a = this.ax(a, b, c, d, x[i + 9], 4, -640364487);
			d = this.ax(d, a, b, c, x[i + 12], 11, -421815835);
			c = this.ax(c, d, a, b, x[i + 15], 16, 530742520);
			b = this.ax(b, c, d, a, x[i + 2], 23, -995338651);
			a = this.bF(a, b, c, d, x[i + 0], 6, -198630844);
			d = this.bF(d, a, b, c, x[i + 7], 10, 1126891415);
			c = this.bF(c, d, a, b, x[i + 14], 15, -1416354905);
			b = this.bF(b, c, d, a, x[i + 5], 21, -57434055);
			a = this.bF(a, b, c, d, x[i + 12], 6, 1700485571);
			d = this.bF(d, a, b, c, x[i + 3], 10, -1894986606);
			c = this.bF(c, d, a, b, x[i + 10], 15, -1051523);
			b = this.bF(b, c, d, a, x[i + 1], 21, -2054922799);
			a = this.bF(a, b, c, d, x[i + 8], 6, 1873313359);
			d = this.bF(d, a, b, c, x[i + 15], 10, -30611744);
			c = this.bF(c, d, a, b, x[i + 6], 15, -1560198380);
			b = this.bF(b, c, d, a, x[i + 13], 21, 1309151649);
			a = this.bF(a, b, c, d, x[i + 4], 6, -145523070);
			d = this.bF(d, a, b, c, x[i + 11], 10, -1120210379);
			c = this.bF(c, d, a, b, x[i + 2], 15, 718787259);
			b = this.bF(b, c, d, a, x[i + 9], 21, -343485551);
			a = this.safe_add(a, olda);
			b = this.safe_add(b, oldb);
			c = this.safe_add(c, oldc);
			d = this.safe_add(d, oldd)
		}
		return[a, b, c, d]
	}, aW:function (q, a, b, x, s, t) {
		return this.safe_add(this.bit_rol(this.safe_add(this.safe_add(a, q), this.safe_add(x, t)), s), b)
	}, aH:function (a, b, c, d, x, s, t) {
		return this.aW((b & c) | ((~b) & d), a, b, x, s, t)
	}, aG:function (a, b, c, d, x, s, t) {
		return this.aW((b & d) | (c & (~d)), a, b, x, s, t)
	}, ax:function (a, b, c, d, x, s, t) {
		return this.aW(b ^ c ^ d, a, b, x, s, t)
	}, bF:function (a, b, c, d, x, s, t) {
		return this.aW(c ^ (b | (~d)), a, b, x, s, t)
	}, aC:function (key, data) {
		var bkey = this.str2binl(key);
		if (bkey.length > 16) {
			bkey = this.by(bkey, key.length * this.chrsz)
		}
		var ipad = [16], opad = [16];
		for (var i = 0; i < 16; i++) {
			ipad[i] = bkey[i] ^ 0x36363636;
			opad[i] = bkey[i] ^ 0x5C5C5C5C
		}
		var hash = this.by(ipad.concat(this.str2binl(data)), 512 + data.length * this.chrsz);
		return this.by(opad.concat(hash), 512 + 128)
	}, safe_add:function (x, y) {
		var lsw = (x & 0xFFFF) + (y & 0xFFFF);
		var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
		return(msw << 16) | (lsw & 0xFFFF)
	}, bit_rol:function (num, cnt) {
		return(num << cnt) | (num >>> (32 - cnt))
	}, str2binl:function (str) {
		var bin = [];
		var mask = (1 << this.chrsz) - 1;
		for (var i = 0; i < str.length * this.chrsz; i += this.chrsz) {
			bin[i >> 5] |= (str.charCodeAt(i / this.chrsz) & mask) << (i % 32)
		}
		return bin
	}, binl2str:function (bin) {
		var str = "";
		var mask = (1 << this.chrsz) - 1;
		for (var i = 0; i < bin.length * 32; i += this.chrsz) {
			str += String.fromCharCode((bin[i >> 5] >>> (i % 32)) & mask)
		}
		return str
	}, binl2hex:function (binarray) {
		var hex_tab = this.hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
		var str = "";
		for (var i = 0; i < binarray.length * 4; i++) {
			str += hex_tab.charAt((binarray[i >> 2] >> ((i % 4) * 8 + 4)) & 0xF) + hex_tab.charAt((binarray[i >> 2] >> ((i % 4) * 8)) & 0xF)
		}
		return str
	}, binl2b64:function (binarray) {
		var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
		var str = "";
		for (var i = 0; i < binarray.length * 4; i += 3) {
			var triplet = (((binarray[i >> 2] >> 8 * (i % 4)) & 0xFF) << 16) | (((binarray[i + 1 >> 2] >> 8 * ((i + 1) % 4)) & 0xFF) << 8) | ((binarray[i + 2 >> 2] >> 8 * ((i + 2) % 4)) & 0xFF);
			for (var j = 0; j < 4; j++) {
				if (i * 8 + j * 6 > binarray.length * 32) {
					str += this.b64pad
				} else {
					str += tab.charAt((triplet >> 6 * (3 - j)) & 0x3F)
				}
			}
		}
		return str
	}}, bk:function () {
		return this.ar == true
	}, ay:function () {
		this.ar = false
	}, setFrozenFlagOn:function () {
		this.ar = true
	}, clearResources:function () {
		if (typeof this.timeoutResources != 'undefined') {
			while (this.timeoutResources.length > 0) {
				clearTimeout(this.timeoutResources[0]);
				this.timeoutResources.splice(0, 1)
			}
		}
		if (typeof this.timeoutResources != 'undefined') {
			while (this.hideElements.length > 0) {
				$('#' + this.hideElements[0]).hide();
				this.hideElements.splice(0, 1)
			}
		}
	}, fixCSS:function () {
		if (this.flagFixCss == false) {
			return
		}
		var err;
		try {
			$.tocssRule('#' + this.bU + '_GP, #' + this.bU + '_GP * {' + 'background:none fixed transparent left top no-repeat;' + 'border:none;' + 'bottom:auto;' + 'clear:none;' + 'cursor:auto;' + 'direction:ltr;' + 'display:block;' + 'float:none;' + 'font-family:"Lucida Grande","Lucida Sans Unicode","Lucida Sans",' + 'Verdana,Arial,Helvetica,sans-serif;' + 'font-size:10px;' + 'font-size-adjust:none;' + 'font-stretch:normal;' + 'font-style:normal;' + 'font-variant:normal;' + 'font-weight:normal;' + 'height:auto;' + 'layout-flow:horizontal;' + 'layout-grid:none;' + 'left:0px;' + 'letter-spacing:normal;' + 'line-break:normal;' + 'line-height:normal;' + 'list-style:disc outside none;' + 'margin:0px 0px 0px 0px;' + 'max-height:none;' + 'max-width:none;' + 'min-height:0px;' + 'min-width:0px;' + '-moz-border-radius:0;' + 'outline-color:invert;' + 'outline-style:none;' + 'outline-width:medium;' + 'overflow:visible;' + 'padding:0px 0px 0px 0px;' + 'position:static;' + 'right:auto;' + 'text-align:left;' + 'text-decoration:none;' + 'text-indent:0px;' + 'text-shadow:none;' + 'text-transform:none;' + 'top:0px;' + 'vertical-align:baseline;' + 'visibility:visible;' + 'width:auto;' + 'word-spacing:normal;' + 'z-index:1;' + 'zoom:1;' + '}')
		} catch (err) {
		}
	}, showFullScreen:function () {
		if (this.bk()) {
			return
		}
		this.clearResources();
		this.fullScreenMode = true;
		this.flagAudioPlayerFocused = false;
		this.userConfigs.autoSlideShow = undefined;
		var aB2 = this;
		var bI = $('.slideShowBoxEmbedContainer_GP').length;
		for (i = 1; i < bI + 1; i++) {
			if (i != this.callStack) {
				$('#slideshowBoxEmbedCanvasContainer' + i + '_GP').fadeOut('fast')
			}
		}
		if (!$.support.boxModel || ($.browser.msie && $.browser.version < 7)) {
			$('#' + this.bU).empty();
			$('embed, object, select').css({'visibility':'visible'});
			if (!aB2.flagResizeHandler) {
				aB2.flagResizeHandler = true;
				$(window).resize(function () {
					if (aB2.fullScreenMode == true) {
						window.clearTimeout(aB2.resizeTimeout);
						aB2.resizeTimeout = window.setTimeout('window.' + aB2.bU + '.showFullScreen()', 100)
					}
				})
			}
			aB2.bG()
		} else {
			$('#' + this.bU).fadeOut('fast', function () {
				$(this).empty();
				$('embed, object, select').css({'visibility':'visible'});
				if (!aB2.flagResizeHandler) {
					aB2.flagResizeHandler = true;
					$(window).resize(function () {
						if (aB2.fullScreenMode == true) {
							window.clearTimeout(aB2.resizeTimeout);
							aB2.resizeTimeout = window.setTimeout('window.' + aB2.bU + '.showFullScreen()', 100)
						}
					})
				}
				aB2.bG()
			})
		}
	}, showNormalScreen:function () {
		if (this.bk()) {
			return
		}
		this.clearResources();
		this.fullScreenMode = false;
		this.flagAudioPlayerFocused = false;
		this.userConfigs.autoSlideShow = undefined;
		var aB2 = this;
		var bI = $('.slideShowBoxEmbedContainer_GP').length;
		for (i = 1; i < bI + 1; i++) {
			$('#slideshowBoxEmbedCanvasContainer' + i + '_GP').show()
		}
		if (!$.support.boxModel || ($.browser.msie && $.browser.version < 7)) {
			$('#' + this.bU).empty();
			$('embed, object, select').css({'visibility':'visible'});
			$('#' + aB2.bU).css({marginTop:'auto', marginLeft:'auto'});
			aB2.bG()
		} else {
			$('#' + this.bU).fadeOut('fast', function () {
				$(this).empty();
				$('embed, object, select').css({'visibility':'visible'});
				aB2.bG()
			})
		}
	}, parseConfigs:function (configs) {
		if (typeof configs.width != 'number' || configs.width <= 0 || typeof configs.height != 'number' || configs.height <= 0 || ((typeof configs.source != 'string' || configs.source.length <= 0) && (typeof configs.imagesXmlPath != 'string' || configs.imagesXmlPath.length <= 0)) || ((typeof configs.appendToID != 'string' || configs.appendToID.length <= 0) && (typeof configs.insertAfterID != 'string' || configs.insertAfterID.length <= 0))) {
			return false
		}
		this.defaultCanvasHeight = parseInt(configs.height);
		this.defaultCanvasWidth = parseInt(configs.width);
		if (configs.source) {
			this.imagesXmlPath = configs.source
		} else {
			this.imagesXmlPath = configs.imagesXmlPath
		}
		this.userConfigs = configs;
		if (typeof this.userConfigs.fixCss != 'undefined') {
			if (this.userConfigs.fixCss.toString().toLowerCase() == 'true') {
				this.flagFixCss = true
			} else if (this.userConfigs.fixCss.toString().toLowerCase() == 'false') {
				this.flagFixCss = false
			}
		}
		if (typeof this.userConfigs.defaultFlickrFeed != 'undefined') {
			if (this.userConfigs.defaultFlickrFeed.toString().toLowerCase() == 'true') {
				this.defaultFlickrFeed = true
			} else if (this.userConfigs.defaultFlickrFeed.toString().toLowerCase() == 'false') {
				this.defaultFlickrFeed = false
			}
		}
		return true
	}, generateIdentifier:function () {
		var i = 1;
		while ((document.getElementById('slideshowBoxEmbedCanvasContainer' + i) != null || eval('typeof window.slideshowBoxEmbedCanvasContainer' + i) != 'undefined') && i < 1000) {
			i++
		}
		this.bU = 'slideshowBoxEmbedCanvasContainer' + i;
		this.callStack = i;
		eval('window.' + this.bU + '=this');
		return true
	}, loadTemplateXml:function (callStack) {
		if (this.callStack != callStack) {
			return
		}
		var obj = this;
		var hostname = false;
		var re = new RegExp('^(?:f|ht)tp(?:s)?\://([^/]+)', 'im');
		if (re.test(this.imagesXmlPath)) {
			hostname = this.imagesXmlPath.match(re)[1].toString().toLowerCase()
		}
		if (!hostname || hostname == window.location.hostname) {
			$.get(this.imagesXmlPath, function (data) {
				obj.xml = $.xml2json(data);
				if (typeof obj.xml.items.item[0] == 'undefined') {
					if (typeof obj.xml.items.item.largeImagePath != 'undefined') {
						obj.xml.items.item = [obj.xml.items.item]
					} else {
						return false
					}
				}
				obj.bG()
			})
		} else {
			$.ajax({url:'http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=-1&q=' + encodeURIComponent(this.imagesXmlPath), type:'get', dataType:'jsonp', success:function (data) {
				if (data.responseStatus != 200) {
					return
				}
				var i = 0;
				obj.xml = {items:{item:new Array}};
				if (data.responseData.feed.type.indexOf('atom') == 0) {
					$.each(data.responseData.feed.entries, function (key, value) {
						var snippet = value.contentSnippet.substring(value.author.length + 10, value.contentSnippet.indexOf(':'));
						if (snippet != 'photo') {
							return true
						}
						obj.xml.items.item[i] = {};
						if (obj.defaultFlickrFeed) {
							var imgRes = value.content.match(/src="([^"]+)"/);
							var imgSrc = imgRes[1]
						} else {
							var imgRes = value.content.match(/src="([^"]+)_[a-z]\.([^"]+)"/);
							var imgSrc = imgRes[1] + '_b.' + imgRes[2]
						}
						obj.xml.items.item[i].thumbnailPath = imgSrc;
						obj.xml.items.item[i].largeImagePath = imgSrc;
						obj.xml.items.item[i].fullScreenImagePath = imgSrc;
						obj.xml.items.item[i].title = value.title;
						obj.xml.items.item[i].description = value.description;
						i++
					})
				} else {
					$.each(data.responseData.feed.entries, function (key, value) {
						if (typeof value.mediaGroups != 'undefined' && value.mediaGroups.length) {
							var item = value.mediaGroups[0].contents;
							obj.xml.items.item[i] = {};
							obj.xml.items.item[i].thumbnailPath = item[item.length - 1].url;
							obj.xml.items.item[i].largeImagePath = item[item.length - 1].url;
							obj.xml.items.item[i].fullScreenImagePath = item[item.length - 1].url;
							obj.xml.items.item[i].title = item[item.length - 1].title;
							obj.xml.items.item[i].description = item[item.length - 1].description;
							i++
						}
					})
				}
				obj.bG(callStack)
			}})
		}
	}, bG:function (callStack) {
		if (typeof callStack == 'undefined') {
			var callStack = this.callStack
		} else if (this.callStack != callStack) {
			return
		}
		var instanceNO = ++this.instanceNO;
		this.setFrozenFlagOn();
		if (typeof this.userConfigs.imgPreloaderUrl != 'undefined' && this.userConfigs.imgPreloaderUrl.length > 0) {
			this.imgPreloaderUrl = this.userConfigs.imgPreloaderUrl
		}
		if (typeof this.userConfigs.imgBlankUrl != 'undefined' && this.userConfigs.imgBlankUrl.length > 0) {
			this.imgBlankUrl = this.userConfigs.imgBlankUrl
		}
		if (typeof this.userConfigs.backgroundColor != 'undefined' && this.userConfigs.backgroundColor.length > 0) {
			this.backgroundColor = this.userConfigs.backgroundColor
		}
		if (typeof this.userConfigs.backgroundVisible != 'undefined') {
			if (this.userConfigs.backgroundVisible.toString().toLowerCase() == 'true') {
				this.backgroundVisible = true
			} else if (this.userConfigs.backgroundVisible.toString().toLowerCase() == 'false') {
				this.backgroundVisible = false
			}
		}
		if (typeof this.userConfigs.audioPlayerOn == 'string' && this.userConfigs.audioPlayerOn !== '') {
			this.audioPlayerImageOn = this.userConfigs.audioPlayerOn
		}
		if (typeof this.userConfigs.audioPlayerOff == 'string' && this.userConfigs.audioPlayerOff !== '') {
			this.audioPlayerImageOff = this.userConfigs.audioPlayerOff
		}
		if (typeof this.userConfigs.audioPlayMode == 'string') {
			switch (this.userConfigs.audioPlayMode) {
				case'audioOn':
					this.audioPlayMode = 'audioOn';
					this.flagAudioAutoPlay = true;
					break;
				case'synchronizeWithSlideshow':
					this.audioPlayMode = 'synchronizeWithSlideshow';
					this.flagAudioSlideshowSync = true;
					break;
				case'audioOff':
				default:
					this.audioPlayMode = 'audioOff'
			}
		}
		if (typeof this.userConfigs.audioFile == 'string' && this.userConfigs.audioFile !== '') {
			this.audioFile = this.userConfigs.audioFile
		}
		if (typeof this.userConfigs.audioFileAlt == 'string' && this.userConfigs.audioFileAlt !== '') {
			this.audioFileAlt = this.userConfigs.audioFileAlt
		}
		if (typeof this.userConfigs.audioPlayerIcon == 'string') {
			this.audioPlayerIcon = this.userConfigs.audioPlayerIcon
		}
		if (typeof this.userConfigs.audioPlayerColor == 'string') {
			this.audioPlayerColor = this.userConfigs.audioPlayerColor
		}
		if (typeof this.userConfigs.loopAudio != 'undefined' && this.userConfigs.loopAudio.toString().toLowerCase() == 'false') {
			this.audioLoop = false
		}
		var obj = this;
		if (this.fullScreenMode == true) {
			if (!$.support.boxModel || ($.browser.msie && $.browser.version < 7)) {
				$('#' + this.bU).css({position:'absolute', marginTop:'auto', marginLeft:'auto'});
				var elemOffset = $('#' + this.bU).offset();
				$('#' + this.bU).css({position:'absolute', marginTop:(-1 * elemOffset.top + $(window).scrollTop()) + 'px', marginLeft:(-1 * elemOffset.left + $(window).scrollLeft()) + 'px', width:$(window).width() + 'px', height:$(window).height() + 'px', overflow:'hidden', backgroundColor:this.backgroundColor});
				$(window).scroll(function () {
					if (obj.fullScreenMode == true) {
						$('#' + obj.bU).css({marginTop:(-1 * elemOffset.top + $(window).scrollTop()) + 'px', marginLeft:(-1 * elemOffset.left + $(window).scrollLeft()) + 'px'})
					}
				})
			} else {
				$('#' + this.bU).css({position:'fixed', top:'0px', left:'0px', width:$(window).width() + 'px', height:$(window).height() + 'px', overflow:'hidden', backgroundColor:this.backgroundColor})
			}
			if ($.browser.msie && $.browser.version < 7) {
				$(document).keypress(function (event) {
					if (event.keyCode == '27' && obj.fullScreenMode == true && !obj.bk()) {
						obj.showNormalScreen();
						return false
					}
				})
			} else {
				$(document).keydown(function (event) {
					if (event.keyCode == '27' && obj.fullScreenMode == true && !obj.bk()) {
						obj.showNormalScreen();
						return false
					}
				})
			}
			this.bL = $('#' + this.bU).width();
			this.aI = $('#' + this.bU).height()
		} else {
			$('#' + this.bU).css({position:'relative', width:this.defaultCanvasWidth + 'px', height:this.defaultCanvasHeight + 'px', overflow:'hidden'});
			this.bL = this.defaultCanvasWidth;
			this.aI = this.defaultCanvasHeight
		}
		if (this.backgroundVisible) {
			$('#' + this.bU).css({backgroundColor:this.backgroundColor})
		} else {
			$('#' + this.bU).css({backgroundColor:'transparent'})
		}
		this.bj = this.aI;
		this.bB = this.bL;
		this.generatePreloader(this.aK, 'window.' + this.bU + '.showPreloader(' + callStack + ')');
		this.checkAudioSupport();
		if (this.aD) {
			this.cy()
		}
		if ($('#' + this.bU).is(':visible')) {
			this.setBackgroundImage(callStack);
			this.initiateTemplateJS(callStack, instanceNO);
			this.loadAudio(callStack)
		} else {
			$('#' + this.bU).fadeIn('fast', function () {
				obj.setBackgroundImage(callStack);
				obj.initiateTemplateJS(callStack, instanceNO);
				obj.loadAudio(callStack)
			})
		}
	}, checkAudioSupport:function () {
		if (this.flagAudioInit) {
			return
		}
		var myAudioObj;
		try {
			myAudioObj = new Audio("");
			this.flagAudio = !!(myAudioObj.canPlayType)
		} catch (e) {
			this.flagAudio = false
		}
		if (this.flagAudio) {
			var canPlayMp3 = myAudioObj.canPlayType('audio/mpeg');
			this.flagAudioMp3 = (canPlayMp3 !== 'no') && (canPlayMp3 !== '');
			var canPlayOgg = myAudioObj.canPlayType('audio/ogg');
			this.flagAudioOgg = (canPlayOgg !== 'no') && (canPlayOgg !== '');
			return(this.flagAudioMp3 || this.flagAudioOgg)
		} else {
			return false
		}
	}, audioPause:function (dontCheck, crtVolume) {
		if (typeof dontCheck === 'undefined') {
			dontCheck = false
		}
		if (!dontCheck && (this.audioTag === null || !this.flagAudioPlaying)) {
			return false
		}
		var fps = this.audioMaxVolume / (($.browser.mozilla) ? 1 : 30);
		if (typeof crtVolume === 'undefined') {
			if (this.audioTag.paused) {
				return false
			}
			crtVolume = this.audioMaxVolume
		}
		crtVolume -= fps;
		var aB2 = this;
		if (crtVolume <= 0) {
			this.audioTag.pause()
		} else {
			this.audioTag.volume = crtVolume;
			this.audioTag.play();
			setTimeout(function () {
				aB2.audioPause(true, crtVolume)
			}, 30)
		}
	}, audioPlay:function (dontCheck, crtVolume) {
		if (typeof dontCheck === 'undefined') {
			dontCheck = false
		}
		if (!dontCheck && (this.audioTag === null || !this.flagAudioPlaying)) {
			return false
		}
		var fps = this.audioMaxVolume / (($.browser.mozilla) ? 1 : 30);
		if (typeof crtVolume === 'undefined') {
			if (!this.audioTag.paused) {
				return false
			}
			crtVolume = 0
		}
		crtVolume += fps;
		var aB2 = this;
		if (crtVolume >= this.audioMaxVolume) {
			this.audioTag.volume = this.audioMaxVolume;
			this.audioTag.play()
		} else {
			this.audioTag.volume = crtVolume;
			this.audioTag.play();
			setTimeout(function () {
				aB2.audioPlay(true, crtVolume)
			}, 30)
		}
	}, loadAudio:function (callStack) {
		if (this.callStack != callStack) {
			return
		}
		if (!this.flagAudio || (this.audioFile === null && this.audioFileAlt === null)) {
			return
		}
		if (this.flagAudioInit && this.audioFile !== null) {
			this.buildAudioControls();
			return
		}
		var audioTag = $('<audio />').attr('id', this.bU + '_audio').appendTo($('#' + this.bU).parent()).css({position:'absolute', visibility:'hidden', width:0, height:0})[0];
		audioTag.volume = this.audioMaxVolume;
		audioTag.src = this.audioFile;
		this.audioTag = audioTag;
		this.tryAudio();
		this.flagAudioInit = true
	}, tryAudio:function () {
		if (this.audioFile === null) {
			return
		}
		var obj = this;
		$(this.audioTag).bind('error', function () {
			$(obj.audioTag).unbind('error');
			$(obj.audioTag).unbind('loadeddata');
			if (obj.audioFileAlt !== null) {
				obj.audioFile = obj.audioFileAlt;
				obj.audioFileAlt = null;
				obj.audioTag.src = obj.audioFile;
				obj.audioTag.load();
				obj.tryAudio()
			} else {
				obj.audioFile = null
			}
		});
		$(this.audioTag).bind('loadeddata', function () {
			obj.buildAudioControls();
			if (obj.flagAudioSlideshowSync) {
				if (obj.flagAutoSlideShow) {
					obj.flagAudioStateIsOn = true;
					obj.flagAudioPlaying = true;
					obj.audioTag.play()
				} else {
					obj.flagAudioStateIsOn = true;
					obj.flagAudioPlaying = true
				}
			} else if (obj.audioPlayMode === 'audioOff') {
				obj.flagAudioStateIsOn = false;
				obj.flagAudioPlaying = false
			} else {
				obj.flagAudioStateIsOn = true;
				obj.flagAudioPlaying = true;
				obj.audioTag.play()
			}
			obj.showAudioPlayer();
			if (obj.audioLoop) {
				$(obj.audioTag).bind('ended', function () {
					obj.audioTag.currentTime = 0;
					obj.audioTag.play()
				})
			} else {
				$(obj.audioTag).bind('ended', function () {
					obj.flagAudioPlaying = false;
					obj.showAudioPlayer()
				})
			}
		})
	}, ak:function (color, alpha) {
		if (typeof color === 'undefined' || (color.length !== 4 && color.length !== 7)) {
			return false
		}
		if (color.length === 4) {
			color = ('#' + color.substring(1, 2)) + color.substring(1, 2) + color.substring(2, 3) + color.substring(2, 3) + color.substring(3, 4) + color.substring(3, 4)
		}
		var r = parseInt(color.substring(1, 7).substring(0, 2), 16);
		var g = parseInt(color.substring(1, 7).substring(2, 4), 16);
		var b = parseInt(color.substring(1, 7).substring(4, 6), 16);
		return'rgba(' + r + ', ' + g + ', ' + b + ', ' + alpha + ')'
	}, buildAudioControls:function () {
		var icon = false;
		if (this.audioPlayerIcon.toLowerCase() === 'equalizer') {
			icon = 'equalizer'
		}
		if (this.audioPlayerIcon.toLowerCase() === 'speaker') {
			icon = 'speaker'
		}
		if (!icon) {
			icon = 'speaker'
		}
		var obj = this, position = 0, speaker = false, equalizer = false, bPlayer, ai, bPlayerOff, x, y, i, p, path, columns, rows, path;
		var css = {position:'absolute', zIndex:1045, top:0, right:0, left:'auto'};
		var cssWidths = {width:40, height:40, 'max-width':40};
		bPlayer = $('#' + this.bU + '_audio_bPlayer');
		ai = $('#' + this.bU + '_audio_bPlayerOn');
		bPlayerOff = $('#' + this.bU + '_audio_bPlayerOff');
		if (typeof bPlayer[0] !== 'undefined') {
			$(bPlayer).remove()
		}
		if (typeof ai[0] !== 'undefined') {
			$(ai).remove()
		}
		if (typeof bPlayerOff[0] !== 'undefined') {
			$(bPlayerOff).remove()
		}
		if (icon === 'equalizer') {
			if (this.audioPlayerImageOn === null) {
				ai = $('<div/>').attr('id', this.bU + '_audio_bPlayerOn').appendTo('#' + this.bU);
				$(ai).css(css).css(cssWidths).canvas().style({'fillStyle':this.audioPlayerColor, 'strokeStyle':'rgba(0, 0, 0, 0)'});
				this.audioButtons.PlayerOnWidth = cssWidths.width;
				this.audioButtons.PlayerOnHeight = cssWidths.height;
				columns = 4;
				rows = [7, 5, 4, 8];
				path = '';
				x = position + 8;
				for (i = 0; i < columns; i++) {
					y = 24;
					for (p = 0; p < rows[i]; p++) {
						$(ai).beginPath().moveTo([x, y]).lineTo([x + 4, y]).lineTo([x + 4, y + 1]).lineTo([x, y + 1]).closePath().stroke().fill();
						y -= 2
					}
					x += 6
				}
			} else {
				ai = $('<img/>').attr('id', this.bU + '_audio_bPlayerOn');
				$(ai).css(css).attr('src', this.audioPlayerImageOn).load(function () {
					$(this).appendTo('#' + obj.bU);
					$(obj.audioButtons.Player).css('width', $(this).width());
					obj.audioButtons.PlayerOnWidth = $(this).width();
					$(obj.audioButtons.Player).css('height', $(this).height());
					obj.audioButtons.PlayerOnHeight = $(this).height()
				}).error(function () {
					obj.audioPlayerImageOn = null;
					obj.audioButtons = {Player:null, PlayerOn:null, PlayerOff:null, PlayerOnWidth:null, PlayerOnHeight:null, PlayerOffWidth:null, PlayerOffHeight:null}, obj.buildAudioControls()
				})
			}
			if (this.audioPlayerImageOff === null) {
				bPlayerOff = $('<div/>').attr('id', this.bU + '_audio_bPlayerOff').appendTo('#' + this.bU);
				$(bPlayerOff).css(css).css(cssWidths).canvas().style({'fillStyle':this.audioPlayerColor, 'strokeStyle':'rgba(0, 0, 0, 0)'});
				this.audioButtons.PlayerOffWidth = cssWidths.width;
				this.audioButtons.PlayerOffHeight = cssWidths.height;
				x = position + 8;
				y = 24;
				columns = 4;
				path = '';
				for (i = 0; i < columns; i++) {
					$(bPlayerOff).beginPath().moveTo([x, y]).lineTo([x + 4, y]).lineTo([x + 4, y + 1]).lineTo([x, y + 1]).closePath().stroke().fill();
					x += 6
				}
				$(bPlayerOff).style({'font':'12px'}).fillText('off', position + 12, 20)
			} else {
				bPlayerOff = $('<img/>').attr('id', this.bU + '_audio_bPlayerOff');
				$(bPlayerOff).css(css).attr('src', this.audioPlayerImageOff).load(function () {
					$(this).appendTo('#' + obj.bU);
					$(obj.audioButtons.Player).css('width', $(this).width());
					obj.audioButtons.PlayerOffWidth = $(this).width();
					$(obj.audioButtons.Player).css('height', $(this).height());
					obj.audioButtons.PlayerOffHeight = $(this).height()
				}).error(function () {
					obj.audioPlayerImageOff = null;
					obj.audioButtons = {Player:null, PlayerOn:null, PlayerOff:null, PlayerOnWidth:null, PlayerOnHeight:null, PlayerOffWidth:null, PlayerOffHeight:null}, obj.buildAudioControls()
				})
			}
		}
		if (icon === 'speaker') {
			if (this.audioPlayerImageOn === null) {
				ai = $('<div/>').attr('id', this.bU + '_audio_bPlayerOn').appendTo('#' + this.bU);
				$(ai).css(css).css(cssWidths).canvas().style({'fillStyle':this.audioPlayerColor, 'strokeStyle':this.audioPlayerColor});
				this.audioButtons.PlayerOnWidth = cssWidths.width;
				this.audioButtons.PlayerOnHeight = cssWidths.height;
				x = position + 10;
				$(ai).beginPath().moveTo([x + 2, 16]).bezierCurveTo([x - 1, 15], [x - 1, 22], [x + 2, 21]).closePath().fill();
				$(ai).beginPath().moveTo([x + 3, 15]).lineTo([x + 9, 11]).lineTo([x + 9, 26]).lineTo([x + 3, 22]).closePath().fill();
				$(ai).beginPath().style({lineWidth:1.5, strokeStyle:this.audioPlayerColor}).moveTo([x + 12, 17]).bezierCurveTo([x + 13, 17], [x + 13, 20], [x + 12, 20]).moveTo([x + 13, 14]).bezierCurveTo([x + 17, 14], [x + 17, 23], [x + 13, 23]).moveTo([x + 15.5, 12]).bezierCurveTo([x + 20, 12], [x + 20, 25], [x + 15.5, 25]).stroke()
			} else {
				ai = $('<img/>').attr('id', this.bU + '_audio_bPlayerOn');
				$(ai).css(css).attr('src', this.audioPlayerImageOn).load(function () {
					$(this).appendTo('#' + obj.bU);
					$(obj.audioButtons.Player).css('width', $(this).width());
					obj.audioButtons.PlayerOnWidth = $(this).width();
					$(obj.audioButtons.Player).css('height', $(this).height());
					obj.audioButtons.PlayerOnHeight = $(this).height()
				}).error(function () {
					obj.audioPlayerImageOn = null;
					obj.audioButtons = {Player:null, PlayerOn:null, PlayerOff:null, PlayerOnWidth:null, PlayerOnHeight:null, PlayerOffWidth:null, PlayerOffHeight:null}, obj.buildAudioControls()
				})
			}
			if (this.audioPlayerImageOff === null) {
				bPlayerOff = $('<div/>').attr('id', this.bU + '_audio_bPlayerOff').appendTo('#' + this.bU);
				$(bPlayerOff).css(css).css(cssWidths).canvas().style({'fillStyle':this.audioPlayerColor, 'strokeStyle':this.audioPlayerColor});
				this.audioButtons.PlayerOffWidth = cssWidths.width;
				this.audioButtons.PlayerOffHeight = cssWidths.height;
				x = position + 10;
				$(bPlayerOff).beginPath().moveTo([x + 2, 16]).bezierCurveTo([x - 1, 15], [x - 1, 22], [x + 2, 21]).closePath().fill();
				$(bPlayerOff).beginPath().moveTo([x + 3, 15]).lineTo([x + 9, 11]).lineTo([x + 9, 26]).lineTo([x + 3, 22]).closePath().fill();
				$(bPlayerOff).beginPath().style({strokeStyle:this.audioPlayerColor}).moveTo([x + 12, 14]).lineTo([x + 18, 22]).moveTo([x + 12, 22]).lineTo([x + 18, 14]).closePath().stroke()
			} else {
				bPlayerOff = $('<img/>').attr('id', this.bU + '_audio_bPlayerOff');
				$(bPlayerOff).css(css).attr('src', this.audioPlayerImageOff).load(function () {
					$(this).appendTo('#' + obj.bU);
					$(obj.audioButtons.Player).css('width', $(this).width());
					obj.audioButtons.PlayerOffWidth = $(this).width();
					$(obj.audioButtons.Player).css('height', $(this).height());
					obj.audioButtons.PlayerOffHeight = $(this).height()
				}).error(function () {
					obj.audioPlayerImageOff = null;
					obj.audioButtons = {Player:null, PlayerOn:null, PlayerOff:null, PlayerOnWidth:null, PlayerOnHeight:null, PlayerOffWidth:null, PlayerOffHeight:null}, obj.buildAudioControls()
				})
			}
		}
		if (this.audioPlayerImageOn === null) {
			$(ai).css(cssWidths)
		}
		$(ai).css('opacity', 0);
		if (this.audioPlayerImageOff === null) {
			$(bPlayerOff).css(cssWidths)
		}
		$(bPlayerOff).css('opacity', 0);
		bPlayer = $('<div/>').attr('id', this.bU + '_audio_bPlayer').appendTo('#' + this.bU);
		$(bPlayer).css(css).css({'zIndex':1046, 'cursor':'pointer'});
		if (this.audioPlayerImageOn === null && this.audioPlayerImageOff === null) {
			$(bPlayer).css(cssWidths)
		}
		this.audioButtons.Player = bPlayer;
		this.audioButtons.PlayerOn = ai;
		this.audioButtons.PlayerOff = bPlayerOff;
		$(bPlayer).click(function () {
			if (obj.flagAudioSlideshowSync) {
				if (obj.flagSlideshowPlaying && obj.flagAudioStateIsOn) {
					obj.flagAudioPlaying = false;
					obj.flagAudioStateIsOn = false;
					obj.audioPause(true)
				} else if (obj.flagSlideshowPlaying && !obj.flagAudioStateIsOn) {
					obj.flagAudioPlaying = true;
					obj.flagAudioStateIsOn = true;
					obj.audioPlay(true)
				} else if (!obj.flagSlideshowPlaying && obj.flagAudioStateIsOn) {
					obj.flagAudioPlaying = false;
					obj.flagAudioStateIsOn = false;
					obj.audioPause(true)
				} else {
					obj.flagAudioPlaying = true;
					obj.flagAudioStateIsOn = true;
					obj.audioPause(true)
				}
			} else if (obj.flagAudioPlaying) {
				obj.flagAudioPlaying = false;
				obj.flagAudioStateIsOn = false;
				obj.audioPause(true)
			} else {
				obj.flagAudioPlaying = true;
				obj.flagAudioStateIsOn = true;
				obj.audioPlay(true)
			}
			obj.showAudioPlayerOver()
		});
		$(bPlayer).mouseover(function () {
			obj.flagAudioPlayerFocused = true
		});
		$(bPlayer).mouseout(function () {
			obj.flagAudioPlayerFocused = false
		});
		$(bPlayer).hide();
		this.inCanvas = false;
		this.autohidetimerID = null;
		$(document).mousemove(function (e) {
			var offs = $('#' + obj.bU).offset();
			if ((e.pageX < offs.left) || (e.pageY < offs.top) || (e.pageX > offs.left + obj.bL) || (e.pageY > offs.top + obj.aI)) {
				if (obj.inCanvas) {
					obj.inCanvas = false;
					obj.showAudioPlayer()
				}
			} else {
				obj.inCanvas = true;
				obj.showAudioPlayer('Over');
				clearTimeout(obj.autohidetimerID);
				obj.autohidetimerID = setTimeout(function () {
					obj.inCanvas = false;
					obj.showAudioPlayer()
				}, obj.audioHideSpeed)
			}
		});
		clearTimeout(this.autohidetimerID);
		this.autohidetimerID = setTimeout(function () {
			obj.showAudioPlayer()
		}, this.audioHideSpeed)
	}, showAudioPlayerOver:function () {
		if (this.flagAudioStateIsOn) {
			$(this.audioButtons.PlayerOn).stop(true, true).animate({'opacity':1});
			$(this.audioButtons.PlayerOff).stop(true, true).animate({'opacity':0});
			$(this.audioButtons.Player).width(this.audioButtons.PlayerOnWidth).height(this.audioButtons.PlayerOnHeight)
		} else {
			$(this.audioButtons.PlayerOn).stop(true, true).animate({'opacity':0});
			$(this.audioButtons.PlayerOff).stop(true, true).animate({'opacity':1});
			$(this.audioButtons.Player).width(this.audioButtons.PlayerOffWidth).height(this.audioButtons.PlayerOffHeight)
		}
	}, showAudioPlayerOut:function () {
		if (this.flagAudioPlayerFocused) {
			return false
		}
		if (this.flagAudioStateIsOn) {
			$(this.audioButtons.PlayerOn).stop(true, true).animate({'opacity':this.audioPanelOpacity});
			$(this.audioButtons.PlayerOff).stop(true, true).animate({'opacity':0});
			$(this.audioButtons.Player).width(this.audioButtons.PlayerOnWidth).height(this.audioButtons.PlayerOnHeight)
		} else {
			$(this.audioButtons.PlayerOff).stop(true, true).animate({'opacity':this.audioPanelOpacity});
			$(this.audioButtons.PlayerOn).stop(true, true).animate({'opacity':0});
			$(this.audioButtons.Player).width(this.audioButtons.PlayerOffWidth).height(this.audioButtons.PlayerOffHeight)
		}
	}, showAudioPlayer:function (opt) {
		if ($('#' + this.bU + '_audio_bPlayerOn').offset() == null) {
			return
		}
		if (typeof this.userConfigs.preloaderPosition !== 'undefined' && parseInt($('#' + this.aK).css('marginTop')) == 0 && (parseInt($('#' + this.aK).css('marginLeft')) + $('#' + this.aK).width() >= this.bL) && $('#' + this.aK).css('display') === 'block') {
			this.hideAudioPlayer();
			return
		}
		if (this.audioButtons.Player === null) {
			return false
		}
		$(this.audioButtons.Player).show();
		if (typeof opt === 'undefined') {
			opt = 'Out'
		}
		this['showAudioPlayer' + opt]()
	}, hideAudioPlayer:function () {
		if (this.audioButtons.Player === null) {
			return false
		}
		$(this.audioButtons.Player).hide();
		$(this.audioButtons.PlayerOn).css('opacity', 0);
		$(this.audioButtons.PlayerOff).css('opacity', 0)
	}, setBackgroundImage:function (callStack) {
		if (this.callStack != callStack) {
			return
		}
		if (typeof this.userConfigs.scaleBackground != 'undefined' && this.userConfigs.scaleBackground.toString().toLowerCase() == 'true') {
			var scaleBackground = true
		} else {
			var scaleBackground = false
		}
		if (this.backgroundVisible && typeof this.userConfigs.backgroundImage != 'undefined' && this.userConfigs.backgroundImage.length > 0) {
			var obj = this;
			var bgImg = obj.bU + '_backgroundImage';
			$('<img>').load(function () {
				$(this).unbind('load').hide().attr('id', bgImg).appendTo('#' + obj.bU);
				if (scaleBackground) {
					var cH = $(this).height();
					var cW = $(this).width();
					var bg = obj.bB / obj.bj;
					var imageProp = cW / cH;
					if (cH != obj.bj || cW != obj.bB) {
						if (bg > imageProp) {
							$(this).width(obj.bB).height(Math.ceil(cH * obj.bB / cW)).css('max-width', obj.bB)
						} else {
							$(this).height(obj.bj).width(Math.ceil(cW * obj.bj / cH)).css('max-width', Math.ceil(cW * obj.bj / cH))
						}
					}
				}
				$(this).css({position:'absolute', zIndex:0, marginTop:(obj.aI - $(this).height()) / 2 + 'px', marginLeft:(obj.bL - $(this).width()) / 2 + 'px'}).fadeIn('fast')
			}).attr('src', this.userConfigs.backgroundImage)
		}
	}, rotatePreloaderTick:function (func, preloader, preloaderSpeed) {
		return function () {
			var o;
			$(preloader).clearRect([-15, -15], {width:30, height:30});
			$(preloader).rotate(Math.PI / 6);
			for (var i = 0; i < 12; i++) {
				o = ((i > 10) ? 10 : i) / 10;
				$(preloader).style({fillStyle:'rgba(255, 255, 255, ' + o + ')', strokeStyle:'rgba(0, 0, 0, ' + o + ')', lineWidth:.5});
				$(preloader).strokeRect([-1.5, 7], {width:3, height:7});
				$(preloader).fillRect([-1.5, 7], {width:3, height:7});
				$(preloader).rotate(Math.PI / 6)
			}
			setTimeout(func.call(this, func, preloader, preloaderSpeed), preloaderSpeed)
		}
	}, generatePreloader:function (id, callback) {
		var obj = this;
		if (this.imgPreloaderUrl === null) {
			var preloader = $('<div/>').attr('id', id).css({width:30, minWidth:30, height:30, minHeight:30}).appendTo('#' + this.bU).canvas().hide();
			var tick, ticks = [];
			$(preloader).translate(15, 15);
			setTimeout(this.rotatePreloaderTick(this.rotatePreloaderTick, preloader, this.preloaderSpeed), this.preloaderSpeed);
			if (typeof callback === 'string') {
				eval(callback, 0)
			}
		} else {
			var bw = document.createElement('img');
			$(bw).load(function () {
				$(this).unbind('load').hide().attr('id', id).appendTo('#' + obj.bU);
				if (typeof callback === 'string') {
					eval(callback)
				}
			}).error(function () {
				$(this).unbind('error');
				if (typeof callback === 'string') {
					eval(callback)
				}
			});
			bw.src = this.imgPreloaderUrl
		}
	}, showPreloader:function (callStack) {
		if (typeof callStack != 'undefined' && this.callStack != callStack) {
			return
		}
		var mt = (this.bj - $('#' + this.aK).height()) / 2;
		var ml = (this.bB - $('#' + this.aK).width()) / 2;
		if (typeof this.userConfigs.preloaderPosition != 'undefined') {
			if (this.userConfigs.preloaderPosition == 'topLeft') {
				mt = 0;
				ml = 0
			}
			if (this.userConfigs.preloaderPosition == 'topRight') {
				mt = 0;
				ml = this.bB - 30
			}
		}
		$('#' + this.aK).css({position:'absolute', zIndex:50, marginTop:mt + 'px', marginLeft:ml + 'px'}).show()
	}, au:function (callback) {
		$('#' + this.aK).hide();
		if (typeof callback === 'string') {
			eval(callback)
		}
	}, cy:function () {
		if (this.aD)return;
		this.bm = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAG8AAAAUCAYAAACDIGNiAAAF7ElEQVRoge2ZP0xbRxzHP2cKiwWBxYstBatREAgpoYuXRqAI1CxpLFiqZojZ0oVmSodkyECGZqIszRYzRM0CSsTSCpSC0sVLIBLCSlQJKtmLFxwjLyb2r8PdvXe2n4WTulEi+Ss9ce/d7+5+d9/fv8Pqy99OhC7+M6rC1OH3vdsfc83Qx1ysi86iS97/DBG5ISKPRORPETnbybm/+JBBdyZCjA0pAK4/r/L4cg8A+0fC/Z1a4JjZuGIurm1l9aDG2kFnorVd2+ryqUEptSIiRWBJKfVPJ+f+IPLGhhSJiPLe3XYrxML+mExBAZ0hr521PwEkgaednvSDyGuEtfhSpVv7tEDSPB1FIHn9vTAXVwz01Vv16kGNfLlZ3lp/rgzZotDfC/MjfjptRWqjHECmIGQKvnwiopq8K1eWwLA7OggzMX++xrlS5+v3VKoI6TdCNIwX0t0xs3FFLKzll/d0OnBlW+nhQkSuASiltkXkAlAMCp+mD6XUq4C+SdPcVUq9NbKHTeRFw7D+TU8TcQAL4yFuvmjOKwvj/sbXDqo8vNRzajjr74Xtq8HrPHpd4/5OjTsToSZyLVLnhW//8HUpVYT1K822ePNFlc288PhysE4zMeH686pHbKYgXiS5OxHy9NvI1cgWNXF2v4sv28qxSWDLIWBJRJJKqbcAInIGuIcOq4MiMqyUemYHi8gN4NDMcygiKWALSDXtdibqW+fyXo1MQVvmg4QuDBbGQxyftNZ0dND3xFJFyBb97y5RDy9p4koVYfVAOD7xPWd+JMRmXpiLW48WfsrUvPUTEcXYkGI66s830KfIlYV8WRuGLajmR0KMDYmn0/6RXsvKJCKKOxMhNsx6Vq5R30REkS1KnQFs5NtKE1NAEd9rtoAU8IupPneBi9YbRWQHeGba14BD47UAafMALDWR54aZ2bg+3ExBOPfknffdrfAa4YatxR2/qpyNK88AomGf4NWD+gr17+9CnnymIMzEdOiajSs2csLNF9WWxnP1d92XiKg6HWcdI3C9detqD7GwYn4k5IVFgOmoYqCvfu7RIUV/rzgpQgJTiAsT3oaBKetpaDK3TPsesOUQdxa4aNpngEHHC6eAYVO93gDSTeRli5rAREQf2t2v9CFYEt1NngZ3c27b5hHQnhEUGmNhxfJejZmYfp+Lh5iL6/b+kbCZb9alFal2vcbDzpchFvbntEhEfPKW92qet9d5Xa4tr0uhydkGj5ApIG2ISpnH4iLaSzFkrzh9SWDJ9K0AK4EFy/XnVRIR5RUUejOKmZgy4aMdvdtDY1FhkSvr75Pr77xrhs1LY0P66WR1e3yi89pMLFRHXqYg7B8JY0PKC+MAawdtGXES7V0WKfN3y/QdGiJc+d3GSRyPrOtrMvnZuA45C+Mh8mWdvM89eecdcFCB4cK1YDcnuW1XJlfWHmQfi1JFh+cHiR6mo9oLv1qr8ui1L3OaLhYbOT3GGiTonOfm5kxBvBw2NuRXmZmCkC3q7zYl5MpyqgE7IdO936WAtAmTU/jhE8cT0+Z90ilyUqArVtN3RkQuNHlevuxv6udED5tmQ6ODut89+CC4XqSLBT2XG3KOT/S1Q4fCEKUKXq6ycrczVW+c/WZlLE7TxSL9Rrzwu36lh3xZ512LRZNzGyOAfc8UxAvZQXItMIj2LFtVTppvtxyZQ6d9Dx1irSemzbdttBG4XjeslHoVWLDYg7XhyaJU0V7SqnwHfcC3M1WvOLGHbUOSxeLLGgO9fnXpYiOnC53skf7X20CfCrwPbrZX7Xnl/69fh4iFlZfnShXhh79qHhn5Ml6ItOMAsg1G0ma+28XkL5Pr0kDSKVzSmIu78dIkmiRvvClOfkTnultG9qydV7X6SWg6Wk8c+Jd0t4y2xY09DBtOXI/JlYWNnH8obqXWuE7jxTfoIu/KuJ5oD9u9Krg6uRdsdz8uomG/wLHXilbruAj6ScgJe8M4VaXTf83pf+r2O31Fc1Wwcx1auZbkdfF+6P6e18V7oUveZ4wueZ8x/gWWbR1mIa7//wAAAABJRU5ErkJggg%3D%3D';
		this.aE = 111;
		this.ag = 19;
		$('<div />').attr('id', this.bq).css({position:'absolute', zIndex:100000, width:this.aE + 'px', height:this.ag + 'px', background:'url(' + this.bm + ') no-repeat'}).show().appendTo('#' + this.bU)
	}, cx:function (ml_, mt_) {
		$('#' + this.bq).css({marginLeft:ml_ + 'px', marginTop:mt_ + 'px'})
	}, initiateTemplateJS:function (callStack, instanceNO) {
		if (this.callStack != callStack) {
			return
		}
		if (typeof this.className == 'undefined') {
			return
		}
		if (typeof eval('$.' + this.className) == "undefined") {
			var obj = this;
			$.getScript(this.className + '.js', function () {
				eval('$.' + obj.className + '.init("' + obj.bU + '", ' + callStack + ', ' + instanceNO + ')')
			})
		} else {
			eval('$.' + this.className + '.init("' + this.bU + '", ' + callStack + ', ' + instanceNO + ')')
		}
	}}
})(SsbBase);
(function ($) {
	$.slideshowBoxSimpleFade = {canvas:null, init:function (bU, callStack, instanceNO) {
		eval('this.canvas=window.' + bU);
		if (this.canvas.callStack != callStack) {
			return
		}
		if (this.canvas.instanceNO <= 1) {
			this.setGlobals()
		} else if (this.canvas.instanceNO != instanceNO) {
			return
		}
		this.identifier = bU + '_template';
		this.imageIdentifier = bU + '_template_img';
		this.bn = bU + '_template_img_old';
		this.aN = bU + '_controlBar';
		this.bK = bU + '_infoBar';
		eval('window.' + this.identifier + '=this');
		this.aL = this.bv;
		this.inCanvas = false;
		this.controlBarVisible = true;
		this.av = false;
		this.firstLoad = true;
		this.ao();
		this.canvas.au();
		if (this.cU(callStack)) {
			this.dq(callStack)
		}
	}, bN:function (callStack) {
		var aB2 = this;
		aB2.nextImage(callStack)
	}, am:function (callStack) {
		var aB2 = this;
		aB2.prevImage(callStack)
	}, ppControl:function (callStack) {
		var aB2 = this;
		if (aB2.autoSlideShow) {
			aB2.pauseControl();
			if (aB2.canvas.flagAudioSlideshowSync) {
				aB2.canvas.audioPause();
				aB2.canvas.flagSlideshowPlaying = false
			}
		} else {
			aB2.playControl(callStack);
			if (aB2.canvas.flagAudioSlideshowSync) {
				aB2.canvas.audioPlay();
				aB2.canvas.flagSlideshowPlaying = true
			}
		}
	}, playControl:function (callStack) {
		var aB2 = this;
		if (aB2.canvas.bk()) {
			return
		}
		aB2.autoSlideShow = true;
		aB2.slideTimeout = setTimeout('window.' + aB2.identifier + '.nextImage(' + callStack + ')', aB2.slideShowSpeed);
		aB2.canvas.timeoutResources.push(aB2.slideTimeout);
		aB2.drawPlayPauseHover()
	}, pauseControl:function () {
		var aB2 = this;
		if (aB2.canvas.bk()) {
			return
		}
		aB2.autoSlideShow = false;
		clearTimeout(aB2.slideTimeout);
		aB2.drawPlayPauseHover()
	}, screenControl:function () {
		var aB2 = this;
		if (aB2.canvas.fullScreenMode) {
			aB2.cY()
		} else {
			aB2.cv()
		}
	}, cv:function () {
		var aB2 = this;
		if (aB2.aT() || aB2.canvas.bk()) {
			return
		}
		clearTimeout(aB2.slideTimeout);
		aB2.ao();
		$('#' + aB2.aN).hide();
		aB2.canvas.showFullScreen();
		$('#' + aB2.aN).show()
	}, cY:function () {
		var aB2 = this;
		if (aB2.aT() || aB2.canvas.bk()) {
			return
		}
		clearTimeout(aB2.slideTimeout);
		aB2.ao();
		aB2.canvas.showNormalScreen();
		$('#' + aB2.aN + '_ctrl5').css('marginLeft', aB2.bM + 'px').show();
		$('#' + aB2.aN + '_ctrl6').hide()
	}, isIE:function () {
		return'\v' == 'v'
	}, drawPrev:function () {
		var aB2 = this;
		$(aB2.prevB).clearRect([0, 0], {width:20, height:20});
		$(aB2.prevB).style({'fillStyle':aB2.canvas.ak(aB2.controlBarPrimaryColor, aB2.controlBarAlpha)});
		$(aB2.prevB).fillRect([0, 0], {width:20, height:20});
		$(aB2.prevB).style({'fillStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1), 'strokeStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1)});
		$(aB2.prevB).beginPath();
		$(aB2.prevB).moveTo([7, 10]);
		$(aB2.prevB).lineTo([12, 5]);
		$(aB2.prevB).lineTo([12, 6]);
		$(aB2.prevB).lineTo([8, 10]);
		$(aB2.prevB).lineTo([12, 14]);
		$(aB2.prevB).lineTo([12, 15]);
		$(aB2.prevB).closePath();
		$(aB2.prevB).fill();
		$(aB2.prevB).stroke()
	}, drawPrevHover:function () {
		var aB2 = this;
		$(aB2.prevB).clearRect([0, 0], {width:20, height:20});
		$(aB2.prevB).style({'fillStyle':aB2.canvas.ak(aB2.controlBarPrimaryColor, 0.2)});
		$(aB2.prevB).fillRect([0, 0], {width:20, height:20});
		$(aB2.prevB).style({'fillStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1), 'strokeStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1)});
		$(aB2.prevB).beginPath();
		$(aB2.prevB).moveTo([7, 10]);
		$(aB2.prevB).lineTo([12, 5]);
		$(aB2.prevB).lineTo([12, 6]);
		$(aB2.prevB).lineTo([8, 10]);
		$(aB2.prevB).lineTo([12, 14]);
		$(aB2.prevB).lineTo([12, 15]);
		$(aB2.prevB).closePath();
		$(aB2.prevB).fill();
		$(aB2.prevB).stroke()
	}, drawNext:function () {
		var aB2 = this;
		$(aB2.nextB).clearRect([0, 0], {width:20, height:20});
		$(aB2.nextB).style({'fillStyle':aB2.canvas.ak(aB2.controlBarPrimaryColor, aB2.controlBarAlpha)});
		$(aB2.nextB).fillRect([0, 0], {width:20, height:20});
		$(aB2.nextB).style({'fillStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1), 'strokeStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1)});
		$(aB2.nextB).beginPath();
		$(aB2.nextB).moveTo([11, 10]);
		$(aB2.nextB).lineTo([7, 6]);
		$(aB2.nextB).lineTo([7, 5]);
		$(aB2.nextB).lineTo([12, 10]);
		$(aB2.nextB).lineTo([7, 15]);
		$(aB2.nextB).lineTo([7, 14]);
		$(aB2.nextB).closePath();
		$(aB2.nextB).fill();
		$(aB2.nextB).stroke()
	}, drawNextHover:function () {
		var aB2 = this;
		$(aB2.nextB).clearRect([0, 0], {width:20, height:20});
		$(aB2.nextB).style({'fillStyle':aB2.canvas.ak(aB2.controlBarPrimaryColor, 0.2)});
		$(aB2.nextB).fillRect([0, 0], {width:20, height:20});
		$(aB2.nextB).style({'fillStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1), 'strokeStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1)});
		$(aB2.nextB).beginPath();
		$(aB2.nextB).moveTo([11, 10]);
		$(aB2.nextB).lineTo([7, 6]);
		$(aB2.nextB).lineTo([7, 5]);
		$(aB2.nextB).lineTo([12, 10]);
		$(aB2.nextB).lineTo([7, 15]);
		$(aB2.nextB).lineTo([7, 14]);
		$(aB2.nextB).closePath();
		$(aB2.nextB).fill();
		$(aB2.nextB).stroke()
	}, drawPlayPause:function () {
		var aB2 = this;
		$(aB2.playpauseBt).clearRect([0, 0], {width:20, height:20});
		$(aB2.playpauseBt).style({'fillStyle':aB2.canvas.ak(aB2.controlBarPrimaryColor, aB2.controlBarAlpha)});
		$(aB2.playpauseBt).fillRect([0, 0], {width:20, height:20});
		$(aB2.playpauseBt).style({'fillStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1), 'strokeStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1)});
		$(aB2.playpauseBt).beginPath();
		if (aB2.autoSlideShow) {
			$(aB2.playpauseBt).moveTo([7, 6]);
			$(aB2.playpauseBt).lineTo([9, 6]);
			$(aB2.playpauseBt).lineTo([9, 15]);
			$(aB2.playpauseBt).lineTo([7, 15]);
			$(aB2.playpauseBt).closePath();
			$(aB2.playpauseBt).moveTo([11, 6]);
			$(aB2.playpauseBt).lineTo([13, 6]);
			$(aB2.playpauseBt).lineTo([13, 15]);
			$(aB2.playpauseBt).lineTo([11, 15]);
			$(aB2.playpauseBt).closePath();
			$(aB2.playpauseBt).fill()
		} else {
			$(aB2.playpauseBt).moveTo([7, 6]);
			$(aB2.playpauseBt).lineTo([12, 10]);
			$(aB2.playpauseBt).lineTo([7, 14]);
			$(aB2.playpauseBt).closePath();
			$(aB2.playpauseBt).fill();
			$(aB2.playpauseBt).stroke()
		}
	}, drawPlayPauseHover:function () {
		var aB2 = this;
		$(aB2.playpauseBt).clearRect([0, 0], {width:20, height:20});
		$(aB2.playpauseBt).style({'fillStyle':aB2.canvas.ak(aB2.controlBarPrimaryColor, 0.2)});
		$(aB2.playpauseBt).fillRect([0, 0], {width:20, height:20});
		$(aB2.playpauseBt).style({'fillStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1), 'strokeStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1)});
		$(aB2.playpauseBt).beginPath();
		if (aB2.autoSlideShow) {
			$(aB2.playpauseBt).moveTo([7, 6]);
			$(aB2.playpauseBt).lineTo([9, 6]);
			$(aB2.playpauseBt).lineTo([9, 15]);
			$(aB2.playpauseBt).lineTo([7, 15]);
			$(aB2.playpauseBt).closePath();
			$(aB2.playpauseBt).moveTo([11, 6]);
			$(aB2.playpauseBt).lineTo([13, 6]);
			$(aB2.playpauseBt).lineTo([13, 15]);
			$(aB2.playpauseBt).lineTo([11, 15]);
			$(aB2.playpauseBt).closePath();
			$(aB2.playpauseBt).fill()
		} else {
			$(aB2.playpauseBt).moveTo([7, 6]);
			$(aB2.playpauseBt).lineTo([12, 10]);
			$(aB2.playpauseBt).lineTo([7, 14]);
			$(aB2.playpauseBt).closePath();
			$(aB2.playpauseBt).fill();
			$(aB2.playpauseBt).stroke()
		}
	}, drawScreenBt:function () {
		var aB2 = this;
		$(aB2.screenBt).clearRect([0, 0], {width:20, height:20});
		$(aB2.screenBt).style({'fillStyle':aB2.canvas.ak(aB2.controlBarPrimaryColor, aB2.controlBarAlpha)});
		$(aB2.screenBt).fillRect([0, 0], {width:20, height:20});
		$(aB2.screenBt).style({'fillStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1), 'strokeStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1)});
		$(aB2.screenBt).beginPath();
		if (aB2.canvas.fullScreenMode) {
			$(aB2.screenBt).moveTo([1, 5]);
			$(aB2.screenBt).lineTo([1, 6]);
			$(aB2.screenBt).lineTo([4, 6]);
			$(aB2.screenBt).lineTo([4, 3]);
			$(aB2.screenBt).lineTo([3, 3]);
			$(aB2.screenBt).lineTo([3, 5]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([16, 3]);
			$(aB2.screenBt).lineTo([17, 3]);
			$(aB2.screenBt).lineTo([17, 5]);
			$(aB2.screenBt).lineTo([19, 5]);
			$(aB2.screenBt).lineTo([19, 6]);
			$(aB2.screenBt).lineTo([16, 6]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([16, 14]);
			$(aB2.screenBt).lineTo([19, 14]);
			$(aB2.screenBt).lineTo([19, 15]);
			$(aB2.screenBt).lineTo([17, 15]);
			$(aB2.screenBt).lineTo([17, 17]);
			$(aB2.screenBt).lineTo([16, 17]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([4, 17]);
			$(aB2.screenBt).lineTo([3, 17]);
			$(aB2.screenBt).lineTo([3, 15]);
			$(aB2.screenBt).lineTo([1, 15]);
			$(aB2.screenBt).lineTo([1, 14]);
			$(aB2.screenBt).lineTo([4, 14]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).fillRect([5, 7], {width:10, height:6})
		} else {
			$(aB2.screenBt).moveTo([4, 9]);
			$(aB2.screenBt).lineTo([3, 9]);
			$(aB2.screenBt).lineTo([3, 5]);
			$(aB2.screenBt).lineTo([7, 5]);
			$(aB2.screenBt).lineTo([7, 6]);
			$(aB2.screenBt).lineTo([4, 6]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([13, 5]);
			$(aB2.screenBt).lineTo([13, 6]);
			$(aB2.screenBt).lineTo([16, 6]);
			$(aB2.screenBt).lineTo([16, 9]);
			$(aB2.screenBt).lineTo([17, 9]);
			$(aB2.screenBt).lineTo([17, 5]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([13, 15]);
			$(aB2.screenBt).lineTo([13, 14]);
			$(aB2.screenBt).lineTo([16, 14]);
			$(aB2.screenBt).lineTo([16, 11]);
			$(aB2.screenBt).lineTo([17, 11]);
			$(aB2.screenBt).lineTo([17, 15]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([7, 15]);
			$(aB2.screenBt).lineTo([7, 14]);
			$(aB2.screenBt).lineTo([4, 14]);
			$(aB2.screenBt).lineTo([4, 11]);
			$(aB2.screenBt).lineTo([3, 11]);
			$(aB2.screenBt).lineTo([3, 15]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).fillRect([5, 7], {width:10, height:6})
		}
	}, drawScreenBtHover:function () {
		var aB2 = this;
		$(aB2.screenBt).clearRect([0, 0], {width:20, height:20});
		$(aB2.screenBt).style({'fillStyle':aB2.canvas.ak(aB2.controlBarPrimaryColor, 0.2)});
		$(aB2.screenBt).fillRect([0, 0], {width:20, height:20});
		$(aB2.screenBt).style({'fillStyle':aB2.canvas.ak(aB2.controlBarSecondaryColor, 1)});
		$(aB2.screenBt).beginPath();
		if (aB2.canvas.fullScreenMode) {
			$(aB2.screenBt).moveTo([1, 5]);
			$(aB2.screenBt).lineTo([1, 6]);
			$(aB2.screenBt).lineTo([4, 6]);
			$(aB2.screenBt).lineTo([4, 3]);
			$(aB2.screenBt).lineTo([3, 3]);
			$(aB2.screenBt).lineTo([3, 5]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([16, 3]);
			$(aB2.screenBt).lineTo([17, 3]);
			$(aB2.screenBt).lineTo([17, 5]);
			$(aB2.screenBt).lineTo([19, 5]);
			$(aB2.screenBt).lineTo([19, 6]);
			$(aB2.screenBt).lineTo([16, 6]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([16, 14]);
			$(aB2.screenBt).lineTo([19, 14]);
			$(aB2.screenBt).lineTo([19, 15]);
			$(aB2.screenBt).lineTo([17, 15]);
			$(aB2.screenBt).lineTo([17, 17]);
			$(aB2.screenBt).lineTo([16, 17]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([4, 17]);
			$(aB2.screenBt).lineTo([3, 17]);
			$(aB2.screenBt).lineTo([3, 15]);
			$(aB2.screenBt).lineTo([1, 15]);
			$(aB2.screenBt).lineTo([1, 14]);
			$(aB2.screenBt).lineTo([4, 14]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).fillRect([5, 7], {width:10, height:6})
		} else {
			$(aB2.screenBt).moveTo([4, 9]);
			$(aB2.screenBt).lineTo([3, 9]);
			$(aB2.screenBt).lineTo([3, 5]);
			$(aB2.screenBt).lineTo([7, 5]);
			$(aB2.screenBt).lineTo([7, 6]);
			$(aB2.screenBt).lineTo([4, 6]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([13, 5]);
			$(aB2.screenBt).lineTo([13, 6]);
			$(aB2.screenBt).lineTo([16, 6]);
			$(aB2.screenBt).lineTo([16, 9]);
			$(aB2.screenBt).lineTo([17, 9]);
			$(aB2.screenBt).lineTo([17, 5]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([13, 15]);
			$(aB2.screenBt).lineTo([13, 14]);
			$(aB2.screenBt).lineTo([16, 14]);
			$(aB2.screenBt).lineTo([16, 11]);
			$(aB2.screenBt).lineTo([17, 11]);
			$(aB2.screenBt).lineTo([17, 15]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).moveTo([7, 15]);
			$(aB2.screenBt).lineTo([7, 14]);
			$(aB2.screenBt).lineTo([4, 14]);
			$(aB2.screenBt).lineTo([4, 11]);
			$(aB2.screenBt).lineTo([3, 11]);
			$(aB2.screenBt).lineTo([3, 15]);
			$(aB2.screenBt).closePath();
			$(aB2.screenBt).fill();
			$(aB2.screenBt).fillRect([5, 7], {width:10, height:6})
		}
	}, setGlobals:function () {
		this.images = [];
		this.bv = 0;
		this.aL = 0;
		this.slideTimeout = null;
		this.autohidetimerID = null;
		this.autoHideControls = true;
		this.autoSlideShow = true;
		this.controlBarAlpha = 0.8;
		this.controlBarPrimaryColor = '#333333';
		this.controlBarSecondaryColor = '#ffffff';
		this.controlsHideSpeed = 2000;
		this.fullScreenButton = true;
		this.loadOriginalImages = false;
		this.navigationControls = true;
		this.scaleMode = 'scaleCrop';
		this.showImageIndex = true;
		this.showImageInfos = true;
		this.slideShowControls = true;
		this.slideShowSpeed = 6000;
		this.controlBarWidth = 0;
		this.infoBarWidth = 0;
		this.dM = 0;
		this.nextBt = 0;
		this.bM = 0;
		this.flagBusy = false;
		this.inCanvas = false;
		this.controlBarVisible = true;
		this.av = false;
		this.firstLoad = true;
		this.prevB = null;
		this.nextB = null;
		this.playpauseBt = null;
		this.screenBt = null;
		this.bf = 'normal';
		this.aM = 'normal';
		this.bO = 'normal';
		this.as = 'normal';
		this.fontSize = 10;
		this.controlLabelFontSize = 10;
		this.textTopOffset = 0;
		this.an = 0;
		this.aq = 0;
		this.preloaderPosition = 'centered';
		this.preloaderMT = 0;
		this.preloaderML = 0
	}, cU:function (callStack) {
		if (this.canvas.callStack != callStack) {
			return
		}
		if (typeof this.canvas.userConfigs.autoHideControls != 'undefined') {
			if (this.canvas.userConfigs.autoHideControls.toString() == 'true') {
				this.autoHideControls = true
			} else if (this.canvas.userConfigs.autoHideControls.toString() == 'false') {
				this.autoHideControls = false
			}
		}
		if (typeof this.canvas.userConfigs.autoSlideShow != 'undefined') {
			if (this.canvas.userConfigs.autoSlideShow.toString() == 'true') {
				this.autoSlideShow = true;
				this.canvas.flagSlideshowPlaying = true;
				this.canvas.flagAutoSlideShow = true
			} else if (this.canvas.userConfigs.autoSlideShow.toString() == 'false') {
				this.autoSlideShow = false;
				this.canvas.flagSlideshowPlaying = false;
				this.canvas.flagAutoSlideShow = false
			}
		}
		if (typeof this.canvas.userConfigs.controlBarAlpha != 'undefined') {
			this.controlBarAlpha = parseFloat(this.canvas.userConfigs.controlBarAlpha)
		}
		if (typeof this.canvas.userConfigs.controlBarPrimaryColor != 'undefined' && this.canvas.userConfigs.controlBarPrimaryColor.length) {
			this.controlBarPrimaryColor = this.canvas.userConfigs.controlBarPrimaryColor
		}
		if (typeof this.canvas.userConfigs.controlBarSecondaryColor != 'undefined' && this.canvas.userConfigs.controlBarSecondaryColor.length) {
			this.controlBarSecondaryColor = this.canvas.userConfigs.controlBarSecondaryColor
		}
		if (typeof this.canvas.userConfigs.controlsHideSpeed != 'undefined' && this.canvas.userConfigs.controlsHideSpeed > 0) {
			this.controlsHideSpeed = parseFloat(this.canvas.userConfigs.controlsHideSpeed) * 1000;
			this.canvas.audioHideSpeed = this.controlsHideSpeed
		}
		if (typeof this.canvas.userConfigs.fullScreenButton != 'undefined') {
			if (this.canvas.userConfigs.fullScreenButton.toString() == 'true') {
				this.fullScreenButton = true
			} else if (this.canvas.userConfigs.fullScreenButton.toString() == 'false') {
				this.fullScreenButton = false
			}
		}
		if (typeof this.canvas.userConfigs.loadOriginalImages != 'undefined') {
			if (this.canvas.userConfigs.loadOriginalImages.toString() == 'true') {
				this.loadOriginalImages = true
			} else if (this.canvas.userConfigs.loadOriginalImages.toString() == 'false') {
				this.loadOriginalImages = false
			}
		}
		if (typeof this.canvas.userConfigs.navigationControls != 'undefined') {
			if (this.canvas.userConfigs.navigationControls.toString() == 'true') {
				this.navigationControls = true
			} else if (this.canvas.userConfigs.navigationControls.toString() == 'false') {
				this.navigationControls = false
			}
		}
		if (typeof this.canvas.userConfigs.scaleMode != 'undefined') {
			if (this.canvas.userConfigs.scaleMode == 'scale' || this.canvas.userConfigs.scaleMode == 'scaleCrop') {
				this.scaleMode = this.canvas.userConfigs.scaleMode
			}
		}
		if (typeof this.canvas.userConfigs.showImageIndex != 'undefined') {
			if (this.canvas.userConfigs.showImageIndex.toString() == 'true') {
				this.showImageIndex = true
			} else if (this.canvas.userConfigs.showImageIndex.toString() == 'false') {
				this.showImageIndex = false
			}
		}
		if (typeof this.canvas.userConfigs.showImageInfos != 'undefined') {
			if (this.canvas.userConfigs.showImageInfos.toString() == 'true') {
				this.showImageInfos = true
			} else if (this.canvas.userConfigs.showImageInfos.toString() == 'false') {
				this.showImageInfos = false;
				this.showImageIndex = false
			}
		}
		if (typeof this.canvas.userConfigs.slideShowControls != 'undefined') {
			if (this.canvas.userConfigs.slideShowControls.toString() == 'true') {
				this.slideShowControls = true
			} else if (this.canvas.userConfigs.slideShowControls.toString() == 'false') {
				this.slideShowControls = false
			}
		}
		if (typeof this.canvas.userConfigs.slideShowSpeed != 'undefined' && this.canvas.userConfigs.slideShowSpeed > 0) {
			this.slideShowSpeed = parseFloat(this.canvas.userConfigs.slideShowSpeed) * 1000
		}
		if (typeof this.canvas.userConfigs.fontName != 'undefined' && this.canvas.userConfigs.fontName.length) {
			this.fontName = this.canvas.userConfigs.fontName
		}
		if (typeof this.canvas.userConfigs.controlLabelFontName != 'undefined' && this.canvas.userConfigs.controlLabelFontName.length) {
			this.controlLabelFontName = this.canvas.userConfigs.controlLabelFontName
		}
		if (typeof this.canvas.userConfigs.textTopOffset != 'undefined') {
			this.textTopOffset = this.canvas.userConfigs.textTopOffset
		}
		if (typeof this.canvas.userConfigs.fontSize != 'undefined' && this.canvas.userConfigs.fontSize > 0) {
			this.fontSize = this.canvas.userConfigs.fontSize
		}
		if (typeof this.canvas.userConfigs.controlLabelFontSize != 'undefined' && this.canvas.userConfigs.controlLabelFontSize > 0) {
			this.controlLabelFontSize = this.canvas.userConfigs.controlLabelFontSize
		}
		if (typeof this.canvas.userConfigs.bold != 'undefined') {
			if (this.canvas.userConfigs.bold.toString() == 'true') {
				this.bold = true
			} else if (this.canvas.userConfigs.bold.toString() == 'false') {
				this.bold = false
			}
		}
		if (typeof this.canvas.userConfigs.italic != 'undefined') {
			if (this.canvas.userConfigs.italic.toString() == 'true') {
				this.italic = true
			} else if (this.canvas.userConfigs.italic.toString() == 'false') {
				this.italic = false
			}
		}
		if (typeof this.canvas.userConfigs.controlLabelBold != 'undefined') {
			if (this.canvas.userConfigs.controlLabelBold.toString() == 'true') {
				this.controlLabelBold = true
			} else if (this.canvas.userConfigs.controlLabelBold.toString() == 'false') {
				this.controlLabelBold = false
			}
		}
		if (typeof this.canvas.userConfigs.controlLabelItalic != 'undefined') {
			if (this.canvas.userConfigs.controlLabelItalic.toString() == 'true') {
				this.controlLabelItalic = true
			} else if (this.canvas.userConfigs.controlLabelItalic.toString() == 'false') {
				this.controlLabelItalic = false
			}
		}
		if (typeof this.canvas.userConfigs.preloaderPosition != 'undefined') {
			if (this.canvas.userConfigs.preloaderPosition == 'centered' || this.canvas.userConfigs.preloaderPosition == 'topLeft' || this.canvas.userConfigs.preloaderPosition == 'topRight') {
				this.preloaderPosition = this.canvas.userConfigs.preloaderPosition
			} else {
				this.preloaderPosition = 'centered'
			}
		}
		var aB2 = this;
		if (typeof aB2.fontName == 'undefined') {
			aB2.fontName = '"Lucida Sans","Lucida Sans Unicode",Verdana,Arial,Helvetica,sans-serif'
		}
		if (typeof this.controlLabelFontName == 'undefined') {
			this.controlLabelFontName = '"Lucida Sans","Lucida Grande","Lucida Sans Unicode",Verdana,Arial,Helvetica,sans-serif'
		}
		if (aB2.bold == true) {
			aB2.bO = 'bold'
		}
		if (aB2.italic == true) {
			aB2.as = 'italic'
		}
		if (aB2.controlLabelBold == true) {
			aB2.bf = 'bold'
		}
		if (aB2.controlLabelItalic == true) {
			aB2.aM = 'italic'
		}
		if (typeof aB2.controlLabelFontSize == 'undefined') {
			aB2.controlLabelFontSize = aB2.fontSize
		}
		$.tocssRule('#' + this.canvas.bU + ' {' + 'font-family: ' + aB2.fontName + '; ' + 'font-size: ' + aB2.fontSize + 'px; ' + 'font-weight: ' + aB2.bf + '; ' + 'font-style: ' + aB2.aM + '; ' + '}');
		if (aB2.textTopOffset >= 0) {
			aB2.an = aB2.aq + aB2.textTopOffset
		} else {
			aB2.an = 0
		}
		var i = 0;
		aB2.images = [];
		for (var i = 0, j = 0; i < aB2.canvas.xml.items.item.length; i++) {
			if (typeof aB2.canvas.xml.items.item[i].largeImagePath != 'undefined' && aB2.canvas.xml.items.item[i].largeImagePath != '') {
				aB2.images[j] = {};
				aB2.images[j].largeImagePath = aB2.canvas.xml.items.item[i].largeImagePath;
				if (typeof aB2.canvas.xml.items.item[i].fullScreenImagePath != 'undefined' && aB2.canvas.xml.items.item[i].fullScreenImagePath.length > 0) {
					aB2.images[j].fullScreenImagePath = aB2.canvas.xml.items.item[i].fullScreenImagePath
				} else {
					aB2.images[j].fullScreenImagePath = aB2.canvas.xml.items.item[i].largeImagePath
				}
				if (typeof aB2.canvas.xml.items.item[i].title != 'undefined') {
					aB2.images[j].title = aB2.canvas.xml.items.item[i].title
				} else {
					aB2.images[j].title = ''
				}
				if (typeof aB2.canvas.xml.items.item[i].description != 'undefined') {
					aB2.images[j].description = aB2.canvas.xml.items.item[i].description.replace(/\r\n/g, '<br />').replace(/\n/g, '<br />').replace(/\r/g, '<br />')
				} else {
					aB2.images[j].description = ''
				}
				aB2.images[j].loaded = 0;
				aB2.images[j].title_visible = '';
				aB2.images[j].cs = '';
				j++
			}
		}
		if (aB2.images.length == 0) {
			return false
		}
		aB2.controlBarWidth = 0;
		aB2.dM = 0;
		aB2.bM = 0;
		aB2.nextBt = 0;
		if (aB2.navigationControls) {
			aB2.controlBarWidth += 50;
			aB2.dM += 25;
			aB2.bM += 50;
			aB2.nextBt += 25
		}
		if (aB2.slideShowControls) {
			aB2.controlBarWidth += 25;
			aB2.nextBt += 25;
			aB2.bM += 25
		}
		if (aB2.fullScreenButton) {
			aB2.controlBarWidth += 25
		}
		var rWidth = aB2.controlBarWidth;
		var obj = aB2.identifier;
		if (aB2.showImageInfos) {
			$('<div />').attr('id', aB2.bK).hide().hover(function () {
				aB2.av = true
			},function () {
				aB2.av = false
			}).css({position:'absolute'}).appendTo('#' + aB2.canvas.bU);
			$('<div />').attr('id', aB2.bK + '_bg').hide().css({position:'absolute'}).appendTo('#' + aB2.canvas.bU);
			$('<div />').attr('id', aB2.bK + '_iTitle').css({position:'absolute'}).appendTo('#' + aB2.bK);
			$('<div />').attr('id', aB2.bK + '_iDescription').css({position:'absolute'}).appendTo('#' + aB2.bK);
			if (aB2.showImageIndex) {
				$('<div />').attr('id', aB2.bK + '_pIndex').css({position:'absolute'}).appendTo('#' + aB2.bK)
			}
		}
		$('#' + aB2.canvas.bU).touchwipe({wipeLeft:function () {
			aB2.bN(callStack)
		}, wipeRight:function () {
			aB2.am(callStack)
		}});
		$('<div />').attr('id', aB2.aN).hide().css({position:'absolute', height:'20px', width:aB2.controlBarWidth}).appendTo('#' + aB2.canvas.bU);
		if (aB2.navigationControls) {
			aB2.prevB = $('<div />').attr('id', aB2.aN + '_ctrl1').css({cursor:'pointer', width:20, minWidth:20, height:20, minHeight:20}).appendTo('#' + aB2.aN);
			$('<div />').attr('id', aB2.aN + '_ctrl1_handler').css({position:'absolute', zIndex:50, cursor:'pointer', width:20, minWidth:20, height:20, minHeight:20, backgroundImage:'url(' + aB2.canvas.imgBlankUrl + ')'}).appendTo('#' + aB2.aN).bind('click',function () {
				aB2.am(callStack)
			}).mouseover(function () {
				aB2.av = true;
				aB2.drawPrevHover()
			}).mouseout(function () {
				aB2.av = false;
				aB2.drawPrev()
			});
			$(aB2.prevB).canvas();
			aB2.drawPrev();
			aB2.nextB = $('<div />').attr('id', aB2.aN + '_ctrl3').appendTo('#' + aB2.aN).css({cursor:'pointer', position:'absolute', marginLeft:aB2.nextBt, width:20, minWidth:20, height:20, minHeight:20});
			$('<div />').attr('id', aB2.aN + '_ctrl3_handler').css({position:'absolute', marginLeft:aB2.nextBt, zIndex:50, cursor:'pointer', width:20, minWidth:20, height:20, minHeight:20, backgroundImage:'url(' + aB2.canvas.imgBlankUrl + ')'}).appendTo('#' + aB2.aN).bind('click',function () {
				aB2.bN(callStack)
			}).mouseover(function () {
				aB2.av = true;
				aB2.drawNextHover()
			}).mouseout(function () {
				aB2.av = false;
				aB2.drawNext()
			});
			$(aB2.nextB).canvas();
			aB2.drawNext()
		}
		if (aB2.slideShowControls) {
			aB2.playpauseBt = $('<div />').attr('id', aB2.aN + '_ctrl2').css({cursor:'pointer', position:'absolute', marginLeft:aB2.dM, width:20, minWidth:20, height:20, minHeight:20}).appendTo('#' + aB2.aN);
			$('<div />').attr('id', aB2.aN + '_ctrl2_handler').css({position:'absolute', marginLeft:aB2.dM, zIndex:50, cursor:'pointer', width:20, minWidth:20, height:20, minHeight:20, backgroundImage:'url(' + aB2.canvas.imgBlankUrl + ')'}).appendTo('#' + aB2.aN).bind('click',function () {
				aB2.ppControl(callStack)
			}).mouseover(function () {
				aB2.av = true;
				aB2.drawPlayPauseHover()
			}).mouseout(function () {
				aB2.av = false;
				aB2.drawPlayPause()
			});
			$(aB2.playpauseBt).canvas();
			aB2.drawPlayPause()
		}
		if (aB2.fullScreenButton) {
			aB2.screenBt = $('<div />').attr('id', aB2.aN + '_ctrl4').css({cursor:'pointer', position:'absolute', marginLeft:aB2.bM, width:20, minWidth:20, height:20, minHeight:20}).appendTo('#' + aB2.aN);
			$('<div />').attr('id', aB2.aN + '_ctrl4_handler').css({position:'absolute', marginLeft:aB2.bM, zIndex:50, cursor:'pointer', width:20, minWidth:20, height:20, minHeight:20, backgroundImage:'url(' + aB2.canvas.imgBlankUrl + ')'}).appendTo('#' + aB2.aN).bind('click',function () {
				aB2.screenControl()
			}).mouseover(function () {
				aB2.av = true;
				aB2.drawScreenBtHover()
			}).mouseout(function () {
				aB2.av = false;
				aB2.drawScreenBt()
			});
			$(aB2.screenBt).canvas();
			aB2.drawScreenBt()
		}
		if (aB2.autoHideControls) {
			var instanceNO = aB2.canvas.instanceNO;
			$(document).mousemove(function (e) {
				if (aB2.canvas.bk() || instanceNO != aB2.canvas.instanceNO || callStack != aB2.canvas.callStack) {
					return
				}
				if (aB2.firstLoad)return true;
				var offs = $('#' + aB2.canvas.bU).offset();
				if ((e.pageX < offs.left) || (e.pageY < offs.top) || (e.pageX > offs.left + aB2.canvas.bL) || (e.pageY > offs.top + aB2.canvas.aI)) {
					if (aB2.inCanvas) {
						aB2.autoHideControlBar();
						aB2.inCanvas = false;
						aB2.controlBarVisible = false
					}
				} else {
					clearTimeout(aB2.autohidetimerID);
					if (!aB2.av) {
						aB2.autohidetimerID = setTimeout("window." + aB2.identifier + ".autoHideControlBar()", aB2.controlsHideSpeed)
					}
					if (!aB2.inCanvas || !aB2.controlBarVisible) {
						aB2.fadeinInfoBar();
						$('#' + aB2.aN).stop(true, true).fadeIn('fast');
						aB2.inCanvas = true;
						aB2.controlBarVisible = true
					}
				}
			});
			$('#' + aB2.canvas.bU).click(function (e) {
				if (aB2.aT() || aB2.canvas.bk() || instanceNO != aB2.canvas.instanceNO || callStack != aB2.canvas.callStack) {
					return
				}
				if (aB2.autoHideControls && !aB2.dJ) {
					clearTimeout(aB2.autohidetimerID);
					if (!aB2.av) {
						aB2.autohidetimerID = setTimeout('window.' + aB2.identifier + '.autoHideControlBar()', aB2.controlsHideSpeed)
					}
					if (!aB2.controlBarVisible) {
						aB2.fadeinInfoBar();
						$('#' + aB2.aN).stop(true, true).fadeIn('fast');
						aB2.inCanvas = true;
						aB2.controlBarVisible = true
					}
				}
			})
		}
		return true
	}, dp:function () {
		var aB2 = this;
		if (aB2.preloaderPosition == 'centered') {
			aB2.preloaderML = Math.floor(aB2.canvas.bB / 2) - Math.floor($('#' + aB2.canvas.aK).width() / 2);
			aB2.preloaderMT = Math.floor(aB2.canvas.bj / 2) - Math.floor($('#' + aB2.canvas.aK).height() / 2)
		}
		if (aB2.preloaderPosition == 'topLeft') {
			aB2.preloaderML = 0;
			aB2.preloaderMT = 0
		}
		if (aB2.preloaderPosition == 'topRight') {
			aB2.preloaderML = aB2.canvas.bB - $('#' + aB2.canvas.aK).width();
			aB2.preloaderMT = 0;
			aB2.canvas.hideAudioPlayer()
		}
		return
	}, autoHideControlBar:function () {
		var aB2 = this;
		$('#' + aB2.aN).stop(true, true).fadeOut('fast');
		aB2.controlBarVisible = false;
		aB2.fadeOutInfoBar()
	}, fadeOutInfoBar:function () {
		var aB2 = this;
		if (!aB2.showImageInfos)return;
		$('#' + aB2.bK).stop(true, true).fadeOut('fast');
		$('#' + aB2.bK + '_bg').stop(true, true).fadeOut('fast')
	}, fadeinInfoBar:function () {
		var aB2 = this;
		if (!aB2.showImageInfos)return;
		$('#' + aB2.bK).stop(true, true).fadeIn('fast');
		$('#' + aB2.bK + '_bg').stop(true, true).fadeIn('fast')
	}, bS:function () {
		var aB2 = this;
		if (!aB2.showImageInfos)return;
		$('#' + aB2.bK).show();
		$('#' + aB2.bK + '_bg').show()
	}, de:function () {
		var aB2 = this;
		if (!aB2.showImageInfos)return;
		$('#' + aB2.bK).hide()
	}, actualizeInfoBar:function () {
		var aB2 = this;
		var noInfo = true;
		if (aB2.images[aB2.bv].description != '' || aB2.images[aB2.bv].title != '') {
			noInfo = false
		}
		var ibH, ibW, ibML, ibMT, extraC;
		var ibIndex;
		var cInd = aB2.bv + 1;
		var iCount = aB2.images.length;
		ibIndex = 'IMAGE ' + cInd + '/' + iCount;
		extraC = ibIndex.length - 10;
		ibH = 0;
		if (aB2.showImageInfos) {
			if ((aB2.images[aB2.bv].description != '') && (aB2.images[aB2.bv].title != '')) {
				ibH = 39
			} else {
				if ((aB2.images[aB2.bv].description != '') || (aB2.images[aB2.bv].title != '')) {
					ibH = 20
				}
			}
			if ((aB2.images[aB2.bv].description == '') && (aB2.images[aB2.bv].title == '')) {
				if (aB2.showImageIndex) {
					ibH = 20
				}
			}
		}
		ibMT = (aB2.canvas.bj - (5 + ibH));
		var descWidth = 0;
		if (!noInfo) {
			ibML = 5;
			ibW = aB2.canvas.bB - (aB2.controlBarWidth + 10);
			if (aB2.showImageIndex) {
				descWidth = ibW - (extraC * 6)
			} else {
				descWidth = ibW - 10
			}
		} else {
			ibW = 65 + extraC * 6;
			if (aB2.showImageIndex) {
				ibW = aB2.canvas.bB - (aB2.controlBarWidth + 10)
			}
			ibML = aB2.canvas.bB - (aB2.controlBarWidth + ibW + 5)
		}
		var mTopDesc = 0;
		var mTopInd = 0;
		var mLeftInd = 0;
		if (aB2.images[aB2.bv].title != '') {
			mTopDesc = 19
		}
		if (!noInfo) {
			mLeftInd = ibW - (extraC * 6);
			if (aB2.images[aB2.bv].description != '' && aB2.images[aB2.bv].title != '') {
				mTopInd = 19
			}
		}
		mLeftInd += 5;
		if (aB2.showImageInfos) {
			var id = aB2.bv;
			var bA = 10;
			var cS = 0;
			if (aB2.showImageIndex) {
				$('<span />').hide().attr('id', aB2.bK + '_span_index_' + id).css({'font':aB2.as + ' ' + aB2.bO + ' ' + aB2.fontSize + 'px ' + aB2.fontName}).html(ibIndex).appendTo('#' + aB2.canvas.bU);
				bA = $('#' + aB2.bK + '_span_index_' + id).width() + 10;
				cS = $('#' + aB2.bK + '_span_index_' + id).height() + 6
			}
			$('#' + aB2.bK + '_span_index_' + id).remove();
			mLeftInd -= bA;
			$('<span />').hide().attr('id', aB2.bK + '_span_' + id).css({'font':aB2.as + ' ' + aB2.bO + ' ' + aB2.fontSize + 'px ' + aB2.fontName}).appendTo('#' + aB2.canvas.bU);
			var str = aB2.images[id].title;
			var title_max_width = (ibW - aB2.fontSize);
			if (aB2.images[id].description == '') {
				title_max_width = (descWidth - bA - aB2.fontSize - 5)
			}
			for (j = 0; j < str.length; j++) {
				aB2.images[id].title_visible = str.substr(0, j) + '...';
				$('#' + aB2.bK + '_span_' + id).html(aB2.images[id].title_visible);
				if ($('#' + aB2.bK + '_span_' + id).width() > title_max_width) {
					break
				} else {
					aB2.images[id].title_visible = str.substr(0, j + 1)
				}
			}
			var aZ = 2;
			if (aB2.textTopOffset < 0) {
				aZ = 2 + aB2.textTopOffset
			}
			var aJ = $('#' + aB2.bK + '_span_' + id).height();
			if (aJ < 20) {
				aJ = 20
			}
			if (aB2.images[id].description != '') {
				aJ = $('#' + aB2.bK + '_span_' + id).height() + 1
			}
			if (aB2.images[id].title == '') {
				aJ = 0
			}
			$('#' + aB2.bK + '_iTitle').css({zIndex:13, paddingTop:aB2.an + 'px', 'font':aB2.as + ' ' + aB2.bO + ' ' + aB2.fontSize + 'px ' + aB2.fontName, color:aB2.controlBarSecondaryColor, height:aJ + 'px', width:(ibW - 8) + 'px', marginLeft:'5px', marginTop:aZ + 'px', overflow:'hidden'}).html(aB2.images[aB2.bv].title_visible);
			var str = aB2.images[id].description;
			for (j = 0; j < str.length; j++) {
				aB2.images[id].cs = str.substr(0, j) + '...';
				$('#' + aB2.bK + '_span_' + id).html(aB2.images[id].cs);
				if ($('#' + aB2.bK + '_span_' + id).width() > (descWidth - bA - aB2.fontSize - 5)) {
					break
				} else {
					aB2.images[id].cs = str.substr(0, j + 1)
				}
			}
			$('#' + aB2.bK + '_span_' + id).html(aB2.images[id].cs);
			var cA = $('#' + aB2.bK + '_span_' + id).height() + 6;
			if (cA < 20) {
				cA = 20
			}
			if (aB2.images[id].description == '') {
				cA = 0
			}
			$('#' + aB2.bK + '_span_' + id).remove();
			descWidth -= bA - aB2.fontSize - 5;
			$('#' + aB2.bK + '_iDescription').css({zIndex:13, color:aB2.controlBarSecondaryColor, marginTop:(aJ + aZ + 1) + 'px', marginLeft:'5px', width:descWidth + 'px', height:cA + 'px', 'font':aB2.as + ' ' + aB2.bO + ' ' + aB2.fontSize + 'px ' + aB2.fontName, overflow:'hidden', paddingTop:aB2.an + 'px'}).html(aB2.images[aB2.bv].cs);
			if (aB2.images.length < 10) {
				mLeftInd -= 5
			}
			if (aB2.showImageIndex) {
				var p_index_mt = (aJ + aZ + 1);
				if (aB2.images[id].description == '') {
					p_index_mt = aZ + 1
				}
				$('#' + aB2.bK + '_pIndex').css({width:bA + 'px', zIndex:13, color:aB2.controlBarSecondaryColor, marginTop:p_index_mt + 'px', marginLeft:mLeftInd + 'px', paddingTop:aB2.an + 'px', 'font':aB2.as + ' ' + aB2.bO + ' ' + aB2.fontSize + 'px ' + aB2.fontName}).html(ibIndex)
			}
			ibH = aJ + cA;
			if (aB2.images[id].title == '') {
				ibH = cA
			}
			if (aB2.images[id].description == '') {
				ibH = aJ
			}
			if (aB2.images[id].title == '' && aB2.images[id].description == '') {
				if (aB2.showImageIndex) {
					ibH = cS;
					mLeftInd = ibW - bA;
					$('#' + aB2.bK + '_pIndex').css({marginLeft:mLeftInd + 'px'})
				} else {
					ibH = 0
				}
			}
			ibMT = aB2.canvas.bj - (ibH + 5);
			ibML = 5;
			$('#' + aB2.bK + '_bg').css({width:ibW + 'px', height:ibH + 'px', marginTop:ibMT + 'px', marginLeft:ibML + 'px', zIndex:12, opacity:aB2.controlBarAlpha, backgroundColor:aB2.controlBarPrimaryColor});
			$('#' + aB2.bK).css({width:ibW + 'px', height:ibH + 'px', marginTop:ibMT + 'px', marginLeft:ibML + 'px', zIndex:13})
		}
	}, dq:function (callStack) {
		var aB2 = this;
		if (aB2.canvas.callStack != callStack) {
			return
		}
		if (typeof aB2.bv != 'number') {
			aB2.bv = 0
		}
		aB2.canvas.ay();
		aB2.showCurrentImage(aB2.canvas.instanceNo, callStack)
	}, bc:function (id, callback, co, callStack) {
		var aB2 = this;
		if (aB2.canvas.callStack != callStack) {
			return
		}
		if (aB2.canvas.bk()) {
			return
		}
		if (aB2.canvas.fullScreenMode == true) {
			if (aB2.images[id].error1 == 1) {
				aB2.images[id].src = aB2.images[id]['largeImagePath']
			} else {
				aB2.images[id].src = aB2.images[id]['fullScreenImagePath']
			}
		} else {
			aB2.images[id].src = aB2.images[id]['largeImagePath']
		}
		aB2.images[id].bw = document.createElement('img');
		var obj = aB2.identifier;
		eval('var res=window.' + obj);
		$(aB2.images[id].bw).load(function () {
			if (aB2.canvas.callStack != callStack) {
				return
			}
			$(this).unbind('load');
			aB2.images[id]['loaded'] = 1;
			if (typeof callback != 'undefined' && !aB2.canvas.bk() && co == aB2.canvas.fullScreenMode) {
				eval(callback)
			}
		}).error(function () {
			if (aB2.canvas.callStack != callStack) {
				return
			}
			if (aB2.images[id].src != aB2.images[id].largeImagePath) {
				aB2.images[id].error1 = 1;
				aB2.bc(id, callback, co, callStack);
				return
			}
			$(this).unbind('error');
			aB2.images[id].error = 1;
			if (typeof callback != 'undefined' && !aB2.canvas.bk() && co == aB2.canvas.fullScreenMode) {
				eval(callback)
			}
		});
		aB2.images[id].bw.lang = id;
		aB2.images[id].bw.src = aB2.images[id].src
	}, dv:function () {
		var aB2 = this;
		if (aB2.loadOriginalImages) {
			return
		}
		var cH = $(aB2.images[aB2.bv].bw).height();
		var cW = $(aB2.images[aB2.bv].bw).width();
		var canvH = aB2.canvas.bj;
		if (cH <= aB2.canvas.bj && cW <= aB2.canvas.bB) {
			return
		}
		var bg = aB2.canvas.bB / aB2.canvas.bj;
		var imageProp = cW / cH;
		var ref;
		switch (aB2.scaleMode) {
			case'scale':
				if (bg > imageProp) {
					if (cH < canvH) {
						ref = cH
					} else {
						ref = canvH
					}
					$(aB2.images[aB2.bv].bw).height(ref).width(Math.ceil(cW * ref / cH))
				} else {
					if (cW < aB2.canvas.bB) {
						ref = cW
					} else {
						ref = aB2.canvas.bB
					}
					$(aB2.images[aB2.bv].bw).width(ref).height(Math.ceil(cH * ref / cW))
				}
				break;
			case'scaleCrop':
			default:
				if (bg > imageProp) {
					if (cW < aB2.canvas.bB) {
						ref = cW
					} else {
						ref = aB2.canvas.bB
					}
					$(aB2.images[aB2.bv].bw).width(ref).height(Math.ceil(cH * ref / cW))
				} else {
					if (cH < canvH) {
						ref = cH
					} else {
						ref = canvH
					}
					$(aB2.images[aB2.bv].bw).height(ref).width(Math.ceil(cW * ref / cH))
				}
				break
		}
	}, showCurrentImage:function (instanceNO, callStack) {
		var aB2 = this;
		if (aB2.canvas.bk()) {
			return
		}
		if (typeof instanceNO == 'undefined') {
			var instanceNO = aB2.canvas.instanceNO
		} else if (instanceNO != aB2.canvas.instanceNO) {
			return
		}
		if (typeof callStack == 'undefined') {
			var callStack = aB2.canvas.callStack
		} else if (callStack != aB2.canvas.callStack) {
			return
		}
		aB2.actualizeInfoBar();
		if (!aB2.controlBarVisible) {
			aB2.de()
		} else {
			if (!aB2.firstLoad) {
				aB2.bS()
			}
		}
		clearTimeout(aB2.slideTimeout);
		if (aB2.images[aB2.bv].loaded != 1 && aB2.images[aB2.bv].error != 1) {
			aB2.dp();
			$('#' + aB2.canvas.aK).css({marginLeft:aB2.preloaderML + 'px', marginTop:aB2.preloaderMT + 'px'}).show();
			aB2.bc(aB2.bv, 'window.' + aB2.identifier + '.showCurrentImage(' + instanceNO + ', ' + callStack + ')', aB2.canvas.fullScreenMode, callStack);
			return
		}
		aB2.canvas.au();
		aB2.canvas.showAudioPlayer();
		aB2 = this;
		var mTop, mLeft;
		if (aB2.aL != aB2.bv) {
			mTop = Math.floor((aB2.canvas.bj - $(aB2.images[aB2.aL].bw).attr('height')) / 2);
			mLeft = Math.floor((aB2.canvas.bB - $(aB2.images[aB2.aL].bw).attr('width')) / 2);
			$(aB2.images[aB2.aL].bw).attr('id', aB2.bn).appendTo('#' + aB2.canvas.bU).css({position:'absolute', cursor:'pointer', zIndex:10, marginTop:mTop + 'px', marginLeft:mLeft + 'px'})
		}
		var obj = aB2.identifier;
		$(aB2.images[aB2.bv].bw).hide().attr('id', aB2.imageIdentifier).appendTo('#' + aB2.canvas.bU);
		aB2.dv();
		mTop = Math.floor((aB2.canvas.bj - $(aB2.images[aB2.bv].bw).height()) / 2);
		mLeft = Math.floor((aB2.canvas.bB - $(aB2.images[aB2.bv].bw).width()) / 2);
		$(aB2.images[aB2.bv].bw).css({position:'absolute', cursor:'pointer', zIndex:11, overflow:'hidden', marginTop:mTop + 'px', marginLeft:mLeft + 'px'}).show().hide().fadeIn('normal',function () {
			aB2.setBusyFlagOff();
			aB2.showControlBar(instanceNO, callStack)
		}).bind('click', function () {
			aB2.nextImage(callStack)
		});
		if (aB2.aL != aB2.bv && (aB2.images[aB2.aL].loaded == 1 || aB2.images[aB2.aL].error == 1)) {
			$('#' + aB2.bn).fadeOut('normal', function () {
				$(this).unbind().hide();
				$(this).remove()
			})
		}
		if (aB2.autoHideControls) {
			clearTimeout(aB2.autohidetimerID);
			if (!aB2.av) {
				aB2.autohidetimerID = setTimeout("window." + aB2.identifier + ".autoHideControlBar()", aB2.controlsHideSpeed)
			}
		}
		if (aB2.autoSlideShow == true) {
			aB2.slideTimeout = setTimeout('window.' + aB2.identifier + '.nextImage(' + callStack + ')', aB2.slideShowSpeed);
			aB2.canvas.timeoutResources.push(aB2.slideTimeout)
		}
	}, showControlBar:function (instanceNO, callStack) {
		var aB2 = this;
		if (aB2.canvas.bk()) {
			return
		}
		if (instanceNO != aB2.canvas.instanceNO || callStack != aB2.canvas.callStack) {
			return
		}
		aB2.controlBarVisible = true;
		aB2.bS();
		$('#' + aB2.aN).css({zIndex:12, marginTop:aB2.canvas.bj - 25 + 'px', marginLeft:aB2.canvas.bB - aB2.controlBarWidth + 'px'}).show();
		if (aB2.firstLoad) {
			aB2.firstLoad = false
		}
		aB2.canvas.showAudioPlayer()
	}, aT:function () {
		var aB2 = this;
		return aB2.flagBusy == true
	}, setBusyFlagOff:function () {
		var aB2 = this;
		aB2.flagBusy = false
	}, ao:function () {
		var aB2 = this;
		aB2.flagBusy = true
	}, nextImage:function (callStack) {
		var aB2 = this;
		if (callStack != aB2.canvas.callStack) {
			return
		}
		if (aB2.aT() || aB2.canvas.bk()) {
			return
		}
		aB2.ao();
		$('#' + aB2.imageIdentifier).unbind('click');
		aB2.aL = aB2.bv;
		if (aB2.bv < aB2.images.length - 1) {
			aB2.bv++
		} else {
			aB2.bv = 0
		}
		aB2.showCurrentImage()
	}, prevImage:function (callStack) {
		var aB2 = this;
		if (callStack != aB2.canvas.callStack) {
			return
		}
		if (aB2.aT() || aB2.canvas.bk()) {
			return
		}
		aB2.ao();
		$('#' + aB2.imageIdentifier).unbind('click');
		aB2.aL = aB2.bv;
		if (aB2.bv > 0) {
			aB2.bv--
		} else {
			aB2.bv = aB2.images.length - 1
		}
		aB2.showCurrentImage()
	}}
})(SsbBase);
