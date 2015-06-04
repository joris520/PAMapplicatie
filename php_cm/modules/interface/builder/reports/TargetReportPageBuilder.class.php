<?php

/**
 * Description of TargetReportPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/TargetReportInterfaceBuilder.class.php');

class TargetReportPageBuilder
{

    static function getDashboardPageHtml(   $displayWidth,
                                            $selectorWidth,
                                            $doHilite,
                                            AssessmentCycleValueObject $assessmentCycle,
                                            TargetDashboardCollection $dashboardCollection)
    {
        return  TargetReportInterfaceBuilder::getDashboardViewHtml( $displayWidth,
                                                                    $selectorWidth,
                                                                    $doHilite,
                                                                    SelfAssessmentReportInterfaceBuilder::SHOW_TOTALS,
                                                                    $assessmentCycle,
                                                                    $dashboardCollection);
    }

}

?>
