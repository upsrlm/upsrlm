<?php

use yii\helpers\Html;
use kartik\password\PasswordInput;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\TouchSpin;
use kartik\widgets\FileInput;
use yii\bootstrap4\Modal;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use common\models\master\MasterRole;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?> <span class="pl-2"><?= isset($user_model->profile) ? $user_model->profile->vsb : '' ?></span>
                </h2>
                <div class="panel-toolbar">
                    <?= Html::a('<i class="fa fa-thumb-up"></i> Update Profile', '/profile/update', ['id' => 'view-button', 'class' => 'btn btn-sm btn-info btn-block', 'title' => '']); ?>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?php
                    if ($user_model->role == MasterRole::ROLE_BMMU) {
                        echo $this->render('viewbmmu', ['model' => $model, 'user_model' => $user_model]);
                    } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                        echo $this->render('viewdmmu', ['model' => $model, 'user_model' => $user_model]);
                    } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                        echo $this->render('viewsmmu', ['model' => $model, 'user_model' => $user_model]);
                    } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT])) {
                        echo $this->render('viewrsethis', ['model' => $model, 'user_model' => $user_model]);
                    } elseif ($user_model->role == MasterRole::ROLE_DC_NRLM) {
                        echo $this->render('viewdcnrlm', ['model' => $model, 'user_model' => $user_model]);
                    } elseif ($user_model->role == MasterRole::ROLE_BANK_DISTRICT_UNIT) {
                        echo $this->render('viewbank', ['model' => $model, 'user_model' => $user_model]);
                    } elseif ($user_model->role == MasterRole::ROLE_RBI) {
                        echo $this->render('viewbank194', ['model' => $model, 'user_model' => $user_model]);
                    } else {
                        echo $this->render('viewcommon', ['model' => $model, 'user_model' => $user_model]);
                    }
                    ?>  
                </div>  
            </div> 
        </div>  
    </div>           
</div>                   