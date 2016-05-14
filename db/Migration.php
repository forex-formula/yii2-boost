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
        if (is_null($options) && ($this->getDb()->getDriverName() == 'mysql')) {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        parent::createTable($table, $columns, $options);
    }
}
