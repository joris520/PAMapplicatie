<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmployeeAssessmentInvitationService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/assessmentInvitation/EmployeeAssessmentInvitationQueries.class.php');
require_once('application/library/PamValidators.class.php');

class EmployeeAssessmentInvitationService
{
    static function createUnique360Hash()
    {
        $multiply = 1;
        $unique_hash_id = false;
        while (!$unique_hash_id) {
            $hash = md5(time()*$multiply);
            $hashResult = EmployeeAssessmentInvitationQueries::getHashFromInvitations($hash);
            if (@mysql_num_rows($hashResult) == 0) {
                $unique_hash_id = true;
            }
            $multiply++;
        }

        return $hash;
    }

    static function createEmailFrom($customerId, $userId, $bossEmailAddress, $bossName)
    {
        $emailName = '';
        $emailAddress = '';
        $debugresult = 0;
        if (PamValidators::IsEmailAddressValidFormat($bossEmailAddress)) {
            $emailName      = $bossName;
            $emailAddress   = $bossEmailAddress;
            $debugresult = 1;
        } else {
            $userValueObject = UserService::getUserValueObjectForUserId($userId);
            if (PamValidators::IsEmailAddressValidFormat($userValueObject->getEmailAddress())) {
                $emailName      = $userValueObject->getName();
                $emailAddress   = $userValueObject->getEmailAddress();
                $debugresult = 2;
            } else {
                $companyInfo = CustomerService::getInfoValueObject($customerId);
                $emailName      = $companyInfo->getCompanyName();
                $emailAddress   = $companyInfo->getCompanyEmail();
                $debugresult = 3;
            }
        }
        return array($emailName, $emailAddress, $debugresult);
    }

}

?>
