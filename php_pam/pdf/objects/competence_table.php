<?php

require_once('pdf/objects/common/printDataTableBase.class.php');


class PdfCompetenceTable extends PdfDataTableBase {

    function DataHeader() {
        $this->PageDataHeader(  array(27, 51, 100, 15),
                                array(  TXT_UCF('CATEGORY'),
                                        TXT_UCF('CLUSTER'),
                                        TXT_UCF('COMPETENCE'),
                                        TXT_UCF('SCALE')));
    }
}

?>
