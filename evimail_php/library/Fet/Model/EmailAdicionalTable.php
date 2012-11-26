<?php
class Fet_Model_EmailAdicionalTable extends Zend_Db_Table
{	


	private $db;
	public $erro;
	protected $_name 				= 'emails_adicionais';
	protected $_rowClass 			= 'Fet_Model_CreditRow';
	protected $_primary = 'id';
	
	//public function __construct(){
		//$this->db = Zend_Registry::get('db_adapter_comunidade');
		//parent::__construct($this->db);
	//}
	
	/**
	* Obtem lista dos usuários 
	* @param bool $fetchResult Define se o retorno será um SQL ou Zend_Db_Table_Rowset_Abstract
	* @return  Zend_Db_Table_Rowset_Abstract ou Zend_Db_Select
	*/
	public function getAllEmailAdicionais($params=array(), $fetchResult = false, $limit = null, $offset = 0)
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
	
	
	
		if (isset($params["id"]))
			$select->where("c.id = ? ", $params["id"]);

		if (isset($params['email']))
			$select->where("c.email = ? ", $params["email"]);
		

		if (isset($params["ini"]) and isset($params["fim"]))
		{
			if (Zend_Validate::is($params["ini"], "Date", array("dd/MM/yyyy"))
					and Zend_Validate::is($params["fim"], "Date", array("dd/MM/yyyy")))
			{
				$dtIni = new Zend_Date($params["ini"] . " 00:00:00", "pt_BR");
				$dtIni = $dtIni->get(Zend_Date::ISO_8601);
					
				$dtFim = new Zend_Date($params["fim"] . " 23:59:59", "pt_BR");
				$dtFim = $dtFim->get(Zend_Date::ISO_8601);

				$select->where('c.create_date BETWEEN "'.$dtIni.'" AND "'.$dtFim.'"');
			}
		}



// 		 Zend_Debug::dump($select->__toString());

		if($limit || $offset)
			$select->limit($limit, $offset);


		if(!isset($params['order'])){
			$select->order("create_date");
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
	public function createEmailAdicional( $data ){
		
		
		$row = $this->createRow();
		unset($data["id"]);
	
		$_data = array();
		foreach($data as $key => $value){
			$_data[$key] = $value;
		}
		

		$row->setFromArray($_data);
		$row->save();
		$id = $row->id;
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
		$row = $this->find($post["id"])->current();

		$userData = array();
		foreach($post as $key => $value){
			$userData[$key] = $value;
		}
			
		$row->setFromArray($userData);
		$row->save();
	}

	
	

}
?>
