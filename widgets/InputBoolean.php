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
    public $booleanFormat;

    /**
     * @var string|false
     * @see http://www.yiiframework.com/doc-2.0/yii-i18n-formatter.html#$nullDisplay-detail
     * @uses \yii\i18n\Formatter::$nullDisplay
     */
    public $prompt;

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
        $options = $this->options;
        if (is_string($this->prompt) && !array_key_exists('prompt', $options)) {
            $options['prompt'] = strip_tags($this->prompt);
        }
        if ($this->hasModel()) {
            $output = Html::activeDropDownList($this->model, $this->attribute, $this->booleanFormat, $options);
        } else {
            $output = Html::dropDownList($this->name, $this->value, $this->booleanFormat, $options);
        }
        return $output;
    }
}
