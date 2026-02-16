<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
?>
<div class="app-top-bar bg-plum-plate top-bar-text-light">
    <div class="container fiori-container">
        <div class="top-bar-left">
            <ul class="nav">
                <li class="nav-item">
                    <a href="<?= Yii::$app->params['app_url']['www'] ?>" class="nav-link">
                        SRLM
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Yii::$app->params['app_url']['www'] . '/page/contact' ?>" class="nav-link">
                        Contact
                    </a>
                </li>
<?php if (!Yii::$app->user->isGuest) { ?>
                    <li class="nav-item ml-1">
                        <a data-placement="top" rel="popover-focus" data-toggle="popover-custom" class="nav-link">
                            Application
                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                        </a>
                        <div class="rm-max-width">
                            <div class="d-none popover-custom-content">
                                <div class="grid-menu grid-menu-2col">
                                    <div class="no-gutters row">
                                        <div class="col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark"><i class="lnr-lighter text-dark opacity-7 btn-icon-wrapper mb-2"> </i>Automation
                                            </button>
                                        </div>
                                        <div class="col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger"><i class="lnr-construction text-danger opacity-7 btn-icon-wrapper mb-2"> </i>Reports
                                            </button>
                                        </div>
                                        <div class="col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-success"><i class="lnr-bus text-success opacity-7 btn-icon-wrapper mb-2"> </i>Activity
                                            </button>
                                        </div>
                                        <div class="col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-focus"><i class="lnr-gift text-focus opacity-7 btn-icon-wrapper mb-2"> </i>Settings
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </li>
<?php } ?>
            </ul>
        </div>
        <div class="top-bar-right">
            <ul class="nav">
<?php if (Yii::$app->user->isGuest) { ?>
                    <li class="nav-item mr-2">
                        <a href="<?= Yii::$app->params['app_url']['www'] ?>" class="nav-link">
                            Login
                        </a>
                    </li>
                <?php } ?>
<?php if (!Yii::$app->user->isGuest) { ?>
                    <li class="nav-item ml-1">
                        <a data-placement="top" rel="popover-focus" data-toggle="popover-custom" class="nav-link">
    <?= Yii::$app->user->identity->name ?>
                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                        </a>
                        <div class="rm-max-width">
                            <div class="d-none popover-custom-content">
                                <div class="grid-menu grid-menu-2col">
                                    <div class="no-gutters row">
                                        <div class="col-sm-6">
                                            <a href="<?= Yii::$app->params['app_url']['www'] . '/changepassword' ?>" class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark"><i class=" fa fa-cog text-dark opacity-7 btn-icon-wrapper mb-2"> </i>Changepassword
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="<?= Yii::$app->params['app_url']['www'] . '/site/logout' ?>" class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger"><i class="fa fa-unlock text-danger opacity-7 btn-icon-wrapper mb-2"> </i>Logout
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-success"><i class="lnr-bus text-success opacity-7 btn-icon-wrapper mb-2"> </i>Activity
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-focus"><i class="lnr-gift text-focus opacity-7 btn-icon-wrapper mb-2"> </i>Settings
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </li>
                <?php } ?>
<?php if (!Yii::$app->user->isGuest) { ?>
                    <li class="nav-item dropdown">
                        <a aria-haspopup="true" data-toggle="dropdown" aria-expanded="false" class="nav-link">
                            <i class="typcn typcn-world-outline mr-1"></i>
    <?= Yii::$app->user->identity->name ?>
                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                        </a>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu dropdown-menu-right">
                            <button type="button" tabindex="0" class="dropdown-item">
                                    <span class="mr-3 opacity-8 flag large US"></span>
                                    USA
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <span class="mr-3 opacity-8 flag large CH"></span>
                                    Switzerland
                                </button>
<!--                            <a tabindex="-1" href="/changepassword" tabindex="0" class="dropdown-item"><i class="ace-icon fa fa-unlock"></i> Change password</a>

                            <div tabindex="-1" class="dropdown-divider"></div>
                            <a tabindex="-1" href="<?= \yii\helpers\Url::to(['/site/logout']) ?>" tabindex="0" class="dropdown-item" data-method="post"><i class="ace-icon fa fa-power-off"></i> Logout</a>-->

                        </div>
                    </li>
<?php } ?>
            </ul>
        </div>
    </div>
</div>
