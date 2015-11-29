<?php
namespace app\modules\purrweb\components\core\validator;

use yii\validators\StringValidator as BaseStringValidator;

/**
 * Description of StringValidator
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class StringValidator extends BaseStringValidator
{
    /**
     * validateAttribute
     * 
     * @param type $model
     * @param type $attribute
     * @return type
     */
    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = (string)$model->$attribute;
        return parent::validateAttribute($model, $attribute);
    }
}