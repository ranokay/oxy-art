<?php
spl_autoload_register('myAutoLoader');

function myAutoLoader($className)
{
	$path = 'php/';
	$extension = '.inc.php';
	$fullPath = $path . $className . $extension;

	if (!file_exists($fullPath)) {
		return false;
	}

	include_once $fullPath;
}
