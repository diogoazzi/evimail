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
		

		$Pedido = new Fet_Controller_Helper_PedidoProfile();
		$Pedido = $Pedido->hidrate($transCielo);
		
// 		$Pedido->tid = '100173489808EBA4A001';
		echo '<pre>';
		print_r($Pedido);
// 		die();
		$objResposta = $Pedido->RequisicaoConsulta();
		
		echo '<pre>';
		print_r($objResposta);
		die();
// 		$objResposta = $Pedido->RequisicaoCaptura('100', null);
		
		
		echo '<pre>';
		
		print_r($objResposta);
		
		die();
// 		str_replace('<','\<', )
	}
}