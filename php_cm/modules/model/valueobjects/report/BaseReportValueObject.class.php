<?php

/**
 * Description of BaseReportValueObject
 *
 * @author ben.dokter
 */
class BaseReportValueObject extends BaseValueObject
{
    private $id;

    protected function __construct($id = NULL)
    {
        parent::__construct(NULL, NULL, NULL, NULL);

        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }
}

?>
