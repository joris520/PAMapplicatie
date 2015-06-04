<?php

/**
 * Description of EmployeeTargetBatchPageBuilder
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/batch/EmployeeTargetBatchInterfaceBuilder.class.php');

class EmployeeTargetBatchPageBuilder
{
    static function getPageHtml($displayWidth)
    {
        list($safeFormHandler, $contentHtml) = EmployeetargetBatchInterfaceBuilder::getAddHtml($displayWidth);

        // popup
        $title = '';
        $formId = 'batch_add_target';
        $cancelFunction = 'xajax_public_batch_addTarget()';
        $buttonName = TXT_BTN('PERFORM');
        $contentHtml =  ApplicationInterfaceBuilder::getBatchAddHtml(   $formId,
                                                                        $safeFormHandler,
                                                                        $title,
                                                                        $contentHtml,
                                                                        $displayWidth,
                                                                        NULL,
                                                                        ApplicationInterfaceBuilder::SHOW_WARNING,
                                                                        $buttonName,
                                                                        $cancelFunction);
        // nog even een hack
        $targetBatchTitle = TXT_UCW('ADD_COLLECTIVE_TARGET');
        $targetBatchBlock = BaseBlockHtmlInterfaceObject::create($targetBatchTitle, $displayWidth);
        $targetBatchBlock->setContentHtml($contentHtml);
        $contentHtml = $targetBatchBlock->fetchHtml();
        return $contentHtml;
    }

    static function getConfirmationAddHtml($displayWidth, $targetName, $employeeCount)
    {
        $pageHtml = EmployeeTargetBatchInterfaceBuilder::getConfirmationAddHtml($displayWidth, $targetName, $employeeCount);

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockHtmlInterfaceObject::create(   TXT_UCF('ADD_COLLECTIVE_TARGET'),
                                                                        $displayWidth);

        $blockInterfaceObject->setContentHtml($pageHtml);

        return $blockInterfaceObject->fetchHtml();
    }
}

?>
