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
				'VALUE'	=>	'Список ИнфоБлоков',
				'LINK'	=>	$arLINK['IBLOCK_LIST'],
			),
		),
	)
);?>
<div class='h1 fild'>Создать ИнфоБлок</div>
<?$APPLICATION->IncludeComponent(
	"main_add:compIBLOCK:temp",
	array(
		'FIELD' => array(
			array(
				'CODE'		=>	'NAME',
				'NAME'		=>	'Название',
				'TYPE'		=>	'S',
				'REQUIRED'	=>	'Y',
			),
			array(
				'CODE'		=>	'CODE',
				'NAME'		=>	'Символьный код',
				'TYPE'		=>	'S',				
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
		'FORM_NAME'		=>	'IBLOCK_ADD',
		'REDIRECT_URL'	=>	$arLINK['IBLOCK_LIST'],
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	$arLINK['IBLOCK_ADD'],
		),		
	)
);?>