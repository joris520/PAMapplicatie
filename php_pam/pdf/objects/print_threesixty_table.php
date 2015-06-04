<?php

require_once('pdf/objects/common/printEmployeeTableBase.inc.php');

class Pdf360Table extends PdfEmployeeTableBase {

    function DataHeader() {
        $header_widths = array(54, 35, 85, 20);
        $header_titles = array(TXT_UCF('EVALUATOR'),  // 408
                                    TXT_UCF('DATE_SENT'),    // 409
                                    TXT_UCF('COMPETENCE'), // 45
                                    ModuleUtils::Abbreviate(TXT_UCF(CUSTOMER_360_SCORE_LABEL), 5, '.'),   // 'SCORE'
                                    );
        
        if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
            $header_widths[] = 55;
            $header_titles[] = TXT_UCF('REMARKS');
        }
        
        $this->PageDataHeader($header_widths,
                              $header_titles); 
    }

}

?>