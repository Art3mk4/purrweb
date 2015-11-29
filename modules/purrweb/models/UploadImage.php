<?php
namespace app\modules\purrweb\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use app\modules\purrweb\models\query\UploadImageQuery;
use app\modules\purrweb\components\core\model\behavior\datetime\AutoTimeBehavior;
use Yii;

/**
 * Description of UploadImage
 *
 * @author art3mk4
 */
class UploadImage extends ActiveRecord
{

    const FULL_THUMB = 'full';

    /**
     * file
     *
     * @var UploadedFile
     */
    public $file;

    /**
     * tableName
     *
     * @return string
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * find
     *
     * @return UploadImageQuery
     */
    public static function find()
    {
        return new UploadImageQuery(get_called_class());
    }

    /**
     * sort
     */
    public function sort()
    {
        return $this->sortBySort();
    }

    /**
     * behaviors
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            AutoTimeBehavior::className()
        ];
    }

    /**
     * rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['filename', 'string', 'max' => 512],
            [['model', 'field', 'title', 'type'], 'string', 'max' => 512],

            ['file', 'file', 'on' => 'insert'],
            ['modelClass', 'string', 'max' => 512],

            [['sort', 'model_id', 'published'], 'integer'],
            ['field', 'default', 'value' => 'file'],
        ];
    }



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'url' => 'Полное имя файла',
            'filename' => 'Имя файла(без расширения)',
            'type' => 'Расширение',
            'model' => 'Тип модели',
            'model_id' => 'Идентификатор модели',
            'created' => 'Дата создания',
            'modified' => 'Дата модификации',
            'sort' => 'Сортировка',
        ];
    }


    /**
     * getFullname
     *
     * @return string
     */
    public function getFullname($thumb = null)
    {
        return $this->getFullpath() . '/' . $this->getName($thumb);
    }

    /**
     * getUrl
     *
     * @return string
     */
    public function getUrl($thumb = null)
    {
        $path = $this->getPath();
        return '/' . $path . "/" . $this->getName($thumb); 
    }


    /**
     * beforeSave
     *
     * @return true
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $file = $this->file;
            $this->title = $file->baseName;
            $this->type = $file->extension;
            $this->checkPath();
            $this->filename = $file->baseName;
        }

        $file->saveAs($this->getFullpath() . $file->baseName . '.' . $file->extension);
        return parent::beforeSave($insert);
    }

    /**
     * checkPath
     *
     * @return void
     */
    private function checkPath()
    {
        $fullpath = $this->getFullpath();
        //Если такого пути нет
        if(!is_writable($fullpath)) {
            mkdir($fullpath, 0777, true);
        }
    }

    /**
     * getPath
     *
     * @return string
     */
    private function getPath()
    {
        return  "upload/{$this->model}/{$this->field}/";
    }
    
    /**
     * getFullpath
     *
     * @return string
     */
    private function getFullpath()
    {
        return Yii::getAlias("@app/web/") . $this->getPath();
    }
}