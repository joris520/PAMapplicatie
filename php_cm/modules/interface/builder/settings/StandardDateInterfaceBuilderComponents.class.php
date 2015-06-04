<?php


/**
 * Description of StandardDateInterfaceBuilderComponents
 *
 * @author ben.dokter
 */
require_once('application/interface/ApplicationInterfaceBuilder.class.php');

class StandardDateInterfaceBuilderComponents
{
    static function getEditLink()
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_DEFAULT_DATE)) {
            $html .= InterfaceBuilder::iconLink('edit_standardDate',
                                                TXT_UCF('EDIT'),
                                                'xajax_public_settings__editStandardDate();',
                                                ICON_EDIT);
        }
        return $html;
    }


}

?>
