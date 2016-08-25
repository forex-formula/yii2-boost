<?php

namespace yii\boost\tests\db;

use yii\boost\db\ActiveQuery;
use yii\phpunit\TestCase;
use Yii;

class ActiveQueryTest extends TestCase
{

    public function testPropertyAlias()
    {
        $mock = $this->createPartialMock(ActiveQuery::className(), ['getAlias']);
        $mock->method('getAlias')->willReturn('foo');
        /* @var $mock ActiveQuery */
        $this->assertEquals('foo', $mock->alias);
    }

    public function testMethodGetA()
    {
        $mock = $this->createPartialMock(ActiveQuery::className(), ['getAlias']);
        $mock->method('getAlias')->willReturn('foo');
        /* @var $mock ActiveQuery */
        $this->assertEquals('foo', $mock->getA());
    }

    public function testPropertyA()
    {
        $mock = $this->createPartialMock(ActiveQuery::className(), ['getAlias']);
        $mock->method('getAlias')->willReturn('foo');
        /* @var $mock ActiveQuery */
        $this->assertEquals('foo', $mock->a);
    }

    public function testMethodA()
    {
        $mock = $this->createPartialMock(ActiveQuery::className(), ['getAlias']);
        $mock->method('getAlias')->willReturn('foo');
        /* @var $mock ActiveQuery */
        $this->assertEquals('foo', $mock->a());
        $this->assertEquals('foo.column', $mock->a('column'));
        $this->assertEquals([
            'foo.column1' => 1,
            'foo.column2' => 2
        ], $mock->a([
            'column1' => 1,
            'column2' => 2
        ]));
    }
}
