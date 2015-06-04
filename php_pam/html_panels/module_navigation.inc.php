
<!-- module_navigation -->
        <div class="nav" id="modules_menu_panel">
            <?php if (isset($user)) { ?>
            <table border="0" align="center" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                        <td class="" style="text-align:center;">
                            <?php echo LANG_ID == 1 ? 'Loading please wait...' : 'Pagina wordt geladen...'; ?>
                        </td>
                </tr>
            </table>
            <?php } else { ?>
            <div class="bottom_border1px">&nbsp;</div>
            <?php } ?>

        </div>
<!-- /module_navigation -->