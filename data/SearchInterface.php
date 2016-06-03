<?php

namespace yii\boost\db;

interface SearchInterface
{

    /**
     * @param array $params
     * @return \yii\data\DataProviderInterface
     */
    public function search($params);
}
