<?php

class Fet_Controller_Helper_InterMail extends Zend_Controller_Action_Helper_Abstract
{
	public function send($to, $subject, $contentPath, $data=array(), $server="mail1")
	{
			$config = Zend_Registry::get("config");
			$mailConfig = $config->mail;
			
			if ($mailConfig->smtp){
				if($mailConfig->transport=="Amazon")
				{
					$transport = new Amazon_Mail_Transport_AmazonSES(array('accessKey'=>$mailConfig->smtpconfig->username,'privateKey'=>$mailConfig->smtpconfig->password));
				}else{
					$transport = new Zend_Mail_Transport_Smtp($mailConfig->host, $mailConfig->smtpconfig->toArray());
				}
	 		}else{
				$transport = new Zend_Mail_Transport_Sendmail();
	      		}

	        	Zend_Mail::setDefaultTransport($transport);

	        	
			$translate = Zend_Registry::get('translate');
	        
			$view = Zend_Registry::get("view");
			$view->data = $data;
			$view->translate = $translate;
			$content = $view->render($contentPath);
			
			$mail = new Zend_Mail("UTF-8");
			$mail->setFrom($mailConfig->mailfrom, $mailConfig->from);
			$mail->addTo($to);
			$mail->setSubject($subject);
			$mail->setBodyHtml($content);

			$mail->send();

		
	}
	
}
