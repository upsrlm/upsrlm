<?php

use common\models\master\MasterRole;
?>
<aside class="page-sidebar">
    <div class="page-logo">
        <a href="/" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
            <img src="<?= $bundle->baseUrl ?>/img/logo.png" style="width: 70px" alt="CBO" aria-roledescription="logo">
            <span class="page-logo-text mr-1"></span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <!-- <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i> -->
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <?php if (!Yii::$app->user->isGuest) { ?>
        <nav id="js-primary-nav" class="primary-nav" role="navigation">
            <div class="nav-filter">
                <div class="position-relative">
                    <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                    <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                        <i class="fal fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <ul id="js-nav-menu" class="nav-menu">
                <li>
                    <i class="fal fa-dashboard"></i>
                    <a href="/" title="Dashboard" data-method="post">
                        <span class="nav-link-text" >Dashboard</span>
                    </a>
                </li> 
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [ MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]))) { ?>   
                <li>
                    <i class="fal fa-dashboard"></i>
                    <a href="/platform" title="Dashboard" data-method="post">
                        <span class="nav-link-text" >Today Progress</span>
                    </a>
                </li> 
                <li>
                    <i class="fal fa-dashboard"></i>
                    <a href="/platform/progress" title="Dashboard" data-method="post">
                        <span class="nav-link-text" >Overall Progress</span>
                    </a>
                </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN]) or Yii::$app->user->identity->inbound)) { ?>
                    <li>
                        <a class="dropdown-item" href="/platform/list/missedcall">Missed Call</a>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN]))) { ?>
                    <li>
                        <a class="dropdown-item" href="/shg/member">SHG Member</a>
                    </li>   
                <?php } ?> 
                 <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN,MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]))) { ?>
                    <li>
                        <a class="dropdown-item" href="/sms/log">SMS</a>
                    </li>   
                <?php } ?>     
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="User" data-filter-tags="upsrlm user">
                            <i class="fal fa-user"></i>
                            <span class="nav-link-text" data-i18n="nav.upsrlm.user">User</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>

                            <li>
                                <a href="/user" title="Users"> 
                                    <span class="nav-link-text">List</span>
                                </a>
                            </li>

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN]))) { ?>

                                <li>
                                    <a href="/user/add" title="Add User"> 
                                        <span class="nav-link-text">Add New User</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?> 
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="Monitoring" data-filter-tags="upsrlm Monitoring">
                            <i class="fal fa-user"></i>
                            <span class="nav-link-text" data-i18n="nav.upsrlm.user">Monitoring</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]))) { ?>   
                                <li>
                                    <a href="/monitoring/agent/progress" title="Outbound Agent Progress"> 
                                        <span class="nav-link-text">Outbound Agent Progress</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE]))) { ?>   
                                <li>
                                    <a href="/monitoring/ibd" title="Inbound Agent Progress"> 
                                        <span class="nav-link-text">Inbound Agent Progress</span>
                                    </a>
                                </li>
                            <?php } ?> 
                             <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>   
                                <li>
                                    <a href="/report/call/dailyprogress" title="Daily Agent Achievement"> 
                                        <span class="nav-link-text">Daily Agent Achievement</span>
                                    </a>
                                </li>
                            <?php } ?>    
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>   
                                <li>
                                    <a href="/monitoring/scneario/userverification" title="User Verification"> 
                                        <span class="nav-link-text">Scneario User Verification</span>
                                    </a>
                                </li>
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>   
                                <li>
                                    <a href="/monitoring/scneario/cstusernotusedapp" title="User not used Rishta App"> 
                                        <span class="nav-link-text">Scneario CST User not used Rishta App</span>
                                    </a>
                                </li>
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>   
                                <li>
                                    <a href="/monitoring/scneario/notnominatedsamuhsakhi" title="Samuh Sakhi Not Nominated by Chairperson/Secretary/Treasurer"> 
                                        <span class="nav-link-text">Scneario Samuh Sakhi Not Nominated by CST</span>
                                    </a>
                                </li>
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>   
                                <li>
                                    <a href="/monitoring/scneario/samuhsakhinotfillform" title="Samuh Sakhi Not fill form in Rishta APP"> 
                                        <span class="nav-link-text">Scneario Samuh Sakhi Not fill form in Rishta APP</span>
                                    </a>
                                </li>
                            <?php } ?>     

                        </ul>
                    </li>
                <?php } ?>     
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="Cloud Tele Report" data-filter-tags="application intel">
                            <span class="nav-link-text" data-i18n="nav.application_intel">Report</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="/report/call/monthlyinternal">Monthly internal agent report</a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="/report/call/monthlydbt">Monthly DBT agent report</a>
                                </li>
                            <?php } ?>

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="/report/call/realinternal">Internal agent report</a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="/report/call/realdbt">DBT agent report</a>
                                </li>
                            <?php } ?>   

                        </ul>
                    </li>
                <?php } ?>  
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]))) { ?>        
                    <?= common\widgets\SrlmSelectApplication::widget([]) ?>
                <?php } ?>      
                <li> 
                    <a href="#" title="User" data-filter-tags="user">
                        <?php ?>
                        <i class="fal fa-user-cog"></i>
                        <span class="nav-link-text" data-i18n="nav.user">Welcome , <?= \Yii::$app->user->identity->name ?></span>
                        <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                    </a>
                    <ul>
                        <li>

                            <a href="<?= Yii::$app->params['app_url']['www'] . '/changepassword' ?>" title="Change password" data-filter-tags="user change password">
                                <span class="nav-link-text" data-i18n="nav.user_change_password"><i class="fal fa fa-unlock"></i> Change password </span>
                            </a>

                        </li>
                        <li>
                            <a href="<?= Yii::$app->params['app_url']['hr'] . '/profile/view' ?>" title="Profile" data-filter-tags="user profile">
                                <span class="nav-link-text" data-i18n="nav.user_profile"><i class="fal fa-user-circle-o"></i> Profile </span>
                            </a>

                        </li>  
                        <li>
                            <a href="<?= Yii::$app->params['app_url']['www'] . '/site/logout' ?>" data-method="post"><i class="fal fa-power-off"></i> Logout</a>  

                        </li>


                    </ul>
                </li>
            </ul>
            <div class="filter-message js-filter-message bg-success-600"></div>
        </nav>
        <!-- END PRIMARY NAVIGATION -->
        <!-- NAV FOOTER -->
        <div class="nav-footer shadow-top">
            <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
                <i class="ni ni-chevron-right"></i>
                <i class="ni ni-chevron-right"></i>
            </a>
            <ul class="list-table m-auto nav-footer-buttons">
                <li>
                    <a href="<?= Yii::$app->params['app_url']['hr'] . '/profile/view' ?>" data-toggle="tooltip" data-placement="top" title="Profile">
                        <i class="fal fa-users"></i>
                    </a>
                </li>
                <li>
                    <a href="<?= Yii::$app->params['app_url']['www'] . '/changepassword' ?>" data-toggle="tooltip" data-placement="top" title="Changepassword">
                        <i class="fal fa-life-ring"></i>
                    </a>
                </li>
                <li>
                    <a href="/site/logout" data-method="post" data-toggle="tooltip" data-placement="top" title="logout">
                        <i class="fal fa-sign-out"></i>
                    </a>
                </li>
            </ul>
        </div> <!-- END NAV FOOTER -->
    <?php } ?>
</aside>
<p id="js-color-profile" class="d-none">
    <span class="color-primary-50"></span>
    <span class="color-primary-100"></span>
    <span class="color-primary-200"></span>
    <span class="color-primary-300"></span>
    <span class="color-primary-400"></span>
    <span class="color-primary-500"></span>
    <span class="color-primary-600"></span>
    <span class="color-primary-700"></span>
    <span class="color-primary-800"></span>
    <span class="color-primary-900"></span>
    <span class="color-info-50"></span>
    <span class="color-info-100"></span>
    <span class="color-info-200"></span>
    <span class="color-info-300"></span>
    <span class="color-info-400"></span>
    <span class="color-info-500"></span>
    <span class="color-info-600"></span>
    <span class="color-info-700"></span>
    <span class="color-info-800"></span>
    <span class="color-info-900"></span>
    <span class="color-danger-50"></span>
    <span class="color-danger-100"></span>
    <span class="color-danger-200"></span>
    <span class="color-danger-300"></span>
    <span class="color-danger-400"></span>
    <span class="color-danger-500"></span>
    <span class="color-danger-600"></span>
    <span class="color-danger-700"></span>
    <span class="color-danger-800"></span>
    <span class="color-danger-900"></span>
    <span class="color-warning-50"></span>
    <span class="color-warning-100"></span>
    <span class="color-warning-200"></span>
    <span class="color-warning-300"></span>
    <span class="color-warning-400"></span>
    <span class="color-warning-500"></span>
    <span class="color-warning-600"></span>
    <span class="color-warning-700"></span>
    <span class="color-warning-800"></span>
    <span class="color-warning-900"></span>
    <span class="color-success-50"></span>
    <span class="color-success-100"></span>
    <span class="color-success-200"></span>
    <span class="color-success-300"></span>
    <span class="color-success-400"></span>
    <span class="color-success-500"></span>
    <span class="color-success-600"></span>
    <span class="color-success-700"></span>
    <span class="color-success-800"></span>
    <span class="color-success-900"></span>
    <span class="color-fusion-50"></span>
    <span class="color-fusion-100"></span>
    <span class="color-fusion-200"></span>
    <span class="color-fusion-300"></span>
    <span class="color-fusion-400"></span>
    <span class="color-fusion-500"></span>
    <span class="color-fusion-600"></span>
    <span class="color-fusion-700"></span>
    <span class="color-fusion-800"></span>
    <span class="color-fusion-900"></span>
</p>
<!-- END Color profile -->