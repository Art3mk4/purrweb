<?php
namespace app\modules\purrweb\components\design\pager;

use yii\base\Widget;
use Yii;
use app\modules\purrweb\components\core\helper\GetUrl;

/**
 * Description of Pager
 *
 * @author art3mk4
 */
class Pager extends Widget
{

    /**
     * pages
     *
     * @var \yii\data\Pagination
     */
    public $pages;

    /**
     * prevDecade
     *
     * @var Decade
     */
    protected $prevDecade;

    /**
     * nextDecade
     *
     * @var Decade
     */
    protected $nextDecade;

    /**
     * Функция для запуска виджета
     */
    public function run() 
    {
        $decade = null;
        if ($this->totalPages > 1) {
            $decade = new Decade($this->currentPage, $this->startPage, $this->endPage);
            $this->prevDecade = $this->createPrevDecade($decade);
            $this->nextDecade = $this->createNextDecade($decade);
        }

        return $this->render(
            "pager/index", [
                'decade' => $decade,
                'currentPage' => $this->currentPage
            ]
        );
    }

    /**
     * createPrevDecade
     *
     * @param Decade $decade
     * @return Decade|null
     */
    private function createPrevDecade(Decade $decade)
    {
        if ($decade->startPage <= $this->startPage) {
            return null;
        }
        $page = $decade->startPage - 1;
        return new Decade($page, $this->startPage, $this->endPage);
    }

    /**
     * getNextDecade
     *
     * @param Decade $decade
     * @return Decade|null
     */
    private function createNextDecade(Decade $decade)
    {
        if ($this->endPage <= $decade->endPage) {
            return null;
        }
        $page = $decade->endPage + 1;
        return new Decade($page, $this->startPage, $this->endPage);
    }

    /**
     * getTotalElements
     *
     * @return int
     */
    protected function getTotalElements()
    {
        return $this->pages->itemCount;
    }

    /**
     * getTotalPages
     *
     * @return int
     */
    protected function getTotalPages()
    {
        return $this->endPage - $this->startPage + 1;
    }

    /**
     * getStartPage
     *
     * @return int
     */
    public function getStartPage() 
    {
        return 1;
    }

    /**
     * getEndPage
     *
     * @return int
     */
    public function getEndPage()
    {
        return $this->pages->pageCount;
    }

    /**
     * getCurrentPage
     *
     * @return int
     */
    protected function getCurrentPage()
    {
        return $this->pages->page + 1;
    }

    /**
     * getPageUrl
     *
     * @param int $page
     * @return string
     */
    public function getUrl($page)
    {
        //Параметры получаем из гетовских
        $params = $_REQUEST;
        
        $route = '/' . Yii::$app->controller->route;
        $params['page'] = $page;

        return GetUrl::url($route, $params);
    }

    /* *
     * getPrevPage
     *
     * @return int
     */
    public function getPrevPage()
    {
        if ($this->currentPage <= $this->startPage) {
            return null;
        }
        return $this->currentPage - 1;
    }

    /* *
     * getNextPage
     *
     * @return int
     */
    public function getNextPage()
    {
        if ($this->endPage <= $this->currentPage) {
            return null;
        }
        return $this->currentPage + 1;
    }
}