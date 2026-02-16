<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "media_coverage".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $url
 * @property string|null $date
 * @property string|null $media_by
 * @property int|null $type
 * @property string|null $file
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class MediaCoverage extends \yii\db\ActiveRecord {

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
                'value' => function() {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'media_coverage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'url'], 'required'],
            [['title'], 'trim'],
            [['description'],'safe'],
            [['description'],'default','value'=>''],
            [['description'], 'string'],
            [['date'], 'safe'],
            [['type', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title'], 'string', 'max' => 1000],
            [['url', 'file'], 'string', 'max' => 500],
            [['media_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'url' => 'Url',
            'date' => 'Date',
            'media_by' => 'Media By',
            'type' => 'Type',
            'file' => 'File',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {

        if ($this->date != null and $this->date != '') {
            $this->date = \Yii::$app->formatter->asDatetime($this->date, "php:Y-m-d");
        }

        return parent::beforeSave($insert);
    }

    public function getMediatype() {
        $array = [1 => 'News', 2 => 'Youtube Video', 3 => 'Blog'];
        return isset($array[$this->type]) ? $array[$this->type] : '';
    }

}
