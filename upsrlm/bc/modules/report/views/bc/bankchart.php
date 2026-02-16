<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

\common\assets\HighChartsAssets::register($this);

?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Bank Wise Report' ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?php
                    $form = ActiveForm::begin([
                        'options' => [
                            'class' => 'form-inline',
                            'data-pjax' => true,
                            'id' => 'search-form'
                        ],
                        'id' => 'search-form',
                        'layout' => 'inline',
                        'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_searchbankreport', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <?php ActiveForm::end();
                    ?>
                    <div class="clearfix pt-3"></div>
                    <div class="row">
                        <div class="col-xl-12">
                            <table class="table table-bordred">
                                <thead>
                                    <tr>
                                        <th>BC Transaction</th>
                                        <?php
                                        if ($searchModel->monthoptionasc()) {
                                            $month = 0;
                                            foreach ($searchModel->monthoptionasc() as $month_id => $month_name) {
                                                if ($month != 0) {
                                                    echo "<th> Month " . $month . "</th>";
                                                }
                                                $month++;
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    if ($searchModel->monthoptionasc()) {
                                        foreach ($searchModel->monthoptionasc() as $month_id => $month_name) {
                                            $bcretentation = $searchModel->bcretentation($month_id);
                                            echo '<tr style="border-top: 1px solid #e9e9e9;">';
                                            if ($month_name != \Yii::$app->formatter->asDatetime(date('Y-m-d'), "php:M-Y")) {
                                                echo '<td>' . $month_name . '</td>';
                                            }
                                            $month = 0;
                                            foreach ($searchModel->monthoptionasc() as $month_idinternal => $month_nameinternal) {
                                                if ($month_id > $month_idinternal) {
                                                } else {
                                                    if ($month != 0) {     ?>
                                                        <td><?= $bcretentation['data'][$month_idinternal] ?></td>
                                                <?php }
                                                    $month++;
                                                }
                                                ?>
                                    <?php
                                            }
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>