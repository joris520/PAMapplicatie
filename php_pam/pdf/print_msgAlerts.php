<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/print_msgAlerts_table.php');
require_once('modules/common/moduleConsts.inc.php');
require_once('modules/model/service/to_refactor/PdpActionsServiceDeprecated.class.php');

function PrintActionAlerts($pdf, $atowner) {
    $pdf->PageTitle(TXT_UCF('PDP_ACTION_NOTIFICATION_MESSAGE'));
//        $pdf->PageHeaderData($pdf->FillHeader($id_e));

    $pdf->DataHeaderValues(array(55, 41, 38, 50, 45, 32, 17.5),
                           array(TXT_UCF('ACTION'),
                                 TXT_UCF('EMPLOYEE'),
                                 TXT_UCF('ACTION_OWNER'),
                                 TXT_UCF('NOTIFICATION_EMAILS'),
                                 TXT_UCF('NOTIFICATION_DATE'),
                                 TXT_UCF('SENT'),
                                 TXT_UCF('CONFIRMED')));
    $pdf->AddPage('L');

    $array_atowner_score = explode(',', $atowner);
    foreach ($array_atowner_score as $user_id) {
        if (!empty($user_id)) {
//            $a_q = "
//                SELECT
//                    pa.action,
//                    e.employee,
//                    pd.email,
//                    u.user_id,
//                    u.name,
//                    a.alert_date,
//                    a.sent_email,
//                    CASE a.is_done
//                        WHEN '0' THEN 'NO'
//                        WHEN '1' THEN 'YES'
//                    END AS is_done,
//                    CASE a.is_confirmed
//                        WHEN '0' THEN 'NO'
//                        WHEN '1' THEN 'YES'
//                    END AS is_confirmed
//                FROM
//                    employees_pdp_actions epa
//                    LEFT JOIN employees e
//                        ON e.ID_E = epa.ID_E
//                    LEFT JOIN pdp_actions pa
//                        ON pa.ID_PDPA = epa.ID_PDPAID
//                    LEFT JOIN users u
//                        ON u.user_id = epa.ID_PDPTOID
//                    INNER JOIN alerts a
//                        ON a.ID_PDPEA = epa.ID_PDPEA
//                    INNER JOIN person_data pd
//                        ON pd.ID_PD = a.ID_PD
//                WHERE
//                    u.user_id = '" . $user_id . "'
//                    AND a.is_level = 1
//                    AND a.customer_id= " . $customer_id;
//
//            $get_q = PDFUtils::getData($a_q, true);
//            if ($get_q) {
            $actions = PdpActionsServiceDeprecated::getPDPactionNotificationMessageAlerts($user_id);

            foreach ($actions as $a) {

                $pdf->SetWidths(array(55, 41, 38, 50, 45, 32, 17.5));
                $pdf->RowT(
                        '',
                        $shaded,
                        array(
                            $a['action'],
                            $a['employee'],
                            $a['name'],
                            ($a['is_done'] == 1 ? $a['sent_email'] : $a['email']),
                            $a['alert_date'],
                            TXT_UCF($a['is_done_label']),
                            TXT_UCF($a['is_confirmed_label'])
                        ));
                $pdf->Ln(0);
            }
//            }
        }
    }
}


function PrintTaskAlerts($pdf, $atowner) {
    $pdf->PageTitle(TXT_UCF('PDP_TASKS_MESSAGE_ALERTS'));

    $pdf->DataHeaderValues(array(55, 41, 38, 50, 45, 32, 17.5),
                           array(TXT_UCF('TASK'),
                                 TXT_UCF('EMPLOYEE'),
                                 TXT_UCF('TASK_OWNER'),
                                 TXT_UCF('NOTIFICATION_EMAILS'),
                                 TXT_UCF('NOTIFICATION_DATE'),
                                 TXT_UCF('SENT'),
                                 TXT_UCF('CONFIRMED')));
    $pdf->AddPage('L');

    $array_atowner_score = explode(',', $atowner);
    foreach ($array_atowner_score as $user_id) {
        if (!empty($user_id)) {
//            $a_q = "SELECT
//                      ept.task, e.employee, pd.email, pto.ID_PDPTO, pto.name, a.alert_date,
//                      CASE a.is_done
//                            WHEN '0' THEN 'NO'
//                            WHEN '1' THEN 'YES'
//                      END AS is_done,
//                      CASE a.is_confirmed
//                            WHEN '0' THEN 'NO'
//                            WHEN '1' THEN 'YES'
//                      END AS is_confirmed
//                    FROM
//                      employees_pdp_tasks ept
//                      left outer join employees e on e.ID_E = ept.ID_E
//                      left outer join pdp_task_ownership pto on pto.ID_PDPTO = ept.ID_PDPTO
//                      left outer join alerts a on a.ID_PDPET = ept.ID_PDPET
//                      left outer join person_data pd on pd.ID_PD = a.ID_PD
//                    WHERE
//                      pto.ID_PDPTO = '" . $user_id . "'
//                    AND a.is_level = 2
//                AND a.customer_id= " . $customer_id;
//
//            $get_q = PDFUtils::getData($a_q, true);
//            if ($get_q) {

            $action_tasks = PdpActionsServiceDeprecated::getPDPactionTaskNotificationMessageAlerts($user_id);
            foreach ($action_tasks as $a) {
                $pdf->SetWidths(array(55, 41, 38, 50, 45, 32, 17.5));
                $pdf->RowT(
                        '',
                        $shaded,
                        array(
                            $a['task'],
                            $a['employee'],
                            $a['name'],
                            $a['email'],
                            $a['alert_date'],
                            TXT_UCF($a['is_done_label']),
                            TXT_UCF($a['is_confirmed_label'])
                        ));
                $pdf->Ln(0);
            }
//            }
        }
    }

}

$actionOwners = $_SESSION['print_msgAlerts']['actionowners'];
$taskOwners   = $_SESSION['print_msgAlerts']['taskowners'];
$printOption  = $_SESSION['print_msgAlerts']['printoption'];
unset($_SESSION['print_msgAlerts']);

$pdf = new PdfMsgAlertsTable();
$pdf->Open();

switch ($printOption) {
    case PRINT_OPTION_ACTION:
        PrintActionAlerts($pdf, $actionOwners);
        break;

    case PRINT_OPTION_TASK:
        PrintTaskAlerts($pdf, $taskOwners);
        break;

    case PRINT_OPTION_ACTION_AND_TASK:
        PrintActionAlerts($pdf, $actionOwners);
        $pdf->ActivatePrintHeader();
        PrintTaskAlerts($pdf, $taskOwners);
        break;
}

$pdf->Output();
?>