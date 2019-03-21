<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/17/19
 * Time: 11:59 PM
 */
return [
    'user' => [
//            'class' => 'common\models\User',
        'identityClass' => 'common\models\User',
        'enableAutoLogin' => true,
        'identityCookie' => ['name' => 'identity', 'httpOnly' => true],
        'loginUrl' => '/auth/login',
    ],
];