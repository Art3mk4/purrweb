<?php
namespace app\modules\purrweb\components\core\model\behavior\image;
use yii\base\Behavior;
use app\modules\purrweb\models\UploadImage;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Description of ImageBehavior
 *
 * @author art3mk4
 */
class ImageBehavior extends Behavior
{
    
    /**
     *
     * @var type 
     */
    public $relationName = 'images';

    /**
     * events
     *
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete'
        ];
    }

    /**
     * beforeDelete
     *
     * @param mixed $event
     * @return void
     */
    public function beforeDelete($event)
    {
        $sender = $event->sender;

        foreach ($sender->images as $image) {
            $image->delete();
        }
    }

    /**
     * getImages
     *
     * @return Relation
     */
    public function getImages()
    {
        $owner = $this->owner;

        return $owner->hasMany(UploadImage::className(), ['model_id' => 'id'])
            ->where(['model' => $owner->formName()])->sortBySort();
    }
    
    /**
     * upload
     */
    public function upload()
    {
        $owner = $this->owner;
        $image = $owner->imageFile[0];
        $upload = new UploadImage();
        $upload->file = $image;
        $upload->model = $owner->formName();
        $upload->model_id = $owner->id;
        if (!$upload->save()) {
            throw new Exception('Не удалось сохранить файл');
        }
    }
}