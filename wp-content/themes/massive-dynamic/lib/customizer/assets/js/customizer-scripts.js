var firstTime = false;
jQuery(document).ready(function ($) {
    "use strict";
    var $t = true;
    var responsiveHtml='<div class="cd-dropdown-wrapper">' +
        '<nav class="cd-dropdown">' +
        '<ul>' +
        '<li class="drop-down-title">'+customizerSentences.responsive+'</li>'+
        '<li class="desktop"><div class="circle"></div><a href="#"><span>'+customizerSentences.desktop+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '<li class="tablet-landscape"><div class="circle"></div><a href="#"><span>'+customizerSentences.tabletLandscape+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '<li class="tablet-portrait"><div class="circle"></div><a href="#"><span>'+customizerSentences.tabletPortrait+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '<li class="smartphone-landscape"><div class="circle"></div><a href="#"><span>'+customizerSentences.mobileLandscape+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '<li class="smartphone-portrait"><div class="circle"></div><a href="#"><span>'+customizerSentences.mobilePortrait+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '</ul>' +
        '</nav>' +
        '<div class="helper"></div>'+
        '</div>';

    var saveHtml='<div class="cd-dropdown-wrapper">' +
        '<nav class="cd-dropdown">' +
        '<ul>' +
        '<li class="drop-down-title">'+customizerSentences.publishPanel+'</li>'+
        '<li class="save"><div class="circle"></div><a href="#"><span>'+customizerSentences.save+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '<li class="save-preview"><div class="circle"></div><a href="#" ><span>'+customizerSentences.saveAndView+'</span><span class="cd-dropdown-option"></span></a><a class="save-preview-link" href="#" target="_blank"></a> </li>' +
        '</ul>' +
        '</nav>' +
        '<div class="helper"></div>'+
        '</div>';


    var informationHtml='<div class="cd-dropdown-wrapper">' +
        '<nav class="cd-dropdown">' +
        '<ul>' +
        '<li class="drop-down-title">'+customizerSentences.information+'</li>'+
        '<li><div class="circle"></div><a target="_blank" href="http://support.pixflow.net"><span>'+customizerSentences.helpAndSupportCenter+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '<li><div class="circle"></div><a target="_blank" href="http://massivedynamic.co/documentation/"><span>'+customizerSentences.documentation+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '</ul>' +
        '</nav>' +
        '<div class="helper"></div>'+
        '</div>';

    var settingHtml='<div class="cd-dropdown-wrapper">' +
        '<nav class="cd-dropdown">' +
        '<ul>' +
        '<li class="drop-down-title">'+customizerSentences.pageOption+'</li>'+
        '<li class="general-page-setting"><div class="circle"></div><a href="#"><span>'+customizerSentences.generalPageSetting+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '<li class="unique-page-setting"><div class="circle"></div><a href="#"><span>'+customizerSentences.uniquePageSetting+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '<li class="description"><a>'+customizerSentences.pageSettingDescription+'</a></li>' +
        '</ul>' +
        '</nav>' +
        '<div class="helper"></div>'+
        '</div>';


    var newsletterHtml='<ul class="newsletter-content"></ul>' ;
    var takeTourHtml= '<ul class="newsletter-content">' +
        '<li>'+
        '<div class="take-tour-img"></div>'+
        '<p class="take-tour-title">'+customizerSentences.needHelp+'</p>'+
        '<p class="take-tour-text">'+customizerSentences.noWorries+' <a href="#">'+customizerSentences.video+'</a> '+customizerSentences.takeATourDescription+'</p>'+
        '<div><a href="#" class="take-tour-btn">'+customizerSentences.takeATour+'</a></div>'+

        '<div class="help-center-container2">'+
        '<a href="#" class="show-hints hints-toggle">'+customizerSentences.showHints+'</a>'+
        '<a href="#" class="hide-hints">'+customizerSentences.hideHints+'</a>'+
        '</div>'+

        '</li>' +
        '</ul>';

    var notifyCenter='<div class="title notification-center close" style="opacity:1;">'+
        '<div id="notification-tabs">'+
        '<div class="pager"></div>'+
        '<div class="tabs-container">'+
        '<div id="opt1" class="newsletter">'+
        '<div class="clearfix notification-tab">'+
        '<span class="tab-title">'+customizerSentences.newsletter+'</span>'+
        '<div class="newsletter-container">'+
        newsletterHtml+
        '</div>'+
        '</div>'+
        '</div>'+
        '<div id="opt2" class="take-a-tour">'+
        '<div class="notification-tab clearfix">'+
        '<span class="tab-title">'+customizerSentences.takeTour+'</span>'+
        '<div class="take-a-tour-container">'+
        takeTourHtml+
        '</div>'+
        '</div>'+
        '</div>'+
        '</div>'+
        '<div class="notification-collapse-area"></div>'+
        '<div class="notification-collapse"></div>'+
        '</div>'+
        '</div>';

    var tourHtml='<div class="tour-dropdown-wrapper">' +
        '<div class="tour-dropdown">' +
        "<div class='tour-dropdown-header' style='width:270px;margin-bottom:22px; margin-top:30px; padding-bottom:70px'><a class='notify-remove px-icon icon-close'></a></div>"+
        notifyCenter+
        '</div>' +
        '</div>';


    $('.wp-full-overlay-sidebar-content,.accordion-section-content,.caroufredsel_wrapper').niceScroll({
        horizrailenabled: false,
        cursorcolor: "rgba(204, 204, 204, 0.2)",
        cursorborder: "1px solid rgba(204, 204, 204, 0.2)",
        cursorwidth: "2px"
    });

    $('#customize-info').css({display: 'none'});
    $('#customize-header-actions').before("<div class='customizer-header'><div class='pic'><a class='notify-win'>"+customizerSentences.avatarImage+"</a></div>" +
        "<p class='name'>"+customizerSentences.fullname+"</p></div>");
    $('.customize-controls-close').append('Close');
    $('#customize-preview').prepend(

        '<a class="collaps customizer-btn"><div class="tooltip"><span class="title">'+customizerSentences.gizmoController+'</span> '+customizerSentences.showHideControllers+' </div></a>' +
        '<a class="customizer-btn information"><span class="symbol"></span><div class="tooltip"><span class="title">'+customizerSentences.informationController+'</span>'+customizerSentences.needInformation+'</div></a>' +
        '<a class="customizer-btn responsive-view"><span class="symbol"></span><div class="tooltip"><span class="title">'+customizerSentences.responsiveView+'</span> '+customizerSentences.differentDevices+' </div></a>' +
        '<a class="customizer-btn import"><span class="symbol"></span><div class="tooltip"><span class="title">'+customizerSentences.importDemo+'</span> '+customizerSentences.usePremadeWebsites+' </div></a>' +

        '<div class="customizer-btn page"><span class="symbol"></span>' +
        '<div class="tooltip">' +
        '<span class="title">'+customizerSentences.newEntries+'</span> '+customizerSentences.addNewPosts+' ' +
        '</div>' +
        '<div class="cd-dropdown-wrapper">' +
        '<nav class="cd-dropdown">' +
        '<ul>'+
        '<li class="drop-down-title">'+customizerSentences.newPages+'</li>'+
        '<li><div class="circle"></div><a data-type="Post" class="add-new-element"><span>'+customizerSentences.addNewPost+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '<li><div class="circle"></div><a data-type="Page" class="add-new-element"><span>'+customizerSentences.addNewPage+'</span><span class="cd-dropdown-option"></span></a></li>' +
        '<li><div class="circle"></div><a data-type="Portfolio" class="add-new-element"><span>'+customizerSentences.addNewPortfolio+'</span><span class="cd-dropdown-option"></span></a></li>'+
        '<li><div class="circle"></div><a target="_blank" href="'+customizerSentences.adminURL+'post-new.php?post_type=product"><span>'+customizerSentences.addNewProduct+'</span><span class="cd-dropdown-option"></span></a></li>'+
        '</ul>'+
        '</nav>' +
        '<div class="helper"></div>'+
        '</div>' +
        '</div>' +

        '<a class="customizer-btn dashboard" href="'+customizerSentences.adminURL+'" ><span class="symbol"></span><span class="text">'+customizerSentences.dashboard+'</span><div class="tooltip"><span class="title">'+customizerSentences.dashboardController+'</span>'+customizerSentences.goToDashboard+'</div></a>' +
        '<a class="customizer-btn setting" id="page-option-btn"><span class="symbol"></span><span class="text"></span><div class="tooltip"><span class="title">'+customizerSentences.generalUniqueSetting+'</span> '+customizerSentences.switchGeneralUnique+' </div><div class="save-loading"></div></a>' +
        '<div class="customizer-btn" id="save-btn"><span class="text"> '+customizerSentences.saveAndView+'</span><div class="save-loading"></div></div> ');

    var pageTitle;
    $('.customizer-btn .add-new-element').click(function(){

        var postType,$promptBox,$close,$createPage;

        postType = $(this).attr('data-type');

        $('.prompt-box-wrapper').remove();
        $promptBox = $('' +
            '<div class="prompt-box-wrapper">' +
            '   <div class="prompt-box-container ">' +
            '       <div class="prompt-box-close"/>' +
            '       <div class="prompt-box-title">'+customizerSentences.addNew+' ' + postType + '</div>' +
            '       <div class="prompt-box-text">'+customizerSentences.enterName+' ' + postType.toLowerCase() + '</div>' +
            '       <input type="text" name="pageTitle" placeholder="' + postType + ' Name" class="prompt-text-box"><br/>'+
            '       <div class="prompt-box-holder"><a href="#" class="prompt-box-btn">'+customizerSentences.create+'</a></div>' +
            '   </div>' +
            '</div>').appendTo('body');

        $promptBox.animate({opacity:1},200);

        $close = $promptBox.find('.prompt-box-close');
        $close.click(function(){
            $('.cd-dropdown ul li .circle').removeClass('expand');
            $('.prompt-box-wrapper').fadeOut(300,function(){
                $(this).remove();
            });
        });

        $createPage = $promptBox.find('.prompt-box-btn');
        $createPage.click(function(){
            $('.cd-dropdown ul li .circle').removeClass('expand');
            pageTitle=$promptBox.find('.prompt-text-box').val();
            $('.prompt-box-wrapper').fadeOut(500,function(){
                $(this).remove();
            });

            if ( pageTitle == '' ) {
                return false;
            }
            jQuery.ajax({
                type: "post",
                url: customizerSentences.ajaxURL,
                data: "action=pixflow_addNewElement" +
                "&nonce=" + customizerSentences.ajaxNonce +
                "&pageTitle=" + pageTitle +
                "&postType=" + postType.toLowerCase() ,
                success: function (result) {
                    pixflow_customizerLoading();
                    window.wp.customize.previewer.previewUrl(result);
                }
            });
        });
    });

    $('#customize-preview .customizer-btn:not(.save-loading)').mouseenter(function(){

        $(this).find('.tooltip').css('display','block');

        if($(this).hasClass('dashboard') || $(this).attr('id')=="save-btn"){

            $(this).find('.tooltip').stop(true).delay(400).animate({
                top: '15px',
                opacity: 1
            }, 250);

        }else{
            $(this).find('.tooltip').stop(true).delay(400).animate({
                top: '55px',
                opacity: 1
            }, 250);
        }

    });
    $('#customize-preview .customizer-btn:not(.save-loading)').mouseleave(function(){

        if($(this).hasClass('dashboard') || $(this).attr('id')=="save-btn"){

            $(this).find('.tooltip').stop(true).animate({
                top: '5px',
                opacity: 0
            }, 300, function() {
                $(this).css('display','none');
            });

        }else{

            $(this).find('.tooltip').stop(true).animate({
                top: '40px',
                opacity: 0
            }, 300, function() {
                $(this).css('display','none');
            });

        }

    });

    $('.wp-full-overlay-sidebar').append(tourHtml);
    var tourDropdownToggle = -1;
    $('.customizer-header:first .pic').click(function(){
        if(tourDropdownToggle != -1) return;
        tourDropdownToggle = 1;
        $('.tour-dropdown-wrapper').addClass('active-dropdown-view');
        $('.tour-dropdown').css({'opacity':0,'margin-top':'-=20px'}).delay(100).animate({
            opacity:1,
            'margin-top':'+=20px'
        },500);
        $('.customizer-header .notify-num').remove();
        if(!$('.tour-dropdown-wrapper .pager a:eq(1)').hasClass('selected')){
            pixflow_setAsReadNotifications();
        }
    });
    $('body').on('click','.tour-dropdown-wrapper .pager a:eq(0)',function(){
        pixflow_setAsReadNotifications();
    })
    $('body').on('click','.tour-dropdown-wrapper li .remove-notify',function(){
        var heightLi=parseInt($(this).parent().height())+33,
            $this=$(this);
        TweenMax.to($this.parent(),.2, {'opacity':'0'});
        TweenMax.to($this.parent(),.4, {'margin-top':'-'+heightLi+'px'});
        setTimeout(function(){
            pixflow_deleteNotification($this.parent().attr('data-notify-id'));
            $this.parent().remove();
        },800);

    });

    var notifyCountDown,responsiveCountDown,saveCountDown,pageCountDown,informationCountDown,settingCountDown;
    $('.notify-remove').click(function(e){
        e.stopPropagation();
        notifyCountDown = setTimeout(function() {
            $('.tour-dropdown-wrapper').removeClass('active-dropdown-view').css('z-index',10);
            $('.bullet.new').removeClass('new');
            $('.tour-dropdown-wrapper .notify-new').remove();
            setTimeout(function() {
                $('.tour-dropdown-wrapper').css('z-index','');
                tourDropdownToggle = -1;
            },300)
        }, 10);
    });

    $(document).click(function (e)
    {
        var container = $(".tour-dropdown-wrapper, .customizer-header");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $('.notify-remove').click();
        }
    });

    $('#notification-tabs .tabs-container').carouFredSel({
        circular: false,
        items: 1,
        width: '100%',
        direction: "left",
        auto: false,
        pagination: {
            container: '#notification-tabs .pager',
            anchorBuilder: function() {
                var tabTitle= '<a href="#" class="'+  $(this).find('.tab-title').text().toLowerCase().replace(/ /g,'-') +'">' + $(this).find('.tab-title').text() + '</a>';

                return tabTitle;
            }
        },
        scroll : {
            fx : "directscroll",
            easing : "quadratic",
            duration:600,
            onBefore : function(data){
                data.items.old.css({opacity:0.5});
                data.items.old.stop().animate({opacity:0},300);
                data.items.visible.stop().animate({opacity:1},800);
            }
        }
    });

    $('#notification-tabs .tabs-container').css('width','204px');

    $('#save-btn').append(saveHtml);
    $('#save-btn').click(function(){
        $(this).find('.cd-dropdown-wrapper').addClass('active-dropdown-view');
        $(this).find('.cd-dropdown-wrapper .helper').css({'background-image': "url('"+customizerSentences.customizerURI+"/assets/images/save-&-publish.gif')", 'background-position':'center center'});
    });

    $('.responsive-view').append(responsiveHtml);
    $('.responsive-view').click(function(){
        $(this).find('.cd-dropdown-wrapper').addClass('active-dropdown-view');
        $(this).find('.cd-dropdown-wrapper .helper').css({'background-image': "url('"+customizerSentences.customizerURI+"/assets/images/responsive.gif')", 'background-position':'center center'});
    });

    $('.customizer-btn.information').append(informationHtml);
    $('.customizer-btn.information').click(function(){
        $(this).find('.cd-dropdown-wrapper').addClass('active-dropdown-view');
        $(this).find('.cd-dropdown-wrapper .helper').css({'background-image': "url('"+customizerSentences.customizerURI+"/assets/images/info.gif')", 'background-position':'center center'});
    });

    $('.customizer-btn.setting').append(settingHtml);
    $('.customizer-btn.setting').click(function(){
        $(this).find('.cd-dropdown-wrapper').addClass('active-dropdown-view');

        if($('.customizer-btn.setting .text').html()=='General setting'){
            $('.customizer-btn.setting .cd-dropdown-wrapper .helper').css({'background-image': "url('"+customizerSentences.customizerURI+"/assets/images/general-setting.gif')", 'background-position':'center center'});
        }else{
            $('.customizer-btn.setting .cd-dropdown-wrapper .helper').css({'background-image': "url('"+customizerSentences.customizerURI+"/assets/images/unique-setting.gif')", 'background-position':'center center'});
        }

        // Show hint step 1
        $('.introjs-hint[data-step=1]').css('opacity', 1);
    });

    $('.customizer-btn.page').click(function(){
        $(this).find('.cd-dropdown-wrapper').addClass('active-dropdown-view');
        $(this).find('.cd-dropdown-wrapper .helper').css({'background-image': "url('"+customizerSentences.customizerURI+"/assets/images/add-new-page.gif')", 'background-position':'center center'});
    });

    var responsiveCountDown,saveCountDown,pageCountDown,informationCountDown,settingCountDown,
        pannelFlag=false, hintFlag=true ;


    function pixflow_hidePannel() {
        'use strict';
        if ( pannelFlag && hintFlag ) {
            $('body').click();
            $('.introjs-hint[data-step=1]').css('display', 'none');
            $('.customizer-btn.setting .cd-dropdown-wrapper').removeClass('active-dropdown-view');
        }

    }

    $('.customizer-btn.setting').mouseleave(function() {

        settingCountDown = setTimeout(function () {

            pannelFlag = true;

            pixflow_hidePannel();

        }, 500);

    });


    $('.customizer-btn.setting').mouseenter(function() {
        pannelFlag = false;
    });


    /* Hint mouse enter & leave */
    $("body").on('mouseenter', '.introjs-hint[data-step=1]', function() {
        hintFlag = false;
    });

    $("body").on('mouseup', '.introjs-button', function() {
        hintFlag = true;
    });

    $("body").on('mouseleave', '.introjs-hint[data-step=1]', function() {
        hintFlag = true;
    });

    /* Tooltip mouse enter */
    $("body").on('mouseenter', '.introjs-fixedTooltip[data-step=1] .introjs-tooltip', function() {
        hintFlag = false;
    });

    /* Tooltip mouse leave */
    $("body").on('mouseleave', '.introjs-fixedTooltip[data-step=1] .introjs-tooltip', function() {
        hintFlag = true;
        $('body').click();
        pixflow_hidePannel();
    });

    // Video link clicked
    $('body').on('mouseup','.video-link-part', function() {
        hintFlag = true;
    });



    $('.customizer-btn.setting').mouseover(function() {
        clearTimeout(settingCountDown);
    });

    $('.responsive-view').mouseleave(function(){
        responsiveCountDown = setTimeout(function() {
            $('.responsive-view .cd-dropdown-wrapper').removeClass('active-dropdown-view');
        }, 500);
    });
    $('.responsive-view').mouseover(function() {
        clearTimeout(responsiveCountDown);
    });

    $('#save-btn .save-preview').click(function () {
        $('#save-btn .cd-dropdown-wrapper').removeClass('active-dropdown-view');
        $('#save-btn .cd-dropdown-wrapper .circle').removeClass('expand');
    });

    $('#save-btn').mouseleave(function(){
        saveCountDown = setTimeout(function() {
            $('#save-btn .cd-dropdown-wrapper').removeClass('active-dropdown-view');
            $('#save-btn .cd-dropdown-wrapper .circle').css('transition-duration','1ms');
            $('#save-btn .cd-dropdown-wrapper .circle').removeClass('expand');
        }, 500);
    });

    $('#save-btn').mouseover(function() {
        clearTimeout(saveCountDown);
    });

    $('.customizer-btn.page').mouseleave(function(){
        pageCountDown = setTimeout(function() {
            $('.customizer-btn.page .cd-dropdown-wrapper').removeClass('active-dropdown-view');
        }, 500);
    });
    $('.customizer-btn.page').mouseover(function() {
        clearTimeout(pageCountDown);
    });

    $('.customizer-btn.information').mouseleave(function(){
        informationCountDown = setTimeout(function() {
            $('.customizer-btn.information .cd-dropdown-wrapper').removeClass('active-dropdown-view');
        }, 500);
    });
    $('.customizer-btn.information').mouseover(function() {
        clearTimeout(informationCountDown);
    });

    $('body').click(function(){
        $('.cd-dropdown-wrapper ul li .cd-dropdown-option').css({'background-image':'none'});
        $('.cd-dropdown-wrapper ul li a').css('color','#262626');
    });
    $('.cd-dropdown-wrapper ul li:not(.description)').click(function(e){
        e.stopPropagation();
        $('.cd-dropdown-wrapper ul li .cd-dropdown-option').css({'background-image':'none'});
        $(this).find('.cd-dropdown-option').css({
            'z-index':1,
            'position': 'relative',
            'text-indent': '90px',
            'transform':'rotateY(90deg)'
        }).animate({'text-indent':0},{
            step:function(now,fx){
                $(this).css('transform','rotateY('+ now +'deg)')
            }
        },800);

        var parentOffset = $(this).offset();
        //or $(this).offset(); if you really just want the current element's offset
        var relX = e.pageX - parentOffset.left;
        var relY = e.pageY - parentOffset.top;

        var speed = (Math.abs($(this).width()/2 - relX )+1);

        if(speed < 50) speed = 3500;
        else if(speed < 90) speed = 2000;
        else speed = 1000;

        $('.cd-dropdown ul li .circle').removeClass('expand');

        $(this).find('.circle').addClass('expand');
        $(this).find('.circle').css('top',relY);
        $(this).find('.circle').css('left',relX);
        $('.cd-dropdown ul li .circle').css('transition-duration','0ms');
        $(this).find('.circle').css('transition-duration',speed+'ms');

        if($(this).hasClass('desktop')) {
            $('.wp-full-overlay-main').css('bottom','130px');
            $('#customize-preview > iframe').contents().find('iframe').contents().find('.default')[0].click();
            $('#customize-preview > iframe').contents().find('iframe').contents().find('#vc_inline-frame-wrapper').removeClass();
            $('#customize-preview').prepend('<div class="browser-frame"><div><span class="circle"></span><span class="circle"></span><span class="circle"></span></div> <span class="title">'+customizerSentences.yourWebsite+'</span> </div>');
            $('#customize-preview .iframe-shadow').css({'padding-top':'37px','webkit-box-shadow': '0 0 10px rgba(0,0,0,.32)','-moz-box-shadow':'0 0 10px rgba(0,0,0,.32)','box-shadow':'0 0 10px rgba(0,0,0,.32)'});
        }else if($(this).hasClass('tablet-landscape')) {
            $('.wp-full-overlay-main').css('bottom','95px');
            $('#customize-preview > iframe').contents().find('iframe').contents().find('.landscape-tablets')[0].click();
            $('#customize-preview > iframe').contents().find('iframe').contents().find('#vc_inline-frame-wrapper').removeClass();
            $('#customize-preview > iframe').contents().find('iframe').contents().find('#vc_inline-frame-wrapper').addClass('tablet-landscape');
            $('.browser-frame').remove();
            $('#customize-preview .iframe-shadow').css({'padding-top':'0px','webkit-box-shadow': 'none','-moz-box-shadow':'none','box-shadow':'none'});
            if(!$('.collaps.customizer-btn').hasClass('hold-collapse')){
                $('.collaps.customizer-btn').click();
            }

        }else if($(this).hasClass('tablet-portrait')) {
            $('.wp-full-overlay-main').css('bottom','75px');
            $('#customize-preview > iframe').contents().find('iframe').contents().find('.portrait-tablets')[0].click();
            $('#customize-preview > iframe').contents().find('iframe').contents().find('#vc_inline-frame-wrapper').removeClass();
            $('#customize-preview > iframe').contents().find('iframe').contents().find('#vc_inline-frame-wrapper').addClass('tablet-portrait');
            $('.browser-frame').remove();
            $('#customize-preview .iframe-shadow').css({'padding-top':'0px','webkit-box-shadow': 'none','-moz-box-shadow':'none','box-shadow':'none'});
            if(!$('.collaps.customizer-btn').hasClass('hold-collapse')){
                $('.collaps.customizer-btn').click();
            }

        }else if($(this).hasClass('smartphone-landscape')) {
            $('.wp-full-overlay-main').css('bottom','95px');
            $('#customize-preview > iframe').contents().find('iframe').contents().find('.landscape-smartphones')[0].click();
            $('#customize-preview > iframe').contents().find('iframe').contents().find('#vc_inline-frame-wrapper').removeClass();
            $('#customize-preview > iframe').contents().find('iframe').contents().find('#vc_inline-frame-wrapper').addClass('smartphone-landscape');
            $('.browser-frame').remove();
            $('#customize-preview .iframe-shadow').css({'padding-top':'0px','webkit-box-shadow': 'none','-moz-box-shadow':'none','box-shadow':'none'});
            if(!$('.collaps.customizer-btn').hasClass('hold-collapse')){
                $('.collaps.customizer-btn').click();
            }

        }else if($(this).hasClass('smartphone-portrait')) {
            $('.wp-full-overlay-main').css('bottom','95px');
            $('#customize-preview > iframe').contents().find('iframe').contents().find('.portrait-smartphones')[0].click();
            $('#customize-preview > iframe').contents().find('iframe').contents().find('#vc_inline-frame-wrapper').removeClass();
            $('#customize-preview > iframe').contents().find('iframe').contents().find('#vc_inline-frame-wrapper').addClass('smartphone-portrait');
            $('.browser-frame').remove();
            $('#customize-preview .iframe-shadow').css({'padding-top':'0px','webkit-box-shadow': 'none','-moz-box-shadow':'none','box-shadow':'none'});
            if(!$('.collaps.customizer-btn').hasClass('hold-collapse')){
                $('.collaps.customizer-btn').click();
            }
        }
    });

    $('#customize-preview .customizer-btn').click(function(){
        $(this).find('.tooltip').css({'display':'none','top':'5px','opacity':'0'});
    });
    $('#customize-preview .customizer-btn .cd-dropdown-wrapper').mousemove(function(){
        $(this).prev().css({'display': 'none','top': '5px','opacity':'0'});
    });


    var customizerLoader = $('<div class="main-loader">' +
        '<span class="text">'+customizerSentences.helloMassiveDynamic+'</span>' +
        '<div class="loading">' +
        '<div class="circle">' +
        '<svg class="circle-fill">' +
        '<circle cx="16" cy="16" r="13" stroke="#36b38b" stroke-width="3" stroke-linecap="round" fill="none"></circle>' +
        '</svg>' +
        '<svg class="circle-track">' +
        '<circle cx="16" cy="16" r="13" stroke="#dbdbdb" stroke-width="3" fill="none"></circle>' +
        '</svg>' +
        '<i class="icon icon-checkmark4"></i>' +
        '</div>' +
        '<span class="loading-text">'+customizerSentences.loading+' <span class="rotating-text">0%</span>' +
        '</div>' +
        '<div/>');
    customizerLoader.appendTo('body');
    var mainLoader = $('.main-loader'),
        mainText = mainLoader.find('.text'),
        mainLoading = mainLoader.find('.loading');
    TweenMax.to(mainText,1,{'opacity':1,delay:0.5});
    TweenMax.to(mainLoading,0.3,{'opacity':1,delay:1.5});
    TweenMax.to(mainLoading,0.3,{'border-color':'#d9d9d9',delay:2});
    TweenMax.to(mainLoading,0.4,{'width':'90px',delay:2.5,onComplete:function(){
        var $rotatingText = $('.main-loader .loading .rotating-text'),
            oldText = 0,
            currentText = -1;
        $rotatingText.css('right',0).animate({'right':99},{
            duration :50000,
            step: function(now,tween){
                $(this).html(Math.floor(now)+"%");
            },
            easing:'easeOutExpo'
        })
    }});

    setTimeout(function() {
        $.ajax({
                url: "http://massivedynamic.co/greeting.php",
                cache: false,
                dataType: "text",
                crossDomain: true
            })
            .done(function( data ) {
                //process text file line by line
                var lines = data.split("\n"),
                    interval = null,
                    i = 0,
                    $text = $('.main-loader .text'),
                    random = false;

                interval = setInterval(function(){
                    pixflow_showTexts();
                },4000);
                function pixflow_showTexts(){
                    'use strict';
                    if(i >= lines.length){
                        clearInterval(interval);
                        return;
                    }
                    if(!random){
                        var text = lines[i];
                        if(text == '-random'){
                            lines.splice(0, i+1);
                            random = true;
                            i=0;
                            return;
                        }
                    }else{
                        var j = Math.floor(Math.random() * (lines.length));
                        var text = lines[j];
                        lines.splice(j, 1);
                        i=-1;
                    }

                    if($text.css('opacity') == '0'){
                        TweenMax.to($text.html(text),1.5,{'opacity':1});
                    }else {
                        TweenMax.to($text,0.5,{'opacity':'0',onComplete: function(){
                            TweenMax.to($text.html(text),1.5,{'opacity':1});
                        }});
                    }
                    i++;
                }
            });
    },1);
    pixflow_getNotifications();
});
if(customizerSentences.firstTime=='false'){
    firstTime = false;
}else{
    firstTime = true;
}
