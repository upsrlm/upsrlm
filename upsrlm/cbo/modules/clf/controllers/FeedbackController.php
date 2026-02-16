<?php

namespace cbo\modules\clf\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use cbo\models\CboClf;
use cbo\models\CboClfSearch;
use cbo\models\CboClfFeedback;
use cbo\models\CboClfFeedbackSearch;
use common\models\master\MasterRole;
use common\models\base\GenralModel;

/**
 * Default controller for the `clf` module
 */
class FeedbackController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

   public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index','view','report', 'downloadcsv'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','report', 'downloadcsv'],
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
    public function actionIndex() {
        $searchModel = new CboClfFeedbackSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReport() {
        $searchModel = new CboClfFeedbackSearch();
        $dataProvider11 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider11->query->andWhere(['=', 'ques_1', '1']);
        $dataProvider12 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider12->query->andWhere(['=', 'ques_1', '2']);
        $dataProvider13 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider13->query->andWhere(['=', 'ques_1', '3']);
        $dataProvider14 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider14->query->andWhere(['=', 'ques_1', '4']);
        $dataProvider21 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider21->query->andWhere(['=', 'ques_2', '1']);
        $dataProvider22 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider22->query->andWhere(['=', 'ques_2', '2']);

        $dataProvider23 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider23->query->andWhere(['=', 'ques_2', '3']);

        $dataProvider31 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider31->query->andWhere(['=', 'ques_3', '1']);
        $dataProvider32 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider32->query->andWhere(['=', 'ques_3', '2']);

        $dataProvider33 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider33->query->andWhere(['=', 'ques_3', '3']);
        $dataProvider34 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider34->query->andWhere(['=', 'ques_3', '4']);

        $dataProvider41 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider41->query->andWhere(['=', 'ques_4', '1']);
        $dataProvider42 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider42->query->andWhere(['=', 'ques_4', '2']);

        $dataProvider43 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider43->query->andWhere(['=', 'ques_4', '3']);
        $dataProvider44 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider44->query->andWhere(['=', 'ques_4', '4']);
        $dataProvider51 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider51->query->andWhere(['=', 'ques_5', '1']);
        $dataProvider52 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider52->query->andWhere(['=', 'ques_5', '2']);
        $dataProvider61 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider61->query->andWhere(['=', 'ques_61', '1']);
        $dataProvider62 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider62->query->andWhere(['=', 'ques_62', '1']);
        $dataProvider63 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider63->query->andWhere(['=', 'ques_63', '1']);
        $dataProvider64 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider64->query->andWhere(['=', 'ques_64', '1']);
        $dataProvider65 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider65->query->andWhere(['=', 'ques_65', '1']);
        $dataProvider66 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider66->query->andWhere(['=', 'ques_66', '1']);
        $dataProvider71 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider71->query->andWhere(['=', 'ques_7', '1']);
        $dataProvider72 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider72->query->andWhere(['=', 'ques_7', '2']);
        $dataProvider73 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider73->query->andWhere(['=', 'ques_7', '3']);
        $dataProvider74 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider74->query->andWhere(['=', 'ques_7', '4']);
        $dataProvider81 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider81->query->andWhere(['=', 'ques_8', '1']);
        $dataProvider82 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider82->query->andWhere(['=', 'ques_8', '2']);
        $dataProvider91 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider91->query->andWhere(['=', 'ques_91', '2']);
        $dataProvider92 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider92->query->andWhere(['=', 'ques_92', '2']);
        $dataProvider93 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider93->query->andWhere(['=', 'ques_93', '2']);
        $dataProvider94 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider94->query->andWhere(['=', 'ques_94', '2']);
        $dataProvider95 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider95->query->andWhere(['=', 'ques_95', '2']);
        $dataProvider96 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider96->query->andWhere(['=', 'ques_96', '2']);
        $dataProvider97 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider97->query->andWhere(['=', 'ques_97', '2']);
        $dataProvider98 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider98->query->andWhere(['=', 'ques_98', '2']);
        $dataProvider99 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider99->query->andWhere(['=', 'ques_99', '2']);
        $dataProvider101 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider101->query->andWhere(['=', 'ques_10', '1']);
        $dataProvider102 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider102->query->andWhere(['=', 'ques_10', '2']);
        $dataProvider103 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider103->query->andWhere(['=', 'ques_10', '3']);
        $dataProvider91a1 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider91a1->query->andWhere(['=', 'ques_91', '2'])->andWhere(['ques_91oa' => 1]);
        $dataProvider91a2 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider91a2->query->andWhere(['=', 'ques_91', '2'])->andWhere(['ques_91oa' => 2]);
        $dataProvider91a3 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider91a3->query->andWhere(['=', 'ques_91', '2'])->andWhere(['ques_91oa' => 3]);
        $dataProvider91a4 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider91a4->query->andWhere(['=', 'ques_91', '2'])->andWhere(['ques_91oa' => 4]);
        $dataProvider91a5 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider91a5->query->andWhere(['=', 'ques_91', '2'])->andWhere(['ques_91oa' => 5]);
        $dataProvider92a1 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider92a1->query->andWhere(['=', 'ques_92', '2'])->andWhere(['ques_92oa' => 1]);
        $dataProvider92a2 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider92a2->query->andWhere(['=', 'ques_92', '2'])->andWhere(['ques_92oa' => 2]);
        $dataProvider92a3 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider92a3->query->andWhere(['=', 'ques_92', '2'])->andWhere(['ques_92oa' => 3]);
        $dataProvider92a4 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider92a4->query->andWhere(['=', 'ques_92', '2'])->andWhere(['ques_92oa' => 4]);
        $dataProvider92a5 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider92a5->query->andWhere(['=', 'ques_92', '2'])->andWhere(['ques_92oa' => 5]);
        $dataProvider93a1 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider93a1->query->andWhere(['=', 'ques_93', '2'])->andWhere(['ques_93oa' => 1]);
        $dataProvider93a2 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider93a2->query->andWhere(['=', 'ques_93', '2'])->andWhere(['ques_93oa' => 2]);
        $dataProvider93a3 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider93a3->query->andWhere(['=', 'ques_93', '2'])->andWhere(['ques_93oa' => 3]);
        $dataProvider93a4 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider93a4->query->andWhere(['=', 'ques_93', '2'])->andWhere(['ques_93oa' => 4]);
        $dataProvider93a5 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider93a5->query->andWhere(['=', 'ques_93', '2'])->andWhere(['ques_93oa' => 5]);
        $dataProvider94a1 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider94a1->query->andWhere(['=', 'ques_94', '2'])->andWhere(['ques_94oa' => 1]);
        $dataProvider94a2 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider94a2->query->andWhere(['=', 'ques_94', '2'])->andWhere(['ques_94oa' => 2]);
        $dataProvider94a3 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider94a3->query->andWhere(['=', 'ques_94', '2'])->andWhere(['ques_94oa' => 3]);
        $dataProvider94a4 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider94a4->query->andWhere(['=', 'ques_94', '2'])->andWhere(['ques_94oa' => 4]);
        $dataProvider94a5 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider94a5->query->andWhere(['=', 'ques_94', '2'])->andWhere(['ques_94oa' => 5]);
        $dataProvider95a1 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider95a1->query->andWhere(['=', 'ques_95', '2'])->andWhere(['ques_95oa' => 1]);
        $dataProvider95a2 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider95a2->query->andWhere(['=', 'ques_95', '2'])->andWhere(['ques_95oa' => 2]);
        $dataProvider95a3 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider95a3->query->andWhere(['=', 'ques_95', '2'])->andWhere(['ques_95oa' => 3]);
        $dataProvider95a4 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider95a4->query->andWhere(['=', 'ques_95', '2'])->andWhere(['ques_95oa' => 4]);
        $dataProvider95a5 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider95a5->query->andWhere(['=', 'ques_95', '2'])->andWhere(['ques_95oa' => 5]);
        $dataProvider96a1 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider96a1->query->andWhere(['=', 'ques_96', '2'])->andWhere(['ques_96oa' => 1]);
        $dataProvider96a2 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider96a2->query->andWhere(['=', 'ques_96', '2'])->andWhere(['ques_96oa' => 2]);
        $dataProvider96a3 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider96a3->query->andWhere(['=', 'ques_96', '2'])->andWhere(['ques_96oa' => 3]);
        $dataProvider96a4 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider96a4->query->andWhere(['=', 'ques_96', '2'])->andWhere(['ques_96oa' => 4]);
        $dataProvider96a5 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider96a5->query->andWhere(['=', 'ques_96', '2'])->andWhere(['ques_96oa' => 5]);
        $dataProvider97a1 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider97a1->query->andWhere(['=', 'ques_97', '2'])->andWhere(['ques_97oa' => 1]);
        $dataProvider97a2 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider97a2->query->andWhere(['=', 'ques_97', '2'])->andWhere(['ques_97oa' => 2]);
        $dataProvider97a3 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider97a3->query->andWhere(['=', 'ques_97', '2'])->andWhere(['ques_97oa' => 3]);
        $dataProvider97a4 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider97a4->query->andWhere(['=', 'ques_97', '2'])->andWhere(['ques_97oa' => 4]);
        $dataProvider97a5 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider97a5->query->andWhere(['=', 'ques_97', '2'])->andWhere(['ques_97oa' => 5]);
        $dataProvider98a1 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider98a1->query->andWhere(['=', 'ques_98', '2'])->andWhere(['ques_98oa' => 1]);
        $dataProvider98a2 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider98a2->query->andWhere(['=', 'ques_98', '2'])->andWhere(['ques_98oa' => 2]);
        $dataProvider98a3 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider98a3->query->andWhere(['=', 'ques_98', '2'])->andWhere(['ques_98oa' => 3]);
        $dataProvider98a4 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider98a4->query->andWhere(['=', 'ques_98', '2'])->andWhere(['ques_98oa' => 4]);
        $dataProvider98a5 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider98a5->query->andWhere(['=', 'ques_98', '2'])->andWhere(['ques_98oa' => 5]);
        $dataProvider99a1 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider99a1->query->andWhere(['=', 'ques_99', '2'])->andWhere(['ques_99oa' => 1]);
        $dataProvider99a2 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider99a2->query->andWhere(['=', 'ques_99', '2'])->andWhere(['ques_99oa' => 2]);
        $dataProvider99a3 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider99a3->query->andWhere(['=', 'ques_99', '2'])->andWhere(['ques_99oa' => 3]);
        $dataProvider99a4 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider99a4->query->andWhere(['=', 'ques_99', '2'])->andWhere(['ques_99oa' => 4]);
        $dataProvider99a5 = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider99a5->query->andWhere(['=', 'ques_99', '2'])->andWhere(['ques_99oa' => 5]);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        $dataProvider = [];
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "11") {
            $dataProvider = $dataProvider11;
        } elseif ($button_type == "12") {
            $dataProvider = $dataProvider12;
        } elseif ($button_type == "21") {
            $dataProvider = $dataProvider21;
        } elseif ($button_type == "22") {
            $dataProvider = $dataProvider22;
        } elseif ($button_type == "23") {
            $dataProvider = $dataProvider23;
        } elseif ($button_type == "24") {
            $dataProvider = $dataProvider24;
        } elseif ($button_type == "31") {
            $dataProvider = $dataProvider31;
        } elseif ($button_type == "32") {
            $dataProvider = $dataProvider32;
        } elseif ($button_type == "33") {
            $dataProvider = $dataProvider33;
        } elseif ($button_type == "34") {
            $dataProvider = $dataProvider34;
        } elseif ($button_type == "35") {
            $dataProvider = $dataProvider35;
        } elseif ($button_type == "41") {
            $dataProvider = $dataProvider41;
        } elseif ($button_type == "42") {
            $dataProvider = $dataProvider42;
        } elseif ($button_type == "43") {
            $dataProvider = $dataProvider43;
        }
        return $this->render('report', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider11' => $dataProvider11,
                    'dataProvider12' => $dataProvider12,
                    'dataProvider13' => $dataProvider13,
                    'dataProvider14' => $dataProvider14,
                    'dataProvider21' => $dataProvider21,
                    'dataProvider22' => $dataProvider22,
                    'dataProvider23' => $dataProvider23,
                    'dataProvider31' => $dataProvider31,
                    'dataProvider32' => $dataProvider32,
                    'dataProvider33' => $dataProvider33,
                    'dataProvider34' => $dataProvider34,
                    'dataProvider41' => $dataProvider41,
                    'dataProvider42' => $dataProvider42,
                    'dataProvider43' => $dataProvider43,
                    'dataProvider44' => $dataProvider44,
                    'dataProvider51' => $dataProvider51,
                    'dataProvider52' => $dataProvider52,
                    'dataProvider61' => $dataProvider61,
                    'dataProvider62' => $dataProvider62,
                    'dataProvider63' => $dataProvider63,
                    'dataProvider64' => $dataProvider64,
                    'dataProvider65' => $dataProvider65,
                    'dataProvider66' => $dataProvider66,
                    'dataProvider71' => $dataProvider71,
                    'dataProvider72' => $dataProvider72,
                    'dataProvider73' => $dataProvider73,
                    'dataProvider74' => $dataProvider74,
                    'dataProvider81' => $dataProvider81,
                    'dataProvider82' => $dataProvider82,
                    'dataProvider101' => $dataProvider101,
                    'dataProvider102' => $dataProvider102,
                    'dataProvider103' => $dataProvider103,
                    'dataProvider91' => $dataProvider91,
                    'dataProvider92' => $dataProvider92,
                    'dataProvider93' => $dataProvider93,
                    'dataProvider94' => $dataProvider94,
                    'dataProvider95' => $dataProvider95,
                    'dataProvider96' => $dataProvider96,
                    'dataProvider97' => $dataProvider97,
                    'dataProvider98' => $dataProvider98,
                    'dataProvider99' => $dataProvider99,
                    'dataProvider91a1' => $dataProvider91a1,
                    'dataProvider91a2' => $dataProvider91a2,
                    'dataProvider91a3' => $dataProvider91a3,
                    'dataProvider91a4' => $dataProvider91a4,
                    'dataProvider91a5' => $dataProvider91a5,
                    'dataProvider92a1' => $dataProvider92a1,
                    'dataProvider92a2' => $dataProvider92a2,
                    'dataProvider92a3' => $dataProvider92a3,
                    'dataProvider92a4' => $dataProvider92a4,
                    'dataProvider92a5' => $dataProvider92a5,
                    'dataProvider93a1' => $dataProvider93a1,
                    'dataProvider93a2' => $dataProvider93a2,
                    'dataProvider93a3' => $dataProvider93a3,
                    'dataProvider93a4' => $dataProvider93a4,
                    'dataProvider93a5' => $dataProvider93a5,
                    'dataProvider94a1' => $dataProvider94a1,
                    'dataProvider94a2' => $dataProvider94a2,
                    'dataProvider94a3' => $dataProvider94a3,
                    'dataProvider94a4' => $dataProvider94a4,
                    'dataProvider94a5' => $dataProvider94a5,
                    'dataProvider95a1' => $dataProvider95a1,
                    'dataProvider95a2' => $dataProvider95a2,
                    'dataProvider95a3' => $dataProvider95a3,
                    'dataProvider95a4' => $dataProvider95a4,
                    'dataProvider95a5' => $dataProvider95a5,
                    'dataProvider96a1' => $dataProvider96a1,
                    'dataProvider96a2' => $dataProvider96a2,
                    'dataProvider96a3' => $dataProvider96a3,
                    'dataProvider96a4' => $dataProvider96a4,
                    'dataProvider96a5' => $dataProvider96a5,
                    'dataProvider97a1' => $dataProvider97a1,
                    'dataProvider97a2' => $dataProvider97a2,
                    'dataProvider97a3' => $dataProvider97a3,
                    'dataProvider97a4' => $dataProvider97a4,
                    'dataProvider97a5' => $dataProvider97a5,
                    'dataProvider98a1' => $dataProvider98a1,
                    'dataProvider98a2' => $dataProvider98a2,
                    'dataProvider98a3' => $dataProvider98a3,
                    'dataProvider98a4' => $dataProvider98a4,
                    'dataProvider98a5' => $dataProvider98a5,
                    'dataProvider99a1' => $dataProvider99a1,
                    'dataProvider99a2' => $dataProvider99a2,
                    'dataProvider99a3' => $dataProvider99a3,
                    'dataProvider99a4' => $dataProvider99a4,
                    'dataProvider99a5' => $dataProvider99a5,
                    
        ]);
    }

    public function actionDownloadcsv() {
        try {

            $searchModel = new CboClfFeedbackSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            $models = $dataProvider->getModels();
            $file = "CLF_feedback_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array(
                'Sr No',
                'Name of CLF',
                'District',
                'Block',
                '1. क्या अबतक मोबाइल ऐप को भरने/ एडिट करने में आपका अनुभव कैसा रहा?',
                '2. क्या संकुल के पदाधिकारी एवं लेखाकार में से किसी या सभी के पास टचवाला फ़ोन है?',
                '3. अगर किसी के पास टच वाला फ़ोन नहीं हैं तो मोबाइल ऐप का उपयोग कैसे करेंगे',
                '4. जब ये प्रश्नोत्तर आपके द्वारा भरा जा रहा है, उस समय संकुल के कितने पदाधिकारी/ सदस्य उपस्थित हैं?',
                '5. आप को संकुल के लेखा सम्बन्धी खाताबही के रखरखाव के लिए कौन सी व्यवस्था ज़्यादा आसान लगती है ?',
                '6.1. मोबाइल-ऐप पर लिखने का कष्ट नहीं रहेगा – सिर्फ़ टच से सही उत्तर चुनना होगा – जैसा अभी हम संकुल के ऐप पर कर रहें हैं ।',
                '6.2. मोबाइल पर खाता बही का सभी रिकार्ड रखना आसान होगा ।',
                '6.3. मोबाइल पर कार्य करने सुविधा होने से संकुल के बैठक में लम्बे समय तक रहने की बाध्यता नहीं होगी; समय बचेगा ।',
                '6.4. मोबाइल पर खाता बही की सुविधा होने से मिशन मैनेजर/ मिशन के अधिकारियों पर निर्भरता कम होगी – हम स्वयं सक्षम होंगे – बिना किसी के हस्तक्षेप के काम कर पाएँगे',
                '6.5. मोबाइल ऐप पर अंकगणित/ हिसाब करने सुविधाएँ उपलब्ध होंगी – ग़लतियाँ नहीं होगी ।',
                '6.6. और भी कई सुविधाएँ हो सकती हैं',
                '7. अगर इस तरह का मोबाइल ऐप लागू होता है तो क्या संकुल के कार्य में समय, ऊर्जा और खर्च बचेगा?',
                '8. क्या मोबाइल ऐप के लिए कोई शुल्क निर्धारित होना चाहिए?',
                '9.1. मोबाइल ऐप पर ही इसके संचालन के लिए उपयुक्त दिशा-निर्देश/ गाइडलाइन मिले ।',
                '9.2. राज्य मिशन से मिलनेवाले ऋणों व अन्य सुविधाओं की मोबाइल ऐप पर मैसज से पूर्व सूचना प्राप्त होना ।',
                '9.3. मोबाइल ऐप पर संकुल के खाता बही रखरखाव सम्बन्धी कार्य किया जा सके – रजिस्टर पर कार्य करने की आवश्यकता ना हो ।',
                '9.4. संकुल (CLF), ग्राम संगठन (VO), एवं समूह (SHG) स्तर पर ऋण के लेनदेन की पूरी रिकार्ड रखा जा सके । माहवार मूलधन व ब्याज सहित ऋण वापसी (EMI) की जानकारी मिले ।',
                '9.5. ऋण का भुगतान एवं ऋण वापसी की जानकारी का मैसज, ऋण देने व ऋण प्राप्त करने वाले दोनो को, मोबाइल ऐप पर ही मिले ।',
                '9.6. संकुल के खाताबही एवं अन्य सभी रिकार्ड का प्रिंट निकालने की सुविधा हो ।',
                '9.7. वित्तीय एवं डिजिटल साक्षरता सम्बन्धी सभी उपयोगी जानकारी उपलब्ध हो । प्रिंट निकालने की सुविधा हो ।',
                '9.8. मोबाइल ऐप प्रयोग करने पर अगर कोई शुल्क निर्धारित हो रहा हो तो उनका बिल एवं शुल्क भुगतान की रसीद ऐप पर ही मिले – ज़रूरत हो तो प्रिंट निकाला जा सके ।',
                '9.9. मोबाइल ऐप के उपयोग में असुविधा हो तों तत्काल मदद के लिए हेल्पलाइन की सुविधा हो',
                '10. आपने सभी प्रश्नों का जवाब कैसे भरा'
            ));
            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    $model->clf != null ? $model->clf->name_of_clf : '',
                    $model->clf != null ? $model->clf->district_name : '',
                    $model->clf != null ? $model->clf->block_name : '',
                    $model->ques1,
                    $model->ques2,
                    $model->ques3,
                    $model->ques4,
                    $model->ques5,
                    $model->ques_61 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques_62 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques_63 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques_64 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques_65 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques_66 == 1 ? 'हाँ' : 'नहीं',
                    $model->ques7,
                    $model->ques8,
                    ($model->ques_8 == 1 and $model->ques_91) ? $model->ques91oa : '',
                    ($model->ques_8 == 1 and $model->ques_92) ? $model->ques92oa : '',
                    ($model->ques_8 == 1 and $model->ques_93) ? $model->ques93oa : '',
                    ($model->ques_8 == 1 and $model->ques_94) ? $model->ques94oa : '',
                    ($model->ques_8 == 1 and $model->ques_95) ? $model->ques95oa : '',
                    ($model->ques_8 == 1 and $model->ques_96) ? $model->ques96oa : '',
                    ($model->ques_8 == 1 and $model->ques_97) ? $model->ques97oa : '',
                    ($model->ques_8 == 1 and $model->ques_98) ? $model->ques98oa : '',
                    ($model->ques_8 == 1 and $model->ques_99) ? $model->ques99oa : '',
                    $model->ques10
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }
    }

    public function actionView($feedbackid) {
        return $this->render('view', [
                    'model' => $this->findModel($feedbackid),
        ]);
    }

    protected function findModel($id) {
        if (($model = CboClfFeedback::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
