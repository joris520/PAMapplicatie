<?php

/**
 * Description of PdpActionCompletedStatusValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class PdpActionCompletedStatusValue extends BaseDatabaseValue
{

    // mode
    const DATABASE_MODE = 1;
    const REPORT_MODE   = 2;

    // gebruikt in reports
    const NO_PDP_ACTION         = -2;

    const NOT_COMPLETED_EXPIRED = -1;

	// employees_pdp_actions.is_completed
    const NOT_COMPLETED = 1;
    const COMPLETED     = 2;
    const CANCELLED     = 3;

    static function values($mode = self::DATABASE_MODE)
    {
        switch ($mode) {
            case self::REPORT_MODE:
                $values = array(
                    PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED,
                    PdpActionCompletedStatusValue::NOT_COMPLETED,
                    PdpActionCompletedStatusValue::COMPLETED,
                    PdpActionCompletedStatusValue::CANCELLED
                    );
                break;
            case self::DATABASE_MODE:
            default:
                $values = array(
                    PdpActionCompletedStatusValue::NOT_COMPLETED,
                    PdpActionCompletedStatusValue::COMPLETED,
                    PdpActionCompletedStatusValue::CANCELLED
                    );
                break;

        }
        return $values;
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }
}

?>
