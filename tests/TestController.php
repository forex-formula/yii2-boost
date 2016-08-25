<?php

namespace yii\boost\tests;

use yii\boost\filters\AjaxFilter;
use yii\web\Controller;

class TestController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => AjaxFilter::className(),
                'only' => ['get-ok']
            ]
        ];
    }

    public function actionGetOk()
    {
        return 'ok';
    }
}
