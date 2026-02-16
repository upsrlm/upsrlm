<?php

namespace bc\modules\md\controllers;

use Yii;
use bc\models\UpsrlmFrameworkValidation;
use bc\models\UpsrlmFrameworkValidationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ValidationController implements the CRUD actions for UpsrlmFrameworkValidation model.
 */
class ValidationController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'framework'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'framework'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all UpsrlmFrameworkValidation models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UpsrlmFrameworkValidationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFramework($id) {
        $from = [Yii::$app->params['supportEmail'] => 'UPSRLM'];
//        $to = ['rahman.kld@gmail.com', 'vikas.kc@gmail.com'];
//        $cc = ['rahman.kld@gmail.com', 'vikas.kc@gmail.com'];
        $to = ['crd-up@nic.in', 'psrd.up@gmail.com', 'manoj@microsave.net'];
        $cc = ['mdsrlmup9@gmail.com', 'vikas.k.c@gmail.com'];
        $bcc = ['rahman.kld@gmail.com', 'vikas.kc@gmail.com'];
        $subject = 'Milestones of deliverables achieved and technologically reported';

        $model = $this->findModel($id);
        if ($model->validation_status == 0) {
            $model->validation_status = 1;
            $model->validation_datetime = new \yii\db\Expression('NOW()');
            $model->validation_by = \Yii::$app->user->identity->id;
            if ($model->save()) {
                if ($model->id == 2) {
                    $subject = 'Milestones of deliverables achieved and technologically reported for deliverable no. 2 "Complete operationalization of the said processes."';
                    Yii::$app->mailerupsrlm->compose('@common/mail/deliverables-2-html', ['model' => $model])
                            ->setFrom([Yii::$app->params['supportEmail'] => 'UPSRLM'])
                            ->setTo($to)
//                        ->setBcc($bcc)
                            ->setCc($cc)
                            ->setSubject($subject)
                            ->send();
                }
                if (in_array($model->id, [3, 4, 5, 6])) {
                    $subject = 'Milestones of deliverables achieved and technologically reported for deliverable no. 3 "Upon completion and acceptance of modules by UPSRLM manifested in operational roll out of the same"';
                    $m3dcount = UpsrlmFrameworkValidation::find()->where(['id' => [3, 4, 5, 6], 'validation_status' => 1])->count();
                    if ($m3dcount == '4') {
                        Yii::$app->mailerupsrlm->compose('@common/mail/deliverables-3-html', ['model' => $model])
                                ->setFrom($from)
                                ->setTo($to)
//                        ->setBcc($bcc)
                                ->setCc($cc)
                                ->setSubject($subject)
                                ->send();
                    }
                }
                if (in_array($model->id, [7, 8])) {
                    $subject = 'Milestones of deliverables achieved and technologically reported for deliverable no. 4 "Upon completion and acceptance of the service product by UPSRLM; manifested in operational roll out"';
                    $m4dcount = UpsrlmFrameworkValidation::find()->where(['id' => [7, 8], 'validation_status' => 1])->count();
                    if ($m4dcount == '2') {
                        Yii::$app->mailerupsrlm->compose('@common/mail/deliverables-4-html', ['model' => $model])
                                ->setFrom($from)
                                ->setTo($to)
//                        ->setBcc($bcc)
                                ->setCc($cc)
                                ->setSubject($subject)
                                ->send();
                    }
                }
                if ($model->id == 9) {
                    $subject = 'Milestones of deliverables achieved and technologically reported for deliverable no. 5 "On operationalization of 100% users as specified and at least 25% of BC Sakhis be functional & operational on ground."';
                    Yii::$app->mailerupsrlm->compose('@common/mail/deliverables-5-html', ['model' => $model])
                            ->setFrom($from)
                            ->setTo($to)
//                        ->setBcc($bcc)
                            ->setCc($cc)
                            ->setSubject($subject)
                            ->send();
                }
            }
            return $this->redirect(['/md/validation']);
        }
    }

    /**
     * Finds the UpsrlmFrameworkValidation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UpsrlmFrameworkValidation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UpsrlmFrameworkValidation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
