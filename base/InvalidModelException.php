<?php

namespace yii\boost\base;

use Exception;
use yii\base\Model;
use UnexpectedValueException;
use yii\helpers\VarDumper;
use yii\boost\db\ActiveRecord as YiiBoostActiveRecord;

class InvalidModelException extends UnexpectedValueException
{

    /**
     * @var Model
     */
    private $_model = null;

    public function __construct(Model $model, $message = null, $code = 0, Exception $previous = null)
    {
        $this->_model = $model;
        parent::__construct($message, $code, $previous);
    }

    public function getName()
    {
        return 'Invalid Model';
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->_model;
    }

    public function getModelDebugData()
    {
        $model = $this->getModel();
        if ($model instanceof YiiBoostActiveRecord) {
            return $model->debugData();
        } elseif ($model->hasErrors()) {
            return [
                'class' => get_class($model),
                'attributes' => $model->getAttributes(),
                'errors' => $model->getErrors()
            ];
        } else {
            return [
                'class' => get_class($model),
                'attributes' => $model->getAttributes()
            ];
        }
    }

    public function __toString()
    {
        return parent::__toString() . PHP_EOL . VarDumper::dumpAsString($this->getModelDebugData());
    }
}
