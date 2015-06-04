

<!-- module_content -->
        <div id="body">
<?php
        if ($_GET['lang'] == 'en') {
            include_once('html_panels/login/eng_login_fns.php');
        } else {
            include_once('html_panels/login/dutch_login_fns.php');
        }

        if ( PAM_DISABLED || !isset($user)) {
            login_form();
        } else {
?>
            <div id="content">
                <div id="module_main_panel"></div>
            </div>

<?php   } ?>

        </div><!-- body -->
<!-- /module_content -->
