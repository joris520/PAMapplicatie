<?php

/**
 * Description of BaseDatabaseValue
 *
 * @author ben.dokter
 */
require_once('application/model/value/BaseValue.class.php');

abstract class BaseDatabaseValue extends BaseValue
{
    // database field `active` tinyint(1) NOT NULL DEFAULT 1,
    const IS_ACTIVE  = 1;
    const IS_DELETED = 2;

}

?>
