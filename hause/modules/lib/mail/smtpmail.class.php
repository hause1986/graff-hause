<?php
	function get_data($smtp_conn) {
    $data="";
    while($str = fgets($smtp_conn, 515)) {
        $data .= $str;
        if(substr($str,3,1) == " ") { break; }
    }
    return $data;
	}

	function SandMail($to, $title, $massage) {
		$EMAIL_NAME = 'Универсум - БИЗНЕС В ПОДАРОК!';
		$SMTP_SERVER = 'ssl://smtp.yandex.ru';
		$SMTP_PORT = '465';
		$SMTP_LOGIN = 'smtp@ruopi.ru';
		$SMTP_PASS = '111111';		
		$EMAIL_FROM = 'info@universum.ru';	
		
		$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n"; 
		$header.="From: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($EMAIL_NAME)))."?= <".$EMAIL_FROM.">\r\n"; 
		$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n"; 
		$header.="Reply-To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($EMAIL_NAME)))."?= <".$EMAIL_FROM.">\r\n";
		$header.="X-Priority: 3 (Normal)\r\n";
		$header.="Message-ID: <172562218.".date("YmjHis")."@yandex.ru>\r\n";
		$header.="To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($EMAIL_NAME)))."?= <".$to.">\r\n";
		//$header.="Bcc: <". $EMAIL_BCC . ">\r\n";
		$header.="Subject: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($title)))."?=\r\n";
		$header.="MIME-Version: 1.0\r\n";
		$header.="Content-Type: text/html; charset=utf-8\r\n";
		$header.="Content-Transfer-Encoding: 8bit\r\n";
				
		$arRes = array();
		$arRes['ERR'] = '';
		$smtp_conn = fsockopen($SMTP_SERVER, $SMTP_PORT, $errno, $errstr, 10);
		
		if(!$smtp_conn) {
			
			$arRes['ERR'] = "соединение с серверов не прошло"; 
			fclose($smtp_conn);	
			
		}else{
			
			$data = get_data($smtp_conn);
			fputs($smtp_conn,"EHLO yandex.ru\r\n");
			$code = substr(get_data($smtp_conn),0,3);			
			if($code != 250) {
				$arRes['ERR'] =  "ошибка приветсвия EHLO";
				fclose($smtp_conn);	
				
			}else{
				
				fputs($smtp_conn,"AUTH LOGIN\r\n");
				$code = substr(get_data($smtp_conn),0,3);				
				if($code != 334) {
					$arRes['ERR'] =  "сервер не разрешил начать авторизацию"; 
					fclose($smtp_conn);	
					
				}else{
					
					fputs($smtp_conn,base64_encode($SMTP_LOGIN)."\r\n");
					$code = substr(get_data($smtp_conn),0,3);					
					if($code != 334) {
						$arRes['ERR'] =  "ошибка доступа к такому юзеру"; 
						fclose($smtp_conn);	
						
					}else{
						
						fputs($smtp_conn,base64_encode($SMTP_PASS)."\r\n");
						$code = substr(get_data($smtp_conn),0,3);						
						if($code != 235) {
							$arRes['ERR'] =  "не правильный пароль"; 
							fclose($smtp_conn);						
						}else{
						
							fputs($smtp_conn,"MAIL FROM:".$SMTP_LOGIN."\r\n");
							$code = substr(get_data($smtp_conn),0,3);						
							if($code != 250) {
								$arRes['ERR'] =  "сервер отказал в команде MAIL FROM"; 
								fclose($smtp_conn);		

							}else{
						
								fputs($smtp_conn,"RCPT TO:".$to."\r\n");
								$code = substr(get_data($smtp_conn),0,3);						
								if($code != 250 AND $code != 251) {
									$arRes['ERR'] =  "Сервер не принял команду RCPT TO"; 
									fclose($smtp_conn);								
						
								}else{
									
									fputs($smtp_conn,"DATA\r\n");
									$code = substr(get_data($smtp_conn),0,3);									
									if($code != 354) {
										$arRes['ERR'] =  "сервер не принял DATA"; 
										fclose($smtp_conn);

									}else{
										
										fputs($smtp_conn,$header."\r\n".$massage."\r\n.\r\n");										
										$code = substr(get_data($smtp_conn),0,3);
										if($code != 250) {
											$arRes['ERR'] =  "ошибка отправки письма"; 
											fclose($smtp_conn); 
		
										}else{

											fputs($smtp_conn,"QUIT\r\n");
											fclose($smtp_conn);
										}
									}
								}				
							}		
						}
					}
				}
			}
		}	
		
		if( strlen($arRes['ERR'] ) ){
			return json_encode(
				array(
					'RES'	=>	'ERR',
					'MESS'	=>	$arRes['ERR'],
				)
			);
		}else{
			return json_encode(
				array(
					'RES'	=>	'OK',					
				)
			);	
		}
	}
