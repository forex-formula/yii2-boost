<?php

namespace yii\boost\tests\base;

use Exception;
use yii\boost\base\InvalidModelException;
use yii\codeception\TestCase;
use yii\boost\tests\TestForm;

class InvalidModelExceptionTest extends TestCase
{

    /**
     * @inheritdoc
     */
    public $appConfig = '@yii/boost/tests/config.php';

    public function testConstruct1()
    {
        $model = new TestForm;
        $exception = new InvalidModelException($model);
        $this->assertEquals('Invalid Model', $exception->getName());
        $this->assertSame($model, $exception->getModel());
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame(null, $exception->getPrevious());
    }

    public function testConstruct2()
    {
        $model = new TestForm;
        $previous = new Exception;
        $exception = new InvalidModelException($model, 'Error', 2, $previous);
        $this->assertEquals('Invalid Model', $exception->getName());
        $this->assertSame($model, $exception->getModel());
        $this->assertSame('Error', $exception->getMessage());
        $this->assertSame(2, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }

    public function testModelDebugData1()
    {
        $model = $this->getMock(TestForm::className(), ['hasErrors', 'getAttributes', 'getErrors']);
        $model->expects($this->once())->method('hasErrors')->willReturn(false);
        $model->expects($this->once())->method('getAttributes')->willReturn(['key1' => 'value1']);
        $model->expects($this->never())->method('getErrors');
        $exception = $this->getMock('yii\boost\base\InvalidModelException', ['getModel'], [], '', false);
        $exception->expects($this->once())->method('getModel')->willReturn($model);
        /* @var $exception InvalidModelException */
        $this->assertEquals([
            'class' => get_class($model),
            'attributes' => ['key1' => 'value1']
        ], $exception->getModelDebugData());
    }

    public function testModelDebugData2()
    {
        $model = $this->getMock(TestForm::className(), ['hasErrors', 'getAttributes', 'getErrors']);
        $model->expects($this->once())->method('hasErrors')->willReturn(true);
        $model->expects($this->once())->method('getAttributes')->willReturn(['key1' => 'value1']);
        $model->expects($this->once())->method('getErrors')->willReturn(['key2' => 'value2']);
        $exception = $this->getMock('yii\boost\base\InvalidModelException', ['getModel'], [], '', false);
        $exception->expects($this->once())->method('getModel')->willReturn($model);
        /* @var $exception InvalidModelException */
        $this->assertEquals([
            'class' => get_class($model),
            'attributes' => ['key1' => 'value1'],
            'errors' => ['key2' => 'value2']
        ], $exception->getModelDebugData());
    }
}
