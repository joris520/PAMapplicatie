<?php
require_once('modules/model/service/to_refactor/ThreesixtyEmailService.class.php');
require_once('modules/interface/components/select/SelectEmployees.class.php');

function moduleOrganisation_selfassessmentReportsForm()
{
    global $smarty;

    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SELF_ASSESSMENTS_REPORT)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_SELFASSESSMENT_REPORTS);

        // beschikbare functies ophalen
        $sql = 'SELECT
                    ID_F,
                    function
                FROM
                    functions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    function';
        $functionQuery = BaseQueries::performQuery($sql);
        $functions = array();
        while ($function = @mysql_fetch_assoc($functionQuery)) {
            $functions[] = array('id_f' => $function['ID_F'],
                                 'name' => $function['function']);
        }

        $tpl = $smarty->createTemplate('to_refactor/mod_organisation/reportSelfassessmentForm.tpl');
        $tpl->assign('functions', $functions);

        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_SELFASSESSMENT_REPORTS));
        $objResponse->assign('module_main_panel', 'innerHTML', $smarty->fetch($tpl));
    }

    return $objResponse;
}

function moduleOrganisation_processSelfassessmentReportsForm($reportSelfassessmentForm)
{
    // de actie uitvoeren...
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SELF_ASSESSMENTS_REPORT)) {

        $selfassessment_function_id = $reportSelfassessmentForm['selfassessment_function_id'];

        if ($selfassessment_function_id > 0 || $selfassessment_function_id == -1) {
            $_SESSION['selfassessment_function_id'] = $selfassessment_function_id;
                // hbd: via de onzichtbare iframe truuk de download starten (bij ajax is dit anders een probleem)
                $get_report_frame = '
                    <iframe id="t' . time() . '" src="report/report_selfassessment.php?time=' . time() . '" width="0" height="0" frameBorder="0" style="display:none;">
                    </iframe>';

                // Het hidden iframe toevoegen
                $objResponse->assign('download_report', 'innerHTML',  $get_report_frame);
        } else {
            $objResponse->alert(TXT_UCF('PLEASE_SELECT_A_JOB_PROFILE'));
        }
        $objResponse->assign("reportsFormBtn", "disabled", false);
    }

    return $objResponse;
}


?>
