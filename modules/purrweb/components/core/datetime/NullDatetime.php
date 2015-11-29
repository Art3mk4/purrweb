<?php
namespace app\modules\purrweb\components\core\datetime;

/**
 * Description of NullDatetime
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class NullDatetime extends \Datetime
{

    /**
     * format
     *
     * @param mixed $format
     * @return void
     */
    public function format($format)
    {
        return '';
    }

    /**
     * getTimestamp
     *
     * @return void
     */
    public function getTimestamp()
    {
        return 0;
    }
}