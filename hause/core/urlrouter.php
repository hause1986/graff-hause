<?require_once( $_SERVER['DOCUMENT_ROOT'] . '/hause/core/init.php' );

/*
Пример
$arRule[] = array(
	'RULE'	=>	'#^/admin/#',
	'PAGE'	=>	'/admin/index.php',
);
*/

$LINK = CTools::GetURL();
foreach( $arRule as $v ){	
	if( preg_match( $v['RULE'], $LINK ) ){		
		$APPLICATION->IncludeFile( $v['PAGE'] );		
		die();
	}
}
$APPLICATION->IncludeFile( '/404.php' );
?>