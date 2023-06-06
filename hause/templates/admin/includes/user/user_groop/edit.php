<?global $arLINK;?>
<?$ID_GROOP = intval( $_GET['id_groop'] );?>
<?$APPLICATION->IncludeComponent(
	"bread_crumb:comp:temp",
	array(
		'ITEMS' => array(
			array(
				'VALUE'	=>	'Меню',
				'LINK'	=>	$arLINK['MAIN'],
			),
			array(
				'VALUE'	=>	'группы пользователей',
				'LINK'	=>	$arLINK['USERS_GROOP_LIST'],
			),
		),
	)
);?>
<div class='h1 fild'>Редактировать группу пользователей</div>
<?$APPLICATION->IncludeComponent(
	"main_edit:compGROOP:temp",
	array(
		'FORM_NAME'		=>	'USERS_GROOP_EDIT',
		'REDIRECT_URL'	=>	$arLINK['USERS_GROOP_EDIT'],
		'ID_GROOP'		=>	$ID_GROOP,
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	str_replace(
				'#ID#',
				$ID_GROOP,
				$arLINK['USERS_GROOP_EDIT']
			),
		),
		'FIELD' => array(
			array(
				'CODE'		=>	'FORM_NAME',
				'VALUE'		=>	'USERS_GROOP_EDIT',
				'TYPE'		=>	'H',
			),	
			array(
				'CODE'		=>	'NAME',
				'NAME'		=>	'Имя',
				'TYPE'		=>	'S',
				'REQUIRED'	=>	'Y',
			),
			array(
				'CODE'	=>	'DESCRIPT_TEXT',
				'NAME'	=>	'Описание',
				'TYPE'	=>	'T',
			),
			array(
				'CODE'	=>	'SORT',
				'NAME'	=>	'Сортировка',
				'VALUE'	=>	'500',
				'TYPE'	=>	'I',
			),					
		),
	)
);?>