<?php

namespace yii\boost\widgets;

use yii\helpers\Html;
use yii\widgets\InputWidget;
use Yii;

class InputBoolean extends InputWidget
{

    /**
     * @var array
     * @see http://www.yiiframework.com/doc-2.0/yii-i18n-formatter.html#$booleanFormat-detail
     * @uses \yii\i18n\Formatter::$booleanFormat
     */
    public $booleanFormat = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (is_null($this->booleanFormat)) {
            $this->booleanFormat = Yii::$app->getFormatter()->booleanFormat;
            if (is_null($this->booleanFormat)) {
                $this->booleanFormat = ['No', 'Yes'];
            }
        }
        Html::addCssClass($this->options, 'form-control');
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $hasModel = $this->hasModel();
        if (array_key_exists('value', $this->options)) {
            $value = $this->options['value'];
        } elseif ($hasModel) {
            $value = Html::getAttributeValue($this->model, $this->attribute);
        } else {
            $value = $this->value;
        }
        $options = array_merge($this->options, ['value' => $value]);
        if ($hasModel) {
            $output = Html::activeDropDownList($this->model, $this->attribute, $this->booleanFormat, $options);
        } else {
            $output = Html::dropDownList($this->name, $this->value, $this->booleanFormat, $options);
        }
        return $output;
    }
}
