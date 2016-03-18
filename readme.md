<h2>yii-grecaptcha usage instructions</h2>
<ol>
<li>support pjax usage</li>
<li>check source code and <a href="https://developers.google.com/recaptcha/">google reCaptcha</a></li>
<li>get reCaptcha sitekey and privatekey form <a href="https://www.google.com/recaptcha/admin" target="_blank">reCaptcha admin</a></li>
<li>import GreCaptcha and GreCaptchaValidator</li>
<li>use in view</li>
<pre><?php $this->widget('extensions.grecaptcha.GreCaptcha',
		                    array(
							'model'=>$model,
                            'pjax'=>true,
							'siteKey'=>'your site key'
							)
                        );
</pre>
<li>use in model</li>
<pre>
public $reCaptcha;
public function rules() {
    return array(
	    array(
        'reCaptcha',
        'pathto GreCaptchaValidator',
        'privateKey'=>'your private key',
        'on'=>'your action'
        )
	)
}
</pre>
</ol>