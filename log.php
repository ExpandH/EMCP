<?php

	$log = file("/home/tryy3/Control_Panel/Servers/1/logs/latest.log");
	$log = array_reverse($log);
	$pos = 200;

	if ($pos > count($log))
	{
		$pos = count($log);
	}

	for ($i = 0; $i < $pos; $i++)
	{
		$line = $log[$i];

        $echo = htmlentities($line);

		$echo = str_replace("[m", "</span>", $echo); //§r
		$echo = str_replace("[0;30;22m", "</span><span style='color:#000000'>", $echo); //§0
		$echo = str_replace("[0;34;22m", "</span><span style='color:#0000AA'>", $echo); //§1
		$echo = str_replace("[0;32;22m", "</span><span style='color:#00AA00'>", $echo); //§2
		$echo = str_replace("[0;36;22m", "</span><span style='color:#00AAAA'>", $echo); //§3
		$echo = str_replace("[0;31;22m", "</span><span style='color:#AA0000'>", $echo); //§4
		$echo = str_replace("[0;35;22m", "</span><span style='color:#AA00AA'>", $echo); //§5
		$echo = str_replace("[0;33;22m", "</span><span style='color:#FFAA00'>", $echo); //§6
		$echo = str_replace("[0;37;22m", "</span><span style='color:#AAAAAA'>", $echo); //§7
		$echo = str_replace("[0;30;1m", "</span><span style='color:#555555'>", $echo); //§8
		$echo = str_replace("[0;34;1m", "</span><span style='color:#5555FF'>", $echo); //§9
		$echo = str_replace("[0;32;1m", "</span><span style='color:#55FF55'>", $echo); //§a
		$echo = str_replace("[0;36;1m", "</span><span style='color:#55FFFF'>", $echo); //§b
		$echo = str_replace("[0;31;1m", "</span><span style='color:#FF5555'>", $echo); //§c
		$echo = str_replace("[0;35;1m", "</span><span style='color:#FF55FF'>", $echo); //§d
		$echo = str_replace("[0;33;1m", "</span><span style='color:#FFFF55'>", $echo); //§e
		$echo = str_replace("[0;37;1m", "</span><span style='color:#FFFFFF !important'>", $echo); //§f
		$echo = str_replace("[5m", "", $echo); //§k
		$echo = str_replace("[21m", "", $echo); //§l
		$echo = str_replace("[9m", "", $echo); //§m
		$echo = str_replace("[4m", "", $echo); //§n
		$echo = str_replace("[3m", "", $echo); //§o
		$echo = str_replace("\n", "<br>", $echo); //§o

		echo $echo;

		$pos--;
	}

?>