<?php

namespace common\models\dynamicdb\support;

use Yii;

/**
 * This is the model class for table "conversation_detail".
 *call_date
 * @property string $conversation_code
 * @property string $stakeholder_code
 * @property string $call_type
 * @property string $calling_no
 * @property string $calling_person_name
 * @property string $calling_person_designation
 * @property string $calling_person_district
 * @property string $calling_person_block
 * @property string $calling_person_gp
 * @property string $call_response
 * @property string $comments
 * @property string|null $call_date
 * @property string $cc_executive_code
 */
class ConversationDetail extends SupportDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'technosys_conversation_detail';
    }

   

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['conversation_code', 'stakeholder_code', 'call_type', 'calling_no', 'calling_person_name', 'calling_person_designation', 'calling_person_district', 'calling_person_block', 'calling_person_gp', 'call_response', 'comments', 'cc_executive_code'], 'required'],
            [['conversation_code'], 'string', 'max' => 12],
            [['stakeholder_code'], 'string', 'max' => 117],
            [['call_type', 'cc_executive_code'], 'string', 'max' => 10],
            [['calling_no'], 'string', 'max' => 20],
            [['calling_person_name'], 'string', 'max' => 225],
            [['calling_person_designation', 'calling_person_district', 'calling_person_block', 'calling_person_gp'], 'string', 'max' => 150],
            [['call_response', 'comments'], 'string', 'max' => 255],
            [['call_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'conversation_code' => 'Conversation Code',
            'stakeholder_code' => 'Stakeholder Code',
            'call_type' => 'Call Type',
            'calling_no' => 'Calling No',
            'calling_person_name' => 'Calling Person Name',
            'calling_person_designation' => 'Calling Person Designation',
            'calling_person_district' => 'District',
            'calling_person_block' => 'Block',
            'calling_person_gp' => 'GP',
            'call_response' => 'Call Response',
            'comments' => 'Comments',
            'call_date'=>'Call Date',
            'cc_executive_code' => 'Executive Name',
        ];
    }

    public function getConvstatus() {

        return $this->hasMany(ConversationStatus::className(), ['conversation_code' => 'conversation_code']);
    }

    public function getCtype() {
        $call_type = ['I' => 'Incoming', 'O' => 'Outgoing','C'=>'Cancel'];
        return isset($call_type[$this->call_type]) ? $call_type[$this->call_type] : $this->call_type;
    }
    public function getBc() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'stakeholder_code']);
    }
    public function getExecutive() {
        return $this->hasOne(master\MasterCcAgent::className(), ['cc_executive_code' => 'cc_executive_code']);
    }

}
