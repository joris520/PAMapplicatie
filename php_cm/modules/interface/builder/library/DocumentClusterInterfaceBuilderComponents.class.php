<?php

/**
 * Description of DocumentClusterInterfaceBuilderComponents
 *
 * @author ben.dokter
 */
class DocumentClusterInterfaceBuilderComponents
{

    static function getAddLink()
    {
        $html = '';
        if (PermissionsService::isAddAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('add_document_cluster',
                                                TXT_UCF('ADD'),
                                                'xajax_public_library__addDocumentCluster();',
                                                ICON_ADD);
        }
        return $html;
    }

    static function getEditLink($documentClusterId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('edit_document_cluster_' . $documentClusterId,
                                                TXT_UCF('EDIT'),
                                                'xajax_public_library__editDocumentCluster(' . $documentClusterId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getRemoveLink($documentClusterId)
    {
        $html = '';
        if (PermissionsService::isDeleteAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('delete_document_cluster_' . $documentClusterId,
                                                TXT_UCF('DELETE'),
                                                'xajax_public_library__removeDocumentCluster(' . $documentClusterId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }



}

?>
