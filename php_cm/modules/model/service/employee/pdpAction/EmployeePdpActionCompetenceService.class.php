<?php

/**
 * Description of EmployeePdpActionCompetenceService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/employee/pdpAction/EmployeePdpActionCompetenceQueries.class.php');
require_once('modules/model/valueobjects/employee/pdpAction/EmployeePdpActionCompetenceValueObject.class.php');

class EmployeePdpActionCompetenceService
{
    const RETURN_AS_STRING  = TRUE;
    const RETURN_AS_ARRAY   = FALSE;

    static function getRelatedCompetenceValueObjects(   $employeeId,
                                                        $employeePdpActionId)
    {
        $valueObjects = array();

        $query = EmployeePdpActionCompetenceQueries::getRelatedCompetences( $employeeId,
                                                                            $employeePdpActionId);

        while ($employeePdpActionCompetenceData = @mysql_fetch_assoc($query)) {
            $valueObject = EmployeePdpActionCompetenceValueObject::createWithData(  $employeeId,
                                                                                    $employeePdpActionId,
                                                                                    $employeePdpActionCompetenceData);
            $valueObjects[] = $valueObject;
        }

        mysql_free_result($query);

        return $valueObjects;
    }

    static function getCompetenceValueObjects($employeeId)
    {
        $jobProfileValueObject  = EmployeeJobProfileService::getValueObject(    $employeeId);
        $competenceValueObjects = EmployeeCompetenceService::getValueObjects(   $employeeId,
                                                                                $jobProfileValueObject->getMainFunctionId(),
                                                                                EmployeeCompetenceService::FETCH_ALL_CLUSTERS,
                                                                                EmployeeCompetenceService::RETURN_AS_CATEGORY_CLUSTER_ARRAY);
        return $competenceValueObjects;
    }


    static function getRelatedCompetenceNames(  $employeeId,
                                                $employeePdpActionId,
                                                $returnType = self::RETURN_AS_STRING)
    {
        $relatedCompetenceNames = ($returnType == self::RETURN_AS_STRING) ? '' : array();
        if (!empty($employeePdpActionId)) {
            $relatedCompetenceValueObjects = self::getRelatedCompetenceValueObjects(    $employeeId,
                                                                                        $employeePdpActionId);

            $competenceNames = array();
            foreach($relatedCompetenceValueObjects as $relatedCompetenceValueObject) {
                $competenceNames[] = $relatedCompetenceValueObject->getCompetenceName();
            }

            if ($returnType == self::RETURN_AS_STRING) {
                $relatedCompetenceNames = implode(', ', $competenceNames);
            } else {
                $relatedCompetenceNames = $competenceNames;
            }
        }
        return $relatedCompetenceNames;
    }

    static function getRelatedCompetenceIds($employeeId,
                                            $employeePdpActionId,
                                            $returnType = self::RETURN_AS_ARRAY)
    {
        $relatedCompetenceIds = ($returnType == self::RETURN_AS_STRING) ? '' : array();
        if (!empty($employeePdpActionId)) {
            $relatedCompetenceValueObjects = self::getRelatedCompetenceValueObjects($employeeId,
                                                                                    $employeePdpActionId);

            $competenceIds = array();
            foreach($relatedCompetenceValueObjects as $relatedCompetenceValueObject) {
                $competenceIds[] = $relatedCompetenceValueObject->getId();
            }

            if ($returnType == self::RETURN_AS_STRING) {
                $relatedCompetenceIds = implode(', ', $competenceIds);
            } else {
                $relatedCompetenceIds = $competenceIds;
            }
        }
        return $relatedCompetenceIds;
    }



}

?>
