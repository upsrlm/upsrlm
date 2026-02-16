<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace sakhi\widgets;
use yii;

class AudioLable extends \yii\base\Widget {

    public $lable;
    public $token;

    public function run() {

        $this->label = 'X';
        $this->options['type'] = 'button';
        $this->options['class'] = 'btn btn-sm btn-danger float-right';
        $this->tokenname = Yii::$app->request->csrfParam;
        $this->token =  Yii::$app->request->csrfToken;
        
        $view = $this->getView();
        $id = $this->options['id'];
        $value = $this->options['value'];
        $js = "
        $('#{$id}').click(function(e){
            var removeOk = confirm('क्या आप निश्चित रूप से इस को हटा रहे हैं ?');
            if(removeOk){
                jQuery.ajax({
                url: '{$value}',
                    type: 'POST',
                    data: {'removeRequest': 1, '{$this->tokenname}': '{$this->token}'},
                    dataType: 'json',
                    success: function (data) {
                        if(data.success === true){
                            history.go(-1);
                            console.log('req 1');
                        }
                    },
                    error  : function (e)
                    {
                        console.log(e);
                    }   
                });
            }
        });
        ";

        $view->registerJs($js);

        return parent::run();
    }

}
