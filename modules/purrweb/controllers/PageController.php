<?php
namespace app\modules\purrweb\controllers;
use app\modules\purrweb\components\BaseController;
use app\modules\purrweb\models\Page;

/**
 * Description of PageController
 *
 * @author art3mk4
 */
class PageController extends BaseController
{

    /**
     * 
     * @return type
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\modules\purrweb\components\design\controller\action\grud\IndexAction',
                'modelName' => Page::className(),
                'order' => 'date',
                'dir' => 'DESC'
            ],
            'add' => [
                'class' => 'app\modules\purrweb\components\design\controller\action\grud\AddAction',
                'modelName' => Page::className()
            ], 
            'edit' => [
                'class' => 'app\modules\purrweb\components\design\controller\action\grud\EditAction',
                'modelName' => Page::className()
            ], 
            'delete' => [
                'class' => 'app\modules\purrweb\components\design\controller\action\grud\DeleteAction',
                'modelName' => Page::className()
            ],
            'upload' => [
                'class' => 'app\modules\purrweb\components\design\controller\action\grud\UploadAction',
                'modelName' => Page::className()
            ], 
        ];
    }
}