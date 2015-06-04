<?php


/**
 * Description of ApplicationInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/components/InterfaceBuilderComponents.class.php');

class ApplicationInterfaceBuilder {

    const SHOW_WARNING = true;
    const HIDE_WARNING = false;

    const VIEW_WIDTH                    = 900;
    const DASHBOARD_WIDTH               = 960;
    const SIMPLE_VIEW_WIDTH             = 600;
    const DETAIL_WIDTH                  = 600;
    const DIALOG_WIDTH                  = 700; // default breedte dialog

    const REPORT_PANEL_SIMPLE_CONTENT   = 900;
    const MAIN_PANEL_SIMPLE_CONTENT     = 800;

    const HISTORY_WIDTH                 = 900;

    const DIALOG_OVERHEAD_HEIGHT        = 90;  // ruimte voor header en knoppen
    const DIALOG_OVERHEAD_WIDTH         = 40;  // ruimte voor evt scrollbalk
    const DIALOG_PADDING_CORRECTION     = 10;  // class "wizard-content" heeft een totale horizontale padding van 10, dus compenseren ivm centering
    const DIALOG_SCROLLBAR_CORRECTION   = 20;  // scrollbar ruimte
    const DIALOG_WIDTH_CORRECTION       = 30;
    const WARNING_HEIGHT                = 38;  // letop: ook in dialogs.js

    const PRINT_OPTIONS_DIALOG_WIDTH    = 300;
    const PRINT_OPTIONS_DIALOG_HEIGHT   = 300;

    const DEFAULT_ACTIONS_WIDTH         = 100;

    const PDF_PRINT_WINDOW_WIDTH        = 900;
    const PDF_PRINT_WINDOW_HEIGHT       = 800;

    // hack...
    const NO_ICON_LINK_SPACES = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    static function getMainPanelNewHtml($contentHtml,
                                        $mainPanelWidth)
    {
        global $smarty;
        $template = $smarty->createTemplate('panel/mainPanelContentNew.tpl');
        $template->assign('mainPanelWidth', is_numeric($mainPanelWidth) ? $mainPanelWidth . 'px' : $mainPanelWidth );
        $template->assign('panelContent', $contentHtml);
        return $smarty->fetch($template);
    }

    static function getMainPanelHtml($contentHtml, $mainPanelWidth = '100%')
    {
        global $smarty;
        $template = $smarty->createTemplate('panel/mainPanelContent.tpl');
        $template->assign('mainPanelWidth', is_numeric($mainPanelWidth) ? $mainPanelWidth . 'px' : $mainPanelWidth );
        $template->assign('panelContent', $contentHtml);
        return $smarty->fetch($template);
    }

    // TODO: interface objecten gaan gebruiken
    static function getInfoPopupHtml($title, $contentHtml, $contentWidth, $contentPixelHeight)
    {
        $correctedContentWidth = is_numeric($contentWidth) ? $contentWidth + self::DIALOG_SCROLLBAR_CORRECTION : $contentWidth;

        global $smarty;
        $template = $smarty->createTemplate('components/contentInfoForm.tpl');
        $template->assign('formTitle', $title);
        $template->assign('formCloseButtonName', TXT_BTN('BUTTON_CLOSE'));
        $template->assign('contentPixelHeight', $contentPixelHeight);
        $template->assign('contentWidth', is_numeric($correctedContentWidth) ? $correctedContentWidth . 'px' : $correctedContentWidth);
        $template->assign('formContent', $contentHtml);
        // hoogte instellen
        $template->assign('fullsize', $contentPixelHeight == NULL);

        return $smarty->fetch($template);
    }

    static function getMessagePopupHtml($title, $contentHtml, $contentPixelHeight = 150)
    {
        global $smarty;
        $template = $smarty->createTemplate('components/contentInfoForm.tpl');
        $template->assign('formTitle', $title);
        $template->assign('contentPixelHeight', $contentPixelHeight);
        $template->assign('formContent', $contentHtml);
        $template->assign('formCancelFunction', 'closeMessageDialog()');
        $template->assign('formCloseButtonName', TXT_BTN('BUTTON_OK'));
        // hoogte instellen
        $template->assign('fullsize', $contentPixelHeight == NULL);

        return $smarty->fetch($template);
    }

    static function getAddPopupHtml($formId,
                                    $safeFormHandler,
                                    $title,
                                    $contentHtml,
                                    $contentWidth,
                                    $contentPixelHeight,
                                    $showReferenceDateWarning = self::SHOW_WARNING,
                                    $buttonName = NULL,
                                    $cancelFunction = NULL)
    {
        // tijdelijke fallback...
        $contentWidth = empty($contentWidth) ? '100%' : $contentWidth;
        $correctedContentWidth = is_numeric($contentWidth) ? $contentWidth + self::DIALOG_SCROLLBAR_CORRECTION : $contentWidth;

        global $smarty;
        $template = $smarty->createTemplate('components/safeContentForm.tpl');
        // warning stuff
        $template->assign('showReferenceDateWarning', $showReferenceDateWarning);
        // safe form stuff
        $template->assign('safeFormIdentifier', $safeFormHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeFormHandler->getTokenHiddenInputHtml());
        // hoogte instellen
        $template->assign('fullHeight', $contentPixelHeight == NULL);
        // algemene velden
        $template->assign('formId', $formId);
        $template->assign('formTitle', $title);
        $template->assign('contentPixelHeight', $contentPixelHeight);
        $template->assign('contentWidth', is_numeric($correctedContentWidth) ? $correctedContentWidth . 'px' : $correctedContentWidth);
        $template->assign('formContent', $contentHtml);
        $template->assign('formSubmitButtonName', empty($buttonName) ? TXT_BTN('ADD') : $buttonName);
        $template->assign('formSubmitButtonId', PROCESS_BUTTON);
        $template->assign('showCancel', TRUE);
        if (!empty($cancelFunction)) {
            $template->assign('formCancelFunction', $cancelFunction);
        }
        $template->assign('buttonTop', FALSE);
        $template->assign('buttonBottom', TRUE);
        $template->assign('buttonAlign', NULL);

        return $smarty->fetch($template);
    }

    static function getEditPopupHtml(   $formId,
                                        $safeFormHandler,
                                        $title,
                                        $contentHtml,
                                        $contentWidth,
                                        $contentPixelHeight,
                                        $showReferenceDateWarning = self::SHOW_WARNING,
                                        $buttonName = NULL,
                                        $cancelFunction = NULL)
    {
        // tijdelijke fallback...
        $contentWidth = empty($contentWidth) ? '100%' : $contentWidth;
        $correctedContentWidth = is_numeric($contentWidth) ? $contentWidth + self::DIALOG_SCROLLBAR_CORRECTION : $contentWidth;

        global $smarty;
        $template = $smarty->createTemplate('components/safeContentForm.tpl');
        // warning stuff
        $template->assign('showReferenceDateWarning', $showReferenceDateWarning);
        // safe form stuff
        $template->assign('safeFormIdentifier', $safeFormHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeFormHandler->getTokenHiddenInputHtml());
        // hoogte instellen
        $template->assign('fullHeight', $contentPixelHeight == NULL);
        // algemene velden
        $template->assign('formId', $formId);
        $template->assign('formTitle', $title);
        $template->assign('contentPixelHeight', $contentPixelHeight);
        $template->assign('contentWidth', is_numeric($correctedContentWidth) ? $correctedContentWidth . 'px' : $correctedContentWidth);
        $template->assign('formContent', $contentHtml);
        $template->assign('formSubmitButtonName', empty($buttonName) ? TXT_BTN('SAVE') : $buttonName);
        $template->assign('formSubmitButtonId', PROCESS_BUTTON);
        $template->assign('showCancel', TRUE);
        if (!empty($cancelFunction)) {
            $template->assign('formCancelFunction', $cancelFunction);
        }
        $template->assign('buttonTop', FALSE);
        $template->assign('buttonBottom', TRUE);
        $template->assign('buttonAlign', NULL);

        return $smarty->fetch($template);
    }

    static function getPrintOptionPopupHtml(   $formId,
                                               $safeFormHandler,
                                               $title,
                                               $contentHtml,
                                               $contentWidth,
                                               $contentPixelHeight,
                                               $showReferenceDateWarning = self::HIDE_WARNING,
                                               $buttonName = NULL,
                                               $cancelFunction = NULL)
    {
        // tijdelijke fallback...
        $contentWidth = empty($contentWidth) ? '100%' : $contentWidth;
        $correctedContentWidth = is_numeric($contentWidth) ? $contentWidth + self::DIALOG_SCROLLBAR_CORRECTION : $contentWidth;

        global $smarty;
        $template = $smarty->createTemplate('components/safeContentForm.tpl');
        // warning stuff
        $template->assign('showReferenceDateWarning', $showReferenceDateWarning);
        // safe form stuff
        $template->assign('safeFormIdentifier', $safeFormHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeFormHandler->getTokenHiddenInputHtml());
        // hoogte instellen
        $template->assign('fullHeight', $contentPixelHeight == NULL);
        // algemene velden
        $template->assign('formId', $formId);
        $template->assign('formTitle', $title);
        $template->assign('contentPixelHeight', $contentPixelHeight);
        $template->assign('contentWidth', is_numeric($correctedContentWidth) ? $correctedContentWidth . 'px' : $correctedContentWidth);
        $template->assign('formContent', $contentHtml);
        $template->assign('formSubmitButtonName', empty($buttonName) ? TXT_BTN('PRINT') : $buttonName);
        $template->assign('formSubmitButtonId', PROCESS_BUTTON);
        $template->assign('showCancel', TRUE);
        if (!empty($cancelFunction)) {
            $template->assign('formCancelFunction', $cancelFunction);
        }
        $template->assign('buttonTop', FALSE);
        $template->assign('buttonBottom', TRUE);
        $template->assign('buttonAlign', NULL);

        return $smarty->fetch($template);
    }

    static function getRemovePopupHtml( $formId,
                                        $safeFormHandler,
                                        $title,
                                        $contentHtml,
                                        $contentWidth,
                                        $contentPixelHeight,
                                        $showReferenceDateWarning = self::HIDE_WARNING)
    {
        // tijdelijke fallback...
        $contentWidth = empty($contentWidth) ? '100%' : $contentWidth;
        $correctedContentWidth = is_numeric($contentWidth) ? $contentWidth + self::DIALOG_SCROLLBAR_CORRECTION : $contentWidth;

        global $smarty;
        $template = $smarty->createTemplate('components/safeContentForm.tpl');
        // warning stuff
        $template->assign('showReferenceDateWarning', $showReferenceDateWarning);
        // safe form stuff
        $template->assign('safeFormIdentifier', $safeFormHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeFormHandler->getTokenHiddenInputHtml());
        // hoogte instellen
        $template->assign('fullHeight', $contentPixelHeight == NULL);
        // algemene velden
        $template->assign('formId', $formId);
        $template->assign('formTitle', $title);
        $template->assign('contentPixelHeight', $contentPixelHeight);
        $template->assign('contentWidth', is_numeric($correctedContentWidth) ? $correctedContentWidth . 'px' : $correctedContentWidth);
        $template->assign('formContent', $contentHtml);
        $template->assign('formSubmitButtonName', TXT_BTN('DELETE'));
        $template->assign('formSubmitButtonId', PROCESS_BUTTON);
        $template->assign('showCancel', TRUE);
        $template->assign('buttonTop', FALSE);
        $template->assign('buttonBottom', TRUE);
        $template->assign('buttonAlign', NULL);

        return $smarty->fetch($template);
    }

    static function getActionPopupHtml( $formId,
                                        $safeFormHandler,
                                        $title,
                                        $contentHtml,
                                        $contentWidth,
                                        $contentPixelHeight,
                                        $showReferenceDateWarning = self::HIDE_WARNING,
                                        $buttonName = NULL)
    {
        // tijdelijke fallback...
        $contentWidth = empty($contentWidth) ? '100%' : $contentWidth;
        $correctedContentWidth = is_numeric($contentWidth) ? $contentWidth + self::DIALOG_SCROLLBAR_CORRECTION : $contentWidth;

        global $smarty;
        $template = $smarty->createTemplate('components/safeContentForm.tpl');
        // warning stuff
        $template->assign('showReferenceDateWarning', $showReferenceDateWarning);
        // safe form stuff
        $template->assign('safeFormIdentifier', $safeFormHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeFormHandler->getTokenHiddenInputHtml());
        // hoogte instellen
        $template->assign('fullHeight', $contentPixelHeight == NULL);
        // algemene velden
        $template->assign('formId', $formId);
        $template->assign('formTitle', $title);
        $template->assign('contentPixelHeight', $contentPixelHeight);
        $template->assign('contentWidth', is_numeric($correctedContentWidth) ? $correctedContentWidth . 'px' : $correctedContentWidth);
        $template->assign('formContent', $contentHtml);
        $template->assign('formSubmitButtonName', (empty($buttonName) ? TXT_BTN('PERFORM') : $buttonName));
        $template->assign('formSubmitButtonId', PROCESS_BUTTON);
        $template->assign('showCancel', TRUE);
        $template->assign('buttonTop', FALSE);
        $template->assign('buttonBottom', TRUE);
        $template->assign('buttonAlign', NULL);

        return $smarty->fetch($template);
    }

    static function getMessagesHtml($messages)
    {
        global $smarty;
        $template = $smarty->createTemplate('components/messages.tpl');
        $template->assign('messages', $messages);
        return $smarty->fetch($template);
    }

    static function getFilterSafeFormHtml($formId, $safeFilterHandler, $contentHtml)
    {
        global $smarty;
        $template = $smarty->createTemplate('components/safeFilterForm.tpl');
        // safe form stuff
        $template->assign('safeFormIdentifier', $safeFilterHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeFilterHandler->getTokenHiddenInputHtml());
        // algemene velden
        $template->assign('formId', $formId);
        $template->assign('formContent', $contentHtml);

        return $smarty->fetch($template);
    }

    static function getListActionSafeFormHtml($formId, $safeActionHandler, $contentHtml)
    {
        global $smarty;
        $template = $smarty->createTemplate('components/safeActionForm.tpl');
        // safe form stuff
        $template->assign('safeFormIdentifier', $safeActionHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeActionHandler->getTokenHiddenInputHtml());
        // algemene velden
        $template->assign('formId', $formId);
        $template->assign('formContent', $contentHtml);

        return $smarty->fetch($template);
    }

    static function getBatchAddHtml($formId,
                                    $safeFormHandler,
                                    $title,
                                    $contentHtml,
                                    $contentWidth,
                                    $contentPixelHeight,
                                    $showReferenceDateWarning = self::SHOW_WARNING,
                                    $buttonName = NULL,
                                    $cancelFunction = NULL)
    {
        // tijdelijke fallback...
        $contentWidth = empty($contentWidth) ? '100%' : $contentWidth;
        //$correctedContentWidth = is_numeric($contentWidth) ? $contentWidth + self::DIALOG_SCROLLBAR_CORRECTION : $contentWidth;

        global $smarty;
        $template = $smarty->createTemplate('components/safeContentForm.tpl');
        // warning stuff
        $template->assign('showReferenceDateWarning', $showReferenceDateWarning);
        // safe form stuff
        $template->assign('safeFormIdentifier', $safeFormHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeFormHandler->getTokenHiddenInputHtml());
        // hoogte instellen
        $template->assign('fullHeight', $contentPixelHeight == NULL);
        $template->assign('contentWidth', is_numeric($contentWidth) ? $contentWidth . 'px' : $contentWidth);
        // algemene velden
        $template->assign('formId', $formId);
        $template->assign('formTitle', $title);
        $template->assign('contentPixelHeight', $contentPixelHeight);
        $template->assign('formContent', $contentHtml);
        $template->assign('formSubmitButtonName', empty($buttonName) ? TXT_BTN('ADD') : $buttonName);
        $template->assign('formSubmitButtonId', PROCESS_BUTTON);
        $template->assign('showCancel', TRUE);
        if (!empty($cancelFunction)) {
            $template->assign('formCancelFunction', $cancelFunction);
        }
        $template->assign('buttonTop', FALSE);
        $template->assign('buttonBottom', TRUE);
        $template->assign('buttonAlign', NULL);
        $template->assign('inBatch', true);
        return $smarty->fetch($template);
    }
    static function getReportActionHtml($formId,
                                        $safeFormHandler,
                                        $title,
                                        $contentHtml,
                                        $contentWidth,
                                        $contentPixelHeight,
                                        $showReferenceDateWarning = self::SHOW_WARNING,
                                        $buttonName = NULL,
                                        $buttonId = NULL,
                                        $cancelName = NULL,
                                        $cancelFunction = NULL,
                                        $showCancel = TRUE,
                                        $buttonTop = FALSE,
                                        $buttonBottom = TRUE,
                                        $buttonAlign = NULL)
    {
        // tijdelijke fallback...
        $contentWidth = empty($contentWidth) ? '100%' : $contentWidth;
        //$correctedContentWidth = is_numeric($contentWidth) ? $contentWidth + self::DIALOG_SCROLLBAR_CORRECTION : $contentWidth;

        global $smarty;
        $template = $smarty->createTemplate('components/safeContentForm.tpl');
        // warning stuff
        $template->assign('showReferenceDateWarning', $showReferenceDateWarning);
        // safe form stuff
        $template->assign('safeFormIdentifier', $safeFormHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeFormHandler->getTokenHiddenInputHtml());
        // hoogte instellen
        $template->assign('fullHeight', $contentPixelHeight == NULL);
        $template->assign('contentWidth', is_numeric($contentWidth) ? $contentWidth . 'px' : $contentWidth);
        // algemene velden
        $template->assign('formId', $formId);
        $template->assign('formTitle', $title);
        $template->assign('contentPixelHeight', $contentPixelHeight);
        $template->assign('formContent', $contentHtml);
        $template->assign('formSubmitButtonName', empty($buttonName) ? TXT_BTN('ADD') : $buttonName);
        $template->assign('formSubmitButtonId', empty($buttonId) ? PROCESS_BUTTON : $buttonId);
        $template->assign('formCancelButtonName', $cancelName);
        $template->assign('showCancel', $showCancel);
        if (!empty($cancelFunction)) {
            $template->assign('formCancelFunction', $cancelFunction);
        }
        $template->assign('buttonTop', $buttonTop);
        $template->assign('buttonBottom', $buttonBottom);
        $template->assign('buttonAlign', $buttonAlign);
        return $smarty->fetch($template);
    }

    static function getReportResultHtml($formId,
                                        $safeFormHandler,
                                        $title,
                                        $contentHtml,
                                        $contentWidth,
                                        $contentPixelHeight,
                                        $showReferenceDateWarning = self::SHOW_WARNING,
                                        $buttonTop = FALSE,
                                        $buttonBottom = TRUE,
                                        $buttonAlign = NULL)
    {
        // tijdelijke fallback...
        $contentWidth = empty($contentWidth) ? '100%' : $contentWidth;
        //$correctedContentWidth = is_numeric($contentWidth) ? $contentWidth + self::DIALOG_SCROLLBAR_CORRECTION : $contentWidth;

        global $smarty;
        $template = $smarty->createTemplate('components/safePrintContentForm.tpl');
        // warning stuff
        $template->assign('showReferenceDateWarning', $showReferenceDateWarning);
        // safe form stuff
        $template->assign('safeFormIdentifier', $safeFormHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeFormHandler->getTokenHiddenInputHtml());
        // hoogte instellen
        $template->assign('fullHeight', $contentPixelHeight == NULL);
        $template->assign('contentWidth', is_numeric($contentWidth) ? $contentWidth . 'px' : $contentWidth);
        // algemene velden
        $template->assign('formId', $formId);
        $template->assign('formTitle', $title);
        $template->assign('contentPixelHeight', $contentPixelHeight);
        $template->assign('formContent', $contentHtml);
        $template->assign('buttonTop', $buttonTop);
        $template->assign('buttonBottom', $buttonBottom);
        $template->assign('buttonAlign', $buttonAlign);
        return $smarty->fetch($template);
    }

    static function getInlineEditHtml($formId, $safeFormHandler, $contentHtml, $mainPanelWidth = '100%')
    {
        global $smarty;
        $template = $smarty->createTemplate('components/safeInlineForm.tpl');
        $template->assign('safeFormIdentifier', $safeFormHandler->getFormIdentifier());
        $template->assign('safeFormToken', $safeFormHandler->getTokenHiddenInputHtml());
        $template->assign('formId', $formId);
        $template->assign('mainPanelWidth', is_numeric($mainPanelWidth) ? $mainPanelWidth . 'px' : $mainPanelWidth );
        $template->assign('formContent', $contentHtml);
        return $smarty->fetch($template);
    }
}

?>
