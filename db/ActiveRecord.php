<?php

namespace yii\boost\db;

use yii\db\Expression;
use yii\helpers\Inflector;
use yii\boost\base\ModelDebugTrait;
use ReflectionClass;
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
     * @param string|array|Expression $orderBy
     * @return array
     */
    public static function findListItems($condition = null, $params = [], $orderBy = null)
    {
        $query = static::find()->listItems();
        if (!is_null($condition)) {
            $query->andWhere($condition, $params);
        }
        if (!is_null($orderBy)) {
            $query->orderBy($orderBy);
        }
        return $query->column();
    }

    /**
     * @return string
     */
    public static function shortName()
    {
        $reflector = new ReflectionClass(get_called_class());
        return $reflector->getShortName();
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
     * @return string
     */
    public function getDisplayField()
    {
        $displayField = static::displayField();
        if (is_array($displayField)) {
            return implode(' ', $this->getAttributes($displayField));
        } else {
            return implode(' ', $this->getPrimaryKey(true));
        }
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
