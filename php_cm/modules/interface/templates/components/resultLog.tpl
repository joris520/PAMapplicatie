{* smarty *}
<!-- resultLog.tpl -->
{* title/headline text *}
<p>{$title}</p>

{* top table/div code *}
<table style="width:{}">
    <tr>
        <td>

            {$resultTxt}

            {* $content *}

            <ul>
                {foreach $result as $result_item}
                <li>{$result_item}</li>
                {/foreach}
            </ul>


{* bottom table/div code *}
        </td>
    </tr>
</table>
<!-- /resultLog.tpl -->