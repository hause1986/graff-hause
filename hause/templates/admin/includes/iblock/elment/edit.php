<?global $arLINK;?>
<?
$ID_ELMENT = intval($_GET['id_elment']);
$elm = new CIBlockElement();
$arElement = $elm->GetByID( $ID_ELMENT );
$ID_IBLOCK = intval( $arElement['ID_IBLOCK'] );

$urlELMENT_LIST = str_replace(
	'#ID#',
	$ID_IBLOCK,
	$arLINK['ELMENT_LIST']
);
$urlELMENT_EDIT = str_replace(
	'#ID#',
	$ID_ELMENT,
	$arLINK['ELMENT_EDIT']
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
<div class='h1 fild'>Редактировать Элемент</div>

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

<?$APPLICATION->IncludeComponent(
	"main_edit:compELMENT:temp",
	array(
		'FORM_NAME'		=>	'ELMENT_EDIT',
		'REDIRECT_URL'	=>	$urlELMENT_EDIT,
		'ID_IBLOCK'		=>	$ID_IBLOCK,
		'ID_ELMENT'		=>	$ID_ELMENT,		
		'FILE_DOWNLOAD'	=>	$arLINK['FILE_DOWNLOAD'],
		'FILE_DELETE'	=>	$arLINK['FILE_DELETE'],		
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	$urlELMENT_EDIT,
		),
	)
);?>