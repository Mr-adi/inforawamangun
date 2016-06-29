var $                      = jQuery,
    scrollFlag             = 0,

    navColor               = themeOptionValues.navColor,
    navHoverColor          = themeOptionValues.navHoverColor,

    navColorSecond         = themeOptionValues.navColorSecond,
    navHoverColorSecond    = themeOptionValues.navHoverColorSecond,

    type                   = themeOptionValues.headerBgColorType,
    color1                 = themeOptionValues.headerBgGradientColor1,
    color2                 = themeOptionValues.headerBgGradientColor2,
    orientation            = themeOptionValues.headerBgGradientOrientation,
    solidColor             = themeOptionValues.headerBgSolidColor,

    typeSecond             = themeOptionValues.headerBgColorTypeSecond,
    colorSecond1           = themeOptionValues.headerBgGradientSecondColor1,
    colorSecond2           = themeOptionValues.headerBgGradientSecondColor2,
    orientationSecond      = themeOptionValues.headerBgGradientSecondOrientation,
    solidColorSecond       = themeOptionValues.headerBgSolidColorSecond,

    siteTop                = parseInt(themeOptionValues.siteTop),
    showUpAfter            = themeOptionValues.showUpAfter,
    showUpStyle            = themeOptionValues.showUpStyle,

    classSecond            = [],
    classFirst             = [],

    headerTopWidth,
    layoutWidth,
    headerWidth,

    backgroundSize,

    logoStyle              = themeOptionValues.logoStyle,
    logoStyleSecond        = themeOptionValues.logoStyleSecond,
    lightLogo              = themeOptionValues.lightLogo,
    darkLogo               = themeOptionValues.darkLogo;

darkLogo  = (''== darkLogo)  ? $('header .logo img').attr('src') : darkLogo;
lightLogo = (''== lightLogo) ? $('header .logo img').attr('src') : lightLogo;


/*Detect site loading position
 return front-end when load normally(not from customizer)
 return customizer-vc-disable when load from customizer and VC is disable
 return customizer-vc-enable when load from customizer and VC is enable
 return other when not load from customizer (load form iframe)*/
function pixflow_detectPosition(){
    'use strict';

    if(window.self === window.top){
        return 'front-end';
    }else{
        var $top = top.location.href;
        if($top.indexOf("customize.php") != -1){
            if($('#vc-link').length){
                return 'customizer-vc-disable';
            }else{
                return 'customizer-vc-enable';
            }
        }else{
            return 'other';
        }
    }
}

function pixflow_gatherHeader() {
    "use strict";

    if (!$('header.top-gather').length)
        return;
    var $openBtn = $('.top-gather .gather-btn span.icon-gathermenu'),
        $closeBtn = $('.gather-overlay .gather-btn'),
        $overlay  = $('.gather-overlay');


    $openBtn.click(function () {
        var screenHeight=window.innerHeight;

        if (!$overlay.hasClass('active')) {
            //show overlay
            $(window).scrollTop(0);
            $overlay.addClass('active');
            $(".gather-overlay").css('display','block');
            TweenMax.to($(".gather-overlay"),.4, {autoAlpha:.93})
            TweenMax.to($(".gather-overlay"),.6, {
                height:screenHeight,
                startAt: {scale: 1.7},
                scale: 1,
                ease: Cubic.easeOut
            });
            TweenMax.to(['.layout , .layout-container > .color-overlay , .layout-container > .texture-overlay , .layout-container > .bg-image'], .5, {
                scale:0.9 ,
                ease: Cubic.easeInOut,
            });
            $('.layout-container').css({'overflow':'hidden', 'max-height': '100%'});
            $('body > div ').each(function(){
                if($(this).height() > $(window).height()){
                    $(this).css('height',$(window).height());
                }
            });
        }
    });

    $closeBtn.click(function () {
        pixflow_closeOverlay();
    });

    $overlay.click(function () {
        pixflow_closeOverlay();
    });


}

function pixflow_closeOverlay(){
    'use strict';

    var $overlay  = $('.gather-overlay');

    if ($overlay.hasClass('active')) {
        $overlay.removeClass('active');
        $(".gather-overlay").css('display','none');
        TweenMax.to($(".gather-overlay"), .5, {scale: 1.6, autoAlpha: 0, ease: Cubic.easeInOut});
        TweenMax.to(['.layout , .layout-container > .color-overlay , .layout-container > .texture-overlay , .layout-container > .bg-image'], .5, {
            scale: 1,
            ease: Cubic.easeInOut,
            onComplete:function(){
                $('.layout').css('transform','none');
                $('.layout-container').css({'overflow':'', 'max-height': ''});
            }
        });

    }

}
function pixflow_headerSideModernFooterHover(){
    'use strict';
    var $footerSwitch =  $('.footer .info > a'),
        $footerContent = $footerSwitch.siblings('.footer-content'),
        $socials       = $footerContent.find('.footer-socials'),
        $copyright     = $footerContent.find('.copyright'),
        $copyAnimation, $socialAnimation;



    $footerContent.css({width:($socials.outerWidth(true)+$copyright.outerWidth(true)),display:'none'});

    $footerSwitch.hoverIntent(function() {

        $footerContent.css('display','block');
        $socialAnimation = TweenMax.to($socials, .1, {transform: 'perspective(1000px) rotateY(0deg)', opacity:1});
        $copyAnimation = TweenMax.to($copyright, .3, {transform: 'perspective(1000px) rotateY(0deg)', opacity:1,delay:0.2,ease:Back.easeOut});
    },function() {
        //don't remove this
    });

    $('.footer').hover(function(){
        "use strict";
        //this one too :)
    },function() {
        "use strict";
        if((typeof $socialAnimation != "undefined") && (typeof $copyAnimation != "undefined")) {
            $socialAnimation.pause();
            $copyAnimation.pause();
        }

        if($(this).parents('header').hasClass('left')){ //Left header

            TweenMax.to($copyright, .1, {transform: 'perspective(1000px) rotateY(90deg)', opacity:0});
            TweenMax.to($socials, .1, {transform: 'perspective(1000px) rotateY(90deg)', opacity:0,delay:.2});

        } else if($(this).parents('header').hasClass('right')) { //Right header
            TweenMax.to($copyright, .1, {transform: 'perspective(1000px) rotateY(-90deg)', opacity:0});
            TweenMax.to($socials, .1, {transform: 'perspective(1000px) rotateY(-90deg)', opacity:0,delay:.2});
        }

        TweenMax.to($footerContent, .1, {display:'block',delay:.2});
    });

    //Footer social icons hover
    var $socialIcon = $socials.find('.icon');

    $socialIcon.each(function () {

        var defaultIcon  = $(this).find('span.default'),
            hoverIcon    = $(this).find('span.hover');

        $(this).hover(function () {
            TweenMax.to(defaultIcon, 0.55, {top: "50px", opacity: 0, ease: Cubic.easeInOut});
            TweenMax.to(hoverIcon, 0.55, {top: "0", opacity: 1, ease: Cubic.easeInOut});
        }, function () {
            TweenMax.to(defaultIcon, 0.55, {top: "0", opacity: 1, ease: Cubic.easeInOut});
            TweenMax.to(hoverIcon, 0.55, {top: "-50px", opacity: 0, ease: Cubic.easeInOut});
        })
    });
}
function pixflow_headerSideModern(){
    "use strict";
    var $nav = $('header.side-modern nav'),
        $lis = $nav.find('> ul > li'),
        liCount = 1,
        navWidth = 'auto',
        longestMenu= 1,
        style1 = $('header.side-modern .content').hasClass('style-style1'),
        flip0Animation = new TimelineMax(),
        $flip0, $flip1, $flip2, count, modernEffect, $aHeight, navHeight;

        if(! $('header.side-modern').length )
            return;

    if ( style1 ){
        $lis = $nav.find('ul');
    }
    else{
        liCount = $lis.length;
        navWidth = ( liCount > 3 ) ? 200* 3  : liCount*200;
    }

    $nav.css('width',navWidth);

    if( liCount%3 != 0 && liCount > 3 ){

        count = 3 - liCount % 3,
            i = 0;

        for( i =0 ; i < count;i++){
            $nav.find('> ul').append('<li class="empty-dropdown" ></li>')
        }

        $lis = $nav.find('> ul > li');
    }

    // add flip class
    $lis.each(function(index,value){
        var liClass = 'flip'+ index % 3 ;
        $(value).addClass(liClass);

        if( index / 3 >= 1 && !style1){
            $(value).addClass('li-level2');
        }
    });

    //make dropdowns equal height
    if (!style1) {

        $nav.find('> ul > li.has-dropdown > .dropdown').each(function () {
            var currentLength = (jQuery)(this).find('> li').length;

            if (currentLength > longestMenu) {
                longestMenu = currentLength;
            }
        });
        $nav.find('> ul > li.has-dropdown > .dropdown').each(function () {
            var $dropdown = (jQuery)(this);
            var currentLength = $dropdown.find('> li').length;
            if (currentLength < longestMenu) {
                for (var i = 1; i <= longestMenu - currentLength; i++) {
                    $dropdown.append('<li class="empty-megamenu"></li>');
                }
            }
        });

        $nav.css({'display': 'block'});
        $aHeight = $lis.find(' > a').height();
        navHeight = parseInt($aHeight + 15) * longestMenu + 20;
        $lis.css('height', navHeight + 'px');
        $nav.css({'display': 'none'});
    }

    $flip0 = $nav.find('.flip0');
    $flip1 = $nav.find('.flip1');
    $flip2 = $nav.find('.flip2');

    modernEffect = new TimelineMax({ paused: true });
    modernEffect.add( TweenMax.staggerTo( [$flip0,$flip1,$flip2], .3, {transform: 'perspective(1000px) rotateY(0deg)',opacity: 1, ease: Power4.easeOut,delay:0},.1));

    var modernEffectStyle1 =  new TimelineMax({ paused: true });
    modernEffectStyle1.add( TweenMax.staggerTo( $flip0, .3, {transform: 'perspective(1000px) rotateY(0deg)',opacity: 1, ease: Power4.easeOut,delay:0},.1));


    $('.side-modern .nav-modern-side').hoverIntent({
        interval:200,
        over:pixflow_modernUlOpen,
        out:pixflow_modernUlClose
    });

    $('header.side-modern .style-style1.side nav.navigation ul li.has-dropdown').hover(
        function(){
        TweenMax.staggerTo( $(this).find('> ul[class *= "flip"]'), .3, {transform: 'perspective(1000px) rotateY(0deg)',opacity: 1, ease: Power4.easeOut,delay:0},.1);
        },
        function(){
            TweenMax.staggerTo( $(this).find('> ul[class *= "flip"]'), .3, {transform: 'perspective(1000px) rotateY(90deg)',opacity: 0, ease: Power4.easeOut,delay:0},.1);
        }
    );

    function pixflow_modernUlOpen(){
        'use strict';
        $(this).find('nav').css({'display':'block'});
        if (style1){
            modernEffectStyle1.restart()
        }else{
            modernEffect.restart();
        }
    };

    function pixflow_modernUlClose(){
        "use strict";

        if ( $(this).parents('header.left').length || $(this).parents('header.right').length ) {
            modernEffect.reverse();
            modernEffectStyle1.reverse();
        }

        TweenMax.to($(this).find('nav'), 0, {display: 'none',delay:.7});
    };



    /********************************************************************* Footer Hover *************************************************************************************/
    pixflow_headerSideModernFooterHover();

    /************************************************************* menu icons pack and search icon hover animation ************************************************/
    var $icons = $('header.side-modern .icons-pack .icon');

    $icons.each(function(){
        var defaultIcon = $(this).find('span.default'),
            hoverIcon = $(this).find('span.hover'),
            defaultColor = $icons.find('a').css('color'),
            hoverColor;

        if(typeof defaultColor != "undefined") {
            hoverColor = pixflow_rgbVal(defaultColor);
            hoverColor = "rgba("+hoverColor+",0.1)";
        }

        $(this).hover(function(){
            if($(this).parents('header').hasClass('left')){ //Left header

                //opening the search form
                if($(this).hasClass('search')){

                    $(this).find('.search-form').css('display','block');
                    TweenMax.to($(this).find('.search-form'), .4, {transform: 'perspective(1000px) rotateY(0deg)', opacity:1});

                }

                TweenMax.to(defaultIcon,0.55,{left:"65px", opacity:0, ease:Cubic.easeInOut});
                TweenMax.to(hoverIcon,0.55,{left:"0", opacity:1, ease:Cubic.easeInOut});
                TweenMax.to($(this).find('a'),0.3,{backgroundColor:hoverColor});

            } else if($(this).parents('header').hasClass('right')){ //Right header

                //opening the search form
                if($(this).hasClass('search')){
                    $(this).find('.search-form').css('display','block');
                    TweenMax.to($(this).find('.search-form'), .4, {transform: 'perspective(1000px) rotateY(0deg)', opacity:1});
                }

                TweenMax.to(defaultIcon,0.55,{right:"65px", opacity:0, ease:Cubic.easeInOut});
                TweenMax.to(hoverIcon,0.55,{right:"0", opacity:1, ease:Cubic.easeInOut});
                TweenMax.to($(this).find('a'),0.3,{backgroundColor:hoverColor});
            }


        },function(){
            if($(this).parents('header').hasClass('left')){ //Left header

                //closing the search form
                if($(this).hasClass('search')){
                    TweenMax.to($(this).find('.search-form'), .2, {transform: 'perspective(1000px) rotateY(90deg)', opacity:0});
                    TweenMax.to($(this).find('.search-form'), .1, {display:'none',delay:.15});
                }
                TweenMax.to(defaultIcon,0.55,{left:"0", opacity:1, ease:Cubic.easeInOut});
                TweenMax.to(hoverIcon,0.55,{left:"-65px", opacity:0, ease:Cubic.easeInOut});
                TweenMax.to($(this).find('a'),0.3,{backgroundColor:'transparent'});
            } else if($(this).parents('header').hasClass('right')){ //Right header

                //closing the search form
                if($(this).hasClass('search')){
                    TweenMax.to($(this).find('.search-form'), .2, {transform: 'perspective(1000px) rotateY(-90deg)', opacity:0});
                    TweenMax.to($(this).find('.search-form'), .1, {display:'none',delay:.15});
                }
                TweenMax.to(defaultIcon,0.55,{right:"0", opacity:1, ease:Cubic.easeInOut});
                TweenMax.to(hoverIcon,0.55,{right:"-65px", opacity:0, ease:Cubic.easeInOut});
                TweenMax.to($(this).find('a'),0.3,{backgroundColor:'transparent'});
            }
        })
    });

    /************************************************* menu navigation button hover animation *****************************************************************/
    var $icon = $('header.side-modern .nav-modern-button');

    var navDefaultIcon = $icon.find('span.default'),
        navHoverIcon = $icon.find('span.hover'),
        navDefaultColor = navDefaultIcon.css('color'),
        navHoverColor;

    if(typeof navDefaultColor != "undefined") {
        navHoverColor = pixflow_rgbVal(navDefaultColor);
        navHoverColor = "rgba(" + navHoverColor + ",0.1)";
    }

    $icon.hover(function(){
        if($(this).parents('header').hasClass('left')) { //Left header

            TweenMax.to(navDefaultIcon, 0.55, {left: "65px", opacity: 0, ease: Cubic.easeInOut});
            TweenMax.to(navHoverIcon, 0.55, {left: "0", opacity: 1, ease: Cubic.easeInOut});
            TweenMax.to($icon, 0.3, {backgroundColor: navHoverColor});

        } else if($(this).parents('header').hasClass('right')) { //Right header

            TweenMax.to(navDefaultIcon, 0.55, {right: "65px", opacity: 0, ease: Cubic.easeInOut});
            TweenMax.to(navHoverIcon, 0.55, {right: "0", opacity: 1, ease: Cubic.easeInOut});
            TweenMax.to($icon, 0.3, {backgroundColor: navHoverColor});
        }
    },function(){
        if($(this).parents('header').hasClass('left')) { //Left header

            TweenMax.to(navDefaultIcon, 0.55, {left: "0", opacity: 1, ease: Cubic.easeInOut});
            TweenMax.to(navHoverIcon, 0.55, {left: "-65px", opacity: 0, ease: Cubic.easeInOut});
            TweenMax.to($icon, 0.3, {backgroundColor: 'transparent'});

        } else if($(this).parents('header').hasClass('right')) { //Right header
            TweenMax.to(navDefaultIcon, 0.55, {right: "0", opacity: 1, ease: Cubic.easeInOut});
            TweenMax.to(navHoverIcon, 0.55, {right: "-65px", opacity: 0, ease: Cubic.easeInOut});
            TweenMax.to($icon, 0.3, {backgroundColor: 'transparent'});
        }
    });

}

//menuClassicAnimation()
function pixflow_underlineAnimation(){
    'use strict';

    var TM = TweenMax,
        $selector = $('header.top-classic .top:not(.style-border) nav > ul > li > a,' +
            'header.top-logotop  nav > ul > li > a');

    if( ! $selector.length )
        return;

    $selector.each(function() {
        $(this).unbind('mouseenter mouseleave');
        if($(this).parents('.content').hasClass('style-wireframe')){
            $(this).hover(function() {
                TM.to($(this).find(' > .menu-separator'),0.15,{width:"100%",ease:Power1.easeInOut});
            },function(){
                TM.to($(this).find(' > .menu-separator'),0.15,{width:"22px",ease:Power1.easeInOut});
            })
        } else{ // Other Classic top styles
            $(this).find(' > .menu-separator').css('width','auto');
            $(this).find(' > .menu-title .title').css('line-height','normal');
            $(this).hover(function() {
                TM.to($(this).find(' > .menu-separator'),0.2,{left:"0",ease:Back.easeOut});
                TM.to($(this).find(' > .menu-separator'),0.2,{right:"0",ease:Back.easeOut});
            },function(){
                TM.to($(this).find(' > .menu-separator'),0.5,{left:"50%",ease:Back.easeOut});
                TM.to($(this).find(' > .menu-separator'),0.5,{right:"50%",ease:Back.easeOut});
            })
        }
    });
}

function pixflow_classicTopWireframeStyle(){
    if( !$('header.top-classic .content').hasClass('style-wireframe') ) return;

    $('header.top-classic .style-wireframe nav > ul > li > a .menu-title .title').css('line-height',$('header').height()+'px');
    $('header.top-classic .style-wireframe nav > ul > li > .dropdown').css('top',$('header').height()+'px');
}

function pixflow_menuTopBlockSquare(){
    'use strict';

    var TMB = TweenMax;

    //Menu Block style hover animation
    $('.top-block:not(.header-clone) .style-style2 nav > ul > li , .top-block:not(.header-clone) .style-style2 .icons-pack li').each(function()
    {
        var $this = $(this);

        $this.hover(function()
        {
            TMB.to( $this.find('> a .menu-separator-block'),1,{bottom:"3px",ease:Elastic.easeOut});
            TMB.to( $this.find('> a .menu-separator-block'),0.9,{height:"3px",ease:Quart.easeOut});
            TMB.to( $this.find('> a .menu-separator-block'),0.1,{opacity:"1"});

            TMB.to( $this.find('.hover-effect'), 0.5, { opacity: "1", marginTop: "80px" }); // for menu
            TMB.to( $this.find('.hover-content'), 0.5, {opacity: "1", marginTop: "80px" }); // for icons pack
        },function(){
            TMB.to($this.find('.hover-effect') , 0.2, { opacity: "0", marginTop: "0" }); // for menu
            TMB.to( $this.find('.hover-content') , 0.2, { opacity: "0", marginTop: "0" }); // for icons pack

            TMB.to($this.find('> a .menu-separator-block'),0.8,{bottom:"-10px"});
            TMB.to($this.find('> a .menu-separator-block'),0.4,{height:"6px"});
            TMB.to($this.find('> a .menu-separator-block'),1,{opacity:"0"});
        });

    });
}

function pixflow_menuTopBlockRec(){
    'use strict';

    var $header     = $('header.top-block'),
        $style1     = $header.find('.style-style1'),
        $menu       = $style1.find('nav > ul > li'),
        $iconsPack  = $style1.find('.icons-pack li'),
        $menuFront  = $menu.find('> a .menu-title'),
        $iconsFront = $iconsPack.find('.title-content'),
        $arrayTemp  = [],
        counter     = 0;

    //if ($menu.length) {

        // Menu navigation
        $menu.each(function () {
            $arrayTemp[counter] = $(this).css('width');
            counter++;
        });

        $menuFront.css({position: 'absolute'});
        counter = 0;

        $menu.each(function () {
            $(this).css({width: $arrayTemp[counter]});
            counter++;
        });

        $arrayTemp = [];
        counter = 0;

        // Icons pack
        $iconsPack.each(function () {
            $arrayTemp[counter] = $(this).css('width');
            counter++;
        });

        $header.css({overflow: 'inherit'});
        $iconsFront.css({position: 'absolute'});
        counter = 0;

        $iconsPack.each(function () {
            $(this).css({width: $arrayTemp[counter]});
            counter++;
        });

    //} // end if

}

/*
 Generate Gradient Background
 Get 2color and Orientation
 Return background style
 */
function pixflow_generateGradientBackground(color1, color2, orientation, colorSecond1, colorSecond2, orientationSecond){
    "use strict";

    var  bg_css= [];

    bg_css[0] = color1;

    if (orientation == "horizontal") {
        bg_css[1]="-moz-linear-gradient(left,"+color1+" 0%,"+color2+"33%,"+colorSecond1+" 77%,"+colorSecond2+" 100%)";
        bg_css[2]="-webkit-gradient(linear, left top, right top, color-stop(0%,"+color1+"), color-stop(33%,"+color2+"),color-stop(77%,"+colorSecond1+"),color-stop(100%,"+colorSecond2+"))";
        bg_css[3]="-webkit-linear-gradient(left,"+color1+" 0%,"+color2+"33%,"+colorSecond1+" 77%,"+colorSecond2+" 100%)";
        bg_css[4]="-o-linear-gradient(left, "+color1+" 0%,"+color2+"33%,"+colorSecond1+" 77%,"+colorSecond2+" 100%)";
        bg_css[5]="-ms-linear-gradient(left,  "+color1+" 0%,"+color2+"33%,"+colorSecond1+" 77%,"+colorSecond2+" 100%)";
        bg_css[6]="linear-gradient(to right, "+color1+" 0%,"+color2+"33%,"+colorSecond1+" 77%,"+colorSecond2+" 100%)";
        bg_css[7]="progid:DXImageTransform.Microsoft.gradient(startColorstr='"+color1+"', endColorstr='"+color2+"', GradientType=0)";

    } else {
        bg_css[1]="-moz-linear-gradient(top,"+color1+" 0%,"+color2+"33%,"+colorSecond1+" 77%,"+colorSecond2+" 100%)";
        bg_css[2]="-webkit-gradient(linear, left top, left bottom, color-stop(0%,"+color1+"), color-stop(33%,"+color2+"),color-stop(77%,"+colorSecond1+"),color-stop(100%,"+colorSecond2+"))";
        bg_css[3]="-webkit-linear-gradient(top,  "+color1+" 0%,"+color2+" 33%,"+colorSecond1+" 66%,"+colorSecond2+" 100%)";
        bg_css[4]="-o-linear-gradient(top,  "+color1+" 0%,"+color2+" 33%,"+colorSecond1+" 77%,"+colorSecond2+" 100%)";
        bg_css[5]="-ms-linear-gradient(top,  "+color1+" 0%,"+color2+" 33%,"+colorSecond1+" 77%,"+colorSecond2+" 100%)";
        bg_css[6]="linear-gradient(to bottom, "+color1+" 0%,"+color2+" 33%,"+colorSecond1+" 77%,"+colorSecond2+" 100%)";
        bg_css[7]="progid:DXImageTransform.Microsoft.gradient(startColorstr='"+color1+"', endColorstr='"+color2+"', GradientType=0)";
    }
    return bg_css;
}

/*
 Generate Solid Background
 Get 1color
 Return background style
 */
function pixflow_generateSolidBackground(solidColor){
    "use strict";

    var  bg_css= [];

    if($('header.top-block').length){
        bg_css[0]=pixflow_RgbaToRgb(solidColor);
    }else{
        bg_css[0]= solidColor;
    }
    return bg_css;
}

function pixflow_showHeaderChanges(){
    "use strict";

    scrollFlag = 0;
    pixflow_headerSetting();
    $(window).scroll();
}

//if setting change in customizer applied here
function pixflow_headerSetting(){
    "use strict";

    var newStyle;

    if($('.header-second-setting').length){

        navColor           = $('#navColor').val();
        navHoverColor      = $('#navHoverColor').val();
        solidColor         = $('#bgSolidColor').val();
        color1             = $('#bgGradientColor1').val();
        color2             = $('#bgGradientColor2').val();
        orientation        = $('#bgGradientOrientation').val();

        navColorSecond     = $('#navColorSecond').val();
        navHoverColorSecond= $('#navHoverColorSecond').val();
        solidColorSecond   = $('#bgSolidColorSecond').val();
        colorSecond1       = $('#bgGradientSecondColor1').val();
        colorSecond2       = $('#bgGradientSecondColor2').val();
        orientationSecond  = $('#bgGradientSecondOrientation').val();

        siteTop            = $('#headerSiteTop').val();
        siteTop            = siteTop.split("px");
        siteTop            = parseInt(siteTop[0]);

        showUpAfter        = parseInt($('#showUpAfter').val());

        layoutWidth        = parseInt($('#layoutWidth').val());
        headerTopWidth     = parseInt($('#headerTopWidth').val());
        headerWidth        =(headerTopWidth/100*layoutWidth/100)*100+'%';

        logoStyle          = $('#logoStyle').val().trim();
        logoStyleSecond    = $('#logoStyleSecond').val().trim();
        if(type=='gradient' || typeSecond=='gradient') {
            if(type!='gradient'){
                color2 = color1 = solidColor;
                orientation = orientationSecond;
            }
            if(typeSecond != 'gradient'){
                colorSecond2 = colorSecond1 = solidColorSecond;
                orientationSecond = orientation;
            }

            classFirst = pixflow_generateGradientBackground(color1, color2, orientation,colorSecond1,colorSecond2,orientationSecond);
            classSecond = classFirst;
        }else{
            classFirst = pixflow_generateSolidBackground(solidColor);
            classSecond = pixflow_generateSolidBackground(solidColorSecond);
        }

        if(orientation == 'horizontal')
            backgroundSize = '400% 400%';
        else
            backgroundSize = '100% 400%';
    }

    newStyle="<style scoped data-name='second-setting'>"+
        "header.top-modern .btn-1b-second:after{ background : " + navColorSecond + "}" +
        "header.top-modern .btn-1b-second:active{background: "+navColorSecond+"}"+
        "header.top-modern .btn-1b-first:after{ background : " + navColor + "}" +
        "header.top-modern .btn-1b-first:active{background: "+navColor+"}"+
        "header.top-block .color-overlay { background : " + classFirst + "}" +
        "header.top-block:not(.header-clone) .style-style1 nav > ul > li > a .menu-title,header.top-block:not(.header-clone) .style-style1 .icons-pack .title-content,header.top-block:not(.header-clone) .style-style1 .icons-pack .hover-content { background : " + classFirst + "}" +
        "</style>";
    $('style[data-name=second-setting]').remove();
    $('body').append(newStyle);
}

//Header scroll Mode
function pixflow_headerStates(){
    "use strict";

    var $window           = $(window),
        $header           = $('header'),
        $business         = $('.layout > .wrap > .business'),
        headerHeight      = parseInt($header.height()),
        layoutWidth       = parseInt(themeOptionValues.layoutWidth),
        headerTopWidth    = parseInt(themeOptionValues.headerTopWidth),
        logoTopHeightFlag = 0,
        headerTop         = 0,
        adminBar          = 0,
        logoHeight, scrollPos, containerHeight, logoMargin, contentHeight, color, colorSecond, $headerClone, display, $headerTopPos;

    if ( !$header.find('.top').length ) {
        return;
    }
    //make logo image link
    var $logo = $header.find('.content a.logo img');
    if($logo.length){
        $logo.click(function(){
            if(typeof pixflow_customizerObj == 'function'){
                pixflow_customizerObj().wp.customize.previewer.previewUrl($(this).attr('data-home-url'));
                return;
            }
            window.location = $(this).attr('data-home-url');
        });
    }
    headerWidth =(headerTopWidth / 100 * layoutWidth / 100) * 100+'%';

    // background 1
    if(type=='gradient' || typeSecond=='gradient') {

        if(type!='gradient'){
            color2 = color1 = solidColor;
            orientation = orientationSecond;
        }

        if(typeSecond!='gradient'){
            colorSecond2 = colorSecond1 = solidColorSecond;
            orientationSecond = orientation;
        }

        color1 = color1==''?color2:color1;
        color2 = color2==''?color1:color2;
        colorSecond1 = colorSecond1==''?colorSecond2:colorSecond1;
        colorSecond2 = colorSecond2==''?colorSecond1:colorSecond2;

        classFirst = pixflow_generateGradientBackground(color1, color2, orientation,colorSecond1,colorSecond2,orientationSecond);
        classSecond = classFirst;
    }
    else{
        classFirst=pixflow_generateSolidBackground(solidColor);
        classSecond=pixflow_generateSolidBackground(solidColorSecond);
    }

    if(orientation=='horizontal') {
        backgroundSize = '400% 400%';
    }else {
        backgroundSize = '100% 400%';
    }

    if(themeOptionValues.headerBgSolidColor=='transparent' || themeOptionValues.headerBgColorType == 'gradient') {
        color = '#000';
    }else {
        color = themeOptionValues.headerBgSolidColor;
    }

    if(themeOptionValues.headerBgSolidColorSecond=='transparent' || themeOptionValues.headerBgColorTypeSecond == 'gradient') {
        colorSecond = '#000';
    }else {
        colorSecond = themeOptionValues.headerBgSolidColorSecond;
    }

    // if business bar active
    if (themeOptionValues.businessBarEnable == 1 && $('header.top-modern').length<1) {
        headerTop=36;
    }else{
        headerTop=0;
    }

    //line Height For Classic
    $('.top-classic .icons-pack li > a').css('line-height', headerHeight+'px');
    $('.top-gather .icons-pack li ').css('line-height', headerHeight+'px');
    $('.top-gather .gather-btn.navigation').css('line-height', headerHeight+'px');

    if($('body.admin-bar').length) {
        adminBar = 32;
    }

    if($('header .top .logo img').css('position')=='absolute') {
        $('header .top .logo img').css('position', 'relative');
        logoHeight = $('header .top a.logo img').height();
        $('header .top .logo img').css('position', 'absolute');
    }else{
        logoHeight = $('header .top a.logo img').height();
    }

    // if in logotop
    if ($('header.top-logotop').length) {
        logoHeight = $('header.top-logotop a.logo').height();
        containerHeight = $('header.top-logotop .logo-top-container').height();
        logoMargin = $('header.top-logotop .logo-top-container').css('margin-top');
        contentHeight = parseInt(logoHeight) + parseInt(containerHeight) + parseInt(logoMargin) + 20;
        if ((headerHeight * 0.7) < contentHeight)
            logoTopHeightFlag = 1;
        else
            logoTopHeightFlag = 0;
    }

    // On scroll event for top header styles
    $window.scroll(function () {

        scrollPos = $(this).scrollTop();

        if ( $('.header-style2').length >= 1 ) {

            //if change setting in customizer
            if ($('.header-style2-changed').length) {

                // if in logotop
                if ($('header.top-logotop').length) {
                    logoHeight = $('header.top-logotop a.logo').height();
                    containerHeight = $('header.top-logotop .logo-top-container').height();
                    logoMargin = $('header.top-logotop .logo-top-container').css('margin-top');
                    contentHeight = parseInt(logoHeight) + parseInt(containerHeight) + parseInt(logoMargin) + 20;
                    if ((headerHeight * 0.7) < contentHeight)
                        logoTopHeightFlag = 1;
                    else
                        logoTopHeightFlag = 0;
                }

                headerHeight = parseInt($header.height());
                $('.header-style2-changed').remove();
            }
            pixflow_headerSetting();

            if ($('header.top-block').length) {
                classSecond = pixflow_generateSolidBackground(solidColorSecond);
                classFirst = pixflow_generateSolidBackground(solidColor);
            }

            if (scrollPos > headerTop + siteTop) {

                if (scrollFlag == 0) {
                    scrollFlag = 1;

                    //$business.fadeOut();

                    $header.addClass('header-fix');
                    if (typeof pixflow_itemOrderSetter == 'function' && $header.find('.top ').hasClass('ui-sortable')) {
                        pixflow_itemOrderSetter('disable');
                    }

                    if (logoStyleSecond == 'dark') {
                        $header.find('.logo img').attr('src', darkLogo);
                    } else {
                        $header.find('.logo img').attr('src', lightLogo);
                    }

                    $header.css({ width: headerWidth + 'px' });

                    if (logoTopHeightFlag == 0 && $('header.top-modern').length < 1 && $('header.top-block').length < 1 && $('header.top-gather .style-style2').length < 1)
                    {
                        $headerTopPos = $header.css('top');

                        if ($('header.top-gather').length) {
                            $header.find('.gather-btn span').stop().animate({
                                padding: '10px'
                            });
                        }
                        if( $('header.top-classic .content').hasClass('style-wireframe') ){
                            TweenMax.to('header.top-classic nav > ul > li > a .menu-title .title',0.2,{'line-height':(headerHeight * .7)});
                        }
                        TweenMax.to($header , 0.2, {height: headerHeight * .7, position: 'fixed', top: $('#wpadminbar').length ? '32px' : '0', color: '#000',onComplete:function(){
                            $header.find('.top').css({height: headerHeight * .7});
                            $('header.top-classic .style-wireframe nav > ul > li > .dropdown').css('top',(headerHeight * .7));

                            $header.find('.color-overlay').css('opacity', '0');
                            pixflow_showSecondHeaderFull('header');

                            classSecond.forEach(function (entry) {
                                $('header + .second-header-bg ').css('background', entry);
                            });

                            if (typeSecond == 'gradient' || type == 'gradient') {
                                $('header + .second-header-bg').css({
                                    'background-position': '100% 100%',
                                    'background-size': backgroundSize
                                });
                            }
                        }});
                        if(logoHeight == 0){
                            logoHeight = $('header .top a.logo img').height();
                        }

                        TweenMax.to($header.find('.logo img'), 0.1, {height: logoHeight * .8});

                        TweenMax.to($('header:not(.header-clone)').find('> .color-overlay'), 0.2, {borderBottomColor: window.top.$('#input_nav_color_second').val() });

                        //line Height For Classic
                        $('.top-classic .icons-pack li,.top-classic .icons-pack li > a').css('line-height', headerHeight * 0.7 + 'px');
                        $('.top-gather .icons-pack li ').css('line-height', headerHeight * 0.7 + 'px');
                        $('.top-gather .gather-btn.navigation').css('line-height', headerHeight * 0.7 + 'px');

                        //check the height of header and set the drop down top
                        if ($('header.top-logotop').length || $('header.top-classic').length) {
                            var navHeight = headerHeight * .7,
                                $link = $('nav > ul > li.has-dropdown > a'),
                                liHeight = 0;

                            if ($link.length > 1) {
                                liHeight = (jQuery)($link.get($link.length - 1)).outerHeight(true) + 20;
                            } else
                                liHeight = $link.outerHeight(true) + 20;


                            if ($('header.top-logotop').length) {
                                (jQuery)('.top-logotop nav > ul > li.has-dropdown > ul').css('top', liHeight + (navHeight - liHeight) / 2 - 37);
                            } else {
                                (jQuery)('.top-classic nav > ul > li.has-dropdown > ul').css('top', liHeight + (navHeight - liHeight) / 2 - 11);
                            }
                        }
                    }else{


                        TweenMax.to($header , 0.2, { position: 'fixed', color: '#000',onComplete:function(){

                            $header.find('.color-overlay').css('opacity', '0');
                            pixflow_showSecondHeaderFull('header');

                            classSecond.forEach(function (entry) {
                                $('header + .second-header-bg ').css('background', entry);
                            });

                            if (typeSecond == 'gradient' || type == 'gradient') {
                                $('header + .second-header-bg').css({
                                    'background-position': '100% 100%',
                                    'background-size': backgroundSize
                                });
                            }
                        }});


                    }

                    $('header .itemorder-handle').css({opacity: 0});
                    if ($('header.top-block').length)
                        $header.animate({'opacity': '0.8'});
                    $header.find('.color-overlay').removeClass('style-first');
                    if ($('header.top-block').length)
                        $header.animate({'opacity': '1'});
                    $header.find('.color-overlay').addClass('style-second');
                    if ($('header.top-block').length < 1)
                        $header.find('.color-overlay').css({'transition': 'background 300ms'});

                    pixflow_headerStateSecond(navColorSecond, navHoverColorSecond, colorSecond, $header, solidColorSecond);
                }

            } else {
                $header.find('.color-overlay').css('opacity', '1');

                TweenMax.to($header.find('> .color-overlay'), 0.2, {borderBottomColor: window.top.$('#input_nav_color').val() });

                if (scrollFlag == 1) {
                    if (scrollPos > adminBar) {
                        return;
                    }
                    scrollFlag = 0;
                    $header.removeClass('header-fix');

                    if (typeof pixflow_itemOrderSetter == 'function' && window.top.$('#customize-preview .collaps').hasClass('hold-collapse') == false && $header.find('.top ').hasClass('ui-sortable')) {
                        pixflow_itemOrderSetter('enable');
                    }

                    $header.css({
                        'width': headerWidth + 'px',
                        'top': $headerTopPos,
                        'position': 'absolute'
                    });

                    if (logoStyle == 'dark') {
                        $header.find('.logo img').attr('src', darkLogo);
                    } else {
                        $header.find('.logo img').attr('src', lightLogo);
                    }

                    if (logoTopHeightFlag == 0 && $('header.top-modern').length < 1 && $('header.top-block').length < 1 && $('header.top-gather .style-style2').length < 1) {
                        if( $('header.top-classic .content').hasClass('style-wireframe') ){
                            TweenMax.to('header.top-classic nav > ul > li > a .menu-title .title',0.2,{'line-height':headerHeight});
                        }

                        TweenMax.to([$header,$header.find('.top')], 0.2, {height: headerHeight, onComplete: function(){
                            $('header.top-classic .style-wireframe nav > ul > li > .dropdown').css('top',headerHeight);
                        }});
                        TweenMax.to($header.find('.logo img'), 0.1, {height: logoHeight});
                        $('.second-header-bg').remove();

                        //line Height For Classic
                        $('.top-classic .icons-pack li > a').css('line-height', headerHeight + 'px');
                        $('.top-gather .icons-pack li').css('line-height', headerHeight + 'px');
                        $('.top-gather .gather-btn.navigation').css('line-height', headerHeight + 'px');

                        //check the height of header and set the drop down top
                        if ($('header.top-logotop').length || $('header.top-classic').length) {

                            var navHeight = headerHeight,
                                $link = $('nav > ul > li.has-dropdown > a'),
                                liHeight = 0;

                            if ($link.length > 1) {
                                liHeight = $($link.get($link.length - 1)).outerHeight(true) + 20;
                            } else {
                                liHeight = $link.outerHeight(true) + 20;
                            }

                            if ($('header.top-logotop').length) {
                                (jQuery)('.top-logotop nav > ul > li.has-dropdown > ul').css('top', liHeight + (navHeight - liHeight) / 2 - 40);
                            } else {
                                (jQuery)('.top-classic nav > ul > li.has-dropdown > ul').css('top', liHeight + (navHeight - liHeight) / 2 - 11);
                            }

                        }
                    }else{
                        $('.second-header-bg').remove();
                    }

                    $('header .itemorder-handle').css({opacity: 1});
                    if ($('header.top-block').length)
                        $header.animate({'opacity': '0.8'});
                    $header.find('.color-overlay').removeClass('style-second');
                    if ($('header.top-block').length)
                        $header.animate({'opacity': '1'});
                    $header.find('.color-overlay').addClass('style-first');
                    if ($('header.top-block').length < 1)
                        $header.find('.color-overlay').css({'transition': 'background 300ms'});

                    pixflow_headerStateFirst(navColor, navHoverColor, color, $header, solidColor);

                    if (type == 'gradient' || typeSecond == 'gradient')
                        $('header + .second-header-bg').css({
                            'background-position': '0 0',
                            'background-size': backgroundSize
                        });
                }
            }
        } // end of style2

        else if ($('.header-style3').length >= 1) {     //if style 3 select for header top on scroll like scooter

            var headerTopPos = $header.css('top');

            if ( showUpAfter <= scrollPos && scrollPos > headerTop + siteTop+headerHeight )
            { // appear second menu

                if (scrollFlag == 0) {

                    $header.css({ opacity: 0 });
                    $('header.header-clone').remove();
                    if( $('header.header-clone').length < 1 ) {
                        $headerClone = $header.clone(true).appendTo($header.parent());
                        $headerClone.addClass('header-clone');

                        $headerClone.find('.color-overlay').addClass('style-second');

                        $headerClone.find('.itemorder-handle').css({ opacity: 0 });

                        if (logoStyleSecond == 'dark') {
                            $headerClone.find('.logo img').attr('src', darkLogo);
                        } else {
                            $headerClone.find('.logo img').attr('src', lightLogo);
                        }

                        $('header.header-clone').megamenu(1200);

                        scrollPos = parseInt($(this).scrollTop());

                        if ($('header.top-block').length) {
                            classSecond = pixflow_generateSolidBackground(solidColorSecond);
                            classFirst = pixflow_generateSolidBackground(solidColor);
                        }
                        if($('header[class*=gather]').length){
                            $headerClone.find('.icon-gathermenu').css('color',navColorSecond);
                            $headerClone.find('.icon-gathermenu').hover(function(){
                                $(this).css('color',navHoverColorSecond);
                            },function(){
                                $(this).css('color',navColorSecond);
                            })
                        }
                    }

                    if (typeof pixflow_itemOrderSetter == 'function' && $header.find('.top ').hasClass('ui-sortable')) {
                        pixflow_itemOrderSetter('disable');
                    }

                    pixflow_headerSetting();

                    pixflow_headerStateSecond(navColorSecond, navHoverColorSecond, colorSecond, $headerClone, solidColorSecond);
                    scrollFlag = 1;

                    $('header:not(.header-clone) nav > ul > li > .dropdown').css({ 'opacity':0, 'margin-top': '-15px', 'display': 'none' });

                    showUpStyle = window.top.$('#input_show_up_style').val();

                    if (showUpStyle == 'fade_in') {

                        $headerClone.css({ 'width': headerWidth, top: $('#wpadminbar').length ? '32px' : '0', 'position': 'fixed', 'z-index': '1000' });

                        if ( $('.business ').length )
                            $business.fadeOut();

                        pixflow_showSecondHeaderFull('header.header-clone');

                        classSecond.forEach( function (entry) {

                            $headerClone.siblings('.second-header-bg').css('background', entry );

                        });

                        if (typeSecond == 'gradient') {
                            $headerClone.siblings('.second-header-bg').css({
                                'background-position': '100% 100%',
                                'background-size': backgroundSize
                            });
                        }

                        $headerClone.siblings('.second-header-bg').css({zIndex:999,'top': 0});
                        $headerClone.stop().animate({opacity:1},400);
                        $headerClone.siblings('.second-header-bg').stop().animate({opacity:1},400);

                    } else { //if slide in

                        $headerClone.css({ 'width':headerWidth, 'position':'fixed', 'z-index':'1000',opacity:1, top:-headerHeight });
                        $headerClone.siblings('.second-header-bg').css({top:-headerHeight,opacity:1});
                        if ( $('.business ').length )
                            $business.fadeOut();

                        pixflow_showSecondHeaderFull('header.header-clone');

                        classSecond.forEach(function(entry) {
                            $headerClone.siblings('.second-header-bg').css('background', entry );
                        });

                        if (typeSecond == 'gradient') {

                            $headerClone.siblings('.second-header-bg').css({
                                'background-position': '100% 100%',
                                'background-size': backgroundSize
                            });
                        }

                        $headerClone.siblings('.second-header-bg').css({zIndex:999});

                        $headerClone.stop().animate({top: $('#wpadminbar').length ? '32px' : '0'},400);
                        $headerClone.siblings('.second-header-bg').stop().animate({top: $('#wpadminbar').length ? '32px' : '0'},400);
                    }
                    var doIt;
                    $(window).resize(function(){
                        if(doIt){
                            clearTimeout(doIt)
                        }
                        doIt = setTimeout(function(){
                            $headerClone.css({ 'width': headerWidth});
                        },100)
                    })
                    //pixflow_headerStateSecond(navColorSecond, navHoverColorSecond, colorSecond, $headerClone, solidColorSecond);

                }

            } else {

                $header.css({ opacity: 1 });

                if (scrollFlag == 1) {
                    if (scrollPos > (headerTop + siteTop+parseInt(headerHeight)+350)) {
                        return;
                    }
                    //scroll is 0
                    scrollFlag = 0;


                    if (showUpStyle == 'fade_in') {
                        $headerClone.stop().animate({opacity: 0, 'z-index': '-1000'},300);
                        $headerClone.siblings('.second-header-bg').animate({opacity: 0, 'z-index': '-1000'},300);
                    }
                    else { //if slide in
                        $headerClone.stop().animate({'top': -headerHeight, 'position': 'fixed',  'z-index': '-1000'},300);
                        $headerClone.siblings('.second-header-bg').stop().animate({'top': -headerHeight, 'position': 'fixed',  'z-index': '-1000'},300);
                    }

                    if (typeof pixflow_itemOrderSetter == 'function' && $header.find('.top ').hasClass('ui-sortable')) {
                        pixflow_itemOrderSetter('enable');
                    }

                    //Show business bar in header modern
                    if (themeOptionValues.businessBarEnable == 1) {
                        if ($('header.top-modern').length && $('header.top-modern .business').length) {
                            $('header.top-modern .business').removeClass('business-off');
                            $('header.top-modern ').css('height', '100px');
                        }
                    }
                }
            }

        }
    });

}

/*
 function for return to second mode after scroll in header state
 get second setting (navColor, HoverColor,color,headerStyle)
 if bg is transparent color is set
 */
function pixflow_headerStateSecond(navColorSecond, navHoverColorSecond, colorSecond, $headerStyle, solidColorSecond){
    "use strict";
    var blockBg =  pixflow_RgbaToRgb(solidColorSecond);

    // hide business bar
    if(themeOptionValues.siteTop >0 && $('header.top-modern').length<1) {
        $('.layout .business').css('display', 'none');
    }
    //hide business bar in header modern
    if (themeOptionValues.businessBarEnable == 1) {
        if ($('header.top-modern').length && $('header.top-modern .business').length) {
            $('header.top-modern .business').addClass('business-off');
            $('header.top-modern ').css('height', '70px');
        }
    }

    //after scroll Second appearance
    $headerStyle.find('nav > ul > li > a .menu-title,.icons-pack .shopcart-item .number').css('color', navColorSecond);
    $headerStyle.find('.icons-pack .shopcart-item .number').css('background-color', navHoverColorSecond);
    $headerStyle.find('.separator a').css({
        color: navColorSecond,
        backgroundColor: navColorSecond,
        opacity: 0.5
    });

    $headerStyle.find('.icons-pack span').css('color', navColorSecond);

    // Under Line in Hover
    if ($('header.top-classic').length || $('header.top-logotop').length) {
        if($('header .style-wireframe').length){
            $headerStyle.find('.navigation .menu-separator').css('backgroundColor', navColorSecond);
        }else{
            $headerStyle.find('.navigation .menu-separator').css('backgroundColor', navHoverColorSecond);
        }
    }

    if ($('header.top-logotop').length) {
        $headerStyle.find('.navigation > ul > li').css('color', navColorSecond);
        $headerStyle.find('.navigation > ul > li').hover(function () {
            $(this).find('> a > .menu-title').css({color: navHoverColorSecond});
        },function(){
            $(this).find('> a > .menu-title').css({color: navColorSecond});
        });
        pixflow_underlineAnimation();
    }

    if ($('header.top-classic').length) {
        $('header.top-classic .style-border nav > ul > li, header.top-classic .style-border nav > ul > li:last-child').css({
            'border-color':'rgba('+ pixflow_rgbVal(navColorSecond) +',0.5)'});

        $headerStyle.find('.navigation > ul > li').hover(function () {
            $(this).find('> a > .menu-title').css({color: navHoverColorSecond});
        }, function () {
            $(this).find('> a >.menu-title').css({color: navColorSecond});
        });
        pixflow_underlineAnimation();
    }

    if ($('header.top-block').length) {
        $headerStyle.find('.navigation > ul > li,' +
            '.icons-pack li').css({
            borderLeftColor: 'rgba(' + pixflow_rgbVal(navColorSecond) + ',0.3)',
            borderRightColor: 'rgba(' + pixflow_rgbVal(navColorSecond) + ',0.3)'
        });

        $headerStyle.find('.menu-separator-block').css({backgroundColor: navHoverColorSecond});

        $headerStyle.find('.style-style1 .navigation > ul > li > a .hover-effect,' +
            '.style-style1 ul.icons-pack li .elem-container .hover-content').css({backgroundColor: navHoverColorSecond});

        $headerStyle.find('.style-style1 .icons-pack .icon .icon-hover').css({color: themeOptionValues.headerBgSolidColorSecond});

        $headerStyle.find('.style-style1 .navigation > ul > li > a .menu-title,' +
            '.style-style1 .icons-pack .title-content').css({backgroundColor: blockBg});

        $headerStyle.find('.style-style2 .navigation > ul > li > a .hover-effect').css({color: navColorSecond});

        $headerStyle.find('.style-style1 nav > ul > li').hover(function () {
            $(this).find('> a .menu-title span,> a .menu-title').css({backgroundColor: navHoverColorSecond,color: navHoverColorSecond});
            $(this).find('> a > .hover-effect').css({backgroundColor: navHoverColorSecond, color:navColorSecond });
        },function(){
            $(this).find('> a .menu-title,> a .menu-title span').css({backgroundColor: blockBg,color: navColorSecond});
        });

        $headerStyle.find('.style-style1 .icons-pack li').hover(function () {
            $(this).find('a .hover-content, a .hover-content span').css({backgroundColor: navHoverColorSecond,color: navColorSecond});
        },function(){
            $(this).find('a .title-content , a .title-content span').css({backgroundColor: blockBg,color: navColorSecond});
        });

        /* Block Square Animation */

        $headerStyle.find('.style-style2 nav > ul > li,.style-style2 .icons-pack li').each(function(){
            var $this = $(this);

            $this.hover(function(){
                $this.css({backgroundColor : 'rgba('+ pixflow_rgbVal(navHoverColorSecond) +',.3)' });
                TweenMax.to( $this.find('> a .menu-separator-block'),1,{bottom:"3px",ease:Elastic.easeOut});
                TweenMax.to( $this.find('> a .menu-separator-block'),0.9,{height:"3px",ease:Quart.easeOut});
                TweenMax.to( $this.find('> a .menu-separator-block'),0.1,{opacity:"1"});

                TweenMax.to( $this.find('.hover-effect'), 0.5, { opacity: "1", marginTop: "80px" }); // for menu
                TweenMax.to( $this.find('.hover-content'), 0.5, {opacity: "1", marginTop: "80px" }); // for icons pack
            },function(){
                $this.css({backgroundColor : 'transparent' });
                TweenMax.to($this.find('.hover-effect') , 0.2, { opacity: "0", marginTop: "0" }); // for menu
                TweenMax.to( $this.find('.hover-content') , 0.2, { opacity: "0", marginTop: "0" }); // for icons pack

                TweenMax.to($this.find('> a .menu-separator-block'),0.8,{bottom:"-10px"});
                TweenMax.to($this.find('> a .menu-separator-block'),0.4,{height:"6px"});
                TweenMax.to($this.find('> a .menu-separator-block'),1,{opacity:"0"});
            });

        });

    }

    if ($('header.top-gather .style-style2').length) {

        $headerStyle.find('.style-style2 .icons-pack li .hover').css({color: navHoverColorSecond});

        $headerStyle.find('.style-style2 .icons-pack li').css({
            borderLeftColor: 'rgba(' + pixflow_rgbVal(navColorSecond) + ',0.5)',
            borderRightColor: 'rgba(' + pixflow_rgbVal(navColorSecond) + ',0.5)'
        });

        $headerStyle.find('.style-style2 .border-right, .style-style2 .border-left').css({
            borderColor: 'rgba(' + pixflow_rgbVal(navColorSecond) + ',0.5)'});

        $headerStyle.find('.style-style2 .icons-pack .icon').unbind('hover');
        $headerStyle.find('.style-style2 .icons-pack .icon').each(function () {

            var defaultIcon = $(this).find('span.default'),
                hoverIcon = $(this).find('span.hover');
            $(this).hover(function () {
                TweenMax.to(defaultIcon, 0.55, {top: "54px", opacity: 0, ease: Cubic.easeInOut});
                TweenMax.to(hoverIcon, 0.55, {top: "2", opacity: 1, ease: Cubic.easeInOut});
            }, function () {
                TweenMax.to(defaultIcon, 0.55, {top: "2", opacity: 1, ease: Cubic.easeInOut});
                TweenMax.to(hoverIcon, 0.55, {top: "-54px", opacity: 0, ease: Cubic.easeInOut});
            })
        });

    }

    if ($('header.top-modern').length) {
        $headerStyle.find('.navigation > ul > li,' +
            '.icons-pack li,' +
            '.first-part').css({
            borderRightColor: 'rgba(' + pixflow_rgbVal(navColorSecond) + ',0.3)'
        });

        $headerStyle.find('.business').css({borderBottomColor: 'rgba(' + pixflow_rgbVal(navColorSecond) + ',0.3)'});
        $headerStyle.find('.navigation > ul > li > a span').css({color: navColorSecond});

        $headerStyle.find('.btn-1b').removeClass('btn-1b-first');
        $headerStyle.find('.btn-1b').addClass('btn-1b-second');

        $headerStyle.find('.btn-1b').hover(function () {
            $(this).find('> a span').css('color','rgb('+ pixflow_RgbaToRgb(colorSecond)+')');
            $(this).find('> a span span').css('color','rgb('+ pixflow_RgbaToRgb(colorSecond)+')');
        }, function () {
            $(this).find('> a .title').css('color', navColorSecond);
            $(this).find('> a .icon').css('color', navColorSecond);
        });
    }

    if ($('header.top-block').length < 1 && $('header.top-gather .style-style2').length < 1 && $('header.top-modern').length < 1) {
        $headerStyle.find('.navigation > ul > li ').hover(function () {
            if($('header .style-wireframe').length){
                $(this).find('.menu-separator').css({backgroundColor: navHoverColorSecond});
            }else{
                $(this).find('> span').css({color: navHoverColorSecond});
            }
        }, function () {
            if($('header .style-wireframe').length){
                $(this).find('.menu-separator').css({backgroundColor: navColorSecond});
            }else{
                $(this).find('> span').css({color: navColorSecond});
            }

        });

        $headerStyle.find('.icons-pack .icon').hover(
            function () {
                $(this).css({color: navHoverColorSecond});
            }, // over
            function () {
                $(this).css({color: navColorSecond});
            }  // out
        );
    }

}

/*
 function for return to first mode after scroll in header state
 get primary setting (navColor, HoverColor,color,headerStyle)
 if bg is transparent color is set
 */
function pixflow_headerStateFirst(navColor, navHoverColor, color, $headerStyle, solidColor){
    "use strict";
    var blockBg=pixflow_RgbaToRgb(solidColor);

    // show business bar
    if(themeOptionValues.siteTop >0 && $('header.top-modern').length<1){
        $('.layout .business').css('display', 'block');
    }

    //Show business bar in header modern
    if (themeOptionValues.businessBarEnable == 1) {
        if ($('header.top-modern').length && $('header.top-modern .business').length) {
            $('header.top-modern .business').removeClass('business-off');
            $('header.top-modern ').css('height', '100px');
        }
    }

    //after scroll First appearance
    $headerStyle.find('nav > ul > li > a .menu-title').css('color',navColor);

    $headerStyle.find('.separator a').css({
        color: navColor,
        backgroundColor: navColor,
        opacity: 0.5
    });

    $headerStyle.find('.icons-pack span').css('color', navColor);

    // Under Line in Hover
    if ($('header.top-classic').length || $('header.top-logotop').length) {
        if($('header .style-wireframe').length < 0){
            $headerStyle.find('.navigation .menu-separator').css('backgroundColor', navHoverColor);
        }
    }

    if ($('header.top-logotop').length) {
        $headerStyle.find('.navigation > ul > li').css('color', navColor);
        $headerStyle.find('.navigation > ul > li').hover(function () {
            $(this).find('.menu-title').css({color: navHoverColor});
        },function(){
            $(this).find('.menu-title').css({color: navColor});
        });
        pixflow_underlineAnimation();
    }
    if ($('header.top-classic').length) {
        $headerStyle.find('.navigation > ul > li').hover(function () {
            if($('header .style-wireframe').length){
                $(this).find('.menu-separator').css({backgroundColor: navHoverColor});
            }else{
                $(this).find('.menu-title').css({color: navHoverColor});
            }
        }, function () {
            if($('header .style-wireframe').length){
                $(this).find('.menu-separator').css({backgroundColor: navColor});
            }else{
                $(this).find('.menu-title').css({color: navColor});
            }
        });
        pixflow_underlineAnimation();
    }

    if ($('header.top-block').length) {
        $headerStyle.find('.navigation > ul > li,' +
            '.icons-pack li').css({
            borderLeftColor: 'rgba(' + pixflow_rgbVal(navColor) + ',0.3)',
            borderRightColor: 'rgba(' + pixflow_rgbVal(navColor) + ',0.3)'
        });

        $headerStyle.find('.menu-separator-block').css({backgroundColor: navHoverColor});

        $headerStyle.find('.style-style1 .navigation > ul > li > a .hover-effect,' +
            '.style-style1 ul.icons-pack li .elem-container .hover-content').css({backgroundColor: navHoverColor});

        $headerStyle.find('.style-style1 .icons-pack .icon .icon-hover').css({color: blockBg});

        $headerStyle.find('.style-style1 .navigation > ul > li > a .menu-title,' +
            '.style-style1 .icons-pack .title-content').css({backgroundColor: blockBg});

        $headerStyle.find('.style-style2 .navigation > ul > li > a .hover-effect').css({color: navColor});

        $headerStyle.find('.style-style1 nav > ul > li').hover(function () {
            $(this).find(' > a .menu-title').css({backgroundColor: navHoverColor});
            $(this).find(' > a .menu-title .icon').css({color: navHoverColor});
        },function(){
            $(this).find('> a .menu-title').css({backgroundColor: blockBg});
            $(this).find('> a .menu-title .icon').css({color: navColor});
        });

        $headerStyle.find('.style-style1 .icons-pack li').hover(function () {
            $(this).find('a .title-content').css({backgroundColor: navHoverColor});
        },function(){
            $(this).find('a .title-content').css({backgroundColor: blockBg});
        });

    }

    if($('header.top-gather .style-style2').length) {

        $headerStyle.find('.style-style2 .icons-pack li .hover').css({color: navHoverColor});
        $headerStyle.find('.style-style2 .icons-pack li').css({ borderLeftColor: 'rgba(' + pixflow_rgbVal(navColor) + ',0.5)',
            borderRightColor: 'rgba(' + pixflow_rgbVal(navColor) + ',0.5)'});
        $headerStyle.find('.style-style2 .border-right, .style-style2 .border-left').css({
            borderColor: 'rgba(' + pixflow_rgbVal(navColor) + ',0.5)'});

    }

    if($('header.top-modern').length) {
        $headerStyle.find('.navigation > ul > li,' +
            '.icons-pack li,'+
            '.first-part').css({
            borderRightColor: 'rgba(' + pixflow_rgbVal(navColor) + ',0.3)'
        });


        $headerStyle.find('.navigation > ul > li > a span').css({color:navColor});
        $headerStyle.find('.business').css({borderBottomColor:'rgba(' + pixflow_rgbVal(navColor) + ',0.3)'});

        $headerStyle.find('.btn-1b').removeClass('btn-1b-second');
        $headerStyle.find('.btn-1b').addClass('btn-1b-first');

        $headerStyle.find('.btn-1b').hover(function () {
            $(this).find('> a span').css('color',color);
            $(this).find('> a span span').css('color',color);
        }, function () {
            $(this).find('> a .title').css('color', navColor);
            $(this).find('> a .icon').css('color', navColor);
        });
    }

    if( $('header.top-block').length < 1 && $('header.top-gather .style-style2').length < 1 && $('header.top-modern').length < 1 ) {
        $headerStyle.find('.navigation > ul > li').hover(function () {
            if($('header .style-wireframe').length){
                $(this).find('.menu-separator').css({backgroundColor: navHoverColor});
            }else{
                $(this).find('> span').css({color: navHoverColor});
            }
        }, function () {
            if($('header .style-wireframe').length){
                $(this).find('.menu-separator').css({backgroundColor: navColor});
            }else{
                $(this).find('> span').css({color: navColor});
            }
        });

        $headerStyle.find('.icons-pack .icon').hover(
            function () {
                $(this).css({color: navHoverColor});
            }, // over
            function () {
                $(this).css({color: navColor});
            }  // out
        );
    }

}

function pixflow_modernTop() {
    "use strict";
    // header top modern
    if ($('header.top-modern').length < 1)
        return;
    else {
        var i = 0;
        i = $("header.top-modern:not(.header-clone) .icons-pack li:visible").length;

        var image = new Image();
        image.src = $('header .logo img').attr('src');

        image.onload = function () {
            var    contentWidthPixel   = parseInt($('header .content').width());
            var    iconWidth    = Math.ceil((i * 71 * 100)/contentWidthPixel);
            var    firstPart    = Math.ceil((parseInt($('header:not(.header-clone) .first-part').outerWidth(true)))* 100 / contentWidthPixel);
            var    secondPart   = Math.floor(100 - firstPart);
            var    navWidth     = 100 - iconWidth;
            var    $navItems    = $('header.top-modern:not(.header-clone) nav > ul > li');


            $('header .first-part').css('width', firstPart +'%');
            $('header .second-part').css('width', secondPart + '%');
            $('header .navigation').css('width', navWidth + '%');
            $('header .icons-pack').css('width', iconWidth + '%');

            if ($navItems.length) {
                $navItems.css('width', 100 / $navItems.length + '%');
            }
        }

        image.onerror = function(){
            var    contentWidthPixel   = parseInt($('header .content').width());
            var    iconWidth    = (i * 71 * 100)/contentWidthPixel;
            var    firstPart    = ($('header .first-part').outerWidth(true))* 100 / contentWidthPixel;
            var    secondPart   = 100 - firstPart - .01;
            var    navWidth     = 100 - iconWidth;
            var    $navItems    = $('header.top-modern nav > ul > li');

            $('header .first-part').css('width', firstPart +'%');
            $('header .second-part').css('width', secondPart + '%');
            $('header .navigation').css('width', navWidth + '%');
            $('header .icons-pack').css('width', iconWidth + '%');

            if ($navItems.length) {
                $navItems.css('width', 100 / $navItems.length + '%');
            }
        }
        $('header.top-modern').css({'opacity':1});
    }

    pixflow_modernHoverColor();      // Hover for Modern Top
}

function pixflow_gatherWidthMenu(){
    "use strict";

    var i= 0,
        liWidth,
        totalWidth,
        menuWidth;

    // gather
    if (! $('.gather-overlay'))
        return;
    else {

        liWidth= $(".gather-overlay .navigation > ul > li").width();
        liWidth=parseInt(liWidth)+50;

        $(".gather-overlay > ul > li").each(function(){
            i++;
            $('.gather-overlay .navigation > ul > li > a .menu-title').css('width', liWidth+'px');
        });

        totalWidth = i * liWidth;
        menuWidth = $('.gather-overlay .menu').width();
        if(totalWidth>menuWidth){
            $('.gather-overlay .navigation > ul > li').css('text-align', 'left');
        }
    }
}

/* return rgb Value */
function pixflow_rgbVal(str){
    "use strict";

    var temp =  str.substr(4,(str.length)-5);
    return temp;
}
function pixflow_headerSideClassicFooterHover(){
    'use strict';
    // Footer social icons hover animation
    var $icon = $('header.side-classic .footer-socials .icon:gt(0)');
    // Footer social icons
    $icon.each(function () {
        var defaultIcon = $(this).find('span.default'),
            hoverIcon   = $(this).find('span.hover');

        $(this).hover(function () {
            TweenMax.to(defaultIcon, 0.55, {top: "54px", opacity: 0, ease: Cubic.easeInOut});
            TweenMax.to(hoverIcon, 0.55, {top: "0", opacity: 1, ease: Cubic.easeInOut});
        }, function () {
            TweenMax.to(defaultIcon, 0.55, {top: "0", opacity: 1, ease: Cubic.easeInOut});
            TweenMax.to(hoverIcon, 0.55, {top: "-54px", opacity: 0, ease: Cubic.easeInOut});
        })
    });
}
function pixflow_headerSideClassic(){
    "use strict";

    // Header side classic icons pack
    var $headerIcons = $('header.side-classic .icons-pack'),
        $iconsParent = $headerIcons.find('.icon'),
        $liHasChildren = $('header.side-classic nav > ul > li.has-dropdown > a .title '),
        $hr = $('<hr/>'),
        $icon,
        TM = TweenMax;

    if( !$('header.side-classic').length)
        return;

    if( $('header.side-classic.standard-mode').length){
        $liHasChildren.append('<span class="icon-angle-down"></span>')
        return;
    }

    $hr.insertAfter('header.side-classic .icons-holder li a:gt(0)');
    $('header.side-classic .icons-holder li:visible:first hr').css('display','none');
    $liHasChildren.append('<span class="icon-angle-right"></span>')

    //header items animation
    TM.staggerFrom('header.side-classic .navigation .menu-separator', 0.9, { scaleX:"0",scaleY:"0", ease:Back.easeInOut, delay:0.7}, 0.1); //Menu Separator
    $('header.side-classic .navigation > ul > li').each(function(){
        $(this).hover(function(){
            TM.to($(this).find('> a .menu-separator'),0.8,{width:"105px",ease:Elastic.easeOut})
        },function(){
            TM.to($(this).find('> a .menu-separator'),0.4,{width:"0"})
        })
    });


    // Header icons pack
    $iconsParent.each(function () {
        var defaultIcon = $(this).find('span.default'),
            hoverIcon   = $(this).find('span.hover');

        $(this).hover(function () {
            TweenMax.to(defaultIcon, 0.55, {top: "54px", opacity: 0, ease: Cubic.easeInOut});
            TweenMax.to(hoverIcon, 0.55, {top: "0", opacity: 1, ease: Cubic.easeInOut});
        }, function () {
            TweenMax.to(defaultIcon, 0.55, {top: "0", opacity: 1, ease: Cubic.easeInOut});
            TweenMax.to(hoverIcon, 0.55, {top: "-54px", opacity: 0, ease: Cubic.easeInOut});
        })
    });

    // Footer Icons Hover Animation
    pixflow_headerSideClassicFooterHover();
}

function pixflow_headerSideEffect(){
    "use strict";

    if ( !$('header.side-classic').length || $('header.side-classic.standard-mode').length )
        return;

    // Footer social icons hover animation
    var $header        = $('header.side-classic'),

    //Header
        $headerIcons   = $header.find('.icons-pack'),
        $search        = $headerIcons.find('.icon.search'),
        $searchContent = $search.find('.search-form'),
        $iconsPack     = $headerIcons.find('.icon:gt(0)'),
        $headerContentWidth, $headerIconsWidth,

    //Footer
        $footerIcons     = $header.find('.footer-socials'),
        footerIconsCount = $footerIcons.find('>li.icon').length,
        $info          = $footerIcons.find('.icon.info'),
        $infoIcons     = $footerIcons.find('.icon.info > a > span'),
        $footerContent = $info.find('.footer-content'),
        $socialIcons   = $footerIcons.find('.icon:gt(0)'),
        TM             = TweenMax,
        $footerIconsWidth;


    // Calculate header li width
    // Search Button
    var $searchParent = $('header.side-classic .icons-pack'),
        $searchChilds = $searchParent.find('li'),
        $searchIcon   = $searchParent.find('li.search'),
        $searchBtn    = $searchParent.find('.search-form .searchBtn'),
        counter       = 0,
        $searchBtnWidth;




    // If we have only search box

    $searchChilds.each(function () {
        counter++;
    });

    if (counter == 1){
        $searchIcon.addClass('searchAlone');
    }

    $searchBtnWidth = $searchIcon.width() / 2;
    $searchBtn.css({ left: -$searchBtnWidth + 'px'});

    // Calculate header icons pack

    $headerContentWidth = $searchContent.width();
    $headerIconsWidth   = $search.width();

    var $iconsPackEffect   = new TimelineMax({ paused: true }),
        $headerIconsEffect = new TimelineMax({ paused: true });

    $iconsPackEffect.add( TM.staggerTo( $iconsPack, .3, {top: "54px", opacity: 0, ease: Cubic.easeInOut}, .1 ) );
    $headerIconsEffect.add( TM.to( $searchContent, .5, {left: $headerIconsWidth + 'px'} ) );

    $search.mouseenter(function (){
        $iconsPackEffect.restart();
        $headerIconsEffect.restart();
        $searchContent.stop().animate({ opacity: 1 }, 'slow');
    });

    $search.mouseleave(function (){
        $searchContent.stop().animate({ opacity: 0 }, '400');
        $iconsPackEffect.reverse();
        $headerIconsEffect.reverse();
    });


    // Calculate footer icons (info & socials)
    $footerIconsWidth = $info.width();

    var $socialIconsEffect = new TimelineMax({ paused: true }),
        $footerIconsEffect = new TimelineMax({ paused: true });

    if(!$socialIcons.length){
        $footerContent.css('top','-54px');
        $footerIcons.css('overflow','hidden');
        $footerIconsEffect.add( TM.staggerTo( $infoIcons, .3, {top: "54px", opacity: 0, ease: Cubic.easeInOut}, .1 ) );
        $footerIconsEffect.add( TM.to( $footerContent, .5, {top: 0+ 'px'} ) );
    }else{
        $socialIconsEffect.add( TM.staggerTo( $socialIcons, .3, {top: "54px", opacity: 0, ease: Cubic.easeInOut}, .1 ) );
        $footerIconsEffect.add( TM.to( $footerContent, .5, {left: '110%'} ) );
    }
    $info.hover(function (){
        $infoIcons.addClass('iconTotation');
        $socialIconsEffect.restart();
        $footerIconsEffect.restart();
        $footerContent.stop().animate({ opacity: 1 }, 1000);
    }, function (){
        $footerContent.stop().animate({ opacity: 0 }, 300);
        $infoIcons.removeClass('iconTotation');
        $socialIconsEffect.reverse();
        $footerIconsEffect.reverse();
    });

}

function pixflow_gatherBlockHover(){
    "use strict";

    var $icon = $('header.top-gather .style-style2 .icons-pack .icon');
    $icon.each(function () {

        var defaultIcon = $(this).find('span.default'),
            hoverIcon = $(this).find('span.hover');

        $(this).hover(function () {
            TweenMax.to(defaultIcon, 0.55, {top: "54px", opacity: 0, ease: Cubic.easeInOut});
            TweenMax.to(hoverIcon, 0.55, {top: "0", opacity: 1, ease: Cubic.easeInOut});
        }, function () {
            TweenMax.to(defaultIcon, 0.55, {top: "0", opacity: 1, ease: Cubic.easeInOut});
            TweenMax.to(hoverIcon, 0.55, {top: "-54px", opacity: 0, ease: Cubic.easeInOut});
        })
    });
}

function pixflow_modernHoverColor(){
    "use strict";

    var $color, $nav_color, $nav_color;

    if(themeOptionValues.headerBgSolidColor=='transparent' || themeOptionValues.headerBgColorType == 'gradient') {
        $color = '#fff';
    }
    else{
        $color=themeOptionValues.headerBgSolidColor;
    }

    $nav_color=themeOptionValues.navColor;

    $('header.top-modern .btn-1b').hover(function () {
        if(themeOptionValues.headerBgSolidColor=='transparent' || themeOptionValues.headerBgColorType == 'gradient') {
            $color = 'rgba(255,255,255,1)';
        }
        else{
            $color=themeOptionValues.headerBgSolidColor;
        }

        $(this).find('> a span').css('color','rgb('+ pixflow_RgbaToRgb($color)+')');
        $(this).find('> a span span').css('color','rgb('+ pixflow_RgbaToRgb($color)+')');

    }, function () {

        $(this).find('> a .title').css('color', $nav_color);
        $(this).find('> a .icon').css('color', $nav_color);

    });
}

function pixflow_classicDropdown (){
    "use strict";

    var $level1 = $('header nav > ul > .has-dropdown:not(.megamenu),.gather-overlay nav > ul > .has-dropdown:not(.megamenu)'),
        $level2;

    if (! $level1.length )
        return;

    if($level1.parents('.side').length) {

        if($level1.parents('.side-classic').length)
            $level2 = $('header nav > ul > .has-dropdown:not(.megamenu), header nav > ul > .has-dropdown:not(.megamenu) ul .has-dropdown');
        else
            $level2 = $('header nav > ul > .has-dropdown:not(.megamenu) ul .has-dropdown:not(.megamenu)');

    }else
        $level2 = $level1.find('> ul > li.has-dropdown');

    $level2.hoverIntent({
        interval:200,
        over:pixflow_openUl,
        out:pixflow_closeUl
    });

    function pixflow_openUl(){
        'use strict';
        var $side = $(this).parents('.side');
        if ($side.length){
            $(this).find('> .dropdown').stop(true,true).slideDown(400);
        } else
            $(this).find('.dropdown').stop(true,true).fadeIn('fast');
        TweenMax.to($(this).find('.dropdown'),0.5);
    }

    function pixflow_closeUl(){
        'use strict';
        var $side = $(this).parents('.side');

        if ($side.length){
            $(this).find('> .dropdown').stop(true,true).delay(800).slideUp(400);
        } else
            $(this).find('.dropdown').stop(true,true).delay(400).fadeOut('fast');
    }
}

function pixflow_sidebarBoxStyle(){
    "use strict";

    if( (! $('body .sidebar').length ) ||
        ($('body.blog').length && themeOptionValues.sidebar_style_blog != "box") &&
        ($('body.single').length && themeOptionValues.sidebar_style_single != "box") &&
        ($('body.woocommerce').length && themeOptionValues.sidebar_style_shop != "box") &&
        (!$('body.blog').length && !$('body.single').length && !$('body.woocommerce').length && themeOptionValues.sidebar_style != 'box')
    ){
        return;
    }

    if($('body.blog').length){
        var x = themeOptionValues.blog_sidebar_bg_image_position
    }else if($('body.single').length) {
        var x = themeOptionValues.single_sidebar_bg_image_position
    }else if($('body.woocommerce').length) {
        var x = themeOptionValues.shop_sidebar_bg_image_position
    }else{
        var x = themeOptionValues.page_sidebar_bg_image_position
    }
    var n = x.indexOf("-"),
        y = 0,
        divs;

    x = x.substring(0,n);

    divs = '<div class="color-overlay color-type"></div><div class="color-overlay texture-type"></div><div class="color-overlay image-type"></div><div class="texture-overlay"></div><div class="bg-image"></div>';

    $('main > .sidebar .widget').each(function(){
        $(this).append(divs);
        $(this).find('.bg-image').css({'background-position': x + ' ' + '-' + y+'px'});
        y += $(this).outerHeight(true);
    })
}

function pixflow_goToTopButton() {
    "use strict";

    var displayAfter = themeOptionValues.goToTopShow,
        toTopButton = $('.go-to-top');

    $(window).scroll(function(){
        if($(window).scrollTop() > displayAfter){
            toTopButton.stop(true).fadeIn(300);
            if($('#footer-bottom').children('.linear').length){
                $('footer .linear').css({'padding-right':'50px'});
            }
        } else{
            toTopButton.stop(true).fadeOut(300);
        }
    });

    $('.go-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 600);
        return false;
    });

    if(toTopButton.is(":visible") && $('#footer-bottom').children('.linear').length){
        $('footer .linear').css({'padding-right':'50px'});
    }
}

/* Shortcode Button Slide */
function pixflow_btnSlide(btnId) {
    "use strict";

    // Calculate button width, use for animation effect
    if (btnId == "staticValue")
    {
        var $shortcodeBtn     = $('.shortcode-btn'),
            $btnSlide         = $shortcodeBtn.find('.slide'),
            $btnSlideStandard = $shortcodeBtn.find('.slide.button-standard'),
            $btnSlideSmall    = $shortcodeBtn.find('.slide.button-small'),
            $btnSlideTxt      = $shortcodeBtn.find('.slide span'),
            $btnSlideStandardWidth, $btnSlideSmallWidth, btnIdTemp, $btnAttr;

        $btnSlide.each(function () {

            btnIdTemp = $(this),
            $btnSlideTxt = btnIdTemp.find('span');

            $btnSlideTxt.css({ position: 'relative', display: 'table' });
            btnIdTemp.css({'width': 'auto'})

            if ( btnIdTemp.hasClass("button-standard") ) {
                $btnSlideStandardWidth = btnIdTemp.outerWidth();
                $btnSlideStandard.css({'width':'52px'});
            }
            else if ( btnIdTemp.hasClass("button-small") ) {
                $btnSlideSmallWidth = btnIdTemp.outerWidth();
                $btnSlideSmall.css('width', '40px');
            }

            $btnSlideTxt.css({ position: 'absolute', display: 'table' });
            btnIdTemp.addClass('slide-transition');

            $btnSlideStandard.hover(function () {
                $(this).css({ width: $btnSlideStandardWidth });
                $(this).find('span').css({ opacity: 1, left: '52px'});
            }, function () {
                $(this).css('width', '52px');
                $(this).find('span').css({ opacity: 0, left: '25px'});
            });

            $btnSlideSmall.hover(function () {
                $(this).css('width', $btnSlideSmallWidth);
                $(this).find('span').css({ opacity: 1, left: '40px'});
            }, function () {
                $(this).css('width', '40px');
                $(this).find('span').css({ opacity: 0, left: '17px'});
            });

        });
    } else {

        var $shortcodeBtn     = $('#'+btnId),
            $btnSlide         = $shortcodeBtn.find('.slide'),
            $btnSlideStandard = $shortcodeBtn.find('.slide.button-standard'),
            $btnSlideSmall    = $shortcodeBtn.find('.slide.button-small'),
            $btnSlideTxt      = $shortcodeBtn.find('.slide span'),
            $btnSlideStandardWidth, $btnSlideSmallWidth, btnIdTemp, $btnAttr;

        $btnSlideTxt.css({ position: 'relative', display: 'inline-block' });
        $btnSlide.css('width', 'inherit');

        btnIdTemp = $('.' + btnId);

        if ( btnIdTemp.hasClass("button-standard") ) {
            $btnSlideStandardWidth = btnIdTemp.outerWidth(true);
            $btnSlideStandard.css('width', '52px');
        }
        else if ( btnIdTemp.hasClass("button-small") ) {
            $btnSlideSmallWidth = btnIdTemp.outerWidth(true);
            $btnSlideSmall.css('width', '40px');
        }

        $btnSlideTxt.css({ position: 'absolute', display: 'table' });
        btnIdTemp.addClass('slide-transition');

        $btnSlideStandard.hover(function () {
            $(btnIdTemp).css({ width: $btnSlideStandardWidth });
            $(btnIdTemp).find('span').css({ opacity: 1, left: '52px'});
        }, function () {
            $(btnIdTemp).css('width', '52px');
            $(btnIdTemp).find('span').css({ opacity: 0, left: '25px'});
        });

        $btnSlideSmall.hover(function () {
            $(this).css('width', $btnSlideSmallWidth);
            $(this).find('span').css({ opacity: 1, left: '40px'});
        }, function () {
            $(this).css('width', '40px');
            $(this).find('span').css({ opacity: 0, left: '17px'});
        });

    }

    var width = $btnSlide.css('width'),
        $btnAnimation = $shortcodeBtn.find('.animation'),
        $btnText      = $btnAnimation.find('span'),
        $btnIcon      = $btnAnimation.find('.button-icon');


    if($(window).width() < 1025){
        $btnSlide.click(function(){
            if($(this).css('width') == width){
                $(this).trigger('mouseenter');
                return false;
            }
        })
    }


}

function pixflow_rowTransitionalColor($row, firstColor, secondColor){
    "use strict";

    var $ = jQuery,
        scrollPos = 0,
        currentRow = $row,
        beginningColor = firstColor,
        endingColor = secondColor,
        percentScrolled,
        newRed,
        newGreen,
        newBlue,
        newColor;

    currentRow.css({'background-color':beginningColor});

    $(document).scroll(function () {
        var animationBeginPos = currentRow.offset().top,
            endPart = currentRow.outerHeight()<800 ? currentRow.outerHeight()/ 4 : $(window).height(),
            animationEndPos = animationBeginPos + currentRow.outerHeight() - endPart;
        scrollPos = $(this).scrollTop();
        if (scrollPos >= animationBeginPos && scrollPos <= animationEndPos) {
            percentScrolled = (scrollPos - animationBeginPos) / (currentRow.outerHeight()- endPart);
            newRed = Math.abs(beginningColor.red() + ( ( endingColor.red() - beginningColor.red() ) * percentScrolled ));
            newGreen = Math.abs(beginningColor.green() + ( ( endingColor.green() - beginningColor.green() ) * percentScrolled ));
            newBlue = Math.abs(beginningColor.blue() + ( ( endingColor.blue() - beginningColor.blue() ) * percentScrolled ));
            newColor = new $.Color(newRed, newGreen, newBlue);
            currentRow.animate({backgroundColor: newColor}, 0);
        } else if (scrollPos > animationEndPos) {
            currentRow.animate({backgroundColor: endingColor}, 0);
        } else if (scrollPos < animationBeginPos) {
            currentRow.animate({backgroundColor: beginningColor}, 0);
        }
    });
}

// set day name, day color for calendar
function pixflow_calendarWidget() {
    "use strict";

    var title, colspan, dayNum, countCell, monthName, j, activeColor, tag;

    if($('.widget_calendar').length<1)
        return;

    $('.widget_calendar').each(function () {
        j = 1;

        //change day title
        $(this).find('table tr th').each(function () {
            title = $(this).attr('title');
            title = title.substr(0, 3);
            $(this).html(title);
        });

        //change day title color
        colspan = parseInt($(this).find('table tbody tr td.pad').attr('colspan'));
        dayNum = parseInt($(this).find('table tr td#today').html()) + colspan;

        countCell = Math.floor(dayNum / 7);
        countCell = dayNum - (7 * countCell);

        if (countCell == 0)
            countCell = 7;

        activeColor = $(this).find('table tr td#today').css('color');

        $(this).find('table tr th').each(function () {
            if (j == countCell) {
                $(this).addClass('active');
            }
            j++;
        });

        //change html of next and prev btn
        if ($(this).find('table tr td#prev a').length) {
            monthName = $(this).find('table tr td#prev a').html();
            monthName = monthName.split("«");
            tag = "<div class='cellSettingLeft'><i class='icon-angle-left'></i></div><div class='cellSettingLeft'>" + monthName[1] + "</div>";
            $(this).find('table tr td#prev a').html(tag);
        }
        if ($(this).find('table tr td#next a').length) {
            monthName = $(this).find('table tr td#next a').html();
            monthName = monthName.split("»");
            tag = "<div class='cellSettingRight'>" + monthName[1] + "</div><div class='cellSettingRight'><i class='icon-angle-right'></i></div>";
            $(this).find('table tr td#next a').html(tag);
        }
    });
}

// enable save & publish button on changes in VC frontend Editor
function pixflow_VcUpdate(){
    "use strict";

    if(pixflow_detectPosition() == 'customizer-vc-enable'){
        var $input = window.top.$("input[data-customize-setting-link='vc_edited']");
        if($input.length){
            $(document).mousedown(function() {
                var $input = window.top.$("input[data-customize-setting-link='vc_edited']");
                $input.attr("value",Date()).keyup();
            });
        }
    }
}

/*
 function has no param and return nothing
 it just call megamenu plugin
 */
function pixflow_callDropdown(){
    "use strict";

    $('header:not(.header-clone),' +
        '.gather-overlay .menu').megamenu(1200);
}

function pixflow_RgbaToRgb($rgba){
    "use strict";

    var rgb            = $rgba.match(/\d+/g),
        counter        = 0,
        arrayBlockRect = [];

    for(var i in rgb) {
        arrayBlockRect[i] = rgb[i];

        counter++;
        if (counter == 3)
            break;
    }
    return ('rgb(' + arrayBlockRect + ')' );
}

function pixflow_addNicesroll(){
    'use strict';

    $('header.side-modern .style-style2 nav.navigation li.has-dropdown:not(.megamenu) .dropdown .dropdown').niceScroll({
        horizrailenabled: false,
        cursorcolor: "#ccc",
        cursorborder: "1px solid #ddd",
        cursorwidth:'2px',
        cursoropacitymax :"0.3",
        scrollspeed:100,
        mousescrollstep:80
    });

}

function pixflow_rowParallax(){
    "use strict";

    if ($(window).width() <= 1280 )
        return;

    $('.row-image').each( function(){

        var $this      = $(this),
            isParallax = $this.attr('isParallax'),
            $dataSpeed = $this.parent().attr('data-speed');

            $('.row-image').each(function () {

                var $this = $(this),
                    isParallax = $this.attr('isParallax');

                if ((typeof isParallax !== typeof undefined && isParallax !== false) ) {

                }

            });

    });

}

function pixflow_makeLinksTargetSelf(){
    "use strict";

    if (pixflow_detectPosition() == 'customizer-vc-disable' || pixflow_detectPosition() == 'front-end')
        return;

    var $links = $('.layout-container header nav a,' +
        '.layout-container header a.logo,' +
        '.layout-container footer a,' +
        '.layout-container .sidebar a,' +
        '.layout-container .portfolio a.button,' +
        'header .icons-pack .elem-container, header .logo a, header a.logo'+
        '.gather-overlay .menu a');
    $links.on('click',function(e){
        $(this).attr('target','_self');
        if($(this).not('.layout-container .portfolio a.button, header .icons-pack .elem-container').length){
            e.preventDefault();
            if($(this).attr('href')=='#' || $(this).attr('href')=='' || $(this).attr('href')==undefined)return;

            var href = $(this).attr('href');
            if((window.parent.vc && window.parent.vc.data_changed) || pixflow_customizerObj().$('#customize-header-actions #save').val() == 'Save & Publish'){
                var text = themeOptionValues.leaveMsg;
                pixflow_customizerObj().pixflow_messageBox(themeOptionValues.unsaved,'caution unsaved-caution',text,themeOptionValues.save_leave,function(){
                    pixflow_customizerObj().saveCallbackFunction = function(){
                        setTimeout(function(){
                            pixflow_customizerObj().saveCallbackFunction = null;
                        },10);
                        if(pixflow_customizerObj().wp.customize.previewer.previewUrl() != href) {
                            pixflow_customizerObj().pixflow_customizerLoading();
                            pixflow_customizerObj().wp.customize.previewer.previewUrl(href);
                            if(pixflow_customizerObj().wp.customize.previewer.previewUrl() != href){
                                window.open(href);
                                pixflow_customizerObj().$('.customizer-loading').css({'display': 'none'});
                            }
                        }else{
                            $('html').animate({opacity:0.7}).animate({opacity:1})
                        }
                    };
                    pixflow_customizerObj().$('#save-btn .save a').click();
                    pixflow_customizerObj().pixflow_closeMessageBox();
                },'Just Leave',function(){
                    pixflow_customizerObj().pixflow_closeMessageBox();
                    setTimeout(function(){
                        if(pixflow_customizerObj().wp.customize.previewer.previewUrl() != href) {
                            pixflow_customizerObj().pixflow_customizerLoading();
                            pixflow_customizerObj().wp.customize.previewer.previewUrl(href);
                            if(pixflow_customizerObj().wp.customize.previewer.previewUrl() != href){
                                window.open(href);
                                pixflow_customizerObj().$('.customizer-loading').css({'display': 'none'});
                            }
                        }else{
                            $('html').animate({opacity:0.7}).animate({opacity:1})
                        }
                    },500);
                },function(){});
                return false;
            }else{
                if(pixflow_customizerObj().wp.customize.previewer.previewUrl() != $(this).attr('href')) {
                    pixflow_customizerObj().pixflow_customizerLoading();
                    pixflow_customizerObj().wp.customize.previewer.previewUrl($(this).attr('href'));
                    if(pixflow_customizerObj().wp.customize.previewer.previewUrl() != href){
                        window.open(href);
                        pixflow_customizerObj().$('.customizer-loading').css({'display': 'none'});
                    }
                }else{
                    $('html').animate({opacity:0.7}).animate({opacity:1})
                }
                return false;
            }
        }
    });

    window.onbeforeunload = null;
}

function pixflow_iconboxTopShortcode(){
    "use strict";

    var circleSvg,circle,icon,title,description,button,iconAnimate1,iconAnimate2,titleAnimate,descriptionAnimate, buttonAnimate, circleAnimate1,circleAnimate2,
        TM = TweenMax;

    $('.iconbox-top .hover-holder').hover(function(){

            circleSvg = $(this).find('.svg-circle'),
                circle = circleSvg.find('circle'),
                icon   = $(this).find('.icon'),
                title  = $(this).find('.title'),
                description = $(this).find('.description'),
                button = $(this).find('.shortcode-btn');

            iconAnimate1 = TM.to(icon,0.3,{scale:0.9});
            circleAnimate1 = TM.to(circleSvg,0.4,{opacity:1});
            circleAnimate2 = TM.to(circle,1,{'stroke-dashoffset':'1px',ease: Quint.easeOut});
        },
        function(){
            iconAnimate1.pause();
            circleAnimate1.pause();
            circleAnimate2.pause();
            TM.to(icon,0.3,{scale : 1});
            TM.to(circleSvg,0.4,{opacity:'0.3'});
            TM.to(circle,0.6,{'stroke-dashoffset':'360px'});
        })
}

function pixflow_displaySliderShortcode($row){
    "use strict";

    if ($row == undefined){
        $row = $('body');
    }

    if($row.find('.device-slider').length<1)
        return;
    else {
        try {
            $row.find('.device-slider').each(function () {

                var $macFrame       = $(this).find('.mac-frame'),
                    $macFrameWidth  = ($macFrame.width() > $(window).width())? $(window).width()*.85 : $macFrame.width(),
                    $macFrameHeight = $macFrameWidth * (1.1);

                $(this).find('.slide-image').css({ width: $macFrameWidth * (0.95) , height: $macFrameHeight * (0.53) });

                $(this).find('.flexslider ul.slides li').each(function () {
                    $(this).css({ 'height': $macFrameHeight });
                });

            })

        } catch (e) {}
    }
}

function pixflow_tabletSliderShortcode($row){
    "use strict";

    if ($row == undefined){
        $row = $('body');
    }

    if($row.find('.tablet-slider').length < 1)
        return;
    else {

        try {
            $row.find('.tablet-slider').each(function () {

                var $tabletFrame       = $(this).find('.tablet-frame'),
                    $tabletFrameWidth  = ($tabletFrame.width()> $(window).width())? $(window).width()*.85 :$tabletFrame.width(),
                    $tabletFrameHeight = $tabletFrameWidth * (0.65);

                $(this).find('.slide-image').css({ width: $tabletFrameWidth - 35, height: $tabletFrameHeight });

                $(this).find('.flexslider ul.slides li').each(function () {
                    $(this).css({ 'height': $tabletFrameHeight });
                });

            });
        } catch (e) {}

    }
}

function pixflow_tabletSlider(id,slideshow){
    'use strict';
    var $item  = $('#' + id);
    if (typeof $.flexslider == 'function'){
        $item.flexslider({
            animation: "fade",
            manualControls: $('ol.flex-control-nav[data-flex-id='+id+'] li'),
            slideshow: slideshow,
        slideshowSpeed: 3000,
            selector: '.slides > li'
    });
    }
    $item.find('ol.flex-control-paging').remove();

    var $tabletFrame       = $item.find('.tablet-frame'),
        $tabletFrameWidth  = ($tabletFrame.width()> $(window).width())? $(window).width()*.85 :$tabletFrame.width(),
        $tabletFrameHeight = $tabletFrameWidth * (0.65);

    $item.find('.slide-image').css({ width: $tabletFrameWidth - 35, height: $tabletFrameHeight });

    $item.find('.flexslider ul.slides li').each(function () {
        $item.css({ 'height': $tabletFrameHeight });
    });
}

function pixflow_mobileSliderShortcode($row){
    "use strict";

    if ($row == undefined){
        $row = $('body');
    }

    if($row.find('.mobile-slider').length < 1)
        return;
    else {

        try {
            $row.find('.mobile-slider').each(function () {

                var shortcodeWidth    = $(this).find('.flexslider').width(),
                    slideHeight       = shortcodeWidth * (0.75),
                    $mobileFrame      = $(this).find('.mobile-frame'),
                    $mobileFrameWidth = ($mobileFrame.width()> $(window).width())? $(window).width()*.85 :$mobileFrame.width();

                $(this).find('.slide-image').css({ width: $mobileFrameWidth - 15, height: $mobileFrameWidth * (1.8) });

                $(this).find('.flexslider ul.slides li').each(function () {
                    $(this).css({ 'height': $mobileFrameWidth * (1.8) });
                });

            });
        } catch (e) {}

    }
}

function pixflow_imageBoxSlider (id , height){
    "use strict";
    var $ = (jQuery),
        $btnIdSlide = $('.'+id),
        $imgSlider = $('#' + id);

    if ( $btnIdSlide.length )
        $btnIdSlide.attr("data-width", "."+id);

    // change height
    $imgSlider.find('.slides').css({ height: height+'px' });
    $imgSlider.find('.slides').css({ 'max-height': $(window).height() });
    if (typeof $.flexslider == 'function'){
        $imgSlider.flexslider({
            animation: $imgSlider.attr('data-effect'),
            slideshow: true,
            animationLoop: true,
            controlNav: false,
            easing: "swing",
            smoothHeight: false,
            startAt: 0,
            slideshowSpeed: $imgSlider.attr('data-speed'),
            directionNav: false,
            touch: true,
            animationSpeed: 1200,
        });
    }
}

function pixflow_imageBoxFancy (id , height) {
    "use strict";
    var $ = (jQuery),
        $imgSlider = $('#' + id);

    $('#'+id+' .image-box-fancy-collapse').click(function(){
        $(this).closest('.image-box-fancy-desc').toggleClass('image-box-fancy-open');
        $(this).find('i').toggleClass('icon-minimize').toggleClass('icon-maximize');
    })

    // change height
    if (height != 'fit'){
        $imgSlider.find('.slides').css({height: height + 'px'});
        $imgSlider.find('.slides').css({'max-height': $(window).height()});
    }else{
        $imgSlider.find('.slides').css({height: $imgSlider.closest('.vc_row').height()});
        $imgSlider.find('.slides').css({'min-height': '450px'});
        $(window).resize(function(){
            $imgSlider.find('.slides').css({height: $imgSlider.closest('.vc_row').height()});
        })
        $(window).load(function(){
            $imgSlider.find('.slides').css({height: $imgSlider.closest('.vc_row').height()});
        })
    }
    if (typeof $.flexslider == 'function'){
        $imgSlider.flexslider({
            animation: $imgSlider.attr('data-effect'),
            slideshow: true,
            animationLoop: true,
            controlNav: false,
            easing: "swing",
            smoothHeight: false,
            startAt: 0,
            slideshowSpeed: $imgSlider.attr('data-speed'),
            directionNav: false,
            touch: true,
            animationSpeed: 1200,
        });
    }
}

var triggeredTabs = new Array();
function pixflow_imageboxFull(){
    "use strict";

    $('.imagebox-full').each(function(){
        var $this = $(this),
            textContainer     = $this.find('.text-container'),
            title             = textContainer.find('.title'),
            containerHeight   = textContainer.height(),
            titleHeight       = title.height(),
            description       = $this.find('.description'),
            descriptionHeight = description.height(),
            overlay           = $this.find('.overlay'),
            overlayColor      = overlay.css('background-color'),
            topPadding,
            newPadding,
            alpha = 1,
            tempColor;

        topPadding = containerHeight - titleHeight;
        newPadding = topPadding - descriptionHeight - 10; //10 is title's margin-bottom
        title.css({'padding-top':topPadding});
        if(overlay.length){
            alpha = overlayColor.replace(/^.*,(.+)\)/,'$1');
            tempColor = pixflow_RgbaToRgb(overlayColor);
            alpha = parseFloat(alpha)+0.2;
        }

        $this.find('.button').click(function(e){
            e.preventDefault();
        });

        $this.find('.button').hover(function(){
            TweenMax.to($this,0.6,{'background-position':'50% 55%'});
            TweenMax.to(title,0.4,{'padding-top':newPadding});
            TweenMax.to(overlay,0.4,{'background-color':tempColor, 'opacity':alpha});
            TweenMax.to(description,0.4,{'opacity':'1',delay:0.2});

        },function(){
            TweenMax.to($this,0.6,{'background-position':'50% 50%'});
            TweenMax.to(title,0.4,{'padding-top':topPadding});
            TweenMax.to(overlay,0.4,{'background-color':overlayColor, 'opacity':'1'});
            TweenMax.to(description,0.4,{'opacity':'0'});

        })
    })
}

var $ = jQuery;

$( 'body' ).on( "sortstart",'.vc_element-container,.ui-sortable', function( event, ui ){
    "use strict";

    if ( $('.tablet-frame').length)
        pixflow_tabletSliderShortcode($('body'));

    if ( $('.mobile-frame').length)
        pixflow_mobileSliderShortcode($('body'));

    pixflow_iconBox();

    $(this).sortable("option", "scroll", false);
    var wscrolltop=$(window).scrollTop();
    var windowHeight = $(window).height();
    var scrollInterval = null;
    var top = 0;
    $(this).sortable({
        sort: function (event, ui) {
            $('.vc_placeholder').css({height:'',width:'','max-width':''});
            if(!$('.vc_placeholder').next().length || ($('.vc_placeholder').next().css('display') =='none' && !$('.vc_placeholder').next().next().length)){
                $('.vc_placeholder').addClass('insert-bottom-of-me').removeClass('insert-top-of-me insert-between');
            }else if(!$('.vc_placeholder').prev().length || ($('.vc_placeholder').prev().css('display') =='none' && !$('.vc_placeholder').prev().prev().length)){
                $('.vc_placeholder').addClass('insert-top-of-me').removeClass('insert-bottom-of-me insert-between');
            }else{
                $('.vc_placeholder').addClass('insert-between').removeClass('insert-top-of-me insert-bottom-of-me').html('').append('<div></div>');
            }
            clearInterval(scrollInterval);
            top = ui.helper.offset().top;
            scrollInterval = setInterval(function(){pixflow_fly()},10);
            ui.helper.unbind('mouseup');
            ui.helper.mouseup(function(){
                setTimeout(function(){
                    $(window).resize();
                    pixflow_portfolioMultisize();
                },200);
                clearInterval(scrollInterval);
            });
            function pixflow_fly(){
                'use strict';
                $(window).scrollTop(wscrolltop);
                if(ui.helper.offset().top < $(window).scrollTop() + 50){
                    wscrolltop-=20;
                    ui.helper.offset().top-=20;
                    top-=20;
                    ui.helper.css('top',top);
                    if(wscrolltop<0){
                        ui.helper.css('top',0);
                        clearInterval(scrollInterval);
                    }

                }else if(ui.helper.offset().top > $(window).scrollTop() + windowHeight - 70){
                    wscrolltop+=20;
                    ui.helper.offset().top+=20;
                    top+=20;
                    ui.helper.css('top',top);
                    if(wscrolltop>$(document).height()){
                        wscrolltop = $(document).height()-70;
                        ui.helper.css('top',$(document).height());
                        clearInterval(scrollInterval);
                    }

                }else{
                    clearInterval(scrollInterval);
                }

            }
        }
    });
});

function pixflow_teamMemberClassic(teamMemberId, teamMemberClassicHoverColor, rowChanged ){
    "use strict";

    if (rowChanged == 'row_changed'){

       var teamWidthRowChanged = $('.vc_vc_row').find('.team-member-classic').parent().width();

       if( $('.vc_vc_row').hasClass(teamMemberId) ){
           $('.vc_vc_row').find('.team-member-classic .content').css({ width: teamWidthRowChanged, height: teamWidthRowChanged });
       }
   }

    var teamMemberWidth = teamMemberId.width();

    teamMemberId.sliphover({
        backgroundColor: teamMemberClassicHoverColor,
        duration: 'transform 0.5s cubic-bezier(0.7, 0.27, 0.33, 0.92);',
        target: '.content',
        caption: 'data-caption'
    });

    teamMemberId.find('.content').css({ width: teamMemberWidth, height: teamMemberWidth });

}

// for performance of execution
var teamMemberClassics = {}
function pixflow_teamMemberClassicHover($id, $image_url, $team_member_classic_texts_color ){
    "use strict";

    var $content = $('#'+$id).find('.content'),
        teamMemberWidth;
    // for performance of execution
    if(teamMemberClassics[$id] == undefined) {
        teamMemberClassics[$id] = setTimeout(function () {
            $('#' + $id).find('style[data-name="' + $id + '"]').remove();
            $('#' + $id).append('' +

                '<style scoped="scoped" data-name="' + $id + '"> ' + "#" + $id + " .content" + ' { background-image: url(' + $image_url + '); } ' +
                '' + '.' + $id + '-topPos' + ' { position: absolute; top: 0; padding: 25px 50px 0 30px; text-align: left; }' +
                '' + '.' + $id + '-topPos .title' + ' { padding: 0; margin: 0; font-size: 22px; line-height: 22px; margin-bottom:10px; font-weight: 400; color: ' + $team_member_classic_texts_color + '; }' +
                '' + '.' + $id + '-topPos .subtitle' + ' { font-size: 16px; line-height: 16px; color: ' + $team_member_classic_texts_color + '; }' +

                '' + '.' + $id + '-bottomPos' + ' { position: absolute; bottom: 0; padding: 0 50px 30px 30px; width: 100%; }' +
                '' + '.' + $id + '-bottomPos .description' + ' { padding-bottom: 17px; text-align: left; font-size: 14px; font-weight: 400; word-wrap: break-word; color: ' + $team_member_classic_texts_color + '; }' +
                '' + '.' + $id + '-bottomPos ul li' + ' { list-style: none; cursor: pointer; float: left; padding-right: 15px; transition: opacity 0.2s; }' +
                '' + '.' + $id + '-bottomPos ul li:hover' + ' { opacity: 0.6; }' +
                '' + '.' + $id + '-bottomPos ul li a' + ' { color: #fff; color: ' + $team_member_classic_texts_color + '; }' +

                '</style>');
            teamMemberClassics[$id] = undefined;
        }, 1000);
    }
    teamMemberWidth = $('#'+$id).width();
    $('#'+$id).find('.content').css({ width: teamMemberWidth, height: teamMemberWidth });
}

function pixflow_teamMemberRecall(){
    "use strict";

    var teamMemberClassic = $('.team-member-classic'),
        teamMemberWidth  = 0,
        teamID;

    if ( !teamMemberClassic.length )
        return;

    // Reset team member sizes
    $('.team-member-classic').each(function()
    {
        var teamId = $(this).parent().attr('id'),
            teamIdImg = $('#' + teamId).find('.content').attr('data-image'),
            teamIdColor = $('#' + teamId).find('.content').attr('data-color');

        pixflow_teamMemberClassicHover(teamId, teamIdImg, teamIdColor);
        $('#' + teamId).sliphover({
            backgroundColor: $('#' + teamId).attr('data-bgColor'),
            duration: 'transform 0.5s cubic-bezier(0.7, 0.27, 0.33, 0.92);',
            target: '.content',
            caption: 'data-caption'
        });
        teamMemberWidth = $(this).width();
    });
}

function pixflow_contactForm(){
    "use strict";

    var inputheight;

    if($('.contact-form').length < 1) {
        return;
    }
    $(".wpcf7").on('invalid.wpcf7',function(e){
        $('span.wpcf7-not-valid-tip').each(function(){
            $(this).prev().css({'box-shadow':'0 0 2px 1px red'});
        });
    });
    $('.wpcf7-form .form-input input').click(function(){
        $(this).css({'box-shadow':'none'});
    });

    $('.contact-form .form-container-business').each(function() {
        inputheight = $(this).find('.form-input').width();
        $(this).find('.form-name input,.form-email input,.form-subject input,.form-submit input').css({'height': inputheight*15/100} );
        $(this).find('.form-message textarea').css('height',inputheight*50/100);
    });

    $('.contact-form .form-container-classic').each(function() {
        inputheight = $(this).find('.form-input').width();
        $(this).find('.form-name input,.form-email input,.form-subject input').css({'height': inputheight*22/100} );
        $(this).find('.form-submit input').css({'height': inputheight*19/100} );
        $(this).find('.form-message textarea').css('height',inputheight*79/100);
    });
}

function pixflow_searchWidget(){
    "use strict";

    var searchWidget=$('.widget_search input:first-child');

    if($('.widget_search').length<1) {
        return;
    }
    searchWidget.focusin(function (){
        $(this).attr('placeholder','');
    });
    searchWidget.focusout(function(){
        if($(this).attr('placeholder')==''){
            $(this).attr('placeholder',themeOptionValues.search);
        }
    });
}

function pixflow_skill_style1($id){
    "use strict";
    var $skillsId = $($id);

    $skillsId.find('.bar-percentage[data-percentage]').each(function (i,el){

        var progress = $(this),
        percentage = Math.ceil($(this).attr('data-percentage'));
        $skillsId.find('.bar-container').css('opacity', '1');
        $skillsId.find('.bar').css('opacity', '1');
        var style2=($skillsId.hasClass('style2'));
        progress.siblings().children().not(".back-bar").not(".bar-title").css('width', 0);

        if(style2){
            setTimeout(function (){
                $({countNum: 0}).animate({countNum: percentage}, {
                    duration: 1050,
                    easing: 'easeInOutQuint',
                    step: function (value) {
                        /* What to do on every count */
                        value=Math.ceil(value);
                        var pct = value + '%';
                        progress.text(pct) && progress.siblings().children().not(".back-bar").not(".bar-title").css('width', pct);
                        var w=progress.siblings().children().not(".back-bar").not(".bar-title").width();
                        progress.css({'width':w});
                    }
                });
            },90*i);
        }
        else {
            $({countNum: 0}).animate({countNum: percentage}, {
                duration: 2000,
                easing: 'easeInOutCubic',
                step: function (value) {
                    /* What to do on every count */
                    value=Math.ceil(value);
                    var pct = value + '%';
                    progress.text(pct) && progress.siblings().children().not(".back-bar").css('width', pct);
                    var w=progress.siblings().children().not(".back-bar").width();
                }
            });
        }

    });
}

function pixflow_portfolioMultisize($portfolioIsotope, count){
    "use strict";

    var $portfolio = $('.portfolio-multisize');

    if(!$portfolio.length) return;

    $portfolio.each(function() {
        var $this = $(this),
            $isotope = $this.find('.isotope'),
            $items = $this.find('.item'),
            padding = $this.attr('data-items-padding'),
            $filters = $this.find('.filter a'),
            col;



        col = pixflow_itemSize($this,$items,padding);
        //Isotope
        var scroll = $(window).scrollTop();

        if(typeof $isotope.data('isotope') != 'undefined'){
            $isotope.isotope('destroy');
        }
        $(window).scrollTop(scroll);
        if($portfolioIsotope && $portfolioIsotope.length && $isotope[0] == $portfolioIsotope[0]){
            var $newItems = $('<div></div>');
            for(var i=1; i<=count;i++){
                $newItems.append($isotope.find('.item:nth-last-child(1)'));
            }
            $newItems = $newItems.children();
            $newItems.remove()
        }

        $isotope.isotope({
            // options
            itemSelector: '.item',
            layoutMode: 'masonry',
            masonry: {
                columnWidth: col
            },
            transitionDuration: '0.9s'
        });

        $isotope.append($newItems);
        $isotope.isotope('appended',$newItems);
        $(window).scrollTop(scroll);
        //Filter Click
        $filters.click(function(e){
            e.preventDefault();
            var $link     = $(this),
                selector  = $link.attr('data-filter');

            $isotope.isotope({ filter: selector });
            $filters.parent().siblings().removeClass('current');
            $link.parent().addClass('current');
            $('.layout-container').siblings('div').each(function(){
                if( $(this).height() > $('.layout-container').height() ){
                    $(this).css('height',$('.layout-container').height());
                }
            });
        });
        if($(window).width()<900) {
            $(this).find('.md-post-like').css('display', 'none');
            $('.overlay-background').click(function () {
                var $this = $(this);
                if ($this.css('opacity') == '0') {
                    $this.find('.md-post-like').css('display', 'inline');
                    $this.find('.md-post-like').click(function () {
                        $this.mouseleave();
                    })
                }
            });
            $('.overlay-background').mouseleave(function () {

                    $(this).find('.md-post-like').css('display', 'none');
            })
        }




    });


}

function pixflow_itemSize($this, $items, padding){
    'use strict';

    var $portfolio = $this.closest('.portfolio-multisize'),
        portfolioWidth = $this.width(),
        col = 0;

    if( portfolioWidth >= 1024 )
    {
        col=6;
    }
    else if(portfolioWidth < 1024 && portfolioWidth > 770 )
    {
        col=4;
    }
    else
    {
        col=1;
    }

    col = Math.floor( portfolioWidth/col );
    var doublePadding = padding * 2,
        metaHeight = 0;

    if($portfolio.hasClass('outside')){
        metaHeight = 90;
    }

    $items.each(function(){

        var $item 		= $(this),
            $itemImage = $item.find('.item-image');

        if (portfolioWidth > 700 ) { //Normal styles

            if ($item.hasClass('thumbnail-large')) { //Thumbnail Large

                $item.css({
                    'width': Math.round(col * 2) + 'px',
                    'height': Math.round(col * 1.722)+ metaHeight + 'px',
                    'padding': padding + 'px'
                });

                $itemImage.css({
                    'width': Math.round(col * 2 - doublePadding) + 'px',
                    'height': Math.round(col * 1.722 - doublePadding)+ 'px'
                });

            } else if ($item.hasClass('thumbnail-medium')) { //Thumbnail Medium

                $item.css({
                    'width': Math.round(col * 2) + 'px',
                    'height': Math.round(col * 1.203)+ metaHeight +'px',
                    'padding': padding + 'px'
                });

                $itemImage.css({
                    'width': Math.round(col * 2 - doublePadding) + 'px',
                    'height': Math.round(col * 1.203 - doublePadding)+ 'px'
                });

            } else { //Thumbnail small

                $item.css({
                    'width': col + 'px',
                    'height': Math.round(col * 1.203)+ metaHeight + 'px',
                    'padding': padding + 'px'
                });

                $itemImage.css({
                    'width': col - doublePadding + 'px',
                    'height': Math.round(col * 1.203 - doublePadding)+ 'px'
                });
            }
        } else { //Responsive styles
            $item.css({
                'width': col + 'px',
                'height': Math.round(col * .563)+ metaHeight +'px',
                'padding': 0
            });

            $itemImage.css({
                'width': col + 'px',
                'height': Math.round(col * .563)+ 'px'
            });
        }
    });
    return col;
}

function pixflow_portfolioLoadMore() {
    "use strict";

    if(pixflow_detectPosition() != 'front-end'){
        return;
    }

    $('.loadmore-button').each(function() {

        var $this = $(this),
            portfolioID = $this.attr('data-portfolio-id'),
            $portfolio = $('.'+portfolioID),
            $portfolioContainer = $portfolio.find('.portfolio-container'),
            $BTN = $portfolio.find('a.button'),
            nextLink = $this.attr('data-nextLink'),
            loadMoreText = $this.attr('data-loadMoreText'),
            loadingText = $this.attr('data-loadingText'),
            noMorePostText = $this.attr('data-noMorePostText'),
            startPage = parseInt($this.attr('data-startPage')),
            nextPage  = startPage + 1,
            max       = parseInt($this.attr('data-maxPages')),
            isLoading = false;
        if (max < 2) {
            if(startPage > 1){
                $BTN.find('span').html(noMorePostText);
                $BTN.fadeOut(3000);
            }
            return
        }

        //Replace links with load more button
        $BTN.find('span').html(loadMoreText);
        var $btn = $BTN,
            $btnText = $BTN.find('span');
        if (nextPage > max){
            $btnText.html(noMorePostText);
            $BTN.fadeOut(3000);
        }

        $btn.click(function(event){
            event.preventDefault();
            var scrollPosition = $(window).scrollTop();
            if (nextPage > max || isLoading)
                return;
            isLoading = true;
            //Set loading text
            $btnText.html(loadingText);
            var $pageContainer = $('<div class="posts-page-'+nextPage+'"></div>');
            var $pagedNum = 'paged';
            nextLink = nextLink.replace(/\/page\/[0-9]+/, '/?'+$pagedNum+'=' + parseInt(nextPage));
            nextLink = nextLink.replace(/paged=[0-9]+/, $pagedNum+'=' + parseInt(nextPage));
            nextLink = nextLink.replace(/paged_[0-9]+=[0-9]+/, $pagedNum+'=' + parseInt(nextPage));
            var index = $('.portfolio-multisize').index($(this).closest('.portfolio-multisize'));
            $pageContainer.load(nextLink + ' .portfolio-container', function () {
                var count = 0;
                if($portfolioContainer.hasClass($portfolioContainer.closest('.portfolio-multisize').attr('data-id')+'fixed-height')){
                    $portfolioContainer.removeClass($portfolioContainer.closest('.portfolio-multisize').attr('data-id')+'fixed-height');
                }
                $pageContainer.find('.portfolio-container:eq('+ index +')').find('.portfolio-item').each(function(){
                    var $item = $('<div></div>');
                    $item.attr('class',$(this).attr('class'));
                    $item.html($(this).html());
                    $portfolioContainer.append($item);
                    count++
                });

                pixflow_portfolioMultisize($portfolioContainer,count);


                $pageContainer.remove();
                // Update page number and nextLink.
                nextPage++;
                if (/\/page\/[0-9]+/.test(nextLink)){
                    nextLink = nextLink.replace(/\/page\/[0-9]+/, '/page/' + nextPage);
                } else{
                    nextLink = nextLink.replace(/paged1=[0-9]+/, 'paged=' + nextPage);
                }

                if (nextPage <= max){
                    $btnText.html(loadMoreText);
                } else if (nextPage > max){
                    $btnText.html(noMorePostText);
                    $btn.fadeOut(3000);
                }

                //call popup for new items
                pixflow_portfolioPopup();

                isLoading = false;
                var num = nextPage;
                num--;

                var $items = $('.portfolio-item');
                var $container = $('.portfolio-container');
                $(window).scrollTop(scrollPosition);

            });
            return false;
        });
    });

}

var skillIds=[], skillFlag=[], skillPos=[], skillI=0,
    skillPieIds=[], skillPieFlag=[], skillPiePos=[], skillPieI=0,j,
    counterIds=[], counterFlag=[], counterPos=[], counterI=0, i;

function pixflow_onScrollFindIDs(param ) {
    "use strict";

    var $param = $('.'+param);

    if ( $param.length )
    {

        // Skill Style1
        if (param == 'skill-style1') {

            $param.each(function () {
                skillIds[skillI] = $('#' + $(this).attr('id'));
                skillPos[skillI] = skillIds[skillI].position().top;
                skillFlag[skillI] = true;
                skillI++;
            });

            if($(window).width() <= 1280 ) {
                for (j = 0; j < skillI; j++) {

                    if (skillFlag[j]) {
                        pixflow_skill_style1(skillIds[j]);
                        skillFlag[j] = false;
                    }
                }
            }else{
                pixflow_eventLoadOnScroll('skillStyle1');
            }
        }

        // Counter Style1
        if (param == 'md-counter') {

            $param.each(function () {
                counterIds[counterI] = $('#' + $(this).attr('id'));
                counterPos[counterI] = counterIds[counterI].position().top;
                counterFlag[counterI] = true;
                counterI++;
            });
            pixflow_eventLoadOnScroll('counterStyle1');
        }

        // Skill Pie
        if (param == 'md-pie-chart') {

            $param.each(function () {
                skillPieIds[skillPieI] = $('#' + $(this).attr('id'));
                skillPiePos[skillPieI] = skillPieIds[skillPieI].position().top;
                skillPieFlag[skillPieI] = true;
                skillPieI++;
            });
            pixflow_eventLoadOnScroll('skillPie');
        }

    }
}

var loadPosition, scrollTop;

function pixflow_eventLoadOnScroll(param) {
    "use strict";

    $(window).scroll(function()
    {
        scrollTop = $(this).scrollTop();
        loadPosition = $(window).height() / 1.3;

        if ( param == 'skillStyle1' )
        {
            for (j = 0; j < skillI; j++) {

                if ((scrollTop > $(skillIds[j]).offset().top - loadPosition) && skillFlag[j]) {
                    pixflow_skill_style1(skillIds[j]);
                    skillFlag[j] = false;
                }
            }
        }

        if ( param == 'skillPie' )
        {
            for (j = 0; j < skillPieI; j++) {

                if ((scrollTop > $(skillPieIds[j]).offset().top - loadPosition) && skillPieFlag[j]) {
                  if(skillPieIds[j].hasClass('type-1'))
                    pixflow_pieChart(skillPieIds[j],skillPieIds[j].attr('data-barColor'),skillPieIds[j].attr('data-trackColor'));
                    if(skillPieIds[j].hasClass('type-2'))
                    pixflow_pieChart2(skillPieIds[j],skillPieIds[j].attr('data-barColor'),skillPieIds[j].attr('data-trackColor'));
                    skillPieFlag[j] = false;
                }
            }
        }

        if ( param == 'counterStyle1' )
        {
            for (i = 0; i < counterI; i++) {

                if ((scrollTop > $(counterIds[i]).offset().top - loadPosition) && counterFlag[i]) {
                    pixflow_counterShortcode( counterIds[i] );
                    counterFlag[i] = false;
                }
            }
        }

    });

}

function pixflow_eventRunFirstTime(param ) {
    'use strict';
    var windowHeight = $(window).height();
    scrollTop = $(window).scrollTop();
    loadPosition = windowHeight / 1.3;

    if (param == 'skill-style1') {
        for (j = 0; j < skillI; j++) {
            if ((scrollTop > $(skillIds[j]).offset().top - loadPosition) && skillFlag[j]) {
                pixflow_skill_style1(skillIds[j]);
                skillFlag[j] = false;
            }
        }
    }

    if (param == 'md-counter') {
        for (i = 0; i < counterI; i++) {
            if ((scrollTop > $(counterIds[i]).offset().top - loadPosition) && counterFlag[i]) {
                pixflow_counterShortcode(counterIds[i]);
                counterFlag[i] = false;
            }else if (scrollTop == 0 && (windowHeight > $(counterIds[i]).offset().top - loadPosition) && counterFlag[i]){
                pixflow_counterShortcode(counterIds[i]);
                counterFlag[i] = false;
            }
        }
    }

}

function pixflow_title_slider(){
    'use strict';

    if(!$('.title-slider').length) {
        return;
    }

    $('.md-text-title').each(function(index,value){
        if($(this).find('.texts li').length <= 1){
            $(this).removeData();
            return true;
        }
        $(this).textillate({
            in: {
                effect: 'fadeIn',
                delayScale: 1.5,
                delay: 65
            },
            out: {
                effect: 'fadeOut',
                delayScale: 1.5,
                delay: 65
            },
            loop: true,
            type: 'char',
            minDisplayTime: 0,
            initialDelay: 100
        });

        $(this).find('ul').css('display','block');
        var liHeight = 0,
            tempVal  = 0;
        $(this).find('ul li').each(function(){
            liHeight=$(this).height();
            if(tempVal<liHeight){
                tempVal=liHeight;
            }
        });
        $(this).find('ul').css('display','none');
        $(this).css('height',tempVal+'px');

    });

}

function pixflow_music($id){
    'use strict';

    var $ = jQuery,
        $Image, ImageWidth, musicWidth, $playPause, $trackLink, $discImage, $musicId, $btnMusicID,  $musicBar, $musicDuration, playPauseBtnFlag, musicPlayed, $trackId, $playPauseBtn, $jpAudio, $trackText;

    // Music Text/Button Play Click

    $('#'+$id+' .tracks .link, #'+$id+' .tracks .jp-controls').click( function()
    {
        var $this = $(this);
        $musicId = $('#' + $this.parents('.music-sc').attr('id'));  // Music shortcode id
        $trackId = $('#' + $this.parents().attr('id'));
        $playPauseBtn = $trackId.find('.jp-controls .play-pause');  // Play-pause button click
        $trackText = $trackId.find('.link');  // track text click
        $jpAudio = $this.parents('.jp-audio');

        $discImage = $musicId.find('.image-album .disc-image');

        // Show/Hide Play/Pause button

        $musicId.find('.jp-controls').hide();
        $playPauseBtn.parents('.jp-controls').show();

        // Determine play or pause state

        if (!$jpAudio.hasClass('jp-state-playing'))
            musicPlayed = true;
        else
            musicPlayed = false;

        $('.music-sc .image-album .disc-image').removeClass('disc-image-state');
        $('.music-sc .jp-duration').css('right', '0');
        $('.music-sc .music-bar').css('display', 'none');

        if (musicPlayed){
            pixflow_musicBtnAnimation($('.music-sc').not('#'+$musicId.attr('id')).find('.jp-controls .play-pause'), false);
            pixflow_musicBtnAnimation($musicId.find('.jp-controls .play-pause'), true);
            $discImage.addClass('disc-image-state');
            $(this).siblings('.jp-type-single').find('.jp-duration').css('right', '25px');
            $(this).siblings('.jp-type-single').find('.music-bar').css('display', 'block');
        }else{
            pixflow_musicBtnAnimation($musicId.find('.jp-controls .play-pause'), false);
        }

    });

    $('#'+$id+' .jp-progress').bind('click',function(){
        var $this = $(this);
        $('#'+$id).jPlayer("stop");
        $('#'+$id+' .jp-progress').not($this).find('.jp-play-bar').addClass('seekRefine');
        $this.find('.jp-play-bar').removeClass('seekRefine');
    });

}

function pixflow_musicFitSizes(){
    'use strict';

    var $musicId, $Image, $discImage, $musicImgContainer, $musicTxtsContainer, musicWidth, ImageWidth, musicIdTxtSize, musicIdImgSize, imgPosTop, imgPosLeft;

    $('.music-sc .jp-controls').show();

    $('.music-sc').each(function () {
        var $this = $(this),
            $jpControls = $this.find('.jp-controls');

        $musicId = $('#' + $this.attr('id'));
        $musicImgContainer = $musicId.find('.wrap-image');
        $musicTxtsContainer = $musicId.find('.music-main-container');
        if($musicId.width()<1024){
            $musicId.css('transform','translateX(0)');
        }
        musicIdImgSize = $musicId.width() / 2.7;
        musicIdTxtSize = $musicId - musicIdImgSize;

        $musicImgContainer.css({width: musicIdImgSize, height: musicIdImgSize}); // set image part size
        $musicTxtsContainer.css('width', musicIdTxtSize); // set texts part size

        imgPosTop = $this.find('.btnSimulate').offset().top; // calculate play button position
        imgPosLeft = $this.find('.btnSimulate').offset().left; // calculate play button position

        $jpControls.offset({top: imgPosTop, left: imgPosLeft}).hide(); // set play button position center

        $discImage = $musicId.find('.image-album .disc-image');
        $discImage.css({width: '90%', height: '90%'}); // set disk image size

    });

    $('.music-sc .tracks .music-bar').hide();
    $('.music-sc .tracks li:nth-child(1) .jp-controls').show();

}

function pixflow_musicBtnAnimation($obj, flag){
    'use strict';

    var $  = jQuery;

    /* Play-Pause animation button */

    $obj.each(function(){

        var $this = $(this),
            bottom = $this.closest('.music-sc').find('.wrap-image').height() / 2,
            left = $this.closest('.music-sc').find('.wrap-image').width() / 2 - 40;

        if( !flag ){
            if( $this.hasClass('musicBtnClicked') )
            {

                if ( $('body').width() > 800 ) {

                    $this.stop().animate({
                        'margin-left': -(left / 2),
                        'margin-top': bottom * .7,
                        width: '50px',
                        height: '50px'
                    }, 200, 'linear', function () {
                        $this.stop().animate({
                            'margin-left': 0,
                            'margin-top': 0,
                            width: '70px',
                            height: '70px'
                        }, 300, 'linear');
                    });
                }
                $this.removeClass('musicBtnClicked');
                $this.find('.icon').removeClass('icon-pause');
                $this.find('.icon').addClass('icon-play');
            }
        }
        else{
            if($this.css('margin-left') != -(left)+"px"){

                if ( $('body').width() > 800 ) {

                    $this.css('background-image', 'none');
                    $this.stop().animate({
                        'margin-left': -(left / 2),
                        'margin-top': bottom * .7,
                        width: '50px',
                        height: '50px'
                    }, 200, 'linear', function () {
                        $this.stop().animate({
                            'margin-left': -(left),
                            'margin-top': bottom,
                            width: '30px',
                            height: '30px'
                        }, 300, 'linear');
                    });
                }

                $this.find('.icon').removeClass('icon-play');
                $this.find('.icon').addClass('icon-pause');
                $this.addClass('musicBtnClicked');
            }

        }

    });

}

function pixflow_instagramWidget(){
    'use strict';

    $('.widget-instagram').each(function(){
        var $this = $(this),
            firstItem = $this.find('.item:first').clone();
        $this.find('.featured-item').css({'height':($this.find('.featured-item').width())});
        $this.find('.featured-item').append(firstItem).fadeIn('slow');

        $this.find('.item').click(function(){
            $this.find('.featured-item .item').fadeOut().remove();
            $this.find('.featured-item').append($(this).clone());
            $this.find('.featured-item .item').hide().fadeIn(800);
        });
    });
}

function pixflow_instagramShortcode(){
    'use strict';
    var $instagram = $('.instagram');

    if(!$instagram.length) return;

    $instagram.each(function() {
        var $this = $(this),
            $items = $this.find('.photo-list .item'),
            itemsMargin = 33,
            col;
        function pixflow_itemSize(){
            'use strict';

            var instagramWidth = Math.floor($this.width()-1);
            if(instagramWidth > $(window).width()){
                instagramWidth = $(window).width() - 10;
            }
            col = 0;

            if( instagramWidth > 1200 )
            {
                col=4;
            }
            else if(instagramWidth <= 1200 && instagramWidth > 768 )
            {
                col=3;
            }
            else if(instagramWidth <= 768 && instagramWidth > 480 )
            {
                col=2;
            }
            else
            {
                col=1;
                itemsMargin = 0;
            }

            if ($(window).width()<1440 && $(window).width()>1024){
                itemsMargin=15;
            } else if($(window).width()<=1024 && $(window).width()>767){
                itemsMargin=10;
            }
            instagramWidth = instagramWidth - (col * (itemsMargin*2));
            col = Math.floor( instagramWidth/col );

            $items.each(function(){

                var $item 	   = $(this),
                    $itemImage = $item.find('.item-image');

                $item.css({
                    'width': col + 'px',
                    'margin-left': itemsMargin + 'px',
                    'margin-right': itemsMargin + 'px'
                });

                $itemImage.css({
                    'width': col  + 'px',
                    'height': col + 'px'
                });
            });
        }
        pixflow_itemSize();
    })
}

var firstImage = null;
function pixflow_semiAjaxOut(){
    if($('.loading-text').length) {
        $('.loading-text').delay(700).animate({opacity: 0}, 1000, 'swing', function () {
            $('#pageLoadingOverlay').animate({opacity: 0}, 1000, 'swing', function () {
                $(this).remove();
            })
        });
    }else{
        $('#pageLoadingOverlay').animate({opacity: 0}, 1000, 'swing', function () {
            $(this).remove();
        })
    }

    if(window.top != window.self){
        $('document').ready(function(){
            if (typeof pixflow_customizerAnimate == 'function') {
                pixflow_customizerAnimate('out');
            }
        });
    }
}
function pixflow_loadSite(){
    "use strict";
    date = new Date();
    if(themeOptionValues.loadingText!='') {
        var time = 3500 - (date.getTime() - timestamp) * 1;
    }else{
        var time = 1000 - (date.getTime() - timestamp) * 1;
    }
    if(time < 0){
        time=0;
    }
    setTimeout(function(){
        if ($('header.top-modern').length){
            var image = new Image();
            image.src = $('header .logo img').attr('src');
            $(image).load(function(){
                pixflow_semiAjaxOut();
            }).error(function(){
                pixflow_semiAjaxOut();
            })
        }else{
            pixflow_semiAjaxOut()
        }
    },time)

}

var loadingElement = 0;
var loadedElement = 0;

function pixflow_checkLoading($obj){
    "use strict";
    var children = $obj.children();

    children.each(function(){
        if($(this).get(0).tagName == 'IMG'){
            if(firstImage == null){
                firstImage = $(this);
            }

            loadingElement++;
            $(this).load(function(){
                loadedElement++;
                if(loadingElement == loadedElement)
                    pixflow_loadSite();
            }).error(function(){
                loadedElement++;
                if(loadingElement == loadedElement)
                    pixflow_loadSite();
            });
        }else{
            if($(this).css('background-image')!='none'){
                if(firstImage == null){
                    firstImage = $(this);
                }
                loadingElement++;
                var url = $(this).css('background-image');
                url = url.replace(/^url\(["']?/i, '').replace(/["']?\)$/, '');
                $('<img/>').attr('src', url).load(function() {
                    $(this).remove();
                    loadedElement++;
                    if(loadingElement == loadedElement)
                        pixflow_loadSite();
                }).error(function(){
                    loadedElement++;
                    if(loadingElement == loadedElement)
                        pixflow_loadSite();
                });
            }
        }

        pixflow_checkLoading($(this));
    });
    setTimeout(function(){
        if(loadingElement == 0) {
            pixflow_loadSite();
        }
    },1)

}
var date,
    timestamp;
function pixflow_loadSemiAjax(){
    "use strict";
    //disable semiAjax
    $('header').css('visibility','visible');
    $('html').css('overflow','auto');
    $('#pageLoadingOverlay').remove();
    return;
    if($(window).width()<768) {
        $('html').css('overflow','auto');
        return;
    }

    date = new Date();
    timestamp = date.getTime();

    var loadingType = themeOptionValues.loadingType,
        loadingText = themeOptionValues.loadingText,
        preloaderLogo = themeOptionValues.preloaderLogo,
        headerTop = $('header.top').css('top'),
        url;
    if(loadingText != ''){
        $('.loading-text img').animate({
            'opacity':1
        },400,'linear',function(){
            $('.loading-text .preloader-text').addClass('show-loading-text');
            TweenMax.to($(this),1.1,{y:'-100%',x:'-50%',top:'10px'});
        })
        var menuDelay = 3500;
    }else{
        var menuDelay = 500;
    }
    if(parseInt(headerTop) <= 0 && parseInt($('.layout').css('padding-top')) == 0) {
        $('#pageLoadingOverlay').css('z-index','9999');
        $('header.top').css('top', -$('header.top').height());
    }

    $('header').css('visibility','visible');
    $('html').css('overflow','auto');
    if(window.top != window.self){
        $('header.top').css('top','');
        $('#pageLoadingOverlay').remove();
        pixflow_loadSite();
        return;
    }
    if ($('header.top-modern').length){
        var image = new Image();
        image.src = $('header .logo img').attr('src');
        $(image).load(function(){
            TweenMax.to($('header.top'), 0.5, {
                top: headerTop, delay: menuDelay / 1000, ease: Power4.easeOut, onComplete: function () {
                    $('header.top').css('top', '')
                }
            });
        }).error(function(){
            TweenMax.to($('header.top'), 0.5, {
                top: headerTop, delay: menuDelay / 1000, ease: Power4.easeOut, onComplete: function () {
                    $('header.top').css('top', '')
                }
            });
        })
    }else {
        TweenMax.to($('header.top'), 0.5, {
            top: headerTop, delay: menuDelay / 1000, ease: Power4.easeOut, onComplete: function () {
                $('header.top').css('top', '')
            }
        });
    }

    if(loadingElement==0 || typeof pixflow_customizerObj == 'function') {
        pixflow_loadSite();
    }
    url = window.location.href.replace(location.hash,"");
    $('a:link').not('[href^="javascript:"], [href^="'+url+'#"],[href^="#"]').each(function(){

        var ev = $._data(this, 'events');
        if((ev && ev.click)){
            return;
        };
        var $this = $(this),
            href = $this.attr('href'),
            target = $this.attr('target');

        if(target && target.toLowerCase()!='_self' && target != '')
            return;
        $this.click(function(clickEvent){
            var events = $._data( $(this)[0], 'events' );
            if(events && events.click && events.click.length > 1){
                return;
            }

            if($(this).attr('class')) {
                var classNames = $(this).attr('class').toString().split(' ');
            }else{
                var classNames = '';
            }
            var linkID = $(this).attr('id');
            var ret = '';
            $(this).parents().add(document).each(function(){
                var events = $._data( $(this)[0], 'events' );
                if(events && events.click && events.click.length > 0){
                    for(i in events.click){
                        if(classNames!='') {
                            $.each(classNames, function (j, className) {
                                if (events.click[i]) {
                                    var cls = events.click[i].selector;
                                    if (cls && cls.search('.' + className) != -1) {
                                        ret = 'true';
                                        return;
                                    }else if(linkID && cls.search('#' + linkID) != -1){
                                        ret = 'true';
                                        return;
                                    }

                                }
                            });
                        }else{
                            if (linkID && events.click[i]) {
                                var cls = events.click[i].selector;
                                if (cls && cls.search('#' + linkID) != -1) {
                                    ret = 'true';
                                }
                            }
                        }
                    }
                }
            });
            if(ret == 'true'){
                return;
            }
            href = $(this).attr('href');
            if($(this).parents().data('events') && $(this).parents().data('events').click){
                return true;
            }
            if(clickEvent.metaKey || clickEvent.ctrlKey || clickEvent.which === 2){
                return true;
            }
            // Hide dropdowns
            $('ul.dropdown').fadeOut(100);
            if($('.gather-overlay').length)
                pixflow_closeOverlay();
            setTimeout(function() {window.location = href}, 1200);
            if($(window).width() > 1024 && parseInt($('header.top').css('top'))<=0 && parseInt($('.layout').css('padding-top')) == 0){
                $('header.top').animate({'top': - $('header.top').height()},500);
            }
            if(loadingType == 'light') {
                $('html').delay(400).animate({opacity: 0}, 1000);
            }else{
                $('body').append('<div id="pageLoadingOverlay" style="position:fixed;top:0;left:0;width:100%;height: 100%; background: #000; opacity: 0;z-index: 9999"></div>');
                $('#pageLoadingOverlay').delay(400).animate({opacity: 1}, 1000);
            }
            return false;
        });
    });
}

function pixflow_processSteps(){
    'use strict';
    var processSteps = $('.process-steps');

    if(!processSteps.length) return;

    if($(window).width() > 768) {
        setTimeout(function(){ //to calculate it's width in tab shortcodes correctly
            processSteps.each(function () {
                var $this = $(this),
                    containerWidth = $this.width(),
                    steps = $this.find('.step'),
                    circle = steps.find('.circle'),
                    separator = circle.find('.separator'),
                    description = $(this).find('.description'),
                    title = $(this).find('.title'),
                    colPercentage = 0,
                    smallColWidth,
                    lastStepsSize = 0;

                //Getting steps width percentage
                steps.each(function () {
                    if ($(this).hasClass('small')) {
                        colPercentage += 1;
                    } else if ($(this).hasClass('medium')) {
                        colPercentage += 1.32;
                    } else if ($(this).hasClass('large')) {
                        colPercentage += 1.64;
                    }
                });
                smallColWidth = Math.floor(containerWidth / colPercentage);

                //Setting size for each item
                steps.each(function () {
                    var step = $(this),
                        circle = step.find('.circle'),
                        separator = circle.find('.separator'),
                        description = step.find('.description'),
                        title = steps.find('.title'),
                        rightPadding;

                    if (step.hasClass('small')) { //Small Size

                        rightPadding = Math.round(smallColWidth * .36);
                        step.css({
                            'width': smallColWidth + 'px',
                            'padding-right': rightPadding + 'px'
                        });
                        circle.css({
                            'height': smallColWidth - rightPadding + 'px'
                        });
                        separator.css({
                            'width': rightPadding - 30 + 'px'
                        })

                    } else if (step.hasClass('medium')) { //Medium Size

                        rightPadding = Math.round(smallColWidth * .35);
                        step.css({
                            'width': Math.round(smallColWidth * 1.2) + 'px',
                            'padding-right': rightPadding + 'px'
                        });
                        circle.css({
                            'height': Math.round(smallColWidth * 1.2) - rightPadding + 'px'
                        });
                        separator.css({
                            'width': rightPadding - 30 + 'px'
                        })

                    } else if (step.hasClass('large')) { //Large Size

                        rightPadding = Math.round(smallColWidth * .27);
                        step.css({
                            'width': Math.round(smallColWidth * 1.34) + 'px',
                            'padding-right': rightPadding + 'px'
                        });
                        circle.css({
                            'height': Math.round(smallColWidth * 1.34) - rightPadding + 'px'
                        });
                        separator.css({
                            'width': rightPadding - 30 + 'px'
                        })
                    }

                    step.hover(function () {
                        TweenMax.to(circle, 0.4, {'scale': '0.95'});
                        TweenMax.to(description, 0.4, {'padding-top': '0', 'margin-bottom': '30px', 'opacity': '1'});
                    }, function () {
                        TweenMax.to(circle, 0.4, {'scale': '1'});
                        TweenMax.to(description, 0.4, {'padding-top': '30px', 'margin-bottom': '0', 'opacity': '0'});
                    });
                });

                //Circles vertical align and animation starting point
                var largeCircleHeight = $this.find('.step.large .circle').height();
                steps.each(function () {
                    var circle = $(this).find('.circle');

                    if ($(this).is('.small, .medium') && largeCircleHeight != null) {
                        circle.css({
                            'margin-top': (largeCircleHeight - circle.height()) / 2 + 'px',
                            'margin-bottom': (largeCircleHeight - circle.height()) / 2 + 30 + 'px'
                        })
                    }
                    //Setting center points for animation
                    lastStepsSize += $(this).prev().outerWidth();
                    circle.attr('data-animate-start', ((containerWidth - $(this).outerWidth() ) / 2) + ($(this).css('padding-right').replace(/[^-\d\.]/g, '') / 2) - lastStepsSize);

                    circle.css({'left': circle.attr('data-animate-start') + 'px'});

                });

                //Center align process steps
                lastStepsSize += $this.find('.step:last-child').outerWidth();
                var lastCirclePadding = $this.find('.step:last-child').css('padding-right').replace(/[^-\d\.]/g, '') / 2;
                $this.css({'padding-left': lastCirclePadding + (($this.width() - lastStepsSize) / 2)});
                $this.find('.step:last-child').css({
                    'width': $this.find('.step:last-child .circle').css('height'),
                    'padding-right': 0
                });

                $this.addClass('animating');
                TweenMax.staggerTo(circle, 0.8, {scale: '1', opacity: '1'}, 0.2);
                TweenMax.staggerTo(circle, 0.8, {left: '0', delay: 0.3}, 0.1);
                TweenMax.staggerTo(separator, 0.6, {'scaleX': '1', delay: 0.6}, 0.2);
                TweenMax.staggerTo(title, 0.6, {
                    'padding-top': '0',
                    'margin-bottom': '30px',
                    opacity: '1',
                    delay: 0.4
                }, 0.1);
                TweenMax.staggerTo(description, 0.6, {visibility: 'visible', delay: 0.8}, 0.1);
            })
        },150);
    }
}

function pixflow_shortcodeAnimation(){
    'use strict';
    if ($(window).width() < 1281)
        return;

    // Remove shortcode animation in acc,toggle,tab
    $('.ui-accordion-content .has-animation').each( function(){
        $(this).removeClass('has-animation');
    });

    $('.has-animation').each( function(i){

        var $this = $(this),
            animation_speed = $this.attr('data-animation-speed'),
            animation_delay = $this.attr('data-animation-delay')*1000,
            animation_position = $this.attr('data-animation-position'),
            shortcodeTop = $this.offset().top,
            shortcodeBottom = $this.offset().top + $this.outerHeight(true),
            move = 50;

        if(animation_position == 'center'){
            $this.css({
                'transform':'translateX(0) translateY(0)',
                '-webkit-transform':'translateX(0) translateY(0)'
            });
        }else if(animation_position == 'right'){
            $this.css({
                'transform':'translateX('+move+'px)',
                '-webkit-transform':'translateX('+move+'px)'
            });
        }else if(animation_position == 'left'){
            $this.css({
                'transform':'translateX(-'+move+'px)',
                '-webkit-transform':'translateX(-'+move+'px)'
            });
        }else if(animation_position == 'top'){
            $this.css({
                'transform':'translateY(-'+move+'px)',
                '-webkit-transform':'translateY(-'+move+'px)'
            });
        }else if(animation_position == 'bottom'){
            $this.css({
                'transform':'translateY('+move+'px)',
                '-webkit-transform':'translateY('+move+'px)'
            });
        }

        /* If the object is completely visible in the window, set translate to 0 */
        if($(document).height() <= $(window).height() || (($(window).scrollTop() + $(window).height() - 200 >= shortcodeTop) && ($(window).scrollTop() + 100 <= shortcodeBottom))){
            $this.css({
                'transform':'translateX(0) translateY(0)',
                '-webkit-transform':'translateX(0) translateY(0)'
            });
        }
    });
}

function pixflow_shortcodeAnimationScroll() {
    'use strict';
    if ($(window).width() < 1281)
        return;

    $('.has-animation').each(function (i) {
        var $this = $(this),
            shortcodeTop = $this.offset().top,
            shortcodeBottom = $this.offset().top + $this.outerHeight(true),
            animation_speed = Number($this.attr('data-animation-speed')) * 0.001,
            animation_delay = Number($this.attr('data-animation-delay')),
            animation_position = $this.attr('data-animation-position'),
            move = 50;
        /* If the object is completely visible in the window, fade it */
        if($(document).height() <= $(window).height() || (($(window).scrollTop() + $(window).height() - 200 >= shortcodeTop) && ($(window).scrollTop() + 100 <= shortcodeBottom))){
            if (!$this.hasClass('show-animation')) {
                $this.addClass('show-animation');
                TweenMax.to($this,animation_speed,{opacity: 1,'transform':'translateX(0) translateY(0)',delay:animation_delay,ease:Quart.easeInOut});//Linear.easeNone
            }
        }
        $(window).scroll(function(){
            if (($(window).scrollTop() + $(window).height() - 200 >= shortcodeTop) && ($(window).scrollTop() + 100 <= shortcodeBottom)) {
                if (!$this.hasClass('show-animation')) {
                    $this.addClass('show-animation');
                    TweenMax.to($this,animation_speed,{opacity: 1,'transform':'translateX(0) translateY(0)',delay:animation_delay,ease:Quart.easeInOut});
                }
            } else {
                if ($this.hasClass('show-animation') && $this.attr('data-animation-show') == 'scroll') {
                    $this.removeClass('show-animation');
                    animation_delay = animation_delay / 2;
                    if (animation_position == 'center') {
                        TweenMax.to($this,animation_speed,{opacity: '0','transform':'translateX(0) translateY(0)',delay:animation_delay,ease:Quart.easeInOut});
                    } else if (animation_position == 'right') {
                        TweenMax.to($this,animation_speed,{opacity: '0','transform':'translateX('+ move +'px)',delay:animation_delay,ease:Quart.easeInOut});
                    } else if (animation_position == 'left') {
                        TweenMax.to($this,animation_speed,{opacity: '0','transform':'translateX(-'+ move +'px)',delay:animation_delay,ease:Quart.easeInOut});
                    } else if (animation_position == 'top') {
                        TweenMax.to($this,animation_speed,{opacity: '0','transform':'translateY(-'+ move +'px)',delay:animation_delay,ease:Quart.easeInOut});
                    } else if (animation_position == 'bottom') {
                        TweenMax.to($this,animation_speed,{opacity: '0','transform':'translateY('+ move +'px)',delay:animation_delay,ease:Quart.easeInOut});
                    }
                }
            }
        })
    });
}

function pixflow_shortcodeScrollAnimation() {
    'use strict';

    //if not in customizer

    var processSteps = $('.process-steps'),
        musicSC = $('.music-sc'),
        showcases = $('.showcase');

    if (!processSteps.length && !musicSC.length && !showcases.length) return;

    if ( $(window).width() > 768 ) {
        processSteps.each(function () {
            var $this = $(this),
                steps = $this.find('.step'),
                circle = steps.find('.circle'),
                separator = circle.find('.separator'),
                title = steps.find('.title'),
                description = steps.find('.description');

            if (window.self === window.top){

                $(window).scroll(function () {

                    if ($this.offset().top <= $(window).scrollTop() + $(window).height() - 100 && $this.offset().top + $this.height() - 300 >= $(window).scrollTop()) {

                        if ($this.hasClass('animating')) {
                            return;
                        } else {
                            $this.addClass('animating');
                            TweenMax.staggerTo(circle, 0.8, {scale: '1', opacity: '1'}, 0.2);
                            TweenMax.staggerTo(circle, 0.8, {left: '0', delay: 0.3}, 0.1);
                            TweenMax.staggerTo(separator, 0.6, {'scaleX': '1', delay: 0.6}, 0.2);
                            TweenMax.staggerTo(title, 0.6, {
                                'padding-top': '0',
                                'margin-bottom': '30px',
                                opacity: '1',
                                delay: 0.4
                            }, 0.1);
                            TweenMax.staggerTo(description, 0.6, {visibility: 'visible', delay: 0.8}, 0.1);
                        }
                    } else {
                        if ($this.hasClass('animating')) {
                            TweenMax.staggerTo(circle, 0.8, {scale: '0', opacity: '0'}, 0.2);
                            TweenMax.staggerTo(separator, 0.6, {'scaleX': '0', delay: 0.6}, 0.2);
                            TweenMax.staggerTo(title, 0.6, {
                                'padding-top': '30px',
                                'margin-bottom': '0',
                                opacity: '0',
                                delay: 0.4
                            }, 0.1);
                            TweenMax.staggerTo(description, 0.6, {visibility: 'hidden', delay: 0.8}, 0.1);
                            steps.each(function () {
                                var singleCircle = $(this).find('.circle');
                                singleCircle.stop().animate({'left': singleCircle.attr('data-animate-start') + 'px'}, 500);
                            });
                            $this.removeClass('animating');
                        } else {
                            return;
                        }
                    }
                })
            }
        });
    }

    // Music Shortcode

    musicSC.each(function () {
        var $this = $(this),
            $discImage;
        var timeOut;
        if (window.self === window.top) {
            $(window).scroll(function () {
                $discImage = $this.find('.disc-image');
                if ($this.offset().top <= $(window).scrollTop() + $(window).height() - 100 && $this.offset().top + $this.height() - 300 >= $(window).scrollTop()) {
                    if ($this.hasClass('animating')) {
                        return;
                    } else {
                        $this.addClass('animating');
                        if($discImage.closest('.music-sc').hasClass('left-music-panel')){
                            $discImage.css('right', '35%');
                            $discImage.css('animation-name','rotateLeft');
                        }else{
                            $discImage.css('right', '-35%');
                        }


                        $discImage.css('animation-play-state', 'running');
                        $discImage.css('animation-duration', '7s');
                        timeOut = setTimeout(function () {
                            $discImage.css('animation-play-state', '');
                            $discImage.css('animation-duration', '');
                        }, 1000)

                    }
                } else {
                    if ($this.hasClass('animating')) {
                        clearInterval(timeOut);
                        $discImage.css('animation-play-state', '');
                        $discImage.css('animation-duration', '');
                        $discImage.css('right', '0');
                        $this.removeClass('animating');

                    } else {
                        return;
                    }
                }
            })
        }
    });

    showcases.each(function () {
        var carousel,
            $element = $(this),
            $carouselImages = $element.find('a');

        $carouselImages.css({
            overflow: 'hidden!important', width: 0, height: 0
        });
        if (typeof $element.waterwheelCarousel == 'function') {
            $carouselImages.removeAttr('style');
            $carouselImages.off('click');
            var carousel = $element.waterwheelCarousel({
                forcedImageWidth: 760,
                forcedImageHeight: 436,
                horizonOffsetMultiplier: 0,
                speed: 600,
                flankingItems: 2,
                separation: 300,
                animationEasing: 'swing',
                opacityMultiplier: 1,
                movingToCenter: function ($moveing) {
                    pixflow_showcase_moved($moveing, $carouselImages);
                }
            });

            var featureLeft = 0,
                featureTop  = 0;

            pixflow_showcase_moved($carouselImages.first(), $carouselImages);

            setTimeout(function () {
                $carouselImages.each(function () {
                    $(this).attr('data-left', $(this).css('left'));
                    $(this).attr('data-top', $(this).css('top'));
                });
                featureLeft = $carouselImages.first().css('left').replace('px', '') * 1 + 119;
                featureTop = $carouselImages.first().css('top').replace('px', '') * 1 + 50;
                var showcaseTop = $element.offset().top,
                    showcaseBottom = $element.offset().top + $element.outerHeight(true);
                if (($(window).scrollTop() + $(window).height()-100 >= showcaseTop) && ($(window).scrollTop() + 300 <= showcaseBottom)
                    || window.self !== window.top) {
                        $element.addClass('open-showcase');
                        $carouselImages.each(function () {
                            $(this).animate({
                                'left': $(this).data('left'),
                                'top': $(this).data('top')
                            },1).finish();
                        })
                }else{
                    $element.removeClass('open-showcase');
                    $carouselImages.not('.carousel-center').animate({
                        left: featureLeft,
                        top: featureTop
                    },1).finish();
                    $carouselImages.filter('.carousel-center').animate({
                        left: $carouselImages.filter('.carousel-center').data('left'),
                        top: $carouselImages.filter('.carousel-center').data('top')
                    },1).finish();
                }
            }, 1);

            if (window.self === window.top) {
                $(window).scroll(function () {
                    if ($element.length) {
                        var showcaseTop = $element.offset().top,
                            showcaseBottom = $element.offset().top + $element.outerHeight(true);

                        if (($(this).scrollTop() + $(this).height() - 100 >= showcaseTop) && ($(this).scrollTop() + 300 <= showcaseBottom)) {

                            if (!$element.hasClass('open-showcase')) {
                                $element.addClass('open-showcase');
                                $carouselImages.each(function () {
                                    $(this).animate({
                                        'left': $(this).data('left'),
                                        'top': $(this).data('top')
                                    }, 600);
                                })
                            }
                        } else {
                            if ($element.hasClass('open-showcase')) {
                                $element.removeClass('open-showcase');
                                $carouselImages.not('.carousel-center').animate({
                                    left: featureLeft,
                                    top: featureTop
                                }, 600);
                            }
                        }
                    }
                });
            }
        }
    })

}

function pixflow_showcase_moved($moveing, $carouselImages){
    "use strict";

    var current = $moveing,
        all = $carouselImages.length;

    $carouselImages.find('.showcase-overlay-first').remove();
    $carouselImages.find('.showcase-overlay-second').remove();

    for (var i = 0; i < all; i++) {
        if (current.index() == all - 1)
            current = $carouselImages.first();
        else
            current = current.next();
        if (i == 0 || (i == 3 && all == 5) || (i == 1 && all == 3)) {
            current.append('<div class="showcase-overlay-first"></div>')
        }
        if ((i == 1 && all == 5) || (i == 2 && all == 5)) {
            current.append('<div class="showcase-overlay-second"></div>')
        }
    }
}

function pixflow_showcaseHover(){
    'use strict';
    var halfHeight = $(window).height()*0.5,
        halfWidth = $(window).width()*0.5,
        rotationLimit = 20;

    if(pixflow_isTouchDevice() && $(window).width() <= 1280)
        return;

    $('.showcase a').each(function(){
        $(this).on('mouseenter', function(){
            var $this = $(this);
            $this.addClass('smooth-rotation');
            setTimeout(function(){
                $this.removeClass('smooth-rotation')
            },350)
        })
        $(this).on('mousemove', function(event){
            var rotateY = ((-event.pageX+halfWidth)/halfWidth)*rotationLimit,
                rotateX = ((event.pageY-halfHeight)/halfHeight)*rotationLimit,
                bodyScrollLeft = $('body').get(0).scrollLeft,
                offsets = $(this).get(0).getBoundingClientRect(),
                offsetX = 0.52 - (event.pageX - offsets.left - bodyScrollLeft) / $(window).width();
            rotateY = rotateY > rotationLimit ? rotationLimit : rotateY;
            rotateY = rotateY < -rotationLimit ? -rotationLimit : rotateY;
            rotateX = rotateX > rotationLimit ? rotationLimit : rotateX;
            rotateX = rotateX < -rotationLimit ? -rotationLimit : rotateX;
            $(this).css({'transform': 'perspective(2000px) rotateX(0deg) rotateY(' + rotateY + 'deg' + ') translateX(' + offsetX * -10 + 'px) translateZ(0px)'});
        })
        $(this).on('mouseleave', function(){
            var $this = $(this);
            $this.addClass('smooth-rotation');
            $this.css({'transform': 'rotateX(0deg) rotateY(0deg) translateZ(0px)'});
            setTimeout(function(){
                $this.removeClass('smooth-rotation')
            },350)
        })
    })
}

function pixflow_clientNormal(){
    'use strict';

    var
        clientNormalHeight    = $('.client-normal').height(),
        movementStrengthBg    = 200,
        widthBg               = movementStrengthBg    / $(window).width(),
        $clientNormal         = $('.client-normal');

    $clientNormal.find('.content').height(clientNormalHeight);

    $clientNormal.each(function() {
        var $this = $(this);
        $this.mousemove(function (e) {
            var pageX = e.pageX - $this.offset().left,
                newvalueBg = widthBg * pageX * -1 - 100;
            $this.css({"background-position": newvalueBg + "px 50%"});
        });
    });
}

function pixflow_calendarBlog(obj, count){
    'use strict';

    var $id = $('.'+obj),
        $blogTitle      = $id.find('.blog-title'),
        $blogContainer  = $id.find('.blog-container'),
        $blogOverlay    = $id.find('.blog-overlay'),
        $blogDay        = $id.find('.blog-day'),
        $blogMonth      = $id.find('.blog-month'),
        $blogYear       = $id.find('.blog-year'),
        widthBlog       = 0,
        movementStrength= 15,
        height          = movementStrength / $(window).height(),
        width           = movementStrength / $(window).width(),
        widthContainer, wheeling ;

    $blogContainer.css({'width': '20%'});

    widthBlog = $id.parent().width();
    widthContainer = widthBlog * 20 / 100;

    if (widthContainer < 300) {
        $blogDay.css('font-size', '45px');
        $blogMonth.css('font-size', '10px');
        $blogYear.css('font-size', '10px');
        $blogYear.css('font-size', '10px');
        $blogTitle.css('font-size', '15px');
    } else {
        $blogDay.css('font-size', '48px');
        $blogMonth.css('font-size', '13px');
        $blogYear.css('font-size', '13px');
        $blogTitle.css('font-size', '18px');
    }
    if (widthBlog < 1360) {
        $blogDay.css('font-size', '48px');
        $blogMonth.css('font-size', '13px');
        $blogYear.css('font-size', '13px');
        $blogTitle.css('font-size', '18px');
        if(widthBlog <= 480){
            //Blog calendar
            $blogContainer.css('width','100%');
        }else if(widthBlog <= 991){
            $blogContainer.css('width','50%');
        }else if(widthBlog <= 1199) {
            $blogContainer.css('width','25%');
        }else{
            $blogContainer.css('width','20%');
        }
    }
    if ($id[0] != undefined) {
        $id[0].onmousemove = function (e) {
            var pageX = e.clientX - ($(window).width() / 2);
            var pageY = e.clientY - ($(window).height() / 2);
            var newvalueX = width * pageX-10;
            var newvalueY = height * pageY-10;
            $id.css("background-position", newvalueX + "px     " + newvalueY + "px");
        }
    }

    $('body').on('mousewheel', function () {
        if ($id[0] != undefined) {
            $id[0].onmousemove = function (e) {
                return false;
            }
            clearTimeout(wheeling);
            wheeling = setTimeout(function () {
                $id[0].onmousemove = function (e) {
                    var pageX = e.clientX - ($(window).width() / 2);
                    var pageY = e.clientY - ($(window).height() / 2);
                    var newvalueX = width * pageX-10;
                    var newvalueY = height * pageY-10;
                    $id.css("background-position", newvalueX + "px     " + newvalueY + "px");
                }
            }, 100);
        }
    });
    if($(window).width() < 1025){
        $blogContainer.click(function(){
            if(!$(this).hasClass('hovered')){
                $(this).addClass('hovered');
                return false;
            }
        });
        $blogContainer.blur(function(){
            $(this).removeClass('hovered');
        })
    }
}

var paginationCounter;

function pixflow_findPaginationOffsets($postPagination ){
    'use strict';

    var thisOffset = [];

    $postPagination.children().each( function(){
        thisOffset[paginationCounter] = $(this).offset();
        paginationCounter++;
    });

    return thisOffset;
}

function pixflow_subscribe(){
    "use strict";

    $('.sc-subscribe').on('submit','.send',function(e){
        e.preventDefault();
        var $this = $(this),
            $form = $this.closest('.sc-subscribe').find('.mc4wp-form'),
            $textbox = $form.find('[type=email]'),
            index = $('.sc-subscribe').index($this.parent()),
            interval = null;
        $textbox.val($this.find('.subscribe-textbox').val());
        if(!$form.length){
            $this.find('.subscribe-err').css('color',$this.find('.errorcolor').val()).html(themeOptionValues.mailchimpNotInstalled);
            return false;
        }
        $.ajax({
            method: "POST",
            url: window.location.href.split('?')[0],
            data: $form.serialize(),
            beforeSend : function(){
                $this.find('.subscribe-button').addClass('subscribe-button-animation');

                var bg = $this.find('.subscribe-button').css('background-color');
                $this.find('.subscribe-textbox').css({border:''});
                $this.find('.subscribe-err').html('');
            }
        }).done(function( msg ) {
            var $id = $(msg).find('.sc-subscribe:eq('+ index +')');
            $this.find('.subscribe-button').removeClass('subscribe-button-animation');

            if($id.find('.mc4wp-error').length || $id.find('.mc4wp-alert').length){
                var text = $id.find('.mc4wp-error').length ? $id.find('.mc4wp-error').text() : $id.find('.mc4wp-alert').text();
                $this.find('.subscribe-err').css('color',$this.find('.errorcolor').val()).html(text);
                $this.find('.subscribe-textbox').css({border:'1px solid '+$this.find('.errorcolor').val()});
            }else if($id.find('.mc4wp-success').length){
                $this.find('.subscribe-err').css('color',$this.find('.successcolor').val()).html($id.find('.mc4wp-success').text());
            }
        });
        return false;
    });


    $('.modern-subscribe').on('submit','.send',function(e){
        e.preventDefault();
        var $this = $(this),
            $form = $this.closest('.modern-subscribe').find('.mc4wp-form'),
            $email = $form.find('[type=email]'),
            $name = $form.find('[name="FNAME"]'),
            index = $('.modern-subscribe').index($this.parent()),
            interval = null;
        $email.val($this.find('.email-input').val());
        $name.val($this.find('.name-input').val());
        if(!$form.length){
            $this.find('.subscribe-err').css('color','#FF6A6A').html(themeOptionValues.mailchimpNotInstalled);
            return false;
        }
        $.ajax({
            method: "POST",
            url: window.location.href.split('?')[0],
            data: $form.serialize(),
            beforeSend : function(){
                $this.find('.subscribe-err').html('');
            }
        }).done(function( msg ) {
            var $id = $(msg).find('.modern-subscribe:eq('+ index +')');
            if($id.find('.mc4wp-error').length || $id.find('.mc4wp-alert').length){
                var text = $id.find('.mc4wp-error').length ? $id.find('.mc4wp-error').text() : $id.find('.mc4wp-alert').text();
                $this.find('.subscribe-err').css('color','#FF6A6A').html(text);
                $this.find('.name-input,.email-input').css({borderBottom:'1px solid #FF6A6A'});
            }else if($id.find('.mc4wp-success').length){
                $this.find('.subscribe-err').css('color','#74c374').html($id.find('.mc4wp-success').text());
            }
        });
        return false;
    });
}

function pixflow_blogPage() {
    "use strict";

    if($('.loop-post-content').length < 1 && $('.single-post-media').length <1 ) {
        return;
    }

    if( $('.flexslider').length >= 1 ) {
        $('.flexslider').flexslider({
            directionNav: "true"
        });
        $('.flex-nav-prev .flex-prev').html('');
        $('.flex-nav-next .flex-next').html('');
    }

    $('body:not(.blog) .loop-post-content').each(function(){
        if($(this).find('.more-link').length >= 1){
            $(this).find('.post-share').css({'margin':'-63px 45px 0 0'});
            $(this).find('.post-comment-holder').css({'margin':'-63px 0 0 0'});
        }
    });

    var $sidebar=$('.sidebar');
    if($('.sidebar').length >= 1){
        if($sidebar.attr('widgetid')=='main-sidebar') {
            $('#content .posts').css('width', '97.5%');
        }else if($sidebar.attr('widgetid')=='post-sidebar') {
            $('#content .post').css('width', '97.5%');
        }
    }

    $('body').on('click','.no-prev-page, .no-next-page',function(e){
        e.preventDefault();
        return false;
    })
}

function pixflow_wooCommerce() {
    "use strict";

    if ( $('.woocommerce-account').length && $(window).width() < 991 ){
        $('.woocommerce').addClass('container').find('.edit.changed-target').attr('target', '_self');
        $('main').css('height',$(window).height());
        $('main .content').css("cssText","position: relative;top: 50%;transform: translateY(-50%);-webkit-filter:blur(0);");
    }

    var num = 0 ;
    $('.notification-center ul.cart_list li.mini_cart_item').each(function(){
        var a =  $(this).find('.quantity').contents()[0].textContent;
        num += parseInt(a);
    });

    if ($('header .icons-pack .shopcart-item').length && num > 0 && !$('header .icons-pack .shopcart-item .number').length ){
        $('header .icons-pack .shopcart-item .icon').append('<i class="number">'+num+'</i>');
    }
    // Category Widget

    if ($('.widget_product_categories').length) {
        $('.widget_product_categories .cat-parent > a').append('<span class="icon-caret-right"></span>');
    }

    // My Account Page
    var $errorMsgDestination, article, title,
        $errorMessage          = $('.woocommerce-error'),
        $confirmMessage        = $('.woocommerce-message'),
        $confirmMsgDestination = $('.woocommerce-message'),
        $wooAddress            = $('.woocommerce-edit-address'),
        $wooEditAccount        = $('.woocommerce-edit-account');

    if ($errorMessage.length){
        if ($("#customer_login").length) {
            $errorMessage.appendTo("#customer_login");
        }
        else if ($(".woocommerce-lost-password").length) {
            $errorMsgDestination = $(".woocommerce-lost-password .lost_reset_password .form-row .button").parents('.form-row');
            $errorMessage.appendTo($errorMsgDestination);
        }
        else if ($(".woocommerce-edit-account").length) {
            $errorMsgDestination = $('.woocommerce-edit-account .woocommerce form');
            $errorMessage.appendTo($errorMsgDestination);
        }
    }

    if ($confirmMessage.length){
        if ($(".woocommerce-lost-password").length) {
            $confirmMsgDestination = $(".woocommerce-lost-password .lost_reset_password .form-row .button").parents('.form-row');
            $confirmMessage.appendTo($confirmMsgDestination);
        }

        if ($(".woocommerce-account.logged-in").length) {
            $confirmMsgDestination = $(".woocommerce-account.logged-in .woocommerce .right-col").parents('.woocommerce ');
            $confirmMessage.appendTo($confirmMsgDestination);
        }
    }

    if ($wooAddress.length){
        title = $wooAddress.find('form h3').text();
        article = '<article class="account-title"> <h1>'+ title +'</h1> <h3></h3> </article>';
        $('.woocommerce').prepend(article);

        $errorMessage.appendTo('.woocommerce-edit-address form');
    }

    /* Tab settings for profile page */

    var $editAccountPass = $('.custom-edit-pass-account'),
        $editBilling     = $('.custom-edit-billing'),
        $editShipping    = $('.custom-edit-shipping'),
        $tabs = $('.woocommerce-account.logged-in .woocommerce .left-col .tabs');

    $tabs.click(function (e) {

        e.preventDefault();

        $tabs.removeClass('active');
        $(this).addClass('active');

        $editAccountPass.removeClass('active');
        $editBilling.removeClass('active');
        $editShipping.removeClass('active');

        $(this).addClass('active');

        // show hide tab content

        $editAccountPass.fadeOut(100);
        $editBilling.fadeOut(100);
        $editShipping.fadeOut(100);

        if ($(this).hasClass('account-pass') ) {

            $editShipping.stop(true, false).fadeOut(1);
            $editBilling.stop(true, false).fadeOut(1);

            $editAccountPass.delay(200).fadeIn(300);
        }
        else if ($(this).hasClass('billing-address') ) {

            $editAccountPass.stop(true, false).fadeOut(1);
            $editShipping.stop(true, false).fadeOut(1);

            $editBilling.delay(200).fadeIn(300);

        }
        else if ($(this).hasClass('shipping-address') ) {

            $editAccountPass.stop(true, false).fadeOut(1);
            $editAccountPass.stop(true, false).fadeOut(1);

            $editShipping.delay(200).fadeIn(300);
        }

    });

    //Shop Page responsive function
    if($(window).width() < 1025){
        $('.thumb-image').click(function(){
            if($(this).parent().siblings('.add_to_cart_button').css('bottom') == '-50px'){
                $(this).trigger('mouseenter');
                return false;
            }
        })
    }
}

// Slick slider carousel
function pixflow_slickSlider(id, slides, autoPlayOpt ){
    "use strict";
    var dotsOpt = true;

    if (typeof autoPlayOpt == 'undefined'){
        autoPlayOpt = false
        dotsOpt = false;
    }

    var $idTMSlick     = id.find('.slides'),
        $teamImg       = id.find('.teammember-image'),
        $teamImgHeight = ($(window).width() <= 768 )? 330 : ($idTMSlick.width() / slides) * 1,
        slickWidth = ($(window).width() <= 768 )? id.parents('.box_size_container').width() : id.parent().width();

    id.css('width',slickWidth);

    $teamImg.css('height', $teamImgHeight);

    if (slides == 1)
        $teamImg.css('width', '100%');

    if($idTMSlick.hasClass('slick-initialized')) {
        $idTMSlick.slick('unslick');
    }

    if(typeof $idTMSlick.slick == 'function') {
        $idTMSlick.slick({
            infinite : true,
            autoplay : autoPlayOpt,
            dots     : dotsOpt,
            slidesToShow  : slides,
            slidesToScroll: slides,
            speed: 1000,
            cssEase: 'ease',
            responsive: [
                {
                    breakpoint: 760,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    }

}


function pixflow_post_carousel()
{
    $('.your-element').on('beforeChange', function(event, slick, currentSlide, nextSlide){
        $('.post-wrap').hasClass(".slick-center").css({'opacity':'1'});
    });
}




function pixflow_teammemberCarousel($id ) {
    "use strict";

    if ( $id == 'resized' ){
        var $wrap = $('.wrap-teammember-style2,.wrap-client-carousel'),
            id  = '';
        $wrap.each(function(){
            id = $(this).attr('id');
            $idTM = $('#' + $(this).attr('id') );
            if (($idTM.parents('.vc_col-sm-12').length || $idTM.parents('.vc_layout_1').length) && $idTM.parents('.vc_col-sm-12').width() >=768 ){
                if (id.indexOf('team')>= 0)
                    pixflow_slickSlider($idTM, 3);
                else{
                    var autoplay = ( $(this).attr('data-autoplay') == 'no') ? false : true,
                        slide = parseInt( $(this).attr('data-slide-item'));

                    pixflow_slickSlider($idTM, slide,autoplay);
                }
            }
            else if ($idTM.parents('.vc_col-sm-10').length && $idTM.parents('.vc_col-sm-10').width() >=768) {

                if (id.indexOf('team')>=0)
                    pixflow_slickSlider($idTM, 3);
                else {
                    var autoplay = ( $(this).attr('data-autoplay') == 'no') ? false : true,
                        slide = parseInt( $(this).attr('data-slide-item'));

                    pixflow_slickSlider($idTM, slide,autoplay);
                }
            }
            else if ($idTM.parents('.vc_col-sm-9').length && $idTM.parents('.vc_col-sm-9').width() >=768) {

                if (id.indexOf('team')>=0)
                    pixflow_slickSlider($idTM, 3);
                else {
                    var autoplay = ( $(this).attr('data-autoplay') == 'no') ? false : true,
                        slide = parseInt( $(this).attr('data-slide-item'));

                    pixflow_slickSlider($idTM, slide,autoplay);
                }
            }
            else if ($idTM.parents('.vc_col-sm-8').length && $idTM.parents('.vc_col-sm-9').width() >=768) {

                if (id.indexOf('team')>=0)
                    pixflow_slickSlider($idTM, 3);
                else {
                    var autoplay = ( $(this).attr('data-autoplay') == 'no') ? false : true,
                        slide = parseInt( $(this).attr('data-slide-item'));

                    pixflow_slickSlider($idTM, slide,autoplay);
                }
            }
            else if ($idTM.parents('.vc_col-sm-6').length || $(window).width() <=768) {
                if (id.indexOf('team')>=0)
                    pixflow_slickSlider($idTM, 2);
                else {
                    var autoplay = ( $(this).attr('data-autoplay') == 'no') ? false : true,
                        slide = parseInt( $(this).attr('data-slide-item'));

                    pixflow_slickSlider($idTM, slide,autoplay);
                }

            }
            else if ($idTM.parents('.vc_col-sm-4').length || $idTM.parents('.vc_layout_3').length) {
                if (id.indexOf('team')>=0)
                    pixflow_slickSlider($idTM, 1);
                else {
                    var autoplay = ( $(this).attr('data-autoplay') == 'no') ? false : true,
                        slide = parseInt( $(this).attr('data-slide-item'));

                    pixflow_slickSlider($idTM, slide,autoplay);
                }
            }
            else if ($idTM.parents('.vc_col-sm-3').length || $idTM.parents('.vc_layout_4').length) {
                if (id.indexOf('team')>=0)
                    pixflow_slickSlider($idTM, 1);
                else {
                    var autoplay = ( $(this).attr('data-autoplay') == 'no') ? false : true,
                        slide = parseInt( $(this).attr('data-slide-item'));

                    pixflow_slickSlider($idTM, slide,autoplay);
                }
            }
            else if ($idTM.parents('.vc_col-sm-2').length || $(window).width() <= 480) {
                pixflow_slickSlider($idTM, 1);
            }

        })
    }
    else if( $('.teammember-image').length || $('.client-logo').length ) {

        var $idTM = $('#' + $id);

        if (($idTM.parents('.vc_col-sm-12').length || $idTM.parents('.vc_layout_1').length) && $idTM.parents('.vc_col-sm-12').width() >=768 ){
            if ($id.indexOf('team')>=0)
                pixflow_slickSlider($idTM, 3);
            else {
                var autoplay = ( $idTM.attr('data-autoplay') == 'no') ? false : true,
                    slide =  $idTM.attr('data-slide-item');

                pixflow_slickSlider($idTM, slide, autoplay);
            }
        }
        else if ($idTM.parents('.vc_col-sm-10').length && $idTM.parents('.vc_col-sm-10').width() >=768) {
            if ($id.indexOf('team')>=0)
                pixflow_slickSlider($idTM, 3);
            else {
                var autoplay = ( $idTM.attr('data-autoplay') == 'no') ? false : true,
                    slide =  $idTM.attr('data-slide-item');

                pixflow_slickSlider($idTM, slide, autoplay);
            }
        }
        else if ($idTM.parents('.vc_col-sm-9').length && $idTM.parents('.vc_col-sm-9').width() >=768) {

            if ($id.indexOf('team')>=0)
                pixflow_slickSlider($idTM, 3);
            else {
                var autoplay = ( $idTM.attr('data-autoplay') == 'no') ? false : true,
                    slide =  $idTM.attr('data-slide-item');

                pixflow_slickSlider($idTM, slide, autoplay);
            }
        }
        else if ($idTM.parents('.vc_col-sm-8').length && $idTM.parents('.vc_col-sm-9').width() >=768) {
            if ($id.indexOf('team')>=0)
                pixflow_slickSlider($idTM, 3);
            else {
                var autoplay = ( $idTM.attr('data-autoplay') == 'no') ? false : true,
                    slide =  $idTM.attr('data-slide-item');

                pixflow_slickSlider($idTM, slide, autoplay);
            }
        }
        else if ($idTM.parents('.vc_col-sm-6').length || $(window).width() <=768) {
            if ($id.indexOf('team')>=0)
                pixflow_slickSlider($idTM, 2);
            else {
                var autoplay = ( $idTM.attr('data-autoplay') == 'no') ? false : true,
                    slide =  $idTM.attr('data-slide-item');

                pixflow_slickSlider($idTM, slide, autoplay);
            }
        }
        else if ($idTM.parents('.vc_col-sm-4').length || $idTM.parents('.vc_layout_3').length) {

            if ($id.indexOf('team')>=0)
                pixflow_slickSlider($idTM, 1);
            else {
                var autoplay = ( $idTM.attr('data-autoplay') == 'no') ? false : true,
                    slide =  $idTM.attr('data-slide-item');

                pixflow_slickSlider($idTM, slide, autoplay);
            }
        }
        else if ($idTM.parents('.vc_col-sm-3').length || $idTM.parents('.vc_layout_4').length) {

            if ($id.indexOf('team')>=0)
                pixflow_slickSlider($idTM, 1);
            else {
                var autoplay = ( $idTM.attr('data-autoplay') == 'no') ? false : true,
                    slide =  $idTM.attr('data-slide-item');

                pixflow_slickSlider($idTM, slide, autoplay);
            }
        }
        else if ($idTM.parents('.vc_col-sm-2').length || $(window).width() <= 480) {
            pixflow_slickSlider($idTM, 1);
        }

    }

}


function pixflow_Products(){
    "use strict";

    if(!$('.woocommerce'))
        return;

    var product = $('.products .product');

    product.each(function(){
        var $this    = $(this),
            itemURL  = $this.find('a:first-child').attr('href'),
            thumbImg = $this.find('.attachment-shop_catalog').attr('src'),
            hoverImg = $this.attr('data-img'),
            thumbHeight;
        if(typeof thumbImg == 'undefined'){
            return true;
        }
        if( $this.parents('.thumbnails-height').length){
            thumbHeight = $this.parents('.thumbnails-height').attr('data-thumbnail-height');
        } else{
            thumbHeight = 285;
        }

        if(hoverImg == ''){
            hoverImg = thumbImg;
        }

        $this.find('.title-link').attr('href',itemURL);
        $this.find('.add_to_cart_button').html('<span class="icon icon-shopcart"></span>');
        $this.find('.purchase-buttom-holder a:first-child img,.purchase-buttom-holder a:first-child .item-image').remove();
        $this.find('.purchase-buttom-holder a:first-child').append('<div class="thumb-image" style="background-image: url('+ thumbImg +')"></div>' +
            '<div class="hover-image" style="background-image: url('+ hoverImg +')"></div>');
        $this.find('.thumb-image,.hover-image').css({'height':thumbHeight});
    })
}

function pixflow_recentViewedWidget(){
    "use strict";

    var $productList=$('.widget_recently_viewed_products .product_list_widget li'),
        imgSrc,
        amountHtml,
        productTitle;

    if($productList.length <1 ) return;

    $productList.each(function(){

        imgSrc        = $(this).find('img').attr('src');
        amountHtml    = $(this).find('.amount').html();
        productTitle  = $(this).find('.product-title').html();

        $(this).find('img').remove();
        $(this).find('.amount').remove();
        $(this).find('.product-title').remove();
        $(this).find('del').remove();
        $(this).find('ins').remove();

        $(this).find('a').append('' +
            '<div class="product-list-widget-img" style="background-image: url('+imgSrc+')"></div>' +
            '<div class="overlay"></div>' +
            '<div class="product-details">' +
            '<span class="product-title">'+productTitle+'</span>' +
            '<br>' +
            '<span class="amount">'+amountHtml+'</span>' +
            '</div>');
    });
}

function pixflow_topRatedWidget(){
    "use strict";

    var $productList=$('.widget_top_rated_products .product_list_widget li'),
        imgSrc,
        amountHtml,
        productTitle,
        starRating;

    if($productList.length <1 ) return;

    $productList.each(function(){

        imgSrc        = $(this).find('img').attr('src');
        amountHtml    = $(this).find('.amount').html();
        productTitle  = $(this).find('.product-title').html();

        if($(this).find('.star-rating').length>=1)
            starRating    ='<div class="star-rating">'+$(this).find('.star-rating').html()+'</div>';
        else
            starRating = '';

        $(this).find('img').remove();
        $(this).find('.amount').remove();
        $(this).find('.product-title').remove();
        $(this).find('.star-rating').remove();

        $(this).find('a').append('' +
            '<div class="product-list-widget-img" style="background-image: url('+imgSrc+')"></div>' +
            '<div class="overlay"></div>' +
            '<div class="product-details">' +
            '<span class="product-title">'+productTitle+'</span>' +
            starRating +
            '<span class="amount">'+amountHtml+'</span>' +
            '</div>');
    });
}

function pixflow_recentPostWidget(){
    "use strict";

    if($('.widget.widget_recent_entries').length <1)
        return;

    var $str = $('.widget.widget_recent_entries ul li a'),
        str,
        subStr;

    $str.each(function() {
        str=$(this).html();

        if(str.length>30) subStr='...';
        else subStr='';

        $(this).html(str.substr(0, 30) + subStr);
    });

}

function pixflow_layeredNav(){
    "use strict";

    $('.dropdown_layered_nav_color option').css({'background-color':'rgba(255,255,255,0.9)'});
}

function pixflow_productCategory(){
    "use strict";
    if(!$('.product-categories').length){
        return;
    }
    $('.product-categories').each(function(){
        var $this = $(this),
            mainWidth = $this.width(),
            catwidth;
        catwidth = Math.floor(mainWidth/$this.attr('data-cols'));
        $this.find('.category').css({'width': catwidth });
    })

    $('.product-categories .category').each(function(){
        var $this = $(this),
            thumbHeight;
        thumbHeight = $this.parents('.product-categories').attr('data-thumbnail-height');
        $this.css({'height':thumbHeight});
    })
}

var clearTime;

function pixflow_notificationCenter(){
    "use strict";

    if ( ! $('.notification-center').length )
        return;

    var monthNames = [
        "Jan", "Feb", "Mar",
        "Apr", "May", "Jun", "Jul",
        "Aug", "Sep", "Oct",
        "Nov", "Dec"
        ],
        date = new Date(),
        day = date.getDate(),
        monthIndex = date.getMonth(),
        year = date.getFullYear(),
        hour = date.getHours(),
        minute = date.getMinutes(),
        ampm = hour > 12 ? "PM" : "AM";

    hour = hour % 12;
    hour = hour ? hour : 12; // zero = 12

    minute = minute > 9 ? minute : "0" + minute;
    hour = hour > 9 ? hour : "0" + hour;

    $('.notification-center .header .date').text(monthNames[monthIndex] + ',' +day + ',' + year);
    $('.notification-center .header .time').text(hour + ":" + minute + " " + ampm);

    function pixflow_liveTime() {
        'use strict';

        clearTime = setTimeout(function () {
            var date = new Date(),
                hour = date.getHours(),
                minute = date.getMinutes(),
                ampm = hour > 12 ? "PM" : "AM";
            hour = hour % 12;
            hour = hour ? hour : 12; // zero = 12

            minute = minute > 9 ? minute : "0" + minute;
            hour = hour > 9 ? hour : "0" + hour;
            $('.notification-center .header .time').html(hour + ":" + minute + " " + ampm);
            pixflow_liveTime();
        }, 20000);
    }

    $('header .icons-pack .elem-container').click(function(e){
        e.preventDefault();
        e.stopPropagation();

        if($('.notification-center').hasClass('close')){
            pixflow_liveTime();

                if ($(this).hasClass('shopcart')) {
                    $('.notification-center .pager a.shop').click();
                }
                else if ($(this).hasClass('search')) {
                    $('.notification-center .pager a.search').click();
                }
                else {
                    var newval;
                    if (pixflow_detectPosition() == 'front-end') {
                        newval = themeOptionValues.activeNotificationTab;
                    }else{
                        var elem = pixflow_customizerObj().$('#input_active_tab_sec')[0];
                        newval = $(elem).val();
                    }

                    $('.notification-center .pager a.' + newval).click();
                }


            $('.notification-center').removeClass('close').addClass('open');
            $('.layout-container').addClass('blur');
            $('.notification-center ').css({'z-index':'99999','opacity':1});
            $('.notification-center ').delay(250).animate({'height':'100%'},600,function(){});
            $('.notification-center .header,.notification-center #notification-tabs').animate({'opacity':1},200);
            $('.notification-center .notification-collapse').delay(1000).animate({'opacity':.5});
        }
        $('.notification-center .cart_list').niceScroll(
            {
                horizrailenabled: false,
                cursorcolor: "#ccc",
                cursorborder: "1px solid #ddd",
                cursorwidth: '2px',
                scrollspeed: 100,
                mousescrollstep: 80
            }
        );

    });

    $('header .icons-pack .elem-container').one("click", function () {
        $( window ).resize();
    });

    $('.tabs-container .tab-cell').css('height',$(window).height()-$('.tabs-container').offset().top-$('.notification-collapse-area').height());

    var $natificationTabs = $('.tabs-container').flickity({
        prevNextButtons: false,
        pageDots: false,
        draggable: false,
        selectedAttraction: 0.016,
        friction: 0.22,
        freeScroll: true,
        freeScrollFriction: 0.05
    });
    // Flickity instance
    var flkty = $natificationTabs.data('flickity');
// elements
    var $cellButtonGroup = $('.pager');
    var $cellButtons = $cellButtonGroup.find('.tab-item');
    var $tabs = $('.tabs-container');

// update selected cellButtons
    $natificationTabs.on( 'cellSelect', function() {
        $cellButtons.filter('.is-selected')
            .removeClass('is-selected');
        $cellButtons.eq( flkty.selectedIndex )
            .addClass('is-selected');

    });

// select cell on button click
    $cellButtonGroup.on( 'click', '.tab-item', function() {
        var index = $(this).index();
        var $tabItem = $tabs.find('.tab-cell');
        $tabItem.css({opacity:0.2});
        $tabItem.stop().animate({opacity:0},200);
        $natificationTabs.flickity( 'select', index );
        var selected = $tabs.find('.tab-cell.is-selected');
        selected.stop().animate({opacity:1},800);

    });

    var extra = 0;
    $('.notification-center div[id *= "opt"] > .clearfix').each(function(){
        var width = $(this).find('.tab-item,.mini_cart_item').length * $(this).find('.tab-item:first,.mini_cart_item:first').outerWidth(true);
        var count = Math.floor($(window).width()*90/100 / $(this).find('.tab-item:first,.mini_cart_item:first').outerWidth(true));
        var extra = $(window).width()*90/100 - count * $(this).find('.tab-item:first,.mini_cart_item:first').outerWidth(true);
        if(width > $(window).width()*90/100){
            $(this).find('.tab-item,.mini_cart_item').css('float','left');
            $(this).find('.absolute').css({'position':'absolute','width':$(window).width()*90/100 - extra});
            $(this).css({'width':$(window).width()*90/100 - extra});
        }else{
            $(this).css({'width':$(window).width()*90/100})
        }
    });

    $('.notification-center .tabs-container,.notification-center .notification-collapse,.notification-collapse-area').click(function(e){
        if( e.target != this){
            return;
        }
        $('.notification-center .notification-collapse').animate({opacity:0},200);
        $('.notification-center').removeClass('open').addClass('close');
        clearInterval(clearTime);
        $('.notification-center .header,.notification-center #notification-tabs').animate({'opacity':0},100);
        $('.notification-center ').animate({'height':'0'},600,function(){
            $('.notification-center ').css({'z-index':'-99','opacity':0});
        });
        $('.layout-container').removeClass('blur');
        $('.notification-tab .input-holder').css({'margin-top':'200px'});
        $('.notification-tab #search-input').val("");
        $('.notification-tab #result-container').html("");

    });

    $('.notification-center ul li a,.notification-center #notification-tabs').click(function(event){
        event.stopPropagation();
    });

    var height =  $(window).height() - $('.notification-center .header').outerHeight(true)-$('.notification-center .pager').outerHeight(true)-100/*collaps btn */;

    $('.notification-center .protfolio-tab .portfolio,.notification-center .posts-tab .posts').css({maxHeight:height+'px'});

    var width = 100,
        windowWidth = $(window).width()-100;

    if ($('.notification-center  .protfolio-tab .portfolio ').length ){

        if ( windowWidth > 240*5 ){
            width = 240*5;
        }else{
            var num = windowWidth / 240;
            width = num*240;
        }

        $('.notification-center .portfolio').css({width:width+'px'});

        $('.notification-center .protfolio-tab .portfolio').css({maxHeight:height+'px'});
        $('.notification-center .protfolio-tab .portfolio').niceScroll({
            horizrailenabled: false,
            cursorcolor: "#ccc",
            cursorborder: "1px solid #ddd",
            cursorwidth: '2px',
            scrollspeed: 100,
            mousescrollstep: 80
        });

    }

    if($('.notification-center .posts-tab .posts').length ){

        $('.notification-center .posts-tab .posts').css({maxHeight:height+'px'});
        $('.notification-center .posts-tab .posts').niceScroll({
            horizrailenabled: false,
            cursorcolor: "#ccc",
            cursorborder: "1px solid #ddd",
            cursorwidth: '2px',
            scrollspeed: 100,
            mousescrollstep: 80
        });
    }

    if($('#result-container').length){
        var height = $(window).height() - $('.notification-center .header').outerHeight(true)-$('.notification-center .pager').outerHeight(true)-$('.input-holder').outerHeight(true)-$('.search-title').outerHeight(true);
        $('#result-container').css({maxHeight:height+'px'});
        $('#result-container').niceScroll({
            horizrailenabled: false,
            cursorcolor: "#ccc",
            cursorborder: "1px solid #ddd",
            cursorwidth: '2px',
            scrollspeed: 100,
            mousescrollstep: 80
        });
    }

}

function pixflow_sidebarWidgets() {
    "use strict";

    var $widgets = $('.sidebar > .widget');

    if ($widgets.length) {
        $widgets.addClass('clearfix');
    }
}

function pixflow_ajaxSearch(){
    'use strict';

    if(!$("#search-input").length){
        return;
    }

    var timeOut = null;

    $("#search-input").keyup(function () {

        var $input = $(this),
            query = $input.val(),
            $content = jQuery('#result-container');

        clearTimeout(timeOut);
        if( query == ''){
            $content.fadeOut();
            return;
        }
        
        timeOut = setTimeout(function(){
            jQuery.ajax({
                type: 'post',
                url: ajax_var.url,
                data: {
                    action: 'pixflow_load_search_results',
                    query: query
                },
                beforeSend: function () {
                    $input.siblings('.clear-button').addClass('searching');
                    $content.fadeOut();
                },
                success: function (response) {
                    $input.siblings('.clear-button').removeClass('searching');
                    if($content.html() == ""){
                        TweenMax.to($input.parent(),.5,{'margin-top':'0',onComplete: function(){
                            $content.html(response);

                            $content.fadeIn('slow');
                            TweenMax.staggerFromTo($content.find('.item'),0.5,{opacity:'0'},{opacity:'1'},.1);
                        }});
                    } else{
                        $content.html(response);

                        $content.fadeIn('slow');
                        TweenMax.staggerFromTo($content.find('.item'),0.5,{opacity:'0'},{opacity:'1'},.1);
                    }
                    if(pixflow_detectPosition() != 'front-end') {
                        setTimeout(function () {
                            $('#result-container a').click(function (e) {
                                e.preventDefault();
                                if ($(this).attr('href') == '#' || $(this).attr('href') == '' || $(this).attr('href') == undefined)return;
                                window.top.pixflow_customizerLoading();
                                window.top.wp.customize.previewer.previewUrl($(this).attr('href'));
                            })
                        }, 550)
                    }
                }
            });
        },1000);


        return false;
    });

    $('#notification-tabs .clear-button').click(function(){
        $(this).siblings('#search-input').val("").focus();
    });
}
var enteredResponsive = false;
function pixflow_responsive() {
    'use strict';

    var width = $(window).width(),
        mainWidth = $('main').attr('style'),
        footerWidth = $('footer').attr('style'),
        headerWidth = $('header').attr('style'),
        exp = new RegExp(/.*?(width)(:)( )?(\d+)(%)/i),
        mainResult = exp.exec(mainWidth),
        footerResult = exp.exec(footerWidth),
        headrResult = exp.exec(headerWidth);


    $(".skill-style1").each(function(){
        pixflow_skill_style1 ($(this));
    });

    function pixflow_portfolioWidget(){
        'use strict';
        //portfolio widget in footer
        var count = 1;
        $('footer .widget-md-recent-portfolio .item').each(function(){
            if( count > 6 ){
                $(this).css({display:'none'})
            }
            count++;
        });
    }

    //Tablet and Phone
    if(width < 1279){

        $('.md-text-title').each(function(){
            if(parseInt($(this).css('font-size')) > parseInt($(this).css('line-height'))){
                $(this).css('line-height',$(this).css('font-size'));
            }
            if(parseInt($(this).css('font-size')) > 50){
                $(this).css({'font-size':'50px','line-height':'56px'});
            }
        });

        //Fixing tab width issue
        $('div[class^="md_tabs"],div[class*=" md_tabs"]').each(function(){

            var $obj =$(this).parents('div[class*="vc_col"]'),
            objClass = $obj.attr('class');
            objClass = objClass.substr(objClass.indexOf('-sm')+4, objClass.length);

            var colWidth = parseInt(objClass);
            colWidth =  colWidth / 12 ;
            colWidth = width/colWidth ;

            $(this).css('max-width',colWidth);
        })

        $('div[class^="vc_custom"],div[class*=" vc_custo"]').each(function(){
            var padding="",
                leftPadding,rightPadding;
            if(parseInt($(this).css('padding-left'))>10){
                leftPadding = parseInt($(this).css('padding-left'));
                padding = 'padding-left: 3%!important;';
            }

            if(parseInt($(this).css('padding-right'))>10){
                rightPadding = parseInt($(this).css('padding-right'));
                padding += 'padding-right: 3%!important;';
            }

            if (padding != ""){
                $(this).attr('data-normal-padding-right',rightPadding);
                $(this).attr('data-normal-padding-left',leftPadding);
                $(this).attr('style',padding);
            }
        });

        if (width < 768){
            $('.md-text').each(function(){
                var $title  = $(this).find('.md-text-title'),
                    $desc = $(this).find('.md-text-content');
                if(parseInt($title.css('font-size')) > 35){
                    $title.css({'font-size':'35px','line-height':'40px',height:'auto'});
                }
                if(parseInt($title.css('font-size')) > parseInt($title.css('line-height'))){
                    $title.css('line-height','auto');
                }

                if(parseInt($desc.css('font-size')) > 20){
                    $desc.css({'font-size':'20px','line-height':'30px'});
                }
                if(parseInt($desc.css('font-size')) > parseInt($desc.css('line-height'))){
                    $desc.css('line-height',$desc.css('font-size'));
                }
            });
        }

        pixflow_portfolioWidget();

        //main and footer width
        if (mainResult != null ){
            mainWidth = parseInt(mainResult[4]);
        }

        if ( footerResult != null ){
            footerWidth = parseInt(footerResult[4]);
        }

        if (mainWidth < 94){
            $('main').css('width','94%');

            if(footerWidth < 94){
                $('footer').css('width','94%');
            }

        }

    }

    if(width <= 1280){

        //flag for resizing back to desktop
        enteredResponsive = true;

        //disable animation on tablet and phone
        $('.has-animation').removeClass('has-animation');

        if ($('.widget-area .widget-area-column').length ){
            var maxHeight = 0;


            $('.widget-area .widget-area-column').each(function(){
                if ( maxHeight < $(this).find('.wrapContent').outerHeight(true)){
                    maxHeight = $(this).find('.wrapContent').outerHeight(true)+60;
                }
            });
            $('.widget-area .widget-area-column').css({height:maxHeight});
        }
        if(pixflow_isTouchDevice() == true ){
            $('.portfolio-nav').css("cssText", "width: 100% !important;");
        }
    }

    //Laptop
    if (width <= 1440 && width > 1280){

        //flag for resizing back to desktop
        enteredResponsive = true;

        //increasing layout size
        var boxSize = $('.sectionOverlay .box_size_container, .sectionOverlay.box_size');
        boxSize.each(function(){
            var wrapWidth = parseInt($(this).css('width'))/$('main').width()*100;
            if( wrapWidth < 90){
                $(this).css('width','90%');
            }
        });

        //Widget area
        var widgetArea = parseInt($('footer .widget-area').css('width'))/$('footer').width()*100;
        if( widgetArea < 100 ){
            $('footer .widget-area').css('width','100%');
        }

        //Single blog width
        var layout = parseInt($('.layout').css('width'))/$('body').width()*100;
        if( layout < 88 ){
            $('.layout').css('width','88%');
        }

        //Changing Typographies
        $('.md-text-title').each(function(){

            if(parseInt($(this).css('font-size')) > parseInt($(this).css('line-height'))){
                $(this).css('line-height',$(this).css('font-size'));
            }
            if(parseInt($(this).css('font-size')) > 85){
                if($(this).find('.texts').length){

                } else{
                    $(this).css({'font-size':'85px','line-height':'85px'});
                }
            }
        });

        pixflow_portfolioWidget();

        //main width
        if (mainResult != null ){
            mainWidth = parseInt(mainResult[4]);
        }

        if ( footerResult != null ){
            footerWidth = parseInt(footerResult[4]);
        }

        if ( headrResult != null ){
            headerWidth = parseInt(footerResult[4]);
        }

        if (mainWidth < 75){
            $('main').attr('data-normal-main-width',mainWidth).css('width','75%');

            if(footerWidth < 75){
                $('footer').attr('data-normal-footer-width',footerWidth).css('width','75%');
            }

            if (headerWidth < 75 ){
                $('header').attr('data-normal-header-width',headerWidth).css('width','75%');
            }
             if ( ! $('.business').hasClass('business-off')) {
                 $('.business').css('width','75%');
             }

        }else if (mainWidth > 75 && mainWidth < 90){
            $('main').attr('data-normal-main-width',mainWidth).css('width','90%');

            if(footerWidth > 75 && footerWidth < 90){
                $('footer').attr('data-normal-footer-width',footerWidth).css('width','90%');
            }
        }

        //Reducing extra padding space
        $('.vc_column_container').each(function(){
            if( parseInt($(this).css('padding-left')) > 30 ){
                $(this).css("cssText", "padding-left: 30px !important;");
            }
            if( parseInt($(this).css('padding-right')) > 30 ){
                $(this).css("cssText", "padding-right: 30px !important;");
            }
        })

        //Side header responsive
        if($('header').hasClass('side-classic')){
            var headerWidthClassic = parseInt($('header').css('width'))/$('.layout').width()*100;
            if(headerWidthClassic < 15){
                $('header').css('width','15%');
                $('.layout > .wrap').css({'width':'85%','margin-left':'15%'});
                //assigning new width for portfolio detail navigation
                $('.portfolio-nav').css("cssText", "width: 85% !important;");
            }
        }

        //Masonry Blog Responsive
        $('[id^=blog-masonry]').each(function(){
            if($(this).width() < 830){
                $(this).find('.blog-masonry-container').css('width','calc(100% / 2 - 30px)');
            }
        });
    }

    //Desktop
    if(width > 1440){
        if( enteredResponsive == true){

            $('main').css('width',$('main').attr('data-normal-main-width')+'%');
            $('footer').css('width',$('footer').attr('data-normal-footer-width')+'%');
            $('header').css('width',$('header').attr('data-normal-header-width')+'%');

            $('div[class^="vc_custom"],div[class*=" vc_custo"]').each(function(){
                var padding="",
                    leftPadding,rightPadding;

                    padding = 'padding-left:'+ $(this).attr('data-normal-padding-left')+'% !important;';
                    padding += 'padding-right:'+ $(this).attr('data-normal-padding-right')+'% !important;';


                if (padding != ""){
                    $(this).attr('style',padding);
                }
            });
        }
    }

    //Laptop and Desktop
    if(width > 1280){
        $('div[class^="md_tabs"],div[class*=" md_tabs"]').each(function(){

            $(this).css('max-width','none');
        })
    }

    //Phone
    if( width <= 800) {
        // imageBoxSlider
        $('.img-box-slider .slides').css({ 'max-height': $(window).height() });

        $('.img-box-slider').find('.slides > li').each(function(){

                var imgw=$(this).find('.imgBox-image').attr('data-width');
				var imgh=$(this).find('.imgBox-image').attr('data-height');

				if((imgw<400) || (imgh<400))
				{
					$(this).find('.imgBox-image').attr('style','background-size:auto !important');
				}

		});

        if (width >= 768){
            $('.pixflow-price-table').each(function(){
                var col = $(this).parents('.vc_column_container').attr('class');

                var re7='((?:[a-z][a-z]+))';	// Word 1
                var re8='(-)';	// Any Single Character 2
                var re9='(\\d+)';	// Integer Number 1

                var p = new RegExp(re7+re8+re9,["i"]);
                var m = p.exec(col);
                if (m != null)
                {
                    col = parseInt(m[3]);
                }

                if (col > 2 ){
                    $(this).parents('.vc_column_container').addClass('responsive-col-50');
                }
            })
        }
    }



    //calling functions
    pixflow_instagramShortcode();
    pixflow_musicFitSizes();
    pixflow_productCategory();
    pixflow_rowParallax();
    pixflow_shortcodeScrollAnimation();
    pixflow_calendarBlog('calendar-blog');
    pixflow_processSteps();

    $('.vc_row').each(function(){
        if( $(this) > $(window).width() ){
            $(this).css('width',$(window).width())
        }
    });

}

function pixflow_osDetect(){
    "use strict";
    var OSName="Unknown OS";
    if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
    if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
    if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
    if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";

    return OSName;
}

function pixflow_browserDetect(){
    "use strict";
    var nVer = navigator.appVersion;
    var nAgt = navigator.userAgent;
    var browserName  = navigator.appName;
    var fullVersion  = ''+parseFloat(navigator.appVersion);
    var majorVersion = parseInt(navigator.appVersion,10);
    var nameOffset,verOffset,ix;

// In Opera, the true version is after "Opera" or after "Version"
    if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
        browserName = "Opera";
        fullVersion = nAgt.substring(verOffset+6);
        if ((verOffset=nAgt.indexOf("Version"))!=-1)
            fullVersion = nAgt.substring(verOffset+8);
    }
// In MSIE, the true version is after "MSIE" in userAgent
    else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
        browserName = "Microsoft Internet Explorer";
        fullVersion = nAgt.substring(verOffset+5);
    }
// In Chrome, the true version is after "Chrome"
    else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
        browserName = "Chrome";
        fullVersion = nAgt.substring(verOffset+7);
    }
// In Safari, the true version is after "Safari" or after "Version"
    else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
        browserName = "Safari";
        fullVersion = nAgt.substring(verOffset+7);
        if ((verOffset=nAgt.indexOf("Version"))!=-1)
            fullVersion = nAgt.substring(verOffset+8);
    }
// In Firefox, the true version is after "Firefox"
    else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
        browserName = "Firefox";
        fullVersion = nAgt.substring(verOffset+8);
    }
// In most other browsers, "name/version" is at the end of userAgent
    else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) <
        (verOffset=nAgt.lastIndexOf('/')) )
    {
        browserName = nAgt.substring(nameOffset,verOffset);
        fullVersion = nAgt.substring(verOffset+1);
        if (browserName.toLowerCase()==browserName.toUpperCase()) {
            browserName = navigator.appName;
        }
    }
// trim the fullVersion string at semicolon/space if present
    if ((ix=fullVersion.indexOf(";"))!=-1)
        fullVersion=fullVersion.substring(0,ix);
    if ((ix=fullVersion.indexOf(" "))!=-1)
        fullVersion=fullVersion.substring(0,ix);

    majorVersion = parseInt(''+fullVersion,10);
    if (isNaN(majorVersion)) {
        fullVersion  = ''+parseFloat(navigator.appVersion);
        majorVersion = parseInt(navigator.appVersion,10);
    }

    return browserName;
}

function pixflow_blogMasonry(id) {
    'use strict';

    var $elem = (typeof id == 'undefind' ) ? $('.masonry-blog') : $('.'+id),
        $elem2 =  $('#'+$('.masonry-blog').attr('id') );

    if (id == 'edit-customizer') {

        $('.masonry-blog').isotope({
            // options
            itemSelector: '.blog-masonry-container',
            layoutMode: 'masonry',
            transitionDuration: '0.9s'
        });
    }

    if ( !$elem.length )
        return;

    if($elem.find('.flexslider').length>= 1) {

        $elem.find('.flexslider').each(function(){
            $(this).flexslider({
                directionNav: "true"
            });
        });

        $('.flex-nav-prev .flex-prev').html('');
        $('.flex-nav-next .flex-next').html('');
    }

    $elem.find('.blog-masonry-container').each(function() {
        if($(this).find('.post-like-holder').length>=1){
            if($(this).find('.like-count').html()=='already0' || $(this).find('.like-count').html()=='&nbsp;'){
                $(this).find('.like-count').html('0');
            }
        }
    });

    $elem.isotope({
        // options
        itemSelector:'.blog-masonry-container',
        layoutMode: 'masonry',
        transitionDuration: '0.9s'
    });

    setTimeout(function(){
        $elem.isotope('layout');
    },100);
    $(window).load(function(){
        $elem.isotope('layout');
    });

}

function pixflow_showSecondHeaderFull(selector) {
    "use strict";

    var $this  = $(selector),

        position   = $this.css('position'),
        opacity    = $this.css('opacity'),
        height     = $this.css('height'),
        top        = $this.css('top'),
        visibility = $this.css('visibility'),
        color = $this.find('.color-overlay').css('background-color');

    if( $('.header-style3').length ){
        if( ! $('.second-header-bg').length ) {

            $this.after('<div class="second-header-bg"></div>');
            $('.second-header-bg').css({width:$('.layout').width(),position:position,opacity:1,height:height,top:top,visibility:visibility,zIndex:999})
            var doIt;
            $(window).resize(function(){
                if(doIt){
                    clearTimeout(doIt);
                }
                doIt = setTimeout(function(){
                    $('.second-header-bg').css({width:$('.layout').width()});
                },150)

            })
        }
    }else if($('.header-style2').length ){

        $('.second-header-bg').remove();
        $this.after('<div class="second-header-bg"></div>');
        $('.second-header-bg').css({width:$(window).width(),position:position,opacity:1,height:height,top:top,visibility:visibility,zIndex:999})
        var doIt;
        $(window).resize(function(){
            if(doIt){
                clearTimeout(doIt);
            }
            doIt = setTimeout(function(){
                $('.second-header-bg').css({width:$(window).width()});
            },150);
        })
    }

}

function pixflow_calculateFixHeader(){
    'use strict';
    var siteWidth = parseInt($('.layout').css('width')),
        headerPercent = $('header').attr('data-width');

    headerPercent /= 100;
    headerWidth = siteWidth * headerPercent;
    $('header.header-style2').css({width:headerWidth+'px'});

}

function pixflow_mobileNavigation(){
    "use strict";

    var $doc          = $(document),
        $mobileNav = $('.navigation-mobile'),
        $mobileNavBtn = $('.navigation-button'),
        dontResize    = false;

    $mobileNavBtn.click(function(e){
        e.preventDefault();
        e.stopPropagation();

        if($mobileNav.is(":hidden")){
            $mobileNav.slideDown(300);
        } else{
            $mobileNav.slideUp(300);
        }
    });

    //Prevent resize event on IOS webkit browsers
    $doc.on('touchstart', function(e){
        var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0],
            $target = $(touch.target);

        if($target.is($mobileNav) || $target.parents('.navigation-mobile').length)
            dontResize = true;

    }).on('touchend', function(){
        setTimeout(function(){dontResize = false;}, 1000);
    });

    $mobileNav.click(function(e){
        e.stopPropagation();
    });

    $mobileNav.find('li').each(function(){
        if($(this).hasClass('has-dropdown')){
            $("<span class='arrow'><i class='icon-angle-down'></i></span>").insertAfter($(this).find('> a'));
        }
    });
    //Menu Click
    $mobileNav.find('.arrow').click(function(){
        if($(this).siblings('.dropdown').is(":hidden")){
            $(this).siblings('a').addClass('open');
            $(this).find('i').removeClass('icon-angle-down').addClass('icon-angle-up');
            $(this).siblings('.dropdown').slideDown(300);
        } else{
            $(this).siblings('a').removeClass('open');
            $(this).find('i').removeClass('icon-angle-up').addClass('icon-angle-down');
            $(this).siblings('.dropdown').slideUp(300);
        }
    });
    //Remove last borders
    if($mobileNav.find('li:last-child').hasClass('separator')){
        $mobileNav.find('li:nth-last-child(2)').css({'border':'none'});
    }

    //Dark / Light Logo
    if($(window).width() < 1281){
        if($('header').hasClass('logo-dark')){
            $('header').find('.logo img').attr('src',darkLogo);
        } else if($('header').hasClass('logo-light')){
            $('header').find('.logo img').attr('src',lightLogo);
        }
    }

}

function pixflow_mobileSidebar(){
    "use strict";
    var $sidebar =  $('.smart-sidebar'),
        $closeButton = $sidebar.find('.close-sidebar'),
        $wrap        = $('.layout > .wrap');

    $sidebar.width(313);
    $('.mobile-sidebar').click(function(){

        if($sidebar.hasClass('open')){
            $sidebar.removeClass('open');
            $wrap.removeClass('move');
        }else{
            $wrap.addClass('move');
            $sidebar.addClass('open');
        }
    });

    $closeButton.click(function(){
        if($sidebar.hasClass('open')){
            $sidebar.removeClass('open');
            $wrap.removeClass('move');
        }
    });

}

function pixflow_counterShortcode(id , flag){
    "use strict";

    if ($('.counter').length < 1 )
        return;

    $(id).find('.timer').css('opacity', '1');

    $.fn.countTo = function (options) {
        options = options || {};
        return $(this).each(function () {

            // set options for current element
            var settings = $.extend({}, $.fn.countTo.defaults, {
                from:            $(this).data('from'),
                to:              $(this).data('to'),
                speed:           $(this).data('speed'),
                refreshInterval: $(this).data('refresh-interval'),
                decimals:        $(this).data('decimals')
            }, options),

                // how many times to update the value, and how much to increment the value on each update
                loops = Math.ceil(settings.speed / settings.refreshInterval),
                increment = (settings.to - settings.from) / loops,
                // references & variables that will change with each update

                self = this,
                $self = $(this),
                loopCount = 0,
                value = settings.from,
                data = $self.data('countTo') || {};

            $self.data('countTo', data);
            // if an existing interval can be found, clear it first
            if (data.interval) {
                clearInterval(data.interval);
            }

            data.interval = setInterval(updateTimer, settings.refreshInterval);
            // initialize the element with the starting value
            render(value);

            function updateTimer() {
                'use strict';
                value += increment;
                loopCount++;
                render(value);
                if (typeof(settings.onUpdate) == 'function') {
                    settings.onUpdate.call(self, value);
                }
                if (loopCount >= loops) {
                    // remove the interval
                    $self.removeData('countTo');
                    clearInterval(data.interval);
                    value = settings.to;
                    if (typeof(settings.onComplete) == 'function') {
                        settings.onComplete.call(self, value);
                    }
                }
            }

            function render(value) {
                'use strict';
                var formattedValue = settings.formatter.call(self, value, settings);
                $self.html(formattedValue);
            }

        });
    };

    $.fn.countTo.defaults = {
        from: 0,               // the number the element should start at
        to: 0,                 // the number the element should end at
        speed: 1000,           // how long it should take to count between the target numbers
        refreshInterval: 3,  // how often the element should be updated
        decimals: 0,           // the number of decimal places to show
        formatter: formatter,  // handler for formatting the value before rendering
        onUpdate: null,        // callback method for every time the element is updated
        onComplete: null       // callback method for when the element finishes updating
    };

    function formatter(value, settings) {
        'use strict';
        return value.toFixed(settings.decimals);
    }

    // custom formatting example
    $('.count-number').data('countToOptions', {
        formatter: function (value, options) {
            return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
        }
    });

    // start all the timers
    $(id).find('.timer').each(count);

    function count(options) {
        'use strict';
        var $this = $(this);
        options = $.extend({}, options || {}, $this.data('countToOptions') || {});
        $this.countTo(options);
    }

}

function pixflow_fitRowToHeight() {
    "use strict";
    var rowsInPage =  $('.vc_row').length;

    $('.vc_row').each(function () {
        var flag = false,
            $this = $(this),
            contentHeight =  $this.find('.wrap').addClass('clearfix').height();

        if ($this.hasClass('fit-to-height')) {
            if  ( contentHeight > $(window).height() && rowsInPage == 1)
                return;

                if ($(window).width() < 1281 && $this.find('> .wrap').css('height').replace(/[^-\d\.]/g, '') * 1 > $(window).height()) {
                    flag = true;
                } else {
                    $this.css({'height': $(window).height()});
                }

                if ($this.hasClass('vertical-aligned') && flag == false) {
                    $this.css({'padding-top': '0', 'padding-bottom': '0'});
                    $this.find('> .wrap').css({
                        'position': 'relative',
                        'top': '50%',
                        'transform': 'translateY(-50%)'
                    });
                }

        }
    })
}

function pixflow_onePageMenu(){
    "use strict";

    $("nav.navigation a,nav.navigation-mobile a").each(function(){
        var href = $(this).attr('href');
        if(href && href.search('#')!=-1) {
            $(this).click(function (e) {
                //e.preventDefault();
                $('html,body').scrollTo(this.hash, this.hash);
            });
        }
    })
}

function pixflow_businesBarEnable() {
    "use strict";

    if ( $('.business').length )
    {
        var headerTopPos = parseInt($('header').css('top'));

        if (headerTopPos <= 36) {
            $('.business ').css({top: '0'});
        }
        else
            $('.business ').css({top: (parseInt(headerTopPos) - 36) + 'px'});

        $('header:not(.top-modern)').css('margin-top', '0');

        if (headerTopPos > 36)
            headerTopPos = parseInt($('header').css('top')) - 36;

        if ( ! $('header.top-modern .business').hasClass('business-off') ) {
            $('header.top-modern').css('height', '100px');
            $('header.top-modern').css('position', 'absolute');
        }
    }

}

function pixflow_headerWidth(){
    'use strict';
    if( $('header.top-logotop').length || $('header.top-modern').length || $('header.side-modern').length || $('header.side-classic').length ){
        return;
    }

    // Refine header Top Block
    if($('header.top-block').length){
        var $header = $('header'),
            $menu = $header.find('.navigation'),
            $iconspack = $header.find('ul.icons-pack'),
            iconspackWidth = 0;
        if($iconspack.prev().hasClass('navigation')){
            $iconspack.find('>li.icon:visible:first').css('border-left','0');
        }else if($iconspack.next().hasClass('navigation')){
            $iconspack.find('>li.icon:visible:first').css('border-right','0');
        }
        $iconspack.find('li.icon:visible').each(function(){
            iconspackWidth = iconspackWidth + $(this).outerWidth(true);
        })
        var iconspackDiff = $iconspack.width() - iconspackWidth - 1;
        $iconspack.width(iconspackWidth);
        $menu.width($menu.width()+iconspackDiff);
        if(!$iconspack.next().hasClass('navigation') || !$iconspack.next().hasClass('logo')){
            $iconspack.find('li.icon:visible:last').css('border-right','0');
        }
    }

    //find biggest child
    function pixflow_findMax(){
        'use strict';
        var maxWidth = -1,
            $maxWidth;
        $('.top .logo,.top .navigation,.top .icons-pack').each(function() {
            if ($(this).width() > maxWidth){
                maxWidth = $(this).width();
                $maxWidth = $(this);
            }
        });
        return $maxWidth;
    }
    //find inner width
    function pixflow_childrensWidth($parent){
        'use strict';
        var oldWidth = $parent.width(),
            newWidth;
        if($parent.hasClass('logo')){
            newWidth = $parent.find('img').width();
        }else if($parent.hasClass('gather-btn')){
            newWidth = oldWidth;
        }else if($parent.hasClass('icons-pack') && $('header.top-block').length) {
            var $header = $('header'),
                $iconspack = $header.find('ul.icons-pack'),
                iconspackWidth = 0;
            $iconspack.find('>li.icon:visible').each(function(){
                iconspackWidth = iconspackWidth + $(this).outerWidth(true);
            })
            newWidth = iconspackWidth;
        }else if($parent.hasClass('icons-pack') && $('header.top-classic').length) {
            var totalWidth = 0;
            $parent.find('li.icon:visible').each(function(){
                totalWidth = totalWidth + $(this).outerWidth(true)+3;
            })
            newWidth = totalWidth;
        }else if($parent.hasClass('navigation') && $('header.top-classic').length) {
            var totalWidth = 0;
            $parent.find('> ul > *:visible').each(function(){
                totalWidth = totalWidth + $(this).outerWidth(true);
            })
            newWidth = totalWidth;
        }else{
            $parent.css('width','auto');
            newWidth = $parent.width();
            $parent.width(oldWidth);
        }
        return newWidth;
    }
    $('.top .logo,.top .navigation,.top .icons-pack').each(function() {
        var $this = $(this),
            itemWidth = $this.width(),
            realItemWidth = pixflow_childrensWidth($this),
            diff = Math.abs(realItemWidth - itemWidth)+1;
        if(realItemWidth > itemWidth){
            var $max = pixflow_findMax();
            if(($max.outerWidth(true) - diff) >= pixflow_childrensWidth($max)){
                $max.width($max.outerWidth(true)-diff);
                $this.width(realItemWidth);
            }
        }
    });
    function pixflow_calcWidth(w){
        'use strict';
        return (w*100)/$('header .content').width();
    }
    var total = pixflow_calcWidth($('.top .logo').width()) + pixflow_calcWidth($('.top .navigation').width()) + pixflow_calcWidth($('.top .icons-pack').width());
    if(total > 100){
        var $max = pixflow_findMax();
        var diff = total - 100;
        diff = (diff * $('header .content').width())/100;
        $max.width($max.width()-diff);
    }
}

function pixflow_portfolioPopup(){
    'use strict';

    $('body').on('click',".inside .item-wrap.portfolio-popup",function(e){
       var element=e.srcElement;

        if((e.which != 2)&&($(window).width()>1024))
        {
            if(element.attributes.class.nodeValue.indexOf('icon')<0)
            {
                $.magnificPopup.open({
                    items: {
                        src: $(this).find(".item-image").attr('data-src')
                    },
                    type: 'image',
                    closeOnContentClick: false,
                    closeBtnInside: false,
                    mainClass: 'mfp-with-zoom mfp-img-mobile',
                    callbacks: {
                        beforeOpen: function() {
                        },
                        afterClose: function() {
                            $("html").css({'overflow-y': 'auto'});
                        },
                    }
                }, 0);
            }
        }
    });
    $('body').on('click',".outside .item-image.portfolio-popup",function(){

        if(($(window).width()>1024))
        {
            $.magnificPopup.open({
                items: {
                    src: $(this).attr('data-src')
                },
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                callbacks: {
                    beforeOpen: function() {
                    },
                    afterClose: function() {
                        $("html").css({'overflow-y': 'auto'});
                    },
                }
            }, 0);
        }
    });

}

$.easyPieChart = function(el, options) {
    var  animateLine, drawLine, easeInOutQuad, rAF, renderBackground, renderScale, renderTrack,
        _this = this;
    this.el = el;

    this.$el = $(el);
    this.$el.data("easyPieChart", this);
    this.init = function() {
        var percent, scaleBy;
        _this.options = $.extend({}, $.easyPieChart.defaultOptions, options);

        percent = parseInt(_this.$el.data('percent'), 10);
        _this.percentage = 0;
        if(_this.$el.find('canvas').length) {
            _this.$el.find('canvas').remove();
        }
        _this.canvas = $("<canvas style='margin-top: -120px;' width='" + _this.options.size + "' height='" + _this.options.size + "'></canvas>").get(0);
        _this.$el.append(_this.canvas);
        if (typeof G_vmlCanvasManager !== "undefined" && G_vmlCanvasManager !== null) {
            G_vmlCanvasManager.initElement(_this.canvas);
        }
        _this.ctx = _this.canvas.getContext('2d');
        if (window.devicePixelRatio > 1) {
            scaleBy = window.devicePixelRatio;
            $(_this.canvas).css({
                width: _this.options.size,
                height: _this.options.size
            });
            _this.canvas.width *= scaleBy;
            _this.canvas.height *= scaleBy;
            _this.ctx.scale(scaleBy, scaleBy);
        }
        _this.ctx.translate(_this.options.size / 2, _this.options.size / 2);
        _this.ctx.rotate(_this.options.rotate * Math.PI / 180);
        _this.$el.addClass('easyPieChart');
        _this.update(percent);
        return _this;
    };
    this.update = function(percent) {
        percent = parseFloat(percent) || 0;
        if (_this.options.animate === false) {
            drawLine(percent);
        } else {
            animateLine(_this.percentage, percent);
        }
        return _this;
    };

    renderTrack = function() {
        var offset;
        offset = _this.options.size / 2 - _this.options.lineWidth / 2;
        if (_this.options.scaleColor !== false) {
            offset -= _this.options.size * 0.08;
        }
        _this.ctx.strokeStyle = _this.options.trackColor;
        _this.ctx.beginPath();
        _this.ctx.arc(0, 0, offset, 0, Math.PI * 2, true);
        _this.ctx.closePath();
        _this.ctx.lineWidth = _this.options.lineWidth;
        _this.ctx.stroke();
    };

    renderBackground = function() {

        if (_this.options.trackColor !== false) {
            renderTrack();
        }
    };
    drawLine = function(percent) {
        var offset;
        renderBackground();
        _this.ctx.strokeStyle = $.isFunction(_this.options.barColor) ? _this.options.barColor(percent) : _this.options.barColor;
        _this.ctx.lineCap = _this.options.lineCap;
        _this.ctx.lineWidth = _this.options.lineWidth;
        offset = _this.options.size / 2 - _this.options.lineWidth / 2;
        if (_this.options.scaleColor !== false) {
            offset -= _this.options.size * 0.08;
        }
        _this.ctx.save();
        _this.ctx.rotate(-Math.PI / 2);
        _this.ctx.beginPath();
        _this.ctx.arc(0, 0, offset, 0, Math.PI * 2 * percent / 100, false);
        _this.ctx.stroke();
        _this.ctx.restore();
    };
    rAF = (function() {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function(callback) {
                return window.setTimeout(callback, 1000 / 60);
            };
    })();
    animateLine = function(from, to) {
        var anim, startTime;
        _this.options.onStart.call(_this);
        _this.percentage = to;
        Date.now || (Date.now = function() {
            return +(new Date);
        });
        startTime = Date.now();
        anim = function() {
            var currentValue, process;
            process = Date.now() - startTime;
            if (process < _this.options.animate) {
                rAF(anim);
            }
            _this.ctx.clearRect(-_this.options.size / 2, -_this.options.size / 2, _this.options.size, _this.options.size);
            renderBackground.call(_this);
            switch (_this.options.easing) {
              case "easeInOutQuad":
                currentValue = [easeInOutQuad(process, from, to - from, _this.options.animate)];
                break;
                case "easeOutBack":
                currentValue = [easeOutBack(process, from, to - from, _this.options.animate)];
                break;
                case "easeOutBounce":
                currentValue = [easeOutBounce(process, from, to - from, _this.options.animate)];
                break;
                case "easeOutElastic":
                currentValue = [easeOutElastic(process, from, to - from, _this.options.animate)];
                break;
               default:
               currentValue = [easeInOutQuad(process, from, to - from, _this.options.animate)];
            }
            _this.options.onStep.call(_this, currentValue);
            drawLine.call(_this, currentValue);
            if (process >= _this.options.animate) {
                return _this.options.onStop.call(_this, currentValue, to);
            }
        };
        rAF(anim);
    };

    easeInOutQuad = function (t, b, c, d) {
	       t /= d/2;
	      if (t < 1) return c/2*t*t + b;
	       t--;
	        return -c/2 * (t*(t-2) - 1) + b;
      };

      easeOutBack=function ( t, b, c, d, s) {
          if (s == undefined) s = 1.70158;
          return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
      };

      easeOutBounce = function (t, b, c, d) {
      	if ((t/=d) < (1/2.75)) {
      		return c*(7.5625*t*t) + b;
      	} else if (t < (2/2.75)) {
      		return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
      	} else if (t < (2.5/2.75)) {
      		return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
      	} else {
      		return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
      	}
      };

      easeOutElastic= function (t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
    };
    return this.init();
};

$.fn.easyPieChart = function(options) {
    return $.each(this, function(i, el) {
        var $el, instanceOptions;
        $el = $(el);
        instanceOptions = $.extend({}, options, $el.data());
        return $el.data('easyPieChart', new $.easyPieChart(el, instanceOptions));
    });
};

function pixflow_pieChart($id, barColor, trackColor){
    'use strict';

    $.easyPieChart.defaultOptions = {
        barColor: barColor,
        trackColor: trackColor,
        lineCap: 'round',
        rotate: 0,
        size: 210,
        lineWidth: 3,
        animate: false,
        onStart: $.noop,
        onStop: $.noop,
        onStep: $.noop
    };
    $id.find('.percentage').easyPieChart({
        animate: 1500,
        lineWidth: 4,
        onStep: function(value) {
            this.$el.find('span').text(Math.round(value));
        },
        onStop: function(value, to) {
            this.$el.find('span').text(Math.round(to));
        }
    });
}

function pixflow_pieChart2($id, barColor, trackColor){
    'use strict';
    var md_pieChart2_animation=$id.attr("data-animation-type");
    var md_pieChart2_show_type=$id.attr("data-show-type");
    var md_pieChart2_line_width=$id.attr("data-line-width");
    var md_pieChart2_line_width=$id.attr("data-line-width");

     $.easyPieChart.defaultOptions = {
         barColor: barColor,
         trackColor: trackColor,
         lineCap: 'round',
         rotate: 0,
         size: 220,
         lineWidth: 3,
        animate: 1500,
         onStart: $.noop,
         onStop: $.noop,
         onStep: $.noop,
     };

     if(md_pieChart2_show_type!='yes'){
            var md_pieChart2_title=$id.find('.percentage').attr("data-title");
     }
     else {
          var md_pieChart2_title=$id.find('.percentage').attr("data-percent")+"%";
     }

     if('yes'== md_pieChart2_show_type)
     {
         $id.find('.percentage').easyPieChart({
           animate: 1500,
           lineWidth: md_pieChart2_line_width,
           easing:md_pieChart2_animation,
          onStep: function(value) {
               this.$el.find('span').html('<p class="md_pieChart2_title">'+Math.round(value)+'%</p>');
           },
           onStop: function(value, to) {
               this.$el.find('span').html('<p class="md_pieChart2_title">'+Math.round(value)+'%</p>');
           }
       });
     }else {
         $id.find('.percentage').easyPieChart({
           animate: 1500,
           lineWidth: md_pieChart2_line_width,
           easing:md_pieChart2_animation,
           onStep: function(value) {
               this.$el.find('span').html('<p class="md_pieChart2_title">'+md_pieChart2_title+'</p>');
           },
           onStop: function(value, to) {
               this.$el.find('span').html('<p class="md_pieChart2_title">'+md_pieChart2_title+'</p>');
           }
       });
     }
}

//----------------------------------------------------------
//                          Google Map
//-----------------------------------------------------------
function pixflow_googleMap(id, lat, lon, zoom, type, icon) {
    "use strict";
    if($(".md-google-map").length)	{

        if(type=='gray'){
            $("."+id).gmap3({
                map:{
                    options:{
                        zoom: parseInt(zoom),
                        disableDefaultUI: true, //  disabling zoom in touch devices
                        disableDoubleClickZoom: true, //  disabling zoom by double click on map
                        center: new google.maps.LatLng(lat, lon),
                        draggable:true, //  disable map dragging
                        mapTypeControl:true,
                        navigationControl: false,
                        scrollwheel: false,
                        streetViewControl: false,
                        panControl:false,
                        zoomControl: true,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        mapTypeControlOptions: {
                            mapTypeIds: [google.maps.MapTypeId.ROADMAP, "Gray"]
                        }
                    }
                },
                styledmaptype:{
                    id: "Gray",
                    options:{
                        name: "Gray"
                    },
                    styles:[
                        {
                            featureType: "water",
                            elementType: "geometry",
                            stylers: [
                                { color : "#1d1d1d" }
                            ]
                        },{
                            featureType: "landscape",
                            stylers: [
                                {color: "#3e3e3e" },
                                {lightness: 7 }
                            ]
                        },{
                            featureType: "administrative.country",
                            elementType: "geometry.stroke",
                            stylers: [
                                { color: "#5f5f5f" },
                                { weight : 1 }
                            ]
                        },{
                            featureType: "landscape.natural.terrain",
                            stylers: [
                                { color : "#4f4f4f" }
                            ]
                        },{
                            featureType: "road",
                            stylers: [
                                { color: "#393939" }
                            ]
                        },{
                            featureType: "administrative.country",
                            elementType: "labels",
                            stylers: [
                                { visibility: "on" },
                                { weight: 0.4 },
                                { color: "#686868" }
                            ]
                        },{
                            eatureType: "administrative.locality",
                            elementType: "labels.text.fill",
                            stylers: [
                                { weigh: 2.4 },
                                { color: "#9b9b9b" }
                            ]
                        },{
                            featureType: "administrative.locality",
                            elementType: "labels.text",
                            stylers: [
                                { visibility: "on" },
                                { lightness: -80 }
                            ]
                        },{
                            featureType: "poi",
                            stylers: [
                                { visibility: "off" },
                                { color: "#d78080" }
                            ]
                        },{
                            featureType: "administrative.province",
                            elementType: "geometry",
                            stylers: [
                                { visibility: "on" },
                                { lightness: -80 }
                            ]
                        },{
                            featureType: "water",
                            elementType: "labels",
                            stylers: [
                                { color: "#adadad" },
                                { weight: 0.1 }
                            ]
                        },{
                            featureType: "administrative.province",
                            elementType: "labels.text.fill",
                            stylers: [
                                { color: "#3a3a3a" },
                                { weight: 4.8 },
                                { lightness: -69 }
                            ]
                        }

                    ]
                },
                marker:{
                    values:[{
                        'latLng': [lat, lon]
                    }],
                    options:{
                        icon: new google.maps.MarkerImage( icon, new google.maps.Size(80, 60, "px", "px"))
                    }
                }

            });
            $('.'+id).gmap3('get').setMapTypeId("Gray");//Display Gray Map On Load  if we don't have this line map loads in default
            if ($(window).width() <= 1280 ){
                $("."+id).gmap3("get").setOptions({draggable:false});
            }

        }else{
            $("."+id).gmap3({
                map:{
                    options:{
                        zoom: parseInt(zoom),
                        disableDefaultUI: true, //  disabling zoom in touch devices
                        disableDoubleClickZoom: true, //  disabling zoom by double click on map
                        center: new google.maps.LatLng(lat, lon),
                        draggable:false, //  disable map dragging
                        mapTypeControl:true,
                        navigationControl: false,
                        scrollwheel: false,
                        streetViewControl: false,
                        panControl:false,
                        zoomControl: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                    }
                },
                marker:{
                    values:[{
                        'latLng': [lat, lon]
                    }],
                    options:{
                        icon: new google.maps.MarkerImage( icon, new google.maps.Size(80, 60, "px", "px"))
                    }
                }
            });

        }
    }

}

function pixflow_iconBox(){
    'use strict';

    if ( ! $('.iconbox-side .icon-background').length )
        return;

    $('.iconbox-side').each(function () {

        if ($(this).find('.icon-background').length) {

            var containerWidth = $(this).find('.iconbox-side-container').outerWidth(true),
                iconWidth = $(this).find('.icon').width(),
                colWidth = $(this).parents('div[class *= "vc_col"]').width(),
                iconboxWidth = containerWidth + iconWidth + 20; // 81 is icon width , 20 padding left and right

            setTimeout( function(){
                if (iconboxWidth > colWidth) {
                    $(this).addClass('responsive');
                } else {
                    $(this).removeClass('responsive');
                }
            }, 200);
        }
    });

}

function pixflow_setCenteredFooterHeight(){
    'use strict';
    if(!$('#footer-bottom .centered').length){
        return
    }
    $('#footer-bottom').css('min-height',$('#footer-bottom .centered').outerHeight())
}

function pixflow_footerParallax(){
    "use strict";
    if($('main').hasClass('has-parallax-footer') && $(window).width() > 1279 ){
        $('main').css('margin-bottom',$('footer').outerHeight(true));
        if( $('.footer-widgets').length && $('.footer-widgets').hasClass('dark') && !$('body').is('.search') ){
            $('main.has-parallax-footer').css('box-shadow','rgba(0, 0, 0, 0.2) 0 -10px 65px 25px')
        }
        $(window).scroll(function(){
            //Displaying and hiding parallax footer ){
            if( ($(window).scrollTop() + $(window).height()) > ( $('main').innerHeight() + $('main').offset().top )){
                $('footer').css('opacity','1');
            } else {
                $('footer').css('opacity','0');
            }

            if( ($(window).scrollTop() + $(window).height()) >  ($('main').innerHeight() + $('main').offset().top ) ){
                var opacity = ( ( ($(window).scrollTop() + $(window).height()) - ($('main').innerHeight() + $('main').offset().top) ) * 100 / 357 / 100);
                TweenMax.to('footer .content',.1,{opacity:opacity});
            } else{
                TweenMax.to('footer .content',.3,{opacity:0.1});
            }
        });
    }
}

function pixflow_portfolioDetail() {

    "use strict";

    if (!$('.portfolio-carousel').length ) {
        return;
    }

    $('.owl-carousel').css('width', $(window).width());
    if ($(".owl-carousel .item").length > 1) {
        $('.owl-carousel').owlCarousel({
            items: 1,
            margin: 10,
            video: true,
            loop: true,
            center:true,
            autoWidth: true,
            dots: true,
            dotsEach: 1,
        });
    }else{
        $('.owl-carousel').owlCarousel({
            items: 1,
            margin: 0,
            video: true,
            loop: false,
            autoWidth: false,
            dots: false,
        });
    }

    var imageUrl = $(".owl-carousel").attr("data-video-image-url"),
        imageSize = $(".owl-carousel").attr("data-fullsize");

    if(imageUrl!="") {
      setTimeout(function(){

        $(".owl-carousel .owl-video-tn").css({"background-image":"url("+ imageUrl +")"});

        if(imageSize==1){
          $(".owl-carousel .owl-video-tn").css({"background-size":"cover"});
        }

      },2000);

    }

}

function pixflow_portfolioDetailFull(){
    "use strict";
    if (!$('.portfolio-full').length) {
        return;
    }

    var height = $(window).height();

    if (parseInt($('main').css('padding-top')) > 0 ){
        $('main').css('padding-top','0');
    }

    $(".owl-carousel .item").css({width:$(window).width(),height:height});

    $('.owl-carousel').css('width', $('.owl-carousel').parent().parent().width());

    if ($(".owl-carousel .item").length > 1){
        $('.owl-carousel').owlCarousel({
            items: 1,
            margin: 0,
            video: true,
            loop: true,
            autoWidth: false,
            dots: true,
            singleItem:true,
            dotsEach: 1,
        });
    }else{
        $('.owl-carousel').owlCarousel({
            items: 1,
            margin: 0,
            video: true,
            loop: false,
            autoWidth: false,
            dots: false,
        });
    }

    var imageurl=$(".owl-carousel").attr("data-video-image-url");
    var imagesize=$(".owl-carousel").attr("data-fullsize");
    if(imageurl!="") {
      setTimeout(function(){
        $(".owl-carousel .owl-video-tn").css({"background-image":"url("+ imageurl +")"});
        if(imagesize==1){
          $(".owl-carousel .owl-video-tn").css({"background-size":"cover"});
        }
      },2000);


    }

}

function pixflow_portfolioSplit(){
    "use strict";
    if( !$('.portfolio-split').length )
        return;
    $(".pinBox").pinBox({
        Top : $('.data').offset().top,
        Container : '.box_size',
        ZIndex : 20,
        MinWidth : '768px'
    });

    var imageurl=$(".media").attr("data-video-image-url");
    $(".ytp-thumbnail-overlay").css({"background-image":"url("+ imageurl +")"});
}

function pixflow_subscribeWidget() {
    "use strict";
    var $subscribes = $('.widget-subscribe');
    if(!$subscribes.length){
        return
    }
    $subscribes.each(function(){
        var $this = $(this);
        $this.find('form.send').submit(function(e){
            e.preventDefault();


            var $thisForm = $(this),
                $form = $this.find('.mc4wp-form'),
                $textbox = $form.find('[type=email]'),
                index = $('.widget-subscribe').index($this),
                interval = null;
            $textbox.val($thisForm.find('.widget-subscribe-textbox').val());
            if(!$form.length){
                $this.find('.subscribe-err').css('color','rgba(255,0,0,.7)').html(themeOptionValues.mailchimpNotInstalled);
                return false;
            }
            $.ajax({
                method: "POST",
                url: window.location.href.split('?')[0],
                data: $form.serialize(),
                beforeSend : function(){
                    $this.find('.widget-subscribe-button').addClass('subscribe-button-animation');

                    $this.find('.subscribe-textbox').css({border:''});
                    $this.find('.subscribe-err').html('');
                }
            }).done(function( msg ) {
                var $id = $(msg).find('.widget-subscribe:eq('+ index +')');
                $this.find('.widget-subscribe-button').removeClass('subscribe-button-animation');

                $this.find('.subscribe-err').html($id.find('.mc4wp-response').text());
            });

            return false;
        });
    })

}

function pixflow_tabShortcode(){
    "use strict";
    $('body').off('click','.wpb_tabs_nav li.ui-state-default');
    $('body').on('click','.wpb_tabs_nav li.ui-state-default',function(){
        setTimeout(function(){
            $(window).resize();
        },150);
    });
    $("ul.md-custom-tab > li").click(function(){
        setTimeout(function(){
            $(window).resize();
        },150);
    });
}

function pixflow_isTouchDevice(){
    "use strict";
    try {
        document.createEvent("TouchEvent");
        return true;
    } catch (e) {
        return false;
    }

}

function pixflow_macBookFix(){
    "use strict";
    if(pixflow_isTouchDevice() == false && $(window).width() <= 1280){
        $('header').find('.hidden-tablet, .visible-tablet').removeClass('hidden-tablet visible-tablet');
        $('header').find('.hidden-desktop').css('display','none!important');
        $('header.top .logo').css({'margin-left':'10px','margin-right':'-10px'});
        $('header').addClass('retina-screen-header');
        $('main').addClass('retina-screen-main');
        //side header
        if(!$('header').is('.side-modern') && $('header').is('.left, .right')){
            $('header').css("cssText", "width: 15% !important;");
            $('header').siblings('.wrap').css("cssText", "width: 85% !important;");
            $('header').siblings('.wrap').find('div').each(function(){
                if($(this).width() > $('header').siblings('.wrap').width()){
                    $(this).css('width',$('header').siblings('.wrap').width());
                }
            })
        }else  if($('header').is('.side-modern') && $('header').is('.left, .right')) {
            $('header').siblings('.wrap').css("cssText", "width: calc(100% - 65px) !important;");
        }
    }
}

function pixflow_testimonialCarousel(){
    "use strict";

    if(!$('.testimonial-carousel').length) return;

    var owl = $(".testimonial-carousel#owl-demo");
    owl.owlCarousel({
        navigation: true,
        dotsSpeed: 800,
        dragEndSpeed: 800,
        navSpeed: 800,
        fluidSpeed: 800,
        center: true,
        singleItem: true,
        items: 1,
        itemsDesktop: true,
        itemsDesktopSmall: true,
        itemsTablet: true,
        itemsMobile: true
    });
    setTimeout(function(){
        owl.data('owlCarousel').e._onResize();
    },1000)
}

function pixflow_portfolioWidget(){
    "use strict";
    if ( ! $('.widget-md-recent-portfolio').length )
        return;

    $('.widget-md-recent-portfolio').each(function(){

        var $item = $(this).find('.item');
        $item.css({height:$item.width() *.75});

    });
}

function pixflow_pixflowSlider(){
    "use strict";
    var $pixflowSliders = $('.pixflow-slider');
    if(!$pixflowSliders.length) return;
    $pixflowSliders.each(function(){
        var $slider = $(this);
        if( $slider.parents('.md-pixflow-slider').is('.vertical') ){
            pixflow_verticalPixflowSlider($slider);
        }else{
            pixflow_classicPixflowSlider($slider);

        }
    });

    BackgroundCheck.init({
        targets: '.current-slide-no,.pixflow-slider-dots,.md-pixflow-slider .flickity-page-dots .dot',
        images: '.pixflow-slide-bg'
    });


}

function pixflow_verticalPixflowSlider($slider){
    var sliderSkin = $slider.attr('data-skin'),
        sliderID = $slider.attr('data-slider-id'),
        sliderHeight = $slider.attr('data-height-mode'),
        sliderAutoplay = $slider.attr('data-autoplay'),
        sliderAutoplaySpeed = Number($slider.attr('data-autoplay-speed'))*1000,
        $sliderDotsContainer = $('.pixflow-slider-dots-container[data-slider-id="'+ sliderID +'"]'),
        vertical = false;
    // Upadet slides height (if heigth mode set to fit)
    if(sliderHeight == 'fit'){
        $slider.find('.pixflow-slide').height($(window).height());
    }

    if('yes' == sliderAutoplay){
        sliderAutoplay = true;
    }else{
        sliderAutoplay = false;
    }
    if('vertical' == sliderSkin){
        vertical = true;
    }
    $slider.slick({
        infinite: true,
        useTransform: true,
        cssEase: 'cubic-bezier(0.215, 0.61, 0.355, 1)',
        vertical: vertical,
        verticalSwiping: vertical,
        autoplay: sliderAutoplay,
        autoplaySpeed: sliderAutoplaySpeed,
        draggable: true,
        swipeToSlide: true,
        touchThreshold:200,
        speed: 400
    });

    // Upadate custom dots
    $slider.on('setPosition', function(event, slick, direction){
        var currentSlide = slick.currentSlide+1;
        BackgroundCheck.refresh();
        $sliderDotsContainer.find('.current-slide-no').html('0'+currentSlide);
        $sliderDotsContainer.find('.pixflow-slider-dot').removeClass('active');
        $sliderDotsContainer.find('.pixflow-slider-dot[data-slide-no="'+ currentSlide +'"]').addClass('active');
    });
    $sliderDotsContainer.find('.pixflow-slider-dot .circle-dot').click(function(){
        var slideNo = $(this).parent().attr('data-slide-no');
        slideNo = parseInt(slideNo) - 1;
        $slider.slick('slickGoTo',slideNo);
    })

    $slider.on('swipeMove', function(event){
        // Fire on Draging
    });

}

function pixflow_classicPixflowSlider(i) {
    function t() {
        function t() {
            var t = i,
                n = 350,
                l = ($(window).width(), (t.attr("data-height-mode")=='fit')?$(window).height(): parseInt(t.find('.flickity-viewport').height())),
                responsive = (pixflow_isTouchDevice() && $(window).width() <= 1024),
                s = responsive ? $(window).width() / 1400 : $(window).width() /1900;

            if (window.innerWidth > 1e3 &&  $(".layout").width() == $(window).width()){
                if (0 == t.parents(".vc_col-sm-12").length) {
                    if(responsive){
                        t.find(".pixflow-slide, .flickity-viewport").css("height", Math.ceil(l));
                    }else {
                        if(!responsive && window.innerWidth >= 1100) {
                            t.find(".pixflow-slide, .flickity-viewport").css("height", Math.ceil(l));
                        }else{
                            t.find(".pixflow-slide, .flickity-viewport").css("height", Math.ceil(l * s))
                        }
                    }
                }else{
                    t.find(".pixflow-slide, .flickity-viewport").css("height", Math.ceil(l));
                }
            }
            else {
                var d = t.parents(".wpb_column").length > 0 ? t.parents(".wpb_column") : t.parents(".col");
                if (0 == d.length && (d = $(".main-content")), d.hasClass("vc_span12") || d.hasClass("main-content") || d.hasClass("span_12") || d.hasClass("vc_col-sm-12")) n >= l * s ? t.find(".pixflow-slide, .flickity-viewport").css("height", n) : t.find(".pixflow-slide, .flickity-viewport").css("height", Math.ceil(l * s));
                else {
                    var a = e(d),
                        o = l / a;
                    o * d.width() <= n ? t.find(".pixflow-slide, .flickity-viewport").css("height", n) : t.find(".pixflow-slide, .flickity-viewport").css("height", o * d.width())
                }
            }
        }

        function e(i) {
            var t = 1100,
                e = $(i).attr("class").match(/\d+/);
            return "2" == e ? t = 170 : "3" == e ? t = 260 : "4" == e ? t = 340 : "6" == e ? t = 530 : "8" == e ? t = 700 : "9" == e ? t = 805 : "10" == e ? t = 916.3 : "12" == e && (t = 1100), t
        }

        var autoplay = (i.attr('data-autoplay') == 'true')? parseFloat(i.attr('data-autoplay-speed')) * 1000:false;

        var l = i.flickity({
            contain: !0,
            draggable: !0,
            lazyLoad: !1,
            imagesLoaded: !0,
            percentPosition: !0,
            pageDots: !0,
            resize: !0,
            setGallerySize: !0,
            wrapAround: !0,
            autoPlay: autoplay,
            prevNextButtons: !1,
            accessibility: !1,
            selectedAttraction:.01,
            friction:.2,
            pauseAutoPlayOnHover: false
        });

        setTimeout(function() {
            i.addClass("loaded"), "fit" == i.attr("data-height-mode") && i.find(".flickity-viewport,.flickity-slider,.pixflow-slide").height($(window).height())
        }, 1150);
        l.data("flickity");


        l.on("dragStart", function(event,pointer ) {
            $(".flickity-viewport").addClass("animating")
        }),

        l.on("dragEnd", function(e,pointer) {
            $(".flickity-viewport").removeClass("animating");
        }),

        l.on("settle", function() {
            BackgroundCheck.refresh();
        }),
        t(),
        $(window).resize(t),
        navigator.userAgent.match(/(Android|iPod|iPhone|iPad|IEMobile|BlackBerry|Opera Mini)/) || $(window).resize(n)
    }

    function e() {
        var t = i,
            n = parseInt(t.find(".flickity-slider").position().left),
            l = t.find(".pixflow-slide").length,
            s = t.find(".pixflow-slide:last-child").index(),
            d = t.find(".pixflow-slide").width();

        if (n >= -3){
            t.find(".pixflow-slide:last-child .pixflow-slide-bg").css("margin-left", parseInt(Math.ceil(d / 3.5)) + "px");
        }
        else {
            t.find(".pixflow-slide:last-child .pixflow-slide-bg").css("margin-left", "-" + parseInt(Math.ceil(d / 3.5 * s)) + "px");
        }

        if ( Math.abs(n) >= (l - 1) * d ) {
            t.find(".pixflow-slide:first-child .pixflow-slide-bg").css("margin-left", "-" + parseInt(Math.ceil(d / 3.5 * l)) + "px")
        }
        else {
            t.find(".pixflow-slide:first-child .pixflow-slide-bg").css("margin-left", "0px")
        }

        t.find(".pixflow-slide-bg").css("transform", "translateX(" + Math.ceil(t.find(".flickity-slider").position().left / -3.5) + "px)")

        requestAnimationFrame(e)
    }

    function n() {
        var t = i.find(".pixflow-slide").width();
        i.find(".pixflow-slide").each(function(i) {
            $(this).find(".pixflow-slide-bg").css("margin-left", "-" + parseInt(Math.ceil(t / 3.5) * i) + "px")
        })
    }
    t(), navigator.userAgent.match(/(Android|iPod|iPhone|iPad|IEMobile|BlackBerry|Opera Mini)/) || window.requestAnimationFrame(e), $(window).resize()
}

function pixflow_iconShortcode(id){
    'use strict';
    var $ = (jQuery);
    /* Replace all SVG images with inline SVG */
    $('.'+id+' img.svg').each(function(){
        var $img = $(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        $.ajax({
            url: imgURL,
            processData: false,
            dataType: "html"
        }).done(function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = $(data).find('svg');
            if(!$svg.length){
                $svg = $(data);
            }
            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                if($svg.attr('class') != undefined)
                    var classes = $svg.attr('class');
                else{
                    for(var i=0; i< $svg.length; i++){
                        if($svg.get(i).getAttribute && $svg.get(i).getAttribute('class') != undefined){
                            var classes = $svg.get(i).getAttribute('class');
                            break;
                        }
                    }
                }
                $svg = $svg.attr('class', classes + " " + imgClass + ' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Replace image with new SVG
            $img.replaceWith($svg);
            if(typeof pixflow_animateSvgInitiate == 'function'){
                pixflow_animateSvgInitiate();
            }
            if(typeof pixflow_animateSvgExecute == 'function'){
                pixflow_animateSvgExecute();
            }
        });

    });
}

function pixflow_animateSvgInitiate(){
    "use strict";
    //making SVGs ready for animate
    var path = document.querySelectorAll('.animate-svg path');
    if(path.length){
        for (i in path) {
            if(i == "length") break;
            var length = path[i].getTotalLength();
            path[i].style.strokeDasharray = length + ' ' + length;
            path[i].style.strokeDashoffset = length;
            path[i].getBoundingClientRect();
        }
    }

}

function pixflow_animateSvgExecute(){
    "use strict";
    //running SVGs animate
    var $svg = $('.animate-svg');
    $(window).scroll(function () {
        $svg.each(function(){
            if( $(this).offset().top <= ( $(window).scrollTop() + $(window).height() ) ) {
                var $path = $(this).find('path');
                $path.each(function(){
                    var oldClass = $(this).attr("class");
                    if(typeof oldClass != 'undefined'){
                        if( oldClass.indexOf('path-animated') == -1 ){
                            $(this).attr("class", oldClass + " "+"path-animated");
                        }
                    } else {
                        $(this).attr("class","path-animated");
                    }

                })
            }
        })
    })
}

function pixflow_modernSubscribe(){
    "use strict";
    if ($(window).width() <= 1025 )
    return;


    $('.modern-subscribe').each(function(){
        var $this=$(this),
            height=$this.css('height');
        $this.find('.subscribe-image').css('height',height);
    });
}

function pixflow_contactFormAnimation(){
    "use strict";
    $('.input__field--hoshi').each(function(){
        var $this =$(this);
        $this.focus(function(){
            var $elem = $(this);
            $elem.parent('.wpcf7-form-control-wrap').addClass('focus');
            $elem.parents('.input').addClass('input--filled');
        });
        $this.focusout(function(){
            var $elem = $(this);
            $elem.parent('.wpcf7-form-control-wrap').removeClass('focus');
            if( $elem.val().length < 1){
                $elem.parents('.input').removeClass('input--filled');
            }
        });

        $this.keyup(function(){
            var $elem = $(this);
            if ($elem.is('.wpcf7-not-valid')){
                $elem.removeClass('wpcf7-not-valid').removeAttr('style');
                $elem.next('.wpcf7-not-valid-tip').remove();
            }
        })

    })
}

function pixflow_call_retina(){
    "use strict";
    if(pixflow_detectPosition() == 'front-end'){
        !function(){function a(){}function b(a){return f.retinaImageSuffix+a}function c(a,c){if(this.path=a||"","undefined"!=typeof c&&null!==c)this.at_2x_path=c,this.perform_check=!1;else{if(void 0!==document.createElement){var d=document.createElement("a");d.href=this.path,d.pathname=d.pathname.replace(g,b),this.at_2x_path=d.href}else{var e=this.path.split("?");e[0]=e[0].replace(g,b),this.at_2x_path=e.join("?")}this.perform_check=!0}}function d(a){this.el=a,this.path=new c(this.el.getAttribute("src"),this.el.getAttribute("data-at2x"));var b=this;this.path.check_2x_variant(function(a){a&&b.swap()})}var e="undefined"==typeof exports?window:exports,f={retinaImageSuffix:"@2x",check_mime_type:!0,force_original_dimensions:!0};e.Retina=a,a.configure=function(a){null===a&&(a={});for(var b in a)a.hasOwnProperty(b)&&(f[b]=a[b])},a.init=function(a){null===a&&(a=e);var b=a.onload||function(){};a.onload=function(){var a,c,e=document.getElementsByTagName("img"),f=[];for(a=0;a<e.length;a+=1)c=e[a],c.getAttributeNode("data-no-retina")||f.push(new d(c));b()}},a.isRetina=function(){var a="(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-resolution: 1.5dppx)";return e.devicePixelRatio>1?!0:e.matchMedia&&e.matchMedia(a).matches?!0:!1};var g=/\.\w+$/;e.RetinaImagePath=c,c.confirmed_paths=[],c.prototype.is_external=function(){return!(!this.path.match(/^https?\:/i)||this.path.match("//"+document.domain))},c.prototype.check_2x_variant=function(a){var b,d=this;return this.is_external()?a(!1):this.perform_check||"undefined"==typeof this.at_2x_path||null===this.at_2x_path?this.at_2x_path in c.confirmed_paths?a(!0):(b=new XMLHttpRequest,b.open("HEAD",this.at_2x_path),b.onreadystatechange=function(){if(4!==b.readyState)return a(!1);if(b.status>=200&&b.status<=399){if(f.check_mime_type){var e=b.getResponseHeader("Content-Type");if(null===e||!e.match(/^image/i))return a(!1)}return c.confirmed_paths.push(d.at_2x_path),a(!0)}return a(!1)},b.send(),void 0):a(!0)},e.RetinaImage=d,d.prototype.swap=function(a){function b(){c.el.complete?(f.force_original_dimensions&&(c.el.setAttribute("width",c.el.offsetWidth),c.el.setAttribute("height",c.el.offsetHeight)),c.el.setAttribute("src",a)):setTimeout(b,5)}"undefined"==typeof a&&(a=this.path.at_2x_path);var c=this;b()},a.isRetina()&&a.init(e)}();
    }

}

function pixflow_sliderCarousel($selector, autoPlay){
    "use strict";
    setTimeout(function(){
        $selector.not('.flickity-enabled').flickity({
            contain: true ,
            initialIndex: 1 ,
            autoPlay: autoPlay,
            prevNextButtons: false,
            percentPosition: false,
            wrapAround: true,
            pauseAutoPlayOnHover: false,
            selectedAttraction: 0.045,
            friction: 0.5
        });
    },100);
}

function pixflow_addToCart(){
    "use strict";
    var $total = $('.notification-center #opt4 .total'),
        $buttons = $('.notification-center #opt4 .buttons');

    if ($total.length > 1){
        $($total.get($total.length - 1)).remove();
    }

    if ($buttons.length > 1){
        $($buttons.get($buttons.length - 1)).remove();
    }

    var num = 0 ;
    $('.notification-center ul.cart_list li.mini_cart_item').each(function(){
        var a =  $(this).find('.quantity').contents()[0].textContent;
        num += parseInt(a);
    });

    if ($('header .icons-pack .shopcart-item').length && num > 0){
        if ($('header .icons-pack .shopcart-item .number').length) {
            $('header .icons-pack .shopcart-item .number').text(num);
        }else{
            $('header .icons-pack .shopcart-item .icon ').append('<i class="number">'+num+'</i>');
        }
    }
    if ( num == 0 ){
        $('header .icons-pack .shopcart-item .number').remove();
    }
}

function pixflow_wc_clear_selection(){
    "use strict";
    if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1)
    {
        $("div.clear-selection").css({"height":"55px"});
    }
    $( ".variations_form" ).on( "woocommerce_variation_select_change", function (e) {
        // Fires whenever variation selects are changed
        var value=$("#pa_color").val()
        if(value !=''){
            $(".clear-selection").css({"opacity":"1"});
        }else{
            $(".clear-selection").css({"opacity":"0"});
        }
    } );
}

function pixflow_progressWidget(){
    $('[data-widget-type="progress"]').each(function(){
        var $progressbarId = $(this);
        $progressbarId.find('.bar-percentage[data-percentage]').each(function () {

            var progress = $(this),
                percentage = Math.ceil($(this).attr('data-percentage'));

            $progressbarId.find('.bar-container').css('opacity', '1');
            $progressbarId.find('.bar').css('opacity', '1');

            $({countNum: 0}).animate({countNum: percentage + 1}, {
                duration: 2000,
                easing: 'easeInOutCubic',
                step: function (value) {
                    var pct = Math.ceil(value) + '%';
                    progress.text(pct) && progress.siblings().children().css('width', pct);
                }
            });

        });
    });
}

function pixflow_horTab(id,type){
    var postfix = '';
    if(type=='business'){
        postfix = '2';
    }
    if($('body').hasClass('vc_editor')){
        $('.'+id).closest('.vc_md_hor_tabs'+postfix).find('.md-hor-tab'+postfix+'-add-tab').parent().remove();
        $('.'+id).closest('.vc_md_hor_tabs'+postfix).find('.wpb_tabs_nav').append('<li><a style="cursor: pointer;" class="md-hor-tab'+postfix+'-add-tab vc_control-btn">ADD TAB</a></li>');
        $('.'+id).closest('.vc_md_hor_tabs'+postfix).find('.md-hor-tab'+postfix+'-add-tab').click(function(e){
            e.preventDefault();
            $(this).parent().parent().find('a.vc_control-btn[title="ADD TAB"] .vc_btn-content').click();
        })
    }
    var tabNavHeight=$('.'+id).find('.wpb_tabs_nav ').height(),
        tabTaller,
        temp=0;
    $('.'+id).find('.ui-tabs-panel ').each(function(){
        var $this=$(this);
        tabTaller=$(this).height();
        if(temp<tabTaller){
            temp=tabTaller;
        }
    });

    if(temp<tabNavHeight){
        $('.'+id).find('.wpb_tour_tabs_wrapper ').css('height',tabNavHeight+'px');
    }else{
        $('.'+id).find('.wpb_tour_tabs_wrapper ').css('height',temp+'px');
    }
    if(typeof pixflow_tabShortcode == 'function'){
        pixflow_tabShortcode();
    }
}

function pixflow_doubleSlider(id,bg,fg,autoplay,duration){
    "use strict";
    function rgba(rgb){
        if(rgb.indexOf('rgba')!= -1) return rgb;
        if(rgb.indexOf('#')!=-1){
            var h = rgb.replace('#', '');
            h =  h.match(new RegExp('(.{'+h.length/3+'})', 'g'));

            for(var i=0; i<h.length; i++)
                h[i] = parseInt(h[i].length==1? h[i]+h[i]:h[i], 16);

            h.push('.8')
            return 'rgba('+h.join(',')+')';

        }
        rgb = rgb.replace(')',',.8)');
        rgb = rgb.replace('rgb','rgba');
        return rgb;
    }
    if( $(window).width() <= 800  ){
        bg[0] = rgba(bg[0]);
    }
    $('#'+ id +' .double-slider-text-container').css('background-color',bg[0]);
    $('#'+ id +' .double-slider-nav a').css('color',fg[0]);
    $('#'+ id +' .double-slider-image-container').flexslider({
        animation: "fade",
        slideshow: autoplay,
        slideshowSpeed: duration,
        animationSpeed: 600,
        touch: false
    })
    $('#'+ id +' .double-slider-text-container').flexslider({
        animation: "slide",
        slideshow: autoplay,
        slideshowSpeed: duration,
        animationSpeed: 600,
        useCSS:false,
        touch: false,
        before: function(slider){
            if( $(window).width() <= 800  ){
                bg[slider.animatingTo] = rgba(bg[slider.animatingTo]);
            }
            $('#'+ id +' .double-slider-text-container').css('background-color',bg[slider.animatingTo]);
            $('#'+ id +' .double-slider-nav a').css('color',fg[slider.animatingTo]);
            if(slider.hasClass('double-slider-text-container')){
                var to = (slider.direction == 'next' && slider.animatingTo == 0) ? slider.count : slider.animatingTo;
                if(slider.currentSlide < to && slider.direction == 'next'){
                    slider.slides.eq(slider.currentSlide).find('.double-slider-sub-title,.double-slider-title,.double-slider-description')
                        .css('transform','translateX(-200px)');
                }else {
                    slider.slides.eq(slider.currentSlide).find('.double-slider-sub-title,.double-slider-title,.double-slider-description')
                        .css('transform','translateX(200px)');
                }
                slider.find('.slides').delay(200);
            }
        },
        after: function(slider){
            setTimeout(function(){
                slider.slides.find('.double-slider-sub-title,.double-slider-title,.double-slider-description')
                    .css('transform','');
            },100)
        }
    })
    $('#'+ id +' .double-slider-prev').click(function(e){
        e.preventDefault();
        $(this).closest('.double-slider').find('.flex-direction-nav .flex-prev').click();
        return false;
    })
    $('#'+ id +' .double-slider-next').click(function(e){
        e.preventDefault();
        $(this).closest('.double-slider').find('.flex-direction-nav .flex-next').click();
        return false;
    })
}

function pixflow_textBox(){
    "use strict";
    $(".text-box").each(function(index, element){

        var $this = $(this),
            iconTimeline = new TimelineLite(),
            titleTimeline = new TimelineLite(),
            masterTimeline = new TimelineLite({paused:true});

        //creating icon timeline
        iconTimeline.to($this.find('.text-box-icon-holder'), 0.7, {'margin-top':'-25px','margin-bottom':'25px',ease: Expo.easeInOut})
            .to($this.find('.text-box-icon-holder'), 0.6, {'margin-top':'-20px','margin-bottom':'20px',ease: Expo.easeOut});

        //Creating title timeline
        titleTimeline.to($this.find('.text-box-title'), 0.7, {'margin-top':'2px','margin-bottom':'25px',ease: Expo.easeInOut})
            .to($this.find('.text-box-title'), 0.6, {'margin-top':'7px','margin-bottom':'20px',ease: Expo.easeOut});

        masterTimeline.add(iconTimeline)
            .add(titleTimeline,0.3)
            .to($this.find('.text-box-description'), 0.4, {'opacity':'1'},"-= 0.9");

        element.animation = masterTimeline;
    });
    $(".text-box").hover(over, out);
    function over(){ this.animation.play() };
    function out(){ this.animation.reverse() };
}

function pixflow_relatedProducts(){
    "use strict";
    if($(".related .products").length){
        $(".related .product").each(function(){
            var imageSource = $(this).find('img').attr('src');
            $(this).find('img').css('display', 'none');
            $('<div class="item-image"></div>').insertAfter($(this).find('img'));
            $(this).find('.item-image').css({'background-image': 'url("' + imageSource + '")'});
        })
    }
}

function pixflow_videoShortcode(id,sources,host,extURL){
    'use strict';
    var $=jQuery,
        $videoImg = $('.'+id+' .video-img');
    setTimeout(function(){
        $videoImg.css({
            height: $videoImg.width()
        });
    },100);
    var doIt;
    $(window).resize(function(){
        var $videoImg = $('.'+id+' .video-img');
        if(doIt){
            clearTimeout(doIt);
        }
        doIt = setTimeout(function(){
            $videoImg.css({
                height: $videoImg.width()
            });
        },150)
    })

    if(typeof videojs == 'function'){
        var $video = $('<video id="'+id+'_video" name="sc_video" class="video-js vjs-default-skin" controls width="80%" height="80%" >'+sources+'<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p></video>');
        if(host == 'youtube'){
            var dataSetup = '"techOrder": ["youtube"], "src": "'+extURL+'"';
        }else if(host == 'vimeo'){
            var dataSetup = '"techOrder": ["vimeo"], "src": "'+extURL+'"';
        }
        $video.attr('data-setup','{'+dataSetup+'}');
        $video.css('display','none');
        $('body').append($video);
        var player = videojs(id+'_video', { /* Options */ }, function() {
            // How about an event listener?
            this.on('ended', function() {
                //nothing
            });
        });

        $('.'+id+' .image-play-btn,.'+id+' .play-btn').click(function()
        {
            var $this = $('.'+id),
                $overlay = $('<div class="video-overlay"></div>');
            $('body').append($overlay);
            $overlay.append($('<span class="close"></span>'));
            var videoTime = setTimeout(function(){
                $('#'+id+'_video,#'+id+'_video video').css({display:'block'});
                $('#'+id+'_video video').css('opacity',1);
                $('#'+id+'_video').stop(false,true).animate({opacity: 1}, 1500);
                player.play();
            },1000);
            $overlay.stop().animate({opacity: .9}, 600);
            $overlay.click(function()
            {
                clearTimeout(videoTime);
                $(this).stop().animate({
                    opacity:0
                }, 600, 'swing', function () {
                    $(this).remove();
                });
                $('#'+id+'_video').stop().animate({
                    opacity:0
                }, 600,'swing',function(){
                    $('#'+id+'_video,#'+id+'_video video').css({display:'none'});
                    player.pause();
                    player.currentTime(0);
                });
            });
        });
    }
}

function isRetinaDisplay() {
    if (window.matchMedia) {
        var mq = window.matchMedia("only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen  and (min-device-pixel-ratio: 1.3), only screen and (min-resolution: 1.3dppx)");
        return (mq && mq.matches || (window.devicePixelRatio > 1));
    }
}

function pixflow_retinaCheck($obj){
    "use strict";
    if (! isRetinaDisplay() )
        return;

    var children = $obj.children();

    children.each(function(){
        var $this = $(this)
        if($(this).css('background-image')!='none'){
            var url = $(this).css('background-image');
            url = url.replace(/^url\(["']?/i, '').replace(/["']?\)$/, '');
            var name = url.substr(0,url.lastIndexOf('.'));
            var ext = url.substr(url.lastIndexOf('.'),url.length);
            name += '@2x';

            $('<img/>').attr('src', name+ext).load(function() {
                $(this).remove();
                $this.css('background-image','url('+name+ext+')');
            }).error(function(){
                $(this).remove();
            });
        }

        setTimeout(function(){pixflow_retinaCheck($this);},1)
    });
}

$(document).ready(function(){
    "use strict";
    document.body.className = document.body.className.replace('no-js','js-enabled');
    pixflow_macBookFix();
    pixflow_loadSemiAjax();
    pixflow_makeLinksTargetSelf();
    pixflow_addNicesroll();        // add nice scroll in body
    pixflow_mobileNavigation();
    pixflow_mobileSidebar();
    pixflow_gatherHeader();
    pixflow_gatherWidthMenu();
    pixflow_gatherBlockHover();       //Hover for Header Top Gather Block
    pixflow_headerSideModern();
    pixflow_underlineAnimation();   // Menu top classic hover animation effect
    pixflow_retinaCheck($('body'));
    pixflow_modernTop();
    pixflow_headerSideClassic();     // Header side classic social icons hover effect
    pixflow_headerSideEffect();      // Header side classic * Info hover effect ... and ... Header side classic Search hover effect
    pixflow_menuTopBlockSquare();    // Header top menu block square
    pixflow_menuTopBlockRec();       // Header top block rectangle (3D)
    pixflow_sidebarBoxStyle();       // Function for sidebar box style
    pixflow_headerStates();       // Header scroll Mode
    pixflow_callDropdown();
    pixflow_classicDropdown();
    pixflow_goToTopButton();       // Footer back to top button
    pixflow_calendarWidget();     // set day name, day color for calendar
    pixflow_searchWidget();
    pixflow_title_slider();
    pixflow_musicFitSizes();
    pixflow_shortcodeScrollAnimation();
    pixflow_clientNormal();
    pixflow_contactForm();
    pixflow_subscribe();
    pixflow_Products();
    pixflow_recentViewedWidget();
    pixflow_topRatedWidget();
    pixflow_blogPage();
    pixflow_instagramShortcode();
    pixflow_instagramWidget();
    pixflow_recentPostWidget();
    pixflow_layeredNav();
    pixflow_productCategory();
    pixflow_wooCommerce();
    pixflow_fitRowToHeight();
    pixflow_notificationCenter();
    pixflow_sidebarWidgets();
    pixflow_onePageMenu();
    pixflow_iconBox();
    pixflow_subscribeWidget();
    pixflow_portfolioPopup();
    pixflow_setCenteredFooterHeight();
    pixflow_footerParallax();
    pixflow_tabShortcode();
    pixflow_classicTopWireframeStyle();
    pixflow_portfolioDetail();
    pixflow_portfolioDetailFull();
    pixflow_animateSvgInitiate();
    pixflow_showcaseHover();
    pixflow_modernSubscribe();
    pixflow_contactFormAnimation();
    pixflow_call_retina();
    pixflow_wc_clear_selection();
    pixflow_textBox();
    pixflow_relatedProducts();
    if ( !$('.vc_md_skill_style1').length && $('.skill-style1').length )
        pixflow_onScrollFindIDs('skill-style1');

    if ( $('.md-counter').length )
        pixflow_onScrollFindIDs('md-counter');

    if ( $('.md-pie-chart').length )
        pixflow_onScrollFindIDs('md-pie-chart');


    if ( $('.md-counter').length || (!$('.vc_md_skill_style1').length && $('.skill-style1').length) ) {
        pixflow_eventRunFirstTime();
    }

    pixflow_ajaxSearch();
    pixflow_responsive();
    pixflow_blogMasonry();
    //pixflow_counterShortcode();

    // Skill Shortcode
    if ( !$('.vc_md_skill_style1').length && $('.skill-style1').length ) {
        pixflow_onScrollFindIDs('skill-style1');
        pixflow_eventRunFirstTime('skill-style1');
    }

    pixflow_shortcodeAnimation();
    pixflow_shortcodeAnimationScroll();
    if($('main').offset().top + $('main').outerHeight() + $('footer').outerHeight() < $('html').height()){
        var margin = $(window).height() - ($('main').offset().top + $('main').outerHeight()+ $('footer').outerHeight());
        if($('#wpadminbar').length){
            margin -= 25;
        }
        if($('footer').not('.compose-mode footer').css('margin-top') == '' || $('footer').not('.compose-mode footer').css('margin-top') == '0px') {
            $('footer').not('.compose-mode footer').css({'margin-top': margin}).attr('data-fixedBottom','true');
        }
    }else{
        if($('footer').attr('data-fixedBottom') == 'true') {
            $('footer').css({'margin-top': ''});
        }
    }

    if ($.browser.webkit) {
        $('.search-form input').attr('autocomplete', 'off');
    }

    if($('ul.products li.product').length){

        $('ul.products').each(function(){
            var maxHeight = 0;
            $(this).find('li.product').each(function(){
                if($(this).height() > maxHeight){
                    maxHeight = $(this).height();
                }
            })
            $(this).find('li.product').css('min-height',maxHeight);
        });

    }
});

$(window).on("load",function() {
    "use strict";

    pixflow_calculateFixHeader();
    pixflow_loadSite();

    if( $('.shortcode-btn .slide').length )
        pixflow_btnSlide("staticValue");

    pixflow_VcUpdate();
    pixflow_rowParallax();
    pixflow_iconboxTopShortcode();
    pixflow_imageBoxSlider(); // Image Box Slider
    pixflow_imageboxFull();

    var $body = $('body');
    pixflow_displaySliderShortcode($body);
    pixflow_tabletSliderShortcode($body);
    pixflow_mobileSliderShortcode($body);
    pixflow_teamMemberRecall();
    pixflow_portfolioMultisize();
    pixflow_portfolioLoadMore();
    pixflow_portfolioSplit();
    pixflow_testimonialCarousel();
    pixflow_pixflowSlider();
    pixflow_animateSvgExecute();
    pixflow_post_carousel();
    // Team Member Carousel
    pixflow_teammemberCarousel('resized');
    pixflow_progressWidget();


     if($('.blog').length) {
        $('.no-next-page').click(function (e) {
            e.preventDefault();
        });
        $('.no-prev-page').click(function (e) {
            e.preventDefault();
        });
     }

    if ($('.blog').length || $('.archive').length){
        var x = parseInt($('header').height())+30 ;
        $('main').css("cssText","margin-top:"+ x +'px');
    }

    pixflow_businesBarEnable();
    //pixflow_wooCommerce();

    if(pixflow_detectPosition() == 'front-end'){
        pixflow_headerWidth();
    }
    // Counter Shortcode
    if ( !$('.vc_md_counter').length && $('.md-counter').length ) {
        pixflow_onScrollFindIDs('md-counter');
        pixflow_eventRunFirstTime('md-counter');
    }
    pixflow_shortcodeAnimation();
    pixflow_shortcodeAnimationScroll();

    if($('main').offset().top + $('main').outerHeight() + $('footer').outerHeight() < $('html').height()){
        var margin = $(window).height() - ($('main').offset().top + $('main').outerHeight()+ $('footer').outerHeight());
        if($('#wpadminbar').length){
            margin -= 25;
        }
        if($('footer').not('.compose-mode footer').css('margin-top') == '' || $('footer').not('.compose-mode footer').css('margin-top') == '0px') {
            $('footer').not('.compose-mode footer').css({'margin-top': margin}).attr('data-fixedBottom','true');
        }
    }else{
        if($('footer').attr('data-fixedBottom') == 'true') {
            $('footer').css({'margin-top': ''});
        }
    }
    $('window').resize();
});

var doItGlobal,doItTransition,windowWith = $(window).width();
window.onresize = function(e){
    "use strict";

    if(doItGlobal){
        clearTimeout(doItGlobal);
    }
    doItGlobal = setTimeout(function() {

        if ($(e.target).hasClass('header-item')) {
            e.stopPropagation();
            return;
        }
        pixflow_responsive();
        pixflow_fitRowToHeight();
        pixflow_calculateFixHeader();

        //header top modern
        pixflow_modernTop();

        // Contact form
        if ($('.contact-form').length) {
            pixflow_contactForm();
        }

        // Display slider
        if ($('.device-slider').length) {
            pixflow_displaySliderShortcode($('body'));
        }

        // Tablet slider
        if ($('.tablet-slider').length) {
            pixflow_tabletSliderShortcode($('body'));
        }

        // Music
        if ($('.music-sc').length) {
            pixflow_musicFitSizes();
        }

        // Mobile slider
        if ($('.mobile-slider').length) {
            pixflow_mobileSliderShortcode($('body'));
        }

        // Team member classic recall
        if ($('.team-member-classic').length) {
            pixflow_teamMemberRecall();
        }

        // Team Member Carousel
        if ($('.wrap-teammember-style2').length) {
            pixflow_teammemberCarousel('resized');
        }

        // Process steps
        if ($('.process-steps').length) {
            pixflow_processSteps();
        }


        // Portfolio
        if ($('.portfolio').length) {
            //Fix Iphone/Ipad: fire resize when scrolling
            if($(window).width()!=windowWith) {
                windowWith=$(window).width();
                pixflow_portfolioMultisize();
            }
        }

        if($('ul.products li.product').length){

            $('ul.products').each(function(){
                var maxHeight = 0;
                $(this).find('li.product').each(function(){
                    if($(this).height() > maxHeight){
                        maxHeight = $(this).height();
                    }
                })
                $(this).find('li.product').css('min-height',maxHeight);
            });

        }

        //Footer Parallax
        pixflow_footerParallax();

        //iconbox Side
        pixflow_iconBox();

        // Product Categories
        pixflow_productCategory();

        // portfolio detail
        pixflow_portfolioDetailFull();

        pixflow_portfolioDetail();

        pixflow_portfolioWidget();

        if ($('main').offset().top + $('main').outerHeight() + $('footer').outerHeight() < $(window).height()) {
            var margin = $(window).height() - ($('main').offset().top + $('main').outerHeight() + $('footer').outerHeight());
            if ($('#wpadminbar').length) {
                margin -= 25;
            }
            if ($('footer').not('.compose-mode footer').css('margin-top') == '' || $('footer').not('.compose-mode footer').css('margin-top') == '0px') {
                $('footer').not('.compose-mode footer').css({'margin-top': margin}).attr('data-fixedBottom', 'true');
            }
        } else {
            if ($('footer').attr('data-fixedBottom') == 'true') {
                $('footer').css({'margin-top': ''});
            }
        }

    },150);
};
