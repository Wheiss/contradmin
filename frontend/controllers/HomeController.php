<?php

namespace frontend\controllers;

class HomeController extends \yii\web\Controller
{
    /**
     * Home
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
