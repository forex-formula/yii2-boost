<?php

namespace yii\boost\tests\db;

use yii\boost\tests\TestActiveRecord;
use yii\phpunit\TestCase;

class ActiveRecordTest extends TestCase
{

    public function testCreateValidators()
    {
        $model = new TestActiveRecord;
        static::assertTrue($model->isAttributeRequired('requiredField'));
    }
}
