<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>

<?
function getCOUNT( $INTERVAL, $arSESS ){
	$res = 0;
	foreach( $arSESS as $v ){
		$now = time();
		$max = $now - $INTERVAL['MIN'];
		$min = $now - $INTERVAL['MAX'];
		if(
				$v[ 'DATE' ] >= $min
			&&	$v[ 'DATE' ] <= $max
		){
			$res++;
		}
	}	
	return $res;
}
function sessDecode( $str ){
	$arRes = array();
	while ($i = strpos( $str, '|') ){
		$k = substr($str, 0, $i);
		$v = unserialize(substr($str, 1 + $i));
		$str = substr($str, 1 + $i + strlen(serialize($v)));
		$arRes[$k] = $v;
	}
	return $arRes;
}
function getFileSESS( $DIR ){
	if( !strlen( $DIR ) ){
		$DIR = '/hause/session/';
	}
	$arNON = array(
		'.',
		'..',
	);
	$arRes = array();
	$arSESS = scandir( $DIR );
	foreach( $arSESS as $v ){
		if( in_array( $v, $arNON ) ){
			continue;
		}
		$strSESS = CFile::RereadFile( $DIR . $v );
		$SESS = sessDecode( $strSESS );
		$arRes[] = array(
			'DATE'	=>	filectime( $DIR . $v ),
			'NAME'	=>	$v,
			'SESS'	=>	$SESS,
		); 
	}
	return $arRes;
}
$arSESS = getFileSESS( $arParam['PATH'] );
foreach( $arParam['LIST'] as &$v ){
	$v['QUANTY'] = getCOUNT( $v['INTERVAL'], $arSESS );
}
unset( $v );
?>