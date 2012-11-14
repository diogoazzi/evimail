<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initConfig()
	{
		$config = new Zend_Config($this->getOptions());
		Zend_Registry::set('config', $config);
		return $config;
	}
	
	protected function _initPlugins() {
	
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Zend_Controller_Plugin_ErrorHandler());
		$front->registerPlugin(new Fet_Plugin_ViewSetup(),98);
	}
	
	protected function _initTranslate()
	{
	   try {
	     $translate = new Zend_Translate('Array', APPLICATION_PATH . '/languages/pt_BR/Zend_Validate.php', 'pt_BR');
	     Zend_Validate_Abstract::setDefaultTranslator($translate);
	   } catch(Exception $e) {
	     die($e->getMessage());
	  }
	}
	
	protected function _initActionHelpers()
	{
		Zend_Controller_Action_HelperBroker::addPath('Fet/Controller/Helper', 'Fet_Controller_Helper');
	}
	
	protected function _initView()
	{
		$view = new Zend_View();
		$view->addBasePath(APPLICATION_PATH.DIRECTORY_SEPARATOR.'views');
		Zend_Registry::set('view', $view);
		return $view;
	}
	
	protected function _initRoutes()
	{
		$config = new Zend_Config_Ini (
		APPLICATION_PATH . '/configs/routes.ini', 'production'
		);
		$frontController = Zend_Controller_Front::getInstance();
		$router = $frontController->getRouter();
		$router->addConfig( $config, 'routes' );
	}
	
}

