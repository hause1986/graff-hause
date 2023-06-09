<?
$class = __DIR__ . '/hause/class.php';
$init = __DIR__ . '/hause/init.php';
$arListTask = array(
	'INFO'	=>	__DIR__ . '/hause/task/info.php',
);

require( $init );
require( $class );

$ghBot = new GHTelegramBot( '6278856035:AAGaiRkUVJwiLncrbz_9z4GUkPSWI6_BaTY' );
$infoBot = $ghBot->getMe();
if( !$infoBot['ok'] ){
	die();
}

foreach( $arListTask as $v ){
	require( $v );
}

$arMessBot = $ghBot->getUp();
if( !$arMessBot['ok'] || !count( $arMessBot['result'] ) ){
	die();
}

foreach( $arMessBot['result'] as $v ){
	$text = $v['message']['text'];
	switch( $text ) {
		case '/info':
		case '/start':
			
		break;
	}
}


echo '<pre>';
print_r( $arMessBot );
echo '</pre>';

?>
