<?php
require_once('pdf/objects/common/printEmployeeTableBase.inc.php');
require_once('pdf/objects/common/pdfConsts.inc.php');


class PdfEmployeeHistoryScoreboardTable extends PdfEmployeeTableBase {

    private $mode;
    var $num_interval = PDF_SCORE_NUM_WIDTH;
    var $width_array;
    var $max_scores_on_page;


    function __construct($set_print_mode, $set_max_scores_on_page = 18, $set_gray_col = 4) {
        parent::__construct();
        $this->mode = $set_print_mode;
        $this->max_scores_on_page = $set_max_scores_on_page;

        // initieren widths array
        $num_interval = $this->num_interval;
        if ($this->mode == PRINTMODE_FUNCTION) {
            $this->gray_col = $set_gray_col;
            $this->width_array = array(20, 40, 50, 13, 13, $num_interval, $num_interval, $num_interval, $num_interval, $num_interval);
        } else {
            $this->width_array = array(20, 40, 50, 26, $num_interval, $num_interval, $num_interval, $num_interval, $num_interval);
        }

        if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
            $this->width_array[] = 100;
        }

        $this->width_array[] = 52.5;
    }

    function FillHeader($employee_id, $function_profile, $history_date = null, $conversation_date = null) {
        $header_data = parent::FillHeader($employee_id, $show_function = 0); // geen hoofd-functieprofiel tonen
        // hbd: header aanvullen
        if ($this->mode == PRINTMODE_FUNCTION) {
            $header_data[] = array('Timeshot ' . TXT_LC('JOB_PROFILE') . ' : ',
                                         $function_profile);
        }
        if ($history_date != null) {
            $header_data[] = array(TXT_UCF('TIMESHOT_DATE') . ' : ',
                                         $history_date);
        }
        if ($conversation_date != null) {
            $header_data[] = array(TXT_UCF('CONVERSATION_DATE') . ' : ',
                                         $conversation_date);
        }
        return $header_data;
    }

    function MaxScoresOnPage()
    {
        return $this->max_scores_on_page;
    }

    function PrintMode()
    {
        return $this->mode;
    }

    function WidthArray()
    {
        return $this->width_array;
    }

    function PrepareDataHeaderValues()
    {
     //   print_r($this->data_header_width_array);
        $num_interval = $this->num_interval;
        if ($this->mode == PRINTMODE_FUNCTION) {
            $data_headers = array(TXT_UCF('CATEGORY'), // 43
                                          TXT_UCF('CLUSTER'),
                                          TXT_UCF('COMPETENCE'),  // 45
                                          ModuleUtils::Abbreviate(TXT_UCF(CUSTOMER_MGR_SCORE_LABEL), 5, '.'),
                                          'Norm',
                                          '1', '2', '3', '4', '5');

            if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
                $data_headers[] = TXT_UCF('REMARKS');
            }

            $this->DataHeaderValues($this->WidthArray(), $data_headers); // 69
        } else {
            $data_headers = array(TXT_UCF('CATEGORY'), // 43
                                          TXT_UCF('CLUSTER'),
                                          TXT_UCF('COMPETENCE'),  // 45
                                          ModuleUtils::Abbreviate(TXT_UCF(CUSTOMER_MGR_SCORE_LABEL), 5, '.'), //'Score',//TXT_UCF('SCORE'), // vertaling past niet....
                                          '1', '2', '3', '4', '5');

            if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
                $data_headers[] = TXT_UCF('REMARKS');
            }

            $this->DataHeaderValues($this->WidthArray(), $data_headers); // 69
        }
    }


//    function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '') {
//        $k = $this->k;
//        $hp = $this->h;
//        if ($style == 'F')
//            $op = 'f';
//        elseif ($style == 'FD' or $style == 'DF')
//            $op = 'B';
//        else
//            $op='S';
//        $MyArc = 4 / 3 * (sqrt(2) - 1);
//        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
//
//        $xc = $x + $w - $r;
//        $yc = $y + $r;
//        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
//        if (strpos($corners, '2') === false)
//            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $y) * $k));
//        else
//            $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
//
//        $xc = $x + $w - $r;
//        $yc = $y + $h - $r;
//        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
//        if (strpos($corners, '3') === false)
//            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
//        else
//            $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
//
//        $xc = $x + $r;
//        $yc = $y + $h - $r;
//        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
//        if (strpos($corners, '4') === false)
//            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - ($y + $h)) * $k));
//        else
//            $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
//
//        $xc = $x + $r;
//        $yc = $y + $r;
//        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
//        if (strpos($corners, '1') === false) {
//            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $y) * $k));
//            $this->_out(sprintf('%.2F %.2F l', ($x + $r) * $k, ($hp - $y) * $k));
//        }
//        else
//            $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
//        $this->_out($op);
//    }

//    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
//        $h = $this->h;
//        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1 * $this->k, ($h - $y1) * $this->k,
//                        $x2 * $this->k, ($h - $y2) * $this->k, $x3 * $this->k, ($h - $y3) * $this->k));
//    }


//    function Rotate($angle, $x=-1, $y=-1) {
//        if ($x == -1)
//            $x = $this->x;
//        if ($y == -1)
//            $y = $this->y;
//        if ($this->angle != 0)
//            $this->_out('Q');
//        $this->angle = $angle;
//        if ($angle != 0) {
//            $angle*=M_PI / 180;
//            $c = cos($angle);
//            $s = sin($angle);
//            $cx = $x * $this->k;
//            $cy = ($this->h - $y) * $this->k;
//            $this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
//        }
//    }
//
//    function _endpage() {
//        if ($this->angle != 0) {
//            $this->angle = 0;
//            $this->_out('Q');
//        }
//        parent::_endpage();
//    }

//    function RotatedText($x, $y, $txt, $angle) {
//        //Text rotated around its origin
//        $this->Rotate($angle, $x, $y);
//        $this->Text($x, $y, $txt);
//        $this->Rotate(0);
//    }
//
//    function RotatedImage($file, $x, $y, $w, $h, $angle) {
//        //Image rotated around its upper-left corner
//        $this->Rotate($angle, $x, $y);
//        $this->Image($file, $x, $y, $w, $h);
//        $this->Rotate(0);
//    }

//    function SingleRowRight($isBorder, $isShaded, $data) {
//        //Calculate the height of the row
//        $nb = 0;
//        for ($i = 0; $i < count($data); $i++)
//            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
//        $h = 5 * $nb;
//        //Issue a page break first if needed
//        $this->CheckPageBreak($h);
//        //Draw the cells of the row
//        for ($i = 0; $i < count($data); $i++) {
//
//            $w = $this->widths[$i];
//            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'R';
//            //Save the current position
//            $x = $this->GetX();
//            $y = $this->GetY();
//            //Draw the border
//            if (!empty($isBorder)) {
//                $this->Rect($x, $y, $w, $h);
//            }
//            //Print the text
//            if ($isShaded == '') {
//                $this->MultiCell($w, 6, $data[$i], 0, $a);
//            } else {
//                $this->SetDrawColor(134, 134, 134);
//                $this->SetFillColor(218, 218, 218);
//                $this->MultiCell($w, 6, $data[$i], 0, $a, true);
//            }
//            //Put the position to the right of the cell
//            $this->SetXY($x + $w, $y);
//        }
//        //Go to the next line
//        $this->Ln($h);
//    }

//    function SingleRow1($isBorder, $isShaded, $data) {
//        //Calculate the height of the row
//        $nb = 0;
//        for ($i = 0; $i < count($data); $i++)
//            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
//        $h = 5 * $nb;
//        //Issue a page break first if needed
//        $this->CheckPageBreak($h);
//        //Draw the cells of the row
//        for ($i = 0; $i < count($data); $i++) {
//
//            if ($i == 3) {
//                $coul = hex2dec('#747474');
//                $this->SetTextColor($coul['R'], $coul['G'], $coul['B']);
//            } else {
//                $coul = hex2dec('#000000');
//                $this->SetTextColor($coul['R'], $coul['G'], $coul['B']);
//            }
//            $w = $this->widths[$i];
//            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
//            //Save the current position
//            $x = $this->GetX();
//            $y = $this->GetY();
//            //Draw the border
//            if (!empty($isBorder)) {
//                $this->Rect($x, $y, $w, $h);
//            }
//            //Print the text
//            if ($isShaded == '') {
//                $this->MultiCell($w, 6, $data[$i], 0, $a);
//            } else {
//                $this->SetDrawColor(134, 134, 134);
//                $this->SetFillColor(218, 218, 218);
//                $this->MultiCell($w, 6, $data[$i], 0, $a, true);
//            }
//            //Put the position to the right of the cell
//            $this->SetXY($x + $w, $y);
//        }
//        //Go to the next line
//        $this->Ln($h);
//    }

//    function NbLines($w, $txt) {
//        //Computes the number of lines a MultiCell of width w will take
//        $cw = &$this->CurrentFont['cw'];
//        if ($w == 0)
//            $w = $this->w - $this->rMargin - $this->x;
//        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
//        $s = str_replace("\r", '', $txt);
//        $nb = strlen($s);
//        if ($nb > 0 and $s[$nb - 1] == "\n")
//            $nb--;
//        $sep = -1;
//        $i = 0;
//        $j = 0;
//        $l = 0;
//        $nl = 1;
//        while ($i < $nb) {
//            $c = $s[$i];
//            if ($c == "\n") {
//                $i++;
//                $sep = -1;
//                $j = $i;
//                $l = 0;
//                $nl++;
//                continue;
//            }
//            if ($c == ' ')
//                $sep = $i;
//            $l+=$cw[$c];
//            if ($l > $wmax) {
//                if ($sep == -1) {
//                    if ($i == $j)
//                        $i++;
//                }
//                else
//                    $i=$sep + 1;
//                $sep = -1;
//                $j = $i;
//                $l = 0;
//                $nl++;
//            }
//            else
//                $i++;
//        }
//        return $nl;
//    }
//
//    function CheckPageBreak($h) {
//        //If the height h would cause an overflow, add a new page immediately
//        if ($this->GetY() + $h > $this->PageBreakTrigger)
//            $this->AddPage($this->CurOrientation);
//    }
//
//    function Footer() {
//        //Position at 1.5 cm from bottom
//        $this->SetY(-15);
//        //Arial italic 8
//        $this->SetFont('Arial', '', 8);
//        //Text color in gray
//        $this->SetTextColor(128);
//        //line
//        $Width = $this->w - $this->lMargin - $this->rMargin;
//        $x = $this->GetX();
//        $y = $this->GetY();
//        $this->Line($x, $y, $x + $Width, $y);
//        $this->SetLineWidth(0.2);
//        $this->Ln(1);
//        //Page number
//        $this->Cell(0, 10, PDF_FOOTER, 0, 0, 'L');
//        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'R');
//    }

//    function TextWithDirection($x, $y, $txt, $direction='R') {
//        $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
//        if ($direction == 'R')
//            $s = sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET', 1, 0, 0, 1, $x * $this->k, ($this->h - $y) * $this->k, $txt);
//        elseif ($direction == 'L')
//            $s = sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET', -1, 0, 0, -1, $x * $this->k, ($this->h - $y) * $this->k, $txt);
//        elseif ($direction == 'U')
//            $s = sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET', 0, 1, -1, 0, $x * $this->k, ($this->h - $y) * $this->k, $txt);
//        elseif ($direction == 'D')
//            $s = sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET', 0, -1, 1, 0, $x * $this->k, ($this->h - $y) * $this->k, $txt);
//        else
//            $s=sprintf('BT %.2f %.2f Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $txt);
//        if ($this->ColorFlag)
//            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
//        $this->_out($s);
//    }
//
//    function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0) {
//        $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
//
//        $font_angle+=90 + $txt_angle;
//        $txt_angle*=M_PI / 180;
//        $font_angle*=M_PI / 180;
//
//        $txt_dx = cos($txt_angle);
//        $txt_dy = sin($txt_angle);
//        $font_dx = cos($font_angle);
//        $font_dy = sin($font_angle);
//
//        $s = sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',
//                        $txt_dx, $txt_dy, $font_dx, $font_dy,
//                        $x * $this->k, ($this->h - $y) * $this->k, $txt);
//        if ($this->ColorFlag)
//            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
//        $this->_out($s);
//    }

}

?>
