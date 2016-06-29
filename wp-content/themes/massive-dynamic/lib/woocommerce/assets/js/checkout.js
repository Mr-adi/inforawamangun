var $=jQuery;

$(document).ready(function(){
    $('main > .content').wrap('<div class="container"></div>');
    $('.form-row').each(function(){
        var $this = $(this),
            $label = $this.find('label'),
            placeholder =$label.html();
        if (placeholder != undefined){
            $this.find('.input-text').attr('placeholder',placeholder.replace(/(<([^>]+)>)/ig,""));
            setTimeout(function(){$this.find('#select2-chosen-2').html(placeholder.replace(/(<([^>]+)>)/ig,""));},1);
        }
    });
    $('<div class="payment-method"><h3>PAYMENT METHOD</h3></div>').insertBefore('.woocommerce-checkout-payment');
});