<?global $arLINK;?>

<?
$ID_IBLOCK = intval( $_GET['id_iblock'] );
$urlELMENT_ADD = str_replace(
	'#ID#',
	$ID_IBLOCK,
	$arLINK['ELMENT_ADD']
);
?>
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
<div class='h1 fild'>Список Элементов</div>
<div class='fild'>	
	<div class="butt min-butt">
		<a href="<?=$urlELMENT_ADD?>">Добавить элемент</a>
	</div>
</div>
<?$APPLICATION->IncludeComponent(
	"main_list:compELMENT:temp",
	array(	
		'ID_IBLOCK'	=>	$ID_IBLOCK,
		'EDIT_ELM'	=>	$arLINK['ELMENT_EDIT'],
		'DEL_ELM'	=>	$arLINK['ELMENT_DEL'],
	)
);?>