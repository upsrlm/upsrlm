<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\training\models\RsetisCenter;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\RsetisBatchTraining;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\selection\models\SrlmBcApplication;
use bc\models\NotificationTemplate;
use bc\models\NotificationLog;
use bc\models\NotificationLogFirebaseDetail;

class CenterTrainingForm extends Model {

    public $id;
    public $batch_name;
    public $district_code;
    public $district_name;
    public $rsetis_center_id;
    public $training_start_date;
    public $training_end_date;
    public $center_training_model;
    public $trainin_batch_model;
    public $schedule_date_of_exam;
    public $no_of_participant;
    public $participants_ids;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $center_model;
    public $batch_model;
    public $district_model;

    public function __construct($trainingmodel = null, $district_code) {
        $this->district_model = \bc\models\master\MasterDistrict::findOne(['district_code' => $district_code]);
        $this->district_code = $this->district_model->district_code;
        $this->district_name = $this->district_model->district_name;
        $this->center_training_model = \Yii::createObject([
                    'class' => RsetisCenterTraining::className()
        ]);
        $this->batch_model = \Yii::createObject([
                    'class' => RsetisBatchTraining::className()
        ]);
        $applications = SrlmBcApplication::find()->where(['district_code' => $this->district_code, 'form_number' => SrlmBcApplication::FORM_STATUS_PART_4, 'gender' => 2, 'status' => SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['=', 'training_status', SrlmBcApplication::TRAINING_STATUS_AGREE_TRAINING])->orderBy('first_name asc')->all();
        $this->no_of_participant = SrlmBcApplication::find()->where(['district_code' => $this->district_code, 'form_number' => SrlmBcApplication::FORM_STATUS_PART_4, 'gender' => 2, 'status' => SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['=', 'training_status', SrlmBcApplication::TRAINING_STATUS_AGREE_TRAINING])->orderBy('first_name asc')->count();
        $this->participants_ids = \yii\helpers\ArrayHelper::getColumn($applications, 'id');
        $this->center_model = RsetisCenter::findOne(['district_code' => $this->district_code]);
        if ($trainingmodel != null) {
            $this->center_training_model = $trainingmodel;
            $this->center_model = $this->center_training_model->center;
            $this->batch_model = $this->center_training_model->tbatch;
            $this->batch_name = $this->batch_model->batch_name;
            $this->rsetis_center_id = $this->center_training_model->rsetis_center_id;
            $this->training_start_date = $this->center_training_model->training_start_date != null ? \Yii::$app->formatter->asDatetime($this->center_training_model->training_start_date, "php:d-m-Y") : '';
            $this->training_end_date = $this->center_training_model->training_end_date != null ? \Yii::$app->formatter->asDatetime($this->center_training_model->training_end_date, "php:d-m-Y") : '';
            $this->schedule_date_of_exam = $this->center_training_model->schedule_date_of_exam != null ? \Yii::$app->formatter->asDatetime($this->center_training_model->schedule_date_of_exam, "php:d-m-Y") : '';
        }
    }

    public function rules() {
        return [
            [['batch_name', 'district_code', 'training_start_date', 'training_end_date', 'schedule_date_of_exam'], 'required'],
            [['rsetis_center_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['training_end_date'], \bc\modules\training\components\validators\TrainingStartEndDateValidator::className()],
            [['batch_name'], 'trim'],
            [['batch_name'], 'string', 'min' => 4, 'max' => 255],
            ['training_start_date', 'validateStartDate'],
            ['schedule_date_of_exam', 'validateScheduleDate']
        ];
    }

    public function validateScheduleDate($attribute) {
        if ($this->training_end_date != '' && $this->schedule_date_of_exam != '') {
            if (strtotime($this->schedule_date_of_exam) < strtotime($this->training_end_date)) {
                $this->addError($attribute, "Schedule date of exam  can not less than training end date");
            }
        }
    }

    public function validateStartDate($attribute) {
        if ($this->training_start_date != '') {
            $day_name = date('D', strtotime(date('y-m-d')));
            if (strtotime($this->training_start_date) < strtotime(date('y-m-d'))) {
                $d1 = new \DateTime(date('Y-m-d', strtotime($this->training_start_date)));
                $d2 = new \DateTime(date('Y-m-d'));
                $interval = $d1->diff($d2);
                $diff = $interval->format('%a');
                if ($diff > 6) {
                    $this->addError($attribute, "Training Start date " . $this->training_start_date . " Not allowed");
                }
            }
//            if (strtotime($this->training_start_date) < strtotime('2021-01-01')) {
//
//                $this->addError($attribute, "Training Start date " . $this->training_start_date . " Not allowed");
//            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'rsetis_center_id' => 'Venue',
            'training_title' => 'training_title',
            'training_start_date' => 'Training Start Date',
            'training_end_date' => 'Training End Date',
            'schedule_date_of_exam' => 'Schedule date of exam',
            'no_of_batch' => 'No Of batch',
            'participants_ids' => 'Batch',
        ];
    }

    public function save() {
        $this->center_training_model->rsetis_center_id = $this->center_model->id;
        $this->center_training_model->training_start_date = $this->training_start_date;
        $this->center_training_model->training_end_date = $this->training_end_date;
        $this->center_training_model->schedule_date_of_exam = $this->schedule_date_of_exam;
        $this->center_training_model->district_code = $this->district_code;
        $this->center_training_model->district_name = $this->district_name;
        if ($this->center_training_model->save()) {
            $this->batch_model->batch_name = $this->batch_name;
            $this->batch_model->district_code = $this->district_code;
            $this->batch_model->district_name = $this->district_name;
            $this->batch_model->rsetis_center_id = $this->center_training_model->rsetis_center_id;
            $this->batch_model->rsetis_center_training_id = $this->center_training_model->id;
            $this->batch_model->save();
            if (isset($this->participants_ids) and is_array($this->participants_ids)) {
                foreach ($this->participants_ids as $participants_id) {
                    $batchp_model = RsetisBatchParticipants::findOne(['bc_application_id' => $participants_id]);
                    if ($batchp_model == null) {
                        $batchp_model = new RsetisBatchParticipants();
                    }
                    $bc_selection_app_model = SrlmBcApplication::find()->where(['id' => $participants_id])->one();
                    if ($bc_selection_app_model->training_status == SrlmBcApplication::TRAINING_STATUS_AGREE_TRAINING) {
                        $batchp_model->setAttributes([
                            'bc_application_id' => $bc_selection_app_model->id,
                            'rsetis_center_id' => $this->center_training_model->rsetis_center_id,
                            'rsetis_batch_id' => $this->batch_model->id,
                            'rsetis_center_training_id' => $this->center_training_model->id,
                            'bc_selection_user_id' => $bc_selection_app_model->srlm_bc_selection_user_id,
                            'training_status' => SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH,
                            'status' => 1
                        ]);
                        if ($batchp_model->save()) {
                            $bc_selection_app_model->training_id = $this->center_training_model->id;
                            $bc_selection_app_model->training_center_id = $this->center_training_model->rsetis_center_id;
                            $bc_selection_app_model->training_batch_id = $this->batch_model->id;
                            $bc_selection_app_model->training_status = SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH;
                            $bc_selection_app_model->action_type = SrlmBcApplication::ACTION_TYPE_RSETHIS_ASSIGN_BATCH;
                            $bc_selection_app_model->update();
                        }
                    }
                }
            }
            $model = new \bc\modules\training\models\TrainingEntity($this->center_training_model);
            $model->calendarpopulate();
            $this->center_model->save();
            $this->batch_model->save();
            $this->center_training_model->save();
            //$this->acknowlagetemplate6();
        } else {
            
        }

        return $this;
    }

    public function acknowlagetemplate6() {
        $models = SrlmBcApplication::find()->select('id')->andWhere(['training_id' => $this->center_training_model->id])->orderBy('id asc')->asArray()->all();
        $template_model = NotificationTemplate::findOne(NotificationTemplate::SHORTLISTED_BC_FORMING_BATCH_TEMPLATE_ID);
        $time = "10 am";
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
            $noti_log_model = new NotificationLog();
            $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
            $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
            $noti_log_model->detail_id = $template_model->id;
            $noti_log_model->user_id = $model->user->id;
            $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
            $noti_log_model->visible = $template_model->visible;
            $noti_log_model->acknowledge = $template_model->acknowledge;
            $noti_log_model->message_title = $template_model->name;
            $noti_log_model->message = sprintf($template_model->template, $this->center_training_model->training_start_date, $this->center_training_model->district_name, $time, $this->center_training_model->schedule_date_of_exam);
            $noti_log_model->cron_status = 0;
            $noti_log_model->status = 0;
            if ($noti_log_model->save()) {
                try {
                    $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
                    $firbase_tocken = $notification->bcuser->firebase_token;
                    //$firbase_tocken='eNKLe5GvSqWUmBpYmcV2jo:APA91bFgVzZ2F1FVu1fZiVBtLQ1tvq3tRbbk80yxCCKH11kTcbP4ppRKkx0QysxFmk7sLGIoQkTOlYw-xg8jpxHL9HIRiVsVMI0Jml1oSvld_g0Wx7A1wGg2KUIo2DLUl1ED-lKAegLJ';

                    $firebase = new \bc\components\GoogleFirebase($notification);
                    $response = $firebase->send($firbase_tocken);

                    $response_result = json_decode($response);
                    $notification->cron_status = '1';
                    $notification->send_count = ($notification->send_count + 1);
                    $notification_model_detail = new NotificationLogFirebaseDetail();
                    $notification_model_detail->notification_log_id = $notification->id;
                    if ($response_result == null) {
                        $notification->status = 0;
                        $notification_model_detail->firebase_message = "No Token";
                    } else {
                        if ($response_result->success) {
                            $notification->status = 1;
                            $notification->send_datetime = new \yii\db\Expression('NOW()');
                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                        } else {
                            $notification->status = 0;
                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                        }
                    }
                    $notification_model_detail->save();
                    $notification->update();

                    $model->viewtemp6 = 1;
                    $model->update();
                } catch (\Exception $ex) {
                    
                }
            } else {
                
            }
        }
    }

}
