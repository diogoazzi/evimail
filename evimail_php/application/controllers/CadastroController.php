<?php

/**
 * Controller for table tb_anuncio
 *
 * @package Fet
 * @author Alvaro Batelli
 * @version 1.0
 *
 */
class CadastroController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->userProfileHelper = $this->_helper->UserProfile;
    	$this->_helper->_acl->allow(null);
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
    		unset($POST['usr_password2']);
    			
    		// executa a inclusão ou alteração
    		$usrId = $this->userProfileHelper->persistUser($POST);
    			
    		if( empty($POST["usr_id"]) && $usrId){
    
    			$key = Zend_Registry::get('config')->key->active;
    			$data["key"] = md5($usrId.$key);
    
    			// atualiza a key
    			$POST["usr_id"] = $usrId;
    			$POST["usr_activeKey"] = $data["key"];
    			$POST["insert"] = true;
    
    			$this->userProfileHelper->persistUser($POST);
    				
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
    
}