<?php
require_once('pdf/objects/common/printEmployeeTableBase.inc.php');
require_once('pdf/objects/common/pdfConsts.inc.php');


class PdfEmployeeScoreboardTable extends PdfEmployeeTableBase {

    var $num_interval = PDF_SCORE_NUM_WIDTH;
    var $width_array;
    var $max_scores_on_page;


    function __construct($set_max_scores_on_page = 18, $set_gray_col = 4)
    {
        parent::__construct();
        $this->mode = $set_print_mode;
        $this->max_scores_on_page = $set_max_scores_on_page;
        $this->gray_col = $set_gray_col;

        $num_interval = $this->num_interval;
        $this->width_array = array(30, 35, 50, 13, 13, $num_interval, $num_interval, $num_interval, $num_interval);
        $this->DataHeaderValues($this->width_array,
                                array(TXT_UCF('CATEGORY'),
                                      TXT_UCF('CLUSTER'),
                                      TXT_UCF('COMPETENCE'),
                                      'Score', 'Norm',
                                      '1', '2', '3', '4', '5'));

//        echo 'constructor';
    }

    function WidthArray()
    {
        return $this->width_array;
    }

    function MaxScoresOnPage()
    {
        return $this->max_scores_on_page;
    }

    function FillHeader($employee_id, $function_profile)
    {
        $header_data = parent::FillHeader($employee_id, $show_function = 0); // geen hoofd-functieprofiel tonen
        // hbd: header aanvullen
        $index = count($header_data);
        $header_data[$index++] = array(TXT_UCF('EVALUATION') . ' ' . TXT_LC('JOB_PROFILE') . ' : ',
                                     $function_profile);
        $header_data[$index++] = array(TXT_UCF('DATE') . ' : ',
                                     date('d-m-Y', time()));
        return $header_data;
    }
}

?>
