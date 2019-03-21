<?php

namespace frontend\controllers;

use common\entities\Role;
use common\models\Contragent;
use common\services\OperationCreator;
use frontend\models\OperationCreate;
use frontend\models\OperationSearch;
use yii\filters\AccessControl;
use Yii;

class OperationController extends \yii\web\Controller
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
                        'roles' => [Role::CONTRAGENT]
                    ]
                ]
            ]
        ];
    }

    /**
     * List of contragent operations
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->getIdentity();
        $contragent = Contragent::findByEmail($user->getEmail());
        $operationsSearch = new OperationSearch();
        $operationsSearch->contragent = $contragent;
        $operationsProvider = $operationsSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'contragent' => $contragent,
            'operationsSearch' => $operationsSearch,
            'operationsProvider' => $operationsProvider,
        ]);
    }

    /**
     * Creates a new Operation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OperationCreate();
        $user = Yii::$app->user->getIdentity();
        $contragent = Contragent::findByEmail($user->getEmail());

        $post = Yii::$app->request->post();
        if (!empty($post)) {
            $operationCreator = new OperationCreator(
                $model,
                array_merge($post[$model->formName()], ['contragent' => $contragent->getEmail()])
            );
            if($operationCreator->create()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
