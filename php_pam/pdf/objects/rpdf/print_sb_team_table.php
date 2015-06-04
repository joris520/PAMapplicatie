<?php
// hbd: nu nog alleen gebruikt door pdf/rpdf/sb_team.php
require_once('pdf/objects/common/printDataTableBase.class.php');


class PdfScoreboardTeamTable extends PdfDataTableBase {

    var $max_scores_on_page;


    function __construct($set_max_scores_on_page = 15) {
        parent::__construct();
        $this->max_scores_on_page = $set_max_scores_on_page;
    }

    function MaxScoresOnPage()
    {
        return $this->max_scores_on_page;
    }

//require_once('fpdf/fpdf.php');
//
//function hex2dec($couleur = "#000000") {
//    $R = substr($couleur, 1, 2);
//    $rouge = hexdec($R);
//    $V = substr($couleur, 3, 2);
//    $vert = hexdec($V);
//    $B = substr($couleur, 5, 2);
//    $bleu = hexdec($B);
//    $tbl_couleur = array();
//    $tbl_couleur['R'] = $rouge;
//    $tbl_couleur['G'] = $vert;
//    $tbl_couleur['B'] = $bleu;
//    return $tbl_couleur;
//}

//class PDF_MC_Table extends FPDF {

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
//
//    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
//        $h = $this->h;
//        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1 * $this->k, ($h - $y1) * $this->k,
//                        $x2 * $this->k, ($h - $y2) * $this->k, $x3 * $this->k, ($h - $y3) * $this->k));
//    }

//    var $widths;
//    var $aligns;
//    var $angle = 0;

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

//    function _endpage() {
//        if ($this->angle != 0) {
//            $this->angle = 0;
//            $this->_out('Q');
//        }
//        parent::_endpage();
//    }

//    function SetWidths($w) {
//        //Set the array of column widths
//        $this->widths = $w;
//    }
//
//    function HR($witdh, $linepos) {
//        $this->SetDrawColor(134, 134, 134);
//        $this->Cell($witdh, 0, '', $linepos, 0, 'C');
//        $this->Ln();
//    }

//    function RotatedText($x, $y, $txt, $angle) {
//        //Text rotated around its origin
//        $this->Rotate($angle, $x, $y);
//        $this->Text($x, $y, $txt);
//        $this->Rotate(0);
//    }

//    function RotatedImage($file, $x, $y, $w, $h, $angle) {
//        //Image rotated around its upper-left corner
//        $this->Rotate($angle, $x, $y);
//        $this->Image($file, $x, $y, $w, $h);
//        $this->Rotate(0);
//    }

//    function SingleRow($isBorder, $isShaded, $data) {
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
