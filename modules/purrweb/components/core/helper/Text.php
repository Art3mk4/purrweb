<?php
namespace app\modules\purrweb\components\core\helper;

/**
 * Description of Text
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class Text
{

    /**
     * wordNum
     * 
     * @param type $ids
     * @param type $words
     * @return type
     */
    public static function wordNum($ids, $words)
    {
        $number = (int)substr($ids, -2, 2);
        if ($number >= 5 && $number < 21) {
            return $words[2];
        }
        $number %= 10;
        if ($number == 1) {
            return $words[0];
        }
        if ($number >= 2 && $number <= 4) {
            return $words[1];
        }

        return $words[2];
    }
}