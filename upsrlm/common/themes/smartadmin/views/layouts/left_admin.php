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
            <!--            <div class="info-card">
                            <img src="<?= $bundle->baseUrl ?>/img/user.png" class="profile-image rounded-circle" alt="<?= Yii::$app->user->identity->name ?>">
                            <div class="info-card-text">
                                <a href="#" class="d-flex align-items-center text-white">
                                    <span class="text-truncate text-truncate-sm d-inline-block">
            <?= Yii::$app->user->identity->name ?>
                                    </span>
                                </a>
                                <span class="d-inline-block text-truncate text-truncate-sm"></span>
                            </div>
                            <img src="<?= $bundle->baseUrl ?>/img/card-backgrounds/cover-2-lg.png" class="cover" alt="cover">
            
                        </div>-->
            <ul id="js-nav-menu" class="nav-menu">
                <li>
                    <i class="fal fa-dashboard"></i>
                    <a href="/dashboard" title="Dashboard" data-method="post">
                        <span class="nav-link-text" >Dashboard</span>
                    </a>
                </li>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="User" data-filter-tags="upsrlm user">
                            <i class="fal fa-user"></i>
                            <span class="nav-link-text" data-i18n="nav.upsrlm.user">User</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <li>
                                <a href="/user" title="Users"> 
                                    <span class="nav-link-text">User List</span>
                                </a>
                            </li>
                            <?php if (Yii::$app->user->identity->role == MasterRole::ROLE_ADMIN || Yii::$app->user->identity->role == MasterRole::ROLE_CALL_CENTER_ADMIN) { ?>

                                <li>
                                    <a href="/user/add" title="Add User"> 
                                        <span class="nav-link-text">Add New User</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="/user/bmmu" title="BMMU"> 
                                    <span class="nav-link-text" data-i18n="nav.user_bmmu">BMMU</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/dmmu" title="DMMU"> 
                                    <span class="nav-link-text" data-i18n="nav.user_dmmu">DMMU</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/smmu" title="SMMU">

                                    <span class="nav-link-text">SMMU</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/bdo" title="BDO" > <span class="nav-link-text">BDO</span></a>
                            </li>
                            <li>
                                <a href="/user/bc" title="BC User">
                                    <span class="nav-link-text">BC User</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/cbo" title="CBO User">
                                    <span class="nav-link-text">CBO User</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/dm" title="District Magistrate"> 
                                    <span class="nav-link-text">District Magistrate</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/dcnrlm" title="DC NRLM"> 
                                    <span class="nav-link-text">DC NRLM </span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/cdo" title="Chief Development Officer"> 
                                    <span class="nav-link-text">Chief Development Officer </span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/dc" title="Divisional Commissioner"> 
                                    <span class="nav-link-text">Divisional Commissioner </span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/yp" title="Verifiers" > 
                                    <span class="nav-link-text">Verifiers (Young professional)</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/rsethis" title="RSETI"> 
                                    <span class="nav-link-text">RSETI</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/rsethibacthcreator" title="RSETI Batch creator"> 
                                    <span class="nav-link-text">RSETI Batch creator</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/nodalbank" title="RSETI Nodal Bank"> 
                                    <span class="nav-link-text">RSETI Nodal Bank</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/supportunit" title="Support Unit"> 
                                    <span class="nav-link-text">Support Unit</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/bankdu" title="Bank/ FI partner agencies"> 
                                    <span class="nav-link-text">Bank/ FI partner agencies</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user/bankfipdnodal" title="Bank/FI Partner District Nodal"> 
                                    <span class="nav-link-text">Bank/FI Partner District Nodal</span>
                                </a>
                            </li>

                            <!--                            <li>
                                                            <a href="/user/deleted" title="Deleted user List"> 
                                                                <span class="nav-link-text">Deleted user List</span>
                                                            </a>
                                                        </li>-->

                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="Master" data-filter-tags="usrlm master">
                            <i class="fal fa-list"></i>
                            <span class="nav-link-text" data-i18n="nav.bc.selection">Master</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <li class="dropdown-header">
                                <a href="/master/block/index"> 
                                    <span class="nav-link-text">Block List</span>
                                </a>
                            </li>
                            <li class="dropdown-header">
                                <a href="/master/grampanchayat/index"> 

                                    <span class="nav-link-text">Gram Panchayat List</span> 
                                </a>
                            </li>
                            <li class="dropdown-header">
                                <a href="/master/master-village/index"> 

                                    <span class="nav-link-text">Village List</span> 
                                </a>
                            </li>
                            <li class="dropdown-header">
                                <a href="/master/partneragencies"> 

                                    <span class="nav-link-text">Partner agencies</span> 
                                </a>  
                            </li>
                            <!--                            <li class="dropdown-header">
                                                            <a href="/master/master-ulb/index">
                            
                                                                <span class="nav-link-text">ULB List</span> 
                                                            </a>
                                                        </li>
                                                          <li class="dropdown-header">
                                                            <a href="/master/ward/index"> 
                            
                                                                <span class="nav-link-text"> Ward List</span> 
                                                            </a>
                                                        </li>-->

                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="Front" data-filter-tags="bc shortlisted">
                            <i class="fal fa-file"></i>
                            <span class="nav-link-text" data-i18n="nav.bc.shortlisted">Front</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul >
                            <li>
                                <a href="/front/notice"> 

                                    <span class="nav-link-text">Notice List</span> 
                                </a>
                            </li>
                            <li >
                                <a href="/front/go"> 

                                    <span class="nav-link-text">Government Order List</span> 
                                </a>
                            </li>
                            <li>
                                <a href="/front/mediacoverage"> 

                                    <span class="nav-link-text">Media Coverage List</span> 
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="BC" data-filter-tags="application intel">
                            <i class="fal fa-female"></i>
                            <span class="nav-link-text" data-i18n="nav.application_intel">BC-Selection</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <li>
                                <a href="/bc/darpan/district"> 

                                    <span class="nav-link-text">Darpan</span> 
                                </a>
                            </li>
                            <li>
                                <a href="/bc/appinstall"> 

                                    <span class="nav-link-text">App Install</span> 
                                </a>
                            </li>
                            <li>
                                <a href="/bc/apilog"> 

                                    <span class="nav-link-text">Api Log</span> 
                                </a>
                            </li>
                            <li>
                                <a href="/bc/smslog/"> 

                                    <span class="nav-link-text">SMS Log</span> 
                                </a>
                            </li>

                            <li>
                                <a href="/bc/notificationlog/"> 

                                    <span class="nav-link-text">Notification Log</span> 
                                </a>
                            </li>
                            <li>
                                <a href="/bc/notificationtemplate/"> 

                                    <span class="nav-link-text">Notification Templates</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="Rishta" data-filter-tags="application intel">
                            <i class="fal fa-female"></i>
                            <span class="nav-link-text" data-i18n="nav.application_intel">Rishta</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <li>
                                <a href="/rishta/appinstall"> 

                                    <span class="nav-link-text">App Install</span> 
                                </a>
                            </li>  
                            <li>
                                <a href="/rishta/web/log"> 

                                    <span class="nav-link-text">Web Log</span> 
                                </a>
                            </li>

                            <li>
                                <a href="/rishta/sms/log"> 

                                    <span class="nav-link-text">SMS Log</span> 
                                </a>
                            </li>

                            <li>
                                <a href="/rishta/rolepermission"> 

                                    <span class="nav-link-text">Role Permission</span> 
                                </a>
                            </li>
                            <li>
                                <a href="/rishta/notificationlog/"> 

                                    <span class="nav-link-text">Notification Log</span> 
                                </a>
                            </li>
                            <li>
                                <a href="/rishta/notificationtemplate/"> 

                                    <span class="nav-link-text">Notification Templates</span>
                                </a>
                            </li>



                        </ul>
                    </li>
                <?php } ?> 
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="Rishta" data-filter-tags="application intel">
                            <i class="fal fa-phone"></i>
                            <span class="nav-link-text" data-i18n="nav.application_intel">Cloud Call center</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <li>
                                <a href="/cloudtel/log/ibd"> 

                                    <span class="nav-link-text">IBD Call Logs</span> 
                                </a>
                            </li>
                            <li>
                                <a href="/cloudtel/log/"> 

                                    <span class="nav-link-text">OBD Call Logs</span> 
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php } ?> 
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="CBO" data-filter-tags="application intel">
        <!--                            <i class="fal fa-female"></i>-->
                            <span class="nav-link-text" data-i18n="nav.application_intel">CBO</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>


                            <li>
                                <a href="/cbo/clf"><span class="nav-link-text">CLF's</span></a>
                            </li>

                            <li>
                                <a href="/cbo/member"> 

                                    <span class="nav-link-text">Member's report</span> 
                                </a>
                            </li>
                            <li>
                                <a href="/cbo/shg/report"> 

                                    <span class="nav-link-text">SHG's report</span> 
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php } ?>     
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>

                    <!--                    <li>
                                            <a href="/audit"><span class="nav-link-text">Web Audit</span></a>
                                        </li>-->

                <?php } ?>    
                <?= common\widgets\SrlmSelectApplication::widget([]) ?>
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
                            <a href="<?= yii\helpers\Url::to(['/site/logout']) ?>" data-method="post"><i class="fal fa-power-off"></i> Logout</a>  

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