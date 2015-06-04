<?php
/**
 * Description of ThreesixtyEmail
 *
 * @author ben.dokter
 */

require_once('application/model/service/EmailService.class.php');
require_once('application/model/queries/UserQueries.class.php');
require_once('application/model/queries/CustomerQueries.class.php');

require_once('modules/model/queries/threesixty/ThreesixtyQueries.class.php');

class ThreesixtyEmailService {

    static function createUnique360Hash()
    {
        $multiply = 1;
        $unique_hash_id = false;
        while (!$unique_hash_id) {
            $hash = md5(time()*$multiply);
            $hashResult = ThreesixtyQueries::getHashFromInvitations($hash);
            if (@mysql_num_rows($hashResult) == 0) {
                $unique_hash_id = true;
            }
            $multiply++;
        }

        return $hash;
    }
    static function getHashFromInvitations($s_hash_id)
    {
        $sql = 'SELECT
                    hash_id
                FROM
                    threesixty_invitations
                WHERE
                    hash_id = "' . mysql_real_escape_string($s_hash_id) . '"';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

}
?>
