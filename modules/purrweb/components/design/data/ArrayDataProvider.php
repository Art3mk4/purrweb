<?php
namespace app\modules\purrweb\components\design\data;
use yii\data\ArrayDataProvider as BaseProvider;

/**
 * Description of ArrayDataProvider
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class ArrayDataProvider extends BaseProvider implements DataProviderInterface
{

    /**
     * getAllModels
     *
     * @return array
     **/
    public function getAllModels()
    {
        return $this->getModels();
    }

    /**
     * getPrevRow
     *
     * @return void
     */
    public function getPrevRow()
    {
        return null;
    }

    /**
     * getNextRow
     *
     * @return void
     */
    public function getNextRow()
    {
        return null;
    }
}