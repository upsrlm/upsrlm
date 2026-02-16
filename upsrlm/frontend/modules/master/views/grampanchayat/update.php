<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel app\models\master\MasterGramPanchayatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Update Gram Panchayats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-header" style="margin-top: 20px">
                <h2>
                    <?= $this->title ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?=
                    $this->render('_form', [
                        'model' => $model,
                    ])
                    ?>

                </div>
            </div>  
        </div>
    </div>

</div>
