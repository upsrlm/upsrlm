<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\assets\SmartAdminAppAsset;
use yii\widgets\Breadcrumbs;
use kartik\widgets\AlertBlock;
use yii\helpers\ArrayHelper;

$arg = explode('/', Yii::$app->request->url);
$url = Yii::$app->request->url;
?>
<header class="">
  <nav class="navbar navbar-expand-xl">
    <div class="container-fluid px-3 px-lg-5">
      <a class="navbar-brand p-0" href="/">
        <h2 class="d-sm-block d-none">Banking Correspondent (BC) Sakhi</h2>
        <h2 class="d-sm-none">BC Sakhi</h2>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item <?= in_array($url, ['/']) ? 'active' : '' ?>">
            <a class="nav-link <?= in_array($url, ['/', '/page/home']) ? 'active' : '' ?>" href="/">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
<!--          <li class="nav-item <?= in_array($url, ['/page/collaboration/index', '/page/collaboration']) ? 'active' : '' ?>"> <a class="nav-link " href="/page/collaboration">Collaboration</a> </li>
          <li class="nav-item <?= in_array($url, ['/page/programlearning/index', '/page/programlearning']) ? 'active' : '' ?>">
            <a class="nav-link " href="/page/programlearning">Program Learning</a>
          </li>-->
          <li class="nav-item <?= in_array($url, ['/page/timeline/index', '/page/timeline']) ? 'active' : '' ?>">
            <a class="nav-link" href="/page/timeline">Timeline</a>
          </li>
          <li class="nav-item <?= in_array($url, ['/page/methodology/index', '/page/methodology']) ? 'active' : '' ?>">
            <a class="nav-link " href="/page/methodology">Theory of Change</a>
          </li>

          <li class="nav-item <?= in_array($url, ['/page/technology/index', '/page/technology']) ? 'active' : '' ?>"> <a class="nav-link " href="/page/technology">Technology</a> </li>
          <li class="nav-item <?= in_array($url, ['/page/go/index', '/page/go']) ? 'active' : '' ?>"> <a class="nav-link " href="/page/go">Government Orders</a> </li>
          <li class="nav-item <?= in_array($url, ['/page/contact/index', '/page/contact']) ? 'active' : '' ?>"> <a class="nav-link " href="/page/contact">Contact Us</a> </li>
          <!-- <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact Us</a>
              </li> -->
        </ul>
      </div>
    </div>
  </nav>
</header>
