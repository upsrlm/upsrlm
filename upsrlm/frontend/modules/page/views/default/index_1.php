<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div>
    <div class="" style="padding-top: 120px;">



        <div class="row">

            <div class="col-xl-8">
                <div class="card-box" style="background-color: #C6E0B8;padding-top: 0px;">
                    <h4 class="page-title" style="text-align: center; font-size: 24px">About</h4>
                    <!--                    <h2 style="margin: 0px;">About</h2>-->
                    <div class=" hm-intro-blk d-flex justify-content-around" style="min-height: 20px">
                        <p>
                            <b>CBO Portal</b>
                            <br/>
                            So far, approximately 4 lakh community based organizations (CBO) have been formed. Termed as the institutions of the poor, these CBOs may be viewed as (a) self-help groups (SHG) as collection of 10-20 families, and (b) federating groups represented by the SHGs at village and cluster levels. Formed at the level of gram panchayats, federation of 7 to 12 SHGs are called village organization (VO). At the next level, 5 to 15 VOs federated for a cluster of 10-20 Gram Panchayats are called cluster level federation (CLF). Both the federating entities, VO and CLF, are represented by the members of the SHGs.
                            <br/>
                            <a href="/page/about/cbo">Know More</a>
                        </p>

                        <div class="devider-line"></div>
                        <p>
                            <b>BC Sakhi Portal</b>
                            <br/>
                            Department of Rural Development (DoUD), Government of Uttar Pradesh (GoUP) has launched a scheme for appointing one Business Correspondent Sakhi (BC) in each of the State’s 58,000 Gram Panchayats (GP). Approx. 2.167 lakh BC applications received, UPSRLM has shortlisted 56,825 BC candidates for training. The trainings would be conducted by RSETI (Rural Self-employment Training Institute). The RSETI trainings aims to prepare BCs for mandatary examination and certification by Indian Institute for Banking & Finance (IIBF).
                            <br/>
                            <a href="/page/about/bc">Know More</a>
                        </p>                        
                    </div>

                </div>
            </div><!-- end col -->

            <div class="col-xl-4">



                <div style="font-weight: bold"> Please call in case of any issue : 92609 85122</div>







                <?php if (Yii::$app->user->isGuest) { ?>


                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h3 class="panel-title">Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <div class="">
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
                                <div class="form-group">
                                    <div class="col-12">
                                        <?php
                                        echo $form->field($model, 'login_type')->radioList($model->login_type_option)->label("");
                                        ?>
        <!--                                <input type="text" class="form-control" value="User Name" placeholder="USER NAME">-->
                                    </div>
                                </div>
                                <div id ="login_pwd" style="display:<?= $model->login_type == "1" ? "block" : "none" ?>;">
                                    <div class="form-group">
                                        <div class="col-12">
                                            <?=
                                            $form->field($model, 'username', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'placeholder' => 'Login', 'enableLabel' => false, 'template' => '<div class=\"\">{input}</div><div class=\"\">{error}</div>']]
                                            )->label('');
                                            ?>
            <!--                                <input type="text" class="form-control" value="User Name" placeholder="USER NAME">-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-12">
                                            <?=
                                                    $form->field(
                                                            $model, 'password', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => "Password"]])
                                                    ->passwordInput()
                                                    ->label(''
                                                    )
                                            ?>
            <!--                                <input type="password" class="form-control" value="" placeholder="Password">-->
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-12">
                                            <div class="mt-3">
                                                <div class="custom-control custom-checkbox">
                                                    <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '1', 'class' => '', 'selected' => 'selected']) ?>
            <!--                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">Remember me</label>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-12">
                                            <?=
                                            Html::submitButton(
                                                    'LOGIN', ['class' => 'btn btn-success waves-effect w-md waves-light w-100', 'tabindex' => '4']
                                            )
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <!--                                    <div class="col-12">
                                        <?php echo Html::a('Forgot password?', ['/forgotpassword'], ['tabindex' => '5', 'class' => 'text-center waves-effect w-md waves-light w-100']); ?>  
                                                                            </div>-->
                                    </div>
                                </div>
                                <div id="login_otp" style="display:<?= $model->login_type == "2" ? "block" : "none" ?>;">
                                    <div class="form-group">
                                        <div class="col-12">
                                            <?=
                                            $form->field($model, 'username_otp', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'placeholder' => 'Mobile Number', 'enableLabel' => false, 'template' => '<div class=\"\">{input}</div><div class=\"\">{error}</div>']]
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
                                            echo $form->field($model, 'otp', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'style' => "display:$d", 'tabindex' => '1', 'placeholder' => 'OTP', 'enableLabel' => false, 'template' => '<div class=\"\">{input}</div><div class=\"\">{error}</div>']]
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
                                                    $d, ['class' => 'btn btn-success waves-effect w-md waves-light w-100', 'tabindex' => '4']
                                            )
                                            ?>
                                        </div>
                                    </div>


                                </div>

                                <?php ActiveForm::end(); ?>

                            </div>
                            <!--                    </div>-->
                        </div>
                    </div>
                    <!--                    <div class="panel panel-default">
                    
                                        </div>-->
                <?php } ?>



            </div>
        </div>

        <!--        <div class="row" style="
                     background: #464646;">
                    <div class="col-xl-4" style="
                         padding-top:20px;">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30"><i class="mdi mdi-notification-clear-all m-r-5"></i>comming soon...... </h4>
                           
                        </div>
                    </div> end col 
                    <div class="col-xl-4" style="
                         padding-top:20px;">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30"><i class="mdi mdi-notification-clear-all m-r-5"></i>comming soon...... </h4>
                            
                        </div>
                    </div>
                    <div class="col-xl-4" style="
                         padding-top:20px;">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30"><i class="mdi mdi-notification-clear-all m-r-5"></i>comming soon...... </h4>
                        </div>
                    </div>
                </div>-->
    </div>    
</div>
<?php
$JS = <<<JS
        $(document).ready(function () {
                $('.single-item-cd-a').slick();
                $(".single-item-cd-glr").slick();
            });
        
        $('.carousel').carousel({
  interval: 2000
})
JS;
$this->registerJS($JS);
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