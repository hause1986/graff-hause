<?if(!$B_PROLOG_M) die();?>
<?class new_db{	
	function query($arRes){	
		global $db;		
		foreach($arRes as $v){
			$db->query($v);
		}
	}
	function Delete(){
		global $db;
		$arRes[] = "DROP TABLE h_iblok_ib";
		$arRes[] = "DROP TABLE h_iblok_elements";		
		
		$arRes[] = "DROP TABLE h_prop_type";		/////////////
		$arRes[] = "DROP TABLE h_prop_iblock";		/////////////
		$arRes[] = "DROP TABLE h_prop_enum";		/////////////
		$arRes[] = "DROP TABLE h_prop_value";		/////////////		
	
		$arRes[] = "DROP TABLE h_files";
		$arRes[] = "DROP TABLE h_users";
		$arRes[] = "DROP TABLE h_groops";
		$arRes[] = "DROP TABLE h_user_groop";
		
		$arRes[] = "DROP TABLE h_captcha";
		$arRes[] = "DROP TABLE h_images";
		
		$this->query($arRes);		
	}
	function Add(){
		global $db;
		$arRes[]=	"
			CREATE TABLE h_iblok_ib (
				ID 				INT  AUTO_INCREMENT ,
				NAME 			VARCHAR(500) NOT NULL ,
				SORT 			INT NOT NULL ,
				CODE 			VARCHAR(500) NOT NULL ,
				ACTIVE			VARCHAR(1) NOT NULL ,
				DESCRIPT_TEXT 	VARCHAR(500) DEFAULT NULL ,
				CREATE_DATE		INT NOT NULL ,
				UP_DATE			INT NOT NULL ,
				PRIMARY KEY(ID)
			)";					
				
		$arRes[]=	"
			CREATE TABLE h_iblok_elements (
				ID 				INT  AUTO_INCREMENT ,
				NAME 			VARCHAR(200) NOT NULL ,
				SORT 			INT NOT NULL ,
				CODE 			VARCHAR(200) NOT NULL ,
				ACTIVE			VARCHAR(1) NOT NULL ,
				ID_IBLOCK		INT NOT NULL ,
				CREATE_DATE		INT NOT NULL ,
				UP_DATE			INT NOT NULL ,
				PRIMARY KEY(ID)
			)";
		$arRes[]=	"
			CREATE TABLE h_files (
				ID				INT  AUTO_INCREMENT ,
				CREATE_DATE		INT NOT NULL ,
				SIZE 			INT NOT NULL ,	
				TYPE			VARCHAR(10) NOT NULL ,
				NAME			VARCHAR(200) NOT NULL ,
				PRIMARY KEY(ID)
			)";
		$arRes[] = "
			CREATE TABLE h_users (
				ID				INT  AUTO_INCREMENT ,
				SORT 			INT NOT NULL ,
				ACTIVE			VARCHAR(1) NOT NULL ,
				NAME			VARCHAR(50) NOT NULL ,
				EMAIL			VARCHAR(50) DEFAULT NULL ,
				LOGIN			VARCHAR(50) NOT NULL ,
				PASS			VARCHAR(50) NOT NULL ,
				CREATE_DATE		INT NOT NULL ,
				UP_DATE			INT NOT NULL ,
				UNIQUE			(LOGIN),
				PRIMARY KEY		(ID)	
			)";	
		$arRes[] = "
			CREATE TABLE h_groops (
				ID				INT  AUTO_INCREMENT ,
				SORT 			INT NOT NULL ,
				NAME			VARCHAR(50) NOT NULL ,
				DESCRIPT_TEXT 	VARCHAR(200) DEFAULT NULL ,
				CREATE_DATE		INT NOT NULL ,
				UP_DATE			INT NOT NULL ,
				PRIMARY KEY(ID)	
			)";	
		$arRes[] = "
			CREATE TABLE h_user_groop (
				ID			INT  AUTO_INCREMENT ,
				ID_USER 	INT NOT NULL ,
				ID_GROOP	INT NOT NULL ,
				PRIMARY KEY(ID)	
			)";
		$arRes[] = insert_db(
			"h_users",
			array(
				"ID"			=> 1,
				"SORT"			=> 500,
				"ACTIVE"		=> "Y",
				"NAME"			=> "Панин",
				"EMAIL"			=> "hause1986@mail.ru",
				"LOGIN"			=> "hause1986",
				"PASS"			=> md5("19821714hausee"),
				"CREATE_DATE"	=> time(),
				"UP_DATE"		=> time(),
			)
		);
		$arRes[] = insert_db(
			"h_groops",
			array(
				"ID"			=> 1,
				"SORT"			=> 10,				
				"NAME"			=> "Administrator",
				"DESCRIPT_TEXT"	=> "Administrator",				
				"CREATE_DATE"	=> time(),
				"UP_DATE"		=> time(),
			)			
		);
		$arRes[] = insert_db(
			"h_groops",
			array(
				"ID"			=> 2,
				"SORT"			=> 500,				
				"NAME"			=> "Guest",
				"DESCRIPT_TEXT"	=> "Guest",				
				"CREATE_DATE"	=> time(),
				"UP_DATE"		=> time(),
			)			
		);	
		$arRes[] = insert_db(
			"h_user_groop",
			array(
				"ID"		=> 1,
				"ID_USER"	=> 1,
				"ID_GROOP"	=> 1,
			)
		);
		$arRes[] = "
			CREATE TABLE h_captcha (
				SID				VARCHAR(50) NOT NULL ,
				WORD			VARCHAR(10) NOT NULL ,
				CREATE_DATE		INT NOT NULL ,
				UNIQUE		(WORD),
				PRIMARY KEY	(SID)	
			)";	
		////////////////////////////////////	
		$arRes[] = "
			CREATE TABLE h_prop_type (
				ID			INT  AUTO_INCREMENT ,
				NAME		VARCHAR(50) NOT NULL ,
				TYPE		VARCHAR(10) NOT NULL ,
				PRIMARY KEY	(ID)	
			)";
		$arRes[] = insert_db(
			"h_prop_type",
			array(
				"ID"	=> 1,
				"NAME"	=> 'Строка',
				"TYPE"	=> 'S'
			)
		);
		$arRes[] = insert_db(
			"h_prop_type",
			array(
				"ID"	=> 2,
				"NAME"	=> 'Текс',
				"TYPE"	=> 'T'
			)
		);
		$arRes[] = insert_db(
			"h_prop_type",
			array(
				"ID"	=> 3,
				"NAME"	=> 'Список',
				"TYPE"	=> 'L'
			)
		);
		$arRes[] = insert_db(
			"h_prop_type",
			array(
				"ID"	=> 4,
				"NAME"	=> 'Целое число',
				"TYPE"	=> 'I'
			)
		);
		$arRes[] = insert_db(
			"h_prop_type",
			array(
				"ID"	=> 5,
				"NAME"	=> 'Файл',
				"TYPE"	=> 'F'
			)
		);
		$arRes[] = insert_db(
			"h_prop_type",
			array(
				"ID"	=> 6,
				"NAME"	=> 'Дата',
				"TYPE"	=> 'D'
			)
		);
		$arRes[] = insert_db(
			"h_prop_type",
			array(
				"ID"	=> 7,
				"NAME"	=> 'Текстовое невидимое поле - служебное',
				"TYPE"	=> 'H'
			)
		);	
		$arRes[] = insert_db(
			"h_prop_type",
			array(
				"ID"	=> 8,
				"NAME"	=> 'Пароль',
				"TYPE"	=> 'P'
			)
		);
		$arRes[]=	"
			CREATE TABLE h_prop_iblock (
				ID 				INT  AUTO_INCREMENT ,
				ID_IBLOCK		INT NOT NULL ,
				ID_PROP_TYPE	INT NOT NULL ,
				NAME 			VARCHAR(50) NOT NULL ,
				CODE 			VARCHAR(50) NOT NULL ,
				SORT 			INT NOT NULL ,
				ACTIVE			VARCHAR(1) NOT NULL ,
				REQUIRED		VARCHAR(1) NOT NULL ,
				MULTIPLE		VARCHAR(1) NOT NULL ,
				FLAG			VARCHAR(1) NOT NULL ,
				PRIMARY KEY(ID)
			)";
			
		$arRes[]=	"
			CREATE TABLE h_prop_enum (
				ID 				INT  AUTO_INCREMENT ,
				ID_PROP			INT NOT NULL ,
				CODE 			VARCHAR(50) DEFAULT NULL ,
				VALUE			VARCHAR(500) NOT NULL ,
				SORT 			INT NOT NULL ,				
				PRIMARY KEY(ID)
			)";				
			
		$arRes[]=	"
			CREATE TABLE h_prop_value (
				ID 				INT  AUTO_INCREMENT ,
				ID_ELEMENT		INT NOT NULL ,
				ID_PROP			INT NOT NULL ,
				VALUE			TEXT DEFAULT NULL ,
				PRIMARY KEY(ID)
			)";

		$arRes[]=	"
			CREATE TABLE h_images (
				ID 				INT  AUTO_INCREMENT ,
				ID_FILE			INT NOT NULL ,
				SIZE			INT NOT NULL ,
				NAME			VARCHAR(200) NOT NULL ,
				PRIMARY KEY(ID)
			)";
			
		/////////////////////////////////////
		$this->query($arRes);			
	}	
}?>