<?php

use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\FieldAppAsset;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $content string */

FieldAppAsset::register($this);
$arg = explode('/', Yii::$app->request->url);
$url = explode('/', Yii::$app->request->url);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="no-skin">
        <?php $this->beginBody() ?>

        <!-- #section:basics/navbar.layout -->
        <div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar">
            <script type="text/javascript">
                try {
                    ace.settings.check('navbar', 'fixed')
                } catch (e) {
                }
            </script>

            <div class="navbar-container" id="navbar-container">
                <div class="navbar-header pull-left">
                    <!-- #section:basics/navbar.layout.brand -->
                    <a href="#" class="navbar-brand">
                        <small>
                            <i class="fa fa-leaf"></i>
                            Fieldata
                        </small>
                    </a>

                    <!-- /section:basics/navbar.layout.brand -->
                </div>
                <!-- #section:basics/navbar.toggle -->
                <button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
                    <span class="sr-only">Toggle user menu</span>
                </button>

                <button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
                </button>

                <!-- /section:basics/navbar.toggle -->
                <!-- #section:basics/navbar.dropdown -->
                <div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
                    <ul class="nav ace-nav">
                        <!-- #section:basics/navbar.user_menu -->
                        <?php if (!Yii::$app->user->isGuest) { ?>
                            <li class="">


                                <span class="light-blue">
                                    <small>Welcome,</small>
                                    <?php echo Yii::$app->user->identity->username; ?>
                                </span>


                            </li>
                        <?php } else { ?>
                            <li>
                                <?= Html::a('<i class="ace-icon fa fa-login"></i>Login', ['/user/login'], ['class' => '']) ?> 
                            </li>
                        <?php } ?>
                        <!-- /section:basics/navbar.user_menu -->
                    </ul>
                </div>

                <!-- /section:basics/navbar.dropdown -->
                <nav role="navigation" class="navbar-menu pull-left collapse navbar-collapse">
                    <!-- #section:basics/navbar.nav -->
                    <ul class="nav navbar-nav">
                        <li>
                            <?= Html::a('<i class="ace-icon fa"></i>Home', ['/'], ['class' => '']) ?> 
                        </li>
                        <li>
                            <?= Html::a('<i class="ace-icon fa"></i>Get Started', ['/'], ['class' => '']) ?> 
                        </li>
                        <li>
                            <?= Html::a('<i class="ace-icon fa"></i>News', ['/'], ['class' => '']) ?> 
                        </li>
                        <li>
                            <?= Html::a('<i class="ace-icon fa"></i>FAQs', ['/'], ['class' => '']) ?> 
                        </li>
                        <li>
                            <?= Html::a('<i class="ace-icon fa"></i>Pricing', ['/'], ['class' => '']) ?> 
                        </li>
                        <li>
                            <?= Html::a('<i class="ace-icon fa"></i>About', ['/'], ['class' => '']) ?> 
                        </li>
                        <li>
                            <?= Html::a('<i class="ace-icon fa"></i>Contact', ['/'], ['class' => '']) ?> 
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Overview
                                &nbsp;
                                <i class="ace-icon fa fa-angle-down bigger-110"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-light-blue dropdown-caret">
                                <li>
                                    <a href="#">
                                        <i class="ace-icon fa fa-eye bigger-110 blue"></i>
                                        Monthly Visitors
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="ace-icon fa fa-user bigger-110 blue"></i>
                                        Active Users
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="ace-icon fa fa-cog bigger-110 blue"></i>
                                        Settings
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <!-- /section:basics/navbar.nav -->

                </nav>
            </div><!-- /.navbar-container -->
        </div>

        <!-- /section:basics/navbar.layout -->
        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed')
                } catch (e) {
                }
            </script>

            <!-- #section:basics/sidebar.horizontal -->
            <div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse">
                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'fixed')
                    } catch (e) {
                    }
                </script>
                <?php if (!Yii::$app->user->isGuest) { ?>
                    <ul class="nav nav-list">
                        <li class="<?php if ($url[1] == 'dashboard') echo 'active'; ?> hover">
                            <?= Html::a('<i class="menu-icon fa fa-tachometer"></i><span class="menu-text">Dashboard</span> <b class="arrow"></b>', ['/dashboard'], ['class' => '']) ?>      

                        </li>
                        <?php if (Yii::$app->user->can('/organization/view/index')) { ?>
                            <li class='<?php if ($url[1] == 'organization') echo 'active'; ?>'>
                                <?= Html::a('<i class="menu-icon fa fa-desktop"></i><span class="menu-text">Organization</span> <b class="arrow"></b>', ['/organization/list'], ['class' => '']) ?>       

                            </li>
                        <?php } ?>
                        <?php if (Yii::$app->user->can('/project/list/index')) { ?>
                            <li class='<?php if ($url[1] == 'project') echo 'active'; ?> open hover'>
                                <?= Html::a('<i class="menu-icon fa fa-desktop"></i><span class="menu-text">Project</span>  <b class="arrow fa fa-angle-down"></b>', ['#'], ['class' => 'dropdown-toggle']) ?>         
                                <ul class="submenu">
                                    <?php if (Yii::$app->user->can('/project/list/index')) { ?>
                                        <li class='<?php if ($url[1] == 'project' && isset($url[2]) && $url[2] == 'list') echo 'active'; ?> hover'>
                                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i><span class="menu-text">List</span> <b class="arrow"></b>', ['/project/list'], ['class' => '']) ?> 
                                        </li>
                                    <?php } ?>
                                    <?php if (Yii::$app->user->can('/project/add/index')) { ?>
                                        <li class='<?php if ($url[1] == 'project' && isset($url[2]) && $url[2] == 'add') echo 'active'; ?> hover'>   
                                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i><span class="menu-text">Add</span> <b class="arrow"></b>', ['/project/add'], ['class' => '']) ?>   
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?> 
                        <?php if (Yii::$app->user->can('/user/default/index')) { ?>
                            <li class='<?php if ($url[1] == 'user' || $url[1] == 'team') echo 'active'; ?> open hover'>
                                <?= Html::a('<i class="menu-icon fa fa-user-md"></i><span class="menu-text">People</span>  <b class="arrow fa fa-angle-down"></b>', ['#'], ['class' => 'dropdown-toggle']) . '<b class="arrow"></b>' ?>         
                                <ul class="submenu">
                                    <?php if (Yii::$app->user->can('/user/default/index')) { ?>
                                        <li class='<?php if ($url[1] == 'user') echo 'active'; ?> hover'>
                                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i><span class="menu-text">List</span> <b class="arrow"></b>', ['/user/'], ['class' => '']) ?> 
                                        </li>
                                    <?php } ?>
                                    <?php if (Yii::$app->user->can('/user/add/add')) { ?>
                                        <li class='<?php if ($url[1] == 'user' && isset($url[2]) && $url[2] == 'add') echo 'active'; ?> hover'>   
                                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i><span class="menu-text">Add</span> <b class="arrow"></b>', ['/user/add'], ['class' => '']) ?>   
                                        </li>
                                    <?php } ?>
                                    <?php if (Yii::$app->user->can('/team/add/index')) { ?>
                                        <li class='<?php if ($url[1] == 'team' && isset($url[2]) && $url[2] == 'add') echo 'active'; ?> hover'>
                                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i><span class="menu-text">Create team</span> <b class="arrow"></b>', ['/team/add'], ['class' => '']) ?> 
                                        </li>
                                    <?php } ?>
                                    <?php if (Yii::$app->user->can('/team/list/index')) { ?>
                                        <li class='<?php if ($url[1] == 'team' && isset($url[2]) && $url[2] == 'list') echo 'active'; ?> hover'>   
                                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i><span class="menu-text">List team</span> <b class="arrow"></b>', ['/team/list'], ['class' => '']) ?>   
                                        </li>  
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>   
                        <?php if (Yii::$app->user->can('/form/list/index')) { ?>
                            <li class='<?php if ($url[1] == 'form') echo 'active'; ?> open hover'>
                                <?= Html::a('<i class="menu-icon fa fa-pencil-square-o"></i><span class="menu-text">Form</span>  <b class="arrow fa fa-angle-down"></b>', ['#'], ['class' => 'dropdown-toggle']) . '<b class="arrow"></b>' ?>

                                <ul class="submenu">
                                    <?php if (Yii::$app->user->can('/form/list/index')) { ?>
                                        <li class='<?php if ($url[1] == 'form' && isset($url[2]) && $url[2] == 'list') echo 'active'; ?> hover'>
                                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i><span class="menu-text">List</span> <b class="arrow"></b>', ['/form/list'], ['class' => '']) ?>   
                                        </li>
                                    <?php } ?>
                                    <?php if (Yii::$app->user->can('/form/upload/index')) { ?>
                                        <li class='<?php if ($url[1] == 'form' && isset($url[2]) && $url[2] == 'upload') echo 'active'; ?> hover'>
                                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i><span class="menu-text">Upload</span> <b class="arrow"></b>', ['/form/upload'], ['class' => '']) ?>   
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?> 
                        <?php if ((Yii::$app->user->can('/inyenyeri/default/index') && (isset(ArrayHelper::getColumn(Yii::$app->user->identity->detail, 'organization_id')[0]) && ArrayHelper::getColumn(Yii::$app->user->identity->detail, 'organization_id')[0] == 4)) || (Yii::$app->user->can('/inyenyeri/default/index') && isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 'administrator')) { ?>
                            <li class='<?php if ($url[1] == 'inyenyeri') echo 'active'; ?> open hover'>
                                <?= Html::a('<i class="menu-icon fa fa-desktop"></i><span class="menu-text">inyenyeri</span>  <b class="arrow fa fa-angle-down"></b>', ['#'], ['class' => 'dropdown-toggle']) . '<b class="arrow"></b>' ?>

                                <ul class="submenu">

                                    <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master') echo 'active'; ?> open hover'>
                                        <?= Html::a('<i class="menu-icon fa fa-caret-right"></i><span class="menu-text">Master</span>  <b class="arrow fa fa-angle-down"></b>', ['#'], ['class' => 'dropdown-toggle']) . '<b class="arrow"></b>' ?>
                                        <ul class="submenu">

                                            <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'membershippackage') echo 'active'; ?> hover'>
                                                <?= Html::a('<i class="menu-icon"></i><span class="menu-text">Packages</span>', ['#'], ['class' => 'dropdown-toggle']) . '<b class="arrow"></b>' ?>

                                                <ul class="submenu">
                                                    <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'membershippackage') echo 'active'; ?> hover'>
                                                        <?= Html::a('<i class="menu-icon fa fa-table purple"></i>List', ['/inyenyeri/master/membershippackage/'], ['class' => '']) . '<b class="arrow"></b>' ?>        

                                                    </li>   
                                                    <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'membershippackage' && isset($url[4]) && $url[4] == 'create') echo 'active'; ?> hover'>
                                                        <?= Html::a('<i class="menu-icon fa fa-plus purple"></i>Add', ['/inyenyeri/master/membershippackage/create'], ['class' => '']) . '<b class="arrow"></b>' ?>    

                                                    </li>


                                                </ul>
                                            </li>
                                            <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'membershipstatus') echo 'active'; ?> open hover'>
                                                <?= Html::a('<i class="menu-icon"></i><span class="menu-text">Status</span>', ['#'], ['class' => 'dropdown-toggle']) . '<b class="arrow"></b>' ?>

                                                <ul class="submenu">
                                                    <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'membershipstatus') echo 'active'; ?> hover'>
                                                        <?= Html::a('<i class="menu-icon fa fa-table purple"></i>List', ['/inyenyeri/master/membershipstatus/'], ['class' => '']) . '<b class="arrow"></b>' ?>        

                                                    </li>   
                                                    <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'membershipstatus' && isset($url[4]) && $url[4] == 'create') echo 'active'; ?> hover'>
                                                        <?= Html::a('<i class="menu-icon fa fa-plus purple"></i>Add', ['/inyenyeri/master/membershipstatus/create'], ['class' => '']) . '<b class="arrow"></b>' ?>    

                                                    </li>


                                                </ul>
                                            </li>
                                            <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'location') echo 'active'; ?> hover'>
                                                <?= Html::a('<i class="menu-icon"></i><span class="menu-text">Location</span>', ['#'], ['class' => 'dropdown-toggle']) . '<b class="arrow"></b>' ?>

                                                <ul class="submenu">
                                                    <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'location') echo 'active'; ?> hover'>
                                                        <?= Html::a('<i class="menu-icon fa fa-table purple"></i>List', ['/inyenyeri/master/location/'], ['class' => '']) . '<b class="arrow"></b>' ?>        

                                                    </li>   
                                                    <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'location' && isset($url[4]) && $url[4] == 'uploadcsv') echo 'active'; ?> hover'>
                                                        <?= Html::a('<i class="menu-icon fa fa-upload purple"></i>Upload CSV', ['/inyenyeri/master/location/uploadcsv'], ['class' => '']) . '<b class="arrow"></b>' ?>    

                                                    </li>


                                                </ul>
                                            </li>
                                            <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'user') echo 'active'; ?> hover'>
                                                <?= Html::a('<i class="menu-icon"></i><span class="menu-text">Users</span><b class="arrow fa fa-angle-down"></b>', ['#'], ['class' => 'dropdown-toggle']) . '<b class="arrow"></b>' ?>

                                                <ul class="submenu">
                                                    <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'user') echo 'active'; ?> hover'>
                                                        <?= Html::a('<i class="menu-icon fa fa-table purple"></i>List', ['/inyenyeri/master/user/'], ['class' => '']) . '<b class="arrow"></b>' ?>        

                                                    </li>   
                                                    <li class='<?php if ($url[1] == 'inyenyeri' && isset($url[2]) && $url[2] == 'master' && isset($url[3]) && $url[3] == 'user' && isset($url[4]) && $url[4] == 'uploadcsv') echo 'active'; ?> hover'>
                                                        <?= Html::a('<i class="menu-icon fa fa-upload purple"></i>Add', ['/inyenyeri/master/user/create'], ['class' => '']) . '<b class="arrow"></b>' ?>    

                                                    </li>


                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>    
                        <li class='<?php if ($url[1] == 'organization') echo 'active'; ?>'>
                            <?= Html::a('<i class="menu-icon fa fa-power-off"></i><span class="menu-text">Logout</span> <b class="arrow"></b>', ['/user/logout'], ['data-method' => 'post']) ?>       

                        </li>
                    </ul><!-- /.nav-list -->
                <?php } ?>
                <!-- #section:basics/sidebar.layout.minimize -->

                <!-- /section:basics/sidebar.layout.minimize -->
                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'collapsed')
                    } catch (e) {
                    }
                </script>
            </div>

            <!-- /section:basics/sidebar.horizontal -->
            <div class="main-content">
                <div class="main-content-inner">
                    <div class="page-content">
                        <div class="page-header">

                            <h1>
                                <?php
                                if (isset($this->title)) {
                                    echo $this->title;
                                }
                                ?>
                            </h1>

                        </div><!-- /.page-header -->

                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->

                                <div class="center">
                                    <?= $content ?>
                                </div>

                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <div class="footer">
                <div class="footer-inner">
                    <!-- #section:basics/footer -->
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder">
                                &COPY; 2012 Arthify Inc.</span>
                            All Rights Reserved. Users are advised to read Terms and Conditions carefully.
                        </span>

                        &nbsp; &nbsp;
                   <!--     <span class="action-buttons">
                            <a href="#">
                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
                            </a>
                        </span>-->
                    </div>

                    <!-- /section:basics/footer -->
                </div>
            </div>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
        <!-- inline scripts related to this page -->
        <script type="text/javascript">
//            jQuery(function($) {
//                var $sidebar = $('.sidebar').eq(0);
//                if (!$sidebar.hasClass('h-sidebar'))
//                    return;
//
//                $(document).on('settings.ace.top_menu', function(ev, event_name, fixed) {
//                    if (event_name !== 'sidebar_fixed')
//                        return;
//
//                    var sidebar = $sidebar.get(0);
//                    var $window = $(window);
//
//                    //return if sidebar is not fixed or in mobile view mode
//                    var sidebar_vars = $sidebar.ace_sidebar('vars');
//                    if (!fixed || (sidebar_vars['mobile_view'] || sidebar_vars['collapsible'])) {
//                        $sidebar.removeClass('lower-highlight');
//                        //restore original, default marginTop
//                        sidebar.style.marginTop = '';
//
//                        $window.off('scroll.ace.top_menu')
//                        return;
//                    }
//
//
//                    var done = false;
//                    $window.on('scroll.ace.top_menu', function(e) {
//
//                        var scroll = $window.scrollTop();
//                        scroll = parseInt(scroll / 4);//move the menu up 1px for every 4px of document scrolling
//                        if (scroll > 17)
//                            scroll = 17;
//
//
//                        if (scroll > 16) {
//                            if (!done) {
//                                $sidebar.addClass('lower-highlight');
//                                done = true;
//                            }
//                        }
//                        else {
//                            if (done) {
//                                $sidebar.removeClass('lower-highlight');
//                                done = false;
//                            }
//                        }
//
//                        sidebar.style['marginTop'] = (17 - scroll) + 'px';
//                    }).triggerHandler('scroll.ace.top_menu');
//
//                }).triggerHandler('settings.ace.top_menu', ['sidebar_fixed', $sidebar.hasClass('sidebar-fixed')]);
//
//                $(window).on('resize.ace.top_menu', function() {
//                    $(document).triggerHandler('settings.ace.top_menu', ['sidebar_fixed', $sidebar.hasClass('sidebar-fixed')]);
//                });
//
//
//            });
        </script>
        <?php
        $js = <<<js
js;
        $this->registerJs($js);
        ?>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

