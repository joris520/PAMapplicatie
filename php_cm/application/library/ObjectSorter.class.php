<?php

/**
 * Description of ObjectSorter
 *
 * @author ben.dokter
 */

class ObjectSorter
{
    const INSERT_ORDER  = 1;
    const KEY_ORDER     = 2;

    private $sortMode;
    private $sortKeys;
    private $sortedObjects;

    static function create($sortMode = self::INSERT_ORDER)
    {
        return new ObjectSorter($sortMode);
    }

    function __construct($sortMode)
    {
        $this->sortMode = $sortMode;

        $this->sortKeys = array();
        $this->sortedObjects = array();
    }

    // voeg de keys toe in de volgorde waarin de uiteindelijke lijst "gesorteerd" moet worden
    function addSortKey($sortKey)
    {
        $this->sortKeys[] = $sortKey;
        if ($this->sortMode == self::KEY_ORDER) {
            $this->sortedObjects[$sortKey] = array();
        }
    }

    function addSortObject($sortKey, $insertObject)
    {
        // per key de objecten verzamelen in insert volgorde
        if ($this->sortMode == self::KEY_ORDER) {
            $this->sortedObjects[$sortKey][] = $insertObject;
        } else {
            // gewoon in insert volgorde
            $this->sortedObjects[] = $insertObject;
        }
    }

    function getSortedObjects()
    {
        $sortedObjects = array();

        if ($this->sortMode == self::KEY_ORDER) {
            foreach((array)$this->sortKeys as $sortKey) {
                foreach((array)$this->sortedObjects[$sortKey] as $sortedObject) {
                    $sortedObjects[] = $sortedObject;
                }
            }
        } else {
            // gewoon in insert volgorde teruggeven
            $sortedObjects = $this->sortedObjects;
        }

        return $sortedObjects;
    }

}

?>
