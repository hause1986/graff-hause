<?
$arPar = array(
	"STEP"		=>	50,
	"URL"		=>	$SITE . "/includes/setting/ajax.php",
);
?>
<script>
var arPar = {
	'url' : '<?=$arPar['URL']?>',
	'step' : '<?=$arPar['STEP']?>',
}
function set_data_ajax( data ){
	$.ajax({
		url: arPar.url,
		type: 'POST',
		data: data,
		success: function ( result ) {
			result = JSON.parse( result);
			if(result.STATUS == 'END'){
				$.each(result.RES, function(){
					text =  this;
					$('#res').append("<div>" + text + "</div>");
				})
				$('#res').append("<div>Загрузка завершена!</div>");
			}else{	
				search = []
				searchEl = $('.search_ajax')
				$.each( searchEl, function(){
					el = $( this ).val()
					if( el.length ){
						search.push( el )
					}
				})			
				data_load = {
					'STEP'		: result.STEP,
					'STATUS'	: result.STATUS,
					'SEEK'		: result.SEEK,					
					'MAX'		: result.MAX,
					'SEARCH'	: search						
				}
				$.each(result.RES, function(){
					text =  this;
					$('#res').append("<div>" + text + "</div>");
				})
				set_data_ajax( data_load );
			}
			$('#progres_bar #pr_line').css({
				'width' : result.PROSESS + '%'
			})
			$('#progres_bar #prosent').html(result.PROSESS + '%')
		}
	});
}
$(document).ready(function(){
	$('#start_ajax').click(function( e ){		
		e.preventDefault();
		status = 'START';
		type_fil = []
		type_fil = $('.type_ajax').val()
		data = {
			'STEP'		: arPar.step,
			'STATUS'	: status,			
			'SEEK'		: '0',
			'TYPE_FIL'	: type_fil,
		}
		$('#res').html('');
		set_data_ajax( data );
	})
});
</script>
<?global $arLINK;?>
<?$APPLICATION->IncludeComponent(
	"bread_crumb:comp:temp",
	array(
		'ITEMS' => array(
			array(
				'VALUE'	=>	'Меню',
				'LINK'	=>	$arLINK['MAIN'],
			),
		),
	)
);?>
<div class='h1 fild'>Поиск по файлам</div>
<div class="fild row">
	<div class="col-md">
		<div id="progres_bar">
			<div id="pr_line" style="width:0%"></div>
			<div id="prosent">0%</div>
		</div>
	</div>
</div>

<div class="fild">Типы файлов где будем искать</div>
<div class="fild">
	<select class='type_ajax' multiple>
		<option value='php' selected>PHP</option>
		<option value='js'>JS</option>
		<option value='css'>CSS</option>
		<option value='txt'>TXT</option>	
	</select>	
</div>

<div class="fild">Поисковые фразы</div>
<div data-multiple>	
	<div data-multiple-clone class="fild">
		<input type="text" class="text search_ajax" autocomplete="off" name="TEXT[]" value="">
	</div>	
	<div class="fild">
		<div class="butt min-butt">
			<a href="#" data-multiple-sudmit="">Ещё</a>
		</div>
	</div>	
</div>

<div class="fild">
	<div class="butt min-butt">
		<a href="#" id="start_ajax">Начать поиск</a>
	</div>
</div>

<div class="fild">
	<div id="res"></div>
</div>