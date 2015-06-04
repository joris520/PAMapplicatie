        <div id="mainframe">
            <div id="header_left" style="margin-top:10px; margin-left:10px;"> <?php echo getHeaderLogo(); ?></div>
            <div id="header_right">
                <?php if (!isset($user)) { ?>
                <div id="gino">
                    <div id="gino_right"><img src="images/logo/ginologo.jpg" /><br />Gino employability suite&nbsp;</div>
                </div>
                <?php } ?>
            <?php if (isset($user)) { ?>
                <div id="application_menu_panel"></div>
            <?php } ?>
            </div>
            <div id="global_loading"><img src="images/bload.gif" /></div>
        </div> <!-- /mainframe -->
