<?php

namespace yii\boost\db;

use yii\db\ActiveRecord as BaseActiveRecord;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\boost\base\ModelDebugTrait;
use ReflectionClass;
use Yii;

/**
 * @property string $titleText
 */
class ActiveRecord extends BaseActiveRecord
{

    use ModelDebugTrait;

    const TITLE_SEPARATOR = ' ';

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
    public static function titleKey()
    {
        return static::primaryKey();
    }

    /**
     * @return string
     */
    public function getTitleText()
    {
        $titleKey = static::titleKey();
        if (is_array($titleKey)) {
            return implode(static::TITLE_SEPARATOR, $this->getAttributes($titleKey));
        } else {
            return implode(static::TITLE_SEPARATOR, $this->getPrimaryKey(true));
        }
    }

    /**
     * @param string $name
     * @param bool $throwException
     * @return string|null
     */
    public function getRelationClass($name, $throwException = true)
    {
        $relation = $this->getRelation($name, $throwException);
        return $relation ? $relation->modelClass : null;
    }

    /**
     * @param string $name
     * @param bool $throwException
     * @return array|null
     */
    public function getRelationLink($name, $throwException = true)
    {
        $relation = $this->getRelation($name, $throwException);
        return $relation ? $relation->link : null;
    }

    /**
     * @param string $name
     * @param bool $throwException
     * @return array|null
     */
    public function getRelationConfig($name, $throwException = true)
    {
        $relation = $this->getRelation($name, $throwException);
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
