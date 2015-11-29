<?php
namespace app\modules\purrweb\components\design\pager;
use yii\base\Object;

/**
 * Description of Decade
 *
 * @author art3mk4
 */
class Decade extends Object
{

    const DECADE_PAGES = 3;

    /**
     * _startPage
     *
     * @var int
     */
    private $_startPage;

    /**
     * _endPage
     *
     * @var int
     */
    private $_endPage;

    /**
     * _isFirst
     *
     * @var boolean
     */
    private $_isFirst = false;

    /**
     * _isLast
     *
     * @var boolean
     */
    private $_isLast = false;

    /**
     * __construct
     *
     * @param int $page
     * @param int $minPage
     * @param int $maxPage
     * @return void
     */
    public function __construct($page, $minPage, $maxPage)
    {
        $decadeIndex = floor(($page -1) / self::DECADE_PAGES);
        
        $this->_startPage = $decadeIndex * self::DECADE_PAGES + 1;
        $this->_endPage = $decadeIndex * self::DECADE_PAGES + self::DECADE_PAGES;

        $this->_startPage = max($minPage, $this->_startPage);
        $this->_endPage = min($maxPage, $this->_endPage);

        $this->_isFirst = ($this->_startPage == $minPage);
        $this->_isLast = ($this->_endPage == $maxPage);
    }

    /**
     * isFirst
     *
     * @return boolean
     */
    public function isFirst()
    {
        return $this->_isFirst;
    }

    /**
     * isLast
     *
     * @return boolean
     */
    public function isLast()
    {
        return $this->_isLast;
    }

    /**
     * getStartPage
     *
     * @return int
     */
    public function getStartPage()
    {
        return $this->_startPage;
    }

    /**
     * getEndPage
     *
     * @return int
     */
    public function getEndPage()
    {
        return $this->_endPage;
    }

    /**
     * getPages
     *
     * @return array
     */
    public function getPages()
    {
        return range($this->_startPage, $this->_endPage);
    }
}