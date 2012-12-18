<?php
class Fet_Model_ConfirmacaoDestinatariosTable extends Zend_Db_Table
{	
	const NAO_CONFIRMADO =0;
	const CONFIRMADO = 1;

	private $db;
	public $erro;
	protected $_name 				= 'confirmacao_destinatarios';
	protected $_rowClass 			= 'Fet_Model_ConfirmacaoDestinatariosRow';
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
		
// 		 Zend_Debug::dump($select->__toString());

		if($limit || $offset)
			$select->limit($limit, $offset);



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
	public function createConfirmacaoDestinatarios( $data ){
		$row = $this->createRow();

		$row->setFromArray($data);
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
	public function updateConfirmacaoDestinatarios( $post ){		
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
