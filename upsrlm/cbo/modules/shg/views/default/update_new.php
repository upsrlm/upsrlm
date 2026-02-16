<?php

use yii\helpers\Html;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */

$this->title = 'Update SHG';
$this->params['breadcrumbs'][] = ['label' => "SHG's", 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
<?= Html::encode($this->title) ?>
                </h2>
                <div class="panel-toolbar">

<?= Html::a('SHG', ['index'], ['class' => 'btn btn-success']) ?>

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>  
            </div> 
            <div class="panel-container show">
                <div class="panel-content">
                    <?=
                    $this->render('_new_form', [
                        'model' => $model,
                    ])
                    ?>
                </div>
            </div>          
        </div>
    </div>     
</div>   