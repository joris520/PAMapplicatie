<?php

/**
 * Description of DocumentClusterPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/library/DocumentClusterInterfaceBuilder.class.php');

class DocumentClusterPageBuilder
{
    static function getPageHtml($displayWidth, $hiliteId = NULL)
    {
        return DocumentClusterInterfaceBuilder::getViewHtml($displayWidth, $hiliteId);
    }

    static function getAddPopupHtml($displayWidth, $contentHeight, $showWarning)
    {
        list($safeFormHandler, $contentHtml) = DocumentClusterInterfaceBuilder::getAddHtml($displayWidth);

        // popup
        $title = TXT_UCF('ADD_ATTACHMENT_CLUSTER');
        $formId = 'add_documentcluster_form';
        return ApplicationInterfaceBuilder::getAddPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, $showWarning);
    }


    static function getEditPopupHtml($displayWidth, $contentHeight, $documentClusterId, $showWarning)
    {
        list($safeFormHandler, $contentHtml) = DocumentClusterInterfaceBuilder::getEditHtml($displayWidth, $documentClusterId);

        // popup
        $title = TXT_UCF('EDIT_ATTACHMENT_CLUSTER');
        $formId = 'edit_documentcluster_form_' . $documentClusterId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, $showWarning);
    }

    static function getRemovePopupHtml($displayWidth, $contentHeight, $documentClusterId)
    {
        $popupHtml = '';
        $title = TXT_UCF('DELETE') . ' ' . TXT_LC('ATTACHMENT_CLUSTER');

        if (!DocumentClusterService::isRemovable($documentClusterId)) {
            // TODO: betere html
            $contentHtml = TXT_UCF('YOU_CANNOT_DELETE_THIS_ATTACHMENT_CLUSTER_WHILE_THERE_ARE_ATTACHMENTS_CONNECTED_TO_IT');
            $popupHtml = ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
        } else {
            list($safeFormHandler, $contentHtml) = DocumentClusterInterfaceBuilder::getRemoveHtml($displayWidth, $documentClusterId);

            // popup
            $formId = 'delete_documentcluster_form_' . $documentClusterId;
            $popupHtml = ApplicationInterfaceBuilder::getRemovePopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
        }
        return $popupHtml;

    }
}

?>
