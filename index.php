<?
$class = __DIR__ . '/hause/class.php';
$init = __DIR__ . '/hause/init.php';
require( $init );
require( $class );



$ghBot = new GHTelegramBot( '6278856035:AAGaiRkUVJwiLncrbz_9z4GUkPSWI6_BaTY' );
$infoBot = $ghBot->getMe();
/*
echo '<pre>';
print_r( $infoBot );
echo '</pre>';
*/
if( !$infoBot['ok'] ){
	die();
}

$arMessBot = $ghBot->getUp();



echo '<pre>';
print_r( $arMessBot );
echo '</pre>';

?>
