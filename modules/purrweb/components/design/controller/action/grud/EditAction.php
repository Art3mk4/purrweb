<?php
namespace app\modules\purrweb\components\design\controller\action\grud;

use Yii;
use yii\db\ActiveRecordInterface;
use yii\base\Model;
use yii\base\Exception;
use yii\web\UploadedFile;

/**
 * Description of EditAction
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class EditAction extends Action
{

    /**
     * _afterSave
     *
     * @var \Closure
     */
    private $_afterSave;
    
    /**
     * Gets the value of afterSave
     *
     * @return \Closure
     */
    public function getAfterSave()
    {
        if (!isset($this->_afterSave)) {
            $this->_afterSave = function (ActiveRecordInterface $item) {
            
            };   
        }
        return $this->_afterSave;
    }

    /**
     * setAfterSave
     *
     * @param \Closure $afterSave
     * @return void
     */
    public function setAfterSave($afterSave)
    {
        $this->_afterSave = $afteSave;
    }
    
    /**
     * run
     *
     * @return void
     */
    public function run()
    {
        $id = $this->getId();
        $item = $this->findItem($id);
        if ($item->load(Yii::$app->request->post()) and $item->save()) {
            $afterSave = $this->getAfterSave();
            $afterSave($item);

            Yii::$app->session->setFlash('success', 'Объект сохранен.');
            return $this->sendRedirect($item);
        }

        if (!empty($item->errors)) {
            throw new Exception('Ошибка при редактирвании'. print_r($item->errors, true));
        }
 
        return $this->controller->render('edit', ['item' => $item]);
    }

    /**
     * sendRedirect
     *
     * @param Model $item
     * @return void
     */
    private function sendRedirect(Model $item)
    {
        $this->controller->redirect($this->getRedirectUrl($item));
    }
}