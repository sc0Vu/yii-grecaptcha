<?php

/**
 * @author Peter Lai
 * @email alk03073135@gmail.com
 * @licence MIT
 * @more details https://www.google.com/recaptcha/intro/index.html
 **/ 
 
// require recaptcha autoload.php
require_once __DIR__ . '/src/autoload.php';

class GreCaptchaValidator extends CValidator
{
	// private key
    protected $privateKey='';
	
	// show recaptcha error detail
	protected $errorDetail = false;
	
	protected function validateAttribute($object,$attribute)
	{
	    $recaptcha = new \ReCaptcha\ReCaptcha($this->privateKey);
		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		
		if (!$resp->isSuccess()) {
			if (!$this->errorDetail) {
				$message = $this->message !== null ? $this->message : Yii::t('yii','The verification code is incorrect.');
			} else {
				foreach ($resp->getErrorCodes() as $error) {
					$message = $this->message . $error . ' ';
				}	
			}			
			$this->addError($object, $attribute, $message);
		}
	}
}