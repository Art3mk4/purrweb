<?php
namespace app\modules\purrweb\components\core\validator;

use yii\validators\DateValidator as BaseDateValidator;

/**
 * Description of TimeValidator
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class TimeValidator extends BaseDateValidator
{

    /**
     *
     * @var type 
     */
    public $format = 'hh:mm';
    
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
            $value = \DateTime::createFromFormat('h:i', $value);
            $model->$attribute = $value;
        }
    }
}