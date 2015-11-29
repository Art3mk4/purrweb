<?php
namespace app\modules\purrweb\components\core\model;

use yii\db\ActiveQuery;
use yii\db\Expression;
use app\modules\purrweb\components\core\helper\ArrayHelper;

/**
 * Description of Query
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class Query extends ActiveQuery
{

    const ASC = 0;
    const DESC = 1;
    const DEFAULT_SORT = 'default';

    /**
     * sortDir
     *
     * @var mixed
     */
    public $sortDir;

    /**
     * sortOrder
     *
     * @var mixed
     */
    public $sortOrder;

    /**
     * getData
     *
     * @param string $title
     * @return array
     */
    public function getData($title = 'title')
    {
        return ArrayHelper::map($this->all(), 'id', 'title'); 
    }

    /**
     * sort
     *
     * @return void
     */
    public function sort()
    {
        $this->sortId(self::DESC);
        $this->setSortMark(self::DEFAULT_SORT, self::DESC);
        return $this;
    }

    /**
     * sortId
     *
     * @param string $order
     * @param string $dir
     * @return Query
     */
    public function sortId($dir = self::DESC)
    {
        $this->addOrderBy('id ' . $this->dir($dir));
        return $this;
    }

    /**
     * sortBySort
     *
     * @return Query
     */
    public function sortBySort($dir = self::ASC)
    {
        $this->addOrderBy(new Expression('`sort` IS NOT NULL'));
        $this->addOrderBy(new Expression('sort ' . $this->dir($dir)));
        $this->addOrderBy('id ' . $this->dir(!$dir));
        return $this;
    }

    /**
     * setSortMark
     *
     * @param string $order
     * @param mixed $dir
     * @return void
     */
    protected function setSortMark($order, $dir)
    {
        $this->sortOrder = $order;
        $this->sortDir = $dir;
    }

    /**
     * dir
     *
     * @param boolean $dir
     * @return string
     */
    protected function dir($dir)
    {
        return $dir ? 'DESC' : 'ASC';
    }

    /**
     * published
     *
     * @return Query
     **/
    public function published()
    {
        $this->andWhere(['published'  =>  '1']);
        return $this;
    }

    /**
     * random
     *
     * @return Query
     */
    public function random()
    {
        $this->addOrderBy('RAND()');
        return $this;
    }

    /**
     * forId
     *
     * @param mixed $id
     * @return Query
     */
    public function forId($id)
    {
        $this->andWhere(['id' => $id]);
        return $this;
    }
}