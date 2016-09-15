<?php

namespace yii\boost\tests;

use yii\boost\db\ActiveRecord;

class TestActiveRecord extends ActiveRecord
{

    /**
     * @var string
     */
    public $requiredField;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requiredField'], 'required']
        ];
    }
}
