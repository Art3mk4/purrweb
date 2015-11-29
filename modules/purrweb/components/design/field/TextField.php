<?php
namespace app\modules\purrweb\components\design\field;

/**
 * Description of TextField
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class TextField extends AbstractModelField
{

    /**
     * Ширина поля
     *
     * @var string
     * @access public
     */
    public $width = "";

    /**
     * Высота поля
     *
     * @var string
     * @access public
     */
    public $height = "";

    /**
     * Макс длина значения  (как текста)
     *
     * @var string
     * @access public
     */
    public $max = "";

    /**
     * Флаг (использовать CKEditor)
     * @var bool
     * @access public
     */
    public $fck = "false";

    /**
     * ВЫполнить виджет
     *
     * @return void
     */
    public function run() 
    {
        return $this->render(
            'textField/index',
            [
                'inputId' => $this->getInputId(),
                'label' => $this->getLabel(),
                'htmlOptions' => $this->htmlOptions,
                'value' => $this->getValue(),
                'inputName' => $this->getInputName()
            ]
        );
    }
}