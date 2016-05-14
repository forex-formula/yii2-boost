<?php

namespace yii\boost\widgets;

use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\base\NotSupportedException;
use Yii;

class InputBoolean extends InputWidget
{

    /**
     * @var array
     * @see http://www.yiiframework.com/doc-2.0/yii-i18n-formatter.html#$booleanFormat-detail
     * @uses \yii\i18n\Formatter::$booleanFormat
     */
    public $items;

    /**
     * @var string|false
     * @see http://www.yiiframework.com/doc-2.0/yii-i18n-formatter.html#$nullDisplay-detail
     * @uses \yii\i18n\Formatter::$nullDisplay
     */
    public $prompt;

    /**
     * @var string
     * @see http://www.yiiframework.com/doc-2.0/yii-base-application.html#$language-detail
     * @uses \yii\base\Application::$language
     */
    public $language;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $formatter = Yii::$app->getFormatter();
        if (is_null($this->items)) {
            $this->items = $formatter->booleanFormat;
            if (is_null($this->items)) {
                $this->items = [Yii::t('yii', 'No', [], $this->language), Yii::t('yii', 'Yes', [], $this->language)];
            }
        }
        if (is_null($this->prompt)) {
            $this->prompt = $formatter->nullDisplay;
            if (is_null($this->prompt)) {
                $this->prompt = Yii::t('yii', '(not set)', [], $this->language);
            }
        }
        if (is_null($this->language)) {
            $this->language = Yii::$app->language;
            if (is_null($this->language)) {
                $this->language = 'en-US';
            }
        }
        Html::addCssClass($this->options, 'form-control');
        if (is_string($this->prompt) && !array_key_exists('prompt', $this->options)) {
            $this->options['prompt'] = strip_tags($this->prompt);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            if (array_key_exists('value', $this->options)) {
                if (!in_array($this->attribute, $this->model->attributes())) {
                    throw new NotSupportedException('Unable to set value of the property \'' . $this->attribute . '\'.');
                }
                $stash = $this->model->{$this->attribute};
                $this->model->{$this->attribute} = $this->options['value'];
                unset($this->options['value']);
            }
            $output = Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
            if (isset($stash)) {
                $this->model->{$this->attribute} = $stash;
            }
            return $output;
        } else {
            return Html::dropDownList($this->name, $this->value, $this->items, $this->options);
        }
    }
}
