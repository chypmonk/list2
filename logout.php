<?php

session_start(); 
session_unset();
session_destroy();
include ("inc/header.php");
echo "<h2>You are now logged out</h2>";

include ("inc/footer.php");

?>