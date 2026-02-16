<?php

namespace common\models;

use Yii;
use common\models\rishta\RishtaNotificationTemplate;
use common\models\rishta\RishtaUserData;

/**
 * This is the model class for table "cbo_members".
 *
 * @property int $id
 * @property int $user_id
 * @property int $cbo_type
 * @property int $cbo_id
 * @property int|null $entry_type
 * @property int|null $role
 * @property int $shg_chairperson
 * @property int $shg_secretary
 * @property int $shg_treasurer
 * @property int $shg_member
 * @property int $vo_chairperson
 * @property int $vo_secretary
 * @property int $vo_treasurer
 * @property int $vo_member
 * @property int $clf_chairperson
 * @property int $clf_secretary
 * @property int $clf_treasurer
 * @property int $clf_member
 * @property int $bc_sakhi
 * @property int $samuh_sakhi
 * @property int $wada_sakhi
 * @property int $suggest_wada_sakhi
 * @property int $accountant
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $status
 */
class CboMembers extends \common\models\dynamicdb\cbo\CboactiveRecord {

    const CBO_TYPE_SHG = 1;
    const CBO_TYPE_VO = 2;
    const CBO_TYPE_CLF = 3;
    const CBO_MEMBER_STATUS_DELETE = -1;
    const CBO_MEMBER_STATUS_NO_DECIDE = 0;
    const CBO_MEMBER_STATUS_CONFIRM = 1;

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'cbo_type', 'cbo_id'], 'required'],
            [['user_id', 'cbo_type', 'cbo_id', 'entry_type', 'role', 'shg_chairperson', 'shg_secretary', 'shg_treasurer', 'shg_member', 'vo_chairperson', 'vo_secretary', 'vo_treasurer', 'vo_member', 'clf_chairperson', 'clf_secretary', 'clf_treasurer', 'clf_member', 'bc_sakhi', 'samuh_sakhi', 'wada_sakhi', 'suggest_wada_sakhi', 'accountant', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['cbo_id'], \common\validators\CheackcboroleValidator::className()],
            ['shg_chairperson', 'default', 'value' => 0],
            ['shg_secretary', 'default', 'value' => 0],
            ['shg_treasurer', 'default', 'value' => 0],
            ['shg_member', 'default', 'value' => 0],
            ['vo_chairperson', 'default', 'value' => 0],
            ['vo_secretary', 'default', 'value' => 0],
            ['vo_treasurer', 'default', 'value' => 0],
            ['vo_member', 'default', 'value' => 0],
            ['clf_chairperson', 'default', 'value' => 0],
            ['clf_secretary', 'default', 'value' => 0],
            ['clf_treasurer', 'default', 'value' => 0],
            ['clf_member', 'default', 'value' => 0],
            ['bc_sakhi', 'default', 'value' => 0],
            ['samuh_sakhi', 'default', 'value' => 0],
            ['wada_sakhi', 'default', 'value' => 0],
            ['suggest_wada_sakhi', 'default', 'value' => 0],
            ['accountant', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'cbo_type' => 'Cbo Type',
            'cbo_id' => 'Cbo ID',
            'entry_type' => 'Entry Type',
            'role' => 'Role',
            'shg_chairperson' => 'Shg Chairperson',
            'shg_secretary' => 'Shg Secretary',
            'shg_treasurer' => 'Shg Treasurer',
            'shg_member' => 'Shg Member',
            'vo_chairperson' => 'Vo Chairperson',
            'vo_secretary' => 'Vo Secretary',
            'vo_treasurer' => 'Vo Treasurer',
            'vo_member' => 'Vo Member',
            'clf_chairperson' => 'Clf Chairperson',
            'clf_secretary' => 'Clf Secretary',
            'clf_treasurer' => 'Clf Treasurer',
            'clf_member' => 'Clf Member',
            'bc_sakhi' => 'Bc Sakhi',
            'samuh_sakhi' => 'Samuh Sakhi',
            'wada_sakhi' => 'Wada Sakhi',
            'accountant' => 'Accountant',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCbotype() {
        $type = [self::CBO_TYPE_SHG => 'SHG', self::CBO_TYPE_VO => 'VO', self::CBO_TYPE_CLF => 'CLF'];
        return isset($type[$this->cbo_type]) ? $type[$this->cbo_type] : '';
    }

    public function getCbo() {
        if ($this->cbo_type == self::CBO_TYPE_SHG) {
            return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_id'])->joinWith(['gp']);
        }
        if ($this->cbo_type == self::CBO_TYPE_VO) {
            return $this->hasOne(\cbo\models\CboVo::className(), ['id' => 'cbo_id']);
        }
        if ($this->cbo_type == self::CBO_TYPE_CLF) {
            return $this->hasOne(\cbo\models\CboClf::className(), ['id' => 'cbo_id']);
        }
    }

    public function getShg() {

        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_id'])->joinWith(['gp']);
    }

    public function getSamuh() {
        return $this->hasOne(\common\models\wada\WadaApplication::className(), ['user_id' => 'user_id', 'cbo_shg_id' => 'cbo_id']);
    }

    public function getFormstatus() {
        if ($this->samuh == null) {
            return 'शुरू नहीं किया गया';
        } else {
            if ($this->samuh->form_number == null) {
                return 'शुरू नहीं किया गया';
            } else {
                $a = [
                    null => 'शुरू नहीं किया गय',
                    0 => 'शुरू नहीं किया गय',
                    1 => 'Section 1 : बेसिक सूचना',
                    2 => 'Section 2 : Mobility',
                    3 => 'Section 3 : टेक्नॉलजी पारंगतता',
                    4 => 'Section 4 : नेतृत्व',
                    5 => 'Section 5 : मल्टी-सेक्टर सेवाओं के बारे में जानकारी',
                    6 => 'Section 6',
                ];
                $status = '';
                if ($this->samuh->form_number == 6) {
                    if ($this->samuh->status == 1) {
                        $status = ' Save mode';
                    }
                    if ($this->samuh->status == 2) {
                        $status = ' Submit';
                    }
                }
                return isset($a[$this->samuh->form_number])? $a[$this->samuh->form_number] . $status:'शुरू नहीं किया गया';
            }
        }
    }

    public function afterSave($insert, $changedAttributes) {
        $attribute = CboMembers::findOne($this->id);
        try {
            $cbo_detail = new \common\models\dynamicdb\cbo_detail\CboMembers();
            $modelcbod = $cbo_detail::findOne($attribute->id);

            if (empty($modelcbod)) {
                $modelcbod = new \common\models\dynamicdb\cbo_detail\CboMembers();
            }
            $modelcbod->id = $attribute->id;
            $modelcbod->setAttributes($attribute->toArray());
            if ($modelcbod->save()) {
                
            } else {
//                print_r($modelcbod->getErrors());
//                exit;
            }
            $user_model = User::findOne($this->user_id);
            $rista = new \sakhi\components\Rishta($user_model);
            $user_model->user_app_data_update = 1;
            $user_model->menu_version_major = base\GenralModel::MENU_MAJOR_VERSION;
            $user_model->menu_version_minor = ($user_model->menu_version_minor + 1);
            $user_model->menu_version = ($user_model->menu_version_major + ('.' . $user_model->menu_version_minor));
            $user_model->splash_screen = $rista->splash_screen($this);
            $user_model->last_menu_updatetime = date("Y-m-d h:i:s");
            $user_model->save();
            $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $this->user_id]);
            if ($rishta_user_data_model == null) {
                $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
            }
            $rishta_user_data_model->user_id = $user_model->id;
            $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
            $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($this);
            $rishta_user_data_model->save();
            $app_detail_model = AppDetail::findOne(['user_id' => $this->user_id, 'status' => 1]);

            if ($app_detail_model != null) {
                $tempplate_model = \common\models\rishta\RishtaNotificationTemplate::findOne(\common\models\rishta\RishtaNotificationTemplate::APP_DATA_UPDATE_TEMP_ID);
                $noti_log_model = new \common\models\rishta\RishtaNotificationLog();
                $noti_log_model->user_id = $user_model->id;
                $noti_log_model->app_id = $user_model->app_id;
                $noti_log_model->visible = $tempplate_model->visible;
                $noti_log_model->acknowledge = $tempplate_model->acknowledge;
                $noti_log_model->message_title = $tempplate_model->name;
                $noti_log_model->message = $tempplate_model->template;
                $noti_log_model->notification_template_id = $tempplate_model->id;
                $noti_log_model->cron_status = 0;
                $noti_log_model->status = 0;
                $noti_log_model->genrated_on = new \yii\db\Expression('NOW()');

                if ($noti_log_model->save()) {
                    try {
                        $notification = \common\models\rishta\RishtaNotificationLog::findOne($noti_log_model->id);
                        $firbase_tocken = $user_model->firebase_token;
                        $firebase = new \common\components\GoogleFirebaseRishta($notification);
                        $response = $firebase->send($firbase_tocken);
                        $response_result = json_decode($response);
                        $notification->cron_status = '1';
                        $notification->send_count = ($notification->send_count + 1);
                        $notification_model_detail = new \common\models\rishta\RishtaNotificationLogFirebaseDetail();
                        $notification_model_detail->notification_log_id = $notification->id;
                        if ($response_result == null) {
                            $notification->status = -1;
                            $notification_model_detail->firebase_message = "No Token";
                        } else {
                            if ($response_result->success) {
                                $notification->status = 1;
                                $notification->send_datetime = new \yii\db\Expression('NOW()');
                                $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                            } else {
                                $notification->status = 2;
                                $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                            }
                        }
                        $notification_model_detail->save();
                        $notification->update();
                    } catch (\Exception $ex) {
                        
                    }
                }
//                $app_detail_model->status = 0;
//                $app_detail_model->date_of_uninstall = new \yii\db\Expression('NOW()');
//                $app_detail_model->save();
            }
        } catch (\Exception $ex) {
//            echo "<pre>";
//            print_r($ex->getFile());exit;
        }
        return true;
    }

//    private function updatecboshg() {
//        
//    }
}
