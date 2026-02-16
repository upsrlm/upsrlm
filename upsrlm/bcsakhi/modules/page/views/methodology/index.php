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

$this->title = 'Theory of Change';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1><?= $this->title ?></h1>
      </div>
    </div>
  </div>
</div>
<div style="min-height: 730px">
  <div class="container-fluid px-3 px-lg-5 py-3">
    <div class="row ">
      <div class="col-xl-6">
        <div class="text-theory">
          <p>Limitations illustrated in the first 30 months of operations of UP BC Sakhi program have been are those that could not be envisaged its commencement in 2020. The primary ambition of the program 1.0 was to erect a techno-human apparatus that could start working amongst the rural poorest segment adhering to existing banking systems. The banking system that prevailed was of fintech-led inter-operable UPI system blending the conventional operating approach of sub-service area (SSA1). The SSA is a centre-based approach and expect the centre (a physically equipped bank branch) to be the hub and mainstay of all banking operations _ business related or otherwise. </p>
          <p>The Service Area Approach (SAA) introduced in April 1989, in order to bring about an orderly and planned development of rural and semi- urban areas of the country, was extended to all Indian scheduled commercial banks including Regional Rural Banks (RRBs), vide our Circular letter RPCD.No.LBS.BC.87/65-87/88 dated 14.3.1988. Under the SAA, all rural and semi-urban branches of banks were allocated specific villages, generally in geographical contiguous areas, the overall development and the credit needs of which were to be taken care of by the respective branches.</p>
        </div>
      </div>
      <div class="col-xl-6">
        <img src="/images/OrangeMinimalist-Column-Process.png" alt="" class="w-100">
      </div>
    </div>
    <div class="row pt-3">
      <div class="col-12">
        <div class="thoery table-responsive">
          <table class="table border go-table table-striped">
            <thead class="thoery-head">
              <tr>
                <th>Limitations</th>
                <th style="width: 60%;">How these are impacting outcomes</th>

              </tr>
            </thead>
            <tbody>
              <tr>
                <td> 1) Lack of finances/ working capital
                </td>
                <td>BCs have been endowed with a working capital of Rs. 75,000/-, of which only 25,000/- is towards OD-based liquidity. It is experienced that, with the given commission rates by 6 Banking partners, for one full cycle utilization of the OD amount daily, helps generating a Commission earning of Rs. 3,000/- per month. The BC Sakhis apparatus is aimed to support underbanked customers who carry out low-ticket transactions.
                <div class="detaisl">
                    <p>As assessed, a financial input of Rs. 1 lakh to Rs. 2 lakh could be adequate for the BC Sakhis to (a) achieve operational viability & (b) optimize customer coverage</p>
                  </div>
                </td>
              </tr>
              <tr>
                <td> 2) BC Sakhis unaware of its clientele</td>
                <td>BC Sakhis have a latent clientele in form of a host of DBT beneficiaries. An estimate suggests, each GP of Uttar Pradesh could constitute number of DBT beneficiaries ranging between 300-500. A monthly realization of one to two cycles of banking transactions by the beneficiaries could yield BC Sakhi commission earning of more than Rs. 10 thousands/ month. 
                  <div class="detaisl">
                    <p>DBT-Beneficiaries details syncing with BC Sakhi mobile app would resolve the issue</p>
                  </div>
                </td>
              </tr>
              <tr>
                <td> 3) Widening technology gap</td>
                <td>Intense implementation, pressure of progress and performance, met with range of dimensions around which awareness raising, capacity building and handholding are necessary. Technology gap is resulting slow and disjointed capacity building of the end-users. Also, it is causing lack of measurement of progress. Prevalent market-advantages, state-aided leverages are not getting shifted to the BC Sakhis. Technology-development has slowed down due to lack of insights flowing into decision making and vision. 

                  <div class="detaisl">
                    <p>Technology monetization would help incentive the technology-front to remain on toes and consistently attempt find and bridge technology gaps. Perspective behind such attempts would be top-notch customer service & value-addition in its income earning.</p>
                  </div>
                </td>
              </tr>
              <tr>
                <td> 4) Under-utilizing existing program-organs</td>
                <td>BC Sakhi program has consistently been linear in its focus and ignored value of existing partnerships thereby optimizing role & engagement. RSETI’s as partners involved in training of the BC Sakhis could add critical value in program performance, strengthening operational roots and aid eliciting key performance-intel. Leveraging RSETIs is an opportunity going forward.

                  <div class="detaisl">
                    <p>RSETIs’ mandate on BC’ post-training following & operational handholding would be unpacked to digitize with simple pedagogically-suited front-end.</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="py-3">The program seeks a leap jump into next leg. By bridging the limitations observed in the 1.0 version and illustrate a conceptual model for next 24-30 months. The conceptual model for BC Sakhi program 2.0 is indicatively illustrated in the next section.</p>
      </div>
    </div>
  </div>
</div>