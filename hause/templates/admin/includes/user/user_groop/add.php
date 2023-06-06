<?global $arLINK;?>
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
<div class='h1 fild'>Добавить группу пользователей</div>
<?$APPLICATION->IncludeComponent(
	"main_add:compGROOP:temp",
	array(
		'FIELD' => array(
			array(
				'CODE'		=>	'NAME',
				'NAME'		=>	'Название',
				'TYPE'		=>	'S',
				'REQUIRED'	=>	'Y',
			),
			array(
				'CODE'		=>	'DESCRIPT_TEXT',
				'NAME'		=>	'Описание',
				'TYPE'		=>	'T',				
			),				
			array(
				'CODE'	=>	'SORT',
				'NAME'	=>	'Сортировка',
				'VALUE'	=>	'500',
				'TYPE'	=>	'I',
			),		
		),
		'FORM_NAME'		=>	'USERS_GROOP_ADD',
		'REDIRECT_URL'	=>	$arLINK['USERS_GROOP_LIST'],
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	$arLINK['USERS_GROOP_ADD'],
		),		
	)
);?>