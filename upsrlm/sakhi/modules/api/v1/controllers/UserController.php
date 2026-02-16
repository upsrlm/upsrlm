<?php

namespace sakhi\modules\api\v1\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Expression;
use yii\web\Controller;
use common\models\AppDetail;
use common\models\ApiLog;
use common\models\master\MasterBlock;
use common\models\master\MasterGramPanchayat;
use common\models\base\GenralModel;
use common\models\User;
use cbo\models\CboClfSearch;
use cbo\models\CboVoSearch;
use cbo\models\ShgSearch;
use cbo\models\CboClf;
use cbo\models\CboVo;
use cbo\models\Shg;

/**
 * User controller for the `api` module
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UserController extends Controller {

    protected $finder;
    private $custom_response = [];
    private $post_json;
    private $data_json;
    public $app_id;
    public $imei_no;
    public $current_module;
    public $fix_otp = "000000";
    public $test_user = [];
    public $test_mode = true;

    public function beforeAction($event) {
        $this->current_module = \Yii::$app->controller->module;
        $this->post_json = $this->current_module->post_json;
        $this->data_json = $this->current_module->data_json;
        $this->custom_response['status'] = "1";
        $this->custom_response['message'] = "Success";

        return parent::beforeAction($event);
    }

    public function actionBeforelogindata() {
        $this->custom_response['splash_background_url'] = \Yii::$app->params['app_url']['www'] . '/images/app/splash_background.v2.png';
        $this->custom_response['splash_background_640_480_url'] = \Yii::$app->params['app_url']['www'] . '/images/app/splash_background_640_480.png';
        $this->custom_response['splash_background_960_720_url'] = \Yii::$app->params['app_url']['www'] . '/images/app/splash_background_960_720.png';
        $this->custom_response['splash_background_470_320_url'] = \Yii::$app->params['app_url']['www'] . '/images/app/splash_background_470_320.png';
        $this->custom_response['splash_background_426_320_url'] = \Yii::$app->params['app_url']['www'] . '/images/app/splash_background_426_320.png';
        $this->custom_response['login_background_url'] = \Yii::$app->params['app_url']['www'] . '/images/app/login_background.v3.png';
        $this->custom_response['login_background_640_480_url'] = \Yii::$app->params['app_url']['www'] . '/images/app/login_background_640_480.png';
        $this->custom_response['login_background_960_720_url'] = \Yii::$app->params['app_url']['www'] . '/images/app/login_background_960_720.png';
        $this->custom_response['login_background_470_320_url'] = \Yii::$app->params['app_url']['www'] . '/images/app/login_background_470_320.png';
        $this->custom_response['login_background_426_320_url'] = \Yii::$app->params['app_url']['www'] . '/images/app/login_background_426_320.png';
        $this->custom_response['login_username_title'] = 'मोबाइल नंबर ';
        $this->custom_response['login_otp_title'] = 'पिन';
        $this->custom_response['login_button_title'] = 'लॉगिन';
        $this->custom_response['login_info1'] = $this->logininfo1();
        $this->custom_response['login_info2'] = $this->logininfo2();
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function logininfo1() {
        $html = '';
        $html = '<p> डिजिटल निजता एवं सुरक्षा के दृष्टिगत, पोर्टल के द्वारा
Rista मोबाइल ऐप के पासवर्ड स्वतः बदलने का समय हो
गया है । रिश्ता ऐप के ब्लॉक हो जाने के स्थिति में आप का
पिन नम्बर स्वतः सृजित हो जाएगा, जिसे आप "रिश्ता कॉल
सेंटर" (लाइन नम्बर 9070804050 , 9070804060, सुबह 7 बजे से
शाम 7 बजे के बीच) पर फ़ोन कर अपना PIN नम्बर प्राप्त
कर लें । PIN नम्बर मोबाइल ऐप पर डालने से रिश्ता ऐप
पुनः सक्रिय हो जाएगा।</p>';

        return $html;
    }

    public function logininfo2() {
        $html = '';
        $html = "<i></i>";

        return $html;
    }

    public function actionLogin() {
        $this->processLogin();
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionUpdategoogletoken() {
        $user = \Yii::$app->user->identity;
        $active_app = AppDetail::findOne($this->current_module->model_apilog->app_id);
        $active_app->firebase_token = $this->data_json['firebase_token'];
        if ($active_app->save()) {
            
        } else {
            $this->custom_response['status'] = "0";
            $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($active_app) . "}";
        }
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    private function processLogin() {
//        print_r($this->data_json);exit;
        if (isset($this->data_json['username']) and isset($this->data_json['otp'])) {
            $model = new \common\models\LoginForm();
            $model->login_type = \common\models\LoginForm::LOGIN_ONLY_OTP;
            $model->username_otp = $this->data_json['username'];
            $model->otp = $this->data_json['otp'];
            $model->scenario = 'login_otp_step2';
            if ($model->validate() and $model->login()) {

                $member_app = AppDetail::find()->where(['user_id' => \Yii::$app->user->identity->id, 'status' => 1])->all();
                if (!empty($member_app)) {
                    AppDetail::updateAll(['date_of_uninstall' => new Expression('NOW()'), 'status' => 0], 'user_id ="' . \Yii::$app->user->identity->id . '" and status=' . '1');
                    $this->processLoginIntoDb(TRUE);
                } else {
                    $this->processLoginIntoDb();
                }
            } else {
                $this->custom_response['status'] = "0";
                $this->custom_response['message'] = "क्षमा करें, आपने गलत मोबाइल नंबर या पिन डाला है। पुनः प्रयास करें ";
                throw new \yii\web\UnauthorizedHttpException("Invalid login or pin"); // HTTP code 401
            }
        } else {
            throw new \yii\web\BadRequestHttpException("Bad Request, login or pin missing"); // HTTP COde 400
        }
    }

    private function processLoginIntoDb($confirm_overwrite = FALSE) {

        $base_url = \Yii::$app->params['app_url']['sakhi'];
        $user_model = \Yii::$app->user->identity;
        $rishta = new \sakhi\components\Rishta($user_model);
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();
        $token = $jwt->getBuilder()
                ->issuedBy(\Yii::$app->params['app_url']['sakhi'])// Configures the issuer (iss claim)
                ->permittedFor(\Yii::$app->params['app_url']['sakhi'])// Configures the audience (aud claim)
                ->identifiedBy('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
                ->issuedAt($time)// Configures the time that the token was issue (iat claim)
//                ->expiresAt($time + 3600)
                ->withClaim('uid', \Yii::$app->user->identity->id)// Configures a new claim, called "uid"
                ->getToken($signer, $key); // Retrieves the generated token
        $this->custom_response['status'] = "1";
        $member_app_model = new AppDetail();
        $member_app_model->user_id = \Yii::$app->user->identity->id;
        $member_app_model->token = (string) $token;
        $member_app_model->imei_no = $this->data_json['imei_no'];
        $member_app_model->os_type = $this->data_json['os_type'];
        $member_app_model->manufacturer_name = $this->data_json['manufacturer_name'];
        $member_app_model->os_version = $this->data_json['os_version'];
        $member_app_model->app_version = $this->data_json['app_version'];
        $member_app_model->firebase_token = $this->data_json['firebase_token'];
        $member_app_model->date_of_install = new Expression('NOW()');

        if ($member_app_model->save()) {
            if (isset($this->data_json['app_version'])) {
                $user_model->app_version = $this->data_json['app_version'];
            }
            $this->custom_response['message'] = "success, request processed successfully";
            $this->custom_response['token'] = $member_app_model->token;
            $this->custom_response['app_id'] = $member_app_model->id;
            $this->custom_response['user_id'] = $member_app_model->user_id;
            $this->custom_response['user_name'] = \Yii::$app->user->identity->name;
            $this->custom_response['mobile_no'] = \Yii::$app->user->identity->mobile_no;
            $this->custom_response['support_url'] = $base_url . '/rest/page?url=/page/help/support'; //\Yii::$app->params['app_url']['sakhi'] . '/page/help/support';
            $this->custom_response['notice1_title'] = $rishta->notice1_title();
            $this->custom_response['notice1'] = $rishta->notice1();
            $this->custom_response['splash_screen'] = \Yii::$app->user->identity->splash_screen;
//            if (\Yii::$app->user->identity->dummy_column) {

            $this->custom_response['splash_screen_value'] = isset(\Yii::$app->user->identity->rishtauserdata) ? \Yii::$app->user->identity->rishtauserdata->splash_screen_value : "";
            $this->custom_response['menu_version'] = \Yii::$app->user->identity->menu_version;
            if ($user_model->hhs == 1) {
                $this->custom_response['cbo_menu'] = $rishta->rishta_menu();
            } else {
                if ($user_model->dummy_column == 1) {
                    $this->custom_response['cbo_menu'] = $rishta->rishta_menu();
                } else {
                    $this->custom_response['cbo_menu'] = isset(\Yii::$app->user->identity->rishtauserdata) ? json_decode(\Yii::$app->user->identity->rishtauserdata->menu_json, true) : [];
                }
            }
//            } else {
//                $this->custom_response['menu_version'] = $this->getCbomenuversion();
//                $this->custom_response['cbo_menu'] = $this->getCbomenu();
//            }
            $this->custom_response['acknowledge_text'] = 'मैंने उपरोक्त दिशा-निर्देशों को पढ़ लिया है और मैं उनसे सहमत हूं।';
            $this->custom_response['profile_photo_url'] = '';
            if (isset($user_model->cboprofile) and $user_model->cboprofile->profile_photo) {
                $this->custom_response['profile_photo_url'] = $base_url . '/rest/image?userid=' . $user_model->id . '&photo=profile_photo'; //\Yii::$app->params['app_url']['sakhi'] . '/page/help/support';;
            }
            $this->custom_response['last_notificationid'] = $this->getLastnotificationid();
            $this->custom_response['get_notification_url'] = \Yii::$app->params['app_url']['sakhi'] . '/rest/getnotification';
            $user_model->firebase_token = $member_app_model->firebase_token;

            $user_model->app_id = $member_app_model->id;
            $user_model->last_access_time = date('Y-m-d H:i:s');
            $user_model->user_app_data_update = 0;
            $user_model->update();
        } else {
            throw new \yii\web\ServerErrorHttpException("App registartion error : " . json_encode($member_app_model->getErrors()));
        }
    }

    public function getCbo() {
        $cbo_array = ['clf' => [], 'vo' => [], 'shg' => [], 'bc' => []];

        $searchModelclf = new CboClfSearch();
        $dataProviderclf = $searchModelclf->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $searchModelvo = new CboVoSearch();
        $dataProvidervo = $searchModelvo->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModelshg = new ShgSearch();
        $dataProvidershg = $searchModelshg->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $cbo_array['clf'] = ArrayHelper::toArray($dataProviderclf->getModels(), [
                    'cbo\models\CboClf' => [
                        'id',
                        'name_of_clf',
                        'nrlm_clf_code',
                        'date_of_formation',
                        'district_name',
                        'block_name'
                    ],
        ]);
        $cbo_array['vo'] = ArrayHelper::toArray($dataProvidervo->getModels(), [
                    'cbo\models\CboVo' => [
                        'id',
                        'name_of_vo',
                        'nrlm_vo_code',
                        'date_of_formation',
                        'district_name',
                        'block_name',
                        'gram_panchayat_name'
                    ],
        ]);
        $cbo_array['shg'] = ArrayHelper::toArray($dataProvidershg->getModels(), [
                    'cbo\models\Shg' => [
                        'id',
                        'name_of_shg',
                        'shg_code',
                        'district_name',
                        'block_name',
                        'gram_panchayat_name',
                        'village_name',
                        'hamlet',
                    ],
        ]);
        return $cbo_array;
    }

    public function getCbomenu() {
        $user_model = User::findOne(Yii::$app->user->identity->id);
        $app = new \sakhi\components\App();
        $base_url = \Yii::$app->params['app_url']['sakhi'];
        $menu_array = ['intro_text' => '', 'page_title' => '', 'menu_item' => []]; //'clf' => [], 'vo' => [], 'shg' => [], 'bc' => []];
        $childclf = [];
        $searchModelclf = new CboClfSearch();
        if (in_array(Yii::$app->user->identity->username, ['9000000001', '9000000004', '9000000114', '9000000224', '9200000003'])) {
            $searchModelclf->id = [876, 877];
        }
        $dataProviderclf = $searchModelclf->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30']);
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
        if (in_array(Yii::$app->user->identity->username, ['9000000001', '9000000004', '9000000114', '9000000224', '9200000003'])) {
            $searchModelvo->id = [14689, 14690];
        }
        $dataProvidervo = $searchModelvo->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        if ($dataProvidervo->query->count() > 0) {
//            $temp2 = ['orders' => $group2_order, 'title' => 'ग्राम संगठन/ VO', 'sub_title' => '', 'menu_type' => 2, 'name' => '', 'url' => '#', 'webview' => false, 'gps' => false, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/vo.png', 'has_child' => true, 'botton_color' => GenralModel::APP_VO_BG_COLOR, 'child' => []];
//            
//        }
//        foreach ($dataProvidervo->getModels() as $key => $vo) {
//            $child2 = ['orders' => $group2_order, 'title' => 'ग्राम संगठन/ VO', 'menu_type' => 3, 'name' => $vo->name_of_vo, 'url' => '#', 'webview' => false, 'gps' => false, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/vo.png', 'has_child' => true, 'botton_color' => GenralModel::APP_VO_BG_COLOR,'child' => []];
//           $child2['child']['intro_text'] = $this->getIntrotext($vo);
//           array_push($temp2['child'], $child2);
//          
//            array_push($temp2['child'][$key]['child'], ['orders' => ($group2_order + 1), 'title' => 'ग्राम संगठन/ VO का विवरण', 'sub_title' => $vo->name_of_vo, 'name' => $vo->name_of_vo, 'menu_type' => 3, 'url' => \Yii::$app->params['app_url']['sakhi'] . '/rest/index?vo_id=' . $vo->id . '&form=1&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/vo.png', 'has_child' => false, 'botton_color' => GenralModel::APP_VO_BG_COLOR]);
//            array_push($temp2['child'][$key]['child'], [ 'orders' => ($group2_order + 2), 'title' => 'धन प्राप्ति का विवरण', 'sub_title' => $vo->name_of_vo, 'menu_type' => 3, 'name' => $vo->name_of_vo, 'url' => \Yii::$app->params['app_url']['sakhi'] . '/rest/index?vo_id=' . $vo->id . '&form=2&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png', 'has_child' => false, 'botton_color' => GenralModel::APP_VO_BG_COLOR]);
//            array_push($temp2['child'][$key]['child'], ['orders' => ($group2_order + 3), 'title' => 'सम्बद्ध SHG', 'sub_title' => $vo->name_of_vo, 'menu_type' => 3, 'name' => $vo->name_of_vo, 'url' => \Yii::$app->params['app_url']['sakhi'] . '/rest/index?vo_id=' . $vo->id . '&form=3&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/add.png', 'has_child' => false, 'botton_color' => GenralModel::APP_VO_BG_COLOR]);
//            array_push($temp2['child'][$key]['child'], [ 'orders' => ($group2_order + 4), 'title' => 'पदाधिकारीयों एवं सदस्यों का विवरण', 'sub_title' => $vo->name_of_vo, 'menu_type' => 3, 'name' => $vo->name_of_vo, 'url' => \Yii::$app->params['app_url']['sakhi'] . '/rest/index?vo_id=' . $vo->id . '&form=4&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/mem-list.png', 'has_child' => false, 'botton_color' => GenralModel::APP_VO_BG_COLOR]);
//            array_push($temp2['child'][$key]['child'], [ 'orders' => ($group2_order + 5), 'title' => 'SHG के साथ ऋण लेनदेन', 'sub_title' => $vo->name_of_vo, 'menu_type' => 3, 'name' => $vo->name_of_vo, 'url' => \Yii::$app->params['app_url']['sakhi'] . '/rest/index?vo_id=' . $vo->id . '&form=5&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/vo-funds.png', 'has_child' => false, 'botton_color' => GenralModel::APP_VO_BG_COLOR]);
//        }
//        if ($dataProvidervo->query->count() > 0) {
//            array_push($menu_array['menu_item'], $temp2);
//        }
        $cbo_member = \common\models\CboMembers::find()->where(['user_id' => $user_model->id, 'suggest_wada_sakhi' => 1])->one();
        $childshg = [];
        $searchModelshg = new ShgSearch();
        if (in_array(Yii::$app->user->identity->username, ['9000000001', '9000000004', '9000000114', '9000000224', '9200000003'])) {
            $searchModelshg->id = [247973, 247974, 247976];
        }
        $dataProvidershg = $searchModelshg->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if ($dataProvidershg->query->count() > 0 and $cbo_member == null) {
            $temp3 = ['orders' => $group3_order, 'title' => 'SHG', 'sub_title' => 'Self Help Group', 'menu_type' => 2, 'url' => '#', 'webview' => false, 'gps' => false, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/shg.png', 'has_child' => true, 'botton_color' => GenralModel::APP_VO_BG_COLOR, 'child' => ['intro_text' => '', 'page_title' => '', 'menu_item' => []]];
            $temp3['child']['page_title'] = "स्वयं सहायता समूह सूची";
            $temp3['child']['intro_text'] = "स्वयं सहायता समूह सूची";
        }
        if ($dataProvidershg->query->count() > 0 and $cbo_member == null) {
            foreach ($dataProvidershg->getModels() as $key => $shg) {
                $child3 = ['orders' => $group3_order, 'title' => 'SHG', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => '#', 'webview' => false, 'gps' => false, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/shg.png', 'has_child' => true, 'botton_color' => GenralModel::APP_SHG_BG_COLOR, 'child' => ['intro_text' => '', 'page_title' => '', 'menu_item' => []]];
                $child3['child']['page_title'] = $shg->name_of_shg;
                $child3['child']['intro_text'] = $this->getIntrotext($shg);
                $child3['child']['menu_item'] = [];
                ///array_push($temp3['child'], $child3);
                if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/feedback/form', ['shgid' => $shg->id])) {
                    array_push($child3['child']['menu_item'], ['orders' => ($group3_order + 1), 'title' => 'फ़ीड्बैक', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => $base_url . '/rest/shg?shgid=' . $shg->id . '&url=' . '/shg/feedback/form?shgid=' . $shg->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'visible' => 1, 'gps' => true, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_SHG_BG_COLOR]);
                }
                if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/profile/index', ['shgid' => $shg->id])) {
                    array_push($child3['child']['menu_item'], ['orders' => ($group3_order + 2), 'title' => 'SHG का विवरण', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => $base_url . '/rest/shg?shgid=' . $shg->id . '&url=' . '/shg/profile/index?shgid=' . $shg->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/shg.png', 'has_child' => false, 'botton_color' => GenralModel::APP_SHG_BG_COLOR]);
                }
                if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/bankaccount/index', ['shgid' => $shg->id])) {
                    array_push($child3['child']['menu_item'], ['orders' => ($group3_order + 3), 'title' => 'बैंक खाता विवरण', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => $base_url . '/rest/shg?shgid=' . $shg->id . '&url=' . '/shg/bankaccount/index?shgid=' . $shg->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/bank-account.png', 'has_child' => false, 'botton_color' => GenralModel::APP_SHG_BG_COLOR]);
                }
                if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/index', ['shgid' => $shg->id])) {
                    array_push($child3['child']['menu_item'], ['orders' => ($group3_order + 4), 'title' => 'पदाधिकारीयों एवं सदस्यों का विवरण', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => $base_url . '/rest/shg?shgid=' . $shg->id . '&url=' . '/shg/member/index?shgid=' . $shg->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/mem-list.png', 'has_child' => false, 'botton_color' => GenralModel::APP_SHG_BG_COLOR]);
                }
                if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/funds/index', ['shgid' => $shg->id])) {
                    array_push($child3['child']['menu_item'], ['orders' => ($group3_order + 5), 'title' => 'धन प्राप्ति का विवरण', 'sub_title' => $shg->name_of_shg, 'menu_type' => 3, 'url' => $base_url . '/rest/shg?shgid=' . $shg->id . '&url=' . '/shg/funds/index?shgid=' . $shg->id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/fund-recieve.png', 'has_child' => false, 'botton_color' => GenralModel::APP_SHG_BG_COLOR]);
                }
                array_push($temp3['child']['menu_item'], $child3);
            }
            if ($dataProvidershg->query->count() > 0) {
                array_push($menu_array['menu_item'], $temp3);
            }
        }
        $childbc = [];

        if (isset($user_model->cboprofile) and $user_model->cboprofile->bc) {

            $temp4 = ['orders' => $group4_order, 'title' => 'बीसी सखी', 'sub_title' => '', 'menu_type' => 2, 'url' => '#', 'webview' => false, 'gps' => false, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/profile.jpg', 'has_child' => true, 'botton_color' => GenralModel::APP_BC_BG_COLOR, 'child' => []];
            //array_push($menu_array['bc'], $temp4);
            $temp = ['orders' => $group4_order, 'title' => 'बीसी सखी प्रोफाइल', 'sub_title' => $user_model->cboprofile->first_name, 'menu_type' => 2, 'url' => $base_url . '/rest/bc?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&url=' . '/bc/default/view?bcid=' . $user_model->cboprofile->srlm_bc_application_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/profile.jpg', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
        }
        if (isset($user_model->cboprofile) and $user_model->cboprofile->bc) {
            array_push($menu_array['menu_item'], $temp);
        }
        if (isset($cbo_member) and $cbo_member->suggest_wada_sakhi) {
            $temp1 = ['orders' => 0, 'title' => 'WADA सखी आवेदन प्रपत्र', 'sub_title' => $user_model->name, 'menu_type' => 2, 'url' => $base_url . '/rest/shg?shgid=' . $cbo_member->cbo_id . '&url=' . '/shg/application/form?shgid=' . $cbo_member->cbo_id . '&app_version=' . $user_model->app_version . '', 'webview' => true, 'gps' => true, 'visible' => 1, 'icon_url' => \Yii::$app->params['app_url']['www'] . '/images/app/writing.png', 'has_child' => false, 'botton_color' => GenralModel::APP_BC_BG_COLOR];
            array_push($menu_array['menu_item'], $temp1);
        }


        return $menu_array;
    }

    public function getCbomenuversion() {
        $menu_version = 1;
        return $menu_version;
    }

    public function getLastnotificationid() {
        $last_notificationid = 0;
        $model = \common\models\rishta\RishtaNotificationLog::find()
                ->select(['id'])
                ->where(['user_id' => Yii::$app->user->identity->id, 'visible' => 1])
                ->orderBy('id desc')
                ->limit(1)
                ->offset(1)
                ->one();
        return isset($model) ? $model->id : $last_notificationid;
    }

    public function getNotice1() {
        $html = '';
        $html .= "<p>यह मोबाइल ऐप उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन से जुडी हुई हैं सभी स्वयं सहायता समूह (SHG), ग्राम संगठन (VO) एवं क्लस्टर स्तरीय संकुल (CLF) के संस्थागत कार्य, वित्तीय लेन देन एवं उनके बही खाते की सुविधा के लिए प्रस्तावित है । इस ऐप में आगे बढ़ने से पहले निम्न बिन्दूओं का संज्ञान लें –</p>
  <p>  1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा । </p>
   <p> 2. इस ऐप द्वारा सृजित सभी सूचना आपके मोबाइल फ़ोन पर पासवर्ड द्वारा सुरक्षित रहेगा ।</p> 
   <p> 3. समूहों द्वारा ऐप में दी गयी फ़ीड्बैक भरा जाना आवश्यक है ।</p>
   <p> 4. सभी सूचनाओं के अंत में सुधार/ एडिट करने के लिए बटन का इस्तेमाल कर सकते हैं । नया आइटम जोड़ने के लिए + का संकेत उपयोग करें । ये आवश्यक है कि सूचनाएँ सही भरी जाएँ  एवं बार बार बदला ना जाए ।</p>
   <p> 5. ऐप में भरे गए सूचनाएँ मिशन के हर स्तर पर पढ़ी जा सकेगी ।</p>
   <p> 6. असुविधा होने पर या अधिक जानकारी के लिए हेल्प लाइन नम्बर 9070804050 पर फ़ोन करें ।</p>";
        return $html;
    }

    public function getNotice1title() {
        $html = '';
        $html .= "समूह के यूज़र के लिए दिशा निर्देश";
        return $html;
    }

    public function getNotice2() {
        $html = '';
        if (in_array(Yii::$app->user->identity->username, ['9000000114'])) {
            $html = '<p> 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा  6. असुविधा होने पर या अधिक जानकारी के लिए हेल्प लाइन नम्बर 9070804050 पर फ़ोन करें ।</p>';
        }
        return $html;
    }

    public function getIntrotext($model = null) {
        $html = '';

        $html = '<p> 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा 1. यह ऍप आपके मोबाइल, सिम कार्ड एवं आपके कार्यस्थल/ लोकेशन की पहचान व रिकार्ड करता है । इनमे से कोई भी बदलाव होने पर यह ऍप एडमिन कण्ट्रोल को सावधानी की सूचना प्रेषित करेगा । मोबाइल फ़ोन बदलने की स्थिति में यह ऍप स्वतः ब्लॉक हो जायेगा  6. असुविधा होने पर या अधिक जानकारी के लिए हेल्प लाइन नम्बर 9070804050 पर फ़ोन करें ।</p>';

        return $html;
    }

    public function getNoticesupport() {
        $html = '';

        $html = '<p> किसी भी सम्बंधित जानकारी के लिए में रिश्ता कॉल सेंटर : 9070804050 में कॉल करें।</p>';

        return $html;
    }
}
