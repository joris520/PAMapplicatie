<?php

require_once('pdf/objects/common/printTableBase.inc.php');


class PdfCustTable extends PrintTableBase {

    private $company_name = '';
    private $data_header_width_array;
    private $data_header_title_array;

    function __construct($customer_id)
    {
        parent::__construct();

        $sql = 'SELECT
                    company_name
                FROM
                    customers
                WHERE
                    customer_id = ' . $customer_id;

        $customer_result = BaseQueries::performQuery($sql);
        $customer_row = @mysql_fetch_assoc($customer_result);
        $this->company_name = $customer_row['company_name'];

        $this->PageHeaderData(array(array('Date:',    date('d-m-Y', time())),
                                    array('Company:', $this->company_name)));

    }

    function PageDataHeaderValues(  $set_width_array,
                                    $set_title_array) {
        $this->data_header_width_array = $set_width_array;
        $this->data_header_title_array = $set_title_array;
    }

    function DataHeader()
    {
        $this->ln(5);
        $this->SetFont('Arial', 'B', 7);
        $this->SetWidths($this->data_header_width_array);
        $this->SingleRow('1', '', $this->data_header_title_array);
        $this->SetFont('Arial', '', 7);
    }

    function Footer() {
        //if ($this->print_footer == 1) { // hbd: mogelijkheid om footer weg te laten
            $this->page_count++;
            //Position at 1.5 cm from bottom
            $this->SetY(-15);
            //Arial italic 8
            $this->SetFont($this->font_family, '', $this->footer_fontsize);
            //Text color in gray
            $this->SetTextColorHex(COLOR_GRAY);
//            $this->SetTextColor(128);
            //line
            $Width = $this->w - $this->lMargin - $this->rMargin;
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Line($x, $y, $x + $Width, $y);
            $this->SetLineWidth(0.2);
            $this->Ln(1);
            //Page number
            $this->Cell(0, 10, PDF_FOOTER, 0, 0, 'L');
            $this->Cell(0, 10, 'Page' . ' ' . $this->page_count, 0, 0, 'R');
       // }
    }
}

?>
