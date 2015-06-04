<?php

/**
 * Description of CompetenceInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/library/CompetenceInterfaceBuilder.class.php');

class CompetenceInterfaceProcessor
{

    static function showDetail($objResponse, $competenceId, $mode)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORES) || PermissionsService::isViewAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
            $contentPrefix = ($mode == CompetenceInterfaceBuilder::DISPLAY_MODE_POPUP) ? 'edit_' : '';

            // de onClick aanpassen
            InterfaceXajax::changeOnClickFunction(  $objResponse,
                                                    $contentPrefix . CompetenceInterfaceBuilderComponents::getDetailLinkId($competenceId),
                                                    CompetenceInterfaceBuilderComponents::getHideDetailOnClick($competenceId, $mode));
            // en de details invullen
            InterfaceXajax::setHtml($objResponse,
                                    $contentPrefix . 'detail_content_' . $competenceId,
                                    CompetenceInterfaceBuilder::getCompetenceDetailHtml($competenceId, SHOW_LAST_MODIFIED));
            InterfaceXajax::fadeInDetail($objResponse,
                                         $contentPrefix . 'detail_row_' . $competenceId);
        }
    }

    static function hideDetail($objResponse, $competenceId, $mode)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORES) || PermissionsService::isViewAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
            $contentPrefix = ($mode == CompetenceInterfaceBuilder::DISPLAY_MODE_POPUP) ? 'edit_' : '';

            // de onClick aanpassen
            InterfaceXajax::changeOnClickFunction(  $objResponse,
                                                    $contentPrefix . CompetenceInterfaceBuilderComponents::getDetailLinkId($competenceId),
                                                    CompetenceInterfaceBuilderComponents::getShowDetailOnClick($competenceId, $mode));
            // en de details weghalen
            InterfaceXajax::fadeOutDetailAndClearContent(   $objResponse,
                                                            $contentPrefix . 'detail_row_' . $competenceId,
                                                            $contentPrefix . 'detail_content_' . $competenceId);
        }
    }
}

?>
