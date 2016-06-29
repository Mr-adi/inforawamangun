if(window.top != window.self) {
    /* Header Items Order */
    jQuery.noConflict();
    var $ = jQuery;
// Load VC frontend editor

    function pixflow_customizerObj() {
        "use strict";
        var $customizerObj;
        try {
            $customizerObj = window.top;
        } catch (e) {
            $customizerObj = {};
            $customizerObj.$ = jQuery
        }
        return $customizerObj;
    }

    function pixflow_headerGrid(called) {
        'use strict';
        if (window == window.top || $('header.top-modern').length > 0 || $('header.top-logotop').length > 0) {

            return;
        }
        if ($('header:not(.header-clone) .top').length < 1) {
            return;
        }
        if (pixflow_customizerObj().$("input[data-customize-setting-link='header_styles']").val() == 'style3' && called != 'true') {
            return;
        }
        var $headerContent = $('header:not(.header-clone) .top'),
            $headerLogo = $headerContent.find('.logo'),
            $headerMenu = $headerContent.find('.navigation'),
            $headerIcons = $headerContent.find('.icons-pack'),
            $headerTopTheme = pixflow_customizerObj().$("input[data-customize-setting-link='header_theme']").val(),
            $items = [],
            $existItmes = [],
            $itemOrder = [],
            $orders = pixflow_customizerObj().$("input[data-customize-setting-link='header_items_order']").attr("value"),
            $defaults = {
                'classic': {
                    'logo': {align: 'item-left', width: 15, min: '5', max: '100'},
                    'menu': {align: 'item-right', width: 79.2, min: '40', max: '100'},
                    'icons': {align: 'item-center', width: 5.7, min: '5', max: '100'}
                },
                'block': {
                    'logo': {align: 'item-left', width: 13, min: '5', max: '100'},
                    'menu': {align: 'item-right', width: '70', min: '30', max: '100'},
                    'icons': {align: 'item-right', width: '17', min: '5', max: '100'}
                },
                'gather': {
                    'logo': {align: 'item-left', width: '80', min: '5', max: '100'},
                    'menu': {align: 'item-right', width: '5', min: '5', max: '100'},
                    'icons': {align: 'item-right', width: '15', min: '5', max: '100'}
                }
            };
        // Check enabled items
        if ($headerLogo.length) {
            $existItmes[$existItmes.length] = 'logo';
        }
        if ($headerMenu.length) {
            $existItmes[$existItmes.length] = 'menu';
        }
        if ($headerIcons.length) {
            $existItmes[$existItmes.length] = 'icons';
        }

        if ($orders != '') {
            $orders = JSON.parse($orders);
            for (var i = 0; i < $orders.length; i++) {
                $items[$orders[i].id] = {
                    align: $orders[i].align,
                    width: $orders[i].width,
                    headerTheme: $orders[i].headerTheme
                };
                $itemOrder[$itemOrder.length] = $orders[i].id;
            }
        }
        //Check current items order with exist items on header
        $existItmes.sort();
        $itemOrder.sort();
        var is_same = $existItmes.length == $itemOrder.length && $existItmes.every(function (element, index) {
                return element === $itemOrder[index];
            });
        var itemSetting = '<div class="item-setting">' +
            '<div class="setting-holder">' +
            '<span class="menu-selector">'+livepreview_var.settings+'</span>' +
            '<span class="left-aligned"></span>' +
            '<span class="center-aligned"></span>' +
            '<span class="right-aligned"></span>' +
            '</div>' +
            '</div>';

        // Add item order handler
        $("header").append('<div class="itemorder-handle disable"></div>');
        // Add required class and attrs
        // Logo
        $headerLogo.append(itemSetting);
        $headerLogo.addClass('header-item');

        if (typeof $items['logo'] != 'undefined' && is_same != false && $items['logo'].headerTheme == $headerTopTheme) {
            var align = $items['logo'].align,
                width = $items['logo'].width;
        } else {
            if(!$defaults[$headerTopTheme]) {
                $headerTopTheme = 'classic';
            }
            var align = $defaults[$headerTopTheme].logo.align,
                width = $defaults[$headerTopTheme].logo.width;
        }

        $headerLogo.attr({
            'data-md-align': align,
            'data-md-width': width,
            'data-custom-id': 'logo',
            'data-md-min-width': $defaults[$headerTopTheme].logo.min,
            'data-md-max-width': $defaults[$headerTopTheme].logo.max
        });
        //Menu

        $headerMenu.append(itemSetting);
        $headerMenu.addClass('header-item');
        if (typeof $items['menu'] != 'undefined' && is_same != false && $items['logo'].headerTheme == $headerTopTheme) {
            var align = $items['menu'].align,
                width = $items['menu'].width;
        } else {
            var align = $defaults[$headerTopTheme].menu.align,
                width = $defaults[$headerTopTheme].menu.width;
        }

        $headerMenu.attr({
            'data-md-align': align,
            'data-md-width': width,
            'data-custom-id': 'menu',
            'data-md-min-width': $defaults[$headerTopTheme].menu.min,
            'data-md-max-width': $defaults[$headerTopTheme].menu.max
        });
        //Icons
        $headerIcons.append(itemSetting);
        $headerIcons.addClass('header-item');
        if (typeof $items['icons'] != 'undefined' && is_same != false && $items['logo'].headerTheme == $headerTopTheme) {
            var align = $items['icons'].align,
                width = $items['icons'].width;
        } else {
            var align = $defaults[$headerTopTheme].icons.align,
                width = $defaults[$headerTopTheme].icons.width;
        }
        $headerIcons.attr({
            'data-md-align': align,
            'data-md-width': width,
            'data-custom-id': 'icons',
            'data-md-min-width': $defaults[$headerTopTheme].icons.min,
            'data-md-max-width': $defaults[$headerTopTheme].icons.max
        });

        $('.header-item').each(function () {
            if ($(this).hasClass('item-left')) {
                $(this).find('.item-setting .left-aligned').addClass('selected');
            } else if ($(this).hasClass('item-center')) {
                $(this).find('.item-setting .center-aligned').addClass('selected');
            } else if ($(this).hasClass('item-right')) {
                $(this).find('.item-setting .right-aligned').addClass('selected');
            }
        });

        //Item Setting Display
        $("header .logo,header .navigation,header .icons-pack").hoverIntent({
            over: function(){
                $(this).find('.item-setting').stop().fadeIn(100);
            },
            out: function(){
                $(this).find('.item-setting').stop().fadeOut('slow');
            },
            timeout: 300
        });

        // Item setting options
        $('.item-setting span:not(.menu-selector)').click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            var $this = $(this);
            if ($this.hasClass('left-aligned')) {
                $this.parents('.header-item').removeClass('item-center item-right').addClass('item-left').attr('data-md-align', 'item-left');
                $this.siblings().removeClass('selected');
                $this.addClass('selected');

            } else if ($this.hasClass('center-aligned')) {
                $this.parents('.header-item').removeClass('item-left item-right').addClass('item-center').attr('data-md-align', 'item-center');
                $this.siblings().removeClass('selected');
                $this.addClass('selected');
            } else if ($this.hasClass('right-aligned')) {
                $this.parents('.header-item').removeClass('item-left item-center').addClass('item-right').attr('data-md-align', 'item-right');
                $this.siblings().removeClass('selected');
                $this.addClass('selected');
            }
            pixflow_serialize_widget_map();
        });
        $('a.logo.header-item').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            $(this).attr('href','#');
            return false;
        })
        $('.item-setting').click(function(e){
            e.stopPropagation();
            return false;
        })
        $('.item-setting .menu-selector').click(function (e) {
            e.stopPropagation();
            if($('#unique-setting-switch', window.top.document).hasClass('close')){
                $('#unique-setting-switch', window.top.document).click();
            }
            var $header_item_id = $(this).parent().parent().parent().attr('data-custom-id');
            if($header_item_id == 'logo'){
                $('#accordion-section-branding > h3', window.top.document).click();
            }else if($header_item_id == 'menu'){
                $('#accordion-panel-header > h3', window.top.document).click();
                $('#accordion-section-header_layout > h3', window.top.document).click();
            }else if($header_item_id == 'icons'){
                $('#accordion-section-notification_main > h3', window.top.document).click();
            }
            return false;
        });

        // Add drag Handle
        $('.header-item').append('<div class="sortable-handle"></div>');
        $('.header-item').append('<div class="ui-move-handle"></div>');

        //Footer setting
        var footerSetting = '<div class="footer-setting">' +
            '<div class="setting-holder">'+livepreview_var.footerSetting+'</div>' +
            '</div>';
        $('footer').append(footerSetting);

        $("footer").hoverIntent({
            over: function () {
                $(this).find('.footer-setting').css({'display': 'block'});
            },
            out: function () {
                $(this).find('.footer-setting').css({'display': 'none'});
            },
            timeout: 300
        });

        $('footer .footer-setting .setting-holder').click(function () {
            $('#accordion-panel-footer > h3', window.top.document).click();
            $('#accordion-section-footer_layout > h3', window.top.document).click();
        });

        // get array
        function pixflow_serialize_widget_map() {
            'use strict';
            var res = _.map($('.header-item'), function (el) {
                el = $(el);
                return {
                    id: el.attr('data-custom-id'),
                    align: el.attr('data-md-align'),
                    width: el.attr('data-md-width'),
                    headerTheme: $headerTopTheme
                };
            });
            if ($headerTopTheme == 'gather' && $('header .style-style2').length) {
                pixflow_gatherBlockBorder(res);
            }
            var finals = [];
            var final = [];
            for(var k in res) {

                if(finals.indexOf(res[k]['id']) != -1 || res[k]==null){
                    delete res[k];
                }else{
                    finals.push(res[k]['id']);
                    final.push(res[k]);
                }
            }
            res = JSON.stringify(final);
            pixflow_customizerObj().$("input[data-customize-setting-link='header_items_order']").attr("value", res).keyup();
        };
        function pixflow_updateMaxWidth(event) {
            var itemsWidth = $headerLogo.width() + $headerMenu.width() + $headerIcons.width(),
                freeSpace = $headerContent.width() - itemsWidth;
            $('header:not(.header-clone) .top .header-item').each(function (index, value) {
                var maxWidth = $(this).width() + freeSpace;
                maxWidth = maxWidth.toFixed(1);
                if (event == 'stop') {
                    var wid =  $(this).width() / $headerContent.width() * 100;
                    wid = wid.toFixed(1);
                    $(this).css('width', wid + '%');
                    $(this).attr('data-md-width', wid);
                }
                $(this).resizable("option", "maxWidth", maxWidth);
            });
        }

        //Install Sortable
        /*Add sortable functionality*/
        $headerContent.sortable({
            placeholder: 'item-order-placeholder',
            containment: 'parent',
            items: "> .header-item",
            axis: 'x',
            forcePlaceholderSize: true,
            cursorAt: {top: 0, left: 0},
            helper: function () {
                return $("<div class=\"custom-helper\"></div>");
            },
            start: function (event, ui) {
                $(".item-order-placeholder").css("width", ui.originalPosition.width);
                var id = ui.item.attr('data-custom-id');
                ui.helper.addClass(id + '-helper');
            },
            update: function (event, ui) {
                pixflow_serialize_widget_map();
            }
        });
        $headerContent.disableSelection();
        $headerContent.sortable({cancel: '.item-setting'});
        /*Add resizeable functionality*/
        $('.header-item').resizable({
            handles: 'e',
            containment: "parent",
            create: function (event, ui) {
            },
            stop: function (event, ui) {
                pixflow_updateMaxWidth('stop');
                pixflow_serialize_widget_map();
            },
            resize: function (event, ui) {
                pixflow_updateMaxWidth('resize');
                var currentAlign = ui.element.attr('data-md-align'),
                    currentWidth = ui.element.width() / $headerContent.width() * 100;
                ui.element.attr({'data-md-align': currentAlign, 'data-md-width': currentWidth});
            }
        });

        // Optimize styles
        $('header .top ul.icons-pack li.icon').css('line-height', $('header').height() + 'px');
        function pixflow_gatherBlockBorder(items) {
            var headerItems = $('.header-item');
            var headerItems = $('.header-item');
            for (var i = 1; i < items.length; i++) {
                var leftItem = items[i - 1],
                    currentItem = items[i];
                if (currentItem == leftItem) {
                    if (leftItem.logo == 'menu') {
                        headerItems.eq(i - 1).find('.icon-gathermenu').removeClass('border-left');
                        headerItems.eq(i - 1).find('.icon-gathermenu').addClass('border-right');
                    } else {
                        headerItems.eq(i - 1).removeClass('border-left');
                        headerItems.eq(i - 1).addClass('border-right');
                    }
                } else {
                    if (leftItem.logo == 'menu') {
                        headerItems.eq(i - 1).find('.icon-gathermenu').removeClass('border-left');
                        headerItems.eq(i - 1).find('.icon-gathermenu').addClass('border-right');
                    } else {
                        headerItems.eq(i - 1).removeClass('border-left');
                        headerItems.eq(i - 1).addClass('border-right');
                    }
                    if (currentItem.logo == 'menu') {
                        headerItems.eq(i).find('.icon-gathermenu').removeClass('border-right');
                        headerItems.eq(i).find('.icon-gathermenu').addClass('border-left');
                    } else {
                        headerItems.eq(i).removeClass('border-right');
                        headerItems.eq(i).addClass('border-left');
                    }
                }
            }
            if (headerItems.eq(0).attr('data-md-align') == 'left') {
                if (headerItems.eq(0).attr('data-custom-id') == 'menu') {
                    headerItems.eq(0).find('.icon-gathermenu').removeClass('border-left');
                } else {
                    headerItems.eq(0).removeClass('border-left');
                }
            } else {
                if (headerItems.eq(0).attr('data-custom-id') == 'menu') {
                    headerItems.eq(0).find('.icon-gathermenu').addClass('border-left');
                } else {
                    headerItems.eq(0).addClass('border-left');
                }
            }
            if ($('.header-item:last-child').attr('data-md-align') == 'right') {
                if ($('.header-item:last-child').attr('data-custom-id') == 'menu') {
                    $('.header-item:last-child').find('.icon-gathermenu').removeClass('border-right');
                } else {
                    $('.header-item:last-child').removeClass('border-right');
                }
            } else {
                if ($('.header-item:last-child').attr('data-custom-id') == 'menu') {
                    $('.header-item:last-child').find('.icon-gathermenu').addClass('border-right');
                } else {
                    $('.header-item:last-child').addClass('border-right');
                }
            }
        }
    }

    /* Footer Widget Area Drag & Drop Feature */
    function pixflow_widgetDragDrop() {
        'use strict';
        if (window == window.top) {
            return
        }
        if ($(".footer-widgets .widget-area .widget-area-column").length <= 1) {
            return;
        }

        var $widgetColumns = $(".footer-widgets .widget-area");
        $widgetColumns.find(".widget-area-column").append('<div class="sortable-handle"></div>');
        $widgetColumns.sortable({
            axis:"x",
            //revert: true,
            cursor: "move",
            cursorAt: {left: 20},
            update: function (event, ui) {
                var sortedIDs = $widgetColumns.sortable("toArray");
                pixflow_customizerObj().$("input[data-customize-setting-link='footer_widgets_order']").attr("value", JSON.stringify(sortedIDs)).keyup();
            }
        });
        $widgetColumns.disableSelection();

    }

    function pixflow_customizerAnimate(state) {
        "use strict";
        if (state == 'in') {
            //Be cool!
        } else {
            if(pixflow_customizerObj().dirtyLoadedSettings.length){
                for (var key in pixflow_customizerObj().dirtyLoadedSettings){
                    pixflow_customizerObj().dirtyLoadedSettings[key].click();
                }
                pixflow_customizerObj().dirtyLoadedSettings = [];
            }
            if (typeof pixflow_customizerObj().TweenMax == 'function') {
                pixflow_customizerObj().TweenMax.to(pixflow_customizerObj().$('.customizer-loading .loading .circle svg'), 0.5, {
                    'opacity': 0,
                    delay: 0.6
                }); //svg out
                pixflow_customizerObj().TweenMax.to(pixflow_customizerObj().$('.customizer-loading .loading .circle .icon'), 0.5, {
                    'opacity': 1, delay: 0.8, onComplete: function () {
                        if (typeof pixflow_customizerObj().TweenMax == 'function') {
                            pixflow_customizerObj().TweenMax.to(pixflow_customizerObj().$('.customizer-loading .loading'), 0.5, {
                                'opacity': 0,
                                delay: 1.5
                            });
                       pixflow_customizerObj().TweenMax.to(pixflow_customizerObj().$('.customizer-loading .dark-overlay'), 1, {
                                'opacity': 0, delay: 1.5, onComplete: function () {
                                    pixflow_customizerObj().$('.customizer-loading').css('display', 'none');
                                    pixflow_customizerObj().$('.customizer-loading .loading').css({'width': '0'});
                                    pixflow_customizerObj().$('.customizer-loading .loading .circle .icon').css({'opacity': '0'});
                                    pixflow_customizerObj().$('.customizer-loading .loading .circle svg').css({'opacity': '1'});
                                }
                            });
                        }
                    }
                });
                pixflow_checkCollapse();
                setTimeout(function () {
                    if (pixflow_customizerObj().$('.customizer-loading .loading').css('opacity') == 1) {
                        pixflow_customizerAnimate('out');
                    }
                }, 2000);
            }
        }
    }

    /*
     * Widget organization function
     * run when VC front editor loaded
     * show/hide widget panel
     * */
    function pixflow_widgets() {
        // Run When load VC is enable
        if (pixflow_detectPosition() != 'customizer-vc-enable') {
            return;
        }
        var $sidebars = $('.sidebar'),
            $footerWidgets = $('.footer-widgets'),
            $widgetPanel = pixflow_customizerObj().$('#accordion-panel-widgets');
        if ($sidebars.length || $footerWidgets.length) {
            $widgetPanel.css('display', 'block');
            $widgetPanel.find('li.control-section-sidebar').each(function (index, value) {
                $id = $(this).attr('id').substr(34);
                if ($('div[widgetid=' + $id + ']').length) {
                    $(this).css('display', 'block');
                } else {
                    $(this).css('display', 'none');
                }
            });
        } else {
            $widgetPanel.css('display', 'none');
        }
    }

    function pixflow_checkCollapse(){
        if(pixflow_customizerObj().$('.hold-collapse').length){
            pixflow_customizerObj().$('.hold-collapse').click();
        }
    }

    function pixflow_loadVC(){

        'use strict';
        //return;
        var iframe = $('#px-iframe',$('#customize-preview > iframe',window.top.document).contents());
        
        if (iframe.length) {
            var saveSteps = 2;
            iframe.css({
                'position': 'fixed',
                'height': '100%',
                'width': '100%',
                'top': '0',
                'left': '0',
                'border': 'none'
            });
            iframe.ready(function () {

                pixflow_customizerObj().uniqueLoaded++;
                iframe.contents().find('a.vc_back-button').parent().remove();
                iframe.contents().find("button#vc_button-update").css('display', 'none');
                pixflow_customizerObj().$('input#save').click(function () {
                    try {
                        iframe.contents().find("button#vc_button-update").click();
                    } catch (e) {
                    }
                });
                iframe.contents().find('#vc_inline-frame').contents().find('#wpadminbar').remove();
                if($('meta[name="post-id"]').attr('setting-status') == 'unique') {
                    if(pixflow_customizerObj().uniqueLoaded >= 1){
                        var doLoading = true;
                    }
                }else{
                    var doLoading = true;
                }

                if(doLoading == true){
                    pixflow_customizerAnimate('out');
                    var mainLoader = pixflow_customizerObj().$('.main-loader'),
                        loaderLoading = mainLoader.find('.loading'),
                        loaderSVG = loaderLoading.find('.circle svg'),
                        loaderIcon = loaderLoading.find('.circle .icon'),
                        loaderText = mainLoader.find('.text'),
                        $rotatingText = loaderLoading.find('.rotating-text'),
                        loadingText = loaderLoading.find('.loading-text');
                    $rotatingText.stop().animate({right:100},{
                        duration:2000,
                        step:function(now,tween){
                            $(this).html(Math.floor(now)+"%");
                        },
                        complete:function() {
                            try {
                                pixflow_customizerObj().TweenMax.to(loadingText, 0.5, {
                                    'opacity': 0, onComplete: function () { //loading text out
                                        loadingText.text(livepreview_var.allDone);
                                    }
                                });
                                pixflow_customizerObj().TweenMax.to(loadingText, 0.5, {'opacity': 1, delay: .6}); //all done in
                                pixflow_customizerObj().TweenMax.to(loaderLoading, 0.5, {'width': '75px', delay: .6});
                                pixflow_customizerObj().TweenMax.to(loaderSVG, 0.5, {'opacity': 0, delay: .6}); //svg out
                                pixflow_customizerObj().TweenMax.to(loaderIcon, 0.5, {
                                    'opacity': 1, delay: .8, onComplete: function () { //width reduced
                                        try {
                                            pixflow_customizerObj().TweenMax.to(loaderText, 0.5, {'opacity': 0, delay: 1.5});
                                            pixflow_customizerObj().TweenMax.to(loaderLoading, 0.5, {'opacity': 0, delay: 1.5});
                                            pixflow_customizerObj().TweenMax.to(mainLoader, 1, {
                                                'opacity': '0', delay: 2, onComplete: function () {
                                                    mainLoader.css('display', 'none');
                                                }
                                            });
                                        } catch (e) {
                                            mainLoader.css('display', 'none');
                                        }
                                    }
                                });
                            } catch (e) {
                                mainLoader.css('display', 'none');
                            }
                        }
                    })

                }

                var $row = $('.vc_row');
                $row.each(function () {
                    var $firstCol = $($(this).find('.vc_vc_column').get(0));
                    $firstCol.find('.vc_controls-out-tl').css({'display': 'block'});
                });
                pixflow_tabSetting();
                if (typeof pixflow_customizerObj().pixflow_loaded == 'function') {
                    pixflow_customizerObj().pixflow_loaded();
                }

            });

        } else {
            
            var saveSteps = 1;
            
            window.onload = function () {

                pixflow_customizerAnimate('out');
                var mainLoader = pixflow_customizerObj().$('.main-loader'),
                    loaderLoading = mainLoader.find('.loading'),
                    loaderSVG = loaderLoading.find('.circle svg'),
                    loaderIcon = loaderLoading.find('.circle .icon'),
                    loaderText = mainLoader.find('.text'),
                    $rotatingText = loaderLoading.find('.rotating-text'),
                    loadingText = loaderLoading.find('.loading-text');
                $rotatingText.stop().animate({right:100},{
                    duration:2000,
                    step:function(now,tween){
                        $(this).html(Math.floor(now)+"%");
                    },
                    complete:function(){
                        try {
                            pixflow_customizerObj().TweenMax.to(loadingText, 0.5, {
                                'opacity': 0, onComplete: function () { //loading text out
                                    loadingText.text(livepreview_var.allDone);
                                }
                            });
                            pixflow_customizerObj().TweenMax.to(loadingText, 0.5, {'opacity': 1, delay: .6}); //all done in
                            pixflow_customizerObj().TweenMax.to(loaderLoading, 0.5, {'width': '75px', delay: .6});
                            pixflow_customizerObj().TweenMax.to(loaderSVG, 0.5, {'opacity': 0, delay: .6}); //svg out
                            pixflow_customizerObj().TweenMax.to(loaderIcon, 0.5, {
                                'opacity': 1, delay: .8, onComplete: function () { //width reduced
                                    try {
                                        pixflow_customizerObj().TweenMax.to(loaderText, 0.5, {'opacity': 0, delay: 1.5});
                                        pixflow_customizerObj().TweenMax.to(loaderLoading, 0.5, {'opacity': 0, delay: 1.5});
                                        pixflow_customizerObj().TweenMax.to(mainLoader, 1, {
                                            'opacity': '0', delay: 2, onComplete: function () {
                                                mainLoader.css('display', 'none');
                                            }
                                        });
                                    } catch (e) {
                                        mainLoader.css('display', 'none');
                                    }
                                }
                            });
                            pixflow_customizerObj().pixflow_loaded();
                        }catch (e){
                            mainLoader.css('display', 'none');
                        }
                    }
                })
            };
        }
        var s;

        if(pixflow_customizerObj().$('#save-btn').length >= 1) {
            pixflow_customizerObj().$('#save-btn .save,#save-btn .save-preview').click(function () {
                try{
                    var customizerSaved = 0,
                        checkVc = false,
                        checkedCustomizer = false,
                        $this = $(this),
                        post_id = $('meta[name="post-id"]').attr('content'),
                        post_detail = $('meta[name="post-id"]').attr('detail');
                    if($('meta[name="post-id"]').attr('setting-status') == 'unique'){
                        pixflow_customizerObj().$('li.unique-page-setting .circle').addClass('expand');

                        pixflow_save_status('unique', post_id, post_detail,'save');
                        pixflow_save_unique_setting(post_id,post_detail);
                        try{
                            iframe.contents().find("button#vc_button-update").click();
                        }catch (e){}
                    }else{
                        pixflow_customizerObj().$('li.general-page-setting .circle').addClass('expand');
                        pixflow_save_status('general', post_id, post_detail,'save');
                        pixflow_customizerObj().$('input#save').click();
                    }

                    pixflow_customizerObj().$('#customize-preview #save-btn').css({'background-color':'#e1e1e1 ','color':'#000'});
                    pixflow_customizerObj().$('#customize-preview #save-btn .save-loading').animate({width:'90%'},7000);
                    pixflow_customizerObj().$('#customize-preview #save-btn .text').html(livepreview_var.saving);
                    s = setInterval(function(){
                        if(!checkedCustomizer && !pixflow_customizerObj().$('body.saving').length){
                            customizerSaved++;
                            checkedCustomizer=true;
                        }
                        if(window.parent.jQuery('body .vc_message.success').length){
                            customizerSaved++;
                        }
                        if(customizerSaved == saveSteps){
                            clearInterval(s);
                            pixflow_customizerObj().$('#customize-preview #save-btn .save-loading').stop().animate({'width':'100%'},200,'swing',function(){
                                pixflow_customizerObj().$('#customize-preview #save-btn .text').html(livepreview_var.save_preview);
                                pixflow_customizerObj().$('#customize-preview #save-btn .save-loading').css('width','0%');
                                pixflow_customizerObj().$('#customize-header-actions #save').val('Saved');
                                window.top.pixflow_refreshFrame();
                                if(typeof pixflow_customizerObj().saveCallbackFunction == 'function'){
                                    setTimeout(function(){pixflow_customizerObj().saveCallbackFunction();},1);
                                }
                                if($this.hasClass('save-preview')){

                                    window.top.location = window.top.wp.customize.previewer.previewUrl();
                                }
                                pixflow_customizerObj().$('.customizer-btn#save-btn .cd-dropdown-wrapper').removeClass('active-dropdown-view');

                            });
                        }
                    },100);
                }catch (e){}
            });

        }
        if($('meta[name="post-id"]').attr('setting-status') == 'unique'){
            pixflow_customizerObj().pixflow_setUniqueCustomizer();
        }else{
            pixflow_customizerObj().pixflow_setGeneralCustomizer();
        }

    }

    function pixflow_tabSetting() {
        "use strict";

        var $tabs = $('.vc_md_tabs,.vc_md_modernTabs');

        $('body').on('click', 'ul.wpb_tabs_nav > li', function () {
            var id = $(this).attr('data-m-id'),
                width = $(this).find('> a').outerWidth(true),
                $tab = $(this).parents('ul.ui-tabs-nav').nextAll('div[data-model-id=' + id + ']'),
                $tabs = $(this).parents('ul.ui-tabs-nav').nextAll('.ui-tabs-panel'),
                left = $(this).position().left + (width - 66) / 2,
                top = $tab.find('.vc_controls-column').css('top');

            top = parseInt(top, 10) * -1;

            $tabs.find('.vc_controls-out-tr .element-md_tab,.vc_controls-out-tr .element-md_modernTab').css({
                'top': top + 'px',
                'opacity': 0
            });
            $tab.find('.vc_controls-out-tr .element-md_tab.vc_active,.vc_controls-out-tr .element-md_modernTab.vc_active').css({'left': left}).animate({
                top: top + 35 + 'px',
                opacity: 1
            });
            $tab.find('.parent-md_modernTabs').css('top', top - 47 + 'px');

        });

        if (!$tabs.length)
            return;

        $tabs.each(function () {
            var activeLi = $(this).find('.ui-tabs-active'),
                id = activeLi.attr('data-m-id'),
                width = activeLi.find('> a').outerWidth(true),
                $tab = activeLi.parents('ul.ui-tabs-nav').nextAll('div[data-model-id=' + id + ']'),
                left = activeLi.position().left + (width - 66) / 2,
                top = $tab.find('.vc_controls-column').css('top');
            top = parseInt(top, 10) * -1;

            $tab.find('.vc_controls-out-tr .element-md_tab.vc_active , .vc_controls-out-tr .element-md_modernTab.vc_active').css({
                'top': top + 35 + 'px',
                'left': left + 'px'
            });
            $tab.find('.parent-md_modernTabs').css('top', top - 47 + 'px');
        });

    }

    function pixflow_itemOrderSetter(action) {
        'use strict';
        var $headerContent = $('header .top'),
            $headerItems = $('.header-item');
        if (!$headerContent.hasClass('ui-sortable')) {
            pixflow_headerGrid();
        }
        if(pixflow_customizerObj().$('.hold-collapse').length && action != 'disable')
            return;

        if (action == 'disable') {
            $headerItems.find('.sortable-handle,.ui-resizable-handle,.ui-move-handle').css('display', 'none');
            $headerItems.css('background-color', 'rgba(255, 255, 255, 0)');
            $headerContent.sortable(action);
            $headerItems.resizable(action);
            $('.item-setting').css('opacity', '0');
        } else {
            $headerContent =$headerContent.not('.header-clone .top');
            $headerItems = $headerItems.not('.header-clone .header-item');
            $headerContent.sortable(action);
            $headerItems.resizable(action);
            $headerItems.find('.sortable-handle,.ui-resizable-handle,.ui-move-handle').css('display', 'block');
            $('.item-setting').css('opacity', '1');
        }

    }

    function pixflow_portfolioItemsPanel() {
        'use strict';

        var $portfolioItem = $('.portfolio-multisize .isotope .item'),
            panelSetting = '<div class="portfolio-panel-setting">' +
                '                   <div class="setting-holder">' +
                '                       <span class="setting">'+livepreview_var.settings+'</span>' +
                '                       <span data-size="thumbnail-large" class="large-size portfolio-size" title="Large Tile"></span>' +
                '                       <span data-size="thumbnail-medium" class="average-size portfolio-size" title="Medium Tile"></span>' +
                '                       <span data-size="thumbnail-small" class="small-size portfolio-size" title="Small Tile"></span>' +
                '                   </div>' +
                '               </div>';

        $portfolioItem.append(panelSetting);
        $portfolioItem.find('.portfolio-size').each(function (index, value) {
            $(this).attr('data-item_id', $(this).parent().parent().attr('data-item_id'));
        });

        $portfolioItem.hover(function () {
            $(this).find('.portfolio-panel-setting').css({top: '10px', opacity: '1'});
        }, function () {
            $(this).find('.portfolio-panel-setting').css({top: '-5px', opacity: '0'});
        });

        $portfolioItem.find('.portfolio-panel-setting span').click(function () {
            if ($(this).hasClass('small-size')) {
                $(this).parents('.item').removeClass('thumbnail-medium thumbnail-large').addClass('thumbnail-small');
                $(this).siblings().removeClass('current');
                $(this).addClass('current');
                pixflow_portfolioMultisize();
            } else if ($(this).hasClass('average-size')) {
                $(this).parents('.item').removeClass('thumbnail-small thumbnail-large').addClass('thumbnail-medium');
                $(this).siblings().removeClass('current');
                $(this).addClass('current');
                pixflow_portfolioMultisize();
            } else if ($(this).hasClass('large-size')) {
                $(this).parents('.item').removeClass('thumbnail-medium thumbnail-small').addClass('thumbnail-large');
                $(this).siblings().removeClass('current');
                $(this).addClass('current');
                pixflow_portfolioMultisize();
            } else if ($(this).hasClass('setting')) {
                $(this).closest('.vc_md_portfolio_multisize').find('a[title="Edit Portfolio Multi-Size"]')[0].click();
            }
            var item = $(this).parents('.portfolio-item'),
                post_id = item.data("item_id"),
                size = $(this).attr('data-size');
            jQuery.ajax({
                type: "post",
                url: livepreview_var.url,
                data: "action=pixflow_portfolio_size&nonce=" + livepreview_var.nonce + "&portfolio_size=" + size + "&post_id=" + post_id,
                success: function (res) {
                    return res;
                }
            })
        });
    $('.portfolio .shortcode-btn a').click(function(e){
        e.preventDefault();
        return;
    })
    }

    function pixflow_loadRelatedSidebar(){
        'use strict';
        var sidebar = $('meta[name="post-id"]').attr('sidebar-type'),
            pageSidebar = pixflow_customizerObj().$('#accordion-section-sidebar_general'),
            mainSidebar = pixflow_customizerObj().$('#accordion-section-sidebar_blogPage'),
            postSidebar = pixflow_customizerObj().$('#accordion-section-sidebar_blogSingle'),
            shopSidebar = pixflow_customizerObj().$('#accordion-section-sidebar_shop');
        if(pixflow_customizerObj().$('#accordion-panel-sidebar').hasClass('current-panel') && pixflow_customizerObj().$('#accordion-section-sidebar_'+sidebar).css('display') == 'none'){
            //Running back button click twice( I'm not noob, I'm just tired :)
            pixflow_customizerObj().$('.back-btn').click();
            pixflow_customizerObj().$('.back-btn').click();
        }

        if('general' == sidebar){
            pageSidebar.css('display','list-item');
            mainSidebar.css('display','none');
            postSidebar.css('display','none');
            shopSidebar.css('display','none');
        }else if('blogPage' == sidebar){
            mainSidebar.css('display','list-item');
            pageSidebar.css('display','none');
            postSidebar.css('display','none');
            shopSidebar.css('display','none');
        }else if('blogSingle' == sidebar){
            postSidebar.css('display','list-item');
            pageSidebar.css('display','none');
            mainSidebar.css('display','none');
            shopSidebar.css('display','none');
        }else if('shop' == sidebar){
            shopSidebar.css('display','list-item');
            pageSidebar.css('display','none');
            mainSidebar.css('display','none');
            postSidebar.css('display','none');
        }
    }

    var $ = jQuery;

    $(document).ready(function (){
        pixflow_headerGrid('true');
        pixflow_widgetDragDrop();
        pixflow_loadVC();
        //pixflow_widgets(); // stop to run this function until fix widget in VC frontend editor

        window.top.pixflow_shortcodesPanel();
        window.top.pixflow_openShortcodePanel();
        $($('iframe',window.top.document)[0]).contents().find('body').css({margin:0});

        $(document).on('mouseenter', '.vc_vc_row .wrap', function () {
            jQuery(jQuery(this).find('div[class *= vc_vc_column]').get(0)).addClass('controls-hover');
            jQuery(jQuery(this).find('div[class *= vc_vc_column]').get(0)).find('div[class*="parent-vc_row"]:not(.parent-vc_row_inner)').css({'display': 'block'});
            jQuery(jQuery(this).find('div[class *= vc_vc_column_inner ]').get(0)).find('div[class*="parent-vc_row_inner"]').css({'display': 'block'});


            if ($(this).prev().hasClass('vc_vc_row') == false || $(this).parents('vc_vc_row_inner') == 1) {

                var rowPadding = parseInt($($('.vc_row').get(0)).css('padding-top')),
                    mainPadding = parseInt($('main').css('padding-top')),
                    top = rowPadding + mainPadding,
                    num = 0,
                    firstRow = $($('.vc_row').get(0)).find('.vc_controls-out-tl')/*.get(0)*/,
                    headerHeight = $('header[class *= "top"]').height();

                if ($(this).parent('.vc_inner').length) {
                    var $innerRow = $(this).parent('.vc_inner'),
                        innerRowPadding = parseInt($innerRow.css('padding-top')),
                        $innerRowControls = $innerRow.find('.vc_controls-out-tl');

                    num = (innerRowPadding >= 45) ? -45 : 0;

                    if (!$innerRowControls.hasClass('flag')) {
                        $innerRowControls.css('top', num);
                        $innerRowControls.addClass('flag')
                    }


                } else {

                    if (mainPadding >= headerHeight) {
                        //content is not under header now check if row has space to view its settings or not
                        num = (rowPadding >= 45) ? -45 : 0;

                        if (!$(firstRow).hasClass('flag')) {
                            $(firstRow).css('top', num);
                            $(firstRow).addClass('flag')
                        }

                    } else {
                        //row has enough space to view its setting
                        // check if it is under header or not
                        var headerTop = parseInt($('header[class *= "top"]').css('top'));

                        headerHeight += headerTop;
                        num = (headerHeight + 45 <= top && rowPadding >= 45 ) ? -45 : headerHeight - top;
                        var x = $(firstRow).has('.flag');

                        if (!x.hasClass('flag')) {
                            $(firstRow).css('top', num);
                            $(firstRow).addClass('flag')
                        }
                    }

                }
            }

        });

        $(document).on('mouseleave', '.vc_vc_row .wrap,.vc_inner .wrap', function () {

            if ($(this).prev().hasClass('vc_vc_row') == false && $(this).parents('.vc_vc_row_inner').length == 0) {
                jQuery(jQuery(this).find('div.vc_vc_column').get(0)).removeClass('controls-hover');
                jQuery(jQuery(this).find('div.vc_vc_column_inner').get(0)).removeClass('controls-hover');
                var firstRow = $($('.vc_row').get(0)).find('.vc_controls-out-tl').get(0);

                if ($(firstRow).hasClass('flag')) {
                    $(this).find('.flag').removeClass('flag')
                }

            }
        });
        window.onbeforeunload = null;

        $(document).on('click','.vc_control-btn-delete',function(){
            if ( $('#vc_no-content-helper').hasClass('vc_not-empty')){
                return;
            }else{
                var iframeHeight = $('body').height(),
                    footerHeight = $('footer').height(),
                    num;


                num = iframeHeight - footerHeight;
                $('#vc_no-content-helper').css('height', num + 'px');
            }
        });
    });

    $(window).load(function () {
        //pixflow_portfolioItemsPanel();
        if ($('meta[name="post-id"]').attr('setting-status') == 'unique') {
            pixflow_customizerObj().$('li.unique-page-setting').click();
        } else {
            pixflow_customizerObj().$('li.general-page-setting').click();
        }
        pixflow_loadRelatedSidebar();

        //Hide overflow from header icons
        $( "header.top:not(.top-modern) .icons-pack li.icon").wrapAll( "<div class='wrap' />");
        $('header .hidden-tablet').removeClass('hidden-tablet');
    });
}
