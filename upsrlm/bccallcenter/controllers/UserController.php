<?php

namespace bccallcenter\controllers;

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
                'only' => ['resetpassword'],
                'rules' => [
                    [
                        'actions' => ['resetpassword'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN,MasterRole::ROLE_DBT_CALL_CENTER_MANAGER,MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE,MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN]));
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'introemail' => ['post', 'get'],
                    'forgotpassword' => ['post'],
                    'block' => ['post'],
                    'switch' => ['post'],
                ],
            ],
        ];
    }

    public function actionResetpassword() {
        $user = new \common\models\form\ResetPasswordByUsernameForm();
        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->validate()) {
            $user->user = User::findOne(['username' => $user->username]);
            if (isset($user->user->username)) {
                $user->success = 1;
            }
            if (isset($user->user->username) and $user->success==1 and $user->validate() and $user->save()) {
                \Yii::$app->getSession()->setFlash('success', "Reset Password Of " . $user->user->name . " successfully");
                return $this->refresh();
            }
            
        }

        return $this->render('resetpassword', [
                    'user' => $user
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
