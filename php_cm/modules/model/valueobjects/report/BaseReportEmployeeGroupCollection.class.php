<?php

/**
 * Description of BaseReportEmployeeGroupCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseGroupCollection.class.php');
require_once('modules/model/valueobjects/report/BaseReportEmployeeCollection.class.php');

class BaseReportEmployeeGroupCollection extends BaseGroupCollection
{
    static function create()
    {
        return new BaseReportEmployeeGroupCollection();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCollection( $key,
                            BaseReportEmployeeCollection $collection)
    {
        parent::setCollection($key, $collection);
    }

    /**
     * @return BaseReportEmployeeCollection
     */
    function  getCollection($key)
    {
        return parent::getCollection($key);
    }



}

?>
