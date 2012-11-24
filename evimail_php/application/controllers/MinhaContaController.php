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
    	$identity = $auth->getIdentity();
    	$this->view->assign('user', $identity);

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
    	
//     	die($post['produto'].'#');
//     	$post["produto"] = '12300' ; //valor
    	
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
    		'cre_value' => $post['produto'],
    		'cre_date' => date('Y-m-d H:i:s', time()),
    		'cre_payed' => Fet_Model_CreditTable::CREDITO_NAO_PAGO
    	);
    	$credit_id = $creditTable->createCredit($userData);

    	$Pedido->dadosPedidoNumero = $credit_id;
    	$Pedido->dadosPedidoValor = $post["produto"];
    	
    	//TODO: arrumar URL de retorno
    	$Pedido->urlRetorno = Fet_Controller_Helper_PedidoProfile::ReturnURL($Pedido->dadosPedidoNumero);
    	
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
    	
    	
//     	die('trans:'. $cieloTrans);
    	$urlAutenticacao = "url-autenticacao";
    	$Pedido->urlAutenticacao = $objResposta->$urlAutenticacao;
    	
    	echo '<pre>';
    	print_r($Pedido);
    	die();
    	
    	// Serializa Pedido e guarda na SESSION
//     	$StrPedido = $Pedido->ToString();

    	echo '<script type="text/javascript">
			window.location.href = "' . $Pedido->urlAutenticacao . '"
		 </script>';
    	
    	 die('eee');
    }
    
    function alterarDadosAction() {
    	$auth = Zend_Auth::getInstance();
    	$identity = $auth->getIdentity();
    	

    	
    	$birthDate = new Zend_Date($identity->usr_birthDate,"YYYY-MM-DD");
    	$birthDateF = $birthDate->toString('dd/MM/YYYY');
    	
    	$identity->usr_birthDateFormatado = $birthDateF;
    	
    	$this->view->assign("user",$identity);

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
    	$this->view->assign('user', $user);
    	
    	$creditTable = new Fet_Model_CreditTable();
    	$totalCredito = $creditTable->getTotalCreditosDisponiveis($user->usr_id);
    	$this->view->assign('totalCredits', $totalCredito);
    	
    	$pathBase = pathinfo(__FILE__);
    	$pathBase = $pathBase['dirname'];
    	$path = $pathBase.'/../../public/pdf/'.$user->usr_id.'/'.$email->ema_hash.'/';
    	
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

    
    public function gerarPdfAction(){
    	$post = $this->getRequest()->getPost();
    	$emailTable = new Fet_Model_EmailTable();
    	$email = $emailTable->find($post['ema_id'])->current();
    	
    	$creditTable = new Fet_Model_CreditTable();    	
    	$totalCredito = $creditTable->getTotalCreditosDisponiveis($email->ema_usr_id);
    	
    	if($totalCredito <= 0)
    		throw new Exception("Crédito insuficiente.");
    	
		$creditRow = $creditTable->getFirstPayedRow($email->ema_usr_id);
		
		$auth = Zend_Auth::getInstance();
		$user = $auth->getIdentity();
		
		$Date = new Zend_Date($email->ema_senddate,"YYYY-MM-DD HH:mm:ss");
		$DateF = $Date->toString('dd/MM/YYYY HH:mm:ss');
		
		$mail_pdf = '<html><body>hash autentica&ccedil;&atilde;o: '.$email->ema_hash.'<br><br>';
		$mail_pdf .= 'Recebido em: '.$DateF.'<br>';
		$mail_pdf .= 'De: '.$email->ema_emailfrom.'<br>';
		$mail_pdf .= 'Para: '.$email->ema_emailto.'<br>';
		$mail_pdf .= 'Assunto: '.$email->ema_subject.'<br><br>';
		$mail_pdf .= $email->ema_body;
		
		require_once("Dompdf/dompdf_config.inc.php");
    	$dompdf = new DOMPDF();
    	$dompdf->load_html($mail_pdf);
    	$dompdf->set_paper('letter', 'landscape');
    	$dompdf->render();
    	
    	$pathBase = pathinfo(__FILE__);
    	$pathBase = $pathBase['dirname'];
    	$path = $pathBase.'/../../public/pdf/'.$user->usr_id.'/'.$email->ema_hash.'/';
    	if(!file_exists($path))
    		mkdir($path, 0755,true);
    	

    	$pdf = $dompdf->output();
    	file_put_contents($path."email.pdf", $pdf);
    	
    	
    	$config = array('auth' => 'login',
    			'username' => 'evimail@webneural.com',
    			'password' => 'y2s2r2i4',
    			'ssl' => 'tls',
    			'port' => 587);
    	
    	$transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
    	
    	$html_body = $email->ema_subject ."<br><br>".$email->ema_body;
    	$mail = new Zend_Mail();
    	$mail->setType(Zend_Mime::MULTIPART_RELATED);
    	$mail->setBodyHtml($html_body);
    	
    	$mail->setFrom('evimail@webneural.com', 'EviMail');
    	// 		    $mail->addTo("diogo.azzi@webneural.com");
    	// 		    $mail->addTo("diogoafe@gmail.com");
    	$mail->addTo($email->ema_emailfrom);
    	$mail->setSubject('EviMail - PDF - '.$email->ema_subject);
    	
    	$file = $mail->createAttachment($pdf);
    	$file->filename = $path."email.pdf";
    	
    	if ($handle = opendir($path)) {
    		/* This is the correct way to loop over the directory. */
    		while (false !== ($entry = readdir($handle))) {
    			if($entry == 'email.pdf')
    				continue;
    			
    			$ext_arr = explode('.',$entry);
				$ext = $ext_arr[1];
				
				$at = new Zend_Mime_Part($myImage);
				
				if($ext == 'txt') {
					$at->type        = 'plain/text';
// 					$at->disposition = Zend_Mime::DISPOSITION_INLINE;
// 					$at->encoding    = Zend_Mime::ENCODING_BASE64;
					$at->filename    = $path.$entry;
				} else {
					$at->type        = 'application';
										$at->disposition = Zend_Mime::DISPOSITION_INLINE;
										$at->encoding    = Zend_Mime::ENCODING_BASE64;
					$at->filename    = $path.$entry;					
				}
				$mail->addAttachment($at);
    		}
    		closedir($handle);
    	}
    	 
    	$mail->send($transport);


    	$creditRow->cre_value = $creditRow->cre_value -1;
    	$creditRow->save();
    	
    	$email->ema_confirmed = Fet_Model_EmailTable::EMAIL_ENVIADO_DEBITADO;
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
    	
    	$this->view->assign('emails', $return);
    	$this->view->assign('user', $user);
    } 
    
    
    function downloadPdfAction(){
    	$auth = Zend_Auth::getInstance();
    	$user = $auth->getIdentity();
    	 
    	$params = $this->getRequest()->getParams();
    	
    	$pathBase = pathinfo(__FILE__);
    	$pathBase = $pathBase['dirname'];
    	$path = $pathBase.'/../../public/pdf/'.$user->usr_id.'/'.$params['ema_hash'].'/';
    	
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
}
