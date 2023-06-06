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
				'VALUE'	=>	'Списол Инфоблоков',
				'LINK'	=>	$arLINK['IBLOCK_LIST'],
			),			
		),
	)
);?>
<?

$PROP_MOD_ADD = str_replace(
	'#ID_IBLOCK#',
	$ID_IBLOCK,
	$arLINK['PROP_MOD_ADD']
); 
?>

<div class='h1 fild'>Дополнительные свойства ИнфоБлока</div>
<div class='fild'>	
	<div class="butt min-butt">
		<a href="<?=$PROP_MOD_ADD?>">Добавить поле</a>
	</div>
</div>
<?$APPLICATION->IncludeComponent(
	"prop_modul:comp:temp",
	array(		
		'ID_IBLOCK'	=>	$ID_IBLOCK,
		'EDIT_ELM'	=>	$arLINK['PROP_MOD_EDIT'],
		'DEL_ELM'	=>	$arLINK['PROP_MOD_DEL'],
	)
);?>