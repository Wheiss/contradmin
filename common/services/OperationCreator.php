<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 3/20/19
 * Time: 10:42 PM
 */

namespace common\services;


use common\models\Account;
use common\models\Contragent;
use common\models\Operation;
use Yii;

/**
 * Class OperationCreator
 * @package common\services
 */
class OperationCreator
{
    private $operation = null;
    private $data = [];

    public function __construct(Operation $operation, $data)
    {
        $this->operation = $operation;
        $this->data = $data;
    }

    /**
     * Creates an operation
     * @return bool
     */
    public function create()
    {
        $data = $this->data;

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {

            $contragentEmail = $data['contragent'];
            $contragent = Contragent::findByEmail($contragentEmail);
            if (!$contragent) {
                $contragent = new Contragent();
                $contragent->load([
                    'Contragent' => [
                        'email' => $contragentEmail
                    ],
                ]);
                $contragent->save();
            }

            $accountName = $data['account_name'];
            $account = Account::findByName($accountName);
            if(!$account) {
                $account = new Account();
                $account->load([
                    'Account' => [
                        'name' => $accountName,
                    ],
                ]);
                $account->save();
            }

            $sum = $data['sum'];
            $direction = $data['direction'];
            $contragent->moveFunds($sum, $direction);
            $account->moveFunds($sum, $direction);
            $newOperation = new Operation();
            $data = [
                'Operation' => array_merge(
                    $data,
                    [
                        'created_at' => time(),
                        'account_id' => $account->id,
                        'contragent_balance' => $contragent->getBalance(),
                        'account_balance' => $account->getBalance(),
                    ]
                ),
            ];
            $newOperation->load($data);
            if (!$newOperation->save()) {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
    }
}