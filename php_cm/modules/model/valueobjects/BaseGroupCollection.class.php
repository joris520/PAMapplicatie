<?php

/**
 * Description of BaseGroupCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');

class BaseGroupCollection
{
    protected $collections;

    protected function __construct()
    {
        $this->collections = array();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getKeys()
    {
        return array_keys($this->collections);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    protected function setCollection(   $key,
                                        BaseCollection $collection)
    {
        $this->collections[$key] = $collection;
    }

    /**
     * @return BaseCollection
     */
    function getCollection($key)
    {
        return $this->collections[$key];
    }

//    function hasCollection($key)
//    {
//        return count($this->collections[$key]) > 0;
//    }


}

?>
