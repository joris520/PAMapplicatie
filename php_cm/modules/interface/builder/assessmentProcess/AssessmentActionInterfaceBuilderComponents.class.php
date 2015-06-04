<?php

/**
 * Description of AssessmentActionInterfaceBuilderComponents
 *
 * @author ben.dokter
 */
require_once('modules/interface/state/AssessmentProcessActionButton.class.php');
require_once('modules/interface//converter/state/AssesssmentProcessActionStateConverter.class.php');

class AssessmentActionInterfaceBuilderComponents
{


    // tsn process knopjes


    static function getSelectedAction($safeFormIdentifier, $formId, $selectedAction)
    {
        $html = '';
        if (PermissionsService::isExecuteAllowed(AssessmentProcessActionButton::getPermissionForAction($selectedAction))) {
            $title = AssesssmentProcessActionStateConverter::display($selectedAction);
            $buttonId = AssessmentProcessActionButton::getButtonIdForAction($selectedAction);
            $buttonLabel = AssessmentProcessActionButton::getLabelForButtonId($buttonId);

            $html .= '<img src="' . ICON_INFO . '" class="icon-style" border="0" height="14" width="14" title="' . $title . '">&nbsp;' .
                     '<input class="btn btn_width_150" id="' . $buttonId . '" type="button" ' .
                        'onclick="submitActionSafeForm(\''.$safeFormIdentifier . '\', \'' . $formId . '\', this.id);return false;" ' .
                        'value="' . $buttonLabel . '">';
        }
        return $html;
    }

    static function getSelectedUndo($safeFormIdentifier, $formId, $selectedAction)
    {
        $html = '';
        if (PermissionsService::isExecuteAllowed(AssessmentProcessActionButton::getPermissionForAction($selectedAction))) {
            $title = AssesssmentProcessActionStateConverter::display($selectedAction);
            $buttonId = AssessmentProcessActionButton::getButtonIdForAction($selectedAction);
            $html .= '<a id="' . $buttonId . '" href="" title="' . $title . '" onclick="submitActionSafeForm(\''.$safeFormIdentifier . '\', \'' . $formId . '\', this.id);return false;">' .
                     '<img src="' . ICON_UNDO . '" class="icon-style" border="0">' .
                     '</a>';
        }
        return $html;
    }

}

?>
