<?php

class HomeController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_helper->_acl->allow(null);
    }

    public function indexAction()
    {
        // action body
    }


}

