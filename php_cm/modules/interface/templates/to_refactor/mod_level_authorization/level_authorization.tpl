<!-- level_authorization.tpl -->
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td class="left_panel" style="width:200px; min-width:200px;">
            <div id="scrollDiv">
                <table align="left" width="100%">
                    {foreach $user_levels as $user_level}
                    <tr id='rowLeftNav{$user_level.level_id}'>
                        <td class="divLeftRow bottom_line">
                        <a href="javascript:void(0)" onclick="xajax_moduleLevelAuth_displayAccess({$user_level.level_id}, '{$user_level.level_name}'); selectRow('rowLeftNav{$user_level.level_id}');">{$user_level.level_name}</a>
                        </td>
                    </tr>
                    {/foreach}
                </table>
            </div>
        </td>
        <td align="left" >
            <table cellspacing="0" cellpadding="10" border="0">
                <tr>
                    <td>
                        <div id="div_lev_auth_main">
                            &nbsp;
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- /level_authorization.tpl -->