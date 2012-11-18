<?php
class Fet_Model_CreditTable extends Zend_Db_Table
{	
	const CREDITO_NAO_PAGO =0;
	const CREDITO_PAGO = 1;
// 	const CREDITO_UTILIZADO_NAO_CONFIRMADO = 2;
// 	const CREDITO_UTILIZADO_CONFIRMADO = 3;

	private $db;
	public $erro;
	protected $_name 				= 'credits';
	protected $_rowClass 			= 'Fet_Model_CreditRow';
	protected $_primary = 'cre_id';
	
	//public function __construct(){
		//$this->db = Zend_Registry::get('db_adapter_comunidade');
		//parent::__construct($this->db);
	//}
	
	/**
	* Obtem lista dos usuários 
	* @param bool $fetchResult Define se o retorno será um SQL ou Zend_Db_Table_Rowset_Abstract
	* @return  Zend_Db_Table_Rowset_Abstract ou Zend_Db_Select
	*/
	public function getAllCredits($params=array(), $fetchResult = false, $limit = null, $offset = 0)
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
// 		->joinLeft(array('u' => 'user'), 'u.usr_id = e.usr_id', array('cre_email', 'cre_email'))

		;//
	
	
	
		if (isset($params["type"]))
			$select->where("c.cre_type = ? ", $params["type"]);

		if (isset($params['payed']))
			$select->where("c.cre_payed = ? ", $params["payed"]);
	
		if (isset($params["ini"]) and isset($params["fim"]))
		{
			if (Zend_Validate::is($params["ini"], "Date", array("dd/MM/yyyy"))
					and Zend_Validate::is($params["fim"], "Date", array("dd/MM/yyyy")))
			{
				$dtIni = new Zend_Date($params["ini"] . " 00:00:00", "pt_BR");
				$dtIni = $dtIni->get(Zend_Date::ISO_8601);
					
				$dtFim = new Zend_Date($params["fim"] . " 23:59:59", "pt_BR");
				$dtFim = $dtFim->get(Zend_Date::ISO_8601);

				$select->where('c.cre_date BETWEEN "'.$dtIni.'" AND "'.$dtFim.'"');
			}
		}


		if (isset($params["usr_id"])){
			$select->where("c.usr_id = ?", $params["usr_id"]);
		}

		if(isset($params["cre_id"])){
			$select->where('c.cre_id = ?', $params['cre_id']);
		}


// 		 Zend_Debug::dump($select->__toString());

		if($limit || $offset)
			$select->limit($limit, $offset);


		if(!isset($params['order'])){
			$select->order("cre_date");
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
	public function createCredit( $userData ){
		$row = $this->createRow();
		unset($userData["cre_id"]);
	
		$data = array();
		foreach($userData as $key => $value){
			$data[$key] = $value;
		}

		$row->setFromArray($data);
		$row->save();
		$id = $row->cre_id;
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
		$row = $this->find($post["cre_id"])->current();

		$userData = array();
		foreach($post as $key => $value){
			$userData[$key] = $value;
		}
			
		$row->setFromArray($userData);
		$row->save();
	}

	
	public function getTotalCreditosDisponiveis($usr_id){
		
// 		$usr_id = 18;
		
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

	public function getFirstPayedRow($usr_id){
		$params = array(
				'usr_id' => $usr_id,
				'payed' => Fet_Model_CreditTable::CREDITO_PAGO
		);
		
		$credits = $this->getAllCredits($params,true);
		
		if(!$credits || count($credits) == 0)
			return null;
		
		return($credits[0]);
	}
	

}
?>
