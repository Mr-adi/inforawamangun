(function ($) {

    function pixflow_postTypes(){
        'use strict';
        $('#postdivrich').hide();
        // Hide Quote format
        $('label.post-format-quote').next().remove();
        $('#post-format-quote,label.post-format-quote').remove();
        // Hide Audio format
        $('label.post-format-audio').next().remove();
        $('#post-format-audio,label.post-format-audio').remove();
        // Sync options with selected post format
        pixflow_portfolioGroups($('input[name="post_format"]:checked').attr('value'));
        $('input[name="post_format"]').change(function(){
            pixflow_portfolioGroups($(this).val());
        });
        // Get selected format and sync portfolio setting
        function pixflow_portfolioGroups(value){
            if('video' == value){
                $('.wpa_loop-video_group').fadeIn();
                $('div[id *= video_position ]').fadeIn();

            }else{
                $('.wpa_loop-video_group').fadeOut();
                $('div[id *= video_position ]').fadeOut();

            }
        }
    }

    function pixflow_portfolioTemplate(){
        'use strict';
        var $portofolioTemplate = $('input[name="portfolio_options[template_type]"]');
        pixflow_syncEditor($('input[name="portfolio_options[template_type]"]:checked').attr('value'));
        $portofolioTemplate.change(function(){
            pixflow_syncEditor($(this).val());
        });
        function pixflow_syncEditor(template){
            if('standard' == template){
                $('#wpb_visual_composer,.composer-switch').slideUp();
                $('#portfolio_options_metabox').css('margin-top','10px');
            }else if('shortcode' == template){
                $('#wpb_visual_composer,.composer-switch').slideDown();
                $('#portfolio_options_metabox').css('margin-top','auto');
            }
            $(window).resize();
        }
    }
    $(window).load(function () {
        setTimeout(function(){
            pixflow_portfolioTemplate();
        },100);
        pixflow_postTypes();
    });

})(jQuery);