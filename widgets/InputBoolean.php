<?php

namespace yii\boost\widgets;

use yii\helpers\Html;
use yii\widgets\InputWidget;
use Yii;

class InputBoolean extends InputWidget
{

    /**
     * @var array|null
     * @see http://www.yiiframework.com/doc-2.0/yii-i18n-formatter.html#$booleanFormat-detail
     * @uses \yii\i18n\Formatter::$booleanFormat
     */
    public $booleanFormat = null;

    /**
     * @var string|false|null
     * @see http://www.yiiframework.com/doc-2.0/yii-i18n-formatter.html#$nullDisplay-detail
     * @uses \yii\i18n\Formatter::$nullDisplay
     */
    public $prompt = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $formatter = Yii::$app->getFormatter();
        if (is_null($this->booleanFormat)) {
            $this->booleanFormat = $formatter->booleanFormat;
            if (is_null($this->booleanFormat)) {
                $this->booleanFormat = [Yii::t('yii', 'No'), Yii::t('yii', 'Yes')];
            }
        }
        if (is_null($this->prompt)) {
            $this->prompt = $formatter->nullDisplay;
            if (is_null($this->prompt)) {
                $this->prompt = Yii::t('yii', '(not set)');
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
        if (is_string($this->prompt) && !array_key_exists('prompt', $options)) {
            $options['prompt'] = strip_tags($this->prompt);
        }
        if ($hasModel) {
            $output = Html::activeDropDownList($this->model, $this->attribute, $this->booleanFormat, $options);
        } else {
            $output = Html::dropDownList($this->name, $this->value, $this->booleanFormat, $options);
        }
        return $output;
    }
}
