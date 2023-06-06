<?
function getSelector( $arPar, $arRes ){
	foreach( $arPar as $v ){		
		if( $v['type'] == 'rule' ){
			//$arRes = array_merge( $arRes, $v['selectors'] );
		}elseif( $v['type'] == '@media' ){
			echo '<pre>';
			print_r();
			echo '</pre>';
			$arRes = getSelector( $v['nestedRules'], $arRes );
		}
	}
	return $arRes;
}
function getAllSelector( $arPar ){
	$arRes = array();
	$arRes = getSelector( $arPar['value'], $arRes );
	return $arRes;
}
function rFile( $fileName ){
	$file = '';	
	if( !file_exists( $fileName ) ){
		return $file;
	}
	
	$fh = fopen( $fileName, 'r' );
	if( $fh ){
		while ( !feof( $fh ) ) {
			$buffer = fgets( $fh );
			$file .= $buffer;
		}
	}
	return $file;
}

/**********************************/
$fileName = __DIR__ . '\s.json';
$file = rFile( $fileName );
$arJson = json_decode( $file, true );
$arSelector = getAllSelector( $arJson );

echo '<pre>';
print_r( $arSelector );
print_r( $arJson );
echo '<p/re>';


?>