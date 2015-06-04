<?php

/**
 * Description of AssessmentActionResultInterfaceBuilder
 *
 * @author ben.dokter
 */


class AssessmentActionResultInterfaceBuilder
{

    static function getActionResultHtml($displayWidth,
                                        AssessmentProcessResultValueObject $resultValueObject)
    {
//        die('getActionResultHtml'.print_r($resultValueObject, true));
        $bossId = $resultValueObject->getBossId();
        $action = $resultValueObject->getAction();

        $title = AssesssmentProcessActionStateConverter::display($action);

        $bossName = '';
        if (!empty($bossId)) {
            $bossIdValue = EmployeeSelectService::getBossIdValue($bossId);
            $bossName = $bossIdValue->getValue();
        }
        switch($resultValueObject->getAction()) {
            case AssessmentProcessActionState::MARK_SELFASSESSMENT_DONE:
                $contentHtml = self::generateMarkSelfAssessmentCompleteActionResultHtml($displayWidth, $bossId, $bossName, $resultValueObject);
                break;
            case AssessmentProcessActionState::MARK_SELECT_ASSESSMENT_EVALUATION_DONE:
                $contentHtml = self::generateMarkEvaluationsSelectedActionResultHtml($displayWidth, $bossId, $bossName, $resultValueObject);
                break;
            default:
                $contentHtml = self::generateActionResultHtml($displayWidth, $bossId, $bossName, $action);
        }

        return array($contentHtml, $title);

    }

    private static function generateActionResultHtml(   $displayWidth,
                                                        $bossId,
                                                        $bossName,
                                                        $action)
    {
        $userIsThisBoss = USER_EMPLOYEE_IS_BOSS && $bossId == EMPLOYEE_ID;

        $bossLabel = $userIsThisBoss ? '' : 'ZoCo ' . $bossName;

        $interfaceObject = AssessmentProcessActionResult::create($displayWidth);
        $interfaceObject->setBossLabel( $bossLabel);
        $interfaceObject->setBossLabel( $bossLabel);
        $interfaceObject->setMessage( AssesssmentProcessActionStateConverter::messageResult($action));

        return $interfaceObject->fetchHtml();
    }


    private static function generateMarkSelfAssessmentCompleteActionResultHtml( $displayWidth,
                                                                                $bossId,
                                                                                $bossName,
                                                                                AssessmentProcessResultValueObject $resultValueObject)
    {
        $confirmHtml = '';

        if (!empty($bossId)) {
            $userIsThisBoss = USER_EMPLOYEE_IS_BOSS && $bossId == EMPLOYEE_ID;

            $bossLabel = $userIsThisBoss ? '' : 'ZoCo ' . $bossName;

            $canLabel = $userIsThisBoss ? 'U kunt ' : 'De ZoCo kan ';
            $youLabel =  $userIsThisBoss ? 'u' : 'de ZoCo' ;

            $interfaceObject = AssessmentProcessActionCloseInvitationsResult::create($displayWidth);
            $interfaceObject->setBossLabel( $bossLabel);
            $interfaceObject->setCanLabel(  $canLabel);
            $interfaceObject->setYouLabel(  $youLabel);

            $confirmHtml = $interfaceObject->fetchHtml();
        }
        return $confirmHtml;
    }

    private static function generateMarkEvaluationsSelectedActionResultHtml($displayWidth,
                                                                            $bossId,
                                                                            $bossName,
                                                                            AssessmentProcessResultValueObject $resultValueObject)
    {
        $confirmHtml = '';

        if (!empty($bossId)) {
            $userIsThisBoss = USER_EMPLOYEE_IS_BOSS && $bossId == EMPLOYEE_ID;

            $bossLabel = $userIsThisBoss ? '' : 'ZoCo ' . $bossName;

            $interfaceObject = AssessmentProcessActionEvaluationsSelectedResult::create($displayWidth);
            $interfaceObject->setBossLabel( $bossLabel);
            $interfaceObject->setEvaluationCount($resultValueObject->getInvitationCount());

            $confirmHtml = $interfaceObject->fetchHtml();
        }
        return $confirmHtml;
    }


}

?>
