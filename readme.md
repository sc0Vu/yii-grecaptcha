yii-grecaptcha usage instructions

1.check source code and google reCaptcha
2.get reCaptcha sitekey and privatekey(https://www.google.com/recaptcha/admin)
3.import GreCaptcha and GreCaptchaValidator
4.use in view
<?php $this->widget('extensions.grecaptcha.GreCaptcha',
		                    array(
							'model'=>$model,
							'siteKey'=>'your site key',
							)); ?>
5.use in model
public $reCaptcha;
public function rules() {
    return array(
	    array('reCaptcha', 'extensions.grecaptcha.GreCaptchaValidator', 'privateKey'=>'6Lf-fQoTAAAAAC3XpWFFTUakT9SmJ88ghyh_i1JC', 'on'=>'login'),
	)
} 