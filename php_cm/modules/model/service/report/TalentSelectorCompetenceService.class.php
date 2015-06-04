<?php

/**
 * Description of CompetenceService
 *
 * @author hans.prins
 */

require_once('modules/model/valueobjects/report/TalentSelectorCompetenceValueObject.class.php');
require_once('modules/model/queries/report/TalentSelectorCompetenceQueries.class.php');

class TalentSelectorCompetenceService
{
    static function getValueObjects()
    {
        // TODO: aan de competenceService zelf vragen
        $valueObjects = array();
        $query = TalentSelectorCompetenceQueries::getCompetences();

        while ($competenceData = @mysql_fetch_assoc($query)) {
            $valueObjects[] = TalentSelectorCompetenceValueObject::createWithData($competenceData);
        }

        mysql_free_result($query);
        return $valueObjects;
    }
}

?>
