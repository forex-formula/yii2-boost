<?php

namespace yii\boost\db;

/**
 * @mixin \yii\db\ActiveQuery
 */
trait AliasTrait
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
        if (is_string($this->_alias)) {
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
}
