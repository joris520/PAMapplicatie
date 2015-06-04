<?php

/**
 * Description of FunctionService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/library/FunctionQueries.class.php');

class FunctionService
{
    static function getFunctionIdValues()
    {
        $functionIdValues = array();

        $query = FunctionQueries::getFunctions();

        while ($functionData = mysql_fetch_assoc($query)) {
            $functionIdValues[] = IdValue::create($functionData[FunctionQueries::ID_FIELD], $functionData['function']);
        }
        mysql_free_result($query);

        return $functionIdValues;
    }

    static function getFunctionIdValue($functionId)
    {
        $functionIdValue = NULL;

        $query = FunctionQueries::getFunctionById($functionId);

        $functionData = mysql_fetch_assoc($query);
        if (!empty($functionData)) {
            $functionIdValue = IdValue::create($functionData[FunctionQueries::ID_FIELD], $functionData['function']);
        }
        mysql_free_result($query);

        return $functionIdValue;
    }

}

?>
