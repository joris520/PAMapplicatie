<!-- scoreSelectComponent.tpl -->
{*scaleType*}
    {if $scaleType == ScaleValue::SCALE_Y_N}
        <option value="{ScoreValue::SCORE_Y}">{ScoreConverter::display(ScoreValue::SCORE_Y)} - {NormConverter::description(NormValue::NORM_Y)}</option>
        <option value="{ScoreValue::SCORE_N}">{ScoreConverter::display(ScoreValue::SCORE_N)} - {NormConverter::description(NormValue::NORM_N)}</option>
    {else}{* ScaleValue::SCALE_1_5 *}
        <option value="{ScoreValue::SCORE_1}">{ScoreConverter::display(ScoreValue::SCORE_1)} - {NormConverter::description(NormValue::NORM_1)}</option>
        <option value="{ScoreValue::SCORE_2}">{ScoreConverter::display(ScoreValue::SCORE_2)} - {NormConverter::description(NormValue::NORM_2)}</option>
        <option value="{ScoreValue::SCORE_3}">{ScoreConverter::display(ScoreValue::SCORE_3)} - {NormConverter::description(NormValue::NORM_3)}</option>
        <option value="{ScoreValue::SCORE_4}">{ScoreConverter::display(ScoreValue::SCORE_4)} - {NormConverter::description(NormValue::NORM_4)}</option>
        <option value="{ScoreValue::SCORE_5}">{ScoreConverter::display(ScoreValue::SCORE_5)} - {NormConverter::description(NormValue::NORM_5)}</option>
    {/if}
<!-- scoreSelectComponent.tpl -->
