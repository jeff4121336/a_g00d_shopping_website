<?php

    function csrf_getNonce($action) {
// 	session_start();    	  
 	$nonce = mt_rand() . mt_rand();
        if (!isset($_SESSION['csrf_nonce']))
            $_SESSION['csrf_nonce'] = array();
        $_SESSION['csrf_nonce'][$action] = $nonce;
        return $nonce;
    }

    function csrt_verifyNonce($action, $receivedNonce) {
        if (isset($receivedNonce) && $_SESSION['csrf_nonce'][$action] == $receivedNonce) {
            unset($_SESSION['csrf_nonce'][$action]);
	    return true;
        }
        throw new Exception('csrf-attack');
    }
?>    
