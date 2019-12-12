jQuery(document).ready(function ($) {


    /* Check if already scrolled or navigation is hovered */
    var mainHeader = $("#main-header");

    //set scrolling variables
    var scrolling = false,
        previousTop = 0,
        currentTop = 0,
        scrollDelta = 1,
        scrollOffset = 60;

    $(window).on('scroll', function () {
        if (!scrolling) {
            scrolling = true;
            (!window.requestAnimationFrame)
                ? setTimeout(autoHideHeader, 250)
                : requestAnimationFrame(autoHideHeader);
        }
    });


    $(window).focus(function(e) {
        mainHeader.removeClass('is-hidden');
    });

    function autoHideHeader() {
        var currentTop = $(window).scrollTop();
        checkSimpleNavigation(currentTop);
        previousTop = currentTop;
        scrolling = false;
    }

    function checkSimpleNavigation(currentTop) {

        /* Check if menu is hovered */
        var hovered = $(".lh_custom_nav").find("li:hover").length > 0;
        var visibleMenu = $('#lh_mobile_nav_menu').hasClass('lh_mobile_nav_menu--visible');

        if(hovered || visibleMenu != false) {
            return;
        }

        //there's no secondary nav or secondary nav is below primary nav
        if (previousTop - currentTop > scrollDelta ) {
            //if scrolling up...

            mainHeader.closest('.header-wrap').removeClass('header-hidden');
            mainHeader.removeClass('is-hidden');
        } else if (currentTop - previousTop > scrollDelta && currentTop > scrollOffset) {
            //if scrolling down...
            mainHeader.addClass('is-hidden');
            mainHeader.closest('.header-wrap').addClass('header-hidden');
        }
    }


    //add link
    function appendExpandButton() {
        $('.material-options__list ul').each(function () {
            var listLength = $(this).find('li').length;
            $(this).find('li').eq(listLength-2).append('<button class="js-expand-list">' + lhtranslation.material_expand +' </button>');
            $(this).find('li').eq(listLength-2).addClass('material-options__item--has--button');
        })
    }

    //expand
    function expandMaterialsList(){
        $(document).on('click', '.js-expand-list', function(){
            $('.material-options__list').addClass('material-options__list--expanded');
            $('.material-options__item--has--button').remove();
        });
    }


    //calculate remanining space
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };


    function setExcerptHeight() {
        var posts = $('.home-news--regular .et_pb_post, .home-news--featured .et_pb_post');

        posts.each(function () {

            var post = $(this);
            var postTitle = post.find('.entry-title');
            var postMeta = post.find('.post-meta');

            //calculate height
            var postHeight = post.height();
            var titleHeight = postTitle.height();
            var postMetaHeight = post.find('.post-meta').height();
            var postImageHeight = post.find('.entry-featured-image-url').length > 0 ? post.find('.entry-featured-image-url').outerHeight() : 0;


            var remaniningHeight = postHeight - postImageHeight - titleHeight - postMetaHeight;

            if($(this).closest('.home-news--featured').length > 0) {
                post.find('.post-content').attr('data-height', remaniningHeight);
                post.find('.post-content').height(remaniningHeight-40);
            }
            else {
                post.find('.post-content').attr('data-height', remaniningHeight-4);
                post.find('.post-content').height(remaniningHeight-4);
            }

            var p = post.find('.post-content p');
            var divh = post.find('.post-content').height();

            shave(p, divh);

            /** Click on the whole card */
            var cardHref = postTitle.find('a').attr('href');
            post.on('click', function (e) {

                if(e.ctrlKey || e.metaKey) {
                    window.open(cardHref, '_blank');
                    return false;
                }

                var sel = getSelection().toString();
                if(!sel){
                    window.location = cardHref;
                }
            });

        });
    }

    var debouncedSetExcerptHeight = debounce(setExcerptHeight, 500);
     $(window).on('load', function () {
        setExcerptHeight();
    });


    expandMaterialsList();
    appendExpandButton();
    
    
    $(window).on('resize', debouncedSetExcerptHeight);


    /*** Wrap ul into container ***/
    $( ".sub-menu" ).wrap( "<div class='sub-menu-wrap'></div>" );

    /* Vote band */
    if(Cookies.get('band-closed') != 'true') {

        $('body').addClass('band-visible')
        $('.band').addClass('band--visible');

        //close vote band
        $('.band button').on('click', function () {
            Cookies.set('band-closed', 'true');
            $('.band').remove();
            $('body').removeClass('band-visible');


            // mobileMenuOffset()
        });
    } else {
        $('.band').remove();
    }

    /* Submenu click */
    $('.lh-sub-menu li').on('click', function (e) {

        var linkHref = $(this).find('a').attr('href');

        if(e.ctrlKey || e.metaKey) {
            window.open(linkHref, '_blank');
            return false;
        }

        var sel = getSelection().toString();
        if(!sel){
            window.location = linkHref;
        }
    });


    $('.mobile_menu_bar').on('click', function (e) {

        if(!$('#lh_mobile_nav_menu').hasClass('lh_mobile_nav_menu--visible')) {
            scrollLock.disablePageScroll();
        } else {
            scrollLock.enablePageScroll();
        }
        $('#lh_mobile_nav_menu').toggleClass('lh_mobile_nav_menu--visible');
    });

    $(window).on('resize', function () {
        if($('.lh_mobile_nav_menu--visible').is(":visible") == false) {
            scrollLock.enablePageScroll();
        }
    });


    $('.lh_custom_mobile_nav > .menu-item-has-children > a ').on('click', function (e) {
        e.preventDefault();
        $(this).closest('.menu-item-has-children').toggleClass('menu-item--expanded');
    });


    /*** Accordion ***/
    $('.lh-accordion__title button').on('click', function(){
        if($(this).attr('aria-expanded') == 'false') {

            $('.lh-accordion--expanded').find('button').attr('aria-expanded', 'false');
            $('.lh-accordion--expanded').removeClass('lh-accordion--expanded');

            $(this).attr('aria-expanded', 'true');
            $(this).closest('.lh-accordion__item').addClass('lh-accordion--expanded');
        } else {
            $(this).attr('aria-expanded', 'false');
            $(this).closest('.lh-accordion__item').removeClass('lh-accordion--expanded');
        }
    });


});



/* scroll lock */
!function(e,t){"object"==typeof exports&&"object"==typeof module?module.exports=t():"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?exports.scrollLock=t():e.scrollLock=t()}(this,function(){return function(l){var o={};function r(e){if(o[e])return o[e].exports;var t=o[e]={i:e,l:!1,exports:{}};return l[e].call(t.exports,t,t.exports,r),t.l=!0,t.exports}return r.m=l,r.c=o,r.d=function(e,t,l){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:l})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(t,e){if(1&e&&(t=r(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var l=Object.create(null);if(r.r(l),Object.defineProperty(l,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)r.d(l,o,function(e){return t[e]}.bind(null,o));return l},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=0)}([function(e,t,l){"use strict";l.r(t);var o=function(e){return Array.isArray(e)?e:[e]},a=function(e){return e instanceof Node},r=function(e,t){if(e&&t){e=e instanceof NodeList?e:[e];for(var l=0;l<e.length&&!0!==t(e[l],l,e.length);l++);}},n=function(e){return console.error("[scroll-lock] ".concat(e))},h=function(e){if(Array.isArray(e))return e.join(", ")},c=function(e){var t=[];return r(e,function(e){return t.push(e)}),t},v=function(e,t){var l=!(2<arguments.length&&void 0!==arguments[2])||arguments[2],o=3<arguments.length&&void 0!==arguments[3]?arguments[3]:document;if(l&&-1!==c(o.querySelectorAll(t)).indexOf(e))return e;for(;(e=e.parentElement)&&-1===c(o.querySelectorAll(t)).indexOf(e););return e},b=function(e,t){var l=2<arguments.length&&void 0!==arguments[2]?arguments[2]:document;return-1!==c(l.querySelectorAll(t)).indexOf(e)},i=function(e){if(e)return"hidden"===getComputedStyle(e).overflow},S=function(e){if(e)return!!i(e)||e.scrollTop<=0},m=function(e){if(e){if(i(e))return!0;var t=e.scrollTop;return e.scrollHeight<=t+e.offsetHeight}},y=function(e){if(e)return!!i(e)||e.scrollLeft<=0},k=function(e){if(e){if(i(e))return!0;var t=e.scrollLeft;return e.scrollWidth<=t+e.offsetWidth}};l.d(t,"disablePageScroll",function(){return d}),l.d(t,"enablePageScroll",function(){return s}),l.d(t,"getScrollState",function(){return f}),l.d(t,"clearQueueScrollLocks",function(){return p}),l.d(t,"getTargetScrollBarWidth",function(){return g}),l.d(t,"getCurrentTargetScrollBarWidth",function(){return w}),l.d(t,"getPageScrollBarWidth",function(){return G}),l.d(t,"getCurrentPageScrollBarWidth",function(){return F}),l.d(t,"addScrollableTarget",function(){return T}),l.d(t,"removeScrollableTarget",function(){return P}),l.d(t,"addScrollableSelector",function(){return O}),l.d(t,"removeScrollableSelector",function(){return W}),l.d(t,"addLockableTarget",function(){return Y}),l.d(t,"addLockableSelector",function(){return x}),l.d(t,"setFillGapMethod",function(){return E}),l.d(t,"addFillGapTarget",function(){return j}),l.d(t,"removeFillGapTarget",function(){return M}),l.d(t,"addFillGapSelector",function(){return q}),l.d(t,"removeFillGapSelector",function(){return C}),l.d(t,"refillGaps",function(){return A});var u=["padding","margin","width","max-width","none"],L={scroll:!0,queue:0,scrollableSelectors:["[data-scroll-lock-scrollable]"],lockableSelectors:["body","[data-scroll-lock-lockable]"],fillGapSelectors:["body","[data-scroll-lock-fill-gap]","[data-scroll-lock-lockable]"],fillGapMethod:u[0],startTouchY:0,startTouchX:0},d=function(e){L.queue<=0&&(L.scroll=!1,N(),I()),T(e),L.queue++},s=function(e){0<L.queue&&L.queue--,L.queue<=0&&(L.scroll=!0,B(),X()),P(e)},f=function(){return L.scroll},p=function(){L.queue=0},g=function(e){var t=1<arguments.length&&void 0!==arguments[1]&&arguments[1];if(a(e)){var l=e.style.overflowY;t?f()||(e.style.overflowY=e.dataset.scrollLockSavedOverflowYProperty):e.style.overflowY="scroll";var o=w(e);return e.style.overflowY=l,o}return 0},w=function(e){if(a(e)){if(e===document.body){var t=document.documentElement.clientWidth;return window.innerWidth-t}var l=e.style.borderLeftWidth,o=e.style.borderRightWidth;e.style.borderLeftWidth="0px",e.style.borderRightWidth="0px";var r=e.offsetWidth-e.clientWidth;return e.style.borderLeftWidth=l,e.style.borderRightWidth=o,r}return 0},G=function(){var e=0<arguments.length&&void 0!==arguments[0]&&arguments[0];return g(document.body,e)},F=function(){return w(document.body)},T=function(e){e&&o(e).map(function(e){r(e,function(e){a(e)?e.dataset.scrollLockScrollable="":n('"'.concat(e,'" is not a Element.'))})})},P=function(e){e&&o(e).map(function(e){r(e,function(e){a(e)?delete e.dataset.scrollLockScrollable:n('"'.concat(e,'" is not a Element.'))})})},O=function(e){e&&o(e).map(function(e){L.scrollableSelectors.push(e)})},W=function(e){e&&o(e).map(function(t){L.scrollableSelectors=L.scrollableSelectors.filter(function(e){return e!==t})})},Y=function(e){e&&(o(e).map(function(e){r(e,function(e){a(e)?e.dataset.scrollLockLockable="":n('"'.concat(e,'" is not a Element.'))})}),f()||N())},x=function(e){e&&(o(e).map(function(e){L.lockableSelectors.push(e)}),f()||N(),q(e))},E=function(e){if(e)if(-1!==u.indexOf(e))L.fillGapMethod=e,A();else{var t=u.join(", ");n('"'.concat(e,'" method is not available!\nAvailable fill gap methods: ').concat(t,"."))}},j=function(e){e&&o(e).map(function(e){r(e,function(e){a(e)?(e.dataset.scrollLockFillGap="",L.scroll||D(e)):n('"'.concat(e,'" is not a Element.'))})})},M=function(e){e&&o(e).map(function(e){r(e,function(e){a(e)?(delete e.dataset.scrollLockFillGap,L.scroll||z(e)):n('"'.concat(e,'" is not a Element.'))})})},q=function(e){e&&o(e).map(function(e){L.fillGapSelectors.push(e),L.scroll||Q(e)})},C=function(e){e&&o(e).map(function(t){L.fillGapSelectors=L.fillGapSelectors.filter(function(e){return e!==t}),L.scroll||H(t)})},A=function(){L.scroll||I()},N=function(){var e=h(L.lockableSelectors);K(e)},B=function(){var e=h(L.lockableSelectors);R(e)},K=function(e){var t=document.querySelectorAll(e);r(t,function(e){U(e)})},R=function(e){var t=document.querySelectorAll(e);r(t,function(e){_(e)})},U=function(e){if(a(e)&&"true"!==e.dataset.scrollLockLocked){var t=window.getComputedStyle(e);e.dataset.scrollLockSavedOverflowYProperty=t.overflowY,e.dataset.scrollLockSavedInlineOverflowProperty=e.style.overflow,e.dataset.scrollLockSavedInlineOverflowYProperty=e.style.overflowY,e.style.overflow="hidden",e.dataset.scrollLockLocked="true"}},_=function(e){a(e)&&"true"===e.dataset.scrollLockLocked&&(e.style.overflow=e.dataset.scrollLockSavedInlineOverflowProperty,e.style.overflowY=e.dataset.scrollLockSavedInlineOverflowYProperty,delete e.dataset.scrollLockSavedOverflowYProperty,delete e.dataset.scrollLockSavedInlineOverflowProperty,delete e.dataset.scrollLockSavedInlineOverflowYProperty,delete e.dataset.scrollLockLocked)},I=function(){L.fillGapSelectors.map(function(e){Q(e)})},X=function(){L.fillGapSelectors.map(function(e){H(e)})},Q=function(e){var t=document.querySelectorAll(e),l=-1!==L.lockableSelectors.indexOf(e);r(t,function(e){D(e,l)})},D=function(e){var t=1<arguments.length&&void 0!==arguments[1]&&arguments[1];if(a(e)){var l;if(""===e.dataset.scrollLockLockable||t)l=g(e,!0);else{var o=v(e,h(L.lockableSelectors));l=g(o,!0)}"true"===e.dataset.scrollLockFilledGap&&z(e);var r=window.getComputedStyle(e);if(e.dataset.scrollLockFilledGap="true",e.dataset.scrollLockCurrentFillGapMethod=L.fillGapMethod,"margin"===L.fillGapMethod){var n=parseFloat(r.marginRight);e.style.marginRight="".concat(n+l,"px")}else if("width"===L.fillGapMethod)e.style.width="calc(100% - ".concat(l,"px)");else if("max-width"===L.fillGapMethod)e.style.maxWidth="calc(100% - ".concat(l,"px)");else if("padding"===L.fillGapMethod){var c=parseFloat(r.paddingRight);e.style.paddingRight="".concat(c+l,"px")}}},H=function(e){var t=document.querySelectorAll(e);r(t,function(e){z(e)})},z=function(e){if(a(e)&&"true"===e.dataset.scrollLockFilledGap){var t=e.dataset.scrollLockCurrentFillGapMethod;delete e.dataset.scrollLockFilledGap,delete e.dataset.scrollLockCurrentFillGapMethod,"margin"===t?e.style.marginRight="":"width"===t?e.style.width="":"max-width"===t?e.style.maxWidth="":"padding"===t&&(e.style.paddingRight="")}};"undefined"!=typeof window&&window.addEventListener("resize",function(e){A()}),"undefined"!=typeof document&&(document.addEventListener("touchstart",function(e){L.scroll||(L.startTouchY=e.touches[0].clientY,L.startTouchX=e.touches[0].clientX)}),document.addEventListener("touchmove",function(n){if(!L.scroll){var e=L.startTouchY,t=L.startTouchX,l=n.touches[0].clientY,o=n.touches[0].clientX;if(n.touches.length<2){var c=h(L.scrollableSelectors),a=e<l,i=l<e,u=t<o,d=o<t,s=e+3<l,f=l<e-3,p=t+3<o,g=o<t-3;!function e(t){var l=1<arguments.length&&void 0!==arguments[1]&&arguments[1];if(t){var o=v(t,c,!1);if(b(t,'input[type="range"]'))return!1;if(l||b(t,'textarea, [contenteditable="true"]')&&v(t,c)||b(t,c)){var r=!1;y(t)&&k(t)?(a&&S(t)||i&&m(t))&&(r=!0):S(t)&&m(t)?(u&&y(t)||d&&k(t))&&(r=!0):(s&&S(t)||f&&m(t)||p&&y(t)||g&&k(t))&&(r=!0),r&&(o?e(o,!0):n.preventDefault())}else e(o)}else n.preventDefault()}(n.target)}}},{passive:!1}),document.addEventListener("touchend",function(e){L.scroll||(L.startTouchY=0,L.startTouchX=0)}));var J={hide:function(e){n('"hide" is deprecated! Use "disablePageScroll" instead. \n https://github.com/FL3NKEY/scroll-lock#disablepagescrollscrollabletarget'),d(e)},show:function(e){n('"show" is deprecated! Use "enablePageScroll" instead. \n https://github.com/FL3NKEY/scroll-lock#enablepagescrollscrollabletarget'),s(e)},toggle:function(e){n('"toggle" is deprecated! Do not use it.'),f()?d():s(e)},getState:function(){return n('"getState" is deprecated! Use "getScrollState" instead. \n https://github.com/FL3NKEY/scroll-lock#getscrollstate'),f()},getWidth:function(){return n('"getWidth" is deprecated! Use "getPageScrollBarWidth" instead. \n https://github.com/FL3NKEY/scroll-lock#getpagescrollbarwidth'),G()},getCurrentWidth:function(){return n('"getCurrentWidth" is deprecated! Use "getCurrentPageScrollBarWidth" instead. \n https://github.com/FL3NKEY/scroll-lock#getcurrentpagescrollbarwidth'),F()},setScrollableTargets:function(e){n('"setScrollableTargets" is deprecated! Use "addScrollableTarget" instead. \n https://github.com/FL3NKEY/scroll-lock#addscrollabletargetscrollabletarget'),T(e)},setFillGapSelectors:function(e){n('"setFillGapSelectors" is deprecated! Use "addFillGapSelector" instead. \n https://github.com/FL3NKEY/scroll-lock#addfillgapselectorfillgapselector'),q(e)},setFillGapTargets:function(e){n('"setFillGapTargets" is deprecated! Use "addFillGapTarget" instead. \n https://github.com/FL3NKEY/scroll-lock#addfillgaptargetfillgaptarget'),j(e)},clearQueue:function(){n('"clearQueue" is deprecated! Use "clearQueueScrollLocks" instead. \n https://github.com/FL3NKEY/scroll-lock#clearqueuescrolllocks'),p()}},V=function(r){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{},t=Object.keys(n);"function"==typeof Object.getOwnPropertySymbols&&(t=t.concat(Object.getOwnPropertySymbols(n).filter(function(e){return Object.getOwnPropertyDescriptor(n,e).enumerable}))),t.forEach(function(e){var t,l,o;t=r,o=n[l=e],l in t?Object.defineProperty(t,l,{value:o,enumerable:!0,configurable:!0,writable:!0}):t[l]=o})}return r}({disablePageScroll:d,enablePageScroll:s,getScrollState:f,clearQueueScrollLocks:p,getTargetScrollBarWidth:g,getCurrentTargetScrollBarWidth:w,getPageScrollBarWidth:G,getCurrentPageScrollBarWidth:F,addScrollableSelector:O,removeScrollableSelector:W,addScrollableTarget:T,removeScrollableTarget:P,addLockableSelector:x,addLockableTarget:Y,addFillGapSelector:q,removeFillGapSelector:C,addFillGapTarget:j,removeFillGapTarget:M,setFillGapMethod:E,refillGaps:A,_state:L},J);t.default=V}]).default});

/* Cookies */
// /** cookies **/
//
/*!
 * JavaScript Cookie v2.2.0
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;(function (factory) {
    var registeredInModuleLoader;
    if (typeof define === 'function' && define.amd) {
        define(factory);
        registeredInModuleLoader = true;
    }
    if (typeof exports === 'object') {
        module.exports = factory();
        registeredInModuleLoader = true;
    }
    if (!registeredInModuleLoader) {
        var OldCookies = window.Cookies;
        var api = window.Cookies = factory();
        api.noConflict = function () {
            window.Cookies = OldCookies;
            return api;
        };
    }
}(function () {
    function extend () {
        var i = 0;
        var result = {};
        for (; i < arguments.length; i++) {
            var attributes = arguments[ i ];
            for (var key in attributes) {
                result[key] = attributes[key];
            }
        }
        return result;
    }

    function decode (s) {
        return s.replace(/(%[0-9A-Z]{2})+/g, decodeURIComponent);
    }

    function init (converter) {
        function api() {}

        function set (key, value, attributes) {
            if (typeof document === 'undefined') {
                return;
            }

            attributes = extend({
                path: '/'
            }, api.defaults, attributes);

            if (typeof attributes.expires === 'number') {
                attributes.expires = new Date(new Date() * 1 + attributes.expires * 864e+5);
            }

            // We're using "expires" because "max-age" is not supported by IE
            attributes.expires = attributes.expires ? attributes.expires.toUTCString() : '';

            try {
                var result = JSON.stringify(value);
                if (/^[\{\[]/.test(result)) {
                    value = result;
                }
            } catch (e) {}

            value = converter.write ?
                converter.write(value, key) :
                encodeURIComponent(String(value))
                    .replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);

            key = encodeURIComponent(String(key))
                .replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent)
                .replace(/[\(\)]/g, escape);

            var stringifiedAttributes = '';
            for (var attributeName in attributes) {
                if (!attributes[attributeName]) {
                    continue;
                }
                stringifiedAttributes += '; ' + attributeName;
                if (attributes[attributeName] === true) {
                    continue;
                }

                // Considers RFC 6265 section 5.2:
                // ...
                // 3.  If the remaining unparsed-attributes contains a %x3B (";")
                //     character:
                // Consume the characters of the unparsed-attributes up to,
                // not including, the first %x3B (";") character.
                // ...
                stringifiedAttributes += '=' + attributes[attributeName].split(';')[0];
            }

            return (document.cookie = key + '=' + value + stringifiedAttributes);
        }

        function get (key, json) {
            if (typeof document === 'undefined') {
                return;
            }

            var jar = {};
            // To prevent the for loop in the first place assign an empty array
            // in case there are no cookies at all.
            var cookies = document.cookie ? document.cookie.split('; ') : [];
            var i = 0;

            for (; i < cookies.length; i++) {
                var parts = cookies[i].split('=');
                var cookie = parts.slice(1).join('=');

                if (!json && cookie.charAt(0) === '"') {
                    cookie = cookie.slice(1, -1);
                }

                try {
                    var name = decode(parts[0]);
                    cookie = (converter.read || converter)(cookie, name) ||
                        decode(cookie);

                    if (json) {
                        try {
                            cookie = JSON.parse(cookie);
                        } catch (e) {}
                    }

                    jar[name] = cookie;

                    if (key === name) {
                        break;
                    }
                } catch (e) {}
            }

            return key ? jar[key] : jar;
        }

        api.set = set;
        api.get = function (key) {
            return get(key, false /* read as raw */);
        };
        api.getJSON = function (key) {
            return get(key, true /* read as json */);
        };
        api.remove = function (key, attributes) {
            set(key, '', extend(attributes, {
                expires: -1
            }));
        };

        api.defaults = {};

        api.withConverter = init;

        return api;
    }

    return init(function () {});
}));


/**
 shave - Shave is a javascript plugin that truncates multi-line text within a html element based on set max height
 @version v2.5.3
 @link https://github.com/dollarshaveclub/shave#readme
 @author Jeff Wainwright <yowainwright@gmail.com> (jeffry.in)
 @license MIT
 **/
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
        typeof define === 'function' && define.amd ? define(factory) :
            (global.shave = factory());
}(this, (function () { 'use strict';

    function shave(target, maxHeight) {
        var opts = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
        if (!maxHeight) throw Error('maxHeight is required');
        var els = typeof target === 'string' ? document.querySelectorAll(target) : target;
        if (!els) return;
        var character = opts.character || '…';
        var classname = opts.classname || 'js-shave';
        var spaces = typeof opts.spaces === 'boolean' ? opts.spaces : true;
        var charHtml = "<span class=\"js-shave-char\">".concat(character, "</span>");
        if (!('length' in els)) els = [els];

        for (var i = 0; i < els.length; i += 1) {
            var el = els[i];
            var styles = el.style;
            var span = el.querySelector(".".concat(classname));
            var textProp = el.textContent === undefined ? 'innerText' : 'textContent'; // If element text has already been shaved

            if (span) {
                // Remove the ellipsis to recapture the original text
                el.removeChild(el.querySelector('.js-shave-char'));
                el[textProp] = el[textProp]; // eslint-disable-line
                // nuke span, recombine text
            }

            var fullText = el[textProp];
            var words = spaces ? fullText.split(' ') : fullText; // If 0 or 1 words, we're done

            if (words.length < 2) continue; // Temporarily remove any CSS height for text height calculation

            var heightStyle = styles.height;
            styles.height = 'auto';
            var maxHeightStyle = styles.maxHeight;
            styles.maxHeight = 'none'; // If already short enough, we're done

            if (el.offsetHeight <= maxHeight) {
                styles.height = heightStyle;
                styles.maxHeight = maxHeightStyle;
                continue;
            } // Binary search for number of words which can fit in allotted height


            var max = words.length - 1;
            var min = 0;
            var pivot = void 0;

            while (min < max) {
                pivot = min + max + 1 >> 1; // eslint-disable-line no-bitwise

                el[textProp] = spaces ? words.slice(0, pivot).join(' ') : words.slice(0, pivot);
                el.insertAdjacentHTML('beforeend', charHtml);
                if (el.offsetHeight > maxHeight) max = spaces ? pivot - 1 : pivot - 2;else min = pivot;
            }

            el[textProp] = spaces ? words.slice(0, max).join(' ') : words.slice(0, max);
            el.insertAdjacentHTML('beforeend', charHtml);
            var diff = spaces ? " ".concat(words.slice(max).join(' ')) : words.slice(max);
            var shavedText = document.createTextNode(diff);
            var elWithShavedText = document.createElement('span');
            elWithShavedText.classList.add(classname);
            elWithShavedText.style.display = 'none';
            elWithShavedText.appendChild(shavedText);
            el.insertAdjacentElement('beforeend', elWithShavedText);
            styles.height = heightStyle;
            styles.maxHeight = maxHeightStyle;
        }
    }

    return shave;

})));