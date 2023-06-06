<?
include_once __DIR__ . '/phpQuery.php';
class GHCssSelecter{
	
	private function getSelector( $arPar, $arRes ){
		foreach( $arPar as $v ){		
			if( $v['type'] == 'rule' ){
				$arRes = array_merge( $arRes, $v['selectors'] );
			}elseif( $v['type'] == '@media' ){
				$arRes = $this->getSelector( $v['nestedRules'], $arRes );
			}
		}
		return $arRes;
	}
	
	public function getAllSelector( $arPar ){
		$arRes = array();
		$arRes = $this->getSelector( $arPar['value'], $arRes );
		$arRes = array_values(
			array_unique( $arRes )
		);
		return $arRes;
	}
	
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
$arParFiles = array(
	'CSS'	=>	__DIR__ . '\style.css',
	'JSON'	=>	__DIR__ . '\style.json',
	'HTML'	=>	__DIR__ . '\index.html',
);

$arJson = json_decode(
	rFile( $arParFiles['JSON'] ),
	true
);
$cssSel = new GHCssSelecter();
$arSelector = $cssSel->getAllSelector( $arJson );


$htmlDom = phpQuery::newDocument( 
	rFile( $arParFiles['HTML'] )
);

foreach( $arSelector as $v ){
	$flag = false;
	$res = pq( $htmlDom->find( $v ) );
	echo '<pre>';
	echo $v;
	print_r( $res );
	echo '</pre>';
	bdeak;
}


?>