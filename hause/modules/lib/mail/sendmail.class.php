<?
class mailTo{
	private $toEmail;
	private $fromEmail;
	private $subjectEmail;
	
	
	private $boundary;
	private $messageText;
	private $attachFiles;
	
	public function __construct(){	
		$this->toEmail = '';
		$this->fromEmail = '';
		$this->subjectEmail = '';
		$this->boundary = "--".md5(uniqid(time()));
		$this->messageText = '';
		$this->attachFiles = '';		
	}	
	public function to( $to = 'hause1986@mail.ru' ){
		$this->toEmail = $to;
	}
	public function from( $from = 'graff@cool.hak', $name = '' ){
		$this->fromEmail = "From: ".$name." <".$from.">\r\n";
	}	
	public function subject($subject){
		$this->subjectEmail = $subject;
	}
	
	
	public function message($message){	
		$this->messageText = chunk_split(base64_encode( $message ));		
	}
	public function html($file_path){
		$message = file_get_contents($file_path);
		$message = chunk_split(base64_encode($message));
		$this->messageText = $message;
	}
	public function attachss( $file_path ){
		
		if( file_exists( $file_path ) ){
			$filenameAR = explode( '/', $file_path );
			$filename = $filenameAR[count($filenameAR) - 1];
			
			$boundary = $this->boundary;
			$fp = fopen($file_path, "r");
			$file = fread($fp, filesize($file_path)); 
			fclose($fp);

			$message_part = "\r\n--$boundary\r\n"; 
			$message_part .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";  
			$message_part .= "Content-Transfer-Encoding: base64\r\n"; 
			$message_part .= "Content-Disposition: attachment; filename=\"$filename\"\r\n"; 
			$message_part .= "\r\n";
			$message_part .= chunk_split(base64_encode($file));			
			$this->attachFiles .= $message_part;			
		}	
	}
	public function attach( $file_path ){
		
		if( file_exists( $file_path ) ){
			$filenameAR = explode( '/', $file_path );
			$filename = $filenameAR[count($filenameAR) - 1];
			
			$boundary = $this->boundary;
			$fp = fopen($file_path, "r");
			$file = fread($fp, filesize($file_path)); 
			fclose($fp);

			$message_part = "\r\n--$boundary\r\n"; 
			$message_part .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";  
			$message_part .= "Content-Transfer-Encoding: base64\r\n"; 
			$message_part .= "Content-Disposition: attachment; filename=\"$filename\"\r\n"; 
			$message_part .= "\r\n";
			$message_part .= chunk_split(base64_encode($file));			
			$this->attachFiles = $message_part;			
		}	
	}	
	
	public function send(){
		$res = false;
		$boundary = $this->boundary;
		
		$mailheaders = "";
		$mailheaders .= "MIME-Version: 1.0;\r\n"; 
		$mailheaders .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"; 
		$mailheaders .= $this->fromEmail;	
		
		////////////////////////////////////////////////////
		$multipart	= "";
		$multipart .= "--$boundary\r\n"; 
		$multipart .= "Content-type: text/html; charset=utf-8 \r\n";
		$multipart .= "Content-Transfer-Encoding: base64\r\n";
		$multipart .= "\r\n";			
		$multipart .= $this->messageText;		
		$multipart .= $this->attachFiles;
		
		$res = mail( 
			$this->toEmail,
			$this->subjectEmail,
			$multipart,
			$mailheaders
		);
		return $res;
	}
}
?>