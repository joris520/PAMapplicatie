<?php


/**
 * Description of BaseValueObject
 *
 * @author ben.dokter
 */

require_once('gino/DateUtils.class.php');

class BaseValueObject
{

    protected $databaseId;
    protected $savedByUserId;
    protected $savedByUserName;
    protected $savedDateTime;

    protected function __construct( $databaseId,
                                    $savedByUserId,
                                    $savedByUserName,
                                    $savedDateTime)
    {
        $this->databaseId       = $databaseId;
        $this->savedByUserId    = $savedByUserId;
        $this->savedByUserName  = $savedByUserName;
        $this->savedDatetime    = $savedDateTime;
    }

    function getId() {
        return $this->databaseId;
    }

    function isEmpty()
    {
        return empty($this->databaseId);
    }

    function hasId() {
        return !empty($this->databaseId);
    }

    function getSavedByUserId() {
        return $this->savedByUserId;
    }

    function getSavedByUserName() {
        return $this->savedByUserName;
    }

    function getSavedDateTime() {
        return $this->savedDatetime;
    }

    function getSavedInfo() {
        return array(   $this->savedByUserId,
                        $this->savedByUserName,
                        $this->savedDatetime);
    }

    function getSavedRefence()
    {
        return $this->databaseId . '/' . $this->savedByUserId;
    }

    function databaseDate($displayDate)
    {
        return DateUtils::convertToDatabaseDate($displayDate); // OF basequeries?
    }

}

?>
