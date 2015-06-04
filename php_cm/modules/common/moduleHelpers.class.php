<?php

/**
 * Description of moduleHelpers
 *
 * @author ben.dokter
 */

require_once('application/interface/ApplicationNavigationConsts.inc.php');

class ModuleHelpers {

    static function getWelcomeMessage($module_name, $label = '** WERK IN UITVOERING **')
    {
        $html = '<h1>' . $label . '</h1>';
        switch ($module_name) {
            case MODULE_COMPETENCES:
                $welcomeMessage = '<p class="info-text">' .
                                        TXT_UCF('ON_THIS_SCREEN_YOU_CAN_CREATE_OR_EDIT_COMPETENCES') . '. <br />' .
                                        TXT_UCF('YOU_CAN_CHOOSE_FROM_THREE_CATEGORIES_JOB_SPECIFIC_PERSONAL_AND_MANAGERIAL') . '. <br />' .
                                        TXT_UCF('INSIDE_A_CATEGORY_YOU_CAN_GROUP_COMPETENCES_LOGICALLY_BY_USING_CLUSTERS') . '. <br />' .
                                  '</p>';
                break;
            case MODULE_EMPLOYEES:
                $welcomeMessage = '<p class="info-text">WelomeMessage:' .
                                    TXT_UCF('SELECT_EMPLOYEES') .
                                  '</p>';
                break;
        }
        return $html . $welcomeMessage;

    }

}

?>
