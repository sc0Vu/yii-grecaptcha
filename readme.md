<h2>yii-grecaptcha usage instructions</h2>
<ol>
<li>check source code and google reCaptcha</li>
<li>get reCaptcha sitekey and privatekey(<a href="https://www.google.com/recaptcha/admin" target="_blank">reCaptcha admin</a>)</li>
<li>import GreCaptcha and GreCaptchaValidator</li>
<li>use in view
<code><?php $this->widget('extensions.grecaptcha.GreCaptcha',
		                    array(
							'model'=>$model,
							'siteKey'=>'your site key',
							)); ?></code></li>
<li>5.use in model
<code>
public $reCaptcha;
public function rules() {
    return array(
	    array('reCaptcha', 'extensions.grecaptcha.GreCaptchaValidator', 'privateKey'=>'6Lf-fQoTAAAAAC3XpWFFTUakT9SmJ88ghyh_i1JC', 'on'=>'login'),
	)
} </code></li>
</ol>