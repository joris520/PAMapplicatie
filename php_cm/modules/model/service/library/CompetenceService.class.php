<?php

/**
 * Description of CompetenceService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/library/CompetenceQueries.class.php');
require_once('modules/model/valueobjects/library/CompetenceValueObject.class.php');

class CompetenceService
{

    static function getValueObjectById($competenceId)
    {
        $query = CompetenceQueries::selectCompetence($competenceId);
        $competenceData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return CompetenceValueObject::createWithData($competenceData);
    }

    static function getValueObjects($functionId)
    {
        $query = CompetenceQueries::selectCompetences($functionId);

        $valueObjects = array();
        while ($competencesData = mysql_fetch_assoc($query)) {
            $valueObject = CompetenceValueObject::createWithData($competencesData);
            $valueObjects[] = $valueObject;
        }

        mysql_free_result($query);

        return $valueObjects;
    }

    static function getCompetenceIds($functionId, $returnAsString = true)
    {
        $query = CompetenceQueries::selectCompetences($functionId);

        $competenceIds = array();
        while ($competencesData = mysql_fetch_assoc($query)) {
            $competenceIds[] = $competencesData[CompetenceQueries::ID_FIELD];
        }

        mysql_free_result($query);

        return $returnAsString ? implode(',',$competenceIds) : $competenceIds;
    }

}

?>
