function pixflow_makeGradient(id, target, color1, color2, orientation){
    'use strict';
    var firstColorPosition = '0%',
        secondColorPosition = '100%';

    // Get colcor1
    if((color1 == '') || (typeof color1 == 'undefined')){
        var color1 = $('#input_' + id + '_color1').val();
    }

    // Get colcor2
    if((color2 == '') || (typeof color2 == 'undefined')){
        var color2 = $('#input_' + id + '_color2').val();
    }

    // Get orientation
    if((orientation == '') || (typeof orientation == 'undefined')){
        var orientation = $('#input_'+ id + '_orientation').val();
    }

    // Generate css
    var bg_css = [];
    bg_css[0] = color1;
    if(orientation == 'horizontal'){
        bg_css[1] = "-moz-linear-gradient(left, " + color1 + " " + firstColorPosition + ", " + color2 + " " + secondColorPosition + ")";
        bg_css[2] = "-webkit-gradient(left top, right top, color-stop("+firstColorPosition+", "+color1+"), color-stop("+secondColorPosition+", "+color2+"))";
        bg_css[3] = "-webkit-linear-gradient(left, "+color1+" "+firstColorPosition+", "+color2+" "+secondColorPosition+")";
        bg_css[4] = "-o-linear-gradient(left, "+color1+" "+firstColorPosition+", "+color2+" "+secondColorPosition+")";
        bg_css[5] = "-ms-linear-gradient(left, "+color1+" "+firstColorPosition+", "+color2+" "+secondColorPosition+")";
        bg_css[6] = "linear-gradient(to right, "+color1+" "+firstColorPosition+", "+color2+" "+secondColorPosition+")"
    }else if(orientation == 'vertical'){
        bg_css[1] = "-moz-linear-gradient(top, " + color1 + " " + firstColorPosition + ", " + color2 + " " + secondColorPosition + ")";
        bg_css[2] = "-webkit-gradient(left top, left bottom, color-stop("+firstColorPosition+", "+color1+"), color-stop("+secondColorPosition+", "+color2+"))";
        bg_css[3] = "-webkit-linear-gradient(top, "+color1+" "+firstColorPosition+", "+color2+" "+secondColorPosition+")";
        bg_css[4] = "-o-linear-gradient(top, "+color1+" "+firstColorPosition+", "+color2+" "+secondColorPosition+")";
        bg_css[5] = "-ms-linear-gradient(top, "+color1+" "+firstColorPosition+", "+color2+" "+secondColorPosition+")";
        bg_css[6] = "linear-gradient(to bottom, "+color1+" "+firstColorPosition+", "+color2+" "+secondColorPosition+")"
    }

    // Update target
    var $contents = pixflow_livePreviewObj();

    $('#gradient_' + id + '_gradient').css('background', 'none' );
    bg_css.forEach(function(entry) {
        $('#gradient_' + id + '_gradient').css('background', entry );
        $contents.$(target).css('background', entry );
    });
}
function pixflow_generateGradientBackground(color1, color2, orientation, colorSecond1, colorSecond2, orientationSecond){
    'use strict';
    var  bg_css= [];
    bg_css[0] = color1;
    if (orientation == "horizontal") {
        bg_css[1]= "-moz-linear-gradient(left," + color1 + " 0%," + color2 + "33%," + colorSecond1 + " 77%," + colorSecond2 + " 100%)";
        bg_css[2]= "-webkit-gradient(linear, left top, right top, color-stop(0%," + color1 + "), color-stop(33%," + color2 + "),color-stop(77%," + colorSecond1 + "),color-stop(100%," + colorSecond2 + "))";
        bg_css[3]= "-webkit-linear-gradient(left," + color1 + " 0%," + color2 + "33%," + colorSecond1 + " 77%," + colorSecond2 + " 100%)";
        bg_css[4]= "-o-linear-gradient(left, " + color1 + " 0%," + color2 + "33%," + colorSecond1 + " 77%," + colorSecond2 + " 100%)";
        bg_css[5]= "-ms-linear-gradient(left,  " + color1 + " 0%," + color2 + "33%," + colorSecond1 + " 77%," + colorSecond2 + " 100%)";
        bg_css[6]= "linear-gradient(to right, " + color1 + " 0%," + color2 + "33%," + colorSecond1 + " 77%," + colorSecond2 + " 100%)";
        bg_css[7]= "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color1 + "', endColorstr='" + color2 + "', GradientType=0)";

    } else {
        bg_css[1]= "-moz-linear-gradient(top," + color1 + " 0%," + color2 + "33%," + colorSecond1 + " 77%," + colorSecond2 + " 100%)";
        bg_css[2]= "-webkit-gradient(linear, left top, left bottom, color-stop(0%," + color1 + "), color-stop(33%," + color2 + "),color-stop(77%," + colorSecond1 + "),color-stop(100%," + colorSecond2 + "))";
        bg_css[3]= "-webkit-linear-gradient(top,  " + color1 + " 0%," + color2 + " 33%," + colorSecond1 + " 77%," + colorSecond2 + " 100%)";
        bg_css[4]= "-o-linear-gradient(top,  " + color1 + " 0%," + color2 + " 33%," + colorSecond1 + " 77%," + colorSecond2 + " 100%)";
        bg_css[5]= "-ms-linear-gradient(top,  " + color1 + " 0%," + color2 + " 33%," + colorSecond1 + " 77%," + colorSecond2 + " 100%)";
        bg_css[6]= "linear-gradient(to bottom, " + color1 + " 0%," + color2 + " 33%," + colorSecond1 + " 77%," + colorSecond2 + " 100%)";
        bg_css[7]= "progid:DXImageTransform.Microsoft.gradient(startColorstr='" + color1 + "', endColorstr='" + color2 + "', GradientType=0)";
    }
    return bg_css;

}
