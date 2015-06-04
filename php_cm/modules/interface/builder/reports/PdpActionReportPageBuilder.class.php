<?php

/**
 * Description of PdpActionReportPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/PdpActionReportInterfaceBuilder.class.php');

class PdpActionReportPageBuilder
{

    static function getDashboardPageHtml(   $displayWidth,
                                            $selectorWidth,
                                            $doHilite,
                                            AssessmentCycleValueObject $assessmentCycle,
                                            PdpActionDashboardCollection $dashboardCollection)
    {
        return  PdpActionReportInterfaceBuilder::getDashboardViewHtml(  $displayWidth,
                                                                        $selectorWidth,
                                                                        $doHilite,
                                                                        SelfAssessmentReportInterfaceBuilder::SHOW_TOTALS,
                                                                        $assessmentCycle,
                                                                        $dashboardCollection);
    }

}

?>
