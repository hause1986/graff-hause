<?require_once( $_SERVER["DOCUMENT_ROOT"] . "/hause/core/init.php" );

$arRule[] = array(
	'RULE'	=>	'#^/admin/#',
	'PAGE'	=>	'/admin/index.php',
);
$arRule[] = array(
	'RULE'	=>	'#^/proecty/#',
	'PAGE'	=>	'/proecty/index.php',
);
$arRule[] = array(
	'RULE'	=>	'#^/akcii/#',
	'PAGE'	=>	'/akcii/index.php',
);
$arRule[] = array(
	'RULE'	=>	'#^/nashi-postroennie-proecti/#',
	'PAGE'	=>	'/nashi-postroennie-proecti/index.php',
);

$LINK = CTools::GetURL();
foreach( $arRule as $v ){	
	if( preg_match( $v['RULE'], $LINK ) ){		
		$APPLICATION->IncludeFile( $v['PAGE'] );		
		die();
	}
}
$APPLICATION->IncludeFile( '/404.php' );
?>