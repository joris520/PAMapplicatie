<?php

require_once('pdf/objects/common/printDataTableBase.class.php');

class PdfDictionaryTable extends PdfDataTableBase {

    private $print_toc = 0;

    function ActivatePrintTOCHeader($print_toc_header_value = 1) {
        $this->print_toc= $print_toc_header_value;
    }

    function DataHeader()
    {
        if ($this->print_toc == 1) {
            $last_col_val = TXT_UCF('PAGE');
        } else {
            $last_col_val = TXT_UCF('SCALE');
        }
        $this->PageDataHeader(array(27, 51, 100, 15),
                              array(TXT_UCF('CATEGORY'),
                                    TXT_UCF('CLUSTER'),
                                    TXT_UCF('COMPETENCE'),
                                    $last_col_val));
    }

    function PageHeaderEnd()
    {
        parent::PageHeaderEnd();
        if ($this->print_toc == 1) {
            $this->SetFont($this->font_family, 'B', $this->title_font_size);
            $this->Cell(0, 5, TXT_UCF('TABLE_OF_CONTENTS'), '', 0, 'C'); // 499
            $this->Ln(9);
        }
        $this->SetFont($this->font_family, '', $this->page_font_size);

    }

    function HandleNorm($indexLabel, $valueLabel) {
        if ($this->GetY() >= '240.00125') {
            $this->AddPage();
        }
        $this->SetWidths(array(78.5, 10, 105));
        $this->Row('0', array('', $indexLabel, $valueLabel));
    }
}

?>
