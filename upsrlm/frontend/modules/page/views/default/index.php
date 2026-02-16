<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\WebApplication;
use common\models\master\MasterRole;
?>
<div style="margin-top: 0px">
    <?= \bcsakhi\components\widget\home\GalleryWidget::widget([]) ?>
</div>
<section class="about_home">
    <div class="container-fluid px-3 px-lg-5">
        <div class="row">
            <div class="col-md-12 col-xl-8">
                <div class="title">
                    <h3>About</h3>
                </div>
                <p>
                    People in rural hinterland often travel to the bank branches in nearby towns to access their fund or update information of their bank accounts which leads to increased cost in accessing the financial services. It has been observed that rural women often rely on relatives, or friends for carrying out banking transactions. Further, poor often suffer from congestion of intermediaries. Many a times, these intermediaries promise to add value to the trail of business transaction in favour of the poor. Despite advancement of technology and banking penetration, there is scope for improvement of banking services of rural residents in India.
                      </p>
                <p>
                    It is in this context that Reserve Bank of India (RBI) issued guidelines for engagement of Banking Correspondent (BC) Sakhis (Women Banking agents) for providing banking and financial services at doorstep at rural areas. In line with these guidelines Government of Uttar Pradesh (GoUP), adopted the BC Sakhi Program, or Mission One Gram Panchayat, One BC Sakhi, with the aim to train and certify women members of Self-Help Groups (SHGs- concept has been one of the largest women-focused credit and savings program that seeks to improve women role and position in financial decisions). BC Sakhis are then able to provide banking services to areas without physical bank branches.
                </p>
                <p>
                    The program provides an amount of ₹4,000 per month for six months to help the BC Sakhis stabilise their banking service business. As business proceeds, the BC Sakhis are paid a commission based on the amount of transactions they make, which is generally 0.20%-0.32% of the amount transacted. The potential women SHG members are trained on the BC module at the district level at Rural Self Employment Training Institutes (RSETIs) or other selected places. RSETIs already have a six-day course on Training of Banking Correspondent, which has been notified by Ministry of Rural Development (MoRD), Government of India. Each batch of trainees receives training inputs of six days.
                </p>

                <p>
                    In Uttar Pradesh, the program was launched in May 2020 amidst lockdown of COVID19 Pandemic with the goal of creating 58,000 BC Sakhis. Presently, the state has 38,435 BC Sakhis operational, trained and certified by Indian Institute of Banking & Finance (IIBF). The model in Uttar Pradesh has proven to be cost effective and sustainable mechanism for delivery of financial services to under-banked and un-banked sections of the society.
                    .</p>
            </div>
            <div class="col-xl-4 col-md-12 mb-3">
                <div class="about_home_content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => false,
                        'validateOnBlur' => false,
                        'validateOnType' => false,
                        'validateOnChange' => false,
                    ])
                    ?>

                    <p class="text-center">Please call in case of any issue : <a href="tel:9070804050"><br />9070804050</a></p>
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <div class="about_home_login">
                            <h2 class="mb-3">Sign In</h2>
                            <div class="form-group" style="display: none">

                                <?php
                                echo $form->field($model, 'login_type')->radioList($model->login_type_option)->label("");
                                ?>
                                <!--                                <input type="text" class="form-control" value="User Name" placeholder="USER NAME">-->
                            </div>
                            <div id="login_pwd" style="display:<?= $model->login_type == "1" ? "block" : "none" ?>;">
                                <div class="form-group">

                                    <?=
                                    $form->field(
                                        $model,
                                        'username',
                                        ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'placeholder' => 'Login', 'enableLabel' => false, 'template' => '<div class=\"\">{input}</div><div class=\"\">{error}</div>']]
                                    )->label('');
                                    ?>
                                </div>
                                <div class="form-group">

                                    <?=
                                    $form->field(
                                        $model,
                                        'password',
                                        ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => "Password"]]
                                    )
                                        ->passwordInput()
                                        ->label(
                                            ''
                                        )
                                    ?>
                                    <!--                                <input type="password" class="form-control" value="" placeholder="Password">-->

                                </div>
                                <div class="form-group">

                                    <div class="form-group form-check">
                                        <label class="form-check-label">
                                            <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '1', 'class' => '', 'selected' => 'selected']) ?>
                                        </label>
                                        <!--<a href="#" class="forgot"> Forgot Password ?</a>-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-12">
                                        <?=
                                        Html::submitButton(
                                            'LOGIN',
                                            ['class' => 'btn btn-success waves-effect w-md waves-light w-100', 'tabindex' => '4']
                                        )
                                        ?>
                                    </div>
                                </div>

                                <!--                                <div class="form-group">
                                
                                <?php echo Html::a('Forgot password?', ['/forgotpassword'], ['tabindex' => '5', 'class' => 'text-center waves-effect w-md waves-light w-100']); ?>  
                                                                </div>-->

                            </div>
                            <div id="login_otp" style="display:<?= $model->login_type == "2" ? "block" : "none" ?>;">
                                <div class="form-group">
                                    <div class="col-12">
                                        <?=
                                        $form->field(
                                            $model,
                                            'username_otp',
                                            ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'placeholder' => 'Mobile Number', 'enableLabel' => false, 'template' => '<div class=\"\">{input}</div><div class=\"\">{error}</div>']]
                                        )->label('');
                                        ?>
                                        <!--                                <input type="text" class="form-control" value="User Name" placeholder="USER NAME">-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-12">
                                        <?=
                                        $form->field($model, 'otp_sent')->hiddenInput()->label(false);
                                        ?>
                                        <?php
                                        $d = $model->login_type == "2" && $model->otp_sent == "1" ? "block" : "none";
                                        echo $form->field(
                                            $model,
                                            'otp',
                                            ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'style' => "display:$d", 'tabindex' => '1', 'placeholder' => 'OTP', 'enableLabel' => false, 'template' => '<div class=\"\">{input}</div><div class=\"\">{error}</div>']]
                                        )->label('');
                                        ?>
                                        <!--                                <input type="text" class="form-control" value="User Name" placeholder="USER NAME">-->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-12">
                                        <?php
                                        $d = $model->login_type == "2" && $model->otp_sent == "1" ? "Login" : "Next";
                                        echo Html::submitButton(
                                            $d,
                                            ['class' => 'btn btn-success waves-effect w-md waves-light w-100', 'tabindex' => '4']
                                        )
                                        ?>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php if (!Yii::$app->user->isGuest) {
                        ?>


                            <span class="">Go to Portal</span>


                            <?php if (in_array(WebApplication::WEB_APP_BC_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['bc'])) { ?>

                                <a href="<?= Yii::$app->params['app_url']['bc'] ?>" class="btn btn-warning btn-block"><span> B.C Sakhi Portal</span> </a>

                            <?php } ?>
                            <?php if (in_array(WebApplication::WEB_APP_CBO_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['cbo'])) { ?>

                                <a href="<?= Yii::$app->params['app_url']['cbo'] ?>" class="btn btn-info btn-block"><span> C.B.O Portal </span> </a>

                            <?php } ?>
                            <?php if (in_array(WebApplication::WEB_APP_HR_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['hr'])) { ?>
                                <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_HR_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_JMD])) { ?>

                                    <a href="<?= Yii::$app->params['app_url']['hr'] ?>" class="btn btn-dark btn-block"><span> HR Portal </span> </a>

                                <?php } ?>
                            <?php } ?>
                            <?php if (in_array(WebApplication::WEB_APP_ADMIN_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))  and isset(Yii::$app->params['app_url']['admin'])) { ?>

                                <a href="<?= Yii::$app->params['app_url']['admin'] ?>" class="btn btn-danger btn-block"><span> Admin Portal </span> </a>

                            <?php } ?>
                            

                        <?php } ?>
                    <?php } ?>
                </div>
                <?php ActiveForm::end(); ?>
                <?= \bcsakhi\components\widget\home\VideoWidget::widget([]) ?>
            </div>
        </div>
    </div>
</section>

<?= \bcsakhi\components\widget\home\TopbcWidget::widget([]) ?>

<?= \bcsakhi\components\widget\home\PartnerWidget::widget([]) ?>

<!--<div class="home_slider mb-4">
    <div class="container-fluid">
        -first-
        <div class="row first_slide">
            <div class="col-xl-1 col-md-2">
                <div class="home_slider_title title_bc_bg">
                    <h3>BC</h3>
                </div>
            </div>
            <div class="col-xl-11 col-md-10">
                <div class="inner_slider">
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="icon_box">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->bc_identify) ? \common\helpers\Utility::numberIndiaStyle($app_data->bc_identify) : '&nbsp;' ?></h2>
                                    <p>Identify</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->bc_preselect) ? \common\helpers\Utility::numberIndiaStyle($app_data->bc_preselect) : '&nbsp;' ?></h2>
                                    <p>Preselect</p>


                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->bc_trained) ? \common\helpers\Utility::numberIndiaStyle($app_data->bc_trained) : '&nbsp;' ?></h2>
                                    <p>Trained</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->bc_trained_and_certified) ? \common\helpers\Utility::numberIndiaStyle($app_data->bc_trained_and_certified) : '&nbsp;' ?></h2>
                                    <p>Trained & certified</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->bc_onboarded) ? \common\helpers\Utility::numberIndiaStyle($app_data->bc_onboarded) : '&nbsp;' ?></h2>
                                    <p>Onboarded</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->bc_operational) ? \common\helpers\Utility::numberIndiaStyle($app_data->bc_operational) : '&nbsp;' ?></h2>
                                    <p>Operational</p>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        -first-
        -Second-
        <div class="row">
            <div class="col-xl-1 col-md-2">
                <div class="home_slider_title title_clf_bg">
                    <h3>CLF</h3>
                </div>
            </div>
            <div class="col-xl-11 col-md-10">
                <div class="inner_slider">
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="icon_box title_clf_bg">
                                <div class="icon_content">
                                    <h2><?= isset($app_data->clf_formed) ? \common\helpers\Utility::numberIndiaStyle($app_data->clf_formed) : '&nbsp;' ?></h2>
                                    <p>Formed</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_clf_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->clf_e_registered) ? \common\helpers\Utility::numberIndiaStyle($app_data->clf_e_registered) : '&nbsp;' ?></h2>
                                    <p>E-registered</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_clf_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->clf_app_operated) ? \common\helpers\Utility::numberIndiaStyle($app_data->clf_app_operated) : '&nbsp;' ?></h2>
                                    <p>App-operated</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_clf_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->clf_start_up_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->clf_start_up_received) : '&nbsp;' ?></h2>
                                    <p>Start-up received</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_clf_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->clf_cif_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->clf_cif_received) : '&nbsp;' ?></h2>
                                    <p>CIF received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_clf_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->clf_isf_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->clf_isf_received) : '&nbsp;' ?></h2>
                                    <p>ISF received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_clf_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->clf_infra_fund_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->clf_infra_fund_received) : '&nbsp;' ?></h2>
                                    <p>INFRA Fund received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_clf_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->clf_others_fund_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->clf_others_fund_received) : '&nbsp;' ?></h2>
                                    <p>Others Fund received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_clf_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->clf_fund_utilization_efficiency) ? \common\helpers\Utility::numberIndiaStyle($app_data->clf_fund_utilization_efficiency) : '&nbsp;' ?></h2>
                                    <p>Fund Utilization efficiency</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_clf_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->clf_stagnant_fund) ? \common\helpers\Utility::numberIndiaStyle($app_data->clf_stagnant_fund) : '&nbsp;' ?></h2>
                                    <p>Stagnant fund</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -Second-
        -Third-
        <div class="row">
            <div class="col-xl-1 col-md-2">
                <div class="home_slider_title title_vo_bg">
                    <h3>VO</h3>
                </div>
            </div>
            <div class="col-xl-11 col-md-10">
                <div class="inner_slider">
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="icon_box title_vo_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->vo_formed) ? \common\helpers\Utility::numberIndiaStyle($app_data->vo_formed) : '&nbsp;' ?></h2>
                                    <p>Formed</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_vo_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->vo_e_registered) ? \common\helpers\Utility::numberIndiaStyle($app_data->vo_e_registered) : '&nbsp;' ?></h2>
                                    <p>E-registered</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_vo_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->vo_app_operated) ? \common\helpers\Utility::numberIndiaStyle($app_data->vo_app_operated) : '&nbsp;' ?></h2>
                                    <p>App-operated</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_vo_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->vo_start_up_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->vo_start_up_received) : '&nbsp;' ?></h2>
                                    <p>Start-up received</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_vo_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->vo_vrf_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->vo_vrf_received) : '&nbsp;' ?></h2>
                                    <p>VRF received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_vo_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->vo_lf_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->vo_lf_received) : '&nbsp;' ?></h2>
                                    <p>LF received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_vo_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->vo_patb_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->vo_patb_received) : '&nbsp;' ?></h2>
                                    <p>PATB received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_vo_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->vo_agey_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->vo_agey_received) : '&nbsp;' ?></h2>
                                    <p>AGEY received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_vo_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->vo_isf_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->vo_isf_received) : '&nbsp;' ?></h2>
                                    <p>ISF received</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -Third-
        -Forth-
        <div class="row">
            <div class="col-xl-1 col-md-2">
                <div class="home_slider_title title_shg_bg">
                    <h3>SHG</h3>
                </div>
            </div>
            <div class="col-xl-11 col-md-10">
                <div class="inner_slider">
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="icon_box title_shg_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->shg_formed) ? \common\helpers\Utility::numberIndiaStyle($app_data->shg_formed) : '&nbsp;' ?></h2>
                                    <p>Formed</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_shg_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->shg_e_registered) ? \common\helpers\Utility::numberIndiaStyle($app_data->shg_e_registered) : '&nbsp;' ?></h2>
                                    <p>E-registered</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_shg_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->shg_members) ? \common\helpers\Utility::numberIndiaStyle($app_data->shg_members) : '&nbsp;' ?></h2>
                                    <p>SHG members</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_shg_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->shg_start_up_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->shg_start_up_received) : '&nbsp;' ?></h2>
                                    <p>Start-up received</p>

                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_shg_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->shg_cif_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->shg_cif_received) : '&nbsp;' ?></h2>
                                    <p>CIF received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_shg_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->shg_repeated_bank_loan) ? \common\helpers\Utility::numberIndiaStyle($app_data->shg_repeated_bank_loan) : '&nbsp;' ?></h2>
                                    <p>Repeated Bank Loan</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_shg_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->shg_fund_3_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->shg_fund_3_received) : '&nbsp;' ?></h2>
                                    <p>Fund-3 received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_shg_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->shg_fund_4_received) ? \common\helpers\Utility::numberIndiaStyle($app_data->shg_fund_4_received) : '&nbsp;' ?></h2>
                                    <p>Fund-4 received</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_shg_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->shg_fund_utilization_efficiency) ? \common\helpers\Utility::numberIndiaStyle($app_data->shg_fund_utilization_efficiency) : '&nbsp;' ?></h2>
                                    <p>Fund Utilization efficiency</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon_box title_shg_bg">

                                <div class="icon_content">
                                    <h2><?= isset($app_data->shg_stagnant_fund) ? \common\helpers\Utility::numberIndiaStyle($app_data->shg_stagnant_fund) : '&nbsp;' ?></h2>
                                    <p>Stagnant fund</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -Forth-


    </div>
</div>-->

<?php
?>
<?php
$JS = <<<JS
        $(document).ready(function () {
       //  $('LoginForm[otp]').hide();
        
        //   tp_sent
            $('input:radio[value=1]').click(function(){
                $('#login_pwd').show();
                $('#login_otp').hide();
            });
            $('input:radio[value=2]').click(function(){
                $('#login_otp').show();
                $('#login_pwd').hide();
            });
        });
        
      
JS;
$this->registerJS($JS);
?>
<?php
$style = <<< CSS
        
.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } 
.embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        
        
.control-label{
 display:none;       
}
CSS;
$this->registerCss($style);
?>