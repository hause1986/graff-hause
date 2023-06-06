<?require( $_SERVER["DOCUMENT_ROOT"]."/hause/core/init.php" );?>
<?
if( strlen( $_GET['captcha_sid'] ) > 1 ){	
	$sid = htmlspecialchars( $_GET['captcha_sid'] );	
	$capt = new CCaptcha;
	$capt->CaptchaGetImg( $sid );
}?>