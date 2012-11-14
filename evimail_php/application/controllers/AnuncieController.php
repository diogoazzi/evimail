<?php

/**
 * Controller for table tb_anuncio
 *
 * @package Fet
 * @author Alvaro Batelli
 * @version 1.0
 *
 */
class AnuncieController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->_acl->allow(null);
    	$this->view->assign('renderBuscaRapida', false);

    }

    public function indexAction()
    {
    	$formNovoAnunciante = new Application_Form_NovoAnuncianteCadastro();

    	 if ($this->_request->isPost()) {

    	 	//Se o form estiver valido armazeno na session para recuperar os dados depois e finalizar o cadastro.
            if ($formNovoAnunciante->isValid($this->_request->getPost())) {

           		$SessionAnuncianteCadastro = new Zend_Session_Namespace('FormNovoAnunciante');
    	 		$SessionAnuncianteCadastro->formNovoAnunciante = $formNovoAnunciante;
    	 		
    	 		print_r($formNovoAnunciante);die;

               // $values = $formNovoAnunciante->getValues();

               //$tableAnuncianteCadastro = new Application_Model_AnuncianteCadastro_DbTable();

               // $tableAnuncianteCadastro->insert($values);

                $this->_helper->redirector('passo1');
                exit;
            }
        }

        $this->view->formNovoAnunciante = $formNovoAnunciante;
    }

    public function convidadoAction()
    {
    	$formNovoAnunciante = new Application_Form_NovoAnunciante();

    	 if ($this->_request->isPost()) {

    	 	//Se o form estiver valido armazeno na session para recuperar os dados depois e finalizar o cadastro.
            if ($formNovoAnunciante->isValid($this->_request->getPost())) {

           		$SessionAnuncianteCadastro = new Zend_Session_Namespace('FormNovoAnunciante');
    	 		$SessionAnuncianteCadastro->formNovoAnunciante = $formNovoAnunciante;

               // $values = $formNovoAnunciante->getValues();

               //$tableAnuncianteCadastro = new Application_Model_AnuncianteCadastro_DbTable();

               // $tableAnuncianteCadastro->insert($values);

                $this->_helper->redirector('passo1');
                exit;
            }
        }

        $this->view->formNovoAnunciante = $formNovoAnunciante;
    }

	//exibe os planos de anuncio e planos de destaque
 	public function passo1Action()
    {
//$SessionAnuncianteCadastro->formNovoAnunciante;
    	//$formPlanosAnunciosDestaques = new Application_Form_PlanosAnunciosDestaques();

    	$formNovoAnuncianteCadastro = new Application_Form_NovoAnuncianteCadastro();

    	$formNovoAnuncianteCadastro->setValues();

    	 if ($this->_request->isPost()) {

    	 	//Se o form estiver valido armazeno na session para recuperar os dados depois e finalizar o cadastro.
            if ($formNovoAnunciante->isValid($this->_request->getPost())) {

           		$SessionAnuncianteCadastro = new Zend_Session_Namespace('AnuncianteCadastro');
    	 		$SessionAnuncianteCadastro->formNovoAnunciante = $formNovoAnunciante;

				//Obter o plano de anuncio e o plano de destaque selececionados
				//setar na sesssao e direcionar para o passo2 cadastro basico e pagueseguro

                $this->_helper->redirector('passo2');
                exit;
            }
        }

        $this->view->formNovoAnuncianteCadastro = $formNovoAnuncianteCadastro;

    }

	//exibe formulario de cadastro basico do usuario e as op��os de pagueseguro do pague seguro
    public function passo2Action()
    {
    	$formCadastroAnunciante = new Application_Form_CadastroAnunciante();

    	// instanciar form pagseguro
    	// ideia eh postar via ajax esse form de cadastro responder um json deixando o form desabilitado
    	// para o user continuar o pagamento no pagseguro

    	$this->view->formCadastroAnunciante = $formCadastroAnunciante;
    }

	// exibe a pagina de convidado para digitar o voucher
    public function convidado2Action()
    {
    	$formQueroAnunciarConvidadoCel   = new Application_Form_QueroAnunciarConvidadoCelular();
    	$formQueroAnunciarConvidadoEmail = new Application_Form_QueroAnunciarConvidadoEmail();

		if ($this->_request->isPost()) {

			//verificar qual dos dois formularios foram postados validar e gravar na sessao e direcionar para o passo2 - selecionar planos
			if($this->validarVoucher()){
				$this->_helper->redirector('passo2');
			}else{
				//setar msg de erro q o voucher eh invalido ou email ou telefone nao confere.
			}
		}

    	$this->view->formQueroAnunciarConvidadoCel   = $formQueroAnunciarConvidadoCel;
    	$this->view->formQueroAnunciarConvidadoEmail = $formQueroAnunciarConvidadoEmail;
    }

	//Este metodo eh chamado via ajax na pagina anuncie/convidado
	private function validarVoucher()
    {
		/**
		 * todo : verificar se eh convidado de via email ou sms e validar o codigo do voucher
		 */
		return true;
    }



}