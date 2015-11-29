<?php

/**
 * Description of CrudBehavior
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
namespace app\modules\purrweb\components\design\controller;
use app\modules\purrweb\components\core\helper\GetUrl;
use yii\base\Behavior;
use yii\web\NotFoundHttpException;
use Yii;
use yii\base\Model;

class CrudBehavior extends Behavior
{
    /**
     *
     * @var type 
     */
    public $modelName;
    
    /**
     *
     * @var type 
     */
    private $_loader;


    /**
     * getRedirectUrl
     *
     * @param Model $item
     * @return string
     */
    public function getRedirectUrl($item)
    {
        return $this->getBackUrl();
    }

    /**
     * getBackUrl
     *
     * @return string
     */
    public function getBackUrl()
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
    public function validateId($id = null)
    {
        if (!isset($id)) {
            return false;
        }
        if (!is_numeric($id)) {
            return false;
        }

        return true;
    }

    /**
     * getId
     *
     * @return mixed
     */
    public function getId()
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
    public function findItem($id)
    {
        $loader = $this->loader; 
        $item = $loader()->forId($id)->one();
        if (!isset($item)) {
            throw new NotFoundHttpException('Нет такого объекта');
        }

        return $item;
    }
    
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
     * sendRedirect
     *
     * @param Model $item
     * @return void
     */
    public function sendRedirect($item)
    {
        if (Yii::$app->request->isAjax) {
            $ajax = new Ajax();
            $ajax->sendRespond(true, 'Данные верны');
            Yii::$app->end();
        }
        
        $this->owner->redirect($this->getRedirectUrl($item));
    }
}