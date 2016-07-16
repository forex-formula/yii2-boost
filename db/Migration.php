<?php

namespace yii\boost\db;

use yii\db\mysql\ColumnSchemaBuilder;
use yii\db\Schema;
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
    public function init()
    {
        parent::init();
        $db = $this->getDb();
        if ($db->getDriverName() == 'mysql') {
            $queryBuilder = $db->getQueryBuilder();
            $queryBuilder->typeMap = array_merge($queryBuilder->typeMap, [
                Schema::TYPE_UPK => str_replace('(11)', '(10)', $queryBuilder->typeMap[Schema::TYPE_UPK]),
                'tinyint' => 'tinyint(4)',
                'utinyint' => 'tinyint(3)',
                'usmallint' => 'smallint(5)',
                'uinteger' => 'int(10)'
            ]);
        }
    }

    /**
     * @param ColumnSchemaBuilder|string $type
     * @return ColumnSchemaBuilder|string
     */
    public function fixColumnType($type)
    {
        $closure = function () {
            /* @var $this ColumnSchemaBuilder */
            if ($this->isUnsigned) {
                switch ($this->type) {
                    case 'tinyint':
                        $this->type = 'utinyint';
                        break;
                    case Schema::TYPE_SMALLINT:
                        $this->type = 'usmallint';
                        break;
                    case Schema::TYPE_INTEGER:
                        $this->type = 'uinteger';
                        break;
                }
            } elseif ($this->type == Schema::TYPE_BOOLEAN) {
                $this->isUnsigned = true;
            }
        };
        if ($type instanceof ColumnSchemaBuilder) {
            call_user_func($closure->bindTo($type, get_class($type)));
        }
        return $type;
    }

    /**
     * @inheritdoc
     */
    public function createTable($table, $columns, $options = null)
    {
        if (($this->getDb()->getDriverName() == 'mysql') && is_null($options)) {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        foreach ($columns as $name => $type) {
            $columns[$name] = $this->fixColumnType($type);
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

    /**
     * @inheritdoc
     */
    public function addColumn($table, $column, $type)
    {
        parent::addColumn($table, $column, $this->fixColumnType($type));
    }
}
