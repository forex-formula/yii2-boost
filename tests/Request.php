<?php

namespace yii\boost\tests;

use yii\web\Request as WebRequest;

class Request extends WebRequest
{

    /**
     * @var bool
     */
    private $fakeIsAjax = false;

    /**
     * @param bool $fakeIsAjax
     */
    public function setFakeIsAjax($fakeIsAjax)
    {
        $this->fakeIsAjax = $fakeIsAjax;
    }

    /**
     * @inheritdoc
     */
    public function getIsAjax()
    {
        return $this->fakeIsAjax;
    }
}
