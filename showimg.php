<?php

	$file = $_GET['thefile'];
	
	if (!is_file($file) || !file_exists($file)){
		exit;
	}

	echo $file;
?>

