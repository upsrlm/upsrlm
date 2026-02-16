<?php

namespace bc\modules\transaction;

/**
 * transaction module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'bc\modules\transaction\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (\Yii::$app->request->isConsoleRequest) {
            \Yii::configure($this, ['controllerNamespace' => 'bc\modules\transaction\commands']);
            \Yii::configure($this, require(__DIR__ . '/config/main-local-console.php'));
        } else {
            \Yii::configure($this, require(__DIR__ . '/config/main-local.php'));
        }
    }

    /**
     * Set District Dump Database any time during transaction process
     *
     * @param [type] $db
     * @return void
     */
    public function setDistrictDumpDb($db)
    {
        return $this->bctransactiondistrictbcdb->dsn = 'mysql:host=localhost;dbname=' . $db;
    }
}
