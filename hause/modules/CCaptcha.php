<?class CCaptcha{	
	function img_code($code){		
		$im = imagecreate(110, 40);	
		$color = imagecolorallocate($im, 255, 255, 255);
		$color = imagecolorallocate($im, 0, 0, 0);
		//imagerectangle($im, 0,0,109,54,$color);		
		$x = rand(0, 5);
		for($i = 0; $i < strlen($code); $i++) {
			$x+=18;
			$letter=substr($code, $i, 1);
			imagettftext(
				$im, 
				rand(23, 25), 
				rand(6, 10), 
				$x,
				rand(30, 45),
				$color,
				$_SERVER["DOCUMENT_ROOT"].'/hause/modules/arial.ttf', 
				$letter
			);
		}
		$linenum = rand(4, 8); 
		for ($i=0; $i<$linenum; $i++){
			imageline(
				$im, 
				rand(3, 10), 
				rand(3, 50), 
				rand(100, 107), 
				rand(3, 50), 
				$color
			);
		}
		header("Content-Type:image/png");
		imagePng($im);
		imagedestroy($im);
		die();
	}	
	function CaptchaGetCode(){
		$this->unset_cap_all();
		$chars = 'abdefhknrstyz23456789';
		$length = rand(4, 5);
		$numChars = strlen($chars);
		$str = '';
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, rand(1, $numChars) - 1, 1);
		}
		$array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
		srand ((float)microtime()*1000000);
		shuffle ($array_mix);
		$word = implode( "", $array_mix );
		$sid = md5( $word.':graff:'.time() );		
		$this->set_cap( $sid, $word );			
		return $sid;
	}
	function CaptchaCheckCode($word, $sid){
		$word = htmlspecialchars($word);
		$sid  = htmlspecialchars($sid);		
		$res = false;
		if(strlen($word) > 1 && strlen($sid)>1){
			if($word == $this->get_cap($sid)){
				$res = true;
				$this->unset_cap($sid);
			}			
		}
		return $res;
	}
	function CaptchaGetImg($sid){		
		$word = $this->get_cap($sid);		
		$this->img_code($word);		
	}
	function unset_cap_all(){
		global $db;
		$query = "
			DELETE 
			FROM
				h_captcha
			WHERE
				CREATE_DATE < ".( intval(time() ) - ( 5 * 60 ) )."
			";			
		$db->query($query);
	}
	function unset_cap($sid){
		global $db;
		$query = "
			DELETE 
			FROM
				h_captcha
			WHERE
				SID = '".$sid."'
			";
		$db->query($query);		
	}	
	function set_cap( $sid, $word ){
		global $db;
		$query = insert_db(
			"h_captcha",
			array(
				"SID"			=> $sid,
				"WORD"			=> $word,
				"CREATE_DATE"	=> time(),
			)
		);		
		$db->query( $query );	
	}	
	function get_cap($sid){
		global $db;
		$query = "
			SELECT
				*
			FROM
				h_captcha
			WHERE
				SID = '".$sid."'
			";			
		$res = $db->selectRow($query);
		$word = $res['WORD'];		
		return $word;
	}	
}
$capt = new CCaptcha;
?>