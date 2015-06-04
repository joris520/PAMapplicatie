<?php

/**
 * Description of EmployeeSortFilterConverter
 *
 * @author ben.dokter
 */
require_once('application/interface/converter/AbstractBaseConverter.class.php');

class EmployeeSortFilterConverter extends AbstractBaseConverter
{

    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case EmployeeSortFilterValue::SORT_ALPHABETICAL:
                $display = TXT_UCF('FILTER_EMPLOYEES_SORT_ALPHABETICAL');
                break;
            case EmployeeSortFilterValue::SORT_ASSESSMENT_STATE:
                $display = TXT_UCF('FILTER_EMPLOYEES_SORT_ASSESSMENT_STATUS_MANAGER');
                break;
        }
        return $display;
    }

    // default de display
    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }

    static function description($value)
    {
        $description = '';
        switch($value) {
            case EmployeeSortFilterValue::SORT_ALPHABETICAL:
                $description = TXT_UCF('FILTER_EMPLOYEES_TITLE_SORT_ALPHABETICAL');
                break;
            case EmployeeSortFilterValue::SORT_ASSESSMENT_STATE:
                $description = TXT_UCF('FILTER_EMPLOYEES_TITLE_SORT_ASSESSMENT_STATUS_MANAGER');
                break;
        }
        return $description;
    }

}

?>
