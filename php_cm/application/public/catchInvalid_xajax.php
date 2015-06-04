<?php

function moduleApplication_catchInvalidFunctionCalls()
{
    $objResponse = new xajaxResponse();

    // TODO: uitzondering maken voor moduleLogin_logOut
    PamApplication::hasValidSession($objResponse);

    return $objResponse;
}

//function moduleApplication_beforeXajaxFunction(&$callnext) {
//    // set callnext to false in order to skip the further request processing
//    $callnext = array(false);
//}

?>
