<?php

class Fet_Controller_Helper_EmailProfile extends Zend_Controller_Action_Helper_Abstract{
	
	/**
	 * Realiza o cadastro do profile no banco de dados
	 * @param $name
	 * @return boolen
	*/
	public function persistEmail( $post, $insert = false, $log = true ){
		
		$userTable = new Fet_Model_EmailTable();

		if( empty($post["usr_id"]) ){
			$usrId = $userTable->createUser($post);
			return $usrId;
		}else{
			$data = $userTable->find($post["usr_id"])->current();
			
// 			if(isset($post['fileAvatar50name'])){
// 				$post['img_id'] = $this->createProfileImage($post);
// 			}
			
			$userTable->updateUser($post);
			
			//pra que este if,  jah tem empty$post[usr_id]
			if(!$insert){
				$auth = Zend_Auth::getInstance();
				$data = $auth->getIdentity();
				$user = $userTable->find($post["usr_id"])->current();
				
				if($userImage = $user->getUserImage()):
					$thumb = $userImage->getThumbnailUrl();
				else:
					$thumb = '/img/bgImgDial.gif';
				endif;
				
				$data->thumb = $thumb;
				
				$auth->getStorage()->clear();
				$auth->getStorage()->write($data);
			}
			
			return $post["usr_id"];
		}
	}
	
	public function createProfileImage($post){
		$album = new Community_Controller_Action_Helper_UserAlbum();
	
		$myAlbum = $album->getProfileAlbumByUserId($post['usr_id'], true)->current();
	
		if($myAlbum){
			$albId = $myAlbum->alb_id;
		} else {
			$albumUri = $album->generateAlbumUri($post['usr_id']);
			$albumArray = $album->saveAlbum($albumUri,
			$post['usr_id'],
			null,
			null,
										   "Fotos do Perfil", 
										   "Fotos do Perfil",
			null,
			null,
			null,
			null,
			'P'
			);
			$albId = $albumArray['alb_id'];
		}
	
		$paramsPhoto['alb_id'] = $albId;
		$paramsPhoto['pho_title'] = $post['dia_name'];
		$paramsPhoto['pho_description'] = $post['dia_name'];
		$paramsPhoto['pho_extension'] = end(explode('.', $post['fileAvatar50name']));
		$photo = $album->addPhoto($paramsPhoto);
	
		$post['img_id'] = $photo['pho_id'];
	
		$dir = Community_Controller_Action_Helper_Location::getUserAlbumLocalPath($post['usr_id'], $albId);
		@mkdir($dir, 0777, true);
		@mkdir($dir.DIRECTORY_SEPARATOR."thumbs", 0777, true);
		@mkdir($dir.DIRECTORY_SEPARATOR."thumbs".DIRECTORY_SEPARATOR."thumb", 0777, true);
		
		copy(Community_Controller_Action_Helper_Location::getUserTempLocalPath($post['usr_id'])."/".$post['fileAvatar50name'],
		Community_Controller_Action_Helper_Location::getUserAlbumThumbLocalPath($post['usr_id'], $albId).$photo['pho_uri']);
	
		return $post['img_id'];
	}

	public function persistPassword( $post, $log = true ){
	
		$userTable = new Community_Model_UserTable();
	
		if( empty($post["usr_id"]) ){
			$usrId = $userTable->createUser($post);
			return $usrId;
		}else{
			$data = $userTable->find($post["usr_id"])->current();
				
// 			if($_SESSION['fileAvatar50name']){
// 				$post[img_id] = $this->createProfileImage($post);
// 			}
				
			$userTable->updateUser($post);
				
			if ($log===true)
			{
				$changedFields = $this->getChangedFields( $data, $post);
				//$this->_log[] = array('actionId'=>UserAction::ALTERAR_PROFILE_ACTION_ID, 'actionDescription'=>$changedFields, 'usrId' => $post["usr_id"]);
			}
				
			return $post["usr_id"];
		}
	}
	
	
	
	/**
	 * Obtem um objeto User_Table a partir do e-mail do usuário
	 * @param $email
	 * @return Zend_Db_Table_Row
	 */
	public function getUserByEmail( $email , $deleted = 0){
		$userTable = new Fet_Model_UserTable();
		return $userTable->getUserByEmail( $email , $deleted);
		
	}
	
	public function getUserByFacebookId( $email , $deleted = 0){
		$userTable = new Community_Model_UserTable();
		return $userTable->getUserByFacebookId( $email , $deleted);
	
	}
	

	/**
	 * Obtem um objeto User_Table a partir do login do usuário
	 * @param $email
	 * @return Zend_Db_Table_Row
	 */
	public function getUserByLogin( $login , $deleted = 0){
		$userTable = new Fet_Model_UserTable();
		return $userTable->getUserByLogin( $login , $deleted);
	}
	
	public function getUser($usrId)
	{
		$userTable = new Community_Model_UserTable();
		return $userTable->getAllUsers(array('usr_id'=>$usrId),true)->current();
	}
	
	/**
	* Adiciona amigo à lista de amigos de um determinado usuario
	* @param $usrId Usuario para o qual será adicionado o amigo
	* @param $friendId Amigo a ser adicionado na lista de amigos do usuário
	* @return unknown_type
	*/
	public function addFriend($usrId, $friendId, $sendMail = true)
	{
		$friend = new Community_Model_FriendTable();
		$friend->addFriend($usrId, $friendId);
		/*
			if ($sendMail!==false)
		$this->_helper->InterMail->send($POST["usr_email"], "Cadastro Realizado", "mail/mail_template.phtml", $data);
		*/
	}
	
	/**
	* Retorna o status da amizade, caso o tenha.
	* @param $usrId Usuario principal (logado)
	* @param $friendId Amigo do
	* @return unknown_type
	*/
	public function getStatusFriend($usrId, $friendId)
	{
		$friend = new Community_Model_FriendTable();
		return $friend->getStatusFriend($usrId, $friendId);
	}

	/**
	* Exclui uma amizade
	* @param $usrId Usuario principal
	* @param $friendId Amigo do usuario
	* @return unknown_type
	*/
	public function deleteFriend($usrId, $friendId)
	{
		$friend = new Community_Model_FriendTable();
		$friend->deleteFriend($usrId, $friendId);
		return;
	}
	
	/**
	* Confirma a solicitação de amizade
	* @param $usrId Usuario principal
	* @param $friendId Amigo do usuario
	* @return unknown_type
	*/
	public function confirmFriend($usrId, $friendId)
	{

		$friend = new Community_Model_FriendTable();
		$friend->confirmFriend($usrId, $friendId);
		return;
	
	}
	
	
	public function generatePassword($length=8, $strength=0) {
		
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
	
	public function getNewPassword( $email, $passwd ){
		
		$userTable = new Fet_Model_UserTable();
		
		$userData = $userTable->getUserByEmail( $email );

		if( !empty($userData) ){
			
			if($userData->usr_status!=1){
				return false;
			}
			
			$data["url"] = APPLICATION_URL;

			$userTable->updatePasswd( $userData->usr_id, md5($passwd) );
			
			return $userData;
			
		}else{
			
			$userData = $userTable->getUserByLogin($email );
			
			if( !empty($userData) ){
				if($userData->usr_status!=1){
					return false;
				}
				$data["url"] = APPLICATION_URL;
	
				$userTable->updatePasswd( $userData->usr_id, md5($passwd) );
				
				return $userData;
				
			}else{
				return false;
			}
		}
	}
	
	/**
	 * Ativa o profile no banco de dados
	 * @param $name
	 * @return boolen
	*/
	public function activeUser( $key ){

		$userTable = new Fet_Model_UserTable();
		
		if( !empty($key) ){
			return $userTable->activeUser($key);
		}else{
			return false;
		}
		
	}

	/**
	* Ativa o profile no banco de dados
	* @param $name
	* @return boolen
	*/
	public function activeCollaborator( $key ){
	
		$userTable = new Community_Model_CollaboratorTable();
	
		if( !empty($key) ){
			return $userTable->activeCollaborator($key);
		}else{
			return false;
		}
	
	}
	
	/**
	 * Retorna os campos da tabela profile que foram alterados pelo usuário.
	 * @param User $table
	 * @param array
	 * @return String
	 */
	protected function getChangedFields( $table, $post )
	{
		$columns = $table->toArray();
		
		foreach($columns as $key=>$value)
		{
			if(key_exists($key, $columns))
			{
				$postedData[$key] = $post[$key];	
			}
			 
		}

		$alteracoes = array_diff_assoc($postedData, $columns);
		
		foreach($alteracoes as $key=>$value)
		{
			if( $this->getLabelAlteracao($key) != "" ){
				$dataChanged .= "Alterou ".$this->getLabelAlteracao($key)." para: ".$this->getValue($key, $value)."<br>";
			}	
		}
		
		return $dataChanged;
		
	}
	
	protected function getValue($key, $value)
	{
		switch($key){
			case 'usr_maritalStatus':
			    
			    switch ($value) {
			    	case "1":
			    	    return "Solteiro(a)";
			    	break;
			    	
			    	case "2":
			    	    return "Namorando";
			    	break;
			    	
			    	case "3":
			    	    return "Casado(a)";
			    	break;
			    	
			    	case "4":
			    	    return "Enrolado(a)";
			    	break;

			    	default:
			    		return "";
			    	break;
			    }

				break;
			case 'usr_smoke':
			    return ($value=='1')? 'Sim' : 'Não';
			case 'usr_drink':
			    return ($value=='1')? 'Sim' : 'Não';
			default:
			    return $value;
		}
	}
	
	protected function getLabelAlteracao($tableField)
	{
		
		switch($tableField){
			case 'usr_nickname':
				return 'Apelido ';
				break;
			case 'usr_aboutme':
				return 'Quem Sou ';
				break;
			case 'usr_passion':
				return 'Paixões ';
				break;
			case 'usr_activity':
				return 'Atividades ';
				break;
			case 'usr_music':
				return 'Músicas ';
				break;
			case 'usr_party':
				return 'Balada ';
				break;
			case 'usr_smoke':
				return 'Fumo ';
				break;
			case 'usr_drink':
				return 'Bebo ';
				break;
			case 'usr_site':
				return 'Página da web ';
				break;
			case 'usr_orkut':
				return 'Orkut ';
				break;
			case 'usr_facebook':
				return 'Facebook ';
				break;
			case 'usr_myspace':
				return 'MySpace ';
				break;
			case 'usr_name':
				return 'Nome ';
				break;
			case 'usr_occupation':
				return 'Profissão ';
				break;
			case 'usr_celular':
				return 'Celular ';
				break;
			case 'usr_maritalStatus':
				return 'Relacionamento ';
				break;
		}
	}
	
	public function getTempDirectory($usrId)
	{
	    $directoryTempUser = Community_Controller_Action_Helper_Location::getUserTempLocalPath($usrId);

		if (!file_exists($directoryTempUser))
		{
            mkdir($directoryTempUser, 755, true);
		}
		
		return $directoryTempUser;
	}
	
	public function getAllUsersCheckFriendsPaginator( $usr_id=null, $params=array(), $fetchResult=false, $limit=null ){
	
		$userTable = new Community_Model_UserTable();
	
		if($usr_id){
			$users = $userTable->getAllUsersCheckFriends($usr_id, $params, true, $limit);
		} else {
			$users = $userTable->getAllUsers( $params, true, $limit );
		}
	
		$paginatorAdapter = new Zend_Paginator_Adapter_Iterator($users);
	
		$paginator = new Zend_Paginator($paginatorAdapter);
	
		$paginator->setItemCountPerPage(10)
		->setCurrentPageNumber($params['page']);
		return $paginator;
	
	}

	public function deleteUsers($usrId){
		
		$userTable = new Community_Model_UserTable();
		
		$row = $userTable->find($usrId)->current();
		
		$row->usr_deleted = 1;
		$row->save();
	}	
}
