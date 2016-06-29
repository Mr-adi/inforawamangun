
function pixflow_save_status(status, id, detail, action){
    'use strict';
    if(status == '' || id == ''){
        return
    }
    if(action != 'change'){
        action = 'save';
    }
    if(action != 'save'){
        var $loader = pixflow_customizerObj().$('#page-option-btn .save-loading').stop().animate({width:'90%'},1000);
    }
    jQuery.ajax({
        type: "post",
        url: ajax_var.url,
        data: "action=pixflow-save-status" +
        "&nonce=" + ajax_var.nonce +
        "&pixflow_save_status=" +
        "&id=" + id +
        "&act=" + action +
        "&detail=" + detail +
        "&status=" + status,
        success: function (result) {
            if(status == 'unique' && action != 'save'){
                $loader.stop().animate({width:'99%'},200,'swing',function(){
                    $(this).css('width',0);
                    pixflow_customizerObj().$('#page-option-btn').removeAttr('style');
                });
            }

            if(status == 'general' && action != 'save'){
                $loader.stop().animate({width:'99%'},200,'swing',function(){

                    $(this).css('width',0);
                    pixflow_customizerObj().$('#page-option-btn').removeAttr('style');
                });
            }
        }
    })
}
function pixflow_save_unique_setting(id, detail){
    'use strict';
    if(id == ''){
        return;
    }
    try {
        var w = window.top;
    }catch(e){
        return;
    }
    var md_api = w.wp.customize;
    var md_dirtyCustomized = {};
    md_api.each( function ( value, key ) {
        if ( value._dirty ) {
            md_dirtyCustomized[ key ] = value();
        }
    } );
    jQuery.ajax({
        type: "post",
        url: ajax_var.url,
        data: "action=pixflow-save-unique-setting" +
        "&nonce=" + ajax_var.nonce +
        "&pixflow_save_unique_setting=" +
        "&id=" + id +
        "&detail=" + detail +
        "&dirtyCustomized=" + JSON.stringify(md_dirtyCustomized) +
        "&headerItemOrder=" + window.top.wp.customize('header_items_order').get(),
        success: function (result) {
            console.log(result)
        }
    })
}
