<?global $arLINK;?>
<?$ID_IBLOCK = intval( $_GET['id_iblock'] );?>
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
<div class='h1 fild'>Редактировать ИнфоБлок</div>
<?$APPLICATION->IncludeComponent(
	"main_edit:compIBLOCK:temp",
	array(
		'FORM_NAME'		=>	'IBLOCK_EDIT',
		'REDIRECT_URL'	=>	$arLINK['IBLOCK_EDIT'],
		'ID_IBLOCK'		=>	$ID_IBLOCK,
		'SAVE_ELM'		=>	array(
			'NAME'			=>	'Сохранить',
			'LINK'			=>	str_replace(
				'#ID#',
				$ID_IBLOCK,
				$arLINK['IBLOCK_EDIT']
			),
		),
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
	)
);?>
	