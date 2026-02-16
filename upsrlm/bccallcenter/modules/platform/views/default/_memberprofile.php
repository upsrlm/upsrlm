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
                        return isset($model->cboshg->name_of_shg) ? $model->cboshg->name_of_shg : '';
                    },
                ],
                [
                    'attribute' => 'name',
                    'label' => 'नाम',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->name) ? $model->name : '';
                    },
                ],
                [
                    'attribute' => 'mobile',
                    'label' => 'मोबाइल नंबर',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->mobile) ? $model->mobile : '';
                    },
                ],
                [
                    'attribute' => 'role',
                    'label' => 'पद',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $html = '';
                        if (isset($model->shgrole)) {
                            $html .= $model->shgrole->role_hindi;
                        } else {
                            $html .= 'सदस्य';
                        }
                        if ($model->suggest_wada_sakhi == 1) {
                            $html .= '<br/>मनोनीत समूह सखी';
                        }
                        return $html;
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
                        return isset($model->cboshg->district_name) ? $model->cboshg->district_name : '';
                    },
                ],
                [
                    'attribute' => 'block_name',
                    'label' => 'ब्लॉक',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->cboshg->block_name) ? $model->cboshg->block_name : '';
                    },
                ],
                [
                    'attribute' => 'gram_panchayat_name',
                    'label' => 'ग्राम पंचायत',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->cboshg->gram_panchayat_name) ? $model->cboshg->gram_panchayat_name : '';
                    },
                ],
                [
                    'attribute' => 'village_name',
                    'label' => 'ग्राम',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return isset($model->cboshg->village_name) ? $model->cboshg->village_name : '';
                    },
                ],
                [
                    'attribute' => 'form_status',
                    'label' => 'फॉर्म की स्थिति',
                    'format' => 'raw',
                    'visible' => $model->suggest_wada_sakhi == 1,
                    'value' => function ($model) {
                        $app= \common\models\wada\WadaApplication::find()->where(['mobile_number'=>$model->mobile,'cbo_shg_id'=>$model->cbo_shg_id])->one();
                        return $app==null?'शुरू नहीं किया गया':$app->formstatus;
                    },
                ],
            ],
        ])
        ?>
    </div>
</div>