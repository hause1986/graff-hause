<?global $arLINK;?>
<?
$ID_IBLOCK = intval( $_GET['id_iblock'] );
$PROP_MOD_ADD = str_replace(
	'#ID_IBLOCK#',
	$ID_IBLOCK,
	$arLINK['PROP_MOD_ADD']
);
$PROP_MOD_LIST = str_replace(
	'#ID_IBLOCK#',
	$ID_IBLOCK,
	$arLINK['PROP_MOD']
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
				'VALUE'	=>	'Список Доп.свойств ИнфоБлока',
				'LINK'	=>	$PROP_MOD_LIST,
			),
		),
	)
);?>
<div class='h1 fild'>Создать Доп. свойство ИнфоБлока</div>
<?$APPLICATION->IncludeComponent(
	"prop_modul_add:comp:temp",
	array(		
		'FORM_NAME'		=>	'PROP_MOD_ADD',		
		'ID_IBLOCK'		=>	$ID_IBLOCK,
		'REDIRECT_URL'	=>	$PROP_MOD_LIST,
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	$PROP_MOD_ADD,
		),		
	)
);?>