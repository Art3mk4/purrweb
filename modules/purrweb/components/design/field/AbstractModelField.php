<?php
namespace app\modules\purrweb\components\design\field;

use yii\base\Widget;

/**
 * Description of AbstractModelField
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
abstract class AbstractModelField extends Widget
{

    /**
     * _htmlOptions
     *
     * @var array
     */
    public $htmlOptions = array(
        'style' => '',
        'class' => ''
    );

    /**
     * model
     *
     * @var yii\base\Model
     */
    public $model;

    /**
     * field
     *
     * @var string
     */
    public $field;

    /**
     * _isEdit
     *
     * @var boolean
     */
    public $isEdit = true;

    /**
     * _label
     *
     * @var string
     */
    private $_label;

    /**
     * _value
     *
     * @var value
     */
    protected $_value;

    /**
     * _inputId
     *
     * @var string
     */
    private $_inputId;

    /**
     * _inputName
     *
     * @var string
     */
    private $_inputName;

    /**
     * Gets the value of value
     *
     * @return mixed
     */
    public function getValue()
    {
        if (!isset($this->_value)) {
            $this->_value = $this->model->getAttribute($this->field);
        }
        return $this->_value;
    }

    /**
     * Sets the value of value
     *
     * @param mixed $value 
     */
    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }

    /**
     * Gets the value of label
     *
     * @return string
     */
    public function getLabel()
    {
        if (!isset($this->_label)) {
            $this->_label = $this->model->getAttributeLabel($this->field);
        }
        return $this->_label;
    }

    /**
     * Sets the value of label
     *
     * @param string $label 
     */
    public function setLabel($label)
    {
        $this->_label = $label;
        return $this;
    }

    /**
     * getErrors
     *
     * @return array|null
     */
    protected function getErrors()
    {
        if (isset($this->model->errors[$this->field])) {
            return $this->model->errors[$this->field];
        }
    
        return array();
    }

    /**
     * getIsRequired
     *
     * @return boolean
     */
    protected function getIsRequired()
    {
        if ($this->model->isAttributeRequired($this->field)) {
            return true;
        } 
        return false;
    }

    /**
     * Gets the value of inputId
     *
     * @return string
     */
    public function getInputId()
    {
        if (!isset($this->_inputId)) {
            $nameModel = $this->model->formName();
            $field = $this->field;
        
            $this->_inputId = "{$nameModel}_{$field}";
        }
        return $this->_inputId;
    }
    
    /**
     * Sets the value of inputId
     *
     * @param string $inputId 
     */
    public function setInputId($inputId)
    {
        $this->_inputId = $inputId;
        return $this;
    }

    /**
     * Gets the value of inputName
     *
     * @return string
     */
    public function getInputName()
    {
        if (!isset($this->_inputName)) {
            $nameModel = $this->model->formName();

            $this->_inputName = "{$nameModel}[{$this->field}]";
        }
        return $this->_inputName;
    }
    
    /**
     * Sets the value of inputName
     *
     * @param string $inputName 
     */
    public function setInputName($inputName)
    {
        $this->_inputName = $inputName;
        return $this;
    }

    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        $this->processErrors();
    
        parent::init();
    }

    /**
     * processErrors
     *
     * @return void
     */
    private function processErrors()
    {
        if (!empty($this->errors)) {
            $this->htmlOptions['class'] .= 'error';
        }
    }
}