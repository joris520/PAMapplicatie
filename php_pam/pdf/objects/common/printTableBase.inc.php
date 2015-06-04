<?php

require_once('fpdf/fpdf.php');
require_once('pdf/objects/common/pdfConsts.inc.php');
require_once('pdf/objects/common/pdfUtils.inc.php');

/**
 * hbd: Basisklasse waar alle common print functionaliteit in zit
 */
class PrintTableBase extends FPDF
{
    const ALIGN_LEFT    = 'L';
    const ALIGN_CENTER  = 'C';
    const ALIGN_RIGHT   = 'R';

    const PAGE_PORTRAIT    = 'P';
    const PAGE_LANDSCAPE   = 'L';

    var $widths;
    var $aligns;
    var $angle = 0;

    // hbd: print_header en page_title generiek
    private $page_header_data_array;
    private $data_header_width_array;
    private $data_header_align_array;
    private $data_header_title_array;

    private $page_count = 0;
    private $reset_page_count = false;
    private $print_header = 1;
    private $print_header_on_new_page = 1;
    private $print_data_header = 1;
    private $print_footer = 1;
    private $page_title = 'TITLE';

    protected $gray_col = '-';
    // font
    var $font_family = 'Arial';
    protected $header_fontsize = 9;
    var $page_fontsize = 8.5;
    protected $footer_fontsize = 7;
    protected $title_fontsize = 11;
    protected $dataheader_fontsize = 8.5;
    // positie/breedte header cel
    private $header_cell_landscape = 130;
    private $header_cell_portrait = 60;
    private $header_cell_caption = 60;
    private $header_cell_value = 80;
    // breedte lijn cel
    private $header_repeat_landscape = 276;
    private $header_repeat_portrait = 189;
    // waar staat de dataheader in de pagina
    var $data_header_end_y;


    // hbd: deze twee functies (Text en Cell) overridden om de UTF8 -> fpdf ISO-8559-1 centraal te regelen.
    function Text($x, $y, $txt)
    {
        parent::Text($x, $y, PdfUtils::fpdfSafe($txt));
    }

    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        parent::Cell($w, $h, PdfUtils::fpdfSafe($txt), $border, $ln, $align, $fill, $link);
    }

//    // DirectCell doet de encoding conversie niet...
//    function DirectCell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
//    {
//        parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
//    }
    ///

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function PageTitle($title)
    {
        $this->page_title = $title;
    }

    function AddPage($orientation='', $format='')
    {
        parent::AddPage($orientation, $format);
        if ($this->reset_page_count) {
            $this->ResetPageCount();
            $this->reset_page_count = false;
        }
    }

    function requestResetPageCount($reset_page_count = true)
    {
        $this->reset_page_count = $reset_page_count;
    }

    function ResetPageCount($set_page_count = 0)
    {
        $this->page_count = $set_page_count;
    }

    function PageNo()
    {
        return $this->page_count;
    }

    function GetDataHeaderOffsetY()
    {
        return $this->data_header_end_y;
    }

    function FontSizes($set_header_fontsize = 9,
                       $set_page_fontsize = 8.5,
                       $set_footer_fontsize = 7,
                       $set_title_fontsize = 11,
                       $set_dataheader_fontsize = 8.5)
    {
        $this->header_fontsize = $set_header_fontsize;
        $this->page_fontsize = $set_page_fontsize;
        $this->footer_fontsize = $set_footer_fontsize;
        $this->title_fontsize = $set_title_fontsize;
        $this->dataheader_fontsize = $set_dataheader_fontsize;
    }

    function setTextColorHex($hex_color) {
        $coul = PdfUtils::hex2dec($hex_color);
        $this->SetTextColor($coul['R'], $coul['G'], $coul['B']);
    }

    function setFillColorHex($hex_color) {
        $coul = PdfUtils::hex2dec($hex_color);
        $this->SetFillColor($coul['R'], $coul['G'], $coul['B']);
    }

    function setDrawColorHex($hex_color) {
        $coul = PdfUtils::hex2dec($hex_color);
        $this->SetDrawColor($coul['R'], $coul['G'], $coul['B']);
    }

    function ActivatePrintHeader($set_print_header = 1)
    {
        $this->print_header = $set_print_header;
    }

    function ActivatePrintHeaderOnNewPage($set_print_header_on_new_page = 1)
    {
        $this->print_header_on_new_page = $set_print_header_on_new_page;
    }


    function ActivatePrintFooter($set_print_footer = 1)
    {
        $this->print_footer = $set_print_footer;
    }

    function ActivateDataHeader($set_data_header = 1)
    {
        $this->print_data_header = $set_data_header;
    }

    function PageHeaderData($data_array)
    {
        $this->page_header_data_array = $data_array;
    }

    function DataHeaderValues(  Array $set_width_array,
                                Array $set_title_array,
                                Array $set_align_array = NULL) {
        $this->data_header_width_array = $set_width_array;
        $this->data_header_title_array = $set_title_array;
        if (!is_null($set_width_array) && is_null($set_align_array)) {
            $this->data_header_align_array = $this->defaultAlignArray(count($set_width_array));
        } else {
            $this->data_header_align_array = $set_align_array;
        }
    }

    function defaultAlignArray($columns)
    {
        $alignArray = array();

        for ($column = 0; $column < $columns; $column++) {
            $alignArray[] = self::ALIGN_LEFT;
        }
        return $alignArray;
    }

    function HR($witdh, $linepos) {
        $this->SetDrawColor(134, 134, 134);
        $this->Cell($witdh, 1, '', $linepos, 1, 'C');
        $this->Ln();
    }

    function HRDots($width) {
        $this->Cell($width, '', str_repeat('.', $width), '', 1, '');
    }

    // hbd: Shaded als extra. TODO: combineren met function Row.
    function SingleRow($isBorder, $isShaded, $data) {
        $this->BasicSingleRow($isBorder, $isShaded, $data);
    }

    function BasicSingleRow($isBorder, $isShaded, $data, $defaultAlign = 'L', $isTitleRow = '') {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {

            if ($this->gray_col != '-' && $i == $this->gray_col) {
                $this->setTextColorHex(COLOR_GRAY);
            } else {
                $this->setTextColorHex(COLOR_BLACK);
            }

            $w = $this->widths[$i];
            if ($isTitleRow != '') {
                if ($i == 0) {
                    $algn = 'R';
                } elseif ($i == 1) {
                    $algn = 'L';
                }
            } else {
                $algn = isset($this->aligns[$i]) ? $this->aligns[$i] : $defaultAlign;
            }
            $a = $algn;

            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();

            $shadeCell = ($isShaded != '' && strpos($data[$i], '[x]') === false) ||
                    ($isShaded == '' && strpos($data[$i], '[x]') !== false)? true : false;
            $drawCellBorder = ($isBorder != '' && strpos($data[$i], '[-]') === false)  ||
                   ($isBorder == '' && strpos($data[$i], '[-]') !== false)? true : false;

            $data2 = str_replace('[-]', '', $data[$i]);
            $data2 = str_replace('[x]', '', $data2);

            //Print the text
            if (!$shadeCell) {
                $this->MultiCell($w, 5, $data2, 0, $a);
            } else {
                $this->SetDrawColor(134, 134, 134);
                $this->SetFillColor(218, 218, 218);
                $this->MultiCell($w, 5, $data2, 0, $a, true);
            }
            //Put the position to the right of the cell
            //Draw the border
            if ($drawCellBorder) {
                $this->Rect($x, $y, $w, $h);
            }
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }


    function SingleDataHeaderRow($data) {
        $this->BasicSingleRow($isBorder = '', $isShaded = '', $data);
    }


    // hbd: gewone rij. TODO: combineren met SingleRow
    function Row($isBorder, $data) {
        $this->BasicSingleRow($isBorder, '', $data);
    }

    // hbd: automatisch eerste kolom rechts align, om en om links. Todo: combineren met (Single)Row
    function SingleTitleRow($isBorder, $isShaded, $data) {
        $this->BasicSingleRow($isBorder, $isShaded, $data, $defaultAlign = 'L', $isTitleRow = 'Y');
    }

    function SingleRowAlign($isBorder, $isAlign, $data) {
        $this->BasicSingleRow($isBorder, $isShaded = '', $data, $defaultAlign = $isAlign);
    }

    function RowT($isborder, $isShaded, $data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Print the text

            $shadeCell = ($isShaded != '' && strpos($data[$i], '[x]') === false) ||
                    ($isShaded == '' && strpos($data[$i], '[x]') !== false)? true : false;
            $drawCellBorder = ($isborder != '' && strpos($data[$i], '[-]') === false) ||
                   ($isborder == '' && strpos($data[$i], '[-]') !== false) ? true : false;

            $data2 = str_replace('[-]', '', $data[$i]);
            $data2 = str_replace('[x]', '', $data2);

            if (!$shadeCell) {
                $this->MultiCell($w, 5, $data2, 0, $a);
            } else {
                $this->SetDrawColor(134, 134, 134);
                $this->SetFillColor(218, 218, 218);
                $this->MultiCell($w, 5, $data2, 0, $a, true);
            }
            //Draw the border
            if ($drawCellBorder) {
                $this->Rect($x, $y, $w - 2, $h);
            }
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate($angle = 0);
    }

    function RotatedImage($file, $x, $y, $w, $h, $angle) {
        //Image rotated around its upper-left corner
        $this->Rotate($angle, $x, $y);
        $this->Image($file, $x, $y, $w, $h);
        $this->Rotate($angle = 0);
    }

    function _endpage() {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    function Rotate($angle, $x=-1, $y=-1) {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle*=M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function TextWithDirection($x, $y, $txt, $direction='R') {
        $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
        if ($direction == 'R')
            $s = sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET', 1, 0, 0, 1, $x * $this->k, ($this->h - $y) * $this->k, $txt);
        elseif ($direction == 'L')
            $s = sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET', -1, 0, 0, -1, $x * $this->k, ($this->h - $y) * $this->k, $txt);
        elseif ($direction == 'U')
            $s = sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET', 0, 1, -1, 0, $x * $this->k, ($this->h - $y) * $this->k, $txt);
        elseif ($direction == 'D')
            $s = sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET', 0, -1, 1, 0, $x * $this->k, ($this->h - $y) * $this->k, $txt);
        else
            $s=sprintf('BT %.2f %.2f Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $txt);
        if ($this->ColorFlag)
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        $this->_out($s);
    }

    function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0) {
        $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));

        $font_angle+=90 + $txt_angle;
        $txt_angle*=M_PI / 180;
        $font_angle*=M_PI / 180;

        $txt_dx = cos($txt_angle);
        $txt_dy = sin($txt_angle);
        $font_dx = cos($font_angle);
        $font_dy = sin($font_angle);

        $s = sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',
                        $txt_dx, $txt_dy, $font_dx, $font_dy,
                        $x * $this->k, ($this->h - $y) * $this->k, $txt);
        if ($this->ColorFlag)
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        $this->_out($s);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                }
                else
                    $i=$sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    function Footer() {
        if ($this->print_footer == 1) { // hbd: mogelijkheid om footer weg te laten
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
            $this->Cell(0, 10, TXT_UCF('PRINT_DATE') . ' '. date('d-m-Y', time()) . '   ' . TXT_UCF('PAGE') . ' ' . $this->page_count, 0, 0, 'R');
        }
    }

    function Header()
    {
        // hbd: een page break kan op elk moment plaatsvinden, dus even widths apart zetten.
        $current_widths = $this->widths;
        if ($this->print_header >= 1) {
            $this->PageHeader($this->page_title);
            if ($this->print_header_on_new_page == 0) {
                $this->print_header = 0; // hbd: automatisch uitzetten header op vervolgpagina's
            }
        }
        if ($this->print_data_header) {
            $this->DataHeader(); // hbd: override deze functie
            $this->data_header_end_y = $this->GetY();
        }
        // hbd: default font size voor data op pagina klaarzetten
        $this->SetFont($this->font_family, '', $this->page_fontsize);
        $this->SetTextColor(0);
        // herstel widths
        $this->SetWidths($current_widths);
    }

    function PageHeader($pageLabel)
    {
        if ($this->print_header == 1) {
            if (file_exists(PDF_LOGO)) {
                $this->Image(PDF_LOGO, 8, 5, LOGO_WIDTH_PDF, LOGO_HEIGHT_PDF);
            }
        }
        $this->Cell(-1);
        $this->SetTextColorHex(COLOR_RED);

        $this->SetFont($this->font_family, 'B', $this->title_fontsize);
        $this->Ln(0);
        // uitlijnen gelijk met andere header informatie (zie PageHeaderEnd)
        $cell_width = $this->CellWidthForOrientation() + $this->header_cell_caption;
        $this->Cell($cell_width);
        $this->Cell(0, 0, $pageLabel , 0, 0, 'L');
        $this->Ln(2);

        $this->SetFont($this->font_family, '', $this->header_fontsize);
        $this->PageHeaderEnd(); // hbd: override deze functie
        $this->SetFont($this->font_family, '', $this->page_fontsize);

    }

    protected function CellWidthForOrientation() {
        if ($this->CurOrientation == 'L') {
            $cell_width = $this->header_cell_landscape;
        } else {
            $cell_width = $this->header_cell_portrait;
        }
        return $cell_width;
    }

    // hbd: pagina specifieke vervolg in header
    //      Override deze in de relevante pagina's
    function PageHeaderEnd()
    {
        $this->SetTextColorHex(COLOR_BLACK);
        $this->SetFont($this->font_family, '', $this->header_fontsize);
        $cell_width = $this->CellWidthForOrientation();
        if (empty($this->page_header_data_array)) {
            $this->Ln(20);
        } else {
            foreach($this->page_header_data_array as $header_data) {
                $this->Cell($cell_width);
                $this->SetWidths(array($this->header_cell_caption, $this->header_cell_value));
                $this->SingleTitleRow('', '', $header_data);
                $this->Ln(-1);
            }
            $this->Ln(9); // ruimte tot content page
        }
        $this->SetFont($this->font_family, '', $this->page_fontsize);
    }


    private function RepeatWidthForOrientation() {
        if ($this->CurOrientation == 'L') {
            $repeat_width = $this->header_repeat_landscape;
        } else {
            $repeat_width = $this->header_repeat_portrait;
        }
        return $repeat_width;
    }


    // hbd: roep vanuit de pagina specifieke DataHeader deze util aan
    function DataHeader()
    {
        if (!empty($this->data_header_width_array) &&
            !empty($this->data_header_title_array) &&
            !empty($this->data_header_align_array)) {
            $this->PageDataHeader(  $this->data_header_width_array,
                                    $this->data_header_title_array,
                                    $this->data_header_align_array);
        }
    }

    // hbd: roep vanuit de pagina specifieke DataHeader deze util aan
    function PageDataHeader(Array $width_array,
                            Array $title_array,
                            Array $align_array = NULL)
    {
        $align_array = is_null($align_array) ? $this->defaultAlignArray(count($width_array)) : $align_array;
        $repeat_width = $this->RepeatWidthForOrientation();
        $this->SetTextColorHex(COLOR_BLACK);
        $this->SetFont($this->font_family, 'B', $this->dataheader_fontsize);
        $this->Cell(0, 4, str_repeat('¯', $repeat_width));
        $this->Ln(1);
        $this->SetWidths($width_array);
        $this->SetAligns($align_array);
        $this->SingleDataHeaderRow($title_array);
        $this->Ln(0);
//        $this->Cell(0, 4, iconv("UTF-8", "ISO-8859-1", str_repeat('¯', $repeat_width)));
        $this->Cell(0, 4, str_repeat('¯', $repeat_width));
        $this->Ln(1);
        $this->SetFont($this->font_family, '', $this->page_fontsize);
    }

    // hbd: eigenlijk niet generiek genoeg
    function fillBox($text_color, $fill_color, $legenda_x, $legenda_y, $color_text, $scale_text, $scale_width = 30, $fill_mode = 'F')
    {
        $text_hori_offset = 19;
        $color_width = 18.4;
        $color_height = 4.5;

        $this->SetTextColorHex($text_color);
        $this->setFillColorHex($fill_color);
        if (!empty($color_text)) {
            $this->Rect($legenda_x, $legenda_y - 3, $color_width, $color_height, $fill_mode);
            $this->Text($legenda_x + 1, $legenda_y, $color_text);
        }
        if (!empty($scale_text)) {
            $this->Rect($legenda_x + $text_hori_offset, $legenda_y - 3, $scale_width, $color_height, $fill_mode);
            $this->Text($legenda_x + $text_hori_offset + 1, $legenda_y, $scale_text);
        }
    }


}


?>
