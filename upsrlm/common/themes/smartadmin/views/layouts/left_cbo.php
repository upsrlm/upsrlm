<?php

use common\models\master\MasterRole;
$baseUrl = '/cbo';  // CBO module base path
?>
<aside class="page-sidebar">
    <div class="page-logo">
        <a href="/cbo" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
            <img src="<?= $bundle->baseUrl ?>/img/logo.png" style="width: 70px" alt="CBO" aria-roledescription="logo">
            <span class="page-logo-text mr-1"></span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
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
                <!-- Dashboard -->
                <li>
                    <a href="<?= $baseUrl ?>/dashboard" title="Dashboard" data-filter-tags="dashboard">
                        <i class="fal fa-chart-pie"></i>
                        <span class="nav-link-text" data-i18n="nav.dashboard">Dashboard</span>
                    </a>
                </li>

                <!-- SHG -->
                <li>
                    <a href="<?= $baseUrl ?>/shg" title="SHG Management" data-filter-tags="shg">
                        <i class="fal fa-users"></i>
                        <span class="nav-link-text" data-i18n="nav.shg">SHG</span>
                        <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                    </a>
                    <ul>
                        <li>
                            <a href="<?= $baseUrl ?>/shg/default" title="SHG List" data-filter-tags="shg list">
                                <span class="nav-link-text" data-i18n="nav.shg_list">List</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- VO -->
                <li>
                    <a href="<?= $baseUrl ?>/vo" title="Village Organization" data-filter-tags="vo">
                        <i class="fal fa-sitemap"></i>
                        <span class="nav-link-text" data-i18n="nav.vo">VO</span>
                        <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                    </a>
                    <ul>
                        <li>
                            <a href="<?= $baseUrl ?>/vo/default" title="VO List" data-filter-tags="vo list">
                                <span class="nav-link-text" data-i18n="nav.vo_list">List</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- CLF -->
                <li>
                    <a href="<?= $baseUrl ?>/clf" title="Community Livelihood Fund" data-filter-tags="clf">
                        <i class="fal fa-city"></i>
                        <span class="nav-link-text" data-i18n="nav.clf">CLF</span>
                        <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                    </a>
                    <ul>
                        <li>
                            <a href="<?= $baseUrl ?>/clf/dashboard" title="CLF Dashboard" data-filter-tags="clf dashboard">
                                <span class="nav-link-text" data-i18n="nav.clf_dashboard">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $baseUrl ?>/clf/default" title="CLF List" data-filter-tags="clf list">
                                <span class="nav-link-text" data-i18n="nav.clf_list">List</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- BC -->
                <li>
                    <a href="<?= $baseUrl ?>/bc" title="BC Management" data-filter-tags="bc">
                        <i class="fal fa-briefcase"></i>
                        <span class="nav-link-text" data-i18n="nav.bc">BC</span>
                        <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                    </a>
                    <ul>
                        <li>
                            <a href="<?= $baseUrl ?>/bc/noshg" title="BC No SHG" data-filter-tags="bc noshg">
                                <span class="nav-link-text" data-i18n="nav.bc_noshg">BC No SHG</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $baseUrl ?>/bc/certified" title="BC Certified" data-filter-tags="bc certified">
                                <span class="nav-link-text" data-i18n="nav.bc_certified">BC Certified</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- WADA -->
                <li>
                    <a href="<?= $baseUrl ?>/wada" title="WADA Management" data-filter-tags="wada">
                        <i class="fal fa-stream"></i>
                        <span class="nav-link-text" data-i18n="nav.wada">WADA</span>
                        <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                    </a>
                    <ul>
                        <li>
                            <a href="<?= $baseUrl ?>/wada/samuhsakhi" title="WADA Samuh Sakhi" data-filter-tags="wada samuh">
                                <span class="nav-link-text" data-i18n="nav.wada_samuh">Samuh Sakhi</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Report -->
                <li>
                    <a href="#" title="Report" data-filter-tags="report">
                        <i class="fal fa-file-csv"></i>
                        <span class="nav-link-text" data-i18n="nav.report">Report</span>
                        <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                    </a>
                    <ul>
                        <li>
                            <a href="<?= $baseUrl ?>/shg/report/registration" title="CBO Registration" data-filter-tags="report registration">
                                <span class="nav-link-text" data-i18n="nav.report_registration">CBO Registration</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $baseUrl ?>/shg/report/daily" title="Daily Activity" data-filter-tags="report daily">
                                <span class="nav-link-text" data-i18n="nav.report_daily">Daily Activity</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Select Portal -->
                <li>
                    <a href="#" title="Select Portal" data-filter-tags="select portal">
                        <i class="fal fa-layer-group"></i>
                        <span class="nav-link-text" data-i18n="nav.select_portal">Select Portal</span>
                        <b class="collapse-sign"><em class="fal fa-angle-down"></em></b>
                    </a>
                    <ul>
                        <li>
                            <a href="<?= Yii::$app->params['app_url']['bc'] ?>" title="B.C Sakhi Portal" data-filter-tags="portal bc">
                                <span class="nav-link-text" data-i18n="nav.portal_bc">B.C Sakhi Portal</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Yii::$app->params['app_url']['cbo'] ?>" title="C.B.O Portal" data-filter-tags="portal cbo">
                                <span class="nav-link-text" data-i18n="nav.portal_cbo">C.B.O Portal</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Yii::$app->params['app_url']['wada'] ?>" title="Wada Sakhi Portal" data-filter-tags="portal wada">
                                <span class="nav-link-text" data-i18n="nav.portal_wada">Wada Sakhi Portal</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Yii::$app->params['app_url']['ultrapoor'] ?>" title="Ultra-Poor Portal" data-filter-tags="portal ultrapoor">
                                <span class="nav-link-text" data-i18n="nav.portal_ultrapoor">Ultra-Poor Portal</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Welcome/Profile -->
                <li>
                    <a href="#" title="You" data-filter-tags="profile welcome">
                        <i class="fal fa-user"></i>
                        <span class="nav-link-text" data-i18n="nav.welcome">Welcome, <?= !Yii::$app->user->isGuest ? Yii::$app->user->identity->name : 'User' ?></span>
                    </a>
                </li>

            </ul>
        </nav>
    <?php } ?>
</aside>
