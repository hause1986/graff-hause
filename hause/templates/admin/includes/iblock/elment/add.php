<?global $arLINK;?>
<?
$ID_IBLOCK = intval( $_GET['id_iblock'] );
$urlELMENT_LIST = str_replace(
	'#ID#',
	$ID_IBLOCK,
	$arLINK['ELMENT_LIST']
);
$urlELMENT_ADD = str_replace(
	'#ID#',
	$ID_IBLOCK,
	$arLINK['ELMENT_ADD']
);
?>
<?$APPLICATION->IncludeComponent(
	"bread_crumb:comp:temp",
	array(
		'ITEMS' => array(
			array(
				'VALUE'	=>	'Меню',
				'LINK'	=>	$arLINK['MAIN'],
			),
			array(
				'VALUE'	=>	'Список Элементов',
				'LINK'	=>	$urlELMENT_LIST,
			),
		),
	)
);?>
<script>
$(document).ready(function(){	
    $('.left_blok').contentAdmin();
	$('[data-href]').linkHref();
	$('.form').sendForm();
	$('[data-trans]').translite();
	$('[data-multiple]').multiple();
	$('.file-upload').chFile();
});
</script>
<div class='h1 fild'>Создать Элемент</div>
<?$APPLICATION->IncludeComponent(
	"main_add:compELMENT:temp",
	array(
		'FORM_NAME'		=>	'ELMENT_ADD',
		'ID_IBLOCK'		=>	$ID_IBLOCK,
		'REDIRECT_URL'	=>	$urlELMENT_LIST,
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	$urlELMENT_ADD,
		),		
	)
);?>