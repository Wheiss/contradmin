<?php
namespace frontend\models;

use common\entities\Role;
use common\models\Contragent;
use yii\base\Model;
use common\models\User;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            if (!$user->save()) {
                return null;
            };

            $auth = \Yii::$app->getAuthManager();
            $role = $auth->getRole(Role::CONTRAGENT);
            $auth->assign($role, $user->getId());
            $this->createContragent($user);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }


        return  $user;
    }

    /**
     * Create contragent for new user
     * @param $user
     */
    protected function createContragent($user)
    {
        // if contragent exists link to it, else - create new
        $contragent = Contragent::findByEmail($user->getEmail());
        if(!$contragent) {
            $contragent = new Contragent();
            $contragent->load([
                'Contragent' => [
                    'email' => $user->getEmail()
                ],
            ]);
            $contragent->save();
        }
        $user->link('contragent', $contragent);
    }
}
