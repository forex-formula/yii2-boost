<?php

namespace yii\boost\db;

use yii\db\Migration as YiiMigration;

class Migration extends YiiMigration
{

    const RESTRICT = 'RESTRICT';
    const CASCADE = 'CASCADE';
    const SET_NULL = 'SET NULL';
    const NO_ACTION = 'NO ACTION';

    /**
     * @inheritdoc
     */
    public function createTable($table, $columns, $options = null)
    {
        if (($this->getDb()->getDriverName() == 'mysql') && is_null($options)) {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        parent::createTable($table, $columns, $options);
    }

    /**
     * @param string $table
     * @param array $columns
     * @param string $comment
     * @param string $options
     */
    public function createTableWithComment($table, $columns, $comment, $options = null)
    {
        $db = $this->getDb();
        if ($db->getDriverName() == 'mysql') {
            $commentOption = ' COMMENT=' . $db->quoteValue($comment);
            if (is_null($options)) {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $options .= $commentOption;
        }
        parent::createTable($table, $columns, $options);
    }

    /**
     * @inheritdoc
     * @param string|null $name
     */
    public function addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete = null, $update = null)
    {
        if (is_null($name)) {
            $name = implode('-', array_merge((array)$table, (array)$columns));
        }
        parent::addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete, $update);
    }

    /**
     * @inheritdoc
     * @param string|null $name
     */
    public function createIndex($name, $table, $columns, $unique = false)
    {
        if (is_null($name)) {
            $name = implode('-', (array)$columns);
        }
        parent::createIndex($name, $table, $columns, $unique);
    }

    /**
     * @param string|null $name
     * @param string $table
     * @param string|array $columns
     */
    public function createUnique($name, $table, $columns)
    {
        $this->createIndex($name, $table, $columns, true);
    }
}
