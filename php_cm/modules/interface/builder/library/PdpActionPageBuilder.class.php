<?php

/**
 * Description of PdpActionPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/library/PdpActionInterfaceBuilder.class.php');

class PdpActionPageBuilder
{
    static function getPageHtml($displayWidth,
                                PdpActionClusterGroupCollection $clusterGroupCollection,
                                PdpActionUserDefinedGroupCollection $userDefinedClusterGroupCollection = NULL,
                                $hiliteId = NULL)
    {
        $html = PdpActionInterfaceBuilder::getActionHtml(           $displayWidth) .

                PdpActionInterfaceBuilder::getViewHtml(             $displayWidth,
                                                                    $clusterGroupCollection,
                                                                    $hiliteId);

        if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
            $html .=    PdpActionInterfaceBuilder::getUserDefinedViewHtml(  $displayWidth,
                                                                            $userDefinedClusterGroupCollection);
        }

        return $html;
    }

    static function getAddPopupHtml($displayWidth,
                                    $contentHeight,
                                    PdpActionValueObject $valueObject)
    {
        list($safeFormHandler, $contentHtml) = PdpActionInterfaceBuilder::getAddHtml(   $displayWidth,
                                                                                        $valueObject);

        // popup
        $title = TXT_UCF('ADD_NEW_PDP_ACTION');
        $formId = 'add_new_pdp_action';
        return ApplicationInterfaceBuilder::getAddPopupHtml($formId,
                                                            $safeFormHandler,
                                                            $title,
                                                            $contentHtml,
                                                            $displayWidth,
                                                            $contentHeight,
                                                            ApplicationInterfaceBuilder::HIDE_WARNING);
    }


    static function getEditPopupHtml(   $displayWidth,
                                        $contentHeight,
                                        PdpActionValueObject $valueObject)
    {
        list($safeFormHandler, $contentHtml) = PdpActionInterfaceBuilder::getEditHtml(  $displayWidth,
                                                                                        $valueObject);

        // popup
        $title = TXT_UCF('EDIT_ACTION_LIBRARY');
        $formId = 'edit_pdp_action';
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight,
                                                                ApplicationInterfaceBuilder::HIDE_WARNING);
    }

    static function getRemovePopupHtml( $displayWidth,
                                        $contentHeight,
                                        PdpActionValueObject $valueObject)
    {
        $popupHtml = '';
        $title = TXT_UCF('DELETE_PDP_ACTION');

        list($hasError, $messages) = PdpActionService::validateRemove($valueObject);

        if ($hasError) {
            $contentHtml = ApplicationInterfaceBuilder::getMessagesHtml($messages);
            $popupHtml = ApplicationInterfaceBuilder::getInfoPopupHtml( $title,
                                                                        $contentHtml,
                                                                        $displayWidth,
                                                                        $contentHeight);
        } else {
            list($safeFormHandler, $contentHtml) = PdpActionInterfaceBuilder::getRemoveHtml($displayWidth,
                                                                                            $valueObject);

            // popup
            $formId = 'delete_pdp_action';
            $popupHtml = ApplicationInterfaceBuilder::getRemovePopupHtml(   $formId,
                                                                            $safeFormHandler,
                                                                            $title,
                                                                            $contentHtml,
                                                                            $displayWidth,
                                                                            $contentHeight);
        }
        return $popupHtml;
    }


    static function getEditClusterPopupHtml($displayWidth,
                                            $contentHeight,
                                            PdpActionClusterValueObject $clusterValueObject)
    {
        list($safeFormHandler, $contentHtml) = PdpActionInterfaceBuilder::getEditClusterHtml(   $displayWidth,
                                                                                                $clusterValueObject);

        // popup
        $title = TXT_UCF('UPDATE_CLUSTER');
        $formId = 'edit_pdp_action_cluster';
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight,
                                                                ApplicationInterfaceBuilder::HIDE_WARNING);

    }

    static function getRemoveClusterPopupHtml(  $displayWidth,
                                                $contentHeight,
                                                PdpActionClusterValueObject $clusterValueObject)
    {
        $popupHtml = '';
        $title = TXT_UCF('DELETE_CLUSTER');

        list($hasError, $messages) = PdpActionClusterService::validateRemoveCluster($clusterValueObject);
        if ($hasError) {
            $contentHtml = ApplicationInterfaceBuilder::getMessagesHtml($messages);
            $popupHtml = ApplicationInterfaceBuilder::getInfoPopupHtml( $title,
                                                                        $contentHtml,
                                                                        $displayWidth,
                                                                        $contentHeight);
        } else {
            list($safeFormHandler, $contentHtml) = PdpActionInterfaceBuilder::getRemoveClusterHtml( $displayWidth,
                                                                                                    $clusterValueObject);

            // popup
            $formId = 'delete_pdp_action_cluster';
            $popupHtml = ApplicationInterfaceBuilder::getRemovePopupHtml(   $formId,
                                                                            $safeFormHandler,
                                                                            $title,
                                                                            $contentHtml,
                                                                            $displayWidth,
                                                                            $contentHeight);
        }
        return $popupHtml;
    }

    static function getEmployeesPopupHtml(  $detailWidth,
                                            $contentHeight,
                                            BaseReportEmployeeCollection $collection)
    {
        $contentHtml = BaseReportEmployeeInterfaceBuilder::getEmployeesHtml($displayWidth,
                                                                            $collection,
                                                                            TXT_UCF('USAGE'));

        // popup
        $title = TXT_UCF('PDP_ACTION') . ' ' . TXT_LC('USAGE');
        return ApplicationInterfaceBuilder::getInfoPopupHtml(   $title,
                                                                $contentHtml,
                                                                $detailWidth,
                                                                $contentHeight);
    }


}

?>
