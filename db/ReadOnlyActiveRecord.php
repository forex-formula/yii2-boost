<?php

namespace yii\boost\db;

use yii\base\NotSupportedException;

class ReadOnlyActiveRecord extends ActiveRecord
{

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public static function updateAll($attributes, $condition = '', $params = [])
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public static function updateAllCounters($counters, $condition = '', $params = [])
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public static function deleteAll($condition = '', $params = [])
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public function insert($runValidation = true, $attributes = null)
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    protected function insertInternal($attributes = null)
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public function update($runValidation = true, $attributeNames = null)
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    protected function updateInternal($attributes = null)
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public function beforeSave($insert)
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public function afterSave($insert, $changedAttributes)
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public function delete()
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    protected function deleteInternal()
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public function beforeDelete()
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     * @throw NotSupportedException
     */
    public function afterDelete()
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }
}
