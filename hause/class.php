<?
class GHTelegramBot{
	private $TOKEN;
	private $URL;


	function __construct( $TOKEN = '' ){		
		$this->TOKEN = $TOKEN;
		$this->URL = 'https://api.telegram.org/bot' . $TOKEN . '/';
	}
	
	public function send( $method, $arPar = array() ){		
		$params = '';
		$url = $this->URL . $method;
		if( count( $arPar ) ){
			$params = http_build_query( $arPar );
			$url .= '?' . $params;
		}
		echo '<div>';
		echo $url;
		echo '</div>';
		$res = file_get_contents( $url );
		return json_decode( $res, true );		
	}
	/*  */
	public function getMe(){
		return $this->send(
			'getMe',
			null
		);
	}
	/* */
	public function getUp(){	
		$arRes = $this->send(
			'getUpdates',
			array( 'offset' => intval( $_SESSION['ID_UP_LAST'] ) )			
		);		
		if( $arRes['ok'] && count( $arRes['result'] ) ){
			$res = array_reverse( $arRes['result'] );
			$_SESSION['ID_UP_LAST'] = intval( $res[0]['update_id'] ) + 1 ;
		}
		return $arRes;		
	}
}
?>
