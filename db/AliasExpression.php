<?php

namespace yii\boost\db;

use yii\db\Expression;

class AliasExpression extends Expression
{

    /**
     * @var ActiveQuery
     */
    private $_query;

    /**
     * @param ActiveQuery $query
     * @param string $expression
     * @param array $params
     * @param array $config
     */
    public function __construct(ActiveQuery $query, $expression, $params = [], $config = [])
    {
        $this->_query = $query;
        parent::__construct($expression, $params, $config);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuery()
    {
        return $this->_query;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return str_replace('{a}', $this->getQuery()->getAlias(), parent::__toString());
    }
}
