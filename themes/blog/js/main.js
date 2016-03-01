
function onBeforeScroll(obj) {
    "use strict";
    var currentTimeago = jQuery(this).parent().parent().next().children(".current");
    currentTimeago.fadeOut(obj.scroll.duration, function() {
        jQuery(this).removeClass("current");
        if (obj.scroll.direction == "next") {
            if (jQuery(this).next().length) jQuery(this).next().fadeIn(obj.scroll.duration).addClass("current");
            else
                jQuery(this).parent().children().first().fadeIn(obj.scroll.duration).addClass("current");
        } else {
            if (jQuery(this).prev().length) jQuery(this).prev().fadeIn(obj.scroll.duration).addClass("current");
            else
                jQuery(this).parent().children().last().fadeIn(obj.scroll.duration).addClass("current");
        }
    });
}
var menu_position = null;
jQuery(document).ready(function($) {
    "use strict";
    $(".slider").each(function(index) {
        var autoplay = 0;
        var pause_on_hover = 0;
        var interval = 5000;
        var effect = "scroll";
        var easing = "easeInOutQuint";
        var duration = 750;
        var elementClasses = $(this).attr('class').split(' ');
        for (var i = 0; i < elementClasses.length; i++) {
            if (elementClasses[i].indexOf('autoplay-') != -1) autoplay = elementClasses[i].replace('autoplay-', '');
            if (elementClasses[i].indexOf('pause_on_hover-') != -1) pause_on_hover = elementClasses[i].replace('pause_on_hover-', '');
            if (elementClasses[i].indexOf('interval-') != -1) interval = elementClasses[i].replace('interval-', '');
        }
        var carouselOptions = {
            responsive: false,
            width: "100%",
            items: {
                start: (config.is_rtl ? -2 : -1),
                visible: 3,
                minimum: 3
            },
            scroll: {
                items: 1,
                easing: easing,
                duration: parseInt(duration),
                fx: effect
            },
            auto: {
                play: (parseInt(autoplay) ? true : false),
                timeoutDuration: parseInt(interval),
                pauseDuration: parseInt(interval),
                pauseOnHover: (parseInt(pause_on_hover) ? true : false)
            }
        };
        $(this).carouFredSel(carouselOptions, {
            transition: true,
            wrapper: {
                classname: "caroufredsel_wrapper caroufredsel_wrapper_slider"
            }
        });
        if ($(this).children().length > 1) {
            $(this).sliderControl({
                appendTo: $(".slider_content_box"),
                listContainer: $(".slider_posts_list_container"),
                listItems: ($(".main").width() > 768 ? 4 : 2)
            });
        }
    });
    var controlBySlideLeft = function(param) {
        var self = $(this);
        var index = (typeof(param.data) != "undefined" ? param.data.index : param);
        $("#" + self.parent().attr("id").replace("control-by-", "")).trigger("isScrolling", function(isScrolling) {
            if (!isScrolling) {
                var controlFor = $(".control-for-" + self.parent().attr("id").replace("control-by-", ""));
                var currentIndex = controlFor.children().index(controlFor.children(".current"));
                if (currentIndex == 0) {
                    controlFor.trigger("prevPage");
                    if (controlFor.children(".current").prev().length) controlFor.children(".current").removeClass("current").prev().addClass("current");
                    else {
                        controlFor.children(".current").removeClass("current");
                        controlFor.children(":last").addClass("current");
                    }
                } else if (currentIndex > controlFor.triggerHandler("currentVisible").length + 1) {
                    var slideToIndex = parseInt($(this).children(":first").attr("id").replace("horizontal_slide_" + index + "_", ""));
                    if (slideToIndex == 0) slideToIndex = controlFor.children().length - 1;
                    else
                        slideToIndex--;
                    controlFor.trigger("slideTo", [slideToIndex, {
                        onAfter: function() {
                            controlFor.children(".current").removeClass("current");
                            controlFor.children(":first").addClass("current");
                        }
                    }]);
                } else
                    controlFor.children(".current").removeClass("current").prev().addClass("current");
            }
        });
    };
    var controlBySlideRight = function(param) {
        var self = $(this);
        var index = (typeof(param.data) != "undefined" ? param.data.index : param);
        $("#" + self.parent().attr("id").replace("control-by-", "")).trigger("isScrolling", function(isScrolling) {
            if (!isScrolling) {
                var controlFor = $(".control-for-" + self.parent().attr("id").replace("control-by-", ""));
                var currentIndex = controlFor.children().index(controlFor.children(".current"));
                if (currentIndex == controlFor.triggerHandler("currentVisible").length) {
                    controlFor.trigger("nextPage");
                    controlFor.children(".current").removeClass("current").next().addClass("current");
                } else if (currentIndex > controlFor.triggerHandler("currentVisible").length) {
                    var slideToIndex = parseInt($(this).children(":first").attr("id").replace("horizontal_slide_" + index + "_", ""));
                    if (slideToIndex == controlFor.children().length - 1) slideToIndex = 0;
                    else
                        slideToIndex++;
                    controlFor.trigger("slideTo", slideToIndex);
                    controlFor.children(".current").removeClass("current");
                    controlFor.children(":first").addClass("current");
                } else {
                    if (controlFor.children(".current").next().length) controlFor.children(".current").removeClass("current").next().addClass("current");
                    else {
                        controlFor.children(".current").removeClass("current");
                        controlFor.children(":first").addClass("current");
                    }
                }
            }
        });
    };
    var horizontalCarousel = function() {
        $(".horizontal_carousel").each(function(index) {
            $(this).addClass("pr_preloader_" + index);
            $(".pr_preloader_" + index).before("<span class='pr_preloader'></span>");
            $(".pr_preloader_" + index + " img:first").one("load", function() {
                $(".pr_preloader_" + index).prev(".pr_preloader").remove();
                $(".pr_preloader_" + index).fadeTo("slow", 1, function() {
                    $(this).css("opacity", "");
                });
                var visible = 3;
                var autoplay = 0;
                var pause_on_hover = 0;
                var scroll = 1;
                var effect = "scroll";
                var easing = "easeInOutQuint";
                var duration = 750;
                var navigation = 1;
                var control_for = "";
                var elementClasses = $(".pr_preloader_" + index).attr('class').split(' ');
                for (var i = 0; i < elementClasses.length; i++) {
                    if (elementClasses[i].indexOf('visible-') != -1) visible = elementClasses[i].replace('visible-', '');
                    if (elementClasses[i].indexOf('autoplay-') != -1) autoplay = elementClasses[i].replace('autoplay-', '');
                    if (elementClasses[i].indexOf('pause_on_hover-') != -1) pause_on_hover = elementClasses[i].replace('pause_on_hover-', '');
                    if (elementClasses[i].indexOf('scroll-') != -1) scroll = elementClasses[i].replace('scroll-', '');
                    if (elementClasses[i].indexOf('effect-') != -1) effect = elementClasses[i].replace('effect-', '');
                    if (elementClasses[i].indexOf('easing-') != -1) easing = elementClasses[i].replace('easing-', '');
                    if (elementClasses[i].indexOf('duration-') != -1) duration = elementClasses[i].replace('duration-', '');
                    if (elementClasses[i].indexOf('navigation-') != -1) navigation = elementClasses[i].replace('navigation-', '');
                    if (elementClasses[i].indexOf('control-for-') != -1) control_for = elementClasses[i].replace('control-for-', '');
                }
                var length = $(this).children().length;
                if (length < visible) visible = length;
                var carouselOptions = {
                    items: {
                        visible: parseInt(visible, 10)
                    },
                    scroll: {
                        items: parseInt(scroll),
                        fx: effect,
                        easing: easing,
                        duration: parseInt(duration),
                        pauseOnHover: (parseInt(pause_on_hover) ? true : false),
                        onAfter: function() {
                            var popup = false;
                            if (typeof($(this).attr("id")) != "undefined") {
                                var split = $(this).attr("id").split("-");
                                if (split[split.length - 1] == "popup") popup = true;
                            }
                            if (popup) var scroll = $(".gallery_popup").scrollTop();
                            $(this).trigger('configuration', [{
                                scroll: {
                                    easing: "easeInOutQuint",
                                    duration: 750
                                }
                            }, true]);
                            if ($(".control-for-" + $(this).attr("id")).length) {
                                $(".control-for-" + $(this).attr("id")).trigger("configuration", {
                                    scroll: {
                                        easing: "easeInOutQuint",
                                        duration: 750
                                    }
                                });
                            }
                            if (popup) $(".gallery_popup").scrollTop(scroll);
                        }
                    },
                    auto: {
                        items: parseInt(scroll),
                        play: (parseInt(autoplay) ? true : false),
                        fx: effect,
                        easing: easing,
                        duration: parseInt(duration),
                        pauseOnHover: (parseInt(pause_on_hover) ? true : false),
                        onAfter: null
                    }
                };
                $(".pr_preloader_" + index).carouFredSel(carouselOptions, {
                    wrapper: {
                        classname: "caroufredsel_wrapper caroufredsel_wrapper_hortizontal_carousel"
                    }
                });
                if (parseInt(navigation)) {
                    $(".pr_preloader_" + index).parent().before("<a class='slider_control left slider_control_" + index + "' href='#' title='prev'></a>");
                    $(".pr_preloader_" + index).parent().after("<a class='slider_control right slider_control_" + index + "' href='#' title='next'></a>");
                    $(".pr_preloader_" + index).parent().parent().hover(function() {
                        $(".horizontal_carousel_container .left.slider_control_" + index).removeClass("slideRightBack").addClass("slideRight");
                        $(".horizontal_carousel_container .right.slider_control_" + index).removeClass("slideLeftBack").addClass("slideLeft");
                        $(".horizontal_carousel_container .pr_preloader_" + index + " .fullscreen").removeClass("slideRightBack").addClass("slideRight");
                    }, function() {
                        $(".horizontal_carousel_container .left.slider_control_" + index).removeClass("slideRight").addClass("slideRightBack");
                        $(".horizontal_carousel_container .right.slider_control_" + index).removeClass("slideLeft").addClass("slideLeftBack");
                        $(".horizontal_carousel_container .pr_preloader_" + index + " .fullscreen").removeClass("slideRight").addClass("slideRightBack");
                    });
                }
                $(".pr_preloader_" + index).trigger('configuration', ['prev', {
                    button: $(".horizontal_carousel_container .left.slider_control_" + index)
                }, false]);
                $(".pr_preloader_" + index).trigger('configuration', ['next', {
                    button: $(".horizontal_carousel_container .right.slider_control_" + index)
                }, false]);
                $(".pr_preloader_" + index + " li img").css("display", "block");
                $(".pr_preloader_" + index + " li .icon").css("display", "block");
                $(".pr_preloader_" + index).trigger('configuration', ['debug', false, true]);
                var self = $(".pr_preloader_" + index);
                var base = "x";
                var scrollOptions = {
                    scroll: {
                        easing: "linear",
                        duration: 200
                    }
                };
                self.swipe({
                    fallbackToMouseEvents: false,
                    allowPageScroll: "vertical",
                    excludedElements: "button, input, select, textarea, .noSwipe",
                    swipeStatus: function(event, phase, direction, distance, fingerCount, fingerData) {
                        if (!self.is(":animated")) {
                            self.trigger("isScrolling", function(isScrolling) {
                                if (!isScrolling) {
                                    if (phase == "move" && (direction == "left" || direction == "right")) {
                                        if (base == "x") {
                                            if ($(".gallery_popup").is(":visible")) var scroll = $(".gallery_popup").scrollTop();
                                            self.trigger("configuration", scrollOptions);
                                            if ($(".control-for-" + self.attr("id")).length) $(".control-for-" + self.attr("id")).trigger("configuration", scrollOptions);
                                            if ($(".gallery_popup").is(":visible")) $(".gallery_popup").scrollTop(scroll);
                                            self.trigger("pause");
                                        }
                                        if (direction == "left") {
                                            if (base == "x") base = 0;
                                            self.css("left", parseInt(base) - distance + "px");
                                        } else if (direction == "right") {
                                            if (base == "x" || base == 0) {
                                                self.children().last().prependTo(self);
                                                base = -self.children().first().width() - parseInt(self.children().first().css("margin-right"));
                                            }
                                            self.css("left", base + distance + "px");
                                        }
                                    } else if (phase == "cancel") {
                                        if (distance != 0) {
                                            self.trigger("play");
                                            self.animate({
                                                "left": base + "px"
                                            }, 750, "easeInOutQuint", function() {
                                                if ($(".gallery_popup").is(":visible")) var scroll = $(".gallery_popup").scrollTop();
                                                if (base == -self.children().first().width() - parseInt(self.children().first().css("margin-right"))) {
                                                    self.children().first().appendTo(self);
                                                    self.css("left", "0px");
                                                    base = "x";
                                                }
                                                self.trigger("configuration", {
                                                    scroll: {
                                                        easing: "easeInOutQuint",
                                                        duration: 750
                                                    }
                                                });
                                                if ($(".control-for-" + self.attr("id")).length) $(".control-for-" + self.attr("id")).trigger("configuration", {
                                                    scroll: {
                                                        easing: "easeInOutQuint",
                                                        duration: 750
                                                    }
                                                });
                                                if ($(".gallery_popup").is(":visible")) $(".gallery_popup").scrollTop(scroll);
                                            });
                                        }
                                    } else if (phase == "end") {
                                        self.trigger("play");
                                        if (direction == "right") {
                                            if (typeof(self.parent().parent().attr("id")) != "undefined" && self.parent().parent().attr("id").indexOf('control-by') == 0) {
                                                if ($(".horizontal_carousel_container .left.slider_control_" + index).length) controlBySlideLeft.call($(".horizontal_carousel_container .left.slider_control_" + index), index);
                                                else
                                                    controlBySlideLeft.call($(".pr_preloader_" + index).parent(), index);
                                            }
                                            self.animate({
                                                "left": 0 + "px"
                                            }, 200, "linear", function() {
                                                if ($(".gallery_popup").is(":visible")) var scroll = $(".gallery_popup").scrollTop();
                                                self.trigger("configuration", {
                                                    scroll: {
                                                        easing: "easeInOutQuint",
                                                        duration: 750
                                                    }
                                                });
                                                if ($(".control-for-" + self.attr("id")).length) $(".control-for-" + self.attr("id")).trigger("configuration", {
                                                    scroll: {
                                                        easing: "easeInOutQuint",
                                                        duration: 750
                                                    }
                                                });
                                                if ($(".gallery_popup").is(":visible")) $(".gallery_popup").scrollTop(scroll);
                                                base = "x";
                                            });
                                        } else if (direction == "left") {
                                            if (base == -self.children().first().width() - parseInt(self.children().first().css("margin-right"))) {
                                                self.children().first().appendTo(self);
                                                self.css("left", (parseInt(self.css("left")) - base) + "px");
                                            }
                                            if ($(".horizontal_carousel_container .right.slider_control_" + index).length) $(".horizontal_carousel_container .right.slider_control_" + index).trigger("click");
                                            else
                                                $(".horizontal_carousel_container .slider_control .right_" + index).trigger("click");
                                            base = "x";
                                        }
                                    }
                                }
                            });
                        }
                    }
                });
                $(window).trigger("resize");
                $(".pr_preloader_" + index).trigger('configuration', ['debug', false, true]);
                if (control_for != "") {
                    $(".pr_preloader_" + index).children().each(function(child_index) {
                        if (child_index == 0) $(this).addClass("current");
                        $(this).attr("id", "horizontal_slide_" + index + "_" + child_index);
                    });
                    $(".pr_preloader_" + index).children().click(function(event) {
                        event.preventDefault();
                        var self = $(this);
                        $("#" + control_for).trigger("isScrolling", function(isScrolling) {
                            if (!isScrolling) {
                                var slideIndex = self.attr("id").replace("horizontal_slide_" + index + "_", "");
                                self.parent().children().removeClass("current");
                                self.addClass("current");
                                var controlForIndex = parseInt($("#" + control_for).children(":first").attr("id").split("_")[2]);
                                $("#" + control_for).trigger("slideTo", $("#horizontal_slide_" + controlForIndex + "_" + slideIndex));
                            }
                        });
                    });
                }
                $("[id^='control-by-'] .pr_preloader_" + index).children().each(function(child_index) {
                    $(this).attr("id", "horizontal_slide_" + index + "_" + child_index);
                });
                $("[id^='control-by-'] .left.slider_control_" + index).click({
                    index: index
                }, controlBySlideLeft);
                $("[id^='control-by-'] .right.slider_control_" + index).click({
                    index: index
                }, controlBySlideRight);
            }).each(function() {
                if (this.complete) $(this).load();
            });
        });
    };
    horizontalCarousel();
    var verticalCarousel = function() {
        $(".vertical_carousel").each(function(index) {
            $(this).addClass("pr_preloader_vl_" + index);
            $(".pr_preloader_vl_" + index + " img:first").one("load", function() {
                var visible = 3;
                var autoplay = 0;
                var pause_on_hover = 0;
                var scroll = 1;
                var effect = "scroll";
                var easing = "easeInOutQuint";
                var duration = 750;
                var navigation = 1;
                var elementClasses = $(".pr_preloader_vl_" + index).attr('class').split(' ');
                for (var i = 0; i < elementClasses.length; i++) {
                    if (elementClasses[i].indexOf('visible-') != -1) visible = elementClasses[i].replace('visible-', '');
                    if (elementClasses[i].indexOf('autoplay-') != -1) autoplay = elementClasses[i].replace('autoplay-', '');
                    if (elementClasses[i].indexOf('pause_on_hover-') != -1) pause_on_hover = elementClasses[i].replace('pause_on_hover-', '');
                    if (elementClasses[i].indexOf('scroll-') != -1) scroll = elementClasses[i].replace('scroll-', '');
                    if (elementClasses[i].indexOf('effect-') != -1) effect = elementClasses[i].replace('effect-', '');
                    if (elementClasses[i].indexOf('easing-') != -1) easing = elementClasses[i].replace('easing-', '');
                    if (elementClasses[i].indexOf('duration-') != -1) duration = elementClasses[i].replace('duration-', '');
                    if (elementClasses[i].indexOf('navigation-') != -1) navigation = elementClasses[i].replace('navigation-', '');
                }
                var length = $(".pr_preloader_vl_" + index).children().length;
                if (length < visible) visible = length;
                var carouselOptions = {
                    direction: "up",
                    items: {
                        visible: parseInt(visible)
                    },
                    scroll: {
                        items: parseInt(scroll),
                        fx: effect,
                        easing: easing,
                        duration: parseInt(duration),
                        pauseOnHover: (parseInt(pause_on_hover) ? true : false)
                    },
                    auto: {
                        items: parseInt(scroll),
                        play: (parseInt(autoplay) ? true : false),
                        fx: effect,
                        easing: easing,
                        duration: parseInt(duration),
                        pauseOnHover: (parseInt(pause_on_hover) ? true : false)
                    }
                };
                $(".pr_preloader_vl_" + index).carouFredSel(carouselOptions, {
                    wrapper: {
                        classname: "caroufredsel_wrapper caroufredsel_wrapper_vertical_carousel"
                    }
                });
                if (navigation) {
                    $(".pr_preloader_vl_" + index).parent().before("<a class='slider_control up slider_control_" + index + "' href='#' title='prev'></a>");
                    $(".pr_preloader_vl_" + index).parent().after("<a class='slider_control down slider_control_" + index + "' href='#' title='next'></a>");
                    $(".pr_preloader_vl_" + index).parent().parent().hover(function() {
                        $(".vertical_carousel_container .up.slider_control_" + index).removeClass("slideDownBack").addClass("slideDown");
                        $(".vertical_carousel_container .down.slider_control_" + index).removeClass("slideUpBack").addClass("slideUp");
                    }, function() {
                        $(".vertical_carousel_container .up.slider_control_" + index).removeClass("slideDown").addClass("slideDownBack");
                        $(".vertical_carousel_container .down.slider_control_" + index).removeClass("slideUp").addClass("slideUpBack");
                    });
                }
                $(".pr_preloader_vl_" + index).trigger('configuration', ['prev', {
                    button: $(".vertical_carousel_container .up.slider_control_" + index)
                }, false]);
                $(".pr_preloader_vl_" + index).trigger('configuration', ['next', {
                    button: $(".vertical_carousel_container .down.slider_control_" + index)
                }, false]);
                $(".pr_preloader_vl_" + index + " li img").css("display", "block");
                $(".pr_preloader_vl_" + index + " li .icon").css("display", "block");
                $(".pr_preloader_vl_" + index).trigger('configuration', ['debug', false, true]);
                $(window).trigger("resize");
                $(".pr_preloader_vl_" + index).trigger('configuration', ['debug', false, true]);
            }).each(function() {
                if (this.complete) $(this).load();
            });
        });
    };
    verticalCarousel();
    
    

    function windowResize() {
        $(".slider, .small_slider, .slider_posts_list").trigger('configuration', ['debug', false, true]);
        if ($(".slider").length) {
            $(".slider").sliderControl("destroy");
            $(".slider").sliderControl({
                appendTo: $(".slider_content_box"),
                listContainer: $(".slider_posts_list_container"),
                listItems: ($(".theme_page .vc_row:not('.full_width')").width() > 462 ? 4 : 2)
            });
        }   
        
    }
    $(window).resize(windowResize);
	
});