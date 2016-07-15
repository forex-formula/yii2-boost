<?php

namespace yii\boost\data;

interface SearchInterface
{

    /**
     * @param array $params
     * @return \yii\data\DataProviderInterface
     */
    public function search($params);
}
