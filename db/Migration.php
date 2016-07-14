<?php

namespace yii\boost\db;

use yii\db\Migration as YiiMigration;

class Migration extends YiiMigration
{

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
}
