<?php

require_once('plot/phplot/phplot.php');
require_once('modules/common/moduleConsts.inc.php');

class GraphUtils {

    // TODO: betere filename
    static function DrawPdfGraph($pdf, $data, $filename_offset, $graph_location_verti, $graph_location_hori, $b_is_team)
    {
        usleep(500);
        $image_name = ModuleUtils::getCustomerTempPath() . 'chart_' . time() . $filename_offset . '.png';
        $space_per_score = $b_is_team ? 17 : 22;
        $graph_margin = $b_is_team ? 5 : 5;

        $space_width = $b_is_team ? 70 : 95;
        $space_length = $space_per_score * (count($data));

        $area_width = $space_width + $graph_margin;
        $area_length = $space_length;


        $plot = new PHPlot($area_length, $area_width);
        $plot->SetImageBorderType('plain');
        $plot->SetPlotAreaPixels($graph_margin, $graph_margin, $space_length, $space_width);
        $plot->SetDataType('text-data');
        $plot->SetDataValues($data);
        $plot->SetPlotAreaWorld(NULL, 0, NULL, 1000);
        $plot->SetXDataLabelPos('none');
        $plot->SetYTickPos('none');
        $plot->SetYTickLabelPos('none');
        $plot->SetXTickPos('none');
        $plot->SetXTickLabelPos('none');
        $plot->SetDataColors(array(COLOUR_GRAY, COLOUR_BLACK));
        $plot->SetYTickIncrement(250);
        $plot->SetPlotType('linepoints');
        $plot->SetImageBorderColor(COLOUR_WHITE);
        $plot->SetGridColor(COLOUR_GRAY);
        $plot->SetPlotBorderType('none');
        $plot->SetIsInline(true);
        $plot->SetOutputfile($image_name);
        $plot->DrawGraph();

        $pdf->RotatedImage($image_name, $graph_location_hori, $graph_location_verti , null, null, 270); // 26 // first page
        unlink($image_name);

    }

    // TODO: deze functie nog wegwerken...
    static function DrawPageGraph($pdf, $data, $filename_offset, $graph_location_hori, $area_length = 480, $area_width = 110)
    {
        //echo "data:".print_r($data);
        if ($data) {
            $image_name = ModuleUtils::getCustomerTempPath() . 'chart2_' . time() . $filename_offset . '.png';
            //echo "imagename:".$image_name;

            $p1 = new PHPlot($area_length, $area_width);
            $p1->SetTitle('');
            $p1->SetDataType('text-data');

            $p1->SetDataValues($data);
            $p1->SetDataColors(array(COLOUR_GRAY, COLOUR_BLACK));

            $p1->SetPlotType('linepoints');

            $p1->SetPlotAreaWorld(.5, 0, 21.8, 1000);

            $p1->SetGridColor(COLOUR_WHITE);
            //$p1->SetDrawXGrid(True);
            //$p1->SetDrawYGrid(True);
            $p1->SetDrawXGrid(False);
            $p1->SetDrawYGrid(False);
            $p1->SetLineWidths(1);
            $p1->SetLineSpacing(0);
            $p1->SetLineStyles('solid');

            $p1->SetMarginsPixels(20, 5, 5, 15);
            $p1->SetNumXTicks(20);
            $p1->SetNumYTicks(4);

            $p1->SetXDataLabelPos('none');
            $p1->SetXTickPos('none');
            $p1->SetXTickLabelPos('none');
            $p1->SetYTickPos('none');
            $p1->SetYTickLabelPos('none');

            $p1->SetImageBorderColor('#FFFFFF');
    //
            $p1->SetPlotBorderType('none');
            $p1->SetIsInline(true);
            $p1->SetOutputfile($image_name);
            $p1->DrawGraph();

            $graph_location_verti = $pdf->GetDataHeaderOffsetY() + 0.8;
            $pdf->RotatedImage($image_name, $graph_location_hori, $graph_location_verti , null, null, 270); // 26 // first page

            unlink($image_name);
        }
    }



    static function EvalScoreToGraphValue($score, $norm)
    {
            switch ($score) {
                case '':
                case 'NULL':
                    $score_grid = 0;
                    break;
                case 'Y':
                    $score_grid = 1000; // !
                    break;
                case 'N':
                    $score_grid = 0;
                    break;
                case 1:$score_grid = 0;
                    break;
                case 2:$score_grid = 250;
                    break;
                case 3:$score_grid = 500;
                    break;
                case 4:$score_grid = 750;
                    break;
                case 5:$score_grid = 1000;
                    break;
            }
            return $score_grid;
    }

    static function EvalNormToGraphValue($norm)
    {
        switch ($norm) {
            case '':
            case 'NULL':
                $norm_grid = 0;
                break;
            case 'Y':
                $norm_grid = 1000;
                break;
            case 'N':
                $norm_grid = 0;
                break;
            case 1:$norm_grid = 0;
                break;
            case 2:$norm_grid = 250;
                break;
            case 3:$norm_grid = 500;
                break;
            case 4:$norm_grid = 750;
                break;
            case 5:$norm_grid = 1000;
                break;
        }
        return $norm_grid;
    }

    static function AttentionImage($score1, $norm1, $score_disp) {
        unset($attention_image);
        //$attention_image
        $res = $norm1 - $score1;
        $score_disp = trim($score_disp);
        //$no_score_disp = empty($score_disp) || ($score_disp == '-');
        if (trim($score1) <> '' && ($score_disp<> '-')) {
            if (is_numeric(trim($norm1))) {
                switch ($res) {
                    case 0:
                        $attention_image = 'green.png';
                        break;
                    case 1:
                        $attention_image = 'orange.png';
                        break;
                    case 2:
                        $attention_image =  'blue.png';
                        break;
                    case 3:
                        $attention_image = 'red.png';
                        break;
                    case 4:
                        $attention_image = 'red.png';
                        break;
                }
                if ($norm1 == 3 && $score1 == 1) {
                    $attention_image = 'red.png';
                }

                if ($res < 0) {
                    $attention_image = 'yellow.png';
                }
            } else { // Y/N

                if (trim($norm1) == trim($score1)) {
                    $attention_image = 'green.png';
                } else if (trim($norm1) == 'N') {
                    if ((trim($score1) == 'Y') || (trim($score1) > 1))  {
                        $attention_image = 'yellow.png';
                    }
                } else if (trim($norm1) == 'Y') {
                         if ($score1 == 'N') {
                            $attention_image = 'red.png';
                         } else {

                            $res = 5 - trim($score1);
                            switch ($res) {
                                case 0:
                                    $attention_image = 'green.png';
                                    break;
                                case 1:
                                    $attention_image = 'orange.png';
                                    break;
                                case 2:
                                    $attention_image =  'blue.png';
                                    break;
                                case 3:
                                    $attention_image = 'red.png';
                                    break;
                                case 4:
                                    $attention_image = 'red.png';
                                    break;
                            }

                         }
                         //$attention_image = 'white.png';
//                    } else {
                        //$attention_image = 'red.png';
                }
            }
        } else {
            //$attention_image = 'white.png';
        }
        return $attention_image;
    }

    static function addScoreLegenda($pdf, $score_x, $score_y, $legenda_x, $legenda_y)
    {
        $offset_row = 5.2;
        $graph_legenda_width = 3;

        $pdf->SetFont('Arial', '', 7);
        // lijntjes legenda
        $pdf->fillBox(COLOUR_BLACK, COLOUR_WHITE, $score_x, $score_y, TXT_UCF(CUSTOMER_MGR_SCORE_LABEL), '');
        $pdf->fillBox(COLOUR_BLACK, COLOUR_BLACK, $score_x, $score_y, '', ' ', $graph_legenda_width);
        $score_y += $offset_row;
        $pdf->fillBox(COLOUR_BLACK, COLOUR_WHITE, $score_x, $score_y, TXT_UCF('NORM'), '');
        $pdf->fillBox(COLOUR_BLACK, COLOUR_GRAY, $score_x, $score_y, '', ' ', $graph_legenda_width);

        // rood
        $legenda_y -= $offset_row;
        $legenda_y -= $offset_row;
        $pdf->fillBox(COLOUR_BLACK, COLOUR_WHITE, $legenda_x, $legenda_y, TXT_UCF('COLOUR_SCALE'), '');
        $legenda_x += 1; // correctie voor kleurenvlak uitlijnen onder bovenstaande tekst
        $legenda_y += $offset_row;
        $pdf->fillBox(COLOUR_WHITE, COLOUR_RED, $legenda_x, $legenda_y, TXT_UCF('COLOUR_SCALE_RED'), TXT_UCF('SCALE_3_BELOW_NORM'));
        // donker blauw
        $legenda_y += $offset_row;
        $pdf->fillBox(COLOUR_WHITE, COLOUR_DARK_BLUE, $legenda_x, $legenda_y, TXT_UCF('COLOUR_SCALE_DARK_BLUE'), TXT_UCF('SCALE_2_BELOW_NORM'));
        // licht blauw
        $legenda_y += $offset_row;
        $pdf->fillBox(COLOUR_WHITE, COLOUR_LIGHT_BLUE, $legenda_x, $legenda_y, TXT_UCF('COLOUR_SCALE_LIGHT_BLUE'), TXT_UCF('SCALE_1_BELOW_NORM'));
        // groen
        $legenda_y += $offset_row;
        $pdf->fillBox(COLOUR_BLACK, COLOUR_GREEN, $legenda_x, $legenda_y, TXT_UCF('COLOUR_SCALE_GREEN'), TXT_UCF('SCALE_ON_NORM'));
        // geel
        $legenda_y += $offset_row;
        $pdf->fillBox(COLOUR_BLACK, COLOUR_YELLOW, $legenda_x, $legenda_y, TXT_UCF('COLOUR_SCALE_YELLOW'), TXT_UCF('SCALE_ABOVE_NORM'));

        $scale_legenda = TXT_UCF('SCALE') . ': ' .
                         '  [1] ' . SCALE_NONE .
                         '  [2] ' . SCALE_BASIC .
                         '  [3] ' . SCALE_AVERAGE .
                         '  [4] ' . SCALE_GOOD .
                         '  [5] ' . SCALE_SPECIALIST;
        $pdf->fillBox(COLOUR_BLACK, COLOUR_WHITE, 10, $legenda_y, $scale_legenda, '');

    }

}
?>
