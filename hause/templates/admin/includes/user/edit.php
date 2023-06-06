<?global $arLINK;?>
<?$ID_USER = intval( $_GET['id_user'] );?>
<?$APPLICATION->IncludeComponent(
	"bread_crumb:comp:temp",
	array(
		'ITEMS' => array(
			array(
				'VALUE'	=>	'Меню',
				'LINK'	=>	$arLINK['MAIN'],
			),
			array(
				'VALUE'	=>	'список пользователей',
				'LINK'	=>	$arLINK['USER_LIST'],
			),
		),
	)
);?>
<div class='h1 fild'>Редактировать пользователя</div>
<?$APPLICATION->IncludeComponent(
	"main_edit:compUSER:temp",
	array(
		'FORM_NAME'		=>	'USER_EDIT',
		'REDIRECT_URL'	=>	$arLINK['USER_EDIT'],
		'ID_USER'		=>	$ID_USER,
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	str_replace(
				'#ID#',
				$ID_USER,
				$arLINK['USER_EDIT']
			),
		),
		'FIELD' => array(
			array(
				'CODE'		=>	'FORM_NAME',
				'VALUE'		=>	'USER_EDIT',
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
			),
			array(
				'CODE'		=>	'ID_GROOP',
				'NAME'		=>	'Группы',
				'MULTIPLE'	=>	'Y',
				'TYPE'		=>	'L',
				'REQUIRED'	=>	'Y',				
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
				)				
			),			
			array(
				'CODE'	=>	'SORT',
				'NAME'	=>	'Сортировка',				
				'TYPE'	=>	'I',
			)					
		),
	)
);?>