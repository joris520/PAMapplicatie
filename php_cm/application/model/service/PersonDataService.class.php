<?php

/**
 * Description of PersonDataService
 *
 * @author ben.dokter
 */

require_once('application/model/queries/PersonDataQueries.class.php');

class PersonDataService
{
    // Save a personal_data table record
    static function insertPersonalData($customer_id, $email_cluster_id, $firstname, $lastname, $emailAddress)
    {
        // TODO: validate!!!

        return PersonDataQueries::insertPersonData($customer_id, $email_cluster_id, $firstname, $lastname, $emailAddress);
    }

    // Update a personal_data table record

    static function updatePersonalData($persondata_id, $customer_id, $email_cluster_id, $firstname, $lastname, $emailAddress)
    {
        return PersonDataQueries::updatePersonalData($persondata_id, $customer_id, $email_cluster_id, $firstname, $lastname, $emailAddress);
    }

    static function updateForEmployee($employeeId, $firstname, $lastname, $emailAddress)
    {
        return PersonDataQueries::updateForEmployee($employeeId, $firstname, $lastname, $emailAddress);
    }

    static function updateEmailForEmployee($employeeId, $emailAddress)
    {
        return PersonDataQueries::updateEmailForEmployee($employeeId, $emailAddress);
    }


    static function getPersonData($person_data_id)
    {
        return @mysql_fetch_assoc(personDataQueries::getPersonData($person_data_id));
    }

    static function getPersonDataByEmployeeId($employeeId)
    {
        return @mysql_fetch_assoc(personDataQueries::getPersonDataByEmployeeId($employeeId));
    }


}

?>
