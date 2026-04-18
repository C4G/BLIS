<?php

$local_path = getenv("LOCAL_DIR") ?: realpath(__DIR__."/../../local");

$directories = scandir($local_path);
foreach($directories as $directory){
	if($directory=='.' or $directory=='..' ){
		//echo 'dot';
	}else{
		if (strpos($directory,'test') !== false && is_dir($local_path."/".$directory)) {
			copy("en.php",$local_path."/".$directory."/en.php");
			copy("default.php",$local_path."/".$directory."/default.php");
			copy("fr.php",$local_path."/".$directory."/fr.php");
			echo $directory .'<br />';
		}

	}
}

?>