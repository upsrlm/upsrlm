<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\assets\FioriAsset;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;
use common\models\master\MasterRole;

/* @var $this \yii\web\View */
/* @var $content string */

$bundel = FioriAsset::register($this);
$bundelbc = bc\assets\FioriAsset::register($this);
$arg = explode('/', Yii::$app->request->url);
$url = explode('/', Yii::$app->request->url);
//print_r($url);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Disable tap highlight on IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>

    <body>
        <?php $this->beginBody() ?>  
        <div class="app-container app-theme-white app-fluid-container">
            <div class="app-top-bar bg-plum-plate top-bar-text-light">
                <div class="container fiori-container">
                    <div class="top-bar-left">

                    </div>
                    <div class="top-bar-right">

                    </div>
                </div>
            </div>
            <div class="app-header header-shadow bg-warning header-text-dark">
                <div class="container fiori-container">
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                                        <div class="app-header__logo">
                                            <a href="https://fiori.architectui.com" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Fiori Admin Template" class="logo-src"></a>
                                        </div>        
                    <ul class="horizontal-nav-menu">
                        <li class="dropdown">
                            <a  data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false" class="active">
                                <i class="nav-icon-big typcn typcn-directions"></i>
                                <span>SRLM - BC Application</span>
                                <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-lg">
                                <!--                                <div class="dropdown-menu-header">
                                                                    <div class="dropdown-menu-header-inner bg-plum-plate">
                                                                        <div class="menu-header-image" style="background-image: url('../assets/images/dropdown-header/abstract4.jpg');"></div>
                                                                        <div class="menu-header-content text-left">
                                                                            <h5 class="menu-header-title">Dashboards</h5>
                                                                            <h6 class="menu-header-subtitle">This is a dropdown header example!</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                <div class="scroll-area-xs">
                                    <div class="scrollbar-container">
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/dashboard"><i class="fa fa-dashboard"></i> Application - Dashboard</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/registereduser"><i class="fa fa-users"></i> Applicant List</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/district"><i class="fa fa-globe"></i> District Wise Status</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/block"><i class="fa fa-globe"></i> Block Wise Status</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/grampanchayat"><i class="fa fa-globe"></i> GP Wise Status</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/registration"><i class="fa fa-globe"></i> GP with No Registration</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/districtgp"><i class="fa fa-globe"></i> GP with No Registration summary</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/downloadcsvgp"><i class="fa fa-download"></i> GP wise application reportt</a>

                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="dropdown">
                            <a  data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false">
                                <i class="nav-icon-big typcn typcn-document"></i>
                                <span>SRLM - BC Selection</span>
                                <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-rounded">
                                <div class="scroll-area-xs">
                                    <div class="scrollbar-container">
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/dashboard/report"><i class="fa fa-dashboard"></i> Report</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/data/application/list"><i class="fa fa-dashboard"></i> BC Sakhi List</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/data/application/singleapplication"><i class="fa fa-dashboard"></i> Single application</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/data/application/highestscore"><i class="fa fa-dashboard"></i> Person Highest score</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/dashboard/graph"><i class="fa fa-chart-bar"></i> Graphs</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/data/application/report"><i class="fa fa-dashboard"></i> Select</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/dashboard/report/selected"><i class="fa fa-users"></i> GP where Selection Completed</a>


                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a  data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false">
                                <i class="nav-icon-big typcn typcn-lightbulb"></i>
                                <span>SRLM - BC Verification</span>
                                <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-rounded p-0">
                                <div class="scroll-area-xs">
                                    <div class="scrollbar-container">
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/application/bcdata">Download List for Verification</a>
                                        <a class="dropdown-item" href="<?= $baseUrl ?>/selection/dashboard/graph/selection">Graph</a>


                                    </div>
                                </div>  
                            </div>
                        </li>

                    </ul>        
                    <div class="app-header-right">


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
            <div class="app-main">
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="app-inner-layout app-inner-layout-page">
                            <!--                            <div class="app-inner-bar">
                                                            <div class="container fiori-container">
                                                                <div class="inner-bar-left">
                                                                    <ul class="nav">
                                                                        <li class="nav-item">
                                                                            <a href="#" class="nav-link show-menu-btn">
                                                                                <i class="fa fa-align-left mr-2"></i>
                                                                                <span class="hide-text-md">Show page menu</span>
                                                                            </a>
                                                                            <a href="#" class="nav-link close-menu-btn">
                                                                                <i class="fa fa-align-right mr-2"></i>
                                                                                <span class="hide-text-md">Close page menu</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>                            
                                                                <div class="inner-bar-center">
                                                                    <ul class="nav">
                                                                        <li class="nav-item">
                                                                            <a role="tab" data-toggle="tab" class="nav-link active" href="#tab-content-0">
                                                                                <span>Overview</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a role="tab" data-toggle="tab" class="nav-link" href="#tab-content-1">
                                                                                <span>Audiences</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a role="tab" data-toggle="tab" class="nav-link" href="#tab-content-2">
                                                                                <span>Demographics</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item dropdown">
                                                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link opacity-8">
                                                                                <span>More</span>
                                                                                <i class="fa fa-angle-down ml-1 opacity-6"></i>
                                                                            </a>
                                                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-right rm-pointers dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
                                                                                <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                                                <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-inbox"> </i><span>Menus</span></button>
                                                                                <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-file-empty"> </i><span>Settings</span></button>
                                                                                <button type="button" tabindex="0" class="dropdown-item"><i class="dropdown-icon lnr-book"> </i><span>Actions</span></button>
                                                                                <div tabindex="-1" class="dropdown-divider"></div>
                                                                                <div class="p-3 text-right">
                                                                                    <button class="mr-2 btn-shadow btn-sm btn btn-link">View Details</button>
                                                                                    <button class="mr-2 btn-shadow btn-sm btn btn-primary">Action</button>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="inner-bar-right">
                                                                    <ul class="nav">
                                                                        <li class="nav-item">
                                                                            <a href="javascript:void(0);" class="nav-link open-right-drawer">
                                                                                <span class="hide-text-md">Show right drawer</span>
                                                                                <i class="fa fa-align-right ml-2"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>                        
                                                            </div>
                                                        </div>-->
                            <div class="app-inner-layout__wrapper">
                                <!-- --->
                                <!--                                <div class="app-inner-layout__sidebar">
                                                                    <div class="app-layout__sidebar-inner dropdown-menu-rounded">
                                                                        <div class="nav flex-column">
                                                                            <div class="nav-item-header text-primary nav-item">
                                                                                Dashboards Examples
                                                                            </div>
                                                                            <a class="dropdown-item" href="analytics-dashboard.html">Analytics</a>
                                                                            <a class="dropdown-item" href="management-dashboard.html">Management</a>
                                                                            <a class="dropdown-item" href="advertisement-dashboard.html">Advertisement</a>
                                                                            <a class="dropdown-item" href="helpdesk-dashboard.html">Helpdesk</a>
                                                                            <a class="dropdown-item active" href="monitoring-dashboard.html">Monitoring</a>
                                                                            <a class="dropdown-item" href="crypto-dashboard.html">Cryptocurrency</a>
                                                                            <a class="dropdown-item" href="pm-dashboard.html">Project Management</a>
                                                                            <a class="dropdown-item" href="product-dashboard.html">Product</a>
                                                                            <a class="dropdown-item" href="statistics-dashboard.html">Statistics</a>
                                                                        </div>                            
                                                                    </div>
                                                                </div>-->
                                <div class="app-inner-layout__content">

                                    <div class="tab-content">
                                        <div class="container fiori-container">
                                            <div class="app-page-title app-page-title-simple">
                                                <div class="page-title-wrapper">
                                                    <div class="page-title-heading">
                                                        <!-- page heading sub heading and breadcrumb action---> 
                                                        <div>
                                                            <div class="page-title-head center-elem">
                                                                <span class="d-inline-block pr-2">
                                                                    <i class=""></i>
                                                                </span>
                                                                <span class="d-inline-block"></span>
                                                            </div>
                                                            <!--                                                            <div class="page-title-subheading opacity-10">
                                                                                                                            <nav class="" aria-label="breadcrumb">
                                                                                                                                <ol class="breadcrumb">
                                                                                                                                    <li class="breadcrumb-item">
                                                                                                                                        <a href="javascript:void(0);">
                                                                                                                                            <i aria-hidden="true" class="fa fa-home"></i>
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    <li class="breadcrumb-item">
                                                                                                                                        <a href="javascript:void(0);">Dashboards</a>
                                                                                                                                    </li>
                                                                                                                                    <li class="active breadcrumb-item" aria-current="page">
                                                                                                                                        Minimal Dashboard Example
                                                                                                                                    </li>
                                                                                                                                </ol>
                                                                                                                            </nav>
                                                                                                                        </div>-->
                                                        </div>
                                                    </div>
                                                    <div class="page-title-actions">
                                                        <!-- page action---> 
                                                        <!--                                                        <div class="d-inline-block pr-3">
                                                                                                                    <select id="custom-inp-top" type="select" class="custom-select">
                                                                                                                        <option>Select period...</option>
                                                                                                                        <option>Last Week</option>
                                                                                                                        <option>Last Month</option>
                                                                                                                        <option>Last Year</option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                                <button type="button" data-toggle="tooltip" data-placement="left" class="btn btn-dark" title="Show a Toastr Notification!">
                                                                                                                    <i class="fa fa-battery-three-quarters"></i>
                                                                                                                </button>-->
                                                    </div>
                                                </div>
                                            </div> 
                                            <?= $content ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="container fiori-container">
                                <div class="app-footer__inner">
                                    <div class="app-footer-left">

                                    </div>
                                    <div class="app-footer-right">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
            <!--THEME OPTIONS START-->
            <div class="ui-theme-settings">
        <button type="button" id="TooltipDemo" class="btn-open-options btn btn-outline-2x btn-outline-focus">
            <i class="fa fa-sync-alt icon-anim-pulse fa-2x"></i>
        </button>
        <div class="theme-settings__inner">
            <div class="scrollbar-container">
                <div class="theme-settings__options-wrapper">
                    <h3 class="themeoptions-heading">Layout Options
                    </h3>
                    <div class="p-3">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="switch has-switch switch-container-class" data-class="fixed-footer">
                                                <div class="switch-animate switch-off">
                                                    <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Fixed Footer
                                            </div>
                                            <div class="widget-subheading">Makes the app footer bottom fixed, always visible!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="switch has-switch switch-container-class" data-class="app-fluid-container">
                                                <div class="switch-animate switch-off">
                                                    <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Fluid Containers
                                            </div>
                                            <div class="widget-subheading">Makes the app layout full width instead on container boxed!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="switch has-switch switch-container-class" data-class="body-subnav-pills">
                                                <div class="switch-animate switch-off">
                                                    <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Pills Page Navigation Style
                                            </div>
                                            <div class="widget-subheading">Changes the page sub navigation style to pills!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <h3 class="themeoptions-heading">
                        <div>
                            Header Options
                        </div>
                        <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class" data-class="">
                            Restore Default
                        </button>
                    </h3>
                    <div class="p-3">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <h5 class="pb-2">Choose Color Scheme
                                </h5>
                                <div class="theme-settings-swatches">
                                    <div class="swatch-holder bg-primary switch-header-cs-class" data-class="bg-primary header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-secondary switch-header-cs-class" data-class="bg-secondary header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-success switch-header-cs-class" data-class="bg-success header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-info switch-header-cs-class" data-class="bg-info header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-warning switch-header-cs-class" data-class="bg-warning header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-danger switch-header-cs-class" data-class="bg-danger header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-light switch-header-cs-class" data-class="bg-light header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-dark switch-header-cs-class" data-class="bg-dark header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-focus switch-header-cs-class" data-class="bg-focus header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-alternate switch-header-cs-class" data-class="bg-alternate header-text-light">
                                    </div>
                                    <div class="divider">
                                    </div>
                                    <div class="swatch-holder bg-vicious-stance switch-header-cs-class" data-class="bg-vicious-stance header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-midnight-bloom switch-header-cs-class" data-class="bg-midnight-bloom header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-night-sky switch-header-cs-class" data-class="bg-night-sky header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-slick-carbon switch-header-cs-class" data-class="bg-slick-carbon header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-asteroid switch-header-cs-class" data-class="bg-asteroid header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-royal switch-header-cs-class" data-class="bg-royal header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-warm-flame switch-header-cs-class" data-class="bg-warm-flame header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-night-fade switch-header-cs-class" data-class="bg-night-fade header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-sunny-morning switch-header-cs-class" data-class="bg-sunny-morning header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-tempting-azure switch-header-cs-class" data-class="bg-tempting-azure header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-amy-crisp switch-header-cs-class" data-class="bg-amy-crisp header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-heavy-rain switch-header-cs-class" data-class="bg-heavy-rain header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-mean-fruit switch-header-cs-class" data-class="bg-mean-fruit header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-malibu-beach switch-header-cs-class" data-class="bg-malibu-beach header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-deep-blue switch-header-cs-class" data-class="bg-deep-blue header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-ripe-malin switch-header-cs-class" data-class="bg-ripe-malin header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-arielle-smile switch-header-cs-class" data-class="bg-arielle-smile header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-plum-plate switch-header-cs-class" data-class="bg-plum-plate header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-happy-fisher switch-header-cs-class" data-class="bg-happy-fisher header-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-happy-itmeo switch-header-cs-class" data-class="bg-happy-itmeo header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-mixed-hopes switch-header-cs-class" data-class="bg-mixed-hopes header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-strong-bliss switch-header-cs-class" data-class="bg-strong-bliss header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-grow-early switch-header-cs-class" data-class="bg-grow-early header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-love-kiss switch-header-cs-class" data-class="bg-love-kiss header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-premium-dark switch-header-cs-class" data-class="bg-premium-dark header-text-light">
                                    </div>
                                    <div class="swatch-holder bg-happy-green switch-header-cs-class" data-class="bg-happy-green header-text-light">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <h3 class="themeoptions-heading">
                        <div>Top Bar Options</div>
                        <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-topBar-cs-class" data-class="bg-plum-plate top-bar-text-light">
                            Restore Default
                        </button>
                    </h3>
                    <div class="p-3">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <h5 class="pb-2">Choose Color Scheme
                                </h5>
                                <div class="theme-settings-swatches">
                                    <div class="swatch-holder bg-primary switch-topBar-cs-class" data-class="bg-primary top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-secondary switch-topBar-cs-class" data-class="bg-secondary top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-success switch-topBar-cs-class" data-class="bg-success top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-info switch-topBar-cs-class" data-class="bg-info top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-warning switch-topBar-cs-class" data-class="bg-warning top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-danger switch-topBar-cs-class" data-class="bg-danger top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-light switch-topBar-cs-class" data-class="bg-light top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-dark switch-topBar-cs-class" data-class="bg-dark top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-focus switch-topBar-cs-class" data-class="bg-focus top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-alternate switch-topBar-cs-class" data-class="bg-alternate top-bar-text-light">
                                    </div>
                                    <div class="divider">
                                    </div>
                                    <div class="swatch-holder bg-vicious-stance switch-topBar-cs-class" data-class="bg-vicious-stance top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-midnight-bloom switch-topBar-cs-class" data-class="bg-midnight-bloom top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-night-sky switch-topBar-cs-class" data-class="bg-night-sky top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-slick-carbon switch-topBar-cs-class" data-class="bg-slick-carbon top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-asteroid switch-topBar-cs-class" data-class="bg-asteroid top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-royal switch-topBar-cs-class" data-class="bg-royal top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-warm-flame switch-topBar-cs-class" data-class="bg-warm-flame top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-night-fade switch-topBar-cs-class" data-class="bg-night-fade top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-sunny-morning switch-topBar-cs-class" data-class="bg-sunny-morning top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-tempting-azure switch-topBar-cs-class" data-class="bg-tempting-azure top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-amy-crisp switch-topBar-cs-class" data-class="bg-amy-crisp top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-heavy-rain switch-topBar-cs-class" data-class="bg-heavy-rain top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-mean-fruit switch-topBar-cs-class" data-class="bg-mean-fruit top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-malibu-beach switch-topBar-cs-class" data-class="bg-malibu-beach top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-deep-blue switch-topBar-cs-class" data-class="bg-deep-blue top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-ripe-malin switch-topBar-cs-class" data-class="bg-ripe-malin top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-arielle-smile switch-topBar-cs-class" data-class="bg-arielle-smile top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-plum-plate switch-topBar-cs-class" data-class="bg-plum-plate top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-happy-fisher switch-topBar-cs-class" data-class="bg-happy-fisher top-bar-text-dark">
                                    </div>
                                    <div class="swatch-holder bg-happy-itmeo switch-topBar-cs-class" data-class="bg-happy-itmeo top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-mixed-hopes switch-topBar-cs-class" data-class="bg-mixed-hopes top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-strong-bliss switch-topBar-cs-class" data-class="bg-strong-bliss top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-grow-early switch-topBar-cs-class" data-class="bg-grow-early top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-love-kiss switch-topBar-cs-class" data-class="bg-love-kiss top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-premium-dark switch-topBar-cs-class" data-class="bg-premium-dark top-bar-text-light">
                                    </div>
                                    <div class="swatch-holder bg-happy-green switch-topBar-cs-class" data-class="bg-happy-green top-bar-text-light">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <h3 class="themeoptions-heading">
                        <div>Main Content Options</div>
                    </h3>
                    <div class="p-3">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <h5 class="pb-2">Color Schemes
                                </h5>
                                <div class="theme-settings-swatches">
                                    <div role="group" class="mt-2 btn-group">
                                        <button type="button" class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class" data-class="app-theme-white">
                                            White Theme
                                        </button>
                                        <button type="button" class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class" data-class="app-theme-gray">
                                            Gray Theme
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!--THEME OPTIONS END-->
        </div>

        <div class="app-drawer-overlay d-none animated fadeIn"></div><!--DRAWER END-->


        <?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>