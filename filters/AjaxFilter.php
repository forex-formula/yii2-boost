<?php

namespace yii\boost\filters;

use yii\base\ActionFilter;
use yii\web\BadRequestHttpException;
use Yii;

class AjaxFilter extends ActionFilter
{

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->getRequest()->getIsAjax()) {
            throw new BadRequestHttpException;
        }
        return parent::beforeAction($action);
    }
}
