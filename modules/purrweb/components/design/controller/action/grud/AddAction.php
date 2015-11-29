<?php
namespace app\modules\purrweb\components\design\controller\action\grud;

use app\modules\purrweb\components\core\helper\GetUrl;
use yii\base\Exception;

/**
 * Description of AddAction
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class AddAction extends Action
{

    /**
     * modelName
     *
     * @var string
     */
    public $modelName;

    /**
     * creator
     *
     * @var Closure
     */
    private $_creator; 
    
    /**
    * getCreator
    *
    * @return \Closure
    */
    public function getCreator()
    {
        if (!isset($this->_creator)) {
            $this->_creator = function () {
                $modelName = $this->modelName;
                return new $modelName;
            };
        }
        return $this->_creator;
    }
    
    /**
    * setCreator
    *
    * @param \Closure $creator
    * @return 
    */
    public function setCreator($creator)
    {
        $this->_creator = $creator;
    }

    /**
     * run
     *
     * @return void
     */
    public function run()
    {
        $creatorClosure = $this->creator;
        $item = $creatorClosure();

        if (!$item->save()) {
            throw new Exception('Ошибка при редактировании', print_r($item->errors, true));
        }

        return $this->controller->redirect(GetUrl::url('edit', ['id' => $item->id]));
    }
}