<?php
return [
    'name' => 'Contradmin',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'itemFile' => __DIR__ . '/../rbac/items.php',
            'assignmentFile' => __DIR__ . '/../rbac/assignments.php',
        ],
        'urlManagerBackend' => require __DIR__ . '/url-manger-backend.php',
    ],
];
