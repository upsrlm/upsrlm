<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\password\PasswordInput;
use kartik\date\DatePicker;
use common\models\master\MasterRole;

if ($user->user_model->role == MasterRole::ROLE_BDO) {
    $this->title = 'Update BDO';
    $this->params['breadcrumbs'][] = ['label' => 'BDO', 'url' => ['bdo']];
}
if ($user->user_model->role == MasterRole::ROLE_BMMU) {
    $this->title = 'Update BMMU';
    $this->params['breadcrumbs'][] = ['label' => 'BMMU', 'url' => ['bmmu']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?=
                    $this->render('_bdoform', [
                        'model' => $user,
                        'disabled' => '',
                    ])
                    ?>

                </div>
            </div> 
        </div> 
    </div>
</div>    