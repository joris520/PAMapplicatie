<?php

require_once('pdf/objects/common/printEmployeeTableBase.inc.php');


class PdfEmployeeTable extends PdfEmployeeTableBase
{

    const PAGETYPE_NONE         = 0;
    const PAGETYPE_ATTACHMENT   = 1;
    const PAGETYPE_PDPACTION    = 2;
    const PAGETYPE_PDPCOSTS     = 3;
    const PAGETYPE_PROFILE      = 4;
    const PAGETYPE_SCORE        = 5;
    const PAGETYPE_TARGET       = 6;
    const PAGETYPE_ACTIONFORM   = 7;
    const PAGETYPE_THREESIXTY   = 8;
    const PAGETYPE_FINAL_RESULT = 9;


    var $page_type = PdfEmployeeTable::PAGETYPE_NONE;
    var $data_header_employee_costs;

    function EmployeePageType($set_page_type = PdfEmployeeTable::PAGETYPE_NONE)
    {
        $this->page_type = $set_page_type;
    }

    // *******************************************************
    // Specifiek score
    // *******************************************************

    function fillDataHeaderScore($show_360, $show_norm, $show_actions, $show_remarks) {
        $category_width     = 5; //$show_category ? 25 : 2;
        $cluster_width      = 52; //41;
        $competence_width   = 75; //$show_category ? 62 : 85;
        $header_widths      =  array($category_width, $cluster_width, $competence_width, 11, 9, 12, 14);
        $category_label     = '' ;// ($show_category) ? TXT_UCF('CATEGORY') : '';
        $header_labels      =  array(   $category_label,
                                        TXT_UCF('CLUSTER'),
                                        TXT_UCF('COMPETENCE'),
                                        TXT_UCF('EMPL'),
                                        TXT_UCF('MGR'),
                                        TXT_UCF('NEW'),
                                        ModuleUtils::Abbreviate(TXT_UCF(CUSTOMER_MGR_SCORE_LABEL), 5, '.'));

        if ($show_360) {
            $header_widths[] = 14;
            $header_labels[] = TXT_UCF(CUSTOMER_360_SCORE_LABEL);
        }
        if ($show_norm) {
            $header_widths[] = 12;
            $header_labels[] = TXT_UCF('NORM');
        }
        if ($show_actions) {
            $header_widths[] = 13;
            $header_labels[] = TXT_UCF('ACTIONS');
        }
        if ($show_remarks) {
            $header_widths[] = 30;
            $header_labels[] = TXT_UCF('REMARKS');
        }
        $this->DataHeaderValues($header_widths, $header_labels);

    }

    // *******************************************************
    // Specifiek score
    // *******************************************************

    function fillHeaderPdpAction($employee_id, $start_date, $end_date, $show_function = 1)
    {
        $header_data = parent::FillHeader($employee_id, $show_function);

        if(!is_null($start_date) && !is_null($end_date)) {
            $endDateDisplay = DateConverter::display($end_date,'');

            $header_data[] = array( TXT_UCF('DATE_PERIOD') . ': ',
                                    DateConverter::display($start_date) . (!empty($endDateDisplay) ? ' - ' . $endDateDisplay : ''));
        }

        return $header_data;
    }

    // *******************************************************
    // Specifiek costs
    // *******************************************************

    function FillHeaderPdpCosts($employee_id)
    {
        $header_data = array();
        $header_data[]= array(TXT_UCF('PRINT_DATE') . ':', date('d-m-Y', time()));
        return $header_data;
    }

    function DataHeaderEmployeeCosts($set_data_header_employee_costs)
    {
        $this->data_header_employee_costs = $set_data_header_employee_costs;
    }

    function PageDataHeader(Array $width_array,
                            Array $title_array,
                            Array $align_array = NULL) {
        $cell_width = $this->CellWidthForOrientation();

        // hbd: kleine uitzondering voor PDPCosts.
        if ($this->page_type == PdfEmployeeTable::PAGETYPE_PDPCOSTS) {
            foreach((array)$this->data_header_employee_costs as $header_data) {
                $this->Cell($cell_width);
                $this->SetWidths(array(40, 50));
                $this->SingleTitleRow('', '', $header_data);
                $this->Ln(-1);
            }
        }
        if (is_null($align_array)) {
            $align_array = $this->defaultAlignArray($width_array);
        }
        parent::PageDataHeader($width_array, $title_array, $align_array);
    }


    // *
    // *******************************************************
    // print hulpjes
    // *******************************************************

    function HandleDataRow($label, $field_value, $field_width = 60, $label_width = 40)
    {
        $this->SetWidths(array($label_width, $field_width));
        $row_label = (empty($label)) ? '' : $label . ': ';
        $this->Row('', array($row_label, $field_value));
        $this->Ln(1);
    }

    function HandlePeriodRow($label, $field_value)
    {
        $this->SetWidths(array(40, 60, 30, 60));
        $row_label = (empty($label)) ? '' : $label . ': ';
        $this->SingleRow('', '1', array($row_label, $field_value, '', ''));
        $this->Ln(0);
    }

    function HandleObjectiveRow($label, $field_value)
    {
        $this->SetWidths(array(40, 40, 110));
        $row_label = (empty($label)) ? '' : $label . ': ';
        $this->Row('', array('', $row_label, $field_value));
        $this->Ln(0);
    }

    function HandleFinalResultRowWide($label, $scoreValue, $commentValue)
    {
        $this->SetWidths(array(10,  30, 30, 120));
        $row_label = (empty($label)) ? '' : $label . ': ';
        $this->Row('', array('', $row_label, $scoreValue , $commentValue));
        $this->Ln(0);
    }

    function HandleFinalResultRow($label, $value)
    {
        $this->SetWidths(array(5, 30, 155));
        $row_label = (empty($label)) ? '' : $label . ': ';
        $this->Row('', array('', $row_label, $value));
        $this->Ln(0);
    }


} // PdfEmployeeTable

?>