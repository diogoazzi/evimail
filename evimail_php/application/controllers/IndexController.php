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
    	
    	$mail = new Zend_Mail_Storage_Imap(array('host'     => 'imap.gmail.com',
    	                                         'user'     => 'evimail@webneural.com',
    	                                         'password' => 'y2s2r2i4',
    											 'ssl' => 'SSL'));
    	$i = 1;
    	foreach ($mail as $message) {
    		if ($message->hasFlag(Zend_Mail_Storage::FLAG_SEEN)) {
    			continue;
    		}
    		
    		$recieved_arr = explode(',',$message->date);
    		$recieved_arr = explode('-', $recieved_arr[1]);
    		$recieved = trim($recieved_arr[0]);
			$recieved_obj = new Zend_Date(trim($recieved),"dd MMM YYYY HH:mm:ss");
    		$recieved = $recieved_obj->toString('YYYY-MM-dd HH:mm:ss');
    		
    		$from_arr = explode('<',$message->from);
    		$from = str_replace('>','',$from_arr[1]);
    		
    		$usrProfile = new Fet_Controller_Helper_UserProfile();
    		$user = $usrProfile->getUserByEmail($from);
    		
    		//usuario nao encontrado nao salva email
    		if(!$user)
    			continue;
    		
    		$usr_id = $user->usr_id;
		    
		    //TODO: get atttachements
		    $mensagem = $this->getBody($message);
		    
		    //email jah cadastrado nao salva
		    $hash = md5($from.$recieved.$this->getBody($message));
		    if($emailTable->verificaByHash($hash))
		    	continue;
		    
		    echo "Armazenando email...";
		    $userData =  Array(
		    		'ema_emailfrom' => $from ,
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
		    
		    
		    $emailMsg = "Você acaba de receber novo email no seu evimail.<br>".
				    "Você possui um total de $totalCredito créditos.<br>".
				    'Clique <a href="http://evimail.local/minha-conta/visualiza-laudo/activeKey/'.$auth_key.'/ema_id/41/usr_email/'.$from.'"> aqui </a> para visualiza-lo.<br>';
		    
		    
		    $config = array('auth' => 'login',
		    		'username' => 'evimail@webneural.com',
		    		'password' => 'y2s2r2i4',
		    		'ssl' => 'tls',
		    		'port' => 587);
		    
		    $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
		    
		    $html_body = "<html>".'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.$message->subject ."<br><br>".$emailMsg;
		    $mail = new Zend_Mail();
		    $mail->setType(Zend_Mime::MULTIPART_RELATED);
		    $mail->setBodyHtml($html_body);
		    
		    $mail->setFrom('evimail@webneural.com', 'EviMail');
		    $mail->addTo($from);
		    $mail->setSubject('EviMail - PDF - '.$message->subject);
		    $mail->send($transport);
		    
		    
		    die('acaba aqui a rotina de processa smtp');
			//fim		    
			continue;		    
		    die('acaba aqui a rotina de processa smtp');
		     		       
		    		    $i++;
    	}
    	
    	die('a');
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
    
}

