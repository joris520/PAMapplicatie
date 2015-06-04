{*
    $module_tabs_cat
    $spread
    $label_0
    $label_1
    $label_2
*}
<!-- displayCategoryTabAccess.tpl -->
            {assign var=allow_empty_line value=false}
            {assign var=iterationCount value=0}
            <td width="600">
            {foreach $module_tabs_cat as $tabLabel => $tabMenu}
                {if $allow_empty_line == true}
                <br />
                {/if}
                <h3 class="in-cell">{$tabLabel}</h3>
                {foreach $tabMenu as $tab}
                    {assign var='allow_empty_line' value=true}
                    {if $level_id > $tab.max_user_level_edit AND $level_id > $tab.max_user_level_view}
                    {assign var='allowed' value='disabled="disabled"'}
                    {else}
                    {assign var='allowed' value=''}
                    {/if}
                    <div style="margin:5px;">
                        <select name="sel_priv[]" style="width:80px;" {$allowed}>
                            <option value="0" {if $tab.privilege == 0}selected="selected"{/if}>{$label_0}</option>
                            {if $level_id <= $tab.max_user_level_view}
                            <option value="1" {if $tab.privilege == 1}selected="selected"{/if}>{$label_1}</option>
                            {/if}
                            {if $level_id <= $tab.max_user_level_edit}
                            <option value="2" {if $tab.privilege == 2}selected="selected"{/if}>{$label_2}</option>
                            {/if}
                            {if $level_id <= $tab.max_user_level_add_delete}
                            <option value="3" {if $tab.privilege == 3}selected="selected"{/if}>{$label_3}</option>
                            {/if}
                        </select>
                        {if $allowed == ''}<input type="hidden" name="id[]" value="{$tab.id}"/>{/if}
                        {*$tab.tab_menu_label|ucfirst*}{$tab.word_label|TXT_UCF}<br />
                    </div>
                    {if $spread == 1}
                        {assign var=iterationCount value=$iterationCount+1}
                        {if $iterationCount == (1/3 * $tabModuleCount)|ceil ||
                            $iterationCount == (2/3 * $tabModuleCount)|ceil}
                        {assign var='allowempty_line' value=false}
                        </td>
                        <td width="600">
                        {/if}
                    {/if}
                {/foreach}
            {/foreach}
            </td>
<!-- /displayCategoryTabAccess.tpl -->