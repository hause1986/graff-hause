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
<div class='h1 fild'>Список ИнфоБлоков</div>
<div class='fild'>	
	<div class="butt min-butt">
		<a href="<?=$arLINK['IBLOCK_ADD']?>">Добавить ИнфоБлок</a>
	</div>
</div>
<?$APPLICATION->IncludeComponent(
	"main_list:compIBLOCK:tempIBLOCK",
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
				'CODE'	=>	'CODE',
				'NAME'	=>	'Символьный код',					
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
				'CODE'	=>	'ACTIVE',
				'NAME'	=>	'Актив',				
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
		'PROP_MOD'	=>	$arLINK['PROP_MOD'],
		'LIST_ELM'	=>	$arLINK['ELMENT_LIST'],
		'EDIT_ELM'	=>	$arLINK['IBLOCK_EDIT'],
		'DEL_ELM'	=>	$arLINK['IBLOCK_DEL'],		
	)
);?>