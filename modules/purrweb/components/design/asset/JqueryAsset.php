<?php
namespace app\modules\purrweb\components\design\asset;
use yii\web\AssetBundle;

/**
 * Description of JqueryAsset
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class JqueryAsset extends AssetBundle
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
    public $js = [
        'js/libs/jquery-1.7.2.min.js'
    ];
}