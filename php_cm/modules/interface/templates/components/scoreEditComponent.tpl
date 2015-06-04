<!-- scoreEditComponent.tpl -->
{*scaleType*}
{*inputName*}
{*isEmptyAllowed*}
{*score*}
{if !empty($keepAliveCallback)}
{assign var=onClickFunction value='onClick="'|cat:$keepAliveCallback|cat:';"'}
{/if}
    {if $scaleType == ScaleValue::SCALE_Y_N}
        <input  id="{$inputName}_y" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_Y}"  {if $score == ScoreValue::SCORE_Y} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_y" title="{ScoreConverter::display(ScoreValue::SCORE_Y)}">{ScoreConverter::input(ScoreValue::SCORE_Y)}</label>
        <input  id="{$inputName}_n" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_N}"  {if $score == ScoreValue::SCORE_N} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_n" title="{ScoreConverter::display(ScoreValue::SCORE_N)}">{ScoreConverter::input(ScoreValue::SCORE_N)}</label>
        {if $isEmptyAllowed}
        &nbsp;&nbsp;&nbsp;
        <input  id="{$inputName}_na" type="radio" name="{$inputName}" value="{ScoreValue::INPUT_SCORE_NA}" {if $score == ScoreValue::SCORE_NA} checked {/if}>
        <label for="{$inputName}_na">{ScoreConverter::input(ScoreValue::SCORE_NA)}</label>
        {/if}
    {else}{* ScaleValue::SCALE_1_5 *}
        <input  id="{$inputName}_1" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_1}"  {if $score == ScoreValue::SCORE_1} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_1" title="{ScoreConverter::display(ScoreValue::SCORE_1)}">{ScoreConverter::input(ScoreValue::SCORE_1)}</label>
        <input  id="{$inputName}_2" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_2}"  {if $score == ScoreValue::SCORE_2} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_2" title="{ScoreConverter::display(ScoreValue::SCORE_2)}">{ScoreConverter::input(ScoreValue::SCORE_2)}</label>
        <input  id="{$inputName}_3" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_3}"  {if $score == ScoreValue::SCORE_3} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_3" title="{ScoreConverter::display(ScoreValue::SCORE_3)}">{ScoreConverter::input(ScoreValue::SCORE_3)}</label>
        <input  id="{$inputName}_4" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_4}"  {if $score == ScoreValue::SCORE_4} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_4" title="{ScoreConverter::display(ScoreValue::SCORE_4)}">{ScoreConverter::input(ScoreValue::SCORE_4)}</label>
        <input  id="{$inputName}_5" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_5}"  {if $score == ScoreValue::SCORE_5} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_5" title="{ScoreConverter::display(ScoreValue::SCORE_5)}">{ScoreConverter::input(ScoreValue::SCORE_5)}</label>
        {if $isEmptyAllowed}
        &nbsp;&nbsp;&nbsp;
        <input  id="{$inputName}_na" type="radio" name="{$inputName}" value="{ScoreValue::INPUT_SCORE_NA}" {if $score == ScoreValue::SCORE_NA} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_na">{ScoreConverter::input(ScoreValue::SCORE_NA)}</label>
        {/if}
    {/if}
<!-- scoreEditComponent.tpl -->
