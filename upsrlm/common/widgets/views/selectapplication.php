<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\master\MasterRole;
use common\models\WebApplication;

$arr = explode('/', $this->theme->basePath);
$themename = end($arr);

?>
<?php
if (!Yii::$app->user->isGuest) {
    if ($themename == 'field') {
        ?>
        <li class="black">
            <a data-toggle="dropdown" class="dropdown-toggle "  href="#">
                <i class="ace-icon fa fa-area-chart"></i>
                <span class="">Select Portal</span>
                <i class="ace-icon fa fa-caret-down"></i>
            </a>
            <ul class="user-menu dropdown-menu-right dropdown-navbar navbar-grey dropdown-menu dropdown-caret dropdown-close">
                <?php if (in_array(WebApplication::WEB_APP_BC_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['bc'])) { ?>
                    <li class="dropdown-headers">
                        <a href="<?= Yii::$app->params['app_url']['bc'] ?>"><span> B.C Sakhi Portal</span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_CBO_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['cbo'])) { ?>
                    <li class="dropdown-headers">
                        <a href="<?= Yii::$app->params['app_url']['cbo'] ?>"><span> C.B.O Portal </span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_HR_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['hr'])) { ?>
                    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_HR_ADMIN, MasterRole::ROLE_MD])) { ?>
                        <li class="dropdown-headers">
                            <a href="<?= Yii::$app->params['app_url']['hr'] ?>"><span> HR Portal </span> </a>
                        </li>
                    <?php } ?>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_ADMIN_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['admin'])) { ?>
                    <li class="dropdown-headers">
                        <a href="<?= Yii::$app->params['app_url']['admin'] ?>"><span> Admin Portal </span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_SUPPORT_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['support'])) { ?>
                    <li class="dropdown-headers">
                        <a href="<?= Yii::$app->params['app_url']['support'] ?>"><span> Support Portal </span> </a>
                    </li>
                <?php } ?>           
                <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>
                    <li class="dropdown-headers">
                        <a href="<?= Yii::$app->params['app_url']['www'] ?>"><span> UPSRLM Portal </span> </a>
                    </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    <?php if ($themename == 'aasaan') { ?>
        <li class="has-submenu">
            <a data-toggle="dropdown" class="dropdown-toggle "  href="#">
                <i class="ace-icon fa fa-area-chart"></i>
                <span class="">Select Portal</span>
                <i class="ace-icon fa fa-caret-down"></i>
            </a>
            <ul class="user-menu submenu">
                <?php if (in_array(WebApplication::WEB_APP_BC_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['bc'])) { ?>
                    <li class="dropdown-headers">
                        <a href="<?= Yii::$app->params['app_url']['bc'] ?>"><span> B.C Sakhi Portal</span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_CBO_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['cbo'])) { ?>
                    <li class="dropdown-headers">
                        <a href="<?= Yii::$app->params['app_url']['cbo'] ?>"><span> C.B.O Portal </span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_HR_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['hr'])) { ?>
                    <li class="dropdown-headers">
                        <a href="<?= Yii::$app->params['app_url']['hr'] ?>"><span> HR Portal </span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_ADMIN_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['admin'])) { ?>
                    <li class="dropdown-headers">
                        <a href="<?= Yii::$app->params['app_url']['admin'] ?>"><span> Admin Portal </span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_SUPPORT_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['support'])) { ?>
                    <li class="dropdown-headers">
                        <a href="<?= Yii::$app->params['app_url']['support'] ?>"><span> Support Portal </span> </a>
                    </li>
                <?php } ?>           
                <li class="dropdown-headers">
                    <a href="<?= Yii::$app->params['app_url']['www'] ?>"><span> UPSRLM Portal </span> </a>
                </li>
            </ul>
        </li>
    <?php } ?>
    <?php if ($themename == 'fiori') { ?>
        <div class="app-header-right">
            <div class="header">
                <div class="widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="dropdown">
                                <button type="button" class="btn btn-link border-3 dropdown-toggle" data-toggle="dropdown">
                                    Select Portal
                                    <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <?php if (in_array(WebApplication::WEB_APP_BC_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))) { ?>
                                        <a class="dropdown-item" href="<?= Yii::$app->params['app_url']['bc'] ?>">B.C Sakhi Portal</a>

                                    <?php } ?>
                                    <?php if (in_array(WebApplication::WEB_APP_CBO_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))) { ?>
                                        <a class="dropdown-item" href="<?= Yii::$app->params['app_url']['cbo'] ?>">C.B.O Portal</a>
                                    <?php } ?>
                                    <?php if (in_array(WebApplication::WEB_APP_HR_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))) { ?>
                                        <a class="dropdown-item" href="<?= Yii::$app->params['app_url']['hr'] ?>">HR Portal</a>
                                    <?php } ?>
                                    <?php if (in_array(WebApplication::WEB_APP_ADMIN_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))) { ?>
                                        <a class="dropdown-item" href="<?= Yii::$app->params['app_url']['admin'] ?>">Admin Portal</a>
                                    <?php } ?>
                                    <?php if (in_array(WebApplication::WEB_APP_SUPPORT_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))) { ?>
                                        <a class="dropdown-item" href="<?= Yii::$app->params['app_url']['support'] ?>">Support Portal</a>
                                    <?php } ?>
                                    <a class="dropdown-item" href="<?= Yii::$app->params['app_url']['www'] ?>">UPSRLM Portal</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    <?php } ?>
    <?php if ($themename == 'smartadmin') { ?>
        <?php if(isset(Yii::$app->user->identity->application) and count(Yii::$app->user->identity->application)!=2) { ?>
        <li> 
            <a href="#" title="Select Portal" data-filter-tags="select portal">
                <i class="fal fal fa-chart-line"></i>
                <span class="nav-link-text" data-i18n="nav.select_portal">Select Portal</span>
                <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
            </a>
            <ul>
                <?php if (in_array(WebApplication::WEB_APP_BC_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['bc'])) { ?>
                    <li>
                        <a href="<?= Yii::$app->params['app_url']['bc'] ?>" title="B.C Sakhi Portal" data-filter-tags="select portal bc">
                            <span class="nav-link-text" data-i18n="nav.select_portal_bc">B.C Sakhi Portal</span>
                        </a>

                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_CBO_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['cbo'])) { ?>
                    <li >
                        <a href="<?= Yii::$app->params['app_url']['cbo'] ?>"><span> C.B.O Portal </span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_HR_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id')) and isset(Yii::$app->params['app_url']['hr'])) { ?>
                    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_HR_ADMIN, MasterRole::ROLE_MD])) { ?>
                        <li>
                            <a href="<?= Yii::$app->params['app_url']['hr'] ?>"><span> HR Portal </span> </a>
                        </li>
                    <?php } ?>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_ADMIN_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['admin'])) { ?>
                    <li>
                        <a href="<?= Yii::$app->params['app_url']['admin'] ?>"><span> Admin Portal </span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_SUPPORT_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id') )  and isset(Yii::$app->params['app_url']['support'])) { ?>
                    <li>
                        <a href="<?= Yii::$app->params['app_url']['support'] ?>"><span> Support Portal </span> </a>
                    </li>
                <?php } ?> 
                <?php if (in_array(WebApplication::WEB_APP_SAHELI_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['saheli'])) { ?>
                    <li>
                        <a href="<?= Yii::$app->params['app_url']['saheli'] ?>"><span> Saheli Sakhi Portal </span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_WADA_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['wada'])) { ?>
                    <li>
                        <a href="<?= Yii::$app->params['app_url']['wada'] ?>"><span> Wada Sakhi Portal </span> </a>
                    </li>
                <?php } ?>    
                <?php if (in_array(WebApplication::WEB_APP_CALL_CENTER_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['callcenter'])) { ?>
                    <li>
                        <a href="<?= Yii::$app->params['app_url']['callcenter'] ?>"><span> Call Center Portal </span> </a>
                    </li>
                <?php } ?>
                <?php if (in_array(WebApplication::WEB_APP_BC_CALL_CENTER_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['bccallcenter'])) { ?>
                    <li>
                        <a href="<?= Yii::$app->params['app_url']['bccallcenter'] ?>"><span> BC Call Center Portal </span> </a>
                    </li>
                <?php } ?>     
                <?php if (in_array(WebApplication::WEB_APP_DBT_CALL_CENTER_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['dbtcallcenter'])) { ?>
                    <li>
                        <a href="<?= Yii::$app->params['app_url']['dbtcallcenter'] ?>"><span> DBT Call Center Portal </span> </a>
                    </li>
                <?php } ?>  
                 <?php if (in_array(WebApplication::WEB_APP_ULTRA_POOR_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['ultrapoor'])) { ?>
                    <li>
                        <a href="<?= Yii::$app->params['app_url']['ultrapoor'] ?>"><span> Ultra-Poor Portal </span> </a>
                    </li>
                <?php } ?>    
                <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])  and isset(Yii::$app->params['app_url']['www'])) { ?>
                    <li>
                        <a href="<?= Yii::$app->params['app_url']['www'] ?>"><span> UPSRLM Portal </span> </a>
                    </li>
                <?php } ?>


            </ul>
        </li>
        <?php } ?>
    <?php } ?>
<?php } ?>