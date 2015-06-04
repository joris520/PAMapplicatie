<?php

/**
 * Description of BossFilterValue
 *
 * @author ben.dokter
 */
require_once('application/model/value/BaseValue.class.php');
require_once('modules/interface/state/BossFilterState.class.php');

class BossFilterValue extends BaseValue
{
    const MODE_DISPLAY = 1;
    const MODE_REPORT  = 2;

    // mode
    const HAS_NO_BOSS   = 'no_boss';
    const IS_BOSS       = 'is_boss';
    const ALL           = 'all';

    static function values($mode = self::MODE_DISPLAY)
    {
        switch($mode) {
            case self::MODE_REPORT:
                $values =   array(
                                self::HAS_NO_BOSS,
                                self::IS_BOSS,
                                self::ALL
                            );
                break;
            case self::MODE_REPORT:
            default:
                $values =   array(
                                self::HAS_NO_BOSS,
                                self::IS_BOSS
                            );
                break;
        }

        return $values;
    }

    static function isValidValue($value, $mode = self::MODE_DISPLAY)
    {
        return is_numeric($value) ||
               self::isAllowedValue($value, self::values($mode), BaseDatabaseValue::VALUE_OPTIONAL);
    }

    static function explainValue($value)
    {
        $selectedBossId  = NULL;
        $selectHasNoBoss = false;
        $selectIsBoss    = false;
        $bossFilterState = BossFilterState::NONE_SELECTED;

        if ($value == BossFilterValue::HAS_NO_BOSS) {
            $selectHasNoBoss = true;
            $bossFilterState = BossFilterState::HAS_NO_BOSS_SELECTED;
        } elseif ($value == BossFilterValue::IS_BOSS) {
            $selectIsBoss = true;
            $bossFilterState = BossFilterState::IS_BOSS_SELECTED;
        } else {
            if (!empty($value) && is_numeric($value)) {
                $selectedBossId = intval($value);
                $bossFilterState = BossFilterState::BOSSID_SELECTED;
            }
        }
        return array($selectIsBoss, $selectHasNoBoss, $selectedBossId, $bossFilterState);
    }
}

?>
