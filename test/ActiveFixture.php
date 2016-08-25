<?php

namespace yii\boost\test;

use yii\test\ActiveFixture as BaseActiveFixture;

class ActiveFixture extends BaseActiveFixture
{

    /**
     * @inheritdoc
     */
    public function unload()
    {
        parent::unload();
        $this->resetTable();
    }
}
