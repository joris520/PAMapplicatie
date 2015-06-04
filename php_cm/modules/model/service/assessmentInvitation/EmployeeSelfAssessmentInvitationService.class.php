<?php


/**
 * Description of EmployeeSelfAssessmentInvitationService
 *
 * @author ben.dokter
 */

require_once('modules/model/service/assessmentInvitation/EmployeeAssessmentInvitationService.class.php');
//require_once('modules/model/service/assessmentProcess/AssessmentProcessController.class.php');

require_once('modules/model/valueobjects/assessmentInvitation/EmployeeSelfAssessmentInvitationValueObject.class.php');
require_once('modules/model/valueobjects/batch//EmployeeInvitationResultValueObject.class.php');
require_once('modules/model/queries/assessmentInvitation/EmployeeSelfAssessmentInvitationQueries.class.php');

class EmployeeSelfAssessmentInvitationService
{
    const USE_QUERY_SORTING         = false;
    const USE_EMPLOYEE_ID_AS_KEY    = true;

    const ANY_INVITATION_STATUS     = NULL;

    const CALCULATE_SUM_DIFFS       = true;
    const NO_SUM_DIFFS              = false;

    static function getValueObject( $employeeId,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObject = NULL;

        $query = EmployeeSelfAssessmentInvitationQueries::getInvitationInPeriod($employeeId,
                                                                                $assessmentCycle->getStartDate(),
                                                                                $assessmentCycle->getEndDate());
        $invitationData = mysql_fetch_assoc($query);
        $valueObject = EmployeeSelfAssessmentInvitationValueObject::createWithData($employeeId, $invitationData);

        mysql_free_result($query);

        return $valueObject;

    }

    static function countInvitations(   $selectedEmployeeIds,
                                        AssessmentCycleValueObject $assessmentCycle,
                                        $filterStatus = self::ANY_INVITATION_STATUS)
    {
        $query = EmployeeSelfAssessmentInvitationQueries::countInvitationsInPeriod( $selectedEmployeeIds,
                                                                                    $assessmentCycle->getStartDate(),
                                                                                    $assessmentCycle->getEndDate(),
                                                                                    $filterStatus);
        $countData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return $countData['counted'];
    }

    static function getValueObjects($selectedEmployeeIds,
                                    AssessmentCycleValueObject $assessmentCycle,
                                    $filterStatus = self::ANY_INVITATION_STATUS,
                                    $useEmployeeAsKey = self::USE_QUERY_SORTING,
                                    $calculateSumDiffs = self::NO_SUM_DIFFS)
    {
        $valueObjects = array();

        $query = EmployeeSelfAssessmentInvitationQueries::getInvitationInPeriod($selectedEmployeeIds,
                                                                                $assessmentCycle->getStartDate(),
                                                                                $assessmentCycle->getEndDate(),
                                                                                $filterStatus,
                                                                                $calculateSumDiffs);

        while ($invitationData = mysql_fetch_assoc($query)) {
            $valueObject = EmployeeSelfAssessmentInvitationValueObject::createWithEmployeeData($invitationData);
            if ($useEmployeeAsKey == self::USE_EMPLOYEE_ID_AS_KEY) {
                $valueObjects[$valueObject->getEmployeeId()] = $valueObject;
            } else {
                $valueObjects[] = $valueObject;
            }
        }
        mysql_free_result($query);

        return $valueObjects;
    }

    static function addInvitation($employeeId, $invitationMessageId)
    {
        $hasError = false;

        // ophalen employee gegevens
        $employeePersonalValueObject = EmployeeProfilePersonalService::getValueObject($employeeId);
        $employeeName = $employeePersonalValueObject->getEmployeeName();
        $employeeEmailAddress = $employeePersonalValueObject->getEmailAddress();

        $employeeJobProfileValueObject = EmployeeJobProfileService::getValueObject($employeeId);
        $mainFunction = $employeeJobProfileValueObject->getMainFunction();
        $competenceIds = CompetenceService::getCompetenceIds($mainFunction->getFunctionId());

        $invitationResultValueObject = EmployeeInvitationResultValueObject::create( $employeeId,
                                                                                    $employeeName,
                                                                                    $employeeEmailAddress,
                                                                                    $mainFunction->getFunctionName());
        // controle of verzenden kan
        // 1) geldig e-mail
        // 2) er zijn competenties bij het functieprofiel
        if (!ModuleUtils::IsEmailAddressValidFormat($employeeEmailAddress)) {
            $hasError = true;
            $invitationResultValueObject->setInvitationStatus(InvitationStatusValue::INVALID_EMAIL_ADDRESS);
        } elseif (empty($competenceIds)) {
            $hasError = true;
            $invitationResultValueObject->setInvitationStatus(InvitationStatusValue::NO_COMPETENCES);
        }

        if (!$hasError ) {
            $employeeOrganisationValueObject = EmployeeProfileOrganisationService::getValueObject($employeeId);
            $bossName           = $employeeOrganisationValueObject->getBossEmployeeName();
            $bossEmailAddress   = $employeeOrganisationValueObject->getBossEmailAddress();

            list($fromEmailName, $fromEmailAddress) = EmployeeAssessmentInvitationService::createEmailFrom(CUSTOMER_ID, USER_ID, $bossEmailAddress, $bossName);

            $invitationHashId = EmployeeAssessmentInvitationService::createUnique360Hash();

            // als er toch al uitnodigingen waren deze "deprecaten" zodat er altijd maar 1 laatste te vinden is...
            $deprecatedInvitations = self::deprecateOtherInvitations($employeeId);

            EmployeeSelfAssessmentInvitationQueries::insertInvitation(  $invitationHashId,
                                                                        $employeeId,
                                                                        $employeePersonalValueObject->getPersonDataId(),
                                                                        $mainFunction->getFunctionId(),
                                                                        $invitationMessageId,
                                                                        $fromEmailName,
                                                                        $fromEmailAddress,
                                                                        $competenceIds,
                                                                        AssessmentInvitationCompletedValue::NOT_COMPLETED,
                                                                        AssessmentInvitationStatusValue::CURRENT);

            $invitationResultValueObject->setInvitationHashId($invitationHashId);
            $invitationResultValueObject->setInvitationStatus($deprecatedInvitations > 0 ? InvitationStatusValue::REINVITED : InvitationStatusValue::INVITED);
            $invitationResultValueObject->setEmailFrom($fromEmailName, $fromEmailAddress);


//            $sql = 'UPDATE
//                        employees_topics
//                    SET
//                        assessment_status = ' . AssessmentProcessStatusValue::INVITED . ',
//                        score_status = ' . ScoreStatusValue::PRELIMINARY . '
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_E = ' . $id_e;
//            BaseQueries::performUpdateQuery($sql);
        }
        return $invitationResultValueObject;
    }

    static function deprecateOtherInvitations($employeeId)
    {
        return EmployeeSelfAssessmentInvitationQueries::deprecateInvitations($employeeId);
    }


    static function closeInvitations(   $selectedEmployeeIds,
                                        AssessmentCycleValueObject $assessmentCycle)
    {
        return EmployeeSelfAssessmentInvitationQueries::updateStatusInvitationsInPeriod($selectedEmployeeIds,
                                                                                        AssessmentInvitationStatusValue::CURRENT,
                                                                                        AssessmentInvitationStatusValue::CLOSED,
                                                                                        $assessmentCycle->getStartDate(),
                                                                                        $assessmentCycle->getEndDate());
    }

    static function closeInvitationsByHashId($selectedInvitationHashIds)
    {
        return EmployeeSelfAssessmentInvitationQueries::updateStatusInvitationForHashIds(   $selectedInvitationHashIds,
                                                                                            AssessmentInvitationStatusValue::CURRENT,
                                                                                            AssessmentInvitationStatusValue::CLOSED);
    }
    static function uncloseInvitationsByHashId($selectedInvitationHashIds)
    {
        return EmployeeSelfAssessmentInvitationQueries::updateStatusInvitationForHashIds(   $selectedInvitationHashIds,
                                                                                            AssessmentInvitationStatusValue::CLOSED,
                                                                                            AssessmentInvitationStatusValue::CURRENT);
    }

    static function resendInvitation($employeeId, $resendHashId)
    {
        return EmployeeSelfAssessmentInvitationQueries::markResendInvitation($employeeId, $resendHashId);
    }

    static function updateInvitationReminder(   SelfAssessmentReportInvitationValueObject $notCompletedInvitation,
                                                $invitationMessageId)
    {
        $hasError = false;

        // ophalen employee gegevens
        $employeeId = $notCompletedInvitation->getId();

        // ophalen uitnodigingsgegevens
        $invitationHash = $notCompletedInvitation->getInvitationHash();
        $reminderType = $notCompletedInvitation->hasReminder1() ? InvitationStatusValue::REMINDED_2 : InvitationStatusValue::REMINDED_1;

        $employeePersonalValueObject = EmployeeProfilePersonalService::getValueObject($employeeId);
        $employeeName = $employeePersonalValueObject->getEmployeeName();
        $employeeEmailAddress = $employeePersonalValueObject->getEmailAddress();

        $invitationResult = EmployeeInvitationResultValueObject::create($employeeId,
                                                                        $employeeName,
                                                                        $employeeEmailAddress,
                                                                        null);
        // controle of verzenden kan
        // 1) geldig e-mail
        if (!ModuleUtils::IsEmailAddressValidFormat($employeeEmailAddress)) {
            $hasError = true;
            $invitationResult->setInvitationStatus(InvitationStatusValue::INVALID_EMAIL_ADDRESS);
        }

        if (!$hasError) {
            if ($reminderType == InvitationStatusValue::REMINDED_1) {
                $inserted = EmployeeSelfAssessmentInvitationQueries::insertReminder1(   $invitationHash,
                                                                                        $employeeId,
                                                                                        $invitationMessageId);
            } else {
                $inserted = EmployeeSelfAssessmentInvitationQueries::insertReminder2(   $invitationHash,
                                                                                        $employeeId,
                                                                                        $invitationMessageId);
            }
            $invitationResult->setInvitationStatus($inserted == 1 ? $reminderType : InvitationStatusValue::NOT_REMINDED);

//            $sql = 'UPDATE
//                        employees_topics
//                    SET
//                        assessment_status = ' . AssessmentProcessStatusValue::INVITED . ',
//                        score_status = ' . ScoreStatusValue::PRELIMINARY . '
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_E = ' . $id_e;
//            BaseQueries::performUpdateQuery($sql);
        }
        return $invitationResult;
    }



}

?>
