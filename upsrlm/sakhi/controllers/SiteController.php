<?php

namespace sakhi\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\master\MasterRole;
use common\models\dynamicdb\cbo_detail\RishtaTempPhoto;
/**
 * Site controller
 */
class SiteController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'paymentresponse') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'testing', 'paymentresponse'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['paymentresponse'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['testing'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CBO_USER]));
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logouts' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        echo 'check';exit;
        return $this->render('index');
    }

    public function actionPan($bcid = null)
    {
        $model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);
        if (\Yii::$app->request->post()) {
            define('UPLOAD_DIR', 'assets/');
            $content = base64_decode(\Yii::$app->request->post()['pan']);
            $im = imagecreatefromstring($content);

            if ($im !== false) {
                header('Content-Type: image/jpeg');
                imagejpeg($im, UPLOAD_DIR . 'pan_' . uniqid() . '.jpg');
                imagedestroy($im);
            }
            $content1 = base64_decode(\Yii::$app->request->post()['pan1']);
            $im1 = imagecreatefromstring($content1);

            if ($im1 !== false) {
                header('Content-Type: image/jpeg');
                imagejpeg($im1, UPLOAD_DIR . 'pan1_' . uniqid() . '.jpg');
                imagedestroy($im1);
            }
            //            print_r(\Yii::$app->request->post());
            //            print_r($_FILES);
        }
        return $this->render('pan1', ['model' => $model]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionTesting()
    {
        $user_model = Yii::$app->user->identity;
        $base_url = \Yii::$app->params['app_url']['sakhi'];
        $searchModelclf = new \cbo\models\CboClfSearch();
        if (in_array(Yii::$app->user->identity->username, ['9000000001', '9000000004', '9000000114', '9000000224', '9200000003'])) {
            $searchModelclf->id = [876, 877];
        }
        $dataProviderclf = $searchModelclf->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $searchModelvo = new \cbo\models\CboVoSearch();
        if (in_array(Yii::$app->user->identity->username, ['9000000001', '9000000004', '9000000114', '9000000224', '9200000003'])) {
            $searchModelvo->id = [14689, 14690];
        }
        $dataProvidervo = $searchModelvo->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $searchModelshg = new \cbo\models\ShgSearch();
        if (in_array(Yii::$app->user->identity->username, ['9000000001', '9000000004', '9000000114', '9000000224', '9200000003'])) {
            $searchModelshg->id = [247973, 247974, 247976];
        }
        $dataProvidershg = $searchModelshg->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        return $this->render('testing', [
            'user_model' => $user_model,
            'dataProviderclf' => $dataProviderclf,
            'dataProvidervo' => $dataProvidervo,
            'dataProvidershg' => $dataProvidershg,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/')->send();
        exit;
        return $this->goHome();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function actionPaymentresponse()
    {
        $paytm = new \sakhi\components\paytm\PaytmConfig();
        $paytm->run();

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";

        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";

        $isValidChecksum = \sakhi\components\paytm\PaytmChecksum::verifySignature($paramList, $paytm->PAYTM_MERCHANT_KEY, $paytmChecksum);

        if ($isValidChecksum == "TRUE") {
            $model = \common\models\wada\paytm\WadaPaytmLog::find()->where(['orderid' => $_POST['ORDERID']])->one();
            if (!$model) {
                $model = new \common\models\wada\paytm\WadaPaytmLog();
            }
            $model->txnid = isset($_POST['TXNID']) ? $_POST['TXNID'] : '';
            $model->txndate = isset($_POST['TXNDATE']) ? $_POST['TXNDATE'] : Null;
            $model->respcode = isset($_POST['RESPCODE']) ? $_POST['RESPCODE'] : '';
            $model->currency = isset($_POST['CURRENCY']) ? $_POST['CURRENCY'] : '';
            $model->gatewayname = isset($_POST['GATEWAYNAME']) ? $_POST['GATEWAYNAME'] : '';
            $model->respmsg = isset($_POST['RESPMSG']) ? $_POST['RESPMSG'] : '';
            $model->bankname = isset($_POST['BANKNAME']) ? $_POST['BANKNAME'] : '';
            $model->banktxnid = isset($_POST['BANKTXNID']) ? $_POST['BANKTXNID'] : '';
            $model->checksumhash = isset($_POST['CHECKSUMHASH']) ? $_POST['CHECKSUMHASH'] : '';
            $model->status_msg = isset($_POST['STATUS']) ? $_POST['STATUS'] : '';
            if (isset($_POST["STATUS"]) && $_POST["STATUS"] == "TXN_SUCCESS") {
                $model->status = 1;
            } else {
                $model->status = 0;
            }
            if ($model->save(false)) {
                $wada_model = \common\models\wada\WadaApplication::findOne(['id' => $model->application_id]);
                if ($model->status == 1) {
                    $wada_model->is_amount_pay = 1;
                    $wada_model->amount_pay_datetime = $model->txndate;
                    $wada_model->amount_pay_datetime = $model->txndate;
                    $wada_model->amount_txnid = $model->txnid;
                    $wada_model->status = 2;
                    $wada_model->save(false);
                }
            }

            return $this->render('@sakhi/modules/shg/views/application/paymentresponse', [
                'isValidChecksum' => $isValidChecksum,
                'model' => $model
            ]);
        } else {
            echo "<b>Checksum mismatched.</b>";
            //Process transaction as suspicious.
        }
    }
    public function actionAcpuinfo() {
        echo "<pre/>";
        print_r(apcu_sma_info());
        echo "<br/>";
        echo "<br/>";
        print_r(apcu_cache_info());
        exit; //  
        //return $this->goHome();
    }

    public function actionAcpuclear() {
        apcu_clear_cache();
        $this->redirect("/site/acpuinfo");
    }
}
