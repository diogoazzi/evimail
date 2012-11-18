<?php

class Fet_Controller_Helper_EmailProfile extends Zend_Controller_Action_Helper_Abstract{
	
	/**
	 * Realiza o cadastro do profile no banco de dados
	 * @param $name
	 * @return boolen
	*/
	public function persistEmail( $post, $insert = false, $log = true ){
		
		$emailTable = new Fet_Model_EmailTable();

		if( empty($post["ema_id"]) ){
			$usrId = $emailTable->createemail($post);
			return $usrId;
		}else{
			$data = $emailTable->find($post["ema_id"])->current();
			
// 			if(isset($post['fileAvatar50name'])){
// 				$post['img_id'] = $this->createProfileImage($post);
// 			}
			
			$emailTable->updateemail($post);
			
			//pra que este if,  jah tem empty$post[ema_id]
			if(!$insert){
				$auth = Zend_Auth::getInstance();
				$data = $auth->getIdentity();
				$email = $emailTable->find($post["ema_id"])->current();
				
				
				$data->thumb = $thumb;
				
				$auth->getStorage()->clear();
				$auth->getStorage()->write($data);
			}
			
			return $post["ema_id"];
		}
	}
	

	
	
// 	public function deleteEmail($ema_id){
		
// 		$emailTable = new Community_Model_EmailTable();
		
// 		$row = $emailTable->find($ema_id)->current();
		
// 		$row->usr_deleted = 1;
// 		$row->save();
// 	}	
}
