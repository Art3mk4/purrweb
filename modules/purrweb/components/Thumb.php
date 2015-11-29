<?php
namespace app\modules\purrweb\components;

use yii\base\Object;
use yii\web\UploadedFile;
use Yii;

/*
//resize
'min'  => array(
    'mode' => 'resize',
    'resize' => array(
        'width' => '180',
    ),
    'crop' => array(
        'width' => '130',
        'height' => '100',
    ),
),

//adaptive_crop
'full' => array(
    'mode' => 'adaptive_crop',
    'resize' => array(
        'width' => '500',
        'height' => '300',
    ),
    'crop' => array(
        'width' => '500',
        'height' => '300',
    ),
),
*/

/**
 * Description of BaseController
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class Thumb extends Object
{

    const FULL_NAME = 'full';

    /**
     * _name
     *
     * @var string
     */
    private $_name;

    /**
     * _fullpath
     *
     * @var string
     */
    private $_fullpath;

    /**
     * _source
     *
     * @var UploadedFile
     */
    private $_source;

    /**
     * _options
     *
     * @var array
     */
    private $_options; 

    /**
     * _lib
     *
     * @var EasyPHPThumb
     */
    private $_lib;

    /**
     * _originSize
     *
     * @var array
     */
    private $_originSize;

    /**
     * getFullOptions
     *
     * @return array
     */
    public static function getFullOptions()
    {
        return [
            'height' => 800
        ];
    }


    /**
     * __construct
     *
     * @param mixed $fullpath
     * @param mixed $name
     * @param array $options
     * @param string $source
     * @return void
     */
    public function __construct($fullpath, $name, array $options, $source)
    {
        $this->_name = $name;
        $this->_source = $source;
        $this->_options = $options;
        $this->_fullpath = $fullpath;

        require_once(Yii::getAlias('@app/vendor/xtlan/phpthumb/EasyPhpThumb.php'));
        $this->_lib = new \EasyPhpThumb();

    
    }

    /**
     * save
     *
     * @return void
     */
    public function save()
    {
        //Получаем оригинальный размер
        $this->_originSize = $this->getOriginSizeFromFile();

        //Определяем режим что делать с картинкой по опциям
        $thumbMode = $this->getThumbMode();

        //Загружаем картинку
        $image = $this->_lib
            ->load($this->_source);

        //В зависимости от режима
        switch($thumbMode) {
            case 'adaptive_crop':
                $image = $this->adaptiveResize($image);
                $image = $this->crop($image);
                break;
            case 'crop':
                $iamge = $this->crop($image);
                break;
            case 'resize':
            default:
                $image = $this->resize($image);
                break;
            case 'ownAdaptive_crop':
                $image = $this->ownAdaptiveResize($image);
                $image = $this->crop($image);
                break;
        }

        //Сохраняем картинку
        return $image->save($this->_fullpath);
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        return unlink($this->_fullpath);
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /* *
     * crop
     *
     * @param mixed $image
     * @access private
     * @return void
     */
    private function crop($image) {
        //Получаем размеры для вырезания
        $thumbSize = $this->getThumbSize('crop');
        //Задаем новые размеры в качестве исходных
        $this->_originSize = $thumbSize;;

        //Получаем координаты  для вырезания
        $cropCoords = $this->getCropCoords($thumbSize);

        //Обрезаем картинку по центру если нет координат
        if(empty($cropCoords))
            return $image->cropFromCenter($thumbSize['width'], $thumbSize['height']);

        //Либо вырезаем по точным координатам
        return $image->crop($cropCoords['x'],$cropCoords['y'],$thumbSize['width'],$thumbSize['height']);
    }


    /**
     * resize
     *
     * @param mixed $image
     * @access private
     * @return void
     */
    private function resize($image) {
        //Получаем размеры для вырезания
        $thumbSize = $this->getThumbSize('resize');
        //Задаем новые размеры в качестве исходных
        $this->_originSize = $thumbSize;;

        return $image->resize($thumbSize['width'],$thumbSize['height']);
    }


    /**
     * adaptiveResize
     *
     * @param mixed $image
     * @access private
     * @return void
     */
    private function adaptiveResize($image) {
        //Получаем размеры для вырезания
        $thumbSize = $this->getThumbSize('resize');
        //Задаем новые размеры в качестве исходных
        $this->_originSize = $thumbSize;;

        return $image->adaptiveResize($thumbSize['width'], $thumbSize['height']);
    }

    /**
     * ownAdaptiveResize
     *
     * @param mixed $image
     * @access private
     * @return void
     */
    private function ownAdaptiveResize($image) {
        //Теперь определяяем размеры для адаптивного уменьшения
        $thumbSize = $this->getOwnAdaptiveThumbSize('resize');
        return $image->resize($thumbSize['width'], $thumbSize['height']);
    }


    /**
     * getOriginSizeFromFile
     *
     * @access private
     * @return void
     */
    private function getOriginSizeFromFile() {
        $fileSize = getimagesize($this->_source);
        return array('width' => $fileSize[0], 'height' => $fileSize[1]);
    }

    /**
     * getThumbMode
     *
     * @return void
     */
    private function getThumbMode() {
        if(!isset($this->_options['mode']))
            return 'adaptive_resize';
        return $this->_options['mode'];
    }

    /**
     * getThumbSize
     *
     * @param bool $mode
     * @access private
     * @return void
     */
    private function getThumbSize( $mode = 'crop') {

        //Для начала берем размер из всего размера
        $size = $this->_options;
        //Проверяем размеры картинки доступны ли в отдельном массиве
        if(isset($this->_options[$mode]))
            $size = $this->_options[$mode];

        //Миниатюры размеры
        if(!isset($size['width']))
            $size['width'] = $this->_originSize['width'];

        if(!isset($size['height']))
            $size['height'] = $this->_originSize['height'];

        return $size;
    }

    /**
     * getOwnAdaptiveThumbSize
     *
     * @param bool $mode
     * @access private
     * @return void
     */
    private function getOwnAdaptiveThumbSize( $mode = 'crop') {

        //Для начала берем размер по стандартному
        $size = $this->getThumbSize($mode);

        //Опрделеяем отклонение ширины
        $dw = $size['width'] / $this->_originSize['width'];

        //Определяем отклонение высоты
        $dh = $size['height'] / $this->_originSize['height'];

        //Определяем минимальное отклонение
        $d = $dw > $dh ? $dw : $dh;
        $d = $d == 0 ? 1 : $d;

        //Определяем новые размеры с учетом минимума
        $size['width'] = round($this->_originSize['width']*$d);
        $size['height'] = round($this->_originSize['height']*$d);

        return $size;
    }



    /**
     * getCropCoords
     *
     * @return void
     */
    private function getCropCoords() {
         //Для начала берем размер из всего размера
        $coords = $this->_options;
        //Проверяем размеры картинки доступны ли в отдельном массиве
        if(isset($this->_options['crop']))
            $coords = $this->_options['crop'];

        //Если не заданы координаты
        if(!isset($coords['x']) and !isset($coords['y']))
            return array();

        //Определяем коодинату x
        if(!isset($coords['x'])) {
            $coords['x'] = 0;
        } elseif($coords['x'] < 0) {
            $x = abs($coords['x']);
            $coords['x'] = $this->_originSize['width'] - $x;
        }

        //Определяем коодинату y
        if(!isset($coords['y'])) {
            $coords['y'] = 0;
        } elseif($coords['y'] < 0) {
            $y = abs($coords['y']);
            $coords['y'] = $this->_originSize['height'] - $y;
        }

        return $coords;

    }

    
}
