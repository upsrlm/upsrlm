<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\assets\SmartAdminAppAsset;
use yii\widgets\Breadcrumbs;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;
$arg = explode('/', Yii::$app->request->url);
$url=Yii::$app->request->url;
//technology
?>
<div class="container">
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col logo_section">
            <div class="full">
                <div class="center-desk">
                    <div class="logo"> <a href="/"><img src="/images/logo.jpeg" alt="logo"/></a> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
            <div class="menu-area">
                <div class="limit-box">
                    <nav class="main-menu">
                        <ul class="menu-area-main">
                            <li class="<?= in_array($url,['/','/page/home'])?'active':''?>"> <a href="/">Home</a> </li>
                            <li class="<?= in_array($url,['/page/transaction/index','/page/transaction'])?'active':''?>"> <a href="/page/transaction">Infographics</a> </li>
                            <li class="<?= in_array($url,['/page/timeline/index','/page/timeline'])?'active':''?>"> <a href="/page/timeline">Timeline</a> </li>
                            <li class="<?= in_array($url,['/page/methodology/index','/page/methodology'])?'active':''?>"> <a href="/page/methodology">Theory of changes</a> </li>
                            <li class="<?= in_array($url,['/page/technology/index','/page/technology'])?'active':''?>"> <a href="/page/technology">Technology</a> </li>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div>