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
//     	$emailRow = new Fet_Model_EmailRow();
//     	$emailRow->
    	
    	$emailTable = new Fet_Model_EmailTable();
    	
    	$userData =  Array(
    		'ema_userfrom' => 'mario.caseiro@gmail.com',
    		'ema_userto' => 'evimail@webneural.com.br',
    		'ema_emailfrom' => 'Mario Caseiro' ,
    		'ema_emailto' => 'WEBNEURAL',
			'ema_subject' => 'teste 1',
    		'ema_senddate' => time(),
    		'ema_confirmed' => Fet_Model_EmailTable::EMAIL_NAO_ENVIADO,
    		'ema_usr_id' => 10,
    		'ema_usr_body' => 'FoooBar lkasjldkjasldkjasdlkajsdlakjdlaskjdladsjk'	    			
		);
    	$emailTable->createEmail($userData);
    	
    	die('sssss');
    	require_once("Dompdf/dompdf_config.inc.php");
    	
    	$mail = new Zend_Mail_Storage_Imap(array('host'     => 'imap.gmail.com',
    	                                         'user'     => 'evimail@webneural.com',
    	                                         'password' => 'y2s2r2i4',
    											 'ssl' => 'SSL'));
    	$i = 1;
    	foreach ($mail as $message) {
    		if ($message->hasFlag(Zend_Mail_Storage::FLAG_SEEN)) {
    			continue;
    		}
    		//echo "------------MENSAGEM ---------------<br>\n";
		    //echo $message->subject . "<br>\n";
		    //echo $message->contentType."<br>\n";
			
		    echo $message->from."<br>\n";
		    
		    if( isset($message->cc) ) {
		    	//echo $message->cc."<br>\n";
		    }
		    
//		    echo "----> FULL BODY:<br>\n";
//		    echo quoted_printable_decode($message->getContent())."<br><br>\n";
		    
		    //echo "----> PARTS:<br>\n";
		    //TODO: get atttachements
		    $mensagem = $this->getBody($message);
		    //echo $mensagem."<br>\n";
		    
		    echo "Armazenando email...";
    		//TODO: GUARDAR EMAIL COM CORPO
		       
		    //TODO: verificar creditos
		    
		    $dompdf = new DOMPDF();
		    $dompdf->load_html($mensagem);
		    $dompdf->set_paper('letter', 'landscape');
		    $dompdf->render();
		    
		    $pdf = $dompdf->output();
		    file_put_contents($i.".pdf", $pdf);
		    

		    $config = array('auth' => 'login',
		                    'username' => 'evimail@webneural.com',
		                    'password' => 'y2s2r2i4',
		    				'ssl' => 'tls',
		    				'port' => 587);
		    
		    $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
		    
		    $html_body = $message->subject ."<br><br>".$mensagem;
		    $mail = new Zend_Mail();
		    $mail->setType(Zend_Mime::MULTIPART_RELATED);
		    $mail->setBodyHtml($html_body);
		    
		    $mail->setFrom('evimail@webneural.com', 'EviMail');
// 		    $mail->addTo("diogo.azzi@webneural.com");
// 		    $mail->addTo("diogoafe@gmail.com");
		    $mail->addTo("evimailm@gmail.com");
		    $mail->setSubject('EviMail - PDF - '.$message->subject);
		    $file = $mail->createAttachment($pdf);
		    $file->filename = $i.".pdf";
		    $mail->send($transport);
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

