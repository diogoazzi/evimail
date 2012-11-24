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
		
		$userTable = new Fet_Model_UserTable();
		$data = array('usr_id' => $credit->usr_id);
		$users = $userTable->getAllUsers($data, true);
		$user = $users[0];
		


		$Pedido = new Fet_Controller_Helper_PedidoProfile();
		$Pedido = $Pedido->hidrate($transCielo);

		$objResposta = $Pedido->RequisicaoConsulta();
		
		
		if($objResposta->status == 5){
			$msg = 'Sou solicita&ccedil;&atilde;o de pagamento n&atilde;o foi aprovada.';
			$subject = 'Evimail - Pagamento Recusado pela Operadora';
			$this->enviaEmail($msg, $subject, $user->usr_email);
			$this->_redirect('/minha-conta/');
			die();
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
			$this->enviaEmail($msg, $subject, $user->usr_email);
			
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
				
			if($objResposta->status == 5){
				$msg = 'Sou solicita&ccedil;&atilde;o de pagamento n&atilde;o foi aprovada.';
				$subject = 'Evimail - Pagamento Recusado pela Operadora';
				$this->enviaEmail($msg, $subject, $user->usr_email);
			}
			
			if($objResposta->status == 4){
				$objResposta = $Pedido->RequisicaoCaptura('100', null);
			}
			
			if($objResposta->status == 6){
				$credit->cre_payed = Fet_Model_CreditTable::CREDITO_PAGO;
				$credit->save();

				$msg = 'Sou solicita&ccedil;&atilde;o de pagamento foi aprovada.';
				$subject = 'Evimail - Pagamento Autorizado pela Operadora';
				$this->enviaEmail($msg, $subject, $user->usr_email);
			}
			
			$trans->status = $objResposta->status;
			$trans->save();
			
		}
		
		die('Fim do processamento.');
	}
	
	private function enviaEmail($emailMsg, $subject, $to){
		$config = array('auth' => 'login',
				'username' => 'evimail@webneural.com',
				'password' => 'y2s2r2i4',
				'ssl' => 'tls',
				'port' => 587);
		
		$transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
		
		$mail = new Zend_Mail();
		$mail->setType(Zend_Mime::MULTIPART_RELATED);
		$mail->setBodyHtml($emailMsg);
		
		$mail->setFrom('evimail@webneural.com', 'EviMail');
		$mail->addTo($to);
		$mail->setSubject($subject);
		$mail->send($transport);
	}
}