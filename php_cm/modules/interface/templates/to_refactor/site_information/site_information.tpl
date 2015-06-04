{* smarty *}
{if $language_id == LanguageValue::LANG_ID_EN}
    <div class="font_s18">
        <strong>Welcome To <span class="indicator">{'SITE_TITLE'|constant}</span></strong>
    </div>
    {'SITE_TITLE'|constant} is a dynamic competence and performance management system enabling both managers and employees to evaluate and analyse mutual expectations and to monitor and follow-up on agreed improvement actions. <br />
    {'SITE_TITLE'|constant} is a standalone application of Gino's employability suite.<br /><br />
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
{else}
    <div class="font_s18">
        <strong>Welkom bij <span class="indicator">{'SITE_TITLE'|constant}</span></strong>
    </div>
    {'SITE_TITLE'|constant} is een dynamisch competentie- en personeelsmanagementsysteem dat zowel   managers als medewerkers in staat stelt om hun wederzijdse verwachtingen te   evalueren en te analyseren. Daarnaast kunnen ze voortgangsafspraken monitoren en opvolgen.<br />
    {'SITE_TITLE'|constant} is een zelfstandig te gebruiken onderdeel van Gino's employability suite.<br /><br />
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
{/if}