<?php

namespace console\controllers;

use common\models\User;
use Yii;
use common\entities\Role;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $seeContragentPage = $auth->createPermission('seeContragentPage');
        $seeContragentPage->description = 'See contragent page';
        $auth->add($seeContragentPage);

        // добавляем разрешение "updatePost"
        $seeAdminPage = $auth->createPermission('seeAdminPage');
        $seeAdminPage->description = 'See admin page';
        $auth->add($seeAdminPage);

        // добавляем роль "contragent" и даём роли разрешение "viewContragentPage"
        $contragent = $auth->createRole(Role::CONTRAGENT);
        $auth->add($contragent);
        $auth->addChild($contragent, $seeContragentPage);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole(Role::ADMIN);
        $auth->add($admin);
        $auth->addChild($admin, $seeAdminPage);
    }

}
