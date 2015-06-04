<?php

require_once('modules/common/moduleConsts.inc.php');
require_once('application/interface/InterfaceBuilder.class.php');
require_once('modules/model/queries/to_refactor/CompetenceQueriesDeprecated.class.php');

class CompetencesServiceDeprecated {

    static function getCategories()
    {
        $categories = array();
        $categoryResult = CompetenceQueriesDeprecated::getCategories();
        while ($category = @mysql_fetch_assoc($categoryResult)) {
            $categories[] = $category;
        }
        return $categories;
    }

    static function getCategory($i_category_id)
    {
        $categories = array();
        $categoryResult = CompetenceQueriesDeprecated::getCategories($i_category_id);
        while ($category = @mysql_fetch_assoc($categoryResult)) {
            $categories[] = $category;
        }
        return $categories[0];
    }


    static function getClustersByCategory($i_category_id)
    {
        $clusters = array();
        $clusterResult = CompetenceQueriesDeprecated::getClustersByCategory($i_category_id);
        while ($cluster = @mysql_fetch_assoc($clusterResult)) {
            $clusters[] = $cluster;
        }
        return $clusters;
    }

    static function getCompetencesByCluster($i_category_id, $i_cluster_id)
    {
        $competences = array();
//        if (empty($i_cluster_id)) {
//            $i_cluster_id = 0;
//        }
        $competenceResult = CompetenceQueriesDeprecated::getCompetencesByCluster($i_category_id, $i_cluster_id);
        $previous_cluster = '';
        $cluster_has_main = false;
        while ($competence = @mysql_fetch_assoc($competenceResult)) {
            $cluster_name = empty($competence['cluster']) ? EMPTY_CLUSTER_LABEL : $competence['cluster'];
            if ($cluster_name != $previous_cluster) {
                $cluster_has_main = ($competence['is_cluster_main'] == COMPETENCE_CLUSTER_IS_MAIN);
            }
            $competence['cluster'] = $cluster_name;
            $competence['cluster_has_main'] = $cluster_has_main;
            $competences[] = $competence;

            $previous_cluster = $cluster_name;
        }
        return $competences;
    }

    static function getAllCompetences()
    {
        $competences = array();
        $competenceResult = CompetenceQueries::getAllCompetences();
        while ($competence = @mysql_fetch_assoc($competenceResult)) {
            $competences[] = $competence;
        }
        return $competences;

    }
    static function getClusterDetails($cluster_id)
    {
        $clusterDetailsResult = CompetenceQueriesDeprecated::getClusterDetails($cluster_id);
        return @mysql_fetch_assoc($clusterDetailsResult);
    }


    static function getCompetencesByCategory($category_id)
    {
        $competences = array();
        $competenceResult = CompetenceQueriesDeprecated::getCompetencesByCategory($category_id);
        while ($competence = @mysql_fetch_assoc($competenceResult)) {
            $competences[] = $competence;
        }
        return $competences;

    }

    static function getCompetencesByIds($compentenceIds)
    {
        $competences = array();
        if (count($compentenceIds) > 0) {
            $competenceResult = CompetenceQueriesDeprecated::getCompetencesByIds($compentenceIds);
            while ($competence = @mysql_fetch_assoc($competenceResult)) {
                $competence['skill_name'] = $competence['knowledge_skill_point']; // TODO: snelle hack vervangen
                $competences[] = $competence;
            }
        }
        return $competences;

    }

    static function checkValidCluster($cluster_name, $exclude_cluster_id = null)
    {
        $hasError = false;
        $message = '';

        if (empty($cluster_name)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_CLUSTER');
        } else {
            $check_cluster_qry = CompetenceQueriesDeprecated::findClusterByName($cluster_name, $exclude_cluster_id);
            if (@mysql_num_rows($check_cluster_qry) > 0) {
                $hasError = true;
                $message = TXT_UCF('CLUSTER_NAME_ALREADY_EXISTS_PLEASE_ENTER_A_NEW_CLUSTER_NAME');
            }
        }

        return array($hasError, $message);
    }

    static function checkValidCompetence($cluster_id,
                                         $exclude_competence_id, // add: null edit: competence_id
                                         $competence_name,
                                         $description,
                                         $scale,
                                         $norm1,
                                         $norm2,
                                         $norm3,
                                         $norm4,
                                         $norm5)
    {
        $hasError = false;
        $message = '';

        if (empty($competence_name)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_COMPETENCE');
        } elseif (empty($description)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_DESCRIPTION');
        } elseif (empty($cluster_id)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_A_CLUSTER');
        } elseif ($scale == '0') {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_A_SCALE');
        } elseif (($scale == ScaleValue::SCALE_Y_N) &&
                  (!empty($norm1) ||
                   !empty($norm2) ||
                   !empty($norm3) ||
                   !empty($norm4) ||
                   !empty($norm5))) {
            $hasError = true;
            $message = TXT_UCF('SCALE_INVALID_WHEN_YOU_SELECT_A_SCALE_Y_N_PLEASE_EMPTY_ALL_FIELDS_1_2_3_4_5');
        } else {
            $check_cluster_qry = CompetenceQueriesDeprecated::findCompetenceByName($competence_name, $exclude_competence_id);
            if (@mysql_num_rows($check_cluster_qry) > 0) {
                $hasError = true;
                $message = TXT_UCF('COMPETENCE_NAME_ALREADY_EXISTS_PLEASE_ENTER_A_NEW_COMPETENCE_NAME');
            }
        }

        return array($hasError, $message);
    }

    static function validateAndAddClusterToCategory($i_category_id, $s_cluster_name)
    {
        $new_cluster_id = null;
        list($hasError, $message) = CompetencesServiceDeprecated::checkValidCluster($s_cluster_name);
        if (!$hasError) {
            $new_cluster_id = CompetenceQueriesDeprecated::addClusterToCategory($i_category_id, $s_cluster_name);
        }
        return array($hasError, $message, $new_cluster_id);
    }

    static function validateAndUpdateClusterInCategory($i_category_id,
                                                       $i_cluster_id,
                                                       $s_cluster_name,
                                                       $i_main_competence_id)
    {
        list($hasError, $message) = CompetencesServiceDeprecated::checkValidCluster($s_cluster_name, $i_cluster_id);

        if (!$hasError) {
            CompetenceQueriesDeprecated::updateClusterInCategory($i_category_id, $i_cluster_id, $s_cluster_name);

            // De category van het cluster kan aangepast zijn, dan ook de category in de competenties updaten
            CompetenceQueriesDeprecated::updateCategoryInClusteredCompetence($i_category_id, $i_cluster_id);

            // main competence omhangen...
            CompetenceQueriesDeprecated::resetClusterMainCompetence($i_cluster_id);
            if (!empty($i_main_competence_id)) {
                CompetenceQueriesDeprecated::setClusterMainCompetence($i_cluster_id, $i_main_competence_id);
            }
        }
        return array($hasError, $message);
    }

    static function validateAndAddCompetenceToCluster($i_category_id,
                                                      $i_cluster_id,
                                                      $s_competence_name,
                                                      $s_description,
                                                      $i_scale,
                                                      $s_norm1,
                                                      $s_norm2,
                                                      $s_norm3,
                                                      $s_norm4,
                                                      $s_norm5,
                                                      $i_is_na_allowed,
                                                      $i_is_key)
    {
        $new_competence_id = null;
        list($hasError, $message) = CompetencesServiceDeprecated::checkValidCompetence($i_cluster_id,
                                                                    null, // $competence_id == null->new
                                                                    $s_competence_name,
                                                                    $s_description,
                                                                    $i_scale,
                                                                    $s_norm1,
                                                                    $s_norm2,
                                                                    $s_norm3,
                                                                    $s_norm4,
                                                                    $s_norm5);
        if (!$hasError) {

            $new_competence_id = CompetenceQueriesDeprecated::addCompetenceToCluster($i_category_id,
                                                                           $i_cluster_id,
                                                                           $s_competence_name,
                                                                           $s_description,
                                                                           $i_scale,
                                                                           $s_norm1,
                                                                           $s_norm2,
                                                                           $s_norm3,
                                                                           $s_norm4,
                                                                           $s_norm5,
                                                                           $i_is_na_allowed,
                                                                           $i_is_key);
        }
        return array($hasError, $message, $new_competence_id);
    }

    static function validateAndUpdateCompetenceInCluster($i_category_id,
                                                         $i_cluster_id,
                                                         $i_competence_id,
                                                         $s_competence_name,
                                                         $s_description,
                                                         $i_scale,
                                                         $s_norm1,
                                                         $s_norm2,
                                                         $s_norm3,
                                                         $s_norm4,
                                                         $s_norm5,
                                                         $i_is_na_allowed,
                                                         $i_is_key)
    {
        list($hasError, $message) = CompetencesServiceDeprecated::checkValidCompetence($i_cluster_id,
                                                                    $i_competence_id, // competence die we aan het editen zijn
                                                                    $s_competence_name,
                                                                    $s_description,
                                                                    $i_scale,
                                                                    $s_norm1,
                                                                    $s_norm2,
                                                                    $s_norm3,
                                                                    $s_norm4,
                                                                    $s_norm5);

        if (!$hasError) {
            CompetenceQueriesDeprecated::updateCompetenceInCluster($i_category_id,
                                                         $i_cluster_id,
                                                         $i_competence_id,
                                                         $s_competence_name,
                                                         $s_description,
                                                         $i_scale,
                                                         $s_norm1,
                                                         $s_norm2,
                                                         $s_norm3,
                                                         $s_norm4,
                                                         $s_norm5,
                                                         $i_is_na_allowed,
                                                         $i_is_key);
        }
        return array($hasError, $message);
    }

    static function deleteFullCompetence($i_competence_id)
    {
        CompetenceQueriesDeprecated::deleteCompetenceEmployeeScores($i_competence_id);
        CompetenceQueriesDeprecated::deleteCompetenceFunctions($i_competence_id);
        return CompetenceQueriesDeprecated::deleteCompetence($i_competence_id);
    }

    static function deleteUnusedCluster($i_cluster_id)
    {
        return CompetenceQueriesDeprecated::deleteUnusedClustermpetence($i_cluster_id);
    }

    static function getLastModifiedCompetenceInClusterInfo($i_category_id, $i_cluster_id)
    {
        $competenceLastModifiedResult = CompetenceQueriesDeprecated::getLastModifiedCompetenceInClusterInfo($i_category_id, $i_cluster_id);
        return @mysql_fetch_assoc($competenceLastModifiedResult);
    }

    static function getCompetenceDetails($i_competence_id)
    {
        $competenceDetailsResult = CompetenceQueriesDeprecated::getCompetenceDetails($i_competence_id);
        return @mysql_fetch_assoc($competenceDetailsResult);
    }

    static function getCompetenceUsageCount($i_competence_id)
    {
        $competenceUsageResult = CompetenceQueriesDeprecated::getCompetenceUsage($i_competence_id);
        $usageCount = @mysql_fetch_assoc($competenceUsageResult);
        return $usageCount['used_in_functions_count'];

    }

    static function getClusterUsageCount($i_category_id, $i_cluster_id)
    {
        $clusterUsageResult = CompetenceQueriesDeprecated::getClusterUsageCount($i_category_id, $i_cluster_id);
        $usageCount = @mysql_fetch_assoc($clusterUsageResult);
        return $usageCount['used_in_competences_count'];

    }


}
?>