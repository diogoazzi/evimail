<?php

class CieloController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
		$this->_helper->_acl->allow(null);
	}

	public function indexAction()
	{
			

	}

	public function getRetornoAction(){

		$params = $this->getRequest()->getParams();

		$transCieloTable = new Fet_Model_TransCieloTable();
		$userData = array('numero_pedido' => $params['numero_pedido']);
		$transCielo = $transCieloTable->getAllTrans($userData, true);
		$transCielo = $transCielo[0];

		$creditTable = new Fet_Model_CreditTable();
		$data = array ('cre_id' => $params['numero_pedido']);
		$credits = $creditTable->getAllCredits($data, true);
		$credit = $credits[0];
		
		$email_id = $params['ema_id'];

		$userTable = new Fet_Model_UserTable();
		$data = array('usr_id' => $credit->usr_id);
		$users = $userTable->getAllUsers($data, true);
		$user = $users[0];



		$Pedido = new Fet_Controller_Helper_PedidoProfile();
		$Pedido = $Pedido->hidrate($transCielo);

		$objResposta = $Pedido->RequisicaoConsulta();

		$emailAdicionalTable = new Fet_Model_EmailAdicionalTable();
		$emailsAdicionais = $emailAdicionalTable->getAllEmailAdicionais(array('usr_id' => $user->usr_id),true);


		$emails = array($user->usr_email);

		foreach($emailsAdicionais as $_emailAdicional){
			$emails[] = $_emailAdicional->email;
		}


		if($objResposta->status == 5){
			$msg = 'Sou solicita&ccedil;&atilde;o de pagamento n&atilde;o foi aprovada.';
			$subject = 'Evimail - Pagamento Recusado pela Operadora';
			$this->enviaEmail($msg, $subject, $emails, $user->usr_name);
			$this->_redirect('/minha-conta/');
			die('nao autorizada');
		}
			

		if($objResposta->status == 4)
			$objResposta = $Pedido->RequisicaoCaptura('100', null);

		if($objResposta->status == 6) {
			$credit->cre_payed = Fet_Model_CreditTable::CREDITO_PAGO;
			$credit->save();
				
			$transCielo->status = 6;
			$transCielo->save();
				
			$msg = 'Sou solicita&ccedil;&atilde;o de pagamento foi aprovada.';
			$subject = 'Evimail - Pagamento Autorizado pela Operadora';
			$this->enviaEmail($msg, $subject, $emails, $user->usr_name);
			
			if(isset($email_id) && $email_id != null && $email_id != '')
				$this->_redirect('/minha-conta/visualiza-laudo/ema_id/'.$email_id);
			else
				$this->_redirect('/minha-conta/');
			die('capturada com sucesso.');
		}

			
		die('status transacao: '.$objResposta->status);

	}

	public function processaTransacoesAction(){
		$transCieloTable = new Fet_Model_TransCieloTable();
		$userData = array('status' => '0');
		$transCielo = $transCieloTable->getAllTrans($userData, true);

		echo count($transCielo)." transacoes encontradas com status = 0\n";

		foreach($transCielo as $trans){
			$Pedido = new Fet_Controller_Helper_PedidoProfile();
			$Pedido = $Pedido->hidrate($trans);
			$objResposta = $Pedido->RequisicaoConsulta();
			$objVars = get_object_vars($objResposta);
			$creditTable = new Fet_Model_CreditTable();
			$data = array ('cre_id' => $objVars['dados-pedido']->numero);
			$credits = $creditTable->getAllCredits($data, true);
			$credit = $credits[0];
				
			$userTable = new Fet_Model_UserTable();
			$data = array('usr_id' => $credit->usr_id);
			$users = $userTable->getAllUsers($data, true);
			$user = $users[0];
				
			$emailAdicionalTable = new Fet_Model_EmailAdicionalTable();
			$emailsAdicionais = $emailAdicionalTable->getAllEmailAdicionais(array('usr_id' => $user->usr_id),true);
				
			$emailAdicional = false;
				
			$emails = array($user->usr_email);

			foreach($emailsAdicionais as $_emailAdicional){
				$emails[] = $_emailAdicional->email;
			}

			if($objResposta->status == 5){
				$msg = 'Sou solicita&ccedil;&atilde;o de pagamento n&atilde;o foi aprovada.';
				$subject = 'Evimail - Pagamento Recusado pela Operadora';
				$this->enviaEmail($msg, $subject, $emails, $user->usr_name);
			}
				
			if($objResposta->status == 4){
				$objResposta = $Pedido->RequisicaoCaptura('100', null);
			}
				
			if($objResposta->status == 6){
				
				$credit->cre_payed = Fet_Model_CreditTable::CREDITO_PAGO;
				$credit->save();

				$msg = 'Sou solicita&ccedil;&atilde;o de pagamento foi aprovada.';
				$subject = 'Evimail - Pagamento Autorizado pela Operadora';
				$this->enviaEmail($msg, $subject, $emailTo, $user->usr_name);
			}
				
			$trans->status = $objResposta->status;
			$trans->save();
				
		}

		die('Fim do processamento.');
	}


	private function enviaEmail($emailMsg, $subject, $to_array, $toName=null){

    	$_config = Zend_Registry::get('config');
		$config = array('auth' => 'login',
				'username' => $_config->mail->contato->user,
				'password' => $_config->mail->contato->pass,
				'ssl' => 'tls',
				'port' => 587);
		
		$transport = new Zend_Mail_Transport_Smtp($_config->mail->host, $config);
		

		$data['msg'] = $emailMsg;
		$data["url"] = "http://".$_SERVER["SERVER_NAME"];
		$data["usuario"] = $toName;
		$data["title"] = $subject;

		$view = Zend_Registry::get("view");
		$view->data = $data;
		$content = $view->render("mail/confirmacao_cadastro.phtml");

		$mail = new Zend_Mail("UTF-8");
		$mail->setType(Zend_Mime::MULTIPART_RELATED);
		$mail->setBodyHtml($emailMsg);

		$mail->setFrom($_config->mail->contato->from, $_config->mail->contato->name);

		foreach($to_array as $to)
			$mail->addTo($to);

		$mail->setSubject($subject);
		$mail->send($transport);
	}
}
