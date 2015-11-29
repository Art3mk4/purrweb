<?php
namespace app\modules\purrweb\components\core\validator;

use yii\validators\DateValidator as BaseDateValidator;

/**
 * Description of DateValidator
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class DateValidator extends BaseDateValidator
{

    /**
     *
     * @var type 
     */
    public $format = 'dd.MM.y';

    /**
     * 
     * @param type $model
     * @param type $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        parent::validateAttribute($model, $attribute);

        $errors = $model->getErrors($attribute);
        $value = $model->$attribute;
        if (empty($errors) and !empty($value)) {
            $value = \DateTime::createFromFormat('d.m.Y', $value);
            $model->$attribute = $value;
        }
    }
}