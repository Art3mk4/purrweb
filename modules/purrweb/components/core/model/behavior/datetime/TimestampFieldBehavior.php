<?php
namespace app\modules\purrweb\components\core\model\behavior\datetime;

use yii\db\ActiveRecord;
use yii\base\Behavior;
use app\modules\purrweb\components\core\datetime\NullDatetime;

/**
 * Description of TimestampFieldBehavior
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class TimestampFieldBehavior extends Behavior
{

    /**
     *
     * @var type 
     */
    public $fields = ['time'];

    /**
     * events
     *
     * @return void
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',

            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',

            ActiveRecord::EVENT_AFTER_INSERT => 'afterFind',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterFind'
        ];
    }

    /**
     * afterFind
     * 
     * @param type $event
     */
    public function afterFind($event)
    {
        $sender = $event->sender;
        foreach ($this->fields as $field) {
            $oldValue = $sender->$field;

            $newValue = empty($oldValue) ? new NullDatetime() : new \DateTime();
            $newValue->setTimestamp($oldValue);

            $sender->$field = $newValue;
        }
    }

    /**
     * beforeSave
     *
     * @param mixed $event
     * @return void
     */
    public function beforeSave($event)
    {
        $sender = $event->sender;
        foreach ($this->fields as $field) {
            $oldValue = $sender->$field;

            $sender->$field = $oldValue->getTimestamp();
        }
    }
}