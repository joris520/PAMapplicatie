<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/common/printDataTableBase.class.php');
require_once('modules/interface/converter/library/pdpAction/PdpCostConverter.class.php');

$pdf = new PdfDataTableBase();
$pdf->PageTitle(TXT_UCF('PDP_ACTION_LIBRARY')); // 82
$pdf->DataHeaderValues(array(60, 90, 50, 50, 18),
                       array(TXT_UCF('CLUSTER'),
                             TXT_UCF('ACTION'),
                             TXT_UCF('PROVIDER'),
                             TXT_UCF('DURATION'),
                             TXT_UCF('COST'). ' (€)'),
                        array(PrintTableBase::ALIGN_LEFT,
                              PrintTableBase::ALIGN_LEFT,
                              PrintTableBase::ALIGN_LEFT,
                              PrintTableBase::ALIGN_LEFT,
                              PrintTableBase::ALIGN_RIGHT));


$pdf->Open();

$c = $_GET['c'];

$pdf->AddPage($orientation = 'L');

if (!empty($c) && $c == 1) {
    $sql = '
        SELECT
		  pac.ID_PDPAC,
          pac.cluster,
          pa.action,
          pa.provider,
          pa.duration,
          pa.costs
		FROM
		  pdp_actions pa
      	  LEFT OUTER JOIN pdp_action_cluster pac ON pac.ID_PDPAC = pa.ID_PDPAC
		WHERE
			pa.customer_id = ' . CUSTOMER_ID . '
            and pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
		ORDER BY
		  cluster,
          pa.action';
    $result = BaseQueries::performQuery($sql);

    $i = 1;
    while ($result_row = @mysql_fetch_assoc($result)) {
        $oldCluster = $newCluster;
        $newCluster = $result_row['cluster'];
        if ($newCluster <> $oldCluster || $i == 1) {
            $cluster = $result_row['cluster'];
        } else {
            $cluster = '';
        }

        $pdf->SetWidths(array(60, 90, 50, 50, 18));
        $pdf->SetAligns(array(PrintTableBase::ALIGN_LEFT,
                              PrintTableBase::ALIGN_LEFT,
                              PrintTableBase::ALIGN_LEFT,
                              PrintTableBase::ALIGN_LEFT,
                              PrintTableBase::ALIGN_RIGHT));
        $pdf->SingleRow('', '', array(  $cluster,
                                        $result_row['action'],
                                        $result_row['provider'],
                                        $result_row['duration'],
                                        PdpCostConverter::display($result_row['costs'])));
        $pdf->Ln(1);

        $i++;
    }
} elseif (!empty($c) && $c == 2) {

    $array_func_selection = explode("^", $_SESSION['clus']);
    foreach ($array_func_selection as $id_c) {
        if (!empty($id_c)) {
            //BEGIN SESSION FOREACH
            $sql = 'SELECT
                      pac.ID_PDPAC,
                      pac.cluster,
                      pa.action,
                      pa.provider,
                      pa.duration,
                      pa.costs
                    FROM
                      pdp_action_cluster pac
                      join pdp_actions pa on pa.ID_PDPAC = pac.ID_PDPAC
                    WHERE
                      pac.ID_PDPAC = ' . $id_c . '
                      AND pac.customer_id = ' . CUSTOMER_ID . '
                    ORDER BY
                      pa.action';
            $result = BaseQueries::performQuery($sql);

            while ($result_row = @mysql_fetch_assoc($result)) {
                $oldCluster = $newCluster;
                $newCluster = $result_row['cluster'];
                if ($newCluster <> $oldCluster || $i == 1) {
                    $cluster = $result_row['cluster'];
                } else {
                    $cluster = '';
                }

                $pdf->SetWidths(array(60, 90, 50, 50, 50));
                $pdf->SingleRow('', '', array($cluster, $result_row['action'], $result_row['provider'], $result_row['duration'], '€ ' . $result_row['costs']));
                $pdf->Ln(1);
            }

            //END SESSION FOREACH
        }
    }
}

$pdf->Output();
?>