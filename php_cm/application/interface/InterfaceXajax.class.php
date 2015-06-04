<?php

/**
 * Description of InterfaceXajax
 *
 * @author ben.dokter
 */

require_once('application/interface/InterfaceConsts.inc.php');

class InterfaceXajax
{
    const FORM_WIDTH_CORRECTION = ApplicationInterfaceBuilder::DIALOG_WIDTH_CORRECTION;

    static function hiliteMasterRow($objResponse, $hilite_element_id)
    {
        $objResponse->call('switchSelectedMaster', MASTER_SCROLL_CONTENT, $hilite_element_id);//$old_hilite_element_id, $hilite_element_id);
    }

    static function removeHiliteMasterRow($objResponse)
    {
        $objResponse->call('removeSelectedMaster', MASTER_SCROLL_CONTENT);
    }

    static function showMessageDialog($objResponse, $messageHtml, $messageType = MESSAGE_ERROR, $messageContentHeight = 60, $messageDiv = DIALOG_MESSAGE, $formDialogDiv = FORM_DIALOG, $formStyle = POPUP_ERROR)
    {
        $objResponse->assign($messageDiv, 'innerHTML', $messageHtml);
        self::addClass($objResponse, $messageDiv, $messageType);
        //die('$formHtml'. $formHtml);
        //$objResponse->call('activateDialogUI', FORM_DIALOG, $formWidth, $formHeight); // helaas, jquery UI schaalt wel in auto in hoogte maar de modal achtergrond niet
        $objResponse->call('showDialogMessage', $messageContentHeight);
    }

    /** deprecated **/
    static function showFormDialog($objResponse, $formHtml, $formWidth, $formHeight, $formDialogDiv = FORM_DIALOG, $formStyle = POPUP_DEFAULT)
    {
        $objResponse->assign($formDialogDiv, 'innerHTML', $formHtml);
        //$objResponse->call('activateDialogUI', FORM_DIALOG, $formWidth, $formHeight); // helaas, jquery UI schaalt wel in auto in hoogte maar de modal achtergrond niet
        $objResponse->call('activateFormDialog',    $formDialogDiv,
                                                    $formWidth,
                                                    $formHeight,
                                                    $formStyle);
    }

    static function showAddDialog($objResponse, $formHtml, $formWidth, $formHeight, $showReferenceDateWarning = ApplicationInterfaceBuilder::SHOW_WARNING, $formDialogDiv = FORM_DIALOG, $formStyle = POPUP_ADD_STYLE)
    {
        $correctedWidth = $formWidth + self::FORM_WIDTH_CORRECTION;
        $objResponse->assign($formDialogDiv, 'innerHTML', $formHtml);
        $objResponse->assign($formDialogDiv, 'style.width', $correctedWidth . 'px');
//        // snelle hack om bij een edit even aan te geven dat de opslag datum anders is
//        if ($showReferenceDateWarning && PamApplication::hasModifiedReferenceDate()) {
//            $formHeight += ApplicationInterfaceBuilder::WARNING_HEIGHT;
//        }
        $objResponse->call('activateFormDialog',    $formDialogDiv,
                                                    $correctedWidth,
                                                    $formHeight + ApplicationInterfaceBuilder::DIALOG_OVERHEAD_HEIGHT,
                                                    $formStyle);
    }

    static function showEditDialog( $objResponse,
                                    $formHtml,
                                    $formWidth,
                                    $formHeight,
                                    $showReferenceDateWarning = ApplicationInterfaceBuilder::SHOW_WARNING,
                                    $formDialogDiv = FORM_DIALOG,
                                    $formStyle = POPUP_EDIT_STYLE)
    {
        $correctedWidth = $formWidth + self::FORM_WIDTH_CORRECTION;
        $objResponse->assign($formDialogDiv, 'innerHTML', $formHtml);
        $objResponse->assign($formDialogDiv, 'style.width', $correctedWidth . 'px');
//        // snelle hack om bij een edit even aan te geven dat de opslag datum anders is
//        if ($showReferenceDateWarning && PamApplication::hasModifiedReferenceDate()) {
//            $formHeight += ApplicationInterfaceBuilder::WARNING_HEIGHT;
//        }
        $objResponse->call('activateFormDialog',    $formDialogDiv,
                                                    $correctedWidth,
                                                    $formHeight + ApplicationInterfaceBuilder::DIALOG_OVERHEAD_HEIGHT,
                                                    $formStyle);
    }

    static function showPrintDialog($objResponse, $formHtml, $formWidth, $formHeight, $formDialogDiv = FORM_DIALOG, $formStyle = POPUP_EDIT)
    {
        $correctedWidth = $formWidth + self::FORM_WIDTH_CORRECTION;
        $objResponse->assign($formDialogDiv, 'innerHTML', $formHtml);
        $objResponse->assign($formDialogDiv, 'style.width', $correctedWidth . 'px');
        $objResponse->call('activateFormDialog',    $formDialogDiv,
                                                    $formWidth + ApplicationInterfaceBuilder::DIALOG_OVERHEAD_WIDTH,
                                                    $formHeight + ApplicationInterfaceBuilder::DIALOG_OVERHEAD_HEIGHT,
                                                    $formStyle);
    }

    static function showRemoveDialog($objResponse, $formHtml, $formWidth, $formHeight, $formDialogDiv = FORM_DIALOG, $formStyle = POPUP_WARNING_STYLE)
    {
        $correctedWidth = $formWidth + self::FORM_WIDTH_CORRECTION;
        $objResponse->assign($formDialogDiv, 'innerHTML', $formHtml);
        $objResponse->assign($formDialogDiv, 'style.width', $correctedWidth . 'px');
        $objResponse->call( 'activateFormDialog',   $formDialogDiv,
                                                    $formWidth + ApplicationInterfaceBuilder::DIALOG_OVERHEAD_WIDTH,
                                                    $formHeight + ApplicationInterfaceBuilder::DIALOG_OVERHEAD_HEIGHT,
                                                    $formStyle);
    }

    static function showActionDialog($objResponse, $formHtml, $formWidth, $formHeight, $formDialogDiv = FORM_DIALOG, $formStyle = POPUP_WARNING_STYLE)
    {
        $correctedWidth = $formWidth + self::FORM_WIDTH_CORRECTION;
        $objResponse->assign($formDialogDiv, 'innerHTML', $formHtml);
        $objResponse->assign($formDialogDiv, 'style.width', $correctedWidth . 'px');
        $objResponse->call( 'activateFormDialog',   $formDialogDiv,
                                                    $formWidth  + ApplicationInterfaceBuilder::DIALOG_OVERHEAD_WIDTH,
                                                    $formHeight + ApplicationInterfaceBuilder::DIALOG_OVERHEAD_HEIGHT,
                                                    $formStyle);
    }

    static function showInfoDialog($objResponse, $formHtml, $formWidth, $formHeight, $formDialogDiv = FORM_DIALOG, $formStyle = POPUP_EDIT)
    {
        //$borderStyle = POPUP_DEFAULT_STYLE;
        $correctedWidth = $formWidth + self::FORM_WIDTH_CORRECTION;

        $objResponse->assign($formDialogDiv, 'innerHTML', $formHtml);
        $objResponse->assign($formDialogDiv, 'style.width', $correctedWidth . 'px');
        $objResponse->call( 'activateFormDialog',   $formDialogDiv,
                                                    $formWidth  + ApplicationInterfaceBuilder::DIALOG_OVERHEAD_WIDTH,
                                                    $formHeight + ApplicationInterfaceBuilder::DIALOG_OVERHEAD_HEIGHT,
                                                    $formStyle);
    }

    static function replaceFormDialog($objResponse, $formHtml)
    {
        $objResponse->assign(FORM_DIALOG, 'innerHTML', $formHtml);
    }

    static function closeFormDialog($objResponse)
    {
        $objResponse->call('closeFormDialog');
    }

    static function hiliteNewElement($objResponse)
    {
        $objResponse->call('hilite_new_element');
    }

    static function alertMessage($objResponse, $message)
    {
        $objResponse->alert($message);
    }

    static function setFocus($objResponse, $field)
    {
        $objResponse->script('xajax.$("' . $field . '").focus();');
    }

    static function openInWindow($objResponse, $performFunction, $window_width, $window_height)
    {
        $objResponse->script('window.open("' . $performFunction . '", "", "resizable=yes,width=' . $window_width . ',height=' . $window_height . '")');

    }
    static function setHtml($objResponse, $element_name, $html)
    {
        $objResponse->assign($element_name, 'innerHTML', $html);
    }

    static function setValue($objResponse, $element_name, $html)
    {
        $objResponse->assign($element_name, 'value', $html);
    }

    static function redirect($objResponse, $url)
    {
        $objResponse->redirect($url);
    }

    static function reloadApplication(  $objResponse,
                                        $parameters = NULL)
    {
        $objResponse->redirect('index.php'. (empty($parameters) ? '' : '?' . $parameters ));
    }

    static function toggleVisibility($objResponse, $element_name)
    {
        $objResponse->call( 'toggleVisilibityById', $element_name);
    }

    static function changePopupBorderColor($objResponse, $color)
    {
        $objResponse->assign('simplemodal-container', 'style.borderColor', $color);
    }

    static function enableButton($objResponse, $button_name)
    {
        $objResponse->assign($button_name, 'disabled', false);
    }

    static function disableButton($objResponse, $button_name)
    {
        $objResponse->assign($button_name, 'disabled', true);
    }

    static function fadeInDetail($objResponse, $fade_element_name)
    {
        $objResponse->call('fadeInDetail', $fade_element_name);
    }

    static function fadeOutDetailAndClearContent($objResponse, $fade_element_name, $content_element_name)
    {
        $objResponse->call('fadeOutDetail', $fade_element_name, $content_element_name);
    }

    static function scrollToSelected($objResponse)
    {
        $objResponse->call('setScroll', $_COOKIE['scrollpos']);
    }

    static function activateEditButtons($objResponse, $activate_element_name)
    {
        $objResponse->call('activateEditButtons', $activate_element_name);

    }
//    static function deactivateEditButtons($objResponse, $deactivate_element_name)
//    {
//        //$objResponse->call('deactivateEditButtons', $deactivate_element_name);
//
//    }

    static function changeOnClickFunction($objResponse, $element_name, $function)
    {
        $objResponse->script('xajax.$("'. $element_name . '").onclick=function(){' . $function . '};');
    }

    static function addClass($objResponse, $element_name, $class_name)
    {
        $objResponse->call('addClassToElement', $element_name, $class_name);
    }

    static function removeClass($objResponse, $element_name, $class_name)
    {
        $objResponse->call('removeClassFromElement', $element_name, $class_name);
    }
}

?>
