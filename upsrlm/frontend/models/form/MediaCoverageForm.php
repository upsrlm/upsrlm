<?php

namespace frontend\models\form;

use Yii;
use frontend\models\MediaCoverage;
use yii\base\Model;

/**
 * MediaCoverageForm is the model behind the MediaCoverage
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class MediaCoverageForm extends Model {

    /**
     * {@inheritdoc}
     */
    public $id;
    public $title;
    public $description;
    public $url;
    public $date;
    public $media_by;
    public $type;
    public $file;
    public $updated_by;
    public $created_by;
    public $updated_at;
    public $created_at;
    public $status;
    public $media_coverage_model;
    public $isNew;
    public $type_option = [];
    public $base_path;

    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {
        $this->base_path = Yii::$app->params['basepath'] . 'frontend/web/uploads/media_coverage';
        $this->type_option = [1 => 'News', 2 => 'Youtube Video', 3 => 'Blog'];
        $this->media_coverage_model = \Yii::createObject([
                    'class' => MediaCoverage::className()
        ]);

        $this->isNew = true;
        if ($model != null) {
            $this->isNew = false;
            $this->media_coverage_model = $model;
            $this->id = $this->media_coverage_model->id;
            $this->title = $this->media_coverage_model->title;
            $this->description = $this->media_coverage_model->description;
            $this->url = $this->media_coverage_model->url;
            $this->date = $this->media_coverage_model->date != NULL ? \Yii::$app->formatter->asDatetime($this->media_coverage_model->date, "php:d-m-Y") : '';
            $this->media_by = $this->media_coverage_model->media_by;
            $this->file = $this->media_coverage_model->file;
            $this->type = $this->media_coverage_model->type;
        }
    }

    public function rules() {
        return [
            [['title', 'url'], 'required'],
            [['title'], 'trim'],
            [['url'], 'url'],
            [['description'], 'string'],
            [['description'], 'safe'],
            [['description'], 'default', 'value' => ''],
            [['date'], 'required'],
            [['date'], 'date', 'format' => 'php:d-m-Y'],
            [['type'], 'required'],
            [['type', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title'], 'string', 'max' => 1000],
            [['url'], 'string', 'max' => 500],
            [['media_by'], 'string', 'max' => 255],
            [['media_by'], 'trim'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,, gif, png'],
            [['file'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
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

}
