(function($) {
    $.fn.capcha = function() {
        var main = function(){
            var main_object = $(this);			
			main_object.find('[data-captcha-update]').click(function(e){
				e.preventDefault();
				fieldCode = main_object.find('[data-captcha-sid]')				
				data = {
					'FORM_NAME' : 'CAPCHA_CODE',
				}
				$.ajax({
					url: '/admin/ajax.php',
					type: 'POST',
					data: data,
					dataType: 'json',
					success: function (result) {
						if(result.RES == 'OK'){
							fieldCode.find('[name=captcha_sid]').val( result.CODE )
							fieldCode.css('background-image', 'url(/hause/tools/captcha.php?captcha_sid=' + result.CODE + ')')
						}
					}
				})				
			})
        };
        return this.each( main );
    };
})(jQuery);
$(document).ready(function(){
	$('[data-captcha]').capcha();
});