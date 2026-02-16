<?php

namespace sakhi\modules\clf\controllers;

use Yii;
use cbo\models\CboClf;
use cbo\models\CboClfSearch;
use cbo\models\form\CboClfForm;
use cbo\models\form\CboClfMembersForm;
use common\models\master\MasterRole;
use common\models\base\GenralModel;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use cbo\models\form\Clfbasicform;
use cbo\models\form\ClfaddvoForm;
use cbo\models\form\Clffundsrecivedform;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `clf` module
 */
class DefaultController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'update', 'addvo', 'fundsrecived', 'memberlist', 'updatemember', 'voshg', 'fundsvo', 'addfundsvo', 'addmember', 'removemember'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'addvo', 'fundsrecived', 'memberlist', 'updatemember', 'voshg', 'fundsvo', 'addfundsvo', 'addmember', 'removemember'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->params['env'] === 'local') {
                                return true;
                            }
                            return (!Yii::$app->user->isGuest && in_array(
                                Yii::$app->user->identity->role,
                                [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CBO_USER]
                            ));
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $searchModel = new CboClfSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        if ($dataProvider->getCount() == 1) {
            foreach ($dataProvider->getModels() as $clf_model) {
                $this->redirect(["/clf/default/view?clfid=$clf_model->id"]);
            }
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($clfid) {
        return $this->render('view', [
                    'model' => $this->findModel($clfid),
        ]);
    }

    public function actionUpdate($clfid) {
        $clf_model = $this->findModel($clfid);
        $model = new Clfbasicform($clf_model);
        $this->performAjaxValidation($model);
//        if (Yii::$app->request->isPost) {
//            $model->passbook_photo = UploadedFile::getInstance($model, 'passbook_photo');
//            $model->passbook_photo2 = UploadedFile::getInstance($model, 'passbook_photo2');
//            $model->passbook_photo3 = UploadedFile::getInstance($model, 'passbook_photo3');
//            $model->pan_photo = UploadedFile::getInstance($model, 'pan_photo');
//            if ($model->load(Yii::$app->request->post())) {
//
//                if ($model->save()) {
//                    return $this->redirect(['/clf/default/view?clfid=' . $clf_model->id]);
//                }
//            }
//        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionFundsrecived($clfid) {
        $clf_model = $this->findModel($clfid);
        return $this->render('fundsrecived', [
                    'model' => $clf_model,
        ]);
    }

    public function actionReceivefundsgov($clfid, $clffundsid = null) {
        $clf_model = $this->findModel($clfid);
        $clffundsgov = \cbo\models\CboClfFunds::findOne(['id' => $clffundsid, 'received_by' => \cbo\models\CboClfFunds::RECEIVED_BY_GOV]);
        $model = new \cbo\models\form\ClffundrecivedgovForm($clf_model, $clffundsgov);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['/clf/default/fundsrecived?clfid=' . $clf_model->id]);
            }
        }
        return $this->render('clfreceivefundsgov', [
                    'model' => $model,
        ]);
    }

    public function actionReceivefundsvo($clfid, $clffundsid = null) {
        $clf_model = $this->findModel($clfid);
        $clffundsgov = \cbo\models\CboClfFunds::findOne(['id' => $clffundsid, 'received_by' => \cbo\models\CboClfFunds::RECEIVED_BY_VO]);
        $model = new \cbo\models\form\ClffundrecivedvoForm($clf_model, $clffundsgov);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['/clf/default/fundsrecived?clfid=' . $clf_model->id]);
            }
        }
        return $this->render('clfreceivefundsvo', [
                    'model' => $model,
        ]);
    }

    public function actionFundsvo($clfid) {
        $clf_model = $this->findModel($clfid);

        return $this->render('fundsvo', [
                    'model' => $clf_model,
        ]);
    }

    public function actionAddvo($clfid) {
        $clf_model = $this->findModel($clfid);
        $model = new ClfaddvoForm($clf_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['/clf/default/view?clfid=' . $clf_model->id]);
            }
        }
        return $this->render('addvo', [
                    'model' => $model,
        ]);
    }

    public function actionMemberlist($clfid) {
        $clf_model = $this->findModel($clfid);
        $model = new ClfaddvoForm($clf_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['/clf/default/memberlist?clfid=' . $clf_model->id]);
            }
        }
        return $this->render('memberlist', [
                    'model' => $model,
        ]);
    }

    public function actionAddmember($clfid) {
        $valid = true;
        $clf_model = $this->findModel($clfid);
        $model = new CboClfMembersForm($clf_model);
        $model->sakhi = 1;
        $model->clf_model = $clf_model;
        $model->clf_member_model = new \cbo\models\CboClfMembers();
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->clf_member_model->cbo_clf_id = $clf_model->id;
            $model->clf_member_model->name = $model->name;
            $model->clf_member_model->mobile_no = $model->mobile_no;
            $model->clf_member_model->role = $model->role;
            $model->clf_member_model->bank_operator = $model->bank_operator;
            if ($model->clf_member_model->save()) {
                return $this->redirect(['/clf/default/updatemember?clfid=' . $clf_model->id . "&clfmemberid=" . $model->clf_member_model->id]);
            }
        }
        return $this->render('addmember', [
                    'model' => $model,
        ]);
    }

    public function actionFeedback($clfid) {
        $valid = true;
        $clf_model = $this->findModel($clfid);
        $model = new \cbo\models\form\CboClfFeedbackForm($clf_model);
        $model->scenario = 'first';
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                if ($model->ques_8 == '2') {
                    return $this->redirect(['/clf/default/feedbackview?clfid=' . $clf_model->id]);
                }
                if ($model->ques_8 == '1') {
                    return $this->redirect(['/clf/default/feedbackview?clfid=' . $clf_model->id]);
                }
            }
        }
        return $this->render('feedback', [
                    'model' => $model,
        ]);
    }

    public function actionNextfeedback($clfid) {
        $valid = true;
        $clf_model = $this->findModel($clfid);
        $model = new \cbo\models\form\CboClfFeedbacknextform($clf_model);
//        $model->scenario = 'next';
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            if ($model->save()) {
                return $this->redirect(['/clf/default/feedbackview?clfid=' . $clf_model->id]);
            }
        }
        return $this->render('nextfeedback', [
                    'model' => $model,
        ]);
    }

    public function actionFeedbackview($clfid) {
        $valid = true;
        $clf_model = $this->findModel($clfid);
        $model = \cbo\models\CboClfFeedback::findOne(['cbo_clf_id' => $clf_model->id]);

        return $this->render('feedbackview', [
                    'model' => $model,
        ]);
    }

    public function actionUpdatemember($clfid, $clfmemberid) {
        $member_model = \cbo\models\CboClfMembers::findOne($clfmemberid);
        $model = new \cbo\models\form\Clfmemberform($member_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['/clf/default/memberlist?clfid=' . $model->clf_model->id]);
            }
        }
        return $this->render('updatemember', [
                    'model' => $model,
        ]);
    }

    public function actionRemovemember($clfid, $clfmemberid) {
        $member_model = \cbo\models\CboClfMembers::findOne($clfmemberid);
        $member_model->status = -1;
        if ($member_model->user != null) {
            $member_model->user->status = 0;
            $member_model->user->save();
            $cbo_member = \common\models\CboMembers::find()->where(['cbo_type' => \common\models\CboMembers::CBO_TYPE_CLF, 'cbo_id' => $member_model->cbo_clf_id, 'user_id' => $member_model->user->id])->one();
            if ($cbo_member != null) {
                $cbo_member->status = -1;
                $cbo_member->save();
            }
        }

        if ($member_model->save()) {
            return $this->redirect(['/clf/default/memberlist?clfid=' . $member_model->cbo_clf_id]);
        }
    }

    public function actionAddfundsvo($clfid, $void, $clfvofundsid = null) {
        $clf_model = $this->findModel($clfid);
        $vo_model = $this->findModelvo($void);
        $funds_model = \cbo\models\CboClfVoFunds::find()->where(['id' => $clfvofundsid])->one();
        $model = new \cbo\models\form\Clfvofundsform($clf_model, $vo_model, $funds_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['/clf/default/fundsvo?clfid=' . $model->clf_model->id]);
            }
        }
        return $this->render('addfundsvo', [
                    'model' => $model,
        ]);
    }

    public function actionVoshg() {
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                $cbo_vo_id = $parents[0];
                $array = [];
                if ($cbo_vo_id != null) {
                    $searchModel = new \cbo\models\ShgSearch();
                    $searchModel->cbo_vo_id = $cbo_vo_id;
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model) {
                            $array[$model->id] = ['id' => $model->id, 'name' => $model->name_of_shg];
                        }
                    }
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    \Yii::$app->response->data = ['output' => $array, 'selected' => ''];
                }
            } else {
                echo Json::encode(['output' => '', 'selected' => '']);
            }
        }
    }

    protected function findModel($id) {
        if (($model = CboClf::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelvo($id) {
        if (($model = \cbo\models\CboVo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
