<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:01:03
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\to_refactor/site_information/site_information.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3185557013cfef6ce7-99391902%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ce55b6a666c974a73022e869ac9989d2261bfd4d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\to_refactor/site_information/site_information.tpl',
      1 => 1433407470,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3185557013cfef6ce7-99391902',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<?php if ($_smarty_tpl->getVariable('language_id')->value==LanguageValue::LANG_ID_EN){?>
    <div class="font_s18">
        <strong>Welcome To <span class="indicator"><?php echo constant('SITE_TITLE');?>
</span></strong>
    </div>
    <?php echo constant('SITE_TITLE');?>
 is a dynamic competence and performance management system enabling both managers and employees to evaluate and analyse mutual expectations and to monitor and follow-up on agreed improvement actions. <br />
    <?php echo constant('SITE_TITLE');?>
 is a standalone application of Gino's employability suite.<br /><br />
    <table width="369" border="0" cellspacing="0" cellpadding="0" style="color:#656565;">
        <tr>
            <td colspan="3"><strong>Some important functionalities include :</strong></td>
        </tr>
        <tr>
            <td width="18" rowspan="4">&nbsp;</td>
            <td width="193">&bull; Competence dictionary</td>
            <td width="158">&bull; Evaluation forms</td>
        </tr>
        <tr>
            <td>&bull; Competence profiles</td>
            <td>&bull; GAP analysis</td>
        </tr>
        <tr>
            <td>&bull; Personal development plans</td>
            <td>&bull; Email alerts</td>
        </tr>
        <tr>
            <td>&bull; Personal target summaries</td>
            <td>&bull; 360&deg; feedback options</td>
        </tr>
    </table>
    <br />
    <!--<a href="#" class="activated">&bull; Online support</a> <br />-->
    &bull; Visit our websites <a href="http://www.pampeople.com" target="_blank" class="activated">www.pampeople.com</a> and  <a href="http://www.gino.nl" target="_blank" class="activated">www.gino.nl</a><br/>
<?php }else{ ?>
    <div class="font_s18">
        <strong>Welkom bij <span class="indicator"><?php echo constant('SITE_TITLE');?>
</span></strong>
    </div>
    <?php echo constant('SITE_TITLE');?>
 is een dynamisch competentie- en personeelsmanagementsysteem dat zowel   managers als medewerkers in staat stelt om hun wederzijdse verwachtingen te   evalueren en te analyseren. Daarnaast kunnen ze voortgangsafspraken monitoren en opvolgen.<br />
    <?php echo constant('SITE_TITLE');?>
 is een zelfstandig te gebruiken onderdeel van Gino's employability suite.<br /><br />
    <table width="369" border="0" cellspacing="0" cellpadding="0" style="color:#656565;">
        <tr>
            <td colspan="3"><strong>Tot de belangrijkste functionaliteiten behoren: </strong></td>
        </tr>
        <tr>
            <td width="18" rowspan="4">&nbsp;</td>
            <td width="207">&bull; Competentiewoordenboek</td>
            <td width="144">&bull; Evaluatieformulieren</td>
        </tr>
        <tr>
            <td>&bull; Functieprofielen</td>
            <td>&bull; Sterkte-zwakte analyses</td>
        </tr>
        <tr>
            <td>&bull; Persoonlijke ontwikkelingsplannen</td>
            <td>&bull; E-mail ondersteuning</td>
        </tr>
        <tr>
            <td>&bull; Opleidingskosten registratie</td>
            <td>&bull; 360 graden feedback</td>
        </tr>
    </table>
    <br />
    <!--<a href="#">&bull; Online support</a> <br />-->
    &bull; Bezoek onze websites <a href="http://www.pampeople.nl" target="_blank" class="activated">www.pampeople.nl</a> en <a href="http://www.gino.nl" target="_blank" class="activated">www.gino.nl</a><br />
<?php }?>