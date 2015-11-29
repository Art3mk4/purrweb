<?php
namespace app\modules\purrweb\components\core\validator;

use yii\validators\Validator;

/**
 * Description of IntegerArrayValidator
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class IntegerArrayValidator extends Validator
{

    const EMPTY_ARRAY = '[]';

    /**
     * validateAttribute
     *
     * @param mixed $model
     * @param mixed $attribute
     * @return void
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (empty($value)) {
            return true;
        }

        if ($value == self::EMPTY_ARRAY) {
            $model->$attribute = array();
            $value = array();
        }

        if (!is_array($value)) {
            return $this->addError($model, $attribute, 'Передан не массив');
        }

        foreach ($value as $val) {
            if (!is_numeric($val)) {
                return $this->addError($model, $attribute, 'Передан не числовой массив');
            }
        }
    } 
}