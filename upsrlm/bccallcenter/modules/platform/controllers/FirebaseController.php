<?php

namespace bccallcenter\modules\platform\controllers;

use yii\web\Controller;
use Yii;
use common\models\rishta\form\CustomMessageForm;
use common\models\rishta\RishtaNotificationLog;
use common\models\rishta\RishtaNotificationLogFirebaseDetail;
use common\components\GoogleFirebaseRishta;
use common\models\User;
use common\models\master\MasterRole;

/**
 * Dialer controller for the `platform` module
 */
class FirebaseController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['message'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['message'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionMessage($userid, $red = '/tracking/bc/transaction') {
        $user_model = $this->findModel($userid);
        $model = new CustomMessageForm($user_model);
        $model->notification_template_id=500;
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            \Yii::$app->getSession()->setFlash('success', "Notification send to " . $user_model->name . " successfully");

            return $this->redirect([$red]);
        }


        return $this->render('_messageform', ['model' => $model]);
    }

    protected function findModel($id) {
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $user;
    }
}
