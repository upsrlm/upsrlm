<?php
if (file_exists(dirname(__DIR__, 2) . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotenv->safeLoad();
}
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@sakhi', dirname(dirname(__DIR__)) . '/sakhi');
Yii::setAlias('@cbo', dirname(dirname(__DIR__)) . '/cbo');
Yii::setAlias('@bc', dirname(dirname(__DIR__)) . '/bc');
Yii::setAlias('@hr', dirname(dirname(__DIR__)) . '/hr');
Yii::setAlias('@file', dirname(dirname(__DIR__)) . '/file');
Yii::setAlias('@bcsakhi', dirname(dirname(__DIR__)) . '/bcsakhi');
Yii::setAlias('@bccallcenter', dirname(dirname(__DIR__)) . '/bccallcenter');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

