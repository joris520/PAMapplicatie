<?php

/**
 * Description of AssessmentCycleInterfaceBuilderComponents
 *
 * @author hans.prins
 */

require_once('application/interface/InterfaceBuilder.class.php');

class AssessmentCycleInterfaceBuilderComponents
{
    static function getAddLink()
    {
        $html = '';
        if (PermissionsService::isAddAllowed(PERMISSION_ASSESSMENT_CYCLE)) {
            $html .= InterfaceBuilder::iconLink('add_assessment_cyle',
                                                TXT_UCF('ADD_ASSESSMENT_CYCLE'),
                                                'xajax_public_library__addAssessmentCycle();',
                                                ICON_ADD);
        }
        return $html;
    }

    static function getEditLink($assessmentCycleId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_ASSESSMENT_CYCLE)) {
            $html .= InterfaceBuilder::iconLink('edit_assessment_cyle_' . $assessmentCycleId,
                                                TXT_UCF('EDIT'),
                                                'xajax_public_library__editAssessmentCycle(' . $assessmentCycleId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getRemoveLink($assessmentCycleId)
    {
        $html = '';
        if (PermissionsService::isDeleteAllowed(PERMISSION_ASSESSMENT_CYCLE)) {
            $html .= InterfaceBuilder::iconLink('delete_assessment_cyle_' . $assessmentCycleId,
                                                TXT_UCF('DELETE'),
                                                'xajax_public_library__removeAssessmentCycle(' . $assessmentCycleId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }

    static function getHoverInformationIcon($assessmentCycleId, $title)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_ASSESSMENT_CYCLE)) {
            $html .= InterfaceBuilder::iconHover('info_assessment_cyle_' . $assessmentCycleId,
                                                 $title,
                                                 ICON_INFO);
        }
        return $html;
    }
}

?>
