<?php

	$shmop_read_id = shmop_open(5, 'w', 0644, 50);

	$shmop_read = shmop_read($shmop_read_id, 0, 50);

	echo $shmop_read . "<br>";
	echo str_from_mem($shmop_read);

	function str_from_mem(&$value) {
	  	$i = strpos($value, "\0");
	  	if ($i === false) {
	    	return $value;
	  	}
	  	$result =  substr($value, 0, $i);
	  	return $result;
	}
?>