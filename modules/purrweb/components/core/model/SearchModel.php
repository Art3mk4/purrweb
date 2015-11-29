<?php
namespace app\modules\purrweb\components\core\model;
use yii\base\Model;
use yii\db\QueryInterface;

/**
 * Description of SearchModel
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class SearchModel extends Model
{

    /**
     * search
     *
     * @param QueryInterface $query
     * @return void
     */
    public function search(QueryInterface $query)
    {
        foreach ($this->attributes as $name => $attribute) {
            if (!empty($attribute)) {
                $methodName = 'for' . ucfirst($name);
                if (method_exists($query, $methodName)) {
                    $query->$methodName($attribute);
                }
            }
        }

        return $query;
    }
}