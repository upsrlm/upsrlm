<?php

namespace sakhi\modules\hhs\controllers;

use Yii;
use yii\web\Controller;
use common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurveySearch;
use common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey;
use kartik\form\ActiveForm;
use common\helpers\FileHelpers;

/**
 * Default controller for the `hhs` module
 */
class DefaultController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message;

    public function beforeAction($action) {

        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionView($hhsid) {
        $model = $this->findModel($hhsid);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModel($id) {
        if (($model = NfsaBaseSurvey::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
