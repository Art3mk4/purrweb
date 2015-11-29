<?php
namespace app\modules\purrweb\components\design\field;

/**
 * Description of TextareaField
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class TextareaField extends AbstractModelField
{

    /**
     * Флаг (использовать CKEditor)
     * @var boolean
     */
    private $_fck = false;

    /**
     * Gets the value of fck
     *
     * @return boolean
     */
    public function getFck()
    {
        return $this->_fck;
    }

    /**
     * Sets the value of fck
     *
     * @param string|boolean $fck 
     */
    public function setFck($fck)
    {
        $this->_fck = $fck;
        
        return $this;
    }

    /**
     * Sets the value of max
     *
     * @param int $max 
     */
    public function setMax($max)
    {
        $this->htmlOptions['maxlength'] = $max;
    }

    /**
     * Sets the value of width
     *
     * @param string $width 
     */
    public function setWidth($width)
    {
        $this->htmlOptions['style'] .= 'width:' . $width; 
    }
    
    /**
     * setHeight
     * 
     * @param type $heght
     */
    public function setHeight($heght)
    {
        $this->htmlOptions['style'] .= 'height:' . $height; 
    }

    /**
     * ВЫполнить виджет
     *
     * @access public
     * @return void
     */
    public function run()
    {
        return $this->render(
            'textareaField/index',
            [
                'errors' => $this->errors,
                'inputName' => $this->inputName,
                'value' => $this->value,
                'inputId' => $this->inputId,
                'htmlOptions' => $this->htmlOptions,
                'label' => $this->getLabel(),
                'fck' => $this->getFck(),
                'model' => $this->model
            ]
        );
    }
}