<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

        <!----header one starts here--->
        <div class="header_primary">
            <div class="container-fluid">
                <div class="row no-gutters">
                    <div class="col-md-1">
                        <div class="header_primary_logo">
                            <a href="/"><img src="<?=$bundle->baseUrl?>/images/logo_up.png" class="img-fluid" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="logo_heading">
                            <h2>ग्राम विकास विभाग, उत्तर प्रदेश शासन</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="right_nav">
                            <div class="header_primary_logo-1">
                                <h2 class="bc_sakhi">B.C Sakhi</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-header header-shadow bg-ripe-malin header-text-light">
            <div class="container-fluid fiori-container">
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>

                <ul class="horizontal-nav-menu">
                    <li class="dropdown">
                        <a data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false" class="active">
                            <i class="nav-icon-big typcn typcn-directions"></i>
                            <span>Dashboards</span>
                            <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                        </a>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-lg">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-plum-plate">
                                    <div class="menu-header-image" style="background-image: url('assets/images/dropdown-header/abstract4.jpg');"></div>
                                    <div class="menu-header-content text-left">
                                        <h5 class="menu-header-title">Dashboards</h5>
                                        <h6 class="menu-header-subtitle">This is a dropdown header example!</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="scroll-area-xs">
                                <div class="scrollbar-container">
                                    <a class="dropdown-item" href="analytics-dashboard.html">Analytics</a>
                                    <a class="dropdown-item" href="management-dashboard.html">Management</a>
                                    <a class="dropdown-item" href="advertisement-dashboard.html">Advertisement</a>
                                    <a class="dropdown-item" href="index.html">Helpdesk</a>
                                    <a class="dropdown-item" href="monitoring-dashboard.html">Monitoring</a>
                                    <a class="dropdown-item" href="crypto-dashboard.html">Cryptocurrency</a>
                                    <a class="dropdown-item active" href="pm-dashboard.html">Project Management</a>
                                    <a class="dropdown-item" href="product-dashboard.html">Product</a>
                                    <a class="dropdown-item" href="statistics-dashboard.html">Statistics</a>
                                </div>
                            </div>
                            <ul class="nav flex-column">
                                <li class="nav-item-divider nav-item"></li>
                                <li class="nav-item-btn nav-item d-block text-center">
                                    <a href="#" class="btn-wide btn-shadow btn btn-success btn-sm">Purchase</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false">
                            <i class="nav-icon-big typcn typcn-document"></i>
                            <span>Layouts</span>
                            <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                        </a>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-rounded">
                            <div class="dropdown-mega-menu p-0">
                                <div class="grid-menu grid-menu-2col">
                                    <div class="no-gutters row">
                                        <div class="col-sm-8 pl-lg-0 pb-lg-0 pt-lg-0">
                                            <div class="nav flex-column">
                                                <a href="apps-mailbox.html" class="dropdown-item-desc dropdown-item">
                                                    <span>Mailbox</span>
                                                    <p>Sed consequat, leo eget bibendum sodales, augue velit cursus nunc.</p>
                                                </a>
                                                <div class="divider mt-2 mb-2"></div>
                                                <a href="apps-chat.html" class="dropdown-item-desc dropdown-item">
                                                    <span>Chat</span>
                                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                                                </a>
                                                <div class="divider mt-2 mb-2"></div>
                                                <a href="apps-faq-section.html" class="dropdown-item-desc dropdown-item">
                                                    <span>FAQ Section</span>
                                                    <p>Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat.</p>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="nav flex-column">
                                                <div class="nav-item-header text-primary nav-item">
                                                    User Pages
                                                </div>
                                                <a class="dropdown-item" href="pages-login.html" target="_blank">
                                                    Login
                                                </a>
                                                <a class="dropdown-item" href="pages-login-2.html" target="_blank">
                                                    Login 2
                                                </a>
                                                <a class="dropdown-item" href="pages-login-3.html" target="_blank">
                                                    Login 3
                                                </a>
                                                <a class="dropdown-item" href="pages-register-boxed.html">
                                                    Register Boxed
                                                </a>
                                                <a class="dropdown-item" href="pages-forgot-password.html">
                                                    Forgot Password
                                                </a>
                                                <a class="dropdown-item" href="pages-forgot-password-boxed.html">
                                                    Forgot Password Boxed
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false">
                            <i class="nav-icon-big typcn typcn-lightbulb"></i>
                            <span>Components</span>
                            <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                        </a>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-rounded p-0">
                            <div class="dropdown-mega-menu dropdown-mega-menu-sm p-0">
                                <div class="grid-menu grid-menu-3col">
                                    <div class="nav flex-column">
                                        <div class="row no-gutters">
                                            <div class="col-sm-4">
                                                <a href="components-tabs.html" class="dropdown-item">
                                                    Tabs
                                                </a>
                                                <a href="components-accordions.html" class="dropdown-item">
                                                    Accordions
                                                </a>
                                                <a href="components-notifications.html" class="dropdown-item">
                                                    Notifications
                                                </a>
                                                <a href="components-modals.html" class="dropdown-item">
                                                    Modals
                                                </a>
                                                <a href="components-loading-blocks.html" class="dropdown-item">
                                                    Loading Blockers
                                                </a>
                                                <a href="components-progress-bar.html" class="dropdown-item">
                                                    Progress Bar
                                                </a>
                                                <a href="components-tooltips-popovers.html" class="dropdown-item">
                                                    Tooltips &amp; Popovers
                                                </a>
                                                <a href="components-carousel.html" class="dropdown-item">
                                                    Carousel
                                                </a>
                                                <a href="components-calendar.html" class="dropdown-item">
                                                    Calendar
                                                </a>
                                            </div>
                                            <div class="col-sm-4">
                                                <a href="components-pagination.html" class="dropdown-item">
                                                    Pagination
                                                </a>
                                                <a href="components-count-up.html" class="dropdown-item">
                                                    Count Up
                                                </a>
                                                <a href="components-scrollable-elements.html" class="dropdown-item">
                                                    Scrollable
                                                </a>
                                                <a href="components-tree-view.html" class="dropdown-item">
                                                    Tree View
                                                </a>
                                                <a href="components-maps.html" class="dropdown-item">
                                                    Maps
                                                </a>
                                                <a href="components-ratings.html" class="dropdown-item">
                                                    Ratings
                                                </a>
                                                <a href="components-image-crop.html" class="dropdown-item">
                                                    Image Crop
                                                </a>
                                                <a href="components-guided-tours.html" class="dropdown-item">
                                                    Guided Tours
                                                </a>
                                                <a href="elements-utilities.html" class="dropdown-item">
                                                    Utilities
                                                </a>
                                            </div>
                                            <div class="col-sm-4">
                                                <a href="elements-buttons-standard.html" class="dropdown-item ">
                                                    Buttons
                                                </a>
                                                <a href="elements-dropdowns.html" class="dropdown-item">
                                                    Dropdowns
                                                </a>
                                                <a href="elements-icons.html" class="dropdown-item">
                                                    Icons
                                                </a>
                                                <a href="elements-badges-labels.html" class="dropdown-item">
                                                    Badges
                                                </a>
                                                <a href="elements-cards.html" class="dropdown-item">
                                                    Cards
                                                </a>
                                                <a href="elements-loaders.html" class="dropdown-item">
                                                    Loading Indicators
                                                </a>
                                                <a href="elements-list-group.html" class="dropdown-item">
                                                    List Groups
                                                </a>
                                                <a href="elements-navigation.html" class="dropdown-item">
                                                    Navigation Menus
                                                </a>
                                                <a href="elements-timelines.html" class="dropdown-item">
                                                    Timeline
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false">
                            <i class="nav-icon-big typcn typcn-tags"></i>
                            <span>Widgets</span>
                            <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                        </a>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                            <div class="dropdown-mega-menu dropdown-mega-menu-sm p-0">
                                <div class="grid-menu grid-menu-3col">
                                    <div class="nav flex-column">
                                        <div class="row no-gutters">
                                            <div class="col-sm-4">
                                                <div class="nav flex-column">
                                                    <div class="nav-item-header text-primary nav-item">
                                                        Boxes
                                                    </div>
                                                    <a href="widgets-chart-boxes.html" class="dropdown-item">
                                                        Chart Boxes 1
                                                    </a>
                                                    <a href="widgets-chart-boxes-2.html" class="dropdown-item">
                                                        Chart Boxes 2
                                                    </a>
                                                    <a href="widgets-chart-boxes-3.html" class="dropdown-item">
                                                        Chart Boxes 3
                                                    </a>
                                                    <a href="widgets-profile-boxes.html" class="dropdown-item">
                                                        Profile Boxes
                                                    </a>
                                                    <div class="divider"></div>
                                                    <div class="nav-item-header text-primary nav-item">
                                                        Tables
                                                    </div>
                                                    <a href="tables-data-tables.html" class="dropdown-item">
                                                        Data Tables
                                                    </a>
                                                    <a href="tables-regular.html" class="dropdown-item">
                                                        Regular Tables
                                                    </a>
                                                    <a href="tables-grid.html" class="dropdown-item">
                                                        Grid Tables
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="nav flex-column">
                                                    <div class="nav-item-header text-primary nav-item">
                                                        Forms
                                                    </div>
                                                    <a href="forms-controls.html" class="dropdown-item">
                                                        Controls
                                                    </a>
                                                    <a href="forms-layouts.html" class="dropdown-item">
                                                        Layouts
                                                    </a>
                                                    <a href="forms-validation.html" class="dropdown-item">
                                                        Validation
                                                    </a>
                                                    <a href="forms-wizard.html" class="dropdown-item">
                                                        Wizard
                                                    </a>
                                                    <div class="divider"></div>
                                                    <a href="forms-datepicker.html" class="dropdown-item">
                                                        Datepicker
                                                    </a>
                                                    <a href="forms-range-slider.html" class="dropdown-item">
                                                        Range Slider
                                                    </a>
                                                    <a href="forms-toggle-switch.html" class="dropdown-item">
                                                        Toggle Switch
                                                    </a>
                                                    <a href="forms-wysiwyg-editor.html" class="dropdown-item">
                                                        WYSIWYG Editor
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="nav flex-column">
                                                    <div class="nav-item-header text-primary nav-item">
                                                        Charts
                                                    </div>
                                                    <a href="charts-chartjs.html" class="dropdown-item">
                                                        ChartJS
                                                    </a>
                                                    <a href="charts-apexcharts.html" class="dropdown-item">
                                                        Apex Charts
                                                    </a>
                                                    <a href="charts-sparklines.html" class="dropdown-item">
                                                        Chart Sparklines
                                                    </a>
                                                    <div class="divider"></div>
                                                    <a href="forms-input-mask.html" class="dropdown-item">
                                                        Input Mask
                                                    </a>
                                                    <a href="forms-clipboard.html" class="dropdown-item">
                                                        Clipboard
                                                    </a>
                                                    <a href="forms-textarea-autosize.html" class="dropdown-item">
                                                        Textarea Autosize
                                                    </a>
                                                    <a href="forms-input-selects.html" class="dropdown-item">
                                                        Input Selects
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
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
                                            <a class="dropdown-item" href="HR-Portal.html" target="_blank">HR Portal</a>
                                            <a class="dropdown-item" href="C.B.O-Portal.html" target="_blank">C.B.O Portal</a>
                                            <a class="dropdown-item" href="B.C-Sakhi.html" target="_blank">B.C Sakhi Portal</a>
                                            <a class="dropdown-item" href="Admin.html" target="_blank">Admin Portal</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-btn-lg">
                    </div>
                    <div class="user_logout">
                        <div class="dropdown">

                            <button type="button" class="btn custom_drop_btn-2 dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-lock logout_icon-2"></i>
                                Logout

                            </button>
                            <div class="dropdown-menu logout_area">
                                <a class="dropdown-item" href="" target="_blank"> <img src="assets/images/avatars/12.jpg" class="img-fluid" alt="user_logout"></a>
                                <a class="dropdown-item" href="Dashboard-3.html" target="_blank">Activity</a>
                                <a class="dropdown-item" href="Dashboard-2.html" target="_blank">Forgot Password</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
            </div>
        </div>