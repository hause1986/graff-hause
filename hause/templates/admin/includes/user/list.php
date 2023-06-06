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
<div class='h1 fild'>Список пользователей</div>
<div class='fild'>	
	<div class="butt min-butt">
		<a href="<?=$arLINK['USER_ADD']?>">Добавить пользователя</a>
	</div>
</div>
<?$APPLICATION->IncludeComponent(
	"main_list:compUSER:temp",
	array(
		'FIELD' => array(
			array(
				'CODE'	=>	'ID',
				'NAME'	=>	'ID',				
			),	
			array(
				'CODE'	=>	'NAME',
				'NAME'	=>	'Имя',				
			),
			array(
				'CODE'	=>	'LOGIN',
				'NAME'	=>	'Логин',				
			),
			array(
				'CODE'	=>	'EMAIL',
				'NAME'	=>	'Email',				
			),
			array(
				'CODE'	=>	'ID_GROOP',
				'NAME'	=>	'Группы',
				'TYPE'	=>	'L',
			),	
			array(
				'CODE'	=>	'SORT',
				'NAME'	=>	'Сорт',				
			),
			array(
				'CODE'	=>	'CREATE_DATE',
				'NAME'	=>	'Дата создания',
				'TYPE'	=>	'D',
			),
			array(
				'CODE'	=>	'UP_DATE',
				'NAME'	=>	'Дата изменения',
				'TYPE'	=>	'D',
			),
		),
		'EDIT_ELM'	=>	$arLINK['USER_EDIT'],
		'DEL_ELM'	=>	$arLINK['USER_DEL'],	
	)
);?>