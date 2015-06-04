<?php

/**
 * Description of AssessmentIconView
 *
 * @author ben.dokter
 */

class AssessmentIconView
{
    private $iconFile;
    private $title;

    static function create($iconFile, $title)
    {
        return new AssessmentIconView($iconFile, $title);
    }

    protected function __construct($iconFile, $title)
    {
        $this->iconFile = $iconFile;
        $this->title = $title;
    }

    function fetchHtml()
    {
        return '<img title="' . $this->title . '" class="icon-style-small" src="' . $this->iconFile . '" border="0" width="13" height="13" />';
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getIconFile()
    {
        return $this->iconFile;
    }

    function getTitle()
    {
        return $this->title;
    }
}

?>
