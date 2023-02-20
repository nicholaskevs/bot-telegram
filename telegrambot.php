#!/usr/bin/env php
<?php

$shortOpt = "h";
$shortOpt .= "c:";

$opt = getopt($shortOpt);

if(empty($opt)) {
	require 'src/main.php';
	
} elseif(isset($opt['c'])) {
	$commands = explode(',', $opt['c']);
	require 'src/runcommands.php';
	
} elseif(isset($opt['h'])) {
	echo '-c [commandlist] - run command stated in commandlist, separate commands with comma' . PHP_EOL;
	echo '-h - print help info' . PHP_EOL;
}
