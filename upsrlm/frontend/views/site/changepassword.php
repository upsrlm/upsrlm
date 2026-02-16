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
                                    <?php
                                    $form = ActiveForm::begin([
                                                'id' => 'change-password-form',
                                                'options' => ['class' => 'form-horizontal'],
                                                'fieldConfig' => [
                                                    'template' => "{label}\n<div >{input}</div>\n<div >{error}</div>",
                                                    'labelOptions' => ['class' => ' control-label'],
                                                ],
                                                'enableAjaxValidation' => true,
                                                'enableClientValidation' => false,
                                    ]);
                                    ?>
                                    <?=
                                    $form->field($user, 'new_password')->widget(PasswordInput::classname(), [
                                        'options' => ['placeholder' => 'New Password'],
                                        'pluginOptions' => ['showMeter' => false]
                                    ]);
                                    ?>
                                    <?=
                                    $form->field($user, 're_password')->widget(PasswordInput::classname(), [
                                        'options' => ['placeholder' => 'Repeat Password'],
                                        'pluginOptions' => ['showMeter' => false]
                                    ]);
                                    ?>
                                    <?=
                                    $form->field($user, 'current_password')->widget(PasswordInput::classname(), [
                                        'options' => ['placeholder' => 'Current Password'],
                                        'pluginOptions' => ['showMeter' => false]
                                    ]);
                                    ?>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 ">
                                            <?= Html::submitButton('Save', ['class' => 'btn btn-info py-2 px-3']) ?><br>
                                        </div>
                                    </div>

                                    <?php ActiveForm::end(); ?>
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
