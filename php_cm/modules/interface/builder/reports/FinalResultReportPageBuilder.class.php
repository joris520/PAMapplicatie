<?php

/**
 * Description of FinalResultReportPageBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/reports/FinalResultReportInterfaceBuilder.class.php');

class FinalResultReportPageBuilder
{
    static function getDashboardPageHtml(   $displayWidth,
                                            $selectorWidth,
                                            $doHilite,
                                            AssessmentCycleValueObject $assessmentCycle,
                                            FinalResultDashboardCollection $dashboardCollection)
    {
        return  FinalResultReportInterfaceBuilder::getDashboardViewHtml($displayWidth,
                                                                        $selectorWidth,
                                                                        $doHilite,
                                                                        SelfAssessmentReportInterfaceBuilder::SHOW_TOTALS,
                                                                        $assessmentCycle,
                                                                        $dashboardCollection);
    }

}

?>
