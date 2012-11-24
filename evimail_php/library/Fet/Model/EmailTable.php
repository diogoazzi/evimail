<?php
class Fet_Model_EmailTable extends Zend_Db_Table
{	
	const EMAIL_NAO_ENVIADO =0;
	const EMAIL_ENVIADO_NAO_DEBIATO = 1;
	const EMAIL_ENVIADO_DEBITADO = 2;

	private $db;
	public $erro;
	protected $_name 				= 'email';
	protected $_rowClass 			= 'Fet_Model_EmailRow';
	protected $_primary = 'ema_id';
	
	//public function __construct(){
		//$this->db = Zend_Registry::get('db_adapter_comunidade');
		//parent::__construct($this->db);
	//}
	
	/**
	* Obtem lista dos usuários 
	* @param bool $fetchResult Define se o retorno será um SQL ou Zend_Db_Table_Rowset_Abstract
	* @return  Zend_Db_Table_Rowset_Abstract ou Zend_Db_Select
	*/
	public function getAllEmail($params=array(), $fetchResult = false, $limit = null, $offset = 0)
	{
		/**
		 * Obtendo os dados de todos os amigos do usuário $usrId
		 * @var Zend_Db_Sql
		 */
		$select = $this->select()
		->from(
			array('e' => $this->_name)
		)
		->setIntegrityCheck(false)
		;//
	
	    
	
		if (isset($params["ini"]) and isset($params["fim"]))
		{
			if (Zend_Validate::is($params["ini"], "Date", array("dd/MM/yyyy"))
					and Zend_Validate::is($params["fim"], "Date", array("dd/MM/yyyy")))
			{
				$dtIni = new Zend_Date($params["ini"] . " 00:00:00", "pt_BR");
				$dtIni = $dtIni->get(Zend_Date::ISO_8601);
					
				$dtFim = new Zend_Date($params["fim"] . " 23:59:59", "pt_BR");
				$dtFim = $dtFim->get(Zend_Date::ISO_8601);

				$select->where('e.ema_sendDate BETWEEN "'.$dtIni.'" AND "'.$dtFim.'"');
			}
		}

		    
		if (isset($params["confirmed"]))
		{
			$select->where('e.ema_confirmed = ?', $params["confirmed"]);
		}

		if (isset($params["search"])){
			$select->where("e.ema_userfrom like ?
					or e.ema_userto like ?
					or e.ema_emailfrom like ?
					or e.ema_emailto like ?
					or e.ema_cc like ?
					or e.ema_bcc like ?
					or e.ema_subject like ?
					or e.ema_body like ?", '%'.$params["search"].'%');
		}

		if(isset($params["ema_id"])){
			$select->where('e.ema_id = ?', $params['ema_id']);
		}
		
		if(isset($params["ema_hash"])){
			$select->where('e.ema_hash = ?', $params['ema_hash']);
		}
		
		if(isset($params["ema_usr_id"])){	
			$select->where('e.ema_usr_id = ?', $params['ema_usr_id']);
		}
		
		
		if(isset($params['to']))
			$select->where('e.ema_emailto = ?', $params['to']);
		 
		if(isset($params['from']))
			$select->where('e.ema_emailfrom = ?', $params['from']);
		 
		if(isset($params['subject']))
			$select->where('e.ema_subject like ?', '%'.$params['subject'].'%');
		 
		if(isset($params['status']))
			$select->where('e.ema_confirmed = ?', $params['status']);
		
		
		

		if($limit || $offset)
			$select->limit($limit, $offset);



		if(!isset($params['order'])){
			$select->order("ema_sendDate desc");
		} else {
			if(!is_array($params['order']))
				$select->order($params['order']);
			else {
				foreach($params['order'] as $order)
					$select->order($order);
			}
		}
		
// 		Zend_Debug::dump($select->__toString());

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
	public function createEmail( $mailData ){
		$row = $this->createRow();
		unset($mailData["ema_id"]);
		
// 		die('eeee');
		
		if(!$mailData["ema_confirmed"]){
			$mailData["ema_confirmed"] = 0;
		}
		
		$data = array();
		foreach($mailData as $key => $value){
			$data[$key] = $value;
		}
		

		$row->setFromArray($data);
		$row->save();
		$id = $row->ema_id;
		if($id){
			return $id;
		} else {
			return false;
		}
	}
	
	/**
	 * Atualiza os dados de um Email
	 * @param Array $post
	 * @return boolean
	*/	
	public function updateEmail( $post ){
		$row = $this->find($post["ema_id"])->current();

		$mailData = array();
		foreach($post as $key => $value){
			$mailData[$key] = $value;
		}
		
		$row->setFromArray($mailData);		
		$row->save();
	}
	
	
	
	/**
	 * Busca dados do email através do e-mail 
	 * @param string $email
	 */
	public function getUserByEmail( $email , $status = null){

		$select = $this->select()
		->from(array('e'=>'email'))
		->where("ema_emailfrom = ?", $email);

		if($status != null){
			$select->where('u.ema_confirmed = '.$status );
		}
		
		$mail = $this->fetchAll(
			$select
		);
	
		
		$current = $mail->current();
		if(isset($current)){
			return $current;
		} else {
			return false;
		}
	}
	
	public function verificaByHash($hash){
		$param = array('ema_hash' => $hash);
		$mail = $this->getAllEmail($param, true);
		
		
// 		print_r($mail);
		if(!$mail || count($mail) == 0)
			return false;
		
		return true;
	}
}
?>
