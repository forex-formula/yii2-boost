<?php

namespace yii\boost\db;

/**
 * @mixin \yii\db\ActiveQuery
 */
trait AliasTrait
{

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
        return parent::from($tables);
    }

    /**
     * @inheritdoc
     */
    public function alias($alias)
    {
        $this->_alias = null;
        return parent::alias($alias);
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
}
