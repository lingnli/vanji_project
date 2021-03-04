/******/ (function(modules) { // webpackBootstrap
/******/ 	// install a JSONP callback for chunk loading
/******/ 	function webpackJsonpCallback(data) {
/******/ 		var chunkIds = data[0];
/******/ 		var moreModules = data[1];
/******/ 		var executeModules = data[2];
/******/
/******/ 		// add "moreModules" to the modules object,
/******/ 		// then flag all "chunkIds" as loaded and fire callback
/******/ 		var moduleId, chunkId, i = 0, resolves = [];
/******/ 		for(;i < chunkIds.length; i++) {
/******/ 			chunkId = chunkIds[i];
/******/ 			if(installedChunks[chunkId]) {
/******/ 				resolves.push(installedChunks[chunkId][0]);
/******/ 			}
/******/ 			installedChunks[chunkId] = 0;
/******/ 		}
/******/ 		for(moduleId in moreModules) {
/******/ 			if(Object.prototype.hasOwnProperty.call(moreModules, moduleId)) {
/******/ 				modules[moduleId] = moreModules[moduleId];
/******/ 			}
/******/ 		}
/******/ 		if(parentJsonpFunction) parentJsonpFunction(data);
/******/
/******/ 		while(resolves.length) {
/******/ 			resolves.shift()();
/******/ 		}
/******/
/******/ 		// add entry modules from loaded chunk to deferred list
/******/ 		deferredModules.push.apply(deferredModules, executeModules || []);
/******/
/******/ 		// run deferred modules when all chunks ready
/******/ 		return checkDeferredModules();
/******/ 	};
/******/ 	function checkDeferredModules() {
/******/ 		var result;
/******/ 		for(var i = 0; i < deferredModules.length; i++) {
/******/ 			var deferredModule = deferredModules[i];
/******/ 			var fulfilled = true;
/******/ 			for(var j = 1; j < deferredModule.length; j++) {
/******/ 				var depId = deferredModule[j];
/******/ 				if(installedChunks[depId] !== 0) fulfilled = false;
/******/ 			}
/******/ 			if(fulfilled) {
/******/ 				deferredModules.splice(i--, 1);
/******/ 				result = __webpack_require__(__webpack_require__.s = deferredModule[0]);
/******/ 			}
/******/ 		}
/******/ 		return result;
/******/ 	}
/******/
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// object to store loaded and loading chunks
/******/ 	// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 	// Promise = chunk loading, 0 = chunk loaded
/******/ 	var installedChunks = {
/******/ 		"scripts": 0
/******/ 	};
/******/
/******/ 	var deferredModules = [];
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "dist/";
/******/
/******/ 	var jsonpArray = window["webpackJsonp"] = window["webpackJsonp"] || [];
/******/ 	var oldJsonpFunction = jsonpArray.push.bind(jsonpArray);
/******/ 	jsonpArray.push = webpackJsonpCallback;
/******/ 	jsonpArray = jsonpArray.slice();
/******/ 	for(var i = 0; i < jsonpArray.length; i++) webpackJsonpCallback(jsonpArray[i]);
/******/ 	var parentJsonpFunction = oldJsonpFunction;
/******/
/******/
/******/ 	// add entry module to deferred list
/******/ 	deferredModules.push(["./js/scripts.js","vendor"]);
/******/ 	// run deferred modules when ready
/******/ 	return checkDeferredModules();
/******/ })
/************************************************************************/
/******/ ({

/***/ "./js/plugs/imgLiquid-min.js":
/*!***********************************!*\
  !*** ./js/plugs/imgLiquid-min.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(jQuery) {var _imgLiquid = _imgLiquid || {
  VER: "0.9.944"
};

_imgLiquid.bgs_Available = !1, _imgLiquid.bgs_CheckRunned = !1, _imgLiquid.injectCss = ".imgLiquid img {visibility:hidden}", function (i) {
  function t() {
    if (!_imgLiquid.bgs_CheckRunned) {
      _imgLiquid.bgs_CheckRunned = !0;
      var t = i('<span style="background-size:cover" />');
      i("body").append(t), !function () {
        var i = t[0];

        if (i && window.getComputedStyle) {
          var e = window.getComputedStyle(i, null);
          e && e.backgroundSize && (_imgLiquid.bgs_Available = "cover" === e.backgroundSize);
        }
      }(), t.remove();
    }
  }

  i.fn.extend({
    imgLiquid: function imgLiquid(e) {
      this.defaults = {
        fill: !0,
        verticalAlign: "center",
        horizontalAlign: "center",
        useBackgroundSize: !0,
        useDataHtmlAttr: !0,
        responsive: !0,
        delay: 0,
        fadeInTime: 0,
        removeBoxBackground: !0,
        hardPixels: !0,
        responsiveCheckTime: 500,
        timecheckvisibility: 500,
        onStart: null,
        onFinish: null,
        onItemStart: null,
        onItemFinish: null,
        onItemError: null
      }, t();
      var a = this;
      return this.options = e, this.settings = i.extend({}, this.defaults, this.options), this.settings.onStart && this.settings.onStart(), this.each(function (t) {
        function e() {
          -1 === u.css("background-image").indexOf(encodeURI(c.attr("src"))) && u.css({
            "background-image": 'url("' + encodeURI(c.attr("src")) + '")'
          }), u.css({
            "background-size": g.fill ? "cover" : "contain",
            "background-position": (g.horizontalAlign + " " + g.verticalAlign).toLowerCase(),
            "background-repeat": "no-repeat"
          }), i("a:first", u).css({
            display: "block",
            width: "100%",
            height: "100%"
          }), i("img", u).css({
            display: "none"
          }), g.onItemFinish && g.onItemFinish(t, u, c), u.addClass("imgLiquid_bgSize"), u.addClass("imgLiquid_ready"), l();
        }

        function d() {
          function e() {
            c.data("imgLiquid_error") || c.data("imgLiquid_loaded") || c.data("imgLiquid_oldProcessed") || (u.is(":visible") && c[0].complete && c[0].width > 0 && c[0].height > 0 ? (c.data("imgLiquid_loaded", !0), setTimeout(r, t * g.delay)) : setTimeout(e, g.timecheckvisibility));
          }

          if (c.data("oldSrc") && c.data("oldSrc") !== c.attr("src")) {
            var a = c.clone().removeAttr("style");
            return a.data("imgLiquid_settings", c.data("imgLiquid_settings")), c.parent().prepend(a), c.remove(), c = a, c[0].width = 0, setTimeout(d, 10), void 0;
          }

          return c.data("imgLiquid_oldProcessed") ? (r(), void 0) : (c.data("imgLiquid_oldProcessed", !1), c.data("oldSrc", c.attr("src")), i("img:not(:first)", u).css("display", "none"), u.css({
            overflow: "hidden"
          }), c.fadeTo(0, 0).removeAttr("width").removeAttr("height").css({
            visibility: "visible",
            "max-width": "none",
            "max-height": "none",
            width: "auto",
            height: "auto",
            display: "block"
          }), c.on("error", n), c[0].onerror = n, e(), o(), void 0);
        }

        function o() {
          (g.responsive || c.data("imgLiquid_oldProcessed")) && c.data("imgLiquid_settings") && (g = c.data("imgLiquid_settings"), u.actualSize = u.get(0).offsetWidth + u.get(0).offsetHeight / 1e4, u.sizeOld && u.actualSize !== u.sizeOld && r(), u.sizeOld = u.actualSize, setTimeout(o, g.responsiveCheckTime));
        }

        function n() {
          c.data("imgLiquid_error", !0), u.addClass("imgLiquid_error"), g.onItemError && g.onItemError(t, u, c), l();
        }

        function s() {
          var i = {};

          if (a.settings.useDataHtmlAttr) {
            var t = u.attr("data-imgLiquid-fill"),
                e = u.attr("data-imgLiquid-horizontalAlign"),
                d = u.attr("data-imgLiquid-verticalAlign");
            ("true" === t || "false" === t) && (i.fill = Boolean("true" === t)), void 0 === e || "left" !== e && "center" !== e && "right" !== e && -1 === e.indexOf("%") || (i.horizontalAlign = e), void 0 === d || "top" !== d && "bottom" !== d && "center" !== d && -1 === d.indexOf("%") || (i.verticalAlign = d);
          }

          return _imgLiquid.isIE && a.settings.ieFadeInDisabled && (i.fadeInTime = 0), i;
        }

        function r() {
          var i,
              e,
              a,
              d,
              o,
              n,
              s,
              r,
              m = 0,
              h = 0,
              f = u.width(),
              v = u.height();
          void 0 === c.data("owidth") && c.data("owidth", c[0].width), void 0 === c.data("oheight") && c.data("oheight", c[0].height), g.fill === f / v >= c.data("owidth") / c.data("oheight") ? (i = "100%", e = "auto", a = Math.floor(f), d = Math.floor(f * (c.data("oheight") / c.data("owidth")))) : (i = "auto", e = "100%", a = Math.floor(v * (c.data("owidth") / c.data("oheight"))), d = Math.floor(v)), o = g.horizontalAlign.toLowerCase(), s = f - a, "left" === o && (h = 0), "center" === o && (h = .5 * s), "right" === o && (h = s), -1 !== o.indexOf("%") && (o = parseInt(o.replace("%", ""), 10), o > 0 && (h = .01 * s * o)), n = g.verticalAlign.toLowerCase(), r = v - d, "left" === n && (m = 0), "center" === n && (m = .5 * r), "bottom" === n && (m = r), -1 !== n.indexOf("%") && (n = parseInt(n.replace("%", ""), 10), n > 0 && (m = .01 * r * n)), g.hardPixels && (i = a, e = d), c.css({
            width: i,
            height: e,
            "margin-left": Math.floor(h),
            "margin-top": Math.floor(m)
          }), c.data("imgLiquid_oldProcessed") || (c.fadeTo(g.fadeInTime, 1), c.data("imgLiquid_oldProcessed", !0), g.removeBoxBackground && u.css("background-image", "none"), u.addClass("imgLiquid_nobgSize"), u.addClass("imgLiquid_ready")), g.onItemFinish && g.onItemFinish(t, u, c), l();
        }

        function l() {
          t === a.length - 1 && a.settings.onFinish && a.settings.onFinish();
        }

        var g = a.settings,
            u = i(this),
            c = i("img:first", u);
        return c.length ? (c.data("imgLiquid_settings") ? (u.removeClass("imgLiquid_error").removeClass("imgLiquid_ready"), g = i.extend({}, c.data("imgLiquid_settings"), a.options)) : g = i.extend({}, a.settings, s()), c.data("imgLiquid_settings", g), g.onItemStart && g.onItemStart(t, u, c), _imgLiquid.bgs_Available && g.useBackgroundSize ? e() : d(), void 0) : (n(), void 0);
      });
    }
  });
}(jQuery), !function () {
  var i = _imgLiquid.injectCss,
      t = document.getElementsByTagName("head")[0],
      e = document.createElement("style");
  e.type = "text/css", e.styleSheet ? e.styleSheet.cssText = i : e.appendChild(document.createTextNode(i)), t.appendChild(e);
}();
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "../node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ "./js/plugs/jquery.easing.1.3.js":
/*!***************************************!*\
  !*** ./js/plugs/jquery.easing.1.3.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(jQuery) {/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/
// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];
jQuery.extend(jQuery.easing, {
  def: 'easeOutQuad',
  swing: function swing(x, t, b, c, d) {
    //alert(jQuery.easing.default);
    return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
  },
  easeInQuad: function easeInQuad(x, t, b, c, d) {
    return c * (t /= d) * t + b;
  },
  easeOutQuad: function easeOutQuad(x, t, b, c, d) {
    return -c * (t /= d) * (t - 2) + b;
  },
  easeInOutQuad: function easeInOutQuad(x, t, b, c, d) {
    if ((t /= d / 2) < 1) return c / 2 * t * t + b;
    return -c / 2 * (--t * (t - 2) - 1) + b;
  },
  easeInCubic: function easeInCubic(x, t, b, c, d) {
    return c * (t /= d) * t * t + b;
  },
  easeOutCubic: function easeOutCubic(x, t, b, c, d) {
    return c * ((t = t / d - 1) * t * t + 1) + b;
  },
  easeInOutCubic: function easeInOutCubic(x, t, b, c, d) {
    if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
    return c / 2 * ((t -= 2) * t * t + 2) + b;
  },
  easeInQuart: function easeInQuart(x, t, b, c, d) {
    return c * (t /= d) * t * t * t + b;
  },
  easeOutQuart: function easeOutQuart(x, t, b, c, d) {
    return -c * ((t = t / d - 1) * t * t * t - 1) + b;
  },
  easeInOutQuart: function easeInOutQuart(x, t, b, c, d) {
    if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
    return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
  },
  easeInQuint: function easeInQuint(x, t, b, c, d) {
    return c * (t /= d) * t * t * t * t + b;
  },
  easeOutQuint: function easeOutQuint(x, t, b, c, d) {
    return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
  },
  easeInOutQuint: function easeInOutQuint(x, t, b, c, d) {
    if ((t /= d / 2) < 1) return c / 2 * t * t * t * t * t + b;
    return c / 2 * ((t -= 2) * t * t * t * t + 2) + b;
  },
  easeInSine: function easeInSine(x, t, b, c, d) {
    return -c * Math.cos(t / d * (Math.PI / 2)) + c + b;
  },
  easeOutSine: function easeOutSine(x, t, b, c, d) {
    return c * Math.sin(t / d * (Math.PI / 2)) + b;
  },
  easeInOutSine: function easeInOutSine(x, t, b, c, d) {
    return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;
  },
  easeInExpo: function easeInExpo(x, t, b, c, d) {
    return t == 0 ? b : c * Math.pow(2, 10 * (t / d - 1)) + b;
  },
  easeOutExpo: function easeOutExpo(x, t, b, c, d) {
    return t == d ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
  },
  easeInOutExpo: function easeInOutExpo(x, t, b, c, d) {
    if (t == 0) return b;
    if (t == d) return b + c;
    if ((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
    return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
  },
  easeInCirc: function easeInCirc(x, t, b, c, d) {
    return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b;
  },
  easeOutCirc: function easeOutCirc(x, t, b, c, d) {
    return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;
  },
  easeInOutCirc: function easeInOutCirc(x, t, b, c, d) {
    if ((t /= d / 2) < 1) return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;
    return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
  },
  easeInElastic: function easeInElastic(x, t, b, c, d) {
    var s = 1.70158;
    var p = 0;
    var a = c;
    if (t == 0) return b;
    if ((t /= d) == 1) return b + c;
    if (!p) p = d * .3;

    if (a < Math.abs(c)) {
      a = c;
      var s = p / 4;
    } else var s = p / (2 * Math.PI) * Math.asin(c / a);

    return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
  },
  easeOutElastic: function easeOutElastic(x, t, b, c, d) {
    var s = 1.70158;
    var p = 0;
    var a = c;
    if (t == 0) return b;
    if ((t /= d) == 1) return b + c;
    if (!p) p = d * .3;

    if (a < Math.abs(c)) {
      a = c;
      var s = p / 4;
    } else var s = p / (2 * Math.PI) * Math.asin(c / a);

    return a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b;
  },
  easeInOutElastic: function easeInOutElastic(x, t, b, c, d) {
    var s = 1.70158;
    var p = 0;
    var a = c;
    if (t == 0) return b;
    if ((t /= d / 2) == 2) return b + c;
    if (!p) p = d * (.3 * 1.5);

    if (a < Math.abs(c)) {
      a = c;
      var s = p / 4;
    } else var s = p / (2 * Math.PI) * Math.asin(c / a);

    if (t < 1) return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
    return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b;
  },
  easeInBack: function easeInBack(x, t, b, c, d, s) {
    if (s == undefined) s = 1.70158;
    return c * (t /= d) * t * ((s + 1) * t - s) + b;
  },
  easeOutBack: function easeOutBack(x, t, b, c, d, s) {
    if (s == undefined) s = 1.70158;
    return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;
  },
  easeInOutBack: function easeInOutBack(x, t, b, c, d, s) {
    if (s == undefined) s = 1.70158;
    if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= 1.525) + 1) * t - s)) + b;
    return c / 2 * ((t -= 2) * t * (((s *= 1.525) + 1) * t + s) + 2) + b;
  },
  easeInBounce: function easeInBounce(x, t, b, c, d) {
    return c - jQuery.easing.easeOutBounce(x, d - t, 0, c, d) + b;
  },
  easeOutBounce: function easeOutBounce(x, t, b, c, d) {
    if ((t /= d) < 1 / 2.75) {
      return c * (7.5625 * t * t) + b;
    } else if (t < 2 / 2.75) {
      return c * (7.5625 * (t -= 1.5 / 2.75) * t + .75) + b;
    } else if (t < 2.5 / 2.75) {
      return c * (7.5625 * (t -= 2.25 / 2.75) * t + .9375) + b;
    } else {
      return c * (7.5625 * (t -= 2.625 / 2.75) * t + .984375) + b;
    }
  },
  easeInOutBounce: function easeInOutBounce(x, t, b, c, d) {
    if (t < d / 2) return jQuery.easing.easeInBounce(x, t * 2, 0, c, d) * .5 + b;
    return jQuery.easing.easeOutBounce(x, t * 2 - d, 0, c, d) * .5 + c * .5 + b;
  }
});
/*
 *
 * TERMS OF USE - EASING EQUATIONS
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2001 Robert Penner
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 */
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "../node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ "./js/plugs/jquery.mCustomScrollbar.concat.min.js":
/*!********************************************************!*\
  !*** ./js/plugs/jquery.mCustomScrollbar.concat.min.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/* == jquery mousewheel plugin == Version: 3.1.13, License: MIT License (MIT) */
!function (a) {
   true ? !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(/*! jquery */ "../node_modules/jquery/dist/jquery.js")], __WEBPACK_AMD_DEFINE_FACTORY__ = (a),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : undefined;
}(function (a) {
  function b(b) {
    var g = b || window.event,
        h = i.call(arguments, 1),
        j = 0,
        l = 0,
        m = 0,
        n = 0,
        o = 0,
        p = 0;

    if (b = a.event.fix(g), b.type = "mousewheel", "detail" in g && (m = -1 * g.detail), "wheelDelta" in g && (m = g.wheelDelta), "wheelDeltaY" in g && (m = g.wheelDeltaY), "wheelDeltaX" in g && (l = -1 * g.wheelDeltaX), "axis" in g && g.axis === g.HORIZONTAL_AXIS && (l = -1 * m, m = 0), j = 0 === m ? l : m, "deltaY" in g && (m = -1 * g.deltaY, j = m), "deltaX" in g && (l = g.deltaX, 0 === m && (j = -1 * l)), 0 !== m || 0 !== l) {
      if (1 === g.deltaMode) {
        var q = a.data(this, "mousewheel-line-height");
        j *= q, m *= q, l *= q;
      } else if (2 === g.deltaMode) {
        var r = a.data(this, "mousewheel-page-height");
        j *= r, m *= r, l *= r;
      }

      if (n = Math.max(Math.abs(m), Math.abs(l)), (!f || f > n) && (f = n, d(g, n) && (f /= 40)), d(g, n) && (j /= 40, l /= 40, m /= 40), j = Math[j >= 1 ? "floor" : "ceil"](j / f), l = Math[l >= 1 ? "floor" : "ceil"](l / f), m = Math[m >= 1 ? "floor" : "ceil"](m / f), k.settings.normalizeOffset && this.getBoundingClientRect) {
        var s = this.getBoundingClientRect();
        o = b.clientX - s.left, p = b.clientY - s.top;
      }

      return b.deltaX = l, b.deltaY = m, b.deltaFactor = f, b.offsetX = o, b.offsetY = p, b.deltaMode = 0, h.unshift(b, j, l, m), e && clearTimeout(e), e = setTimeout(c, 200), (a.event.dispatch || a.event.handle).apply(this, h);
    }
  }

  function c() {
    f = null;
  }

  function d(a, b) {
    return k.settings.adjustOldDeltas && "mousewheel" === a.type && b % 120 === 0;
  }

  var e,
      f,
      g = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
      h = "onwheel" in document || document.documentMode >= 9 ? ["wheel"] : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
      i = Array.prototype.slice;
  if (a.event.fixHooks) for (var j = g.length; j;) {
    a.event.fixHooks[g[--j]] = a.event.mouseHooks;
  }
  var k = a.event.special.mousewheel = {
    version: "3.1.12",
    setup: function setup() {
      if (this.addEventListener) for (var c = h.length; c;) {
        this.addEventListener(h[--c], b, !1);
      } else this.onmousewheel = b;
      a.data(this, "mousewheel-line-height", k.getLineHeight(this)), a.data(this, "mousewheel-page-height", k.getPageHeight(this));
    },
    teardown: function teardown() {
      if (this.removeEventListener) for (var c = h.length; c;) {
        this.removeEventListener(h[--c], b, !1);
      } else this.onmousewheel = null;
      a.removeData(this, "mousewheel-line-height"), a.removeData(this, "mousewheel-page-height");
    },
    getLineHeight: function getLineHeight(b) {
      var c = a(b),
          d = c["offsetParent" in a.fn ? "offsetParent" : "parent"]();
      return d.length || (d = a("body")), parseInt(d.css("fontSize"), 10) || parseInt(c.css("fontSize"), 10) || 16;
    },
    getPageHeight: function getPageHeight(b) {
      return a(b).height();
    },
    settings: {
      adjustOldDeltas: !0,
      normalizeOffset: !0
    }
  };
  a.fn.extend({
    mousewheel: function mousewheel(a) {
      return a ? this.bind("mousewheel", a) : this.trigger("mousewheel");
    },
    unmousewheel: function unmousewheel(a) {
      return this.unbind("mousewheel", a);
    }
  });
});
!function (a) {
   true ? !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(/*! jquery */ "../node_modules/jquery/dist/jquery.js")], __WEBPACK_AMD_DEFINE_FACTORY__ = (a),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : undefined;
}(function (a) {
  function b(b) {
    var g = b || window.event,
        h = i.call(arguments, 1),
        j = 0,
        l = 0,
        m = 0,
        n = 0,
        o = 0,
        p = 0;

    if (b = a.event.fix(g), b.type = "mousewheel", "detail" in g && (m = -1 * g.detail), "wheelDelta" in g && (m = g.wheelDelta), "wheelDeltaY" in g && (m = g.wheelDeltaY), "wheelDeltaX" in g && (l = -1 * g.wheelDeltaX), "axis" in g && g.axis === g.HORIZONTAL_AXIS && (l = -1 * m, m = 0), j = 0 === m ? l : m, "deltaY" in g && (m = -1 * g.deltaY, j = m), "deltaX" in g && (l = g.deltaX, 0 === m && (j = -1 * l)), 0 !== m || 0 !== l) {
      if (1 === g.deltaMode) {
        var q = a.data(this, "mousewheel-line-height");
        j *= q, m *= q, l *= q;
      } else if (2 === g.deltaMode) {
        var r = a.data(this, "mousewheel-page-height");
        j *= r, m *= r, l *= r;
      }

      if (n = Math.max(Math.abs(m), Math.abs(l)), (!f || f > n) && (f = n, d(g, n) && (f /= 40)), d(g, n) && (j /= 40, l /= 40, m /= 40), j = Math[j >= 1 ? "floor" : "ceil"](j / f), l = Math[l >= 1 ? "floor" : "ceil"](l / f), m = Math[m >= 1 ? "floor" : "ceil"](m / f), k.settings.normalizeOffset && this.getBoundingClientRect) {
        var s = this.getBoundingClientRect();
        o = b.clientX - s.left, p = b.clientY - s.top;
      }

      return b.deltaX = l, b.deltaY = m, b.deltaFactor = f, b.offsetX = o, b.offsetY = p, b.deltaMode = 0, h.unshift(b, j, l, m), e && clearTimeout(e), e = setTimeout(c, 200), (a.event.dispatch || a.event.handle).apply(this, h);
    }
  }

  function c() {
    f = null;
  }

  function d(a, b) {
    return k.settings.adjustOldDeltas && "mousewheel" === a.type && b % 120 === 0;
  }

  var e,
      f,
      g = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
      h = "onwheel" in document || document.documentMode >= 9 ? ["wheel"] : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
      i = Array.prototype.slice;
  if (a.event.fixHooks) for (var j = g.length; j;) {
    a.event.fixHooks[g[--j]] = a.event.mouseHooks;
  }
  var k = a.event.special.mousewheel = {
    version: "3.1.12",
    setup: function setup() {
      if (this.addEventListener) for (var c = h.length; c;) {
        this.addEventListener(h[--c], b, !1);
      } else this.onmousewheel = b;
      a.data(this, "mousewheel-line-height", k.getLineHeight(this)), a.data(this, "mousewheel-page-height", k.getPageHeight(this));
    },
    teardown: function teardown() {
      if (this.removeEventListener) for (var c = h.length; c;) {
        this.removeEventListener(h[--c], b, !1);
      } else this.onmousewheel = null;
      a.removeData(this, "mousewheel-line-height"), a.removeData(this, "mousewheel-page-height");
    },
    getLineHeight: function getLineHeight(b) {
      var c = a(b),
          d = c["offsetParent" in a.fn ? "offsetParent" : "parent"]();
      return d.length || (d = a("body")), parseInt(d.css("fontSize"), 10) || parseInt(c.css("fontSize"), 10) || 16;
    },
    getPageHeight: function getPageHeight(b) {
      return a(b).height();
    },
    settings: {
      adjustOldDeltas: !0,
      normalizeOffset: !0
    }
  };
  a.fn.extend({
    mousewheel: function mousewheel(a) {
      return a ? this.bind("mousewheel", a) : this.trigger("mousewheel");
    },
    unmousewheel: function unmousewheel(a) {
      return this.unbind("mousewheel", a);
    }
  });
});
/* == malihu jquery custom scrollbar plugin == Version: 3.1.5, License: MIT License (MIT) */

!function (e) {
   true ? !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(/*! jquery */ "../node_modules/jquery/dist/jquery.js")], __WEBPACK_AMD_DEFINE_FACTORY__ = (e),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : undefined;
}(function (e) {
  !function (t) {
    var o =  true && __webpack_require__(/*! !webpack amd options */ "../node_modules/webpack/buildin/amd-options.js"),
        a =  true && module.exports,
        n = "https:" == document.location.protocol ? "https:" : "http:",
        i = "cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js";
    o || (a ? __webpack_require__(/*! jquery-mousewheel */ "../node_modules/jquery-mousewheel/jquery.mousewheel.js")(e) : e.event.special.mousewheel || e("head").append(decodeURI("%3Cscript src=" + n + "//" + i + "%3E%3C/script%3E"))), t();
  }(function () {
    var t,
        o = "mCustomScrollbar",
        a = "mCS",
        n = ".mCustomScrollbar",
        i = {
      setTop: 0,
      setLeft: 0,
      axis: "y",
      scrollbarPosition: "inside",
      scrollInertia: 950,
      autoDraggerLength: !0,
      alwaysShowScrollbar: 0,
      snapOffset: 0,
      mouseWheel: {
        enable: !0,
        scrollAmount: "auto",
        axis: "y",
        deltaFactor: "auto",
        disableOver: ["select", "option", "keygen", "datalist", "textarea"]
      },
      scrollButtons: {
        scrollType: "stepless",
        scrollAmount: "auto"
      },
      keyboard: {
        enable: !0,
        scrollType: "stepless",
        scrollAmount: "auto"
      },
      contentTouchScroll: 25,
      documentTouchScroll: !0,
      advanced: {
        autoScrollOnFocus: "input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",
        updateOnContentResize: !0,
        updateOnImageLoad: "auto",
        autoUpdateTimeout: 60
      },
      theme: "light",
      callbacks: {
        onTotalScrollOffset: 0,
        onTotalScrollBackOffset: 0,
        alwaysTriggerOffsets: !0
      }
    },
        r = 0,
        l = {},
        s = window.attachEvent && !window.addEventListener ? 1 : 0,
        c = !1,
        d = ["mCSB_dragger_onDrag", "mCSB_scrollTools_onDrag", "mCS_img_loaded", "mCS_disabled", "mCS_destroyed", "mCS_no_scrollbar", "mCS-autoHide", "mCS-dir-rtl", "mCS_no_scrollbar_y", "mCS_no_scrollbar_x", "mCS_y_hidden", "mCS_x_hidden", "mCSB_draggerContainer", "mCSB_buttonUp", "mCSB_buttonDown", "mCSB_buttonLeft", "mCSB_buttonRight"],
        u = {
      init: function init(t) {
        var t = e.extend(!0, {}, i, t),
            o = f.call(this);

        if (t.live) {
          var s = t.liveSelector || this.selector || n,
              c = e(s);
          if ("off" === t.live) return void m(s);
          l[s] = setTimeout(function () {
            c.mCustomScrollbar(t), "once" === t.live && c.length && m(s);
          }, 500);
        } else m(s);

        return t.setWidth = t.set_width ? t.set_width : t.setWidth, t.setHeight = t.set_height ? t.set_height : t.setHeight, t.axis = t.horizontalScroll ? "x" : p(t.axis), t.scrollInertia = t.scrollInertia > 0 && t.scrollInertia < 17 ? 17 : t.scrollInertia, "object" != _typeof(t.mouseWheel) && 1 == t.mouseWheel && (t.mouseWheel = {
          enable: !0,
          scrollAmount: "auto",
          axis: "y",
          preventDefault: !1,
          deltaFactor: "auto",
          normalizeDelta: !1,
          invert: !1
        }), t.mouseWheel.scrollAmount = t.mouseWheelPixels ? t.mouseWheelPixels : t.mouseWheel.scrollAmount, t.mouseWheel.normalizeDelta = t.advanced.normalizeMouseWheelDelta ? t.advanced.normalizeMouseWheelDelta : t.mouseWheel.normalizeDelta, t.scrollButtons.scrollType = g(t.scrollButtons.scrollType), h(t), e(o).each(function () {
          var o = e(this);

          if (!o.data(a)) {
            o.data(a, {
              idx: ++r,
              opt: t,
              scrollRatio: {
                y: null,
                x: null
              },
              overflowed: null,
              contentReset: {
                y: null,
                x: null
              },
              bindEvents: !1,
              tweenRunning: !1,
              sequential: {},
              langDir: o.css("direction"),
              cbOffsets: null,
              trigger: null,
              poll: {
                size: {
                  o: 0,
                  n: 0
                },
                img: {
                  o: 0,
                  n: 0
                },
                change: {
                  o: 0,
                  n: 0
                }
              }
            });
            var n = o.data(a),
                i = n.opt,
                l = o.data("mcs-axis"),
                s = o.data("mcs-scrollbar-position"),
                c = o.data("mcs-theme");
            l && (i.axis = l), s && (i.scrollbarPosition = s), c && (i.theme = c, h(i)), v.call(this), n && i.callbacks.onCreate && "function" == typeof i.callbacks.onCreate && i.callbacks.onCreate.call(this), e("#mCSB_" + n.idx + "_container img:not(." + d[2] + ")").addClass(d[2]), u.update.call(null, o);
          }
        });
      },
      update: function update(t, o) {
        var n = t || f.call(this);
        return e(n).each(function () {
          var t = e(this);

          if (t.data(a)) {
            var n = t.data(a),
                i = n.opt,
                r = e("#mCSB_" + n.idx + "_container"),
                l = e("#mCSB_" + n.idx),
                s = [e("#mCSB_" + n.idx + "_dragger_vertical"), e("#mCSB_" + n.idx + "_dragger_horizontal")];
            if (!r.length) return;
            n.tweenRunning && Q(t), o && n && i.callbacks.onBeforeUpdate && "function" == typeof i.callbacks.onBeforeUpdate && i.callbacks.onBeforeUpdate.call(this), t.hasClass(d[3]) && t.removeClass(d[3]), t.hasClass(d[4]) && t.removeClass(d[4]), l.css("max-height", "none"), l.height() !== t.height() && l.css("max-height", t.height()), _.call(this), "y" === i.axis || i.advanced.autoExpandHorizontalScroll || r.css("width", x(r)), n.overflowed = y.call(this), M.call(this), i.autoDraggerLength && S.call(this), b.call(this), T.call(this);
            var c = [Math.abs(r[0].offsetTop), Math.abs(r[0].offsetLeft)];
            "x" !== i.axis && (n.overflowed[0] ? s[0].height() > s[0].parent().height() ? B.call(this) : (G(t, c[0].toString(), {
              dir: "y",
              dur: 0,
              overwrite: "none"
            }), n.contentReset.y = null) : (B.call(this), "y" === i.axis ? k.call(this) : "yx" === i.axis && n.overflowed[1] && G(t, c[1].toString(), {
              dir: "x",
              dur: 0,
              overwrite: "none"
            }))), "y" !== i.axis && (n.overflowed[1] ? s[1].width() > s[1].parent().width() ? B.call(this) : (G(t, c[1].toString(), {
              dir: "x",
              dur: 0,
              overwrite: "none"
            }), n.contentReset.x = null) : (B.call(this), "x" === i.axis ? k.call(this) : "yx" === i.axis && n.overflowed[0] && G(t, c[0].toString(), {
              dir: "y",
              dur: 0,
              overwrite: "none"
            }))), o && n && (2 === o && i.callbacks.onImageLoad && "function" == typeof i.callbacks.onImageLoad ? i.callbacks.onImageLoad.call(this) : 3 === o && i.callbacks.onSelectorChange && "function" == typeof i.callbacks.onSelectorChange ? i.callbacks.onSelectorChange.call(this) : i.callbacks.onUpdate && "function" == typeof i.callbacks.onUpdate && i.callbacks.onUpdate.call(this)), N.call(this);
          }
        });
      },
      scrollTo: function scrollTo(t, o) {
        if ("undefined" != typeof t && null != t) {
          var n = f.call(this);
          return e(n).each(function () {
            var n = e(this);

            if (n.data(a)) {
              var i = n.data(a),
                  r = i.opt,
                  l = {
                trigger: "external",
                scrollInertia: r.scrollInertia,
                scrollEasing: "mcsEaseInOut",
                moveDragger: !1,
                timeout: 60,
                callbacks: !0,
                onStart: !0,
                onUpdate: !0,
                onComplete: !0
              },
                  s = e.extend(!0, {}, l, o),
                  c = Y.call(this, t),
                  d = s.scrollInertia > 0 && s.scrollInertia < 17 ? 17 : s.scrollInertia;
              c[0] = X.call(this, c[0], "y"), c[1] = X.call(this, c[1], "x"), s.moveDragger && (c[0] *= i.scrollRatio.y, c[1] *= i.scrollRatio.x), s.dur = ne() ? 0 : d, setTimeout(function () {
                null !== c[0] && "undefined" != typeof c[0] && "x" !== r.axis && i.overflowed[0] && (s.dir = "y", s.overwrite = "all", G(n, c[0].toString(), s)), null !== c[1] && "undefined" != typeof c[1] && "y" !== r.axis && i.overflowed[1] && (s.dir = "x", s.overwrite = "none", G(n, c[1].toString(), s));
              }, s.timeout);
            }
          });
        }
      },
      stop: function stop() {
        var t = f.call(this);
        return e(t).each(function () {
          var t = e(this);
          t.data(a) && Q(t);
        });
      },
      disable: function disable(t) {
        var o = f.call(this);
        return e(o).each(function () {
          var o = e(this);

          if (o.data(a)) {
            o.data(a);
            N.call(this, "remove"), k.call(this), t && B.call(this), M.call(this, !0), o.addClass(d[3]);
          }
        });
      },
      destroy: function destroy() {
        var t = f.call(this);
        return e(t).each(function () {
          var n = e(this);

          if (n.data(a)) {
            var i = n.data(a),
                r = i.opt,
                l = e("#mCSB_" + i.idx),
                s = e("#mCSB_" + i.idx + "_container"),
                c = e(".mCSB_" + i.idx + "_scrollbar");
            r.live && m(r.liveSelector || e(t).selector), N.call(this, "remove"), k.call(this), B.call(this), n.removeData(a), $(this, "mcs"), c.remove(), s.find("img." + d[2]).removeClass(d[2]), l.replaceWith(s.contents()), n.removeClass(o + " _" + a + "_" + i.idx + " " + d[6] + " " + d[7] + " " + d[5] + " " + d[3]).addClass(d[4]);
          }
        });
      }
    },
        f = function f() {
      return "object" != _typeof(e(this)) || e(this).length < 1 ? n : this;
    },
        h = function h(t) {
      var o = ["rounded", "rounded-dark", "rounded-dots", "rounded-dots-dark"],
          a = ["rounded-dots", "rounded-dots-dark", "3d", "3d-dark", "3d-thick", "3d-thick-dark", "inset", "inset-dark", "inset-2", "inset-2-dark", "inset-3", "inset-3-dark"],
          n = ["minimal", "minimal-dark"],
          i = ["minimal", "minimal-dark"],
          r = ["minimal", "minimal-dark"];
      t.autoDraggerLength = e.inArray(t.theme, o) > -1 ? !1 : t.autoDraggerLength, t.autoExpandScrollbar = e.inArray(t.theme, a) > -1 ? !1 : t.autoExpandScrollbar, t.scrollButtons.enable = e.inArray(t.theme, n) > -1 ? !1 : t.scrollButtons.enable, t.autoHideScrollbar = e.inArray(t.theme, i) > -1 ? !0 : t.autoHideScrollbar, t.scrollbarPosition = e.inArray(t.theme, r) > -1 ? "outside" : t.scrollbarPosition;
    },
        m = function m(e) {
      l[e] && (clearTimeout(l[e]), $(l, e));
    },
        p = function p(e) {
      return "yx" === e || "xy" === e || "auto" === e ? "yx" : "x" === e || "horizontal" === e ? "x" : "y";
    },
        g = function g(e) {
      return "stepped" === e || "pixels" === e || "step" === e || "click" === e ? "stepped" : "stepless";
    },
        v = function v() {
      var t = e(this),
          n = t.data(a),
          i = n.opt,
          r = i.autoExpandScrollbar ? " " + d[1] + "_expand" : "",
          l = ["<div id='mCSB_" + n.idx + "_scrollbar_vertical' class='mCSB_scrollTools mCSB_" + n.idx + "_scrollbar mCS-" + i.theme + " mCSB_scrollTools_vertical" + r + "'><div class='" + d[12] + "'><div id='mCSB_" + n.idx + "_dragger_vertical' class='mCSB_dragger' style='position:absolute;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>", "<div id='mCSB_" + n.idx + "_scrollbar_horizontal' class='mCSB_scrollTools mCSB_" + n.idx + "_scrollbar mCS-" + i.theme + " mCSB_scrollTools_horizontal" + r + "'><div class='" + d[12] + "'><div id='mCSB_" + n.idx + "_dragger_horizontal' class='mCSB_dragger' style='position:absolute;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>"],
          s = "yx" === i.axis ? "mCSB_vertical_horizontal" : "x" === i.axis ? "mCSB_horizontal" : "mCSB_vertical",
          c = "yx" === i.axis ? l[0] + l[1] : "x" === i.axis ? l[1] : l[0],
          u = "yx" === i.axis ? "<div id='mCSB_" + n.idx + "_container_wrapper' class='mCSB_container_wrapper' />" : "",
          f = i.autoHideScrollbar ? " " + d[6] : "",
          h = "x" !== i.axis && "rtl" === n.langDir ? " " + d[7] : "";
      i.setWidth && t.css("width", i.setWidth), i.setHeight && t.css("height", i.setHeight), i.setLeft = "y" !== i.axis && "rtl" === n.langDir ? "989999px" : i.setLeft, t.addClass(o + " _" + a + "_" + n.idx + f + h).wrapInner("<div id='mCSB_" + n.idx + "' class='mCustomScrollBox mCS-" + i.theme + " " + s + "'><div id='mCSB_" + n.idx + "_container' class='mCSB_container' style='position:relative; top:" + i.setTop + "; left:" + i.setLeft + ";' dir='" + n.langDir + "' /></div>");
      var m = e("#mCSB_" + n.idx),
          p = e("#mCSB_" + n.idx + "_container");
      "y" === i.axis || i.advanced.autoExpandHorizontalScroll || p.css("width", x(p)), "outside" === i.scrollbarPosition ? ("static" === t.css("position") && t.css("position", "relative"), t.css("overflow", "visible"), m.addClass("mCSB_outside").after(c)) : (m.addClass("mCSB_inside").append(c), p.wrap(u)), w.call(this);
      var g = [e("#mCSB_" + n.idx + "_dragger_vertical"), e("#mCSB_" + n.idx + "_dragger_horizontal")];
      g[0].css("min-height", g[0].height()), g[1].css("min-width", g[1].width());
    },
        x = function x(t) {
      var o = [t[0].scrollWidth, Math.max.apply(Math, t.children().map(function () {
        return e(this).outerWidth(!0);
      }).get())],
          a = t.parent().width();
      return o[0] > a ? o[0] : o[1] > a ? o[1] : "100%";
    },
        _ = function _() {
      var t = e(this),
          o = t.data(a),
          n = o.opt,
          i = e("#mCSB_" + o.idx + "_container");

      if (n.advanced.autoExpandHorizontalScroll && "y" !== n.axis) {
        i.css({
          width: "auto",
          "min-width": 0,
          "overflow-x": "scroll"
        });
        var r = Math.ceil(i[0].scrollWidth);
        3 === n.advanced.autoExpandHorizontalScroll || 2 !== n.advanced.autoExpandHorizontalScroll && r > i.parent().width() ? i.css({
          width: r,
          "min-width": "100%",
          "overflow-x": "inherit"
        }) : i.css({
          "overflow-x": "inherit",
          position: "absolute"
        }).wrap("<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />").css({
          width: Math.ceil(i[0].getBoundingClientRect().right + .4) - Math.floor(i[0].getBoundingClientRect().left),
          "min-width": "100%",
          position: "relative"
        }).unwrap();
      }
    },
        w = function w() {
      var t = e(this),
          o = t.data(a),
          n = o.opt,
          i = e(".mCSB_" + o.idx + "_scrollbar:first"),
          r = oe(n.scrollButtons.tabindex) ? "tabindex='" + n.scrollButtons.tabindex + "'" : "",
          l = ["<a href='#' class='" + d[13] + "' " + r + " />", "<a href='#' class='" + d[14] + "' " + r + " />", "<a href='#' class='" + d[15] + "' " + r + " />", "<a href='#' class='" + d[16] + "' " + r + " />"],
          s = ["x" === n.axis ? l[2] : l[0], "x" === n.axis ? l[3] : l[1], l[2], l[3]];
      n.scrollButtons.enable && i.prepend(s[0]).append(s[1]).next(".mCSB_scrollTools").prepend(s[2]).append(s[3]);
    },
        S = function S() {
      var t = e(this),
          o = t.data(a),
          n = e("#mCSB_" + o.idx),
          i = e("#mCSB_" + o.idx + "_container"),
          r = [e("#mCSB_" + o.idx + "_dragger_vertical"), e("#mCSB_" + o.idx + "_dragger_horizontal")],
          l = [n.height() / i.outerHeight(!1), n.width() / i.outerWidth(!1)],
          c = [parseInt(r[0].css("min-height")), Math.round(l[0] * r[0].parent().height()), parseInt(r[1].css("min-width")), Math.round(l[1] * r[1].parent().width())],
          d = s && c[1] < c[0] ? c[0] : c[1],
          u = s && c[3] < c[2] ? c[2] : c[3];
      r[0].css({
        height: d,
        "max-height": r[0].parent().height() - 10
      }).find(".mCSB_dragger_bar").css({
        "line-height": c[0] + "px"
      }), r[1].css({
        width: u,
        "max-width": r[1].parent().width() - 10
      });
    },
        b = function b() {
      var t = e(this),
          o = t.data(a),
          n = e("#mCSB_" + o.idx),
          i = e("#mCSB_" + o.idx + "_container"),
          r = [e("#mCSB_" + o.idx + "_dragger_vertical"), e("#mCSB_" + o.idx + "_dragger_horizontal")],
          l = [i.outerHeight(!1) - n.height(), i.outerWidth(!1) - n.width()],
          s = [l[0] / (r[0].parent().height() - r[0].height()), l[1] / (r[1].parent().width() - r[1].width())];
      o.scrollRatio = {
        y: s[0],
        x: s[1]
      };
    },
        C = function C(e, t, o) {
      var a = o ? d[0] + "_expanded" : "",
          n = e.closest(".mCSB_scrollTools");
      "active" === t ? (e.toggleClass(d[0] + " " + a), n.toggleClass(d[1]), e[0]._draggable = e[0]._draggable ? 0 : 1) : e[0]._draggable || ("hide" === t ? (e.removeClass(d[0]), n.removeClass(d[1])) : (e.addClass(d[0]), n.addClass(d[1])));
    },
        y = function y() {
      var t = e(this),
          o = t.data(a),
          n = e("#mCSB_" + o.idx),
          i = e("#mCSB_" + o.idx + "_container"),
          r = null == o.overflowed ? i.height() : i.outerHeight(!1),
          l = null == o.overflowed ? i.width() : i.outerWidth(!1),
          s = i[0].scrollHeight,
          c = i[0].scrollWidth;
      return s > r && (r = s), c > l && (l = c), [r > n.height(), l > n.width()];
    },
        B = function B() {
      var t = e(this),
          o = t.data(a),
          n = o.opt,
          i = e("#mCSB_" + o.idx),
          r = e("#mCSB_" + o.idx + "_container"),
          l = [e("#mCSB_" + o.idx + "_dragger_vertical"), e("#mCSB_" + o.idx + "_dragger_horizontal")];

      if (Q(t), ("x" !== n.axis && !o.overflowed[0] || "y" === n.axis && o.overflowed[0]) && (l[0].add(r).css("top", 0), G(t, "_resetY")), "y" !== n.axis && !o.overflowed[1] || "x" === n.axis && o.overflowed[1]) {
        var s = dx = 0;
        "rtl" === o.langDir && (s = i.width() - r.outerWidth(!1), dx = Math.abs(s / o.scrollRatio.x)), r.css("left", s), l[1].css("left", dx), G(t, "_resetX");
      }
    },
        T = function T() {
      function t() {
        r = setTimeout(function () {
          e.event.special.mousewheel ? (clearTimeout(r), W.call(o[0])) : t();
        }, 100);
      }

      var o = e(this),
          n = o.data(a),
          i = n.opt;

      if (!n.bindEvents) {
        if (I.call(this), i.contentTouchScroll && D.call(this), E.call(this), i.mouseWheel.enable) {
          var r;
          t();
        }

        P.call(this), U.call(this), i.advanced.autoScrollOnFocus && H.call(this), i.scrollButtons.enable && F.call(this), i.keyboard.enable && q.call(this), n.bindEvents = !0;
      }
    },
        k = function k() {
      var t = e(this),
          o = t.data(a),
          n = o.opt,
          i = a + "_" + o.idx,
          r = ".mCSB_" + o.idx + "_scrollbar",
          l = e("#mCSB_" + o.idx + ",#mCSB_" + o.idx + "_container,#mCSB_" + o.idx + "_container_wrapper," + r + " ." + d[12] + ",#mCSB_" + o.idx + "_dragger_vertical,#mCSB_" + o.idx + "_dragger_horizontal," + r + ">a"),
          s = e("#mCSB_" + o.idx + "_container");
      n.advanced.releaseDraggableSelectors && l.add(e(n.advanced.releaseDraggableSelectors)), n.advanced.extraDraggableSelectors && l.add(e(n.advanced.extraDraggableSelectors)), o.bindEvents && (e(document).add(e(!A() || top.document)).unbind("." + i), l.each(function () {
        e(this).unbind("." + i);
      }), clearTimeout(t[0]._focusTimeout), $(t[0], "_focusTimeout"), clearTimeout(o.sequential.step), $(o.sequential, "step"), clearTimeout(s[0].onCompleteTimeout), $(s[0], "onCompleteTimeout"), o.bindEvents = !1);
    },
        M = function M(t) {
      var o = e(this),
          n = o.data(a),
          i = n.opt,
          r = e("#mCSB_" + n.idx + "_container_wrapper"),
          l = r.length ? r : e("#mCSB_" + n.idx + "_container"),
          s = [e("#mCSB_" + n.idx + "_scrollbar_vertical"), e("#mCSB_" + n.idx + "_scrollbar_horizontal")],
          c = [s[0].find(".mCSB_dragger"), s[1].find(".mCSB_dragger")];
      "x" !== i.axis && (n.overflowed[0] && !t ? (s[0].add(c[0]).add(s[0].children("a")).css("display", "block"), l.removeClass(d[8] + " " + d[10])) : (i.alwaysShowScrollbar ? (2 !== i.alwaysShowScrollbar && c[0].css("display", "none"), l.removeClass(d[10])) : (s[0].css("display", "none"), l.addClass(d[10])), l.addClass(d[8]))), "y" !== i.axis && (n.overflowed[1] && !t ? (s[1].add(c[1]).add(s[1].children("a")).css("display", "block"), l.removeClass(d[9] + " " + d[11])) : (i.alwaysShowScrollbar ? (2 !== i.alwaysShowScrollbar && c[1].css("display", "none"), l.removeClass(d[11])) : (s[1].css("display", "none"), l.addClass(d[11])), l.addClass(d[9]))), n.overflowed[0] || n.overflowed[1] ? o.removeClass(d[5]) : o.addClass(d[5]);
    },
        O = function O(t) {
      var o = t.type,
          a = t.target.ownerDocument !== document && null !== frameElement ? [e(frameElement).offset().top, e(frameElement).offset().left] : null,
          n = A() && t.target.ownerDocument !== top.document && null !== frameElement ? [e(t.view.frameElement).offset().top, e(t.view.frameElement).offset().left] : [0, 0];

      switch (o) {
        case "pointerdown":
        case "MSPointerDown":
        case "pointermove":
        case "MSPointerMove":
        case "pointerup":
        case "MSPointerUp":
          return a ? [t.originalEvent.pageY - a[0] + n[0], t.originalEvent.pageX - a[1] + n[1], !1] : [t.originalEvent.pageY, t.originalEvent.pageX, !1];

        case "touchstart":
        case "touchmove":
        case "touchend":
          var i = t.originalEvent.touches[0] || t.originalEvent.changedTouches[0],
              r = t.originalEvent.touches.length || t.originalEvent.changedTouches.length;
          return t.target.ownerDocument !== document ? [i.screenY, i.screenX, r > 1] : [i.pageY, i.pageX, r > 1];

        default:
          return a ? [t.pageY - a[0] + n[0], t.pageX - a[1] + n[1], !1] : [t.pageY, t.pageX, !1];
      }
    },
        I = function I() {
      function t(e, t, a, n) {
        if (h[0].idleTimer = d.scrollInertia < 233 ? 250 : 0, o.attr("id") === f[1]) var i = "x",
            s = (o[0].offsetLeft - t + n) * l.scrollRatio.x;else var i = "y",
            s = (o[0].offsetTop - e + a) * l.scrollRatio.y;
        G(r, s.toString(), {
          dir: i,
          drag: !0
        });
      }

      var o,
          n,
          i,
          r = e(this),
          l = r.data(a),
          d = l.opt,
          u = a + "_" + l.idx,
          f = ["mCSB_" + l.idx + "_dragger_vertical", "mCSB_" + l.idx + "_dragger_horizontal"],
          h = e("#mCSB_" + l.idx + "_container"),
          m = e("#" + f[0] + ",#" + f[1]),
          p = d.advanced.releaseDraggableSelectors ? m.add(e(d.advanced.releaseDraggableSelectors)) : m,
          g = d.advanced.extraDraggableSelectors ? e(!A() || top.document).add(e(d.advanced.extraDraggableSelectors)) : e(!A() || top.document);
      m.bind("contextmenu." + u, function (e) {
        e.preventDefault();
      }).bind("mousedown." + u + " touchstart." + u + " pointerdown." + u + " MSPointerDown." + u, function (t) {
        if (t.stopImmediatePropagation(), t.preventDefault(), ee(t)) {
          c = !0, s && (document.onselectstart = function () {
            return !1;
          }), L.call(h, !1), Q(r), o = e(this);
          var a = o.offset(),
              l = O(t)[0] - a.top,
              u = O(t)[1] - a.left,
              f = o.height() + a.top,
              m = o.width() + a.left;
          f > l && l > 0 && m > u && u > 0 && (n = l, i = u), C(o, "active", d.autoExpandScrollbar);
        }
      }).bind("touchmove." + u, function (e) {
        e.stopImmediatePropagation(), e.preventDefault();
        var a = o.offset(),
            r = O(e)[0] - a.top,
            l = O(e)[1] - a.left;
        t(n, i, r, l);
      }), e(document).add(g).bind("mousemove." + u + " pointermove." + u + " MSPointerMove." + u, function (e) {
        if (o) {
          var a = o.offset(),
              r = O(e)[0] - a.top,
              l = O(e)[1] - a.left;
          if (n === r && i === l) return;
          t(n, i, r, l);
        }
      }).add(p).bind("mouseup." + u + " touchend." + u + " pointerup." + u + " MSPointerUp." + u, function () {
        o && (C(o, "active", d.autoExpandScrollbar), o = null), c = !1, s && (document.onselectstart = null), L.call(h, !0);
      });
    },
        D = function D() {
      function o(e) {
        if (!te(e) || c || O(e)[2]) return void (t = 0);
        t = 1, b = 0, C = 0, d = 1, y.removeClass("mCS_touch_action");
        var o = I.offset();
        u = O(e)[0] - o.top, f = O(e)[1] - o.left, z = [O(e)[0], O(e)[1]];
      }

      function n(e) {
        if (te(e) && !c && !O(e)[2] && (T.documentTouchScroll || e.preventDefault(), e.stopImmediatePropagation(), (!C || b) && d)) {
          g = K();
          var t = M.offset(),
              o = O(e)[0] - t.top,
              a = O(e)[1] - t.left,
              n = "mcsLinearOut";
          if (E.push(o), W.push(a), z[2] = Math.abs(O(e)[0] - z[0]), z[3] = Math.abs(O(e)[1] - z[1]), B.overflowed[0]) var i = D[0].parent().height() - D[0].height(),
              r = u - o > 0 && o - u > -(i * B.scrollRatio.y) && (2 * z[3] < z[2] || "yx" === T.axis);
          if (B.overflowed[1]) var l = D[1].parent().width() - D[1].width(),
              h = f - a > 0 && a - f > -(l * B.scrollRatio.x) && (2 * z[2] < z[3] || "yx" === T.axis);
          r || h ? (U || e.preventDefault(), b = 1) : (C = 1, y.addClass("mCS_touch_action")), U && e.preventDefault(), w = "yx" === T.axis ? [u - o, f - a] : "x" === T.axis ? [null, f - a] : [u - o, null], I[0].idleTimer = 250, B.overflowed[0] && s(w[0], R, n, "y", "all", !0), B.overflowed[1] && s(w[1], R, n, "x", L, !0);
        }
      }

      function i(e) {
        if (!te(e) || c || O(e)[2]) return void (t = 0);
        t = 1, e.stopImmediatePropagation(), Q(y), p = K();
        var o = M.offset();
        h = O(e)[0] - o.top, m = O(e)[1] - o.left, E = [], W = [];
      }

      function r(e) {
        if (te(e) && !c && !O(e)[2]) {
          d = 0, e.stopImmediatePropagation(), b = 0, C = 0, v = K();
          var t = M.offset(),
              o = O(e)[0] - t.top,
              a = O(e)[1] - t.left;

          if (!(v - g > 30)) {
            _ = 1e3 / (v - p);
            var n = "mcsEaseOut",
                i = 2.5 > _,
                r = i ? [E[E.length - 2], W[W.length - 2]] : [0, 0];
            x = i ? [o - r[0], a - r[1]] : [o - h, a - m];
            var u = [Math.abs(x[0]), Math.abs(x[1])];
            _ = i ? [Math.abs(x[0] / 4), Math.abs(x[1] / 4)] : [_, _];
            var f = [Math.abs(I[0].offsetTop) - x[0] * l(u[0] / _[0], _[0]), Math.abs(I[0].offsetLeft) - x[1] * l(u[1] / _[1], _[1])];
            w = "yx" === T.axis ? [f[0], f[1]] : "x" === T.axis ? [null, f[1]] : [f[0], null], S = [4 * u[0] + T.scrollInertia, 4 * u[1] + T.scrollInertia];
            var y = parseInt(T.contentTouchScroll) || 0;
            w[0] = u[0] > y ? w[0] : 0, w[1] = u[1] > y ? w[1] : 0, B.overflowed[0] && s(w[0], S[0], n, "y", L, !1), B.overflowed[1] && s(w[1], S[1], n, "x", L, !1);
          }
        }
      }

      function l(e, t) {
        var o = [1.5 * t, 2 * t, t / 1.5, t / 2];
        return e > 90 ? t > 4 ? o[0] : o[3] : e > 60 ? t > 3 ? o[3] : o[2] : e > 30 ? t > 8 ? o[1] : t > 6 ? o[0] : t > 4 ? t : o[2] : t > 8 ? t : o[3];
      }

      function s(e, t, o, a, n, i) {
        e && G(y, e.toString(), {
          dur: t,
          scrollEasing: o,
          dir: a,
          overwrite: n,
          drag: i
        });
      }

      var d,
          u,
          f,
          h,
          m,
          p,
          g,
          v,
          x,
          _,
          w,
          S,
          b,
          C,
          y = e(this),
          B = y.data(a),
          T = B.opt,
          k = a + "_" + B.idx,
          M = e("#mCSB_" + B.idx),
          I = e("#mCSB_" + B.idx + "_container"),
          D = [e("#mCSB_" + B.idx + "_dragger_vertical"), e("#mCSB_" + B.idx + "_dragger_horizontal")],
          E = [],
          W = [],
          R = 0,
          L = "yx" === T.axis ? "none" : "all",
          z = [],
          P = I.find("iframe"),
          H = ["touchstart." + k + " pointerdown." + k + " MSPointerDown." + k, "touchmove." + k + " pointermove." + k + " MSPointerMove." + k, "touchend." + k + " pointerup." + k + " MSPointerUp." + k],
          U = void 0 !== document.body.style.touchAction && "" !== document.body.style.touchAction;

      I.bind(H[0], function (e) {
        o(e);
      }).bind(H[1], function (e) {
        n(e);
      }), M.bind(H[0], function (e) {
        i(e);
      }).bind(H[2], function (e) {
        r(e);
      }), P.length && P.each(function () {
        e(this).bind("load", function () {
          A(this) && e(this.contentDocument || this.contentWindow.document).bind(H[0], function (e) {
            o(e), i(e);
          }).bind(H[1], function (e) {
            n(e);
          }).bind(H[2], function (e) {
            r(e);
          });
        });
      });
    },
        E = function E() {
      function o() {
        return window.getSelection ? window.getSelection().toString() : document.selection && "Control" != document.selection.type ? document.selection.createRange().text : 0;
      }

      function n(e, t, o) {
        d.type = o && i ? "stepped" : "stepless", d.scrollAmount = 10, j(r, e, t, "mcsLinearOut", o ? 60 : null);
      }

      var i,
          r = e(this),
          l = r.data(a),
          s = l.opt,
          d = l.sequential,
          u = a + "_" + l.idx,
          f = e("#mCSB_" + l.idx + "_container"),
          h = f.parent();
      f.bind("mousedown." + u, function () {
        t || i || (i = 1, c = !0);
      }).add(document).bind("mousemove." + u, function (e) {
        if (!t && i && o()) {
          var a = f.offset(),
              r = O(e)[0] - a.top + f[0].offsetTop,
              c = O(e)[1] - a.left + f[0].offsetLeft;
          r > 0 && r < h.height() && c > 0 && c < h.width() ? d.step && n("off", null, "stepped") : ("x" !== s.axis && l.overflowed[0] && (0 > r ? n("on", 38) : r > h.height() && n("on", 40)), "y" !== s.axis && l.overflowed[1] && (0 > c ? n("on", 37) : c > h.width() && n("on", 39)));
        }
      }).bind("mouseup." + u + " dragend." + u, function () {
        t || (i && (i = 0, n("off", null)), c = !1);
      });
    },
        W = function W() {
      function t(t, a) {
        if (Q(o), !z(o, t.target)) {
          var r = "auto" !== i.mouseWheel.deltaFactor ? parseInt(i.mouseWheel.deltaFactor) : s && t.deltaFactor < 100 ? 100 : t.deltaFactor || 100,
              d = i.scrollInertia;
          if ("x" === i.axis || "x" === i.mouseWheel.axis) var u = "x",
              f = [Math.round(r * n.scrollRatio.x), parseInt(i.mouseWheel.scrollAmount)],
              h = "auto" !== i.mouseWheel.scrollAmount ? f[1] : f[0] >= l.width() ? .9 * l.width() : f[0],
              m = Math.abs(e("#mCSB_" + n.idx + "_container")[0].offsetLeft),
              p = c[1][0].offsetLeft,
              g = c[1].parent().width() - c[1].width(),
              v = "y" === i.mouseWheel.axis ? t.deltaY || a : t.deltaX;else var u = "y",
              f = [Math.round(r * n.scrollRatio.y), parseInt(i.mouseWheel.scrollAmount)],
              h = "auto" !== i.mouseWheel.scrollAmount ? f[1] : f[0] >= l.height() ? .9 * l.height() : f[0],
              m = Math.abs(e("#mCSB_" + n.idx + "_container")[0].offsetTop),
              p = c[0][0].offsetTop,
              g = c[0].parent().height() - c[0].height(),
              v = t.deltaY || a;
          "y" === u && !n.overflowed[0] || "x" === u && !n.overflowed[1] || ((i.mouseWheel.invert || t.webkitDirectionInvertedFromDevice) && (v = -v), i.mouseWheel.normalizeDelta && (v = 0 > v ? -1 : 1), (v > 0 && 0 !== p || 0 > v && p !== g || i.mouseWheel.preventDefault) && (t.stopImmediatePropagation(), t.preventDefault()), t.deltaFactor < 5 && !i.mouseWheel.normalizeDelta && (h = t.deltaFactor, d = 17), G(o, (m - v * h).toString(), {
            dir: u,
            dur: d
          }));
        }
      }

      if (e(this).data(a)) {
        var o = e(this),
            n = o.data(a),
            i = n.opt,
            r = a + "_" + n.idx,
            l = e("#mCSB_" + n.idx),
            c = [e("#mCSB_" + n.idx + "_dragger_vertical"), e("#mCSB_" + n.idx + "_dragger_horizontal")],
            d = e("#mCSB_" + n.idx + "_container").find("iframe");
        d.length && d.each(function () {
          e(this).bind("load", function () {
            A(this) && e(this.contentDocument || this.contentWindow.document).bind("mousewheel." + r, function (e, o) {
              t(e, o);
            });
          });
        }), l.bind("mousewheel." + r, function (e, o) {
          t(e, o);
        });
      }
    },
        R = new Object(),
        A = function A(t) {
      var o = !1,
          a = !1,
          n = null;
      if (void 0 === t ? a = "#empty" : void 0 !== e(t).attr("id") && (a = e(t).attr("id")), a !== !1 && void 0 !== R[a]) return R[a];

      if (t) {
        try {
          var i = t.contentDocument || t.contentWindow.document;
          n = i.body.innerHTML;
        } catch (r) {}

        o = null !== n;
      } else {
        try {
          var i = top.document;
          n = i.body.innerHTML;
        } catch (r) {}

        o = null !== n;
      }

      return a !== !1 && (R[a] = o), o;
    },
        L = function L(e) {
      var t = this.find("iframe");

      if (t.length) {
        var o = e ? "auto" : "none";
        t.css("pointer-events", o);
      }
    },
        z = function z(t, o) {
      var n = o.nodeName.toLowerCase(),
          i = t.data(a).opt.mouseWheel.disableOver,
          r = ["select", "textarea"];
      return e.inArray(n, i) > -1 && !(e.inArray(n, r) > -1 && !e(o).is(":focus"));
    },
        P = function P() {
      var t,
          o = e(this),
          n = o.data(a),
          i = a + "_" + n.idx,
          r = e("#mCSB_" + n.idx + "_container"),
          l = r.parent(),
          s = e(".mCSB_" + n.idx + "_scrollbar ." + d[12]);
      s.bind("mousedown." + i + " touchstart." + i + " pointerdown." + i + " MSPointerDown." + i, function (o) {
        c = !0, e(o.target).hasClass("mCSB_dragger") || (t = 1);
      }).bind("touchend." + i + " pointerup." + i + " MSPointerUp." + i, function () {
        c = !1;
      }).bind("click." + i, function (a) {
        if (t && (t = 0, e(a.target).hasClass(d[12]) || e(a.target).hasClass("mCSB_draggerRail"))) {
          Q(o);
          var i = e(this),
              s = i.find(".mCSB_dragger");

          if (i.parent(".mCSB_scrollTools_horizontal").length > 0) {
            if (!n.overflowed[1]) return;
            var c = "x",
                u = a.pageX > s.offset().left ? -1 : 1,
                f = Math.abs(r[0].offsetLeft) - u * (.9 * l.width());
          } else {
            if (!n.overflowed[0]) return;
            var c = "y",
                u = a.pageY > s.offset().top ? -1 : 1,
                f = Math.abs(r[0].offsetTop) - u * (.9 * l.height());
          }

          G(o, f.toString(), {
            dir: c,
            scrollEasing: "mcsEaseInOut"
          });
        }
      });
    },
        H = function H() {
      var t = e(this),
          o = t.data(a),
          n = o.opt,
          i = a + "_" + o.idx,
          r = e("#mCSB_" + o.idx + "_container"),
          l = r.parent();
      r.bind("focusin." + i, function () {
        var o = e(document.activeElement),
            a = r.find(".mCustomScrollBox").length,
            i = 0;
        o.is(n.advanced.autoScrollOnFocus) && (Q(t), clearTimeout(t[0]._focusTimeout), t[0]._focusTimer = a ? (i + 17) * a : 0, t[0]._focusTimeout = setTimeout(function () {
          var e = [ae(o)[0], ae(o)[1]],
              a = [r[0].offsetTop, r[0].offsetLeft],
              s = [a[0] + e[0] >= 0 && a[0] + e[0] < l.height() - o.outerHeight(!1), a[1] + e[1] >= 0 && a[0] + e[1] < l.width() - o.outerWidth(!1)],
              c = "yx" !== n.axis || s[0] || s[1] ? "all" : "none";
          "x" === n.axis || s[0] || G(t, e[0].toString(), {
            dir: "y",
            scrollEasing: "mcsEaseInOut",
            overwrite: c,
            dur: i
          }), "y" === n.axis || s[1] || G(t, e[1].toString(), {
            dir: "x",
            scrollEasing: "mcsEaseInOut",
            overwrite: c,
            dur: i
          });
        }, t[0]._focusTimer));
      });
    },
        U = function U() {
      var t = e(this),
          o = t.data(a),
          n = a + "_" + o.idx,
          i = e("#mCSB_" + o.idx + "_container").parent();
      i.bind("scroll." + n, function () {
        0 === i.scrollTop() && 0 === i.scrollLeft() || e(".mCSB_" + o.idx + "_scrollbar").css("visibility", "hidden");
      });
    },
        F = function F() {
      var t = e(this),
          o = t.data(a),
          n = o.opt,
          i = o.sequential,
          r = a + "_" + o.idx,
          l = ".mCSB_" + o.idx + "_scrollbar",
          s = e(l + ">a");
      s.bind("contextmenu." + r, function (e) {
        e.preventDefault();
      }).bind("mousedown." + r + " touchstart." + r + " pointerdown." + r + " MSPointerDown." + r + " mouseup." + r + " touchend." + r + " pointerup." + r + " MSPointerUp." + r + " mouseout." + r + " pointerout." + r + " MSPointerOut." + r + " click." + r, function (a) {
        function r(e, o) {
          i.scrollAmount = n.scrollButtons.scrollAmount, j(t, e, o);
        }

        if (a.preventDefault(), ee(a)) {
          var l = e(this).attr("class");

          switch (i.type = n.scrollButtons.scrollType, a.type) {
            case "mousedown":
            case "touchstart":
            case "pointerdown":
            case "MSPointerDown":
              if ("stepped" === i.type) return;
              c = !0, o.tweenRunning = !1, r("on", l);
              break;

            case "mouseup":
            case "touchend":
            case "pointerup":
            case "MSPointerUp":
            case "mouseout":
            case "pointerout":
            case "MSPointerOut":
              if ("stepped" === i.type) return;
              c = !1, i.dir && r("off", l);
              break;

            case "click":
              if ("stepped" !== i.type || o.tweenRunning) return;
              r("on", l);
          }
        }
      });
    },
        q = function q() {
      function t(t) {
        function a(e, t) {
          r.type = i.keyboard.scrollType, r.scrollAmount = i.keyboard.scrollAmount, "stepped" === r.type && n.tweenRunning || j(o, e, t);
        }

        switch (t.type) {
          case "blur":
            n.tweenRunning && r.dir && a("off", null);
            break;

          case "keydown":
          case "keyup":
            var l = t.keyCode ? t.keyCode : t.which,
                s = "on";

            if ("x" !== i.axis && (38 === l || 40 === l) || "y" !== i.axis && (37 === l || 39 === l)) {
              if ((38 === l || 40 === l) && !n.overflowed[0] || (37 === l || 39 === l) && !n.overflowed[1]) return;
              "keyup" === t.type && (s = "off"), e(document.activeElement).is(u) || (t.preventDefault(), t.stopImmediatePropagation(), a(s, l));
            } else if (33 === l || 34 === l) {
              if ((n.overflowed[0] || n.overflowed[1]) && (t.preventDefault(), t.stopImmediatePropagation()), "keyup" === t.type) {
                Q(o);
                var f = 34 === l ? -1 : 1;
                if ("x" === i.axis || "yx" === i.axis && n.overflowed[1] && !n.overflowed[0]) var h = "x",
                    m = Math.abs(c[0].offsetLeft) - f * (.9 * d.width());else var h = "y",
                    m = Math.abs(c[0].offsetTop) - f * (.9 * d.height());
                G(o, m.toString(), {
                  dir: h,
                  scrollEasing: "mcsEaseInOut"
                });
              }
            } else if ((35 === l || 36 === l) && !e(document.activeElement).is(u) && ((n.overflowed[0] || n.overflowed[1]) && (t.preventDefault(), t.stopImmediatePropagation()), "keyup" === t.type)) {
              if ("x" === i.axis || "yx" === i.axis && n.overflowed[1] && !n.overflowed[0]) var h = "x",
                  m = 35 === l ? Math.abs(d.width() - c.outerWidth(!1)) : 0;else var h = "y",
                  m = 35 === l ? Math.abs(d.height() - c.outerHeight(!1)) : 0;
              G(o, m.toString(), {
                dir: h,
                scrollEasing: "mcsEaseInOut"
              });
            }

        }
      }

      var o = e(this),
          n = o.data(a),
          i = n.opt,
          r = n.sequential,
          l = a + "_" + n.idx,
          s = e("#mCSB_" + n.idx),
          c = e("#mCSB_" + n.idx + "_container"),
          d = c.parent(),
          u = "input,textarea,select,datalist,keygen,[contenteditable='true']",
          f = c.find("iframe"),
          h = ["blur." + l + " keydown." + l + " keyup." + l];
      f.length && f.each(function () {
        e(this).bind("load", function () {
          A(this) && e(this.contentDocument || this.contentWindow.document).bind(h[0], function (e) {
            t(e);
          });
        });
      }), s.attr("tabindex", "0").bind(h[0], function (e) {
        t(e);
      });
    },
        j = function j(t, o, n, i, r) {
      function l(e) {
        u.snapAmount && (f.scrollAmount = u.snapAmount instanceof Array ? "x" === f.dir[0] ? u.snapAmount[1] : u.snapAmount[0] : u.snapAmount);

        var o = "stepped" !== f.type,
            a = r ? r : e ? o ? p / 1.5 : g : 1e3 / 60,
            n = e ? o ? 7.5 : 40 : 2.5,
            s = [Math.abs(h[0].offsetTop), Math.abs(h[0].offsetLeft)],
            d = [c.scrollRatio.y > 10 ? 10 : c.scrollRatio.y, c.scrollRatio.x > 10 ? 10 : c.scrollRatio.x],
            m = "x" === f.dir[0] ? s[1] + f.dir[1] * (d[1] * n) : s[0] + f.dir[1] * (d[0] * n),
            v = "x" === f.dir[0] ? s[1] + f.dir[1] * parseInt(f.scrollAmount) : s[0] + f.dir[1] * parseInt(f.scrollAmount),
            x = "auto" !== f.scrollAmount ? v : m,
            _ = i ? i : e ? o ? "mcsLinearOut" : "mcsEaseInOut" : "mcsLinear",
            w = !!e;

        return e && 17 > a && (x = "x" === f.dir[0] ? s[1] : s[0]), G(t, x.toString(), {
          dir: f.dir[0],
          scrollEasing: _,
          dur: a,
          onComplete: w
        }), e ? void (f.dir = !1) : (clearTimeout(f.step), void (f.step = setTimeout(function () {
          l();
        }, a)));
      }

      function s() {
        clearTimeout(f.step), $(f, "step"), Q(t);
      }

      var c = t.data(a),
          u = c.opt,
          f = c.sequential,
          h = e("#mCSB_" + c.idx + "_container"),
          m = "stepped" === f.type,
          p = u.scrollInertia < 26 ? 26 : u.scrollInertia,
          g = u.scrollInertia < 1 ? 17 : u.scrollInertia;

      switch (o) {
        case "on":
          if (f.dir = [n === d[16] || n === d[15] || 39 === n || 37 === n ? "x" : "y", n === d[13] || n === d[15] || 38 === n || 37 === n ? -1 : 1], Q(t), oe(n) && "stepped" === f.type) return;
          l(m);
          break;

        case "off":
          s(), (m || c.tweenRunning && f.dir) && l(!0);
      }
    },
        Y = function Y(t) {
      var o = e(this).data(a).opt,
          n = [];
      return "function" == typeof t && (t = t()), t instanceof Array ? n = t.length > 1 ? [t[0], t[1]] : "x" === o.axis ? [null, t[0]] : [t[0], null] : (n[0] = t.y ? t.y : t.x || "x" === o.axis ? null : t, n[1] = t.x ? t.x : t.y || "y" === o.axis ? null : t), "function" == typeof n[0] && (n[0] = n[0]()), "function" == typeof n[1] && (n[1] = n[1]()), n;
    },
        X = function X(t, o) {
      if (null != t && "undefined" != typeof t) {
        var n = e(this),
            i = n.data(a),
            r = i.opt,
            l = e("#mCSB_" + i.idx + "_container"),
            s = l.parent(),
            c = _typeof(t);

        o || (o = "x" === r.axis ? "x" : "y");
        var d = "x" === o ? l.outerWidth(!1) - s.width() : l.outerHeight(!1) - s.height(),
            f = "x" === o ? l[0].offsetLeft : l[0].offsetTop,
            h = "x" === o ? "left" : "top";

        switch (c) {
          case "function":
            return t();

          case "object":
            var m = t.jquery ? t : e(t);
            if (!m.length) return;
            return "x" === o ? ae(m)[1] : ae(m)[0];

          case "string":
          case "number":
            if (oe(t)) return Math.abs(t);
            if (-1 !== t.indexOf("%")) return Math.abs(d * parseInt(t) / 100);
            if (-1 !== t.indexOf("-=")) return Math.abs(f - parseInt(t.split("-=")[1]));

            if (-1 !== t.indexOf("+=")) {
              var p = f + parseInt(t.split("+=")[1]);
              return p >= 0 ? 0 : Math.abs(p);
            }

            if (-1 !== t.indexOf("px") && oe(t.split("px")[0])) return Math.abs(t.split("px")[0]);
            if ("top" === t || "left" === t) return 0;
            if ("bottom" === t) return Math.abs(s.height() - l.outerHeight(!1));
            if ("right" === t) return Math.abs(s.width() - l.outerWidth(!1));

            if ("first" === t || "last" === t) {
              var m = l.find(":" + t);
              return "x" === o ? ae(m)[1] : ae(m)[0];
            }

            return e(t).length ? "x" === o ? ae(e(t))[1] : ae(e(t))[0] : (l.css(h, t), void u.update.call(null, n[0]));
        }
      }
    },
        N = function N(t) {
      function o() {
        return clearTimeout(f[0].autoUpdate), 0 === l.parents("html").length ? void (l = null) : void (f[0].autoUpdate = setTimeout(function () {
          return c.advanced.updateOnSelectorChange && (s.poll.change.n = i(), s.poll.change.n !== s.poll.change.o) ? (s.poll.change.o = s.poll.change.n, void r(3)) : c.advanced.updateOnContentResize && (s.poll.size.n = l[0].scrollHeight + l[0].scrollWidth + f[0].offsetHeight + l[0].offsetHeight + l[0].offsetWidth, s.poll.size.n !== s.poll.size.o) ? (s.poll.size.o = s.poll.size.n, void r(1)) : !c.advanced.updateOnImageLoad || "auto" === c.advanced.updateOnImageLoad && "y" === c.axis || (s.poll.img.n = f.find("img").length, s.poll.img.n === s.poll.img.o) ? void ((c.advanced.updateOnSelectorChange || c.advanced.updateOnContentResize || c.advanced.updateOnImageLoad) && o()) : (s.poll.img.o = s.poll.img.n, void f.find("img").each(function () {
            n(this);
          }));
        }, c.advanced.autoUpdateTimeout));
      }

      function n(t) {
        function o(e, t) {
          return function () {
            return t.apply(e, arguments);
          };
        }

        function a() {
          this.onload = null, e(t).addClass(d[2]), r(2);
        }

        if (e(t).hasClass(d[2])) return void r();
        var n = new Image();
        n.onload = o(n, a), n.src = t.src;
      }

      function i() {
        c.advanced.updateOnSelectorChange === !0 && (c.advanced.updateOnSelectorChange = "*");
        var e = 0,
            t = f.find(c.advanced.updateOnSelectorChange);
        return c.advanced.updateOnSelectorChange && t.length > 0 && t.each(function () {
          e += this.offsetHeight + this.offsetWidth;
        }), e;
      }

      function r(e) {
        clearTimeout(f[0].autoUpdate), u.update.call(null, l[0], e);
      }

      var l = e(this),
          s = l.data(a),
          c = s.opt,
          f = e("#mCSB_" + s.idx + "_container");
      return t ? (clearTimeout(f[0].autoUpdate), void $(f[0], "autoUpdate")) : void o();
    },
        V = function V(e, t, o) {
      return Math.round(e / t) * t - o;
    },
        Q = function Q(t) {
      var o = t.data(a),
          n = e("#mCSB_" + o.idx + "_container,#mCSB_" + o.idx + "_container_wrapper,#mCSB_" + o.idx + "_dragger_vertical,#mCSB_" + o.idx + "_dragger_horizontal");
      n.each(function () {
        Z.call(this);
      });
    },
        G = function G(t, o, n) {
      function i(e) {
        return s && c.callbacks[e] && "function" == typeof c.callbacks[e];
      }

      function r() {
        return [c.callbacks.alwaysTriggerOffsets || w >= S[0] + y, c.callbacks.alwaysTriggerOffsets || -B >= w];
      }

      function l() {
        var e = [h[0].offsetTop, h[0].offsetLeft],
            o = [x[0].offsetTop, x[0].offsetLeft],
            a = [h.outerHeight(!1), h.outerWidth(!1)],
            i = [f.height(), f.width()];
        t[0].mcs = {
          content: h,
          top: e[0],
          left: e[1],
          draggerTop: o[0],
          draggerLeft: o[1],
          topPct: Math.round(100 * Math.abs(e[0]) / (Math.abs(a[0]) - i[0])),
          leftPct: Math.round(100 * Math.abs(e[1]) / (Math.abs(a[1]) - i[1])),
          direction: n.dir
        };
      }

      var s = t.data(a),
          c = s.opt,
          d = {
        trigger: "internal",
        dir: "y",
        scrollEasing: "mcsEaseOut",
        drag: !1,
        dur: c.scrollInertia,
        overwrite: "all",
        callbacks: !0,
        onStart: !0,
        onUpdate: !0,
        onComplete: !0
      },
          n = e.extend(d, n),
          u = [n.dur, n.drag ? 0 : n.dur],
          f = e("#mCSB_" + s.idx),
          h = e("#mCSB_" + s.idx + "_container"),
          m = h.parent(),
          p = c.callbacks.onTotalScrollOffset ? Y.call(t, c.callbacks.onTotalScrollOffset) : [0, 0],
          g = c.callbacks.onTotalScrollBackOffset ? Y.call(t, c.callbacks.onTotalScrollBackOffset) : [0, 0];

      if (s.trigger = n.trigger, 0 === m.scrollTop() && 0 === m.scrollLeft() || (e(".mCSB_" + s.idx + "_scrollbar").css("visibility", "visible"), m.scrollTop(0).scrollLeft(0)), "_resetY" !== o || s.contentReset.y || (i("onOverflowYNone") && c.callbacks.onOverflowYNone.call(t[0]), s.contentReset.y = 1), "_resetX" !== o || s.contentReset.x || (i("onOverflowXNone") && c.callbacks.onOverflowXNone.call(t[0]), s.contentReset.x = 1), "_resetY" !== o && "_resetX" !== o) {
        if (!s.contentReset.y && t[0].mcs || !s.overflowed[0] || (i("onOverflowY") && c.callbacks.onOverflowY.call(t[0]), s.contentReset.x = null), !s.contentReset.x && t[0].mcs || !s.overflowed[1] || (i("onOverflowX") && c.callbacks.onOverflowX.call(t[0]), s.contentReset.x = null), c.snapAmount) {
          var v = c.snapAmount instanceof Array ? "x" === n.dir ? c.snapAmount[1] : c.snapAmount[0] : c.snapAmount;
          o = V(o, v, c.snapOffset);
        }

        switch (n.dir) {
          case "x":
            var x = e("#mCSB_" + s.idx + "_dragger_horizontal"),
                _ = "left",
                w = h[0].offsetLeft,
                S = [f.width() - h.outerWidth(!1), x.parent().width() - x.width()],
                b = [o, 0 === o ? 0 : o / s.scrollRatio.x],
                y = p[1],
                B = g[1],
                T = y > 0 ? y / s.scrollRatio.x : 0,
                k = B > 0 ? B / s.scrollRatio.x : 0;
            break;

          case "y":
            var x = e("#mCSB_" + s.idx + "_dragger_vertical"),
                _ = "top",
                w = h[0].offsetTop,
                S = [f.height() - h.outerHeight(!1), x.parent().height() - x.height()],
                b = [o, 0 === o ? 0 : o / s.scrollRatio.y],
                y = p[0],
                B = g[0],
                T = y > 0 ? y / s.scrollRatio.y : 0,
                k = B > 0 ? B / s.scrollRatio.y : 0;
        }

        b[1] < 0 || 0 === b[0] && 0 === b[1] ? b = [0, 0] : b[1] >= S[1] ? b = [S[0], S[1]] : b[0] = -b[0], t[0].mcs || (l(), i("onInit") && c.callbacks.onInit.call(t[0])), clearTimeout(h[0].onCompleteTimeout), J(x[0], _, Math.round(b[1]), u[1], n.scrollEasing), !s.tweenRunning && (0 === w && b[0] >= 0 || w === S[0] && b[0] <= S[0]) || J(h[0], _, Math.round(b[0]), u[0], n.scrollEasing, n.overwrite, {
          onStart: function onStart() {
            n.callbacks && n.onStart && !s.tweenRunning && (i("onScrollStart") && (l(), c.callbacks.onScrollStart.call(t[0])), s.tweenRunning = !0, C(x), s.cbOffsets = r());
          },
          onUpdate: function onUpdate() {
            n.callbacks && n.onUpdate && i("whileScrolling") && (l(), c.callbacks.whileScrolling.call(t[0]));
          },
          onComplete: function onComplete() {
            if (n.callbacks && n.onComplete) {
              "yx" === c.axis && clearTimeout(h[0].onCompleteTimeout);
              var e = h[0].idleTimer || 0;
              h[0].onCompleteTimeout = setTimeout(function () {
                i("onScroll") && (l(), c.callbacks.onScroll.call(t[0])), i("onTotalScroll") && b[1] >= S[1] - T && s.cbOffsets[0] && (l(), c.callbacks.onTotalScroll.call(t[0])), i("onTotalScrollBack") && b[1] <= k && s.cbOffsets[1] && (l(), c.callbacks.onTotalScrollBack.call(t[0])), s.tweenRunning = !1, h[0].idleTimer = 0, C(x, "hide");
              }, e);
            }
          }
        });
      }
    },
        J = function J(e, t, o, a, n, i, r) {
      function l() {
        S.stop || (x || m.call(), x = K() - v, s(), x >= S.time && (S.time = x > S.time ? x + f - (x - S.time) : x + f - 1, S.time < x + 1 && (S.time = x + 1)), S.time < a ? S.id = h(l) : g.call());
      }

      function s() {
        a > 0 ? (S.currVal = u(S.time, _, b, a, n), w[t] = Math.round(S.currVal) + "px") : w[t] = o + "px", p.call();
      }

      function c() {
        f = 1e3 / 60, S.time = x + f, h = window.requestAnimationFrame ? window.requestAnimationFrame : function (e) {
          return s(), setTimeout(e, .01);
        }, S.id = h(l);
      }

      function d() {
        null != S.id && (window.requestAnimationFrame ? window.cancelAnimationFrame(S.id) : clearTimeout(S.id), S.id = null);
      }

      function u(e, t, o, a, n) {
        switch (n) {
          case "linear":
          case "mcsLinear":
            return o * e / a + t;

          case "mcsLinearOut":
            return e /= a, e--, o * Math.sqrt(1 - e * e) + t;

          case "easeInOutSmooth":
            return e /= a / 2, 1 > e ? o / 2 * e * e + t : (e--, -o / 2 * (e * (e - 2) - 1) + t);

          case "easeInOutStrong":
            return e /= a / 2, 1 > e ? o / 2 * Math.pow(2, 10 * (e - 1)) + t : (e--, o / 2 * (-Math.pow(2, -10 * e) + 2) + t);

          case "easeInOut":
          case "mcsEaseInOut":
            return e /= a / 2, 1 > e ? o / 2 * e * e * e + t : (e -= 2, o / 2 * (e * e * e + 2) + t);

          case "easeOutSmooth":
            return e /= a, e--, -o * (e * e * e * e - 1) + t;

          case "easeOutStrong":
            return o * (-Math.pow(2, -10 * e / a) + 1) + t;

          case "easeOut":
          case "mcsEaseOut":
          default:
            var i = (e /= a) * e,
                r = i * e;
            return t + o * (.499999999999997 * r * i + -2.5 * i * i + 5.5 * r + -6.5 * i + 4 * e);
        }
      }

      e._mTween || (e._mTween = {
        top: {},
        left: {}
      });

      var f,
          h,
          r = r || {},
          m = r.onStart || function () {},
          p = r.onUpdate || function () {},
          g = r.onComplete || function () {},
          v = K(),
          x = 0,
          _ = e.offsetTop,
          w = e.style,
          S = e._mTween[t];

      "left" === t && (_ = e.offsetLeft);
      var b = o - _;
      S.stop = 0, "none" !== i && d(), c();
    },
        K = function K() {
      return window.performance && window.performance.now ? window.performance.now() : window.performance && window.performance.webkitNow ? window.performance.webkitNow() : Date.now ? Date.now() : new Date().getTime();
    },
        Z = function Z() {
      var e = this;
      e._mTween || (e._mTween = {
        top: {},
        left: {}
      });

      for (var t = ["top", "left"], o = 0; o < t.length; o++) {
        var a = t[o];
        e._mTween[a].id && (window.requestAnimationFrame ? window.cancelAnimationFrame(e._mTween[a].id) : clearTimeout(e._mTween[a].id), e._mTween[a].id = null, e._mTween[a].stop = 1);
      }
    },
        $ = function $(e, t) {
      try {
        delete e[t];
      } catch (o) {
        e[t] = null;
      }
    },
        ee = function ee(e) {
      return !(e.which && 1 !== e.which);
    },
        te = function te(e) {
      var t = e.originalEvent.pointerType;
      return !(t && "touch" !== t && 2 !== t);
    },
        oe = function oe(e) {
      return !isNaN(parseFloat(e)) && isFinite(e);
    },
        ae = function ae(e) {
      var t = e.parents(".mCSB_container");
      return [e.offset().top - t.offset().top, e.offset().left - t.offset().left];
    },
        ne = function ne() {
      function e() {
        var e = ["webkit", "moz", "ms", "o"];
        if ("hidden" in document) return "hidden";

        for (var t = 0; t < e.length; t++) {
          if (e[t] + "Hidden" in document) return e[t] + "Hidden";
        }

        return null;
      }

      var t = e();
      return t ? document[t] : !1;
    };

    e.fn[o] = function (t) {
      return u[t] ? u[t].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != _typeof(t) && t ? void e.error("Method " + t + " does not exist") : u.init.apply(this, arguments);
    }, e[o] = function (t) {
      return u[t] ? u[t].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != _typeof(t) && t ? void e.error("Method " + t + " does not exist") : u.init.apply(this, arguments);
    }, e[o].defaults = i, window[o] = !0, e(window).bind("load", function () {
      e(n)[o](), e.extend(e.expr[":"], {
        mcsInView: e.expr[":"].mcsInView || function (t) {
          var o,
              a,
              n = e(t),
              i = n.parents(".mCSB_container");
          if (i.length) return o = i.parent(), a = [i[0].offsetTop, i[0].offsetLeft], a[0] + ae(n)[0] >= 0 && a[0] + ae(n)[0] < o.height() - n.outerHeight(!1) && a[1] + ae(n)[1] >= 0 && a[1] + ae(n)[1] < o.width() - n.outerWidth(!1);
        },
        mcsInSight: e.expr[":"].mcsInSight || function (t, o, a) {
          var n,
              i,
              r,
              l,
              s = e(t),
              c = s.parents(".mCSB_container"),
              d = "exact" === a[3] ? [[1, 0], [1, 0]] : [[.9, .1], [.6, .4]];
          if (c.length) return n = [s.outerHeight(!1), s.outerWidth(!1)], r = [c[0].offsetTop + ae(s)[0], c[0].offsetLeft + ae(s)[1]], i = [c.parent()[0].offsetHeight, c.parent()[0].offsetWidth], l = [n[0] < i[0] ? d[0] : d[1], n[1] < i[1] ? d[0] : d[1]], r[0] - i[0] * l[0][0] < 0 && r[0] + n[0] - i[0] * l[0][1] >= 0 && r[1] - i[1] * l[1][0] < 0 && r[1] + n[1] - i[1] * l[1][1] >= 0;
        },
        mcsOverflow: e.expr[":"].mcsOverflow || function (t) {
          var o = e(t).data(a);
          if (o) return o.overflowed[0] || o.overflowed[1];
        }
      });
    });
  });
});

/***/ }),

/***/ "./js/plugs/scrolloverflow.min.js":
/*!****************************************!*\
  !*** ./js/plugs/scrolloverflow.min.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_RESULT__;function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/**
* Customized version of iScroll.js 0.1.3
* It fixes bugs affecting its integration with fullpage.js
* @license
*/
!function (r, n, p) {
  var f = r.requestAnimationFrame || r.webkitRequestAnimationFrame || r.mozRequestAnimationFrame || r.oRequestAnimationFrame || r.msRequestAnimationFrame || function (t) {
    r.setTimeout(t, 1e3 / 60);
  },
      m = function () {
    var e = {},
        o = n.createElement("div").style,
        i = function () {
      for (var t = ["t", "webkitT", "MozT", "msT", "OT"], i = 0, s = t.length; i < s; i++) {
        if (t[i] + "ransform" in o) return t[i].substr(0, t[i].length - 1);
      }

      return !1;
    }();

    function t(t) {
      return !1 !== i && ("" === i ? t : i + t.charAt(0).toUpperCase() + t.substr(1));
    }

    e.getTime = Date.now || function () {
      return new Date().getTime();
    }, e.extend = function (t, i) {
      for (var s in i) {
        t[s] = i[s];
      }
    }, e.addEvent = function (t, i, s, e) {
      t.addEventListener(i, s, !!e);
    }, e.removeEvent = function (t, i, s, e) {
      t.removeEventListener(i, s, !!e);
    }, e.prefixPointerEvent = function (t) {
      return r.MSPointerEvent ? "MSPointer" + t.charAt(7).toUpperCase() + t.substr(8) : t;
    }, e.momentum = function (t, i, s, e, o, n) {
      var r,
          h,
          a = t - i,
          l = p.abs(a) / s;
      return h = l / (n = void 0 === n ? 6e-4 : n), (r = t + l * l / (2 * n) * (a < 0 ? -1 : 1)) < e ? (r = o ? e - o / 2.5 * (l / 8) : e, h = (a = p.abs(r - t)) / l) : 0 < r && (r = o ? o / 2.5 * (l / 8) : 0, h = (a = p.abs(t) + r) / l), {
        destination: p.round(r),
        duration: h
      };
    };
    var s = t("transform");
    return e.extend(e, {
      hasTransform: !1 !== s,
      hasPerspective: t("perspective") in o,
      hasTouch: "ontouchstart" in r,
      hasPointer: !(!r.PointerEvent && !r.MSPointerEvent),
      hasTransition: t("transition") in o
    }), e.isBadAndroid = function () {
      var t = r.navigator.appVersion;
      if (!/Android/.test(t) || /Chrome\/\d/.test(t)) return !1;
      var i = t.match(/Safari\/(\d+.\d)/);
      return !(i && "object" == _typeof(i) && 2 <= i.length) || parseFloat(i[1]) < 535.19;
    }(), e.extend(e.style = {}, {
      transform: s,
      transitionTimingFunction: t("transitionTimingFunction"),
      transitionDuration: t("transitionDuration"),
      transitionDelay: t("transitionDelay"),
      transformOrigin: t("transformOrigin")
    }), e.hasClass = function (t, i) {
      return new RegExp("(^|\\s)" + i + "(\\s|$)").test(t.className);
    }, e.addClass = function (t, i) {
      if (!e.hasClass(t, i)) {
        var s = t.className.split(" ");
        s.push(i), t.className = s.join(" ");
      }
    }, e.removeClass = function (t, i) {
      if (e.hasClass(t, i)) {
        var s = new RegExp("(^|\\s)" + i + "(\\s|$)", "g");
        t.className = t.className.replace(s, " ");
      }
    }, e.offset = function (t) {
      for (var i = -t.offsetLeft, s = -t.offsetTop; t = t.offsetParent;) {
        i -= t.offsetLeft, s -= t.offsetTop;
      }

      return {
        left: i,
        top: s
      };
    }, e.preventDefaultException = function (t, i) {
      for (var s in i) {
        if (i[s].test(t[s])) return !0;
      }

      return !1;
    }, e.extend(e.eventType = {}, {
      touchstart: 1,
      touchmove: 1,
      touchend: 1,
      mousedown: 2,
      mousemove: 2,
      mouseup: 2,
      pointerdown: 3,
      pointermove: 3,
      pointerup: 3,
      MSPointerDown: 3,
      MSPointerMove: 3,
      MSPointerUp: 3
    }), e.extend(e.ease = {}, {
      quadratic: {
        style: "cubic-bezier(0.25, 0.46, 0.45, 0.94)",
        fn: function fn(t) {
          return t * (2 - t);
        }
      },
      circular: {
        style: "cubic-bezier(0.1, 0.57, 0.1, 1)",
        fn: function fn(t) {
          return p.sqrt(1 - --t * t);
        }
      },
      back: {
        style: "cubic-bezier(0.175, 0.885, 0.32, 1.275)",
        fn: function fn(t) {
          return (t -= 1) * t * (5 * t + 4) + 1;
        }
      },
      bounce: {
        style: "",
        fn: function fn(t) {
          return (t /= 1) < 1 / 2.75 ? 7.5625 * t * t : t < 2 / 2.75 ? 7.5625 * (t -= 1.5 / 2.75) * t + .75 : t < 2.5 / 2.75 ? 7.5625 * (t -= 2.25 / 2.75) * t + .9375 : 7.5625 * (t -= 2.625 / 2.75) * t + .984375;
        }
      },
      elastic: {
        style: "",
        fn: function fn(t) {
          return 0 === t ? 0 : 1 == t ? 1 : .4 * p.pow(2, -10 * t) * p.sin((t - .055) * (2 * p.PI) / .22) + 1;
        }
      }
    }), e.tap = function (t, i) {
      var s = n.createEvent("Event");
      s.initEvent(i, !0, !0), s.pageX = t.pageX, s.pageY = t.pageY, t.target.dispatchEvent(s);
    }, e.click = function (t) {
      var i,
          s = t.target;
      /(SELECT|INPUT|TEXTAREA)/i.test(s.tagName) || ((i = n.createEvent(r.MouseEvent ? "MouseEvents" : "Event")).initEvent("click", !0, !0), i.view = t.view || r, i.detail = 1, i.screenX = s.screenX || 0, i.screenY = s.screenY || 0, i.clientX = s.clientX || 0, i.clientY = s.clientY || 0, i.ctrlKey = !!t.ctrlKey, i.altKey = !!t.altKey, i.shiftKey = !!t.shiftKey, i.metaKey = !!t.metaKey, i.button = 0, i.relatedTarget = null, i._constructed = !0, s.dispatchEvent(i));
    }, e;
  }();

  function t(t, i) {
    for (var s in this.wrapper = "string" == typeof t ? n.querySelector(t) : t, this.scroller = this.wrapper.children[0], this.scrollerStyle = this.scroller.style, this.options = {
      resizeScrollbars: !0,
      mouseWheelSpeed: 20,
      snapThreshold: .334,
      disablePointer: !m.hasPointer,
      disableTouch: m.hasPointer || !m.hasTouch,
      disableMouse: m.hasPointer || m.hasTouch,
      startX: 0,
      startY: 0,
      scrollY: !0,
      directionLockThreshold: 5,
      momentum: !0,
      bounce: !0,
      bounceTime: 600,
      bounceEasing: "",
      preventDefault: !0,
      preventDefaultException: {
        tagName: /^(INPUT|TEXTAREA|BUTTON|SELECT|LABEL)$/
      },
      HWCompositing: !0,
      useTransition: !0,
      useTransform: !0,
      bindToWrapper: void 0 === r.onmousedown
    }, i) {
      this.options[s] = i[s];
    }

    this.translateZ = this.options.HWCompositing && m.hasPerspective ? " translateZ(0)" : "", this.options.useTransition = m.hasTransition && this.options.useTransition, this.options.useTransform = m.hasTransform && this.options.useTransform, this.options.eventPassthrough = !0 === this.options.eventPassthrough ? "vertical" : this.options.eventPassthrough, this.options.preventDefault = !this.options.eventPassthrough && this.options.preventDefault, this.options.scrollY = "vertical" != this.options.eventPassthrough && this.options.scrollY, this.options.scrollX = "horizontal" != this.options.eventPassthrough && this.options.scrollX, this.options.freeScroll = this.options.freeScroll && !this.options.eventPassthrough, this.options.directionLockThreshold = this.options.eventPassthrough ? 0 : this.options.directionLockThreshold, this.options.bounceEasing = "string" == typeof this.options.bounceEasing ? m.ease[this.options.bounceEasing] || m.ease.circular : this.options.bounceEasing, this.options.resizePolling = void 0 === this.options.resizePolling ? 60 : this.options.resizePolling, !0 === this.options.tap && (this.options.tap = "tap"), this.options.useTransition || this.options.useTransform || /relative|absolute/i.test(this.scrollerStyle.position) || (this.scrollerStyle.position = "relative"), "scale" == this.options.shrinkScrollbars && (this.options.useTransition = !1), this.options.invertWheelDirection = this.options.invertWheelDirection ? -1 : 1, this.x = 0, this.y = 0, this.directionX = 0, this.directionY = 0, this._events = {}, this._init(), this.refresh(), this.scrollTo(this.options.startX, this.options.startY), this.enable();
  }

  function h(t, i, s) {
    var e = n.createElement("div"),
        o = n.createElement("div");
    return !0 === s && (e.style.cssText = "position:absolute;z-index:9999", o.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;background:rgba(0,0,0,0.5);border:1px solid rgba(255,255,255,0.9);border-radius:3px"), o.className = "iScrollIndicator", e.className = "h" == t ? (!0 === s && (e.style.cssText += ";height:7px;left:2px;right:2px;bottom:0", o.style.height = "100%"), "iScrollHorizontalScrollbar") : (!0 === s && (e.style.cssText += ";width:7px;bottom:2px;top:2px;right:1px", o.style.width = "100%"), "iScrollVerticalScrollbar"), e.style.cssText += ";overflow:hidden", i || (e.style.pointerEvents = "none"), e.appendChild(o), e;
  }

  function a(t, i) {
    for (var s in this.wrapper = "string" == typeof i.el ? n.querySelector(i.el) : i.el, this.wrapperStyle = this.wrapper.style, this.indicator = this.wrapper.children[0], this.indicatorStyle = this.indicator.style, this.scroller = t, this.options = {
      listenX: !0,
      listenY: !0,
      interactive: !1,
      resize: !0,
      defaultScrollbars: !1,
      shrink: !1,
      fade: !1,
      speedRatioX: 0,
      speedRatioY: 0
    }, i) {
      this.options[s] = i[s];
    }

    if (this.sizeRatioX = 1, this.sizeRatioY = 1, this.maxPosX = 0, this.maxPosY = 0, this.options.interactive && (this.options.disableTouch || (m.addEvent(this.indicator, "touchstart", this), m.addEvent(r, "touchend", this)), this.options.disablePointer || (m.addEvent(this.indicator, m.prefixPointerEvent("pointerdown"), this), m.addEvent(r, m.prefixPointerEvent("pointerup"), this)), this.options.disableMouse || (m.addEvent(this.indicator, "mousedown", this), m.addEvent(r, "mouseup", this))), this.options.fade) {
      this.wrapperStyle[m.style.transform] = this.scroller.translateZ;
      var e = m.style.transitionDuration;
      if (!e) return;
      this.wrapperStyle[e] = m.isBadAndroid ? "0.0001ms" : "0ms";
      var o = this;
      m.isBadAndroid && f(function () {
        "0.0001ms" === o.wrapperStyle[e] && (o.wrapperStyle[e] = "0s");
      }), this.wrapperStyle.opacity = "0";
    }
  }

  t.prototype = {
    version: "5.2.0",
    _init: function _init() {
      this._initEvents(), (this.options.scrollbars || this.options.indicators) && this._initIndicators(), this.options.mouseWheel && this._initWheel(), this.options.snap && this._initSnap(), this.options.keyBindings && this._initKeys();
    },
    destroy: function destroy() {
      this._initEvents(!0), clearTimeout(this.resizeTimeout), this.resizeTimeout = null, this._execEvent("destroy");
    },
    _transitionEnd: function _transitionEnd(t) {
      t.target == this.scroller && this.isInTransition && (this._transitionTime(), this.resetPosition(this.options.bounceTime) || (this.isInTransition = !1, this._execEvent("scrollEnd")));
    },
    _start: function _start(t) {
      if (1 != m.eventType[t.type] && 0 !== (t.which ? t.button : t.button < 2 ? 0 : 4 == t.button ? 1 : 2)) return;

      if (this.enabled && (!this.initiated || m.eventType[t.type] === this.initiated)) {
        !this.options.preventDefault || m.isBadAndroid || m.preventDefaultException(t.target, this.options.preventDefaultException) || t.preventDefault();
        var i,
            s = t.touches ? t.touches[0] : t;
        this.initiated = m.eventType[t.type], this.moved = !1, this.distX = 0, this.distY = 0, this.directionX = 0, this.directionY = 0, this.directionLocked = 0, this.startTime = m.getTime(), this.options.useTransition && this.isInTransition ? (this._transitionTime(), this.isInTransition = !1, i = this.getComputedPosition(), this._translate(p.round(i.x), p.round(i.y)), this._execEvent("scrollEnd")) : !this.options.useTransition && this.isAnimating && (this.isAnimating = !1, this._execEvent("scrollEnd")), this.startX = this.x, this.startY = this.y, this.absStartX = this.x, this.absStartY = this.y, this.pointX = s.pageX, this.pointY = s.pageY, this._execEvent("beforeScrollStart");
      }
    },
    _move: function _move(t) {
      if (this.enabled && m.eventType[t.type] === this.initiated) {
        this.options.preventDefault && t.preventDefault();
        var i,
            s,
            e,
            o,
            n = t.touches ? t.touches[0] : t,
            r = n.pageX - this.pointX,
            h = n.pageY - this.pointY,
            a = m.getTime();

        if (this.pointX = n.pageX, this.pointY = n.pageY, this.distX += r, this.distY += h, e = p.abs(this.distX), o = p.abs(this.distY), !(300 < a - this.endTime && e < 10 && o < 10)) {
          if (this.directionLocked || this.options.freeScroll || (e > o + this.options.directionLockThreshold ? this.directionLocked = "h" : o >= e + this.options.directionLockThreshold ? this.directionLocked = "v" : this.directionLocked = "n"), "h" == this.directionLocked) {
            if ("vertical" == this.options.eventPassthrough) t.preventDefault();else if ("horizontal" == this.options.eventPassthrough) return void (this.initiated = !1);
            h = 0;
          } else if ("v" == this.directionLocked) {
            if ("horizontal" == this.options.eventPassthrough) t.preventDefault();else if ("vertical" == this.options.eventPassthrough) return void (this.initiated = !1);
            r = 0;
          }

          r = this.hasHorizontalScroll ? r : 0, h = this.hasVerticalScroll ? h : 0, i = this.x + r, s = this.y + h, (0 < i || i < this.maxScrollX) && (i = this.options.bounce ? this.x + r / 3 : 0 < i ? 0 : this.maxScrollX), (0 < s || s < this.maxScrollY) && (s = this.options.bounce ? this.y + h / 3 : 0 < s ? 0 : this.maxScrollY), this.directionX = 0 < r ? -1 : r < 0 ? 1 : 0, this.directionY = 0 < h ? -1 : h < 0 ? 1 : 0, this.moved || this._execEvent("scrollStart"), this.moved = !0, this._translate(i, s), 300 < a - this.startTime && (this.startTime = a, this.startX = this.x, this.startY = this.y);
        }
      }
    },
    _end: function _end(t) {
      if (this.enabled && m.eventType[t.type] === this.initiated) {
        this.options.preventDefault && !m.preventDefaultException(t.target, this.options.preventDefaultException) && t.preventDefault();
        t.changedTouches && t.changedTouches[0];
        var i,
            s,
            e = m.getTime() - this.startTime,
            o = p.round(this.x),
            n = p.round(this.y),
            r = p.abs(o - this.startX),
            h = p.abs(n - this.startY),
            a = 0,
            l = "";

        if (this.isInTransition = 0, this.initiated = 0, this.endTime = m.getTime(), !this.resetPosition(this.options.bounceTime)) {
          if (this.scrollTo(o, n), !this.moved) return this.options.tap && m.tap(t, this.options.tap), this.options.click && m.click(t), void this._execEvent("scrollCancel");
          if (this._events.flick && e < 200 && r < 100 && h < 100) this._execEvent("flick");else {
            if (this.options.momentum && e < 300 && (i = this.hasHorizontalScroll ? m.momentum(this.x, this.startX, e, this.maxScrollX, this.options.bounce ? this.wrapperWidth : 0, this.options.deceleration) : {
              destination: o,
              duration: 0
            }, s = this.hasVerticalScroll ? m.momentum(this.y, this.startY, e, this.maxScrollY, this.options.bounce ? this.wrapperHeight : 0, this.options.deceleration) : {
              destination: n,
              duration: 0
            }, o = i.destination, n = s.destination, a = p.max(i.duration, s.duration), this.isInTransition = 1), this.options.snap) {
              var c = this._nearestSnap(o, n);

              this.currentPage = c, a = this.options.snapSpeed || p.max(p.max(p.min(p.abs(o - c.x), 1e3), p.min(p.abs(n - c.y), 1e3)), 300), o = c.x, n = c.y, this.directionX = 0, this.directionY = 0, l = this.options.bounceEasing;
            }

            if (o != this.x || n != this.y) return (0 < o || o < this.maxScrollX || 0 < n || n < this.maxScrollY) && (l = m.ease.quadratic), void this.scrollTo(o, n, a, l);

            this._execEvent("scrollEnd");
          }
        }
      }
    },
    _resize: function _resize() {
      var t = this;
      clearTimeout(this.resizeTimeout), this.resizeTimeout = setTimeout(function () {
        t.refresh();
      }, this.options.resizePolling);
    },
    resetPosition: function resetPosition(t) {
      var i = this.x,
          s = this.y;
      return t = t || 0, !this.hasHorizontalScroll || 0 < this.x ? i = 0 : this.x < this.maxScrollX && (i = this.maxScrollX), !this.hasVerticalScroll || 0 < this.y ? s = 0 : this.y < this.maxScrollY && (s = this.maxScrollY), (i != this.x || s != this.y) && (this.scrollTo(i, s, t, this.options.bounceEasing), !0);
    },
    disable: function disable() {
      this.enabled = !1;
    },
    enable: function enable() {
      this.enabled = !0;
    },
    refresh: function refresh() {
      this.wrapper.offsetHeight;
      this.wrapperWidth = this.wrapper.clientWidth, this.wrapperHeight = this.wrapper.clientHeight, this.scrollerWidth = this.scroller.offsetWidth, this.scrollerHeight = this.scroller.offsetHeight, this.maxScrollX = this.wrapperWidth - this.scrollerWidth, this.maxScrollY = this.wrapperHeight - this.scrollerHeight, this.hasHorizontalScroll = this.options.scrollX && this.maxScrollX < 0, this.hasVerticalScroll = this.options.scrollY && this.maxScrollY < 0, this.hasHorizontalScroll || (this.maxScrollX = 0, this.scrollerWidth = this.wrapperWidth), this.hasVerticalScroll || (this.maxScrollY = 0, this.scrollerHeight = this.wrapperHeight), this.endTime = 0, this.directionX = 0, this.directionY = 0, this.wrapperOffset = m.offset(this.wrapper), this._execEvent("refresh"), this.resetPosition();
    },
    on: function on(t, i) {
      this._events[t] || (this._events[t] = []), this._events[t].push(i);
    },
    off: function off(t, i) {
      if (this._events[t]) {
        var s = this._events[t].indexOf(i);

        -1 < s && this._events[t].splice(s, 1);
      }
    },
    _execEvent: function _execEvent(t) {
      if (this._events[t]) {
        var i = 0,
            s = this._events[t].length;
        if (s) for (; i < s; i++) {
          this._events[t][i].apply(this, [].slice.call(arguments, 1));
        }
      }
    },
    scrollBy: function scrollBy(t, i, s, e) {
      t = this.x + t, i = this.y + i, s = s || 0, this.scrollTo(t, i, s, e);
    },
    scrollTo: function scrollTo(t, i, s, e) {
      e = e || m.ease.circular, this.isInTransition = this.options.useTransition && 0 < s;
      var o = this.options.useTransition && e.style;
      !s || o ? (o && (this._transitionTimingFunction(e.style), this._transitionTime(s)), this._translate(t, i)) : this._animate(t, i, s, e.fn);
    },
    scrollToElement: function scrollToElement(t, i, s, e, o) {
      if (t = t.nodeType ? t : this.scroller.querySelector(t)) {
        var n = m.offset(t);
        n.left -= this.wrapperOffset.left, n.top -= this.wrapperOffset.top, !0 === s && (s = p.round(t.offsetWidth / 2 - this.wrapper.offsetWidth / 2)), !0 === e && (e = p.round(t.offsetHeight / 2 - this.wrapper.offsetHeight / 2)), n.left -= s || 0, n.top -= e || 0, n.left = 0 < n.left ? 0 : n.left < this.maxScrollX ? this.maxScrollX : n.left, n.top = 0 < n.top ? 0 : n.top < this.maxScrollY ? this.maxScrollY : n.top, i = null == i || "auto" === i ? p.max(p.abs(this.x - n.left), p.abs(this.y - n.top)) : i, this.scrollTo(n.left, n.top, i, o);
      }
    },
    _transitionTime: function _transitionTime(t) {
      if (this.options.useTransition) {
        t = t || 0;
        var i = m.style.transitionDuration;

        if (i) {
          if (this.scrollerStyle[i] = t + "ms", !t && m.isBadAndroid) {
            this.scrollerStyle[i] = "0.0001ms";
            var s = this;
            f(function () {
              "0.0001ms" === s.scrollerStyle[i] && (s.scrollerStyle[i] = "0s");
            });
          }

          if (this.indicators) for (var e = this.indicators.length; e--;) {
            this.indicators[e].transitionTime(t);
          }
        }
      }
    },
    _transitionTimingFunction: function _transitionTimingFunction(t) {
      if (this.scrollerStyle[m.style.transitionTimingFunction] = t, this.indicators) for (var i = this.indicators.length; i--;) {
        this.indicators[i].transitionTimingFunction(t);
      }
    },
    _translate: function _translate(t, i) {
      if (this.options.useTransform ? this.scrollerStyle[m.style.transform] = "translate(" + t + "px," + i + "px)" + this.translateZ : (t = p.round(t), i = p.round(i), this.scrollerStyle.left = t + "px", this.scrollerStyle.top = i + "px"), this.x = t, this.y = i, this.indicators) for (var s = this.indicators.length; s--;) {
        this.indicators[s].updatePosition();
      }
    },
    _initEvents: function _initEvents(t) {
      var i = t ? m.removeEvent : m.addEvent,
          s = this.options.bindToWrapper ? this.wrapper : r;
      i(r, "orientationchange", this), i(r, "resize", this), this.options.click && i(this.wrapper, "click", this, !0), this.options.disableMouse || (i(this.wrapper, "mousedown", this), i(s, "mousemove", this), i(s, "mousecancel", this), i(s, "mouseup", this)), m.hasPointer && !this.options.disablePointer && (i(this.wrapper, m.prefixPointerEvent("pointerdown"), this), i(s, m.prefixPointerEvent("pointermove"), this), i(s, m.prefixPointerEvent("pointercancel"), this), i(s, m.prefixPointerEvent("pointerup"), this)), m.hasTouch && !this.options.disableTouch && (i(this.wrapper, "touchstart", this), i(s, "touchmove", this), i(s, "touchcancel", this), i(s, "touchend", this)), i(this.scroller, "transitionend", this), i(this.scroller, "webkitTransitionEnd", this), i(this.scroller, "oTransitionEnd", this), i(this.scroller, "MSTransitionEnd", this);
    },
    getComputedPosition: function getComputedPosition() {
      var t,
          i,
          s = r.getComputedStyle(this.scroller, null);
      return i = this.options.useTransform ? (t = +((s = s[m.style.transform].split(")")[0].split(", "))[12] || s[4]), +(s[13] || s[5])) : (t = +s.left.replace(/[^-\d.]/g, ""), +s.top.replace(/[^-\d.]/g, "")), {
        x: t,
        y: i
      };
    },
    _initIndicators: function _initIndicators() {
      var t,
          i = this.options.interactiveScrollbars,
          s = "string" != typeof this.options.scrollbars,
          e = [],
          o = this;
      this.indicators = [], this.options.scrollbars && (this.options.scrollY && (t = {
        el: h("v", i, this.options.scrollbars),
        interactive: i,
        defaultScrollbars: !0,
        customStyle: s,
        resize: this.options.resizeScrollbars,
        shrink: this.options.shrinkScrollbars,
        fade: this.options.fadeScrollbars,
        listenX: !1
      }, this.wrapper.appendChild(t.el), e.push(t)), this.options.scrollX && (t = {
        el: h("h", i, this.options.scrollbars),
        interactive: i,
        defaultScrollbars: !0,
        customStyle: s,
        resize: this.options.resizeScrollbars,
        shrink: this.options.shrinkScrollbars,
        fade: this.options.fadeScrollbars,
        listenY: !1
      }, this.wrapper.appendChild(t.el), e.push(t))), this.options.indicators && (e = e.concat(this.options.indicators));

      for (var n = e.length; n--;) {
        this.indicators.push(new a(this, e[n]));
      }

      function r(t) {
        if (o.indicators) for (var i = o.indicators.length; i--;) {
          t.call(o.indicators[i]);
        }
      }

      this.options.fadeScrollbars && (this.on("scrollEnd", function () {
        r(function () {
          this.fade();
        });
      }), this.on("scrollCancel", function () {
        r(function () {
          this.fade();
        });
      }), this.on("scrollStart", function () {
        r(function () {
          this.fade(1);
        });
      }), this.on("beforeScrollStart", function () {
        r(function () {
          this.fade(1, !0);
        });
      })), this.on("refresh", function () {
        r(function () {
          this.refresh();
        });
      }), this.on("destroy", function () {
        r(function () {
          this.destroy();
        }), delete this.indicators;
      });
    },
    _initWheel: function _initWheel() {
      m.addEvent(this.wrapper, "wheel", this), m.addEvent(this.wrapper, "mousewheel", this), m.addEvent(this.wrapper, "DOMMouseScroll", this), this.on("destroy", function () {
        clearTimeout(this.wheelTimeout), this.wheelTimeout = null, m.removeEvent(this.wrapper, "wheel", this), m.removeEvent(this.wrapper, "mousewheel", this), m.removeEvent(this.wrapper, "DOMMouseScroll", this);
      });
    },
    _wheel: function _wheel(t) {
      if (this.enabled) {
        r.navigator.userAgent.match(/(MSIE|Trident)/) || t.preventDefault();
        var i,
            s,
            e,
            o,
            n = this;
        if (void 0 === this.wheelTimeout && n._execEvent("scrollStart"), clearTimeout(this.wheelTimeout), this.wheelTimeout = setTimeout(function () {
          n.options.snap || n._execEvent("scrollEnd"), n.wheelTimeout = void 0;
        }, 400), "deltaX" in t) s = 1 === t.deltaMode ? (i = -t.deltaX * this.options.mouseWheelSpeed, -t.deltaY * this.options.mouseWheelSpeed) : (i = -t.deltaX, -t.deltaY);else if ("wheelDeltaX" in t) i = t.wheelDeltaX / 120 * this.options.mouseWheelSpeed, s = t.wheelDeltaY / 120 * this.options.mouseWheelSpeed;else if ("wheelDelta" in t) i = s = t.wheelDelta / 120 * this.options.mouseWheelSpeed;else {
          if (!("detail" in t)) return;
          i = s = -t.detail / 3 * this.options.mouseWheelSpeed;
        }
        if (i *= this.options.invertWheelDirection, s *= this.options.invertWheelDirection, this.hasVerticalScroll || (i = s, s = 0), this.options.snap) return e = this.currentPage.pageX, o = this.currentPage.pageY, 0 < i ? e-- : i < 0 && e++, 0 < s ? o-- : s < 0 && o++, void this.goToPage(e, o);
        e = this.x + p.round(this.hasHorizontalScroll ? i : 0), o = this.y + p.round(this.hasVerticalScroll ? s : 0), this.directionX = 0 < i ? -1 : i < 0 ? 1 : 0, this.directionY = 0 < s ? -1 : s < 0 ? 1 : 0, 0 < e ? e = 0 : e < this.maxScrollX && (e = this.maxScrollX), 0 < o ? o = 0 : o < this.maxScrollY && (o = this.maxScrollY), this.scrollTo(e, o, 0);
      }
    },
    _initSnap: function _initSnap() {
      this.currentPage = {}, "string" == typeof this.options.snap && (this.options.snap = this.scroller.querySelectorAll(this.options.snap)), this.on("refresh", function () {
        var t,
            i,
            s,
            e,
            o,
            n,
            r = 0,
            h = 0,
            a = 0,
            l = this.options.snapStepX || this.wrapperWidth,
            c = this.options.snapStepY || this.wrapperHeight;

        if (this.pages = [], this.wrapperWidth && this.wrapperHeight && this.scrollerWidth && this.scrollerHeight) {
          if (!0 === this.options.snap) for (s = p.round(l / 2), e = p.round(c / 2); a > -this.scrollerWidth;) {
            for (this.pages[r] = [], o = t = 0; o > -this.scrollerHeight;) {
              this.pages[r][t] = {
                x: p.max(a, this.maxScrollX),
                y: p.max(o, this.maxScrollY),
                width: l,
                height: c,
                cx: a - s,
                cy: o - e
              }, o -= c, t++;
            }

            a -= l, r++;
          } else for (t = (n = this.options.snap).length, i = -1; r < t; r++) {
            (0 === r || n[r].offsetLeft <= n[r - 1].offsetLeft) && (h = 0, i++), this.pages[h] || (this.pages[h] = []), a = p.max(-n[r].offsetLeft, this.maxScrollX), o = p.max(-n[r].offsetTop, this.maxScrollY), s = a - p.round(n[r].offsetWidth / 2), e = o - p.round(n[r].offsetHeight / 2), this.pages[h][i] = {
              x: a,
              y: o,
              width: n[r].offsetWidth,
              height: n[r].offsetHeight,
              cx: s,
              cy: e
            }, a > this.maxScrollX && h++;
          }
          this.goToPage(this.currentPage.pageX || 0, this.currentPage.pageY || 0, 0), this.options.snapThreshold % 1 == 0 ? (this.snapThresholdX = this.options.snapThreshold, this.snapThresholdY = this.options.snapThreshold) : (this.snapThresholdX = p.round(this.pages[this.currentPage.pageX][this.currentPage.pageY].width * this.options.snapThreshold), this.snapThresholdY = p.round(this.pages[this.currentPage.pageX][this.currentPage.pageY].height * this.options.snapThreshold));
        }
      }), this.on("flick", function () {
        var t = this.options.snapSpeed || p.max(p.max(p.min(p.abs(this.x - this.startX), 1e3), p.min(p.abs(this.y - this.startY), 1e3)), 300);
        this.goToPage(this.currentPage.pageX + this.directionX, this.currentPage.pageY + this.directionY, t);
      });
    },
    _nearestSnap: function _nearestSnap(t, i) {
      if (!this.pages.length) return {
        x: 0,
        y: 0,
        pageX: 0,
        pageY: 0
      };
      var s = 0,
          e = this.pages.length,
          o = 0;
      if (p.abs(t - this.absStartX) < this.snapThresholdX && p.abs(i - this.absStartY) < this.snapThresholdY) return this.currentPage;

      for (0 < t ? t = 0 : t < this.maxScrollX && (t = this.maxScrollX), 0 < i ? i = 0 : i < this.maxScrollY && (i = this.maxScrollY); s < e; s++) {
        if (t >= this.pages[s][0].cx) {
          t = this.pages[s][0].x;
          break;
        }
      }

      for (e = this.pages[s].length; o < e; o++) {
        if (i >= this.pages[0][o].cy) {
          i = this.pages[0][o].y;
          break;
        }
      }

      return s == this.currentPage.pageX && ((s += this.directionX) < 0 ? s = 0 : s >= this.pages.length && (s = this.pages.length - 1), t = this.pages[s][0].x), o == this.currentPage.pageY && ((o += this.directionY) < 0 ? o = 0 : o >= this.pages[0].length && (o = this.pages[0].length - 1), i = this.pages[0][o].y), {
        x: t,
        y: i,
        pageX: s,
        pageY: o
      };
    },
    goToPage: function goToPage(t, i, s, e) {
      e = e || this.options.bounceEasing, t >= this.pages.length ? t = this.pages.length - 1 : t < 0 && (t = 0), i >= this.pages[t].length ? i = this.pages[t].length - 1 : i < 0 && (i = 0);
      var o = this.pages[t][i].x,
          n = this.pages[t][i].y;
      s = void 0 === s ? this.options.snapSpeed || p.max(p.max(p.min(p.abs(o - this.x), 1e3), p.min(p.abs(n - this.y), 1e3)), 300) : s, this.currentPage = {
        x: o,
        y: n,
        pageX: t,
        pageY: i
      }, this.scrollTo(o, n, s, e);
    },
    next: function next(t, i) {
      var s = this.currentPage.pageX,
          e = this.currentPage.pageY;
      ++s >= this.pages.length && this.hasVerticalScroll && (s = 0, e++), this.goToPage(s, e, t, i);
    },
    prev: function prev(t, i) {
      var s = this.currentPage.pageX,
          e = this.currentPage.pageY;
      --s < 0 && this.hasVerticalScroll && (s = 0, e--), this.goToPage(s, e, t, i);
    },
    _initKeys: function _initKeys(t) {
      var i,
          s = {
        pageUp: 33,
        pageDown: 34,
        end: 35,
        home: 36,
        left: 37,
        up: 38,
        right: 39,
        down: 40
      };
      if ("object" == _typeof(this.options.keyBindings)) for (i in this.options.keyBindings) {
        "string" == typeof this.options.keyBindings[i] && (this.options.keyBindings[i] = this.options.keyBindings[i].toUpperCase().charCodeAt(0));
      } else this.options.keyBindings = {};

      for (i in s) {
        this.options.keyBindings[i] = this.options.keyBindings[i] || s[i];
      }

      m.addEvent(r, "keydown", this), this.on("destroy", function () {
        m.removeEvent(r, "keydown", this);
      });
    },
    _key: function _key(t) {
      if (this.enabled) {
        var i,
            s = this.options.snap,
            e = s ? this.currentPage.pageX : this.x,
            o = s ? this.currentPage.pageY : this.y,
            n = m.getTime(),
            r = this.keyTime || 0;

        switch (this.options.useTransition && this.isInTransition && (i = this.getComputedPosition(), this._translate(p.round(i.x), p.round(i.y)), this.isInTransition = !1), this.keyAcceleration = n - r < 200 ? p.min(this.keyAcceleration + .25, 50) : 0, t.keyCode) {
          case this.options.keyBindings.pageUp:
            this.hasHorizontalScroll && !this.hasVerticalScroll ? e += s ? 1 : this.wrapperWidth : o += s ? 1 : this.wrapperHeight;
            break;

          case this.options.keyBindings.pageDown:
            this.hasHorizontalScroll && !this.hasVerticalScroll ? e -= s ? 1 : this.wrapperWidth : o -= s ? 1 : this.wrapperHeight;
            break;

          case this.options.keyBindings.end:
            e = s ? this.pages.length - 1 : this.maxScrollX, o = s ? this.pages[0].length - 1 : this.maxScrollY;
            break;

          case this.options.keyBindings.home:
            o = e = 0;
            break;

          case this.options.keyBindings.left:
            e += s ? -1 : 5 + this.keyAcceleration >> 0;
            break;

          case this.options.keyBindings.up:
            o += s ? 1 : 5 + this.keyAcceleration >> 0;
            break;

          case this.options.keyBindings.right:
            e -= s ? -1 : 5 + this.keyAcceleration >> 0;
            break;

          case this.options.keyBindings.down:
            o -= s ? 1 : 5 + this.keyAcceleration >> 0;
            break;

          default:
            return;
        }

        s ? this.goToPage(e, o) : (0 < e ? (e = 0, this.keyAcceleration = 0) : e < this.maxScrollX && (e = this.maxScrollX, this.keyAcceleration = 0), 0 < o ? (o = 0, this.keyAcceleration = 0) : o < this.maxScrollY && (o = this.maxScrollY, this.keyAcceleration = 0), this.scrollTo(e, o, 0), this.keyTime = n);
      }
    },
    _animate: function _animate(n, r, h, a) {
      var l = this,
          c = this.x,
          p = this.y,
          d = m.getTime(),
          u = d + h;
      this.isAnimating = !0, function t() {
        var i,
            s,
            e,
            o = m.getTime();
        if (u <= o) return l.isAnimating = !1, l._translate(n, r), void (l.resetPosition(l.options.bounceTime) || l._execEvent("scrollEnd"));
        e = a(o = (o - d) / h), i = (n - c) * e + c, s = (r - p) * e + p, l._translate(i, s), l.isAnimating && f(t);
      }();
    },
    handleEvent: function handleEvent(t) {
      switch (t.type) {
        case "touchstart":
        case "pointerdown":
        case "MSPointerDown":
        case "mousedown":
          this._start(t);

          break;

        case "touchmove":
        case "pointermove":
        case "MSPointerMove":
        case "mousemove":
          this._move(t);

          break;

        case "touchend":
        case "pointerup":
        case "MSPointerUp":
        case "mouseup":
        case "touchcancel":
        case "pointercancel":
        case "MSPointerCancel":
        case "mousecancel":
          this._end(t);

          break;

        case "orientationchange":
        case "resize":
          this._resize();

          break;

        case "transitionend":
        case "webkitTransitionEnd":
        case "oTransitionEnd":
        case "MSTransitionEnd":
          this._transitionEnd(t);

          break;

        case "wheel":
        case "DOMMouseScroll":
        case "mousewheel":
          this._wheel(t);

          break;

        case "keydown":
          this._key(t);

          break;

        case "click":
          this.enabled && !t._constructed && (t.preventDefault(), t.stopPropagation());
      }
    }
  }, a.prototype = {
    handleEvent: function handleEvent(t) {
      switch (t.type) {
        case "touchstart":
        case "pointerdown":
        case "MSPointerDown":
        case "mousedown":
          this._start(t);

          break;

        case "touchmove":
        case "pointermove":
        case "MSPointerMove":
        case "mousemove":
          this._move(t);

          break;

        case "touchend":
        case "pointerup":
        case "MSPointerUp":
        case "mouseup":
        case "touchcancel":
        case "pointercancel":
        case "MSPointerCancel":
        case "mousecancel":
          this._end(t);

      }
    },
    destroy: function destroy() {
      this.options.fadeScrollbars && (clearTimeout(this.fadeTimeout), this.fadeTimeout = null), this.options.interactive && (m.removeEvent(this.indicator, "touchstart", this), m.removeEvent(this.indicator, m.prefixPointerEvent("pointerdown"), this), m.removeEvent(this.indicator, "mousedown", this), m.removeEvent(r, "touchmove", this), m.removeEvent(r, m.prefixPointerEvent("pointermove"), this), m.removeEvent(r, "mousemove", this), m.removeEvent(r, "touchend", this), m.removeEvent(r, m.prefixPointerEvent("pointerup"), this), m.removeEvent(r, "mouseup", this)), this.options.defaultScrollbars && this.wrapper.parentNode.removeChild(this.wrapper);
    },
    _start: function _start(t) {
      var i = t.touches ? t.touches[0] : t;
      t.preventDefault(), t.stopPropagation(), this.transitionTime(), this.initiated = !0, this.moved = !1, this.lastPointX = i.pageX, this.lastPointY = i.pageY, this.startTime = m.getTime(), this.options.disableTouch || m.addEvent(r, "touchmove", this), this.options.disablePointer || m.addEvent(r, m.prefixPointerEvent("pointermove"), this), this.options.disableMouse || m.addEvent(r, "mousemove", this), this.scroller._execEvent("beforeScrollStart");
    },
    _move: function _move(t) {
      var i,
          s,
          e,
          o,
          n = t.touches ? t.touches[0] : t;
      m.getTime();
      this.moved || this.scroller._execEvent("scrollStart"), this.moved = !0, i = n.pageX - this.lastPointX, this.lastPointX = n.pageX, s = n.pageY - this.lastPointY, this.lastPointY = n.pageY, e = this.x + i, o = this.y + s, this._pos(e, o), t.preventDefault(), t.stopPropagation();
    },
    _end: function _end(t) {
      if (this.initiated) {
        if (this.initiated = !1, t.preventDefault(), t.stopPropagation(), m.removeEvent(r, "touchmove", this), m.removeEvent(r, m.prefixPointerEvent("pointermove"), this), m.removeEvent(r, "mousemove", this), this.scroller.options.snap) {
          var i = this.scroller._nearestSnap(this.scroller.x, this.scroller.y),
              s = this.options.snapSpeed || p.max(p.max(p.min(p.abs(this.scroller.x - i.x), 1e3), p.min(p.abs(this.scroller.y - i.y), 1e3)), 300);

          this.scroller.x == i.x && this.scroller.y == i.y || (this.scroller.directionX = 0, this.scroller.directionY = 0, this.scroller.currentPage = i, this.scroller.scrollTo(i.x, i.y, s, this.scroller.options.bounceEasing));
        }

        this.moved && this.scroller._execEvent("scrollEnd");
      }
    },
    transitionTime: function transitionTime(t) {
      t = t || 0;
      var i = m.style.transitionDuration;

      if (i && (this.indicatorStyle[i] = t + "ms", !t && m.isBadAndroid)) {
        this.indicatorStyle[i] = "0.0001ms";
        var s = this;
        f(function () {
          "0.0001ms" === s.indicatorStyle[i] && (s.indicatorStyle[i] = "0s");
        });
      }
    },
    transitionTimingFunction: function transitionTimingFunction(t) {
      this.indicatorStyle[m.style.transitionTimingFunction] = t;
    },
    refresh: function refresh() {
      this.transitionTime(), this.options.listenX && !this.options.listenY ? this.indicatorStyle.display = this.scroller.hasHorizontalScroll ? "block" : "none" : this.options.listenY && !this.options.listenX ? this.indicatorStyle.display = this.scroller.hasVerticalScroll ? "block" : "none" : this.indicatorStyle.display = this.scroller.hasHorizontalScroll || this.scroller.hasVerticalScroll ? "block" : "none", this.scroller.hasHorizontalScroll && this.scroller.hasVerticalScroll ? (m.addClass(this.wrapper, "iScrollBothScrollbars"), m.removeClass(this.wrapper, "iScrollLoneScrollbar"), this.options.defaultScrollbars && this.options.customStyle && (this.options.listenX ? this.wrapper.style.right = "8px" : this.wrapper.style.bottom = "8px")) : (m.removeClass(this.wrapper, "iScrollBothScrollbars"), m.addClass(this.wrapper, "iScrollLoneScrollbar"), this.options.defaultScrollbars && this.options.customStyle && (this.options.listenX ? this.wrapper.style.right = "2px" : this.wrapper.style.bottom = "2px"));
      this.wrapper.offsetHeight;
      this.options.listenX && (this.wrapperWidth = this.wrapper.clientWidth, this.options.resize ? (this.indicatorWidth = p.max(p.round(this.wrapperWidth * this.wrapperWidth / (this.scroller.scrollerWidth || this.wrapperWidth || 1)), 8), this.indicatorStyle.width = this.indicatorWidth + "px") : this.indicatorWidth = this.indicator.clientWidth, this.maxPosX = this.wrapperWidth - this.indicatorWidth, "clip" == this.options.shrink ? (this.minBoundaryX = 8 - this.indicatorWidth, this.maxBoundaryX = this.wrapperWidth - 8) : (this.minBoundaryX = 0, this.maxBoundaryX = this.maxPosX), this.sizeRatioX = this.options.speedRatioX || this.scroller.maxScrollX && this.maxPosX / this.scroller.maxScrollX), this.options.listenY && (this.wrapperHeight = this.wrapper.clientHeight, this.options.resize ? (this.indicatorHeight = p.max(p.round(this.wrapperHeight * this.wrapperHeight / (this.scroller.scrollerHeight || this.wrapperHeight || 1)), 8), this.indicatorStyle.height = this.indicatorHeight + "px") : this.indicatorHeight = this.indicator.clientHeight, this.maxPosY = this.wrapperHeight - this.indicatorHeight, "clip" == this.options.shrink ? (this.minBoundaryY = 8 - this.indicatorHeight, this.maxBoundaryY = this.wrapperHeight - 8) : (this.minBoundaryY = 0, this.maxBoundaryY = this.maxPosY), this.maxPosY = this.wrapperHeight - this.indicatorHeight, this.sizeRatioY = this.options.speedRatioY || this.scroller.maxScrollY && this.maxPosY / this.scroller.maxScrollY), this.updatePosition();
    },
    updatePosition: function updatePosition() {
      var t = this.options.listenX && p.round(this.sizeRatioX * this.scroller.x) || 0,
          i = this.options.listenY && p.round(this.sizeRatioY * this.scroller.y) || 0;
      this.options.ignoreBoundaries || (t < this.minBoundaryX ? ("scale" == this.options.shrink && (this.width = p.max(this.indicatorWidth + t, 8), this.indicatorStyle.width = this.width + "px"), t = this.minBoundaryX) : t > this.maxBoundaryX ? t = "scale" == this.options.shrink ? (this.width = p.max(this.indicatorWidth - (t - this.maxPosX), 8), this.indicatorStyle.width = this.width + "px", this.maxPosX + this.indicatorWidth - this.width) : this.maxBoundaryX : "scale" == this.options.shrink && this.width != this.indicatorWidth && (this.width = this.indicatorWidth, this.indicatorStyle.width = this.width + "px"), i < this.minBoundaryY ? ("scale" == this.options.shrink && (this.height = p.max(this.indicatorHeight + 3 * i, 8), this.indicatorStyle.height = this.height + "px"), i = this.minBoundaryY) : i > this.maxBoundaryY ? i = "scale" == this.options.shrink ? (this.height = p.max(this.indicatorHeight - 3 * (i - this.maxPosY), 8), this.indicatorStyle.height = this.height + "px", this.maxPosY + this.indicatorHeight - this.height) : this.maxBoundaryY : "scale" == this.options.shrink && this.height != this.indicatorHeight && (this.height = this.indicatorHeight, this.indicatorStyle.height = this.height + "px")), this.x = t, this.y = i, this.scroller.options.useTransform ? this.indicatorStyle[m.style.transform] = "translate(" + t + "px," + i + "px)" + this.scroller.translateZ : (this.indicatorStyle.left = t + "px", this.indicatorStyle.top = i + "px");
    },
    _pos: function _pos(t, i) {
      t < 0 ? t = 0 : t > this.maxPosX && (t = this.maxPosX), i < 0 ? i = 0 : i > this.maxPosY && (i = this.maxPosY), t = this.options.listenX ? p.round(t / this.sizeRatioX) : this.scroller.x, i = this.options.listenY ? p.round(i / this.sizeRatioY) : this.scroller.y, this.scroller.scrollTo(t, i);
    },
    fade: function fade(t, i) {
      if (!i || this.visible) {
        clearTimeout(this.fadeTimeout), this.fadeTimeout = null;
        var s = t ? 250 : 500,
            e = t ? 0 : 300;
        t = t ? "1" : "0", this.wrapperStyle[m.style.transitionDuration] = s + "ms", this.fadeTimeout = setTimeout(function (t) {
          this.wrapperStyle.opacity = t, this.visible = +t;
        }.bind(this, t), e);
      }
    }
  }, t.utils = m,  true && module.exports ? module.exports = t :  true ? (!(__WEBPACK_AMD_DEFINE_RESULT__ = (function () {
    return t;
  }).call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)), void 0 !== r && (r.IScroll = t)) : undefined;
}(window, document, Math),
/*!
* Scrolloverflow 2.0.4 module for fullPage.js >= 3
* https://github.com/alvarotrigo/fullPage.js
* @license MIT licensed
*
* Copyright (C) 2015 alvarotrigo.com - A project by Alvaro Trigo
*/
function (l, c) {
  l.fp_scrolloverflow = function () {
    l.IScroll || (l.IScroll = module.exports);
    var s = "fp-scrollable",
        n = "." + s,
        t = ".active",
        d = ".fp-section",
        e = d + t,
        o = ".fp-slide",
        u = ".fp-tableCell";

    function r() {
      var p = this;

      function s() {
        var i;
        fp_utils.hasClass(c.body, "fp-responsive") ? (i = p.options.scrollOverflowHandler, e(function (t) {
          fp_utils.hasClass(fp_utils.closest(t, d), "fp-auto-height-responsive") && i.remove(t);
        })) : e(t);
      }

      function t(t) {
        if (!fp_utils.hasClass(t, "fp-noscroll")) {
          fp_utils.css(t, {
            overflow: "hidden"
          });
          var i,
              s,
              e,
              o = p.options.scrollOverflowHandler,
              n = o.wrapContent(),
              r = fp_utils.closest(t, d),
              h = o.scrollable(t),
              a = (s = r, null != (e = fp_utils.closest(s, d)) ? parseInt(getComputedStyle(e)["padding-bottom"]) + parseInt(getComputedStyle(e)["padding-top"]) : 0);
          null != h ? i = o.scrollHeight(t) : (i = t.scrollHeight, p.options.verticalCentered && (i = f(u, t)[0].scrollHeight));
          var l = fp_utils.getWindowHeight(),
              c = l - a;
          l < i + a ? null != h ? o.update(t, c) : (p.options.verticalCentered ? (fp_utils.wrapInner(f(u, t)[0], n.scroller), fp_utils.wrapInner(f(u, t)[0], n.scrollable)) : (fp_utils.wrapInner(t, n.scroller), fp_utils.wrapInner(t, n.scrollable)), o.create(t, c, p.iscrollOptions)) : o.remove(t), fp_utils.css(t, {
            overflow: ""
          });
        }
      }

      function e(s) {
        f(d).forEach(function (t) {
          var i = f(o, t);
          i.length ? i.forEach(function (t) {
            s(t);
          }) : s(t);
        });
      }

      p.options = null, p.init = function (t, i) {
        return p.options = t, p.iscrollOptions = i, "complete" === c.readyState && (s(), fullpage_api.shared.afterRenderActions()), l.addEventListener("load", function () {
          s(), fullpage_api.shared.afterRenderActions();
        }), p;
      }, p.createScrollBarForAll = s, p.createScrollBar = t;
    }

    IScroll.prototype.wheelOn = function () {
      this.wrapper.addEventListener("wheel", this), this.wrapper.addEventListener("mousewheel", this), this.wrapper.addEventListener("DOMMouseScroll", this);
    }, IScroll.prototype.wheelOff = function () {
      this.wrapper.removeEventListener("wheel", this), this.wrapper.removeEventListener("mousewheel", this), this.wrapper.removeEventListener("DOMMouseScroll", this);
    };
    var f = null,
        h = null,
        a = {
      refreshId: null,
      iScrollInstances: [],
      lastScrollY: null,
      iscrollOptions: {
        scrollbars: !0,
        mouseWheel: !0,
        hideScrollbars: !1,
        fadeScrollbars: !1,
        disableMouse: !0,
        interactiveScrollbars: !0
      },
      init: function init(t) {
        f = fp_utils.$, h = t;
        var i = "ontouchstart" in l || 0 < navigator.msMaxTouchPoints || navigator.maxTouchPoints;
        return a.iscrollOptions.click = i, a.iscrollOptions = fp_utils.deepExtend(a.iscrollOptions, t.scrollOverflowOptions), new r().init(t, a.iscrollOptions);
      },
      toggleWheel: function toggleWheel(s) {
        f(n, f(e)[0]).forEach(function (t) {
          var i = t.fp_iscrollInstance;
          null != i && (s ? i.wheelOn() : i.wheelOff());
        });
      },
      onLeave: function onLeave() {
        a.toggleWheel(!1);
      },
      beforeLeave: function beforeLeave() {
        a.onLeave();
      },
      afterLoad: function afterLoad() {
        a.toggleWheel(!0);
      },
      create: function create(s, e, o) {
        f(n, s).forEach(function (t) {
          fp_utils.css(t, {
            height: e + "px"
          });
          var i = t.fp_iscrollInstance;
          null != i && a.iScrollInstances.forEach(function (t) {
            t.destroy();
          }), i = new IScroll(t, o), a.iScrollInstances.push(i), fp_utils.hasClass(fp_utils.closest(s, d), "active") || i.wheelOff(), t.fp_iscrollInstance = i;
        });
      },
      isScrolled: function isScrolled(t, i) {
        var s = i.fp_iscrollInstance;
        return !s || ("top" === t ? 0 <= s.y && !fp_utils.getScrollTop(i) : "bottom" === t ? 0 - s.y + fp_utils.getScrollTop(i) + i.offsetHeight >= i.scrollHeight : void 0);
      },
      scrollable: function scrollable(t) {
        return f(".fp-slides", t).length ? f(n, f(".fp-slide.active", t)[0])[0] : f(n, t)[0];
      },
      scrollHeight: function scrollHeight(t) {
        return f(".fp-scroller", f(n, t)[0])[0].scrollHeight;
      },
      remove: function remove(t) {
        if (null != t) {
          var i = f(n, t)[0];

          if (null != i) {
            var s = i.fp_iscrollInstance;
            null != s && s.destroy(), i.fp_iscrollInstance = null, fp_utils.unwrap(f(".fp-scroller", t)[0]), fp_utils.unwrap(f(n, t)[0]);
          }
        }
      },
      update: function update(t, i) {
        clearTimeout(a.refreshId), a.refreshId = setTimeout(function () {
          a.iScrollInstances.forEach(function (t) {
            t.refresh(), fullpage_api.silentMoveTo(fp_utils.index(f(e)[0]) + 1);
          });
        }, 150), fp_utils.css(f(n, t)[0], {
          height: i + "px"
        }), h.verticalCentered && fp_utils.css(f(n, t)[0].parentNode, {
          height: i + "px"
        });
      },
      wrapContent: function wrapContent() {
        var t = c.createElement("div");
        t.className = s;
        var i = c.createElement("div");
        return i.className = "fp-scroller", {
          scrollable: t,
          scroller: i
        };
      }
    };
    return {
      iscrollHandler: a
    };
  }();
}(window, document);

/***/ }),

/***/ "./js/plugs/svg.js":
/*!*************************!*\
  !*** ./js/plugs/svg.js ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($, jQuery) {$('img.svg').each(function () {
  var $img = jQuery(this);
  var imgID = $img.attr('id');
  var imgClass = $img.attr('class');
  var imgURL = $img.attr('src');
  jQuery.get(imgURL, function (data) {
    // Get the SVG tag, ignore the rest   
    var $svg = jQuery(data).find('svg'); // Add replaced image's ID to the new SVG   

    if (typeof imgID !== 'undefined') {
      $svg = $svg.attr('id', imgID);
    } // Add replaced image's classes to the new SVG   


    if (typeof imgClass !== 'undefined') {
      $svg = $svg.attr('class', imgClass + ' replaced-svg');
    } // Remove any invalid XML tags as per http://validator.w3.org   


    $svg = $svg.removeAttr('xmlns:a'); // Check if the viewport is set, if the viewport is not set the SVG wont't scale.   

    if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
      $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'));
    } // Replace image with new SVG   


    $img.replaceWith($svg);
  }, 'xml');
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "../node_modules/jquery/dist/jquery.js"), __webpack_require__(/*! jquery */ "../node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ "./js/scripts.js":
/*!***********************!*\
  !*** ./js/scripts.js ***!
  \***********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var plugs_imgLiquid_min_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! plugs/imgLiquid-min.js */ "./js/plugs/imgLiquid-min.js");
/* harmony import */ var plugs_imgLiquid_min_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(plugs_imgLiquid_min_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var svg_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! svg.js */ "./js/plugs/svg.js");
/* harmony import */ var svg_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(svg_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var jquery_easing_1_3_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! jquery.easing.1.3.js */ "./js/plugs/jquery.easing.1.3.js");
/* harmony import */ var jquery_easing_1_3_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(jquery_easing_1_3_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var jquery_mCustomScrollbar_concat_min_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! jquery.mCustomScrollbar.concat.min.js */ "./js/plugs/jquery.mCustomScrollbar.concat.min.js");
/* harmony import */ var jquery_mCustomScrollbar_concat_min_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(jquery_mCustomScrollbar_concat_min_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var scrolloverflow_min_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! scrolloverflow.min.js */ "./js/plugs/scrolloverflow.min.js");
/* harmony import */ var scrolloverflow_min_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(scrolloverflow_min_js__WEBPACK_IMPORTED_MODULE_4__);
// import slick from 'jquery_version/slick.js';
 // import fullpage from 'fullpage.js'



;
 // import 'fullpage.extensions.min.js';


$(document).ready(function () {
  $("html,body").animate({
    scrollTop: $(this).scrollTop() - 1
  }, 10);
  /* ==========================================================================
                * ALL
    ==========================================================================*/

  var $window = $(window);
  var windowHeight = $(window).height();
  var windowWidth = $(window).width();
  var footerHeight = $('footer').height();
  /* ==========================================================================
                * slick
    ==========================================================================*/
  // $('.index_banner div').slick({
  //   dots: true,
  //   infinite: true,
  //   speed: 500,
  //   // fade: true,
  //   cssEase: 'linear',
  //   autoplay: false,
  //   autoplaySpeed: 3500,
  //   slidesToShow: 3,
  //   slidesToScroll: 1,
  // autoplay: true,
  // autoplaySpeed: 2000,
  // });

  /* ==========================================================================
                    * resize
        ==========================================================================*/

  var windowHeight = $(this).height();
  var miniHeight = windowHeight - $('footer').outerHeight() - 90;
  $('main').css({
    "min-height": miniHeight + "px"
  });
  $(window).on('resize', function (event) {
    var windowHeight = $(this).height();
    var miniHeight = windowHeight - $('footer').outerHeight() - 90;
    var moMiniHeight = windowHeight - $('footer').outerHeight() - 50;

    if ($(this).width() > 992) {
      $('main').css({
        "min-height": miniHeight + "px"
      });
    } else {
      $('main').css({
        "min-height": moMiniHeight + "px"
      });
    }

    if ($(this).width() > 991) {
      $('body,html,footer').removeAttr("style");
      $('.header_box').removeClass('open').removeAttr('style');
      $('.nav_box').removeAttr("style");
      $('.hamburger-menu,.menu-wrapper').removeClass('animate').removeAttr("style");
      $('.h-mo-bgc').removeClass('mobgshow').removeAttr("style");
      $('.nav_box').removeClass('navop').removeAttr("style");
    } // nav pc


    if ($(this).width() > 992) {
      $('.nav_box li').on('mouseenter', function () {
        $(this).find('.nav-moreboxbg').stop().fadeIn();
      }).on('mouseleave', function () {
        $(this).find('.nav-moreboxbg').stop().fadeOut();
      });
    } else {
      $('.nav_box li').find('.nav-moreboxbg').removeAttr("style");
      $('.nav_box li').off('mouseenter mouseleave');
    } // 語言box


    if ($(this).width() > 992) {
      $(".h-lan").on('mouseenter', function () {
        $(this).addClass('showlanbx');
      }).on('mouseleave', function () {
        $(this).removeClass('showlanbx');
      });
    } else {
      $('.h-lan').off('mouseenter mouseleave');
    } // 清除連結(mo)


    if ($(this).width() < 992) {
      $('.moneh').attr("href", "javascript:;");
    }

    if ($(this).width() < 1200) {
      $('.nav_box li a').click(function () {
        $(this).next().addClass('shnextpage');
      });
      $('.prevar').click(function () {
        $(this).offsetParent().parent().removeClass('shnextpage');
        $(this).offsetParent().removeClass('shnextpage');
      });
      $('.moneh').click(function () {
        $(this).next().addClass('shnextpage');
      }); // ios 

      var iosh = $('.nav_box .nav-morebox>a');
      iosh.click(function () {
        $('.nav_box').removeClass('ioshead');
      });
      $('nav>ul>li>a').click(function () {
        $('.nav_box').addClass('ioshead');
      });
    }
  }).resize();
  /* ==========================================================================
            * header-menu
  ==========================================================================*/

  $('.menu-wrapper').on('click', function () {
    if (!$('.hamburger-menu').hasClass('animate')) {
      $('.hamburger-menu').addClass('animate');
      $('.hamburger-menu').removeClass('colsanimate');
      $('.nav_box').addClass('navop');
      $('.navopbg').addClass('navbgop');
      $('.header_box').addClass('open');
      $('body,html').css({
        'overflow': 'hidden'
      }).addClass('iostop');
      $('footer').css({
        'z-index': '-1'
      });
    } else {
      $('.hamburger-menu').addClass('colsanimate');
      $('.hamburger-menu').removeClass('animate');
      $('footer').removeAttr("style");
      $('.nav_box').removeClass('navop');
      $('.navopbg').removeClass('navbgop');
      $('.header_box').removeClass('open');
      $('body,html,.sub_menu').removeAttr("style").removeClass('iostop');
      $('.product_bottom').removeClass('active').removeAttr('style');
    }
  });
  /* ==========================================================================
                * imgLiquid
    ==========================================================================*/

  $('.itme-product').imgLiquid();
  /* ==========================================================================
               * circle
   ==========================================================================*/

  $('.ap-card ');
  /* ==========================================================================
                * scrollStyle
    ==========================================================================*/

  $('.r-text p , .l-card .tx-bx').mCustomScrollbar({
    theme: "dark"
  });
  $(window).on('scroll', function () {
    var scrollTop = $(this).scrollTop();
    var top = $('.top_btn');

    if (scrollTop > 99) {
      $('.header_show').addClass('chheader');
    } else {
      $('.header_show').removeClass('chheader');
    }

    if (scrollTop > 170) {
      top.addClass('show-topbtn');
    } else {
      top.removeClass('show-topbtn');
    }

    var footerH = $('footer').height();

    if ($(window).width() > 768) {
      if ($(window).scrollTop() >= $(document).height() - $(window).height() - 25) {
        $('.top_btn').addClass('fix');
      } else {
        $('.top_btn').removeClass('fix');
      }
    } else {
      if ($(window).scrollTop() >= $(document).height() - $(window).height() - 25) {
        $('.top_btn').removeClass('fix');
      } else {
        $('.top_btn').removeClass('fix');
      }
    }
  });
  /* ==========================================================================
                * top-btn
    ==========================================================================*/

  $(".top_btn").click(function () {
    $("html,body").animate({
      scrollTop: 0
    }, 1000, 'easeOutExpo');
    return false;
  });
  $(window).on('resize', function () {
    if ($(this).width() < 768) {
      $(".bot-op").click(function () {
        var tstop = $(this).offset().top - 50;
        $("html,body").animate({
          scrollTop: tstop
        }, 1, 'easeOutExpo');
        return false;
      });
    } else {}
  });
  /* ==========================================================================
    * banner
  ==========================================================================*/
  // 先宣告  (編號值,x,x)
  //初始化

  var bannerIndex = new Array();
  var nextIndex = new Array();
  var prevIndex = new Array();
  var alllength = new Array();
  var stopSlider = new Array();

  function setSlider(id, ele) {
    bannerIndex[id] = 0;
    nextIndex[id] = 0;
    prevIndex[id] = 0;
    alllength[id] = ele;
    stopSlider[id] = '';
  }

  function chbanner(id) {
    nextIndex[id] = bannerIndex[id] + 1;
    prevIndex[id] = bannerIndex[id] - 1;
    if (bannerIndex[id] == alllength[id] - 1) nextIndex[id] = 0;
    if (bannerIndex[id] == 0) prevIndex[id] = alllength[id] - 1; // 換圖開始

    switch (id) {
      case 1:
        $('.pc-banner .it').removeClass('chbanner').stop().fadeOut();
        $('.mo-banner .it').removeClass('chbanner').stop().fadeOut();
        $('.show-box .go-it').removeClass('show-me');
        $('.show-box .go-it').eq(bannerIndex[id]).addClass('show-me');
        $('.pc-banner .it').eq(bannerIndex[id]).addClass('chbanner').stop().fadeIn();
        $('.mo-banner .it').eq(bannerIndex[id]).addClass('chbanner').stop().fadeIn();
        $('.mo-show-box .go-it').removeClass('show-me');
        $('.mo-show-box .go-it').eq(bannerIndex[id]).addClass('show-me');
        break;

      case 2:
        $('.pc-banner2 .it').removeClass('chbanner').stop().fadeOut();
        $('.mo-banner2 .it').removeClass('chbanner').stop().fadeOut();
        $('.show-box2 .go-it').removeClass('show-me');
        $('.show-box2 .go-it').eq(bannerIndex[id]).addClass('show-me');
        $('.mo-show-box2 .go-it').removeClass('show-me');
        $('.mo-show-box2 .go-it').eq(bannerIndex[id]).addClass('show-me');
        $('.pc-banner2 .it').eq(bannerIndex[id]).addClass('chbanner').stop().fadeIn();
        $('.mo-banner2 .it').eq(bannerIndex[id]).addClass('chbanner').stop().fadeIn();
        break;
    } // 換圖結束


    bannerIndex[id] = nextIndex[id];
  }

  function makSlider(id, mode, type) {
    id = id || 1; // Slider編號

    mode = mode || 1; // 1:一開始觸發  2:左右按鍵  3: 豆豆

    type = type || 0; // 判斷左右時 1:左 2:右 / mode 3時 為索引值

    clearInterval(stopSlider[id]);

    switch (mode) {
      case 2:
        if (type == 1) bannerIndex[id] = prevIndex[id];else bannerIndex[id] = nextIndex[id];
        break;

      case 3:
        bannerIndex[id] = type;
        break;
    }

    chbanner(id);
    stopSlider[id] = setInterval(chbanner, 5000, id);
  } //宣告


  setSlider(1, $('.pc-banner .it').length);
  setSlider(2, $('.pc-banner2 .it').length);
  makSlider(1, 1);
  makSlider(2, 1);
  $('.go-it').click(function () {
    var goIndex = $(this).index();
    makSlider(1, 3, goIndex);
  });
  /* ==========================================================================
              * top-menu
  ==========================================================================*/

  $(window).on('resize', function () {
    //top menu
    if ($('#top-menu-ul').length > 0) {
      var menu_ul = $('#top-menu-ul ul').width();
      var menu_box = $('#top-menu-ul .item_menu_Box').width();
      $('#top-menu-ul').removeClass('open_flexslider');
      $('#top-menu-ul .slides').removeAttr('style');
      $('#top-menu-ul .item_menu_Box').removeAttr('style');

      if (menu_ul > menu_box) {
        $('#top-menu-ul').addClass('open_flexslider');
      }

      slider_ul_list();
    }
  }).resize();

  function slider_ul_list() {
    var newscroll = 0;
    var move = new Array();
    var total_width = 0;
    var i = 0;
    var sum = 0;
    var sumArray = new Array();
    var total = $("#top-menu-ul li");
    var active = $("#top-menu-ul .slides .active").index();
    total_width = $("#top-menu-ul ul").width(); //1043.4

    total.each(function () {
      move[i] = $(this).width();
      sum += move[i]; //move[i]紀錄每個按鈕的【寬度】(累加)

      sumArray[i] = sum;
      i++;
    });
    sum = Math.round((total_width - sum) / i);

    for (var j = 0; j < i; j++) {
      move[j] += sum;
    } //move[j]紀錄每個按鈕的【位置】


    sum = 0;

    for (var ac = 0; ac < active; ac++) {
      sum += move[ac];
    } //move[ac]當前按鈕的【位置】


    if ($('#top-menu-ul').hasClass('open_flexslider')) {
      var item_w = $("#top-menu-ul ul").width(); //ul 所有寬度

      var list_width = $('#top-menu-ul .item_menu_Box').width(); //按鈕外層       

      sum = sum > total_width - list_width ? total_width - list_width : sum; //判斷是否已經移動到最右邊   

      if (active > 0) {
        $('#top-menu-ul .item_menu_Box').scrollLeft(sum);
      } else {
        newscroll = 0;
      } //click用


      var j = 0;
      var move_total = 0;

      for (var ac = 0; ac <= active; ac++) {
        move_total = ac > 0 ? move_total + move[ac - 1] : 0;
        if (move_total > total_width - list_width) move_total = total_width - list_width;else j = ac;
      }

      ac - j > 1 ? j++ : "";
      move_total = Math.floor(move_total);
      $(".item_menu_Box").on('scroll', function () {
        newscroll = $('#top-menu-ul .item_menu_Box').scrollLeft();
      });
      $("#top-menu-ul .flex-next").on('click', function () {
        if (newscroll == move_total) {
          if (move_total < total_width - list_width && j < i) {
            j++;
            move_total = 0;

            for (var k = 0; k < j; k++) {
              move_total += move[k];
            }

            move_total = move_total > total_width - list_width ? total_width - list_width : move_total;
            move_total = Math.floor(move_total);
            $('#top-menu-ul .item_menu_Box').stop().animate({
              scrollLeft: move_total
            }, 600, 'easeOutExpo');
          }
        } else {
          var m_switch = 0;

          for (var k = 0; k < i; k++) {
            if (m_switch == 0 && newscroll < sumArray[k]) {
              m_switch = 1;
              move_total = Math.floor(sumArray[k]);
              $('#top-menu-ul .item_menu_Box').stop().animate({
                scrollLeft: move_total
              }, 600, 'easeOutExpo');
              j = k + 1;
            }
          }
        }

        return false;
      });
      $("#top-menu-ul .flex-prev").on('click', function () {
        if (newscroll == move_total) {
          if (move_total > 0 && j > 0) {
            j--;
            move_total = 0;

            for (var k = 0; k < j; k++) {
              move_total += move[k];
            }

            move_total = move_total > total_width - list_width ? total_width - list_width : move_total;
            move_total = Math.floor(move_total);
            $('#top-menu-ul .item_menu_Box').stop().animate({
              scrollLeft: move_total
            }, 600, 'easeOutExpo');
          }
        } else {
          var m_switch = 0;

          for (var k = j; k >= 0; k--) {
            if (m_switch == 0 && newscroll > sumArray[k]) {
              m_switch = 1;
              move_total = Math.floor(sumArray[k]);
              $('#top-menu-ul .item_menu_Box').stop().animate({
                scrollLeft: move_total
              }, 600, 'easeOutExpo');
              j = k + 1;
            }
          }
        }

        return false;
      });
    }
  }
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "../node_modules/jquery/dist/jquery.js")))

/***/ })

/******/ });
//# sourceMappingURL=scripts.js.map?200f1a73