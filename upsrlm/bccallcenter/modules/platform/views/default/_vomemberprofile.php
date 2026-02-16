<div class="row">
    <div class="col-md-6">
        <p class="font-weight-bold">सदस्य विवरण</p>
        <?php
        echo \yii\widgets\DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'name_of_shg',
                    'label' => 'समूह का नाम',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->samuhsakhishg->name_of_shg) ? $model->samuhsakhishg->name_of_shg : '';
                    },
                ],
                [
                    'attribute' => 'name',
                    'label' => 'नाम',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->samuh_sakhi_name) ? $model->samuh_sakhi_name : '';
                    },
                ],
                [
                    'attribute' => 'mobile',
                    'label' => 'मोबाइल नंबर',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->samuh_sakhi_mobile_no) ? $model->samuh_sakhi_mobile_no : '';
                    },
                ],
                
            ],
        ])
        ?>
    </div>
    <div class="col-md-6">
        <p class="font-weight-bold">सदस्य का पता विवरण</p>
        <?php
        echo \yii\widgets\DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'district_name',
                    'label' => 'जिला',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->district_name) ? $model->district_name : '';
                    },
                ],
                [
                    'attribute' => 'block_name',
                    'label' => 'ब्लॉक',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->block_name) ? $model->block_name : '';
                    },
                ],
                [
                    'attribute' => 'gram_panchayat_name',
                    'label' => 'ग्राम पंचायत',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->gram_panchayat_name) ? $model->gram_panchayat_name : '';
                    },
                ],
                          
              
            ],
        ])
        ?>
    </div>
</div>