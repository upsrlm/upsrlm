<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
use cbo\models\CboVo;

$this->title = "Rishta App Menu";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="panel">
                        <div class="panel-hdr">
                            <h2>
                                <?= "CLF" ?>
                            </h2>

                        </div>
                        <?php if ($dataProviderclf->getModels() != null) { ?>
                            <?php foreach ($dataProviderclf->getModels() as $clf) { ?>
                                <div class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= $clf->name_of_clf ?>
                                        </h2>

                                    </div>
                                    <div class="panel-content">
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/clf.png' . '" alt=""/>' . 'संकुल/ CLF का विवरण', ['/clf/default/view', 'clfid' => $clf->id], ['class' => 'btn btn-primary', 'data-pjax' => 0]) . '</div>';
                                        ?> 
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/mem-list.png' . '" alt=""/>' . 'संकुल सदस्यों का विवरण', ['/clf/default/memberlist', 'clfid' => $clf->id], ['class' => 'btn btn-primary', 'data-pjax' => 0]) . '</div>';
                                        ?>  
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png' . '" alt=""/>' . 'धन प्राप्ति का विवरण', ['/clf/default/fundsrecived', 'clfid' => $clf->id], ['class' => 'btn btn-primary', 'data-pjax' => 0]) . '</div>';
                                        ?>  
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/writing.png' . '" alt=""/>' . 'फ़ीड्बैक', ['/clf/default/feedback', 'clfid' => $clf->id], ['class' => 'btn btn-primary', 'data-pjax' => 0]) . '</div>';
                                        ?>  
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/add.png' . '" alt=""/>' . 'सम्बद्ध ग्राम संगठन', ['/clf/default/addvo', 'clfid' => $clf->id], ['class' => 'btn btn-primary', 'data-pjax' => 0]) . '</div>';
                                        ?>  
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/vo-funds.png' . '" alt=""/>' . 'ग्राम संगठन के साथ ऋण लेनदेन', ['/clf/default/fundsvo', 'clfid' => $clf->id], ['class' => 'btn btn-primary', 'data-pjax' => 0]) . '</div>';
                                        ?>  
                                    </div>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                    </div>  
                    <div class="panel">
                        <?php if ($dataProvidervo->getModels() !== null) { ?>
                            <?php foreach ($dataProvidervo->getModels() as $vo) { ?>
                                <div class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= $vo->name_of_vo ?>
                                        </h2>

                                    </div>
                                    <div class="panel-content">
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/vo.png' . '" alt=""/>' . 'ग्राम संगठन/ VO का विवरण', ['/vo/default/view', 'void' => $vo->id], ['class' => 'btn btn-success', 'data-pjax' => 0]) . '</div>';
                                        ?> 
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/mem-list.png' . '" alt=""/>' . 'ग्राम संगठन के सदस्यों का विवरण', ['/vo/default/memberlist', 'void' => $vo->id], ['class' => 'btn btn-success', 'data-pjax' => 0]) . '</div>';
                                        ?>  
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png' . '" alt=""/>' . 'धन प्राप्ति का विवरण', ['/vo/default/fundsrecived', 'void' => $vo->id], ['class' => 'btn btn-success', 'data-pjax' => 0]) . '</div>';
                                        ?>  

                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/add.png' . '" alt=""/>' . 'सम्बद्ध SHG', ['/vo/default/addshg', 'void' => $vo->id], ['class' => 'btn btn-success', 'data-pjax' => 0]) . '</div>';
                                        ?>  
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/vo-funds.png' . '" alt=""/>' . 'SHG के साथ ऋण लेनदेन', ['/vo/default/fundshg', 'void' => $vo->id], ['class' => 'btn btn-success', 'data-pjax' => 0]) . '</div>';
                                        ?>    
                                    </div>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="panel">
                        <?php if ($dataProvidershg->getModels() !== null) { ?>
                            <?php foreach ($dataProvidershg->getModels() as $shg) { ?>
                                <div class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= $shg->name_of_shg ?>
                                        </h2>

                                    </div>
                                    <div class="panel-content">
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/writing.png' . '" alt="फ़ीड्बैक"/>' . 'फ़ीड्बैक', ['/shg/feedback/form', 'shgid' => $shg->id], ['class' => 'btn btn-danger', 'data-pjax' => 0]) . '</div>';
                                        ?> 
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/shg.png' . '" alt="SHG का विवरण"/>' . 'SHG का विवरण', ['/shg/profile/index', 'shgid' => $shg->id], ['class' => 'btn btn-danger', 'data-pjax' => 0]) . '</div>';
                                        ?> 
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/bank-account.png' . '" alt="बैंक खाता विवरण"/>' . 'बैंक खाता विवरण', ['/shg/bankaccount/index', 'shgid' => $shg->id], ['class' => 'btn btn-danger', 'data-pjax' => 0]) . '</div>';
                                        ?>  
                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/mem-list' . '" alt="पदाधिकारीयों एवं सदस्यों का विवरण"/>' . 'पदाधिकारीयों एवं सदस्यों का विवरण', ['/shg/member/index', 'shgid' => $shg->id], ['class' => 'btn btn-danger', 'data-pjax' => 0]) . '</div>';
                                        ?>  

                                        <?php
                                        echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png' . '" alt=""/>' . 'धन प्राप्ति का विवरण', ['/shg/funds/index', 'shgid' => $shg->id], ['class' => 'btn btn-danger', 'data-pjax' => 0]) . '</div>';
                                        ?>  
                                        <?php
                                        //echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/vo-funds.png' . '" alt=""/>' . 'SHG के साथ ऋण लेनदेन', ['/shg/default/fundshg', 'shgid' => $shg->id], ['class' => 'btn btn-danger', 'data-pjax' => 0]) . '</div>';
                                        ?>     
                                    </div>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                    </div> 
                    <?php if (isset($user_model->cboprofile) and $user_model->cboprofile->bc) { ?>
                        <div class="panel">
                            <div class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= $user_model->cboprofile->first_name ?>
                                    </h2>

                                </div>
                                <div class="panel-content">
                                    <?php
                                    echo '<div class="col-lg-12 mb-1">' . yii\bootstrap4\Html::a('<img style="width:40px" src="' . \Yii::$app->params['app_url']['www'] . '/images/app/profile.jpg' . '" alt=""/>' . 'बीसी सखी प्रोफाइल', ['/bc/default/view', 'bcid' => $user_model->cboprofile->srlm_bc_application_id], ['class' => 'btn btn-danger', 'data-pjax' => 0]) . '</div>';
                                    ?> 

                                </div>
                            </div> 
                        </div>    
                    <?php } ?>
                </div>
            </div>
        </div> 
    </div>
</div>
