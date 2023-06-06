<?global $arLINK;?>
<?$ID_PROP = intval( $_GET['id_prop_type'] );?>
<?$APPLICATION->IncludeComponent(
	"bread_crumb:comp:temp",
	array(
		'ITEMS' => array(
			array(
				'VALUE'	=>	'Меню',
				'LINK'	=>	$arLINK['MAIN'],
			),
			array(
				'VALUE'	=>	'Список Типов Доп.свойств',
				'LINK'	=>	$arLINK['PROP_LIST'],
			),
		),
	)
);?>
<div class='h1 fild'>Редактировать Тип Доп.свойства</div>
<?$APPLICATION->IncludeComponent(
	"main_edit:compPROP:temp",
	array(
		'FORM_NAME'		=>	'PROP_EDIT',
		'ID_PROP'		=>	$ID_PROP,
		'REDIRECT_URL'	=>	$arLINK['PROP_LIST'],
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	str_replace(
				'#ID#',
				$ID_PROP,
				$arLINK['PROP_EDIT']
			),
		),
	)
);?>