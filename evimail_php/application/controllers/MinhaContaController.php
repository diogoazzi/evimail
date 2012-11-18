<?php

/**
 * Controller for table tb_anuncio
 *
 * @package Fet
 * @author Alvaro Batelli
 * @version 1.0
 *
 */
class MinhaContaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->userProfileHelper = $this->_helper->UserProfile;
    	$this->_helper->_acl->allow(null);
    	
    	$user = Zend_Auth::getInstance()->getIdentity();
    	
    	if(!$user){
    		$params = $this->getRequest()->getParams();
 
    		//tenta autenticar por activeKey
    		if(isset($params['activeKey']) && isset($params['usr_email'])){
    			if(!$this->identifyFromActiveKey($params['usr_email'], $params['activeKey']))
    				$this->_redirect('/');
    		}else
    			$this->_redirect('/');
    	}
    }

    public function indexAction()
    {

    }
    
    public function persistirAction(){
    
    	$POST = $this->getRequest()->getPost();
    
    	$translate = Zend_Registry::get('translate');
    
    	$auth = Zend_Auth::getInstance();
    	$identity = $auth->getIdentity();
    	if($identity){
    		$usr_id = $identity->usr_id;
    		if( $usr_id != "" ){
    			$POST["usr_id"] = $usr_id;
    		}
    	}
    
    	try
    	{
    		// validaçães do formulário
    
    		if( !isset($POST['usr_id'])){
    			if($POST["usr_password"] != $POST["usr_password2"] ){
    				throw new Exception($translate->_("A senha de confirmação não confere com a senha digitada").".");
    			}else if( $this->userProfileHelper->getUserByEmail($POST["usr_email"], null) ){
    				throw new Exception($translate->_("E-mail já cadastrado, tente outro").".");
    			}else if( $this->userProfileHelper->getUserByLogin($POST["usr_nickname"], null) ){
    				throw new Exception($translate->_("Usuário já cadastrado, tente outro").".");
    			}else if (!Zend_Validate::is($POST["usr_email"], "NotEmpty")) {
    				throw new Exception($translate->_("E-mail Obrigatório"));
    			}else if (!Zend_Validate::is($POST["usr_email"], "EmailAddress")) {
    				throw new Exception($translate->_("E-mail inválido"));
    			}else if (!Zend_Validate::is($POST["usr_password"], "NotEmpty")) {
    				throw new Exception($translate->_("Campo Senha é Obrigatório"));
    			} 
    		}
    
    		if (!Zend_Validate::is($POST["usr_name"], "NotEmpty")) {
    			throw new Exception($translate->_("Erro: Nome Obrigatório"));
    		}
    			
    		if( !isset($POST["usr_id"])){
    			$openPass = $POST["usr_password"];
    		}
    		$POST["usr_password"] = md5($POST["usr_password"]);

    			
    		// executa a inclusão ou alteração
    		$usrId = $this->userProfileHelper->persistUser($POST,true);
    			
    		if( empty($POST["usr_id"]) && $usrId){
    
    			$key = Zend_Registry::get('config')->key->active;
    			$data["key"] = md5($usrId.$key);
    
    			// atualiza a key
    			$POST["usr_id"] = $usrId;
    			$POST["usr_activeKey"] = $data["key"];
//     			$POST["insert"] = true;
    
    			$this->userProfileHelper->persistUser($POST, false);
    				
    			$this->view->assign("usr_mail",$POST["usr_email"]);
    
    			// envia e-mail
    			$data["url"] = "http://".$_SERVER["SERVER_NAME"];
    
    			$translate = Zend_Registry::get('translate');
    
    			$data["title"] = $translate->_("Evimail - Confirmação de Cadastro!");
    			$data["usuario"] = $POST["usr_name"];
    
    			$data["msg"] = ("
    	                <p>".$translate->_("Seu cadastro no Evimail foi efetuado com sucesso usando este endereço de email. Para começar a postar você precisa completar seu cadastro.")." </p>
    	                <br>
    	                <p>".$translate->_("Use o link abaixo para confirmar seu registro:")."</p>
    	                <a href='".$data["url"]."/active/".$data['key']."/l/".$_SESSION['language']."' class='link' style='color:#1155CC'>
    							".$data["url"]."/active/".$data['key']."
    					</a>
    	                <p>".$translate->_("Se você não realizou um registro no Evimail, por favor, desconsidere essa mensagem.")."</p>
    	                <p>".$translate->_("Se tiver alguma dúvida, entre em contato conosco pelo email abaixo:")."</p>
    	                <p>contato@evimail.com</p>
    	                <p>".$translate->_("Seus dados de acesso:")."</p>
    	                Login: ".$POST["usr_email"]." <br>
    					".$translate->_("Senha:")." ".$openPass."<br>
    	                <p><b>".$translate->_("Obrigado")."!</b><br/>
    	                ".$translate->_("Time do Evimail")."
    	                </p>
    				");
    
    			$this->_helper->InterMail->send($POST["usr_email"], $data["title"], "mail/confirmacao_cadastro.phtml", $data);
    				
    			$directoryUser = Fet_Controller_Helper_Location::getUserRepositoryLocalPath($usrId);
    			@mkdir($directoryUser, 0777, true);
    			@mkdir($directoryUser.DIRECTORY_SEPARATOR."pdfs", 0777, true);
    			@mkdir($directoryUser.DIRECTORY_SEPARATOR."avatar", 0777, true);
    			@mkdir($directoryUser.DIRECTORY_SEPARATOR."tmp", 0777, true);
    		}
    
    		Zend_Session::start();
    		$defaultNamespace = new Zend_Session_Namespace('signup');
    		$defaultNamespace->emailCadastrado = $POST["usr_email"];
    			
    		$aReturn = array("ok"=>"1");
    			
    	}catch( Exception $e ){
    
    		$aReturn = array("error" => $e->getMessage());
    
    	}
    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$this->getResponse()->clearBody();
    	$this->getResponse()->setBody(
    	Zend_Json::encode(
    	$aReturn
    	)
    	);
    }
    
    function contratarServicoAction() {
    	
    	
    }
    
    function alterarDadosAction() {
    	$auth = Zend_Auth::getInstance();
    	$identity = $auth->getIdentity();
    	

    	
    	$birthDate = new Zend_Date($identity->usr_birthDate,"YYYY-MM-DD");
    	$birthDateF = $birthDate->toString('dd/MM/YYYY');
    	
    	$identity->usr_birthDateFormatado = $birthDateF;
    	
//     	get_class($identity);
//     	echo '<pre>';
//     	print_r($identity);
//     	die();
    	$this->view->assign("user",$identity);
// 		echo '<pre>';
// 		print_r($identity);
//     	if(!$identity){
    		
//     	}
    }
    
    function visualizaLaudoAction(){

    	$params = $this->getRequest()->getParams();
    	$emailTable = new Fet_Model_EmailTable();
    	
    	$email = $emailTable->find($params['ema_id'])->current();
    	
    	$Date = new Zend_Date($email->ema_senddate,"YYYY-MM-DD HH:mm:ss");
    	$DateF = $Date->toString('dd/MM/YYYY HH:mm:ss');
    	 
    	$email->ema_DateFormatado = $DateF;
    	
    	$this->view->assign('email', $email);
    	
    	$auth = Zend_Auth::getInstance();
    	$user = $auth->getIdentity();
    	
//     	echo '<pre>';
//     	print_r($user);
//     	die();
    	$this->view->assign('user', $user);
    	
    	
    	$this->view->assign('menu', 'laudo');
    	
    }
    
    
    public function identifyFromActiveKey($email, $key)
    {
    	$translate = Zend_Registry::get('translate');
    
    	$formData['txtLoginEmail'] = $email;
    	$formData['key'] = $key;
    		
    	if (empty($key)) {
    		return false;
    	} else {
    
    		$authAdapter = $this->_getAuthAdapterActiveKey($formData);
    		$auth = Zend_Auth::getInstance();
    		$result = $auth->authenticate($authAdapter);
    
    		if (!$result->isValid()) {
    			$this->_flashMessage('Login failed');
    			return false;
    		} else {
    			// success: store database row to auth's storage
    			// (Not the password though!)
    			$data = $authAdapter->getResultRowObject(null,
    					'pwdLoginSenha');
    			
    			$data->role = 'member';
    
    			$user = new Fet_Model_UserTable();
    			$user = $user->find($data->usr_id)->current();
    			$auth->getStorage()->write($data);

    			return true;
    		}
    	}
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

    
    public function gerarPdfAction(){
    	$POST = $this->getRequest()->getPost();
    	echo '<pre>';
    	print_r($POST);
    	die(); 	
    }

    
    public function consultarHistoricoAction(){
    	
    }
}
