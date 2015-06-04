<?php

/**
 * Description of BaseBatchValueObject
 *
 * @author ben.dokter
 */
require_once('application/model/valueobjects/BaseValueObject.class.php');

class BaseBatchValueObject extends BaseValueObject
{
    protected function __construct()
    {
        parent::__construct(NULL, NULL, NULL, NULL);
    }
}

?>
