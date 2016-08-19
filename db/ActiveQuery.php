<?php

namespace yii\boost\db;

use yii\db\Expression;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery as YiiActiveQuery;

class ActiveQuery extends YiiActiveQuery
{

    /**
     * @event Event
     */
    const EVENT_ALIAS = 'alias';

    /**
     * @var string
     */
    private $_alias;

    /**
     * @inheritdoc
     */
    public function from($tables)
    {
        $this->_alias = null;
        $result = parent::from($tables);
        $this->trigger(static::EVENT_ALIAS);
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function alias($alias)
    {
        $this->_alias = null;
        $result = parent::alias($alias);
        $this->trigger(static::EVENT_ALIAS);
        return $result;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        if (!is_null($this->_alias)) {
            return $this->_alias;
        }
        if (empty($this->from)) {
            /* @var $modelClass ActiveRecord */
            $modelClass = $this->modelClass;
            $tableName = $modelClass::tableName();
        } else {
            $tableName = '';
            foreach ($this->from as $alias => $tableName) {
                if (is_string($alias)) {
                    $this->_alias = $alias;
                    return $alias;
                } else {
                    break;
                }
            }
        }
        if (preg_match('/^(.*?)\s+({{\w+}}|\w+)$/', $tableName, $matches)) {
            $alias = $matches[2];
        } else {
            $alias = $tableName;
        }
        $this->_alias = $alias;
        return $alias;
    }

    /**
     * @return string
     */
    public function getA()
    {
        return $this->getAlias();
    }

    /**
     * @param string $column
     * @return string
     */
    public function a($column = null)
    {
        $alias = $this->getAlias();
        if (is_null($column)) {
            return $alias;
        } else {
            return $alias . '.' . $column;
        }
    }

    /**
     * @return self
     */
    public function listItems()
    {
        /* @var $modelClass ActiveRecord */
        $modelClass = $this->modelClass;
        $primaryKey = $modelClass::primaryKey();
        if (count($primaryKey) != 1) {
            throw new NotSupportedException('Unable to request list items.');
        }
        $this->indexBy($primaryKey[0]);
        $displayField = $modelClass::displayField();
        if (is_array($displayField) && (count($displayField) > 1)) {
            $this->select(new Expression('CONCAT([[' . implode(']], \' \', [[', $displayField) . ']])'));
        } else {
            $this->select($displayField);
        }
        return $this;
    }
}
