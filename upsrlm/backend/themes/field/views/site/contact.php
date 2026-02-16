<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Contact Us';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('common'); ?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>

        <p>
            
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
        </p>

        <div class="row">
            <div class="col-lg-8">
                <?php
                $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div >{error}</div>",
                                'labelOptions' => ['class' => 'col-sm-3 control-label'],
                            ],
                ]);
                ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'subject') ?>
                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
                <?=
                $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-7">{input}</div></div>',
                ])
                ?>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-11 ">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
            <div class="col-xs-6 col-sm-3 pricing-box">
                <div class="widget-box widget-color-blue">
                    <div class="widget-header">
                        <h5 class="widget-title bigger lighter">Contact Details</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <p> US :<br>6005 State Bridge Road, <br>
                                Duluth, GA 30097, USA<br><br>
                                India : <br>
                                B-84, Sewak Park, NSIT Road,<br> Dwarka Mor, New Delhi - 110059

                                <br><br>
                                Uganda:<br>
                                C/o. Yo Uganda Limited, <br>
                                5th Floor Impala House, <br>
                                13 Kimathi Avenue, Kampala
                                <br>
                                <br>
                                Voice Mail :<br>+1 718 717 2578
                            </p>

                        </div>



                    </div>
                </div>

            </div>
        </div>

    <?php endif; ?>
</div>
