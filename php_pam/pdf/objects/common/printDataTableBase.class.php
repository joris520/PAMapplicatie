<?php

require_once('pdf/objects/common/printTableBase.inc.php');

class PdfDataTableBase extends PrintTableBase {

    function __construct()
    {
        parent::__construct();

        $this->PageHeaderData(array(array(TXT_UCF('DATE') . ':', date('d-m-Y', time()))));
    }

    function PageHeaderEnd() {
        parent::PageHeaderEnd();
        $this->Ln(13);
    }

}
?>
