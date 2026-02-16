<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
//common\assets\FioriSrlmAsset::register($this);
$this->title = 'Contact Us';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="page-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1><?=$this->title?></h1>
          </div>
        </div>
      </div>
    </div>
    <div style="min-height:630px">
    <div class="contact-information">
        <div class="container-fluid px-lg-5 px-3">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="contact-item">
                        <i class="fa fa-whatsapp"></i>
                        <h4>Whatsapp</h4>
                        <a href="https://wa.me/7766883328" target="_blank">(91) 77 66 88 33 28</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-item">
                        <i class="fa fa-envelope"></i>
                        <h4>Email</h4>
                        <a href="mailto:mail@upsrlm.org">mail@upsrlm.org</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- <address>
        <div class="col-md-12 h3 mt-2">    
            Contact
        </div>
        <div class="col-md-12 h3">       
            Email: <a href="mailto:mail@bcsakhi.org">mail@bcsakhi.org</a>
        </div>
        <div class="col-md-12 h3">   

            WhatsApp: <a href="https://wa.me/7766883328" target="_blank">(91) 77 66 88 33 28</a>
        </div>
    </address>     -->
</div>

