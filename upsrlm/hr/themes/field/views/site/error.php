<?php
use yii\helpers\Html;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$code=Yii::$app->errorHandler->exception->statusCode;
?>
<div class="error-container">
    <div class="well">
        <h1 class="grey lighter smaller">
            <span class="blue bigger-125">
                <i class="ace-icon fa <?php if($code=='400' || $code=='403' || $code=='404') { echo "fa-sitemap";}else{ echo "fa-random";}?>"> <?=$code?></i>
                
            </span>
           <?= nl2br(Html::encode($message)) ?>
        </h1>

        <hr />
        <?php if($code!='403'){?>
        <h3 class="lighter smaller">We looked everywhere but we couldn't find it!</h3>

        <div>

            <div class="space"></div>
            <h4 class="smaller">Try one of the following:</h4>

            <ul class="list-unstyled spaced inline bigger-110 margin-15">
                <li>
                    <i class="ace-icon fa fa-hand-o-right blue"></i>
                    Re-check the url for typos
                </li>

                <li>
                    <i class="ace-icon fa fa-hand-o-right blue"></i>
                    Tell us about it <a href="/contact-us">Write to Us</a>
                </li>
            </ul>
        </div>

        <hr />
        <?php }?>
        <div class="space"></div>

        <div class="center">
            <a href="javascript:history.back()" class="btn btn-grey">
                <i class="ace-icon fa fa-arrow-left"></i>
                Go Back
            </a>
            <?php if (!Yii::$app->user->isGuest) { ?>
            <a href="/dashboard" class="btn btn-primary">
                <i class="ace-icon fa fa-tachometer"></i>
                Dashboard
            </a>
            <?php }?>
        </div>
    </div>
</div>