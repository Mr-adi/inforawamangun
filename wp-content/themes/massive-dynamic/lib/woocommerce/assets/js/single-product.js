var $=jQuery;
$(document).ready(function(){
    if(!$('.thumbnails .zoom').length)
        return;
    $('.attachment-shop_single').attr('srcset','');
    var featureImage = $('.attachment-shop_single').clone(),
        link = $('<a href="'+ featureImage.attr('src') +'" class="zoom" title="" data-rel="prettyPhoto[product-gallery]">');
    link.prepend(featureImage);
    featureImage.removeClass('attachment-shop_single');
    $('.thumbnails').append(link);

    $('.thumbnails .zoom').unbind('click');
    $('.thumbnails .zoom').each(function(){
        var $this = $(this);
        $('<img/>').attr('src', $this.attr('href'));
        $this.css({'background':"url(" + $this.find('img').attr('src') + ") center no-repeat"});
        $this.click(function(e){
            $('.attachment-shop_single').stop().animate({opacity:0},300,'swing',function(){
                $(this).attr('src',$this.attr('href')).stop().animate({opacity:1},300);
                $(this).parent().attr('href',$this.attr('href'));
            });
            setTimeout(function(){
                $('.layout-container').siblings('div').each(function(){
                    if( $(this).height() > $('.layout-container').height() ){
                        $(this).css('height',$('.layout-container').height());
                    }
                });
            },1000);

            return false;
        })
    })
});