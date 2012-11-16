<?php

class AuthController extends Zend_Controller_Action
{
	
	public function init(){

		$this->_helper->_acl->allow(null); // todos acessam tudo
		
		$this->_helper->ajaxContext
			->addActionContext('identify', array('html', 'json'))
		    ->addActionContext('verify-by-facebook', array('json'))
			->initContext();
		
		//$this->userProfileHelper = $this->_helper->UserProfile;
	}
	
	/**
	 * The default action - show the home page
	 */
	public function indexAction()
	{
		// TODO Auto-generated AuthController::indexAction() default action
	}

	public function activeAction()
	{
		$key = $this->getRequest()->getParam("keyActive");
		$l = $this->getRequest()->getParam("language");		
		
		$result = $this->_helper->UserProfile->activeUser($key);
		
		if( !$result ){
			
			die("Chave de ativação inexistente. <a href='/'>Clique Aqui</a> para voltar");
			
		}else{
			$translate = Zend_Registry::get('translate');
				
			$this->view->assign("msg","<a href='/'>".$translate->_("Sua conta foi ativada com sucesso! Clique aqui e faça o seu login").".</a>");
			$this->identifyFromActiveKey($result->usr_email,$key);
			//$this->_redirect('/dial/create?l='.$l);
			$this->_redirect('/minha-conta?l='.$l);
		}
		
	}
	
	public function identifyKeyAction()
	{
		$key = $this->getRequest()->getParam("keyActive");
		
		$translate = Zend_Registry::get('translate');
	
		$result = $this->_helper->UserProfile->activeUser($key);
		
		$this->identifyFromActiveKey($result->usr_email,$key);
		
		$this->_redirect('/');
	}
	
	public function esqueciAction(){
		
		$flashMessenger = $this->_helper->FlashMessenger;
	    $flashMessenger->setNamespace('actionErrors');
	    $this->view->actionErrors = $flashMessenger->getMessages();
		
		$this->view->hideLogin = true;
	}
	
	public function reenviasenhaAction(){
		
		$email = $this->getRequest()->getParam("email");
		
		$passwd = $this->_helper->UserProfile->generatePassword();
		
		$return = $this->_helper->UserProfile->getNewPassword($email, $passwd);
		
		$translate = Zend_Registry::get('translate');
		
		if( $return ){
			$data["url"] = "http://".$_SERVER["SERVER_NAME"];
			$data["title"] = $translate->_("Esqueci minha senha - Evimail");
			/*$data["msg"] = ("
			".$translate->_("Olá").", 
			
			".$translate->_("Você informou ter esquecido sua senha no Evimail e estamos enviando uma nova senha para você")."<br>
			<br>
			".$translate->_("Seu usuário é").": <br><b>".$return->usr_nickname."</b><br>
			".$translate->_("Sua nova senha é").": <br><b>".$passwd."</b><br>
			<br>
			".$translate->_("Se tiver alguma dúvida, entre em contato conosco pelo email abaixo").":<br>
			<br>
			contato@evimail.com.br<br>
			");*/
			$data['usr_name'] = $return->usr_name;
			$data['usr_nickname'] = $return->usr_nickname;
			$data['passwd'] = $passwd;
			
			$this->_helper->InterMail->send($return->usr_email, $translate->_("Esqueci minha senha - Evimail"), "mail/esqueci-senha.phtml", $data);
			
			$this->_flashMessage($message = $translate->_("Nova senha enviada com sucesso para")." $email");
			
			$this->_redirect('/');
			
		}else{
			
			$this->_flashMessage($message = $translate->_(utf8_decode("Nome de Usuário ou e-mail inválidos")));
			$this->_redirect('/auth/esqueci');
						
		}
		
	}
	
	

	/**
	 * The default action - show the home page
	 */
	public function logoutAction()
	{
		$usr_id = Zend_Auth::getInstance()->getIdentity()->usr_id;
		
		if($usr_id){
/* 			$user = new Community_Model_UserTable();
			$user = $user->find($usr_id)->current();

			$user->usr_online = '0';
			$user->save();
 */			
			Zend_Auth::getInstance()->clearIdentity();
		}
		
		session_destroy();

		$this->_redirect('/');
	}
	
	
	/**
	 * Cria um novo Usuario
	 * @param Array $post
	 * @return boolean
	*/	
	public function identifyAction()
	{
		if ($this->getRequest()->isPost()) {

			$translate = Zend_Registry::get('translate');			
			
			// collect the data from the user
			$formData = $this->_getFormData();

			if (empty($formData['txtLoginEmail']) || empty($formData['pwdLoginSenha'])) {

				$this->_flashMessage($message = $translate->_("Campos login e senha obrigatórios"));
				$redirect = $this->view->baseUrl();
			} else {
				
				// do the authentication
				$authAdapter = $this->_getAuthAdapter($formData, 'usr_email');

				$auth = Zend_Auth::getInstance();
				$result = $auth->authenticate($authAdapter);
				/*if (!$result->isValid()) {
					$authAdapter = $this->_getAuthAdapter($formData, 'usr_nickname');
					$result = $auth->authenticate($authAdapter);
				}*/

				if (!$result->isValid()) {
					$this->_flashMessage($message = $translate->_("Login ou senha inválidos"));
					$redirect = $this->view->baseUrl('/auth');	
				} else {
					$data = $authAdapter->getResultRowObject(null,
                                'pwdLoginSenha');
					//$_SESSION['username'] = str_replace(" ","_",$data->usr_nickname);
					
					if( $data->fl_ativo == "N" /*or $data->usr_deleted == 1*/){
						Zend_Auth::getInstance()->clearIdentity();
						$this->_flashMessage($message = $translate->_("Seu cadastro ainda não foi ativado, verifique seu e-mail e ative sua conta"));
						$redirect = $this->view->baseUrl();
						//exit;
					}
					else{
						$user = new Fet_Model_UserTable();
						$user = $user->find($data->usr_id)->current();
						
						/*if($userImage = $user->getUserImage()): 
					    	$thumb = $userImage->getThumbnailUrl(); 
					    else: 
					    	$thumb = $this->view->baseUrl('/img/avatar_borderless.gif'); 
					    endif;
					    
					    $data->thumb = $thumb;*/

						$data->role = 'member';
					    
					    $auth->getStorage()->write($data);

						//$user->usr_online = '1';
						//$user->save();
						
						$loginRedirect = $this->getRequest()->getParam('loginRedirect', '');
						$redirect = ($loginRedirect=='')? $this->view->baseUrl('/minha-conta') : $loginRedirect;
					}	
				}
			}

			
			if($this->getRequest()->isXmlHttpRequest())
			{
				$this->_helper->ajaxContext->initContext('json');
				if(Zend_Auth::getInstance()->getIdentity()->usr_id && Zend_Auth::getInstance()->getIdentity()->usr_status == "1")
				{
					$this->view->success = true;
					$this->view->message = $message;
					$this->view->redirect = $redirect;
				}else{
					$this->view->success = false;
					$this->view->error = $message;
				}
			}else{
				$this->_redirect($redirect);
			}
			
		}
	}	
	
	public function identifyFromActiveKey($email, $key)
	{
		$translate = Zend_Registry::get('translate');
		
		$formData['txtLoginEmail'] = $email;
		$formData['key'] = $key;
		 
		if (empty($key)) {
			$this->_flashMessage($translate->_("Por favor, forneça a chave de ativacao."));
		} else {
			 
			$authAdapter = $this->_getAuthAdapterActiveKey($formData);
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($authAdapter);

			if (!$result->isValid()) {
				$this->_flashMessage('Login failed');
			} else {
				// success: store database row to auth's storage
				// (Not the password though!)
				$data = $authAdapter->getResultRowObject(null,
                                'pwdLoginSenha');
				
				$user = new Fet_Model_UserTable();
				$user = $user->find($data->usr_id)->current();
						
				/*if($userImage = $user->getUserImage()): 
				    	$thumb = $userImage->getThumbnailUrl(); 
			        else: 
				    	$thumb = $this->view->baseUrl('/img/avatar_borderless.gif'); 
			        endif;

				$data->thumb = $thumb;
				*/
				
				$auth->getStorage()->write($data);
			}
		}
	}
	
	public function signupFacebookAction()
	{
		$params = $this->getRequest()->getParams();
		
		print_r($params);die;
	}
	
	/**
	 * Retrieve the login form data from _POST
	 *
	 * @return array
	 */
	protected function _getFormData()
	{
		$data = array();
		$filterChain = new Zend_Filter;
		$filterChain->addFilter(new Zend_Filter_StripTags);
		$filterChain->addFilter(new Zend_Filter_StringTrim);

		$data['txtLoginEmail'] = $filterChain->filter(
		$this->getRequest()->getPost('txtLoginEmail'));
		$data['pwdLoginSenha'] = $filterChain->filter(
		$this->getRequest()->getPost('pwdLoginSenha'));

		return $data;
	}
	

	/**
	 * Set up the auth adapater for interaction with the database
	 *
	 * @return Zend_Auth_Adapter_DbTable
	*/
	protected function _getAuthAdapter($formData, $identifyColumn='email')
	{
		
		//$dbAdapter = Zend_Registry::get('db_adapter_fet');
		$authAdapter = new Zend_Auth_Adapter_DbTable();
		$authAdapter->setTableName('user')
		->setIdentityColumn($identifyColumn)
		->setCredentialColumn('usr_password')
		->setCredentialTreatment('?');

		$password = $formData['pwdLoginSenha'];

		//echo "a".$formData['txtLoginEmail']."b - c".md5($password)."d"; exit;

		$authAdapter->setIdentity(trim(trim($formData['txtLoginEmail'])));
		$authAdapter->setCredential(trim(md5($password)));
		//print_r($authAdapter); exit;
		return $authAdapter;
		
	}
	
/**
	 * Set up the auth adapater for interaction with the database
	 *
	 * @return Zend_Auth_Adapter_DbTable
	*/
	protected function _getAuthAdapterActiveKey($formData, $identifyColumn='usr_email')
	{
		
		//$dbAdapter = Zend_Registry::get('db_adapter_comunidade');
		$authAdapter = new Zend_Auth_Adapter_DbTable();
		$authAdapter->setTableName('user')
		->setIdentityColumn($identifyColumn)
		->setCredentialColumn('usr_activeKey')
		->setCredentialTreatment('?');

		$password = $formData['key'];

		//echo "a".$formData['txtLoginEmail']."b - c".md5($password)."d"; exit;

		$authAdapter->setIdentity(trim(trim($formData['txtLoginEmail'])));
		$authAdapter->setCredential(trim($password));
		//print_r($authAdapter); exit;
		return $authAdapter;
		
	}
	
    protected function _flashMessage($message) {

    	$flashMessenger = $this->_helper->FlashMessenger;
        $flashMessenger->setNamespace('actionErrors');
        $flashMessenger->addMessage($message);

    }
    
    public function verifyByFacebookAction()
    {
    	define('FACEBOOK_APP_ID', '459079204132419');
    	define('FACEBOOK_SECRET', 'd97670c5830c7ef6d034c745e9405d92');
    	 
    	$user = $this->getRequest()->getParam('user');
    	$authResponse = $this->getRequest()->getParam('authResponse');
    	$facebookId = $user['id'];
    	
    	$translate = Zend_Registry::get('translate');
    	 
    	$userF = $this->userProfileHelper->getUserByFacebookId($facebookId, null);    	

    	$passwd = $this->_helper->UserProfile->generatePassword();
    	$this->view->pass = $passwd;
    	
    	if(!$userF){
    		if(!$user['username']){
    		 	$nick = explode('@',$user['email']);
    			$user['username'] = $nick[0];
    		}
    		$userNickname = $this->userProfileHelper->getUserByLogin($user['username'], null);
    		if(!$userNickname){
	        	$userEmail = $this->userProfileHelper->getUserByEmail($user['email'], null);
	        	
	    		if(!$userEmail){
	    			$POST["facebookId"] = $user['id'];
	    			$POST["facebookToken"] = $authResponse['accessToken'];
	    			
	    			$birth = explode("/",$user['birthday']);
	    			$POST["usr_birthYear"] = $birth[2];
	    			$POST["usr_birthMonth"] = $birth[1];
	    			$POST["usr_birthDay"] = $birth[0];
	    			
	    			$POST["usr_name"] = $user['first_name']." ".$user['last_name'];
	    			$POST["usr_email"] = $user['email'];
					$POST["usr_password"] = MD5($passwd);
					if($user[gender]=="male"){
						$gender = "M";
					} else {
						$gender = "F";
					}
	    			$POST["usr_gender"] = $gender;
	    			$POST["usr_nickname"] = $user['username'];
	    			// nickname e email disponíveis, cria conta de usuário
	    			$usrId = $this->userProfileHelper->persistUser($POST);
	    			
	    			if( empty($POST["usr_id"]) && $usrId){
	    			
	    				$key = Zend_Registry::get('config')->key->active;
	    				$data["key"] = md5($usrId.$key);
	    				
	    				// atualiza a key
	    				$POST["usr_id"] = $usrId;
	    				$POST["usr_activeKey"] = $data["key"];
	    				$POST["usr_status"] = 1;
	    				$POST["insert"] = true;
	    				
	    				$this->userProfileHelper->persistUser($POST);
	    				
	    				$directoryUser = Community_Controller_Action_Helper_Location::getUserRepositoryLocalPath($usrId);
	    				@mkdir($directoryUser, 0777, true);
	    				@mkdir($directoryUser.DIRECTORY_SEPARATOR."albums", 0777, true);
	    				@mkdir($directoryUser.DIRECTORY_SEPARATOR."avatar", 0777, true);
	    				@mkdir($directoryUser.DIRECTORY_SEPARATOR."tmp", 0777, true);
	    				
	    				$collabInvites = new Community_Model_CollaboratorInviteTable();
	    				$collabInvites = $collabInvites->findByEmail($POST['usr_email']);
	    				if(count($collabInvites)>0){
	    					$collab = $collabInvites->current();
	    					$collabData['usr_id'] = $usrId;
	    					$collabData['dia_id']= $collab->dia_id;
	    					$collabData['col_status']= 1;
	    					$collabTable = new Community_Model_CollaboratorTable();
	    					$col_id = $collabTable->createCollaborator($collabData);
	    				}

	    				// envia e-mail
	    				$data["url"] = "http://".$_SERVER["SERVER_NAME"];
	    				
	    				$translate = Zend_Registry::get('translate');
	    				
	    				$data["title"] = $translate->_("Bem Vindo ao TheDial.me!");
	    				
	    				$data["msg"] = ("
	    									<h2>".$translate->_("Olá")." ".$POST["usr_name"]."</h2>
	    					                <p>".$translate->_("Seu cadastro no TheDial foi efetuado com sucesso usando este endereço de email obtido através de sua autenticação com dados do Facebook.")." </p>
	    					                <br>
	    					                <p>".$translate->_("Os dados de acesso abaixo foram gerados para que você possa entrar no TheDial")."</p>
	    					                <p>".$translate->_("Seus dados de acesso:")."</p>
	    					                Login: ".$POST["usr_email"]." <br>
	    									".$translate->_("Senha:")." ".$passwd."<br>
	    					                <p>".$translate->_("Se você não realizou um registro no TheDial.me, por favor, desconsidere essa mensagem.")."</p>
	    					                <p>".$translate->_("Se tiver alguma dúvida, entre em contato conosco pelo email abaixo:")."</p>
	    					                <p>contato@thedial.me</p>
	    					                <p><b>".$translate->_("Obrigado")."!</b><br/>
	    					                ".$translate->_("Time do TheDial")."
	    					                </p>
	    								");
	    				
	    				$this->_helper->InterMail->send($POST["usr_email"], $data["title"], "mail/mail_template.phtml", $data);
	    				 
	    				$this->identifyFromActiveKey($POST['usr_email'],$POST["usr_activeKey"]);
	    				$this->view->usr_activeKey = $POST["usr_activeKey"];
	    			}
	    				
	    		} else {
	    			// email já cadastrado, retorna para cadastro com dados preenchidos
	    			$this->view->msg = $translate->_("E-mail já cadastrado, tente outro");
	    			$this->view->erro = 'email';
	    			$this->view->facebookUser = $user;
	    		}
    		} else {
    			$this->view->msg = $translate->_("Usuário já cadastrado, tente outro");
    			$this->view->erro = 'nickname';
    			$this->view->facebookUser = $user;
    		}
    		/*} else {
    		 // nickname já cadastrado, retorna para cadastro com dados preenchidos
    		$this->view->erro = 'nickname';
    		$this->view->facebookUser = $user;
    		}*/
    	} else {
    		// usuario já cadastrado com a conta facebook
    		$this->view->temFacebook = true;
    		$this->view->usr_activeKey = $userF->usr_activeKey;
    	}
    }
    
	
}
?>
