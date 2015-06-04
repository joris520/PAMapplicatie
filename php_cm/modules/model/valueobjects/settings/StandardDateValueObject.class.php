<?php

/**
 * Description of StandardDateValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class StandardDateValueObject extends BaseValueObject
{
    public $defaultEndDate; // database Date format

    static function createWithData($standardDateId, $standardDateData)
    {
        return new StandardDateValueObject($standardDateId, $standardDateData);
    }

    static function createWithValues($standardDateId, $defaultEndDate)
    {
        $standardDateData = array();

        $standardDateData[StandardDateQueries::ID_FIELD] = $standardDateId;
        $standardDateData['default_end_date'] = $defaultEndDate;

        return new StandardDateValueObject($standardDateId, $standardDateData);
    }

    function __construct($standardDateId, $standardDateData)
    {
        parent::__construct($standardDateId,
                            $standardDateData['saved_by_user_id'],
                            $standardDateData['saved_by_user'],
                            $standardDateData['saved_datetime']);

        $this->defaultEndDate = $standardDateData['default_end_date'];
    }
}

?>
