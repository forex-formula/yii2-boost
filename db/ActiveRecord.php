<?php

namespace yii\boost\db;

use yii\db\Expression;
use yii\boost\base\ModelDebugTrait;
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
     * @return string[]|Expression
     */
    public static function displayField()
    {
        return static::primaryKey();
    }

    /**
     * @return string[]
     */
    public static function hasManyRelationNames()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public static function hasOneRelationNames()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function createValidators()
    {
        $validators = parent::createValidators();
        /* @var $validator \yii\validators\Validator */
        foreach ($validators as $validator) {
            if (is_null($validator->when)) {
                $validator->when = function ($model, $attribute) {
                    return !$model->$attribute instanceof Expression;
                };
            }
        }
        return $validators;
    }
}
