<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
use yii\bootstrap4\Modal;

$this->title = 'Download';
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

                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_MD])) { ?>
                        <div class="col-lg-12 mb-2">
                            <?php
                            echo Html::a('<i class="fal fa fa-download"></i> Download Certified BC pendency', ['/report/download/cpendencycsv'], [
                                'class' => 'btn btn-sm btn-info mr-2',
                                'data-pjax' => "0",
                            ]) . ' ';
                            ?> 
                        </div>  
                        <div class="col-lg-12 mb-2">
                            <?php
                            echo Html::a('<i class="fal fa fa-download"></i> Download PVR Pendency', ['/report/download/pvrpendencycsv'], [
                                'class' => 'btn btn-sm btn-info mr-2',
                                'data-pjax' => "0",
                            ]) . ' ';
                            ?> 
                        </div>  
                    <?php } ?>   
                </div>
            </div>

        </div>    
    </div>
</div>    
