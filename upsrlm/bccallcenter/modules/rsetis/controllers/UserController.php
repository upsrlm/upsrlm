<?php

namespace bccallcenter\modules\rsetis\controllers;

use Yii;
use yii\base\ExitException;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use common\models\RelationUserDivisionSearch;
use common\models\RelationUserUlbSearch;
use common\models\RelationUserGramPanchayat;
use common\models\RelationUserBdoBlockSearch;
use common\models\RelationUserDistrictSearch;
use common\models\User;
use common\models\UserSearch;
use common\models\master\MasterRole;
use common\models\form\AddUserForm;
use common\models\form\ResetPasswordForm;
use backend\models\form\BDOForm;
use common\models\base\GenralModel;

class UserController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            
        ];
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex() {
        Url::remember('', 'actions-redirect');
        $searchModel = new UserSearch();
        $searchModel->role = [MasterRole::ROLE_RSETIS_DISTRICT_UNIT];
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['districts']);
            $dataProvider->query->andWhere(['relation_user_district.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('relation_user_district.district_code');
        }

        return $this->render('rsethis', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }



    public function actionView($userid) {
        $model = $this->findModel($userid);

        return $this->render('view', [
                    'model' => $model
        ]);
    }

    protected function findModel($id) {
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $user;
    }

}
