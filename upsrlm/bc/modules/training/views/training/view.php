<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
use kartik\tabs\TabsX;  
$this->title = "Training View :".$model->date;
$this->params['breadcrumbs'][] = ['label' => 'Trainings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-default-index">
    <div class="panel panel-default">
        <div class='panel-body'>
            
         <?= Yii::$app->controller->renderPartial('_view', ['model' => $model])?> 
         <?= Yii::$app->controller->renderPartial('_participandetail', ['model' => $model,
                        'searchModelp' => $searchModelp,
                        'dataProvider' => $dataProviderp,
                    ])?>  
            <?php if($model->group_photo_file_name != null){ ?>
             <table class="table table-responsive">
                    <tr>
                        <th>Group Photo</th>
                      
                    </tr> 
                    <tr>
                        <td>
                    <?= $model->group_photo_file_name != null ? '<span class="profile-picture">
                                        <img src="' . $model->group_photo_url . '" data-src="' . $model->group_photo_url . '"  class="lozad" title="profile_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                        </td> 
                       
                    </tr>
                </table>
            <?php } ?>
        </div>
    </div>  
</div>