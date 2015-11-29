<?php
namespace Xtlan\Design\Asset;
use yii\web\AssetBundle;

/**
 * Description of UnderscoreAsset
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class UnderscoreAsset extends AssetBundle
{
    /**
     *
     * @var type 
     */
    public $sourcePath = '@vendor/bower/underscore';
    
    /**
     *
     * @var type 
     */
    public $js = [
        'underscore.js'
    ];
}