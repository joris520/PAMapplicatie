<?php

/**
 * Description of IdValue
 *
 * @author ben.dokter
 */
class IdValue
{
    private $databaseId;
    private $value;

    static function create($databaseId, $value)
    {
        return new IdValue($databaseId, $value);
    }

    protected function __construct($databaseId, $value)
    {
        $this->databaseId   = $databaseId;
        $this->value        = $value;
    }

    function getValue()
    {
        return $this->value;
    }

    function getDatabaseId()
    {
        return $this->databaseId;
    }
}

?>
