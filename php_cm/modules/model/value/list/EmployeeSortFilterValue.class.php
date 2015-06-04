<?php

/**
 * Description of EmployeeSortFilterValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class EmployeeSortFilterValue extends BaseDatabaseValue
{
    // mode
    const MODE_ALPHABETICAL =  1;
    const MODE_ASSESSMENT   =  2;

    // values
    // Filters voor medewerkerslijst
    const SORT_ALPHABETICAL                 =  1;
    const SORT_ASSESSMENT_STATE             =  2;


    static function values($mode = self::MODE_ASSESSMENT)
    {
        $values =   array(
                        self::SORT_ALPHABETICAL
                    );

        if ($mode == self::MODE_ASSESSMENT) {
            $values[] = self::SORT_ASSESSMENT_STATE;
        }
        return $values;
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

}

?>
