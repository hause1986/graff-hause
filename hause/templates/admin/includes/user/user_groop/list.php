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
<div class='h1 fild'>Список групп</div>
<div class='fild'>	
	<div class="butt min-butt">
		<a href="<?=$arLINK['USERS_GROOP_ADD']?>">Добавить группу</a>
	</div>
</div>
<?$APPLICATION->IncludeComponent(
	"main_list:compGROOP:temp",
	array(
		'FIELD' => array(
			array(
				'CODE'	=>	'ID',
				'NAME'	=>	'ID',
			),		
			array(
				'CODE'	=>	'NAME',
				'NAME'	=>	'Название',
			),
			array(
				'CODE'	=>	'DESCRIPT_TEXT',
				'NAME'	=>	'Описание',
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
		'EDIT_ELM'	=>	$arLINK['USERS_GROOP_EDIT'],
		'DEL_ELM'	=>	$arLINK['USERS_GROOP_DEL'],	
	)
);?>