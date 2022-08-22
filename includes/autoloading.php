<?php

spl_autoload_register('bookShopAutoloader');

function bookShopAutoloader($class) {	
 
    // Only Run When Contain Our Namespace 
	if (strpos($class,'BookShop') === false){		
		return;
	}

	$file_parts = explode('\\',$class);
	$file_parts = array_map('strtolower',$file_parts);
	$file_parts = end($file_parts);
	$path       = 'class-'.$file_parts.'.php';
	require_once($path);
}
