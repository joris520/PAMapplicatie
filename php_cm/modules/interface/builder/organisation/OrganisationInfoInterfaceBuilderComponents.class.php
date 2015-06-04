<?php

/**
 * Description of OrganisationInfoInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class OrganisationInfoInterfaceBuilderComponents
{

    static function getEditLink()
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_MENU_ORGANISATION)) {
            $html .= InterfaceBuilder::iconLink('edit_organisationInfo',
                                                TXT_UCF('EDIT'),
                                                'xajax_public_organisationInfo__editInfo();',
                                                ICON_EDIT);
        }
        return $html;
    }


}

?>
