<?php

///////////////////////////////////////
/// BENCHMARKING
////////////////

//CARLO 15-Jan-09
function moduleFunction_benchmarkingOptions_deprecated() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_FUNCTIONS__SELECT_BENCHMARK_DEPRECATED);
        $safeFormHandler->addStringInputFormatType('cross');
        $safeFormHandler->addStringArrayInputFormatType('function');
        $safeFormHandler->finalizeDataDefinition();

        $html = '<p>' . TXT_UCF('BENCHMARKING_OPTIONS') . '</p>
        <form id="fromBenchmarking" name="fromBenchmarking" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

        $html .= '
        <table width="600" border="0" cellspacing="0" cellpadding="2" class="border1px">
        <tr>
        <td width="40%">
            <input name="cross" type="radio" value="1" checked>  ' . TXT_UCF('CROSS_SELECTION') . ' <br>
            &nbsp; &nbsp; &nbsp; <span style="font-size:smaller;">' . TXT_UCF('CTRL_CLICK_TO_SELECT_MULTIPLE_JOB_PROFILES') . '</span><br>
        <input name="cross" type="radio" value="2"> ' . TXT_UCF('ALL_JOB_PROFILES') . '</td>
        <td width="60%" align="left">
            <select name="function[]" size="10" style="width: 280px;" multiple>';
        $f_q = "select * from functions where customer_id=" . CUSTOMER_ID . " order by function";
        $fDb = MysqlUtils::getData($f_q, true);
        if ($fDb) {
            $i = 1;
            foreach ($fDb as $f) {
                $selected = $i == 1 ? 'selected' : '';
                $html .= '<option value="' . $f[ID_F] . '" ' . $selected . '>' . $f['function'] . '</option>';
                $i++;
            }
        }
        $html .= '</select>
        </td>
        </tr>
        <tr><td colspan="2" align="center"></td></tr>
    </table>

        <input type="submit" id="submitButton" value="' . TXT_BTN('VIEW_BENCHMARKING') . '" class="btn btn_width_150">
                ';
        $top_nav = '<a id="btn_add_profile" href="" onclick="xajax_moduleFunction_addFunction_deprecated(); return false;" title="' . TXT_BTN('ADD_NEW_PROFILE') . '"><img src="' . ICON_ADD . '" class="icon-style" border="0" width="16" height="16"></a>&nbsp;&nbsp;</form>';

        $objResponse->assign('top_nav', 'innerHTML', $top_nav);
        $objResponse->assign('mod_function_right', 'innerHTML', $html);
    }

    return $objResponse;
}


function functions_processSafeForm_selectBenchmark_deprecated($objResponse, $safeFormHandler)
{
    if (PermissionsService::isEditAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {

        $cross = $safeFormHandler->retrieveSafeValue('cross');
        $function = $safeFormHandler->retrieveSafeValue('function');

        // sdj: opvragen ID_Fs uit formulier
        if ($cross == 1) { // TODO: magic number
            $ID_Fs = implode(', ', $function);
        } else {
            $sql = 'SELECT
                        ID_F
                    FROM
                        functions
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                    ORDER BY
                        function';
            $qRes = BaseQueries::performSelectQuery($sql);
            $ID_Fs = implode(', ', MysqlUtils::result2Array($qRes));
        }

        $sql = 'SELECT
                    ID_F,
                    function
                FROM
                    functions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_F IN (' . $ID_Fs . ')
                ORDER BY
                    function';
        $qRes = BaseQueries::performSelectQuery($sql);
        $functions = MysqlUtils::result2Array2D($qRes);

        $num_funs = count($functions);

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_FUNCTIONS__EDIT_BENCHMARK_DEPRECATED);
        $safeFormHandler->addStringArrayInputFormatType('norm_input_val');
        $safeFormHandler->finalizeDataDefinition();

        // sdj: opbouwen html

        $html = '
            <table border="1" cellpadding="3">
                <tr>
                    <td>' . TXT_UC('Y') . '/' . TXT_UC('N') . ' = *</td>
                </tr>
                <tr>
                    <td>1/5 = -</td>
                </tr>
            </table>
            <br /><br /><br />

        <form id="benchmarkForm" name="benchmarkForm"  onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

        $html .= '
        <div>

            <table>
                <tr>
                    <td style="border-width:0px;">&nbsp;</td>
        ';

        // sdj: bovenste tabelrij; functienamen
        foreach ($functions as $function) {

            $function_chars = ModuleUtils::charsForVerticalText($function['function']);
            //$function_chars = str_split($function['function']);
            $html .= '
                    <td width="50px" align="center" style="vertical-align: bottom;"><table><tr><td class="bench_ksptd">' . implode("<br />", $function_chars) . '</td></tr></table></td>
            ';
            /*
            // sdj: div in td om misschien nog mooier effect te kunnen creeëren, maar werkte niet naar wens.
            $html .= '
                    <td><td width=50px class="bench_ksptd"><div class="bench_ksptd2">' . implode("<br />", $function_chars) . '</div></td>
            ';
            */
        }

        $html .= '
                </tr>
        ';

        // sdj: opvragen alle competenties
        // sdj: deze query in toekomst mogelijk aanpassen, om categorie en cluster mee te geven en te gebruiken voor sorteren
        $sql = 'SELECT
                    ksp.ID_KSP,
                    ksp.knowledge_skill_point
                FROM
                    knowledge_skills_points ksp
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    ksp.knowledge_skill_point';
        $qRes = BaseQueries::performSelectQuery($sql);
        $kspArray = MysqlUtils::result2Array2D($qRes);


        $id_fun_ksp = 0;

        // sdj: per competentie een rij maken met competenties en per gekozen functieprofiel de norm
        foreach ($kspArray as $ksp) {
            $html .= '
                <tr onmouseout="this.style.backgroundColor=\'#FFFFFF\'" onmouseover="this.style.backgroundColor=\'#fcf9d2\'" >
                    <td align="right" style="vertical-align: middle;">' . $ksp['knowledge_skill_point'] . '</td>';

            // sdj: normen opvragen voor alle functieprofielen van klant
            $sql = 'SELECT
                        distinct(ksp.scale) as scale_type,
                        ksp.ID_KSP,
                        ksp.knowledge_skill_point,
                        fp.ID_F,
                        fs.function,
                        fp.scale as norm
                    FROM
                        function_points fp
                        INNER JOIN functions fs ON fp.ID_F = fs.ID_F
                        LEFT JOIN knowledge_skills_points ksp
                            ON ksp.ID_KSP = fp.ID_KSP
                WHERE
                    ksp.customer_id= ' . CUSTOMER_ID . '
                    AND fp.ID_KSP = ' . $ksp['ID_KSP'] . '
                ORDER BY
                    fs.function';
            $qRes = BaseQueries::performSelectQuery($sql);
            $normArray = MysqlUtils::result2IndexedArray2D($qRes, 'ID_F');

            // sdj: scaletype opvragen voor gegeven competentie
            $sql = 'SELECT
                        ksp.scale as scale_type,
                        ksp.ID_KSP,
                        ksp.knowledge_skill_point
                    FROM
                        knowledge_skills_points ksp
                    WHERE
                        ksp.customer_id = ' . CUSTOMER_ID . '
                        AND ksp.ID_KSP = ' . $ksp['ID_KSP'];
            $qRes = BaseQueries::performSelectQuery($sql);
            $scaleTypeArray = MysqlUtils::result2Array2D($qRes);


            // sdj: op volgorde van functieprofielen (vastgelegd in $functions) de normen tonen in apparte cellen
            for ($i = 0; $i < $num_funs; $i++) {
                $current_ID_F = $functions[$i][ID_F];

                //if (trim($normArray[$current_ID_F]['scale_type']) == "1-5") {
                // sdj: dit (bovenstaande) is soms NULL, door OUTER JOIN, dus wordt scaleTypeArray gebruikt ...
                if (trim($scaleTypeArray[0]['scale_type']) == ScaleValue::SCALE_1_5) {
                    $norm_val = '-';
                    $scale_type = 1;
                } else {
                    $norm_val = '*';
                    $scale_type = 2;
                }

                if (trim($normArray[$current_ID_F]['norm']) != '') {
                    $norm_val = $normArray[$current_ID_F]['norm'];
                }

                // schaal voor Y/N in juiste taal laten zien
                if ($norm_val == 'Y') {
                    $norm_show = TXT_UC('Y');
                } elseif ($norm_val == 'N') {
                    $norm_show = TXT_UC('N');
                } else { // Anders is het de 1/5 schaal
                    $norm_show = $norm_val;
                }

                $html_cell  = '<input type="text" name="norm_input_val[' . $i . '][]" id="normInput_' . $id_fun_ksp . '" class= "norm_input" maxlength="1" value="' . $norm_show . '"
                                                                            onkeyup="xajax_moduleFunctions_benchmarkingValidate_deprecated(' . $id_fun_ksp . ',' . $scale_type . ', this.value, \'' . $norm_val . '\');"/>';

                $hid_ID_KSP[$i][] = $scaleTypeArray[0]['ID_KSP'];
                $hid_ID_F[$i][] = $current_ID_F;
                $hid_old_norm_val[$i][] = $norm_val;

                $html .= '
                    <td align="center" valign="middle" style="vertical-align: middle;">' . $html_cell . '</td>';

                $id_fun_ksp++;
            }

            $safeFormHandler->storeSafeValue('hid_ID_KSP', $hid_ID_KSP);
            $safeFormHandler->storeSafeValue('hid_ID_F', $hid_ID_F);
            $safeFormHandler->storeSafeValue('hid_old_norm_val', $hid_old_norm_val);

            $safeFormHandler->finalizeDataDefinition();

            $html .= '
                </tr>';

        }

        $html .= '</table>

                <br />
                <br />
                <input type="button" class="btn btn_width_80" value="&laquo; ' . TXT_BTN('BACK') . '" onclick="xajax_moduleFunction_benchmarkingOptions_deprecated();return false;"/>
                <input type="submit" id="submitButton" class="btn btn_width_80" value="' . TXT_BTN('SAVE') . '"/>
        </div>
            </form>
        ';

        $objResponse->assign('mod_function_right', 'innerHTML', $html);
        $objResponse->assign('top_nav', 'innerHTML', '<input type="button" value="Benchmarking" id="btn_benchmarking" class="btn btn_width_150" onclick="xajax_moduleFunction_benchmarkingOptions_deprecated();return false;">
                                                    <input type="button" value="' . TXT_BTN('ADD_NEW_PROFILE') . '" class="btn btn_width_150" onclick="xajax_moduleFunction_addFunction_deprecated();return false;">
                            ');
    }
}

function functions_processSafeForm_editBenchmark_deprecated($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {

        $arrayNormInputVal = $safeFormHandler->retrieveSafeValue('norm_input_val');
        $arrayID_KSP = $safeFormHandler->retrieveSafeValue('hid_ID_KSP');
        $arrayID_F = $safeFormHandler->retrieveSafeValue('hid_ID_F');
        $arrayOld_norm_val = $safeFormHandler->retrieveSafeValue('hid_old_norm_val');

        //die(print_r($arrayNormInputVal, true));

        // TODO: validatie!!
        $hasError = true;
        BaseQueries::startTransaction();

        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        // TODO: $i en $j wegwerken
        $i = 0;
        foreach ($arrayNormInputVal as $value) {
            $j = 0;
            $arrayFunction = $value;

            foreach ($arrayFunction as $norm) {
                // ***IF IT WAS CHANGED***
                $norm = trim($norm);

                // schaal voor Y/N niet als vertaling in de database bewaren
                if (strtoupper($norm) == TXT_UC('Y')) {
                    $norm = 'Y';
                }

                if (strtoupper($norm) == TXT_UC('N')) {
                    $norm = 'N';
                }

                if (trim($arrayOld_norm_val[$i][$j]) != $norm) {
                    $sql = '';

                    if ($norm == '-' || $norm == '*' || $norm == '') {
                        // ***DELETE***

                        $sql = 'DELETE FROM
                                    function_points
                                WHERE
                                    customer_id = ' . CUSTOMER_ID . '
                                    AND ID_KSP = ' . $arrayID_KSP[$i][$j] . '
                                    AND ID_F = ' . $arrayID_F[$i][$j];
                        BaseQueries::performUpdateQuery($sql);
                    } elseif (trim($arrayOld_norm_val[$i][$j]) == '-' || trim($arrayOld_norm_val[$i][$j]) == '*') {
                        // ***INSERT***

                        $sql = 'INSERT INTO
                                    function_points
                                    (   customer_id,
                                        ID_F,
                                        ID_KSP,
                                        scale,
                                        weight_factor,
                                        modified_by_user,
                                        modified_time,
                                        modified_date
                                    ) VALUES (
                                        ' . CUSTOMER_ID . ',
                                        ' . $arrayID_F[$i][$j] . ',
                                        ' . $arrayID_KSP[$i][$j] . ',
                                       "' . mysql_real_escape_string(strtoupper($norm)) . '",
                                        ' . DEFAULT_FUNCTION_WEIGHT . ',
                                       "' . $modified_by_user . '",
                                       "' . $modified_time . '",
                                       "' . $modified_date . '")';
                        BaseQueries::performInsertQuery($sql);
                    } else {
                        // ***UPDATE***

                        $sql = 'UPDATE
                                    function_points
                                SET
                                    scale = "' . mysql_real_escape_string(strtoupper($norm)) . '",
                                    modified_by_user = "' . $modified_by_user . '",
                                    modified_time = "' . $modified_time . '",
                                    modified_date = "' . $modified_date . '"
                                WHERE
                                    customer_id = ' . CUSTOMER_ID . '
                                    AND ID_KSP = ' . $arrayID_KSP[$i][$j] . '
                                    AND ID_F = ' . $arrayID_F[$i][$j];
                        BaseQueries::performUpdateQuery($sql);
                    }
                }

                $j++;
            }

            $i++;
        }
        BaseQueries::finishTransaction();
        $hasError = false;

        $message = TXT_UCF('NORMS_HAVE_BEEN_SAVED');

        //$objResponse->assign("btn_saveBench", "disabled", false);
        $objResponse->call('xajax_moduleFunctions(1)');
    }
    return array($hasError, $message);
}

function moduleFunctions_benchmarkingValidate_deprecated($id, $scale, $entered, $norm_val) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {

        if ($entered != '') {

            if ($scale == 1) {
                if (($entered >= 1 && $entered <= 5)  ||  $entered == "-") {

                } else {
                    $objResponse->alert(TXT_UCF('YOU_CANNOT_ENTER_THE_VALUE') . ' ' . $entered . '. ' . TXT_UCF('PLEASE_ENTER_A_NUMERIC_VALUE_BETWEEN_1_AND_5'));
                    $objResponse->assign('normInput_' . $id, 'value', $norm_val);
                    $objResponse->script('xajax.$("normInput_' . $id . '").focus();');
                }
            } else {
                $entered = strtoupper(trim($entered));
                if ($entered == TXT_UC('Y') || $entered == TXT_UC('N')  ||  $entered == "*") {

                } else {
                    $objResponse->alert(TXT_UCF('YOU_CANNOT_ENTER_THE_VALUE') . ' ' . $entered . '. ' . TXT_UCF('PLEASE_ENTER_A_VALUE_OF_EITHER_Y_OR_N'));
                    $objResponse->assign('normInput_' . $id, 'value', strtoupper($norm_val));
                    $objResponse->script('xajax.$("normInput_' . $id . '").focus();');
                }
            }
        }
    }

    return $objResponse;
}

?>
