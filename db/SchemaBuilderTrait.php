<?php

namespace yii\boost\db;

/**
 * @mixin \yii\db\Migration
 */
trait SchemaBuilderTrait
{

    /**
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function enabledShortcut()
    {
        return $this->boolean()->notNull()->defaultValue(0);
    }

    /**
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function createdAtShortcut()
    {
        return $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP');
    }

    /**
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function updatedAtShortcut()
    {
        return $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    /**
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function deletedShortcut()
    {
        return $this->boolean()->notNull()->defaultValue(0);
    }
}
