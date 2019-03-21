<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/17/19
 * Time: 5:40 PM
 */

namespace backend\models;

use common\entities\Role;
use common\models\LoginForm as BaseForm;
use Yii;

class LoginForm extends BaseForm
{
    /**
     * {@inheritdoc}
     */
    protected function canLogin()
    {
        if(!parent::canLogin()) {
            return false;
        }
        $auth = Yii::$app->getAuthManager();
        $hasAccess = $auth->checkAccess($this->getUser()->getId(), Role::ADMIN);
        if(!$hasAccess) {
            $this->addError('username', 'You have no access to admin panel');
        }

        return $hasAccess;
    }
}