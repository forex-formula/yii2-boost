<?php

namespace yii\boost\tests\filters;

use yii\codeception\TestCase;
use Yii;

class AjaxFilterTest extends TestCase
{

    /**
     * @inheritdoc
     */
    public $appConfig = '@yii/boost/tests/config.php';

    public function testAjaxRequest()
    {
        /* @var $request \yii\boost\tests\Request */
        $request = Yii::$app->getRequest();
        $request->setIsAjax(true);
        $this->assertEquals('yii\boost\tests\TestController::actionAjax', Yii::$app->runAction('test/ajax'));
    }

    public function testBadRequest()
    {
        $this->setExpectedException('yii\web\BadRequestHttpException');
        $this->assertEquals('yii\boost\tests\TestController::actionAjax', Yii::$app->runAction('test/ajax'));
    }
}
