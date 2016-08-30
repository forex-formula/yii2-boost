<?php

namespace yii\boost\db;

use yii\db\ActiveRecord as BaseActiveRecord;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\boost\base\ModelDebugTrait;
use ReflectionClass;
use Yii;

class ActiveRecord extends BaseActiveRecord
{

    use ModelDebugTrait;

    const DISPLAY_FIELD_SEPARATOR = ' ';

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
     * @param array $condition
     * @param string|array|Expression $orderBy
     * @return array
     */
    public static function findFilterListItems(array $condition = [], $orderBy = null)
    {
        $query = static::find()->listItems()->andFilterWhere($condition);
        if (!is_null($orderBy)) {
            $query->orderBy($orderBy);
        }
        return $query->column();
    }

    /**
     * @return string[]
     */
    public static function singularRelations()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public static function pluralRelations()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public static function booleanAttributes()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public static function dateAttributes()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public static function datetimeAttributes()
    {
        return [];
    }

    /**
     * @return string
     */
    public static function classShortName()
    {
        $reflector = new ReflectionClass(get_called_class());
        return $reflector->getShortName();
    }

    /**
     * @return string
     */
    public static function modelTitle()
    {
        return Inflector::titleize(static::classShortName());
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
            return implode(static::DISPLAY_FIELD_SEPARATOR, $this->getAttributes($displayField));
        } else {
            return implode(static::DISPLAY_FIELD_SEPARATOR, $this->getPrimaryKey(true));
        }
    }

    /**
     * @param string $name
     * @return string
     */
    public function getRelationClass($name)
    {
        $relation = $this->getRelation($name, false);
        return $relation ? $relation->modelClass : null;
    }

    /**
     * @param string $name
     * @return array
     */
    public function getRelationLink($name)
    {
        $relation = $this->getRelation($name, false);
        return $relation ? $relation->link : null;
    }

    /**
     * @param string $name
     * @return array
     */
    public function getRelationConfig($name)
    {
        $relation = $this->getRelation($name, false);
        return $relation ? [
            'class' => $relation->modelClass,
            'link' => $relation->link
        ] : null;
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
                $validator->when = function (ActiveRecord $model, $attribute) {
                    return !$model->$attribute instanceof Expression;
                };
            }
        }
        return $validators;
    }
}
