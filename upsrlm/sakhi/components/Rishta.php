<?php

namespace sakhi\components;

use yii;
use cbo\models\CboClfSearch;
use cbo\models\CboVoSearch;
use cbo\models\ShgSearch;
use cbo\models\CboClf;
use cbo\models\CboVo;
use cbo\models\Shg;
use sakhi\components\App;
use common\models\base\GenralModel;
use common\models\User;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiaryBasicEducationPayment;
use common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey;
use bc\modules\transaction\models\summary\BcTrackingBcDateRange;

class Rishta extends \yii\base\Component {

    public $menu = ['left_menu' => [], 'content_menu' => []];
    public $menu_version;
    public $notice1title;
    public $notice1;
    public $notice2;
    public $noticesupport;
    public $content = [];
    public $user_model;
    public $app;
    public $base_url;
    public $icon_base_url;

    public function __construct($user_model) {
        $this->user_model = $user_model;
        $this->app = new \sakhi\components\App();
        $this->base_url = \Yii::$app->params['app_url']['sakhi'];
        $this->icon_base_url = \Yii::$app->params['app_url']['www'];
    }

    public function rishta_menu() {
        $user_model = $this->user_model;
        $app = new \sakhi\components\App();
        $base_url = \Yii::$app->params['app_url']['sakhi'];
        $menu_array = ['intro_text' => '', 'page_title' => '', 'menu_item' => []]; //'clf' => [], 'vo' => [], 'shg' => [], 'bc' => []];
        $childclf = [];
        $searchModelclf = new CboClfSearch();
        $dataProviderclf = $searchModelclf->search([], $user_model, \Yii::$app->params['page_size30']);
        $group1_order = 100;
        $group2_order = 200;
        $group3_order = 300;
        $group4_order = 400;
        $group5_order = 500;
        $group6_order = 600;
        $group7_order = 700;
        $group8_order = 800;
        $group9_order = 900;
        $group10_order = 1000;
        $menu_array['intro_text'] = '';
        $menu_array['page_title'] = 'Rishta';
        $dataProviderclf->query->count();
        if ($dataProviderclf->query->count() > 0) {
            $temp1 = ['orders' => $group1_order, 'title' => 'क्लस्टर स्तरीय संकुल', 'sub_title' => 'CLF', 'menu_type' => 2, 'url' => '#', 'webview' => false, 'gps' => false, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/clf.png', 'has_child' => true, 'botton_color' => GenralModel::APP_CLF_BG_COLOR, 'child' => ['intro_text' => '', 'page_title' => '', 'menu_item' => []]];
            $temp1['child']['intro_text'] = "क्लस्टर स्तरीय संकुल सूची";
            $temp1['child']['page_title'] = "क्लस्टर स्तरीय संकुल सूची";
        }
        foreach ($dataProviderclf->getModels() as $key => $clf) {
            $child1 = ['id' => $clf->id, 'orders' => $group1_order, 'title' => 'क्लस्टर स्तरीय संकुल', 'sub_title' => $clf->name_of_clf, 'menu_type' => 3, 'url' => '#', 'webview' => false, 'gps' => false, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/clf.png', 'has_child' => true, 'botton_color' => GenralModel::APP_CLF_BG_COLOR, 'child' => ['intro_text' => '', 'page_title' => '', 'menu_item' => []]];
            $child1['child']['intro_text'] = "clf";
            $child1['child']['page_title'] = "CLF List";
            $child1['child']['menu_item'] = [];
            array_push($child1['child']['menu_item'], ['orders' => ($group1_order + 1), 'title' => 'संकुल/ CLF का विवरण', 'sub_title' => $clf->name_of_clf, 'menu_type' => 3, 'url' => $base_url . '/rest/clf?clfid=' . $clf->id . '&url=' . '/clf/default/view?clfid=' . $clf->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/clf.png', 'has_child' => false, 'botton_color' => GenralModel::APP_CLF_BG_COLOR]);
            array_push($child1['child']['menu_item'], ['orders' => ($group1_order + 2), 'title' => 'पदाधिकारीयों एवं सदस्यों का विवरण', 'sub_title' => $clf->name_of_clf, 'menu_type' => 3, 'url' => $base_url . '/rest/clf?clfid=' . $clf->id . '&url=' . '/clf/default/memberlist?clfid=' . $clf->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/mem-list.png', 'has_child' => false, 'botton_color' => GenralModel::APP_CLF_BG_COLOR]);
            array_push($child1['child']['menu_item'], ['orders' => ($group1_order + 3), 'title' => 'धन प्राप्ति का विवरण', 'sub_title' => $clf->name_of_clf, 'menu_type' => 3, 'url' => $base_url . '/rest/clf?clfid=' . $clf->id . '&url=' . '/clf/default/fundsrecived?clfid=' . $clf->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png', 'has_child' => false, 'botton_color' => GenralModel::APP_CLF_BG_COLOR]);
            array_push($child1['child']['menu_item'], ['orders' => ($group1_order + 4), 'title' => 'फ़ीड्बैक', 'sub_title' => $clf->name_of_clf, 'menu_type' => 3, 'url' => $base_url . '/rest/clf?clfid=' . $clf->id . '&url=' . '/clf/default/feedback?clfid=' . $clf->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'visible' => 1, 'gps' => true, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_CLF_BG_COLOR]);
            array_push($child1['child']['menu_item'], ['orders' => ($group1_order + 5), 'title' => 'सम्बद्ध ग्राम संगठन', 'sub_title' => $clf->name_of_clf, 'menu_type' => 3, 'url' => $base_url . '/rest/clf?clfid=' . $clf->id . '&url=' . '/clf/default/addvo?clfid=' . $clf->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/add.png', 'has_child' => false, 'botton_color' => GenralModel::APP_CLF_BG_COLOR]);
            array_push($child1['child']['menu_item'], ['orders' => ($group1_order + 6), 'title' => 'ग्राम संगठन के साथ ऋण लेनदेन', 'sub_title' => $clf->name_of_clf, 'menu_type' => 3, 'url' => $base_url . '/rest/clf?clfid=' . $clf->id . '&url=' . '/clf/default/fundsvo?clfid=' . $clf->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/vo-funds.png', 'has_child' => false, 'botton_color' => GenralModel::APP_CLF_BG_COLOR]);

            array_push($temp1['child']['menu_item'], $child1);
        }
        if ($dataProviderclf->query->count() > 0) {
            array_push($menu_array['menu_item'], $temp1);
        }

        $searchModelvo = new CboVoSearch();

        $dataProvidervo = $searchModelvo->search([], $user_model, \Yii::$app->params['page_size30']);

        $cbo_member = \common\models\CboMembers::find()->where(['user_id' => $user_model->id, 'suggest_wada_sakhi' => 1])->one();
        $childshg = [];
        $searchModelshg = new ShgSearch();

        $dataProvidershg = $searchModelshg->search([], $user_model, \Yii::$app->params['page_size30']);
        if ($dataProvidershg->query->count() > 0) {
            $temp3 = ['orders' => $group3_order, 'title' => 'SHG', 'sub_title' => 'Self Help Group', 'menu_type' => 2, 'url' => '#', 'webview' => false, 'gps' => false, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/shg.png', 'has_child' => true, 'botton_color' => GenralModel::APP_VO_BG_COLOR, 'child' => ['intro_text' => '', 'page_title' => '', 'menu_item' => []]];
            $temp3['child']['page_title'] = "स्वयं सहायता समूह सूची";
            $temp3['child']['intro_text'] = "स्वयं सहायता समूह सूची";
        }
        if ($dataProvidershg->query->count() > 0) {
            foreach ($dataProvidershg->getModels() as $key => $shg) {
                $child3 = ['orders' => $group3_order, 'title' => 'SHG', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => '#', 'webview' => false, 'gps' => false, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/shg.png', 'has_child' => true, 'botton_color' => GenralModel::APP_SHG_BG_COLOR, 'child' => ['intro_text' => '', 'page_title' => '', 'menu_item' => []]];
                $child3['child']['page_title'] = $shg->name_of_shg;
                $child3['child']['intro_text'] = $this->getIntrotext($shg);
                $child3['child']['menu_item'] = [];
                ///array_push($temp3['child'], $child3);
                if ($app->checkAccess('shg', $user_model, '/shg/feedback/form', ['shgid' => $shg->id])) {
                    array_push($child3['child']['menu_item'], ['orders' => ($group3_order + 1), 'title' => 'SHG फ़ीड्बैक', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => $base_url . '/rest/shg?shgid=' . $shg->id . '&url=' . '/shg/feedback/form?shgid=' . $shg->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'visible' => 1, 'gps' => true, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_SHG_BG_COLOR]);
                }
                if ($app->checkAccess('shg', $user_model, '/shg/profile/index', ['shgid' => $shg->id])) {
                    array_push($child3['child']['menu_item'], ['orders' => ($group3_order + 2), 'title' => 'SHG का विवरण', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => $base_url . '/rest/shg?shgid=' . $shg->id . '&url=' . '/shg/profile/index?shgid=' . $shg->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/shg.png', 'has_child' => false, 'botton_color' => GenralModel::APP_SHG_BG_COLOR]);
                }
                if ($app->checkAccess('shg', $user_model, '/shg/bankaccount/index', ['shgid' => $shg->id])) {
                    array_push($child3['child']['menu_item'], ['orders' => ($group3_order + 3), 'title' => 'SHG बैंक खाता विवरण', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => $base_url . '/rest/shg?shgid=' . $shg->id . '&url=' . '/shg/bankaccount/index?shgid=' . $shg->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/bank-account.png', 'has_child' => false, 'botton_color' => GenralModel::APP_SHG_BG_COLOR]);
                }
                if ($app->checkAccess('shg', $user_model, '/shg/member/index', ['shgid' => $shg->id])) {
                    array_push($child3['child']['menu_item'], ['orders' => ($group3_order + 4), 'title' => 'SHG पदाधिकारीयों एवं सदस्यों का विवरण', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => $base_url . '/rest/shg?shgid=' . $shg->id . '&url=' . '/shg/member/index?shgid=' . $shg->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/mem-list.png', 'has_child' => false, 'botton_color' => GenralModel::APP_SHG_BG_COLOR]);
                }
                if ($app->checkAccess('shg', $user_model, '/shg/funds/index', ['shgid' => $shg->id])) {
                    array_push($child3['child']['menu_item'], ['orders' => ($group3_order + 5), 'title' => 'SHG धन प्राप्ति का विवरण', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => $base_url . '/rest/shg?shgid=' . $shg->id . '&url=' . '/shg/funds/index?shgid=' . $shg->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png', 'has_child' => false, 'botton_color' => GenralModel::APP_SHG_BG_COLOR]);
                }
                array_push($temp3['child']['menu_item'], $child3);
            }
            if ($dataProvidershg->query->count() > 0) {
                array_push($menu_array['menu_item'], $temp3);
            }
        }
        $childbc = [];
        if (isset($user_model->cboprofile) and $user_model->cboprofile->bc) {
            $bc_trackin = BcTrackingBcDateRange::findOne(['bc_application_id' => $user_model->cboprofile->srlm_bc_application_id]);
            $basic_education = DbtBeneficiaryBasicEducationPayment::find()->where(['gram_panchayat_code' => $user_model->cboprofile->gram_panchayat_code])->exists();
            $bc = \bc\modules\selection\models\SrlmBcApplication::findOne($user_model->cboprofile->srlm_bc_application_id);
            if ($user_model->cboprofile->bc_copy_file_count >= 0) {
                $temp = ['orders' => $group4_order, 'title' => 'बीसी सखी प्रोफाइल', 'sub_title' => $user_model->cboprofile->first_name, 'menu_type' => 2, 'url' => $base_url . '/rest/bc?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&url=' . '/bc/default/view?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/profile.jpg', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
                array_push($menu_array['menu_item'], $temp);
                if (isset($bc) and $bc->training_status == '3' and $bc->bc_unwilling_bank == '1') {
                    $temps = ['orders' => $group4_order, 'title' => 'अनिच्छुक बीसी सखी', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/bc?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&url=' . '/bc/default/unwilling?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/unwilling.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
                    array_push($menu_array['menu_item'], $temps);
                }
                if (isset($bc_trackin)) {

                    $tempb2 = ['orders' => $group4_order + 1, 'title' => 'कार्य करने में आपकी प्रमुख समस्याएँ बतायें (हर 15 दिन में भर सकते है)', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/bc?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&url=' . '/bc/tracking/feedback?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
                    array_push($menu_array['menu_item'], $tempb2);
                }
                $temp1 = ['orders' => ($group4_order + 2), 'title' => 'प्रोफाइल', 'sub_title' => $user_model->name, 'menu_type' => 1, 'url' => $base_url . '/rest/user?userid=' . $user_model->id . '&url=' . '/user/default/view?userid=' . $user_model->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/profile.jpg', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
                array_push($menu_array['menu_item'], $temp1);
            }
            if ($basic_education) {
                $temp11 = ['orders' => $group4_order + 3, 'title' => 'UPSRLM/ राज्य आजीविका मिशन ', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/bc?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&url=' . '/bc/upsrlm/index?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
                array_push($menu_array['menu_item'], $temp11);
                $temp12 = ['orders' => $group4_order + 4, 'title' => 'BOCW/ श्रम विभाग', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/bc?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&url=' . '/bc/bocw/index?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
                array_push($menu_array['menu_item'], $temp12);
                $temp13 = ['orders' => $group4_order + 5, 'title' => 'Basic Education/ शिक्षा', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/bc?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&url=' . '/bc/basiceducation/index?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
                array_push($menu_array['menu_item'], $temp13);
                $temp14 = ['orders' => $group4_order + 6, 'title' => 'MGNREGA/ नरेगा ', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/bc?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&url=' . '/bc/mgnrega/index?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
                array_push($menu_array['menu_item'], $temp14);
                $temp15 = ['orders' => $group4_order + 7, 'title' => 'Agriculture/ कृषि', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/bc?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&url=' . '/bc/agriculture/index?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
                array_push($menu_array['menu_item'], $temp15);
            }
        }
//        $temp2 = ['orders' => ($group4_order + 2), 'title' => 'पिन बदलें', 'sub_title' => $user_model->name, 'menu_type' => 1, 'url' => $base_url . '/rest/user?userid=' . $user_model->id . '&url=' . '/user/default/changepin?userid=' . $user_model->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/profile.jpg', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
//        array_push($menu_array['menu_item'], $temp2);
        if (isset($cbo_member) and $cbo_member->suggest_wada_sakhi) {
            if ($user_model->dummy_column == 1) {
                $temp1 = ['orders' => 0, 'title' => 'समूह सखी आवेदन प्रपत्र', 'sub_title' => $user_model->name, 'menu_type' => 2, 'url' => $base_url . '/rest/shg?shgid=' . $cbo_member->cbo_id . '&url=' . '/shg/application/form?shgid=' . $cbo_member->cbo_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
                // $temp1 = ['orders' => 0, 'title' => 'समूह सखी आवेदन प्रपत्र', 'sub_title' => $user_model->name, 'menu_type' => 2, 'url' => $base_url . '/rest/shg?shgid=' . $cbo_member->cbo_id . '&url=' . '/test/application/form?shgid=' . $cbo_member->cbo_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR]; 
            } else {
                $temp1 = ['orders' => 0, 'title' => 'समूह सखी आवेदन प्रपत्र', 'sub_title' => $user_model->name, 'menu_type' => 2, 'url' => $base_url . '/rest/shg?shgid=' . $cbo_member->cbo_id . '&url=' . '/shg/application/form?shgid=' . $cbo_member->cbo_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
            }
            array_push($menu_array['menu_item'], $temp1);
        }
        if (isset($user_model->cboprofile) and $user_model->cboprofile->wada_sakhi) {
            $temp5 = ['orders' => $group5_order, 'title' => 'प्रशिक्षण', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/page' . '?url=' . '/page/wsstraining/department' . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/wsstraining.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
            array_push($menu_array['menu_item'], $temp5);
        }
        if (isset($user_model->online)) {
            if ($user_model->online == '1') {
                $temp6 = ['orders' => $group6_order, 'title' => 'पूर्व आकलन : हाई स्पीड इंटरनेट परियोजना', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/page' . '?url=' . '/online/fb/form' . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_ONLINE_BG_COLOR];
                array_push($menu_array['menu_item'], $temp6);
            }
        }

//        if (isset($user_model->hhs)) {
//            if ($user_model->hhs == '1') {
//                $hhs_model= NfsaBaseSurvey::findOne(['hhs_user_id'=>$user_model->id]);
//                $temp7 = ['orders' => $group7_order, 'title' => 'Hhs प्रोफाइल', 'sub_title' => $hhs_model->name_of_head_of_household, 'menu_type' => 2, 'url' => $base_url . '/rest/hhs?hhsid=' . $hhs_model->id . '&url=' . '/hhs/default/view?hhsid=' . $hhs_model->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/profile.jpg', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
//                array_push($menu_array['menu_item'], $temp7);
//            }
//        }
//        if ($user_model->dummy_column == 1) {
//            $temp6 = ['orders' => $group6_order, 'title' => 'पूर्व आकलन : हाई स्पीड इंटरनेट परियोजना', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/page' . '?url=' . '/online/fb/form' . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_ONLINE_BG_COLOR];
//            array_push($menu_array['menu_item'], $temp6);
////            $temp7 = ['orders' => $group6_order, 'title' => 'पोस्ट मूल्यांकन  : हाई स्पीड इंटरनेट परियोजना', 'sub_title' => '', 'menu_type' => 2, 'url' => $base_url . '/rest/page' . '?url=' . '/online/fb/postassessment' . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_ONLINE_BG_COLOR];
////            array_push($menu_array['menu_item'], $temp7);
//        }
        return $menu_array;
    }

    public function splash_screen($model) {
        $splash_screen = 0;

        return $splash_screen;
    }

    public function splash_screen_value($model) {
        $splash_screen_value = null;

        return $splash_screen_value;
    }

    public function notice1_title() {
        $this->notice1title = '';
        $this->notice1title = "समूह के यूज़र के लिए दिशा निर्देश";
        if (isset($this->user_model->online)) {
            if ($this->user_model->online == '1') {
                $this->notice1title = 'यूज़र के लिए दिशा निर्देश ';
            }
        }
        return $this->notice1title;
    }

    public function notice1() {

        $this->notice1 = "<p style='text-align: justify;text-justify: inter-word;'>यह मोबाइल ऐप उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन से जुडी हुई हैं सभी स्वयं सहायता समूह (SHG), ग्राम संगठन (VO) एवं क्लस्टर स्तरीय संकुल (CLF) के संस्थागत कार्य, वित्तीय लेन देन एवं उनके बही खाते की सुविधा के लिए प्रस्तावित है । इस ऐप में आगे बढ़ने से पहले निम्न बिन्दूओं का संज्ञान लें –</p>
  <p style='text-align: justify;text-justify: inter-word;'>  1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा । </p>
   <p style='text-align: justify;text-justify: inter-word;'> 2. इस ऐप द्वारा सृजित सभी सूचना आपके मोबाइल फ़ोन पर पासवर्ड द्वारा सुरक्षित रहेगा ।</p> 
   <p style='text-align: justify;text-justify: inter-word;'> 3. समूहों द्वारा ऐप में दी गयी फ़ीड्बैक भरा जाना आवश्यक है ।</p>
   <p style='text-align: justify;text-justify: inter-word;'> 4. सभी सूचनाओं के अंत में सुधार/ एडिट करने के लिए बटन का इस्तेमाल कर सकते हैं । नया आइटम जोड़ने के लिए + का संकेत उपयोग करें । ये आवश्यक है कि सूचनाएँ सही भरी जाएँ  एवं बार बार बदला ना जाए ।</p>
   <p style='text-align: justify;text-justify: inter-word;'> 5. ऐप में भरे गए सूचनाएँ मिशन के हर स्तर पर पढ़ी जा सकेगी ।</p>
   <p style='text-align: justify;text-justify: inter-word;'> 6. असुविधा होने पर या अधिक जानकारी के लिए हेल्प लाइन नम्बर 9070804050 पर फ़ोन करें ।</p>";
        if (isset($this->user_model->online)) {
            if ($this->user_model->online == '1') {
                $this->notice1 = "<div>
      स्मार्टफ़ोन ने ग्रामीण क्षेत्रों में भी इंटरनेट ज़रूरत तथा प्रामाणिकता को जन जन तक पहुँचाया है । पर सभी को जानकारी है, ग्रामीण क्षेत्रों में कमज़ोर इंटरनेट के कारण स्मार्टफ़ोन से होने वाले कई सेवाएँ जैसे कि ह्वाट्सऐप या यूट्यूब, जिस तरह शहरों में स्वचालित महसूस होती है, ग्रामीण क्षेत्र में उतनी नहीं । विशेषकर वीडियो से चलने वाली सभी सेवाएँ, ग्रामीण क्षेत्र में अच्छी गुणवत्ता के साथ नहीं हो पाती है । इस लिये शहरी क्षेत्रों में जो आर्थिक रूप से संपन्न, सामान्य या गरीब परिवार रहतें हैं, उन्हें एक सामान्य स्मार्टफ़ोन के माध्यम से कम खर्चे में, बिना किसी भेदभाव के एक समान सेवाएँ और सुविधाएँ मिलती है । शहरों में हाई स्पीड इंटरनेट के कारण स्मार्टफ़ोन में क्या क्या सुविधाएँ प्राप्त होती हैं, और जो ग्रामीण क्षेत्रों में उपलब्ध नहीं होती है, वे निम्नवत् हैं:   
    <ol>
        <li>1. ई-शिक्षा: स्कूलों पढ़नेवाले बच्चे घर में भी मोबाइल का माध्यम से पढ़ाई कर सकते है;</li>   
        <li>2. ई-स्वास्थ्य/ टेली मेडिसिन: मोबाइल ऐप के सहायता से कोई भी मरीज़ डॉक्टरों से वीडियो-माध्यम से देख व बात कर सकेंगे</li>  
        <li>3. ई-कृषि/ Agri-tech: मौसम के पूर्वानुमान से लेकर कृषि उत्पादों के बाज़ार भाव, मिट्टी की जाँच तथा फसल के स्वास्थ्य व गुणवत्ता संबंधी ढेरों सेवाएँ किसानों को स्मार्टफ़ोन आधारित ऐप से निःशुल्क या बहुत कम खर्चें में उपलब्ध हो सकता है ।</li> 
        <li>4. ई-वित्तीय सेवा (ई-बैंकिंग, ऋण, ई-कॉमर्स इत्यादि):जैसा आज कल बीसी सखी कार्यक्रम के अन्तर्गत हर गाँव में बीसी सखी अपने हस्तचालित माइक्रो-एटीएम मशीन से सभी ग्रामीणों को निर्बाध रूप से बैंकिंग सेवाएँ दे रही हैं, उसी तरह सभी तरह के वित्तीय एवं भुगतान की सेवाएँ स्मार्टफ़ोन के माध्यम से संपन्न की जा सकेगी ।</li>
        <li>5. ई-सरकारी सेवा/ e-gov services: ड्राइविंग लाइसेंस, जन्म, विवाह तथा मृत्यु प्रमाण पत्र, राशन कार्ड, पैन कार्ड, वोटर कार्ड, आधार कार्ड में सुधार/ अपडेट करने संबंधी कई कार्य आसानी से स्मार्टफ़ोन के माध्यम से घर बैठे ही संपन्न किया जा सकेगा</li>
        <li>6. OTT सेवा/ यूट्यूब, मनोरंजन: अंततः अनेकों ग्रामीण परिवार अपने बचे हुए समय में मनोरंजक कार्यक्रम देखना चाहेंगे जो कि स्मार्टफ़ोन या टेलीविज़न के माध्यम से आसानी से संभव हो पाएगा</li>
        
    </ol>
    </div>
    <div>हाई स्पीड इंटरनेट के कारण आज दुनिया भर में विकास की, आर्थिक समृद्धि की तथा सामाजिक परिवर्तन की गति तेज हुई है। पहले जो काम महीनों या सालों में संभव हुया करता था, आज वे सभी काम तेज़ी से, दिनों में और कई कार्य तो घंटों में संभव हो जाता है । इस ऐप के माध्यम से पंचायती राज विभाग, उत्तर प्रदेश सरकार ने आपसे ये समझने की कोशिश की है कि इन विषों विषयों पर आपके क्या विचार है। आपसे ये अपेक्षा है कि आप सोच समझ कर, समय लेकर सभी सवालों पर सही तथा प्रामाणिक उत्तर चुने</div>";
            }
        }

        return $this->notice1;
    }

    public function notice2() {
        $this->notice2 = '';
        $this->notice2 .= "<p style='text-align: justify;text-justify: inter-word;'> 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा  6. असुविधा होने पर या अधिक जानकारी के लिए हेल्प लाइन नम्बर 9070804050 पर फ़ोन करें ।</p>";
        return $this->notice2;
    }

    public function noticesupport() {
        $this->noticesupport = '';

        $this->noticesupport = "<p style='text-align: justify;text-justify: inter-word;'> किसी भी सम्बंधित जानकारी के लिए में रिश्ता कॉल सेंटर : 0522-2724611 में कॉल करें।</p>";

        return $this->noticesupport;
    }

    public function getIntrotext($model = null) {
        $html = '';

        $html = '<p> 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा  6. असुविधा होने पर या अधिक जानकारी के लिए हेल्प लाइन नम्बर 9070804050 पर फ़ोन करें ।</p>';

        return $html;
    }
}
