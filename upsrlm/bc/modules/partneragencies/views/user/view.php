<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
if ($model->role == MasterRole::ROLE_BDO) {
    $this->params['breadcrumbs'][] = ['label' => 'BDO', 'url' => ['bdo']];
} else if ($model->role == MasterRole::ROLE_BMMU) {
    $this->params['breadcrumbs'][] = ['label' => 'BMMU', 'url' => ['bmmu']];
} else if ($model->role == MasterRole::ROLE_DMMU) {
    $this->params['breadcrumbs'][] = ['label' => 'DMMU', 'url' => ['dmmu']];
} else if ($model->role == MasterRole::ROLE_SMMU) {
    $this->params['breadcrumbs'][] = ['label' => 'SMMU', 'url' => ['smmu']];
} else if ($model->role == MasterRole::ROLE_DM) {
    $this->params['breadcrumbs'][] = ['label' => 'District Magistrate', 'url' => ['dm']];
} else if ($model->role == MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL) {
    $this->params['breadcrumbs'][] = ['label' => 'Bank/FI Partner District Nodal', 'url' => ['bankfipdnodal']];
}else if ($model->role == MasterRole::ROLE_CORPORATE_BCS) {
    $this->params['breadcrumbs'][] = ['label' => 'CORPORATE BCs', 'url' => ['bankfipcorporatebc']];
} else if ($model->role == MasterRole::ROLE_DIVISIONAL_COMMISSIONER) {
    $this->params['breadcrumbs'][] = ['label' => 'Divisional Commissioner', 'url' => ['dc']];
} else if ($model->role == MasterRole::ROLE_RSETIS_DISTRICT_UNIT) {
    $this->params['breadcrumbs'][] = ['label' => 'RSETI', 'url' => ['rsethis']];
} else if ($model->role == MasterRole::ROLE_RSETIS_STATE_UNIT) {
    $this->params['breadcrumbs'][] = ['label' => 'RSETI', 'url' => ['rsethis']];
} else if ($model->role == MasterRole::ROLE_RSETIS_NODAL_BANK) {
    $this->params['breadcrumbs'][] = ['label' => 'RSETIs Nodal Bank', 'url' => ['nodalbank']];
} else if ($model->role == MasterRole::ROLE_BANK_DISTRICT_UNIT) {
    $this->params['breadcrumbs'][] = ['label' => 'Bank/FI Partner', 'url' => ['index']];
} else if ($model->role == MasterRole::ROLE_DC_NRLM) {
    $this->params['breadcrumbs'][] = ['label' => 'DC NRLM', 'url' => ['index']];
} else if ($model->role == MasterRole::ROLE_YOUNG_PROFESSIONAL) {
    $this->params['breadcrumbs'][] = ['label' => 'Verifiers', 'url' => ['yp']];
} else {

    $this->params['breadcrumbs'][] = ['label' => $model->urole != null ? $model->urole->role_name : 'Users', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?> <span class="pl-2"><?= isset($model->profile)?$model->profile->vsb:'' ?></span>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <div class="row">
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'name',
                                    'username',
                                    'email',
                                ],
                            ])
                            ?>         
                        </div>
                        <div class = "col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'mobile_no',
                                    [
                                        'attribute' => 'role',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->urole != null ? $model->urole->role_name : '';
                                        },
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->status == User::STATUS_ACTIVE ? 'Active' : 'Inactive';
                                        },
                                    ],
                                ],
                            ])
                            ?>     
                        </div>
                    </div>



                    <?php
                    if ($model->role == MasterRole::ROLE_BMMU) {
                        echo $this->render('profile/bmmu', ['user_model' => $model, 'model' => $model->profile]);
                    }if ($model->role == MasterRole::ROLE_DMMU) {
                        echo $this->render('profile/dmmu', ['user_model' => $model, 'model' => $model->profile]);
                    }if ($model->role == MasterRole::ROLE_SMMU) {
                        echo $this->render('profile/smmu', ['user_model' => $model, 'model' => $model->profile]);
                    } elseif (in_array($model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT])) {
                        echo $this->render('profile/rsethi', ['user_model' => $model, 'model' => $model->profile]);
                    } elseif ($model->role == MasterRole::ROLE_DC_NRLM) {
                        echo $this->render('profile/dcnrlm', ['user_model' => $model, 'model' => $model->profile]);
                    } elseif ($model->role == MasterRole::ROLE_BANK_DISTRICT_UNIT) {
                        echo $this->render('profile/bankpartner', ['user_model' => $model, 'model' => $model->profile]);
                    } else {
                        echo $this->render('profile/common', ['user_model' => $model, 'model' => $model->profile]);
                    }
                    ?>  
                </div>      
            </div>
        </div>
    </div>
</div>