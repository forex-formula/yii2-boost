<?php

namespace yii\boost\base;

use Exception;
use yii\base\Model;
use UnexpectedValueException;
use yii\helpers\VarDumper;

class InvalidModelException extends UnexpectedValueException
{

    /**
     * @var Model
     */
    private $_model;

    /**
     * @param Model $model
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct(Model $model, $message = null, $code = 0, Exception $previous = null)
    {
        $this->_model = $model;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
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

    /**
     * @return array
     */
    public function getModelDebugData()
    {
        $model = $this->getModel();
        if ($model instanceof ModelDebugTrait) {
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

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return parent::__toString() . PHP_EOL . VarDumper::dumpAsString($this->getModelDebugData());
    }
}
