<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/17/19
 * Time: 3:53 PM
 */
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => false,
    'hostInfo' => 'http://backend.contradmin.me',
    'rules' => require __DIR__ . '/../../backend/config/routes.php',
];