<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\fielddata\models\FormSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Download Complete applications (Only Females)';
?>
<div class='table-header'>    
    <div>Total Complete applications (Only Females) : <b><?= $model->total ?></b> </div>
</div>

<div class="dataTables_wrapper" class="dataTables_wrapper form-inline no-footer">
    <div class="row" style="padding-top:5px;padding-bottom:5px">
        <div class="col-lg-10 ">
            <div class="search-form ">

                <?php
                $form = ActiveForm::begin([
                            'options' => [
                                'class' => 'form-horizontal',
                                'data-pjax' => true,
                            ],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div >{error}</div>",
                                'labelOptions' => ['class' => 'col-md-3 control-label'],
                            ],
                            'method' => 'post',
                ]);
                ?>
                <?php
                echo $form->field($model, 'start')->textInput(['maxlength' => 255]);

                echo $form->field($model, 'end')->textInput(['maxlength' => 255]);
                ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-11">    
                        <?= Html::submitButton('<i class="fa fa-file-excel-o"></i> Download', ['class' => 'btn btn-info ', 'style' => 'margin-top:20px']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>


    </div>



