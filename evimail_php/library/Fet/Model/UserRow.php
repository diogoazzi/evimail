<?php
class Fet_Model_UserRow extends Zend_Db_Table_Row
{
	var $staId;
	var $userImage;
	var $month = array(
						"01" => "Janeiro","02" => "Fevereiro", "03" => "março", "04" => "Abril", 		
						"05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto",
						"09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro"   	 
	);
	
	public function getUserImage(){
		if($this->img_id){
			if(!$this->userImage){
				$photo = new Community_Model_PhotoTable();
				$this->userImage = $photo->find($this->img_id)->current();
			}
			return $this->userImage;
		}
	}
	
	
	public function getNomeCidade()
	{
	
		if( $this->cit_id != "" ){
			$city = new Community_Controller_Action_Helper_Citytable();
			$dataCity = $city->getCityById( $this->cit_id );
			$cit_name = $dataCity->cit_name;
			$this->staId = $dataCity->sta_id;
		}
		return $cit_name;
	
	}
	
	public function getNomeEstado()
	{
	
		$city = new Community_Controller_Action_Helper_Citytable();
		$dataState = $city->getStateById( $this->staId );
		return $dataState[0]["sta_name"];
	
	}
	
	public function getSiglaEstado( $sta_id = '' )
	{
		if( $this->staId != "" ){
			$city = new Community_Controller_Action_Helper_Citytable();
			$dataState = $city->getStateById( $this->staId );
		}
	
		return $dataState[0]["sta_acronym"];
	
	}
	
	public function getDataInscricao()
	{
		return date('d/m/Y', strtotime($this->usr_insertDate));
	}
	
	public function getAniversario()
	{
		$month =$this->month[date('m', strtotime($this->usr_birthDate))];
		return date('d \d\e ', strtotime($this->usr_birthDate))." ".$month;
	}
	
	public function getNascimento()
	{
		$month =$this->month[date('m', strtotime($this->usr_birthDate))];
		return date('d \d\e ', strtotime($this->usr_birthDate))." ".$month." de ".substr($this->usr_birthDate,0,4);
	}
	
	public function getIdade()
	{
		if($this->usr_birthDate){
			$dateObject = new Community_Controller_Action_Helper_DateObject();
			return $dateObject->getYearsOld($this->usr_birthDate);
		} else {
			return null;
		}
	}
	
	public function getSexo()
	{
		switch(strtolower($this->usr_gender))
		{
			case 'm':
				return 'Masculino';
				break;
	
			case 'f':
				return 'Feminino';
				break;
		}
	}

	
	public function getMaritalStatus()
	{
		switch($this->usr_maritalStatus)
		{
			case '1':
				return 'Casado';
				break;
			case '2':
				return 'Divorciado';
				break;
			case '3':
				return 'Solteiro';
				break;
			case '4':
				return 'Outro';
				break;
		}
	}
	
}
