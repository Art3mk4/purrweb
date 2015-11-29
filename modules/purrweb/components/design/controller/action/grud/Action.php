<?php
namespace app\modules\purrweb\components\design\controller\action\grud;

use yii\base\Action as BaseAction;
use yii\base\Model;
use app\modules\purrweb\components\core\helper\GetUrl;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Description of Action
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
abstract class Action extends BaseAction
{

    /**
     * modelName
     *
     * @var string
     */
    public $modelName;

    /**
     * redirectUrl
     *
     * @var Closure|mixed
     */
    public $redirectUrl;

    /**
     * useStringId
     *
     * @var boolean
     */
    public $useStringId = false;

    /**
     * loader
     *
     * @var \Closure
     */
    protected $_loader;

    /**
     * Gets the value of Loader
     *
     * @return \Closure
     */
    public function getLoader()
    {
        if (!isset($this->_loader)) {
            $modelName = $this->modelName;
            $this->_loader = function () use ($modelName) {
                return $modelName::find();
            };
        }
        return $this->_loader;
    }

    /**
     * Sets the value of loader
     *
     * @param \Closure $loader 
     *
     * @return EditAction
     */
    public function setLoader($loader)
    {
        $this->_loader = $loader;
        return $this;
    }

    /**
     * getRedirectUrl
     *
     * @param Model $item
     * @return string
     */
    protected function getRedirectUrl(Model $item)
    {
        if (!isset($this->redirectUrl)) {
            return $this->getBackUrl();
        }

        if (is_callable($this->redirectUrl)) {
            $redirFunction = $this->redirectUrl;
            return call_user_func($redirFunction, $item);
        }

        return $this->redirectUrl;
    }

    /**
     * getBackUrl
     *
     * @return string
     */
    protected function getBackUrl()
    {
        $prevUrl = GetUrl::previous();
        $defaultUrl = GetUrl::toRoute('index');
        if (strpos($prevUrl, $defaultUrl) !== false) {
            return $prevUrl;
        }

        return $defaultUrl;
    }

    /**
      validateId
     *
     * @param mixed $id
     * @return boolean
     */
    protected function validateId($id = null)
    {
        if (!isset($id)) {
            return false;
        }
        if (!($this->useStringId or is_numeric($id))) {
            return false;
        }

        return true;
    }

    /**
     * getId
     *
     * @return mixed
     */
    protected function getId()
    {
        $id = Yii::$app->request->getQueryParam('id', null);
        if (!$this->validateId($id)) {
            throw new NotFoundHttpException('Неверный идентификатор');
        }
        return $id;
    }

    /**
     * findItem
     *
     * @param mixed $id
     * @return void
     */
    protected function findItem($id)
    {
        $loader = $this->loader; 
        $item = $loader()->forId($id)->one();
        if (!isset($item)) {
            throw new NotFoundHttpException('Нет такого объекта');
        }

        return $item;
    }
}