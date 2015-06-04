<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/common/pdfConsts.inc.php');
require_once('pdf/objects/common/pdfUtils.inc.php');
require_once('pdf/objects/common/graphUtils.inc.php');
require_once('pdf/objects/rpdf/print_sb_team_table.php');
require_once('plot/phplot/phplot.php');

$score_totals = $_SESSION['print_sb_team_score_totals'];
$employees_scores = $_SESSION['print_sb_team_employees_scores'];
$employees_info = $_SESSION['print_sb_team_employees_info'];


$pdf = new PdfScoreboardTeamTable($set_max_scores_on_page = 15);

// hbd: todo aanpassen titel
$title = $_SESSION['print_sb_team_title'];
$subtitle1 =  $_SESSION['print_sb_team_subtitle_fun'];
$subtitle2 =  $_SESSION['print_sb_team_subtitle_dep'];

 $pdf->PageHeaderData(array( array('', '            ' . ucfirst($subtitle1)),
                             array('', '            ' . TXT_UCF('DEPARTMENT') . ': ' . ucfirst($subtitle2)),
                             array('', '            ' . TXT_UCF('DATE') . ': '. date('d-m-Y', time()))));

$pdf->PageTitle('          ' . $title);

$pdf->Open();
$pdf->AddPage($orientation = 'L');

$max_scores_per_page = $pdf->MaxScoresOnPage();
$vertical_offset = 12;


$sql3 = $_SESSION['print_sb_team_sql3'];

$dbID_KSPs = PdfUtils::getData($sql3, true);

//$id_fjoin = $_SESSION['print_sb_team_id_fjoin'];
//$condition = $_SESSION['print_sb_team_condition'];
//print_r($condition);
//

// hbd: bepaal welke ksp's er op een pagina passen
if ($dbID_KSPs) {
    $ksp_on_page = 0;
    $page_num = 0;
    $id_ksp_array = array();
    foreach ($dbID_KSPs as $value) {
        $id_ksp_array[$page_num][$ksp_on_page] = $value['ID_KSP'];
        $ksp_on_page++;

        if ($ksp_on_page == $max_scores_per_page) {
            $ksp_on_page = 0;
            $page_num++;
        }
    }
}

$j = 1;

$j_e = 0;
$i_e = 0;

$emp_loop = 1;

$score_array = array();
foreach ($dbarray as $value) {
    $oldemp = $emp;
    $emp = $value['employee'];
    $norm = $value['norm'];
    $score = $value['score'];
    $is_cluster_main = $value['is_cluster_main'];


    //IN EMPLOYEE CHANGE

    if ($emp != $oldemp && $j != 1) {
        $j_e = 0;
        //
        $i_e = 0;

        $emp_loop++;
    }

    //$score_array[$i_e][$j] = "[[" . $j . "]] " . "[" . $i_e . "]-" . "[" . $j_e . "] " . $value['score'] . " [" . $value['knowledge_skill_point'] . "]" . " [" . $value['employee'] . "]";

    if (trim($value['score']) == '') {
        $score_input = 0;
    } else {
        $score_input = trim($value['score']);
    }

    if (trim($value['norm']) == '') {
        $norm_input = 0;
    } else {
        $norm_input = trim($value['norm']);
    }

//    $score_array[$i_e][$j] = $score_input . " " . $norm_input . " " . $value['employee'] ;
    $score_array[$i_e][$j]['score'] = $score_input ;
    $score_array[$i_e][$j]['norm'] = $norm_input;
    $score_array[$i_e][$j]['employee'] = $emp;
    $score_array[$i_e][$j]['is_cluster_main'] = $is_cluster_main;

    $j_e++;


    if ($j_e == $max_scores_per_page) {
        $i_e++;
        $j_e = 0;
    }


    $j++;
}

//function determineIncrement
$num_loops = count($id_ksp_array) - 1; // 2D array, eerste index is aantal pagina's

for ($counter_loop = 0; $counter_loop <= $num_loops; $counter_loop++) {


    if ($counter_loop == 0) {
        $start = 0;
        $loop_while = min($max_scores_per_page-1, count($id_ksp_array[$counter_loop])-1);
        //echo $counter_loop . ' : ' . $start . ' - ' . $loop_while . "\n";
    } else {
        $start = $loop_while + 1;
        $elements_left = count($id_ksp_array[$counter_loop]);
        $max_this_page = min($elements_left, $max_scores_per_page);
        $loop_while = $start + $max_this_page -1;
//        echo 'cl ' . $counter_loop . ' : ' . $start . ' - ' . $loop_while . "\n";
//        echo '  el ' .$elements_left . ' : ' . $max_this_page . ' - ' . $loop_while . "\n";
    }

    $counter = 151.85;
    $cell_margin = $counter - 12.5;
    $value_margin = 6;

    $pdf->Ln(-10);

    $pdf->image('../images/score/grey.png', 9, 34 + $vertical_offset, 24.3, 4.2, 'PNG');

    $pdf->Rect(9, 34 + $vertical_offset, 24.5, 4.5);

    $pdf->image('../images/score/grey.png', 34.5, 34 + $vertical_offset, 45, 4.2, 'PNG');

    $pdf->Rect(34.5, 34 + $vertical_offset, 45, 4.5);
    $pdf->image('../images/score/grey.png', 80.5, 34 + $vertical_offset, 66, 4.2, 'PNG');

    $pdf->Rect(80.5, 34 + $vertical_offset, 66, 4.5);

    $move_right = 148.5;

    $pdf->Text(10, 38 + $vertical_offset, TXT_UCF('CATEGORY')); // 43

    $j = 1;
    foreach ($dbarray as $value) {

        $oldemp = $emp;
        $emp = $value['employee'];

        if ($emp != $oldemp || $j == 1) {

            $pdf->image('../images/score/bar.png', $move_right, 2 + $vertical_offset, 5, 37, 'PNG');
            $move_right = $move_right + 6;

            $capitalize = ucwords($emp);
            $pdf->TextWithDirection($counter, 37 + $vertical_offset, $capitalize, 'U');
            $counter = $counter + $value_margin;
        }
        $j++;
    }

    $pdf->Ln(36);

    $counter_v = 43 + $vertical_offset;
    $counter_h = 10;

    $counter_border = 40;

    $j = 1;

    $j = 1;
    for ($i = $start; $i <= $loop_while; $i++) {
        $oldemp = $emp;
        $emp = $dbarray[$i]['employee'];

        if ($emp == $oldemp || $j == 1) {

            $counter_border = $counter_border + 6;

            $oldks = $ks;
            $ks = $dbarray[$i]['knowledge_skill'];
            if ($ks != $oldks || $j == 1) {
                $knowledge_skill = ModuleUtils::Abbreviate($ks, 15);
            } else {
                $knowledge_skill = '';
            }

            $pdf->Rect($counter_h - 1, $counter_v - 3.5, 24.5, 4.5);


            $pdf->Text($counter_h, $counter_v, $knowledge_skill);

            $counter_v = $counter_v + 6;
        } else {
            break;
        }

        $j++;
    }

    $pdf->Text($counter_h + 25, 38 + $vertical_offset, TXT_UCF('CLUSTER')); // 44

    $counter_v = 43 + $vertical_offset;
    $counter_h = $counter_h + 25;

    $j = 1;
    for ($i = $start; $i <= $loop_while; $i++) {
        $oldemp = $emp;
        $emp = $dbarray[$i]['employee'];
        //echo $i.'-';
        if ($emp == $oldemp || $j == 1) {

            $oldcluster = $cluster;
            $cluster = $dbarray[$i]['cluster'];
            if ($cluster != $oldcluster || $j == 1) {
                $cluster1 = ModuleUtils::Abbreviate($cluster, 22);
            } else {
                $cluster1 = '';
            }

            $fill_mode = $dbarray[$i]['is_cluster_main'] == 1 ? 'FD' : '';
            $pdf->setFillColorHex(COLOR_LIGHTGRAY);
            $pdf->Rect($counter_h - .5, $counter_v - 3.5, 45, 4.5, $fill_mode);

            $pdf->Text($counter_h, $counter_v, $cluster1);

            $counter_v = $counter_v + 6;
        } else {
            break;
        }


        $j++;
    }


    $counter_v = 43 + $vertical_offset;
    $counter_h = 81;

    $pdf->Text($counter_h, 38 + $vertical_offset, TXT_UCF('COMPETENCE')); // 45

    $j = 1;
    for ($i = $start; $i <= $loop_while; $i++) {

        $oldemp = $emp;
        $emp = $dbarray[$i]['employee'];

        if ($emp == $oldemp || $j == 1) {
            $counter_v_img = $counter_v - 3;
            $counter_h_img = $counter_h - 1.2;

            $ksp1 = ModuleUtils::Abbreviate($dbarray[$i]['knowledge_skill_point'], 33);
            $fill_mode = $dbarray[$i]['is_cluster_main'] == 1 ? 'FD' : '';
            $pdf->setFillColorHex(COLOR_LIGHTGRAY);

            $pdf->Rect($counter_h - .5, $counter_v - 3.5, 66, 4.5, $fill_mode);

            $pdf->Text($counter_h, $counter_v, $ksp1);

            $counter_v = $counter_v + 6;
        } else {
            break;
        }

        $j++;
    }


    //die("[" . $i . "]");



    $j = 1;
    $counter_v = 43 + $vertical_offset;
    $counter_h = $counter_h + 69;


    foreach ($score_array[$counter_loop] as $value) {


        $oldemp = $emp;
        $emp = $value['employee'];//substr($value, 4, 30);
        $norm = $value['norm'];//substr($value, 2, 1);
        $score = $value['score'];//substr($value, 0, 1);

//        if ($score == '0') {
//            $score_disp = ' ';
//        } else {
//            $score_disp = $score;
//        }
        $score_disp = ModuleUtils::ScorepointLetter($score);

        if ($emp != $oldemp && $j != 1) {
            $counter_h = $counter_h + 6;
            $counter_v = 43 + $vertical_offset;
        }

        $counter_v_img = $counter_v - 3;
        $counter_h_img = $counter_h - 1.2;

//        AttentionImage()
        $fill_mode = '';
        $attention_image = GraphUtils::AttentionImage($score, $norm, $score_disp);
        if (!empty($attention_image)) {
            $pdf->image('../images/score/'.$attention_image, $counter_h_img, $counter_v_img, null, 3.5, 'PNG');
        } else {
            $fill_mode = $value['is_cluster_main'] == 1 ? 'FD' : '';
            $pdf->setFillColorHex(COLOR_LIGHTGRAY);
        }


        $pdf->Rect($counter_h - 1.4, $counter_v - 3, 4.8, 3.7, $fill_mode);

        $pdf->Text($counter_h, $counter_v, $score_disp);

        $counter_v = $counter_v + 6;

        $j++;
    }
//   echo $j;

    //$dbarray2 = getData($sql2, true);

    $counter_border = 40;

    $j = 1;
    for ($i = $start; $i <= $loop_while; $i++) {

        $oldemp = $emp;
        $emp = $dbarray[$i]['employee'];

        if ($emp == $oldemp || $j == 1) {

            if (is_numeric($dbarray2[$i]['avg_norm1'])) {
                $avg_norm = floor($dbarray2[$i]['avg_norm1']);
            } else {
                $avg_norm = $dbarray2[$i]['avg_norm1'];
            }

            if ($j == 1) {
                $pdf->image('../images/score/grey.png', $counter_h + 5, 34 + $vertical_offset, 17, 4.2, 'PNG');
                $pdf->Rect($counter_h + 5, 34 + $vertical_offset, 17, 4.5);

                $pdf->Text($counter_h + 8, 38 + $vertical_offset, "NORM");

                $counter_v = 43 + $vertical_offset;
                $counter_h = $counter_h + 12;
            }

            //$pdf->image('../images/score/white_border.png', $counter_h - 7, $counter_border, 17, 5,'PNG');
            $counter_border = $counter_border + 6;

            $counter_v_img = $counter_v - 3;
            $counter_h_img = $counter_h - 1.2;

            //$pdf->image('../images/score/white.png', $counter_h_img, $counter_v_img, null, 3.5, 'PNG');
            $fill_mode = $dbarray2[$i]['is_cluster_main'] == 1 ? 'FD' : '';
            $pdf->setFillColorHex(COLOR_LIGHTGRAY);

            $pdf->Rect($counter_h - 7, $counter_v - 3, 16.7, 4, $fill_mode);

            $pdf->Text($counter_h, $counter_v, ModuleUtils::ScoreNormLetter($avg_norm));
            $counter_v = $counter_v + 6;
        } else {
            break;
        }

        $j++;
    }

    $counter_border = 40;

    $j = 1;
    for ($i = $start; $i <= $loop_while; $i++) {

        if (trim($dbarray2[$i]['knowledge_skill_point'] == '')) {
            break;
        }

        if (is_numeric($dbarray2[$i]['avg_norm1'])) {
            $avg_norm = floor($dbarray2[$i]['avg_norm1']);
        } else {
            $avg_norm = $dbarray2[$i]['avg_norm1'];
        }


        if (is_numeric($dbarray2[$i]['avg_score3'])) {

            if (intval(substr($dbarray2[$i]['avg_score3'], 2, 1)) < 6) {
                $avg_score = floor($dbarray2[$i]['avg_score3']);
            } else {
                $avg_score = round($dbarray2[$i]['avg_score3']);
            }
        } else {
            $avg_score = $dbarray2[$i]['avg_score3'];
        }

        //$ = '['.$dbarray2[$i]['emp_count'] . '|avgs:' . $avg_score . ']';
        if ($j == 1) {


            $pdf->image('../images/score/grey.png', $counter_h + 11, 34 + $vertical_offset, 28.2, 4.2, 'PNG');

            $pdf->Rect($counter_h + 11, 34 + $vertical_offset, 28., 4.5);
            $pdf->Text($counter_h + 12, 38 + $vertical_offset, "TEAM SCORE");  // hbd: vertaling (past niet)?

            $counter_v = 43  + $vertical_offset;
            $counter_h = $counter_h + 21;
        }

        //$pdf->image('../images/score/white_border.png', $counter_h - 10, $counter_border, 28.5, 5,'PNG');

        $counter_border = $counter_border + 6;

        $counter_v_img = $counter_v - 3;
        $counter_h_img = $counter_h - 10;

        $image_length = 27.7;

        $fill_mode = '';
        $attention_image = GraphUtils::AttentionImage($score1, $norm1, $score_disp);
        if (!empty($attention_image)) {
            $score_color_y = $pdf->GetY();// + 1;
            //echo $attention_image;
            $pdf->image('../images/score/'.$attention_image, 82, $score_color_y, null, 4, 'PNG');
        } else {
            $fill_mode = $dbarray2[$i]['is_cluster_main'] == 1 ? 'FD' : '';
            $pdf->setFillColorHex(COLOR_LIGHTGRAY);
        }


        if (is_numeric(trim($avg_norm))) {
            if (!trim($avg_score) == '') {
                $result = $avg_norm - $avg_score;
                switch ($result) {
                    case 0:
                        $attention_image = 'green.png';
                        break;
                    case 1:
                        $attention_image = 'orange.png';
                        break;
                    case 2:
                        $attention_image = 'blue.png';
                        break;
                    case 3:
                        $attention_image = 'red.png';
                        break;
                    case 4:
                        $attention_image = 'red.png';
                        break;
                }

                if ($avg_norm == 3 && $avg_score == 1) {
                    $attention_image = 'red.png';
                }


                if ($result < 0) {
                    $attention_image = 'yellow.png';
                }
            } else {
                //$pdf->image('../images/score/white.png', $counter_h_img, $counter_v_img, $image_length, 3.5, 'PNG');
            }

        } else {
            if (!trim($avg_score) == '') {
                if (trim($avg_norm) == 'N') {
                    if (trim($avg_score) > 1) {
                        $attention_image = 'yellow.png';
                    } else {
                        $attention_image = 'green.png';

                    }
                } else if (trim($avg_norm) == trim($avg_score)) {
                        $attention_image = 'green.png';
                } else {
                    $result2 = 5 - $avg_score;

                    switch ($result2) {
                        case 0:
                            $attention_image = 'green.png';
                            break;
                        case 1:
                            $attention_image = 'orange.png';
                            break;
                        case 2:
                            if ($avg_norm == 3 && $avg_score == 1) {
                                $attention_image = 'red.png';
                            } else {
                                $attention_image = 'blue.png';
                            }
                            break;
                        case 3:
                            $attention_image = 'red.png';
                            break;
                        case 4:
                            $attention_image = 'red.png';
                            break;
                    }
                }
            } else {
                //$pdf->image('../images/score/white.png', $counter_h_img, $counter_v_img, $image_length, 3.5, 'PNG');
            }
        }

        $fill_mode = '';
        if (!empty($attention_image)) {
            $pdf->image('../images/score/'. $attention_image, $counter_h_img, $counter_v_img, $image_length, 3.5, 'PNG');
        } else {
            $fill_mode = $dbarray2[$i]['is_cluster_main'] == 1 ? 'FD' : '';
            $pdf->setFillColorHex(COLOR_LIGHTGRAY);
        }



        if ($avg_score == 0) {
            $avg_score_disp = '-';
        } else {
            $avg_score_disp = $avg_score;
        }

        if (trim(strtoupper($avg_norm)) == "Y" || trim(strtoupper($avg_norm)) == "N") {
            $avg_score_disp = ' ';//$avg_score;
        }

        $pdf->Rect($counter_h - 10, $counter_v   - 3, 27.9, 3.7, $fill_mode);

        $pdf->Text($counter_h + 3, $counter_v , $avg_score_disp);
        $counter_v = $counter_v + 6;




        $j++;
    }
    $pdf->image('../images/score/grey.png', $counter_h + 19, 34 + $vertical_offset, 23.7, 4.2, 'PNG');

    $pdf->Rect($counter_h + 19, 34 + $vertical_offset, 24, 4.5);
    $graphx = $counter_h + 19.5;

    $pdf->Text($graphx, 38  + $vertical_offset, "1    2    3    4    5");

    $time = time();

    $j = 1;
    $count_ks = 1;


    for ($i = $start; $i <= $loop_while; $i++) {
        $oldemp = $emp;
        $emp = $dbarray[$i]['employee'];

        if ($emp == $oldemp || $j == 1) {
            $count_ks++;
        } else {
            break;
        }
        $j++;
    }

    $data = "";

    $data = array();

    $j = 1;
    for ($i = $start; $i <= $loop_while; $i++) {


        if (is_numeric($dbarray2[$i]['avg_norm1'])) {
            $avg_norm = floor($dbarray2[$i]['avg_norm1']);
        } else {
            $avg_norm = $dbarray2[$i]['avg_norm1'];
        }

        if (is_numeric($dbarray2[$i]['avg_score3'])) {

            if (intval(substr($dbarray2[$i]['avg_score3'], 2, 1)) < 6) {
                $avg_score = floor($dbarray2[$i]['avg_score3']);
            } else {
                $avg_score = round($dbarray2[$i]['avg_score3']);
            }
        } else {
            $avg_score = $dbarray2[$i]['avg_score3'];
        }

        switch ($avg_score) {
            case '':$score_grid = 0;
                break;
            case 'Y':
                    $score_grid = 1000;
//                if ($avg_norm == 'Y') {
//                    $score_grid = 1000;
//                } else {
//                    $score_grid = 0;
//                }
                break;
            case 'N':
                $score_grid = 0;
//                if ($avg_norm == 'N') {
//                    $score_grid = 1000;
//                } else {
//                    $score_grid = 0;
//                }
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

        switch ($avg_norm) {
            case '':$norm_grid = 0;
                break;
            case 'Y':
                $norm_grid = 1000;
                break;
            case 'N':
                $norm_grid = 0;//1000;
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

        $data[] = array($score, $norm_grid, $score_grid);
        $j++;
    }
    //echo $j;
    $count_ks = $count_ks - 1;
    $spacer = 16.75;

    $area_length = $spacer * ($count_ks);
    $area_width = 65;

    $space_length = $spacer * ($count_ks);
    $space_width = 60;

    $plot = new PHPlot($area_length, $area_width);
    $plot->SetImageBorderType('plain');
    $plot->SetPlotAreaPixels(0, 3, $space_length, $space_width);
    $plot->SetDataType('text-data');
    $plot->SetDataValues($data);
    $plot->SetPlotAreaWorld(NULL, 0, NULL, 1000);
    $plot->SetXDataLabelPos('none');
    $plot->SetYTickPos('none');
    $plot->SetYTickLabelPos('none');
    $plot->SetXTickPos('none');
    $plot->SetXTickLabelPos('none');
    $plot->SetDataColors(array('#999999', 'black'));
    $plot->SetYTickIncrement(250);
    $plot->SetPlotType('linepoints');
    $plot->SetImageBorderColor('#FFFFFF');
    $plot->SetGridColor('#FFFFFF');
    $plot->SetPlotBorderType('none');
    $plot->SetIsInline(true);
    $plot->SetOutputfile(ModuleUtils::getCustomerTempPath() . $counter_loop . $time . "_print.png");
    $plot->DrawGraph();

    reset($data);
    unset($data);
    $data = "";




    $pdf->RotatedImage(ModuleUtils::getCustomerTempPath() . $counter_loop . $time . "_print.png", $graphx + 22.5, 40 + $vertical_offset, null, null, 270);
    //die('path:' . realpath ('../temp/'));
    $pdf->Ln(90);
    $pdf->Cell(210);
    $pdf->Image('../images/score/criteria.png', 240, $pdf->GetY(), 40); // deze gaat er nog uit...

    if ($counter_loop != $num_loops) {
        $pdf->ActivatePrintHeader(2);
        $pdf->AddPage($orientation = 'L');
    }
}

//die($sql);

$pdf->Output();

?>
