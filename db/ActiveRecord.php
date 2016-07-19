<?php

namespace yii\boost\db;

use yii\boost\base\ModelDebugTrait;
use yii\db\Expression;
use Yii;
use yii\db\ActiveRecord as YiiActiveRecord;

class ActiveRecord extends YiiActiveRecord
{

    use ModelDebugTrait;

    /**
     * @inheritdoc
     * @return ActiveQuery
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    /**
     * @inheritdoc
     */
    public static function findAll($condition = null)
    {
        if (is_null($condition)) {
            return static::find()->all();
        } else {
            return parent::findAll($condition);
        }
    }

    /**
     * @return string[]
     */
    public function displayField()
    {
        return $this->primaryKey();
    }

    /**
     * @inheritdoc
     */
    public function activeAttributes()
    {
        return array_filter(parent::activeAttributes(), function ($attribute) {
            return !($this->{$attribute} instanceof Expression);
        });
    }
}
