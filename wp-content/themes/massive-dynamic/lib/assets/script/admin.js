(function ($) {
    "use strict";

    //Handles icon selector
    function pixflow_IconSelect() {
        'use strict';
        var $menuIcons = $('.px-input-icon');

        $menuIcons.each(function(key,val){

            var $input = $(this).find('input[name*="menu-item-icon"]'),
                value  = $input.attr('value'),
                $icons = $(this).find('.px-icon');


            //get the previous value and show it
            if(value.length){
                $(this).find('.px-icon[data-name='+value+']').addClass('selected');
            }

            $icons.click(function(){
                var $currentInput = $(this).siblings('input');
                $currentInput.attr('value',$(this).attr('data-name'));
                $icons.removeClass('selected');
                $(this).addClass('selected');
            });



        });
    }

    function pixflow_showIcons(){
        'use strict';
        var $iconsCheck = $('input[name *= "show_icon" ]');

        if( !$iconsCheck.length ) return;

        $iconsCheck.each(function(){

            var $next = $(this).parents('.field-show-icon').next('.field-icon');

            if ( $(this).is(':checked') )
                $next.slideDown('fast');
            else
                $next.slideUp('fast');


            $(this).click(function (){
                if ( $(this).is(':checked') )
                    $next.slideDown('fast');
                else
                    $next.slideUp('fast');
            })
        });


    }

    function pixflow_showMegaBg(){
        'use strict';
        var $megaCheck = $('input[name *= "megaOpt" ]');
        if( !$megaCheck.length ) return;
        $megaCheck.each(function(){
            var $next = $(this).parents('.field-mega-menu').find('.field-mega-menu-bg');
            if ( $(this).is(':checked') )
                $next.slideDown('fast');
            else
                $next.slideUp('fast');
            $(this).click(function (){
                if ( $(this).is(':checked') )
                    $next.slideDown('fast');
                else
                    $next.slideUp('fast');
            })
        });
    }

    //run icon select and show icon in ajax call
    function pixflow_menuUpdate(){
        'use strict';

        var $ul = $('.menu-edit  ul.menu');

        if ( ! $ul .length )
            return;

        ! function () {
            var ulContent;
            $(document).ajaxStop(function () {
                if(ulContent !== $ul.html()){
                    ulContent = $ul.html();
                    $ul.trigger('contentChanged');
                }
            });
        }();

        $ul.on('contentChanged',function(){

            pixflow_IconSelect();
            pixflow_showIcons();
            pixflow_showMegaBg();

        });
    }

    function pixflow_livePreviewObj() {
        "use strict";

        var $livePreview;
        if ($('#customize-preview > iframe').contents().find('iframe#px-iframe').contents().find('iframe#vc_inline-frame').length) {
            $livePreview = $('#customize-preview > iframe').contents().find('iframe#px-iframe').contents().find('iframe#vc_inline-frame')[0].contentWindow;
        } else {
            if($('#customize-preview > iframe').length){
                $livePreview = $('#customize-preview > iframe')[0].contentWindow;
            }
        }
        if(!$livePreview){
            $livePreview = window;
        }
        if(typeof $livePreview.$ != 'function'){
            $livePreview.$ = jQuery;
        }
        return $livePreview;
    }

    function pixflow_setTabsSorting( view ) {
        'use strict';
        var $controls = $( view.tabsControls().get( 0 ) );
        if ( $controls.hasClass( 'ui-sortable' ) ) {
            $controls.sortable( 'destroy' );
        }
        $controls.sortable( {
            axis: (view.model.get( 'shortcode' ) === 'vc_tour' ||  view.model.get( 'shortcode' ) === 'md_hor_tabs' || view.model.get( 'shortcode' ) === 'md_hor_tabs2'? 'y' : 'x'),
            update: view.stopSorting,
            scroll:false,
            items: "> li:not(.add_tab_block)"
        } );
        // fix: #1019, from http://stackoverflow.com/questions/2451528/jquery-ui-sortable-scroll-helper-element-offset-firefox-issue
        var userAgent = navigator.userAgent.toLowerCase();

        if ( userAgent.match( /firefox/ ) ) {
            $controls.bind( "sortstart", function ( event, ui ) {
                ui.helper.css( 'margin-top', $( window ).scrollTop() );
            } );
            $controls.bind( "sortbeforestop", function ( event, ui ) {
                ui.helper.css( 'margin-top', 0 );
            } );
        }
    };
    function pixflow_shortcodesBetweenShortcodes(){
        if($('iframe')[0].contentWindow.$('.insert-after-row-placeholder-open').length){
            if($('iframe')[0].contentWindow.$('.insert-after-row-placeholder-open:first').prev().length) {
                $('iframe')[0].contentWindow.$('.vc_vc_row:last').insertAfter($('iframe')[0].contentWindow.$('.insert-after-row-placeholder-open:first').parent());
            }else{
                $('iframe')[0].contentWindow.$('.vc_vc_row:last').insertBefore($('iframe')[0].contentWindow.$('.insert-after-row-placeholder-open:first').parent());
            }
            window.vc.app.saveRowOrder();
        }
        $('iframe')[0].contentWindow.$('.insert-after-row-placeholder').remove();

        if($('iframe')[0].contentWindow.$('.insert-between-placeholder-open').length){
            var parentElement = $('iframe')[0].contentWindow.$('.insert-between-placeholder-open:first').parent();
            parentElement.find('.vc_element:last').insertAfter($('iframe')[0].contentWindow.$('.insert-between-placeholder-open:first'));
            window.vc.app.saveElementOrder([], {item:{parent:function(){ return parentElement}},sender:null});
        }
        $('iframe')[0].contentWindow.$('.insert-between-placeholder').remove();
    }

    function pixflow_doBuild(index,t){
        if(!vc.post_shortcodes.length){
            try {
                vc.frame_window.vc_iframe.reload()
            } catch (e) {
                window.console && window.console.error && window.console.error(e)
            }
            return;
        }
        var data = vc.post_shortcodes[index];
        var shortcode = JSON.parse(decodeURIComponent(data + "")), $block = vc.$page.find("[data-model-id=" + shortcode.id + "]"), params = ($block.parents("[data-model-id]"), _.isObject(shortcode.attrs) ? shortcode.attrs : {}), model = vc.shortcodes.create({
            id: shortcode.id,
            shortcode: shortcode.tag,
            params: t.unescapeParams(params),
            parent_id: shortcode.parent_id,
            from_content: !0
        }, {silent: !0});
        $block.attr("data-model-id", model.get("id")), t._renderBlockCallback($block.get(0))
            , vc.frame.setSortable(), t.checkNoContent(), vc.frame.render();
        if(index == vc.post_shortcodes.length-1) {
            try {
                vc.frame_window.vc_iframe.reload()
            } catch (e) {
                window.console && window.console.error && window.console.error(e)
            }
        }else{
            setTimeout(function(){
                pixflow_doBuild(index+1,t);
            },1);
        }
    }
    function pixflow_customShortcodesJs() {
        'use strict';
        try {
            if (_.isUndefined(window.vc)) {
                window.vc = {};
            }
        }catch (e){}
        //Frontend
        try{
            window.InlineShortcodeView.prototype.changed = function(e){
                this.$el.removeClass( 'vc_empty-shortcode-element' );
                this.$el.height() === 0 && this.$el.addClass( 'vc_empty-shortcode-element' );
                this.$el.find('.myLoader div').css({width:'100%'});
                $('iframe')[0].contentWindow.$('.myLoader').remove();

                pixflow_shortcodesBetweenShortcodes();

                var smallShortcodes = [
                    'vc_empty_space',
                    'md_button',
                    'vc_facebook',
                    'vc_tweetmeme',
                    'vc_pinterest',
                    'md_text',
                    'md_separator'
                ];


                var fullShortcodes = [
                    'md_team_member_classic',
                    'vc_empty_space',
                    'md_button',
                    'md_call_to_action',
                    'md_imagebox_full',
                    'md_portfolio_multisize',
                    'md_showcase',
                    'md_blog',
                    'md_blog_carousel',
                    'md_client_normal',
                    'md_instagram',
                    'md_blog_masonry',
                    'md_process_steps',
                    'md_teammember2',
                    'pixflow_subscribe',
                    'md_pricetabel',
                    'md_google_map',
                    'md_masterslider',
                    'md_rev_slider',
                    'md_blog_classic',
                    'vc_facebook',
                    'vc_tweetmeme',
                    'vc_pinterest',
                    'vc_gmaps',
                    'vc_round_chart',
                    'vc_line_chart',
                    'md_product_categories',
                    'md_products',
                    'md_textbox',
                    'md_full_button',
                    'md_testimonial_classic',
                    'md_client_carousel',
                    'md_fancy_text',
                    'md_iconbox_side',
                    'md_iconbox_side2',
                    'md_slider',
                    'md_testimonial_carousel',
                    'md_modern_subscribe',
                    'md_double_slider',
                    'md_skill_style2',
                    'md_slider_carousel',
                    'md_slider',
                    'md_text_box'
                ];
                var alignment = false;
                if(this.$controls_buttons && this.$controls_buttons.find('.vc_control-btn-align').length){
                    alignment = true;
                }
                if(this.$controls_buttons && !this.$controls_buttons.find('.vc_control-btn-left').length && fullShortcodes.indexOf(this.model.attributes.shortcode)==-1) {
                    alignment = true;
                    var $alignControl = $('<span class="vc_control-btn vc_control-btn-align"></span>');
                    this.$controls_buttons.append($alignControl);
                    $alignControl.append('<a class="vc_control-btn vc_control-btn-left" href="#" title="Left"></a>');
                    $alignControl.append('<a class="vc_control-btn vc_control-btn-center" href="#" title="Center"></a>');
                    $alignControl.append('<a class="vc_control-btn vc_control-btn-right" href="#" title="Right"></a>');
                    var el = this;
                    this.$el.find('.vc_control-btn-left').click(function(e){
                        e.preventDefault();
                        var model = el.model;
                        model.attributes.params['align']= 'left' ;
                        el.$el.find('[class *= "md-align-"]')
                            .removeClass('md-align-right')
                            .removeClass('md-align-center')
                            .addClass('md-align-left')
                    })
                    this.$el.find('.vc_control-btn-center').click(function(e){
                        e.preventDefault();
                        var model = el.model;
                        model.attributes.params['align']= 'center' ;
                        el.$el.find('[class *= "md-align-"]')
                            .removeClass('md-align-right')
                            .removeClass('md-align-left')
                            .addClass('md-align-center')
                    })
                    this.$el.find('.vc_control-btn-right').click(function(e){
                        e.preventDefault();
                        var model = el.model;
                        model.attributes.params['align']= 'right' ;
                        el.$el.find('[class *= "md-align-"]')
                            .removeClass('md-align-left')
                            .removeClass('md-align-center')
                            .addClass('md-align-right')
                    })
                }
                var t = this;
                setTimeout(function(){
                    var $mdMoveGizmo = false;
                    if(t.$controls_buttons && t.$controls_buttons.find('.vc_control-btn.vc_element-move .md-move-gizmo').length){
                        $mdMoveGizmo = this.$controls_buttons.find('.vc_control-btn.vc_element-move .md-move-gizmo');
                    }
                    if( t.$controls_buttons && ! t.$controls_buttons.find('.vc_control-btn.vc_element-move .md-move-gizmo').length && t.$el.height() < 100) {
                        var $mdMoveGizmo = $('<div>').addClass('md-move-gizmo');
                        t.$controls_buttons.find('.vc_control-btn.vc_element-move').append($mdMoveGizmo);
                    }

                    if($mdMoveGizmo && alignment) {
                        $mdMoveGizmo.css('left', '200px');
                        t.$controls_buttons.find('.vc_control-btn-edit').css('left',-209);
                        t.$controls_buttons.find('.vc_control-btn-clone').css('left',-107);
                        t.$controls_buttons.find('.vc_control-btn-delete').css('left',-5);
                        t.$controls_buttons.find('.vc_control-btn-align').css('left',97);
                    }
                    else if(!$mdMoveGizmo && !alignment && t.$controls_buttons){
                        t.$controls_buttons.find('.vc_control-btn-edit').css('left',-99);
                        t.$controls_buttons.find('.vc_control-btn-clone').css('left',3);
                        t.$controls_buttons.find('.vc_control-btn-delete').css('left',105);
                    }
                },1000);

            };
            window.InlineShortcodeView.prototype.destroy = function(e){
                _.isObject(e) && e.preventDefault() && e.stopPropagation();
                var thisModel = this.model;
                window.top.pixflow_messageBox(
                    admin_var.areYouSure,
                    'caution',
                    admin_var.deleteMsg,
                    admin_var.deleteMsgYes,
                    function(){
                        thisModel.destroy();
                        window.top.pixflow_closeMessageBox();
                    },
                    admin_var.deleteMsgNo,
                    function(){
                        window.top.pixflow_closeMessageBox();
                    }
                )

            }
            if($.browser.mozilla) {
                vc.ShortcodesBuilder.prototype.buildFromContent = function () {
                    var content = decodeURIComponent(vc.frame_window.jQuery("#vc_template-post-content").html() + "").replace(/\<style([^\>]*)\>\/\*\* vc_js\-placeholder \*\*\//g, "<script$1>").replace(/\<\/style([^\>]*)\>\<\!\-\- vc_js\-placeholder \-\-\>/g, "</script$1>");
                    try {
                        vc.$page.html(content).prepend($('<div class="vc_empty-placeholder"></div>'))
                    } catch (e) {
                        window.console && window.console.error && window.console.error(e)
                    }
                    pixflow_doBuild(0, this);
                }
            }
            window.InlineShortcodeViewContainer.prototype.changed = function(e){
                pixflow_shortcodesBetweenShortcodes();
                this.allowAddControlOnEmpty() && (0 === this.$el.find(".vc_element[data-tag]").length && this.$el.addClass("vc_empty").find("> :first").addClass("vc_empty-element") || this.$el.removeClass("vc_empty").find("> .vc_empty-element").removeClass("vc_empty-element"))
            }
            window.InlineShortcodeView_vc_row.prototype.changed = function ( e ) {
                window.InlineShortcodeView_vc_row.__super__.changed.call( this );
                this.addLayoutClass();
                pixflow_shortcodesBetweenShortcodes();
                try{

                    $('iframe')[0].contentWindow.$('.myLoader').remove();
                    $('iframe')[0].contentWindow.$('#vc_no-content-helper.vc_welcome');
                    $('iframe')[0].contentWindow.pixflow_portfolioMultisize();
                    $('iframe')[0].contentWindow.pixflow_teamMemberClassic(this.el.className, '', 'row_changed'); // Shortcode Team Member classic
                    $('iframe')[0].contentWindow.pixflow_displaySliderShortcode(this.$el);
                    $('iframe')[0].contentWindow.pixflow_tabletSliderShortcode(this.$el);
                    $('iframe')[0].contentWindow.pixflow_mobileSliderShortcode(this.$el);
                    $('iframe')[0].contentWindow.pixflow_musicFitSizes();
                }catch (e){}

            };
/*-------------------------Accordion-----------------------*/
            window.InlineShortcodeView_md_accordion = window.InlineShortcodeView_vc_row.extend( {
                events: {
                    'click > .wpb_accordion > .vc_empty-element': 'addElement'
                },
                render: function () {
                    _.bindAll( this, 'stopSorting' );
                    this.$accordion = this.$el.find( '> .wpb_accordion' );
                    window.InlineShortcodeView_md_accordion.__super__.render.call( this );
                    return this;
                },
                changed: function () {
                    $('iframe#vc_inline-frame').contents().find('.myLoader').remove();
                    if ( this.$el.find( '.vc_element[data-tag]' ).length == 0 ) {
                        this.$el.addClass( 'vc_empty' ).find( '> :first' ).addClass( 'vc_empty-element' );
                    } else {
                        this.$el.removeClass( 'vc_empty' ).find( '> .vc_empty-element' ).removeClass( 'vc_empty-element' );
                        this.setSorting();
                    }
                },
                buildAccordion: function ( active_model ) {
                    var active = false;
                    if ( active_model ) {
                        active = this.$accordion.find( '[data-model-id=' + active_model.get( 'id' ) + ']' ).index();
                    }
                    window.vc.frame_window.vc_iframe.buildAccordion( this.$accordion, active );
                },
                setSorting: function () {
                    window.vc.frame_window.vc_iframe.setAccordionSorting( this );
                },
                beforeUpdate: function () {
                    this.$el.find( '.wpb_accordion_heading' ).remove();
                    window.InlineShortcodeView_md_accordion.__super__.beforeUpdate.call( this );
                },
                stopSorting: function () {
                    this.$accordion.find( '> .wpb_accordion_wrapper > .vc_element[data-tag]' ).each( function () {
                        var model = window.vc.shortcodes.get( $( this ).data( 'modelId' ) );
                        model.save( { order: $( this ).index() }, { silent: true } );
                    } );
                },
                addElement: function ( e ) {
                    e && e.preventDefault();
                    new window.vc.ShortcodesBuilder()
                        .create( {
                            shortcode: 'md_accordion_tab',
                            params: { title: window.i18nLocale.section },
                            parent_id: this.model.get( 'id' )
                        } )
                        .render();
                },
                rowsColumnsConverted: function () {
                    _.each( window.vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                }
            } );


            window.InlineShortcodeView_md_accordion_tab = window.InlineShortcodeView_vc_tab.extend( {
                events: {
                    'click > .vc_controls .vc_element .vc_control-btn-delete': 'destroy',
                    'click > .vc_controls .vc_element .vc_control-btn-edit': 'edit',
                    'click > .vc_controls .vc_element .vc_control-btn-clone': 'clone',
                    'click > .vc_controls .vc_element .vc_control-btn-prepend': 'prependElement',
                    'click > .vc_controls .vc_control-btn-append': 'appendElement',
                    'click > .vc_controls .vc_parent .vc_control-btn-delete': 'destroyParent',
                    'click > .vc_controls .vc_parent .vc_control-btn-edit': 'editParent',
                    'click > .vc_controls .vc_parent .vc_control-btn-clone': 'cloneParent',
                    'click > .vc_controls .vc_parent .vc_control-btn-prepend': 'addSibling',
                    'click > .wpb_accordion_section > .vc_empty-element': 'appendElement',
                    'click > .vc_controls .vc_control-btn-switcher': 'switchControls',
                    'mouseenter': 'resetActive',
                    'mouseleave': 'holdActive'
                },
                changed: function () {
                    $('iframe#vc_inline-frame').contents().find('.myLoader').remove();
                    if ( this.$el.find( '.vc_element[data-tag]' ).length == 0 ) {
                        this.$el.addClass( 'vc_empty' );
                        this.content().addClass( 'vc_empty-element' );
                    } else {
                        this.$el.removeClass( 'vc_empty' );
                        this.content().removeClass( 'vc_empty-element' );
                    }
                },
                render: function () {
                    window.InlineShortcodeView_vc_tab.__super__.render.call( this );
                    if ( ! this.content().find( '.vc_element[data-tag]' ).length ) {
                        this.content().html( '' );
                    }
                    try {
                        this.parent_view.buildAccordion(!this.model.get('from_content') && !this.model.get('default_content') ? this.model : false);
                    }catch (e){}
                    return this;
                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                },
                destroy: function ( e ) {
                    var parent_id = this.model.get( 'parent_id' );
                    window.InlineShortcodeView_md_accordion_tab.__super__.destroy.call( this, e );
                    if ( ! vc.shortcodes.where( { parent_id: parent_id } ).length ) {
                        vc.shortcodes.get( parent_id ).destroy();
                    }
                }
            } );

            /*---------------------------Frontend Toggle ---------------------------------*/

            window.InlineShortcodeView_md_toggle = window.InlineShortcodeView_vc_row.extend( {
                events: {
                    'click > .wpb_md_toggle > .vc_empty-element': 'addElement'
                },
                render: function () {
                    _.bindAll( this, 'stopSorting' );
                    this.$toggle = this.$el.find( '> .wpb_md_toggle' );
                    window.InlineShortcodeView_md_toggle.__super__.render.call( this );
                    return this;
                },
                changed: function () {
                    $('iframe#vc_inline-frame').contents().find('.myLoader').remove();
                    if ( this.$el.find( '.vc_element[data-tag]' ).length == 0 ) {
                        this.$el.addClass( 'vc_empty' ).find( '> :first' ).addClass( 'vc_empty-element' );
                    } else {
                        this.$el.removeClass( 'vc_empty' ).find( '> .vc_empty-element' ).removeClass( 'vc_empty-element' );
                    }
                },

                beforeUpdate: function () {
                    this.$el.find( '.wpb_toggle_heading' ).remove();
                    window.InlineShortcodeView_md_toggle.__super__.beforeUpdate.call( this );
                },
                stopSorting: function () {
                    this.$toggle.find( '> .wpb_toggle_wrapper > .vc_element[data-tag]' ).each( function () {
                        var model = window.vc.shortcodes.get( $( this ).data( 'modelId' ) );
                        model.save( { order: $( this ).index() }, { silent: true } );
                    } );
                },
                addElement: function ( e ) {
                    e && e.preventDefault();
                    new window.vc.ShortcodesBuilder()
                        .create( {
                            shortcode: 'md_toggle_tab',
                            params: { title: window.i18nLocale.section },
                            parent_id: this.model.get( 'id' )
                        } )
                        .render();
                },
                rowsColumnsConverted: function () {
                    _.each( window.vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                }
            } );

            window.InlineShortcodeView_md_toggle_tab = window.InlineShortcodeView_vc_tab.extend( {
                events: {
                    'click > .vc_controls .vc_element .vc_control-btn-delete': 'destroy',
                    'click > .vc_controls .vc_element .vc_control-btn-edit': 'edit',
                    'click > .vc_controls .vc_element .vc_control-btn-clone': 'clone',
                    'click > .vc_controls .vc_element .vc_control-btn-prepend': 'prependElement',
                    'click > .vc_controls .vc_control-btn-append': 'appendElement',
                    'click > .vc_controls .vc_parent .vc_control-btn-delete': 'destroyParent',
                    'click > .vc_controls .vc_parent .vc_control-btn-edit': 'editParent',
                    'click > .vc_controls .vc_parent .vc_control-btn-clone': 'cloneParent',
                    'click > .vc_controls .vc_parent .vc_control-btn-prepend': 'addSibling',
                    'click > .wpb_accordion_section > .vc_empty-element': 'appendElement',
                    'click > .vc_controls .vc_control-btn-switcher': 'switchControls',
                    'mouseenter': 'resetActive',
                    'mouseleave': 'holdActive'
                },
                changed: function () {
                    $('iframe#vc_inline-frame').contents().find('.myLoader').remove();
                    if ( this.$el.find( '.vc_element[data-tag]' ).length == 0 ) {
                        this.$el.addClass( 'vc_empty' );
                        this.content().addClass( 'vc_empty-element' );
                    } else {
                        this.$el.removeClass( 'vc_empty' );
                        this.content().removeClass( 'vc_empty-element' );
                    }
                },
                render: function () {
                    window.InlineShortcodeView_vc_tab.__super__.render.call( this );
                    if ( ! this.content().find( '.vc_element[data-tag]' ).length ) {
                        this.content().html( '' );
                    }
                    this.$el.find('.wpb_accordion_section > h3').click(function(){
                        $(this).parent().find(' > .wpb_toggle_content ').slideToggle();
                        if ($(this).hasClass('ui-state-active')) {
                            $(this).removeClass('ui-state-active').find('.ui-icon-triangle-1-e').removeClass('ui-icon-triangle-1-e').addClass('ui-icon-triangle-1-s');
                        } else {
                            $(this).addClass('ui-state-active').find('.ui-icon-triangle-1-s').removeClass('ui-icon-triangle-1-s').addClass('ui-icon-triangle-1-e');
                        }
                    });


                    return this;
                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                },
                destroy: function ( e ) {
                    var parent_id = this.model.get( 'parent_id' );
                    window.InlineShortcodeView_md_accordion_tab.__super__.destroy.call( this, e );
                    if ( ! vc.shortcodes.where( { parent_id: parent_id } ).length ) {
                        vc.shortcodes.get( parent_id ).destroy();
                    }
                }
            } );

            /*---------------------------Frontend Business Toggle ---------------------------------*/

            window.InlineShortcodeView_md_toggle2 = window.InlineShortcodeView_vc_row.extend( {
                events: {
                    'click > .wpb_md_toggle2 > .vc_empty-element': 'addElement'
                },
                render: function () {
                    _.bindAll( this, 'stopSorting' );
                    this.$toggle = this.$el.find( '> .wpb_md_toggle2' );
                    window.InlineShortcodeView_md_toggle2.__super__.render.call( this );
                    return this;
                },
                changed: function () {
                    $('iframe#vc_inline-frame').contents().find('.myLoader').remove();
                    if ( this.$el.find( '.vc_element[data-tag]' ).length == 0 ) {
                        this.$el.addClass( 'vc_empty' ).find( '> :first' ).addClass( 'vc_empty-element' );
                    } else {
                        this.$el.removeClass( 'vc_empty' ).find( '> .vc_empty-element' ).removeClass( 'vc_empty-element' );
                    }
                },

                beforeUpdate: function () {
                    this.$el.find( '.wpb_toggle_heading' ).remove();
                    window.InlineShortcodeView_md_toggle2.__super__.beforeUpdate.call( this );
                },
                stopSorting: function () {
                    this.$toggle.find( '> .wpb_toggle_wrapper > .vc_element[data-tag]' ).each( function () {
                        var model = window.vc.shortcodes.get( $( this ).data( 'modelId' ) );
                        model.save( { order: $( this ).index() }, { silent: true } );
                    } );
                },
                addElement: function ( e ) {
                    e && e.preventDefault();
                    new window.vc.ShortcodesBuilder()
                        .create( {
                            shortcode: 'md_toggle_tab2',
                            params: { title: window.i18nLocale.section },
                            parent_id: this.model.get( 'id' )
                        } )
                        .render();
                },
                rowsColumnsConverted: function () {
                    _.each( window.vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                }
            } );

            window.InlineShortcodeView_md_toggle_tab2 = window.InlineShortcodeView_vc_tab.extend( {
                events: {
                    'click > .vc_controls .vc_element .vc_control-btn-delete': 'destroy',
                    'click > .vc_controls .vc_element .vc_control-btn-edit': 'edit',
                    'click > .vc_controls .vc_element .vc_control-btn-clone': 'clone',
                    'click > .vc_controls .vc_element .vc_control-btn-prepend': 'prependElement',
                    'click > .vc_controls .vc_control-btn-append': 'appendElement',
                    'click > .vc_controls .vc_parent .vc_control-btn-delete': 'destroyParent',
                    'click > .vc_controls .vc_parent .vc_control-btn-edit': 'editParent',
                    'click > .vc_controls .vc_parent .vc_control-btn-clone': 'cloneParent',
                    'click > .vc_controls .vc_parent .vc_control-btn-prepend': 'addSibling',
                    'click > .wpb_accordion_section > .vc_empty-element': 'appendElement',
                    'click > .vc_controls .vc_control-btn-switcher': 'switchControls',
                    'mouseenter': 'resetActive',
                    'mouseleave': 'holdActive'
                },
                changed: function () {
                    $('iframe#vc_inline-frame').contents().find('.myLoader').remove();
                    if ( this.$el.find( '.vc_element[data-tag]' ).length == 0 ) {
                        this.$el.addClass( 'vc_empty' );
                        this.content().addClass( 'vc_empty-element' );
                    } else {
                        this.$el.removeClass( 'vc_empty' );
                        this.content().removeClass( 'vc_empty-element' );
                    }
                },
                render: function () {
                    window.InlineShortcodeView_vc_tab.__super__.render.call( this );
                    if ( ! this.content().find( '.vc_element[data-tag]' ).length ) {
                        this.content().html( '' );
                    }
                    this.$el.find('.wpb_accordion_section > h3').click(function(){
                        $(this).parent().find(' > .wpb_toggle_content ').slideToggle();
                        if ($(this).hasClass('ui-state-active')) {
                            $(this).removeClass('ui-state-active').find('.ui-icon-triangle-1-e').removeClass('ui-icon-triangle-1-e').addClass('ui-icon-triangle-1-s');
                        } else {
                            $(this).addClass('ui-state-active').find('.ui-icon-triangle-1-s').removeClass('ui-icon-triangle-1-s').addClass('ui-icon-triangle-1-e');
                        }
                    })
                    return this;
                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                },
                destroy: function ( e ) {
                    var parent_id = this.model.get( 'parent_id' );
                    window.InlineShortcodeView_md_accordion_tab.__super__.destroy.call( this, e );
                    if ( ! vc.shortcodes.where( { parent_id: parent_id } ).length ) {
                        vc.shortcodes.get( parent_id ).destroy();
                    }
                }
            } );

            /*-------------------------Frontend Tab---------------------------*/
            window.InlineShortcodeView_md_tab = window.InlineShortcodeViewContainerWithParent.extend( {
                controls_selector: '#vc_controls-template-vc_tab',
                render: function () {
                    var tab_id, active, params;
                    params = this.model.get( 'params' );

                    window.InlineShortcodeView_md_tab.__super__.render.call( this );
                    this.$tab = this.$el.find( '> :first' );

                    if ( _.isEmpty( params.tab_id ) ) {
                        params.tab_id = vc_guid() + '-' + Math.floor( Math.random() * 11 );
                        this.model.save( 'params', params );
                        tab_id = 'tab-' + params.tab_id;
                        this.$tab.attr( 'id', tab_id );
                    } else {
                        tab_id = this.$tab.attr( 'id' );
                    }

                    this.$el.attr( 'id', tab_id );
                    this.$tab.attr( 'id', tab_id + '-real' );
                    if ( ! this.$tab.find( '.vc_element[data-tag]' ).length ) {
                        this.$tab.html( '' );
                    }
                    this.$el.addClass( 'ui-tabs-panel wpb_ui-tabs-hide' );
                    this.$tab.removeClass( 'ui-tabs-panel wpb_ui-tabs-hide' );
                    if ( this.parent_view && this.parent_view.addTab ) {
                        if ( ! this.parent_view.addTab( this.model ) ) {
                            this.$el.removeClass( 'wpb_ui-tabs-hide' );
                        }
                    }
                    active = this.doSetAsActive();
                    try {
                        this.$el.closest('.vc_md_tabs').find('.md-tab-add-tab').parent().remove();
                        this.parent_view.buildTabs(active);
                        this.$el.closest('.vc_md_tabs').find('.wpb_tabs_nav').append('<li><a style="cursor: pointer;padding:30px 35px;min-height:84px" class="md-tab-add-tab vc_control-btn"><strong>+</strong>ADD TAB</a></li>');
                        this.$el.closest('.vc_md_tabs').find('.md-tab-add-tab').click(function(e){
                            e.preventDefault();
                            $(this).parent().parent().find('a.vc_control-btn[title="ADD TAB"] .vc_btn-content').click();
                        })
                    }catch (e){}
                    return this;
                },
                doSetAsActive: function () {
                    var active_before_cloned = this.model.get( 'active_before_cloned' );
                    if ( ! this.model.get( 'from_content' ) && ! this.model.get( 'default_content' ) && _.isUndefined( active_before_cloned ) ) {
                        return this.model;
                    } else if ( ! _.isUndefined( active_before_cloned ) ) {
                        this.model.unset( 'active_before_cloned' );
                        if ( active_before_cloned === true ) {
                            return this.model;
                        }
                    }

                    return false;
                },
                removeView: function ( model ) {
                    window.InlineShortcodeView_md_tab.__super__.removeView.call( this, model );
                    if ( this.parent_view && this.parent_view.removeTab ) {
                        this.parent_view.removeTab( model );
                    }
                },
                clone: function ( e ) {
                    _.isObject( e ) && e.preventDefault() && e.stopPropagation();
                    vc.clone_index = vc.clone_index / 10;
                    var clone = this.model.clone(),
                        params = clone.get( 'params' ),
                        builder = new vc.ShortcodesBuilder();
                    var newmodel = vc.CloneModel( builder, this.model, this.model.get( 'parent_id' ) );
                    var active_model = this.parent_view.active_model_id;
                    var that = this;
                    builder.render( function () {
                        if ( that.parent_view.cloneTabAfter ) {
                            that.parent_view.cloneTabAfter( newmodel );
                        }
                    } );

                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                }
            } );

            window.InlineShortcodeView_md_tabs = window.InlineShortcodeView_vc_row.extend( {
                events: {
                    'click > :first > .vc_empty-element': 'addElement',
                    'click .md-tab-add-tab': 'addElement',
                    'click > :first > .wpb_wrapper > .ui-tabs-nav > li': 'setActiveTab'
                },
                already_build: false,
                active_model_id: false,
                $tabsNav: false,
                active: 0,
                render: function () {
                    _.bindAll( this, 'stopSorting' );
                    this.$tabs = this.$el.find( '> .wpb_tabs' );
                    window.InlineShortcodeView_md_tabs.__super__.render.call( this );
                    this.buildNav();
                    return this;
                },

                buildNav: function () {
                    var $nav = this.tabsControls();
                    this.$tabs.find( '> .wpb_wrapper > .vc_element[data-tag="md_tab"]' ).each( function ( key ) {
                        $( 'li:eq(' + key + ')', $nav ).attr( 'data-m-id', $( this ).data( 'model-id' ) );
                    } );
                },
                changed: function () {
                    $('iframe#vc_inline-frame').contents().find('.myLoader').remove();
                    if ( this.$el.find( '.vc_element[data-tag]' ).length == 0 ) {
                        this.$el.addClass( 'vc_empty' ).find( '> :first > div' ).addClass( 'vc_empty-element' );
                    } else {
                        this.$el.removeClass( 'vc_empty' ).find( '> :first > div' ).removeClass( 'vc_empty-element' );
                    }
                    this.setSorting();
                },
                setActiveTab: function ( e ) {
                    var $tab = $( e.currentTarget );
                    this.active_model_id = $tab.data( 'm-id' );
                    },
                tabsControls: function () {
                    return this.$tabsNav ? this.$tabsNav : this.$tabsNav = this.$el.find( '.wpb_tabs_nav' );
                },
                buildTabs: function ( active_model ) {
                    if ( active_model ) {
                        this.active_model_id = active_model.get( 'id' );
                        this.active = this.tabsControls().find( '[data-m-id=' + this.active_model_id + ']' ).index();
                        this.tabsControls().find( '[data-m-id=' + this.active_model_id + ']' ).click();
                    }else{
                        this.tabsControls().find( 'li:first').click();
                    }
                    if ( this.active_model_id === false ) {
                        var active_el = this.tabsControls().find( 'li:first' );
                        this.active = active_el.index();
                        this.active_model_id = active_el.data( 'm-id' );
                    }
                    if ( ! this.checkCount() ) {
                        vc.frame_window.vc_iframe.buildTabs( this.$tabs, this.active );
                    }
                },
                checkCount: function () {
                    return this.$tabs.find( '> .wpb_wrapper > .vc_element[data-tag="md_tab"]' ).length != this.$tabs.find( '> .wpb_wrapper > .vc_element.vc_md_tab' ).length;
                },
                beforeUpdate: function () {
                    this.$tabs.find( '.wpb_tabs_heading' ).remove();
                    vc.frame_window.vc_iframe.destroyTabs( this.$tabs );
                },
                updated: function () {
                    window.InlineShortcodeView_md_tabs.__super__.updated.call( this );
                    if(this.$tabs.find( '.wpb_tabs_nav').length >1) {
                        this.$tabs.find('.wpb_tabs_nav:first').remove();
                    }else{
                        this.$tabs.find('.wpb_tabs_nav:first > li a.md-tab-add-tab')[0].click();
                        this.$tabs.find('.wpb_tabs_nav:first > li a.md-tab-add-tab')[0].click();
                    }
                    this.buildNav();
                    vc.frame_window.vc_iframe.buildTabs( this.$tabs );
                    this.setSorting();
                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                },

                addTab: function ( model ) {

                    if ( this.updateIfExistTab( model ) ) {
                        return false;
                    }
                    var $control = this.buildControlHtml( model ),
                        $cloned_tab;
                    if ( model.get( 'cloned' ) && ($cloned_tab = this.tabsControls().find( '[data-m-id=' + model.get( 'cloned_from' ).id + ']' )).length ) {
                        if ( ! model.get( 'cloned_appended' ) ) {
                            $control.appendTo( this.tabsControls() );
                            model.set( 'cloned_appended', true );
                        }
                    } else {
                        $control.appendTo( this.tabsControls() );
                    }
                    this.changed();
                    return true;
                },
                cloneTabAfter: function ( model ) {
                    this.$tabs.find( '> .wpb_wrapper > .wpb_tabs_nav > div' ).remove();
                    this.buildTabs( model );
                },
                updateIfExistTab: function ( model ) {
                    var $tab = this.tabsControls().find( '[data-m-id=' + model.get( 'id' ) + ']' );
                    if ( $tab.length ) {
                        $tab.attr( 'aria-controls', 'tab-' + model.getParam( 'tab_id' ) )
                            .find( 'a' )
                            .attr( 'href', '#tab-' + model.getParam( 'tab_id' ) )
                            .html("<i class='left-icon "+model.getParam( 'tab_icon_class')+"'></i><span>"+ model.getParam( 'title' )+"</span>");

                        return true;
                    }
                    return false;
                },
                buildControlHtml: function ( model ) {
                    var params = model.get( 'params' ),
                        $tab = $( '<li data-m-id="' + model.get( 'id' ) + '"><a href="#tab-' + model.getParam( 'tab_id' ) + '"></a></li>' );
                    $tab.data( 'model', model );
                    $tab.find( '> a' ).html('<i class="left-icon '+params.tab_icon_class+'"></i><span>'+ model.getParam( 'title' )+'</span>' );
                    return $tab;
                },
                addElement: function ( e ) {
                    e && e.preventDefault();
                    new vc.ShortcodesBuilder()
                        .create( {
                            shortcode: 'md_tab',
                            params: {
                                tab_id: vc_guid() + '-' + this.tabsControls().find( 'li' ).length,
                                title: this.getDefaultTabTitle()
                            },
                            parent_id: this.model.get( 'id' )
                        } )
                        .render();
                },
                getDefaultTabTitle: function () {
                    return window.i18nLocale.tab;
                },
                setSorting: function () {
                    if ( this.hasUserAccess() ) {
                        pixflow_setTabsSorting( this );

                    }
                    if($('body').hasClass('vc_editor')){
                        pixflow_livePreviewObj().$('.md-tab-add-tab').parent().remove();
                        pixflow_livePreviewObj().$('.vc_md_tabs .wpb_tabs_nav').append('<li><a style="cursor: pointer;padding:30px 35px;min-height:84px" class="md-tab-add-tab vc_control-btn"><strong>+</strong>'+admin_var.addTab+'</a></li>');
                        pixflow_livePreviewObj().$('.md-tab-add-tab').click(function(e){
                            e.preventDefault();
                            $(this).parent().parent().find('a.vc_control-btn[title="ADD TAB"] .vc_btn-content').click();
                        })
                    }
                },
                stopSorting: function ( event, ui ) {
                    this.tabsControls().find( '> li' ).each( function ( key, value ) {
                        if($( this ).attr('data-m-id') != '')
                            var id = $( this ).data( 'm-id' );
                        else
                            var id = $( this ).data( 'model-id' );
                        var model = window.vc.shortcodes.get( id );
                        try {
                            model.save({order: key}, {silent: true});
                        }catch (e){}
                    } );
                },
                placeElement: function ( $view, activity ) {
                    var model = vc.shortcodes.get( $view.data( 'modelId' ) );
                    if ( model && model.get( 'place_after_id' ) ) {
                        $view.insertAfter( vc.$page.find( '[data-model-id=' + model.get( 'place_after_id' ) + ']' ) );
                        model.unset( 'place_after_id' );
                    } else {
                        $view.insertAfter( this.tabsControls() );
                    }
                    this.changed();

                },
                removeTab: function ( model ) {
                    if ( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ).length == 1 ) {
                        return this.model.destroy();
                    }
                    var $tab = this.tabsControls().find( '[data-m-id=' + model.get( 'id' ) + ']' ),
                        index = $tab.index();
                    if ( this.tabsControls().find( '[data-m-id]:eq(' + (index + 1) + ')' ).length ) {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, (index + 1) );
                    } else if ( this.tabsControls().find( '[data-m-id]:eq(' + (index - 1) + ')' ).length ) {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, (index - 1) );
                    } else {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, 0 );
                    }
                    $tab.remove();
                    this.tabsControls().find('.ui-state-active').click();
                },
                clone: function ( e ) {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.set( 'active_before_cloned', this.active_model_id === model.get( 'id' ) );
                    }, this );
                    window.InlineShortcodeView_md_tabs.__super__.clone.call( this, e );
                }

            });
/*-------------------------Frontend Modern Tab---------------------------*/
            window.InlineShortcodeView_md_modernTab = window.InlineShortcodeViewContainerWithParent.extend( {
                controls_selector: '#vc_controls-template-vc_tab',
                render: function () {
                    var tab_id, active, params;
                    params = this.model.get( 'params' );

                    window.InlineShortcodeView_md_modernTab.__super__.render.call( this );
                    this.$tab = this.$el.find( '> :first' );

                    if ( _.isEmpty( params.tab_id ) ) {
                        params.tab_id = vc_guid() + '-' + Math.floor( Math.random() * 11 );
                        this.model.save( 'params', params );
                        tab_id = 'tab-' + params.tab_id;
                        this.$tab.attr( 'id', tab_id );
                    } else {
                        tab_id = this.$tab.attr( 'id' );
                    }

                    this.$el.attr( 'id', tab_id );
                    this.$tab.attr( 'id', tab_id + '-real' );
                    if ( ! this.$tab.find( '.vc_element[data-tag]' ).length ) {
                        this.$tab.html( '' );
                    }
                    this.$el.addClass( 'ui-tabs-panel wpb_ui-tabs-hide' );
                    this.$tab.removeClass( 'ui-tabs-panel wpb_ui-tabs-hide' );
                    if ( this.parent_view && this.parent_view.addTab ) {
                        if ( ! this.parent_view.addTab( this.model ) ) {
                            this.$el.removeClass( 'wpb_ui-tabs-hide' );
                        }
                    }
                    active = this.doSetAsActive();
                    try {
                        this.$el.closest('.vc_md_modernTabs').find('.md-modernTab-add-tab').parent().remove();
                        this.$el.closest('.vc_md_modernTabs').find('.wpb_tabs_nav').append('<li><a style="cursor: pointer;padding:23px 0px;min-height:84px" class="md-modernTab-add-tab vc_control-btn"><strong>+</strong><div class="modernTabTitle">ADD TAB</div></a></li>');
                        this.parent_view.buildTabs(active);
                        this.$el.closest('.vc_md_modernTabs').find('.md-modernTab-add-tab').click(function(e){
                            e.preventDefault();
                            $(this).parent().parent().find('a.vc_control-btn[title="ADD TAB"] .vc_btn-content').click();
                        })
                    }catch (e){}
                    return this;
                },
                doSetAsActive: function () {
                    var active_before_cloned = this.model.get( 'active_before_cloned' );
                    if ( ! this.model.get( 'from_content' ) && ! this.model.get( 'default_content' ) && _.isUndefined( active_before_cloned ) ) {
                        return this.model;
                    } else if ( ! _.isUndefined( active_before_cloned ) ) {
                        this.model.unset( 'active_before_cloned' );
                        if ( active_before_cloned === true ) {
                            return this.model;
                        }
                    }

                    return false;
                },
                removeView: function ( model ) {
                    window.InlineShortcodeView_md_modernTab.__super__.removeView.call( this, model );
                    if ( this.parent_view && this.parent_view.removeTab ) {
                        this.parent_view.removeTab( model );
                    }
                },
                clone: function ( e ) {
                    _.isObject( e ) && e.preventDefault() && e.stopPropagation();
                    vc.clone_index = vc.clone_index / 10;
                    var clone = this.model.clone(),
                        params = clone.get( 'params' ),
                        builder = new vc.ShortcodesBuilder();
                    var newmodel = vc.CloneModel( builder, this.model, this.model.get( 'parent_id' ) );
                    var active_model = this.parent_view.active_model_id;
                    var that = this;
                    builder.render( function () {
                        if ( that.parent_view.cloneTabAfter ) {
                            that.parent_view.cloneTabAfter( newmodel );
                        }
                    } );
                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                }
            } );

            window.InlineShortcodeView_md_modernTabs = window.InlineShortcodeView_vc_row.extend( {
                events: {
                    'click > :first > .vc_empty-element': 'addElement',
                    'click .md-modernTab-add-tab': 'addElement',
                    'click > :first > .wpb_wrapper > .ui-tabs-nav > li': 'setActiveTab'
                },
                already_build: false,
                active_model_id: false,
                $tabsNav: false,
                active: 0,
                render: function () {
                    _.bindAll( this, 'stopSorting' );
                    this.$tabs = this.$el.find( '> .wpb_tabs' );
                    window.InlineShortcodeView_md_modernTabs.__super__.render.call( this );
                    this.buildNav();
                    return this;
                },

                buildNav: function () {
                    var $nav = this.tabsControls();
                    this.$tabs.find( '> .wpb_wrapper > .vc_element[data-tag="md_modernTab"]' ).each( function ( key ) {
                        $( 'li:eq(' + key + ')', $nav ).attr( 'data-m-id', $( this ).data( 'model-id' ) );
                    } );
                },
                changed: function () {
                    $('iframe#vc_inline-frame').contents().find('.myLoader').remove();
                    if ( this.$el.find( '.vc_element[data-tag]' ).length == 0 ) {
                        this.$el.addClass( 'vc_empty' ).find( '> :first > div' ).addClass( 'vc_empty-element' );
                    } else {
                        this.$el.removeClass( 'vc_empty' ).find( '> :first > div' ).removeClass( 'vc_empty-element' );
                    }
                    this.setSorting();
                },
                setActiveTab: function ( e ) {
                    var $tab = $( e.currentTarget );
                    this.active_model_id = $tab.data( 'm-id' );
                },
                tabsControls: function () {
                    return this.$el.find( '.wpb_tabs_nav:first' );
                    return this.$tabsNav ? this.$tabsNav : this.$tabsNav = this.$el.find( '.wpb_tabs_nav' );
                },
                buildTabs: function ( active_model ) {
                    if ( active_model ) {
                        this.active_model_id = active_model.get( 'id' );
                        this.active = this.tabsControls().find( '[data-m-id=' + this.active_model_id + ']' ).index();
                        this.tabsControls().find( '[data-m-id=' + this.active_model_id + ']').click();
                    }else{
                        this.tabsControls().find( 'li:first').click();
                    }
                    if ( this.active_model_id === false ) {
                        var active_el = this.tabsControls().find( 'li:first' );
                        this.active = active_el.index();
                        this.active_model_id = active_el.data( 'm-id' );
                    }
                    if ( ! this.checkCount() ) {
                        vc.frame_window.vc_iframe.buildTabs( this.$tabs, this.active );
                    }
                },
                checkCount: function () {
                    return this.$tabs.find( '> .wpb_wrapper > .vc_element[data-tag="md_modernTab"]' ).length != this.$tabs.find( '> .wpb_wrapper > .vc_element.vc_md_modernTab' ).length;
                },
                beforeUpdate: function () {
                    this.$tabs.find( '.wpb_tabs_heading' ).remove();
                    vc.frame_window.vc_iframe.destroyTabs( this.$tabs );
                },
                updated: function () {

                    window.InlineShortcodeView_md_modernTabs.__super__.updated.call( this );
                    if(this.$tabs.find( '.wpb_tabs_nav').length >1) {
                        this.$tabs.find('.wpb_tabs_nav:first').remove();
                    }else{
                        this.$tabs.find('.wpb_tabs_nav:first > li a.md-modernTab-add-tab')[0].click();
                        this.$tabs.find('.wpb_tabs_nav:first > li a.md-modernTab-add-tab')[0].click();
                    }
                    this.buildNav();
                    vc.frame_window.vc_iframe.buildTabs( this.$tabs );
                    this.setSorting();
                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                },

                addTab: function ( model ) {
                    if ( this.updateIfExistTab( model ) ) {
                        return false;
                    }

                    var $control = this.buildControlHtml( model ),
                        $cloned_tab;
                    if ( model.get( 'cloned' ) && ($cloned_tab = this.tabsControls().find( '[data-m-id=' + model.get( 'cloned_from' ).id + ']' )).length ) {
                        if ( ! model.get( 'cloned_appended' ) ) {
                            $control.appendTo( this.tabsControls() );
                            model.set( 'cloned_appended', true );
                        }
                    } else {
                        $control.appendTo( this.tabsControls() );
                    }
                    this.changed();
                    return true;
                },
                cloneTabAfter: function ( model ) {
                    this.$tabs.find( '> .wpb_wrapper > .wpb_tabs_nav > div' ).remove();
                    this.buildTabs( model );
                },
                updateIfExistTab: function ( model ) {
                    var $tab = this.tabsControls().find( '[data-m-id=' + model.get( 'id' ) + ']' );
                    var $html='',
                        fontSize;
                    if(model.getParam('tab_icon_class')!='') {
                        $html += "<i class='left-icon " + model.getParam('tab_icon_class') + "'></i>";
                    }else {
                        fontSize=parseInt($tab.attr( 'aria-controls', 'tab-' + model.getParam( 'tab_id' ) )
                            .find( 'a' ).css('font-size'));
                        fontSize=fontSize+5;
                        $html += "<i class='left-icon' style='font-size:"+fontSize+"px'></i>";
                    }

                    if(model.getParam('title')!='') {
                        $html += "<div class='modernTabTitle'>" + model.getParam('title') + '</div>';
                    }else {
                        $html += "<div class='modernTabTitle'></div>";
                    }
                    if ( $tab.length ) {
                        $tab.attr( 'aria-controls', 'tab-' + model.getParam( 'tab_id' ) )
                            .find( 'a' )
                            .attr( 'href', '#tab-' + model.getParam( 'tab_id' ) )
                            .html($html );
                        if(model.getParam('title')=='' && model.getParam('tab_icon_class')=='icon-') {
                            $tab.attr('aria-controls', 'tab-' + model.getParam('tab_id')).find('a')
                                .attr('href', '#tab-' + model.getParam('tab_id')).parent().css('display', 'none');
                        }
                        return true;
                    }
                    return false;
                },
                buildControlHtml: function ( model ) {
                    var params = model.get( 'params' ),
                        $tab = $( '<li data-m-id="' + model.get( 'id' ) + '"><a href="#tab-' + model.getParam( 'tab_id' ) + '"></a></li>' );
                    $tab.data( 'model', model );
                    $tab.find( '> a' ).html('<i class="left-icon '+params.tab_icon_class+'"></i><div class="modernTabTitle">'+ model.getParam( 'title' )+'</div>' );
                    return $tab;
                },
                addElement: function ( e ) {
                    e && e.preventDefault();
                    new vc.ShortcodesBuilder()
                        .create( {
                            shortcode: 'md_modernTab',
                            params: {
                                tab_id: vc_guid() + '-' + this.tabsControls().find( 'li' ).length,
                                title: this.getDefaultTabTitle(),
                                tab_icon_class:'icon-cog'
                            },
                            parent_id: this.model.get( 'id' )
                        } )
                        .render();
                },
                getDefaultTabTitle: function () {
                    return window.i18nLocale.tab;
                },
                setSorting: function () {
                    if ( this.hasUserAccess() ) {
                        pixflow_setTabsSorting( this );

                    }
                    if($('body').hasClass('vc_editor')){
                        pixflow_livePreviewObj().$('.md-modernTab-add-tab').parent().remove();
                        pixflow_livePreviewObj().$('.md_modernTab .wpb_tabs_nav').append('<li><a style="cursor: pointer;padding:23px 0px;min-height:84px" class="md-modernTab-add-tab vc_control-btn"><strong>+</strong><div class="modernTabTitle">'+admin_var.addTab+'</div></a></li>');
                        pixflow_livePreviewObj().$('.md-modernTab-add-tab').click(function(e){
                            e.preventDefault();
                            $(this).parent().parent().find('a.vc_control-btn[title="ADD TAB"] .vc_btn-content').click();
                        })
                    }
                },
                stopSorting: function ( event, ui ) {
                    this.tabsControls().find( '> li' ).each( function ( key, value ) {
                        if($( this ).attr('data-m-id') != '')
                            var id = $( this ).data( 'm-id' );
                        else
                            var id = $( this ).data( 'model-id' );
                        var model = window.vc.shortcodes.get( id );
                        try {
                            model.save({order: key}, {silent: true});
                        }catch (e){}
                    } );
                },
                placeElement: function ( $view, activity ) {
                    var model = vc.shortcodes.get( $view.data( 'modelId' ) );
                    if ( model && model.get( 'place_after_id' ) ) {
                        $view.insertAfter( vc.$page.find( '[data-model-id=' + model.get( 'place_after_id' ) + ']' ) );
                        model.unset( 'place_after_id' );
                    } else {
                        $view.insertAfter( this.tabsControls() );
                    }
                    this.changed();

                },
                removeTab: function ( model ) {
                    if ( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ).length == 1 ) {
                        return this.model.destroy();
                    }
                    var $tab = this.tabsControls().find( '[data-m-id=' + model.get( 'id' ) + ']' ),
                        index = $tab.index();
                    if ( this.tabsControls().find( '[data-m-id]:eq(' + (index + 1) + ')' ).length ) {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, (index + 1) );
                    } else if ( this.tabsControls().find( '[data-m-id]:eq(' + (index - 1) + ')' ).length ) {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, (index - 1) );
                    } else {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, 0 );
                    }
                    $tab.remove();
                    this.tabsControls().find('.ui-state-active').click();
                },
                clone: function ( e ) {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.set( 'active_before_cloned', this.active_model_id === model.get( 'id' ) );
                    }, this );
                    window.InlineShortcodeView_md_modernTabs.__super__.clone.call( this, e );
                }

            });

            /*-------------------------Frontend Horizontal Tab---------------------------*/
            window.InlineShortcodeView_md_hor_tab = window.InlineShortcodeViewContainerWithParent.extend( {
                controls_selector: '#vc_controls-template-vc_tab',
                render: function () {
                    var tab_id, active, params;
                    params = this.model.get( 'params' );
                    window.InlineShortcodeView_md_hor_tab.__super__.render.call( this );
                    this.$tab = this.$el.find( '> :first' );
                    if ( _.isEmpty( params.tab_id ) ) {
                        params.tab_id = vc_guid() + '-' + Math.floor( Math.random() * 11 );
                        this.model.save( 'params', params );
                        tab_id = 'tab-' + params.tab_id;
                        this.$tab.attr( 'id', tab_id );
                    } else {
                        tab_id = this.$tab.attr( 'id' );
                    }
                    this.$el.attr( 'id', tab_id );
                    this.$tab.attr( 'id', tab_id + '-real' );
                    if ( ! this.$tab.find( '.vc_element[data-tag]' ).length ) {
                        this.$tab.html( '' );
                    }
                    this.$el.addClass( 'ui-tabs-panel wpb_ui-tabs-hide' );
                    this.$tab.removeClass( 'ui-tabs-panel wpb_ui-tabs-hide' );
                    if ( this.parent_view && this.parent_view.addTab ) {
                        if ( ! this.parent_view.addTab( this.model ) ) {
                            this.$el.removeClass( 'wpb_ui-tabs-hide' );
                        }
                    }
                    active = this.doSetAsActive();
                    try {
                        this.parent_view.buildTabs(active);
                    }catch (e){}
                    return this;
                },
                doSetAsActive: function () {
                    var active_before_cloned = this.model.get( 'active_before_cloned' );
                    if ( ! this.model.get( 'from_content' ) && ! this.model.get( 'default_content' ) && _.isUndefined( active_before_cloned ) ) {
                        return this.model;
                    } else if ( ! _.isUndefined( active_before_cloned ) ) {
                        this.model.unset( 'active_before_cloned' );
                        if ( active_before_cloned === true ) {
                            return this.model;
                        }
                    }
                    return false;
                },
                removeView: function ( model ) {
                    window.InlineShortcodeView_md_hor_tab.__super__.removeView.call( this, model );
                    if ( this.parent_view && this.parent_view.removeTab ) {
                        this.parent_view.removeTab( model );
                    }
                },
                clone: function ( e ) {
                    _.isObject( e ) && e.preventDefault() && e.stopPropagation();
                    vc.clone_index = vc.clone_index / 10;
                    var clone = this.model.clone(),
                        params = clone.get( 'params' ),
                        builder = new vc.ShortcodesBuilder();
                    var newmodel = vc.CloneModel( builder, this.model, this.model.get( 'parent_id' ) );
                    var active_model = this.parent_view.active_model_id;
                    var that = this;
                    builder.render( function () {
                        if ( that.parent_view.cloneTabAfter ) {
                            that.parent_view.cloneTabAfter( newmodel );
                        }
                    } );
                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                }
            } );

            window.InlineShortcodeView_md_hor_tabs = window.InlineShortcodeView_vc_row.extend( {
                events: {
                    'click > :first > .vc_empty-element': 'addElement',
                    'click .md-hor-tab-add-tab': 'addElement',
                    'click > :first > .wpb_wrapper > .ui-tabs-nav > li': 'setActiveTab'
                },
                already_build: false,
                active_model_id: false,
                $tabsNav: false,
                active: 0,
                render: function () {
                    _.bindAll( this, 'stopSorting' );
                    this.$tabs = this.$el.find( '> .wpb_tabs' );
                    window.InlineShortcodeView_md_hor_tabs.__super__.render.call( this );
                    this.buildNav();
                    return this;
                },
                buildNav: function () {
                    var $nav = this.tabsControls();
                    this.$tabs.find( '> .wpb_wrapper > .vc_element[data-tag="md_hor_tab"]' ).each( function ( key ) {
                        $( 'li:eq(' + key + ')', $nav ).attr( 'data-m-id', $( this ).data( 'model-id' ) );
                    } );
                },
                changed: function () {
                    $('iframe#vc_inline-frame').contents().find('.myLoader').remove();
                    if ( this.$el.find( '.vc_element[data-tag]' ).length == 0 ) {
                        this.$el.addClass( 'vc_empty' ).find( '> :first > div' ).addClass( 'vc_empty-element' );
                    } else {
                        this.$el.removeClass( 'vc_empty' ).find( '> :first > div' ).removeClass( 'vc_empty-element' );
                    }
                    this.setSorting();
                },
                setActiveTab: function ( e ) {
                    var $tab = $( e.currentTarget );
                    this.active_model_id = $tab.data( 'm-id' );
                },
                tabsControls: function () {
                    return this.$el.find( '.wpb_tabs_nav:first' );
                    return this.$tabsNav ? this.$tabsNav : this.$tabsNav = this.$el.find( '.wpb_tabs_nav' );
                },
                buildTabs: function ( active_model ) {
                    if ( active_model ) {
                        this.active_model_id = active_model.get( 'id' );
                        this.active = this.tabsControls().find( '[data-m-id=' + this.active_model_id + ']' ).index();
                        this.tabsControls().find( '[data-m-id=' + this.active_model_id + ']').click();
                    }else{
                        this.tabsControls().find( 'li:first').click();
                    }
                    if ( this.active_model_id === false ) {
                        var active_el = this.tabsControls().find( 'li:first' );
                        this.active = active_el.index();
                        this.active_model_id = active_el.data( 'm-id' );
                    }
                    if ( ! this.checkCount() ) {
                        vc.frame_window.vc_iframe.buildTabs( this.$tabs, this.active );
                    }
                },
                checkCount: function () {
                    return this.$tabs.find( '> .wpb_wrapper > .vc_element[data-tag="md_hor_tab"]' ).length != this.$tabs.find( '> .wpb_wrapper > .vc_element.vc_md_hor_tab' ).length;
                },
                beforeUpdate: function () {
                    this.$tabs.find( '.wpb_tabs_heading' ).remove();
                    vc.frame_window.vc_iframe.destroyTabs( this.$tabs );
                },
                updated: function () {
                    window.InlineShortcodeView_md_hor_tabs.__super__.updated.call( this );
                    if(this.$tabs.find( '.wpb_tabs_nav').length >1) {
                        this.$tabs.find('.wpb_tabs_nav:first').remove();
                    }
                    this.buildNav();
                    vc.frame_window.vc_iframe.buildTabs( this.$tabs );
                    this.setSorting();
                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                },
                addTab: function ( model ) {
                    if ( this.updateIfExistTab( model ) ) {
                        return false;
                    }
                    var $control = this.buildControlHtml( model ),
                        $cloned_tab;

                    if ( model.get( 'cloned' ) && ($cloned_tab = this.tabsControls().find( '[data-m-id=' + model.get( 'cloned_from' ).id + ']' )).length ) {
                        if ( ! model.get( 'cloned_appended' ) ) {
                            $control.prependTo( this.tabsControls() );
                            model.set( 'cloned_appended', true );
                        }
                    } else {
                        $control.prependTo( this.tabsControls() );
                    }

                    this.changed();
                    return true;
                },
                cloneTabAfter: function ( model ) {
                    this.$tabs.find( '> .wpb_wrapper > .wpb_tabs_nav > div' ).remove();
                    this.buildTabs( model );
                },
                updateIfExistTab: function ( model ) {
                    var $tab = this.tabsControls().find( '[data-m-id=' + model.get( 'id' ) + ']' );
                    var $html='',
                        fontSize;


                    if(model.getParam('tab_icon')!='') {
                        $html += "<i class='right-icon " + model.getParam('tab_icon') + "'></i>";
                    }else {
                        fontSize=parseInt($tab.attr( 'aria-controls', 'tab-' + model.getParam( 'tab_id' ) )
                            .find( 'a' ).css('font-size'));
                        fontSize=fontSize+5;
                        $html += "<i class='right-icon' style='font-size:"+fontSize+"px'></i>";
                    }
                    if(model.getParam('title')!='') {
                        $html += "<div class='horTabTitle'>" + model.getParam('title') + '</div> <i class="right-icon icon-angle-right"></i>';
                    }else {
                        $html += "<div class='horTabTitle'></div> <i class='right-icon icon-angle-right'></i>";
                    }
                    if ( $tab.length ) {
                        $tab.attr( 'aria-controls', 'tab-' + model.getParam( 'tab_id' ) )
                            .find( 'a' )
                            .attr( 'href', '#tab-' + model.getParam( 'tab_id' ) )
                            .html($html );
                        if(model.getParam('title')=='' && model.getParam('tab_icon')=='') {
                            $tab.attr('aria-controls', 'tab-' + model.getParam('tab_id')).find('a')
                                .attr('href', '#tab-' + model.getParam('tab_id')).parent().css('display', 'none');
                        }
                        return true;
                    }
                    return false;
                },
                buildControlHtml: function ( model ) {

                    var params = model.get( 'params' ),
                        $tab = $( '<li data-m-id="' + model.get( 'id' ) + '"><a href="#tab-' + model.getParam( 'tab_id' ) + '"></a></li>' );
                    $tab.data( 'model', model );
                    $tab.find( '> a' ).html('<i class="right-icon '+params.tab_icon+'"></i><div class="horTabTitle">'+ model.getParam( 'title' )+'</div><i class="right-icon icon-angle-right"></i>' );
                    return $tab;
                },
                addElement: function ( e ) {
                    e && e.preventDefault();
                    new vc.ShortcodesBuilder()
                        .create( {
                            shortcode: 'md_hor_tab',
                            params: {
                                tab_id: vc_guid() + '-' + this.tabsControls().find( 'li' ).length,
                                title: this.getDefaultTabTitle(),
                                tab_icon:'icon-cog'
                            },
                            parent_id: this.model.get( 'id' )
                        } )
                        .render();
                },
                getDefaultTabTitle: function () {
                    return window.i18nLocale.tab;
                },
                setSorting: function () {
                    if ( this.hasUserAccess() ) {
                        pixflow_setTabsSorting( this );
                    }
                    if($('body').hasClass('vc_editor')){
                        pixflow_livePreviewObj().$('.md-hor-tab-add-tab').parent().remove();
                        pixflow_livePreviewObj().$('.md_hor_tab .wpb_tabs_nav').append('<li><a style="cursor: pointer;" class="md-hor-tab-add-tab vc_control-btn"><div class="horTabTitle">'+admin_var.addTab+'</div></a></li>');
                        pixflow_livePreviewObj().$('.md-hor-tab-add-tab').click(function(e){
                            e.preventDefault();
                            $(this).parent().parent().find('a.vc_control-btn[title="ADD TAB"] .vc_btn-content').click();
                        })
                    }
                },
                stopSorting: function ( event, ui ) {
                    this.tabsControls().find( '> li' ).each( function ( key, value ) {
                        if($( this ).attr('data-m-id') != '')
                            var id = $( this ).data( 'm-id' );
                        else
                            var id = $( this ).data( 'model-id' );
                        var model = window.vc.shortcodes.get( id );
                        try {
                            model.save({order: key}, {silent: true});
                        }catch (e){}
                    } );
                },
                placeElement: function ( $view, activity ) {
                    var model = vc.shortcodes.get( $view.data( 'modelId' ) );
                    if ( model && model.get( 'place_after_id' ) ) {
                        $view.insertAfter( vc.$page.find( '[data-model-id=' + model.get( 'place_after_id' ) + ']' ) );
                        model.unset( 'place_after_id' );
                    } else {
                        $view.insertAfter( this.tabsControls() );
                    }
                    this.changed();
                },
                removeTab: function ( model ) {
                    if ( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ).length == 1 ) {
                        return this.model.destroy();
                    }
                    var $tab = this.tabsControls().find( '[data-m-id=' + model.get( 'id' ) + ']' ),
                        index = $tab.index();
                    if ( this.tabsControls().find( '[data-m-id]:eq(' + (index + 1) + ')' ).length ) {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, (index + 1) );
                    } else if ( this.tabsControls().find( '[data-m-id]:eq(' + (index - 1) + ')' ).length ) {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, (index - 1) );
                    } else {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, 0 );
                    }
                    $tab.remove();
                    this.tabsControls().find('.ui-state-active').click();
                },
                clone: function ( e ) {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.set( 'active_before_cloned', this.active_model_id === model.get( 'id' ) );
                    }, this );
                    window.InlineShortcodeView_md_hor_tabs.__super__.clone.call( this, e );
                }
            });

            /*-------------------------Frontend Horizontal Tab 2---------------------------*/
            window.InlineShortcodeView_md_hor_tab2 = window.InlineShortcodeViewContainerWithParent.extend( {
                controls_selector: '#vc_controls-template-vc_tab',
                render: function () {
                    var tab_id, active, params;
                    params = this.model.get( 'params' );
                    window.InlineShortcodeView_md_hor_tab2.__super__.render.call( this );
                    this.$tab = this.$el.find( '> :first' );
                    if ( _.isEmpty( params.tab_id ) ) {
                        params.tab_id = vc_guid() + '-' + Math.floor( Math.random() * 11 );
                        this.model.save( 'params', params );
                        tab_id = 'tab-' + params.tab_id;
                        this.$tab.attr( 'id', tab_id );
                    } else {
                        tab_id = this.$tab.attr( 'id' );
                    }
                    this.$el.attr( 'id', tab_id );
                    this.$tab.attr( 'id', tab_id + '-real' );
                    if ( ! this.$tab.find( '.vc_element[data-tag]' ).length ) {
                        this.$tab.html( '' );
                    }
                    this.$el.addClass( 'ui-tabs-panel wpb_ui-tabs-hide' );
                    this.$tab.removeClass( 'ui-tabs-panel wpb_ui-tabs-hide' );
                    if ( this.parent_view && this.parent_view.addTab ) {
                        if ( ! this.parent_view.addTab( this.model ) ) {
                            this.$el.removeClass( 'wpb_ui-tabs-hide' );
                        }
                    }
                    active = this.doSetAsActive();
                    try {
                        this.parent_view.buildTabs(active);
                    }catch (e){}
                    return this;
                },
                doSetAsActive: function () {
                    var active_before_cloned = this.model.get( 'active_before_cloned' );
                    if ( ! this.model.get( 'from_content' ) && ! this.model.get( 'default_content' ) && _.isUndefined( active_before_cloned ) ) {
                        return this.model;
                    } else if ( ! _.isUndefined( active_before_cloned ) ) {
                        this.model.unset( 'active_before_cloned' );
                        if ( active_before_cloned === true ) {
                            return this.model;
                        }
                    }
                    return false;
                },
                removeView: function ( model ) {
                    window.InlineShortcodeView_md_hor_tab2.__super__.removeView.call( this, model );
                    if ( this.parent_view && this.parent_view.removeTab ) {
                        this.parent_view.removeTab( model );
                    }
                },
                clone: function ( e ) {
                    _.isObject( e ) && e.preventDefault() && e.stopPropagation();
                    vc.clone_index = vc.clone_index / 10;
                    var clone = this.model.clone(),
                        params = clone.get( 'params' ),
                        builder = new vc.ShortcodesBuilder();
                    var newmodel = vc.CloneModel( builder, this.model, this.model.get( 'parent_id' ) );
                    var active_model = this.parent_view.active_model_id;
                    var that = this;
                    builder.render( function () {
                        if ( that.parent_view.cloneTabAfter ) {
                            that.parent_view.cloneTabAfter( newmodel );
                        }
                    } );
                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                }
            } );

            window.InlineShortcodeView_md_hor_tabs2 = window.InlineShortcodeView_vc_row.extend( {
                events: {
                    'click > :first > .vc_empty-element': 'addElement',
                    'click .md-hor-tab2-add-tab': 'addElement',
                    'click > :first > .wpb_wrapper > .ui-tabs-nav > li': 'setActiveTab'
                },
                already_build: false,
                active_model_id: false,
                $tabsNav: false,
                active: 0,
                render: function () {
                    _.bindAll( this, 'stopSorting' );
                    this.$tabs = this.$el.find( '> .wpb_tabs' );
                    window.InlineShortcodeView_md_hor_tabs2.__super__.render.call( this );
                    this.buildNav();
                    return this;
                },
                buildNav: function () {
                    var $nav = this.tabsControls();
                    this.$tabs.find( '> .wpb_wrapper > .vc_element[data-tag="md_hor_tab2"]' ).each( function ( key ) {
                        $( 'li:eq(' + key + ')', $nav ).attr( 'data-m-id', $( this ).data( 'model-id' ) );
                    } );
                },
                changed: function () {
                    $('iframe#vc_inline-frame').contents().find('.myLoader').remove();
                    if ( this.$el.find( '.vc_element[data-tag]' ).length == 0 ) {
                        this.$el.addClass( 'vc_empty' ).find( '> :first > div' ).addClass( 'vc_empty-element' );
                    } else {
                        this.$el.removeClass( 'vc_empty' ).find( '> :first > div' ).removeClass( 'vc_empty-element' );
                    }
                    this.setSorting();
                },
                setActiveTab: function ( e ) {
                    var $tab = $( e.currentTarget );
                    this.active_model_id = $tab.data( 'm-id' );
                },
                tabsControls: function () {
                    return this.$el.find( '.wpb_tabs_nav:first' );
                    return this.$tabsNav ? this.$tabsNav : this.$tabsNav = this.$el.find( '.wpb_tabs_nav' );
                },
                buildTabs: function ( active_model ) {
                    if ( active_model ) {
                        this.active_model_id = active_model.get( 'id' );
                        this.active = this.tabsControls().find( '[data-m-id=' + this.active_model_id + ']' ).index();
                        this.tabsControls().find( '[data-m-id=' + this.active_model_id + ']').click();
                    }else{
                        this.tabsControls().find( 'li:first').click();
                    }
                    if ( this.active_model_id === false ) {
                        var active_el = this.tabsControls().find( 'li:first' );
                        this.active = active_el.index();
                        this.active_model_id = active_el.data( 'm-id' );
                    }
                    if ( ! this.checkCount() ) {
                        vc.frame_window.vc_iframe.buildTabs( this.$tabs, this.active );
                    }
                },
                checkCount: function () {
                    return this.$tabs.find( '> .wpb_wrapper > .vc_element[data-tag="md_hor_tab2"]' ).length != this.$tabs.find( '> .wpb_wrapper > .vc_element.vc_md_hor_tab2' ).length;
                },
                beforeUpdate: function () {
                    this.$tabs.find( '.wpb_tabs_heading' ).remove();
                    vc.frame_window.vc_iframe.destroyTabs( this.$tabs );
                },
                updated: function () {
                    window.InlineShortcodeView_md_hor_tabs2.__super__.updated.call( this );
                    if(this.$tabs.find( '.wpb_tabs_nav').length >1) {
                        this.$tabs.find('.wpb_tabs_nav:first').remove();
                    }
                    this.buildNav();
                    vc.frame_window.vc_iframe.buildTabs( this.$tabs );
                    this.setSorting();
                },
                rowsColumnsConverted: function () {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.view.rowsColumnsConverted && model.view.rowsColumnsConverted();
                    } );
                },
                addTab: function ( model ) {
                    if ( this.updateIfExistTab( model ) ) {
                        return false;
                    }
                    var $control = this.buildControlHtml( model ),
                        $cloned_tab;

                    if ( model.get( 'cloned' ) && ($cloned_tab = this.tabsControls().find( '[data-m-id=' + model.get( 'cloned_from' ).id + ']' )).length ) {
                        if ( ! model.get( 'cloned_appended' ) ) {
                            $control.prependTo( this.tabsControls() );
                            model.set( 'cloned_appended', true );
                        }
                    } else {
                        $control.prependTo( this.tabsControls() );
                    }

                    this.changed();
                    return true;
                },
                cloneTabAfter: function ( model ) {
                    this.$tabs.find( '> .wpb_wrapper > .wpb_tabs_nav > div' ).remove();
                    this.buildTabs( model );
                },
                updateIfExistTab: function ( model ) {
                    var $tab = this.tabsControls().find( '[data-m-id=' + model.get( 'id' ) + ']' );
                    var $html='',
                        fontSize;


                    if(model.getParam('tab_icon')!='') {
                        $html += "<i class='right-icon " + model.getParam('tab_icon') + "'></i>";
                    }else {
                        fontSize=parseInt($tab.attr( 'aria-controls', 'tab-' + model.getParam( 'tab_id' ) )
                            .find( 'a' ).css('font-size'));
                        fontSize=fontSize+5;
                    }
                    if(model.getParam('title')!='') {
                        $html += "<div class='horTabTitle'>" + model.getParam('title') + '</div>';
                    }else {
                        $html += "<div class='horTabTitle'></div>";
                    }
                    if ( $tab.length ) {
                        $tab.attr( 'aria-controls', 'tab-' + model.getParam( 'tab_id' ) )
                            .find( 'a' )
                            .attr( 'href', '#tab-' + model.getParam( 'tab_id' ) )
                            .html($html );
                        if(model.getParam('title')=='' && model.getParam('tab_icon')=='') {
                            $tab.attr('aria-controls', 'tab-' + model.getParam('tab_id')).find('a')
                                .attr('href', '#tab-' + model.getParam('tab_id')).parent().css('display', 'none');
                        }
                        return true;
                    }
                    return false;
                },
                buildControlHtml: function ( model ) {

                    var params = model.get( 'params' ),
                        $tab = $( '<li data-m-id="' + model.get( 'id' ) + '"><a href="#tab-' + model.getParam( 'tab_id' ) + '"></a></li>' );
                    $tab.data( 'model', model );
                    $tab.find( '> a' ).html('<i class="right-icon '+params.tab_icon+'"></i><div class="horTabTitle">'+ model.getParam( 'title' )+'</div>' );
                    return $tab;
                },
                addElement: function ( e ) {
                    e && e.preventDefault();
                    new vc.ShortcodesBuilder()
                        .create( {
                            shortcode: 'md_hor_tab2',
                            params: {
                                tab_id: vc_guid() + '-' + this.tabsControls().find( 'li' ).length,
                                title: this.getDefaultTabTitle(),
                                tab_icon:'icon-cog'
                            },
                            parent_id: this.model.get( 'id' )
                        } )
                        .render();
                },
                getDefaultTabTitle: function () {
                    return window.i18nLocale.tab;
                },
                setSorting: function () {
                    if ( this.hasUserAccess() ) {
                        pixflow_setTabsSorting( this );
                    }
                    if($('body').hasClass('vc_editor')){
                        pixflow_livePreviewObj().$('.md-hor-tab2-add-tab').parent().remove();
                        pixflow_livePreviewObj().$('.md_hor_tab2 .wpb_tabs_nav').append('<li><a style="cursor: pointer;" class="md-hor-tab2-add-tab vc_control-btn"><div class="horTabTitle">'+admin_var.addTab+'</div></a></li>');
                        pixflow_livePreviewObj().$('.md-hor-tab2-add-tab').click(function(e){
                            e.preventDefault();
                            $(this).parent().parent().find('a.vc_control-btn[title="ADD TAB"] .vc_btn-content').click();
                        })
                    }
                },
                stopSorting: function ( event, ui ) {
                    this.tabsControls().find( '> li' ).each( function ( key, value ) {
                        if($( this ).attr('data-m-id') != '')
                            var id = $( this ).data( 'm-id' );
                        else
                            var id = $( this ).data( 'model-id' );
                        var model = window.vc.shortcodes.get( id );
                        try {
                            model.save({order: key}, {silent: true});
                        }catch (e){}
                    } );
                },
                placeElement: function ( $view, activity ) {
                    var model = vc.shortcodes.get( $view.data( 'modelId' ) );
                    if ( model && model.get( 'place_after_id' ) ) {
                        $view.insertAfter( vc.$page.find( '[data-model-id=' + model.get( 'place_after_id' ) + ']' ) );
                        model.unset( 'place_after_id' );
                    } else {
                        $view.insertAfter( this.tabsControls() );
                    }
                    this.changed();
                },
                removeTab: function ( model ) {
                    if ( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ).length == 1 ) {
                        return this.model.destroy();
                    }
                    var $tab = this.tabsControls().find( '[data-m-id=' + model.get( 'id' ) + ']' ),
                        index = $tab.index();
                    if ( this.tabsControls().find( '[data-m-id]:eq(' + (index + 1) + ')' ).length ) {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, (index + 1) );
                    } else if ( this.tabsControls().find( '[data-m-id]:eq(' + (index - 1) + ')' ).length ) {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, (index - 1) );
                    } else {
                        vc.frame_window.vc_iframe.setActiveTab( this.$tabs, 0 );
                    }
                    $tab.remove();
                    this.tabsControls().find('.ui-state-active').click();
                },
                clone: function ( e ) {
                    _.each( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
                        model.set( 'active_before_cloned', this.active_model_id === model.get( 'id' ) );
                    }, this );
                    window.InlineShortcodeView_md_hor_tabs2.__super__.clone.call( this, e );
                }
            });

        }catch (e){}

        //Backend
        try{
/*------------------------------Backend Accordion-----------------*/
            window.MdAccordionView = vc.shortcode_view.extend( {
                adding_new_tab: false,
                events: {
                    'click .add_tab': 'addTab',
                    'click > .vc_controls .column_delete, > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .column_edit, > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .column_clone,> .vc_controls .vc_control-btn-clone': 'clone'
                },
                render: function () {
                    window.MdAccordionView.__super__.render.call( this );
                    // check user role to add controls
                    if ( ! this.hasUserAccess() ) {
                        return this;
                    }
                    this.$content.sortable( {
                        axis: "y",
                        handle: "h3",
                        stop: function ( event, ui ) {
                            // IE doesn't register the blur when sorting
                            // so trigger focusout handlers to remove .ui-state-focus
                            ui.item.prev().triggerHandler( "focusout" );
                            $( this ).find( '> .wpb_sortable' ).each( function () {
                                var shortcode = $( this ).data( 'model' );
                                shortcode.save( { 'order': $( this ).index() } ); // Optimize
                            } );
                        }
                    } );
                    return this;
                },
                changeShortcodeParams: function ( model ) {
                    var params, collapsible;

                    window.MdAccordionView.__super__.changeShortcodeParams.call( this, model );
                    params = model.get( 'params' );
                    collapsible = _.isString( params.collapsible ) && params.collapsible === 'yes' ? true : false;
                    if ( this.$content.hasClass( 'ui-accordion' ) ) {
                        this.$content.accordion( "option", "collapsible", collapsible );
                    }
                },
                changedContent: function ( view ) {
                    if ( this.$content.hasClass( 'ui-accordion' ) ) {
                        this.$content.accordion( 'destroy' );
                    }
                    var collapsible = _.isString( this.model.get( 'params' ).collapsible ) && this.model.get( 'params' ).collapsible === 'yes' ? true : false;
                    this.$content.accordion( {
                        header: "h3",
                        navigation: false,
                        autoHeight: true,
                        heightStyle: "content",
                        collapsible: collapsible,
                        active: this.adding_new_tab === false && view.model.get( 'cloned' ) !== true ? 0 : view.$el.index()
                    } );
                    this.adding_new_tab = false;
                },
                addTab: function ( e ) {
                    e.preventDefault();
                    // check user role to add controls
                    if ( ! this.hasUserAccess() ) {
                        return false;
                    }
                    this.adding_new_tab = true;
                    vc.shortcodes.create( {
                        shortcode: 'md_accordion_tab',
                        params: { title: window.i18nLocale.section },
                        parent_id: this.model.id
                    } );
                },
                _loadDefaults: function () {
                    window.MdAccordionView.__super__._loadDefaults.call( this );
                }
            } );


            window.MdAccordionTabView = window.VcColumnView.extend( {
                events: {
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-prepend': 'addElement',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone',
                    'click > .wpb_accordion_content .vc_empty-container': 'prependElement'
                },
                setContent: function () {
                    this.$content = this.$el.find( '.wpb_accordion_content .vc_empty-container' );
                    this.$content.click(function(e){
                        $(this).closest('.wpb_md_accordion_tab').find('.vc_control-btn-prepend').click()
                    })
                },
                changeShortcodeParams: function ( model ) {
                    var params;

                    window.MdAccordionTabView.__super__.changeShortcodeParams.call( this, model );
                    params = model.get( 'params' );
                    if ( _.isObject( params ) && _.isString( params.title ) ) {
                        this.$el.find( 'h3 .md-accordion-tab-title' ).text( params.title );
                    }
                    if ( _.isObject( params ) && _.isString( params.icon ) ) {
                        this.$el.find( 'h3 .icon').removeAttr('class').addClass('icon').addClass(params.icon);
                    }
                },
                setEmpty: function () {
                    $( ' [data-element_type]', this.$el ).addClass( 'vc_empty-column' );
                    this.$content.addClass( 'vc_empty-container' );
                    this.$content.click(function(e){
                        $(this).closest('.wpb_md_accordion_tab').find('.vc_control-btn-prepend').click()
                    })
                },
                unsetEmpty: function () {
                    $( ' [data-element_type]', this.$el ).removeClass( 'vc_empty-column' );
                    this.$content.removeClass( 'vc_empty-container' );
                    this.$content.unbind('click');
                }
            } );

            /*------------------Backend Toggle ---------------------------*/

            window.MdToggleView = vc.shortcode_view.extend( {
                adding_new_tab: false,
                events: {
                    'click .add_tab': 'addTab',
                    'click > .vc_controls .column_delete, > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .column_edit, > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .column_clone,> .vc_controls .vc_control-btn-clone': 'clone'
                },
                render: function () {
                    window.MdToggleView.__super__.render.call( this );
                    // check user role to add controls
                    if ( ! this.hasUserAccess() ) {
                        return this;
                    }
                    this.$content.sortable( {
                        axis: "y",
                        handle: "h3",
                        stop: function ( event, ui ) {
                            // IE doesn't register the blur when sorting
                            // so trigger focusout handlers to remove .ui-state-focus
                            ui.item.prev().triggerHandler( "focusout" );
                            $( this ).find( '> .wpb_sortable' ).each( function () {
                                var shortcode = $( this ).data( 'model' );
                                shortcode.save( { 'order': $( this ).index() } ); // Optimize
                            } );
                        }
                    } );
                    return this;
                },
                changeShortcodeParams: function ( model ) {
                    var params, collapsible;

                    window.MdToggleView.__super__.changeShortcodeParams.call( this, model );
                    params = model.get( 'params' );
                    collapsible = _.isString( params.collapsible ) && params.collapsible === 'yes' ? true : false;
                    if ( this.$content.hasClass( 'ui-accordion' ) ) {
                        //this.$content.multiAccordion( "option", "collapsible", collapsible );
                    }
                },
                changedContent: function ( view ) {
                    var collapsible = _.isString( this.model.get( 'params' ).collapsible ) && this.model.get( 'params' ).collapsible === 'yes' ? true : false;

                    this.adding_new_tab = false;
                },
                addTab: function ( e ) {
                    e.preventDefault();
                    // check user role to add controls
                    if ( ! this.hasUserAccess() ) {
                        return false;
                    }
                    this.adding_new_tab = true;
                    vc.shortcodes.create( {
                        shortcode: 'md_toggle_tab',
                        params: { title: window.i18nLocale.section },
                        parent_id: this.model.id
                    } );
                },
                _loadDefaults: function () {
                    window.MdToggleView.__super__._loadDefaults.call( this );
                }
            } );

            window.MdToggleTabView = window.VcColumnView.extend( {
                events: {
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-prepend': 'addElement',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone',
                    'click > .wpb_accordion_content .vc_empty-container': 'prependElement'
                },
                setContent: function () {
                    this.$content = this.$el.find( '.wpb_toggle_content .vc_empty-container' );
                    this.$content.click(function(e){
                        $(this).closest('.wpb_md_toggle_tab').find('.vc_control-btn-prepend').click();

                    })
                    this.$el.find('.wpb_element_wrapper > h3').click(function(){
                        $(this).parent().find(' > .wpb_toggle_content ').slideToggle();
                        if ($(this).hasClass('ui-state-active')) {
                            $(this).removeClass('ui-state-active').find('.ui-icon-triangle-1-e').removeClass('ui-icon-triangle-1-e').addClass('ui-icon-triangle-1-s');
                        } else {
                            $(this).addClass('ui-state-active').find('.ui-icon-triangle-1-s').removeClass('ui-icon-triangle-1-s').addClass('ui-icon-triangle-1-e');
                        }
                    })
                },
                changeShortcodeParams: function ( model ) {
                    var params;

                    window.MdToggleTabView.__super__.changeShortcodeParams.call( this, model );
                    params = model.get( 'params' );
                    if ( _.isObject( params ) && _.isString( params.title ) ) {
                        this.$el.find( 'h3 .md-toggle-tab-title' ).text( params.title );
                    }
                    if ( _.isObject( params ) && _.isString( params.icon ) ) {
                        this.$el.find( 'h3 .icon').removeAttr('class').addClass('icon').addClass(params.icon);
                    }
                },
                setEmpty: function () {
                    $( ' [data-element_type]', this.$el ).addClass( 'vc_empty-column' );
                    this.$content.addClass( 'vc_empty-container' );
                    this.$content.click(function(e){
                        $(this).closest('.wpb_md_toggle_tab').find('.vc_control-btn-prepend').click()
                    })
                },
                unsetEmpty: function () {
                    $( ' [data-element_type]', this.$el ).removeClass( 'vc_empty-column' );
                    this.$content.removeClass( 'vc_empty-container' );
                    this.$content.unbind('click');
                }
            } );

            /*------------------Backend Business Toggle ---------------------------*/

            window.MdToggle2View = vc.shortcode_view.extend( {
                adding_new_tab: false,
                events: {
                    'click .add_tab': 'addTab',
                    'click > .vc_controls .column_delete, > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .column_edit, > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .column_clone,> .vc_controls .vc_control-btn-clone': 'clone'
                },
                render: function () {
                    window.MdToggle2View.__super__.render.call( this );
                    // check user role to add controls
                    if ( ! this.hasUserAccess() ) {
                        return this;
                    }
                    this.$content.sortable( {
                        axis: "y",
                        handle: "h3",
                        stop: function ( event, ui ) {
                            // IE doesn't register the blur when sorting
                            // so trigger focusout handlers to remove .ui-state-focus
                            ui.item.prev().triggerHandler( "focusout" );
                            $( this ).find( '> .wpb_sortable' ).each( function () {
                                var shortcode = $( this ).data( 'model' );
                                shortcode.save( { 'order': $( this ).index() } ); // Optimize
                            } );
                        }
                    } );
                    return this;
                },
                changeShortcodeParams: function ( model ) {
                    var params, collapsible;

                    window.MdToggle2View.__super__.changeShortcodeParams.call( this, model );
                    params = model.get( 'params' );
                    collapsible = _.isString( params.collapsible ) && params.collapsible === 'yes' ? true : false;
                    if ( this.$content.hasClass( 'ui-accordion' ) ) {
                        //this.$content.multiAccordion( "option", "collapsible", collapsible );
                    }
                },
                changedContent: function ( view ) {
                    var collapsible = _.isString( this.model.get( 'params' ).collapsible ) && this.model.get( 'params' ).collapsible === 'yes' ? true : false;

                    this.adding_new_tab = false;
                },
                addTab: function ( e ) {
                    e.preventDefault();
                    // check user role to add controls
                    if ( ! this.hasUserAccess() ) {
                        return false;
                    }
                    this.adding_new_tab = true;
                    vc.shortcodes.create( {
                        shortcode: 'md_toggle_tab2',
                        params: { title: window.i18nLocale.section },
                        parent_id: this.model.id
                    } );
                },
                _loadDefaults: function () {
                    window.MdToggle2View.__super__._loadDefaults.call( this );
                }
            } );

            window.MdToggleTab2View = window.VcColumnView.extend( {
                events: {
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-prepend': 'addElement',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone',
                    'click > .wpb_accordion_content .vc_empty-container': 'prependElement'
                },
                setContent: function () {
                    this.$content = this.$el.find( '.wpb_toggle_content .vc_empty-container' );
                    this.$content.click(function(e){
                        $(this).closest('.wpb_md_toggle_tab2').find('.vc_control-btn-prepend').click();

                    })
                    this.$el.find('.wpb_element_wrapper > h3').click(function(){
                        $(this).parent().find(' > .wpb_toggle_content ').slideToggle();
                        if ($(this).hasClass('ui-state-active')) {
                            $(this).removeClass('ui-state-active').find('.ui-icon-triangle-1-e').removeClass('ui-icon-triangle-1-e').addClass('ui-icon-triangle-1-s');
                        } else {
                            $(this).addClass('ui-state-active').find('.ui-icon-triangle-1-s').removeClass('ui-icon-triangle-1-s').addClass('ui-icon-triangle-1-e');
                        }
                    })
                },
                changeShortcodeParams: function ( model ) {
                    var params;

                    window.MdToggleTab2View.__super__.changeShortcodeParams.call( this, model );
                    params = model.get( 'params' );
                    if ( _.isObject( params ) && _.isString( params.title ) ) {
                        this.$el.find( 'h3 .md-toggle-tab2-title' ).text( params.title );
                    }
                    if ( _.isObject( params ) && _.isString( params.icon ) ) {
                        this.$el.find( 'h3 .icon').removeAttr('class').addClass('icon').addClass(params.icon);
                    }
                },
                setEmpty: function () {
                    $( ' [data-element_type]', this.$el ).addClass( 'vc_empty-column' );
                    this.$content.addClass( 'vc_empty-container' );
                    this.$content.click(function(e){
                        $(this).closest('.wpb_md_toggle_tab2').find('.vc_control-btn-prepend').click()
                    })
                },
                unsetEmpty: function () {
                    $( ' [data-element_type]', this.$el ).removeClass( 'vc_empty-column' );
                    this.$content.removeClass( 'vc_empty-container' );
                    this.$content.unbind('click');
                }
            } );
/*----------------------------Backend Tabs---------------------------*/
            window.MdTabsView = vc.shortcode_view.extend( {
                new_tab_adding: false,
                events: {
                    'click .add_tab': 'addTab',
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone'
                },
                initialize: function ( params ) {
                    window.MdTabsView.__super__.initialize.call( this, params );
                    _.bindAll( this, 'stopSorting' );
                },
                render: function () {

                    window.MdTabsView.__super__.render.call( this );
                    this.$tabs = this.$el.find( '.wpb_tabs_holder' );
                    this.createAddTabButton();
                    return this;
                },
                ready: function ( e ) {
                    window.MdTabsView.__super__.ready.call( this, e );
                },
                createAddTabButton: function () {
                    var new_tab_button_id = (+ new Date() + '-' + Math.floor( Math.random() * 11 ));
                    this.$tabs.append( '<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>' );
                    this.$add_button = $( '<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + window.i18nLocale.add_tab + '"></a></li>' ).appendTo( this.$tabs.find( ".tabs_controls" ) );
                },
                addTab: function ( e ) {
                    e.preventDefault();
                    // check user role to add controls
                    if ( ! this.hasUserAccess() ) {
                        return false;
                    }
                    this.new_tab_adding = true;
                    var tab_title      = window.i18nLocale.tab,
                        tab_icon_class ='icon-cog',
                        tabs_count     = this.$tabs.find( '[data-element_type=md_tab]' ).length,
                        tab_id         = (+ new Date() + '-' + tabs_count + '-' + Math.floor( Math.random() * 11 ));
                    vc.shortcodes.create( {
                        shortcode: 'md_tab',
                        params: { title: tab_title, tab_id: tab_id},
                        parent_id: this.model.id
                    } );
                    return false;
                },
                stopSorting: function ( event, ui ) {
                    var shortcode;
                    this.$tabs.find( 'ul.tabs_controls li:not(.add_tab_block)' ).each( function ( index ) {
                        var href = $( this ).find( 'a' ).attr( 'href' ).replace( "#", "" );
                        shortcode = vc.shortcodes.get( $( '[id=' + $( this ).attr( 'aria-controls' ) + ']' ).data( 'model-id' ) );
                        vc.storage.lock();
                        shortcode.save( { 'order': $( this ).index() } ); // Optimize
                    } );
                    shortcode && shortcode.save();
                },
                changedContent: function ( view ) {
                    var params = view.model.get( 'params' );
                    if ( ! this.$tabs.hasClass( 'ui-tabs' ) ) {
                        this.$tabs.tabs( {
                            select: function ( event, ui ) {
                                return ! $( ui.tab ).hasClass( 'add_tab' );
                            }
                        } );
                        this.$tabs.find( ".ui-tabs-nav" ).prependTo( this.$tabs );
                        // check user role to add controls
                        if ( this.hasUserAccess() ) {
                            this.$tabs.find( ".ui-tabs-nav" ).sortable( {
                                axis: (this.$tabs.closest( '[data-element_type]' ).data( 'element_type' ) == 'vc_tour' ? 'y' : 'x'),
                                update: this.stopSorting,
                                items: "> li:not(.add_tab_block)"
                            } );
                        }
                    }

                    if ( view.model.get( 'cloned' ) === true ) {
                        var cloned_from = view.model.get( 'cloned_from' ),
                            $tab_controls = $( '.tabs_controls > .add_tab_block', this.$content ),
                            $new_tab = $( "<li><i class='left-icon "+params.tab_icon_class+"'></i><a href='#tab-" + params.tab_id + "'>" + params.title + "</a></li>" ).insertBefore( $tab_controls );
                        this.$tabs.tabs( 'refresh' );
                        this.$tabs.tabs( "option", 'active', $new_tab.index() );
                    } else {
                        $( "<li><i class='left-icon "+params.tab_icon_class+"'></i><a href='#tab-" + params.tab_id + "'>" + params.title + "</a></li>" )
                            .insertBefore( this.$add_button );
                        this.$tabs.tabs( 'refresh' );
                        this.$tabs.tabs( "option",
                            "active",
                            this.new_tab_adding ? $( '.ui-tabs-nav li', this.$content ).length - 2 : 0 );

                    }
                    this.new_tab_adding = false;
                },
                cloneModel: function ( model, parent_id, save_order ) {
                    var new_order,
                        model_clone,
                        params,
                        tag;

                    new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
                    params = _.extend( {}, model.get( 'params' ) );
                    tag = model.get( 'shortcode' );

                    if ( tag === 'md_tab' ) {
                        _.extend( params,
                            { tab_id: + new Date() + '-' + this.$tabs.find( '[data-element-type=md_tab]' ).length + '-' + Math.floor( Math.random() * 11 ) } );
                    }

                    model_clone = Shortcodes.create( {
                        shortcode: tag,
                        id: vc_guid(),
                        parent_id: parent_id,
                        order: new_order,
                        cloned: (tag !== 'md_tab'), // todo review this by @say2me
                        cloned_from: model.toJSON(),
                        params: params
                    } );

                    _.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
                        this.cloneModel( shortcode, model_clone.get( 'id' ), true );
                    }, this );
                    return model_clone;
                }
            } );


            window.MdTabView = window.VcColumnView.extend( {
                events: {
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-prepend': 'addElement',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone',
                    'click > .wpb_element_wrapper > .vc_empty-container': 'addToEmpty'
                },
                render: function () {
                    var params = this.model.get( 'params' );

                    window.MdTabView.__super__.render.call( this );
                    /**
                     * @deprecated 4.4.3
                     * @see composer-atts.js vc.atts.tab_id.addShortcode
                     */
                    if ( ! params.tab_id) {
                        params.tab_id = (+ new Date() + '-' + Math.floor( Math.random() * 11 ));
                        this.model.save( 'params', params );
                    }
                    this.id = 'tab-' + params.tab_id;
                    this.$el.attr( 'id', this.id );
                    return this;
                },
                ready: function ( e ) {
                    window.MdTabView.__super__.ready.call( this, e );
                    this.$tabs = this.$el.closest( '.wpb_tabs_holder' );
                    var params = this.model.get( 'params' );
                    return this;
                },
                changeShortcodeParams: function ( model ) {
                    var params;

                    window.MdTabView.__super__.changeShortcodeParams.call( this, model );
                    params = model.get( 'params' );
                    if ( _.isObject( params ) && _.isString( params.title ) && _.isString( params.tab_id ) ) {

                        $( '.ui-tabs-nav [href=#tab-' + params.tab_id + ']' ).text( params.title );

                        $( '.ui-tabs-nav [href=#tab-' + params.tab_id + ']').prev('i.left-icon').removeAttr('class');
                        $( '.ui-tabs-nav [href=#tab-' + params.tab_id + ']').prev().addClass( 'left-icon '+ params.tab_icon_class );
                    }
                },
                deleteShortcode: function ( e ) {
                    _.isObject( e ) && e.preventDefault();
                    var answer = confirm( window.i18nLocale.press_ok_to_delete_section ),
                        parent_id = this.model.get( 'parent_id' );
                    if ( answer !== true ) {
                        return false;
                    }
                    this.model.destroy();
                    if ( ! vc.shortcodes.where( { parent_id: parent_id } ).length ) {
                        var parent = vc.shortcodes.get( parent_id );
                        parent.destroy();
                        return false;
                    }
                    var params = this.model.get( 'params' ),
                        current_tab_index = $( '[href=#tab-' + params.tab_id + ']', this.$tabs ).parent().index();
                    $( '[href=#tab-' + params.tab_id + ']' ).parent().remove();
                    var tab_length = this.$tabs.find( '.ui-tabs-nav li:not(.add_tab_block)' ).length;
                    if ( tab_length > 0 ) {
                        this.$tabs.tabs( 'refresh' );
                    }
                    if ( current_tab_index < tab_length ) {
                        this.$tabs.tabs( "option", "active", current_tab_index );
                    } else if ( tab_length > 0 ) {
                        this.$tabs.tabs( "option", "active", tab_length - 1 );
                    }

                },
                cloneModel: function ( model, parent_id, save_order ) {
                    var new_order,
                        model_clone,
                        params,
                        tag;

                    new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
                    params = _.extend( {}, model.get( 'params' ) );
                    tag = model.get( 'shortcode' );

                    if ( tag === 'md_tab' ) {
                        _.extend( params,
                            { tab_id: + new Date() + '-' + this.$tabs.find( '[data-element_type=md_tab]' ).length + '-' + Math.floor( Math.random() * 11 ) } );
                    }

                    model_clone = Shortcodes.create( {
                        shortcode: tag,
                        parent_id: parent_id,
                        order: new_order,
                        cloned: true,
                        cloned_from: model.toJSON(),
                        params: params
                    } );

                    _.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
                        this.cloneModel( shortcode, model_clone.get( 'id' ), true );
                    }, this );
                    return model_clone;
                }
            } );

            /*----------------------------Backend Modern Tabs---------------------------*/
            window.MdModernTabsView = vc.shortcode_view.extend( {
                new_tab_adding: false,
                events: {
                    'click .add_tab': 'addTab',
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone'
                },
                initialize: function ( params ) {
                    window.MdModernTabsView.__super__.initialize.call( this, params );
                    _.bindAll( this, 'stopSorting' );
                },
                render: function () {

                    window.MdModernTabsView.__super__.render.call( this );
                    this.$tabs = this.$el.find( '.wpb_tabs_holder' );
                    this.createAddTabButton();
                    return this;
                },
                ready: function ( e ) {
                    window.MdModernTabsView.__super__.ready.call( this, e );
                },
                createAddTabButton: function () {
                    var new_tab_button_id = (+ new Date() + '-' + Math.floor( Math.random() * 11 ));
                    this.$tabs.append( '<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>' );
                    this.$add_button = $( '<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + window.i18nLocale.add_tab + '"></a></li>' ).appendTo( this.$tabs.find( ".tabs_controls" ) );
                },
                addTab: function ( e ) {
                    e.preventDefault();
                    // check user role to add controls
                    if ( ! this.hasUserAccess() ) {
                        return false;
                    }
                    this.new_tab_adding = true;
                    var tab_title      = window.i18nLocale.tab,
                        tab_icon_class ='icon-cog',
                        tabs_count     = this.$tabs.find( '[data-element_type=md_modernTab]' ).length,
                        tab_id         = (+ new Date() + '-' + tabs_count + '-' + Math.floor( Math.random() * 11 ));
                    vc.shortcodes.create( {
                        shortcode: 'md_modernTab',
                        params: { title: tab_title, tab_id: tab_id},
                        parent_id: this.model.id
                    } );
                    return false;
                },
                stopSorting: function ( event, ui ) {
                    var shortcode;
                    this.$tabs.find( 'ul.tabs_controls li:not(.add_tab_block)' ).each( function ( index ) {
                        var href = $( this ).find( 'a' ).attr( 'href' ).replace( "#", "" );
                        shortcode = vc.shortcodes.get( $( '[id=' + $( this ).attr( 'aria-controls' ) + ']' ).data( 'model-id' ) );
                        vc.storage.lock();
                        shortcode.save( { 'order': $( this ).index() } ); // Optimize
                    } );
                    shortcode && shortcode.save();
                },
                changedContent: function ( view ) {
                    var params = view.model.get( 'params' );

                    if ( ! this.$tabs.hasClass( 'ui-tabs' ) ) {
                        this.$tabs.tabs( {
                            select: function ( event, ui ) {
                                return ! $( ui.tab ).hasClass( 'add_tab' );
                            }
                        } );
                        this.$tabs.find( ".ui-tabs-nav" ).prependTo( this.$tabs );
                        // check user role to add controls
                        if ( this.hasUserAccess() ) {
                            this.$tabs.find( ".ui-tabs-nav" ).sortable( {
                                axis: (this.$tabs.closest( '[data-element_type]' ).data( 'element_type' ) == 'vc_tour' ? 'y' : 'x'),
                                update: this.stopSorting,
                                items: "> li:not(.add_tab_block)"
                            } );
                        }
                    }

                    if ( view.model.get( 'cloned' ) === true ) {
                        var cloned_from = view.model.get( 'cloned_from' ),
                            $tab_controls = $( '.tabs_controls > .add_tab_block', this.$content ),
                            $new_tab = $( "<li><a href='#tab-" + params.tab_id + "'><i class='left-icon "+params.tab_icon_class+"'></i><div class='modernTabTitle'>" + params.title + "</div></a></li>" ).insertBefore( $tab_controls );
                        this.$tabs.tabs( 'refresh' );
                        this.$tabs.tabs( "option", 'active', $new_tab.index() );
                    } else {
                        $( "<li><a href='#tab-" + params.tab_id + "'><i class='left-icon "+params.tab_icon_class+"'></i><div class='modernTabTitle'>" + params.title + "</div></a></li>" )
                            .insertBefore( this.$add_button );
                        this.$tabs.tabs( 'refresh' );
                        this.$tabs.tabs( "option",
                            "active",
                            this.new_tab_adding ? $( '.ui-tabs-nav li', this.$content ).length - 2 : 0 );

                    }
                    this.new_tab_adding = false;
                },
                cloneModel: function ( model, parent_id, save_order ) {
                    var new_order,
                        model_clone,
                        params,
                        tag;

                    new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
                    params = _.extend( {}, model.get( 'params' ) );
                    tag = model.get( 'shortcode' );

                    if ( tag === 'md_modernTab' ) {
                        _.extend( params,
                            { tab_id: + new Date() + '-' + this.$tabs.find( '[data-element-type=md_modernTab]' ).length + '-' + Math.floor( Math.random() * 11 ) } );
                    }

                    model_clone = Shortcodes.create( {
                        shortcode: tag,
                        id: vc_guid(),
                        parent_id: parent_id,
                        order: new_order,
                        cloned: (tag !== 'md_modernTab'), // todo review this by @say2me
                        cloned_from: model.toJSON(),
                        params: params
                    } );

                    _.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
                        this.cloneModel( shortcode, model_clone.get( 'id' ), true );
                    }, this );
                    return model_clone;
                }
            } );


            window.MdModernTabView = window.VcColumnView.extend( {
                events: {
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-prepend': 'addElement',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone',
                    'click > .wpb_element_wrapper > .vc_empty-container': 'addToEmpty'
                },
                render: function () {
                    var params = this.model.get( 'params' );

                    window.MdModernTabView.__super__.render.call( this );

                    if ( ! params.tab_id) {
                        params.tab_id = (+ new Date() + '-' + Math.floor( Math.random() * 11 ));
                        this.model.save( 'params', params );
                    }
                    this.id = 'tab-' + params.tab_id;
                    this.$el.attr( 'id', this.id );
                    return this;
                },
                ready: function ( e ) {
                    window.MdModernTabView.__super__.ready.call( this, e );
                    this.$tabs = this.$el.closest( '.wpb_tabs_holder' );
                    var params = this.model.get( 'params' );
                    return this;
                },
                changeShortcodeParams: function ( model ) {
                    var params;

                    window.MdModernTabView.__super__.changeShortcodeParams.call( this, model );
                    params = model.get( 'params' );
                    var $html='';
                    if(params.tab_icon_class!='') {
                        $html += "<i class='left-icon " + params.tab_icon_class + "'></i>";
                    }else {
                        $html += "<i class='left-icon'></i>";
                    }
                    if(params.title!='') {
                        $html += "<div class='modernTabTitle'>" + params.title + '</div>';
                    }else {
                        $html += "<div class='modernTabTitle'></div>";
                    }

                    if ( _.isObject( params ) && _.isString( params.title ) && _.isString( params.tab_id ) ) {
                        $( '.ui-tabs-nav [href=#tab-' + params.tab_id + ']' ).html( $html);
                    }
                },
                deleteShortcode: function ( e ) {
                    _.isObject( e ) && e.preventDefault();
                    var answer = confirm( window.i18nLocale.press_ok_to_delete_section ),
                        parent_id = this.model.get( 'parent_id' );
                    if ( answer !== true ) {
                        return false;
                    }
                    this.model.destroy();
                    if ( ! vc.shortcodes.where( { parent_id: parent_id } ).length ) {
                        var parent = vc.shortcodes.get( parent_id );
                        parent.destroy();
                        return false;
                    }
                    var params = this.model.get( 'params' ),
                        current_tab_index = $( '[href=#tab-' + params.tab_id + ']', this.$tabs ).parent().index();
                    $( '[href=#tab-' + params.tab_id + ']' ).parent().remove();
                    var tab_length = this.$tabs.find( '.ui-tabs-nav li:not(.add_tab_block)' ).length;
                    if ( tab_length > 0 ) {
                        this.$tabs.tabs( 'refresh' );
                    }
                    if ( current_tab_index < tab_length ) {
                        this.$tabs.tabs( "option", "active", current_tab_index );
                    } else if ( tab_length > 0 ) {
                        this.$tabs.tabs( "option", "active", tab_length - 1 );
                    }

                },
                cloneModel: function ( model, parent_id, save_order ) {
                    var new_order,
                        model_clone,
                        params,
                        tag;

                    new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
                    params = _.extend( {}, model.get( 'params' ) );
                    tag = model.get( 'shortcode' );

                    if ( tag === 'md_modernTab' ) {
                        _.extend( params,
                            { tab_id: + new Date() + '-' + this.$tabs.find( '[data-element_type=md_modernTab]' ).length + '-' + Math.floor( Math.random() * 11 ) } );
                    }

                    model_clone = Shortcodes.create( {
                        shortcode: tag,
                        parent_id: parent_id,
                        order: new_order,
                        cloned: true,
                        cloned_from: model.toJSON(),
                        params: params
                    } );

                    _.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
                        this.cloneModel( shortcode, model_clone.get( 'id' ), true );
                    }, this );
                    return model_clone;
                }
            } );

            /*----------------------------Backend Horizontal Tabs---------------------------*/
            window.MdHorTabsView = vc.shortcode_view.extend( {
                new_tab_adding: false,
                events: {
                    'click .add_tab': 'addTab',
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone'
                },
                initialize: function ( params ) {
                    window.MdHorTabsView.__super__.initialize.call( this, params );
                    _.bindAll( this, 'stopSorting' );
                },
                render: function () {
                    window.MdHorTabsView.__super__.render.call( this );
                    this.$tabs = this.$el.find( '.wpb_tabs_holder' );
                    this.createAddTabButton();
                    return this;
                },
                ready: function ( e ) {
                    window.MdHorTabsView.__super__.ready.call( this, e );
                },
                createAddTabButton: function () {
                    var new_tab_button_id = (+ new Date() + '-' + Math.floor( Math.random() * 11 ));
                    this.$tabs.append( '<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>' );
                    this.$add_button = $( '<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + window.i18nLocale.add_tab + '"></a></li>' ).appendTo( this.$tabs.find( ".tabs_controls" ) );
                },
                addTab: function ( e ) {
                    e.preventDefault();
                    // check user role to add controls
                    if ( ! this.hasUserAccess() ) {
                        return false;
                    }
                    this.new_tab_adding = true;
                    var tab_title      = window.i18nLocale.tab,
                        tab_icon ='icon-cog',
                        tabs_count     = this.$tabs.find( '[data-element_type=md_hor_tab]' ).length,
                        tab_id         = (+ new Date() + '-' + tabs_count + '-' + Math.floor( Math.random() * 11 ));
                    vc.shortcodes.create( {
                        shortcode: 'md_hor_tab',
                        params: { title: tab_title, tab_id: tab_id},
                        parent_id: this.model.id
                    } );
                    return false;
                },
                stopSorting: function ( event, ui ) {
                    var shortcode;
                    this.$tabs.find( 'ul.tabs_controls li:not(.add_tab_block)' ).each( function ( index ) {
                        var href = $( this ).find( 'a' ).attr( 'href' ).replace( "#", "" );
                        shortcode = vc.shortcodes.get( $( '[id=' + $( this ).attr( 'aria-controls' ) + ']' ).data( 'model-id' ) );
                        vc.storage.lock();
                        shortcode.save( { 'order': $( this ).index() } ); // Optimize
                    } );
                    shortcode && shortcode.save();
                },
                changedContent: function ( view ) {
                    var params = view.model.get( 'params' );
                    if ( ! this.$tabs.hasClass( 'ui-tabs' ) ) {
                        this.$tabs.tabs( {
                            select: function ( event, ui ) {
                                return ! $( ui.tab ).hasClass( 'add_tab' );
                            }
                        } );
                        this.$tabs.find( ".ui-tabs-nav" ).prependTo( this.$tabs );
                        // check user role to add controls
                        if ( this.hasUserAccess() ) {
                            this.$tabs.find( ".ui-tabs-nav" ).sortable( {
                                axis: (this.$tabs.closest( '[data-element_type]' ).data( 'element_type' ) == 'vc_tour' ? 'y' : 'x'),
                                update: this.stopSorting,
                                items: "> li:not(.add_tab_block)"
                            } );
                        }
                    }
                    if ( view.model.get( 'cloned' ) === true ) {
                        var cloned_from = view.model.get( 'cloned_from' ),
                            $tab_controls = $( '.tabs_controls > .add_tab_block', this.$content ),
                            $new_tab = $( "<li><a href='#tab-" + params.tab_id + "'><div class='horTabTitle'>" + params.title + "</div><i class='right-icon "+params.tab_icon+"'></i></a></li>" ).insertBefore( $tab_controls );
                        this.$tabs.tabs( 'refresh' );
                        this.$tabs.tabs( "option", 'active', $new_tab.index() );
                    } else {
                        $( "<li><a href='#tab-" + params.tab_id + "'><div class='horTabTitle'>" + params.title + "</div><i class='right-icon "+params.tab_icon+"'></i></a></li>" )
                            .insertBefore( this.$add_button );
                        this.$tabs.tabs( 'refresh' );
                        this.$tabs.tabs( "option",
                            "active",
                            this.new_tab_adding ? $( '.ui-tabs-nav li', this.$content ).length - 2 : 0 );
                    }
                    this.new_tab_adding = false;
                },
                cloneModel: function ( model, parent_id, save_order ) {
                    var new_order,
                        model_clone,
                        params,
                        tag;
                    new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
                    params = _.extend( {}, model.get( 'params' ) );
                    tag = model.get( 'shortcode' );
                    if ( tag === 'md_hor_tab' ) {
                        _.extend( params,
                            { tab_id: + new Date() + '-' + this.$tabs.find( '[data-element-type=md_hor_tab]' ).length + '-' + Math.floor( Math.random() * 11 ) } );
                    }
                    model_clone = Shortcodes.create( {
                        shortcode: tag,
                        id: vc_guid(),
                        parent_id: parent_id,
                        order: new_order,
                        cloned: (tag !== 'md_hor_tab'),
                        cloned_from: model.toJSON(),
                        params: params
                    } );
                    _.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
                        this.cloneModel( shortcode, model_clone.get( 'id' ), true );
                    }, this );
                    return model_clone;
                }
            } );

            window.MdHorTabView = window.VcColumnView.extend( {
                events: {
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-prepend': 'addElement',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone',
                    'click > .wpb_element_wrapper > .vc_empty-container': 'addToEmpty'
                },
                render: function () {
                    var params = this.model.get( 'params' );
                    window.MdHorTabView.__super__.render.call( this );
                    if ( ! params.tab_id) {
                        params.tab_id = (+ new Date() + '-' + Math.floor( Math.random() * 11 ));
                        this.model.save( 'params', params );
                    }
                    this.id = 'tab-' + params.tab_id;
                    this.$el.attr( 'id', this.id );
                    return this;
                },
                ready: function ( e ) {
                    window.MdHorTabView.__super__.ready.call( this, e );
                    this.$tabs = this.$el.closest( '.wpb_tabs_holder' );
                    var params = this.model.get( 'params' );
                    return this;
                },
                changeShortcodeParams: function ( model ) {
                    var params;
                    window.MdHorTabView.__super__.changeShortcodeParams.call( this, model );
                    params = model.get( 'params' );
                    var $html='';
                    if(params.title!='') {
                        $html += "<div class='horTabTitle'>" + params.title + '</div>';
                    }else {
                        $html += "<div class='horTabTitle'></div>";
                    }
                    if(params.tab_icon!='') {
                        $html += "<i class='right-icon " + params.tab_icon + "'></i>";
                    }else {
                        $html += "<i class='right-icon'></i>";
                    }
                    if ( _.isObject( params ) && _.isString( params.title ) && _.isString( params.tab_id ) ) {
                        $( '.ui-tabs-nav [href=#tab-' + params.tab_id + ']' ).html( $html);
                    }
                },
                deleteShortcode: function ( e ) {
                    _.isObject( e ) && e.preventDefault();
                    var answer = confirm( window.i18nLocale.press_ok_to_delete_section ),
                        parent_id = this.model.get( 'parent_id' );
                    if ( answer !== true ) {
                        return false;
                    }
                    this.model.destroy();
                    if ( ! vc.shortcodes.where( { parent_id: parent_id } ).length ) {
                        var parent = vc.shortcodes.get( parent_id );
                        parent.destroy();
                        return false;
                    }
                    var params = this.model.get( 'params' ),
                        current_tab_index = $( '[href=#tab-' + params.tab_id + ']', this.$tabs ).parent().index();
                    $( '[href=#tab-' + params.tab_id + ']' ).parent().remove();
                    var tab_length = this.$tabs.find( '.ui-tabs-nav li:not(.add_tab_block)' ).length;
                    if ( tab_length > 0 ) {
                        this.$tabs.tabs( 'refresh' );
                    }
                    if ( current_tab_index < tab_length ) {
                        this.$tabs.tabs( "option", "active", current_tab_index );
                    } else if ( tab_length > 0 ) {
                        this.$tabs.tabs( "option", "active", tab_length - 1 );
                    }
                },
                cloneModel: function ( model, parent_id, save_order ) {
                    var new_order,
                        model_clone,
                        params,
                        tag;
                    new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
                    params = _.extend( {}, model.get( 'params' ) );
                    tag = model.get( 'shortcode' );
                    if ( tag === 'md_hor_tab' ) {
                        _.extend( params,
                            { tab_id: + new Date() + '-' + this.$tabs.find( '[data-element_type=md_hor_tab]' ).length + '-' + Math.floor( Math.random() * 11 ) } );
                    }
                    model_clone = Shortcodes.create( {
                        shortcode: tag,
                        parent_id: parent_id,
                        order: new_order,
                        cloned: true,
                        cloned_from: model.toJSON(),
                        params: params
                    } );
                    _.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
                        this.cloneModel( shortcode, model_clone.get( 'id' ), true );
                    }, this );
                    return model_clone;
                }
            } );

            /*----------------------------Backend Horizontal Tabs 2---------------------------*/
            window.MdHorTabs2View = vc.shortcode_view.extend( {
                new_tab_adding: false,
                events: {
                    'click .add_tab': 'addTab',
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone'
                },
                initialize: function ( params ) {
                    window.MdHorTabs2View.__super__.initialize.call( this, params );
                    _.bindAll( this, 'stopSorting' );
                },
                render: function () {
                    window.MdHorTabs2View.__super__.render.call( this );
                    this.$tabs = this.$el.find( '.wpb_tabs_holder' );
                    this.createAddTabButton();
                    return this;
                },
                ready: function ( e ) {
                    window.MdHorTabs2View.__super__.ready.call( this, e );
                },
                createAddTabButton: function () {
                    var new_tab_button_id = (+ new Date() + '-' + Math.floor( Math.random() * 11 ));
                    this.$tabs.append( '<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>' );
                    this.$add_button = $( '<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + window.i18nLocale.add_tab + '"></a></li>' ).appendTo( this.$tabs.find( ".tabs_controls" ) );
                },
                addTab: function ( e ) {
                    e.preventDefault();
                    // check user role to add controls
                    if ( ! this.hasUserAccess() ) {
                        return false;
                    }
                    this.new_tab_adding = true;
                    var tab_title      = window.i18nLocale.tab,
                        tab_icon ='icon-cog',
                        tabs_count     = this.$tabs.find( '[data-element_type=md_hor_tab2]' ).length,
                        tab_id         = (+ new Date() + '-' + tabs_count + '-' + Math.floor( Math.random() * 11 ));
                    vc.shortcodes.create( {
                        shortcode: 'md_hor_tab2',
                        params: { title: tab_title, tab_id: tab_id},
                        parent_id: this.model.id
                    } );
                    return false;
                },
                stopSorting: function ( event, ui ) {
                    var shortcode;
                    this.$tabs.find( 'ul.tabs_controls li:not(.add_tab_block)' ).each( function ( index ) {
                        var href = $( this ).find( 'a' ).attr( 'href' ).replace( "#", "" );
                        shortcode = vc.shortcodes.get( $( '[id=' + $( this ).attr( 'aria-controls' ) + ']' ).data( 'model-id' ) );
                        vc.storage.lock();
                        shortcode.save( { 'order': $( this ).index() } ); // Optimize
                    } );
                    shortcode && shortcode.save();
                },
                changedContent: function ( view ) {
                    var params = view.model.get( 'params' );
                    if ( ! this.$tabs.hasClass( 'ui-tabs' ) ) {
                        this.$tabs.tabs( {
                            select: function ( event, ui ) {
                                return ! $( ui.tab ).hasClass( 'add_tab' );
                            }
                        } );
                        this.$tabs.find( ".ui-tabs-nav" ).prependTo( this.$tabs );
                        // check user role to add controls
                        if ( this.hasUserAccess() ) {
                            this.$tabs.find( ".ui-tabs-nav" ).sortable( {
                                axis: (this.$tabs.closest( '[data-element_type]' ).data( 'element_type' ) == 'vc_tour' ? 'y' : 'x'),
                                update: this.stopSorting,
                                items: "> li:not(.add_tab_block)"
                            } );
                        }
                    }
                    if ( view.model.get( 'cloned' ) === true ) {
                        var cloned_from = view.model.get( 'cloned_from' ),
                            $tab_controls = $( '.tabs_controls > .add_tab_block', this.$content ),
                            $new_tab = $( "<li><a href='#tab-" + params.tab_id + "'><div class='horTabTitle'>" + params.title + "</div><i class='right-icon "+params.tab_icon+"'></i></a></li>" ).insertBefore( $tab_controls );
                        this.$tabs.tabs( 'refresh' );
                        this.$tabs.tabs( "option", 'active', $new_tab.index() );
                    } else {
                        $( "<li><a href='#tab-" + params.tab_id + "'><div class='horTabTitle'>" + params.title + "</div><i class='right-icon "+params.tab_icon+"'></i></a></li>" )
                            .insertBefore( this.$add_button );
                        this.$tabs.tabs( 'refresh' );
                        this.$tabs.tabs( "option",
                            "active",
                            this.new_tab_adding ? $( '.ui-tabs-nav li', this.$content ).length - 2 : 0 );
                    }
                    this.new_tab_adding = false;
                },
                cloneModel: function ( model, parent_id, save_order ) {
                    var new_order,
                        model_clone,
                        params,
                        tag;
                    new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
                    params = _.extend( {}, model.get( 'params' ) );
                    tag = model.get( 'shortcode' );
                    if ( tag === 'md_hor_tab2' ) {
                        _.extend( params,
                            { tab_id: + new Date() + '-' + this.$tabs.find( '[data-element-type=md_hor_tab2]' ).length + '-' + Math.floor( Math.random() * 11 ) } );
                    }
                    model_clone = Shortcodes.create( {
                        shortcode: tag,
                        id: vc_guid(),
                        parent_id: parent_id,
                        order: new_order,
                        cloned: (tag !== 'md_hor_tab2'),
                        cloned_from: model.toJSON(),
                        params: params
                    } );
                    _.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
                        this.cloneModel( shortcode, model_clone.get( 'id' ), true );
                    }, this );
                    return model_clone;
                }
            } );

            window.MdHorTab2View = window.VcColumnView.extend( {
                events: {
                    'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
                    'click > .vc_controls .vc_control-btn-prepend': 'addElement',
                    'click > .vc_controls .vc_control-btn-edit': 'editElement',
                    'click > .vc_controls .vc_control-btn-clone': 'clone',
                    'click > .wpb_element_wrapper > .vc_empty-container': 'addToEmpty'
                },
                render: function () {
                    var params = this.model.get( 'params' );
                    window.MdHorTab2View.__super__.render.call( this );
                    if ( ! params.tab_id) {
                        params.tab_id = (+ new Date() + '-' + Math.floor( Math.random() * 11 ));
                        this.model.save( 'params', params );
                    }
                    this.id = 'tab-' + params.tab_id;
                    this.$el.attr( 'id', this.id );
                    return this;
                },
                ready: function ( e ) {
                    window.MdHorTab2View.__super__.ready.call( this, e );
                    this.$tabs = this.$el.closest( '.wpb_tabs_holder' );
                    var params = this.model.get( 'params' );
                    return this;
                },
                changeShortcodeParams: function ( model ) {
                    var params;
                    window.MdHorTab2View.__super__.changeShortcodeParams.call( this, model );
                    params = model.get( 'params' );
                    var $html='';
                    if(params.title!='') {
                        $html += "<div class='horTabTitle'>" + params.title + '</div>';
                    }else {
                        $html += "<div class='horTabTitle'></div>";
                    }
                    if(params.tab_icon!='') {
                        $html += "<i class='right-icon " + params.tab_icon + "'></i>";
                    }else {
                        $html += "<i class='right-icon'></i>";
                    }
                    if ( _.isObject( params ) && _.isString( params.title ) && _.isString( params.tab_id ) ) {
                        $( '.ui-tabs-nav [href=#tab-' + params.tab_id + ']' ).html( $html);
                    }
                },
                deleteShortcode: function ( e ) {
                    _.isObject( e ) && e.preventDefault();
                    var answer = confirm( window.i18nLocale.press_ok_to_delete_section ),
                        parent_id = this.model.get( 'parent_id' );
                    if ( answer !== true ) {
                        return false;
                    }
                    this.model.destroy();
                    if ( ! vc.shortcodes.where( { parent_id: parent_id } ).length ) {
                        var parent = vc.shortcodes.get( parent_id );
                        parent.destroy();
                        return false;
                    }
                    var params = this.model.get( 'params' ),
                        current_tab_index = $( '[href=#tab-' + params.tab_id + ']', this.$tabs ).parent().index();
                    $( '[href=#tab-' + params.tab_id + ']' ).parent().remove();
                    var tab_length = this.$tabs.find( '.ui-tabs-nav li:not(.add_tab_block)' ).length;
                    if ( tab_length > 0 ) {
                        this.$tabs.tabs( 'refresh' );
                    }
                    if ( current_tab_index < tab_length ) {
                        this.$tabs.tabs( "option", "active", current_tab_index );
                    } else if ( tab_length > 0 ) {
                        this.$tabs.tabs( "option", "active", tab_length - 1 );
                    }
                },
                cloneModel: function ( model, parent_id, save_order ) {
                    var new_order,
                        model_clone,
                        params,
                        tag;
                    new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
                    params = _.extend( {}, model.get( 'params' ) );
                    tag = model.get( 'shortcode' );
                    if ( tag === 'md_hor_tab2' ) {
                        _.extend( params,
                            { tab_id: + new Date() + '-' + this.$tabs.find( '[data-element_type=md_hor_tab2]' ).length + '-' + Math.floor( Math.random() * 11 ) } );
                    }
                    model_clone = Shortcodes.create( {
                        shortcode: tag,
                        parent_id: parent_id,
                        order: new_order,
                        cloned: true,
                        cloned_from: model.toJSON(),
                        params: params
                    } );
                    _.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
                        this.cloneModel( shortcode, model_clone.get( 'id' ), true );
                    }, this );
                    return model_clone;
                }
            } );

        }catch (e){}
    }

    function pixflow_media_upload() {
        'use strict';
        var custom_uploader;

            $(document).on("click", '.custom_media_button',function(e) {

            e.preventDefault();

            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: admin_var.chooseImage,
                button: {
                    text: admin_var.chooseImage
                },
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('.custom_media_url').val(attachment.url);
            });

            //Open the uploader dialog
            custom_uploader.open();

            return true;
        });
    }

    function pixflow_singlePageLayout (){
        'use strict';
        var $body, $obj,$popup;

        if ( $(window.top.document.getElementsByTagName('body')).hasClass('wp-customizer') ){
            $body = $('iframe#vc_inline-frame').contents().find('body');
            $popup = $('body');
            $obj = $('iframe#vc_inline-frame').contents();
        }else{
            $popup = $body = $obj = $('body');
        }

        if ( !$body.hasClass('single-portfolio') && !$body.hasClass('post-type-portfolio')) {
            $obj.find('.wpb_switch-to-composer').click(function(){
                var $this = $(this);
                if( $this.parent('.composer-switch').hasClass('vc_backend-status') ){
                    $this.text(admin_var.classicMode);
                }else{
                    $this.text(admin_var.backendEditor);
                }
            }).click();

            $obj.find('.vc_default-templates .wpb_row,.vc_default-templates .vc_row-fluid').append(''+
            '<a class="vc_templates-image vc_templates-blank" href="#"><span>'+admin_var.yourStyle+'</span></a>');

            $obj.find('.vc_templates-blank').click(function(){
                if($(this).hasClass('vc_templates-blank')) {
                    $obj.find('#vc_no-content-add-element').click();
                }
                if($(this).attr('target')){
                    $(this).removeAttr('target');
                }
            });

            $('#titlediv').after('<a target="_blank" href="http://support.pixflow.net" class="support-forum">'+admin_var.supportForum+'</a>');
            $('.composer-switch , .vc_backend-status').append('<a href="'+$('.back-to-customizer .button').attr('href')+'" class="wpb_switch-to-customizer">'+admin_var.massiveBuilder+'</a>');

            return;
        }


        $obj.find('.vc_welcome-header').html('<h5>'+admin_var.portfolioPostLayout+'</h5>');
        $obj.find('.vc_welcome-header h5').after('<h3>'+admin_var.welcomeMsg+'</h3>');

        $obj.find('.vc_welcome-header h3').after('<div class="portfolio-templates">' +
        '<div class="clearfix">' +
        '<div class="md-template-button custom" data-name="custom">' +
        '<span class="image"></span><span class="name">'+admin_var.yourStyle+'</span>' +
        '</div>' +
        ' </div>' +
        '</div>');

        $obj.find('#vc_no-content-add-element,#vc_templates-more-layouts').css({opacity:0,zIndex:-999});

        $obj.find('.portfolio-templates .md-template-button').click(function(){
           var clicked = $(this).attr('data-name');
            clicked = clicked[0].toUpperCase()+clicked.slice(1);

            $obj.find('.portfolio-templates .md-template-button').removeClass('clicked');
            $(this).addClass('clicked');
            if ($(this).hasClass('custom')){
                $obj.find('#vc_no-content-add-element').click();
            }else {
                $body.find('#vc_templates-more-layouts').click();
                $popup.find('.vc_templates-panel').css('opacity', 0);
                $popup.find('#vc_ui-panel-templates .vc_ui-list-bar-item-trigger:contains(' + clicked + ')').click();
                $popup.find('.vc_templates-panel .vc_ui-close-button').click();
            }
        });


        $('#poststuff #postbox-container-1 #postimagediv').after('<div class="thumbnail-point"></div>');
        $('.wpb_switch-to-composer').click(function(){
            var $this = $(this);
            if( $this.parent('.composer-switch').hasClass('vc_backend-status') ){
                $this.text(admin_var.classicMode);
            }else{
                $this.text(admin_var.backendEditor);
            }
        }).click();


        $('.composer-switch , .vc_backend-status').append('<a href="'+$('.back-to-customizer .button').attr('href')+'" class="wpb_switch-to-customizer">'+admin_var.massiveBuilder+'</a><a class="templates">'+admin_var.changeLayout+'</a>');
        $obj.find('.vc_default-templates .wpb_row,.vc_default-templates .vc_row-fluid').append(''+
        '<a class="vc_templates-image vc_templates-blank" href="#"><span>'+admin_var.yourStyle+'</span></a>');
        $('.post-type-portfolio .vc_templates-image').click(function(){
            $('.post-type-portfolio .vc_templates-image').removeClass('clicked');
            $(this).addClass('clicked');
            if($(this).hasClass('vc_templates-blank')) {
                $('#vc_no-content-add-element').click();
            }


        });
        $('.templates').click(function(){
            if ($('.vc_not-empty').length) {
                var r = confirm(admin_var.changeLayoutMsg);
                if (r == true) {
                    $('[data-model-id]').each(function () {
                        try {
                            vc.shortcodes.get($(this).attr('data-model-id')).destroy();
                            $('.post-type-portfolio .vc_templates-image').removeClass('clicked');
                        } catch (e) {
                        }
                    })
                } else {
                }
            }else{
                $('#vc_templates-more-layouts').click();
                $('[data-model-id]').each(function () {
                    try {
                        vc.shortcodes.get($(this).attr('data-model-id')).destroy();
                        $('.post-type-portfolio .vc_templates-image').removeClass('clicked');
                    } catch (e) {
                    }
                })
            }
        });
    }

    function pixflow_classic_mode(){
        'use strict';
        var currentPage=location.pathname.substring(location.pathname.lastIndexOf("/") + 1),
            $composerBtn = jQuery('.wpb_switch-to-composer'),
            $postPage = $('.post-type-post'),
            $switch = $('.composer-switch');

            if($composerBtn.length<1){
                return;
            }
        if (! $switch.hasClass('vc_backend-status') && !$postPage.length ){
            $composerBtn.click();
            $composerBtn.html(admin_var.classicMode);
        } else if( $switch.hasClass('vc_backend-status') && $postPage.length ) {
            $composerBtn.click();
            $composerBtn.html(admin_var.backendEditor);
        }
    }

    function pixflow_addMassivePanel(){
        'use strict';
        var $welcomePanel = $('#welcome-panel');

        if( ! $welcomePanel.length )
            return;

        var href = $('#menu-appearance .hide-if-no-customize a').attr('href');

        $welcomePanel.before('' +
             '<div class="massive-panel">' +
             '<div class="left-side">' +
             '<h1 class="title">'+admin_var.createWeb+'<span> '+admin_var.massiveBuilder+'</span></h1>' +
             '<hr>' +
             '<p class="description">'+admin_var.massiveBuilderMsg+'</p>' +
             '<a class="button" href="'+ href +'"> '+admin_var.massiveBuilder+'</a>' +
             '</div>' +
             '<div class="right-side">' +
             '<a target="_blank" href="http://support.pixflow.net" class="help"></a>'+
             '</div>'+
             '<div class="clearfix"></div>'+
             '</div>');
    }

    function pixflow_metabox(){
        'use strict';
        if($('.post-format').length<1){
            return;
        }

        if($('#post-format-gallery').attr('checked')=='checked'){
            $('#featuredgallerydiv').css('display','block');
            $('#section-video').css('display','none');
            $('#section-audio').css('display','none');
            $('#blog_meta_box_video_url').css('display','none');
            $('#blog_meta_box_audio_url').css('display','none');
        }
        else if($('#post-format-audio').attr('checked')=='checked'){
            $('#featuredgallerydiv').css('display','none');
            $('#blog_meta_box_video_url').css('display','none');
            $('#blog_meta_box_audio_url').css('display','block');
            $('#section-video').css('display','none');
            $('#section-audio').css('display','block');
        }
        else if($('#post-format-video').attr('checked')=='checked'){
            $('#featuredgallerydiv').css('display','none');
            $('#blog_meta_box_video_url').css('display','block');
            $('#blog_meta_box_audio_url').css('display','none');
            $('#section-video').css('display','block');
            $('#section-audio').css('display','none');
        }else{
            $('#featuredgallerydiv').css('display','none');
            $('#section-video').css('display','none');
            $('#section-audio').css('display','none');
            $('#blog_meta_box_video_url').css('display','none');
            $('#blog_meta_box_audio_url').css('display','none');
        }

        $('.post-format').click(function(){

            if($(this).attr('value')=='gallery'){
                $('#featuredgallerydiv').css('display','block');
                $('#section-video').css('display','none');
                $('#section-audio').css('display','none');
                $('#blog_meta_box_video_url').css('display','none');
                $('#blog_meta_box_audio_url').css('display','none');
            }
            if($(this).attr('value')=='audio'){
                $('#featuredgallerydiv').css('display','none');
                $('#section-video').css('display','none');
                $('#section-audio').css('display','block');
                $('#blog_meta_box_video_url').css('display','none');
                $('#blog_meta_box_audio_url').css('display','block');
            }
            if($(this).attr('value')=='video'){
                $('#featuredgallerydiv').css('display','none');
                $('#section-video').css('display','block');
                $('#section-audio').css('display','none');
                $('#blog_meta_box_video_url').css('display','block');
                $('#blog_meta_box_audio_url').css('display','none');
            }
            if($(this).attr('value')=='0' || $(this).attr('value')=='quote') {
                $('#featuredgallerydiv').css('display','none');
                $('#section-video').css('display','none');
                $('#section-audio').css('display','none');
                $('#blog_meta_box_video_url').css('display','none');
                $('#blog_meta_box_audio_url').css('display','none');
            }
        });

    }

    function pixflow_featuredGallery(){
        'use strict';
        function pixflow_fixBackButton() {
            'use strict';
            setTimeout(function(){

                jQuery('.media-menu a:first-child').text('? '+admin_var.editSelection).addClass('button').addClass('button-large').addClass('button-primary');

            },0);

        }

        function pixflow_ajaxUpdateTempMetaData() {
            'use strict';
            jQuery.ajax({
                type : "post",
                dataType : "json",
                url : myAjax.ajaxurl,
                data : {
                    action: "pixflow_fg_update_temp",
                    fg_post_id: jQuery("#fg_perm_metadata").data("post_id"),
                    fg_temp_noncedata: jQuery("#fg_temp_noncedata").val(),
                    fg_temp_metadata: jQuery("#fg_perm_metadata").val()
                },
                success: function(response) {
                    if (response == "error") {
                        alert(admin_var.updateErr);
                    }
                }
            });

        }
        // Uploading files
        if (jQuery('#fg_removeall').hasClass('premp6')) {
            var button = '<button class="media-modal-icon"></button>';
        } else {
            var button = '<button>?</button>';
        }
        jQuery('#fg_select').on('click', function (event) {
            event.preventDefault();
            // If the media frame already exists, reopen it.
            if (file_frame) {
                file_frame.open();
                pixflow_fixBackButton();
                return;
            }
            // Create the media frame.
            var file_frame = wp.media.frame = wp.media({
                frame: "post",
                state: "featured-gallery",
                library: {type: 'image'},
                button: {text: "Edit Image Order"},
                multiple: true
            });
            // Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
            file_frame.states.add([
                new wp.media.controller.Library({
                    id: 'featured-gallery',
                    title: 'Select Images for Gallery',
                    priority: 20,
                    toolbar: 'main-gallery',
                    filterable: 'uploaded',
                    library: wp.media.query(file_frame.options.library),
                    multiple: file_frame.options.multiple ? 'reset' : false,
                    editable: true,
                    allowLocalEdits: true,
                    displaySettings: true,
                    displayUserSettings: true
                }),
            ]);
            file_frame.on('open', function () {
                var selection = file_frame.state().get('selection');
                var library = file_frame.state('gallery-edit').get('library');
                var ids = jQuery('#fg_perm_metadata').val();
                if (ids) {
                    var idsArray = ids.split(',');
                    idsArray.forEach(function (id) {
                        var attachment = wp.media.attachment(id);
                        attachment.fetch();
                        selection.add(attachment ? [attachment] : []);
                    });
                    file_frame.setState('gallery-edit');
                    idsArray.forEach(function (id) {
                        var attachment = wp.media.attachment(id);
                        attachment.fetch();
                        library.add(attachment ? [attachment] : []);
                    });
                }
            });

            file_frame.on('ready', function () {
                jQuery('.media-modal').addClass('no-sidebar');
                pixflow_fixBackButton();
            });

            // When an image is selected, run a callback.
            file_frame.on('update', function () {
                var imageIDArray = [];
                var imageHTML = '';
                var metadataString = '',
                images = file_frame.state().get('library');
                images.each(function (attachment) {
                    imageIDArray.push(attachment.attributes.id);
                    imageHTML += '<li>' + button + '<img id="' + attachment.attributes.id + '" src="' + attachment.attributes.url + '"></li>';
                });
                metadataString = imageIDArray.join(",");
                if (metadataString) {
                    jQuery("#fg_perm_metadata").val(metadataString);
                    jQuery("#featuredgallerydiv ul").html(imageHTML);
                    jQuery('#fg_select').text(admin_var.editSelection);
                    jQuery('#fg_removeall').addClass('visible');
                    setTimeout(function () {
                        pixflow_ajaxUpdateTempMetaData();
                    }, 0);
                }
            });

            // Finally, open the modal
            file_frame.open();
        });

        jQuery('#featuredgallerydiv ul').on('click', 'button', function (event) {
            event.preventDefault();

            if (confirm('Are you sure you want to remove this image?')) {

                var removedImage = jQuery(this).parent().children('img').attr('id');

                var oldGallery = jQuery("#fg_perm_metadata").val();

                var newGallery = oldGallery.replace(',' + removedImage, '').replace(removedImage + ',', '').replace(removedImage, '');

                jQuery(this).parent('li').remove();

                jQuery("#fg_perm_metadata").val(newGallery);

                if (newGallery == "") {

                    jQuery('#fg_select').text(admin_var.selectImage);

                    jQuery('#fg_removeall').removeClass('visible');

                }

                pixflow_ajaxUpdateTempMetaData();

            }

        });

        jQuery('#fg_removeall').on('click', function (event) {

            event.preventDefault();

            if (confirm('Are you sure you want to remove all images?')) {

                jQuery("#featuredgallerydiv ul").html("");

                jQuery("#fg_perm_metadata").val("");

                jQuery('#fg_removeall').removeClass('visible');

                jQuery('#fg_select').text(admin_var.selectImage);

                pixflow_ajaxUpdateTempMetaData();

            }

        });
    }

    function pixflow_emptyPageLayout(){
        'use strict';
        var $obj,$body;
            if ($(window.top.document.getElementsByTagName('body')).hasClass('wp-customizer') && $('iframe#vc_inline-frame').length) {
                $obj = $('iframe#vc_inline-frame').contents();
                $body = $('iframe#vc_inline-frame').contents().find('body');
            } else {
                $body = $obj = $('body');
            }

        if ( $body.hasClass('single-portfolio') || $body.hasClass('post-type-portfolio') ){
            return;
        } else {

            if ($body.hasClass('compose-mode')) {
                $obj.find('.vc_welcome-header,.vc_welcome-brand,.vc_ui-help-block').remove();
                $obj.find('.vc_welcome #vc_no-content-add-element').clone(true).insertAfter($obj.find('#vc_no-content-helper .vc_ui-btn-group')).addClass('md-blank-btn');
                $obj.find('.vc_ui-btn-group #vc_no-content-add-element,#vc_templates-more-layouts').remove();
                $obj.find('#vc_no-content-helper .md-blank-btn').after('<h5 class="head">'+admin_var.blankPage+'</h5>');
                $obj.find('#vc_no-content-helper .head').after('<h3 class="desc">'+admin_var.dragShortcode+'</h3>');

                var iframeHeight = $('iframe#vc_inline-frame').height(),
                    footerHeight = $obj.find('footer').height(),
                    num;

                num = iframeHeight - footerHeight;
                $obj.find('#vc_no-content-helper.vc_welcome:not(.vc_not-empty)').css('height', num + 'px');

            } else {

                $obj.find('.vc_welcome-header,.vc_welcome-brand,.vc_ui-help-block').remove();
                $obj.find('#vc_no-content-add-element').clone(true).insertAfter('#vc_no-content-helper .vc_ui-btn-group').addClass('md-blank-btn');
                $obj.find('.vc_ui-btn-group #vc_no-content-add-element,#vc_templates-more-layouts').remove();
                $obj.find('#vc_no-content-helper .md-blank-btn').after('<h5 class="head">'+admin_var.blankPage+'</h5>');
                $obj.find('#vc_no-content-helper .head').after('<h3 class="desc">'+admin_var.chooseShortcode+'</h3>');

            }
        }


    }

    function pixflow_dependency(){
        'use strict';
        $('body').on('click','.wpb-input[data-dependent-set="true"]',function(){
            $('#vc_ui-panel-edit-element ul.vc_ui-tabs-line-dropdown > li').each(function(){
                $(this).appendTo('#vc_ui-panel-edit-element ul.vc_general');
            })
            $('#vc_ui-panel-edit-element ul.vc_general').sort(function (a, b) {
                var contentA =parseInt( $(a).attr('data-tab-index'));
                var contentB =parseInt( $(b).attr('data-tab-index'));
                return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
            })
            $('.vc_ui-panel-header-content li.vc_ui-tabs-line-dropdown-toggle').appendTo('#vc_ui-panel-edit-element ul.vc_general');
        })
    }

    $('.remove-megaMenu-attachment').click(function(){
        var $this=$(this),
            menuId=$this.attr('id').split("-");

        $('#image-'+menuId[1]).remove();
        $('#attachment-'+menuId[1]).remove();

        $('#input-attachment-'+menuId[1]).val('1');
    });

    $(document).ready(function () {
        pixflow_IconSelect();
        pixflow_dependency();
        pixflow_showIcons();
        pixflow_showMegaBg();
        pixflow_menuUpdate();
       // mdAppendSeparatorToControllers();
       //md_addBrToTitles();
        pixflow_customShortcodesJs();
        pixflow_media_upload();
        pixflow_addMassivePanel();
        pixflow_metabox();
        pixflow_featuredGallery();

    });

    $(window).load(function(){

        pixflow_emptyPageLayout();
        pixflow_singlePageLayout();
        pixflow_classic_mode();

    });
})(jQuery);
