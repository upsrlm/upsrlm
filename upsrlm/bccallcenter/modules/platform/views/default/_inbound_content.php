<?php if ($dataProvider) { ?>
    <h2>Incoming Call</h2>
<?php
    echo \yii\widgets\DetailView::widget([
        'model' => $dataProvider,
        'attributes' => [
            'customer_number',
            'name_of_shg',
            'member_name',
            'ibd_request_datetime',
            [
                'label' => 'View Detail',
                'format' => 'raw',
                'value' => function ($model) {
                    return \yii\helpers\Html::a('<i class="fal fa-eye"></i> View Detail and Pending Scnearios', ['/platform/default/callhistory?calling_list_id=' . $model->id], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                }
            ],
        ],
    ]);
} else {
    echo "<h2>Waiting for Incoming Call</h2>";
}
?>