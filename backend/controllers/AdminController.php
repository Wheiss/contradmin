<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 3/22/19
 * Time: 8:03 AM
 */

namespace backend\controllers;

use common\entities\Role;
use yii\web\Controller as BaseController;
use yii\filters\AccessControl;

abstract class AdminController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Role::ADMIN],
                    ],
                ],
            ],
        ];
    }
}