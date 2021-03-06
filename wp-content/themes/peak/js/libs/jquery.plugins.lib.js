/*!
 * JavaScript Cookie v2.0.4
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(factory);
    } else if (typeof exports === 'object') {
        module.exports = factory();
    } else {
        var _OldCookies = window.Cookies;
        var api = window.Cookies = factory();
        api.noConflict = function () {
            window.Cookies = _OldCookies;
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

    function init (converter) {
        function api (key, value, attributes) {
            var result;

            // Write

            if (arguments.length > 1) {
                attributes = extend({
                    path: '/'
                }, api.defaults, attributes);

                if (typeof attributes.expires === 'number') {
                    var expires = new Date();
                    expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
                    attributes.expires = expires;
                }

                try {
                    result = JSON.stringify(value);
                    if (/^[\{\[]/.test(result)) {
                        value = result;
                    }
                } catch (e) {}

                value = encodeURIComponent(String(value));
                value = value.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);

                key = encodeURIComponent(String(key));
                key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
                key = key.replace(/[\(\)]/g, escape);

                return (document.cookie = [
                    key, '=', value,
                    attributes.expires && '; expires=' + attributes.expires.toUTCString(), // use expires attribute, max-age is not supported by IE
                    attributes.path    && '; path=' + attributes.path,
                    attributes.domain  && '; domain=' + attributes.domain,
                    attributes.secure ? '; secure' : ''
                ].join(''));
            }

            // Read

            if (!key) {
                result = {};
            }

            // To prevent the for loop in the first place assign an empty array
            // in case there are no cookies at all. Also prevents odd result when
            // calling "get()"
            var cookies = document.cookie ? document.cookie.split('; ') : [];
            var rdecode = /(%[0-9A-Z]{2})+/g;
            var i = 0;

            for (; i < cookies.length; i++) {
                var parts = cookies[i].split('=');
                var name = parts[0].replace(rdecode, decodeURIComponent);
                var cookie = parts.slice(1).join('=');

                if (cookie.charAt(0) === '"') {
                    cookie = cookie.slice(1, -1);
                }

                try {
                    cookie = converter && converter(cookie, name) || cookie.replace(rdecode, decodeURIComponent);

                    if (this.json) {
                        try {
                            cookie = JSON.parse(cookie);
                        } catch (e) {}
                    }

                    if (key === name) {
                        result = cookie;
                        break;
                    }

                    if (!key) {
                        result[name] = cookie;
                    }
                } catch (e) {}
            }

            return result;
        }

        api.get = api.set = api;
        api.getJSON = function () {
            return api.apply({
                json: true
            }, [].slice.call(arguments));
        };
        api.defaults = {};

        api.remove = function (key, attributes) {
            api(key, '', extend(attributes, {
                expires: -1
            }));
        };

        api.withConverter = init;

        return api;
    }

    return init();
}));


/**
 * photoset-grid - v1.0.1
 * 2014-04-08
 * jQuery plugin to arrange images into a flexible grid
 * http://stylehatch.github.com/photoset-grid/
 *
 * Copyright 2014 Jonathan Moore - Style Hatch
 */

/*jshint browser: true, curly: true, eqeqeq: true, forin: false, immed: false, newcap: true, noempty: true, strict: true, undef: true, devel: true */
;(function ( $, window, document, undefined ) {

    'use strict';

    // Plugin name and default settings
    var pluginName = "photosetGrid",
        defaults = {
            // Required
            // set the width of the container
            width         : '100%',
            // the space between the rows / columns
            gutter        : '0px',

            // Optional
            // wrap the images in a vs. div and link to the data-highres images
            highresLinks  : false,
            // threshold for the lowres image, if container is > swap the data-highres
            lowresWidth   : 500,
            // relational attr to apply to the links for lightbox use
            rel           : '',

            // add a border to each image
            borderActive: false,
            // set border width
            borderWidth: '5px',
            // set border color
            borderColor: '#000000',
            // set border radius
            borderRadius: '0',
            // if true it will remove "double" borders
            borderRemoveDouble: false,

            // Call back events
            onInit        : function(){},
            onComplete    : function(){}
        };

    // Plugin constructor
    function Plugin( element, options ) {
        this.element = element;
        this.options = $.extend( {}, defaults, options );

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function() {
            // Call the optional onInit event set when the plugin is called
            this.options.onInit();

            this._setupRows(this.element, this.options);
            this._setupColumns(this.element, this.options);

        },

        _callback: function(elem){
            // Call the optional onComplete event after the plugin has been completed
            this.options.onComplete(elem);
        },

        _setupRows: function(  elem, options ){
            // Convert the layout string into an array to build the DOM structures
            if(options.layout) {
                // Check for layout defined in plugin call
                this.layout = options.layout;
            } else if($(elem).attr('data-layout')) {
                // If not defined in the options, check for the data-layout attr
                this.layout = $(elem).attr('data-layout');
            } else {
                // Otherwise give it a stacked layout (no grids for you)
                // Generate a layout string of all ones based on the number of images
                var stackedLayout = "";
                var defaultColumns = 1;
                for (var imgs=0; imgs<$(elem).find('img').length; imgs++ ) {
                    stackedLayout = stackedLayout + defaultColumns.toString();
                }
                this.layout = stackedLayout;
            }

            // Dump the layout into a rows array
            // Convert the array into all numbers vs. strings
            this.rows = this.layout.split('');
            for (var i in this.rows ) {
                this.rows[i] = parseInt(this.rows[i], 10);
            }

            var $images = $(elem).find('img');
            var imageIndex = 0;

            $.each(this.rows, function(i, val){
                var rowStart = imageIndex;
                var rowEnd = imageIndex + val;

                // Wrap each set of images in a row into a container div
                $images.slice(rowStart, rowEnd).wrapAll('<div class="photoset-row cols-' + val + '"></div>');

                imageIndex = rowEnd;
            });

            $(elem).find('.photoset-row:not(:last-child)').css({
                'margin-bottom': options.gutter
            });
        },

        _setupColumns: function(  elem, options ){

            // Reference to this Plugin
            var $this = this;

            var setupStyles = function(waitForImagesLoaded){
                var $rows = $(elem).find('.photoset-row');
                var $images = $(elem).find('img');

                // Wrap the images in links to the highres or regular image
                // Otherwise wrap in div.photoset-cell
                if(options.highresLinks){
                    $images.each(function(){
                        var title;
                        // If the image has a title pass it on
                        if($(this).attr('title')){
                            title = ' title="' + $(this).attr('title') + '"';
                        } else {
                            title = '';
                        }
                        var highres;
                        // If a highres image exists link it up!
                        if($(this).attr('data-highres')){
                            highres = $(this).attr('data-highres');
                        } else {
                            highres = $(this).attr('src');
                        }
                        $(this).wrapAll('<a href="' + highres + '"' + title + ' class="photoset-cell highres-link" />');
                        if(options.borderActive){
                            $(this).wrapAll('<span class="photoset-content-border" />');
                        }
                    });

                    // Apply the optional rel
                    if(options.rel){
                        $images.parent().attr('rel', options.rel);
                    }

                } else {
                    $images.each(function(){
                        if(options.borderActive){
                            $(this).wrapAll('<div class="photoset-cell photoset-cell--border" />');
                            $(this).wrapAll('<div class="photoset-content-border" />');
                        } else {
                            $(this).wrapAll('<div class="photoset-cell" />');
                        }
                    });
                }

                var $cells = $(elem).find('.photoset-cell');
                var $cols1 = $(elem).find('.cols-1 .photoset-cell');
                var $cols2 = $(elem).find('.cols-2 .photoset-cell');
                var $cols3 = $(elem).find('.cols-3 .photoset-cell');
                var $cols4 = $(elem).find('.cols-4 .photoset-cell');
                var $cols5 = $(elem).find('.cols-5 .photoset-cell');
                var $cellBorder = $(elem).find('.photoset-content-border');

                // Apply styles initial structure styles to the grid
                $(elem).css({
                    'width': options.width
                });
                $rows.css({
                    'clear': 'left',
                    'display': 'block',
                    'overflow': 'hidden'
                });
                $cells.css({
                    'float': 'left',
                    'display': 'block',
                    'line-height': '0',
                    '-webkit-box-sizing': 'border-box',
                    '-moz-box-sizing': 'border-box',
                    'box-sizing': 'border-box'
                });
                $images.css({
                    'width': '100%',
                    'height': 'auto'
                });
                if(options.borderActive){
                    $cellBorder.css({
                        'display': 'block',
                        'border': options.borderWidth + ' solid ' + options.borderColor,
                        'border-radius': options.borderRadius,
                        'overflow': 'hidden',
                        '-webkit-box-sizing': 'border-box',
                        '-moz-box-sizing': 'border-box',
                        'box-sizing': 'border-box'
                    });
                }

                // if the imaged did not have height/width attr set them
                if (waitForImagesLoaded) {
                    $images.each(function(){
                        $(this).attr('height', $(this).height());
                        $(this).attr('width', $(this).width());
                    });
                }

                // Set the width of the cells based on the number of columns in the row
                $cols1.css({ 'width': '100%' });
                $cols2.css({ 'width': '50%' });
                $cols3.css({ 'width': '33.3%' });
                $cols4.css({ 'width': '25%' });
                $cols5.css({ 'width': '20%' });


                var gutterVal = parseInt(options.gutter, 10);
                // Apply 50% gutter to left and right
                // this provides equal gutters a high values
                $(elem).find('.photoset-cell:not(:last-child)').css({
                    'padding-right': (gutterVal / 2) + 'px'
                });
                $(elem).find('.photoset-cell:not(:first-child)').css({
                    'padding-left': (gutterVal / 2) + 'px'
                });

                // If 'borderRemoveDouble' is true, let us remove the extra gutter border
                if(options.borderRemoveDouble){
                    $(elem).find('.photoset-row').not(':eq(0)').find('.photoset-content-border').css({'border-top': 'none'});
                    $(elem).find('.photoset-row').not('.cols-1').find('.photoset-content-border').not(":eq(0)").css({'border-left': 'none'});
                }

                function resizePhotosetGrid(){

                    // Give the values a floor to prevent misfires
                    var w = $(elem).width().toString();

                    if( w !== $(elem).attr('data-width') ) {
                        $rows.each(function(){
                            var $shortestImg = $(this).find('img:eq(0)');

                            $(this).find('img').each(function(){
                                var $img = $(this);
                                if( $img.attr('height') < $shortestImg.attr('height') ){
                                    $shortestImg = $(this);
                                }

                                if(parseInt($img.css('width'), 10) > options.lowresWidth && $img.attr('data-highres')){
                                    $img.attr('src', $img.attr('data-highres'));
                                }
                            });

                            // Get the row height from the calculated/real height/width of the shortest image
                            var rowHeight = ( $shortestImg.attr('height') * parseInt($shortestImg.css('width'), 10) ) / $shortestImg.attr('width');
                            // Adding a buffer to shave off a few pixels in height
                            var bufferHeight = Math.floor(rowHeight * 0.025);
                            $(this).height( rowHeight - bufferHeight );

                            // If border is set to true, then add the parent row height to each .photoset-content-border
                            if(options.borderActive){
                                $(this).find('.photoset-content-border').each(function(){
                                    $(this).css({'height': rowHeight - bufferHeight});
                                });
                            }

                            $(this).find('img').each(function(){
                                // Get the image height from the calculated/real height/width
                                var imageHeight = ( $(this).attr('height') * parseInt($(this).css('width'), 10) ) / $(this).attr('width');
                                var marginOffset = ( (rowHeight - imageHeight) * 0.5 ) + 'px';
                                $(this).css({
                                    'margin-top' : marginOffset
                                });
                            });

                        });
                        $(elem).attr('data-width', w );
                    }

                }
                resizePhotosetGrid();

                $(window).on("resize", function() {
                    resizePhotosetGrid();
                });

            };

            // By default the plugin will wait until all of the images are loaded to setup the styles
            var waitForImagesLoaded = true;
            var hasDimensions = true;

            // Loops through all of the images in the photoset
            // if the height and width exists for all images set waitForImagesLoaded to false
            $(elem).find('img').each(function(){
                hasDimensions = hasDimensions & ( !!$(this).attr('height') & !!$(this).attr('width') );
            });

            waitForImagesLoaded = !hasDimensions;

            // Only use imagesLoaded() if waitForImagesLoaded
            if(waitForImagesLoaded) {
                $(elem).imagesLoaded(function(){
                    setupStyles(waitForImagesLoaded);
                    $this._callback(elem);
                });
            } else {
                setupStyles(waitForImagesLoaded);
                $this._callback(elem);
            }


        }

    };

    // plugin wrapper around the constructor
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin( this, options ));
            }
        });
    };

    /*!
     * jQuery imagesLoaded plugin v2.1.1
     * http://github.com/desandro/imagesloaded
     *
     * MIT License. by Paul Irish et al.
     */

    /*jshint curly: true, eqeqeq: true, noempty: true, strict: true, undef: true, browser: true */
    /*global jQuery: false */

    // blank image data-uri bypasses webkit log warning (thx doug jones)
    var BLANK = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';

    $.fn.imagesLoaded = function( callback ) {
        var $this = this,
            deferred = $.isFunction($.Deferred) ? $.Deferred() : 0,
            hasNotify = $.isFunction(deferred.notify),
            $images = $this.find('img').add( $this.filter('img') ),
            loaded = [],
            proper = [],
            broken = [];

        // Register deferred callbacks
        if ($.isPlainObject(callback)) {
            $.each(callback, function (key, value) {
                if (key === 'callback') {
                    callback = value;
                } else if (deferred) {
                    deferred[key](value);
                }
            });
        }

        function doneLoading() {
            var $proper = $(proper),
                $broken = $(broken);

            if ( deferred ) {
                if ( broken.length ) {
                    deferred.reject( $images, $proper, $broken );
                } else {
                    deferred.resolve( $images );
                }
            }

            if ( $.isFunction( callback ) ) {
                callback.call( $this, $images, $proper, $broken );
            }
        }

        function imgLoadedHandler( event ) {
            imgLoaded( event.target, event.type === 'error' );
        }

        function imgLoaded( img, isBroken ) {
            // don't proceed if BLANK image, or image is already loaded
            if ( img.src === BLANK || $.inArray( img, loaded ) !== -1 ) {
                return;
            }

            // store element in loaded images array
            loaded.push( img );

            // keep track of broken and properly loaded images
            if ( isBroken ) {
                broken.push( img );
            } else {
                proper.push( img );
            }

            // cache image and its state for future calls
            $.data( img, 'imagesLoaded', { isBroken: isBroken, src: img.src } );

            // trigger deferred progress method if present
            if ( hasNotify ) {
                deferred.notifyWith( $(img), [ isBroken, $images, $(proper), $(broken) ] );
            }

            // call doneLoading and clean listeners if all images are loaded
            if ( $images.length === loaded.length ) {
                setTimeout( doneLoading );
                $images.unbind( '.imagesLoaded', imgLoadedHandler );
            }
        }

        // if no images, trigger immediately
        if ( !$images.length ) {
            doneLoading();
        } else {
            $images.bind( 'load.imagesLoaded error.imagesLoaded', imgLoadedHandler )
                .each( function( i, el ) {
                    var src = el.src;

                    // find out if this image has been already checked for status
                    // if it was, and src has not changed, call imgLoaded on it
                    var cached = $.data( el, 'imagesLoaded' );
                    if ( cached && cached.src === src ) {
                        imgLoaded( el, cached.isBroken );
                        return;
                    }

                    // if complete is true and browser supports natural sizes, try
                    // to check for image status manually
                    if ( el.complete && el.naturalWidth !== undefined ) {
                        imgLoaded( el, el.naturalWidth === 0 || el.naturalHeight === 0 );
                        return;
                    }

                    // cached images don't fire load sometimes, so we reset src, but only when
                    // dealing with IE, or image is complete (loaded) and failed manual check
                    // webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
                    if ( el.readyState || el.complete ) {
                        el.src = BLANK;
                        el.src = src;
                    }
                });
        }

        return deferred ? deferred.promise( $this ) : $this;
    };

    /*
     * throttledresize: special jQuery event that happens at a reduced rate compared to "resize"
     *
     * latest version and complete README available on Github:
     * https://github.com/louisremi/jquery-smartresize
     *
     * Copyright 2012 @louis_remi
     * Licensed under the MIT license.
     *
     * This saved you an hour of work?
     * Send me music http://www.amazon.co.uk/wishlist/HNTU0468LQON
     */

    var $event = $.event,
        $special,
        dummy = {_:0},
        frame = 0,
        wasResized, animRunning;

    $special = $event.special.throttledresize = {
        setup: function() {
            $( this ).on( "resize", $special.handler );
        },
        teardown: function() {
            $( this ).off( "resize", $special.handler );
        },
        handler: function( event, execAsap ) {
            // Save the context
            var context = this,
                args = arguments;

            wasResized = true;

            if ( !animRunning ) {
                setInterval(function(){
                    frame++;

                    if ( frame > $special.threshold && wasResized || execAsap ) {
                        // set correct event type
                        event.type = "throttledresize";
                        $event.dispatch.apply( context, args );
                        wasResized = false;
                        frame = 0;
                    }
                    if ( frame > 9 ) {
                        $(dummy).stop();
                        animRunning = false;
                        frame = 0;
                    }
                }, 30);
                animRunning = true;
            }
        },
        threshold: 0
    };


})( jQuery, window, document );



/*!
 * The Final Countdown for jQuery v2.1.0 (http://hilios.github.io/jQuery.countdown/)
 * Copyright (c) 2015 Edson Hilios
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
(function(factory) {
    "use strict";
    if (typeof define === "function" && define.amd) {
        define([ "jquery" ], factory);
    } else {
        factory(jQuery);
    }
})(function($) {
    "use strict";
    var instances = [], matchers = [], defaultOptions = {
        precision: 100,
        elapse: false
    };
    matchers.push(/^[0-9]*$/.source);
    matchers.push(/([0-9]{1,2}\/){2}[0-9]{4}( [0-9]{1,2}(:[0-9]{2}){2})?/.source);
    matchers.push(/[0-9]{4}([\/\-][0-9]{1,2}){2}( [0-9]{1,2}(:[0-9]{2}){2})?/.source);
    matchers = new RegExp(matchers.join("|"));
    function parseDateString(dateString) {
        if (dateString instanceof Date) {
            return dateString;
        }
        if (String(dateString).match(matchers)) {
            if (String(dateString).match(/^[0-9]*$/)) {
                dateString = Number(dateString);
            }
            if (String(dateString).match(/\-/)) {
                dateString = String(dateString).replace(/\-/g, "/");
            }
            return new Date(dateString);
        } else {
            throw new Error("Couldn't cast `" + dateString + "` to a date object.");
        }
    }
    var DIRECTIVE_KEY_MAP = {
        Y: "years",
        m: "months",
        n: "daysToMonth",
        w: "weeks",
        d: "daysToWeek",
        D: "totalDays",
        H: "hours",
        M: "minutes",
        S: "seconds"
    };
    function escapedRegExp(str) {
        var sanitize = str.toString().replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1");
        return new RegExp(sanitize);
    }
    function strftime(offsetObject) {
        return function(format) {
            var directives = format.match(/%(-|!)?[A-Z]{1}(:[^;]+;)?/gi);
            if (directives) {
                for (var i = 0, len = directives.length; i < len; ++i) {
                    var directive = directives[i].match(/%(-|!)?([a-zA-Z]{1})(:[^;]+;)?/), regexp = escapedRegExp(directive[0]), modifier = directive[1] || "", plural = directive[3] || "", value = null;
                    directive = directive[2];
                    if (DIRECTIVE_KEY_MAP.hasOwnProperty(directive)) {
                        value = DIRECTIVE_KEY_MAP[directive];
                        value = Number(offsetObject[value]);
                    }
                    if (value !== null) {
                        if (modifier === "!") {
                            value = pluralize(plural, value);
                        }
                        if (modifier === "") {
                            if (value < 10) {
                                value = "0" + value.toString();
                            }
                        }
                        format = format.replace(regexp, value.toString());
                    }
                }
            }
            format = format.replace(/%%/, "%");
            return format;
        };
    }
    function pluralize(format, count) {
        var plural = "s", singular = "";
        if (format) {
            format = format.replace(/(:|;|\s)/gi, "").split(/\,/);
            if (format.length === 1) {
                plural = format[0];
            } else {
                singular = format[0];
                plural = format[1];
            }
        }
        if (Math.abs(count) === 1) {
            return singular;
        } else {
            return plural;
        }
    }
    var Countdown = function(el, finalDate, options) {
        this.el = el;
        this.$el = $(el);
        this.interval = null;
        this.offset = {};
        this.options = $.extend({}, defaultOptions);
        this.instanceNumber = instances.length;
        instances.push(this);
        this.$el.data("countdown-instance", this.instanceNumber);
        if (options) {
            if (typeof options === "function") {
                this.$el.on("update.countdown", options);
                this.$el.on("stoped.countdown", options);
                this.$el.on("finish.countdown", options);
            } else {
                this.options = $.extend({}, defaultOptions, options);
            }
        }
        this.setFinalDate(finalDate);
        this.start();
    };
    $.extend(Countdown.prototype, {
        start: function() {
            if (this.interval !== null) {
                clearInterval(this.interval);
            }
            var self = this;
            this.update();
            this.interval = setInterval(function() {
                self.update.call(self);
            }, this.options.precision);
        },
        stop: function() {
            clearInterval(this.interval);
            this.interval = null;
            this.dispatchEvent("stoped");
        },
        toggle: function() {
            if (this.interval) {
                this.stop();
            } else {
                this.start();
            }
        },
        pause: function() {
            this.stop();
        },
        resume: function() {
            this.start();
        },
        remove: function() {
            this.stop.call(this);
            instances[this.instanceNumber] = null;
            delete this.$el.data().countdownInstance;
        },
        setFinalDate: function(value) {
            this.finalDate = parseDateString(value);
        },
        update: function() {
            if (this.$el.closest("html").length === 0) {
                this.remove();
                return;
            }
            var hasEventsAttached = $._data(this.el, "events") !== undefined, now = new Date(), newTotalSecsLeft;
            newTotalSecsLeft = this.finalDate.getTime() - now.getTime();
            newTotalSecsLeft = Math.ceil(newTotalSecsLeft / 1e3);
            newTotalSecsLeft = !this.options.elapse && newTotalSecsLeft < 0 ? 0 : Math.abs(newTotalSecsLeft);
            if (this.totalSecsLeft === newTotalSecsLeft || !hasEventsAttached) {
                return;
            } else {
                this.totalSecsLeft = newTotalSecsLeft;
            }
            this.elapsed = now >= this.finalDate;
            this.offset = {
                seconds: this.totalSecsLeft % 60,
                minutes: Math.floor(this.totalSecsLeft / 60) % 60,
                hours: Math.floor(this.totalSecsLeft / 60 / 60) % 24,
                days: Math.floor(this.totalSecsLeft / 60 / 60 / 24) % 7,
                daysToWeek: Math.floor(this.totalSecsLeft / 60 / 60 / 24) % 7,
                daysToMonth: Math.floor(this.totalSecsLeft / 60 / 60 / 24 % 30.4368),
                totalDays: Math.floor(this.totalSecsLeft / 60 / 60 / 24),
                weeks: Math.floor(this.totalSecsLeft / 60 / 60 / 24 / 7),
                months: Math.floor(this.totalSecsLeft / 60 / 60 / 24 / 30.4368),
                years: Math.abs(this.finalDate.getFullYear() - now.getFullYear())
            };
            if (!this.options.elapse && this.totalSecsLeft === 0) {
                this.stop();
                this.dispatchEvent("finish");
            } else {
                this.dispatchEvent("update");
            }
        },
        dispatchEvent: function(eventName) {
            var event = $.Event(eventName + ".countdown");
            event.finalDate = this.finalDate;
            event.elapsed = this.elapsed;
            event.offset = $.extend({}, this.offset);
            event.strftime = strftime(this.offset);
            this.$el.trigger(event);
        }
    });
    $.fn.countdown = function() {
        var argumentsArray = Array.prototype.slice.call(arguments, 0);
        return this.each(function() {
            var instanceNumber = $(this).data("countdown-instance");
            if (instanceNumber !== undefined) {
                var instance = instances[instanceNumber], method = argumentsArray[0];
                if (Countdown.prototype.hasOwnProperty(method)) {
                    instance[method].apply(instance, argumentsArray.slice(1));
                } else if (String(method).match(/^[$A-Z_][0-9A-Z_$]*$/i) === null) {
                    instance.setFinalDate.call(instance, method);
                    instance.start();
                } else {
                    $.error("Method %s does not exist on jQuery.countdown".replace(/\%s/gi, method));
                }
            } else {
                new Countdown(this, argumentsArray[0], argumentsArray[1]);
            }
        });
    };
});


/*! odometer 0.4.7
* https://github.com/HubSpot/odometer
*/
(function() {
    var COUNT_FRAMERATE, COUNT_MS_PER_FRAME, DIGIT_FORMAT, DIGIT_HTML, DIGIT_SPEEDBOOST, DURATION, FORMAT_MARK_HTML, FORMAT_PARSER, FRAMERATE, FRAMES_PER_VALUE, MS_PER_FRAME, MutationObserver, Odometer, RIBBON_HTML, TRANSITION_END_EVENTS, TRANSITION_SUPPORT, VALUE_HTML, addClass, createFromHTML, fractionalPart, now, removeClass, requestAnimationFrame, round, transitionCheckStyles, trigger, truncate, wrapJQuery, _jQueryWrapped, _old, _ref, _ref1,
        __slice = [].slice;

    VALUE_HTML = '<span class="odometer-value"></span>';

    RIBBON_HTML = '<span class="odometer-ribbon"><span class="odometer-ribbon-inner">' + VALUE_HTML + '</span></span>';

    DIGIT_HTML = '<span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner">' + RIBBON_HTML + '</span></span>';

    FORMAT_MARK_HTML = '<span class="odometer-formatting-mark"></span>';

    DIGIT_FORMAT = '(,ddd).dd';

    FORMAT_PARSER = /^\(?([^)]*)\)?(?:(.)(d+))?$/;

    FRAMERATE = 30;

    DURATION = 2000;

    COUNT_FRAMERATE = 20;

    FRAMES_PER_VALUE = 2;

    DIGIT_SPEEDBOOST = .5;

    MS_PER_FRAME = 1000 / FRAMERATE;

    COUNT_MS_PER_FRAME = 1000 / COUNT_FRAMERATE;

    TRANSITION_END_EVENTS = 'transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd';

    transitionCheckStyles = document.createElement('div').style;

    TRANSITION_SUPPORT = (transitionCheckStyles.transition != null) || (transitionCheckStyles.webkitTransition != null) || (transitionCheckStyles.mozTransition != null) || (transitionCheckStyles.oTransition != null);

    requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;

    MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

    createFromHTML = function(html) {
        var el;
        el = document.createElement('div');
        el.innerHTML = html;
        return el.children[0];
    };

    removeClass = function(el, name) {
        return el.className = el.className.replace(new RegExp("(^| )" + (name.split(' ').join('|')) + "( |$)", 'gi'), ' ');
    };

    addClass = function(el, name) {
        removeClass(el, name);
        return el.className += " " + name;
    };

    trigger = function(el, name) {
        var evt;
        if (document.createEvent != null) {
            evt = document.createEvent('HTMLEvents');
            evt.initEvent(name, true, true);
            return el.dispatchEvent(evt);
        }
    };

    now = function() {
        var _ref, _ref1;
        return (_ref = (_ref1 = window.performance) != null ? typeof _ref1.now === "function" ? _ref1.now() : void 0 : void 0) != null ? _ref : +(new Date);
    };

    round = function(val, precision) {
        if (precision == null) {
            precision = 0;
        }
        if (!precision) {
            return Math.round(val);
        }
        val *= Math.pow(10, precision);
        val += 0.5;
        val = Math.floor(val);
        return val /= Math.pow(10, precision);
    };

    truncate = function(val) {
        if (val < 0) {
            return Math.ceil(val);
        } else {
            return Math.floor(val);
        }
    };

    fractionalPart = function(val) {
        return val - round(val);
    };

    _jQueryWrapped = false;

    (wrapJQuery = function() {
        var property, _i, _len, _ref, _results;
        if (_jQueryWrapped) {
            return;
        }
        if (window.jQuery != null) {
            _jQueryWrapped = true;
            _ref = ['html', 'text'];
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                property = _ref[_i];
                _results.push((function(property) {
                    var old;
                    old = window.jQuery.fn[property];
                    return window.jQuery.fn[property] = function(val) {
                        var _ref1;
                        if ((val == null) || (((_ref1 = this[0]) != null ? _ref1.odometer : void 0) == null)) {
                            return old.apply(this, arguments);
                        }
                        return this[0].odometer.update(val);
                    };
                })(property));
            }
            return _results;
        }
    })();

    setTimeout(wrapJQuery, 0);

    Odometer = (function() {
        function Odometer(options) {
            var e, k, property, v, _base, _i, _len, _ref, _ref1, _ref2,
                _this = this;
            this.options = options;
            this.el = this.options.el;
            if (this.el.odometer != null) {
                return this.el.odometer;
            }
            this.el.odometer = this;
            _ref = Odometer.options;
            for (k in _ref) {
                v = _ref[k];
                if (this.options[k] == null) {
                    this.options[k] = v;
                }
            }
            if ((_base = this.options).duration == null) {
                _base.duration = DURATION;
            }
            this.MAX_VALUES = ((this.options.duration / MS_PER_FRAME) / FRAMES_PER_VALUE) | 0;
            this.resetFormat();
            this.value = this.cleanValue((_ref1 = this.options.value) != null ? _ref1 : '');
            this.renderInside();
            this.render();
            try {
                _ref2 = ['innerHTML', 'innerText', 'textContent'];
                for (_i = 0, _len = _ref2.length; _i < _len; _i++) {
                    property = _ref2[_i];
                    if (this.el[property] != null) {
                        (function(property) {
                            return Object.defineProperty(_this.el, property, {
                                get: function() {
                                    var _ref3;
                                    if (property === 'innerHTML') {
                                        return _this.inside.outerHTML;
                                    } else {
                                        return (_ref3 = _this.inside.innerText) != null ? _ref3 : _this.inside.textContent;
                                    }
                                },
                                set: function(val) {
                                    return _this.update(val);
                                }
                            });
                        })(property);
                    }
                }
            } catch (_error) {
                e = _error;
                this.watchForMutations();
            }
            this;
        }

        Odometer.prototype.renderInside = function() {
            this.inside = document.createElement('div');
            this.inside.className = 'odometer-inside';
            this.el.innerHTML = '';
            return this.el.appendChild(this.inside);
        };

        Odometer.prototype.watchForMutations = function() {
            var e,
                _this = this;
            if (MutationObserver == null) {
                return;
            }
            try {
                if (this.observer == null) {
                    this.observer = new MutationObserver(function(mutations) {
                        var newVal;
                        newVal = _this.el.innerText;
                        _this.renderInside();
                        _this.render(_this.value);
                        return _this.update(newVal);
                    });
                }
                this.watchMutations = true;
                return this.startWatchingMutations();
            } catch (_error) {
                e = _error;
            }
        };

        Odometer.prototype.startWatchingMutations = function() {
            if (this.watchMutations) {
                return this.observer.observe(this.el, {
                    childList: true
                });
            }
        };

        Odometer.prototype.stopWatchingMutations = function() {
            var _ref;
            return (_ref = this.observer) != null ? _ref.disconnect() : void 0;
        };

        Odometer.prototype.cleanValue = function(val) {
            var _ref;
            if (typeof val === 'string') {
                val = val.replace((_ref = this.format.radix) != null ? _ref : '.', '<radix>');
                val = val.replace(/[.,]/g, '');
                val = val.replace('<radix>', '.');
                val = parseFloat(val, 10) || 0;
            }
            return round(val, this.format.precision);
        };

        Odometer.prototype.bindTransitionEnd = function() {
            var event, renderEnqueued, _i, _len, _ref, _results,
                _this = this;
            if (this.transitionEndBound) {
                return;
            }
            this.transitionEndBound = true;
            renderEnqueued = false;
            _ref = TRANSITION_END_EVENTS.split(' ');
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                event = _ref[_i];
                _results.push(this.el.addEventListener(event, function() {
                    if (renderEnqueued) {
                        return true;
                    }
                    renderEnqueued = true;
                    setTimeout(function() {
                        _this.render();
                        renderEnqueued = false;
                        return trigger(_this.el, 'odometerdone');
                    }, 0);
                    return true;
                }, false));
            }
            return _results;
        };

        Odometer.prototype.resetFormat = function() {
            var format, fractional, parsed, precision, radix, repeating, _ref, _ref1;
            format = (_ref = this.options.format) != null ? _ref : DIGIT_FORMAT;
            format || (format = 'd');
            parsed = FORMAT_PARSER.exec(format);
            if (!parsed) {
                throw new Error("Odometer: Unparsable digit format");
            }
            _ref1 = parsed.slice(1, 4), repeating = _ref1[0], radix = _ref1[1], fractional = _ref1[2];
            precision = (fractional != null ? fractional.length : void 0) || 0;
            return this.format = {
                repeating: repeating,
                radix: radix,
                precision: precision
            };
        };

        Odometer.prototype.render = function(value) {
            var classes, cls, match, newClasses, theme, _i, _len;
            if (value == null) {
                value = this.value;
            }
            this.stopWatchingMutations();
            this.resetFormat();
            this.inside.innerHTML = '';
            theme = this.options.theme;
            classes = this.el.className.split(' ');
            newClasses = [];
            for (_i = 0, _len = classes.length; _i < _len; _i++) {
                cls = classes[_i];
                if (!cls.length) {
                    continue;
                }
                if (match = /^odometer-theme-(.+)$/.exec(cls)) {
                    theme = match[1];
                    continue;
                }
                if (/^odometer(-|$)/.test(cls)) {
                    continue;
                }
                newClasses.push(cls);
            }
            newClasses.push('odometer');
            if (!TRANSITION_SUPPORT) {
                newClasses.push('odometer-no-transitions');
            }
            if (theme) {
                newClasses.push("odometer-theme-" + theme);
            } else {
                newClasses.push("odometer-auto-theme");
            }
            this.el.className = newClasses.join(' ');
            this.ribbons = {};
            this.formatDigits(value);
            return this.startWatchingMutations();
        };

        Odometer.prototype.formatDigits = function(value) {
            var digit, valueDigit, valueString, wholePart, _i, _j, _len, _len1, _ref, _ref1;
            this.digits = [];
            if (this.options.formatFunction) {
                valueString = this.options.formatFunction(value);
                _ref = valueString.split('').reverse();
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    valueDigit = _ref[_i];
                    if (valueDigit.match(/0-9/)) {
                        digit = this.renderDigit();
                        digit.querySelector('.odometer-value').innerHTML = valueDigit;
                        this.digits.push(digit);
                        this.insertDigit(digit);
                    } else {
                        this.addSpacer(valueDigit);
                    }
                }
            } else {
                wholePart = !this.format.precision || !fractionalPart(value) || false;
                _ref1 = value.toString().split('').reverse();
                for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
                    digit = _ref1[_j];
                    if (digit === '.') {
                        wholePart = true;
                    }
                    this.addDigit(digit, wholePart);
                }
            }
        };

        Odometer.prototype.update = function(newValue) {
            var diff,
                _this = this;
            newValue = this.cleanValue(newValue);
            if (!(diff = newValue - this.value)) {
                return;
            }
            removeClass(this.el, 'odometer-animating-up odometer-animating-down odometer-animating');
            if (diff > 0) {
                addClass(this.el, 'odometer-animating-up');
            } else {
                addClass(this.el, 'odometer-animating-down');
            }
            this.stopWatchingMutations();
            this.animate(newValue);
            this.startWatchingMutations();
            setTimeout(function() {
                _this.el.offsetHeight;
                return addClass(_this.el, 'odometer-animating');
            }, 0);
            return this.value = newValue;
        };

        Odometer.prototype.renderDigit = function() {
            return createFromHTML(DIGIT_HTML);
        };

        Odometer.prototype.insertDigit = function(digit, before) {
            if (before != null) {
                return this.inside.insertBefore(digit, before);
            } else if (!this.inside.children.length) {
                return this.inside.appendChild(digit);
            } else {
                return this.inside.insertBefore(digit, this.inside.children[0]);
            }
        };

        Odometer.prototype.addSpacer = function(chr, before, extraClasses) {
            var spacer;
            spacer = createFromHTML(FORMAT_MARK_HTML);
            spacer.innerHTML = chr;
            if (extraClasses) {
                addClass(spacer, extraClasses);
            }
            return this.insertDigit(spacer, before);
        };

        Odometer.prototype.addDigit = function(value, repeating) {
            var chr, digit, resetted, _ref;
            if (repeating == null) {
                repeating = true;
            }
            if (value === '-') {
                return this.addSpacer(value, null, 'odometer-negation-mark');
            }
            if (value === '.') {
                return this.addSpacer((_ref = this.format.radix) != null ? _ref : '.', null, 'odometer-radix-mark');
            }
            if (repeating) {
                resetted = false;
                while (true) {
                    if (!this.format.repeating.length) {
                        if (resetted) {
                            throw new Error("Bad odometer format without digits");
                        }
                        this.resetFormat();
                        resetted = true;
                    }
                    chr = this.format.repeating[this.format.repeating.length - 1];
                    this.format.repeating = this.format.repeating.substring(0, this.format.repeating.length - 1);
                    if (chr === 'd') {
                        break;
                    }
                    this.addSpacer(chr);
                }
            }
            digit = this.renderDigit();
            digit.querySelector('.odometer-value').innerHTML = value;
            this.digits.push(digit);
            return this.insertDigit(digit);
        };

        Odometer.prototype.animate = function(newValue) {
            if (!TRANSITION_SUPPORT || this.options.animation === 'count') {
                return this.animateCount(newValue);
            } else {
                return this.animateSlide(newValue);
            }
        };

        Odometer.prototype.animateCount = function(newValue) {
            var cur, diff, last, start, tick,
                _this = this;
            if (!(diff = +newValue - this.value)) {
                return;
            }
            start = last = now();
            cur = this.value;
            return (tick = function() {
                var delta, dist, fraction;
                if ((now() - start) > _this.options.duration) {
                    _this.value = newValue;
                    _this.render();
                    trigger(_this.el, 'odometerdone');
                    return;
                }
                delta = now() - last;
                if (delta > COUNT_MS_PER_FRAME) {
                    last = now();
                    fraction = delta / _this.options.duration;
                    dist = diff * fraction;
                    cur += dist;
                    _this.render(Math.round(cur));
                }
                if (requestAnimationFrame != null) {
                    return requestAnimationFrame(tick);
                } else {
                    return setTimeout(tick, COUNT_MS_PER_FRAME);
                }
            })();
        };

        Odometer.prototype.getDigitCount = function() {
            var i, max, value, values, _i, _len;
            values = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
            for (i = _i = 0, _len = values.length; _i < _len; i = ++_i) {
                value = values[i];
                values[i] = Math.abs(value);
            }
            max = Math.max.apply(Math, values);
            return Math.ceil(Math.log(max + 1) / Math.log(10));
        };

        Odometer.prototype.getFractionalDigitCount = function() {
            var i, parser, parts, value, values, _i, _len;
            values = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
            parser = /^\-?\d*\.(\d*?)0*$/;
            for (i = _i = 0, _len = values.length; _i < _len; i = ++_i) {
                value = values[i];
                values[i] = value.toString();
                parts = parser.exec(values[i]);
                if (parts == null) {
                    values[i] = 0;
                } else {
                    values[i] = parts[1].length;
                }
            }
            return Math.max.apply(Math, values);
        };

        Odometer.prototype.resetDigits = function() {
            this.digits = [];
            this.ribbons = [];
            this.inside.innerHTML = '';
            return this.resetFormat();
        };

        Odometer.prototype.animateSlide = function(newValue) {
            var boosted, cur, diff, digitCount, digits, dist, end, fractionalCount, frame, frames, i, incr, j, mark, numEl, oldValue, start, _base, _i, _j, _k, _l, _len, _len1, _len2, _m, _ref, _results;
            oldValue = this.value;
            fractionalCount = this.getFractionalDigitCount(oldValue, newValue);
            if (fractionalCount) {
                newValue = newValue * Math.pow(10, fractionalCount);
                oldValue = oldValue * Math.pow(10, fractionalCount);
            }
            if (!(diff = newValue - oldValue)) {
                return;
            }
            this.bindTransitionEnd();
            digitCount = this.getDigitCount(oldValue, newValue);
            digits = [];
            boosted = 0;
            for (i = _i = 0; 0 <= digitCount ? _i < digitCount : _i > digitCount; i = 0 <= digitCount ? ++_i : --_i) {
                start = truncate(oldValue / Math.pow(10, digitCount - i - 1));
                end = truncate(newValue / Math.pow(10, digitCount - i - 1));
                dist = end - start;
                if (Math.abs(dist) > this.MAX_VALUES) {
                    frames = [];
                    incr = dist / (this.MAX_VALUES + this.MAX_VALUES * boosted * DIGIT_SPEEDBOOST);
                    cur = start;
                    while ((dist > 0 && cur < end) || (dist < 0 && cur > end)) {
                        frames.push(Math.round(cur));
                        cur += incr;
                    }
                    if (frames[frames.length - 1] !== end) {
                        frames.push(end);
                    }
                    boosted++;
                } else {
                    frames = (function() {
                        _results = [];
                        for (var _j = start; start <= end ? _j <= end : _j >= end; start <= end ? _j++ : _j--){ _results.push(_j); }
                        return _results;
                    }).apply(this);
                }
                for (i = _k = 0, _len = frames.length; _k < _len; i = ++_k) {
                    frame = frames[i];
                    frames[i] = Math.abs(frame % 10);
                }
                digits.push(frames);
            }
            this.resetDigits();
            _ref = digits.reverse();
            for (i = _l = 0, _len1 = _ref.length; _l < _len1; i = ++_l) {
                frames = _ref[i];
                if (!this.digits[i]) {
                    this.addDigit(' ', i >= fractionalCount);
                }
                if ((_base = this.ribbons)[i] == null) {
                    _base[i] = this.digits[i].querySelector('.odometer-ribbon-inner');
                }
                this.ribbons[i].innerHTML = '';
                if (diff < 0) {
                    frames = frames.reverse();
                }
                for (j = _m = 0, _len2 = frames.length; _m < _len2; j = ++_m) {
                    frame = frames[j];
                    numEl = document.createElement('div');
                    numEl.className = 'odometer-value';
                    numEl.innerHTML = frame;
                    this.ribbons[i].appendChild(numEl);
                    if (j === frames.length - 1) {
                        addClass(numEl, 'odometer-last-value');
                    }
                    if (j === 0) {
                        addClass(numEl, 'odometer-first-value');
                    }
                }
            }
            if (start < 0) {
                this.addDigit('-');
            }
            mark = this.inside.querySelector('.odometer-radix-mark');
            if (mark != null) {
                mark.parent.removeChild(mark);
            }
            if (fractionalCount) {
                return this.addSpacer(this.format.radix, this.digits[fractionalCount - 1], 'odometer-radix-mark');
            }
        };

        return Odometer;

    })();

    Odometer.options = (_ref = window.odometerOptions) != null ? _ref : {};

    setTimeout(function() {
        var k, v, _base, _ref1, _results;
        if (window.odometerOptions) {
            _ref1 = window.odometerOptions;
            _results = [];
            for (k in _ref1) {
                v = _ref1[k];
                _results.push((_base = Odometer.options)[k] != null ? (_base = Odometer.options)[k] : _base[k] = v);
            }
            return _results;
        }
    }, 0);

    Odometer.init = function() {
        var el, elements, _i, _len, _ref1, _results;
        if (document.querySelectorAll == null) {
            return;
        }
        elements = document.querySelectorAll(Odometer.options.selector || '.odometer');
        _results = [];
        for (_i = 0, _len = elements.length; _i < _len; _i++) {
            el = elements[_i];
            _results.push(el.odometer = new Odometer({
                el: el,
                value: (_ref1 = el.innerText) != null ? _ref1 : el.textContent
            }));
        }
        return _results;
    };

    if ((((_ref1 = document.documentElement) != null ? _ref1.doScroll : void 0) != null) && (document.createEventObject != null)) {
        _old = document.onreadystatechange;
        document.onreadystatechange = function() {
            if (document.readyState === 'complete' && Odometer.options.auto !== false) {
                Odometer.init();
            }
            return _old != null ? _old.apply(this, arguments) : void 0;
        };
    } else {
        document.addEventListener('DOMContentLoaded', function() {
            if (Odometer.options.auto !== false) {
                return Odometer.init();
            }
        }, false);
    }

    if (typeof define === 'function' && define.amd) {
        define(['jquery'], function() {
            return Odometer;
        });
    } else if (typeof exports !== "undefined" && exports !== null) {
        module.exports = Odometer;
    } else {
        window.Odometer = Odometer;
    }

}).call(this);


/** @preserve jQuery animateNumber plugin v0.0.11
 * (c) 2013, Alexandr Borisov.
 * https://github.com/aishek/jquery-animateNumber
 */

// ['...'] notation using to avoid names minification by Google Closure Compiler
(function($) {
    var reverse = function(value) {
        return value.split('').reverse().join('');
    };

    var defaults = {
        numberStep: function(now, tween) {
            var floored_number = Math.floor(now),
                target = $(tween.elem);

            target.text(floored_number);
        }
    };

    var handle = function( tween ) {
        var elem = tween.elem;
        if ( elem.nodeType && elem.parentNode ) {
            var handler = elem._animateNumberSetter;
            if (!handler) {
                handler = defaults.numberStep;
            }
            handler(tween.now, tween);
        }
    };

    if (!$.Tween || !$.Tween.propHooks) {
        $.fx.step.number = handle;
    } else {
        $.Tween.propHooks.number = {
            set: handle
        };
    }

    var extract_number_parts = function(separated_number, group_length) {
        var numbers = separated_number.split('').reverse(),
            number_parts = [],
            current_number_part,
            current_index,
            q;

        for(var i = 0, l = Math.ceil(separated_number.length / group_length); i < l; i++) {
            current_number_part = '';
            for(q = 0; q < group_length; q++) {
                current_index = i * group_length + q;
                if (current_index === separated_number.length) {
                    break;
                }

                current_number_part = current_number_part + numbers[current_index];
            }
            number_parts.push(current_number_part);
        }

        return number_parts;
    };

    var remove_precending_zeros = function(number_parts) {
        var last_index = number_parts.length - 1,
            last = reverse(number_parts[last_index]);

        number_parts[last_index] = reverse(parseInt(last, 10).toString());
        return number_parts;
    };

    $.animateNumber = {
        numberStepFactories: {
            /**
             * Creates numberStep handler, which appends string to floored animated number on each step.
             *
             * @example
             * // will animate to 100 with "1 %", "2 %", "3 %", ...
             * $('#someid').animateNumber({
       *   number: 100,
       *   numberStep: $.animateNumber.numberStepFactories.append(' %')
       * });
             *
             * @params {String} suffix string to append to animated number
             * @returns {Function} numberStep-compatible function for use in animateNumber's parameters
             */
            append: function(suffix) {
                return function(now, tween) {
                    var floored_number = Math.floor(now),
                        target = $(tween.elem);

                    target.prop('number', now).text(floored_number + suffix);
                };
            },

            /**
             * Creates numberStep handler, which format floored numbers by separating them to groups.
             *
             * @example
             * // will animate with 1 ... 217,980 ... 95,217,980 ... 7,095,217,980
             * $('#world-population').animateNumber({
       *    number: 7095217980,
       *    numberStep: $.animateNumber.numberStepFactories.separator(',')
       * });
             *
             * @params {String} [separator=' '] string to separate number groups
             * @params {String} [group_length=3] number group length
             * @returns {Function} numberStep-compatible function for use in animateNumber's parameters
             */
            separator: function(separator, group_length) {
                separator = separator || ' ';
                group_length = group_length || 3;

                return function(now, tween) {
                    var floored_number = Math.floor(now),
                        separated_number = floored_number.toString(),
                        target = $(tween.elem);

                    if (separated_number.length > group_length) {
                        var number_parts = extract_number_parts(separated_number, group_length);

                        separated_number = remove_precending_zeros(number_parts).join(separator);
                        separated_number = reverse(separated_number);
                    }

                    target.prop('number', now).text(separated_number);
                };
            }
        }
    };

    $.fn.animateNumber = function() {
        var options = arguments[0],
            settings = $.extend({}, defaults, options),

            target = $(this),
            args = [settings];

        for(var i = 1, l = arguments.length; i < l; i++) {
            args.push(arguments[i]);
        }

        // needs of custom step function usage
        if (options.numberStep) {
            // assigns custom step functions
            var items = this.each(function(){
                this._animateNumberSetter = options.numberStep;
            });

            // cleanup of custom step functions after animation
            var generic_complete = settings.complete;
            settings.complete = function() {
                items.each(function(){
                    delete this._animateNumberSetter;
                });

                if ( generic_complete ) {
                    generic_complete.apply(this, arguments);
                }
            };
        }

        return target.animate.apply(target, args);
    };

}(jQuery));



/*!
 Ridiculously Responsive Social Sharing Buttons
 Team: @dbox, @joshuatuscan
 Site: http://www.kurtnoble.com/labs/rrssb
 Twitter: @therealkni

 ___           ___
 /__/|         /__/\        ___
 |  |:|         \  \:\      /  /\
 |  |:|          \  \:\    /  /:/
 __|  |:|      _____\__\:\  /__/::\
 /__/\_|:|____ /__/::::::::\ \__\/\:\__
 \  \:\/:::::/ \  \:\~~\~~\/    \  \:\/\
 \  \::/~~~~   \  \:\  ~~~      \__\::/
 \  \:\        \  \:\          /__/:/
 \  \:\        \  \:\         \__\/
 \__\/         \__\/
 */

+(function(window, $, undefined) {
    'use strict';

    var support = {
        calc : false
    };

    /*
     * Public Function
     */

    $.fn.rrssb = function( options ) {

        // Settings that $.rrssb() will accept.
        var settings = $.extend({
            description: undefined,
            emailAddress: undefined,
            emailBody: undefined,
            emailSubject: undefined,
            image: undefined,
            title: undefined,
            url: undefined
        }, options );

        // Return the encoded strings if the settings have been changed.
        for (var key in settings) {
            if (settings.hasOwnProperty(key) && settings[key] !== undefined) {
                settings[key] = encodeString(settings[key]);
            }
        };

        if (settings.url !== undefined) {
            $(this).find('.rrssb-facebook a').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + settings.url);
            $(this).find('.rrssb-tumblr a').attr('href', 'http://tumblr.com/share/link?url=' + settings.url + (settings.title !== undefined ? '&name=' + settings.title : '')  + (settings.description !== undefined ? '&description=' + settings.description : ''));
            $(this).find('.rrssb-linkedin a').attr('href', 'http://www.linkedin.com/shareArticle?mini=true&url=' + settings.url + (settings.title !== undefined ? '&title=' + settings.title : '') + (settings.description !== undefined ? '&summary=' + settings.description : ''));
            $(this).find('.rrssb-twitter a').attr('href', 'http://twitter.com/home?status=' + (settings.description !== undefined ? settings.description : '') + '%20' + settings.url);
            $(this).find('.rrssb-hackernews a').attr('href', 'https://news.ycombinator.com/submitlink?u=' + settings.url + (settings.title !== undefined ? '&text=' + settings.title : ''));
            $(this).find('.rrssb-reddit a').attr('href', 'http://www.reddit.com/submit?url=' + settings.url + (settings.description !== undefined ? '&text=' + settings.description : '') + (settings.title !== undefined ? '&title=' + settings.title : ''));
            $(this).find('.rrssb-googleplus a').attr('href', 'https://plus.google.com/share?url=' + (settings.description !== undefined ? settings.description : '') + '%20' + settings.url);
            $(this).find('.rrssb-pinterest a').attr('href', 'http://pinterest.com/pin/create/button/?url=' + settings.url + ((settings.image !== undefined) ? '&amp;media=' + settings.image : '') + (settings.description !== undefined ? '&amp;description=' + settings.description : ''));
            $(this).find('.rrssb-pocket a').attr('href', 'https://getpocket.com/save?url=' + settings.url);
            $(this).find('.rrssb-github a').attr('href', settings.url);
        }

        if (settings.emailAddress !== undefined) {
            $(this).find('.rrssb-email a').attr('href', 'mailto:' + settings.emailAddress + '?' + (settings.emailSubject !== undefined ? 'subject=' + settings.emailSubject : '') + (settings.emailBody !== undefined ? '&amp;body=' + settings.emailBody : ''));
        }

    };

    /*
     * Utility functions
     */
    var detectCalcSupport = function(){
        //detect if calc is natively supported.
        var el = $('<div>');
        var calcProps = [
            'calc',
            '-webkit-calc',
            '-moz-calc'
        ];

        $('body').append(el);

        for (var i=0; i < calcProps.length; i++) {
            el.css('width', calcProps[i] + '(1px)');
            if(el.width() === 1){
                support.calc = calcProps[i];
                break;
            }
        }

        el.remove();
    };

    var encodeString = function(string) {
        // Recursively decode string first to ensure we aren't double encoding.
        if (string !== undefined && string !== null) {
            if (string.match(/%[0-9a-f]{2}/i) !== null) {
                string = decodeURIComponent(string);
                encodeString(string);
            } else {
                return encodeURIComponent(string);
            }
        }
    };

    var setPercentBtns = function() {
        // loop through each instance of buttons
        $('.rrssb-buttons').each(function(index) {
            var self = $(this);
            var buttons = $('li:visible', self);
            var numOfButtons = buttons.length;
            var initBtnWidth = 100 / numOfButtons;

            // set initial width of buttons
            buttons.css('width', initBtnWidth + '%').attr('data-initwidth',initBtnWidth);
        });
    };

    var makeExtremityBtns = function() {
        // loop through each instance of buttons
        $('.rrssb-buttons').each(function(index) {
            var self = $(this);
            //get button width
            var containerWidth = self.width();
            var buttonWidth = $('li', self).not('.small').first().width();

            // enlarge buttons if they get wide enough
            if (buttonWidth > 170 && $('li.small', self).length < 1) {
                self.addClass('large-format');
            } else {
                self.removeClass('large-format');
            }

            if (containerWidth < 200) {
                self.removeClass('small-format').addClass('tiny-format');
            } else {
                self.removeClass('tiny-format');
            }
        });
    };

    var backUpFromSmall = function() {
        // loop through each instance of buttons
        $('.rrssb-buttons').each(function(index) {
            var self = $(this);

            var buttons = $('li', self);
            var smallButtons = buttons.filter('.small');
            var totalBtnSze = 0;
            var totalTxtSze = 0;
            var upCandidate = smallButtons.first();
            var nextBackUp = parseFloat(upCandidate.attr('data-size')) + 55;
            var smallBtnCount = smallButtons.length;

            if (smallBtnCount === buttons.length) {
                var btnCalc = smallBtnCount * 42;
                var containerWidth = self.width();

                if ((btnCalc + nextBackUp) < containerWidth) {
                    self.removeClass('small-format');
                    smallButtons.first().removeClass('small');

                    sizeSmallBtns();
                }

            } else {
                buttons.not('.small').each(function(index) {
                    var button = $(this);
                    var txtWidth = parseFloat(button.attr('data-size')) + 55;
                    var btnWidth = parseFloat(button.width());

                    totalBtnSze = totalBtnSze + btnWidth;
                    totalTxtSze = totalTxtSze + txtWidth;
                });

                var spaceLeft = totalBtnSze - totalTxtSze;

                if (nextBackUp < spaceLeft) {
                    upCandidate.removeClass('small');
                    sizeSmallBtns();
                }
            }
        });
    };

    var checkSize = function(init) {
        // loop through each instance of buttons
        $('.rrssb-buttons').each(function(index) {

            var self = $(this);
            var buttons = $('li', self);

            // get buttons in reverse order and loop through each
            $(buttons.get().reverse()).each(function(index, count) {

                var button = $(this);

                if (button.hasClass('small') === false) {
                    var txtWidth = parseFloat(button.attr('data-size')) + 55;
                    var btnWidth = parseFloat(button.width());

                    if (txtWidth > btnWidth) {
                        var btn2small = buttons.not('.small').last();
                        $(btn2small).addClass('small');
                        sizeSmallBtns();
                    }
                }

                if (!--count) backUpFromSmall();
            });
        });

        // if first time running, put it through the magic layout
        if (init === true) {
            rrssbMagicLayout(sizeSmallBtns);
        }
    };

    var sizeSmallBtns = function() {
        // loop through each instance of buttons
        $('.rrssb-buttons').each(function(index) {
            var self = $(this);
            var regButtonCount;
            var regPercent;
            var pixelsOff;
            var magicWidth;
            var smallBtnFraction;
            var buttons = $('li', self);
            var smallButtons = buttons.filter('.small');

            // readjust buttons for small display
            var smallBtnCount = smallButtons.length;

            // make sure there are small buttons
            if (smallBtnCount > 0 && smallBtnCount !== buttons.length) {
                self.removeClass('small-format');

                //make sure small buttons are square when not all small
                smallButtons.css('width','42px');
                pixelsOff = smallBtnCount * 42;
                regButtonCount = buttons.not('.small').length;
                regPercent = 100 / regButtonCount;
                smallBtnFraction = pixelsOff / regButtonCount;

                // if calc is not supported. calculate the width on the fly.
                if (support.calc === false) {
                    magicWidth = ((self.innerWidth()-1) / regButtonCount) - smallBtnFraction;
                    magicWidth = Math.floor(magicWidth*1000) / 1000;
                    magicWidth += 'px';
                } else {
                    magicWidth = support.calc+'('+regPercent+'% - '+smallBtnFraction+'px)';
                }

                buttons.not('.small').css('width', magicWidth);

            } else if (smallBtnCount === buttons.length) {
                // if all buttons are small, change back to percentage
                self.addClass('small-format');
                setPercentBtns();
            } else {
                self.removeClass('small-format');
                setPercentBtns();
            }
        }); //end loop

        makeExtremityBtns();
    };

    var rrssbInit = function() {
        $('.rrssb-buttons').each(function(index) {
            $(this).addClass('rrssb-'+(index + 1));
        });

        detectCalcSupport();

        setPercentBtns();

        // grab initial text width of each button and add as data attr
        $('.rrssb-buttons li .rrssb-text').each(function(index) {
            var buttonTxt = $(this);
            var txtWdth = buttonTxt.width();
            buttonTxt.closest('li').attr('data-size', txtWdth);
        });

        checkSize(true);
    };

    var rrssbMagicLayout = function(callback) {
        //remove small buttons before each conversion try
        $('.rrssb-buttons li.small').removeClass('small');

        checkSize();

        callback();
    };

    var popupCenter = function(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 3) - (h / 3)) + dualScreenTop;

        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    };

    var waitForFinalEvent = (function () {
        var timers = {};
        return function (callback, ms, uniqueId) {
            if (!uniqueId) {
                uniqueId = "Don't call this twice without a uniqueId";
            }
            if (timers[uniqueId]) {
                clearTimeout (timers[uniqueId]);
            }
            timers[uniqueId] = setTimeout(callback, ms);
        };
    })();

    // init load
    $(document).ready(function(){
        /*
         * Event listners
         */

        $(document).on('click', '.rrssb-buttons a.popup', {}, function popUp(e) {
            var self = $(this);
            popupCenter(self.attr('href'), self.find('.rrssb-text').html(), 580, 470);
            e.preventDefault();
        });

        // resize function
        $(window).resize(function () {

            rrssbMagicLayout(sizeSmallBtns);

            waitForFinalEvent(function(){
                rrssbMagicLayout(sizeSmallBtns);
            }, 200, "finished resizing");
        });

        rrssbInit();
    });

    // Make global
    window.rrssbInit = rrssbInit;

})(window, jQuery);


/***********
 Animates element's number to new number with commas
 Parameters:
 commas (boolean): turn commas on/off (default is true)
 duration (number): how long in ms (default is 1000)
 ease (string): type of easing (default is "swing", others are avaiable from jQuery's easing plugin
 Examples:
 $("#div").animateNumbers(false, 500, "linear"); // half second linear without commas
 $("#div").animateNumbers(true, 2000); // two second swing with commas
 $("#div").animateNumbers(); // one second swing with commas
 This fully expects an element containing an integer and with a attribute named data-stop specifying the number at which the stats needs to stop
 If the number is within copy then separate it with a span and target the span
 Inserts and accounts for commas during animation by default
 ***********/

(function($) {
    $.fn.animateNumbers = function(commas, duration, ease) {
        return this.each(function() {
            var $this = $(this);
            var start = parseInt($this.text().replace(/,/g, ""));
            var stop = parseInt($this.attr('data-stop').replace(/,/g, ""));
            commas = (commas === undefined) ? true : commas;
            $({value: start}).animate({value: stop}, {
                duration: duration == undefined ? 1000 : duration,
                easing: ease == undefined ? "swing" : ease,
                step: function() {
                    $this.text(Math.floor(this.value));
                    if (commas) { $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); }
                },
                complete: function() {
                    if (parseInt($this.text()) !== stop) {
                        $this.text(stop);
                        if (commas) { $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); }
                    }
                }
            });
        });
    };
})(jQuery);



/**!
 * easyPieChart
 * Lightweight plugin to render simple, animated and retina optimized pie charts
 *
 * @license Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 * @author Robert Fleischmann <rendro87@gmail.com> (http://robert-fleischmann.de)
 * @version 2.1.1
 **/
!function(a,b){"object"==typeof exports?module.exports=b(require("jquery")):"function"==typeof define&&define.amd?define("EasyPieChart",["jquery"],b):b(a.jQuery)}(this,function(a){var b=function(a,b){var c,d=document.createElement("canvas");"undefined"!=typeof G_vmlCanvasManager&&G_vmlCanvasManager.initElement(d);var e=d.getContext("2d");d.width=d.height=b.size,a.appendChild(d);var f=1;window.devicePixelRatio>1&&(f=window.devicePixelRatio,d.style.width=d.style.height=[b.size,"px"].join(""),d.width=d.height=b.size*f,e.scale(f,f)),e.translate(b.size/2,b.size/2),e.rotate((-0.5+b.rotate/180)*Math.PI);var g=(b.size-b.lineWidth)/2;b.scaleColor&&b.scaleLength&&(g-=b.scaleLength+2),Date.now=Date.now||function(){return+new Date};var h=function(a,b,c){c=Math.min(Math.max(0,c||1),1),e.beginPath(),e.arc(0,0,g,0,2*Math.PI*c,!1),e.strokeStyle=a,e.lineWidth=b,e.stroke()},i=function(){var a,c,d=24;e.lineWidth=1,e.fillStyle=b.scaleColor,e.save();for(var d=24;d>0;--d)0===d%6?(c=b.scaleLength,a=0):(c=.6*b.scaleLength,a=b.scaleLength-c),e.fillRect(-b.size/2+a,0,c,1),e.rotate(Math.PI/12);e.restore()},j=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||function(a){window.setTimeout(a,1e3/60)}}(),k=function(){b.scaleColor&&i(),b.trackColor&&h(b.trackColor,b.lineWidth)};this.clear=function(){e.clearRect(b.size/-2,b.size/-2,b.size,b.size)},this.draw=function(a){b.scaleColor||b.trackColor?e.getImageData&&e.putImageData?c?e.putImageData(c,0,0):(k(),c=e.getImageData(0,0,b.size*f,b.size*f)):(this.clear(),k()):this.clear(),e.lineCap=b.lineCap;var d;d="function"==typeof b.barColor?b.barColor(a):b.barColor,a>0&&h(d,b.lineWidth,a/100)}.bind(this),this.animate=function(a,c){var d=Date.now();b.onStart(a,c);var e=function(){var f=Math.min(Date.now()-d,b.animate),g=b.easing(this,f,a,c-a,b.animate);this.draw(g),b.onStep(a,c,g),f>=b.animate?b.onStop(a,c):j(e)}.bind(this);j(e)}.bind(this)},c=function(a,c){var d={barColor:"#ef1e25",trackColor:"#f9f9f9",scaleColor:"#dfe0e0",scaleLength:5,lineCap:"round",lineWidth:3,size:110,rotate:0,animate:1e3,easing:function(a,b,c,d,e){return b/=e/2,1>b?d/2*b*b+c:-d/2*(--b*(b-2)-1)+c},onStart:function(){},onStep:function(){},onStop:function(){}};if("undefined"!=typeof b)d.renderer=b;else{if("undefined"==typeof SVGRenderer)throw new Error("Please load either the SVG- or the CanvasRenderer");d.renderer=SVGRenderer}var e={},f=0,g=function(){this.el=a,this.options=e;for(var b in d)d.hasOwnProperty(b)&&(e[b]=c&&"undefined"!=typeof c[b]?c[b]:d[b],"function"==typeof e[b]&&(e[b]=e[b].bind(this)));e.easing="string"==typeof e.easing&&"undefined"!=typeof jQuery&&jQuery.isFunction(jQuery.easing[e.easing])?jQuery.easing[e.easing]:d.easing,this.renderer=new e.renderer(a,e),this.renderer.draw(f),a.dataset&&a.dataset.percent?this.update(parseFloat(a.dataset.percent)):a.getAttribute&&a.getAttribute("data-percent")&&this.update(parseFloat(a.getAttribute("data-percent")))}.bind(this);this.update=function(a){return a=parseFloat(a),e.animate?this.renderer.animate(f,a):this.renderer.draw(a),f=a,this}.bind(this),g()};a.fn.easyPieChart=function(b){return this.each(function(){a.data(this,"easyPieChart")||a.data(this,"easyPieChart",new c(this,b))})}});


/*global jQuery */
/*!
 * FitVids 1.0
 *
 * Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 *
 * Date: Thu Sept 01 18:00:00 2011 -0500
 */

(function( $ ){

    $.fn.fitVids = function( options ) {
        var settings = {
            customSelector: null
        }

        var div = document.createElement('div'),
            ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0];

        div.className = 'fit-vids-style';
        div.innerHTML = '&shy;<style>         \
      .fluid-width-video-wrapper {        \
         width: 100%;                     \
         position: relative;              \
         padding: 0;                      \
      }                                   \
                                          \
      .fluid-width-video-wrapper iframe,  \
      .fluid-width-video-wrapper object,  \
      .fluid-width-video-wrapper embed {  \
         position: absolute;              \
         top: 0;                          \
         left: 0;                         \
         width: 100%;                     \
         height: 100%;                    \
      }                                   \
    </style>';

        ref.parentNode.insertBefore(div,ref);

        if ( options ) {
            $.extend( settings, options );
        }

        return this.each(function(){
            var selectors = [
                "iframe[src*='player.vimeo.com']",
                "iframe[src*='www.youtube.com']",
                "iframe[src*='www.kickstarter.com']",
                "object",
                "embed"
            ];

            if (settings.customSelector) {
                selectors.push(settings.customSelector);
            }

            var $allVideos = $(this).find(selectors.join(','));

            $allVideos.each(function(){
                var $this = $(this);
                if (this.tagName.toLowerCase() == 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
                var height = ( this.tagName.toLowerCase() == 'object' || $this.attr('height') ) ? $this.attr('height') : $this.height(),
                    width = $this.attr('width') ? $this.attr('width') : $this.width(),
                    aspectRatio = height / width;
                if(!$this.attr('id')){
                    var videoID = 'fitvid' + Math.floor(Math.random()*999999);
                    $this.attr('id', videoID);
                }
                $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
                $this.removeAttr('height').removeAttr('width');
            });
        });
    }
})( jQuery );


/*!
 * jQuery Smooth Scroll - v1.5.3 - 2014-10-15
 * https://github.com/kswedberg/jquery-smooth-scroll
 * Copyright (c) 2014 Karl Swedberg
 * Licensed MIT (https://github.com/kswedberg/jquery-smooth-scroll/blob/master/LICENSE-MIT)
 */

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var version = '1.5.3',
        optionOverrides = {},
        defaults = {
            exclude: [],
            excludeWithin:[],
            offset: 0,

            // one of 'top' or 'left'
            direction: 'top',

            // jQuery set of elements you wish to scroll (for $.smoothScroll).
            //  if null (default), $('html, body').firstScrollable() is used.
            scrollElement: null,

            // only use if you want to override default behavior
            scrollTarget: null,

            // fn(opts) function to be called before scrolling occurs.
            // `this` is the element(s) being scrolled
            beforeScroll: function() {},

            // fn(opts) function to be called after scrolling occurs.
            // `this` is the triggering element
            afterScroll: function() {},
            easing: 'swing',
            speed: 400,

            // coefficient for "auto" speed
            autoCoefficient: 2,

            // $.fn.smoothScroll only: whether to prevent the default click action
            preventDefault: true
        },

        getScrollable = function(opts) {
            var scrollable = [],
                scrolled = false,
                dir = opts.dir && opts.dir === 'left' ? 'scrollLeft' : 'scrollTop';

            this.each(function() {

                if (this === document || this === window) { return; }
                var el = $(this);
                if ( el[dir]() > 0 ) {
                    scrollable.push(this);
                } else {
                    // if scroll(Top|Left) === 0, nudge the element 1px and see if it moves
                    el[dir](1);
                    scrolled = el[dir]() > 0;
                    if ( scrolled ) {
                        scrollable.push(this);
                    }
                    // then put it back, of course
                    el[dir](0);
                }
            });

            // If no scrollable elements, fall back to <body>,
            // if it's in the jQuery collection
            // (doing this because Safari sets scrollTop async,
            // so can't set it to 1 and immediately get the value.)
            if (!scrollable.length) {
                this.each(function() {
                    if (this.nodeName === 'BODY') {
                        scrollable = [this];
                    }
                });
            }

            // Use the first scrollable element if we're calling firstScrollable()
            if ( opts.el === 'first' && scrollable.length > 1 ) {
                scrollable = [ scrollable[0] ];
            }

            return scrollable;
        };

    $.fn.extend({
        scrollable: function(dir) {
            var scrl = getScrollable.call(this, {dir: dir});
            return this.pushStack(scrl);
        },
        firstScrollable: function(dir) {
            var scrl = getScrollable.call(this, {el: 'first', dir: dir});
            return this.pushStack(scrl);
        },

        smoothScroll: function(options, extra) {
            options = options || {};

            if ( options === 'options' ) {
                if ( !extra ) {
                    return this.first().data('ssOpts');
                }
                return this.each(function() {
                    var $this = $(this),
                        opts = $.extend($this.data('ssOpts') || {}, extra);

                    $(this).data('ssOpts', opts);
                });
            }

            var opts = $.extend({}, $.fn.smoothScroll.defaults, options),
                locationPath = $.smoothScroll.filterPath(location.pathname);

            this
                .unbind('click.smoothscroll')
                .bind('click.smoothscroll', function(event) {
                    var link = this,
                        $link = $(this),
                        thisOpts = $.extend({}, opts, $link.data('ssOpts') || {}),
                        exclude = opts.exclude,
                        excludeWithin = thisOpts.excludeWithin,
                        elCounter = 0, ewlCounter = 0,
                        include = true,
                        clickOpts = {},
                        hostMatch = ((location.hostname === link.hostname) || !link.hostname),
                        pathMatch = thisOpts.scrollTarget || ( $.smoothScroll.filterPath(link.pathname) === locationPath ),
                        thisHash = escapeSelector(link.hash);

                    if ( !thisOpts.scrollTarget && (!hostMatch || !pathMatch || !thisHash) ) {
                        include = false;
                    } else {
                        while (include && elCounter < exclude.length) {
                            if ($link.is(escapeSelector(exclude[elCounter++]))) {
                                include = false;
                            }
                        }
                        while ( include && ewlCounter < excludeWithin.length ) {
                            if ($link.closest(excludeWithin[ewlCounter++]).length) {
                                include = false;
                            }
                        }
                    }

                    if ( include ) {

                        if ( thisOpts.preventDefault ) {
                            event.preventDefault();
                        }

                        $.extend( clickOpts, thisOpts, {
                            scrollTarget: thisOpts.scrollTarget || thisHash,
                            link: link
                        });

                        $.smoothScroll( clickOpts );
                    }
                });

            return this;
        }
    });

    $.smoothScroll = function(options, px) {
        if ( options === 'options' && typeof px === 'object' ) {
            return $.extend(optionOverrides, px);
        }
        var opts, $scroller, scrollTargetOffset, speed, delta,
            scrollerOffset = 0,
            offPos = 'offset',
            scrollDir = 'scrollTop',
            aniProps = {},
            aniOpts = {};

        if (typeof options === 'number') {
            opts = $.extend({link: null}, $.fn.smoothScroll.defaults, optionOverrides);
            scrollTargetOffset = options;
        } else {
            opts = $.extend({link: null}, $.fn.smoothScroll.defaults, options || {}, optionOverrides);
            if (opts.scrollElement) {
                offPos = 'position';
                if (opts.scrollElement.css('position') === 'static') {
                    opts.scrollElement.css('position', 'relative');
                }
            }
        }

        scrollDir = opts.direction === 'left' ? 'scrollLeft' : scrollDir;

        if ( opts.scrollElement ) {
            $scroller = opts.scrollElement;
            if ( !(/^(?:HTML|BODY)$/).test($scroller[0].nodeName) ) {
                scrollerOffset = $scroller[scrollDir]();
            }
        } else {
            $scroller = $('html, body').firstScrollable(opts.direction);
        }

        // beforeScroll callback function must fire before calculating offset
        opts.beforeScroll.call($scroller, opts);

        scrollTargetOffset = (typeof options === 'number') ? options :
            px ||
                ( $(opts.scrollTarget)[offPos]() &&
                    $(opts.scrollTarget)[offPos]()[opts.direction] ) ||
                0;

        aniProps[scrollDir] = scrollTargetOffset + scrollerOffset + opts.offset;
        speed = opts.speed;

        // automatically calculate the speed of the scroll based on distance / coefficient
        if (speed === 'auto') {

            // $scroller.scrollTop() is position before scroll, aniProps[scrollDir] is position after
            // When delta is greater, speed will be greater.
            delta = aniProps[scrollDir] - $scroller.scrollTop();
            if(delta < 0) {
                delta *= -1;
            }

            // Divide the delta by the coefficient
            speed = delta / opts.autoCoefficient;
        }

        aniOpts = {
            duration: speed,
            easing: opts.easing,
            complete: function() {
                opts.afterScroll.call(opts.link, opts);
            }
        };

        if (opts.step) {
            aniOpts.step = opts.step;
        }

        if ($scroller.length) {
            $scroller.stop().animate(aniProps, aniOpts);
        } else {
            opts.afterScroll.call(opts.link, opts);
        }
    };

    $.smoothScroll.version = version;
    $.smoothScroll.filterPath = function(string) {
        string = string || '';
        return string
            .replace(/^\//,'')
            .replace(/(?:index|default).[a-zA-Z]{3,4}$/,'')
            .replace(/\/$/,'');
    };

    // default options
    $.fn.smoothScroll.defaults = defaults;

    function escapeSelector (str) {
        return str.replace(/(:|\.)/g,'\\$1');
    }

}));

