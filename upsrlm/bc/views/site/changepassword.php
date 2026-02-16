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
<div class='changepasswordform'>
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <!--Basic tables-->
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        <?= $this->title ?>
                    </h2>

                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <?php
                        $form = ActiveForm::begin([
                                    'id' => 'change-password-form',
                                    'options' => ['class' => 'form-horizontal'],
                                    'fieldConfig' => [
                                        'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div >{error}</div>",
                                        'labelOptions' => ['class' => 'col-md-3 control-label'],
                                    ],
                                    'enableAjaxValidation' => true,
                                    'enableClientValidation' => false,
                        ]);
                        ?>

                        <?= $form->field($user, 'new_password')->passwordInput(['placeholder' => 'New Password']) ?>
                        <?= $form->field($user, 're_password')->passwordInput(['placeholder' => 'Repeat Password']) ?>
                        <hr/>

                        <?= $form->field($user, 'current_password')->passwordInput(['placeholder' => 'Current Password']) ?>

                        <div class="form-group">
                            <div class="col-sm-offset-4 ">
                                <?= Html::submitButton('Save', ['class' => 'btn btn-info']) ?><br>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>        
<?php
$css = <<<css
   div.required label.control-label:after {
    content: " *";
    color: red;
}
css;
$this->registerCss($css);
?>
