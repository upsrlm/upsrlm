<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\dynamicdb\support\ConversationDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Conversation Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="conversation-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'conversation_code',
            'stakeholder_code',
            'call_type',
            'calling_no',
            'calling_person_name',
            'calling_person_designation',
            'calling_person_district',
            'calling_person_block',
            'calling_person_gp',
            'call_response',
            'comments',
            'cc_executive_code',
        ],
    ]) ?>

</div>
