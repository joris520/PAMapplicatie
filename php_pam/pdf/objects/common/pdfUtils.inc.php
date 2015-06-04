<?php
/**
 * PdfUtils bevat static functies, dus aanroepen met PdfUtils::functienaam();
 */
class PdfUtils
{
    // fpdf werkt alleen met ISO-8859-1, dus teksten converteren...
    static function fpdfSafe($text)
    {
        if (!empty($text)) $text = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text);
        return $text;
    }

    static function hex2dec($couleur = "#000000") {
        $R = substr($couleur, 1, 2);
        $rouge = hexdec($R);
        $V = substr($couleur, 3, 2);
        $vert = hexdec($V);
        $B = substr($couleur, 5, 2);
        $bleu = hexdec($B);
        $tbl_couleur = array();
        $tbl_couleur['R'] = $rouge;
        $tbl_couleur['G'] = $vert;
        $tbl_couleur['B'] = $bleu;
        return $tbl_couleur;
    }

    static function getData($sql, $return = true) {
        $query = BaseQueries::performQuery($sql);
        if (@mysql_num_rows($query) != 0) {
            $row = mysql_fetch_assoc($query);
            $variable = '';
            $keys = array_keys($row);

            for ($i2 = 0; $i2 < count($keys); $i2++) {
                $variable .= '$array[$i][\'' . $keys[$i2] . '\'] = $row[\'' . $keys[$i2] . '\'];';
            }
            mysql_data_seek($query, 0);
            $i = 0;

            while ($row = mysql_fetch_assoc($query)) {
                eval($variable);
                $i++;
            }
            if ($return == true) {
                return $array;
            } else {

                echo "<pre>";
                print_r($array);
                echo "</pre>";
            }
        }
        return false;
    }

}
?>
