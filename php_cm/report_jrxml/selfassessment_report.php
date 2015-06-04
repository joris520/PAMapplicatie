<?php
require_once('application/application_setup/pam_config.inc.php');
require_once('modules/model/service/to_refactor/OrganisationSelfassessmentReportService.class.php');

// ingelogd??
if (USER == '') {
    header("Location: ".SITE_URL);
}

    $selfassessment_function_id = intval($_SESSION['selfassessment_function_id']);
    unset($_SESSION['selfassessment_function_id']);

    if ($selfassessment_function_id > 0 || $selfassessment_function_id == -1) {
        // resultaat ophalen
        if ($selfassessment_function_id > 0) {
            // functieprofiel naam ophalen
            $sql = 'SELECT
                        function
                    FROM
                        functions
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_F = ' . $selfassessment_function_id . '
                    LIMIT 1';
            $getf_q = BaseQueries::performQuery($sql);

            $getf = @mysql_fetch_assoc($getf_q);
            $selfassessment_function_name = ucwords($getf['function']);
            $result = organisationSelfassessmentReportService::createEvaluationReport($selfassessment_function_id, $selfassessment_function_name);
        } else {
            $selfassessment_function_name = TXT_UCF('ALL_JOB_PROFILES');
            $result = organisationSelfassessmentReportService::createEvaluationReportAllJobProfiles();
        }

        // download voorbereiden
        header("Content-type: application/csv");

        $output_title = date('Y-m-d_Hi_') . preg_replace("/[^A-Za-z0-9]/", "_", TXT_UCW('SELF_ASSESSMENT') . ' ' . $selfassessment_function_name);
        $download_file = $output_title . '.' . csv;
        header('Content-Disposition: attachment; filename="' . $download_file . '"');

        //Enable caching
        // seconds, minutes, hours, days
        //$expires = 0;//60*60*24*14;
        header("Pragma: public");
        header("Cache-Control: maxage=".$expires);
        header('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT+1');

        /* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
        header('Content-Length: ' . strlen( $result ) );
        echo $result;
    }
?>
