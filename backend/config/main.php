<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => array_merge([
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => require __DIR__ . '/../../common/config/url-manger-backend.php',
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'auth',
        ],
    ], require __DIR__ . '/../../common/config/shared/components.php'),
    'params' => $params,
];
