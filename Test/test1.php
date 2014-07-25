<?php

	$shmop_id = shmop_open(5, 'c', 0644, 50);

	$shmop_write_id = shmop_open(5, 'w', 0644, 50);

	$shmop_write = shmop_write($shmop_write_id, str_to_nts(5), 9);

	/*for ($i = 0; $i < 20; $i++)
	{
		$shmop_write = shmop_write($shmop_write_id, str_to_nts($i+1), $i);
	}*/

	echo $shmop_write;

	function str_to_nts($value) {
	  	return "$value\0";
	}

?>