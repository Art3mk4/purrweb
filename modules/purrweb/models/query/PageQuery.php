<?php
namespace app\modules\purrweb\models\query;
use app\modules\purrweb\components\core\model\Query;

/**
 * Description of PageQuery
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class PageQuery extends Query
{
    /**
     * 
     * @return type
     */
    public function sort($order = self::DEFAULT_SORT, $dir = self::DESC)
    {
        if ($order == 'date') {
            $this->addOrderBy('date ' . $dir);
            return $this;
        }

        return $this->sortBySort();
    }
}