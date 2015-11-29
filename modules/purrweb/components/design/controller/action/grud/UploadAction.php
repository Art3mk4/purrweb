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
class UploadAction extends Action
{

    /**
     * run
     *
     * @return void
     */
    public function run()
    {
        $id = $this->getId();
        $item = $this->findItem($id);
        if (Yii::$app->request->isPost) {
            $item->imageFile = UploadedFile::getInstances($item, 'imageFile');
            if ($item->upload()) {
                // file is uploaded successfully
                return;
            }
        }
 
        return $this->sendRedirect($item);
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