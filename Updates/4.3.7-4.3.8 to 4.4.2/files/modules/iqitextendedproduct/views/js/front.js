/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
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
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	__webpack_require__(7);
	
	__webpack_require__(9);

/***/ }),
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }
	
	var _libThreesixtyThreesixtyMin = __webpack_require__(8);
	
	var _libThreesixtyThreesixtyMin2 = _interopRequireDefault(_libThreesixtyThreesixtyMin);
	
	$(document).ready(function () {
	    var threesixty;
	    var videoIframes = undefined,
	        $videoIframesWrapper = undefined,
	        $videoModal = $('#iqit-iqitvideos-modal'),
	        $threesixtyModal = $('#iqit-threesixty-modal');
	
	    $threesixtyModal.on('shown.bs.modal', function () {
	
	        var speed = 70;
	        if (typeof iqitextendedproduct.speed !== 'undefined') {
	            speed = iqitextendedproduct.speed;
	        }
	
	        if (typeof threesixty !== 'undefined') {
	            threesixty.autoplayStart();
	        } else {
	            threesixty = new _libThreesixtyThreesixtyMin2['default']({
	                element: '#iqit-threesixty',
	                images: $('#iqit-threesixty').data('threesixty'),
	                autoplay: true,
	                autoplaySpeed: speed,
	                stopAutoplayOnClick: true,
	                stopAutoplayOnMouseenter: true,
	                resumeAutoplayOnMouseleave: true,
	                resumeAutoplayDelay: 500
	            });
	            threesixty.load();
	        }
	    });
	
	    $threesixtyModal.on('hidden.bs.modal', function () {
	        threesixty.autoplayStop();
	    });
	
	    $videoModal.on('shown.bs.modal', function () {
	        $videoIframesWrapper = $('#iqitvideos-block');
	        videoIframes = $videoIframesWrapper.html();
	    });
	
	    $videoModal.on('hidden.bs.modal', function () {
	        $videoIframesWrapper.html(videoIframes);
	    });
	});

/***/ }),
/* 8 */
/***/ (function(module, exports) {

	/*
	  Tridi v1.2.0 - JavaScript 360 3D Product Viewer
	  Author: Lukasz Wojcik
	  License: MIT
	  Homepage: https://tridi.lukem.net
	  GitHub: http://github.com/lukemnet/tridi
	*/
	"use strict";
	
	var Tridi = (function () {
	  function t(t) {
	    var i = this;this.trigger = function (t) {
	      var e = i[t];e && e();
	    }, this.validate = function (t) {
	      t.element || console.error("'element' property is missing or invalid. Container element must be specified."), void 0 === t.images && void 0 === t.format && console.error("'format' property is missing or invalid. Image format must be provided for 'numbered' property."), "numbered" !== t.images || t.location || console.error("'location' property is missing or invalid. Image location must be provided for 'numbered' property.");
	    }, this.validate(t), this.element = t.element, this.images = t.images || "numbered", this.format = t.format || void 0, this.location = t.location || "./images", this.count = Array.isArray(this.images) ? this.images.length : t.count, this.draggable = void 0 === t.draggable || t.draggable, this.keys = t.keys || !1, this.hintOnStartup = t.hintOnStartup || !1, this.hintText = t.hintText || null, this.focusOnHintClose = t.focusOnHintClose || !1, this.lazy = t.lazy || !1, this.autoplay = t.autoplay || !1, this.autoplaySpeed = void 0 !== t.autoplaySpeed ? t.autoplaySpeed : 50, this.stopAutoplayOnClick = t.stopAutoplayOnClick || !1, this.stopAutoplayOnMouseenter = t.stopAutoplayOnMouseenter || !1, this.resumeAutoplayOnMouseleave = t.resumeAutoplayOnMouseleave || !1, this.resumeAutoplayDelay = t.resumeAutoplayDelay || 0, this.passive = void 0 === t.passive || t.passive, this.spinner = t.spinner || !1, this.touch = void 0 === t.touch || t.touch, this.mousewheel = t.mousewheel || !1, this.inverse = t.inverse || !1, this.dragInterval = t.dragInterval || 1, this.touchDragInterval = t.touchDragInterval || 2, this.mouseleaveDetect = t.mouseleaveDetect || !1, this.onViewerGenerate = t.onViewerGenerate || void 0, this.onViewerImageGenerate = t.onViewerImageGenerate || void 0, this.onViewerImageUpdate = t.onViewerImageUpdate || void 0, this.onHintShow = t.onHintShow || void 0, this.onHintHide = t.onHintHide || void 0, this.onLoadingScreenShow = t.onLoadingScreenShow || void 0, this.onLoadingScreenHide = t.onLoadingScreenHide || void 0, this.onImagesPreload = t.onImagesPreload || void 0, this.onAutoplayStart = t.onAutoplayStart || void 0, this.onAutoplayStop = t.onAutoplayStop || void 0, this.onNextMove = t.onNextMove || void 0, this.onPrevMove = t.onPrevMove || void 0, this.onNextFrame = t.onNextFrame || void 0, this.onPrevFrame = t.onPrevFrame || void 0, this.onDragStart = t.onDragStart || void 0, this.onDragEnd = t.onDragEnd || void 0, this.onLoad = t.onLoad || void 0, this.onUpdate = t.onUpdate || void 0, this.elementName = this.setElementName(), this.imageIndex = 1, this.moveBuffer = [], this.dragActive = !1, this.intervals = [], this.timeouts = [], this.stashedImgs = 0;
	  }return t.prototype.setElementName = function () {
	    var t = this.element;return "string" == typeof t ? t.substr(1) : t.getAttribute("id") ? t.getAttribute("id") : t.getAttribute("class") ? t.getAttribute("class").split(" ")[0] : "unnamedTridi-" + (Math.floor(9e4 * Math.random()) + 1e4);
	  }, t.prototype.validateUpdate = function (t) {
	    return !!(t.images || t.format || t.count || t.location) || (console.error("UpdatableOptions object doesn't contain options that can be updated."), !1);
	  }, t.prototype.updateOptions = function (e) {
	    var i = this;Object.keys(e).map(function (t) {
	      i[t] = e[t], "images" === t && e[t].constructor === Array && (i.count = e.images.length);
	    });
	  }, t.prototype.getElem = function (t) {
	    return "string" == typeof this.element ? t ? document.querySelector(this.element + " " + t) : document.querySelector(this.element) : this.element;
	  }, t.prototype.viewer = function () {
	    return this.getElem();
	  }, t.prototype.stash = function () {
	    return this.getElem(".tridi-stash");
	  }, t.prototype.getHintOverlay = function () {
	    return this.getElem(".tridi-hint-overlay");
	  }, t.prototype.getLoadingScreen = function () {
	    return this.getElem(".tridi-loading");
	  }, t.prototype.image = function (t) {
	    return this.imgs()[t - 1];
	  }, t.prototype.viewerImage = function () {
	    return this.getElem(".tridi-viewer-image");
	  }, t.prototype.lazyLoad = function (t, e) {
	    this.lazy && !e ? (this.viewerImage().addEventListener("click", t), this.touch && this.viewerImage().addEventListener("touchstart", t, { passive: this.passive })) : t();
	  }, t.prototype.imgs = function () {
	    var i = this;return "numbered" === this.images ? Array.apply(null, { length: this.count }).map(function (t, e) {
	      return i.location + "/" + (e + 1) + "." + i.format.toLowerCase();
	    }) : this.images;
	  }, t.prototype.generateViewer = function () {
	    this.viewer().className += " tridi-viewer tridi-" + this.elementName + "-viewer tridi-draggable-" + this.draggable + " tridi-touch-" + this.touch + " tridi-mousewheel-" + this.mousewheel + " tridi-hintOnStartup-" + this.hintOnStartup + " tridi-lazy-" + this.lazy, this.trigger("onViewerGenerate");
	  }, t.prototype.generateLoadingScreen = function () {
	    var t = document.createElement("div");t.className += "tridi-loading tridi-" + this.elementName + "-loading", t.style.display = "none";var e = document.createElement("div");e.className += "tridi-spinner tridi-" + this.elementName + "-spinner", t.appendChild(e), this.viewer().appendChild(t);
	  }, t.prototype.setLoadingState = function (t, e) {
	    this.getLoadingScreen().style.display = t ? "block" : "none", e || this.trigger(t ? "onLoadingScreenShow" : "onLoadingScreenHide");
	  }, t.prototype.generateStash = function () {
	    if (!this.stash()) {
	      this.stashedImgs = 0;var t = document.createElement("div");t.style.display = "none", t.classList.add("tridi-stash"), this.viewer().appendChild(t);
	    }
	  }, t.prototype.destroyStash = function () {
	    this.stashedImgs = 0, this.stash().parentNode.removeChild(this.stash());
	  }, t.prototype.displayHintOnStartup = function (n) {
	    var _this = this;
	
	    var o = this;if (this.hintOnStartup) {
	      var s, t;
	      var a, e;
	
	      (function () {
	        var i = function i(t) {
	          var e = t.target.classList.contains(s),
	              i = t.target.classList.contains(a);(e || i) && (o.getHintOverlay().style.display = "none", n(), o.focusOnHintClose && o.viewerImage().focus(), o.trigger("onHintHide"));
	        };
	
	        s = "tridi-" + _this.elementName + "-hint-overlay";
	        t = document.createElement("div");
	        t.className += "tridi-hint-overlay " + s, t.tabIndex = 0;a = "tridi-" + _this.elementName + "-hint";
	        e = document.createElement("div");
	        e.className += "tridi-hint " + a, _this.hintText && (e.innerHTML = '<span class="tridi-hint-text tridi-' + _this.elementName + '-hint-text">' + _this.hintText + "</span>"), t.appendChild(e), _this.viewer().appendChild(t), _this.trigger("onHintShow");document.addEventListener("click", i), _this.touch && document.addEventListener("touchstart", i), document.addEventListener("keydown", function (t) {
	          "Enter" === t.key && i(t);
	        });
	      })();
	    } else n();
	  }, t.prototype.stashImage = function (t, e, i, n) {
	    var o = new Image();o.onload = n.bind(this), o.className += "tridi-image tridi-image-" + (i + 1), o.src = e, t.innerHTML += o.outerHTML;
	  }, t.prototype.populateStash = function () {
	    var i = this,
	        n = this.stash(),
	        o = this.imgs();n && o && o.map(function (t, e) {
	      i.stashImage(n, t, e, function () {
	        i.stashedImgs += 1, i.stashedImgs === o.length && (i.setLoadingState(!1, !0), i.trigger("onImagesPreload"));
	      });
	    });
	  }, t.prototype.generateViewerImage = function () {
	    var t = this,
	        e = this.viewer(),
	        i = new Image();i.onload = function () {
	      return t.trigger("onViewerImageGenerate");
	    }, i.className += "tridi-viewer-image tridi-" + this.elementName + "-viewer-image", i.setAttribute("draggable", "false"), i.setAttribute("alt", ""), i.src = this.image(1), e.innerHTML = "" + i.outerHTML + e.innerHTML;
	  }, t.prototype.updateViewerImage = function (t) {
	    var e = this;this.viewerImage().onload = function () {
	      return e.trigger("onViewerImageUpdate");
	    }, this.viewerImage().src = this.image(t);
	  }, t.prototype.nextFrame = function () {
	    this.imageIndex = this.imageIndex <= 1 ? this.count : this.imageIndex - 1, this.viewerImage().src = this.image(this.imageIndex), this.trigger("onNextFrame");
	  }, t.prototype.prevFrame = function () {
	    this.imageIndex = this.imageIndex >= this.count ? 1 : this.imageIndex + 1, this.viewerImage().src = this.image(this.imageIndex), this.trigger("onPrevFrame");
	  }, t.prototype.nextMove = function () {
	    return this.trigger("onNextMove"), this.inverse ? this.prevFrame() : this.nextFrame();
	  }, t.prototype.prevMove = function () {
	    return this.trigger("onPrevMove"), this.inverse ? this.nextFrame() : this.prevFrame();
	  }, t.prototype.rotateViewerImage = function (t) {
	    var e = t.touches ? this.touchDragInterval : this.dragInterval,
	        i = (t.touches ? t.touches[0].clientX : t.clientX) - this.viewerImage().offsetLeft;if (this.moveBuffer.length < 2) this.moveBuffer.push(i);else {
	      var n = this.moveBuffer[1];this.moveBuffer[1] = i, this.moveBuffer[0] = n;
	    }var o = !(i % e),
	        s = this.moveBuffer[0],
	        a = this.moveBuffer[1];o && a < s ? this.nextMove() : o && s < a && this.prevMove();
	  }, t.prototype.startDragging = function () {
	    this.dragActive = !0, this.viewer().classList.add("tridi-dragging"), this.trigger("onDragStart");
	  }, t.prototype.stopDragging = function () {
	    this.dragActive = !1, this.viewer().classList.remove("tridi-dragging"), this.trigger("onDragEnd");
	  }, t.prototype.resetMoveBuffer = function () {
	    this.moveBuffer.length = 0;
	  }, t.prototype.attachCosmeticEvents = function () {
	    var t = this.viewer();t.addEventListener("mouseenter", function () {
	      return t.classList.add("tridi-viewer-hovered");
	    }), t.addEventListener("mouseleave", function () {
	      return t.classList.remove("tridi-viewer-hovered");
	    });
	  }, t.prototype.attachDragEvents = function () {
	    var e = this;if (this.draggable) {
	      var t = this.viewerImage();t.addEventListener("mousedown", function (t) {
	        t.preventDefault && t.preventDefault(), e.startDragging(), e.rotateViewerImage(t);
	      }), t.addEventListener("mouseup", function (t) {
	        t.preventDefault && t.preventDefault(), e.stopDragging(), e.resetMoveBuffer();
	      }), t.addEventListener("mousemove", function (t) {
	        e.dragActive && e.rotateViewerImage(t);
	      }), t.addEventListener("mouseleave", function () {
	        e.resetMoveBuffer();
	      });
	    }
	  }, t.prototype.attachMouseLeaveDetection = function () {
	    var t = this;this.mouseleaveDetect && this.viewer().addEventListener("mouseleave", function () {
	      t.stopDragging(), t.resetMoveBuffer();
	    });
	  }, t.prototype.attachTouchEvents = function () {
	    var e = this;if (this.touch) {
	      var t = this.viewerImage();t.addEventListener("touchstart", function (t) {
	        e.startDragging(), e.rotateViewerImage(t);
	      }, { passive: !0 }), t.addEventListener("touchmove", function (t) {
	        e.rotateViewerImage(t);
	      }, { passive: !0 }), t.addEventListener("touchend", function () {
	        e.stopDragging(), e.resetMoveBuffer();
	      });
	    }
	  }, t.prototype.attachMousewheelEvents = function () {
	    var e = this;this.mousewheel && this.viewerImage().addEventListener("wheel", function (t) {
	      t.preventDefault && !e.passive && t.preventDefault(), 0 < t.deltaY / 120 ? e.nextMove() : e.prevMove();
	    }, { passive: this.passive });
	  }, t.prototype.attachKeyEvents = function () {
	    var e = this;this.keys && (this.viewerImage().setAttribute("tabindex", "0"), this.viewerImage().addEventListener("keydown", function (t) {
	      "ArrowLeft" === t.key && e.prevMove(), "ArrowRight" === t.key && e.nextMove();
	    }));
	  }, t.prototype.clearIntervals = function () {
	    this.intervals.map(clearInterval), this.intervals.length = 0;
	  }, t.prototype.setAutoplayInterval = function () {
	    var t = window.setInterval(this.nextMove.bind(this), this.autoplaySpeed);this.intervals.push(t);
	  }, t.prototype.clearTimeouts = function () {
	    this.timeouts.map(clearTimeout), this.timeouts.length = 0;
	  }, t.prototype.setAutoplayTimeout = function () {
	    var t = window.setTimeout(this.setAutoplayInterval.bind(this), this.resumeAutoplayDelay);this.timeouts.push(t);
	  }, t.prototype.toggleAutoplay = function (t, e) {
	    t ? (this.clearTimeouts(), 0 === this.intervals.length && (e ? this.setAutoplayInterval() : this.setAutoplayTimeout())) : this.clearIntervals(), this.trigger(t ? "onAutoplayStart" : "onAutoplayStop");
	  }, t.prototype.stopAutoplaySequence = function () {
	    this.clearTimeouts(), this.toggleAutoplay(!1);
	  }, t.prototype.startAutoplay = function () {
	    var e = this;if (this.autoplay) {
	      var _t2 = function t(_t) {
	        _t.target.classList.contains("tridi-btn") || e.toggleAutoplay(!0);
	      };
	
	      this.toggleAutoplay(!0, !0), this.stopAutoplayOnClick && (this.viewerImage().addEventListener("mousedown", this.stopAutoplaySequence.bind(this)), this.touch && this.viewerImage().addEventListener("touchstart", this.stopAutoplaySequence.bind(this), { passive: this.passive })), this.stopAutoplayOnMouseenter && this.viewerImage().addEventListener("mouseenter", this.stopAutoplaySequence.bind(this));if (this.resumeAutoplayOnMouseleave) {
	        var i = this.viewerImage();i.addEventListener("mouseleave", _t2), this.touch && i.addEventListener("touchend", _t2);
	      }
	    }
	  }, t.prototype.attachEvents = function () {
	    this.attachCosmeticEvents(), this.attachDragEvents(), this.attachMouseLeaveDetection(), this.attachTouchEvents(), this.attachMousewheelEvents(), this.attachKeyEvents();
	  }, t.prototype.start = function () {
	    var t = this;this.generateViewer(), this.generateLoadingScreen(), this.setLoadingState(!0), this.generateViewerImage(), this.setLoadingState(!1), this.displayHintOnStartup(function () {
	      t.lazyLoad(function () {
	        t.setLoadingState(!0), t.generateStash(), t.populateStash(), t.attachEvents(), t.startAutoplay(), t.setLoadingState(!1);
	      });
	    }), this.trigger("onLoad");
	  }, t.prototype.next = function () {
	    this.nextMove();
	  }, t.prototype.prev = function () {
	    this.prevMove();
	  }, t.prototype.autoplayStart = function () {
	    this.toggleAutoplay(!0);
	  }, t.prototype.autoplayStop = function () {
	    this.toggleAutoplay(!1);
	  }, t.prototype.update = function (t, e) {
	    this.validateUpdate(t) && (this.setLoadingState(!0), this.updateOptions(t), this.destroyStash(), this.generateStash(), this.populateStash(), this.updateViewerImage(e ? this.imageIndex : 1), this.attachEvents(), this.setLoadingState(!1), this.trigger("onUpdate"));
	  }, t.prototype.load = function () {
	    this.start();
	  }, t;
	})();"undefined" != typeof module && (module.exports = Tridi);

/***/ }),
/* 9 */
/***/ (function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);
//# sourceMappingURL=front.js.map