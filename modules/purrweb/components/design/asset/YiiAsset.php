<?php
namespace app\modules\purrweb\components\design\asset;
use yii\web\AssetBundle;

/**
 * Description of YiiAsset
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class YiiAsset extends AssetBundle
{ 
    /**
     *
     * @var type 
     */
    public $sourcePath = '@yii/assets';
    
    /**
     *
     * @var type 
     */
    public $js = [
        'yii.js',
    ];
}