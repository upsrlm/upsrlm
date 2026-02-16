<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php
$form = ActiveForm::begin([
            'id' => 'login-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'validateOnBlur' => false,
            'validateOnType' => false,
            'validateOnChange' => false,
        ])
?>
<h6>Please call in case of any issue : 92609 85122</h6>
<div class="app_form">
    <div id ="login_pwd" style="display:<?= $model->login_type == "1" ? "block" : "none" ?>;">
        <div class="form-group">

            <?=
            $form->field($model, 'username', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'placeholder' => 'Login', 'enableLabel' => false, 'template' => '<div class=\"\">{input}</div><div class=\"\">{error}</div>']]
            )->label('');
            ?>
        </div>
        <div class="form-group">

            <?=
                    $form->field(
                            $model, 'password', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => "Password"]])
                    ->passwordInput()
                    ->label(''
                    )
            ?>
<!--                                <input type="password" class="form-control" value="" placeholder="Password">-->

        </div>
        <div class="form-group">

            <div class="form-group form-check">
                <label class="form-check-label">
                    <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '1', 'class' => '', 'selected' => 'selected']) ?>
                </label>
                <!--<a href="#" class="forgot"> Forgot Password ?</a>-->
            </div>
        </div>
        <div class="form-group">
            <div class="col-12">
                <?=
                Html::submitButton(
                        'LOGIN', ['class' => 'btn btn-success waves-effect w-md waves-light w-100', 'tabindex' => '4']
                )
                ?>
            </div>
        </div>
    </div>
    <div id="login_otp" style="display:<?= $model->login_type == "2" ? "block" : "none" ?>;">
        <div class="form-group">
            <div class="col-12">
                <?=
                $form->field($model, 'username_otp', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'placeholder' => 'Mobile Number', 'enableLabel' => false, 'template' => '<div class=\"\">{input}</div><div class=\"\">{error}</div>']]
                )->label('');
                ?>
<!--                                <input type="text" class="form-control" value="User Name" placeholder="USER NAME">-->
            </div>
        </div>
        <div class="form-group">
            <div class="col-12">
                <?=
                $form->field($model, 'otp_sent')->hiddenInput()->label(false);
                ?>
                <?php
                $d = $model->login_type == "2" && $model->otp_sent == "1" ? "block" : "none";
                echo $form->field($model, 'otp', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'style' => "display:$d", 'tabindex' => '1', 'placeholder' => 'OTP', 'enableLabel' => false, 'template' => '<div class=\"\">{input}</div><div class=\"\">{error}</div>']]
                )->label('');
                ?>
<!--                                <input type="text" class="form-control" value="User Name" placeholder="USER NAME">-->
            </div>
        </div>

        <div class="form-group">
            <div class="col-12">
                <?php
                $d = $model->login_type == "2" && $model->otp_sent == "1" ? "Login" : "Next";
                echo Html::submitButton(
                        $d, ['class' => 'btn btn-success waves-effect w-md waves-light w-100', 'tabindex' => '4']
                )
                ?>
            </div>
        </div>
    </div>

</div>

<?php ActiveForm::end(); ?>

