<?php

namespace yii\boost\base;

use Exception;
use FB;
use yii\helpers\VarDumper;
use Yii;

/**
 * @mixin \yii\base\Model
 */
trait ModelDebugTrait
{

    /**
     * @return array
     */
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

    /**
     * @param string $message
     * @param string $category
     */
    public function debugLog($message = 'Dump:', $category = 'application')
    {
        if ($this->hasErrors()) {
            Yii::error($message . PHP_EOL . VarDumper::dumpAsString($this->debugData()), $category);
        } else {
            Yii::info($message . PHP_EOL . VarDumper::dumpAsString($this->debugData()), $category);
        }
    }

    /**
     * @param string $label
     */
    public function debugFirebug($label = null)
    {
        if ($this->hasErrors()) {
            FB::error($this->debugData(), $label);
        } else {
            FB::info($this->debugData(), $label);
        }
    }

    public function debugDump()
    {
        VarDumper::dump($this->debugData());
    }

    /**
     * @return string
     */
    public function debugDumpAsString()
    {
        return VarDumper::dumpAsString($this->debugData());
    }

    /**
     * @param string $message
     * @param int $code
     * @param Exception $previous
     * @return InvalidModelException
     */
    public function newException($message = null, $code = 0, Exception $previous = null)
    {
        /* @var $this \yii\base\Model */
        return new InvalidModelException($this, $message, $code, $previous);
    }
}
