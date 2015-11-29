<?php
namespace app\modules\purrweb\components\design\data;

/**
 * Description of DataProviderInterface
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
interface DataProviderInterface
{

    /**
     * getAllModels
     *
     * @return array
     */
    public function getAllModels();

    /**
     * getPrevRow
     *
     * @return mixed
     */
    public function getPrevRow();

    /**
     * getNextRow
     *
     * @return mixed
     */
    public function getNextRow();
}