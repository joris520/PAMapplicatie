<?php

/**
 * Description of QuestionInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/model/service/library/QuestionService.class.php');
require_once('modules/interface/interfaceobjects/library/QuestionView.class.php');
require_once('modules/interface/interfaceobjects/library/QuestionEdit.class.php');
require_once('modules/interface/interfaceobjects/library/QuestionDelete.class.php');
require_once('modules/interface/interfaceobjects/library/QuestionGroup.class.php');
require_once('modules/interface/builder/library/QuestionInterfaceBuilderComponents.class.php');

class QuestionInterfaceBuilder
{

    static function getViewHtml($displayWidth,
                                $hiliteId = NULL,
                                $activeQuestionsOnly = true)
    {
        $valueObjects = QuestionService::getValueObjects($activeQuestionsOnly);

        $groupInterfaceObject = QuestionGroup::create($displayWidth);

        foreach($valueObjects as $valueObject) {
            $questionId = $valueObject->getId();
            $interfaceObject = QuestionView::createWithValueObject($valueObject, $displayWidth);
            $interfaceObject->setHiliteRow(     $questionId == $hiliteId);
            $interfaceObject->setEditLink(      QuestionInterfaceBuilderComponents::getEditLink($questionId));
            $interfaceObject->setRemoveLink(    QuestionInterfaceBuilderComponents::getRemoveLink($questionId));

            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                    TXT_UCF('MANAGE_ASSESSMENT_QUESTIONS'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   QuestionInterfaceBuilderComponents::getAddLink());

        return $blockInterfaceObject->fetchHtml();
    }


    static function getAddHtml($displayWidth)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ASSESSMENT_LIBRARY__ADD_QUESTION);

        $safeFormHandler->addIntegerInputFormatType('sort_order');
        $safeFormHandler->addStringInputFormatType('question');
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject = QuestionValueObject::createWithData(NULL);
        $interfaceObject = QuestionEdit::createWithValueObject($valueObject, $displayWidth);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }


    static function getEditHtml($displayWidth, $questionId)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ASSESSMENT_LIBRARY__EDIT_QUESTION);

        $safeFormHandler->storeSafeValue('questionId', $questionId);
        $safeFormHandler->addIntegerInputFormatType('sort_order');
        $safeFormHandler->addStringInputFormatType('question');
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject = QuestionService::getValueObjectById($questionId);
        $interfaceObject = QuestionEdit::createWithValueObject($valueObject, $displayWidth);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getRemoveHtml($displayWidth, $questionId)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ASSESSMENT_LIBRARY__DELETE_QUESTION);

        $safeFormHandler->storeSafeValue('questionId', $questionId);
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject = QuestionService::getValueObjectById($questionId);

        $interfaceObject = QuestionDelete::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_QUESTION'));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

}

?>
