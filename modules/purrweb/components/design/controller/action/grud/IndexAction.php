<?php
namespace app\modules\purrweb\components\design\controller\action\grud;

use Yii;
use yii\base\Action;
use app\modules\purrweb\components\design\data\ActiveDataProvider;
use app\modules\purrweb\components\core\helper\GetUrl;

/**
 * Description of IndexAction
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class IndexAction extends Action
{

    /**
     * modelName
     *
     * @var string
     */
    public $modelName;

    /**
     * pageSize
     *
     * @var int
     */
    public $pageSize = 10;

    /**
     * filterName
     *
     * @var string
     */
    public $filterName;
    
    /**
     * 
     * @var unknown
     */
    public $order;
    
    /**
     * 
     * @var unknown
     */
    public $dir;

    /**
     * query
     *
     * @var Closure
     */
    private $_query; 
    
    /**
    * getModelSearcher
    *
    * @return \Closure
    */
    public function getQuery()
    {
        if (!isset($this->_query)) {
            $this->_query = function () {
                $modelName = $this->modelName;
                return $modelName::find();
            };
        }
        return $this->_query;
    }
    
    /**
    * setModelSearcher
    *
    * @param \Closure $query
    * @return 
    */
    public function setQuery($query)
    {
        $this->_query = $query;
    }

    /**
     * run
     *
     * @return void
     */
    public function run()
    {
        $page = (int)Yii::$app->request->getQueryParam('page', 1);
        $order = Yii::$app->request->getQueryParam('order', null);
        $dir = Yii::$app->request->getQueryParam('dir', null);

        $queryClosure = $this->query;
        $query = $queryClosure();

        $filter = null;
        if (isset($this->filterName)) {
            $filter = $this->controller->getFilter($this->filterName, Yii::$app->request->queryParams);
            $query = $filter->search($query);
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
                'page' => ($page -1)
            ],
        ]);
        
        GetUrl::remember();
        $provider->prepare();

        return $this->controller->render(
            'index',
            [
                'provider' => $provider,
                'filter' => $filter,
            ]
        );
    }
}