<?php

namespace yii\boost\tests;

use yii\web\Request as WebRequest;

class Request extends WebRequest
{

    /**
     * @var bool
     */
    private $isAjax = false;

    /**
     * @param bool $isAjax
     */
    public function setIsAjax($isAjax)
    {
        $this->isAjax = $isAjax;
    }

    /**
     * @inheritdoc
     */
    public function getIsAjax()
    {
        return $this->isAjax;
    }
}
