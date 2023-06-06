(function($) {
    $.fn.htmlViwer = function( options ) {
		var options = $.extend({
			'CSS': {}
		}, options);		
        var main = function(){
            var main_object = $(this);
			var main_textarea = main_object.find( 'textarea' )
			var bodyD = ''	
			var bodyT = ''
			
			bottCode = function(){
				main_object
					.find( '.headD' )
					.append( '<div class="buttH code">&lt;/ &gt;</div>' )
				main_object
					.find( '.headD .code' )
					.click(function(){
						el = $( this )
						
						if( el.hasClass( 'active' ) ){
							text = bodyT.val()
							bodyD.html( text )
							main_textarea.val( text )
							
							el.removeClass( 'active' )
							bodyT
								.css( 'display', 'none' );
							bodyD
								.css( 'display', 'block' );
						}else{
							el.addClass( 'active' )
							bodyT
								.css( 'display', 'block' );
							bodyD
								.css( 'display', 'none' );
						}
				})
			}			
			bottStyle = function(){
				if( options.CSS.length ){
					main_object
						.find( '.headD' )
						.append( '<select class="buttH style"><option value="-">-</option></select>' )
						.change(function(){
							el = $( this )
							opt = $( 'option:selected', this );
							if(	opt.hasClass != 'active' ){
								opt.addClass( 'active' )
								$('head link[data-htmlViwer]').remove(  )
								if( opt.val() != '-' ){		
									$('head').append( '<link rel="stylesheet" data-htmlViwer href="' + opt.val() + '" />' )
								}
							}
						})
					index = 1
					for( key in options.CSS ){
						val = options.CSS[key]
						name = 'Стиль№ ' + index
						main_object
							.find( '.headD .buttH.style' )
							.append( '<option value="' + val + '">' + name + '</option>' )
						index++
					}
				}				
			}
			bottDeletTag = function(){
				main_object
					.find( '.headD' )
					.append( '<div class="buttH start">&lt;/DEL &gt;</div>' )	
				main_object
					.find( '.headD .start' )
					.click(function(){
						el = $( this )
						text = bodyT.val()
						text = text.replace(/<\/?[^>]+>/g,'')
						console.log( text )
						bodyT.val( text )
						bodyD.html( text )
						main_textarea.val( text )
					})
			}			
			setBott = function(){
				bottCode()
				bottStyle()
				bottDeletTag()
			}
			init = function(){
				stilet = '';
				stilet += '<div class="mainlViver">';
					stilet += '<div class="headD"></div>';
					//stilet += '<div class="bodyD" contenteditable ></div>';
					stilet += '<div class="bodyD" ></div>';
					stilet += '<textarea class="bodyT"></textarea>';
				stilet += '</div>';
				
				main_object
					.find( 'textarea' )
					.css( 'display', 'none' );
					
				main_object
					.append( stilet )
	
				bodyD = main_object
					.find( '.mainlViver .bodyD' )
					.html( main_textarea.val() )
					
				bodyT = main_object
					.find( '.mainlViver .bodyT' )
					.html( main_textarea.val() )
					setBott()
			}
			init()
        };
        return this.each( main );
    };
})(jQuery);