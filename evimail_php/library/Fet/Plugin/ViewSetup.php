<?php

class Fet_Plugin_ViewSetup extends Zend_Controller_Plugin_Abstract
{

	protected $_view;

	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
	{
		$acl = new Fet_Model_Acl();
		$aclHelper = new Fet_Controller_Helper_Acl(null, array('acl'=>$acl));
		Zend_Controller_Action_HelperBroker::addHelper($aclHelper);		 
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$this->_assignAuth();
		$this->_assignTranslate();
	}

	protected function _assignAuth(){

		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		
		$viewRenderer->init();
		$view = $viewRenderer->view;
		$this->_view = $view;
		
		$auth = Zend_Auth::getInstance();
		$this->_view->assign('auth',$auth->getStorage ()->read ());
		
	}

	protected function _assignTranslate(){
		
		if (isset($_GET['l']) && in_array($_GET['l'], array('en', 'pt'))) {
			$locale = new Zend_Locale($_GET['l']);
			$_SESSION['language'] = $locale;
		} else {
			if (isset($_SESSION['language'])) {
				$locale = new Zend_Locale($_SESSION['language']);
			} else {
				try {
					$locale = new Zend_Locale('browser');
				} catch (Zend_Locale_Exception $e) {
					$locale = new Zend_Locale('pt');
				}
				$_SESSION['language'] = $locale;
			}
		}
		
		$translate = new Zend_Translate(
			array(
    	            'adapter' => 'csv',
    	            'content' => '../application/languages/pt_BR/lang.csv',
    	            'locale'  => 'pt'
			)
		);
		$translate->addTranslation(
			array(
	    	        'content' => '../application/languages/en_EN/lang.csv',
	    	        'locale' => 'en'
			)
		);
			
		$translate->setLocale($locale);
		
		Zend_Registry::set('translate', $translate);
		
		if($_SESSION['language'] == 'en_US' ){
			$_SESSION['language'] = 'en';
		}
		if($_SESSION['language'] == 'pt_BR' ){
			$_SESSION['language'] = 'pt';
		}

		
		if($_SESSION['language'] != 'pt'){
			$_SESSION['imageDir'] = $_SESSION['language']."/";
		} else {
			$_SESSION['imageDir'] = '';
		}
		
		$this->_view->assign('translate',$translate);
	}	
}