<?php

require_once('pdf/objects/common/printEmployeeTableBase.inc.php');
require_once("pdf/objects/common/pdfConsts.inc.php");


class PdfHistoryPrevTable extends PdfEmployeeTableBase {

    private $mode;
    private $showShaded = '';

    function __construct($print_mode) {
        parent::__construct();
        $this->mode = $print_mode;
    }

    function DataHeader()
    {
        if ($this->mode == PRINTMODE_FUNCTION) {
            $this->PageDataHeader(array(20, 25, 80, 20, 20, 112),
                                  array(TXT_UCF('TIMESHOT_DATE'), // 64
                                        TXT_UCF('CONVERSATION_DATE'), // 64
                                        TXT_UCF('COMPETENCE'), // 45
                                        ModuleUtils::Abbreviate(TXT_UCF(CUSTOMER_MGR_SCORE_LABEL), 5, '.'), // Score
                                        TXT_UCF('NORM'), // Norm // 50
                                        TXT_UCF('REMARKS'))); // 69
        } else {
            $this->PageDataHeader(array(20, 25, 80, 20, 132),
                                  array(TXT_UCF('TIMESHOT_DATE'), // 64
                                        TXT_UCF('CONVERSATION_DATE'), // 64
                                        TXT_UCF('COMPETENCE'), // 45
                                        ModuleUtils::Abbreviate(TXT_UCF(CUSTOMER_MGR_SCORE_LABEL), 5, '.'), // Score
                                        TXT_UCF('REMARKS'))); // 69

        }
    }

    function ToggleShading() {
        $this->showShaded = ($this->showShaded == '') ? '1' : '';
    }

    function HandleHistoryRow($last_row,
                              $date_display, $history_last,
                              $knowledge_skill, $scale,
                              $standard, $remark, $conversation_date) {

        if ($this->mode == PRINTMODE_FUNCTION) {
            $this->SetWidths(array(20, 25, 80, 20, 20, 112));
            $this->SingleRow('', $this->showShaded, array($date_display,
                                                          $conversation_date,
                                                          $knowledge_skill,
                                                          $scale,
                                                          $standard,
                                                          $remark));
        } else {
            $this->SetWidths(array(20, 25, 80, 20, 132));
            $this->SingleRow('', $this->showShaded, array($date_display,
                                                          $conversation_date,
                                                          $knowledge_skill,
                                                          $scale,
                                                          $remark));

        }
        $this->Ln(1);

        if ($last_row) {
            $this->ToggleShading();
        }
    }



}

?>
