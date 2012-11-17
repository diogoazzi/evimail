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
		array('e' => $this->_name),
		array(
		/*'ema_id', 'ema_email', 'ema_name', 'ema_nickname',
		 'ema_occupation', 'ema_birthDate', 'cit_id', 'ema_status', 'ema_destaque',
		'ema_insertDate',
		'ema_insertDateFormat' => "DATE_FORMAT(u.ema_insertDate, '%d/%m/%Y %H:%i')"*/
// 				'*','ema_insertDateFormat' => "DATE_FORMAT(u.ema_insertDate, '%d/%m/%Y %H:%i')",'ema_dataTerminoPlanoFormat' => "DATE_FORMAT(u.ema_dataTerminoPlano, '%d/%m/%Y %H:%i')"
		//'ema_twitter', 'twitter_token', 'twitter_token_secret'
		)
		)
		->setIntegrityCheck(false)
		->joinLeft(array('u' => 'user'), 'u.ema_id = e.ema_ema_id', array('ema_email', 'ema_email'))

		;//
	
	
	
		if (isset($params["nome"]))
		$select->where("u.ema_name like ? or u.ema_nickname like ?", '%'.$params["nome"].'%');
			    
	
		if (isset($params["ini"]) and isset($params["fim"]))
		{
			if (Zend_Validate::is($params["ini"], "Date", array("dd/MM/yyyy"))
					and Zend_Validate::is($params["fim"], "Date", array("dd/MM/yyyy")))
			{
				$dtIni = new Zend_Date($params["ini"] . " 00:00:00", "pt_BR");
				$dtIni = $dtIni->get(Zend_Date::ISO_8601);
					
				$dtFim = new Zend_Date($params["fim"] . " 23:59:59", "pt_BR");
				$dtFim = $dtFim->get(Zend_Date::ISO_8601);

				$select->where('u.ema_insertDate BETWEEN "'.$dtIni.'" AND "'.$dtFim.'"');
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

		if($params["ema_id"]){
			$select->where('e.ema_id = ?', $params['ema_id']);
		}


		//  Zend_Debug::dump($select->__toString());

		if($limit || $offset)
			$select->limit($limit, $offset);



		if(!$params['order']){
			$select->order("ema_senddate desc");
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
}
?>
