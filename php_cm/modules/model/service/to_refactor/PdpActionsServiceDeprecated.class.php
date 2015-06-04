<?php

/**
 * Description of PdpActionsServiceDeprecated
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/to_refactor/PdpActionLibraryQueriesDeprecated.class.php');

class PdpActionsServiceDeprecated {

    static function getPdpActionCluster($pdpActionClusterId)
    {
        return @mysql_fetch_assoc(PdpActionLibraryQueriesDeprecated::getPdpActionCluster($pdpActionClusterId));
    }

    static function getPdpAction($pdpActionId)
    {
         return @mysql_fetch_assoc(PdpActionLibraryQueriesDeprecated::getPdpAction($pdpActionId));
    }

    static function getClusteredPdpActions()
    {
        $pdpActionClustersResult = PdpActionLibraryQueriesDeprecated::getClusteredPdpActions();
        $pdpActionClusters = array();
        while ($pdpActionCluster = @mysql_fetch_assoc($pdpActionClustersResult)) {
            $pdpActionClusters[] = $pdpActionCluster;
        }
        return $pdpActionClusters;
    }

    static function validatePdpActionCluster($cluster_name, $exclude_cluster_id)
    {
        $hasError = false;
        $message = '';

        if (empty($cluster_name)) {
            $message = TXT_UCF('PLEASE_ENTER_A_PDP_CLUSTER');
            $hasError = true;
        } else {
            // controleer bestaand cluster
            $checkExistingResult = PdpActionLibraryQueriesDeprecated::findExistingPdpActionCluster($cluster_name, $exclude_cluster_id);
            if (@mysql_numrows($checkExistingResult) > 0) {
                $message = TXT_UCF('CLUSTER_NAME_ALREADY_EXISTS_PLEASE_ENTER_A_NEW_CLUSTER_NAME');
                $hasError = true;
            }
        }
        return array($hasError, $message);
    }

    static function countPdpActionsByCluster($cluster_id)
    {
        $pdpActionsResult = PdpActionLibraryQueriesDeprecated::getPdpActionsByCluster($cluster_id);
        return @mysql_num_rows($pdpActionsResult);
    }


    static function deleteUnusedPdpActionCluster($cluster_id)
    {
        if (PdpActionsServiceDeprecated::countPdpActionsByCluster($cluster_id) == 0) {
            PdpActionLibraryQueriesDeprecated::deletePdpActionCluster($cluster_id);
        }
    }

    static function getPDPactionNotificationMessageAlerts($i_owner_id = null) {
        $pdpactionalerts_result = PdpActionLibraryQueriesDeprecated::getPDPActionNotifcationMessageAlerts($i_owner_id);

        $pdpactionalerts = array();
        while ($pdpactionalerts_row = @mysql_fetch_assoc($pdpactionalerts_result)) {
            $pdpactionalerts_row['is_done_label'] = $pdpactionalerts_row['is_done'] == 1 ? 'YES' : 'NO';
            $pdpactionalerts_row['is_confirmed_label'] = $pdpactionalerts_row['is_confirmed'] == 1 ? 'YES' : 'NO';

            $pdpactionalerts[] = $pdpactionalerts_row;
        }

        return $pdpactionalerts;
    }

    static function getPDPactionTaskNotificationMessageAlerts($i_owner_id = null) {
        $pdpactiontaskalerts_result = PdpActionLibraryQueriesDeprecated::getPDPActionTaskNotifcationMessageAlerts($i_owner_id);

        $pdpactiontaskalerts = array();
        while ($pdpactiontaskalerts_row = @mysql_fetch_assoc($pdpactiontaskalerts_result)) {
            $pdpactiontaskalerts_row['task'] = ModuleUtils::Abbreviate($pdpactiontaskalerts_row['task'], DEFAULT_OPTION_ABBREVIATE);
            $pdpactiontaskalerts_row['is_done_label'] = $pdpactiontaskalerts_row['is_done'] == 1 ? 'YES' : 'NO';
            $pdpactiontaskalerts_row['is_confirmed_label'] = $pdpactiontaskalerts_row['is_confirmed'] == 1 ? 'YES' : 'NO';

            $pdpactiontaskalerts[] = $pdpactiontaskalerts_row;
        }

        return $pdpactiontaskalerts;
    }

    static function getPDPActionOwners() {
        $pdpactionowners_result = PdpActionLibraryQueriesDeprecated::getPDPActionOwners();

        $pdpactionowners = array();
        while ($pdpactionowners_row = @mysql_fetch_assoc($pdpactionowners_result)) {
            $pdpactionowners[] = $pdpactionowners_row;
        }

        return $pdpactionowners;
    }

    static function getPDPActionTaskOwners() {
        $pdpactiontaskowners_result = PdpActionLibraryQueriesDeprecated::getPDPActionTaskOwners();

        $pdpactiontaskowners = array();
        while ($pdpactiontaskowners_row = @mysql_fetch_assoc($pdpactiontaskowners_result)) {
            $pdpactiontaskowners[] = $pdpactiontaskowners_row;
        }

        return $pdpactiontaskowners;
    }
}

?>
