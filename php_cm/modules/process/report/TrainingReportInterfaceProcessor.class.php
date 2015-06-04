<?php

class TrainingReportInterfaceProcessor extends BaseReportEmployeeInterfaceProcessor
{
    const DISPLAY_WIDTH = 960;

    // Dashboard
    static function displayDashboardView(   xajaxResponse $objResponse,
                                            $doHilite = false)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_TRAINING)) {

            // hiermee kun je alle leidinggevenden ophalen voor op het dashboard (IdValue Array)
            $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            //$dashboardCollection = TrainingReportService::getDashboardCollection($bossIdValues);

            $pageHtml = 'Hier willen we graag het opleidingen dashboard';

            // deze functie zorgt voor het tonen van de inhoud van de tab
            DashboardTabInterfaceProcessor::displayContent(  $objResponse, self::DISPLAY_WIDTH, $pageHtml);
            // deze functie zorgt voor het selecteren (hiliten) van het juiste menu
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse, MODULE_DASHBOARD_MENU_DASHBOARD_TRAINING);
        }
    }

}
?>
