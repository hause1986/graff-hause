(function($) {
    $.fn.contentAdmin = function() {        
        var main = function(){
            var main_object = $(this);
			var main_ul = main_object.find('.vertikal_list_tree')
			
			main_object.find('.main_li').click(function(e){
				elm_li = $(this)
				elm_name = $(e.target)				
				// если нажан на название а не на все что в блоке
				if(
						elm_name.parents('.is_pr_y').length
					||	elm_name.hasClass('is_pr_y')
				){
					if( !elm_li.hasClass("action") ){
						main_object
							.find(".main_li.action")
							.removeClass("action");		
						
						elm_li.addClass("action");
					}else{
						main_object
							.find(".main_li.action")
							.removeClass("action");					
					}
				}
			});	
        };
        return this.each( main );
    };
})(jQuery);

(function($) {
    $.fn.linkHref = function() {
        var main = function(){
            var main_object = $(this);
			main_object.click(function(e){
				e.preventDefault();
				elm = $(this)
				url = '';
				url = elm.attr('data-href')
				if( url.length ){
					location.href = url;
				}
			})
        };
        return this.each( main );
    };
})(jQuery);

(function($) {
    $.fn.sendForm = function() {
        var main = function(){
            var main_object = $(this);
			
			main_object.find('[data-send]').click(function(e){
				e.preventDefault();				
				elm = $(this)				
				url = elm.attr('href')
				main_object.attr( 'action' , url );
				flag = true;
				field = main_object.find('[data-req]')
				
				if( field.length ){
					field.removeClass('err')
					$.each( field, function(){
						elm = $(this)
						if( elm.val() == '' ){
							elm.addClass('err')
							flag = false;
						}
					} )
				}				
				if( flag ){					
					main_object.submit();
				}
			})
        };
        return this.each( main );
    };
})(jQuery);

(function($) {
    $.fn.translite = function() {
        var main = function(){
            var main_object = $(this);
			
			main_object.find('[data-trans-send]').click(function(e){
				e.preventDefault();
				fieldCode = main_object.find('[data-trans-inp]')
				nameCode = fieldCode.attr('data-trans-inp');
				str = $('[name=' + nameCode + ']').val();
				
				if( str.length ){
					data = {
						'FORM_NAME' : 'TRANSLITE',
						'STR'		: str
					}
					$.ajax({
						url: '/admin/ajax.php',
						type: 'POST',
						data: data,
						dataType: 'json',
						success: function (result) {
							if(result.RES == 'OK'){
								fieldCode.val( result.STR )
							}
						}
					})
				}
			})
        };
        return this.each( main );
    };
})(jQuery);
(function($) {
    $.fn.multiple = function() {
        var main = function(){
            var main_object = $(this);			
			main_object.find('[data-multiple-sudmit]').click(function(e){
				e.preventDefault();
				field = main_object.find('[data-multiple-clone]')
				cloneF = field.clone()[0]
				$(cloneF)
					.removeAttr('data-multiple-clone')					
				main_object.prepend( cloneF )
			})
        };
        return this.each( main );
    };
})(jQuery);

(function($) {
    $.fn.chFile = function() {
        var main = function(){
            var main_object = $(this);
			main_object.change(function(){
				elm = $(this)
				i = elm.find('input').get(0).files.length
				if( i ){					
					nF = elm.find('input').get(0).files[0].name
					elm.find('span').html( nF )									
				}
			})
        };
        return this.each( main );
    };
})(jQuery);
$(document).ready(function(){	
    $('.left_blok').contentAdmin();
	$('[data-href]').linkHref();
	$('.form').sendForm();
	$('[data-trans]').translite();
	$('[data-multiple]').multiple();
	$('.file-upload').chFile();
	$('.htmlViwer').htmlViwer();
});