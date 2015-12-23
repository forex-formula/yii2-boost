<?php

namespace yii\boost\tests\base;

use yii\boost\base\InvalidModelException;
use yii\codeception\TestCase;
use Yii;

class InvalidModelExceptionTest extends TestCase
{

    /**
     * @inheritdoc
     */
    public $appConfig = '@yii/boost/tests/config.php';

    public function testConstruct()
    {
    }
}
