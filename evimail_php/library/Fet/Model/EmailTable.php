<?php
class Fet_Model_EmailTable extends Zend_Db_Table
{	
	const EMAIL_NAO_ENVIADO =0;
	const EMAIL_ENVIADO_NAO_DEBIATO = 1;
	const EMAIL_ENVIADO_DEBITADO = 2;

	private $db;
	public $erro;
	protected $_name 				= 'email';
	protected $_rowClass 			= 'Fet_Model_EmailRow';
	protected $_primary = 'ema_id';
	
	//public function __construct(){
		//$this->db = Zend_Registry::get('db_adapter_comunidade');
		//parent::__construct($this->db);
	//}
	
	/**
	* Obtem lista dos usuários 
	* @param bool $fetchResult Define se o retorno será um SQL ou Zend_Db_Table_Rowset_Abstract
	* @return  Zend_Db_Table_Rowset_Abstract ou Zend_Db_Select
	*/
	public function getAllEmail($params=array(), $fetchResult = false, $limit = null, $offset = 0)
	{
		/**
		 * Obtendo os dados de todos os amigos do usuário $usrId
		 * @var Zend_Db_Sql
		 */
		$select = $this->select()
		->from(
		array('e' => $this->_name),
		array(
		/*'ema_id', 'ema_email', 'ema_name', 'ema_nickname',
		 'ema_occupation', 'ema_birthDate', 'cit_id', 'ema_status', 'ema_destaque',
		'ema_insertDate',
		'ema_insertDateFormat' => "DATE_FORMAT(u.ema_insertDate, '%d/%m/%Y %H:%i')"*/
// 				'*','ema_insertDateFormat' => "DATE_FORMAT(u.ema_insertDate, '%d/%m/%Y %H:%i')",'ema_dataTerminoPlanoFormat' => "DATE_FORMAT(u.ema_dataTerminoPlano, '%d/%m/%Y %H:%i')"
		//'ema_twitter', 'twitter_token', 'twitter_token_secret'
		)
		)
		->setIntegrityCheck(false)
		->joinLeft(array('u' => 'user'), 'u.ema_id = e.ema_ema_id', array('ema_email', 'ema_email'))

		;//
	
	
	
		if (isset($params["nome"]))
		$select->where("u.ema_name like ? or u.ema_nickname like ?", '%'.$params["nome"].'%');
			    
	
		if (isset($params["ini"]) and isset($params["fim"]))
		{
			if (Zend_Validate::is($params["ini"], "Date", array("dd/MM/yyyy"))
					and Zend_Validate::is($params["fim"], "Date", array("dd/MM/yyyy")))
			{
				$dtIni = new Zend_Date($params["ini"] . " 00:00:00", "pt_BR");
				$dtIni = $dtIni->get(Zend_Date::ISO_8601);
					
				$dtFim = new Zend_Date($params["fim"] . " 23:59:59", "pt_BR");
				$dtFim = $dtFim->get(Zend_Date::ISO_8601);

				$select->where('u.ema_insertDate BETWEEN "'.$dtIni.'" AND "'.$dtFim.'"');
			}
		}

		    
		if (isset($params["confirmed"]))
		{
			$select->where('e.ema_confirmed = ?', $params["confirmed"]);
		}

		if (isset($params["search"])){
			$select->where("e.ema_userfrom like ?
					or e.ema_userto like ?
					or e.ema_emailfrom like ?
					or e.ema_emailto like ?
					or e.ema_cc like ?
					or e.ema_bcc like ?
					or e.ema_subject like ?
					or e.ema_body like ?", '%'.$params["search"].'%');
		}

		if($params["ema_id"]){
			$select->where('e.ema_id = ?', $params['ema_id']);
		}


		//  Zend_Debug::dump($select->__toString());

		if($limit || $offset)
			$select->limit($limit, $offset);

		/*	if (isset($params["orderby"]))
		 {
		switch ($params["orderby"]) {
		case 'n':
		$order = "ema_name";
		break;
		case 'd':
		$order = "ema_insertDate";
		break;
		}
		}

		if (isset($order)===false) $order = "ema_nickname";
		$select->order($order . " asc");*/

		// 	$select->group('e.ema_id');

		if(!$params['order']){
			$select->order("ema_senddate desc");
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
	 * Cria um novo email
	 * @param Array $post
	 * @return boolean
	*/	
	public function createEmail( $userData ){
		$row = $this->createRow();
		unset($userData["ema_id"]);
		
// 		die('eeee');
		
		if(!$userData["ema_confirmed"]){
			$userData["ema_confirmed"] = 0;
		}
		
		$data = array();
		foreach($userData as $key => $value){
			$data[$key] = $value;
		}
		

		$row->setFromArray($data);
		$row->save();
		$id = $row->ema_id;
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
		
		$row = $this->find($post["ema_id"])->current();

		if($post['ema_birthDate']){
			$dataNasc = explode("/",$post['ema_birthDate']);
			$userData["ema_birthYear"] = $dataNasc[2]; 
			$userData["ema_birthMonth"] = $dataNasc[1]; 
			$userData["ema_birthDay"] = $dataNasc[0];
			
			$birthDate = new Zend_Date(
				$userData["ema_birthYear"]."-".$userData["ema_birthMonth"]."-".$userData["ema_birthDay"],"YYYY-MM-DD"
			);
			$birthDateF = $birthDate->toString('YYYY-MM-dd');
		}
		
		$post['ema_birthDate'] = $birthDateF;
		$post['ema_celular'] = str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$post['ema_celular']))));
		$post['ema_telefone'] = str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$post['ema_telefone']))));
		$post['ema_comercial'] = str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$post['ema_comercial']))));

		$userData = array();
		foreach($post as $key => $value){
			$userData[$key] = $value;
		}
		
// 		$userData = array(  'ema_name'=>$post["ema_name"],
// 							'ema_birthDate'=>$birthDateF,
// 						    'cit_id'=>$post["cit_id"],
// 						    'ema_maritalStatus'=>$post["ema_maritalStatus"],
// 						    'ema_occupation'=>trim($post["ema_occupation"]),
// 							'ema_aboutme'=>$post["ema_aboutme"],
// 							'ema_passion'=>$post["ema_passion"],
// 							'ema_activity'=>$post["ema_activity"],
// 							'ema_music'=>$post["ema_music"],
// 							'ema_party'=>$post["ema_party"],
// 							'ema_orkut'=>$post["ema_orkut"],
// 							'ema_twiter'=>$post["ema_twiter"],
// 							'ema_facebook'=>$post["ema_facebook"],
// 							'ema_myspace'=>$post["ema_myspace"],
// 							'ema_msn'=>$post["ema_msn"],
// 							'ema_site'=>$post["ema_site"],
// 							'ema_hometown'=>$post["ema_hometown"],
// 							'ema_drinking'=>$post["ema_drinking"],
// 							'ema_drink'=>$post["ema_drink"],
// 							'ema_smoke'=>$post["ema_smoke"],
// 							'ema_celular'=>$post["ema_celular"],
// 							'ema_logradouro'=>$post[ema_logradouro],
// 							'ema_numero'=>$post[ema_numero],
// 							'ema_bairro'=>$post[ema_bairro],
// 							'ema_estado'=>$post[ema_estado],
// 							'ema_cidade'=>$post[ema_cidade],
// 							'ema_country'=>$post[ema_country],
// 							'ema_cidadenatal'=>$post[ema_cidadenatal],
// 							'ema_estadonatal'=>$post[ema_estadonatal],
// 							'ema_paisnatal'=>$post[ema_paisnatal],
// 							'ema_gender'=>$post[ema_gender],
// 							'ema_celular'=>$post[ema_celular],
// 							'ema_telefone'=>$post[ema_telefone],
// 							'ema_comercial'=>$post[ema_comercial],
// 							'ema_company'=>$post[ema_company],
// 							'ema_companyposition'=>$post[ema_companyposition],
// 							'ema_companycity'=>$post[ema_companycity],
// 							'ema_companydescription'=>$post[ema_companydescription],
// 							'ema_university'=>$post[ema_university],
// 							'ema_universityyear'=>$post[ema_universityyear],
// 							'ema_universitycurse'=>$post[ema_universitycurse],
// 							'ema_universitydegree'=>$post[ema_universitydegree],
// 							'ema_universitydescription'=>$post[ema_universitydescription],
// 							'ema_college'=>$post[ema_college],
// 							'ema_collegeyear'=>$post[ema_collegeyear],
// 							'ema_collegedescription'=>$post[ema_collegedescription],
// 							'ema_music'=>$post[ema_music],
// 							'ema_books'=>$post[ema_books],
// 							'ema_movies'=>$post[ema_movies],
// 							'ema_television'=>$post[ema_television],
// 							'ema_games'=>$post[ema_games],
// 							'ema_team'=>$post[ema_team],
// 							'codUsuarioAntigo'=>isset($post["codUsuarioAntigo"])? $post["codUsuarioAntigo"] : null);
		
// 		if($post["ema_status"]){
// 			$userData['ema_status'] = $post['ema_status'];
// 		}
		
// 		if($post[img_id]){
// 			$userData['img_id'] = $post[img_id];
// 		}
		
		$row->setFromArray($userData);

// 		if( isset($post["ema_activeKey"])){
// 			$row->ema_activeKey = $post["ema_activeKey"];
// 		}
// 		if( isset($post["ema_birthDate"])){
// 			$row->ema_birthDate = $post["ema_birthDate"];
// 		}
		// atualiza username na session
//		Zend_Auth::getInstance()->getIdentity()->ema_nickname = $post["ema_name"];
		
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
		                       array('u.ema_id'))
						->where("ema_activeKey = ?", $key)
		);

		$usrId = $confirKey->current()->ema_id;

		if(!empty($usrId)){
			$set = array(
			    'u.ema_id' => $usrId
			);
			
			$row = $this->find($usrId)->current();
			$row->ema_status = "1";
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
		->where("ema_email = ?", $email);

		if($deleted != null){
			$select->where('u.ema_deleted = '.$deleted );
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
		->where("ema_facebookid = ?", $facebook);
	
		if($deleted != null){
			$select->where('u.ema_deleted = '.$deleted );
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
		->where("ema_facebookid > 0");
	
		if($deleted != null){
			$select->where('u.ema_deleted = '.$deleted );
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

		$sql1 = 'select ema_id as idFriend from friend where ema_idFriend = '.$usrId;
		$sql2 = 'select ema_idFriend as idFriend from friend where ema_id = '.$usrId;
	
		$db = $this->getAdapter();
	
		/**
		 * Amigos que adicionaram o usuario $usrId
		 * @var Zend_Db_Sql
		 */
		$sql1 = $db->select()->from('friend', array('idFriend'=>'ema_id'))->where('ema_idFriend = ?', $usrId)->where('fri_status = 1');
	
		/**
		 * Amigos adicionados pelo usupário $usrId
		 * @var Zend_Db_Sql
		 */
		$sql2 = $db->select()->from('friend', array('idFriend'=>'ema_idFriend'))->where('ema_id = ?', $usrId)->where('fri_status = 1');
	
	
		$sqlUserFriends = $db->select()->union(array($sql1, $sql2));
	
		/**
		 * Obtendo os dados de todos os amigos do usuário $usrId
		 * @var Zend_Db_Sql
		 */
		$sql = $this->select()
		->from(array('u'=>'user'))
		->setIntegrityCheck(false)
		->join(array('uf'=>$sqlUserFriends), 'uf.idFriend = u.ema_id')
		->where("ema_facebookid > 0");
	
		$sql->where('u.ema_deleted = 0');
		
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
		$userData = array(  'ema_password'=>$nPasswd);
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
		->where("ema_nickname = ?", trim($login));
		if($deleted != null){
			$select->where('u.ema_deleted = '.$deleted);
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
					->where("ema_name like '%$name%'")
					->where('u.ema_deleted = 0');
		
		if($params[status] != ""){
			$select->where('ema_status = ?',$params[status]);
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
