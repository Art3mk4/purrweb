<?php
namespace app\modules\purrweb\components\design\data;
use yii\data\ActiveDataProvider as BaseProvider;

/**
 * Description of ActiveDataProvider
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class ActiveDataProvider extends BaseProvider implements DataProviderInterface
{

    /**
     * _prevRow
     *
     * @var mixed
     */
    private $_prevRow;

    /**
     * _nextRow
     *
     * @var mixed
     */
    private $_nextRow;

    /**
     * _allModels
     *
     * @var array
     */
    private $_allModels = array();

    /**
     * prepareModel s
     *
     * @inheritdoc
     */
    protected function prepareModels()
    {
        $query = clone $this->query;
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
            $query->limit($pagination->getLimit())->offset($pagination->getOffset());
        }
        if (($sort = $this->getSort()) !== false) {
            $query->addOrderBy($sort->getOrders());
        }
        $this->addPrevNextRow($query);

        $this->_allModels =  $query->all($this->db);
        
        return $this->cutPrevNextRow();
    }

    /**
     * loadPrevNextRow
     *
     * @return void
     */
    private function cutPrevNextRow()
    {
        $rows = $this->_allModels;
        if (!$this->isFirstPage()) {
            $this->_prevRow = array_shift($rows);
        }
        
        if (!$this->isLastPage()) {
            $this->_nextRow = array_pop($rows);
        }

        return $rows;
    }

    /**
     * getAllModels
     *
     * @return array
     */
    public function getAllModels()
    {
        return $this->_allModels;
    }

    /**
     * isFirstPage
     *
     * @return boolean
     */
    protected function isFirstPage()
    {
        return ($this->pagination->page + 1 == 1);
    }

    /**
     * isLastPage
     *
     * @return boolean
     */
    protected function isLastPage()
    {
        return  ($this->pagination->page  + 1 == $this->pagination->pageCount);
    }

    /**
     * getPrevRow
     *
     * @return void
     */
    public function getPrevRow()
    {
        return $this->_prevRow;
    }

    /**
     * getNextRow
     *
     * @return void
     */
    public function getNextRow()
    {
        return $this->_nextRow;
    }

    /**
     * addPrevNextRow
     *
     * @return void
     */
    private function addPrevNextRow($query)
    {
        if (!$this->isFirstPage()) {
            $query->offset--;
            $query->limit++;
        }
        
        if (!$this->isLastPage()) {
            $query->limit++;
        }
    }
}