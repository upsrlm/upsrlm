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
                <div class="header_primary">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-1 col-12">
                        <div class="header_primary_logo header_logo">
                            <a href="/"><img src="<?=$bundel->baseUrl?>/images/logo.png" class="img-fluid" alt=""> </a>
                        </div>
                    </div>
                    <div class="col-sm-5 col-12">
                        <div class="header_primary_logo_text">
                            <h3>U.P State Rural Livehood Mission</h3>
                            <h6>Department of Rural Development</h6>
                            <p>Goverment Of Uttar pradesh</p>
                        </div>
                    </div>
                    <div class="col-sm-5 col-12">
                        <div class="header_primary_logo_text">
                            <h3>CBO Portal</h3>
                            
                        </div>
                    </div>
                    <div class="col-sm-1 col-12">
                        <div class="right_nav header_logo">
                            <a href="/"> <img src="<?=$bundel->baseUrl?>/images/logo_up.png" class="img-fluid" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div  class="app-container app-theme-white app-fluid-container">
            <div class="app-top-bar bg-warning top-bar-text-light">
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
<!--                    <div class="app-header__logo">
                        
                    </div>        -->
                    <ul class="horizontal-nav-menu">
                        <li class="dropdown">
                            <a  data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false" class="active">
                                <i class="nav-icon-big typcn typcn-directions"></i>
                                <span>SHG</span>
                                <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-lg">
          
                                <div class="scroll-area-xs">
                                    <div class="scrollbar-container">
                                        <a class="dropdown-item" href="/shg"><i class="fa fa-list"></i> List</a>
                                        <a class="dropdown-item" href="/shg/default/create"><i class="fa fa-plus"></i> Add</a>
                                        
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="dropdown">
                            <a  data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false">
                                <i class="nav-icon-big typcn typcn-document"></i>
                                <span>VO</span>
                                <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-rounded">
                                <div class="scroll-area-xs">
                                    <div class="scrollbar-container">
                                        <a class="dropdown-item" href="/vo"><i class="fa fa-list"></i> List</a>
                                        <a class="dropdown-item" href="/vo/default/create"><i class="fa fa-plus"></i> Add</a>
                                      
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a  data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false">
                                <i class="nav-icon-big typcn typcn-lightbulb"></i>
                                <span>CLF</span>
                                <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-rounded p-0">
                                <div class="scroll-area-xs">
                                    <div class="scrollbar-container">
                                       <a class="dropdown-item" href="/clf"><i class="fa fa-list"></i> List</a>
                                        <a class="dropdown-item" href="/clf/default/create"><i class="fa fa-plus"></i> Add</a>
                                      
                                    </div>
                                </div>  
                            </div>
                        </li>
                        <li class="dropdown">
                            <a  data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false">
                                <i class="nav-icon-big typcn typcn-lightbulb"></i>
                                <span>BC</span>
                                <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-rounded p-0">
                                <div class="scroll-area-xs">
                                    <div class="scrollbar-container">
                                       <a class="dropdown-item" href="/bc/noshg"><i class="fa fa-list"></i> List (No SHG)</a>
                                       
                                    </div>
                                </div>  
                            </div>
                        </li>
                        <li class="dropdown">
                            <a  data-toggle="dropdown" data-offset="10" data-display="static" aria-expanded="false">
                                <i class="nav-icon-big typcn typcn-lightbulb"></i>
                                <span>Report</span>
                                <i class="nav-icon-pointer icon ion-ios-arrow-down"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-rounded p-0">
                                <div class="scroll-area-xs">
                                    <div class="scrollbar-container">
                                       <a class="dropdown-item" href="/shg/report/registration"><i class="fa fa-list"></i> CBO Registration</a>
                                       <a class="dropdown-item" href="/shg/report/daily"><i class="fa fa-download"></i> Daily Activity SHG BMMU</a>
                                       <a class="dropdown-item" href="/shg/report/dailyv"><i class="fa fa-download"></i> Daily Activity SHG Verifier</a>
                                       <a class="dropdown-item" href="/shg/report/csvshgreggp"><i class="fa fa-download"></i> CBO SHG Registration</a>
                                       
                                    </div>
                                </div>  
                            </div>
                        </li>
                    </ul> 
                </div>
            </div>

            <div class="app-main">
                <div class="app-main__outer">
<!--                    <div class="app-main__inner">
                        <div class="app-inner-layout app-inner-layout-page">

                            <div class="app-inner-layout__wrapper">-->

                                <div class="app-inner-layout__content">

                                    <?= $content ?>
<!--                                </div>
                            </div>-->
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