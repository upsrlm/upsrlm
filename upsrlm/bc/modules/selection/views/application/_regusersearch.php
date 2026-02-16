<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\widgets\Pjax;
use common\models\User;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\master\MasterGramPanchayatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-gram-panchayat-search">
    <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform',
                ],
                'method' => 'get',
    ]);
    ?>

    <?php
    echo $form->field($model, 'mobile_no')->textInput(['placeholder' => 'Mobile Number'])->label('');
    ?>

    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?=
    Html::a('<i class="fa fa-file-excel-o"></i> ' . $model->csv_data->last_process_user_id . ' records download csv', ['/selection/application/download'], [
        'title' => Yii::t('user', 'Download CSV'),
        'class' => 'btn  btn-info',
        'class' => 'btn btn-primary btn-md',
        'data-pjax' => 0
    ])
    ?>   


    <?php ActiveForm::end(); ?>

</div>
