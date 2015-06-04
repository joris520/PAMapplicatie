<?php

/**
 * Description of DepartmentPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/organisation/DepartmentInterfaceBuilder.class.php');

class DepartmentPageBuilder
{
    static function getPageHtml($displayWidth,
                                $permission,
                                $hiliteId = NULL)
    {
        return DepartmentInterfaceBuilder::getViewHtml( $displayWidth,
                                                        $permission,
                                                        $hiliteId);
    }

    static function getAddPopupHtml($displayWidth, $contentHeight, $showWarning)
    {
        list($safeFormHandler, $contentHtml) = DepartmentInterfaceBuilder::getAddHtml($displayWidth);

        // popup
        $title = TXT_UCF('ADD_NEW_DEPARTMENT');
        $formId = 'add_department_form';
        return ApplicationInterfaceBuilder::getAddPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, $showWarning);
    }


    static function getEditPopupHtml($displayWidth, $contentHeight, $departmentId, $showWarning)
    {
        list($safeFormHandler, $contentHtml) = DepartmentInterfaceBuilder::getEditHtml($displayWidth, $departmentId);

        // popup
        $title = TXT_UCF('EDIT');
        $formId = 'edit_department_form_' . $departmentId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, $showWarning);
    }

    static function getRemovePopupHtml($displayWidth, $contentHeight, $departmentId)
    {
        $popupHtml = '';
        $title = TXT_UCF('DELETE');

        if (!DepartmentService::isRemovable($departmentId)) {
            // TODO: betere html
            $contentHtml = TXT_UCF('YOU_CANNOT_DELETE_THIS_DEPARTMENT_WHILE_THERE_ARE_EMPLOYEES_CONNECTED_IN_IT');
            $popupHtml = ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
        } else {
            list($safeFormHandler, $contentHtml) = DepartmentInterfaceBuilder::getRemoveHtml($displayWidth, $departmentId);

            // popup
            $formId = 'delete_department_form_' . $departmentId;
            $popupHtml = ApplicationInterfaceBuilder::getRemovePopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
        }
        return $popupHtml;

    }

    static function getEmployeesPopupHtml($detailWidth, $contentHeight, $departmentId)
    {
        $contentHtml = DepartmentInterfaceBuilder::getEmployeesHtml($detailWidth, $departmentId);

        // popup
        $title = TXT_UCF('ADDITIONAL_INFO') . ' ' . TXT_LC('EMPLOYEES');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $detailWidth, $contentHeight);
    }

    static function geUsersPopupHtml($detailWidth, $contentHeight, $departmentId)
    {
        $contentHtml = DepartmentInterfaceBuilder::getUsersHtml($detailWidth, $departmentId);

        // popup
        $title = TXT_UCF('ADDITIONAL_INFO') . ' ' . TXT_LC('USERS');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $detailWidth, $contentHeight);
    }


}

?>
