<?php

namespace yii\boost\db;

use yii\base\Event;
use yii\db\Expression as YiiDbExpression;

class Expression extends YiiDbExpression
{

    /**
     * @var ActiveQuery
     */
    public $query;

    /**
     * @inheritdoc
     */
    public function __construct($expression, $params = [], $config = [])
    {
        parent::__construct($expression, $params, $config);
        if ($this->query instanceof ActiveQuery) {
            $this->query->on(ActiveQuery::EVENT_ALIAS, function (Event $event) use ($expression) {
                /* @var $query ActiveQuery */
                $query = $event->sender;
                $this->expression = str_replace('{a}', $query->getAlias(), $expression);
            });
            $this->expression = str_replace('{a}', $this->query->getAlias(), $expression);
        }
    }
}
