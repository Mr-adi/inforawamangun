if(window.top.jQuery) {
    if (window.top.jQuery('#customize-preview > iframe').contents().find('iframe#px-iframe').length == 0) {
        if(window.top.jQuery('#customize-preview > iframe').length >1){
            window.top.jQuery('#customize-preview > iframe').first().remove();
        }
        document.write("<iframe id='px-iframe' style='position:fixed;width:100%; height:100%; border:none' src='"+localizeVals.vcURL+"'></iframe>");
    }else{
        window.top.jQuery('#customize-preview > iframe').contents().find('iframe#px-iframe').attr('src', localizeVals.vcURL);
    }
}else{
    window.location.reload();
}