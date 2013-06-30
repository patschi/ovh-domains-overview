<?php

// Check for exiting config file, otherwise die and output error message.
if(!file_exists("./inc/config.php")) {
	die("Missing config file! Edit <i>inc/config.sample.php</i> to your needs and rename it to <i>inc/config.inc.php</i>.");
}

// Include required php files
include("./inc/config.php");
include("./inc/functions.php");

// Create cache file if it does not exist
if(!file_exists("./inc/cache.txt")) {
	file_put_contents("./inc/cache.txt", "");
	@chmod(0777, "./inc/cache.txt");
}

// Refresh cache if cache file is empty
if(file_get_contents("./inc/cache.txt") == "") {
	refresh();
}

?>