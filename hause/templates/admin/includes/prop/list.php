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
<div class='h1 fild'>Список типов дополнительных свойств</div>
<div class='fild'>	
	<div class="butt min-butt">
		<a href="<?=$arLINK['PROP_ADD']?>">Добавить тип</a>
	</div>
</div>
<?$APPLICATION->IncludeComponent(
	"main_list:compPROP:temp",
	array(		
		'EDIT_ELM'	=>	$arLINK['PROP_EDIT'],
		'DEL_ELM'	=>	$arLINK['PROP_DEL'],		
	)
);?>