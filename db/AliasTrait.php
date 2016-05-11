<?php

namespace yii\boost\db;

/**
 * @mixin \yii\db\ActiveQuery
 */
trait AliasTrait
{

    /**
     * @return string
     */
    public function getAlias()
    {
        if (empty($this->from)) {
            /* @var $modelClass ActiveRecord */
            $modelClass = $this->modelClass;
            $tableName = $modelClass::tableName();
        } else {
            $tableName = '';
            foreach ($this->from as $alias => $tableName) {
                if (is_string($alias)) {
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
