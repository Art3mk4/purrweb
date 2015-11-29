<?php
namespace app\modules\purrweb\components\core\validator;

use yii\validators\Validator;

/**
 * Description of JoinDatetimeValidator
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class JoinDatetimeValidator extends Validator
{

    /**
     *
     * @var type 
     */
    public $date;

    /**
     *
     * @var type 
     */
    public $time;

    /**
     * validateAttribute
     *
     * @param mixed $model
     * @param mixed $attribute
     * @return void
     */
    public function validateAttribute($model, $attribute)
    {
        $dateField = $this->date;
        $timeField = $this->time;

        $errors = array_merge($model->getErrors($this->date), $model->getErrors($this->time));
        if (empty($errors)) {
            $value = $model->$dateField;
            $timeValue = $model->$timeField;
            if (!empty($value)) {
                $value->setTime($timeValue->format('h'), $timeValue->format('i'));

                $model->$attribute = $value;
            }
        }
    }
}