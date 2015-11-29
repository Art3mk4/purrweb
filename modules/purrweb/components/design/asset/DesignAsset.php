<?php
namespace app\modules\purrweb\components\design\asset;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * Description of DesignAsset
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class DesignAsset extends AssetBundle
{
    /**
     *
     * @var type 
     */
    public $sourcePath = '@app/modules/purrweb/components/design/resources';

    /**
     *
     * @var type 
     */
    public $css = [
        'css/reset.css',
        'fonts/fonts.css',
        'css/screen.css'
    ];

    /**
     *
     * @var type 
     */
    public $js = [
        'js/libs/html5.js',
        'js/libs/jquery.validate.min.js',
        'js/libs/chosen.jquery.min.js',
        'js/views/layout/systemMessage.js',
        'js/views/layout/appRequest.js',
        'js/views/layout/selectInit.js',
    ];

    /**
     *
     * @var type 
     */
    public $depends = [
        'app\modules\purrweb\components\design\asset\JqueryAsset',
        'app\modules\purrweb\components\design\asset\YiiAsset',
        'app\modules\purrweb\components\design\asset\UnderscoreAsset'
    ];

    /**
     *
     * @var type 
     */
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
    
    /**
     *
     * @var type 
     */
    public $cssOptions = [
        'position' => View::POS_HEAD
    ];

    /**
     * 
     * @param type $view
     */
    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);
        $view->registerMetaTag(['content' =>  $this->baseUrl, 'name' => 'design_asset_url'], 'design_asset_url');
    }
}