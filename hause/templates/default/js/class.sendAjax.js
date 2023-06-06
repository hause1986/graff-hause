var SendAjax = function(){
	this.url = null
	this.arrLog = null
}

SendAjax.prototype.url = function( url ){
	if( url != '' ){
		url = window.location.href
	}
	this.url = url
}

SendAjax.prototype.send = function( aJdata, aJsuccess, aJerror ){
	var sendAjaxObj = this
	var success = []
	var error = []
	
	success.push( function( respons ){
		Data = new Date()
		sendAjaxObj.arrLog = {
			'time'		: Data.getHours() + ' : ' + Data.getMinutes() + ' : ' + Data.getSeconds(),
			'aJdata'	: aJdata,
			'respons'	: respons,
		}
	} )
	error.push( function( jqXHR, textStatus, errorThrown ){
		console.log( '[ ' + textStatus + ' ] ' + errorThrown )
	} )	
	if( aJerror != null ){
		error.push( aJerror )
	}	
	if( aJsuccess != null ){
		success.push( aJsuccess )
	}	
	$.ajax({
		url		:	this.url,
		data	:	aJdata,
		timeout	:	60 * 1000,
		error	:	error,
		success	:	success,
		type	:	'POST',
		dataType:	'json',
	} )
}
SendAjax.prototype.setLog = function(){
	return this.arrLog
}