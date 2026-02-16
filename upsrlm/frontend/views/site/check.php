<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\password\PasswordInput;

/**
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $model app\modules\user\models\ChangePasswordForm
 */
$this->title = 'Change Password';
$this->params['icon'] = 'fa fa-cog';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="about_home">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <!--Basic tables-->
                        <div id="panel-1" class="panel ">
                            <div class="panel-hdr">
                                <h2>
                                    <?= $this->title ?>
                                </h2>

                            </div>
                            <div class="panel-container show">
                                <div class="panel-content">

                                    <form action="/api/convergent/otp" method="post">
                                        
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Mobile No</label>
                                            <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobole No">
                                        </div>
                                       
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> 
    </div>  
</section>    
<?php
$css = <<<css
   div.required label.control-label:after {
    content: " *";
    color: red;
}
css;
$this->registerCss($css);
?>
