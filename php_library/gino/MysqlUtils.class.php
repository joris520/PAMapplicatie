<?php

/**
 * Hulpfuncties om met MySQL (query-resultaten) om te gaan, project overstijgend (?)
 */

require_once('BaseQueries.class.php');

class MysqlUtils {

    function getData($sql, $return = true) {
        $query = BaseQueries::performQuery($sql);
        if (@mysql_num_rows($query) != 0) {
            $keys_row = @mysql_fetch_assoc($query);
            $variable = '';
            $keys = array_keys($keys_row);

            for ($i_key = 0; $i_key < count($keys); $i_key++) {
                $variable .= '$data_array[$i][\'' . $keys[$i_key] . '\'] = $row[\'' . $keys[$i_key] . '\'];';
            }
            // terug naar begin en opnieuw lezen...
            mysql_data_seek($query, 0);
            $i = 0;
            while ($row = mysql_fetch_assoc($query)) {
                eval($variable);
                $i++;
            }
            if ($return == true) {
                return $data_array;
            } else {

                echo "<pre>";
                print_r($data_array);
                echo "</pre>";
            }
        }
        return false;
    }

    static function getSqlData($sql, $return = true) {
        $query_result = BaseQueries::performQuery($sql);
        if (@mysql_num_rows($query_result) != 0) {

            $return_array = array();

            while ($query_row = @mysql_fetch_assoc($query_result)) {
                $keys = array_keys($query_row);
                $return_array[$query_row[$keys[0]]] = $query_row[$keys[1]];
            }

            if ($return == true) {
                return $return_array;
            } else {
                echo "<pre>";
                print_r($return_array);
                echo "</pre>";
            }
        }
        return false;
    }

    /**
     * Transforms first column of query result to PHP array (with keys 0, 1, 2, ...)
     */
    static function result2Array(&$result) {
        $return_array = array();
        if (@mysql_num_rows($result) != 0) {
            while ($row = mysql_fetch_assoc($result)) {
                $keys = array_keys($row);
                $return_array[] = $row[$keys[0]];
            }
            mysql_free_result($result);
        }
        return $return_array;
    }

    /**
     * Transforms MySQL result to 2D PHP array
     */
    static function result2Array2D(&$result) {
        $resultArray = array(); // beginnen met lege array
        if (@mysql_num_rows($result) != 0) {
            mysql_data_seek($result, 0);
            $mysqlResultRow = mysql_fetch_assoc($result);
            $keys = array_keys($mysqlResultRow); // eenmalig kolomnamen uitlezen
            mysql_data_seek($result, 0); // weer terug naar eerste resultaat, om hieronder in while ALLE resultaatrijen mee te nemen

            // rij voor rij alle waarden toevoegen aan $resultArray
            while ($mysqlResultRow = mysql_fetch_assoc($result)) {
                $row_arr = array();
                for ($k = 0; $k < count($keys); $k++) {
                    $row_arr[$keys[$k]] = $mysqlResultRow[$keys[$k]];
                }
                array_push($resultArray, $row_arr);
            }

            //mysql_free_result($result);
        }

        return $resultArray;
    }

    /**
     * Transforms MySQL result to indexed 2D PHP array
     *
     * waarde van betreffende resultaatrij in kolom $colName wordt gebruikt als index van resultaat array
     */
    static function result2IndexedArray2D(&$result, $colName) {
        $resultArray = array(); // beginnen met lege array

        if (@mysql_num_rows($result) != 0) {
            $mysqlResultRow = mysql_fetch_assoc($result);
            $keys = array_keys($mysqlResultRow); // eenmalig kolomnamen uitlezen
            mysql_data_seek($result, 0); // weer terug naar eerste resultaat, om hieronder in while ALLE resultaatrijen mee te nemen

            // rij voor rij alle waarden toevoegen aan $resultArray
            while ($mysqlResultRow = mysql_fetch_assoc($result)) {
                $row_arr = array();
                for ($k = 0; $k < count($keys); $k++) {
                    $row_arr[$keys[$k]] = $mysqlResultRow[$keys[$k]];
                }
                $resultArray[$row_arr[$colName]] = $row_arr;
            }

            //mysql_free_result($result);
        }

        return $resultArray;
    }

    /**
     * run the query (expects initiated db-connection)
     * @param <type> $query
     */
    static function runMysqlQuery($sql)
    {
        return BaseQueries::performQuery($sql);
    }

    // Row
    static function getAllData ($sql_result) {
        $result_array = array();
        while ($result_row = @mysql_fetch_assoc($sql_result)) {
            $result_array[] = $result_row;
        }

        return $result_array;
    }
}

?>
