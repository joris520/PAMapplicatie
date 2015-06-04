<?php

//////// mostly deprecated

require_once('modules/model/service/to_refactor/EmployeeProfileServiceDeprecated.class.php');
require_once('modules/model/service/to_refactor/EmployeeScoresService.class.php');
require_once('modules/model/queries/threesixty/ThreesixtyQueries.class.php');
require_once('application/library/PamValidators.class.php');

// converters includen wanneer ze een ModuleUtils functie vervangen
require_once('modules/interface/converter/library/competence/CategoryConverter.class.php');
require_once('application/interface/converter/UserLevelConverter.class.php');

class ModuleUtils
{

    static function createUniqueHash($destination_table)
    {
        $multiply = 1;
        $return_hash = false;
        while (!$return_hash) {
            $hash = md5(time()*$multiply);
            $hashResult = AlertsService::checkHashExistence($hash, $destination_table);
            if (@mysql_num_rows($hashResult) == 0 && ModuleUtils::IsMd5HashValidFormat($hash)) {
                $return_hash = true;
            }
            $multiply++;
        }

        return $hash;
    }

    static function generateAccessList($level_id_hr, $level_id_mgr, $level_id_emp_edit, $inline = true)
    {
        $list = array();

        if (!empty($level_id_hr)) {
            $list[] = UserLevelConverter::display($level_id_hr);
        }

        if (!empty($level_id_mgr)) {
            $list[] = UserLevelConverter::display($level_id_mgr);
        }

        if (!empty($level_id_emp_edit)) {
            $list[] = UserLevelConverter::display($level_id_emp_edit, false);
        }

        return $inline ? implode (', ', $list) : implode (',<br/>', $list);
    }

    static function getUserLevelList() {
        return array(UserLevelValue::CUSTOMER_ADMIN, UserLevelValue::HR, UserLevelValue::MANAGER,
                     UserLevelValue::EMPLOYEE_EDIT, UserLevelValue::EMPLOYEE_VIEW);
    }

    /**
     *
     * De scores omzetten naar een tekst in de juiste taal
     * @param <type> $score_point
     */
    static function ScorepointTextDescription($score_point, $scale_description, $empty_score_string = '-')
    {
        $score_point_text = $empty_score_string;
        if (!empty($score_point)) {
            if (CUSTOMER_OPTION_SHOW_SCORE_AS_NORM_TEXT) {
                $score_point_text = $scale_description;
            } else {
                $score_point_text = ModuleUtils::ScorepointText($score_point, $empty_score_string);
            }
        }
        return $score_point_text;
    }

    static function ScorepointTextDescriptionNew($score_point, $empty_score_string = '-')
    {
        $score_point_text = $empty_score_string;
        if (!empty($score_point)) {
            if (CUSTOMER_OPTION_SHOW_SCORE_AS_NORM_TEXT) {
                $score_point_text = ModuleUtils::ScoreDescription($score_point);
            } else {
                $score_point_text = ModuleUtils::ScorepointText($score_point, $empty_score_string);
            }
        }
        return $score_point_text;
    }

    static function ScoreDescription($score)
    {
        $description = '';

        switch ($score) {
            case '1':
                $description = SCALE_NONE;
                break;
            case '2':
                $description = SCALE_BASIC;
                break;
            case '3':
                $description = SCALE_AVERAGE;
                break;
            case '4':
                $description = SCALE_GOOD;
                break;
            case '5':
                $description = SCALE_SPECIALIST;
                break;
            case 'N':
                $description = SCALE_NO;
                break;
            case 'Y':
                $description = SCALE_YES;
                break;
        }

        return $description;
    }

    static function ScorepointText($score_point, $empty_score_string = '-')
    {
        $score_point_text = $empty_score_string;
        if (!empty($score_point)) {
            if ($score_point == 'Y') {
                $score_point_text = TXT_UCF('YES'); //121
            } elseif ($score_point == 'N') {
                $score_point_text = TXT_UCF('NO'); //122
            } else {
                if ($score_point >= 1 && $score_point <=5) {
                    $score_point_text = $score_point;
                } else {
//                    if ($score_point == 0) {
//                        $score_point_text = TXT('NA');
//                    }
                }
            }
        }
        return $score_point_text;
    }

    static function ScorepointLetter($score_point, $empty_score_string = '-')
    {
        $score_point_text = ModuleUtils::ScorepointText($score_point, $empty_score_string);
        return substr($score_point_text, 0, 1);
    }

    static function ScoreNormText($score_norm, $empty_norm_string = '-')
    {
        return ModuleUtils::ScorepointText($score_norm, $score_norm, $empty_norm_string);
    }

    static function ScoreNormTextDescription($score_norm, $scale_description, $empty_norm_string = '-')
    {
        return ModuleUtils::ScorePointTextDescription($score_norm, $scale_description, $empty_norm_string);
    }

    static function ScoreNormLetter($score_norm, $empty_norm_string = '-')
    {
        $score_norm_text = ModuleUtils::ScoreNormText($score_norm, $empty_norm_string);
        return substr($score_norm_text, 0, 1);
    }


    static function ScaleText($scale_value, $empty_scale_string = '')
    {
        $scale_text = $empty_scale_string;
        if ($scale_value == 'Y') {
            $scale_text = '' . SCALE_YES . '';
        } elseif ($scale_value == 'N') {
            $scale_text = '' . SCALE_NO . '';
        } elseif ($scale_value == '1') {
            $scale_text = '' . SCALE_NONE . '';
        } elseif ($scale_value == '2') {
            $scale_text = '' . SCALE_BASIC . '';
        } elseif ($scale_value == '3') {
            $scale_text = '' . SCALE_AVERAGE . '';
        } elseif ($scale_value == '4') {
            $scale_text = '' . SCALE_GOOD . '';
        } elseif ($scale_value == '5') {
            $scale_text = '' . SCALE_SPECIALIST . '';
        }
        return $scale_text;
    }

    // 1-5 of Y/N
    static function SkillNormText($norm_value)
    {
        $norm_text = $norm_value;
        if ($norm_value == ScaleValue::SCALE_Y_N) {
            $norm_text = TXT('Y_N');
        }
        return $norm_text;
    }
    /**
     *
     * Om loze ',' te voorkomen kan deze functie helpen
     * @param <type> $first_name
     * @param <type> $last_name
     * @return string
     */
    static function EmployeeName($first_name, $last_name, $formatMode = EMPLOYEENAME_FORMAT_LASTNAME_FIRST)
    {
        return EmployeeProfileServiceDeprecated::formatEmployeeName($first_name, $last_name, $formatMode);
    }

    static function ExternalName($first_name, $last_name)
    {
        if(empty($last_name)) {
            return $first_name;
        }
        else {
            if(empty($first_name)) {
                return $last_name;
            }
            else {
                return $last_name . ", " . $first_name;
            }
        }
    }

    static function EmailName($first_name, $last_name, $email_address, $email_cluster = 1)
    {
        $result_email = '';
        if (empty($last_name)) {
            if(empty($first_name)) {
                $result_email = $email_address;
            } else {
                $result_email = $first_name . " &nbsp; &nbsp; (" . $email_address . ")" ;
            }
        } else {
            if(empty($first_name)) {
                $result_email = $last_name . " &nbsp; &nbsp; (" . $email_address . ")" ;
            } else {
                $result_email = $last_name . ", " . $first_name . " &nbsp; &nbsp; (" . $email_address . ")" ;
            }
        }
        if ($email_cluster == 2) {
            $result_email = '* '.$result_email;
        }
        return $result_email;
    }

    static function GenderText($sexe_value)
    {
        return TXT_UCF(strtoupper($sexe_value));
    }

    static function IsBossText($isBoss)
    {
        return $isBoss == 1 ? TXT_UCF('YES') : TXT_UCF('NO');
    }

    static function LabelText($label)
    {
        return TXT_UCF($label);
    }

    static function FTEText($fte)
    {
        return NumberUtils::convertFloat($fte, LANG_ID);
    }

    static function RatingText($rating)
    {
        EmployeeScoresService::getRatingText($rating);
    }

    static function ArrayAsText($array, $seperator, $emptyText = '-')
    {
        return empty($array) ? $emptyText : implode($seperator, $array);
    }

    // TODO: naar de toekomstige "NormService"
    static function DefineScales($customer_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    scale
                WHERE
                    customer_id = ' . $customer_id;
        $scaleQuery = BaseQueries::performQuery($sql);

        while ($scale = @mysql_fetch_assoc($scaleQuery)) {
            switch ($scale['scale_id']) {
                case 1:
                    define('SCALE_NONE',        $scale['description']);
                    define('FINAL_SCALE_NONE',  $scale['total_score_description']);
                    break;
                case 2:
                    define('SCALE_BASIC',       $scale['description']);
                    define('FINAL_SCALE_BASIC', $scale['total_score_description']);
                    break;
                case 3:
                    define('SCALE_AVERAGE',         $scale['description']);
                    define('FINAL_SCALE_AVERAGE',   $scale['total_score_description']);
                    break;
                case 4:
                    define('SCALE_GOOD',        $scale['description']);
                    define('FINAL_SCALE_GOOD',  $scale['total_score_description']);
                    break;
                case 5:
                    define('SCALE_SPECIALIST',          $scale['description']);
                    define('FINAL_SCALE_SPECIALIST',    $scale['total_score_description']);
                    break;
                case 6:
                    define('SCALE_NO',          $scale['description']);
                    define('FINAL_SCALE_NO',    $scale['total_score_description']);
                    break;
                case 7:
                    define('SCALE_YES',         $scale['description']);
                    define('FINAL_SCALE_YES',   $scale['total_score_description']);
                    break;
            }
        }
    }

    // TODO: naar de toekomstige "NormService"
    static function getTotalScoreScaleIdValues($customer_id)
    {
        $totalScoreScaleIdValues = array();

        $sql = 'SELECT
                    *
                FROM
                    scale
                WHERE
                    customer_id = ' . $customer_id . '
                ORDER BY
                    scale_id';
        $scaleQuery = BaseQueries::performQuery($sql);

        while ($scale = @mysql_fetch_assoc($scaleQuery)) {
            $scaleId = $scale['scale_id'];
            $totalScoreDescription = $scale['total_score_description'];
            if (!empty($totalScoreDescription)) {
                $totalScoreScaleIdValues[] = IdValue::create($scaleId, $totalScoreDescription);
            }
        }
        return $totalScoreScaleIdValues;
    }

    static function Abbreviate($text_value, $trim_len, $abbr = '...')
    {
        $trimmed = trim($text_value);
        if (strlen($trimmed) > $trim_len) {
            $trimmed = substr($trimmed, 0, $trim_len) . $abbr;
        }
        return $trimmed;
    }

    static function IsEmailAddressValidFormat($email_address) {
        return PamValidators::IsEmailAddressValidFormat($email_address);
    }

    static function IsMd5HashValidFormat($md5_hash) {
        return PamValidators::IsMd5HashValidFormat($md5_hash);
    }



    /**
     * functie om het gemiddelde van de 360 evaluaties voor de opgegeven ksp te bepalen
     * Bij Y/N is 1,2 -> N, 3,4,5 -> Y
     * @param <type> $employee_id
     * @param <type> $ksp_id
     * @param <type> $ksp_scale
     * @return <type>
     */
    static function score360($employee_id, $ksp_id, $ksp_scale, $use_self_evaluation, $show_only_if_final, $showAsText = true)
    {
        $return_score = '';
        $return_note = '';

        $total_score = 0;
        $te_score_count = 0;

        //FROM 360 EVALUATION FORM
        $competence360ScoreResult = ThreesixtyQueries::getCompetence360Score($employee_id, $ksp_id, $use_self_evaluation, $show_only_if_final);
        if (@mysql_num_rows($competence360ScoreResult) > 0) {
            $total_score = 0;
            $te_score_count = 0;

            while ($te_r = @mysql_fetch_assoc($competence360ScoreResult)) {
                $te_score = $te_r['threesixty_score'];
                $return_note = $te_r['notes'];
                if ($te_score == ScoreValue::SCORE_Y) { // TODO: wat te doen met Y/N
                    $te_score = ScoreValue::SCORE_5;
                } elseif ($te_score == ScoreValue::SCORE_N) {
                    $te_score = ScoreValue::SCORE_1;
                } elseif ($te_score < ScoreValue::MIN_NUM_SCORE || $te_score > ScoreValue::MAX_NUM_SCORE) {
                        unset($te_score);
                }

                if (!empty($te_score)) {
                    $total_score += $te_score;
                    $te_score_count++;
                }
            }
            //$te_score = $t;
        }

        if ($te_score_count > 0) {
            $te_score = floor($total_score / $te_score_count);

            $te_score = moduleUtils::averageYN($te_score, $ksp_scale);
            // wel even vertalen
            if ($showAsText) {
                $return_score = ModuleUtils::ScorepointTextDescription($te_score, ModuleUtils::ScoreDescription($te_score));
            } else {
                $return_score = ModuleUtils::ScorepointText($te_score);
            }
        }
        return array($return_score, $return_note);
    }

    static function averageYN($score, $scale)
    {
        $yn = $score;
        if ($scale == ScaleValue::SCALE_Y_N) {
            if ($score >= 3) {
                $yn = ScoreValue::SCORE_Y;
            } else {
                $yn = ScoreValue::SCORE_N;
            }
        }
        return $yn;
    }

    static function ForceLogout()
    {
        $_SESSION = array();
        session_destroy();
        // hbd: aanmaken nieuwe sessieid
        session_start();
        session_regenerate_id(true);
    }

    static function BossName($firstname, $lastname) {
        return EmployeeProfileServiceDeprecated::formatBossName($firstname, $lastname);
    }

    static function isValidLogin() {
        return USER_ID >= 0 && CUSTOMER_ID > 0 &&
            in_array(USER_LEVEL, ModuleUtils::getUserLevelList());
    }

    // TODO: naar pamApplication
    static function getCustomerLogoPath($customer_id)
    {
        return ModuleUtils::createPath(array(APPLICATION_LOGO_BASE_DIR . 'c' . $customer_id));
    }

    // hbd: variant op de gevonden: http://www.php.net/manual/en/function.str-split.php#107658
    // geeft de losse unicode chars in hoofdletters terug
    static function charsForVerticalText($str)
    {
        return preg_split("//u", mb_strtoupper($str), -1, PREG_SPLIT_NO_EMPTY);
    }

    // TODO: naar pamApplication
    static function getCustomerPhotoPath($customer_id)
    {
        return ModuleUtils::createPath(array(APPLICATION_UPLOADS_BASE_DIR . 'c' . $customer_id));
    }

    // TODO: naar pamApplication
    static function getCustomerAttachmentPath($customer_id)
    {
        return ModuleUtils::createPath(array(APPLICATION_UPLOADS_BASE_DIR . 'c' . $customer_id));
    }

    // TODO: naar pamApplication
    static function getCustomerTempUrl()
    {
        $customer_temp = SITE_URL . DIRECTORY_TEMP . CUSTOMER_FOLDER . '/';
        return $customer_temp;
    }

    // TODO: naar pamApplication
    static function getCustomerTempPath()
    {
        $customer_temp_dir = ModuleUtils::createPath(array(PAM_BASE_DIR . 'pam-public', DIRECTORY_TEMP . CUSTOMER_FOLDER));
        if (!file_exists($customer_temp_dir)) {
            mkdir($customer_temp_dir, DIRECTORY_ACCESS_SETTINGS);
        }
        return $customer_temp_dir;
    }


    // TODO: naar pamApplication
    static function getTempPath() //ForCustomerId($customer_id)
    {
        return ModuleUtils::createPath(array(PAM_BASE_DIR . 'pam-public', DIRECTORY_TEMP));
    }

    // TODO: filteren op alleen jpg en png.
    // kan nu nog niet omdat er nog userdata in kan komen die niet gejpeged of als png is aangemaakt.
    function emptyTempDir()
    {
        $dir = ModuleUtils::getCustomerTempPath();
        if ($handle = opendir($dir)) {

            while ($obj = readdir($handle)) {
                if ($obj != '.' && $obj != '..') {
                    if (!is_dir($obj)) {
                        unlink($dir . $obj);
                    }
                }
            }
            closedir($handle);
            return true;
        }

        return true;
    }

    static function createPath($parts)
    {
        $path = '';
        foreach((array)$parts as $part) {
            $path .= $part . DIRECTORY_SEPARATOR;
        }
        return $path;
    }

    // $s_ksp_scale is de schaal uit knowledge_skill_points.scale
    static function isScoreValid ($s_score, $s_ksp_scale)
    {
        $isScoreValid = false;

        switch ($s_ksp_scale) {
            case ScaleValue::SCALE_1_5:
                if (is_numeric($s_score)) {
                    $i_score = intval($s_score);
                    $isScoreValid = ($i_score >= 1 && $i_score <= 5);
                }

                break;
            case ScaleValue::SCALE_Y_N:
                $score_uc = strtoupper($s_score);
                $isScoreValid = $score_uc == 'Y' || $score_uc == 'N';
                break;
        }

        if (strtoupper($s_score) == 'NA') {
            $isScoreValid = true;
        }

        return $isScoreValid;
    }

    static function filterHTMLTags ($s_string) {
        return htmlspecialchars($s_string, ENT_COMPAT, 'UTF-8');
    }

}
?>
