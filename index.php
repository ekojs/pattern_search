<!DOCTYPE HTML>
<html>  
<body>

<html>
   <body>
      <form action="index.php" method="POST" enctype="multipart/form-data">
	  <input type="file" name="uploadedFile">
      <input type="submit" value="Upload">
      </form>
   </body>
</html>

<?php

if(!empty($_FILES['uploadedFile']))
{
	$tempData = array();
	$pattern = '/^(print?)-\d{1,}\/([a-zA-Z0-9\/\.-]+)\/\d{4}$/is';

	$file_lines = file($_FILES["uploadedFile"]["tmp_name"]);
	
	foreach ($file_lines as $line) {
		$line = str_replace(array("\n", "\r"), '', $line);
		
		if(stripos($line, "prin") > 0){
			$startString = stripos($line, "prin");
			$line = substr($line, $startString, (strlen($line) - $startString));
		}

		if(strrpos($line, " ") || strrpos($line, "\\") || substr_count ($line, '-') > 1){
			$line = str_replace(' ', '', $line);
			$line = preg_replace('/^(print?)-+/i', substr($line, 0, 6), $line);
			$line = str_replace('\\', '/', $line);
		}

    	if(preg_match($pattern, $line)){
			array_push($tempData, $line);
		}
	}

	if(count($tempData) > 0){
		$myFile = 'my_file.txt';
		if(file_exists($myFile)){
			unlink($myFile) or die("Couldn't delete file");
		}

		foreach($tempData as $data){
			file_put_contents($myFile,$data.PHP_EOL,FILE_APPEND);
		}
		echo 'File has been created';
	}
	else{
		echo 'Data empty';
	}
}
?>

</body>
</html>