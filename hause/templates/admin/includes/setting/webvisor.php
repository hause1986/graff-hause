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
<div class='h1 fild'>Посещаемость сайта</div>
<?$APPLICATION->IncludeComponent(
	"webvisor:comp:temp",
	array(		
		'LIST'	=> array(
			array(			
				'NAME'	=>	'Сейчас на сайте',
				'INTERVAL' => array(
					'MIN'	=>	0,
					'MAX'	=>	1 * 60 * 10,
				),				
			),
			array(
				'NAME'	=>	'За 24 часа',
				'INTERVAL' => array(
					'MIN'	=>	0,
					'MAX'	=>	1 * 60 * 60 * 24,
				),				
			),
			array(
				'NAME'	=>	'За 7 дней',		
				'INTERVAL' => array(
					'MIN'	=>	0,
					'MAX'	=>	1 * 60 * 60 * 24 * 7,
				),				
			),
			array(
				'NAME'	=>	'За 30 дней',
				'INTERVAL' => array(
					'MIN'	=>	0,
					'MAX'	=>	1 * 60 * 60 * 24 * 30,
				),				
			),
		),	
	)
);?>