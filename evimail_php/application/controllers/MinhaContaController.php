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
		 
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		$this->view->assign('user', $user);
		 
		 
		$creditTable = new Fet_Model_CreditTable();
		$data = array ('usr_id' => $user->usr_id ,'order' => 'cre_date desc', 'payed' => Fet_Model_CreditTable::CREDITO_PAGO);
		$credits = $creditTable->getAllCredits($data, true);
		 
		if(count($credits) > 0) {
			$lastTrans = $credits[0];
			 
			$date_obj = new Zend_Date(trim($lastTrans->cre_date),"YYYY-MM-dd HH:mm:ss");
			$date = $date_obj->toString('dd/MM/YYYY');
			$lastTrans->cre_date_formatado = $date;
			$this->view->assign('lastTrans', $lastTrans);
			 
			$totalCredito = $creditTable->getTotalCreditosDisponiveis($user->usr_id);
			$this->view->assign('totalCredits', $totalCredito);
		} else {
			$this->view->assign('totalCredits', 0);
		}
		 
		$emailTable = new Fet_Model_EmailTable();
		$data = array('ema_usr_id' => $user->usr_id, 'confirmed' => Fet_Model_EmailTable::EMAIL_ENVIADO_DEBITADO);
		$emails = $emailTable->getAllEmail($data, true);
		$total_enviado = count($emails);
		$this->view->assign('totalEmailEnviado', $total_enviado);

		$data = array('ema_usr_id' => $user->usr_id, 'confirmed' => Fet_Model_EmailTable::EMAIL_NAO_ENVIADO);
		$emails = $emailTable->getAllEmail($data, true);
		$total_nao_enviado = count($emails);
		$this->view->assign('totalEmailNaoEnviado', $total_nao_enviado);

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
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		$this->view->assign('user', $user);
		
		$params =$this->getRequest()->getParams();
		
		if(isset($params['ema_id']))
			$this->view->assign('ema_id', $params['ema_id']);
		 
		$creditTable = new Fet_Model_CreditTable();
		 
		if($creditTable->jaContratou($user->usr_id) > 0 )
			$this->view->assign('jaContratou', true);
		else
			$this->view->assign('jaContratou', false);
		 
	}

	public function pagarServicoAction(){
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		 
		$creditTable = new Fet_Model_CreditTable();
		 
		 
		 
		// CONSTANTES
		define('VERSAO', "1.1.0");
		define("ENDERECO_BASE", "https://qasecommerce.cielo.com.br");
		define("ENDERECO", ENDERECO_BASE."/servicos/ecommwsec.do");
		 
		define("LOJA", "1006993069");
		define("LOJA_CHAVE", "25fbb99741c739dd84d7b06ec78c9bac718838630f30b112d033ce2e621b34f3");
		define("CIELO", "1001734898");
		define("CIELO_CHAVE", "e84827130b9837473681c2787007da5914d6359947015a5cdb2b8843db0fa832");
		 
		$Pedido = new Fet_Controller_Helper_PedidoProfile();
		$post =  $this->getRequest()->getPost();
		 
		 
		//TODO: enviar estes parametros pra pagina
		//     	$post['codigoBandeira'] = 'visa';
		//     	$post["formaPagamento"] = 'A';
		 
		 
		$post["capturarAutomaticamente"] = true;
		 
		//     	print_r($post);
		 
		switch ($post['plano']){
			case '1':
				$post['produto'] = 2000;
				break;
			case '2':
				$post['produto'] = 4000;
				break;
			case '3':
				$post['produto'] = 7000;
				break;
			case '4':
				$post['produto'] = 10000;
				break;
			case '5':
				$post['produto'] = 10000;
				break;
			case '6':
				$post['produto'] = 15000;
				break;
			case '7':
				$post['produto'] = 25000;
				break;
			case '8':
				$post['produto'] = 50000;
				break;
			default:
				throw new Exception("Plano nao selecionado.");
		}
		 
		// L� dados do $post
		$Pedido->formaPagamentoBandeira = $post["codigoBandeira"];
		if($post["formaPagamento"] == "A")
		{
			$Pedido->formaPagamentoProduto = 'A'; //debito
			$Pedido->formaPagamentoParcelas = 1;
		}
		else
		{
			$Pedido->formaPagamentoProduto = 1; // credito a vista
			$Pedido->formaPagamentoParcelas = 1;
		}
		 
		$Pedido->dadosEcNumero = CIELO;
		$Pedido->dadosEcChave = CIELO_CHAVE;
		 
		$Pedido->capturar = true;
		$Pedido->autorizar = 2; //Autorizar transa��o autenticada e n�o-autenticada
		 
		 
		//Gera credit com status nao_pago
		$userData = array(
				'usr_id' => $user->usr_id,
				'cre_type' => 1, //TODO: veruficar cre_type
				'cre_value' => $post['produto']/100,
				'cre_date' => date('Y-m-d H:i:s', time()),
				'cre_payed' => Fet_Model_CreditTable::CREDITO_NAO_PAGO
		);
		$credit_id = $creditTable->createCredit($userData);

		$Pedido->dadosPedidoNumero = $credit_id;
		$Pedido->dadosPedidoValor = $post["produto"];
		$Pedido->urlRetorno = Fet_Controller_Helper_PedidoProfile::ReturnURL($Pedido->dadosPedidoNumero, $post['ema_id']);
		// ENVIA REQUISI��O SITE CIELO
		$objResposta = $Pedido->RequisicaoTransacao(false);
		 
		$Pedido->tid = $objResposta->tid;
		$Pedido->pan = $objResposta->pan;
		$Pedido->status = $objResposta->status;
		 
		//     	echo '<pre>';
		//     	print_r($Pedido);
		//     	print_r($objResposta);
		//     	die();
		 
		if(!isset($Pedido->tid) || ! $Pedido->tid > 0 )
			throw new Exception("TID NAO ENCONTRADO. TRANSACAO NAO SALVA NO BANCO");
		 
		$date_obj = new Zend_Date(trim($Pedido->dadosPedidoData),"YYYY-MM-ddTHH:mm:ss");
		$date = $date_obj->toString('YYYY-MM-dd HH:mm:ss');
		 
		//salvar cielo_transacao
		$cieloTable = new Fet_Model_TransCieloTable();
		$userData = array(
				'tid' => $Pedido->tid,
				'date' => $date,
				'status' => $Pedido->status,
				'valor' => $Pedido->dadosPedidoValor,
				'bandeira' => $Pedido->formaPagamentoBandeira,
				'produto' => $Pedido->formaPagamentoProduto,
				'parcelas' => $Pedido->formaPagamentoParcelas,
				'numero_pedido' => $Pedido->dadosPedidoNumero
		);
		$cieloTrans = $cieloTable->createTrans($userData);
		 
		$urlAutenticacao = "url-autenticacao";
		$Pedido->urlAutenticacao = $objResposta->$urlAutenticacao;

		echo '<script type="text/javascript">
				window.location.href = "' . $Pedido->urlAutenticacao . '"
						</script>';
		 
		die('eee');
	}

	function alterarDadosAction() {
		$auth = Zend_Auth::getInstance();
		$identity = $auth->getIdentity();
		
		
		//TODO: verificar se autenticacao via activeKey e email esta ok
		if(!$identity){
			
		}

		$params = $this->getRequest()->getParams();
		//alterar dados de link com ema_id
		if(isset($params['ema_id'])){
			$this->view->assign('ema_id', $params['ema_id']);
		}

		 
		$birthDate = new Zend_Date($identity->usr_birthDate,"YYYY-MM-DD");
		$birthDateF = $birthDate->toString('dd/MM/YYYY');
		 
		$identity->usr_birthDateFormatado = $birthDateF;
		 
		$this->view->assign("user",$identity);

	}

	function visualizaLaudoAction(){

		$params = $this->getRequest()->getParams();
		$emailTable = new Fet_Model_EmailTable();
		 
		$email = $emailTable->find($params['ema_id'])->current();
		
		if($email->ema_confirmed == Fet_Model_EmailTable::EMAIL_NAO_EVIADO_DEBITADO || 
				$email->ema_confirmed == Fet_Model_EmailTable::EMAIL_ENVIADO_DEBITADO)
			$this->view->assign('emailDebitato', true);
		else 
			$this->view->assign('emailDebitato', false);
		 
		$Date = new Zend_Date($email->ema_senddate,"YYYY-MM-DD HH:mm:ss");
		$DateF = $Date->toString('dd/MM/YYYY HH:mm:ss');

		$email->ema_DateFormatado = $DateF;
		 
		$this->view->assign('email', $email);
		 
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		$this->view->assign('user', $user);
		 
		$creditTable = new Fet_Model_CreditTable();
		$totalCredito = $creditTable->getTotalCreditosDisponiveis($user->usr_id);
		$this->view->assign('totalCredits', $totalCredito);
		 
		$pathBase = pathinfo(__FILE__);
		$pathBase = $pathBase['dirname'];
		$path = $pathBase.'/../../public/pdf/'.$email->ema_usr_id.'/'.$email->ema_hash.'/';
		 
		$anexos = array();
		if ($handle = opendir($path)) {
			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				$anexos[]=$entry;
			}
			closedir($handle);
		}
		 
		$this->view->assign('anexos', $anexos);
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

	
	public function confirmarPdfAction(){
		$post = $this->getRequest()->getPost();
		$emailTable = new Fet_Model_EmailTable();
		$email = $emailTable->find($post['ema_id'])->current();
		
		
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		
		$pathBase = pathinfo(__FILE__);
		$pathBase = $pathBase['dirname'];
		$path = $pathBase.'/../../public/pdf/'.$email->ema_usr_id.'/'.$email->ema_hash.'/';
		if(!file_exists($path))
			throw new Exception("Path $path nao encontrado.");
		
		$confTable = new Fet_Model_ConfirmacaoDestinatariosTable();
		$_data = array('usr_id' => $user->usr_id, 'ema_id' => $email->ema_id);
		$confRow = $confTable->getAllTrans($_data, true);
		
		if(!count($confRow) > 0 )
			throw new Exception('ConfirmacaoDestinatario nao encontrado para usr_id: '.$user->usr_id.' ema_id: '.$email->ema_id);
		$confRow = $confRow[0];
		$confRow->status = Fet_Model_ConfirmacaoDestinatariosTable::CONFIRMADO;
		$confRow->save();
		
		
		$_config = Zend_Registry::get('config');
		$config = array('auth' => 'login',
				'username' => $_config->mail->contato->user,
				'password' => $_config->mail->contato->pass,
				'ssl' => 'tls',
				'port' => 587);
		
		$transport = new Zend_Mail_Transport_Smtp($_config->mail->host, $config);
		$data['msg'] = "Seu email foi confirmado com sucesso<br>
				<br>
				Assunto: ".$email->ema_subject ."<br>
						<br>
						Conteúdo: ".$email->ema_body;
		$data["url"] = "http://".$_SERVER["SERVER_NAME"];
		$data["usuario"] = $user->usr_name;
		$data["title"] = 'EviMail - PDF - '.$email->ema_subject;

		$view = Zend_Registry::get("view");
		$view->data = $data;
		$view->translate = $translate;
		$content = $view->render("mail/confirmacao_cadastro.phtml");

		$mail = new Zend_Mail("UTF-8");
		$mail->setType(Zend_Mime::MULTIPART_RELATED);
		$mail->setBodyHtml($content);
		$mail->setFrom($_config->mail->contato->from, $_config->mail->contato->name);
		$mail->addTo($email->ema_emailfrom);
		
		$userTable = new Fet_Model_UserTable();
		$user = $userTable->find($confRow->usr_id)->current();
		$mail->addTo($user->usr_email);
		
		$mail->setSubject('EviMail - PDF - '.$email->ema_subject);
		
		$pdf = file_get_contents($path."email.pdf");
		$file = $mail->createAttachment($pdf);
		$file->filename = $email->ema_hash.".pdf";
		 
		if ($handle = opendir($path)) {
			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if($entry == 'email.pdf' || $entry == '.' || $entry == '..')
					continue;
				 
				$ext_arr = explode('.',$entry);
				$finalKey = count($ext_arr) - 1;
				$ext = $ext_arr[$finalKey];

				$myImage = file_get_contents($path.$entry);

				$at = new Zend_Mime_Part($myImage);

				if($ext == 'txt') {
					$at->type        = 'plain/text';
					// 					$at->disposition = Zend_Mime::DISPOSITION_INLINE;
					// 					$at->encoding    = Zend_Mime::ENCODING_BASE64;
					$at->filename    = $entry;
				} else {
					// 					$at->type        = 'application';
					$at->disposition = Zend_Mime::DISPOSITION_INLINE;
					$at->encoding    = Zend_Mime::ENCODING_BASE64;
					$at->filename    = $entry;
				}
				$mail->addAttachment($at);
			}
			closedir($handle);
		}

		$mail->send($transport);
		
		$confDestinatarios = $confTable->getAllTrans(array('ema_id' => $email->ema_id), true);
		$nao_confirmado = false;
		foreach($confDestinatarios as $_confDest){
			if($_confDest->status == Fet_Model_ConfirmacaoDestinatariosTable::NAO_CONFIRMADO)
				$nao_confirmado = true;
		}
		//todos os destinatarios confirmaram, entao atualiza par EMAIL_ENVIADO
		if(!$nao_confirmado) {
			$email->ema_confirmed = Fet_Model_EmailTable::EMAIL_ENVIADO_DEBITADO;
			$email->save();			
		}
			
		
		$this->_redirect('/minha-conta/consultar-historico'); 
	}

	public function gerarPdfAction(){
		$translate = Zend_Registry::get('translate');
		
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		
		$post = $this->getRequest()->getPost();
		$emailTable = new Fet_Model_EmailTable();
		$email = $emailTable->find($post['ema_id'])->current();
		 
		$creditTable = new Fet_Model_CreditTable();
		$totalCredito = $creditTable->getTotalCreditosDisponiveis($email->ema_usr_id);
		 
		if($totalCredito <= 0)
			throw new Exception("Crédito insuficiente.");
		 
		$_config = Zend_Registry::get('config');
		$config = array('auth' => 'login',
				'username' => $_config->mail->contato->user,
				'password' => $_config->mail->contato->pass,
				'ssl' => 'tls',
				'port' => 587);
		
		$transport = new Zend_Mail_Transport_Smtp($_config->mail->host, $config);
		
		$to_arr = explode(",", $email->ema_emailto);
		
		foreach($to_arr as $key => $__to) {
			$to_arr2 = explode('<',$__to);
			if(count($to_arr2) > 1)
				$to = str_replace('>','',$to_arr2[1]);
			else
				$to = $to_arr2[0];
				
// 			if($to == 'evimail@evimail.com.br')
			if($to == $_config->mail->evimail->user)
				continue;
				
			$to_arr3[] = $to;
		}
		
		$usrProfile = new Fet_Controller_Helper_UserProfile();
		foreach($to_arr3 as $to){
			$data = array();
			$user_to = $usrProfile->getUserByEmail($to);
			
			
			//USUARIO TO JAH CADASTRADO
			if($user_to) {
				$data['msg'] = "Voc&ecirc;  acaba de receber um email de confirma&ccedil;&atilde;o Evimail..<br>".
						"Este servi&ccedil;o serve para confirmar o recebimento do email enviado por:".$user->usr_name.".<br>".
						'Clique <a href="http://'.$_SERVER["SERVER_NAME"].'/minha-conta/visualiza-laudo/activeKey/'.$user_to->usr_activeKey.'/ema_id/'.$email->ema_id.'/usr_email/'.$to.'"> aqui </a> para visualiza-lo e confirmar.<br>';
				
				$data["usuario"] = $user_to->usr_name;
				
			} //USUARIO TO NAO CADASTRADO 
			else { 
				$userTable = new Fet_Model_UserTable();
				$userData = array();
				$userData['usr_email'] = $to;
				$userData['status'] = 1;
				$user_to_id = $userTable->createUser($userData);
				$user_to = $usrProfile->getUserByEmail($to);
				$key = Zend_Registry::get('config')->key->active;
				$user_to->usr_activeKey = md5($user_to_id.$key);
				$user_to->save();
				
				$data['msg'] = "Voc&ecirc;  acaba de receber um email de confirma&ccedil;&atilde;o Evimail..<br>".
						"Este servi&ccedil;o serve para confirmar o recebimento do email enviado por:".$user->usr_name.".<br>".
						'Clique <a href="http://'.$_SERVER["SERVER_NAME"].'/minha-conta/alterar-dados/activeKey/'.$user_to->usr_activeKey.'/ema_id/'.$emailSaved.'/usr_email/'.$to.'"> aqui </a> para visualiza-lo e confirmar.<br>';
				
				$data["usuario"] = '';
			}
			
			$data["url"] = "http://".$_SERVER["SERVER_NAME"];
			$data["title"] = 'EviMail - PDF - '.$email->ema_subject;
	
			$view = Zend_Registry::get("view");
			$view->data = $data;
			$view->translate = $translate;
			$content = $view->render("mail/confirmacao_cadastro.phtml");
	
			$mail = new Zend_Mail("UTF-8");
			$mail->setType(Zend_Mime::MULTIPART_RELATED);
			$mail->setBodyHtml($content);
			$mail->setFrom($_config->mail->contato->from, $_config->mail->contato->name);
			
			$confirmacaoDestTable = new Fet_Model_ConfirmacaoDestinatariosTable();
			$confData = array();
			$confData['usr_id'] = $user_to->usr_id;
			$confData['ema_id'] = $email->ema_id;
			$confData['status'] = Fet_Model_ConfirmacaoDestinatariosTable::NAO_CONFIRMADO;
			$confirmDestRow = $confirmacaoDestTable->createConfirmacaoDestinatarios($confData);
			
			$mail->addTo($to);
			
			
			$mail->setSubject('EviMail - PDF - '.$email->ema_subject);
			$mail->send($transport);
		}
		
		$creditRow = $creditTable->getFirstPayedRow($email->ema_usr_id);
		$creditRow->cre_value = $creditRow->cre_value -1;
		$creditRow->save();
		
		$email->ema_confirmed = Fet_Model_EmailTable::EMAIL_NAO_EVIADO_DEBITADO;
		$email->save();
		
		$this->_redirect('/minha-conta/consultar-historico');
	}


	public function consultarHistoricoAction(){
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		 

		$post = $this->getRequest()->getPost();
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		 
		$emailTable = new Fet_Model_EmailTable();

		$param = array(
				'ema_usr_id' => $user->usr_id,
				'order' => array ('ema_senddate', 'ema_confirmed'));

		if(isset($post['to']) && $post['to'] != '')
			$param['to'] = $post['to'];

		if(isset($post['from'])  && $post['from'] != '')
			$param['from'] = $post['from'];

		if(isset($post['subject']) && $post['subject'] != '')
			$param['subject'] = $post['subject'];

		if(isset($post['status']) && $post['status'] != '')
			$param['status'] = $post['status'];
		//TODO: colocar os filtros de dt_ini edt_fim

		$emails = $emailTable->getAllEmail($param, true);
		$return = array();
		foreach($emails as $email){
			$Date = new Zend_Date($email->ema_senddate,"YYYY-MM-DD HH:mm:ss");
			$DateF = $Date->toString('dd/MM/YYYY HH:mm:ss');
			 
			$email->ema_DateFormatado = $DateF;
			 
			$return[] = $email;
		}
		
		$param = array(
				'usr_id' => $user->usr_id,
				'order' => array ('ema_senddate', 'ema_confirmed'));
		
		if(isset($post['to']) && $post['to'] != '')
			$param['to'] = $post['to'];
		
		if(isset($post['from'])  && $post['from'] != '')
			$param['from'] = $post['from'];
		
		if(isset($post['subject']) && $post['subject'] != '')
			$param['subject'] = $post['subject'];
		
		if(isset($post['status']) && $post['status'] != '')
			$param['status'] = $post['status'];
		//TODO: colocar os filtros de dt_ini edt_fim
		
		$emails = $emailTable->getAllFromConfirmacaoDestinatario($param, true);
		foreach($emails as $email){
			$Date = new Zend_Date($email->ema_senddate,"YYYY-MM-DD HH:mm:ss");
			$DateF = $Date->toString('dd/MM/YYYY HH:mm:ss');
		
			$email->ema_DateFormatado = $DateF;
		
			$return[] = $email;
		}
		
// 		echo
		 
		$this->view->assign('emails', $return);
		$this->view->assign('user', $user);
	}


	function downloadPdfAction(){
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();

		$params = $this->getRequest()->getParams();
		
		$emailTable = new Fet_Model_EmailTable();
		$email = $emailTable->find($params['ema_id'])->current();
		 
		$pathBase = pathinfo(__FILE__);
		$pathBase = $pathBase['dirname'];
		$path = $pathBase.'/../../public/pdf/'.$email->ema_usr_id.'/'.$params['ema_hash'].'/';
		 
		//     	die($path);
		 
		$filename = $path.'email.pdf';
		$tp = pathinfo($filename);

		header("Content-Type: application/pdf");
		header("Content-disposition: attachment; filename=".$tp['basename'].";");
		header("Content-Length: ".filesize($filename));

		header('Content-Transfer-Encoding: Binary');
		header('Accept-Ranges: bytes');

		header('ETag: "'.md5($filename).'"');
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		ob_clean(); // in case anything else was buffered
		ob_start();
		$this->readfile_chunked($filename);
		ob_end_flush();
		die();
		 
	}

	private function readfile_chunked($filename,$retbytes=true) {
		$chunksize = 1*(1024*1024); // how many bytes per chunk
		$buffer = '';
		$cnt =0;
		// $handle = fopen($filename, 'rb');
		$handle = fopen($filename, 'rb');
		if ($handle === false) {
			return false;
		}
		while (!feof($handle)) {
			$buffer = fread($handle, $chunksize);
			echo $buffer;
			ob_flush();
			flush();
			if ($retbytes) {
				$cnt += strlen($buffer);
			}
		}
		$status = fclose($handle);
		if ($retbytes && $status) {
			return $cnt; // return num. bytes delivered like readfile() does.
		}
		return $status;
	}
	
	
	public function gerenciarEmailsAction(){
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		
		$parms = $this->getRequest()->getParams();
		if(isset($parms['jaExisteEmail']))
			$this->view->assign('jaExiste', true);
		
		$emaTable = new Fet_Model_EmailAdicionalTable();

		$data = array('usr_id' => $user->usr_id);
		$emails = $emaTable->getAllEmailAdicionais($data, true);
		
		if(!isset($emails) || !count($emails) > 0 )
			$this->view->assign('totalEmails', '0');
		else
			$this->view->assign('totalEmails', count($emails));
			
		$this->view->assign('emails' , $emails);
		
		$this->view->assign("emailTitular", $user->usr_email);
		$this->view->assign('user', $user);
	}
	
	public function addEmailAdicionalAction(){
		$parms = $this->getRequest()->getParams();
		
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		
		$emaTable = new Fet_Model_EmailAdicionalTable();
		
		$jaExiste = $emaTable->getAllEmailAdicionais(array('email' => $parms['email']), true);
		if(is_array($jaExiste) || count($jaExiste) > 0){
			$this->_redirect('/minha-conta/gerenciar-emails/jaExisteEmail/true');
			die();
		}
		$userTable = new Fet_Model_UserTable();
		$jaExiste = $userTable->getAllUsers(array('usr_email' => $parms['email']), true);
		if(is_array($jaExiste) || count($jaExiste) > 0){
			$this->_redirect('/minha-conta/gerenciar-emails/jaExisteEmail/true');
			die();
		}
		
		$data = array('email' => $parms['email'], 
				'create_date' => date('Y-m-d H:i:s', time()),
				'usr_id' => $user->usr_id
		);
		$email = $emaTable->createEmailAdicional($data);
		
		$this->_redirect('/minha-conta/gerenciar-emails');	
		
	}
	
	public function removerEmailAdicionalAction(){
		
		$parms = $this->getRequest()->getParams();
		
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		
		$emaTable = new Fet_Model_EmailAdicionalTable();
		
		$emaTable->delete('id = '.$parms['id']);
		
		$this->_redirect('/minha-conta/gerenciar-emails');
	}
}
