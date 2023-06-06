var deleteImg = function(){
	var el = null
	var rem = $("#news-list .listview li").length - 1
	if( rem > 5000 ){
		el = $("#news-list .listview li:eq(" + rem + ")")
		el.remove()
	}
	setTimeout( deleteImg,  10 * 1000 )	
}
getNewsList = function(){
	sendajax.send({
		'APP'		:	'VK',
		'FORM_NAME'	:	'GET_WALL',
	}, function( object ){
		if( object.STATUS != 'ERR' ){
			for( key in object.VALUE ){
				item = object.VALUE[key]				
				str = ''
				for( k in item.ITEMS ){
					v = item.ITEMS[k]
					str += '<li data-id="' + item.ID + '" data-group-id="' + item.GROUP.ID + '" >'
						str += '<div class="group dis-flex">'
							str += '<div class="group-avatar" style="background-image:url(' + item.GROUP.IMG + ')"></div>'
							str += '<div class="group-name"><a target="_blank" href="' + item.LINK + '">' + item.GROUP.NAME + '</div>'							
						str += '</div>'
						str += '<img src="' + v.LINK.MAX + '" class="dis-non">'
						str += '<a target="_blank" class="gallery" data-fancybox="gallery" data-caption="' + item.TEXT.MAX + '" href="' + v.LINK.MAX + '">'
							str += '<div class="avatar" style="background-image:url(' + v.LINK.MIN + ')"></div>'
						str += '</a>'
					str += '</li>'
				}
				$("#news-list .listview").prepend( str )
			}
		}		
		setTimeout( getNewsList,  60 * 1000 * 5 )
	},function( jqXHR, textStatus, errorThrown  ){
		if( textStatus == 'timeout' ){		
			setTimeout( getNewsList,  60 * 1000 * 5 )
		}
	})	
}
var sendajax = null
$(document).ready(function(){
	sendajax = new SendAjax()
	sendajax.url = '/'
	
	$('.gallery').fancybox()
	getNewsList()
	deleteImg()
})