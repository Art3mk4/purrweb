<?php
namespace app\modules\purrweb\models\query;
use app\modules\purrweb\components\core\model\Query;

/**
 * Description of PageQuery
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class UploadImageQuery extends Query 
{

    /**
     * forModel
     *
     * @param mixed $model
     * @param mixed $model_id
     * @param mixed $field
     * @return Query
     */
    public function forModel($model, $model_id, $field)
    {
        $this->andWhere(['model' => $model, 'model_id' => $model_id, 'field' => $field]);
        return $this;
    }
}