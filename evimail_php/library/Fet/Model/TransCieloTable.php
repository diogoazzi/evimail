<?php
class Fet_Model_TransCieloTable extends Zend_Db_Table
{	
	const CREDITO_NAO_PAGO =0;
	const CREDITO_PAGO = 1;
// 	const CREDITO_UTILIZADO_NAO_CONFIRMADO = 2;
// 	const CREDITO_UTILIZADO_CONFIRMADO = 3;

	private $db;
	public $erro;
	protected $_name 				= 'trans_cielo';
	protected $_rowClass 			= 'Fet_Model_CreditRow';
	protected $_primary = 'tid';
	
	//public function __construct(){
		//$this->db = Zend_Registry::get('db_adapter_comunidade');
		//parent::__construct($this->db);
	//}
	
	/**
	* Obtem lista dos usuários 
	* @param bool $fetchResult Define se o retorno será um SQL ou Zend_Db_Table_Rowset_Abstract
	* @return  Zend_Db_Table_Rowset_Abstract ou Zend_Db_Select
	*/
	public function getAllTrans($params=array(), $fetchResult = false, $limit = null, $offset = 0)
	{
		/**
		 * Obtendo os dados de todos os amigos do usuário $usrId
		 * @var Zend_Db_Sql
		 */
		$select = $this->select()
		->from(
		array('c' => $this->_name)
		)
		->setIntegrityCheck(false)
		;//
	
	
	
		if (isset($params["tid"]))
			$select->where("c.tid = ? ", $params["tid"]);

		if (isset($params['status']))
			$select->where("c.status = ? ", $params["status"]);
		

		if (isset($params["ini"]) and isset($params["fim"]))
		{
			if (Zend_Validate::is($params["ini"], "Date", array("dd/MM/yyyy"))
					and Zend_Validate::is($params["fim"], "Date", array("dd/MM/yyyy")))
			{
				$dtIni = new Zend_Date($params["ini"] . " 00:00:00", "pt_BR");
				$dtIni = $dtIni->get(Zend_Date::ISO_8601);
					
				$dtFim = new Zend_Date($params["fim"] . " 23:59:59", "pt_BR");
				$dtFim = $dtFim->get(Zend_Date::ISO_8601);

				$select->where('c.date BETWEEN "'.$dtIni.'" AND "'.$dtFim.'"');
			}
		}


		if (isset($params["numero_pedido"])){
			$select->where("c.numero_pedido = ?", $params["numero_pedido"]);
		}

// 		 Zend_Debug::dump($select->__toString());

		if($limit || $offset)
			$select->limit($limit, $offset);


		if(!isset($params['order'])){
			$select->order("date");
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
	public function createTrans( $userData ){
		$row = $this->createRow();
// 		unset($userData["tid"]);
	
		$data = array();
		foreach($userData as $key => $value){
			$data[$key] = $value;
		}

		$row->setFromArray($data);
		$row->save();
		$id = $row->tid;
		if($id){
			return $id;
		} else {
			return false;
		}
	}
	
	/**
	 * Atualiza os dados de um Credito
	 * @param Array $post
	 * @return boolean
	*/	
	public function updateCredit( $post ){		
		$row = $this->find($post["tid"])->current();

		$userData = array();
		foreach($post as $key => $value){
			$userData[$key] = $value;
		}
			
		$row->setFromArray($userData);
		$row->save();
	}

	
	public function getTotalCreditosDisponiveis($usr_id){
		
		$params = array(
				'usr_id' => $usr_id,
				'payed' => Fet_Model_CreditTable::CREDITO_PAGO
		);
		
		$credits = $this->getAllCredits($params,true);
		$total = 0;
		
		foreach($credits as $credit)
			$total += $credit->cre_value;

		return $total;
	}
	
	
	public function jaContratou($usr_id){
	
		$params = array(
				'usr_id' => $usr_id,
		);
	
		$credits = $this->getAllCredits($params,true);
		
		return count($credits);
	}

	public function getFirstPayedRow($usr_id){
		$params = array(
				'usr_id' => $usr_id,
				'payed' => Fet_Model_CreditTable::CREDITO_PAGO,
				'cre_value' => '0'
		);
		
		$credits = $this->getAllCredits($params,true);
		
		if(!$credits || count($credits) == 0)
			return null;
		
		return($credits[0]);
	}
	

}
?>
