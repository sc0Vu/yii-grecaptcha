<?php

/**
 * @author Peter Lai
 * @email alk03073135@gmail.com
 * @licence MIT
 * @more details https://www.google.com/recaptcha/intro/index.html
 **/
class GreCaptcha extends CInputWidget 
{
	// render id
	public $id = 'greCaptcha';
	
	// site key
	public $siteKey = '';
	
	// light, dark
	public $theme = 'light';
	
	// image, audio
	public $type = 'image';
	
	// normal, compact
	public $size = 'normal';
	
	public $tableindex = 0;
	
	// success callback function, 'function(){alert("Success")}';
	public $callback = "''";
	
	// expired call back function, 'function(){alert("Expired")}';
	public $expiredCallback = "''";
	
	// google recaptcha sorce
	public $sorceUrl = 'https://www.google.com/recaptcha/api.js';
	
	// async load javascript
	public $async = true;
	
	// defer load javascript
	public $defer = true;
	
	// gereCaptcha language default zh-TW see more https://developers.google.com/recaptcha/docs/language
	public $language = 'zh-TW';
	
	protected $errNotSet = 'Please set publicSiteKey or sorceUrl.';
	
	public function init() 
	{
		if (empty($this->siteKey) || empty($this->sorceUrl)) {
			throw new CHttpException(404, $errNotSet);
		} else {
			Yii::app()->getClientScript()->registerScriptFile($this->sorceUrl . '?onload=captchaCallBack&render=explicit&hl=' . $this->language, CClientScript::POS_END, array('async'=>$this->async, 'defer'=>$this->defer));
		}
	}
	
	public function run()
	{
		$grecaptchaJs =<<<EOP
		      var captchaCallBack = function() {
              grecaptcha.render('{$this->id}', {
                'sitekey' : '{$this->siteKey}',
				'theme' : '{$this->theme}',
				'type' : '{$this->type}',
				'size' :'{$this->size}',
				'tableindex' : {$this->tableindex},
				'callback' : {$this->callback},
				'expired-callback' : {$this->expiredCallback},
              });
            }; 
EOP;
		Yii::app()->getClientScript()->registerScript(get_class($this), $grecaptchaJs, CClientScript::POS_HEAD);
        echo CHtml::tag('div', array('id'=>$this->id), '', true);
	}
}
?>