<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;
use common\widgets\Breadcrumbs;

$arg = explode('/', Yii::$app->request->url);
$url = explode('/', Yii::$app->request->url);
?>
<main id="js-page-content" role="main" class="page-content root-text-sm">

    <?=
    Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Home',
            'url' => '/',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ])
    ?>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>

    <?php if (isset($this->params['sub-title'])) { ?>
        <div class="subheader">
            <h1 class="subheader-title">
                <?php if (isset($this->params['icon'])) { ?>
                    <i class='subheader-icon <?= $this->params['icon'] ?>'></i>

                <?php }
                ?>
                <?= $this->params['sub-title'] ?>
            </h1>


        </div>
    <?php } ?>
    <div class="row">
        <div class="col-12">
            <?php
            if (Yii::$app->session->getFlash('success')) {
                yii\bootstrap4\Alert::begin([
                    'options' => [
                        'class' => 'alert-success',
                    ],
                ]);

                echo Yii::$app->session->getFlash('success');

                yii\bootstrap4\Alert::end();
            }
            if (Yii::$app->session->getFlash('error')) {
                yii\bootstrap4\Alert::begin([
                    'options' => [
                        'class' => 'alert-warning',
                    ],
                ]);

                echo Yii::$app->session->getFlash('error');

                yii\bootstrap4\Alert::end();
            }
            if (Yii::$app->session->getFlash('warning')) {
                yii\bootstrap4\Alert::begin([
                    'options' => [
                        'class' => 'alert-warning',
                    ],
                ]);

                echo Yii::$app->session->getFlash('warning');

                yii\bootstrap4\Alert::end();
            }
            ?>

            <?= $content ?>                                  

        </div><!-- end col -->
    </div>
</main>
<!-- this overlay is activated only when mobile menu is triggered -->
<div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
<!-- BEGIN Page Footer -->
<footer class="page-footer" role="contentinfo">
    <div class="d-flex align-items-center flex-1 text-muted">
        <span class="hidden-md-down fw-700"> Facilitated by Department of Rural Development, Government of Uttar Pradesh</span>
    </div>
    <div>
        <ul class="list-table m-0">

            <li class="pl-3 fs-xl"><a href="http://trilineinfotech.com/" class="text-secondary" target="_blank"><i class="fal fa-question-circle" aria-hidden="true"></i></a></li>
        </ul>
    </div>
</footer>