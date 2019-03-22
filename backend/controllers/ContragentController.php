<?php

namespace backend\controllers;

use backend\models\ContragentSearch;
use yii\filters\AccessControl;
use Yii;

class ContragentController extends AdminController
{
    /**
     * Contragents index action
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ContragentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
