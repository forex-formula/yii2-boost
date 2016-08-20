<?php

namespace yii\boost\db;

use yii\db\Expression;
use yii\helpers\Inflector;
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
        return new ActiveQuery(get_called_class());
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
     * @param string|array|Expression $condition
     * @param array $params
     * @return array
     */
    public static function findListItems($condition = null, $params = [])
    {
        if (is_null($condition)) {
            return static::find()->listItems()->column();
        } else {
            return static::find()->andWhere($condition, $params)->listItems()->column();
        }
    }

    /**
     * @return string
     */
    public static function modelLabel()
    {
        return Inflector::titleize(static::formName());
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
    public static function havingManyRelationNames()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public static function havingOneRelationNames()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getDisplayField()
    {
        return implode(' ', $this->getAttributes(static::displayField()));
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
