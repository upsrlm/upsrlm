<?php

use common\models\master\MasterRole;
?>
<div class="header_primary">
    <div class="container-flude">
        <div class="row">
            <div class="col-sm-2 col-12">
                <div class="header_primary_logo">
                    <a href="/"><img src="<?= $bundle->baseUrl ?>/images/logo.png" class="img-fluid" alt=""> </a>
                </div>
            </div>
            <div class="col-sm-8 col-12">
                <div class="header_primary_logo_text">
                    <h4>UTTAR PRADESH STATE RURAL LIVELIHOOD MISSION</h4>
                    <h6>Department of Rural Development</h6>
                    <p>Government Of Uttar Pradesh</p>
                </div>
            </div>


            <div class="col-sm-2 col-12">
                <div class="right_nav">
                    <a href="/"> <img src="<?= $bundle->baseUrl ?>/images/logo_up.png" class="img-fluid" alt=""></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="app-container custom-cont app-theme-white">
                  
                    <div class="app-header header-shadow bg-plum-plate header-text-light">

                        <div class="app-header__mobile-menu">
                            <div>
                                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav" id="mobile-toggle">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                       
                        <div class="mobiele-ne">
                            <ul class="horizontal-nav-menu">
                                <li>
                                    <a href="/" class="">

                                        <span>Home</span>

                                    </a>

                                </li>
                                <li>
                                    <a href="/page/timeline" class="">

                                        <span>Timeline</span>

                                    </a>

                                </li>

                                <li>
                                    <a href="/page/methodology" class="">

                                        <span>Theory of Change</span>

                                    </a>

                                </li>
                                <li>
                                    <a href="/page/technology" class="">

                                        <span>Technology</span>

                                    </a>

                                </li>
                                <li>
                                    <a href="/page/go" class="">

                                        <span>Government Orders</span>

                                    </a>

                                </li>
                                <li>
                                    <a href="/page/contact" class="">

                                        <span>Contact Us</span>

                                    </a>

                                </li>
                                <?php if (!Yii::$app->user->isGuest) { ?>
                                <li>
                                    <a href="/page/heatmap" class="">

                                        <span>Heatmap</span>

                                    </a>

                                </li>
                                <li>
                                    <a href="/site/logout" class="">

                                        <span>Logout</span>

                                    </a>

                                </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="app-header-right">

                        </div>
                        <div class="app-header__menu">
                            <span>
                                <button type="button"
                                        class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                    <span class="btn-icon-wrapper">
                                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                                    </span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<!-- <section class="home_banner"></section>-->