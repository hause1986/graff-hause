<?global $arLINK;?>
<?
$ID = intval( $_GET['id'] );
$arRes = CProp::GetPropByID( $ID );
$PROP_MOD_EDIT = str_replace(
	'#ID#',
	$ID,
	$arLINK['PROP_MOD_EDIT']
);

$PROP_MOD_LIST = str_replace(
	'#ID_IBLOCK#',
	$arRes['ID_IBLOCK'],
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
<div class='h1 fild'>Редактировать Доп. свойство ИнфоБлока</div>
<?$APPLICATION->IncludeComponent(
	"prop_modul_edit:comp:temp",
	array(
		'FORM_NAME'		=>	'PROP_MOD_EDIT',
		'ID'			=>	$ID,
		'REDIRECT_URL'	=>	$PROP_MOD_EDIT,
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	$PROP_MOD_EDIT,
		),
	)
);?>