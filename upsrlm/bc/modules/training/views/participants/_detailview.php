<?php

use kartik\tabs\TabsX;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $model->name ?>
                </h2>
                <div class="panel-toolbar">



                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $items = [
                        [
                            'label' => '<i class="fal fa-user"></i> Profile',
                            'content' => $this->render('_applicationview', [
                                'model' => $model,
                                'i' => 'a-' . $model->id,
                            ]),
                            'active' => true
                        ],
                        [
                            'label' => '<i class="fal fa-certificate"></i> Training and verification',
                            'content' => $this->render('_participantview', [
                                'model' => $pmodel,
                                'i' => 'p-' . $model->id,
//                                'active' => true
                            ]),
                        ],
                        [
                            'label' => '<i class="fal fa-exchange"></i> Transaction',
                            'content' => $this->render('_transactionview', [
                                'model' => $model,
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProvider,
                                'i' => 'a-' . $model->id,
                            ]),
                        ],
                        [
                            'label' => '<i class="fal fa-phone"></i> Call Detail',
                            'content' => $this->render('_calldetail', [
                                'model' => $model,
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProviderCall,
                                'i' => 'a-' . $model->id,
                            ]),
                        ],
                        [
                            'label' => '<i class="fal fa-phone"></i> Loan Repayment',
                            'content' => $this->render('_loan_repayment', [
                                'model' => $model,
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProviderCall,
                                'i' => 'a-' . $model->id,
                            ]),
                        ],
                    ];
                    echo TabsX::widget([
                        'items' => $items,
                        'position' => TabsX::POS_ABOVE,
                        'encodeLabels' => false
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>