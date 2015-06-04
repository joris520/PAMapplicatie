<?php

/**
 * Description of EmployeeModulePrintOption
 *
 * @author hans.prins
 */

require_once('application/print/option/AbstractBasePrintOption.class.php');

class EmployeeModulePrintOption extends AbstractBasePrintOption
{
    // besturing
    const INCLUDE_OPTION_SIGNATURE = TRUE;
    const EXCLUDE_OPTION_SIGNATURE = FALSE;

    // options

    // letop: de volgorde hier bepaalt ook de afdrukvolgorde.
    const OPTION_PROFILE        = 1;
    const OPTION_ATTACHMENT     = 2;
    const OPTION_COMPETENCE     = 3;
    const OPTION_PDP_ACTION     = 4;
    const OPTION_PDP_COST       = 5;
    const OPTION_TARGET         = 6;
    const OPTION_FINAL_RESULT   = 7;
    const OPTION_360            = 8;
    const OPTION_SIGNATURE      = 9;

    static function options(Array $modules = NULL,
                            $signature = self::EXCLUDE_OPTION_SIGNATURE)
    {
        $options = array();

        if (!is_null($modules)) {
            foreach($modules as $module) {
                switch($module) {
                    case MODULE_EMPLOYEE_ATTACHMENTS:
                        $options[self::OPTION_ATTACHMENT] = self::OPTION_ATTACHMENT;
                        break;
                    case MODULE_EMPLOYEE_PROFILE:
                        $options[self::OPTION_PROFILE] = self::OPTION_PROFILE;
                        break;
                    case MODULE_EMPLOYEE_SCORE:
                        $options[self::OPTION_COMPETENCE] = self::OPTION_COMPETENCE;
                        break;
                    case MODULE_EMPLOYEE_PDP_ACTIONS:
                        $options[self::OPTION_PDP_ACTION] = self::OPTION_PDP_ACTION;
                        $options[self::OPTION_PDP_COST] = self::OPTION_PDP_COST;
                        break;
                    case MODULE_EMPLOYEE_TARGETS:
                        $options[self::OPTION_TARGET] = self::OPTION_TARGET;
                        break;
                    case MODULE_EMPLOYEE_FINAL_RESULTS:
                        $options[self::OPTION_FINAL_RESULT] = self::OPTION_FINAL_RESULT;
                        break;
                    case MODULE_EMPLOYEE_360:
                        //$options[self::OPTION_360] = self::OPTION_360;
                        break;
                }
            }
        }

        if ($signature == self::INCLUDE_OPTION_SIGNATURE) {
            $options[self::OPTION_SIGNATURE] = self::OPTION_SIGNATURE;
        }

        // nu even snel sorteren...
        ksort($options);
        return $options;
    }

    static function isValidOption($option)
    {
        return self::isAllowedOption($option, self::options());
    }

}

?>
