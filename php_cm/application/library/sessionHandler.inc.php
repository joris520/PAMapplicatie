<?php

/**
 * 	session handeling
 */

ini_set('session.gc_maxlifetime', 3600); // 1 uur

ini_set('session.gc_probability', 100); // sdj: 1/10000 als probability is met de vele XAJAX aanroepen (en check sessions) waarschijnlijk vaak genoeg
ini_set('session.gc_divisor', 100);

ini_set('session.cookie_lifetime', ini_get('session.gc_maxlifetime')); // gelijk aan garbage collection setting, voor automatisch uitloggen.

session_start();

?>