<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select3\Select3;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = 'शिकायत';
$app = new \sakhi\components\App();
?>
<div class="row margin-set">
    <div class="col-xl-12 p-0">
        <div id="panel-1" class="panel">
            <div class="card-title mb-0 p-2 border-bottom">
                <h2 class="mb-0 px-1"><?= $this->title ?></h2>   
            </div>
            <div class="panel-container show px-1">
                <div class="panel-content h4">

                    <div class="col-lg-12" style="padding: 5px;">
                        <?php foreach (common\models\base\GenralModel::bc_grievance_group() as $key=>$val){ ?>
                        <a href="<?='/bc/grievance/report?bcid='.$model->id.'&group='.$key?>" class="btn btn-danger btn-lg btn-block <?=''?>"><span><?=$val?></span>  </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>          
