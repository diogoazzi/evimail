<?php
class Fet_Model_UserTable extends Zend_Db_Table
{
	const ATIVO = 1;
	const ESPERANDO_ATIVACAO = 0;
	const BANIDO = 3;

	private $db;
	public $erro;
	protected $_name 				= 'user';
	protected $_rowClass 			= 'Fet_Model_UserRow';
	protected $_primary = 'usr_id';
	
	//public function __construct(){
		//$this->db = Zend_Registry::get('db_adapter_comunidade');
		//parent::__construct($this->db);
	//}
	
	/**
	* Obtem lista dos usuários 
	* @param bool $fetchResult Define se o retorno será um SQL ou Zend_Db_Table_Rowset_Abstract
	* @return  Zend_Db_Table_Rowset_Abstract ou Zend_Db_Select
	*/
	public function getAllUsers($params=array(), $fetchResult = false, $limit = null, $offset = 0)
	{
		/**
		 * Obtendo os dados de todos os amigos do usuário $usrId
		 * @var Zend_Db_Sql
		 */
		$select = $this->select()
		->from(
		array('u' => $this->_name),
		array(
		/*'usr_id', 'usr_email', 'usr_name', 'usr_nickname',
		 'usr_occupation', 'usr_birthDate', 'cit_id', 'usr_status', 'usr_destaque',
		'usr_insertDate',
		'usr_insertDateFormat' => "DATE_FORMAT(u.usr_insertDate, '%d/%m/%Y %H:%i')"*/
				'*','usr_insertDateFormat' => "DATE_FORMAT(u.usr_insertDate, '%d/%m/%Y %H:%i')",'usr_dataTerminoPlanoFormat' => "DATE_FORMAT(u.usr_dataTerminoPlano, '%d/%m/%Y %H:%i')"
		//'usr_twitter', 'twitter_token', 'twitter_token_secret'
		)
		)
		->setIntegrityCheck(false)
		->joinLeft(array('c' => 'city'), 'u.cit_id = c.cit_id', array('cit_name'))
		->joinLeft(array('e' => 'state'), 'e.sta_id = c.sta_id', array('sta_acronym','sta_name'))
		->joinLeft(array('pho'=>'photo'), 'u.img_id = pho.pho_id', 'pho.*')
		->joinLeft(array('d'=>'dial'), 'd.usr_id = u.usr_id AND d.dia_deleted = 0', array('dials'=>'count(d.dia_id)'))
		;//
	
		if($params['usr_id_logged']){
		$select->joinLeft(array('bloq' => 'delation'), 'u.usr_id = bloq.usr_id
													AND bloq.usr_idDelation = '.$params['usr_id_logged'].'
													', new Zend_Db_Expr('IF( bloq.usr_idDelation IS NULL, 0, 1 ) bloqueado'));
		}
	
		if (isset($params["nome"]))
		$select->where("u.usr_name like ? or u.usr_nickname like ?", '%'.$params["nome"].'%');
			    
			if (isset($params["city"]))
		{
		$select->where('u.cit_id = ?', $params["city"], 'integer');
			}
	
			if (isset($params["cit_name"]))
		{
			    $select->where("c.cit_name like ?","%".$params["cit_name"]."%");
			}		
			
		    if (isset($params["city"])===false and isset($params["state"]))
		{
		        $select->where('c.sta_id = ?', $params["state"], 'integer');
		    }
	
		if (isset($params["ini"]) and isset($params["fim"]))
		{
		if (Zend_Validate::is($params["ini"], "Date", array("dd/MM/yyyy"))
		    	    and Zend_Validate::is($params["fim"], "Date", array("dd/MM/yyyy")))
	    		{	        
		$dtIni = new Zend_Date($params["ini"] . " 00:00:00", "pt_BR");
		$dtIni = $dtIni->get(Zend_Date::ISO_8601);
		 
		$dtFim = new Zend_Date($params["fim"] . " 23:59:59", "pt_BR");
		$dtFim = $dtFim->get(Zend_Date::ISO_8601);
	
	                $select->where('u.usr_insertDate BETWEEN "'.$dtIni.'" AND "'.$dtFim.'"');
		}
		}
	
		if (isset($params["termIni"]) and isset($params["termFim"]))
		    {
		    	if (Zend_Validate::is($params["termIni"], "Date", array("dd/MM/yyyy"))
		and Zend_Validate::is($params["termFim"], "Date", array("dd/MM/yyyy")))
	    		{	        
	    	        $dtIni = new Zend_Date($params["termIni"] . " 00:00:00", "pt_BR");
	    	        $dtIni = $dtIni->get(Zend_Date::ISO_8601);
		 
		$dtFim = new Zend_Date($params["termFim"] . " 23:59:59", "pt_BR");
		$dtFim = $dtFim->get(Zend_Date::ISO_8601);
	
		$select->where('u.usr_dataTerminoPlano BETWEEN "'.$dtIni.'" AND "'.$dtFim.'"');
	    		}
		    }
	
		$select->where('u.usr_deleted = 0');
		    
		    
		if (isset($params["status"]))
		{
		switch ($params["status"]) {
		case 'a': //ativo
		$usr_status = '1';
		        	break;
		        	case 'n': //Não confirmado
		$usr_status = '0';
		break;
		case 'i': //inativo
		        	    $usr_status = '3';
		break;
			case 'd': //Banido
			$select->where('u.usr_destaque = "S"');
			break;
			}
			 
			if (isset($usr_status))
			$select->where('u.usr_status = ?', $usr_status);
			}
	
			if (isset($params["search"])){
			$select->where("u.usr_name like ?
			or u.usr_nickname like ?
			or u.usr_email like ?
			    			or u.usr_aboutme like ?
			or u.usr_passion like ?
			    			or u.usr_music like ?
			or u.usr_twiter like ?", '%'.$params["search"].'%');
		}
	
			if($params["usr_id"]){
		 	$select->where('u.usr_id = ?', $params['usr_id']);
	}
	
		    if($params["usr_sexualidade"]){	
		 	$select->where('u.usr_sexualidade = ?', $params['usr_sexualidade']);
		    }
	
		    if($params["usr_online"]){	
		 	$select->where('u.usr_online = ?', $params['usr_online']);
		    }
	
		    if($params["usr_idade_de"] || $params["usr_idade_ate"]){	
			if(!$params["usr_idade_de"]) $params["usr_idade_de"] = 18;
		 		if(!$params["usr_idade_ate"]) $params["usr_idade_ate"] = 100;
			$select->where('YEAR(FROM_DAYS(DATEDIFF(CURDATE(), usr_birthdate))) BETWEEN '.$params['usr_idade_de'].' AND '.$params['usr_idade_ate']);
		    }
	
		    if($params['estado']){	
			$select->where('e.sta_id = ?', $params['estado']);
		    }
	
		    if($params['usr_country']){	
		 	$select->where('u.usr_country = ?', $params['usr_country']);
		    }
	
			/*if($params['usr_sou']){
			$select->where('u.usr_sou = ?', $params['usr_sou']);
		    }*/
	
		    if($params['usr_interesse']){	
		 	$select->where('u.usr_sou = ?', $params['usr_interesse']);
	}
	
	
	if($params["cargo"]){
		$select->where('u.usr_id_cargo = ?', $params['cargo']);
	}
	
	if($params["usr_id"]){
		 	$select->where('u.usr_id = ?', $params['usr_id']);
	}
	    	//  Zend_Debug::dump($select->__toString());
	
	if($limit || $offset)
	$select->limit($limit, $offset);
	
	/*	if (isset($params["orderby"]))
	{
			    switch ($params["orderby"]) {
			    	case 'n':
			    	    $order = "usr_name";
	break;
	case 'd':
			    	    $order = "usr_insertDate";
			    	break;
	}
			}
		
	if (isset($order)===false) $order = "usr_nickname";
	$select->order($order . " asc");*/
		
	$select->group('u.usr_id');
	
	if(!$params['order']){
	$select->order("usr_nickname desc");
	} else {
	$select->order($params['order']);
	}
			
	if($fetchResult)
	{
		return $this->fetchAll($select);
	}else{
		return $select;
	}
	
	}
	
	

	/**
	 * Cria um novo Usuario
	 * @param Array $post
	 * @return boolean
	*/	
	public function createUser( $userData ){
		$row = $this->createRow();
		unset($userData["usr_id"]);
		
		if($userData['usr_birthDate']){
			$dataNasc = explode("/",$userData['usr_birthDate']);
			$userData["usr_birthYear"] = $dataNasc[2]; 
			$userData["usr_birthMonth"] = $dataNasc[1]; 
			$userData["usr_birthDay"] = $dataNasc[0];
			
			$birthDate = new Zend_Date(
				$userData["usr_birthYear"]."-".$userData["usr_birthMonth"]."-".$userData["usr_birthDay"],"YYYY-MM-DD"
			);
			$birthDateF = $birthDate->toString('YYYY-MM-dd');
		}
		
		
		if(!$userData["usr_status"]){
			$userData["usr_status"] = 0;
		}
		
		$data = array(	
				'usr_name'=>$userData["usr_name"],
				'usr_email'=>$userData["usr_email"],
				'usr_password'=>$userData["usr_password"],
				'usr_gender'=>$userData["usr_gender"],
				'usr_status'=>$userData["usr_status"],
				'usr_nickname'=>$userData["usr_nickname"],
				'usr_facebookid'=>$userData["facebookId"],
				'usr_facebooktoken'=>$userData["facebookToken"],
				'usr_birthDate'=>$birthDateF,
		);
		
		$row->setFromArray($data);
		$row->save();
		$id = $row->usr_id;
		if($id){
			return $id;
		} else {
			return false;
		}
	}
	
	/**
	 * Atualiza os dados de um Usuario
	 * @param Array $post
	 * @return boolean
	*/	
	public function updateUser( $post ){
		
		$row = $this->find($post["usr_id"])->current();

		if($post['usr_birthDate']){
			$dataNasc = explode("/",$post['usr_birthDate']);
			$userData["usr_birthYear"] = $dataNasc[2]; 
			$userData["usr_birthMonth"] = $dataNasc[1]; 
			$userData["usr_birthDay"] = $dataNasc[0];
			
			$birthDate = new Zend_Date(
				$userData["usr_birthYear"]."-".$userData["usr_birthMonth"]."-".$userData["usr_birthDay"],"YYYY-MM-DD"
			);
			$birthDateF = $birthDate->toString('YYYY-MM-dd');
		}
		
		$post[usr_celular] = str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$post[usr_celular]))));
		$post[usr_telefone] = str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$post[usr_telefone]))));
		$post[usr_comercial] = str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$post[usr_comercial]))));
		
		$userData = array(  'usr_name'=>$post["usr_name"],
							'usr_birthDate'=>$birthDateF,
						    'cit_id'=>$post["cit_id"],
						    'usr_maritalStatus'=>$post["usr_maritalStatus"],
						    'usr_occupation'=>trim($post["usr_occupation"]),
							'usr_aboutme'=>$post["usr_aboutme"],
							'usr_passion'=>$post["usr_passion"],
							'usr_activity'=>$post["usr_activity"],
							'usr_music'=>$post["usr_music"],
							'usr_party'=>$post["usr_party"],
							'usr_orkut'=>$post["usr_orkut"],
							'usr_twiter'=>$post["usr_twiter"],
							'usr_facebook'=>$post["usr_facebook"],
							'usr_myspace'=>$post["usr_myspace"],
							'usr_msn'=>$post["usr_msn"],
							'usr_site'=>$post["usr_site"],
							'usr_hometown'=>$post["usr_hometown"],
							'usr_drinking'=>$post["usr_drinking"],
							'usr_drink'=>$post["usr_drink"],
							'usr_smoke'=>$post["usr_smoke"],
							'usr_celular'=>$post["usr_celular"],
							'usr_logradouro'=>$post[usr_logradouro],
							'usr_numero'=>$post[usr_numero],
							'usr_bairro'=>$post[usr_bairro],
							'usr_estado'=>$post[usr_estado],
							'usr_cidade'=>$post[usr_cidade],
							'usr_country'=>$post[usr_country],
							'usr_cidadenatal'=>$post[usr_cidadenatal],
							'usr_estadonatal'=>$post[usr_estadonatal],
							'usr_paisnatal'=>$post[usr_paisnatal],
							'usr_gender'=>$post[usr_gender],
							'usr_celular'=>$post[usr_celular],
							'usr_telefone'=>$post[usr_telefone],
							'usr_comercial'=>$post[usr_comercial],
							'usr_company'=>$post[usr_company],
							'usr_companyposition'=>$post[usr_companyposition],
							'usr_companycity'=>$post[usr_companycity],
							'usr_companydescription'=>$post[usr_companydescription],
							'usr_university'=>$post[usr_university],
							'usr_universityyear'=>$post[usr_universityyear],
							'usr_universitycurse'=>$post[usr_universitycurse],
							'usr_universitydegree'=>$post[usr_universitydegree],
							'usr_universitydescription'=>$post[usr_universitydescription],
							'usr_college'=>$post[usr_college],
							'usr_collegeyear'=>$post[usr_collegeyear],
							'usr_collegedescription'=>$post[usr_collegedescription],
							'usr_music'=>$post[usr_music],
							'usr_books'=>$post[usr_books],
							'usr_movies'=>$post[usr_movies],
							'usr_television'=>$post[usr_television],
							'usr_games'=>$post[usr_games],
							'usr_team'=>$post[usr_team],
							'codUsuarioAntigo'=>isset($post["codUsuarioAntigo"])? $post["codUsuarioAntigo"] : null);
		
		if($post["usr_status"]){
			$userData['usr_status'] = $post['usr_status'];
		}
		
		if($post[img_id]){
			$userData['img_id'] = $post[img_id];
		}
		
		$row->setFromArray($userData);
		
		if( isset($post["usr_activeKey"])){
			$row->usr_activeKey = $post["usr_activeKey"];
		}
		if( isset($post["usr_birthDate"])){
			$row->usr_birthDate = $post["usr_birthDate"];
		}
		// atualiza username na session
//		Zend_Auth::getInstance()->getIdentity()->usr_nickname = $post["usr_name"];
		
		$row->save();
	}
	
	/**
	 * Realiza a ativação do profile no banco de dados
	 * @param $name
	 * @return boolen
	*/
	public function activeUser( $key ){
		$confirKey = $this->fetchAll(
						$this->select()
						->from(array('u'=>'user'),
		                       array('u.usr_id'))
						->where("usr_activeKey = ?", $key)
		);

		$usrId = $confirKey->current()->usr_id;

		if(!empty($usrId)){
			$set = array(
			    'u.usr_id' => $usrId
			);
			
			$row = $this->find($usrId)->current();
			$row->usr_status = "1";
			$row->save();
			
			return $row;
		}else{
			return false;
		}
	}
	
	/**
	 * Busca dados do usuário através do e-mail 
	 * @param string $email
	 */
	public function getUserByEmail( $email , $deleted = 0){

		$select = $this->select()
		->from(array('u'=>'user'))
		->where("usr_email = ?", $email);

		if($deleted != null){
			$select->where('u.usr_deleted = '.$deleted );
		}
		
		$user = $this->fetchAll(
		$select
		);
	
		
		$current = $user->current();
		if(isset($current)){
			return $current;
		} else {
			return false;
		}
	}
	
	public function getUserByFacebookId( $facebook , $deleted = 0){
	
		$select = $this->select()
		->from(array('u'=>'user'))
		->where("usr_facebookid = ?", $facebook);
	
		if($deleted != null){
			$select->where('u.usr_deleted = '.$deleted );
		}
	
		$user = $this->fetchAll(
		$select
		);
		
		$current = $user->current();
		if(isset($current)){
			return $current;
		} else {
			return false;
		}
	}
	
	public function getUsersWithFacebookId( $deleted = 0){
	
		$select = $this->select()
		->from(array('u'=>'user'))
		->where("usr_facebookid > 0");
	
		if($deleted != null){
			$select->where('u.usr_deleted = '.$deleted );
		}
	
		$user = $this->fetchAll(
		$select
		);
		
		if(isset($user)){
			return $user;
		} else {
			return false;
		}
	}

	public function getFriendsWithFacebookId($usrId){

		$sql1 = 'select usr_id as idFriend from friend where usr_idFriend = '.$usrId;
		$sql2 = 'select usr_idFriend as idFriend from friend where usr_id = '.$usrId;
	
		$db = $this->getAdapter();
	
		/**
		 * Amigos que adicionaram o usuario $usrId
		 * @var Zend_Db_Sql
		 */
		$sql1 = $db->select()->from('friend', array('idFriend'=>'usr_id'))->where('usr_idFriend = ?', $usrId)->where('fri_status = 1');
	
		/**
		 * Amigos adicionados pelo usupário $usrId
		 * @var Zend_Db_Sql
		 */
		$sql2 = $db->select()->from('friend', array('idFriend'=>'usr_idFriend'))->where('usr_id = ?', $usrId)->where('fri_status = 1');
	
	
		$sqlUserFriends = $db->select()->union(array($sql1, $sql2));
	
		/**
		 * Obtendo os dados de todos os amigos do usuário $usrId
		 * @var Zend_Db_Sql
		 */
		$sql = $this->select()
		->from(array('u'=>'user'))
		->setIntegrityCheck(false)
		->join(array('uf'=>$sqlUserFriends), 'uf.idFriend = u.usr_id')
		->where("usr_facebookid > 0");
	
		$sql->where('u.usr_deleted = 0');
		
		$user = $this->fetchAll(
		$sql
		);
		
		if(isset($user)){
			return $user;
		} else {
			return false;
		}
	
	}

	public function updatePasswd( $usrId, $nPasswd ){
		$row = $this->find($usrId)->current();
		$userData = array(  'usr_password'=>$nPasswd);
		$row->setFromArray($userData);
		$row->save();
	}
	
	/**
	 * Busca dados do usuário através do login 
	 * @param string $login
	 */
	public function getUserByLogin( $login , $deleted = 0){
		
		$select = $this->select()
		->from(array('u'=>'user'))
		->where("usr_nickname = ?", trim($login));
		if($deleted != null){
			$select->where('u.usr_deleted = '.$deleted);
		}		
		
		$user = $this->fetchAll(
			$select
		);
	
		$current = $user->current();
		if(isset($current)){
			return $current;
		} else {
			return false;
		}
	}
	
	/**
	 * Busca dados do usuário através do e-mail 
	 * @param string $email
	 */
	public function getUsersByName( $name, $limit, $params=null ){

		$select = $this->select()
					->from(array('u'=>'user'))
					->where("usr_name like '%$name%'")
					->where('u.usr_deleted = 0');
		
		if($params[status] != ""){
			$select->where('usr_status = ?',$params[status]);
		}
		if($limit){
			$select->limit($limit);
		}
		
		$users = $this->fetchAll(
					$select
		);
	
		if(isset($users)){
			return $users;
		} else {
			return false;
		}
	}
	
}
?>
