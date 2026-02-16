<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Alert;
$this->title = Yii::t('user', 'Recover your password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="about">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
                                <?php if (in_array($type, ['success', 'danger', 'warning', 'info'])): ?>
                                    <?=
                                    Alert::widget([
                                        'options' => ['class' => 'alert-dismissible alert-' . $type],
                                        'body' => $message
                                    ])
                                    ?>
    <?php endif ?>
<?php endforeach ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        $form = ActiveForm::begin([
                                    'id' => 'password-recovery-form',
                                    'enableAjaxValidation' => false,
                                    'enableClientValidation' => true,
                        ]);
                        ?>

                        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                        <?=
                        $form->field($model, 'verifyCode', ['enableAjaxValidation' => false])->widget(Captcha::className(), [
                            'captchaAction' => '/site/captcha',
                            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-1"></div><div class="col-lg-6"> {input}</div></div>',
                        ])
                        ?>
<?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn btn-primary btn-block']) ?><br>
                        <div class="form-group">
                            <div class="col-12">

<?php echo Html::a(Yii::t('user', 'Login'), ['/page/home'], ['tabindex' => '5', 'class' => 'text-center waves-effect w-md waves-light w-100']); ?>  

                            </div>
                        </div>
<?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>