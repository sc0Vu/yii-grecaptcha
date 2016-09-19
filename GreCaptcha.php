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

    // render method explicit, onload
    public $render = 'explicit';

    //tabindex of the widget
    public $tabindex = 0;

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

    // error message
    protected $errNotSet = 'Please set public SiteKey or sorceUrl.';

    public function init()
    {
        if (empty($this->siteKey) || empty($this->sorceUrl)) {
            throw new CException($this->errNotSet);
        } else {
            $srcUrl = sprintf('%s?onload=captchaCallBack&render=%s&hl=%s', $this->sorceUrl, $this->render, $this->language);
            if (!$this->isPjax) {
                Yii::app()->getClientScript()->registerScriptFile($srcUrl, CClientScript::POS_END, ['async' => $this->async, 'defer' => $this->defer]);
            } else {
                $script = <<<SCRIPT
				(function(d,s,id,a,b){
					if (d.getElementById(id)) return;
					b = d.getElementsByTagName(s)[0];
					a = d.createElement(s);
					a.src = "{$srcUrl}";
					a.async = {$this->async};
					a.defer = {$this->defer};
					b.parentNode.insertBefore(a,b);
				})(document,'script','{$this->scriptId}');
SCRIPT;
                echo CHtml::tag('script', [''], $script, true);
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
				'tableindex' : {$this->tabindex},
				'callback' : {$this->callback},
				'expired-callback' : {$this->expiredCallback},
              });
            }; 
SCRIPT;
        $noscript = <<<NOSCRIPT
<noscript>
  <div>
    <div style="width: 302px; height: 422px; position: relative;">
      <div style="width: 302px; height: 422px; position: absolute;">
        <iframe src="https://www.google.com/recaptcha/api/fallback?k={$this->siteKey}"
                frameborder="0" scrolling="no"
                style="width: 302px; height:422px; border-style: none;">
        </iframe>
      </div>
    </div>
    <div style="width: 300px; height: 60px; border-style: none;
                   bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px;
                   background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">
      <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                   class="g-recaptcha-response"
                   style="width: 250px; height: 40px; border: 1px solid #c1c1c1;
                          margin: 10px 25px; padding: 0px; resize: none;" >
      </textarea>
    </div>
  </div>
</noscript>
NOSCRIPT;
        if (!$this->isPjax) {
            Yii::app()->getClientScript()->registerScript(get_class($this), $grecaptchaJs, CClientScript::POS_HEAD);
        } else {
            echo CHtml::tag('script', [], $grecaptchaJs, true);
        }

        echo CHtml::tag('div', ['id' => $this->id], '', true);
        echo $noscript;
    }
}
