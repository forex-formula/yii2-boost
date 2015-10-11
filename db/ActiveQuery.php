<?php

namespace yii\boost\db;

use yii\db\ActiveQuery as YiiActiveQuery;

class ActiveQuery extends YiiActiveQuery
{

    /**
     * @var string|null
     */
    private $_alias = null;

    /**
     * @inheritdoc
     */
    public function from($tables)
    {
        $this->_alias = null;
        return parent::from($tables);
    }

    /**
     * @param string $alias
     * @return self
     */
    public function setAlias($alias)
    {
        /* @var $modelClass string|ActiveRecord */
        $modelClass = $this->modelClass;
        return $this->from([$alias => $modelClass::tableName()]);
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
            /* @var $modelClass string|ActiveRecord */
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
}
