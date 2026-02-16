<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = 'SRLM BC Selection : Guideline';
$this->params['icon'] = 'fa fa-book';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="dashboard-index">


    <iframe src="/download/Guideline for RSETI.pdf"  style="border: none;width:100%;height:800px">

</iframe>

</div>
  


