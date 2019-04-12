<?php

$file = $argv[1];
$file_lines = file($file);

$proses = function($file_lines){
	$pattern = '/^(b|print?)-\d{1,}\/([a-zA-Z0-9\/\.-]+)\/\d{4}$/is';
	foreach ($file_lines as $line) {
		/**
		 * Filtering pattern
		 */
		
		$line = preg_replace('/\s/mi','',$line);
		$line = preg_replace('/\\\\/mi','/',$line);
		$line = preg_replace('/^(b|print?)([-]{2,})/mi','$1-',$line);
		$line = preg_replace('/[-]{2,}/mi','-',$line);
		$line = preg_replace('/[\.]{2,}/mi','.',$line);
		$line = preg_replace('/[\/]{2,}/mi','/',$line);
		$line = preg_replace('/([^a-zA-Z\.\-\/\d]{1,}|nom[eo]r)/mi','',$line);
	
		/**
		 * Apply valid pattern
		 */
		if(preg_match($pattern, $line)){
			yield $line;
		}
	}
};

if(file_exists('my_file.txt')){
	unlink('my_file.txt') or die("Couldn't delete file");
}

foreach($proses($file_lines) as $v){
	echo $v.PHP_EOL;
	file_put_contents('my_file.txt',$v.PHP_EOL,FILE_APPEND);
}