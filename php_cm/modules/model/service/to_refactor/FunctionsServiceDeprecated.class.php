<?php

require_once('modules/model/queries/to_refactor/FunctionQueriesDeprecated.class.php');

class FunctionsServiceDeprecated
{
    static function getKnowledgeSkillPointData($knowledgeSkillPoint_id)
    {
        $query = FunctionQueriesDeprecated::getKnowledgeSkillPoint($knowledgeSkillPoint_id);
        $knowledgeSkillPoint = @mysql_fetch_assoc($query);

        mysql_free_result($query);
        return $knowledgeSkillPoint;
    }

    static function getKnowledgeSkillData($knowledgeSkill_id)
    {
        $query = FunctionQueriesDeprecated::getKnowledgeSkill($knowledgeSkill_id);
        $knowledgeSkill = @mysql_fetch_assoc($query);

        mysql_free_result($query);
        return $knowledgeSkill;
    }

    static function getKnowledgeSkillClusterData($cluster_id)
    {
        $query = FunctionQueriesDeprecated::getKnowledgeSkillCluster($cluster_id);
        $knowledgeSkillCluster = @mysql_fetch_assoc($query);

        mysql_free_result($query);
        return $knowledgeSkillCluster;
    }

    static function getFunctionsForEmployeeProfile($employee_id)
    {
        $functionsResult = FunctionQueriesDeprecated::getFunctionsForEmployeeProfile($employee_id);
        $functions = array();
        while ($function = @mysql_fetch_assoc($functionsResult)) {
            $functions[] = $function;
        }
        return $functions;
//        return MysqlUtils::result2Array($functionsResult); // functions
    }

    static function getAllFunctionsNotUsedByEmployeeProfile($employee_id)
    {
        $functionsResult = FunctionQueriesDeprecated::getAllFunctionsNotUsedByEmployeeProfile($employee_id);

        $functions = array();
        while ($function = @mysql_fetch_assoc($functionsResult)) {
            $functions[] = $function;
        }
        return $functions;
    }

    static function getFunctionNames($employee_id)
    {
        // hoofdfunctie
        $functionResult = FunctionQueriesDeprecated::getFunctions($employee_id);
        $mainFunction = @mysql_fetch_assoc($functionResult);

        // nevenfuncties
        $additionalFunctions = array();
        $additionalFunctionsResult = FunctionQueriesDeprecated::getAdditionalFunctions($employee_id);
        while ($additionalFunction = @mysql_fetch_assoc($additionalFunctionsResult)) {
            $additionalFunctions[] = $additionalFunction['function'];
        }

        return array($mainFunction['ID_F'], $mainFunction['function'], $additionalFunctions);
    }

    static function getFunction($function_id)
    {
        return @mysql_fetch_assoc(FunctionQueriesDeprecated::getFunction($function_id));
    }

    static function getFunctionName($function_id)
    {
        $function = @mysql_fetch_assoc(FunctionQueriesDeprecated::getFunction($function_id));
        return $function['function'];
    }

    function isFunctionUsedByEmployees ($i_function_id)
    {
        $isFunctionUsed = false;

        $countInfo = @mysql_fetch_assoc(FunctionQueriesDeprecated::getEmployeesConnectedCount($i_function_id));
        $isFunctionUsed = ($countInfo['employee_count'] > 0);
        if (!$isFunctionUsed) {
            $countInfo = @mysql_fetch_assoc(FunctionQueriesDeprecated::getInvitationsConnectedCount($i_function_id));
            $isFunctionUsed = ($countInfo['invitation_count'] > 0);
        }
        return $isFunctionUsed;
    }

}

?>
