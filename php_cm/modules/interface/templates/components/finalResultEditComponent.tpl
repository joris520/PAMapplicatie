<!-- finalResultEditComponent.tpl -->
{*scaleType*}
{*inputName*}
{*isEmptyAllowed*}
{*score*}
{if !empty($keepAliveCallback)}
{assign var=onClickFunction value='onClick="'|cat:$keepAliveCallback|cat:';"'}
{/if}
{assign var=scale1 value='FINAL_SCALE_NONE'|constant}
{assign var=scale2 value='FINAL_SCALE_BASIC'|constant}
{assign var=scale3 value='FINAL_SCALE_AVERAGE'|constant}
{assign var=scale4 value='FINAL_SCALE_GOOD'|constant}
{assign var=scale5 value='FINAL_SCALE_SPECIALIST'|constant}
{if !empty($scale1)}
        <input  id="{$inputName}_1" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_1}"  {if $score == ScoreValue::SCORE_1} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_1" title="{ScoreConverter::display(ScoreValue::SCORE_1)}">{ScoreConverter::input(ScoreValue::SCORE_1)}</label>
{/if}
{if !empty($scale2)}
        <input  id="{$inputName}_2" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_2}"  {if $score == ScoreValue::SCORE_2} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_2" title="{ScoreConverter::display(ScoreValue::SCORE_2)}">{ScoreConverter::input(ScoreValue::SCORE_2)}</label>
{/if}
{if !empty($scale3)}
        <input  id="{$inputName}_3" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_3}"  {if $score == ScoreValue::SCORE_3} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_3" title="{ScoreConverter::display(ScoreValue::SCORE_3)}">{ScoreConverter::input(ScoreValue::SCORE_3)}</label>
{/if}
{if !empty($scale4)}
        <input  id="{$inputName}_4" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_4}"  {if $score == ScoreValue::SCORE_4} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_4" title="{ScoreConverter::display(ScoreValue::SCORE_4)}">{ScoreConverter::input(ScoreValue::SCORE_4)}</label>
{/if}
{if !empty($scale5)}
        <input  id="{$inputName}_5" type="radio" name="{$inputName}" value="{ScoreValue::SCORE_5}"  {if $score == ScoreValue::SCORE_5} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_5" title="{ScoreConverter::display(ScoreValue::SCORE_5)}">{ScoreConverter::input(ScoreValue::SCORE_5)}</label>
{/if}
{if $isEmptyAllowed}
        &nbsp;&nbsp;&nbsp;
        <input  id="{$inputName}_na" type="radio" name="{$inputName}" value="{ScoreValue::INPUT_SCORE_NA}" {if $score == ScoreValue::SCORE_NA} checked {/if} {$onClickFunction}>
        <label for="{$inputName}_na">{ScoreConverter::input(ScoreValue::SCORE_NA)}</label>
{/if}
<!-- finalResultEditComponent.tpl -->
