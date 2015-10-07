<?php

namespace yii\boost\db;

use Exception;
use FB;
use yii\boost\base\InvalidModelException;
use yii\helpers\VarDumper;
use Yii;
use yii\db\ActiveRecord as YiiActiveRecord;

class ActiveRecord extends YiiActiveRecord
{

    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    public function debugData()
    {
        if ($this->hasErrors()) {
            return [
                'class' => get_class($this),
                'attributes' => $this->getAttributes(),
                'errors' => $this->getErrors()
            ];
        } else {
            return [
                'class' => get_class($this),
                'attributes' => $this->getAttributes()
            ];
        }
    }

    public function log($message = 'Dump:', $category = 'application')
    {
        if ($this->hasErrors()) {
            Yii::error($message . PHP_EOL . VarDumper::dumpAsString($this->debugData()), $category);
        } else {
            Yii::info($message . PHP_EOL . VarDumper::dumpAsString($this->debugData()), $category);
        }
    }

    public function fb($label = null)
    {
        if ($this->hasErrors()) {
            FB::error($this->debugData(), $label);
        } else {
            FB::info($this->debugData(), $label);
        }
    }

    public function dump()
    {
        VarDumper::dump($this->debugData());
    }

    public function dumpAsString()
    {
        return VarDumper::dumpAsString($this->debugData());
    }

    /**
     * @return InvalidModelException
     */
    public function exception($message = null, $code = 0, Exception $previous = null)
    {
        return new InvalidModelException($this, $message, $code, $previous);
    }
}
