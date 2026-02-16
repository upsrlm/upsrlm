<?php

use common\models\master\MasterRole;
$baseUrl = '/bc';  // BC module base path
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

                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->id, [20543]))) { ?>
                    <li> 
                        <a href="#" title="Select Portal" data-filter-tags="select portal">
                            <i class="fal fal fa-chart-line"></i>
                            <span class="nav-link-text" data-i18n="nav.select_portal">Select Portal</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>

                            <li>
                                <a href="<?= Yii::$app->params['app_url']['bc'] ?>" title="B.C Sakhi Portal" data-filter-tags="select portal bc">
                                    <span class="nav-link-text" data-i18n="nav.select_portal_bc">B.C Sakhi Portal</span>
                                </a>

                            </li>


                            <li >
                                <a href="<?= Yii::$app->params['app_url']['cbo'] ?>"><span> C.B.O Portal </span> </a>
                            </li>


                            <li>
                                <a href="<?= Yii::$app->params['app_url']['wada'] ?>"><span> Wada Sakhi Portal </span> </a>
                            </li>


                            <li>
                                <a href="<?= Yii::$app->params['app_url']['ultrapoor'] ?>"><span> Ultra-Poor Portal </span> </a>
                            </li>




                        </ul>
                    <?php } else { ?>
                        <?= common\widgets\SrlmSelectApplication::widget([]) ?>
                    <?php } ?>
                    <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                    <li>
                        <a href="#" title="BC Applications" data-filter-tags="bc application">
        <!--                            <i class="fal fa-user-crown"></i>-->
                            <span class="nav-link-text" data-i18n="nav.bc.application">BC Applications</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <li>
                                <a href="<?= $baseUrl ?>/selection/dashboard" title="Application - Dashboard" data-filter-tags="bc application dashboard">
                                    <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application - Dashboard</span>
                                </a>
                            </li>

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>     
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/district">
                                        <i class="fa fa-globe"></i> District Wise Status
                                    </a> 
                                </li>


                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/block">
                                        <i class="fa fa-globe"></i> Block Wise Status
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/grampanchayat">
                                        <i class="fa fa-globe"></i> GP Wise Status
                                    </a>
                                </li>
                                <!--                            <li>
                                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/registration">
                                                                    <i class="fa fa-globe"></i> GP with No Registration
                                                                </a>
                                                            </li>-->
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/districtgp">
                                        <i class="fa fa-globe"></i> GP with No Registration summary
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/downloadcsvgp">
                                        <i class="fa fa-download"></i> GP wise application report
                                    </a>
                                </li>
                            <?php } ?> 
                                
                             <?php if (!Yii::$app->user->isGuest and '0' && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>  
                                <li>
                                    <a href="#" title="Phase6">
                                        <span class="nav-link-text">Phase 7</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $baseUrl ?>/selection/phase7/dashboard" title="Phase7 Application - Dashboard" data-filter-tags="phase2_application dashboard">
                                        <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application - Dashboard</span>
                                    </a>
                                </li>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase7/application/singleapplication"><i class="fa fa-dashboard"></i> Single application</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase7/application/dublicate"><i class="fa fa-dashboard"></i> Aadhar duplicacy</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase7/application/districtgp">
                                            <i class="fa fa-globe"></i> District Wise Status
                                        </a> 
                                    </li>


                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase7/application/gp">
                                            <i class="fa fa-globe"></i> GP Wise Status
                                        </a>
                                    </li>
                                <?php } ?>   

                            <?php } ?>      
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>  
                                <li>
                                    <a href="#" title="Phase6">
                                        <span class="nav-link-text">Phase 6</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $baseUrl ?>/selection/phase6/dashboard" title="Phase4 Application - Dashboard" data-filter-tags="phase2_application dashboard">
                                        <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application - Dashboard</span>
                                    </a>
                                </li>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase6/application/singleapplication"><i class="fa fa-dashboard"></i> Single application</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase6/application/dublicate"><i class="fa fa-dashboard"></i> Aadhar duplicacy</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase6/application/districtgp">
                                            <i class="fa fa-globe"></i> District Wise Status
                                        </a> 
                                    </li>


                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase6/application/gp">
                                            <i class="fa fa-globe"></i> GP Wise Status
                                        </a>
                                    </li>
                                <?php } ?>   

                            <?php } ?>    
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>  
                                <li>
                                    <a href="#" title="Phase5">
                                        <span class="nav-link-text">Phase 5</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $baseUrl ?>/selection/phase5/dashboard" title="Phase4 Application - Dashboard" data-filter-tags="phase2_application dashboard">
                                        <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application - Dashboard</span>
                                    </a>
                                </li>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase5/application/singleapplication"><i class="fa fa-dashboard"></i> Single application</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase5/application/dublicate"><i class="fa fa-dashboard"></i> Aadhar duplicacy</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase5/application/districtgp">
                                            <i class="fa fa-globe"></i> District Wise Status
                                        </a> 
                                    </li>


                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase5/application/gp">
                                            <i class="fa fa-globe"></i> GP Wise Status
                                        </a>
                                    </li>
                                <?php } ?>   

                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>  
                                <li>
                                    <a href="#" title="Phase4">
                                        <span class="nav-link-text">Phase 4</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $baseUrl ?>/selection/phase4/dashboard" title="Phase4 Application - Dashboard" data-filter-tags="phase2_application dashboard">
                                        <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application - Dashboard</span>
                                    </a>
                                </li>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase4/application/singleapplication"><i class="fa fa-dashboard"></i> Single application</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase4/application/dublicate"><i class="fa fa-dashboard"></i> Aadhar duplicacy</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase4/application/districtgp">
                                            <i class="fa fa-globe"></i> District Wise Status
                                        </a> 
                                    </li>


                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase4/application/gp">
                                            <i class="fa fa-globe"></i> GP Wise Status
                                        </a>
                                    </li>
                                <?php } ?>  

                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>  
                                <li>
                                    <a href="#" title="Phase3">
                                        <span class="nav-link-text">Phase 3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $baseUrl ?>/selection/phase3/dashboard" title="Phase3 Application - Dashboard" data-filter-tags="phase2_application dashboard">
                                        <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application - Dashboard</span>
                                    </a>
                                </li>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase3/application/singleapplication"><i class="fa fa-dashboard"></i> Single application</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase3/application/dublicate"><i class="fa fa-dashboard"></i> Aadhar duplicacy</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase3/application/districtgp">
                                            <i class="fa fa-globe"></i> District Wise Status
                                        </a> 
                                    </li>


                                    <li>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase3/application/gp">
                                            <i class="fa fa-globe"></i> GP Wise Status
                                        </a>
                                    </li>
                                <?php } ?>

                            <?php } ?>     
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>  
                                <li>
                                    <a href="javascript:void(0);" title="Phase2" data-filter-tags="pages phase2">
                                        <span class="nav-link-text">Phase 2</span>
                                    </a>

                                </li>

                                <li>
                                    <a href="<?= $baseUrl ?>/selection/phase2/dashboard" title="Phase2 Application - Dashboard" data-filter-tags="pages phase2 dashboard">
                                        <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application - Dashboard</span>
                                    </a>
                                </li>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                    <li>
                                        <a class="nav-link-text" href="<?= $baseUrl ?>/selection/phase2/application/singleapplication" data-filter-tags="pages phase2 single application"><i class="fa fa-dashboard"></i> Single application</a>
                                    </li>
                                    <li>
                                        <a class="nav-link-text" href="<?= $baseUrl ?>/selection/phase2/application/dublicate" data-filter-tags="pages phase2 aadhar duplicacy"><i class="fa fa-dashboard"></i> Aadhar duplicacy</a>
                                    </li>
                                    <li>
                                        <a class="nav-link-text" href="<?= $baseUrl ?>/selection/phase2/application/districtgp" data-filter-tags="pages phase2 district">
                                            <i class="fa fa-globe"></i> District Wise Status
                                        </a> 
                                    </li>


                                    <li>
                                        <a class="nav-link-text" href="<?= $baseUrl ?>/selection/phase2/application/gp" data-filter-tags="pages phase2 gp">
                                            <i class="fa fa-globe"></i> GP Wise Status
                                        </a>
                                    </li>  
                                <?php } ?>   
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>  
                                <li>
                                    <a href="javascript:void(0);" title="Phase1" data-filter-tags="pages phase1">
                                        <span class="nav-link-text">Phase 1</span>
                                    </a>

                                </li>

                                <li>
                                    <a href="<?= $baseUrl ?>/selection/dashboard/phase1" title="Phase1 Application - Dashboard" data-filter-tags="pages phase1 dashboard">
                                        <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application - Dashboard</span>
                                    </a>
                                </li>

                            <?php } ?>        

                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BC_VIEWER]))) { ?>
                    <li>
                        <a href="#" title="BC Applications" data-filter-tags="bc application">
        <!--                            <i class="fal fa-user-crown"></i>-->
                            <span class="nav-link-text" data-i18n="nav.bc.application">BC Applications</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <li>
                                <a href="<?= $baseUrl ?>/selection/dashboard" title="Application-All" data-filter-tags="bc application dashboard">
                                    <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application-All</span>
                                </a>
                            </li>
<!--                            <li>
                                <a href="<?= $baseUrl ?>/selection/phase7/dashboard" title="Application - Round 7" data-filter-tags="phase7_application dashboard">
                                    <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application July, 2023 Round 7</span>
                                </a>
                            </li>-->
                            <li>
                                <a href="<?= $baseUrl ?>/selection/phase6/dashboard" title="Application - Round 6" data-filter-tags="phase6_application dashboard">
                                    <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application Aug, 2023 Round 6</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= $baseUrl ?>/selection/phase5/dashboard" title="Application - Round 5" data-filter-tags="phase5_application dashboard">
                                    <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application Jan, 2023 Round 5</span>
                                </a>
                            </li>



                            <li>
                                <a href="<?= $baseUrl ?>/selection/phase4/dashboard" title="Application Round 4" data-filter-tags="phase2_application dashboard">
                                    <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application May, 2022 Round 4</span>
                                </a>
                            </li>


                            <li>
                                <a href="<?= $baseUrl ?>/selection/phase3/dashboard" title="Application Round 3" data-filter-tags="phase3_application dashboard">
                                    <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application Dec, 2021 Round 3</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= $baseUrl ?>/selection/phase2/dashboard" title="Application - Dashboard Phase 2" data-filter-tags="pages phase2 dashboard">
                                    <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application Oct, 2021 Round 2</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= $baseUrl ?>/selection/dashboard/phase1" title="Application - Dashboard Phase 1" data-filter-tags="pages phase1 dashboard">
                                    <span class="nav-link-text" data-i18n="nav.bc_application_dashboard">Application Jun, 2020 Round 1</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SPM_FI_MF]))) { ?>
                    <li>
                        <a href="#" title="BC Applications" data-filter-tags="bc application">
        <!--                            <i class="fal fa-user-crown"></i>-->
                            <span class="nav-link-text" data-i18n="nav.bc.application">BC Applications</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SPM_FI_MF]))) { ?>  
                                <li>
                                    <a href="#" title="Phase2">
                                        <span class="nav-link-text">Phase 2</span>
                                    </a>
                                </li>


                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase2/application/gp">
                                        <i class="fa fa-globe"></i> GP Wise Status
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Phase3">
                                        <span class="nav-link-text">Phase 3</span>
                                    </a>
                                </li>


                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase3/application/gp">
                                        <i class="fa fa-globe"></i> GP Wise Status
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Phase4">
                                        <span class="nav-link-text">Phase 4</span>
                                    </a>
                                </li>


                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase4/application/gp">
                                        <i class="fa fa-globe"></i> GP Wise Status
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Phase5">
                                        <span class="nav-link-text">Phase 5</span>
                                    </a>
                                </li>


                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase5/application/gp">
                                        <i class="fa fa-globe"></i> GP Wise Status
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Phase6">
                                        <span class="nav-link-text">Phase 6</span>
                                    </a>
                                </li>


                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase6/application/gp">
                                        <i class="fa fa-globe"></i> GP Wise Status
                                    </a>
                                </li>
<!--                                
                                 <li>
                                    <a href="#" title="Phase7">
                                        <span class="nav-link-text">Phase 7</span>
                                    </a>
                                </li>


                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/phase7/application/gp">
                                        <i class="fa fa-globe"></i> GP Wise Status
                                    </a>
                                </li>-->
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>  

                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BC_VIEWER]))) { ?>
                    <li>
                        <a href="#" title="BC applications report" data-filter-tags="bc selection">
                            <span class="nav-link-text" data-i18n="nav.bc.selection">BC applications report</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <li>
                                <a href="<?= $baseUrl ?>/selection/dashboard/report" title="Report" data-filter-tags="vo dashboard">
                                    <span class="nav-link-text" data-i18n="nav.vo_dashboard">Report</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/dashboard/graph"><i class="fa fa-chart-bar"></i> Graphs</a>
                            </li>

                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_DM, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_VIEWER, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                    <li>
                        <a href="#" title="BC Shortlisted" data-filter-tags="bc shortlisted">
        <!--                            <i class="fal fa-file"></i>-->
                            <span class="nav-link-text" data-i18n="nav.bc.shortlisted">BC pre-selected</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <li>
                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected">Pre Selected</a>
                            </li>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected/urban">Urban</a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                <!--                                <li>
                                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/missing">BC Misplaced</a>
                                                                </li>-->
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                <!--                                <li>
                                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected/vacantgp">Vacant GP</a>
                                                                </li>-->
                            <?php } ?>  
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                <!--                                <li>
                                                                                <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected/standbydownload">Download 1st Stand By List for Verification</a>
                                                                            </li>-->
                            <?php } ?>     
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DM, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_BC_VIEWER]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected/graph">Graph</a>
                                </li>
                            <?php } ?>
                            <!--                            <li>
                                                            <a class="dropdown-item" href="<?= $baseUrl ?>/selection/preselected/bcdata">Download List for Verification</a>
                                                        </li>-->


                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR]))) { ?>
                    <li>
                        <a href="#" title="RSETIs Training" data-filter-tags="application intel">

                            <span class="nav-link-text" data-i18n="nav.application_intel">RSETIs Training</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected">Add training participants/ form batch</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li> 
                <?php } ?>  
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_VIEWER, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                    <li>
                        <a href="#" title="RSETIs Training" data-filter-tags="application intel">
        <!--                            <i class="fal fa-female"></i>-->
                            <span class="nav-link-text" data-i18n="nav.application_intel">RSETIs Training</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/dashboard">Dashboard</a>
                                </li>
                            <?php } ?>
                            <li>
                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/ecalendar">Training e-calendar</a>
                            </li>
                            <li>  
                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/report">Training Report</a>

                            </li>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected">Add training participants/ form batch</a>
                                </li>
                            <?php } ?>
                            <li>  
                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/training">View Training List</a>
                            </li>     
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <!--                                                                <li>  
                                                                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/ineligiblelist">Reason for Ineligible</a> 
                                                                                                </li>-->
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <li>  <a class="dropdown-item" href="<?= $baseUrl ?>/training/educationeligibility">Confirm Education Eligibility</a></li>
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <li> <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/unwillinglist">Final Unwilling Candidate</a></li>
                            <?php } ?> 

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                <li>    
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/agreed">Agree for training</a>
                                </li>
                                <li>    
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/inbatch">Registered (Batch Assigned)</a>
                                </li>
                                <li>    
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/blocked">Preselected blocked BC</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/certified/blocked">Certified blocked BC</a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>   
                                <li >  
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/certified/bankunwilling">
                                        <i class="mdi mdi-view-list"></i> <span>Certified BC Unwiling (Call centre verification pending)</span> 

                                    </a>
                                </li> 
                            <?php } ?>
<!--                            <li >  
                                <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/certified/unwilling">
                                    <i class="mdi mdi-view-list"></i> <span>Unwillingness/ migration/ demise</span> 

                                </a>
                            </li>       -->



                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BC_VIEWER]))) { ?>
                    <li>
                        <a href="#" title="BC training" data-filter-tags="application intel">
        <!--                            <i class="fal fa-female"></i>-->
                            <span class="nav-link-text" data-i18n="nav.application_intel">BC training</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/dashboard">Dashboard</a>
                                </li>
                            <?php } ?>
                            <li>
                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/ecalendar">Training e-calendar</a>
                            </li>
                            <li>  
                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/report">Training Report</a>

                            </li>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected">Add training participants/ form batch</a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <!--                                                                <li>  
                                                                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/ineligiblelist">Reason for Ineligible</a> 
                                                                                                </li>-->
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <li>  <a class="dropdown-item" href="<?= $baseUrl ?>/training/educationeligibility">Confirm Education Eligibility</a></li>
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <li> <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/unwillinglist">Unwilling</a></li>
                            <?php } ?> 
                            <!--                            <li>    
                                                            <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/blocked">List of blocked BC</a>
                                                        </li>-->
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                <!--                                <li>
                                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/certified/blocked">Certified blocked BC</a>
                                                                </li>-->
                            <?php } ?>

                            <li>  
                                <a class="dropdown-item" href="<?= $baseUrl ?>/training/training">View Training List</a>
                            </li>      
<!--                            <li >  
                                <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/certified/unwilling">
                                    <i class="mdi mdi-view-list"></i> <span>BC Certified unwilling</span> 

                                </a>
                            </li>       -->



                        </ul>
                    </li>
                <?php } ?>  
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RBI]))) { ?>
                    <li> 
                        <a href="<?= $baseUrl ?>/report/bc/ac194n" title="Dashboard: Tagging 194N " data-filter-tags="Dashboard: Tagging 194N">
        <!--                            <i class="fal fa-info-circle"></i>-->
                            <span class="nav-link-text" data-i18n="nav.report"> Dashboard: Tagging 194N </span>

                        </a>

                    </li>
                    <li>
                        <a href="<?= $baseUrl ?>/report/bc/ac194nifsc" title="IFSC-wise pendency" data-filter-tags="IFSC-wise pendency">
        <!--                            <i class="fal fa-info-circle"></i>-->
                            <span class="nav-link-text" data-i18n="nav.report"> IFSC-wise pendency </span>

                        </a>
                    </li>

                    <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->id, [326328, 326541]))) { ?>
                        <li>
                            <a href="<?= $baseUrl ?>/transaction/report/chart1" title="Performance report " data-filter-tags="Performance report">
            <!--                            <i class="fal fa-info-circle"></i>-->
                                <span class="nav-link-text" data-i18n="nav.report"> Performance report </span>

                            </a>
                        </li>
                    <?php } ?>  
                <?php } ?>    
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_VIEWER, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                    <li> 
                        <a href="<?= $baseUrl ?>/training/participants" title="Progress MIS" data-filter-tags="Progress MIS">
        <!--                            <i class="fal fa-info-circle"></i>-->
                            <span class="nav-link-text" data-i18n="nav.report">Progress MIS</span>

                        </a>

                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BC_VIEWER]))) { ?>
                    <li> 
                        <a href="<?= $baseUrl ?>/training/participants" title="BC trg. progress MIS" data-filter-tags="BC trg. progress MIS">
        <!--                            <i class="fal fa-info-circle"></i>-->
                            <span class="nav-link-text" data-i18n="nav.report">BC trg. progress MIS</span>

                        </a>

                    </li>
                <?php } ?>    
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_VIEWER]))) { ?>
                   
                    <li>
                        <a href="#" title="Certified BC" data-filter-tags="application intel">
        <!--                            <i class="fal fa-female"></i>-->
                            <span class="nav-link-text" data-i18n="nav.application_intel">Certified BC</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <li>
                                <a title="Certified BC List" data-filter-tags="Certified BC List" href="<?= $baseUrl ?>/training/participants/certified">List</a> 
                            </li>
                             <?php if ((in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MSC]))) { ?>
                            <li>
                                <a title="Unwilling List" data-filter-tags="Unwilling List" href="<?= $baseUrl ?>/training/certified/unwillingprogress">Unwilling List</a> 
                            </li>
                             <?php }?>
                             <?php if ((in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_CDO, MasterRole::ROLE_MSC]))) { ?>
                            <li>
                                <a title="Unwilling Pendency" data-filter-tags="Unwilling Pendency" href="<?= $baseUrl ?>/training/certified/cdounwilling">Unwilling Pendency at CDO</a> 
                            </li>
                             <?php } ?>
                             <?php if ((in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN,MasterRole::ROLE_MD, MasterRole::ROLE_MSC]))) { ?>
                            <li>
                                <a title="Unwilling Pendency" data-filter-tags="Unwilling Pendency" href="<?= $baseUrl ?>/training/certified/upsrlmunwilling">Unwilling Pendency at UPSRLM</a> 
                            </li>
                             <?php } ?>
                             <?php if ((in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_MD, MasterRole::ROLE_MSC]))) { ?>
                            <li>
                                <a title="Paytm to SBI" data-filter-tags="Paytm to SBI" href="<?= $baseUrl ?>/training/participants/paytm">Paytm to SBI</a> 
                            </li>
                             <?php } ?>
                            <li>
                                <a title="Unwilling/ migrated / demise" data-filter-tags="Unwilling/ migrated / demise" href="<?= $baseUrl ?>/training/certified/unwilling">Unwilling/ migrated / demise</a> 
                            </li>




                        </ul>  
                        <!--                    <li>  
                                                <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/certified">
                                                    <i class="mdi mdi-view-list"></i> <span>Certified BC</span> 
                        
                                                </a>-->
                    </li> 
                <?php } ?> 
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BC_VIEWER]))) { ?>
                    <li>  
                        <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/certified">
                            <i class="mdi mdi-view-list"></i> <span>Certified BCs' details</span> 

                        </a>
                    </li> 
                <?php } ?>     
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE]))) { ?>
                    <li> 
                        <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/verification">
                            <i class="mdi mdi-view-list"></i> <span>Verification</span> 

                        </a>
                    </li> 
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BC_VIEWER]))) { ?>
                    <li> 
                        <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/verification">
                            <i class="mdi mdi-view-list"></i> <span>Verification: BC testimonies</span> 

                        </a>
                    </li> 
                <?php } ?>   
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_SPM_FINANCE]))) { ?>      
                    <li>
                        <a href="#" title="BC-SHG PFMS & Payment" data-filter-tags="application intel">
        <!--                            <i class="fal fa-female"></i>-->
                            <span class="nav-link-text" data-i18n="nav.application_intel">PFMS & Payment</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_SPM_FINANCE]))) { ?>
                                <li> 
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/pfmspayment">
                                        <i class="mdi mdi-view-list"></i> <span>BC-SHG PFMS & Payment</span> 

                                    </a>
                                </li> 
                            <?php } ?>     
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_SPM_FINANCE]))) { ?>
                                <li>  
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/bcpfmsmapping">
                                        <i class="mdi mdi-view-list"></i> <span>BC-PFMS</span> 

                                    </a>
                                </li> 
                            <?php } ?>   
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_SPM_FINANCE]))) { ?>
                                <li >  
                                    <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/honorarium">
                                        <i class="mdi mdi-view-list"></i> <span>BC Honorarium</span> 

                                    </a>
                                </li> 
                            <?php } ?>

                        </ul>
                    </li>    
                <?php } ?>

                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DC_NRLM]))) { ?>
                    <li>  
                        <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/participants/bcpfmsmapping">
                            <i class="mdi mdi-view-list"></i> <span>BC-PFMS</span> 

                        </a>
                    </li> 
                <?php } ?> 
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BC_VIEWER]))) { ?>
                    <li>
                        <a href="#" title="RSETIs Training" data-filter-tags="application intel">
        <!--                            <i class="fal fa-female"></i>-->
                            <span class="nav-link-text" data-i18n="nav.application_intel">Analytics (Txn. report)</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BC_VIEWER]))) { ?>
                                <li>
                                    <a title="Report 1" data-filter-tags="Report 1" href="<?= $baseUrl ?>/transaction/report/chart">Report 1</a> 
                                </li>
                                <li>
                                    <a title="Report 2" data-filter-tags="Report 2" href="<?= $baseUrl ?>/transaction/report/reportchart">Report 2</a> 
                                </li>
                                <li>
                                    <a title="Report 2(1)" data-filter-tags="Report 2_1" href="<?= $baseUrl ?>/transaction/report/reportchart1">Report 2_1</a> 
                                </li>
                                <li>
                                    <a title="Report 2(2)" data-filter-tags="Report 2_2" href="<?= $baseUrl ?>/transaction/report/reportchart2">Report 2_2</a> 
                                </li>
                                <li>
                                    <a title="Report 2(3)" data-filter-tags="Report 2_3" href="<?= $baseUrl ?>/transaction/report/reportchart3">Report 2_3</a> 
                                </li>
                                <li>
                                    <a title="Report 2(4)" data-filter-tags="Report 2_4" href="<?= $baseUrl ?>/transaction/report/reportchart4">Report 2_4</a> 
                                </li>
                                <li>
                                    <a title="Report 3" data-filter-tags="Report 3" href="<?= $baseUrl ?>/transaction/report/monthlychart">Report 3</a> 
                                </li>

                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_DC_NRLM]))) { ?>
                    <li>
                        <a href="#" title="RSETIs Training" data-filter-tags="application intel">
        <!--                            <i class="fal fa-female"></i>-->
                            <span class="nav-link-text" data-i18n="nav.application_intel">Bank/FI</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT]))) { ?>
                                <li>

                                    <a title="Manage User" data-filter-tags="Manage User" href="<?= $baseUrl ?>/partneragencies/user">Nodal User</a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                <li>

                                    <a title="Manage Corporate BCs User" data-filter-tags="Manage Corporate BC" href="<?= $baseUrl ?>/partneragencies/user/bankfipcorporatebc">Corporate BCs User</a>
                                </li>
                            <?php } ?>   
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) and Yii::$app->user->identity->master_partner_bank_id == 7) { ?>
                                <li>

                                    <a title="Manage Corporate BCs User" data-filter-tags="Manage Corporate BC" href="<?= $baseUrl ?>/partneragencies/user/bankfipcorporatebc">Corporate BCs User</a>
                                </li>
                            <?php } ?>  
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BANK_DISTRICT_UNIT]))) { ?>
                                <li>
                                    <a title="Manage User" data-filter-tags="Plan field operation" href="<?= $baseUrl ?>/partneragencies/planning">Plan Field Operation</a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BANK_DISTRICT_UNIT]))) { ?>
                                <li>
                                    <a title="Uploqd BC Transaction CSV" data-filter-tags="BC Transaction" href="<?= $baseUrl ?>/partneragencies/transaction/import">Upload Transaction CSV</a>
                                </li>
                            <?php } ?>    
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BANK_DISTRICT_UNIT]))) { ?>
                                <li>
                                    <a title="BC Transaction" data-filter-tags="BC Transaction" href="<?= $baseUrl ?>/transaction/report">BC Transaction</a>
                                </li>
                            <?php } ?> 

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_DC_NRLM]))) { ?>
                                <li>
                                    <a title="Field Associates" data-filter-tags="Field Associates" href="<?= $baseUrl ?>/partneragencies/associates/">Field Associates</a> 
                                </li>
                            <?php } ?>
                            <?php
                            if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS]))) {
                                // if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) {
                                ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/training/preselected/mobileinuse">Add Mobile No BC list</a>
                                </li>
                            <?php } ?> 
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN])) or (Yii::$app->user->identity->role == MasterRole::ROLE_BANK_DISTRICT_UNIT and (Yii::$app->user->identity->master_partner_bank_id == 6 or Yii::$app->user->identity->master_partner_bank_id == 7))) { ?>    
                                <li>
                                    <a title="Paytm BC Sakhi" href="<?= $baseUrl ?>/report/paytmbcsakhi">Paytm BC Sakhi</a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN])) or (Yii::$app->user->identity->role == MasterRole::ROLE_BANK_DISTRICT_UNIT and (Yii::$app->user->identity->master_partner_bank_id == 5))) { ?>    
                                <li>
                                    <a title="BC Feedback" href="<?= $baseUrl ?>/report/tracking/bc/feedbacks">BC Feedback</a>
                                </li>
                            <?php } ?>    
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>    
                                <li>
                                    <a title="BC Performance Feedback" href="<?= $baseUrl ?>/report/tracking/bc/feedback">BC Performance Feedback</a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_DC_NRLM]))) { ?>
                                <li> 
                                    <a href="<?= $baseUrl ?>/report/bc/ac194n" title="Dashboard: Tagging 194N " data-filter-tags="Dashboard: Tagging 194N">

                                        Dashboard: Tagging 194N

                                    </a>

                                </li>
                                <li>
                                    <a href="<?= $baseUrl ?>/report/bc/ac194nifsc" title="IFSC-wise pendency" data-filter-tags="IFSC-wise pendency">

                                        IFSC-wise pendency

                                    </a>
                                </li>
                            <?php } ?>    
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->id, [19851, 19852])) or (Yii::$app->user->identity->role == MasterRole::ROLE_BANK_DISTRICT_UNIT and Yii::$app->user->identity->master_partner_bank_id == 5)) { ?>    
                                <li class="dropdown-submenu dropdown-hover">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown">Report  <i class="fal fa-chevron-double-right"></i></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" title="Overall BC Performance" href="<?= $baseUrl ?>/report/tracking/bc/overallperformance">Overall BC Performance</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Monthly BC Performance" href="<?= $baseUrl ?>/report/tracking/bc/monthlyperformance">Monthly BC Performance</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Weekly BC Performance" href="<?= $baseUrl ?>/report/tracking/bc/weeklyperformance">Weekly BC Performance</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Daily BC Performance" href="<?= $baseUrl ?>/report/tracking/bc/dailyperformance">Daily BC Performance</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Report Transaction"  href="<?= $baseUrl ?>/report/tracking/bc/chart">Report 1</a> 
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Report 2"  href="<?= $baseUrl ?>/report/tracking/bc/reportchart">Report 2</a> 
                                        </li>

                                    </ul>
                                </li>

                            <?php } ?>  
                            <?php
                            if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->id, [19852, 14841, 19851, 16975, 325449, 325487, 325488]))) {
                                ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/report/sbi/mou">SBI MOU</a>
                                </li>

                            <?php } ?>      
                            <?php
                            if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT]))) {
                                ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/partneragencies/gp/in">GP Open</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/partneragencies/gp/out">GP Exit</a>
                                </li>
                            <?php } ?>     
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BC_VIEWER]))) { ?>

                                <li class="dropdown-submenu dropdown-hover">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown">Txn Report  <i class="fal fa-chevron-double-right"></i></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" title="Report 1" data-filter-tags="Report 1" href="<?= $baseUrl ?>/transaction/report/chart">Report 1</a> 
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Report 2" data-filter-tags="Report 2" href="<?= $baseUrl ?>/transaction/report/reportchart">Report 2</a> 
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Report 2(1)" data-filter-tags="Report 2(1)" href="<?= $baseUrl ?>/transaction/report/reportchart1">Report 2_1</a> 
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Report 2(2)" data-filter-tags="Report 2(2)" href="<?= $baseUrl ?>/transaction/report/reportchart2">Report 2_2</a> 
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Report 2(3)" data-filter-tags="Report 2(3)" href="<?= $baseUrl ?>/transaction/report/reportchart3">Report 2_3</a> 
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Report 2(4)" data-filter-tags="Report 2(4)" href="<?= $baseUrl ?>/transaction/report/reportchart4">Report 2_4</a> 
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Report 3" data-filter-tags="Field Associates" href="<?= $baseUrl ?>/transaction/report/monthlychart">Report 3</a> 
                                        </li>
                                        <li>
                                            <a class="dropdown-item" title="Report 4" data-filter-tags="Report 4" href="<?= $baseUrl ?>/transaction/report/chart4">Report 4</a> 
                                        </li>
                                    </ul>
                                </li>

                                <!--                                <li>
                                                                    <a title="Report 2" data-filter-tags="Field Associates" href="<?= $baseUrl ?>/transaction/report/bankchart">Report 4</a> 
                                                                </li>-->
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?> 

                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_MD, MasterRole::ROLE_MSC]))) { ?>
                    <li> 
                        <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/saree">
                            <i class="mdi mdi-view-list"></i> <span>Saree</span> 

                        </a>
                    </li> 
                <?php } ?>
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BC_VIEWER]))) { ?>
                    <li> 
                        <a  class="dropdown-item"   href="<?= $baseUrl ?>/training/saree">
                            <i class="mdi mdi-view-list"></i> <span>BC Uniform</span> 

                        </a>
                    </li> 
                <?php } ?>     
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_RSETIS_NODAL_BANK]))) { ?>
                    <li>
                        <a href="#" title="Reports" data-filter-tags="application intel">
                            <span class="nav-link-text" data-i18n="nav.application_intel">Reports</span>
                            <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                        </a>
                        <ul>
                             <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>    
                                <li>
                                    <a title="Performance BC Sakhi Program" href="<?= $baseUrl ?>/report/performance/bcsakhiprogram">Performance BC Sakhi Program</a>
                                </li>
                                <li>
                                    <a title="Top BC" href="<?= $baseUrl ?>/report/topbc">Top BC Sakhi </a>
                                </li>
                            <?php } ?> 
                            <li>
                                <a class="dropdown-item" href="<?= $baseUrl ?>/report/cumulative/pendencyd">Pendency Dashboard</a>
                            </li>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/report/dashboard">Dashboard</a>
                                </li>
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/report/rseti">Rseti Dashboard</a>
                                </li>
                            <?php } ?>


                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS]))) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $baseUrl ?>/report/partneragencies">Partner Bank/FI Dashboard</a>
                                </li>
                            <?php } ?>
                           <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BC_VIEWER]))) { ?>    
                                <li>
                                    <a title="BC Performance Feedback" href="<?= $baseUrl ?>/report/tracking/bc/feedback">BC Performance Feedback</a>
                                </li>
                            <?php } ?>     
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD]))) { ?>
                                <li>
                                    <a title="Download" data-filter-tags="Download" href="<?= $baseUrl ?>/report/download">Download</a>
                                </li>
                            <?php } ?>  
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?> 
                                <li class="dropdown-submenu dropdown-hover">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown">Performance Matrix <i class="fal fa-chevron-double-right"></i></a>
                                    <ul class="dropdown-menu">
                                        <li> 
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/performance/chart1" title="% Certified BC" data-filter-tags="% Certified BC">

                                               % Certified BC

                                            </a>

                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/performance/chart2" title="% of Operational BC" data-filter-tags="% of Operational BC">

                                                % of Operational BC

                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/performance/chart3" title="Ave. Working Day per Month" data-filter-tags="Ave. Working Day per Month">

                                                Ave. Working Day per Month

                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/performance/chart4" title="Ave. Txn. Per Month" data-filter-tags="Ave. Txn. Per Month">

                                                Ave. Txn. Per Month

                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/performance/chart5" title="Ave. Commission per Month" data-filter-tags="Performance 5">

                                               Ave. Commission per Month

                                            </a>
                                        </li>
                                       
                                       
                                    </ul>
                                </li>
                            <?php } ?>      

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                <li> 
                                    <a href="<?= $baseUrl ?>/report/bc/ac194n" title="Dashboard: Tagging 194N " data-filter-tags="Dashboard: Tagging 194N">

                                        Dashboard: Tagging 194N

                                    </a>

                                </li>
                                <li>
                                    <a href="<?= $baseUrl ?>/report/bc/ac194nifsc" title="IFSC-wise pendency" data-filter-tags="IFSC-wise pendency">

                                        IFSC-wise pendency

                                    </a>
                                </li>
                            <?php } ?> 
                                
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?> 
                                <li class="dropdown-submenu dropdown-hover">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown">Bank Performance  <i class="fal fa-chevron-double-right"></i></a>
                                    <ul class="dropdown-menu">
                                        <li> 
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/partneragencies/performance" title="Partner Agencies Performance " data-filter-tags="Partner Agencies Performance">

                                                Partner Agencies Performance

                                            </a>

                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/partneragencies/bob" title="Bank Of Baroda Performance" data-filter-tags="Bank Of Baroda Performance">

                                                Bank Of Baroda Performance

                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/partneragencies/fino" title="FINO Payment Bank Performance" data-filter-tags="FINO Payment Bank Performance">

                                                FINO Payment Bank Performance

                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/partneragencies/nearby" title="Nearby Technologies Pvt. Ltd. Performance" data-filter-tags="Nearby Technologies Pvt. Ltd. Performance">

                                                Nearby Technologies Pvt. Ltd. Performance

                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/partneragencies/manipal" title="Manipal Technologies Limited Performance" data-filter-tags="Manipal Technologies Limited Performance">

                                                Manipal Technologies Limited Performance

                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/partneragencies/airtel" title="MFSL-Airtel-GVI Consortia Performance" data-filter-tags="MFSL-Airtel-GVI Consortia Performance">

                                                MFSL-Airtel-GVI Consortia Performance

                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/partneragencies/ptm" title="Paytm Payment Bank Performance" data-filter-tags="Paytm Payment Bank Performance">

                                                Paytm Payment Bank Performance

                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= $baseUrl ?>/report/partneragencies/sbi" title="State Bank of India Performance" data-filter-tags="State Bank of India Performance">

                                                State Bank of India Performance

                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>    
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                <li>
                                    <a title="BC Transaction primary reports" data-filter-tags="Transaction performance report" href="<?= $baseUrl ?>/partneragencies/transaction/primaryreport">Transaction performance report</a>
                                </li>    
                            <?php } ?>
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT]))) { ?>
                                <!--                                <li>
                                                                    <a title="BC Transaction secondary reports" data-filter-tags="Transaction thematic report" href="<?= $baseUrl ?>/partneragencies/transaction/secondaryreport">Transaction thematic report</a>
                                                                </li>-->
                            <?php } ?>  
                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS]))) { ?>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                    <li>
                                        <a title="BC loan repaid" href="<?= $baseUrl ?>/report/bc/loanrepaid">Loan repaid</a>
                                    </li>
                                <?php } ?>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DC_NRLM]))) { ?>
                                    <li>
                                        <a title="BC SHG" href="<?= $baseUrl ?>/report/bc/shg">BC SHG</a>
                                    </li>
                                <?php } ?>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]))) { ?>
                                    <li>
                                        <a title="BC Transaction file upload report" href="<?= $baseUrl ?>/partneragencies/transaction/reportadmin">BC Transaction file upload report</a>
                                    </li>
                                <?php } ?>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN])) && (in_array(Yii::$app->user->identity->id, [19851, 19852, 72138]))) { ?>
                                    <li>
                                        <a title="BC Bank" href="<?= $baseUrl ?>/report/bc/bankinactive">BC Bank</a>
                                    </li>
                                <?php } ?>    
                                <li>
                                    <a title="Overall BC Performance" href="<?= $baseUrl ?>/transaction/bc/overallperformance">Overall BC Performance</a>
                                </li>
                                <li>
                                    <a title="Monthly BC Performance" href="<?= $baseUrl ?>/transaction/bc/monthlyperformance">Monthly BC Performance</a>
                                </li>
                                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BC_VIEWER]))) { ?>
                                    <li>
                                        <a title="Weekly BC Performance" href="<?= $baseUrl ?>/transaction/bc/weeklyperformance">Weekly BC Performance</a>
                                    </li>
                                    <li>
                                        <a title="Daily BC Performance" href="<?= $baseUrl ?>/transaction/bc/dailyperformance">Daily BC Performance</a>
                                    </li>
                                    <!--                                    <li>
                                                                            <a title="Monthly Transaction" href="<?= $baseUrl ?>/partneragencies/transaction/monthly"> 
                                    
                                                                                <span class="nav-link-text">Monthly Transaction</span> 
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a title="Weekly Transaction" href="<?= $baseUrl ?>/partneragencies/transaction/weekly"> 
                                    
                                                                                <span class="nav-link-text">Weekly Transaction</span> 
                                                                            </a>
                                                                        </li>-->
                                <?php } ?>
                            <?php } ?>  

                            <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS]))) { ?>
                                <li>
                                    <a title="प्रशिक्षण व संवेदिकरण" data-filter-tags="प्रशिक्षण व संवेदिकरण" href="<?= $baseUrl ?>/report/bcfeedback">प्रशिक्षण व संवेदिकरण</a>
                                </li>
                            <?php } ?> 

                        </ul>
                    </li>
                <?php } ?> 
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER]))) { ?>
                    <!--                    <li class="blue">  
                                            <a  class="dropdown-item"   href="<?= $baseUrl ?>/md/validation">
                                                <i class="mdi mdi-view-list"></i> <span>Validation of Deliverables</span> 
                    
                                            </a>
                                        </li> -->
                <?php } ?> 

                <!--
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                                                                                                                                                                                                <li>
                                                                                                                                                                                                                <a href="#" title="Corona" data-filter-tags="application intel">

                                                                                                                                                                                                                <span class="nav-link-text" data-i18n="nav.application_intel">Corona</span>
                                                                                                                                                                                                                <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                <ul>
                    <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) { ?>
                                                                                                                                                                                                                    <li>
                                                                                                                                                                                                                    <a class="dropdown-item" href="/corona"> Report</a>
                                                                                                                                                                                                                    </li>
                                                                                                                                                                                                                    <li>
                                                                                                                                                                                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/corona/report"> Dashboard</a>
                                                                                                                                                                                                                    </li>
                                                                                                                                                                                                                    <li>
                                                                                                                                                                                                                    <a class="dropdown-item" href="<?= $baseUrl ?>/corona/report/graph"> Graph</a>
                                                                                                                                                                                                                    </li> 
                    <?php } ?>
                                                                                                                                                                                                                </ul>
                                                                                                                                                                                                                </li>
                <?php } ?> 
                -->
                <?php if (!Yii::$app->user->isGuest && (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK]))) { ?>
                    <!--                    <li >   <a class="dropdown-item" href="<?= $baseUrl ?>/training/usermanual">Guideline</a></li>   -->
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
<script>
    $(document).ready(function () {
        if ($(window).width() < 992) {
            $('.nav-item.dropdown').on('click', function (event) {
                event.stopPropagation();
                $(this).find('.dropdown-menu').toggleClass('show');
            });
        } else {
            $('.dropdown-submenu').on('mouseover', function () {
                $(this).find('.dropdown-menu').addClass('show');
            });

            $('.dropdown-submenu').on('mouseout', function () {
                $(this).find('.dropdown-menu').removeClass('show');
            });

            $('.dropdown-item').on('click', function (e) {
                // Only prevent navigation if this item has a submenu
                if ($(this).siblings('.dropdown-menu').length > 0) {
                    e.stopPropagation();
                    $(this).siblings('.dropdown-menu').toggleClass('show');
                }
                // Otherwise let the link navigate normally
            });
        }
    });


</script>
<style>
    @media (min-width: 992px) {
        .navbar .nav-item.dropdown:hover>.dropdown-menu {
            display: block;
        }
        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: 20px;
        }
    }

    /* Ensure submenu opens at bottom */
    .dropdown-submenu {
        position: static;
    }



    .bg-custom-nav {
        background-color: #1a3f59 !important;
    }

    .navbar-dark .navbar-nav .nav-link {
        padding: 20px 15px;
        color: #ffffff;
        font-weight: 500;
        text-transform: uppercase;
        outline: none;
    }

    .navbar-dark .navbar-nav .nav-link:hover,
    .navbar-dark .navbar-nav .nav-link.active {
        color: #1e2024;
        background: #ffcc00;
    }

    .bg-custom-nav {
        background-color: #1a3f59 !important;
    }
    .navbar-dark .navbar-nav .nav-link {
        padding: 20px 15px;
        color: #ffffff;
        font-weight: 500;
        text-transform: uppercase;
        outline: none;
    }
    .navbar-dark .navbar-nav .nav-link:hover, .navbar-dark .navbar-nav .nav-link.active {
        color: #1e2024;
        background: #ffcc00;
    }
</style>