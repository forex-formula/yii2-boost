<?php

namespace yii\boost\tests\filters;

use yii\phpunit\TestCase;
use Yii;

class AjaxFilterTest extends TestCase
{

    public function testAjaxRequest()
    {
        /* @var $request \yii\boost\tests\Request */
        $request = Yii::$app->getRequest();
        $request->setIsAjax(true);
        $this->assertEquals('ok', Yii::$app->runAction('test/get-ok'));
    }

    public function testNonAjaxRequest()
    {
        $this->expectException('yii\web\BadRequestHttpException');
        $this->assertEquals('ok', Yii::$app->runAction('test/get-ok'));
    }
}
