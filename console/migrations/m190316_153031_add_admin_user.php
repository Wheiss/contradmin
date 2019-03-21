<?php

use yii\db\Migration;

/**
 * Class m190316_153031_add_admin_user
 */
class m190316_153031_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new \common\models\User([
            'username' => 'admin',
            'email' => 'admin@mail.com',
        ]);
        $user->setPassword('qwerty');
        $user->generateAuthKey();
        $auth = Yii::$app->authManager;
        $user->save();
        $auth->assign($auth->getRole(\common\entities\Role::ADMIN), $user->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $admin = \common\models\User::findByUsername('admin');
        if($admin) {
            $auth = Yii::$app->authManager;
            $auth->revokeAll($admin->getId());
            $admin->delete();
        }

        return true;
    }

}
