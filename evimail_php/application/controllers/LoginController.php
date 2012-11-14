<?php

/**
 * Controller for Login
 *
 * @package Fet
 * @author Alvaro Batelli
 * @version 1.0
 *
 */
class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->_acl->allow(null);
    	//$this->view->assign('renderBuscaRapida', false);

    }


    public function indexAction()
    {
    	$formLogin = new Application_Form_LoginAnunciante();

    	 if ($this->_request->isPost()) {

    	 	//Se o form estiver valido armazeno na session para recuperar os dados depois e finalizar o cadastro.
            if ($formLogin->isValid($this->_request->getPost())) {

           		$Session = new Zend_Session_Namespace('Login');
    	 		$Session->formLogin = $formLogin;

			   /*
			    * Todo: chamar model passando os valores validar user e senha
			    * identificar se o campo de identificacao eh cpf ou email
			    *
			    */
               // $values = $formNovoAnunciante->getValues();
               //$tableAnuncianteCadastro = new Application_Model_AnuncianteCadastro_DbTable();
               // $tableAnuncianteCadastro->insert($values);

               //Se for valido direcionar para  pagina de adminstracao do usuario
                $this->_helper->redirector('adminAnunciante');
                exit;
            }
        }

        $this->view->formNovoAnunciante = $formNovoAnunciante;
    }


}