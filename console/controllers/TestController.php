<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/17/19
 * Time: 11:54 PM
 */

namespace console\controllers;


use common\models\Contragent;
use common\models\User;
use yii\console\Controller;
use yii\helpers\VarDumper;

class TestController extends Controller
{
    public function actionTest()
    {
        $contragent = Contragent::find()->one();
        VarDumper::dump($contragent->owner);
//        $user = User::findByUsername('pok');
//        VarDumper::dump($user->contragent);
    }
}