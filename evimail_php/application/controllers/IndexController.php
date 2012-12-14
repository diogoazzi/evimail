<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->_acl->allow(null);
    }

    public function indexAction()
    {
    	
        
    }

    public function processaSmtpAction()
    {
    	$auth = Zend_Auth::getInstance();
    	$identity = $auth->getIdentity();

    	$emailTable = new Fet_Model_EmailTable();
    	

    	$_config = Zend_Registry::get('config');
    	    	
    	$mail = new Zend_Mail_Storage_Imap(array('host'     => $_config->mail->host,
    	                                         'user'     => $_config->mail->evimail->user,
    	                                         'password' => $_config->mail->evimail->pass,
    											 'ssl' => 'SSL'));
    	$i = 1;
    	foreach ($mail as $message) {
    		//DEBUG Descomentar
    		if ($message->hasFlag(Zend_Mail_Storage::FLAG_SEEN)) {
    			continue;
    		}
			
    		
    		
//     		echo '<pre>';
//     		print_r($message);
    		
    		$recieved_arr = explode(',',$message->date);
    		$recieved_arr = explode('-', $recieved_arr[1]);
    		$recieved = trim($recieved_arr[0]);
			$recieved_obj = new Zend_Date(trim($recieved),"dd MMM YYYY HH:mm:ss");
    		$recieved = $recieved_obj->toString('YYYY-MM-dd HH:mm:ss');
    		
    		$from_arr = explode('<',$message->from);
    		if(count($from_arr) > 1)
    			$from = str_replace('>','',$from_arr[1]);
    		
    		//DEBUG REMVER
//     		if($message->from != 'caseirom@yahoo.com' && $from != 'caseirom@yahoo.com')
//     			continue;

    		//TODO: fazer tratativa de varios to
//     		$to_arr = explode('<',$message->to);
//     		if(count($to_arr) > 1)
//     			$to = str_replace('>','',$to_arr[1]);

    		//TODO: fazer tratativa de varios cc
    		$cc = null;
    		if(isset($message->cc)) {
    			$cc = $message->cc;
// 	    		$cc_arr = explode('<',$message->cc);
// 	    		$cc = str_replace('>','',$cc_arr[1]);
    		}
    		
    		//TODO: fazer tratativa de bcc nao consta no header bcc
//     		echo '<pre>';
//     		print_r($message->cco);
//     		$bcc_arr = explode('<',$message->bcc);
//     		$bcc = str_replace('>','',$bcc_arr[1]);
    		
    		$usrProfile = new Fet_Controller_Helper_UserProfile();
    		$user = $usrProfile->getUserByEmail($from);
    		
    		
    		//usuario nao encontrado nao salva email
    		if(!$user) {
    			$emailAdicionalTable = new Fet_Model_EmailAdicionalTable();
    			$emailsAdicionais = $emailAdicionalTable->getAllEmailAdicionais(array('email' => $from),true);
	
    			if(!$emailsAdicionais || ! count($emailsAdicionais)> 0 )
    				continue;
    			
    			$user = $usrProfile->getUserById($emailsAdicionais[0]->usr_id);
    			
    			if(!$user)
    				continue;
    		}
    		
    		$usr_id = $user->usr_id;
    		
    		$hash = md5($from.$recieved.$this->getBody($message));
    		$pathBase = pathinfo(__FILE__);
    		$pathBase = $pathBase['dirname'];
    		$path = $pathBase.'/../../public/pdf/'.$user->usr_id.'/'.$hash.'/';
    		 
		    
    		// Check for attachment
		    $y = 0;
    		if($message->isMultipart())
    		{    			
    			$totalAttachements = $message->countParts();
    			
    			for($i=2;$i<= $totalAttachements;$i++){
    				$part = $message->getPart($i);
    				 
    				$text = false;
    				if (strtok($part->contentType, ';') == 'text/plain' || strtok($part->contentType, ';') == 'text/html') {
    					try {
    						$fileName = $part->getHeader('content-disposition');
    						$fileName = explode('filename=',$fileName);
    						$fileName = str_replace('"','', $fileName[1]);
    					} catch (Exception $e){
    						$fileName = 'anexo'.$y.'.txt';
    					}
    					
    					$text = true;
    				}

    				$base64 = false;
    				try {
    				if($part->getHeader('content-transfer-encoding') == 'base64')
    					$base64 = true;
    				} catch (Exception $e){
    					
    				}
					if(!$text) {
	    				try {
	    					$fileName = $part->getHeader('content-disposition');
	    					$fileName = explode('filename=',$fileName);
	    					$fileName = str_replace('"','', $fileName[1]);
	    				} catch (Exception $e) {
							$fileName = $part->getHeader('content-type');
							$fileName = explode('name=',$fileName);
							$fileName = str_replace('"','', $fileName[1]);
	    				}
					}
//     				echo '<pre>';
//     				echo $message->subject.'#<br>';
//     				echo $i.' parte <br>';
//     				echo $base64.': base64<br>';
//     				echo 'fileName: '.$fileName.'<br><hr><br>';
//     				continue;
    				
    				if(!file_exists($path))
    					mkdir($path, 0755,true);
    				 
    				// Get the attachement and decode
    				if($base64)
    					$attachment = base64_decode($part->getContent());
    				else
    					$attachment = $part->getContent();
    				 
    				// Save the attachment
    				$fh = fopen($path.$fileName, 'w');
    				fwrite($fh, $attachment);
    				fclose($fh);
    			}
    			$y++;
    		}

		    $mensagem = $this->getBody($message);
		    
		    //email jah cadastrado nao salva
		    if($emailTable->verificaByHash($hash))
		    	continue;
		    
		    echo "Armazenando email...";
		    $userData =  Array(
		    		'ema_emailfrom' => $from ,
		    		'ema_emailto'	=> $message->to,
		    		'ema_cc' => $cc,
// 		    		'ema_bcc' => $bcc,
		    		'ema_subject' => $message->subject,
		    		'ema_senddate' => $recieved,
		    		'ema_confirmed' => Fet_Model_EmailTable::EMAIL_NAO_ENVIADO,
		    		'ema_usr_id' => $usr_id,
		    		'ema_body' => $this->getBody($message),
		    		'ema_hash' => $hash
		    );
		    $emailSaved = $emailTable->createEmail($userData);
		    

		    $auth_key = $user->usr_activeKey;

		    $creditTable = new Fet_Model_CreditTable();
		    $totalCredito = $creditTable->getTotalCreditosDisponiveis($usr_id);
		    
		    
		    $emailMsg = "Voc&ecirc;  acaba de receber novo email no seu evimail.<br>".
				    "Voc&ecirc;  possui um total de $totalCredito cr&eacute;ditos.<br>".
				    'Clique <a href="http://evimail.local/minha-conta/visualiza-laudo/activeKey/'.$auth_key.'/ema_id/'.$emailSaved.'/usr_email/'.$from.'"> aqui </a> para visualiza-lo.<br>';
		    

            $_config = Zend_Registry::get('config');
		    
		    $config = array('auth' => 'login',
		    		'username' => $_config->mail->contato->user,
		    		'password' => $_config->mail->contato->pass,
		    		'ssl' => 'tls',
		    		'port' => 587);
		    
		    $transport = new Zend_Mail_Transport_Smtp($_config->mail->host, $config);
		    
		    //$html_body = "<html>".'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.$message->subject ."<br><br>".$emailMsg;
            $data['msg'] = $emailMsg;
            $data["url"] = "http://".$_SERVER["SERVER_NAME"];
            $data["usuario"] = $user->usr_name;
            $data["title"] = 'EviMail - PDF - '.$message->subject;

            $view = Zend_Registry::get("view");
            $view->data = $data;
            $html_body = $view->render("mail/confirmacao_cadastro.phtml");

		    $mail = new Zend_Mail("UTF-8");
		    $mail->setType(Zend_Mime::MULTIPART_RELATED);
		    $mail->setBodyHtml($html_body);
		    
		    $mail->setFrom($_config->mail->contato->from, $_config->mail->contato->name);
		    
		    
		    $emailAdicionalTable = new Fet_Model_EmailAdicionalTable();
		    $emailsAdicionais = $emailAdicionalTable->getAllEmailAdicionais(array('usr_id' => $user->usr_id),true);
		    	
		    $mail->addTo($from);

		    foreach($emailsAdicionais as $_emailAdicional){
		    	if($_emailAdicional->email == $from)
		    		continue;
		    	$mail->addTo($_emailAdicional->email);
		    }
		    
		    $mail->setSubject('EviMail - PDF - '.$message->subject);
		    $mail->send($transport);
		    
		    
// 		    die('acaba aqui a rotina de processa smtp');
			//fim		    
			continue;		    
		    die('acaba aqui a rotina de processa smtp');
		     		       
		    		    $i++;
    	}
    	
    	die('fim do processamento SMTP');
    }
    
    public function getBody(Zend_Mail_Message $message)
    {
    	// find body
    	$part = $message;
    	$isText = true;
    	while ($part->isMultipart()) {
    		$foundPart = false;
    		$iterator = new RecursiveIteratorIterator($message);
    		foreach ($iterator as $part) {
    			// this detection code is a bit rough and ready!
    			
    				if (strtok($part->contentType, ';') == 'text/html') {
    					$foundPartHtml = $part;
    					$isHtml = true;
    				} else if (strtok($part->contentType, ';') == 'text/plain') {
    					$foundPartText = $part;
    					$isText = true;
    				}
    		}
    
    		if($isHtml) {
    			$part = $foundPartHtml;
    			break;
    		} else if($isText){
    			$part = $foundPartText;
    			break;
    		}
    	}
    	$body = quoted_printable_decode($part->getContent());
    	return $body;  
    }

    public function termosAction(){

    }
    
    public function politicaPrivacidadeAction(){

    }

    public function faleconoscoAction(){
        
    }

    public function perguntasFrequentesAction(){
        
    }

    public function quemsomosAction(){
        
    }    

    public function vantagensAction(){
        
    }

    public function melhorplanoAction(){
        
    }

    public function modelolaudoAction(){
        
    }    
}

