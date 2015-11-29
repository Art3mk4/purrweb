<?php
namespace app\modules\purrweb\components;
use yii\web\Controller;

/**
 * Description of BaseController
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class BaseController extends Controller
{

    /**
     * actionIndex
     * 
     * @return type
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
