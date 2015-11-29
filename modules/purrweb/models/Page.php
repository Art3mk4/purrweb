<?php
/**
 * Description of Page
 *
 * @author art3mk4
 */
namespace app\modules\purrweb\models;
use yii\db\ActiveRecord;
use app\modules\purrweb\components\core\model\behavior\datetime\AutoTimeBehavior;
use app\modules\purrweb\components\core\model\behavior\image\ImageBehavior;

class Page extends ActiveRecord
{
    /**
     *
     * @var type 
     */
    public $imageFile;

    /**
     * tableName
     * 
     * @return string
     */
    public static function tableName()
    {
        return 'pages';
    }
    
    /**
     * find
     *
     * @return NewsQuery
     */
    public static function find()
    {
        return new query\PageQuery(get_called_class());
    }
    
    /**
     * 
     * @return type
     */
    public function behaviors()
    {
        return [
            AutoTimeBehavior::className(),
            ImageBehavior::className(),
        ];
    }

    /**
     * rules
     * 
     * @return type
     */
    public function rules()
    {
        return [
            ['title', 'default', 'value' => 'Введите название'],
            ['title', 'required'],

            [['published'], 'integer'],
            [['details', 'title'], 'string'],
        ];
    }
}