<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace sakhi\widgets;

use \yii\bootstrap4\ActiveForm;

class ActiveMobileForm extends \yii\bootstrap4\ActiveForm
{

    public function run()
    {


        if ($this->enableClientScript) {
            $view = $this->getView();
            $view->registerJs(
                " 
                $('form').on('beforeSubmit',function(e) {
                    var form =$(this);
                    formdata = new FormData(form[0]);
                    formdata.append('SubmitRequest', '1');
                    jQuery.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: formdata,
                        mimeType: 'multipart/form-data',
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: function (data) {
                            if(data.success === true){
                         if( typeof data.redirecturl !== 'undefined'){
                                  window.location = data.redirecturl;
                          } else{      
                                if( typeof data.webview !== 'undefined'){
                                    closeScreen(data.message);
                                } else {
                                    history.go(-1);
                                   console.log('req 1');
                                 }
                            }
                            }else{
                                runformupdatefunction(data);
                            }
                            
                        },
                        error  : function (e)
                        {
                            console.log(e);
                        }   
                    });
                    return false;        
                }).on('submit', function(e){
                    e.preventDefault();
                })
            ;"
            );
        }
        return parent::run();
    }
}
