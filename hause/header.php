<?require_once( $_SERVER['DOCUMENT_ROOT'] . '/hause/core/init.php' );?>
<?
$mass_templ_st = array();
$mass_templ_st['ALL'] = 'default';
//$mass_templ_st['ADMIN'] = 'admin';

if(
		strlen( $TEMPLATE )
	&&	array_key_exists ( $TEMPLATE, $mass_templ_st )
){
	$templ = $mass_templ_st[$TEMPLATE];
}else{
	$templ = $mass_templ_st['ALL'];
}
$SITE = '/hause/templates/' . $templ;
$SITE_1 = $_SERVER['DOCUMENT_ROOT'] . '/hause/templates/' . $templ;

if( file_exists( $SITE_1 . '/header.php' ) ){	
	require( $SITE_1 . '/header.php' );
}else{	
	echo '<div class=\'MessErrore\'>Ошибка: templates [ ' . $templ . ' ] не найден!</div>';
 	die();
}?>