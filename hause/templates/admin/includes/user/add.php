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
				'VALUE'	=>	'Список пользователей',
				'LINK'	=>	$arLINK['USER_LIST'],
			),
		),
	)
);?>
<div class='h1 fild'>Добавить пользователя</div>
<?$APPLICATION->IncludeComponent(
	"main_add:compUSER:temp",
	array(
		'FIELD'	=>	array(
			array(
				'CODE'		=>	'FORM_NAME',
				'VALUE'		=>	'USER_ADD',
				'TYPE'		=>	'H',
			),	
			array(
				'CODE'		=>	'NAME',
				'NAME'		=>	'Имя',
				'TYPE'		=>	'S',
				'REQUIRED'	=>	'Y',
			),
			array(
				'CODE'		=>	'LOGIN',
				'NAME'		=>	'Логин',
				'TYPE'		=>	'S',
				'REQUIRED'	=>	'Y',
			),
			array(
				'CODE'		=>	'EMAIL',
				'NAME'		=>	'Email',
				'TYPE'		=>	'S',
			),
			array(
				'CODE'		=>	'PASS',
				'NAME'		=>	'Пароль',
				'TYPE'		=>	'P',
				'REQUIRED'	=>	'Y',
			),		
			array(
				'CODE'		=>	'NAME_GROOP',
				'NAME'		=>	'Группы',
				'MULTIPLE'	=>	'Y',
				'TYPE'		=>	'L',
				'REQUIRED'	=>	'Y',				
			),
			array(
				'CODE'	=>	'SORT',
				'NAME'	=>	'Сортировка',
				'VALUE'	=>	'500',
				'TYPE'	=>	'I',
			),
			array(
				'CODE'		=>	'ACTIVE',
				'NAME'		=>	'Активен',
				'TYPE'		=>	'L',
				'FLAG'		=>	'Y',
				'MULTIPLE'	=>	'Y',
				'ITEMS'		=>	array(
					array(
						'ID'	=>	'Y',
						'NAME'	=>	'Да',
					),
				),
				'VALUE'	=>	'Y',
				
			),	
		),
		'FORM_NAME'		=>	'USER_ADD',
		'REDIRECT_URL'	=>	$arLINK['USER_LIST'],
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	$arLINK['USER_ADD'],
		),		
	)
);?>