<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?global $USER?>
<?
if(
	(
		$arParam['CAPTCHA'] == 'Y'
	)||(
			intval( $_SESSION['SESS_AUTH']['SHOT'] ) > 5 
		&&	$arParam['CAPTCHA'] != 'Y'
	)
){
	$arParam['CAPTCHA'] = 'Y';
	global $capt;
	$code = $capt->CaptchaGetCode();
	$arParam['CAPTCHA_FLAG'] = false;
}
if(
		!$USER->IsAuthorized()
	&& 	$_POST['AUTH_F'] == 'Y'
	&&	strlen( $_POST['LOGIN'] )
	&&	strlen( $_POST['PASS'] )	
){
	$_SESSION['SESS_AUTH']['SHOT']++;
	if(
			$arParam['CAPTCHA'] == "Y"
		&&	strlen( $_POST['captcha_word'] )
	){
		if( $capt->CaptchaCheckCode($_POST['captcha_word'], $_POST['captcha_sid'])){
			$arParam['CAPTCHA_FLAG'] = true;
		}
	}
	if(
		(	
				$arParam['CAPTCHA_FLAG']
			&&	$arParam['CAPTCHA'] == "Y"
		)||(
			$arParam['CAPTCHA'] == "N"
		)
	){	
		$LOGIN = htmlspecialchars( $_POST['LOGIN'] );
		$PASS = htmlspecialchars( $_POST['PASS'] );
		
		$USER->Login( $LOGIN, $PASS );
		CTools::LocalRedirect( $_SERVER['REQUEST_URI'] );					
	}	
}?>