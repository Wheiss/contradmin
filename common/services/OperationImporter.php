<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 3/19/19
 * Time: 10:35 PM
 */

namespace common\services;

use common\models\Account;
use common\models\Contragent;
use common\models\Operation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;

/**
 * Class OperationImporter
 * Imports operations from excel tables
 * @package common\services
 */
class OperationImporter
{
    private $file = null;
    private $errors = [];

    // field indexes of imported document
    const FIELD_SUM = 0;
    const FIELD_CREATED_AT = 1;
    const FIELD_ACCOUNT = 2;
    const FIELD_CONTRAGENT_EMAIL = 3;
    const FIELD_DIRECTION = 4;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Imports document data to Operation[]
     * @return Operation[]
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function import()
    {
        $spreadsheet = IOFactory::load($this->file);
        $sheets = $spreadsheet->getAllSheets();
        foreach ($sheets as $sheet) {
            $excelData = $sheet->toArray();
            $operations = [];
            $rowCounter = 0;
            foreach ($excelData as $dataItem) {
                // If row is empty lets go next sheet
                if (empty($dataItem[0])) {
                    continue 2;
                }
                $rowCounter++;
                $db = Yii::$app->db;
                $transaction = $db->beginTransaction();
                try {
                    $sum = $dataItem[self::FIELD_SUM];
                    $direction = $dataItem[self::FIELD_DIRECTION];
                    $contragent = $this->processContragent($dataItem);
                    $account = $this->processAccount($dataItem);

                    $operation = new Operation();
                    $preparedData = [
                        'Operation' => [
                            'sum' => $sum,
                            'account_id' => $account->id,
                            'created_at' => $dataItem[self::FIELD_CREATED_AT],
                            'contragent' => $contragent->getEmail(),
                            'direction' => $direction,
                            'contragent_balance' => $contragent->getBalance(),
                            'account_balance' => $account->getBalance(),
                        ],
                    ];
                    $operation->load($preparedData);
                    $operation->save();
                    $transaction->commit();
                    $operations[] = $operation;

                } catch (\Exception $e) {
                    $transaction->rollBack();
                    $this->errors[] = 'Error on sheet: '
                        . $sheet->getTitle() . ', on row #' . $rowCounter . ': ' . $e->getMessage();
                }

            }
        }

        return $operations;
    }

    /**
     * Find or create contragent and move its funds
     * @param $dataItem
     * @return Contragent|null
     */
    private function processContragent($dataItem)
    {
        $contragent = Contragent::findByEmail($dataItem[self::FIELD_CONTRAGENT_EMAIL]);
        if (empty($contragent)) {
            $contragent = new Contragent();
            $email = $dataItem[self::FIELD_CONTRAGENT_EMAIL];
            $contragent->load([
                'Contragent' => [
                    'email' => $email
                ],
            ]);
            $contragent->save();
        }
        $sum = $dataItem[self::FIELD_SUM];
        $contragent->moveFunds($sum, $dataItem[self::FIELD_DIRECTION]);
        return $contragent;
    }

    /**
     * Find or create account and move its funds
     * @param $dataItem
     * @return Account|null
     */
    private function processAccount($dataItem)
    {
        $name = $dataItem[self::FIELD_ACCOUNT];
        $account = Account::findOne(['name' => $name]);
        if (empty($account)) {
            $account = new Account();
            $account->load([
                'Account' => [
                    'name' => (string)$name,
                ],
            ]);
            $account->save();
        };
        $sum = $dataItem[self::FIELD_SUM];
        $account->moveFunds($sum, $dataItem[self::FIELD_DIRECTION]);

        return $account;
    }

    /**
     * Get import errors
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}