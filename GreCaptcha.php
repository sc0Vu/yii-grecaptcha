<?php

/**
 * @author Peter Lai
 * @email alk03073135@gmail.com
 * @licence MIT
 * @more details https://www.google.com/recaptcha/intro/index.html
 **/
class GreCaptcha extends CInputWidget 
{
	// script id
	public $scriptId = 'recaptcha-sdk';
	
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
	
	// render
	public $render = 'explicit';
	
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
	
	// pjax render
	public $isPjax = false;
	
	// gereCaptcha language default zh-TW see more https://developers.google.com/recaptcha/docs/language
	public $language = 'zh-TW';
	
	protected $errNotSet = 'Please set publicSiteKey or sorceUrl.';
	
	public function init() 
	{
		if (empty($this->siteKey) || empty($this->sorceUrl)) {
			throw new CHttpException(404, $this->errNotSet);
		} else {
			$srcUrl = $this->sorceUrl . '?onload=captchaCallBack&render='.$this->render.'&hl=' . $this->language;
			if (!$this->pjax) {
				Yii::app()->getClientScript()->registerScriptFile($srcUrl, CClientScript::POS_END, array('async'=>$this->async, 'defer'=>$this->defer));
			} else {
				$script = <<<SCRIPT
				(function(d,s,id,a,b){
					if (d.getElementById(id)) return;
					b = d.getElementsByTagName(s)[0];
					a = d.createElement(s);
					a.src = {$srcUrl};
					a.async = {$this->async};
					a.defer = {$this->defer};
					b.parentNode.insertBefore(a,b);
				})(docement,'script','{$this->scriptId}');
SCRIPT;
				echo CHtml::tag('script', array('src'=>$srcUrl, 'async'=>$this->async, 'defer'=>$this->defer), false, true);
			}
		}
	}
	
	public function run()
	{
		$grecaptchaJs = <<<SCRIPT
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
SCRIPT;
		if (!$this->pjax) {
			Yii::app()->getClientScript()->registerScript(get_class($this), $grecaptchaJs, CClientScript::POS_HEAD);
		} else {
			echo CHtml::tag('script', array(), $grecaptchaJs, true);;
		}
		
        echo CHtml::tag('div', array('id'=>$this->id), '', true);
	}
}
?>