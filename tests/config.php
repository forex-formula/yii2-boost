<?php

return [
    'id' => 'test-app',
    'language' => 'ru',
    'basePath' => __DIR__,
    'vendorPath' => dirname(dirname(YII2_PATH)),
    'components' => [
        'request' => [
            'class' => 'yii\boost\tests\Request',
            'enableCookieValidation' => false
        ]
    ]
];
